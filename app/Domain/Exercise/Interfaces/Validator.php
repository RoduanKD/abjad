<?php

namespace App\Domain\Exercise\Interfaces;

interface Validator
{
    public function validateRaw($value): bool;
}
