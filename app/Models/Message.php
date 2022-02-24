<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'from_id',
        'to_id',
        'read_at',
        'created_at'
    ];

    protected $dates  =['created_at', 'read_at'];
    public $timestamps = false;

   

    public function from() {
        return $this->belongsTo(User::class, 'from_id');
    }
}
