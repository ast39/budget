<?php

namespace App\Http\Requests\Calculate\Deposit;

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

            'title'      => ['required', 'string'],
            'start_date' => ['required', 'string'],
            'amount'     => ['nullable', 'numeric'],
            'percent'    => ['nullable', 'numeric'],
            'period'     => ['nullable', 'integer'],
            'refill'     => ['nullable', 'numeric'],
            'plow_back'  => ['required', 'numeric'],
            'withdrawal' => ['string'],
        ];
    }
}
