<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendRequestModel extends Model
{
    
    protected $table="request";
   

    protected $fillable=[
    	'seat_id',
    	'host_id',
        'consumer_id',
        'requested_seat',
        'status',
    ];

   
}
