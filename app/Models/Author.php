<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    //
    protected $fillable = [
        "name",
        "image_path"
    ];
    public function comic():HasMany
    {
        return $this->hasMany(Comic::class);
    }




}
