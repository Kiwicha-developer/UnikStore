<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class Usuario extends Model
{
    public $timestamps = false;
 
    protected $table = 'Usuario';
    
    protected $primaryKey = 'idUser';

    protected $guarded = ['pass'];
    
    protected $fillable = ['idUser','user','idCargo','tokenSesion','registroSesion','horaSesion','estadoUsuario'
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'idUser' => 'int',
        'idCargo' => 'int',
        'tokenSesion' => 'int',
        'registroSesion' => 'bool',
        'horaSesion' => 'datetime',
        'estadoUsuario' => 'bool',
    ];
    
    public function Cargo()
    {
        return $this->belongsTo(Cargo::class, 'idCargo', 'idCargo');
    }
    
    public function Publicacion()
    {
        return $this->hasMany(Publicacion::class,'idUser','idUser');
    }
    
    public function Transaccion()
    {
        return $this->hasMany(Transaccion::class,'idUser','idUser');
    }
    
      public function Comprobante()
    {
        return $this->hasMany(Comprobante::class,'idUser','idUser');
    }
    
      public function IngresoProducto()
    {
        return $this->hasMany(IngresoProducto::class,'idUser','idUser');
    }
    
      public function EgresoProducto()
    {
        return $this->hasMany(EgresoProducto::class,'idUser','idUser');
    }
}