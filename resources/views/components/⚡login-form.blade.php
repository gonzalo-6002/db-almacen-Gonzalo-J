<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $email = '';
    public $password = '';
    public function ingresar()
    {
        $this->validate(['email' => 'required|email' , 'password' => 'required']);
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return $this->redirect('/productos');
        }
        $this->addError('email', 'Correo o contraseña incorrectos.' );
    }
};
?>

<div>
    <form wire:submit="ingresar">
        <input type="email" wire:model="email" placeholder="Correo">
        @error('email') <span>{{ $message }}</span> @enderror
        <input type="password" wire:model="password" placeholder="Contraseña">
        <button type="submit">Ingresar</button>
    </form>
</div>
