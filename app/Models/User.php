<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'student_number',
        'password',
    ];


    public static function getAllUsers(Int $user_id)
    {
        $all_users = self::where('id', '<>', $user_id)->simplePaginate(50);
        return $all_users;
    }

    public static function store($name, $student_number, $password)
    {
        $user = new self([
            'name'            => $name,
            'student_number'  => $student_number,
            'password'        => $password
        ]);
        $user->save();
        return $user;
    }
}
