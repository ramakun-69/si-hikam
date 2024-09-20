<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded =['id'];
    protected $with =['user', 'qrCode','attendances','leaveRequests'];

    public function qrCode()
    {
        return $this->hasOne(QrCode::class, 'nip', 'nip');
    } 

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'nip','nip');
    }
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'nip','nip');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
