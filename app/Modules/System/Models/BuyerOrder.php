<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 11:57:31 +0800.
 */

namespace App\Modules\System\Models;

use App\Modules\Buyer\Models\Buyer;
use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\BuyerOrder
 *
 * @property int $id
 * @property string $order_no 订单编号
 * @property int $buyer_id 采购方id
 * @property float $goods_price 商品总价
 * @property float $order_account 订单本金
 * @property float $order_total 总支付金额
 * @property int $amortize_time 分期
 * @property int $amortize_now 现阶段处于第几期
 * @property string|null $goods_file 商品清单附件
 * @property float $over_cover_charse 逾期服务费总额
 * @property float $cover_charse 总服务费
 * @property float $has_payment 已支付金额
 * @property string|null $contract 合同
 * @property int $effective_end_time 分期截止日期
 * @property int $effective_time 订单生效日期
 * @property int $status 0未生效；1被拒;5生效;6已结束；7退款提交申请；
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Modules\Buyer\Models\Buyer $buyer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\System\Models\BuyerBill[] $order_bills
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\System\Models\BuyerOrderDetail[] $order_detail
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereAmortizeNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereAmortizeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereCoverCharse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereEffectiveEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereEffectiveTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereGoodsFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereGoodsPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereHasPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereOrderAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereOrderTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereOverCoverCharse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BuyerOrder extends Eloquent
{
    const ORDER_NOT_EFFECT = 0;
    const ORDER_REFUSE = 1;
    const ORDER_EFFECT = 5;
    const ORDER_END = 6;
    const ORDER_REFUND = 7;

	protected $table = 'buyer_order';
	protected $primaryKey = 'id';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'buyer_id' => 'int',
		'goods_price' => 'float',
		'order_account' => 'float',
		'order_total' => 'float',
		'amortize_time' => 'int',
		'amortize_now' => 'int',
		'over_cover_charse' => 'float',
		'cover_charse' => 'float',
		'has_payment' => 'float',
		'effective_end_time' => 'int',
		'effective_time' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'order_no',
		'buyer_id',
		'goods_price',
		'order_account',
		'order_total',
		'amortize_time',
		'amortize_now',
		'goods_file',
		'over_cover_charse',
		'cover_charse',
		'has_payment',
		'contract',
		'effective_end_time',
		'effective_time',
		'status'
	];

	//属于哪个导购
	public function buyer()
    {
        return $this->belongsTo(Buyer::class,'id','buyer_id');
    }

    //订单详情
    public function order_detail()
    {
        return $this->hasMany(BuyerOrderDetail::class,'order_no','order_no');
    }

    //订单的所有账单
    public function order_bills(){
        return $this->belongsToMany(BuyerBill::class,'buyer_order_bill','order_no','order_sn')->withPivot('order_sn','order_no');
    }

    //订单生成账单
    public function assigeOrderBill($bill){
        return $this->order_bills()->sync($bill);
    }

    static function statusCN($status)
    {
        $param = array(
            self::ORDER_NOT_EFFECT => '未生效',
            self::ORDER_EFFECT => '已生效',
            self::ORDER_END => '已完成',
            self::ORDER_REFUND => '退款申请',
            self::ORDER_REFUSE => '订单被拒绝'
        );

        return $param[$status];
    }
}
