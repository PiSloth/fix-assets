<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRemark extends Model
{
    use HasFactory;

    const TYPE = [
        'MANUAL' => 'manual',
        'SYSTEM' => 'system',
        'REGULAR' => 'regular',
        'SURPRISE' => 'surprise',
    ];

    protected $fillable = [
        'product_id',
        'remark',
        'user_id',
        'employee_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
