<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];

    public function requestby()
    {
        return $this->belongsTo(User::class);
    }
    public function responsibleby()
    {
        return $this->belongsTo(Employee::class);
    }
    public function verifyby()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(VerifyPhoto::class);
    }
}
