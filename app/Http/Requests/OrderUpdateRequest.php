<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
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
            'order_date' => ['nullable', 'date_format:d.m.Y'],
            'phone' => ['nullable', 'string', 'regex:^[\8+7][\ ]?(\d[\ ]?)(\d[\ ]?){7,10}$'],
            'lng' => ['nullable', 'numeric'],
            'lat' => ['nullable', 'numeric'],
            'products'=>['nullable','array'],
            'products.*.id'=>['nullable','integer','exists:products,id'],
            'products.*.count'=>['nullable','integer','min:1']
        ];
    }
}
