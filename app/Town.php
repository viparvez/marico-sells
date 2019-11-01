<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $fillable = ['code', 'name'];

    public function District(){
    	return $this->belongsTo('App\District', 'district_id');
    }

    public function Retailer(){
        return $this->hasMany('App\Retailer', 'town_id');
    }

    public function CreatedBy() {
        return $this->belongsTo('App\User', 'createdbyuserid');
    }

    public function UpdatedBy() {
        return $this->belongsTo('App\User', 'updatedbyuserid');
    }
}
