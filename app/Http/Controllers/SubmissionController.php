<?php

namespace App\Http\Controllers;

use App\Domain\Exercise\Actions\ExerciseAnswerValidator;
use App\Enums\ExerciseType;
use App\Models\Exercise;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Exercise $exercise)
    {
        $rules = [
            'answer' => 'required' . match ($exercise->type) {
                    ExerciseType::MultipleChoice => '|string',
                    ExerciseType::DrawLetter => '|file|image|mimes:jpg|dimensions:width:320,height:320',
                    ExerciseType::ListenAndRepeat => '|file|mimes:wav',
                },
        ];

        if ($exercise->type === ExerciseType::ListenAndRepeat)
            $result['letter'] = 'required|string|in:' . $exercise->recordings->join(',');

        $request->validate($rules);
        $value = $request->answer;

        $validator = ExerciseAnswerValidator::fromExercise($exercise);
        if ($exercise->type === ExerciseType::ListenAndRepeat)
            $validator->withExtraData(['letter' => $request->letter]);
        $result = $validator->validateRaw($value);

        return ['correct' => $result];
    }
}
