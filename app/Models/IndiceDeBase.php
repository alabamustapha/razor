<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndiceDeBase extends Model
{
    public $table = "indices";

    protected $fillable = [
        'indice', 'valeur',
    ];
    public function user()
    {
        return $this->belongsTo('Laravel\Models\User');
    }
}
