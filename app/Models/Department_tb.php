<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department_tb extends Model
{
    use HasFactory;
    protected $primaryKey = 'department_id';
    public $incrementing = false;
    protected $guarded = [];
    protected $fillable = [
        'department_id',
        'department_name',
        'descriptions'
    ];
}
