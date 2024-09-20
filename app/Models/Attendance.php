<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];
    
    public function scopeGetAttendanceByDate($query, $startDate, $endDate = null)
    {
        return $query->when(
            isset($startDate) && !isset($endDate),
            function ($query) use ($startDate) {
                $query->whereMonth('tanggal', date('m', strtotime($startDate)))
                    ->whereYear('tanggal', date('Y', strtotime($startDate)));
            }
        )->when(
            isset($startDate) && isset($endDate),
            function ($query) use ($startDate, $endDate) {
                $query->whereMonth('tanggal', '>=', date('m', strtotime($startDate)))
                    ->whereMonth('tanggal', '<=', date('m', strtotime($endDate)))
                    ->whereYear('tanggal', date('Y', strtotime($startDate)));
            }
        )->where('user_id', Auth::id());
    }

    public function scopeDaily()
    {

    }
}
