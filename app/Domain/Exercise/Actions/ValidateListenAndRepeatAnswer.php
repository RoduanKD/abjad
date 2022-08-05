<?php

namespace App\Domain\Exercise\Actions;

use App\Domain\Exercise\Interfaces\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ValidateListenAndRepeatAnswer extends ValidateAnswer implements Validator
{
    public function validateRaw($value): bool
    {
        $res = Http::attach('file', file_get_contents($value), 'test.wav')->post(env('PYTHON_HOST') . '/detect-voice');

        return $this->standardizeCharacter($this->extra_data['letter']) === $this->standardizeCharacter($res->body());
    }

    protected function standardizeCharacter(string $char): string
    {
        return Str::replace(['1', 'َ', 'ُ', 'ِ'], ['', 'ا', 'و', 'ي'], $char);
    }
}
