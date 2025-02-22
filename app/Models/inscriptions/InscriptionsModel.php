<?php

namespace App\Models\inscriptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscriptionsModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inscriptions';
    protected $fillable = [
        'race_id',
        'user_id',
        'payment_status',
        'payment_method',
        'status'
    ];
}
