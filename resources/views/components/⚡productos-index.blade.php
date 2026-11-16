<?php
use App\Models\Producto;
use App\Models\Almacen;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

new class extends Component {
    use WithPagination;

    #[Url]
    public $buscar = '';
    #[Url]
    public $categoria = '';
    #[Url]
    public $almacen_id = '';
    #[Url]
    public $stock_bajo = false;

    public function updated()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $consulta = Producto::with(['cantidad.almacen']);

        if ($this->buscar) {
            $consulta->where('nombre', 'like', '%' . $this->buscar . '%');
        }

        if ($this->categoria) {
            $consulta->where('nombre', 'like', $this->categoria . '%');
        }

        if ($this->almacen_id) {
            $consulta->whereHas('cantidad', function ($q) {
                $q->where('almacen_id', $this->almacen_id);
            });
        }

        if ($this->stock_bajo) {
            $consulta->whereHas('cantidad', function ($q) {
                $q->where('stock', '<=', 10);
            });
        }

        return [
            'productos' => $consulta->orderBy('nombre')->paginate(10),
            'almacenes' => Almacen::orderBy('nombre')->get(),
        ];
    }
};
?>

<div>
    <input type="text" wire:model.live.debounce.400ms="buscar" placeholder="Buscar por nombre o código">

    <select wire:model.live="categoria">
        <option value="">Todas las categorias</option>
        <option value="Abrazadera">abrazaderas</option>
        <option value="Alicate">alicates</option>
        <option value="Broca">brocas</option>
        <option value="Cable">cables</option>
        <option value="Cemento">cementos</option>
        <option value="Llave">llaves</option>
        <option value="Martillo">martillos</option>
        <option value="Tubo">tubos</option>
    </select>

    <select wire:model.live="almacen_id">
        <option value="">Todos los almacenes</option>
        @foreach ($almacenes as $almacen)
            <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
        @endforeach
    </select>

    <label>
        <input type="checkbox" wire:model.live="stock_bajo">
        Solo stock bajo (≤ 10)
    </label>

    <table>
        @forelse ($productos as $producto)
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->cantidad->first()?->stock }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Sin datos</td>
            </tr>
        @endforelse
    </table>

    {{ $productos->links() }}
</div>
