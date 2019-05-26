<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }

    /**
     * @return string
     */
    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    /**
     * @return string
     */
    public function getUpdatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }
    //parsing dates to humandiff gotten from: https://laracasts.com/discuss/channels/tips/date-accessor-model-date-to-human-carbon-date
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
