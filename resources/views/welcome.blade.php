@extends('layouts.master')

@section('content')
    <div class="container-fluid parallax-section hero" id="landing"> 
        <div class="row">
            <div class="col-lg col-md justify-content-start d-flex">
                <transition name="hero-intro-transition"
                enter-active-class="animated fadeInLeft"
                leave-active-class="animated fadeOutRight" 
                appear 
                v-on:after-appear="changeIntro"
                v-on:after-enter="changeIntro"
                mode="out-in"
                :duration="{ enter: 2000, leave: 800 }">
                    <div class="home-thumb" v-cloak v-bind:key="currentIntro.h">
                            <h1>${ currentIntro.h }</h1>
                            <p class="text-body">${ currentIntro.p }</p>
                    </div>
                </transition>
            </div>

            <div class="col-lg col-md justify-content-end d-flex ">
                <div class="col-lg-9 col-md-10 home-thumb">
                    <a class="btn btn-primary btn-block btn-lg" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-dark btn-block btn-lg" href="{{ route('register') }}">Register</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script type="text/javascript">
        const app = new Vue({
            delimiters: ['${', '}'],
            el: '#landing',
            data: {
                error: null,
                intros: [
                    {h: "Welcome to FreeMe Social",p: "A media sharing app"}, 
                    {h: "Share experiences with friends &Family", p: "Customize who to share posts with"}, 
                    {h: "Create lasting memories", p:"Your content stays with us secure and as long as you want"}
                ],
                introShow: 0,
                currentIntro: null
            },
            created() {
                this.currentIntro = this.intros[0]
            },
            updated() {
                
               
            },
            methods: {
                changeIntro: function () {
                    var n = this.intros.length;
                    var i;
                    if (this.introShow + 1 == n) {
                        i = 0;
                        this.introShow = 0;
                    } else {
                        i = this.introShow + 1;
                        this.introShow++;
                    }
                    this.currentIntro = this.intros[i];
                }
            }
        });
    </script>
@endpush
    