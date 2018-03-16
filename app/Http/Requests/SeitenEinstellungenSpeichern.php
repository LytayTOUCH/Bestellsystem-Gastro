<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeitenEinstellungenSpeichern extends FormRequest
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
            'site_name' => 'required',
            'site_template' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'site_name.required' => 'Ein Seitenname ist erforderlich',
            'site_template.required' => 'Eine Auswahl des Templates ist erforderlich',
        ];
    }
}
