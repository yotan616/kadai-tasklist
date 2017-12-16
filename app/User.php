<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    
     public function tasks()
    {
        // $this は自分自身（Userクラス）
        // hasMany() は Laravel の呪文、仕様
        // hasMany(どのテーブルを使うか？, そのテーブルないでどのIDをとるか)
        //         ------Task-----------,  --------> $thisのid がデフォルト値
        //                                 -----------> user の id を使う　＝＞　じゃぁカラム名は user_id だね？
        // SQLで書くと： select * from tasks where user_id = ??????;
        return $this->hasMany(Task::class);
    }


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
