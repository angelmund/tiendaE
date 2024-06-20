<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 * 
 * @property int $idCliente
 * @property string $nombre_completo
 * @property string $correo
 * @property int $telefono
 * @property string $direccion
 * 
 * @property Collection|Pedido[] $pedidos
 *
 * @package App\Models
 */
class Cliente extends Model
{
	protected $table = 'clientes';
	protected $primaryKey = 'idCliente';
	public $timestamps = false;

	protected $casts = [
		'telefono' => 'int'
	];

	protected $fillable = [
		'nombre_completo',
		'correo',
		'telefono',
		'direccion'
	];

	public function pedidos()
	{
		return $this->hasMany(Pedido::class, 'id_cliente');
	}
}
