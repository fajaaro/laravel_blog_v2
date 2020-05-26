<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Image extends Model
{
	use softDeletes;

    protected $fillable = ['path', 'imageable_id', 'imageable_type'];

    public function imageable() 
    {
    	return $this->morphTo();
    }

    public function url()
    {
    	return 'http://localhost:8000/storage/' . $this->path;
    }
}
