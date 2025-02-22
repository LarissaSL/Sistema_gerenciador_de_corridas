<?php

namespace App\Models\races;

use App\Models\championships\ChampionshipsModel;
use App\Models\location\LocationsModel;
use App\Models\location\OnlineLocationModel;
use App\Models\users\AdministratorsModel;
use App\Models\users\UsersModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RacesModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'races';
    protected $dates = ['date'];

    protected $fillable = [
        'administrator_id',
        'location_id',
        'online_location_id',
        'championship_id',
        'name',
        'date',
        'time',
        'category',
        'price',
        'status'
    ];

    // Uma corrida pertence a um administrator
    public function administrator() {
        return $this->belongsTo(AdministratorsModel::class);
    }

    // Uma corrida pode ocorrer em apenas um local presencial
    public function location() {
        return $this->belongsTo(LocationsModel::class);
    }

    // Uma corrida pode ocorrer em apenas um local online
    public function onlineLocation() {
        return $this->belongsTo(OnlineLocationModel::class);
    }

    // Uma corrida pode estar em apenas um campeonato
    public function championship() {
        return $this->belongsTo(ChampionshipsModel::class);
    }

    // Uma corrida possui muitos usuários inscritos nela
    public function users() {
        return $this->belongsToMany(UsersModel::class, 'inscriptions');
    }

}
