<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculos';
    
    protected $fillable = [
        'id',
        'codigoVeiculo',
        'fornecedor_id',
        'marca',
        'modelo',
        'ano',
        'versao',
        'cor',
        'km',
        'combustivel',
        'cambio',
        'portas',
        'preco',
        'date'
    ];

   public function opcionais()
   {
       return $this->hasMany(Opcional::class, 'veiculo_id');
   }
}