<?php

namespace App\Http\Controllers;

use App\Domain\Exercise\Actions\ExerciseAnswerValidator;
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
        $request->validate([
            'answer' => 'required',
        ]);
        $value = $request->answer;

        return ['correct' => ExerciseAnswerValidator::fromExercise($exercise)->validateRaw($value)];
    }
}
