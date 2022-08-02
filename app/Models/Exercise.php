<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Exercise extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['type', 'question', 'attributes'];

    protected $casts = [
        'attributes' => 'array',
    ];

    public function correctChoice(): Attribute
    {
        return Attribute::get(fn() => json_decode($this->attributes['attributes'])->choices[json_decode($this->attributes['attributes'])->correct_choice_index]);
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
