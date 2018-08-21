<?php

namespace App;

use App\Models\OauthAccessToken;
use App\Modules\Shopeeker\Models\Shopeeker;
use App\Modules\System\Models\Role;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $mobile
 * @property string $password
 * @property int|null $status 1:正常；0禁用
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OauthAccessToken[] $oauth_access_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\System\Models\Role[] $roles
 */
class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    const STATUS_NORMAL = 1;
    const STATUS_DISABLE = 0;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function oauth_access_token()
    {
        return $this->hasMany(OauthAccessToken::class,'user_id','id');
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'user_role','user_id','role_id')->withPivot('user_id','role_id');
    }

    public function deleteRole($roles){
        return $this->roles()->detach($roles);
    }

    public function assigeRole($roles){
        return $this->roles()->sync($roles);
    }

    public function hasPermission($permission){
        return $this->isInroles($permission->roles);
    }

    //是否有某些角色
    public function isInroles($roles){

        if($roles instanceof Collection){
            return $this->roles->intersect($roles)->count();
        }else{
            return $this->roles->contains($roles);
        }
    }

    public function shopeeker()
    {
        return $this->hasOne(Shopeeker::class,'user_id','id');
    }
}
