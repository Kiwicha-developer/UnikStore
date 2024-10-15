<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristicas extends Model
{
    protected $table = 'Caracteristicas';
    
    protected $primaryKey = 'idCaracteristica';

    protected $guarded = ['idCaracteristica'];
    
    protected $fillable = ['especificacion'
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'idCaracteristica' => 'int'
    ];

    public function Caracteristicas_Grupo(){
        return $this->hasMany(Caracteristicas_Grupo::class,'idCaracteristica','idCaracteristica');
    }

    /**
     * Obtener las relaciones del modelo.
     */
}