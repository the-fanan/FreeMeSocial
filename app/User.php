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
        return asset($this->profile_picture);
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

    public function homePagePosts() {
        return $this->posts()->where('is_trashed', 0)->where('is_archived', 0)->get();
    }

    
    public function getUserPublicPosts() {
        $postDetails = $this->ownPosts()->join('users', 'medias.poster', '=', 'users.id')->where('is_trashed', 0)->where('is_archived', 0)->where('is_public',1)->get(['medias.id as post_id', 'medias.description as description', 'medias.url as file_url', 'medias.type as file_type', 'medias.created_at', 'medias.updated_at', 'users.name as poster_name', 'users.id as poster_id', 'users.username as poster_username', 'users.email as poster_email', 'users.profile_picture']);
        return $postDetails->toArray();
    }

    public function getAllUserPosts() {
        $postDetails = $this->ownPosts()->join('users', 'medias.poster', '=', 'users.id')->where('is_trashed', 0)->where('is_archived', 0)->get(['medias.id as post_id', 'medias.description as description', 'medias.url as file_url', 'medias.type as file_type', 'medias.created_at', 'medias.updated_at', 'users.name as poster_name', 'users.id as poster_id', 'users.username as poster_username', 'users.email as poster_email', 'users.profile_picture']);
        return $postDetails->toArray();
    }

    public function getUserArchives() {
        $postDetails = $this->ownPosts()->join('users', 'medias.poster', '=', 'users.id')->where('is_trashed', 0)->where('is_archived', 1)->get(['medias.id as post_id', 'medias.description as description', 'medias.url as file_url', 'medias.type as file_type', 'medias.created_at', 'medias.updated_at', 'users.name as poster_name', 'users.id as poster_id', 'users.username as poster_username', 'users.email as poster_email', 'users.profile_picture']);
        return $postDetails->toArray();
    }

    public function getUserTrashed() {
        $postDetails = $this->ownPosts()->join('users', 'medias.poster', '=', 'users.id')->where('is_trashed', 1)->get(['medias.id as post_id', 'medias.description as description', 'medias.url as file_url', 'medias.type as file_type', 'medias.created_at', 'medias.updated_at', 'users.name as poster_name', 'users.id as poster_id', 'users.username as poster_username', 'users.email as poster_email', 'users.profile_picture']);
        return $postDetails->toArray();
    }

    public function getPageOwnerRelationPosts($pageOwner) {
        return $this->posts()->where('is_trashed', 0)->where('is_archived', 0)->where('poster', $pageOwner->id)->get();
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
        return Media::select('medias.id as post_id', 'medias.description as description', 'medias.url as file_url', 'medias.type as file_type', 'medias.created_at', 'medias.updated_at', 'users.name as poster_name', 'users.id as poster_id', 'users.username as poster_username', 'users.email as poster_email', 'users.profile_picture')
            ->join('group_media', 'medias.id', '=', 'group_media.media_id')
            ->join('groups', 'group_media.group_id', '=', 'groups.id')
            ->join('group_user', 'groups.id', '=', 'group_user.group_id')
            ->join('users', 'group_user.user_id', '=', 'users.id')
            ->where('users.id', $this->id);
    }
}

