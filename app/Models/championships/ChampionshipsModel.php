<?php

namespace App\Models\championships;

use App\Models\races\RacesModel;
use App\Models\users\AdministratorsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChampionshipsModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "championships";
    protected $fillable = [
        "administrator_id",
        "name",
        "acronym",
        "start_date",
        "final_date",
        "status"
    ];

    // Um campeonato pertence a um administrator
    public function administrator() {
        return $this->belongsTo(AdministratorsModel::class);
    }

    // Um campeonato pode ter várias corridas
    public function races() {
        return $this->hasMany(RacesModel::class);
    }
}
