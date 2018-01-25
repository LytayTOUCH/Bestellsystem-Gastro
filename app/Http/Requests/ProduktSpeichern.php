<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduktSpeichern extends FormRequest
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
            'productName' => 'required',
            'productPrice' => 'required',
            'productCategory' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'productName.required' => 'Ein Produktname ist erforderlich',
            'productPrice.required' => 'Der Produktpreis muss bestimmt werden',
            'productCategory.required' => 'Ohne Kategorie kann leider kein Produkt angelegt werden',
        ];
    }
}
