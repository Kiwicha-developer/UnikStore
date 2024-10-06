<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EgresoProducto extends Model
{
    public $timestamps = false;
 
    protected $table = 'EgresoProducto';
    
    protected $primaryKey = 'idEgreso';

    protected $guarded = ['idEgreso','idRegistro','idUser','idPlataforma'];
    
    protected $fillable = ['fechaEgreso','numeroOrden'
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'idEgreso' => 'int',
        'idRegistro' => 'int',
        'idUser' => 'int',
        'idPlataforma' => 'int',
        'fechaEgreso' => 'date'
    ];
    
     public function RegistroProducto()
    {
        return $this->hasOne(RegistroProducto::class,'idRegistro','idRegistro');
    }
    
     public function Usuario()
    {
        return $this->belongsTo(Usuario::class,'idUser','idUser');
    }
    
     public function Plataforma()
    {
        return $this->belongsTo(Plataforma::class,'idPlataforma','idPlataforma');
    }

    /**
     * Obtener las relaciones del modelo.
     */
    
}