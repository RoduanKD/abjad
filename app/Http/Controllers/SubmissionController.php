<?php

namespace App\Http\Controllers;

use App\Domain\Exercise\Actions\ExerciseAnswerValidator;
use App\Enums\ExerciseType;
use App\Models\Child;
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
            'child'  => 'required|exists:children,id,user_id,' . auth()->id(),
        ];

        if ($exercise->type === ExerciseType::ListenAndRepeat)
            $result['letter'] = 'required|string|in:' . $exercise->recordings->join(',');

        $request->validate($rules);
        $value = $request->answer;

        $validator = ExerciseAnswerValidator::fromExercise($exercise);
        if ($exercise->type === ExerciseType::ListenAndRepeat)
            $validator->withExtraData(['letter' => $request->letter]);
        $result = $validator->validateRaw($value);

        if ($exercise->id === $exercise->letter->exercises()->get('id')->last()->id && $result) {
            $child = Child::find($request->child);
            $child->finishedLetters()->firstOrCreate(['letter_id' => $exercise->letter_id]);
        }

        return ['correct' => $result];
    }
}
