<?php

namespace App\Enums;

enum ExerciseType: string
{
    case VideoTutorial = 'video_tutorial';
    case MultipleChoice = 'multiple_choice';
    case ListenAndRepeat = 'listen_and_repeat';
    case DrawLetter = 'draw_letter';
}
