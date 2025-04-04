<?php

namespace App\Models\users;

use App\Models\championships\ChampionshipsModel;
use App\Models\location\LocationsModel;
use App\Models\location\OnlineLocationModel;
use App\Models\races\RacesModel;
use App\Models\token\LoginTokenModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdministratorsModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "administrators";
    protected $fillable = [
        'user_id'
    ];

    // Um administrador é um usuário
    public function user() {
        return $this->belongsTo(UsersModel::class, 'user_id', 'id');
    }

    // Método para encontrar o administrador de um usuário específico
    public static function findAdministratorByUserId($userId){
        return self::where('user_id', $userId)->first();
    }

    // Um administrador pode ter vários tokens de Login
    public function loginTokens() {
        return $this->hasMany(LoginTokenModel::class);
    }

    // Um administrador pode cadastrar vários campeonatos
    public function championships() {
        return $this->hasMany(ChampionshipsModel::class);
    }

    // Um administrador pode cadastrar vários locais online
    public function onlineLocations() {
        return $this->hasMany(OnlineLocationModel::class);
    }

    // Um administrador pode cadastrar vários locais
    public function locations() {
        return $this->hasMany(LocationsModel::class);
    }

    // Um administrador pode cadastrar várias corridas
    public function races() {
        return $this->hasMany(RacesModel::class);
    }

}
