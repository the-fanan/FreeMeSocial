@extends('layouts.master')

@section('content')
<div class="profile-container">
	<div class="user-header">
		<div class="user-header-profile-image-holder border rounded-circle border-white shadow">
			<img class="" src="{{ asset('images/fine-girl.jpg') }}"/>
		</div>
	</div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary position-relative profile-nav">
		<a class="navbar-brand" href="#">
			<ul class="user-names">
				<strong>Fanan Dala</strong>
				<i>The_fanan</i>
			</ul>
		</a>

		<ul class="navbar-nav mr-auto">
      <li class="nav-item active">
				<a class="nav-link">Posts</a>
      </li>
			@if($props["pageOwner"]->id == $props["currentUser"]->id)
			<li class="nav-item">
        	<a class="nav-link">Archive</a>
			</li>
			<li class="nav-item">
					<a class="nav-link">Trash</a>
			</li>
			@endif
    </ul>
	</nav>

	<div class="container">
		<div class="row justify-content-center user-main-posts">
			<div class="col-8">
				<ul class="list-group">
					<keep-alive>
							<component v-bind:is="currentTab" v-for="(index,post) in currentTabData" v-bind:key="index"></component>
					</keep-alive>
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection

@push('page-scripts')
<script type="text/javascript">
		Vue.component('posts-component', {
			props: ['post'],
			template: "<li class='list-group-item'>\
									<div class='row'>\
										<div class='col-8'>\
												<div class='row justify-content-start'>\
														<div class='col-2 col-lg-1 col-md-2 col-sm-2'>\
																<img src='{{ asset('images/avatar.png') }}' class='img-responsive rounded-circle border border-secondary very-small-circle'/>\
														</div>\
														<div class='col-10 col-lg-11 col-md-10 col-sm-10'>\
																<h4 clas='text-body'>The_fanan</h4>\
														</div>\
												</div>\
										</div>\
										<div class='col-4 justify-content-end d-flex'>\
												<p class='text-muted'>May 04</p>\
										</div>\
									</div>\
									<div class='row'>\
											<div class='col-lg-12'>\
													<p class='text-body'>My first Title</p>\
													<div class='image-cover rounded'>\
																	<img class='rounded img-responsive' src='{{ asset('images/orange-jelly.jpg') }}'/>\
													</div>\
											</div>\
									</div>\
								</li>"
		});
		
    const app = new Vue({
        delimiters: ['${', '}'],
        el: '.profile-container',
        data: {
            error: null,
            showFamilies: true,
            showNewPostButtons: false,
						posts: [1,2,3,4,5],
						archives: [],
						trashed: [],
						tabComponents: ['posts-component'],
						currentTab: "posts-component",
						currentTabData: [1,2,3,4,5],
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