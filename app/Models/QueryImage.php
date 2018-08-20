<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryImage extends Model
{
    protected $table = 'query_image';

    protected $fillable = ['query_id', 'image_id'];

    public $timestamps = false;

    public static function has($queryId, $imageId)
    {
        $queryImage = self::where('query_id', $queryId)
            ->where('image_id', $imageId)
            ->first();

        return ($queryImage !== null);
    }

    public static function add($queryId, $imageId)
    {
        if ($queryId < 1 || $imageId < 1) {
            return;
        }

        if (self::has($queryId, $imageId)) {
            return;
        }

        try {
            self::forceCreate(['query_id' => $queryId, 'image_id' => $imageId]);
        } catch (\Exception $e) {

        }
    }
}