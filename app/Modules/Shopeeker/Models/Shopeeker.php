<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 03:47:03 +0000.
 */

namespace App\Modules\Shopeeker\Models;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereAgencyMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereAgencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereBusinessAgree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereBusinessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereContractSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereContractUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereSccialAgencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereSslNumStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Shopeeker\Models\Shopeeker whereUserId($value)
 * @mixin \Eloquent
 */
class Shopeeker extends Eloquent
{
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
}
