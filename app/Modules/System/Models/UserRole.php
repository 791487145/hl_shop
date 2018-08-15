<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 15 Aug 2018 01:42:10 +0000.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\UserRole
 *
 * @property int $id
 * @property int $role_id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\UserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\UserRole whereUserId($value)
 * @mixin \Eloquent
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
