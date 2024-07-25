<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $table = 'sessions';
    protected $guarded = ['id'];
//    remarks status
protected $fillable = ['id', 'appointment_id', 'date', 'time_start', ' time_end', 'session_no', 'payment_status', ' remarks', 'status', 'created_at', 'updated_at'];

}
