<?php

namespace App\Models\token;

use App\Models\users\AdministratorsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginTokenModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "login_token";
    protected $fillable = [
        "token",
        "status",
        "attempt",
        "administrator_id"
    ];

    // Um Token pertence a um administrator
    public function administrator() {
        return $this->belongsTo(AdministratorsModel::class);
    }
}
