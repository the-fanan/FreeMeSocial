@extends('layouts.master')

@section('content')
<div class="container home-container">
    <div class="row justify-content-between">
       <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <ul class="list-group">
                <li class="list-group-item list-group-item-very-dark text-white justify-content-between">
                    <div class="row">
                        <div class="col-lg-1 col-md-2 col-sm-2 col-2">
                                <img src="{{ asset(Auth::user()->getProfileImage()) }}" class="img-responsive rounded-circle very-small-circle"/>
                        </div>
                        <div class="col-lg-11 col-md-10 col-sm-10 col-10">
                            <form v-on:submit.prevent="uploadMedia">
                                <div class="form-group">
                                    <input class="form-control" v-model="uploadData.description" placeholder="Enter New Post Description" v-on:focus="showNewPostButtons = true">
                                </div>
                                <div class="form-group" v-show="showNewPostButtons">
                                    <select v-model="uploadData.restriction">
                                        <option value="public">Public</option>
                                        <option value="friends">Friends</option>
                                        <option value="family">Family</option>
                                        <option value="freinds-family">Friends and Family</option>
                                    </select>
                                    <span class="file btn btn-primary">
                                            <input type="file" v-on:change="handleFileUpload" ref="file"/>
                                            <i class="fa fa-camera"></i>
                                    </span>

                                    <button type="submit" class="btn btn-light">
                                        New Post
                                    </button>
                                </div>
        
                            </form>
                        </div>
                    </div>
                </li>
                <li class="list-group-item" :class="alertClass" v-show="alert" v-cloak>
                 <strong>${ alert }</strong>
                    <button type="button" v-on:click="alert = null" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </li>
                <li class="list-group-item" v-for="(post,index) in posts" v-bind:key="post.post_id">
                    <div class="row">
                        <div class="col-8">
                            <div class="row justify-content-start">
                                <div class="col-2 col-lg-1 col-md-2 col-sm-2">
                                    <img :src="baseMediaUrl + post.profile_picture" class="img-responsive rounded-circle border border-secondary very-small-circle"/>
                                </div>

                                <div class="col-10 col-lg-11 col-md-10 col-sm-10">
                                    <h4 clas="text-body">${ post.poster_username }</h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 justify-content-end d-flex">
                       `    <div class="dropdown" v-if="post.poster_username == currentUser">
                                <button class="btn btn-light dropdown-toggle" type="button" :id="post.post_id + '-post-settings'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    &sdot; &sdot; &sdot;
                                </button>
                                <div class="dropdown-menu" :aria-labelledby="post.post_id + '-post-settings'">
                                    <a class="dropdown-item" href="#" v-on:click.prevent="archivePost(post.post_id,index)">Archive</a>
                                    <a class="dropdown-item" href="#" v-on:click.prevent="trashPost(post.post_id,index)">Delete</a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header">Restrictions</h6>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" v-on:click.prevent="restrictPublic(post.post_id)">Public</a>
                                    <a class="dropdown-item" href="#" v-on:click.prevent="restrictFriends(post.post_id)">Friends</a>
                                    <a class="dropdown-item" href="#" v-on:click.prevent="restrictFamily(post.post_id)">Family</a>
                                    <a class="dropdown-item" href="#" v-on:click.prevent="restrictFriendsAndFamily(post.post_id)">Friends & Family</a>
                                </div>
                            </div>
                            <p class="text-muted date">${ post.updated_at }</p>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="text-body">${ post.description }</p>
                            <div class="image-cover rounded">
                                    <img v-if="post.file_type == 'image'" class="rounded img-responsive" :src="baseMediaUrl + post.file_url"/>

                                    <video controls v-else>
                                        <source :src="baseMediaUrl + post.file_url" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video> 
                            </div>
                            
                        </div>
                    </div>
                </li>
            </ul>
            <button class="btn btn-block btn-dark load-more btn-lg" v-on:click="loadMore" v-cloak v-show="showLoadMore">${ loadMoreText }</button>
       </div>

       <transition name="family-column-transition"
       enter-active-class="animated fadeInRight"
       leave-active-class="animated fadeOutRight" 
       appear
       mode="out-in"
       :duration="{ enter: 2000, leave: 800 }">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 family-column"  v-cloak v-show="showFamilies">
                <ul class="list-group">
                        <li class="list-group-item list-group-item-very-dark text-white d-flex justify-content-between">
                        Your Families

                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createFamilyModal">Create</button>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-dark">
                                        <a href="#" class="text-dark">The Abayomi's</a>
                                    </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                </div>
                            </div>    
                        </li>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-dark">
                                        The Akinyomi's
                                    </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-primary very-small-circle"/>
                                    </a>
                                </div>
                            </div>    
                        </li>
                </ul>
            </div>
        </transition>
    </div>
    <span class="show-family rounded-circle justify-content-center" v-on:click="showFamilies = !showFamilies">
        <i class="fa fa-group text-white"></i>
    </span>

    <!-- Modal for create family-->
    <div class="modal fade" id="createFamilyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Family</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <form class="justify-content-center">
                       <div class="form-group">
                           <input class="form-control" placeholder="Family Name"/>
                       </div>
                       <div class="form-group">
                            <input class="form-control" placeholder="Add member"/>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                   </form>
                </div>
                
            </div>
        </div>
    </div>
</div>


@endsection

@push('page-scripts')
<script type="text/javascript">
    const app = new Vue({
        delimiters: ['${', '}'],
        el: '.home-container',
        data: {
            error: null,
            showFamilies: true,
            showNewPostButtons: false,
            uploadData: {description: null, file:null, restriction: "public"},
            alert: null,
            alertClass: "list-group-item-danger",
            currentUser: "{{ Auth::user()->username }}",
            posts: _.uniqBy(JSON.parse("{!! addslashes(Auth::user()->homePagePosts()) !!}"), 'post_id'),
            baseMediaUrl: "{{ asset('/') }}",
            showLoadMore: true,
            loadMoreText: "Load More"
        },
        created() {
            if (window.innerWidth < 577) {
                this.showFamilies = false;
            }
        },
        updated() {
            
            
        },
        methods: {
            uploadMedia: function() {
                if(this.uploadData.description && this.uploadData.media && this.uploadData.restriction) {
                    let formData = new FormData();
                    formData.append('description', this.uploadData.description);
                    formData.append('media', this.uploadData.media);
                    formData.append('restriction', this.uploadData.restriction);
                    let vm = this;
                    axios.post( '/media/upload', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(function(response){
                        vm.alert = response.data.message;
                        vm.alertClass= response.data.alertClass;//"list-group-item-info"
                    })
                    .catch(function(){
                        vm.alert = "An error Occured";
                        vm.alertClass= "list-group-item-danger";
                    });
                } else {
                    this.alert = "All fields must be filled";
                    this.alertClass= "list-group-item-danger";
                }
            },
            handleFileUpload: function() {
                this.uploadData.media = this.$refs.file.files[0];
            },
            archivePost: function(postId,index) {
                let vm = this;
                axios.post('/media/archive',
                {
                    postId: postId
                }).then(function(){
                    vm.posts.splice(index, 1);
                    vm.alert = "Post archived successfully";
                    vm.alertClass= "list-group-item-success";
                }).catch(function(){
                    vm.alert = "An error Occured";
                    vm.alertClass= "list-group-item-danger";
                });
            },
            trashPost: function(postId,index) {
                let vm = this;
                axios.post('/media/trash',
                {
                    postId: postId
                }).then(function(){
                    vm.posts.splice(index, 1);
                    vm.alert = "Post Deleted!";
                    vm.alertClass= "list-group-item-warning"
                }).catch(function(){
                    vm.alert = "An error Occured";
                    vm.alertClass= "list-group-item-danger";
                }); 
            },
            restrictPublic: function(postId) {
                let vm = this;
                axios.post('/media/restrict',
                {
                    retriction: "public",
                    postId: postId
                }).then(function(){
                    vm.alert = "Post visibility set to Public.";
                    vm.alertClass= "list-group-item-info";
                }).catch(function(){
                    vm.alert = "An error Occured";
                    vm.alertClass= "list-group-item-danger";
                });
                
            },
            restrictFriends: function(postId) {
                let vm = this;
                axios.post('/media/restrict',
                {
                    retriction: "friends",
                    postId: postId
                }).then(function(){
                    vm.alert = "Post visibility set to Friends.";
                    vm.alertClass= "list-group-item-info";
                }).catch(function(){
                    vm.alert = "An error Occured";
                    vm.alertClass= "list-group-item-danger";
                });
            },
            restrictFamily: function(postId) {
                let vm = this;
                axios.post('/media/restrict',
                {
                    retriction: "family",
                    postId: postId
                }).then(function(){
                    vm.alert = "Post visibility set to Family.";
                    vm.alertClass= "list-group-item-info";
                }).catch(function(){
                    vm.alert = "An error Occured";
                    vm.alertClass= "list-group-item-danger";
                });  
            },
            restrictFriendsAndFamily: function(postId) {
                let vm = this;
                axios.post('/media/restrict',
                {
                    retriction: "friends-family",
                    postId: postId
                }).then(function(){
                    vm.alert = "Post visibility set to Friends And Family.";
                    vm.alertClass= "list-group-item-info";
                }).catch(function(){
                    vm.alert = "An error Occured";
                    vm.alertClass= "list-group-item-danger";
                });
                
            },
            loadMore: function() {
                //request for more if no more say end of posts
            }

        }
    });
</script>
@endpush