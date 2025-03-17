<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function accessoriesGroup()
    {
        return $this->belongsTo(AccessoriesGroup::class);
    }
}
