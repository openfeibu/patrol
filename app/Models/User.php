<?php

namespace App\Models;

use Hash,Auth;
use App\Models\Auth as AuthModel;
use App\Traits\Database\Slugger;
use App\Traits\Database\DateFormatter;
use App\Traits\Filer\Filer;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Request as RequestFacades;

class User extends Authenticatable implements JWTSubject
{
    use Filer, Slugger ,Notifiable;

    /**
     * Configuartion for the model.
     *
     * @var array
     */
    protected $config = 'model.user.user.model';

    public static function checkPassword($phone, $password)
    {

        $user = User::where('phone', $phone)->where('password', bcrypt($password))->first();

        return $user;
    }
    public static function getUserByToken($token)
    {
        $user = User::select('id','phone','name','payment_company_id','provider_id','token')->where('token',$token)->first();

        return $user;
    }
    public static function getUserByPhone($phone)
    {
        return User::select('id','phone','name','payment_company_id','provider_id','token')->where('phone',$phone)->first();
    }
    public static function getUser()
    {
        $token = RequestFacades::input('token','');
        $user = User::select('id','phone','name','payment_company_id','provider_id','token')->where('token',$token)->first();
        if(!$user)
        {
            throw new UnauthorizedHttpException('jwt-auth', '未登录');
        }
        return $user;
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function username()
    {
        return "phone";
    }

}