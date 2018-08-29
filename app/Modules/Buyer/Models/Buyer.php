<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 03:47:03 +0000.
 */

namespace App\Modules\Buyer\Models;

use App\User;
use Reliese\Database\Eloquent\Model as Eloquent;



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
