<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    
    public $incrementing = false;
    protected $guarded = [];
    protected $primaryKey = 'code';
}
