<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Buyer
 * 
 * @property int $id
 * @property int $users_id
 * @property float $account_num
 * @property float $use_account
 * @property float $debt_account_num
 * @property float $refund_account_num
 * @property string $mobile
 * @property int $status
 * @property string $business_pic
 * @property string $sccial_agency_code_pic
 * @property string $business_agree_pic
 * @property string $agency_name
 * @property string $agency_id_card
 * @property string $id_card_front
 * @property string $id_card_receive_side
 * @property string $brought_account
 * @property string $brought_bank
 * @property string $brought_other_bank
 * @property int $ssl_num_status
 * @property string $contract_use
 * @property string $contract_sale
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Buyer extends Eloquent
{
	protected $table = 'buyer';
	protected $primaryKey = 'id';

	protected $casts = [
		'users_id' => 'int',
		'account_num' => 'float',
		'use_account' => 'float',
		'debt_account_num' => 'float',
		'refund_account_num' => 'float',
		'status' => 'int',
		'ssl_num_status' => 'int'
	];

	protected $fillable = [
		'users_id',
		'account_num',
		'use_account',
		'debt_account_num',
		'refund_account_num',
		'mobile',
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
}
