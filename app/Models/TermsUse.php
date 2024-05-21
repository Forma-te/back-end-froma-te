<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsUse extends Model
{

    use HasFactory;

    protected $fillable = ['title','description'];


}
