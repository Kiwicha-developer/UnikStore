@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div id="dashboard-content">
        <x-dashboard_content :registros="$registros" :inventario="$inventario" :stock="$stock" :colors="$colors" :productos="$productos" :stockMin="$stockMin" :publicaciones="$publicaciones"/>
    </div>
    <script>
        function loadProducts() {
            let loader = document.getElementById('loader-list-products');
            let divContainer = document.getElementById('dashboard-content');
            let url = '{{route('dashboard')}}' ;
            const fullUrl = `${url}?query=1`;

            fetch(fullUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    divContainer.innerHTML = data;
                })
                .catch(error => console.error('Error al cargar los productos:', error));
        }

        window.onload = function() {
            loadProducts(); 
            setInterval(loadProducts, 60000);
        }

    </script>
@endsection