<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = [
        'id',
        'nome',
        'url'
    ];

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class, 'fornecedor_id');
    }
}