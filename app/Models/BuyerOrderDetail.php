<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BuyerOrderDetail
 * 
 * @property int $id
 * @property string $order_no
 * @property string $goods_name
 * @property int $goods_num
 * @property float $goods_price
 * @property float $goods_total
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class BuyerOrderDetail extends Eloquent
{
	protected $table = 'buyer_order_detail';
	protected $primaryKey = 'id';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'goods_num' => 'int',
		'goods_price' => 'float',
		'goods_total' => 'float'
	];

	protected $fillable = [
		'order_no',
		'goods_name',
		'goods_num',
		'goods_price',
		'goods_total'
	];
}
