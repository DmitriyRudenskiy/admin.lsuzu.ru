<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $table = 'query';

    public $timestamps = false;

    public function isDuplicateName($name)
    {
        $query = self::where('name', $name)->first();

        return ($query !== null);
    }

    public function isDuplicateAlias($alias)
    {
        $query = self::where('alias', $alias)->first();

        return ($query !== null);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'query_image', 'query_id', 'image_id');
    }
}