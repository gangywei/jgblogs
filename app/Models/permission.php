<?php

namespace App\Models;
use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\SoftDeletes;

class permission extends EntrustPermission
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $fillable = [
        'name', 'display_name','description'
    ];
}
