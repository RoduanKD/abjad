<?php

namespace App\Domain\Exercise\Actions;

use App\Domain\Exercise\Interfaces\Validator;
use App\Enums\ExerciseType;
use App\Models\Exercise;

class ExerciseAnswerValidator
{
    private array $extra_data;

    public function __construct(private Exercise $exercise)
    {
        //
    }

    public static function fromExercise(Exercise $exercise)
    {
        return new self($exercise);
    }

    public function withExtraData($data)
    {
        $this->extra_data = $data;

        return $this;
    }

    public function validateRaw($answer)
    {
        return $this->getValidator()->validateRaw($answer);
    }

    protected function getValidator(): Validator
    {
        switch ($this->exercise->type) {
            case ExerciseType::MultipleChoice:
                return new ValidateMultipleChoiceAnswer($this->exercise);
            case ExerciseType::DrawLetter:
                return new ValidateDrawLetterAnswer($this->exercise);
            case ExerciseType::ListenAndRepeat:
                return new ValidateListenAndRepeatAnswer($this->exercise, $this->extra_data);
        }
    }
}
