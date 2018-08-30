<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * Class BuyerOrderBill
 *
 * @property int $id
 * @property string $order_no
 * @property string $order_sn
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderBill whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderBill whereOrderSn($value)
 * @mixin \Eloquent
 */
class BuyerOrderBill extends Eloquent
{
    protected $table = 'buyer_order_bill';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'order_no',
        'order_sn'
    ];

    public function bills()
    {
        return $this->hasOne(BuyerBill::class,'order_sn','order_sn');
    }

    public function orders()
    {
        return $this->belongsTo(BuyerOrder::class,'order_no','order_no');
    }
}
