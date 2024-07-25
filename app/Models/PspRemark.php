<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PspRemark extends Model
{
    use HasFactory;
    protected $table = 'psp_remarks';
    protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'session_id',
        'patient_id',
        'answer1',
        'answer2',
        'answer3',
        'answer4a',
        'answer4b',
        'remarks',
        'nurse_id',
        'nurse_name',
        'created_at',
        'updated_at'
    ];

}
