<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comicvol extends Model
{
    //
    protected $guarded = [
        "id"
    ];

    protected $casts = [
        'is_collected' => 'boolean',
    ];


    public function comic() :BelongsTo
    {
        return $this->belongsTo(Comic::class);
    }

}
