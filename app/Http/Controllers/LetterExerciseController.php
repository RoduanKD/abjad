<?php

namespace App\Http\Controllers;

use App\Enums\ExerciseType;
use App\Models\Exercise;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class LetterExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function index(Letter $letter)
    {
        $exercises = $letter->exercises;

        return inertia('admin/exercises/index', compact('letter', 'exercises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function create(Letter $letter)
    {
        $types = ExerciseType::cases();
        return inertia('admin/exercises/form', compact('letter', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Letter $letter)
    {
        $request->validate([
            'type'           => ['required', new Enum(ExerciseType::class)],
            'question'       => 'required|array',
            'question.text'  => 'required|max:255',
            'question.voice' => 'required|mimes:mp3,wav',
            'question.image' => 'nullable|image',

            'attributes'           => 'required_if:type:video_tutorial,multiple_choice,listen_and_repeat|array',
            'attributes.video_url' => 'required_if:type,video_tutorial|url|nullable',

            'attributes.correct_choice_index' => 'required_if:type,multiple_choice|prohibited_unless:type,multiple_choice,draw_letter|numeric|max:2',
            'attributes.choices'              => 'required_if:type,multiple_choice|array|size:3',
            'attributes.choices.*.text'       => 'required_if:type,multiple_choice|prohibited_unless:type,multiple_choice,draw_letter|string|max:255',
            'attributes.choices.*.image'      => 'prohibited_unless:type,multiple_choice,draw_letter|image|nullable',

            'attributes.recordings'         => 'required_if:type,listen_and_repeat|array|size:4',
            'attributes.recordings.*.text'  => 'required_if:type,listen_and_repeat|max:255',
            'attributes.recordings.*.voice' => 'required_if:type,listen_and_repeat|mimes:mp3,wav',
        ]);

        $data = [
            'type'     => $request->type,
            'question' => $request->question['text'],
        ];

        $data['attributes'] = match ($request->type) {
            ExerciseType::MultipleChoice->value => [
                'correct_choice_index' => $request->get('attributes')['correct_choice_index'],
                'choices'              => array_map(fn($item) => $item['text'], $request->get('attributes')['choices']),
            ],

            ExerciseType::VideoTutorial->value => ['video_url' => $request->get('attributes')['video_url']],

            ExerciseType::ListenAndRepeat->value => [
                'recordings' => array_map(fn($item) => $item['text'], $request->get('attributes')['recordings']),
            ],

            default => [],
        };

        /* @var \App\Models\Exercise $exercise */
        $exercise = $letter->exercises()->create($data);

        $exercise->addMediaFromRequest('question.voice')->toMediaCollection('question-voice');
        if ($request->file('question.image'))
            $exercise->addMediaFromRequest('question.image')->toMediaCollection('question-image');

        if ($request->filled('attributes.choices')) {
            for ($i = 0; $i < count($request->get('attributes')['choices']); $i++)
                if ($request->type === ExerciseType::MultipleChoice->value && $request->file("attributes.choices.$i.image"))
                    $exercise->addMediaFromRequest("attributes.choices.$i.image")->withCustomProperties(['index' => $i])->toMediaCollection('choices');
        }

        if ($request->type === ExerciseType::ListenAndRepeat->value)
            $exercise->addMultipleMediaFromRequest(['attributes.recordings.0.voice', 'attributes.recordings.1.voice', 'attributes.recordings.2.voice', 'attributes.recordings.3.voice'])->each(function ($adder) {
                $adder->toMediaCollection('recordings');
            });

        return redirect()->route('admin.letters.exercises.index', $letter)->with('success', __('api.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Letter  $letter
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function show(Letter $letter, Exercise $exercise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Letter  $letter
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function edit(Letter $letter, Exercise $exercise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Letter  $letter
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Letter $letter, Exercise $exercise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Letter  $letter
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Letter $letter, Exercise $exercise)
    {
        //
    }
}
