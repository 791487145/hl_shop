<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 Aug 2018 10:52:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class OauthPersonalAccessClient
 * 
 * @property int $id
 * @property int $client_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class OauthPersonalAccessClient extends Eloquent
{
	protected $casts = [
		'client_id' => 'int'
	];

	protected $fillable = [
		'client_id'
	];
}
