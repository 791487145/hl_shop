<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 03:47:03 +0000.
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
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderDetail whereGoodsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderDetail whereGoodsNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderDetail whereGoodsPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderDetail whereGoodsTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderDetail whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderDetail whereUpdatedAt($value)
 * @mixin \Eloquent
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
