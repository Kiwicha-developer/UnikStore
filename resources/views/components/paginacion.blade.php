<div class="row">
    <div class="col-md-12">
        @if ($coleccion->lastPage() > 1)
        <ul class="pagination justify-content-{{$justify}}" style="position: relative">
            <div class="w-100 h-100 bg-transparent rounded-3" style="position: absolute;z-index:800;display:none" id="hidden-loader-paginate">
                <div class="text-start ps-4 text-sistema-uno pt-1">
                    <div class="spinner-grow" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <li class="page-item {{$coleccion->currentPage() < 2 ? 'disabled' : ''}}">
                <a data-link="{{$coleccion->previousPageUrl()}}" onclick="linkEvent(this)" class="page-link" href="javascript:void(0)"><i class="bi bi-caret-left-fill"></i></a>
            </li>
            @for ($i = 1; $i <= $coleccion->lastPage(); $i++)
                <li class="page-item  pag-btn {{$coleccion->currentPage() == $i ? 'active': ''}}">
                    <a data-link="{{$coleccion->url($i)}}" onclick="linkEvent(this)" href="javascript:void(0)" class="page-link">{{$i}}</a>
                </li>
            @endfor
            <li class="page-item {{$coleccion->currentPage() <  $coleccion->lastPage() ? '' : 'disabled'}}">
                <a data-link="{{$coleccion->nextPageUrl()}}" onclick="linkEvent(this)" class="page-link" href="javascript:void(0)"><i class="bi bi-caret-right-fill"></i></a>
            </li>
        </ul>
        @endif
    </div>
    
    <input type="hidden" id="hidden-container" value="{{$container}}">
</div>
<script src="{{asset('js/pagination.js')}}"></script>