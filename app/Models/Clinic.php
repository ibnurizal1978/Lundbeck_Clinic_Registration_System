<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
    protected $table = 'clinics';
    protected $guarded = ['id'];
    protected $fillable = ['id', 'name', 'address', 'status', 'created_at', 'updated_at'];
}
