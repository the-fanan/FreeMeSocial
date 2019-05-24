@extends('layouts.master')

@section('content')
<div class="container home-container">
    <div class="row justify-content-between">
       <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <ul class="list-group">
                <li class="list-group-item list-group-item-very-dark text-white justify-content-between">
                    <div class="row">
                        <div class="col-lg-1 col-md-2 col-sm-2 col-2">
                                <img src="{{ asset('images/avatar.png') }}" class="img-responsive rounded-circle very-small-circle"/>
                        </div>
                        <div class="col-lg-11 col-md-10 col-sm-10 col-10">
                            <form>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Enter New Post Description" v-on:focus="showNewPostButtons = true" v-on:blur="showNewPostButtons = false">
                                </div>
                                <div class="form-group" v-show="showNewPostButtons">
                                    <button class="file btn btn-primary">
                                            <input hidden type="file" name="file"/>
                                            <i class="fa fa-camera"></i>
                                    </button>

                                    <button type="submit" class="btn btn-light">
                                        New Post
                                    </button>
                                </div>
        
                            </form>
                        </div>
                    </div>
                </li>
                <!--li class="list-group-item">
                        intendted for new posts
                </li-->
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
                            <p class="text-muted">May 04</p>
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
                        <li class="list-group-item list-group-item-very-dark text-white">
                        Families
                        </li>
                </ul>
            </div>
        </transition>
    </div>
    <span class="show-family rounded-circle justify-content-center" v-on:click="showFamilies = !showFamilies">
        <i class="fa fa-group text-white"></i>
    </span>
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
        },
        created() {
            if (window.innerWidth < 577) {
                this.showFamilies = false;
            }
        },
        updated() {
            
            
        },
        methods: {
            
        }
    });
</script>
@endpush