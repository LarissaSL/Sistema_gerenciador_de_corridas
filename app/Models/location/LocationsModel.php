<?php

namespace App\Models\location;

use App\Models\races\RacesModel;
use App\Models\users\AdministratorsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationsModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "locations";
    protected $fillable = [
        "administrator_id",
        "name",
        "street",
        "number",
        "neighborhood",
        "cep",
        "city",
        "state",
        "status"
    ];

    // Um local foi cadastrado por um administrador
    public function administrator() {
        return $this->belongsTo(AdministratorsModel::class);
    }

    // Um local pode cediar várias corridas
    public function races() {
        return $this->hasMany(RacesModel::class);
    }
}
