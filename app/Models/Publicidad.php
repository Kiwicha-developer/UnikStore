<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicidad extends Model
{
 
    protected $table = 'Publicidad';

    protected $guarded = ['idPublicidad'];
    
    protected $fillable = ['descripcionPublicidad',
                            'imagenPublicidad',
                            'tipoPublicidad',
                            'estadoPublicidad'
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'idPublicidad' => 'int'
    ];
    
     public function Empresa()
    {
        return $this->belongsTo(Empresa::class,'idEmpresa','idEmpresa');
    }

}