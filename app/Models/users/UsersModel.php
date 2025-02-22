<?php

namespace App\Models\users;

use App\Models\races\RacesModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'users';
    protected $fillable = [
        'name', 
        'last_name', 
        'phone', 
        'email', 
        'password', 
        'status'
    ];

    // Um administrator é um usuário
    public function administrator() {
       return $this->hasOne(AdministratorsModel::class);
    }

    // Um usuário tem muitas inscrições em corridas
    public function races() {
        return $this->belongsToMany(RacesModel::class, 'inscriptions');
    }
}
