<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoPedido extends Model
{
    protected $table = 'estados';
    protected $primaryKey = 'idEstado';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'idEstado');
    }
}
