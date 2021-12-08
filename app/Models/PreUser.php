<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Designer : 畑
 * Date     : 2021/06/14
 * Purpose  : C6-2 仮登録者情報管理
 */

class PreUser extends Model
{
    const SEND_MAIL             = 0;
    const STUDENT_NUMBER_VERIFY = 1;
    const REGISTER              = 2;

    protected $fillable = [
        'student_number',
        'token',
        'status',
        'expiration_datetime',
    ];

    /**
     * Function Name : store
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : 仮登録情報をデータベースに登録する
     * Return        : PreUser オブジェクト
     */
    public static function store($student_number, $hours = 1)
    {
        $pre_user = new self([
            'student_number'      => $student_number,
            'token'               => Str::random(250),
            'status'              => self::SEND_MAIL,
            'expiration_datetime' => Carbon::now()->addHours($hours),
        ]);
        $pre_user->save();
        return $pre_user;
    }

    /**
     * Function Name : findByToken
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : Token に対応するデータを取得する
     * Return        : PreUser オブジェクト
     */
    public static function findByToken($token)
    {
        $pre_user = self::where('token', '=', $token)->first();
        return $pre_user;
    }

    /**
     * Function Name : studentNumberVerify
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : status を STUDENT_NUMBER_VERIFY にする
     * Return        :
     */
    public function studentNumberVerify()
    {
        $this->status = self::STUDENT_NUMBER_VERIFY;
        $this->update();
    }

    /**
     * Function Name : isRegister
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : status が登録済みか判定する
     * Return        : True or False
     */
    public function isRegister()
    {
        $is_register = $this->status === self::REGISTER;
        return $is_register;
    }

    /**
     * Function Name : studentNumberVerify
     * Designer      : 畑
     * Date          : 2021/06/14
     * Function      : status を REGISTER にする
     * Return        :
     */
    public function register()
    {
        $this->status = self::REGISTER;
        $this->update();
    }
}
