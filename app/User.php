<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * The attrbutes are converted to carbon objects
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * User functions
     */
    /**
     * Returns full path to user image
     *
     * @return string
     */
    public function getProfileImage() {
        return asset('/images/avatar.png');
    }

    /**
     * Get Family of user
     *
     * @return Object
     */
    public function ownFamily() {
        return $this->ownGroups()->where('type', 'family')->first();
    }

    /**
     * Get Friends of user
     *
     * @return Object
     */
    public function ownFriends() {
        return $this->ownGroups()->where('type', 'friends')->first();
    }

    public function createAndAssociateGroups() {
        //create
        $family = $this->ownGroups()->create([
            'type' => 'family',
            'has_page' => 1
        ]);

        $friends = $this->ownGroups()->create([
            'type' => 'friends',
        ]);
        //associate
        $this->groups()->attach($family);
        $this->groups()->attach($friends);
    }

    /**
     * Relationships
     */
    /**
     * Groups User owns
     */
    public function ownGroups() {
        return $this->hasMany(Group::class, 'owner');
    }
    /**
     * Groups user belongs to
     */
    public function groups() {
        return $this->belongsToMany(Group::class);
    }
    /**
     * User's own posts
     */
    public function ownPosts() {
        return $this->hasMany(Media::class, 'poster');
    }
    /**
     * Posts user has access to via groups he is associated with
     */
    public function posts() {
        return Media
            ::join('group_medias', 'medias.id', '=', 'group_media.media_id')
            ->join('groups', 'group_media.group_id', '=', 'groups.id')
            ->join('group_users', 'groups.id', '=', 'group_user.group_id')
            ->join('users', 'group_user.user_id', '=', 'users.id')
            ->where('deals.id', $this->id);
    }
}

