<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 15 Aug 2018 01:42:10 +0000.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\AuthMenu
 *
 * @property int $id
 * @property string $name 菜单路由
 * @property int $parent_id
 * @property int $status 状态1：正常
 * @property string|null $title 菜单名
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\AuthMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\AuthMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\AuthMenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\AuthMenu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\AuthMenu whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\AuthMenu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\AuthMenu whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $url
 * @property int|null $order 排序
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\System\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\AuthMenu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\AuthMenu whereUrl($value)
 * @property int|null $tier 层
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\AuthMenu whereTier($value)
 */
class AuthMenu extends Eloquent
{
	protected $table = 'auth_menu';
	protected $primaryKey = 'id';

	protected $casts = [
		'parent_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'parent_id',
		'status',
		'title'
	];

    //权限属于哪个角色
    public function roles(){
        return $this->belongsToMany(Role::class,'role_authmenu','auth_menu_id','role_id')->withPivot('auth_menu_id','role_id');
    }
}
