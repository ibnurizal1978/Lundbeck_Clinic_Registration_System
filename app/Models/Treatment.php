<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;
    protected $table = 'treatments';
    protected $guarded = ['id'];
    protected $fillable = ['id', 'name', 'no_sessions', 'description', 'frequency_days', 'status', 'created_at', 'updated_at'];
}
