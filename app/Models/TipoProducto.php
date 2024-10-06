<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
 
    protected $table = 'TipoProducto';

    protected $guarded = ['idTipoProducto'];
    
    protected $primaryKey = 'idTipoProducto';
    
    protected $fillable = ['tipoProducto',
                            'slugTipo'
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'idTipoProducto' => 'int'
    ];
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($tipo) {
            $tipo->slugTipo = Str::slug($tipo->tipoProducto);
        });

        static::updating(function ($tipo) {
            $tipo->slugTipo = Str::slug($tipo->tipoProducto);
        });
    }

    /**
     * Obtener las relaciones del modelo.
     */
    public function GrupoProducto()
    {
        return $this->hasMany(GrupoProducto::class,'idTipoProducto','idTipoProducto');
    }
    
}