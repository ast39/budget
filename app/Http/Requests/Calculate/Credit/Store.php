<?php

namespace App\Http\Requests\Calculate\Credit;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'title'        => 'required|string',
            'payment_type' => 'required|integer',
            'subject'      => 'required|string|nullable',
            'amount'       => [
                "required_if:subject, !=, 'amount'",
                "numeric",
            ],
            'percent'      => [
                "required_if:subject, !=, 'percent'",
                "numeric",
            ],
            'period'       => [
                "required_if:subject, !=, 'period'",
                "integer",
            ],
            'payment'      => [
                "required_if:subject, !=, 'payment'",
                "numeric",
            ]
        ];
    }
}
