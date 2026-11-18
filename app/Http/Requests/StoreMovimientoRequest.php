<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'producto_id' => ['required', 'integer', 'gt:0', 'exists:productos,id'],
            'almacen_id' => ['required', 'integer', 'gt:0', 'exists:almacenes,id'],
            'usuario_id' => ['required', 'integer', 'gt:0', 'exists:users,id'],
            'tipo_movimiento' => ['required', 'max:50', 'in:entrada,salida'],
        ];
    }

    public function messages(): array
    {
        return [
            'producto_id.required' => 'El producto es obligatorio.',
            'producto_id.integer' => 'El producto debe ser un número entero.',
            'producto_id.gt' => 'El ID del producto debe ser mayor que cero.',
            'producto_id.exists' => 'El producto indicado no existe.',
            'almacen_id.required' => 'El almacén es obligatorio.',
            'almacen_id.integer' => 'El almacén debe ser un número entero.',
            'almacen_id.gt' => 'El ID del almacén debe ser mayor que cero.',
            'almacen_id.exists' => 'El almacén indicado no existe.',
            'usuario_id.required' => 'El usuario es obligatorio.',
            'usuario_id.integer' => 'El usuario debe ser un número entero.',
            'usuario_id.gt' => 'El ID del usuario debe ser mayor que cero.',
            'usuario_id.exists' => 'El usuario indicado no existe.',
            'tipo_movimiento.required' => 'El tipo de movimiento es obligatorio.',
            'tipo_movimiento.max' => 'El tipo de movimiento admite como máximo 50 caracteres.',
            'tipo_movimiento.in' => 'El tipo de movimiento debe ser entrada o salida.',
        ];
    }
}
