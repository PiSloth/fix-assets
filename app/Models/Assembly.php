<?php

namespace App\Models;

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
        return $this->hasOne(Verify::class)->latestOfMany();
    }

    /**
     * Get the image as a data URI.
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return 'data:image/jpeg;base64,' . base64_encode($this->image);
        }

        return null;
    }
}
