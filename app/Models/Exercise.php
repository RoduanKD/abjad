<?php

namespace App\Models;

use App\Enums\ExerciseType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Exercise extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['type', 'question', 'attributes', 'order'];

    protected $casts = [
        'attributes' => 'array',
    ];

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }

    public function type(): Attribute
    {
        return Attribute::get(fn() => ExerciseType::from($this->attributes['type']));
    }

    public function correctChoice(): Attribute
    {
        return Attribute::get(fn() => json_decode($this->attributes['attributes'])->choices[json_decode($this->attributes['attributes'])->correct_choice_index]);
    }

    public function recordings(): Attribute
    {
        return Attribute::get(fn() => collect(json_decode($this->attributes['attributes'])->recordings));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('question-image')
            ->singleFile();

        $this->addMediaCollection('question-voice')
            ->singleFile();

        $this->addMediaCollection('choices');

        $this->addMediaCollection('recordings');
    }
}
