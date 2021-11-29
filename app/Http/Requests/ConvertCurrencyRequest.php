<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ConvertCurrencyRequest extends FormRequest
{
    protected bool $forceJsonResponse = true;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'from' => Str::upper($this->from),
            'to' => Str::upper($this->to),
        ]);
    }

    public function rules(): array
    {
        return [
            'from' => [
                'required',
                Rule::in(config('currencylayer.supported_currencies'))
            ],

            'to' => [
                'required',
                Rule::in(config('currencylayer.supported_currencies'))
            ],

            'amount' => ['required','numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'Missing \':attribute\' currency.',
            '*.in' => 'Currency \':input\' not supported.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
