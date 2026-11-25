<?php

use Livewire\Component;

new class extends Component
{ 
};
?>

<div class="container mx-auto grid grid-cols-6 py-10 px-6 mt-7">
    <div class="col-span-1">
    </div>
    <div class="col-span-3">
        @livewire('productos-index')
    </div>
    <div class="col-span-2">
        @livewire('productos-form')
    </div>
</div>
