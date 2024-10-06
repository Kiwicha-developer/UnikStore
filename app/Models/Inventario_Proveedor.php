<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario_Proveedor extends Model
{
 
    public $timestamps = false;
    
    protected $table = 'Inventario_Proveedor';

    protected $primaryKey = 'idInventarioProveedor';
    
    protected $fillable = ['idInventarioProveedor',
                            'idProducto ',
                            'idProveedor ',
                            'stock',
                            'estado'
                            ];

    
    protected $hidden = [
    ];

    
    protected $casts = [
        'idInventarioProveedor' => 'int',
        'idProducto' => 'int',
        'idProveedor' => 'int',
        'stock' => 'int'
    ];
    
     public function Preveedor()
    {
        return $this->belongsTo(Preveedor::class,'idProveedor','idProveedor');
    }
    
     public function Producto()
    {
        return $this->belongsTo(Producto::class,'idProducto','idProducto');
    }
    

    /**
     * Obtener las relaciones del modelo.
     */
    
}