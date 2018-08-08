<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
	protected $fillable = ['title','additional','authors' ,'description', 'published', 'file'];
}
