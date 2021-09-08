<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_info_category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sortorder',
    ];
      // relación 1 a n
      public function campos(){
    return $this->hasMany(User_info_field::class,'category_id');
    }
}
