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
                                    <input class="form-control" placeholder="Title">
                                </div>
                                <div class="form-group">
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
                <li class="list-group-item">

                </li>
                <li class="list-group-item">
                    b
                </li>

                <li class="list-group-item">
                c
                </li>

                <li class="list-group-item">
            d
                </li>
            </ul>
       </div>

       <transition name="hero-intro-transition"
       enter-active-class="animated fadeInRight"
       leave-active-class="animated fadeOutLeft" 
       appear 
       v-on:after-appear="changeIntro"
       v-on:after-enter="changeIntro"
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