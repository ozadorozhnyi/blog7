<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'preview', 'description',
    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function image()
    {
        return $this->hasOne('App\Image');
    }
}
