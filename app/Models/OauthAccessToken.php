<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class OauthAccessToken
 * 
 * @property string $id
 * @property int $user_id
 * @property int $client_id
 * @property string $name
 * @property string $scopes
 * @property bool $revoked
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $expires_at
 *
 * @package App\Models
 */
class OauthAccessToken extends Eloquent
{
	protected $primaryKey = 'id';
	public $incrementing = false;

	protected $casts = [
		'user_id' => 'int',
		'client_id' => 'int',
		'revoked' => 'bool'
	];

	protected $dates = [
		'expires_at'
	];

	protected $fillable = [
		'user_id',
		'client_id',
		'name',
		'scopes',
		'revoked',
		'expires_at'
	];
}
