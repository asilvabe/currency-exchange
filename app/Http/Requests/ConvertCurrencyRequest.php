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

    public function validationData(): array
    {
        $all = parent::validationData();

        if (array_key_exists('from', $all)) {
            $all['from'] = Str::upper($all['from']);
        }

        if (array_key_exists('to', $all)) { 
            $all['to'] = Str::upper($all['to']);
        }

        return $all;
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
