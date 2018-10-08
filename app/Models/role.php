<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class role extends EntrustRole
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $fillable = [
        'name', 'display_name','description'
    ];

    //多对多关联
    public function users()
    {
        return $this->belongsToMany('App\User','role_user','roles','users');
    }
}
