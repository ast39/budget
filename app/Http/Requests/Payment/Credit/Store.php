<?php

namespace App\Http\Requests\Payment\Credit;

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

            'credit_id' => ['required', 'int'],
            'amount'    => ['required', 'numeric'],
        ];
    }
}
