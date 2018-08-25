<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Shopeeker
 * 
 * @property int $id
 * @property int $user_id
 * @property string $company_name
 * @property string $business_code
 * @property string $sccial_agency_code
 * @property string $business_agree
 * @property string $agency_name
 * @property string $agency_id_card
 * @property string $agency_mobile
 * @property int $province
 * @property int $city
 * @property int $area
 * @property string $contract_use
 * @property string $contract_sale
 * @property int $ssl_num_status
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $business_agree_pic
 * @property string $business_code_pic
 * @property string $sccial_agency_code_pic
 * @property string $brought_account
 * @property string $brought_bank
 * @property string $brought_other_bank
 *
 * @package App\Models
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
		'agency_id_card',
		'agency_mobile',
		'province',
		'city',
		'area',
		'contract_use',
		'contract_sale',
		'ssl_num_status',
		'status',
		'business_agree_pic',
		'business_code_pic',
		'sccial_agency_code_pic',
		'brought_account',
		'brought_bank',
		'brought_other_bank'
	];
}
