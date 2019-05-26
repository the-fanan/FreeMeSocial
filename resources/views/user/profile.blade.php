@extends('layouts.master')

@section('content')
<div class="profile-container">
	<div class="user-header">
		<div class="user-header-profile-image-holder border rounded-circle border-white shadow">
			<img class="" src="{{ $props['pageOwner']->getProfileImage() }}"/>
		</div>
	</div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary position-relative profile-nav">
		<a class="navbar-brand" href="#">
			<ul class="user-names">
				<strong>{{ $props["pageOwner"]->name }}</strong>
				<i>{{ $props["pageOwner"]->username }}</i>
			</ul>
		</a>

		<ul class="navbar-nav mr-auto">
      <li class="nav-item active">
				<a class="nav-link" href="#" v-on:click.prevent="getPosts">Posts</a>
      </li>
			@if($props["pageOwner"]->id == $props["currentUser"]->id)
			<li class="nav-item">
        	<a class="nav-link" href="#" v-on:click.prevent="getArchive">Archive</a>
			</li>
			<li class="nav-item">
					<a class="nav-link" href="#" v-on:click.prevent="getTrash">Trash</a>
			</li>
			@endif
    </ul>
	</nav>

	<div class="container">
		<div class="row justify-content-center user-main-posts">
			<div class="col-8">
				<ul class="list-group">
							<component  v-bind:is="currentTab"></component>
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection

@push('page-scripts')
<script type="text/javascript">
		Vue.component('posts-component', {
			delimiters: ['${', '}'],
			data() {
				return {
					posts: [],
					baseMediaUrl: "{{ asset('/') }}",
					showLoadMore: true,
					loadMoreText: "Load More",
					alert: null,
					alertClass: "list-group-item-danger",
					currentUser: "{{ Auth::user()->id }}",
					pageOwner: "{{ $props['pageOwner']->id }}"
				}
			},
			props: [],
			mounted() {
				let vm = this;
				axios.post('/media/load',
                {
                    type: "posts",
										currentUser: vm.currentUser,
										pageOwner: vm.pageOwner
                }).then(function(response){
									vm.posts = _.uniqBy(response.data, 'post_id');
                }).catch(function(){
                    vm.alert = "An error Occured";
                    vm.alertClass= "list-group-item-danger";
                });
			},
			template: "<span>\
								<li class='list-group-item' :class='alertClass' v-show='alert' v-cloak>\
                 <strong>${ alert }</strong>\
                    <button type='button' v-on:click='alert = null' class='close' data-dismiss='alert' aria-label='Close'>\
                        <span aria-hidden='true'>&times;</span>\
                    </button>\
                </li>\
								<li class='list-group-item' v-for='(post,index) in posts' v-bind:key='post.post_id'>\
									<div class='row'>\
											<div class='col-8'>\
													<div class='row justify-content-start'>\
															<div class='col-2 col-lg-1 col-md-2 col-sm-2'>\
															<a :href=\"'user/' + post.poster_username\"><img :src='baseMediaUrl + post.profile_picture' class='img-responsive rounded-circle border border-secondary very-small-circle'/></a>\
															</div>\
															<div class='col-10 col-lg-11 col-md-10 col-sm-10'>\
																	<h4 clas='text-body'>${ post.poster_username }</h4>\
															</div>\
													</div>\
											</div>\
											<div class='col-4 justify-content-end d-flex'>\
									`    	<div class='dropdown' v-if='post.poster_id == currentUser'>\
													<button class='btn btn-light dropdown-toggle' type='button' :id=\"post.post_id + \'-post-settings\'\" data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>\
																&sdot; &sdot; &sdot;\
													</button>\
													<div class='dropdown-menu' :aria-labelledby=\"post.post_id + \'-post-settings\'\">\
															<a class='dropdown-item' href='#' v-on:click.prevent='archivePost(post.post_id,index)'>Archive</a>\
															<a class='dropdown-item' href='#' v-on:click.prevent='trashPost(post.post_id,index)'>Delete</a>\
															<div class='dropdown-divider'></div>\
															<h6 class='dropdown-header'>Restrictions</h6>\
															<div class='dropdown-divider'></div>\
															<a class='dropdown-item' href='#' v-on:click.prevent='restrictPublic(post.post_id)'>Public</a>\
															<a class='dropdown-item' href='#' v-on:click.prevent='restrictFriends(post.post_id)'>Friends</a>\
															<a class='dropdown-item' href='#' v-on:click.prevent='restrictFamily(post.post_id)'>Family</a>\
															<a class='dropdown-item' href='#' v-on:click.prevent='restrictFriendsAndFamily(post.post_id)'>Friends & Family</a>\
													</div>\
												</div>\
												<p class='text-muted date'>${ post.updated_at }</p>	\
											</div>\
                    </div>\
                    <div class='row'>\
											<div class='col-lg-12'>\
													<p class='text-body'>${ post.description }</p>\
													<div class='image-cover rounded'>\
														<img v-if=\"post.file_type == 'image'\" class='rounded img-responsive' :src='baseMediaUrl + post.file_url'/>\
														<video controls v-else>\
																<source :src='baseMediaUrl + post.file_url' type='video/mp4'>\
																Your browser does not support the video tag.\
														</video> \
													</div>\
											</div>\
                    </div>\
                	</li>\
								</span>",
								methods: {
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
													restriction: "public",
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
													restriction: "friends",
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
													restriction: "family",
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
													restriction: "friends-family",
													postId: postId
											}).then(function(){
													vm.alert = "Post visibility set to Friends And Family.";
													vm.alertClass= "list-group-item-info";
											}).catch(function(){
													vm.alert = "An error Occured";
													vm.alertClass= "list-group-item-danger";
											});
											
									}
								}
		});

		Vue.component('archive-component', {
			delimiters: ['${', '}'],
			data() {
				return {
					posts: [],
					baseMediaUrl: "{{ asset('/') }}",
					showLoadMore: true,
					loadMoreText: "Load More",
					alert: null,
					alertClass: "list-group-item-danger",
					currentUser: "{{ Auth::user()->id }}",
					pageOwner: "{{ $props['pageOwner']->id }}"
				}
			},
			props: [],
			mounted() {
				let vm = this;
				axios.post('/media/load',
                {
                    type: "archive",
										currentUser: vm.currentUser,
										pageOwner: vm.pageOwner
                }).then(function(response){
									vm.posts = _.uniqBy(response.data, 'post_id');
                }).catch(function(){
                    vm.alert = "An error Occured";
                    vm.alertClass= "list-group-item-danger";
                });
			},
			template: "<span>\
								<li class='list-group-item' :class='alertClass' v-show='alert' v-cloak>\
                 <strong>${ alert }</strong>\
                    <button type='button' v-on:click='alert = null' class='close' data-dismiss='alert' aria-label='Close'>\
                        <span aria-hidden='true'>&times;</span>\
                    </button>\
                </li>\
								<li class='list-group-item' v-for='(post,index) in posts' v-bind:key='post.post_id'>\
									<div class='row'>\
											<div class='col-8'>\
													<div class='row justify-content-start'>\
															<div class='col-2 col-lg-1 col-md-2 col-sm-2'>\
															<a :href=\"'user/' + post.poster_username\"><img :src='baseMediaUrl + post.profile_picture' class='img-responsive rounded-circle border border-secondary very-small-circle'/>\
															</a>\
															</div>\
															<div class='col-10 col-lg-11 col-md-10 col-sm-10'>\
																	<h4 clas='text-body'>${ post.poster_username }</h4>\
															</div>\
													</div>\
											</div>\
											<div class='col-4 justify-content-end d-flex'>\
									`    	<div class='dropdown' v-if='post.poster_id == currentUser'>\
													<button class='btn btn-light dropdown-toggle' type='button' :id=\"post.post_id + \'-post-settings\'\" data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>\
																&sdot; &sdot; &sdot;\
													</button>\
													<div class='dropdown-menu' :aria-labelledby=\"post.post_id + \'-post-settings\'\">\
															<a class='dropdown-item' href='#' v-on:click.prevent='unArchivePost(post.post_id,index)'>Unarchive</a>\
															<a class='dropdown-item' href='#' v-on:click.prevent='trashPost(post.post_id,index)'>Delete</a>\
													</div>\
												</div>\
												<p class='text-muted date'>${ post.updated_at }</p>	\
											</div>\
                    </div>\
                    <div class='row'>\
											<div class='col-lg-12'>\
													<p class='text-body'>${ post.description }</p>\
													<div class='image-cover rounded'>\
														<img v-if=\"post.file_type == 'image'\" class='rounded img-responsive' :src='baseMediaUrl + post.file_url'/>\
														<video controls v-else>\
																<source :src='baseMediaUrl + post.file_url' type='video/mp4'>\
																Your browser does not support the video tag.\
														</video> \
													</div>\
											</div>\
                    </div>\
                	</li>\
								</span>",
								methods: {
									unArchivePost: function(postId,index) {
											let vm = this;
											axios.post('/media/unarchive',
											{
													postId: postId
											}).then(function(){
													vm.posts.splice(index, 1);
													vm.alert = "Post unarchived successfully";
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
									}
								}
		});
		
		Vue.component('trash-component', {
			delimiters: ['${', '}'],
			data() {
				return {
					posts: [],
					baseMediaUrl: "{{ asset('/') }}",
					showLoadMore: true,
					loadMoreText: "Load More",
					alert: null,
					alertClass: "list-group-item-danger",
					currentUser: "{{ Auth::user()->id }}",
					pageOwner: "{{ $props['pageOwner']->id }}"
				}
			},
			props: [],
			mounted() {
				let vm = this;
				axios.post('/media/load',
                {
                    type: "trash",
										currentUser: vm.currentUser,
										pageOwner: vm.pageOwner
                }).then(function(response){
									vm.posts = _.uniqBy(response.data, 'post_id');
                }).catch(function(){
                    vm.alert = "An error Occured";
                    vm.alertClass= "list-group-item-danger";
                });
			},
			template: "<span>\
								<li class='list-group-item' :class='alertClass' v-show='alert' v-cloak>\
                 <strong>${ alert }</strong>\
                    <button type='button' v-on:click='alert = null' class='close' data-dismiss='alert' aria-label='Close'>\
                        <span aria-hidden='true'>&times;</span>\
                    </button>\
                </li>\
								<li class='list-group-item' v-for='(post,index) in posts' v-bind:key='post.post_id'>\
									<div class='row'>\
											<div class='col-8'>\
													<div class='row justify-content-start'>\
															<div class='col-2 col-lg-1 col-md-2 col-sm-2'>\
															<a :href=\"'user/' + post.poster_username\"><img :src='baseMediaUrl + post.profile_picture' class='img-responsive rounded-circle border border-secondary very-small-circle'/></a>\
															</div>\
															<div class='col-10 col-lg-11 col-md-10 col-sm-10'>\
																	<h4 clas='text-body'>${ post.poster_username }</h4>\
															</div>\
													</div>\
											</div>\
											<div class='col-4 justify-content-end d-flex'>\
									`    	<div class='dropdown' v-if='post.poster_id == currentUser'>\
													<button class='btn btn-light dropdown-toggle' type='button' :id=\"post.post_id + \'-post-settings\'\" data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>\
																&sdot; &sdot; &sdot;\
													</button>\
													<div class='dropdown-menu' :aria-labelledby=\"post.post_id + \'-post-settings\'\">\
															<a class='dropdown-item' href='#' v-on:click.prevent='unTrashPost(post.post_id,index)'>Untrash</a>\
													</div>\
												</div>\
												<p class='text-muted date'>${ post.updated_at }</p>	\
											</div>\
                    </div>\
                    <div class='row'>\
											<div class='col-lg-12'>\
													<p class='text-body'>${ post.description }</p>\
													<div class='image-cover rounded'>\
														<img v-if=\"post.file_type == 'image'\" class='rounded img-responsive' :src='baseMediaUrl + post.file_url'/>\
														<video controls v-else>\
																<source :src='baseMediaUrl + post.file_url' type='video/mp4'>\
																Your browser does not support the video tag.\
														</video> \
													</div>\
											</div>\
                    </div>\
                	</li>\
								</span>",
								methods: {
									unTrashPost: function(postId,index) {
											let vm = this;
											axios.post('/media/untrash',
											{
													postId: postId
											}).then(function(){
													vm.posts.splice(index, 1);
													vm.alert = "Post Untrashed!";
													vm.alertClass= "list-group-item-success"
											}).catch(function(){
													vm.alert = "An error Occured";
													vm.alertClass= "list-group-item-danger";
											}); 
									}
								}
		});
    const app = new Vue({
        delimiters: ['${', '}'],
        el: '.profile-container',
        data: {
            error: null,
            showFamilies: true,
            showNewPostButtons: false,
						currentTab: "posts-component",
						currentUser: "{{ $props['currentUser']->id }}",
						pageOwner: "{{ $props['pageOwner']->id }}"
        },
        created() {
            if (window.innerWidth < 577) {
                this.showFamilies = false;
            }
        },
        updated() {
            
            
        },
        methods: {
					getPosts: function () {
						//change current tab
						this.currentTab = "posts-component"
					},
					getArchive: function () {
						//change current tab
						this.currentTab = "archive-component"
					},
					getTrash: function () {
						//change current tab
						this.currentTab = "trash-component"
					}
				}
    });
</script>
@endpush