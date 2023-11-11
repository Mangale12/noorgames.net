<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferDetails extends Model
{
    use HasFactory;
    protected $fillable = ['form_id','referer_id','total_refer'];
}
