<?php

use App\Models\Movimiento;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

new class extends Component {
    use WithPagination;

    #[On('movimiento-guardado')]
    public function refrescar()
    {
    }

    public function with(): array
    {
        return [
            'movimientos' => Movimiento::orderBy('id', 'desc')->paginate(10),
        ];
    }
};
?>

<div>
    <table>
        @forelse ($movimientos as $movimiento)
            <tr>
                <td>{{ $movimiento->id }}</td>
                <td>Producto: {{ $movimiento->producto_id }}</td>
                <td>Almacén: {{ $movimiento->almacen_id }}</td>
                <td>Usuario: {{ $movimiento->usuario_id }}</td>
                <td>{{ $movimiento->tipo_movimiento }}</td>
                <td>
                    <button wire:click="$dispatch('editar-movimiento', { id: {{ $movimiento->id }} })">Editar</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Sin datos</td>
            </tr>
        @endforelse
    </table>

    {{ $movimientos->links() }}
</div>
