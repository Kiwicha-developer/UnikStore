<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preveedor extends Model
{
    public $timestamps = false;
    protected $table = 'Preveedor';

    protected $guarded = ['idProveedor'];
    
    protected $fillable = ['idProveedor',
                            'nombreProveedor',
                            'razSocialProveedor',
                            'rucProveedor'
                            ];

    
    protected $hidden = [
    ];

    
    protected $casts = [
        'idProveedor' => 'int'
    ];

    /**
     * Obtener las relaciones del modelo.
     */
    public function Producto()
    {
        return $this->hasMany(Producto::class,'idProveedor','idProveedor');
    }
    public function Comprobante()
    {
        return $this->hasMany(Comprobante::class,'idProveedor','idProveedor');
    }
    public function Inventario_Proveedor()
    {
        return $this->hasMany(Inventario_Proveedor::class,'idProveedor','idProveedor');
    }
    
    
}