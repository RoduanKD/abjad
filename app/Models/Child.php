<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Child extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'is_male', 'birthdate'];

    protected $casts = [
        'is_male' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function initials(): Attribute
    {
        return Attribute::get(fn() => Str::of($this->name)->explode(' ')->map(fn($word) => $word[0])->implode(''));
    }

    public function registerMediaCollections(): void
    {
        $initials = $this->initials;
        $this
            ->addMediaCollection('profile')
            ->singleFile()
            ->useFallbackUrl("https://via.placeholder.com/100?text={$initials}");
    }
}
