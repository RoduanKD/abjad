<?php

namespace App\Domain\Exercise\Actions;

use App\Domain\Exercise\Interfaces\Validator;

class ValidateMultipleChoiceAnswer extends ValidateAnswer implements Validator
{
    public function validateRaw($value): bool
    {
        $correct_choice = $this->exercise->correct_choice;
        return $correct_choice == $value;
    }
}
