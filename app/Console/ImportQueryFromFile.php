<?php
namespace App\Console;

use App\Models\Query;
use App\Models\Source;
use App\Tools\Translit;
use Illuminate\Console\Command;

/**
 * Class ImportQueryFromFile
 * @package App\Console\Commands
 *
 */
class ImportQueryFromFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:query:from:files {source_id} {filename}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sourceId = (int)$this->argument('source_id');
        $name = $this->argument('filename');

        if ($sourceId < 1) {
            $this->error('Source ID is empty.');
            return null;
        } else {
            $this->info('Source ID: ' . $sourceId);
        }

        $model = Source::find($sourceId);

        if ($model === null) {
            $this->error('Source ID not find in datatbase.');
            return null;
        } else {
            $this->info('Source: ' . $model->name);
        }

        $filename = storage_path('import/query') . DIRECTORY_SEPARATOR . $name;

        if (!file_exists($filename)) {
            $this->error('Not find file: ' . $filename);
            return null;
        } else {
            $this->info('Load from file: ' . realpath($filename));
        }

        ini_set('memory_limit', '-1');

        $queries = $this->loadFromFiles($filename);

        $this->info('Count load from file: ' . sizeof($queries));

        foreach ($queries as $value) {
            $value['source_id'] = $model->id;
            $this->add($value);
        }
    }

    /**
     * @param string $filename
     * @return array
     */
    protected function loadFromFiles($filename)
    {
        $result = [];

        $file = new \SplFileObject($filename);

        $file->setFlags(\SplFileObject::READ_CSV);
        foreach ($file as $row) {

            if (sizeof($row) > 1) {
                list($id, $name) = $row;

                $result[] = [
                    'id' => (int)$id,
                    'name' => trim($name),
                    'alias' => (!empty($row[2])) ? trim($row[2]) : null
                ];
            }
        }

        return $result;
    }

    protected function add(array $data)
    {
        $model = new Query();

        // повторяется текст запроса
        if ($model->isDuplicateName($data['name'])) {
            $this->info("\tDuplicate name\n" . implode("\n", $data));
            return false;
        }

        if (empty($data['alias'])) {
            $data['alias'] = $this->makeAlias($data['name']);
        }

        // повторяется псевдоним запроса
        if ($model->isDuplicateAlias($data['alias'])) {

            $data['alias'] .= '_' . rand(1,50);

            if ($model->isDuplicateAlias($data['alias'])) {
                return false;
            }
        }

        Query::forceCreate($data);
    }

    protected function makeAlias($text)
    {
        return (new Translit())->get($text);
    }
}

