@extends('layout.app')

@section('title', 'Mapa de Colombia')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; height: 100vh; background: url('https://upload.wikimedia.org/wikipedia/commons/2/21/Flag_of_Colombia.svg') no-repeat center center/cover;">
    <div id="map-container" style="text-align: center; padding: 20px; background-color: rgba(255, 255, 255, 0.9); border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 800px;">
        <h2 style="color: #004085; margin-bottom: 10px;">Explora Colombia</h2>
        <p style="color: #333; font-size: 16px; max-width: 600px; margin: auto;">
            Conéctate a la <strong>API de Colombia</strong> <a href="https://api-colombia.com/" target="_blank" style="color: #007bff; text-decoration: none;">https://api-colombia.com/</a> para visualizar un mapa interactivo con los <strong>departamentos</strong> y sus principales <strong>atracciones turísticas</strong>.
        </p>
        <a href="{{ route('main') }}" style="margin-top: 20px; display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; transition: background 0.3s;">
            Ir al Mapa de Colombia
        </a>
    </div>
</div>
@endsection
