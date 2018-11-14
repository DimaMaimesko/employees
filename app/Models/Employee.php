<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{


    protected $fillable = ['name','department','position','salary','hired_at', 'boss_id'];

    public function parent(){
        return $this->belongsTo(static::class, 'boss_id', 'id');
    }

    public function children(){
        return $this->hasMany(static::class, 'boss_id', 'id');
    }


}