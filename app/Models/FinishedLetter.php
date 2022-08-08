<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedLetter extends Model
{
    use HasFactory;

    protected $fillable = ['letter_id'];
}
