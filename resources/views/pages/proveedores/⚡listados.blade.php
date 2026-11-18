<?php

use Livewire\Component;

new class extends Component
{
};
?>

@extends('layouts.app')

@section('contenido')
    @livewire('proveedores-index')
@endsection

@section('formulario')
    @livewire('proveedores-form')
@endsection
