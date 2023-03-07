<?php

namespace App\Http\Requests\Manage\Deposit;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest {

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

            'title'      => ['string'],
            'depositor'  => ['string'],
            'start_date' => ['string'],
            'amount'     => ['numeric'],
            'percent'    => ['numeric'],
            'period'     => ['integer'],
            'refill'     => ['numeric'],
            'plow_back'  => ['numeric'],
            'withdrawal' => ['string'],
        ];
    }
}
