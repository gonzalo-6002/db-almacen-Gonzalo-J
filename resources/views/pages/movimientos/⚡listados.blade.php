<?php

use Livewire\Component;

new class extends Component
{
};
?>

@extends('layouts.app')

@section('contenido')
    @livewire('movimientos-index')
@endsection

@section('formulario')
    @livewire('movimientos-form')
@endsection
