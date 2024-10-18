<div class="nav_config">
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link {{$pag == 'web' ? 'bg-sistema-dos text-light active' : 'text-dark'}}" href="{{route('configweb')}}">Web</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{$pag == 'calculos' ? 'bg-sistema-dos text-light active' : 'text-dark'}}" href="{{route('configcalculos')}}">C&aacute;lculos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$pag == 'productos' ? 'bg-sistema-dos text-light active' : 'text-dark'}}" href="{{route('configproductos')}}">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{$pag == 'especificaciones' ? 'bg-sistema-dos text-light active' : 'text-dark'}}" href="{{route('configespecificaciones')}}">Especificaciones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{$pag == 'inventario' ? 'bg-sistema-dos text-light active' : 'text-dark'}}" href="{{route('configinventario')}}">Inventario</a>
          </li>
      </ul>
</div>       