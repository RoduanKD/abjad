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

    public function finishedLetters()
    {
        return $this->hasMany(FinishedLetter::class);
    }

    public function initials(): Attribute
    {
        return Attribute::get(fn() => Str::of($this->name)->explode(' ')->map(fn($word) => Str::substr($word, 0, 1))->implode(''));
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucwords($value),
            set: fn($value) => strtolower($value),
        );
    }

    public function pointsCount(): Attribute
    {
        return Attribute::get(fn() => $this->finishedLetters()->count() * 10);
    }

    public function level(): Attribute
    {
        return Attribute::get(fn() => $this->points_count / 10);
    }

    public function registerMediaCollections(): void
    {
        $image = $this->is_male ? 'boy' : 'girl';
        $this
            ->addMediaCollection('profile')
            ->singleFile()
            ->useFallbackUrl("https://abjad.test/storage/kids/{$image}.svg");
    }
}
