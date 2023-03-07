<?php

namespace App\Http\Requests\Expenses\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest {

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

            'type'        => ['required', 'int'],
            'category_id' => ['required', 'int'],
            'amount'      => ['required', 'numeric'],
            'comment'     => ['required', 'string'],
        ];
    }
}
