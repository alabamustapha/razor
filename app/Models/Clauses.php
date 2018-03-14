<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clauses extends Model
{
    protected $fillable = [
        'nom', 'designation','coefficient','clause',
    ];
    public function user()
    {
        return $this->belongsTo('Residassur.fr\Models\User');
    }
}
