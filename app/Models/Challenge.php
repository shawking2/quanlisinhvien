<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','idInfoFile', 'answer', 'title', 'content',  'status', 'contentFile'
    ];
    //Relationships
    public function infofile()
    {
        return $this->belongsTo('App\Models\InfoFile', 'idInfoFile');
    }

}
