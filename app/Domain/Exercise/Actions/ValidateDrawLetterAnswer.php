<?php

namespace App\Domain\Exercise\Actions;

use App\Domain\Exercise\Interfaces\Validator;
use Illuminate\Support\Facades\Http;

class ValidateDrawLetterAnswer extends ValidateAnswer implements Validator
{
    public function validateRaw($value): bool
    {
        $res = Http::attach('file', file_get_contents($value), 'test.jpg')->post(env('PYTHON_HOST') . '/detect-drawing');

        return $this->exercise->letter->value === $res->body();
    }
}
