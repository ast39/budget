<?php

namespace App\Http\Requests\Payment\Wallet;

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

            'wallet_id' => ['required', 'int'],
            'note'    => ['required', 'string', 'nullable'],
            'amount'  => ['required', 'numeric'],
        ];
    }
}
