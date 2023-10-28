<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'consent', // Add other fields as needed
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Specify the columns to be encrypted and decrypted
    protected $encryptable = [
        'id_card_data',
        'file_data',
        'video_data',
    ];

    public function idCardImages()
    {
        return $this->hasMany(IdCardImage::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}

