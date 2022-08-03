<?php

namespace App\Domain\Exercise\Actions;

use App\Domain\Exercise\Interfaces\Validator;

class ValidateDrawLetterAnswer extends ValidateAnswer implements Validator
{
    public function validateRaw($value): bool
    {
        return true;
    }
}
