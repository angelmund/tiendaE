<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DetallesPedido
 * 
 * @property int $id_detalles_pedido
 * @property int $cantidad
 * @property float $precio
 * @property int $id_producto
 * @property int $id_pedido
 * 
 * @property Producto $producto
 * @property DetallesPedido $detalles_pedido
 * @property Collection|DetallesPedido[] $detalles_pedidos
 *
 * @package App\Models
 */
class DetallesPedido extends Model
{
	protected $table = 'detalles_pedido';
	protected $primaryKey = 'id_detalles_pedido';
	public $timestamps = false;

	protected $casts = [
		'cantidad' => 'int',
		'precio' => 'float',
		'id_producto' => 'int',
		'id_pedido' => 'int'
	];

	protected $fillable = [
		'cantidad',
		'precio',
		'id_producto',
		'id_pedido'
	];

	public function producto()
	{
		return $this->belongsTo(Producto::class, 'id_producto');
	}

	public function detalles_pedido()
	{
		return $this->belongsTo(DetallesPedido::class, 'id_pedido');
	}

	public function detalles_pedidos()
	{
		return $this->hasMany(DetallesPedido::class, 'id_pedido');
	}
}
