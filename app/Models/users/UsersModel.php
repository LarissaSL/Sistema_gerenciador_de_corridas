<?php

namespace App\Models\users;

use App\Models\passwordResetToken\PasswordResetTokenModel;
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

    // Método para verificar se o usuário é um administrador
    public function isAdministrator(){
        return $this->administrator()->exists();
    }
 
    // Método para encontrar o usuário de um administrador específico
    public static function findUserByAdministratorId($administratorId){
        $administrator = AdministratorsModel::find($administratorId);
        return $administrator ? $administrator->user : null;
    }

    // Um usuário tem muitas inscrições em corridas
    public function races() {
        return $this->belongsToMany(RacesModel::class, 'inscriptions');
    }

    public function passwordResetTokens()
{
    return $this->hasMany(PasswordResetTokenModel::class);
}
}
