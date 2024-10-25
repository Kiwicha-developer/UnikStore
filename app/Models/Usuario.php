<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $timestamps = false;
 
    protected $table = 'Usuario';
    
    protected $primaryKey = 'idUser';

    protected $guarded = ['pass'];
    
    protected $fillable = ['idUser','user','idCargo','tokenSesion','registroSesion','horaSesion','estadoUsuario','bandeja'
                            ];

    protected $hidden = [
        
    ];

    protected $casts = [
        'idUser' => 'int',
        'idCargo' => 'int',
        'tokenSesion' => 'int',
        'registroSesion' => 'boolean',
        'horaSesion' => 'datetime',
        'estadoUsuario' => 'boolean',
    ];
    
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

    public function Accesos()
    {
        return $this->hasMany(Accesos::class,'idUser','idUser');
    }
}