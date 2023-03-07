<?php

namespace App\Http\Requests\Fraud\Credit;

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

            'title'        => ['required', 'string'],
            'amount'       => ['required', 'numeric'],
            'percent'      => ['required', 'numeric'],
            'period'       => ['required', 'integer'],
            'payment'      => ['required', 'numeric'],
        ];
    }
}
