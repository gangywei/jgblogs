<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{
	protected $table = 'role_user';
	public $timestamps = false;
    protected $fillable = [
        'user_id', 'role_id'
    ];
}
