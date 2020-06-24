<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class foundationmealModel extends Model
{
    
    protected $table="meal_donation";
    


    protected $fillable=[
    	'image',
    	'name',
    	'quantity',
    	'description',
    	'seat_id',
        'phone',
    
    ];

    // public function user()
    // {
    //     return $this->belongsTo(SeatCreateModel::class);
    // }
}
