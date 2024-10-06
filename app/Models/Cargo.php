<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
 
    protected $table = 'Cargo';
    
    protected $primaryKey = 'idCargo';

    protected $guarded = ['idCargo'];
    
    protected $fillable = ['descCargo'
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'idCargo' => 'int'
    ];

    /**
     * Obtener las relaciones del modelo.
     */
    public function Usuario()
    {
        return $this->hasMany(Usuario::class, 'idCargo', 'idCargo');
    }
}