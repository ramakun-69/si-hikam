<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with =['type'];

    public function type() 
    {
        return $this->belongsTo(TypeOfLeave::class,'type_of_leave_id','id');    
    }
    public function employee() 
    {
        return $this->belongsTo(Employee::class,'nip','nip');    
    }
}
