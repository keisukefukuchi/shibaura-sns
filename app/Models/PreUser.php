<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


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


    public static function findByToken($token)
    {
        $pre_user = self::where('token', '=', $token)->first();
        return $pre_user;
    }

    public function studentNumberVerify()
    {
        $this->status = self::STUDENT_NUMBER_VERIFY;
        $this->update();
    }

    public function isRegister()
    {
        $is_register = $this->status === self::REGISTER;
        return $is_register;
    }

    public function register()
    {
        $this->status = self::REGISTER;
        $this->update();
    }
}
