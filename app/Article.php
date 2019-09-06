<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // add 'belongs to' relationship (article belongs to user)
    public function user() {
      return $this->belongsTo('App\User');
    }
}
