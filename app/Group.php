<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'owner', 'has_page'
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
    public function members() {
        return $this->belongsToMany(User::class);
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function posts() {
        return $this->belongsToMany(Media::class, 'group_media');
    }
}
