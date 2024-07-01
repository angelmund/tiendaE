<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pedido
 * 
 * @property int $idPedido
 * @property Carbon $fecha
 * @property float $total
 * @property int $id_cliente
 * 
 * @property Cliente $cliente
 *
 * @package App\Models
 */
class Pedido extends Model
{
	protected $table = 'pedidos';
	protected $primaryKey = 'idPedido';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime',
		'total' => 'float',
		'id_cliente' => 'int',
	];

	protected $fillable = [
		'fecha',
		'total',
		'id_cliente',

	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'id_cliente');
	}

}
