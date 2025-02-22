<?php

namespace App\Models\location;

use App\Models\races\RacesModel;
use App\Models\users\AdministratorsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineLocationModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "online_location";
    protected $fillable = [
        "administrator_id",
        "link",
        "room",
        "room_password"
    ];

    // Um local online pertence a um administrator
    public function administrator() {
        return $this->belongsTo(AdministratorsModel::class);
    }

    // Um local online pode cediar uma corrida 
    public function race() {
        return $this->hasOne(RacesModel::class);
    }
}
