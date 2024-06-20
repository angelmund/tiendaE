<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 * 
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property float $precio_normal
 * @property float $precio_rebajado
 * @property int $cantidad
 * @property string $imagen
 * @property int $id_categoria
 * 
 * @property Categoria $categoria
 * @property Collection|DetallesPedido[] $detalles_pedidos
 *
 * @package App\Models
 */
class Producto extends Model
{
	protected $table = 'productos';
	public $timestamps = false;

	protected $casts = [
		'precio_normal' => 'float',
		'precio_rebajado' => 'float',
		'cantidad' => 'int',
		'id_categoria' => 'int'
	];

	protected $fillable = [
		'nombre',
		'descripcion',
		'precio_normal',
		'precio_rebajado',
		'cantidad',
		'imagen',
		'id_categoria'
	];

	public function categoria()
	{
		return $this->belongsTo(Categoria::class, 'id_categoria');
	}

	public function detalles_pedidos()
	{
		return $this->hasMany(DetallesPedido::class, 'id_producto');
	}
}
