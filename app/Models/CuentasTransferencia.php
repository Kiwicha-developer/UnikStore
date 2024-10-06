<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class CuentasTransferencia extends Model
{
 
    protected $table = 'CuentasTransferencia';
    
    protected $primaryKey = 'idCuentaBancaria';

    protected $guarded = ['idCuentaBancaria','idBanco','idEmpresa'];
    
    protected $fillable = ['numeroCuenta',
                            'tipoMoneda',
                            'tipoCuenta',
                            'titular'
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'idCuentaBancaria' => 'int',
        'idBanco' => 'int',
        'idEmpresa' => 'int',
    ];

    /**
     * Obtener las relaciones del modelo.
     */
    public function Empresa()
    {
        return $this->belongsTo(Empresa::class,'idEmpresa','idEmpresa');
    }
    
    public function Banco()
    {
        return $this->belongsTo(Banco::class, 'idBanco', 'idBanco');
    }
    
}