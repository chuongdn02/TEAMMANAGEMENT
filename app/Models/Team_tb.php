<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team_tb extends Model
{
    use HasFactory;
    protected $primaryKey = 'team_id';
    public $incrementing = false;
    protected $guarded = [];
    protected $fillable = [
        'team_id',
        'team_name',
        'department_id'
    ];
}
