<?php

use App\Models\Movimiento;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public ?Movimiento $movimiento = null;
    public $producto_id = '';
    public $almacen_id = '';
    public $usuario_id = '';
    public $tipo_movimiento = '';

    protected function rules(): array
    {
        return [
            'producto_id' => ['required', 'integer', 'gt:0', 'exists:productos,id'],
            'almacen_id' => ['required', 'integer', 'gt:0', 'exists:almacenes,id'],
            'usuario_id' => ['required', 'integer', 'gt:0', 'exists:users,id'],
            'tipo_movimiento' => ['required', 'max:50', 'in:entrada,salida'],
        ];
    }

    protected function messages(): array
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

    public function guardar()
    {
        $datos = $this->validate();
        if ($this->movimiento) {
            $this->movimiento->update($datos);
        } else {
            Movimiento::create($datos);
        }
        $this->cancelar();
        session()->flash('ok', 'Movimiento guardado correctamente.');
        $this->dispatch('movimiento-guardado');
    }

    public function cancelar()
    {
        $this->reset();
        $this->resetValidation();
    }

    #[On('editar-movimiento')]
    public function editar($id)
    {
        $this->movimiento = Movimiento::findOrFail($id);
        $this->fill($this->movimiento->only(
            'producto_id', 'almacen_id', 'usuario_id', 'tipo_movimiento'));
        $this->resetValidation();
    }

    public function updated($propiedad)
    {
        if ($propiedad === 'tipo_movimiento') {
            $this->tipo_movimiento = trim(strtolower((string) $this->tipo_movimiento));
        }
        $this->validateOnly($propiedad);
    }
};
?>

<div>
    @if (session('ok'))
        <p class="text-green-700">{{ session('ok') }}</p>
    @endif
    <form wire:submit="guardar" class="space-y-4">
        <h2>{{ $movimiento ? 'Editar movimiento' : 'Nuevo movimiento' }}</h2>
        <div>
            <label for="producto_id">Producto ID</label>
            <input id="producto_id" type="text" wire:model.blur="producto_id">
            @error('producto_id')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="almacen_id">Almacén ID</label>
            <input id="almacen_id" type="text" wire:model.blur="almacen_id">
            @error('almacen_id')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="usuario_id">Usuario ID</label>
            <input id="usuario_id" type="text" wire:model.blur="usuario_id">
            @error('usuario_id')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="tipo_movimiento">Tipo de movimiento</label>
            <input id="tipo_movimiento" type="text" wire:model.blur="tipo_movimiento">
            @error('tipo_movimiento')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Guardar</button>
        @if ($movimiento)
            <button type="button" wire:click="cancelar">Cancelar</button>
        @endif
    </form>
</div>
