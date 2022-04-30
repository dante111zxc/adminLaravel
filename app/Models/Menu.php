<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected  $table = 'menu';
    protected $fillable = [
        'title',
        'guid',
        'slug',
        'parent_id',
        'type',
        'menu_position_id',
        'sort'
    ];


    public function subMenu()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    public function recursiveMenu(){
        return $this->hasMany(Menu::class, 'parent_id', 'id')->with('subMenu');
    }

}
