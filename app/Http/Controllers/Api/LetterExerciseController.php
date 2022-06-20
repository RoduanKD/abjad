<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LetterResource;
use App\Models\Exercise;
use App\Models\Letter;
use Illuminate\Http\Request;

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
        return new LetterResource($letter);
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
}
