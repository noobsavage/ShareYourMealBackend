<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePicEditModel extends Model
{
    
    protected $table="profile";
    //public $timestamps=false;


    protected $fillable=[
    	'user_id',
    	'name',
    	'occupation',
    	'waystatus',
    	'image',
    	'phone',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(SeatCreateModel::class);
    // }
}
