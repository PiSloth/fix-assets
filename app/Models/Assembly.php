<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'image',
        'department_id',
        'branch_id',
        'employee_id',
        'remark',
        'user_id',
        'is_active',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function verify()
    {
        return $this->hasMany(Verify::class);
    }

    public function latestVerify()
    {
        return $this->hasOne(Verify::class, 'assembly_id', 'id')->latestOfMany('id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the image as a data URI.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(function ($value, $attributes) {
            // Convert binary to readable string if not null
            return isset($attributes['image'])
                ? trim($attributes['image'])
                : null;
        });
    }
}
