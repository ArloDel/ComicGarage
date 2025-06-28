<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comic extends Model
{
protected $guarded = [
        "id"
    ];

    public function comicvol():HasMany
    {
        return $this->hasMany(Comicvol::class);
    }

    public function imagecomic():HasMany
    {
        return $this->hasMany(imagecomic::class);
    }

    public function author():BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

}
