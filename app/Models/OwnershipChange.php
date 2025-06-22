<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnershipChange extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'id'];

    // protected $STATUS = [
    //     ''
    // ];

    public function transferto()
    {
        return $this->belongsTo(Employee::class);
    }

    public function ownby()
    {
        return $this->belongsTo(Employee::class);
    }


    public function transferby()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class);
    }
}
