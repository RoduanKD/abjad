<?php

namespace App\Domain\Exercise\Actions;

use App\Models\Exercise;

abstract class ValidateAnswer
{
    public function __construct(protected Exercise $exercise)
    {
    }
}
