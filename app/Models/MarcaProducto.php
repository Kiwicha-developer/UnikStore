<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarcaProducto extends Model
{
 
    protected $table = 'MarcaProducto';

    protected $guarded = ['idMarca'];
    
    protected $fillable = ['idMarca',
                            'nombreMarca',
                            'imagenMarca',
                            'slugMarca'
                            ];

    
    protected $hidden = [
    ];

    
    protected $casts = [
        'idMarca' => 'int'
    ];
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($marca) {
            $marca->slugMarca = Str::slug($marca->nombreMarca);
        });

        static::updating(function ($marca) {
            $marca->slugMarca = Str::slug($marca->nombreMarca);
        });
    }

    /**
     * Obtener las relaciones del modelo.
     */
    public function Producto()
    {
        return $this->hasMany(Producto::class,'idMarca','idMarca');
    }
    
    
}