<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class RoleAuthmenu
 * 
 * @property int $id
 * @property int $role_id
 * @property int $auth_menu_id
 *
 * @package App\Models
 */
class RoleAuthmenu extends Eloquent
{
	protected $table = 'role_authmenu';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int',
		'auth_menu_id' => 'int'
	];

	protected $fillable = [
		'role_id',
		'auth_menu_id'
	];
}
