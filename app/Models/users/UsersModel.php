<?php

namespace App\Models\users;

use App\Models\races\RacesModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UsersModel extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'name', 
        'last_name', 
        'phone', 
        'email', 
        'password', 
        'status'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts()
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Um administrator é um usuário
    public function administrator() {
        return $this->hasOne(AdministratorsModel::class, 'user_id', 'id');
    }

    // Um usuário tem muitas inscrições em corridas
    public function races() {
        return $this->belongsToMany(RacesModel::class, 'inscriptions');
    }
}
