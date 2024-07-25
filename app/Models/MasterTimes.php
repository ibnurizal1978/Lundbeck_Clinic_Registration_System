<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTimes extends Model
{
    use HasFactory;
    protected $table = 'master_times';
    protected $guarded = ['id'];
    protected $fillable = ['id', 'category', 'times', 'created_at', 'updated_at'];
}
