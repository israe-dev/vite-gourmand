<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    protected $table = 'plats';

    protected $fillable = ['nom', 'type', 'photo', 'description', 'quantite'];

    // Un plat peut contenir plusieurs allergènes
    public function allergenes()
    {
        return $this->belongsToMany(Allergene::class, 'allergene_plat', 'plat_id', 'allergene_id');
    }

    // Un plat peut appartenir à plusieurs menus 
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_plat', 'plat_id', 'menu_id');
    }
}