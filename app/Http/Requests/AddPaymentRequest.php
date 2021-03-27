<?php

namespace App\Http\Requests;

use App\Http\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class AddPaymentRequest extends FormRequest
{
    use FailedValidation;
    /**
     * The attributes usefull for default validation.
     *
     * @var array
     */
    protected const VALIDATION_RULES = [
        'name' => 'required|string',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return self::VALIDATION_RULES;
    }
}
