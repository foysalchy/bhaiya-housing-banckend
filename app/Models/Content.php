<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded =['id'];
     public function parent()
    {
        return $this->belongsTo(Content::class,'parent_id');
    }
    protected $casts = [
        'extra' => 'array',
        ];
}
