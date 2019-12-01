<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $fillable = ['code', 'distributor_id', 'ownername', 'shopname', 'rmn', 'email', 'tmname', 'tmemail', 'createdbyuserid', 'updatedbyuserid'];

    public function CreatedBy() {
        return $this->belongsTo('App\User', 'createdbyuserid');
    }

    public function UpdatedBy() {
        return $this->belongsTo('App\User', 'updatedbyuserid');
    }

    public function Distributor(){
    	return $this->belongsTo('App\Distributor', 'distributor_id');
    }
}
