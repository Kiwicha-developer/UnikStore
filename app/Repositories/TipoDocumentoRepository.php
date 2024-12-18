<?php
namespace App\Repositories;

use App\Models\TipoDocumento;

class TipoDocumentoRepository implements TipoDocumentoRepositoryInterface
{
    public function all(){
        return TipoDocumento::all();
    }
}