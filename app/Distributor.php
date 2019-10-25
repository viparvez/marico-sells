<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $fillable = ['code', 'ownername', 'distributorname', 'rmn', 'email', 'hq', 'dsh', 'rh', 'scheme', 'createdbyuserid', 'updatedbyuserid'];

    public function CreatedBy() {
        return $this->belongsTo('App\User', 'createdbyuserid');
    }

    public function UpdatedBy() {
        return $this->belongsTo('App\User', 'updatedbyuserid');
    }

    public function Town(){
    	return $this->belongsTo('App\Town', 'town_id');
    }

    public function Retailer(){
        return $this->hasMany('App\Retailer', 'distributor_id');
    }
}
