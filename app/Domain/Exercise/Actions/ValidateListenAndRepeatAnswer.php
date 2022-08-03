<?php

namespace App\Domain\Exercise\Actions;

use App\Domain\Exercise\Interfaces\Validator;
use Illuminate\Support\Facades\Http;

class ValidateListenAndRepeatAnswer extends ValidateAnswer implements Validator
{
    public function validateRaw($value): bool
    {
        $res = Http::attach('file', file_get_contents($value), 'test.wav')->post(env('PYTHON_HOST'));

        return $this->extra_data['letter'] === $res->body();
    }
}
