<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ruc' => ['required', 'digits:11', 'unique:proveedores,ruc'],
            'razon_social' => ['required', 'max:150'],
            'telefono' => ['required', 'numeric', 'digits_between:7,15'],
            'direccion' => ['required', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'ruc.required' => 'El RUC es obligatorio.',
            'ruc.digits' => 'El RUC debe tener exactamente 11 dígitos.',
            'ruc.unique' => 'Ya existe un proveedor con ese RUC.',
            'razon_social.required' => 'La razón social es obligatoria.',
            'razon_social.max' => 'La razón social admite como máximo 150 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.numeric' => 'El teléfono debe contener solo números.',
            'telefono.digits_between' => 'El teléfono debe tener entre 7 y 15 dígitos.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección admite como máximo 255 caracteres.',
        ];
    }
}
