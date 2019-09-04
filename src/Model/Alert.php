<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'alerts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'status_id',
        'title',
        'description',
        'priotiy',
        'updated_at'
    ];

    public function users()
    {
      return $this->belongsTo('App\Model\User')->get();
    }
}
