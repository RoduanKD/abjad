<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value'];

    public function exercises()
    {
        return $this->hasMany(Exercise::class)->orderBy('order');
    }

    public function getRouteKeyName()
    {
        return 'value';
    }
}
