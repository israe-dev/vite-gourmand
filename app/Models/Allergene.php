<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergene extends Model
{
    protected $table = 'allergenes';
    protected $fillable = ['libelle'];

    // Relation : Un allergène peut être présent dans plusieurs plats
    public function plats()
    {
        return $this->belongsToMany(Plat::class, 'allergene_plat', 'allergene_id', 'plat_id');
    }
}