<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description','type', 'poster', 'url', 'is_trashed', 'is_archived', 'is_public', 'is_friends', 'is_family', 'is-friends_family'
    ];
    /**
     * The attrbutes are converted to carbon objects
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * Relationships
     */
    public function owner() {
        return  $this->belongsTo(User::class, 'owner');
    }

    public function groups() {
        $this->belongsToMany(Group::class,'group_media');
    }
}
