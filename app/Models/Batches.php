<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batches extends Model
{
    protected $fillable = ['name','start_date','end_date','user_id','instructor_id','status'];
}
