<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $table = 'page_views';

    protected $fillable = ['site_id', 'path', 'referrer'];
}
