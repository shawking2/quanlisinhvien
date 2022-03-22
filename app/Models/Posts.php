<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $fillable = [ 'idUser', 'title','content', 'idInfoFile','status'];

    //Relationships
    public function files()
    {
        return $this->hasMany('App\Models\FileSubmit', 'idPost');
    }
    public function infofile()
    {
        return $this->belongsTo('App\Models\InfoFile', 'idUser');
    }
 
}

