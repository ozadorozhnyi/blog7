<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'original',
        'hashed',
    ];

    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    /**
     * Override method by adding physical file deletion.
     */
    public function delete()
    {
        if (Storage::disk('images')->exists($this->hashed)) {
        
            // Delete the linked file on disk
            $deleted = Storage::disk('images')->delete($this->hashed);
            if (!$deleted) {
                \Log::error('Some error occured while deleting linked file.');
            }
        }

        // Call parent method to complete what you started :)
        parent::delete();
    }
}
