<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcional extends Model
{
    use HasFactory;

    // Definir o nome da tabela se não seguir a convenção padrão
    protected $table = 'opcionais';

    
    protected $fillable = [
        'descricao',
        'veiculo_id', 
    ];

    
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'veiculo_id');
    }
}
