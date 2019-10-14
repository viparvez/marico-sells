<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ftpauthentication extends Model
{
    protected $fillable = ['server','password','username', 'port','createdbyuserid', 'updatedbyuserid'];
}
