<?php
//Agregar campo tabla Productos
//Modificar para crear el campo de N° de caja

namespace App\Shop\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'sku' => ['required'],
            'name' => ['required', Rule::unique('products')->ignore($this->segment(3))],
            'nBox' => ['required'],
            'tag' => ['required'],
            'quantity' => ['required', 'numeric'],
            'price' => ['required'],
            'buyprice' => ['required']
        ];
    }
}