<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'sites';

	protected $fillable = ['key', 'name', 'domain'];
}
