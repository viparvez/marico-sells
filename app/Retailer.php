<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $fillable = ['code', 'town_id', 'ownername', 'shopname', 'rmn', 'email', 'hq', 'dsh', 'rh', 'scheme', 'createdbyuserid', 'updatedbyuserid'];

    public function CreatedBy() {
        return $this->belongsTo('App\User', 'createdbyuserid');
    }

    public function UpdatedBy() {
        return $this->belongsTo('App\User', 'updatedbyuserid');
    }

    public function Town(){
    	return $this->belongsTo('App\Town', 'town_id');
    }
}
