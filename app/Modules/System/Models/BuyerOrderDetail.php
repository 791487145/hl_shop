<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 Aug 2018 06:22:20 +0000.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * App\Modules\System\Models\BuyerOrderDetail
 *
 * @property int $id
 * @property string $order_no 订单编号
 * @property string $goods_name 商品名称
 * @property int $goods_num 数量
 * @property float $goods_price 单价
 * @property float $goods_total 总价
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderDetail whereGoodsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderDetail whereGoodsNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderDetail whereGoodsPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderDetail whereGoodsTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderDetail whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderDetail whereUpdatedAt($value)
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
