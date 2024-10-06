<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
 
    protected $table = 'Banco';
    
    protected $primaryKey = 'idBanco';

    protected $guarded = ['idBanco'];
    
    protected $fillable = ['nombreBanco','colorBanco'
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'idBanco' => 'int'
    ];

    /**
     * Obtener las relaciones del modelo.
     */
    public function CuentasTransferencia()
    {
        return $this->hasMany(CuentasTransferencia::class, 'idBanco', 'idBanco');
    }
    
}