<?php

use App\Models\Proveedor;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public ?Proveedor $proveedor = null;
    public $ruc = '';
    public $razon_social = '';
    public $telefono = '';
    public $direccion = '';

    protected function rules(): array
    {
        return [
            'ruc' => [
                'required',
                'digits:11',
                Rule::unique('proveedores', 'ruc')->ignore($this->proveedor?->id),
            ],
            'razon_social' => ['required', 'max:150'],
            'telefono' => ['required', 'numeric', 'digits_between:7,15'],
            'direccion' => ['required', 'max:255'],
        ];
    }

    protected function messages(): array
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

    public function guardar()
    {
        $datos = $this->validate();
        if ($this->proveedor) {
            $this->proveedor->update($datos);
        } else {
            Proveedor::create($datos);
        }
        $this->cancelar();
        session()->flash('ok', 'Proveedor guardado correctamente.');
        $this->dispatch('proveedor-guardado');
    }

    public function cancelar()
    {
        $this->reset();
        $this->resetValidation();
    }

    #[On('editar-proveedor')]
    public function editar($id)
    {
        $this->proveedor = Proveedor::findOrFail($id);
        $this->fill($this->proveedor->only(
            'ruc', 'razon_social', 'telefono', 'direccion'));
        $this->resetValidation();
    }

    public function updated($propiedad)
    {
        if ($propiedad === 'ruc') {
            $this->ruc = trim((string) $this->ruc);
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
        <h2>{{ $proveedor ? 'Editar proveedor' : 'Nuevo proveedor' }}</h2>
        <div>
            <label for="ruc">RUC</label>
            <input id="ruc" type="text" wire:model.blur="ruc">
            @error('ruc')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="razon_social">Razón Social</label>
            <input id="razon_social" type="text" wire:model.blur="razon_social">
            @error('razon_social')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="telefono">Teléfono</label>
            <input id="telefono" type="text" wire:model.blur="telefono">
            @error('telefono')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="direccion">Dirección</label>
            <input id="direccion" type="text" wire:model.blur="direccion">
            @error('direccion')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Guardar</button>
        @if ($proveedor)
            <button type="button" wire:click="cancelar">Cancelar</button>
        @endif
    </form>
</div>
