<?php

namespace App\Http\Resources;

use App\Enums\ExerciseType;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

/* @mixin \App\Models\Exercise */
class ExercisesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id'       => $this->id,
            'type'     => $this->type,
            'question' => [
                'text'  => $this->question,
                'voice' => $this->getFirstMediaUrl('question-voice'),
                'image' => $this->getFirstMediaUrl('question-image'),
            ],
        ];

        $data['attributes'] = match ($this->type) {
            ExerciseType::MultipleChoice => [
                'correct_choice_index' => $this->attributes['correct_choice_index'],
                'choices'              => Arr::map($this->attributes['choices'], fn($choice, $i) => ['text' => $choice, 'image' => Arr::get($this->getMedia('choices'), $i)?->getUrl(), 'voice' => Arr::get($this->getMedia('recordings'), $i)?->getUrl()]),
            ],

            ExerciseType::ListenAndRepeat => [
                'recordings' => Arr::map($this->attributes['recordings'], fn($recording, $i) => ['text' => $recording, 'image' => Arr::get($this->getMedia('recordings'), $i)?->getUrl()]),
            ],
            default => $this->attributes,
        };

        return $data;
    }
}
