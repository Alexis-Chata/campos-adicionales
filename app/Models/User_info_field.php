<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_info_field extends Model
{
    use HasFactory;
    protected $fillable = [
        'shortname',
        'name',
        'dataype',
        'description',
        'descriptionformat',
        'sortorder',
        'category_id',
        'require',
        'locked',
        'visible',
        'forceunique',
        'signup',
        'defaultdata',
        'name',
        'defaultdataformat',
        'param1',
        'param2',
        'param3',
        'param4',
        'param5',
    ];

    // relación 1 a n (inversa)
    public function categoriab(){
        return $this->belongsTo(User_info_category::class,'name');
        }
    //relacion de n a n
    public function usuarios(){
        return $this->belongsToMany(User_info_field::class,'field_user','field_id','user_id')->withPivot('data');
    }
}   
