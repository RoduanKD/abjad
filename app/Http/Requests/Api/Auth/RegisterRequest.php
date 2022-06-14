<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'child' => [
                ...$this->child,
                'is_male' => $this->toBoolean($this->child['is_male']),
            ],
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'child'           => 'required|array',
            'child.name'      => 'required|string|max:255',
            'child.is_male'   => 'required|boolean',
            'child.birthdate' => 'required|date|before:today',
            'child.image'     => 'nullable|image',
            'email'           => 'required|string|email|max:255|unique:users',
            'password'        => ['required', Password::defaults()],
        ];
    }

    private function toBoolean($input)
    {
        return filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
