<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'image';

    protected $fillable = [
        'hash',
        'title',
        'description',
        'original',
        'source'
    ];

    public $timestamps = false;

    /**
     * @param string$hash
     * @return Image|null
     */
    public function get($hash)
    {
        return self::where('hash', $hash)->first();
    }

    /**
     * @param string $hash
     * @return bool
     */
    public function has($hash)
    {
        $image = self::where('hash', $hash)->first();

        return ($image !== null);
    }

    /**
     * @param array $data
     * @return Image
     */
    public function add(array $data)
    {
        return self::forceCreate($data);
    }
}