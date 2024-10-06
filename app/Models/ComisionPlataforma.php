<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComisionPlataforma extends Model
{
    public $timestamps = false;
 
    protected $table = 'ComisionPlataforma';
    
    protected $primaryKey = 'idComisionPlataforma';

    protected $guarded = ['idComisionPlataforma','idPlataforma'];
    
    protected $fillable = ['comision'
                            ];

    
    protected $hidden = [
    ];

    
    protected $casts = [
        'idComisionPlataforma' => 'int'
    ];

    /**
     * Obtener las relaciones del modelo.
     */
    public function Plataforma()
    {
        return $this->belongsTo(Plataforma::class,'idPlataforma','idPlataforma');
    }
    
}