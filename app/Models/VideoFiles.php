<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoFiles extends Model
{
    protected $table = 'videos'; 
    protected $fillable = ['user_id', 'path_to_image']; 

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullPathAttribute()
    {
        $imageDirectory = 'your_image_directory';

        return asset($imageDirectory . '/' . $this->path_to_image);
    }
}
