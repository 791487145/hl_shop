<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UserRole
 * 
 * @property int $id
 * @property int $role_id
 * @property int $user_id
 *
 * @package App\Models
 */
class UserRole extends Eloquent
{
	protected $table = 'user_role';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'role_id',
		'user_id'
	];
}
