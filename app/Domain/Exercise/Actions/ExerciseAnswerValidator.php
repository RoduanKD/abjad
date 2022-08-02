<?php

namespace App\Domain\Exercise\Actions;

use App\Domain\Exercise\Interfaces\Validator;
use App\Enums\ExerciseType;
use App\Models\Exercise;

class ExerciseAnswerValidator
{

    public function __construct(private Exercise $exercise)
    {
        //
    }

    public static function fromExercise(Exercise $exercise)
    {
        return new self($exercise);
    }

    public function validateRaw($answer)
    {
        return $this->getValidator()->validateRaw($answer);
    }

    protected function getValidator(): Validator
    {
        switch (ExerciseType::from($this->exercise->type)) {
            case ExerciseType::MultipleChoice:
                return new ValidateMultipleChoiceAnswer($this->exercise);
        }
    }
}
