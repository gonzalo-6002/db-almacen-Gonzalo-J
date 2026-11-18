<?php

use App\Models\Proveedor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

new class extends Component {
    use WithPagination;

    #[On('proveedor-guardado')]
    public function refrescar()
    {
    }

    public function with(): array
    {
        return [
            'proveedores' => Proveedor::orderBy('razon_social')->paginate(10),
        ];
    }
};
?>

<div>
    <table>
        @forelse ($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor->ruc }}</td>
                <td>{{ $proveedor->razon_social }}</td>
                <td>{{ $proveedor->telefono }}</td>
                <td>{{ $proveedor->direccion }}</td>
                <td>
                    <button wire:click="$dispatch('editar-proveedor', { id: {{ $proveedor->id }} })">Editar</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Sin datos</td>
            </tr>
        @endforelse
    </table>

    {{ $proveedores->links() }}
</div>
