<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 15 Aug 2018 01:42:10 +0000.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\RoleAuthmenu
 *
 * @property int $id
 * @property int $role_id
 * @property int $auth_menu_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\RoleAuthmenu whereAuthMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\RoleAuthmenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\RoleAuthmenu whereRoleId($value)
 * @mixin \Eloquent
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
