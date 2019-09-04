<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'updated_at'
    ];

    public function users()
    {
      return $this->belongsTo('App\Model\User')->get();
    }
}
