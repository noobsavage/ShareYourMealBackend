<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatCreateModel extends Model
{
    
    protected $table="seat";
    //public $timestamps=false;


    protected $fillable=[
    	'host_id',
        'name',
    	'longitude',
    	'latitude',
        'placeName',
    	'No_of_seat',
    	'time',
    	'status',
    ];

    // public function Profile()
    // {
    //     return $this->hasOne(ProfilePicEditModel::class);
    // }
}
