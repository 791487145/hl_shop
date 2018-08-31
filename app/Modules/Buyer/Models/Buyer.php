<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 03:47:03 +0000.
 */

namespace App\Modules\Buyer\Models;

use App\Modules\System\Models\BuyerBill;
use App\Modules\System\Models\BuyerOrder;
use App\User;
use Reliese\Database\Eloquent\Model as Eloquent;



/**
 * App\Modules\Buyer\Models\Buyer
 *
 * @property int $id
 * @property int $users_id
 * @property float|null $account_num 赊账总额
 * @property float|null $use_account 可用额度
 * @property float|null $debt_account_num 欠款总额
 * @property float|null $refund_account_num 应还总额
 * @property string|null $buyer_mobile
 * @property int $status 0未通过；1通过；2禁用
 * @property string|null $business_pic 营业执照
 * @property string|null $sccial_agency_code_pic 社会信用代码
 * @property string|null $business_agree_pic 营业许可证
 * @property string|null $agency_name 法人姓名
 * @property string|null $agency_id_card 法人身份证号
 * @property string|null $id_card_front 身份证正面
 * @property string|null $id_card_receive_side 身份证反面
 * @property string|null $brought_account 对公账号
 * @property string|null $brought_bank 对公银行
 * @property string|null $brought_other_bank 对公开户支行
 * @property int $ssl_num_status 0未认证；1认证（申请数字证书）
 * @property string|null $contract_use 赊账折佣合同
 * @property string|null $contract_sale 销售协议
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereAccountNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereAgencyIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereAgencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereBroughtAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereBroughtBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereBroughtOtherBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereBusinessAgreePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereBusinessPic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereBuyerMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereContractSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereContractUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereDebtAccountNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereIdCardFront($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereIdCardReceiveSide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereRefundAccountNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereSccialAgencyCodePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereSslNumStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereUseAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\Buyer whereUsersId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\System\Models\BuyerBill[] $bills
 */
class Buyer extends Eloquent
{
    const STATUS_NORMAL = 1;
    const STATUS_DISABLE = 0;
    const STATUS_FORBBIN = 2;

	protected $table = 'buyer';
	protected $primaryKey = 'id';

	protected $casts = [
		'users_id' => 'int',
		'status' => 'int',
		'ssl_num_status' => 'int'
	];

	protected $fillable = [
		'users_id',
		'account_num',
		'use_account',
		'debt_account_num',
		'refund_account_num',
		'buyer_mobile',
		'status',
		'business_pic',
		'sccial_agency_code_pic',
		'business_agree_pic',
		'agency_name',
		'agency_id_card',
		'id_card_front',
		'id_card_receive_side',
		'brought_account',
		'brought_bank',
		'brought_other_bank',
		'ssl_num_status',
		'contract_use',
		'contract_sale'
	];

	public function user()
    {
        return $this->hasOne(User::class,'id','users_id');
    }

    public function bills()
    {
        return $this->hasMany(BuyerBill::class,'id','buyer_id');
    }

    static function buyer($buyer)
    {
        $buyer->statusCN = self::statusCN($buyer->status);
        $buyer->ssl_num_status_CN = self::ssl_status_CN($buyer->ssl_num_status);
        return $buyer;
    }

    static function statusCN($st)
    {
        $status = array(
            0 => '禁用',
            1 => '通过',
        );

        return $status[$st];
    }

    static function ssl_status_CN($st)
    {
        $status = array(
            0 => '未认证',
            1 => '认证'
        );

        return $status[$st];
    }
}
