<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 15 Aug 2018 01:42:10 +0000.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $description 描述
 * @property int $order 排序
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Role whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\System\Models\UserRole[] $role_user
 */
class Role extends Eloquent
{
	protected $table = 'role';
	protected $primaryKey = 'id';

	protected $casts = [
		'order' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'order'
	];

	public function role_user()
    {
        return $this->hasMany('App\Modules\System\Models\UserRole','role_id','id');
    }
}
