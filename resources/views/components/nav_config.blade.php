<div class="nav_config">
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link {{$pag == 'web' ? 'bg-sistema-dos text-light active' : 'text-dark'}}" href="{{route('configweb')}}">Web</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{$pag == 'calculos' ? 'bg-sistema-dos text-light active' : 'text-dark'}}" href="{{route('configcalculos')}}">Calculos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$pag == 'categorias' ? 'bg-sistema-dos text-light active' : 'text-dark'}}" href="{{route('configcategorias')}}">Categorias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{$pag == 'especificaciones' ? 'bg-sistema-dos text-light active' : 'text-dark'}}" href="{{route('configespecificaciones')}}">Especificaciones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{$pag == 'almacen' ? 'bg-sistema-dos text-light active' : 'text-dark'}}" href="{{route('configalmacen')}}">Almacen</a>
          </li>
      </ul>
</div>       