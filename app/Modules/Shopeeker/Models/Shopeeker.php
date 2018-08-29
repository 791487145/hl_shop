<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 03:47:03 +0000.
 */

namespace App\Modules\Shopeeker\Models;

use App\Modules\System\Models\ConfCity;
use App\User;
use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\Shopeeker\Models\Shopeeker
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $company_name 公司全称
 * @property string|null $business_code 营业执照注册号
 * @property string|null $sccial_agency_code 社会信用机构代码证
 * @property string|null $business_agree 营业许可正号
 * @property string|null $agency_name 负责人姓名
 * @property string|null $agency_mobile 负责人手机号
 * @property int $province 省
 * @property int $city 市
 * @property int $area 区
 * @property string|null $contract_use 赊账试用合同
 * @property string|null $contract_sale 销售协议
 * @property int $ssl_num_status 0未认证；1认证（申请数字证书）
 * @property int $status 0未通过；1通过；2禁用
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $business_agree_pic
 * @property string|null $business_code_pic
 * @property string|null $sccial_agency_code_pic
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereAgencyMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereAgencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereBusinessAgree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereBusinessAgreePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereBusinessCodePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereContractSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereContractUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereSccialAgencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereSccialAgencyCodePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereSslNumStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $agency_id_card
 * @property string|null $brought_account 对公账号
 * @property string|null $brought_bank 对公银行
 * @property string|null $brought_other_bank 对公开户支行
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereAgencyIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereBroughtAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereBroughtBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereBroughtOtherBank($value)
 * @property-read \App\User $user
 */
class Shopeeker extends Eloquent
{
    const STATUS_FAIL = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FORBBIN = 2;

	protected $table = 'shopeeker';
	protected $primaryKey = 'id';

	protected $casts = [
		'user_id' => 'int',
		'province' => 'int',
		'city' => 'int',
		'area' => 'int',
		'ssl_num_status' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'user_id',
		'company_name',
		'business_code',
		'sccial_agency_code',
		'business_agree',
		'agency_name',
		'agency_mobile',
		'province',
		'city',
		'area',
		'contract_use',
		'contract_sale',
		'ssl_num_status',
		'status'
	];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    static function shopeeker($shopeeker)
    {
        $province = ConfCity::whereId($shopeeker->province)->value('name');
        $city = ConfCity::whereId($shopeeker->city)->value('name');
        $area = ConfCity::whereId($shopeeker->area)->value('name');
        $shopeeker->statusCN = self::statusCN($shopeeker->status);
        $shopeeker->ssl_num_status_CN = self::ssl_status_CN($shopeeker->ssl_num_status);
        $shopeeker->district = $province.$city.$area;
        return $shopeeker;
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
