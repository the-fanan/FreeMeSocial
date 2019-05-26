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
                                        <option value="freind-family">Friends and Family</option>
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
                <li class="list-group-item" :class="alertClass" v-show="alert">
                 <strong>${ alert }</strong>
                    <button type="button" v-on:click="alert = null" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-8">
                            <div class="row justify-content-start">
                                <div class="col-2 col-lg-1 col-md-2 col-sm-2">
                                    <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-secondary very-small-circle"/>
                                </div>

                                <div class="col-10 col-lg-11 col-md-10 col-sm-10">
                                    <h4 clas="text-body">The_fanan</h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 justify-content-end d-flex">
                       `    <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="idofpost-post-settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    &sdot; &sdot; &sdot;
                                </button>
                                <div class="dropdown-menu" aria-labelledby="idofpost-post-settings">
                                    <a class="dropdown-item" href="#">Archive</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header">Restrictions</h6>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Public</a>
                                    <a class="dropdown-item" href="#">Friends</a>
                                    <a class="dropdown-item" href="#">Family</a>
                                    <a class="dropdown-item" href="#">Friends & Family</a>
                                </div>
                            </div>
                            <p class="text-muted date">May 04</p>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="text-body">My first Title</p>
                            <div class="image-cover rounded">
                                    <img class="rounded img-responsive" src="{{ asset('images/orange-jelly.jpg') }}"/>
                            </div>
                            
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row">
                        <div class="col-8">
                            <div class="row justify-content-start">
                                <div class="col-2 col-lg-1 col-md-2 col-sm-2">
                                    <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-secondary very-small-circle"/>
                                </div>

                                <div class="col-10 col-lg-11 col-md-10 col-sm-10">
                                    <h4 class="text-body">Anike</h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 justify-content-end d-flex">
                            <p class="text-muted">May 07</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="text-body">My first post</p>
                            <div class="image-cover rounded">
                                    <img class="rounded img-responsive" src="{{ asset('images/fine-girl.jpg') }}"/>
                            </div>
                            
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                        <div class="row">
                            <div class="col-8">
                                <div class="row justify-content-start">
                                    <div class="col-2 col-lg-1 col-md-2 col-sm-2">
                                        <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle border border-secondary very-small-circle"/>
                                    </div>
    
                                    <div class="col-10 col-lg-11 col-md-10 col-sm-10">
                                        <h4 class="text-body">Anike</h4>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-4 justify-content-end d-flex">
                                <p class="text-muted">May 07</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="text-body">My first post</p>
                                <div class="image-cover rounded">
                                    <video controls>
                                        <source src="{{ asset('images/naruto.mp4') }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video> 
                                </div>
                                
                            </div>
                        </div>
                    </li>
    
            </ul>
            <button class="btn btn-block btn-dark load-more btn-lg">Load More</button>
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
            alertClass: "list-group-item-danger" /**list-group-item-warning list-group-item-info list-group-item-success */
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
                        vm.alertClass= "list-group-item-danger"
                    });
                } else {
                    this.alert = "All fields must be filled";
                    this.alertClass= "list-group-item-danger"
                }
            },
            handleFileUpload: function() {
                this.uploadData.media = this.$refs.file.files[0];
            }
        }
    });
</script>
@endpush