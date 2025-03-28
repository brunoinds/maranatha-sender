<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryProductsPackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:1000'],
            'products' => ['required', 'array'],
            'products.*.product_id' => ['required', 'integer', 'exists:inventory_products,id'],
            'products.*.quantity' => ['required', 'numeric', 'min:0']
        ];
    }
}
