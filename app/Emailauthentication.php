<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emailauthentication extends Model
{
    protected $fillable = ['email','alias','outgoing_server', 'outgoing_protocol', 'outgoing_port', 'password', 'incoming_server', 'incoming_port', 'incoming_protocol', 'createdbyuserid', 'updatedbyuserid'];
}
