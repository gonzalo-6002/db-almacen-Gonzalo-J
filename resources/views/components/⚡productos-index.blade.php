<?php
use App\Models\Producto;
use App\Models\Almacen;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

new class extends Component {
    use WithPagination;

    #[Url(keep: true, history: true)]
    public $buscar = '';

    #[Url(keep: true, history: true)]
    public $categoria = '';

    #[Url(keep: true, history: true)]
    public $almacen_id = '';

    #[Url(keep: true, history: true)]
    public $stock_bajo = false;




    public function updatedBuscar() { $this->resetPage(); }
    public function updatedCategoria() { $this->resetPage(); }
    public function updatedAlmacenId() { $this->resetPage(); }
    public function updatedStockBajo() { $this->resetPage(); }

    public function with(): array
    {
        $consulta = Producto::with(['cantidad.almacen']);

        if ($this->buscar) {
            $consulta->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->buscar . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->buscar . '%');
            });
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
    <div class="flex flex-wrap items-center gap-4 mb-4">
        <input type="text" 
               wire:model.live.debounce.400ms="buscar" 
               placeholder="Buscar por nombre o código"
               class="border rounded px-3 py-2 bg-white">

        <select wire:model.live="categoria" class="border rounded px-3 py-2 bg-white">
            <option value="">Todas las categorias</option>
            <option value="Abrazadera">Abrazaderas</option>
            <option value="Alicate">Alicates</option>
            <option value="Broca">Brocas</option>
            <option value="Cable">Cables</option>
            <option value="Cemento">Cementos</option>
            <option value="Llave">Llaves</option>
            <option value="Martillo">Martillos</option>
            <option value="Tubo">Tubos</option>
        </select>

        <select wire:model.live="almacen_id" class="border rounded px-3 py-2 bg-white">
            <option value="">Todos los almacenes</option>
            @foreach ($almacenes as $almacen)
                <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
            @endforeach
        </select>

        <label class="flex items-center gap-2 cursor-pointer bg-white px-3 py-2 rounded border">
            <input type="checkbox" wire:model.live="stock_bajo">
            <span>Solo stock bajo (≤ 10)</span>
        </label>
    </div>

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
