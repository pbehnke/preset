<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Slim\Http\Request;

class Project extends Model
{
    protected $table = 'projects';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'url',
        'dir'
    ];

    public function users()
    {
      return $this->belongsTo('App\Model\User')->get();
    }

    public static function add(Array $project)
    {
        $project = new Project;

        $project->name = $project['name'];
        $project->description = $project['description'];
        $project->url = $project['url'];
        $project->dir = $project['dir'];

        return $project->save();
    }
}
