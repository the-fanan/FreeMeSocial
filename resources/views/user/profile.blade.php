@extends('layouts.master')

@section('content')
<div class="profile-container">
	<div class="user-header">
		<div class="user-header-profile-image-holder border rounded-circle border-white shadow">
			<img class="" src="{{ asset('images/fine-girl.jpg') }}"/>
		</div>
	</div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary position-relative"">
		<a class="navbar-brand" href="#">
			<ul class="user-names">
				<strong>Fanan Dala</strong>
				<i>The_fanan</i>
			</ul>
		</a>

		<ul class="navbar-nav mr-auto">
      <li class="nav-item active">
				<router-link :to="{ name: 'posts' }" class="nav-link">Posts</router-link>
      </li>
			@if($props["pageOwner"]->id == $props["currentUser"]->id)
			<li class="nav-item">
        	<router-link :to="{ name: 'archive' }" class="nav-link">Archive</router-link>
			</li>
			<li class="nav-item">
					<router-link :to="{ name: 'posts' }" class="nav-link">Archive</router-link>
			</li>
			@endif
    </ul>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<ul class="list-group">
						<router-view></router-view>
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection

@push('page-scripts')
<script type="text/javascript">
		Vue.use(VueRouter);
		const router = new VueRouter({
				mode: 'history',
				routes: [
						{
								path: '/',
								name: 'posts',
								component: PostsComponent
						},
						{
								path: '/posts',
								name: 'posts',
								component: PostsComponent
						},
						{
								path: '/archive',
								name: 'archive',
								component: ArchiveComponent
						},
						{
								path: '/trash',
								name: 'trash',
								component: TrashComponent
						},		
				],
		});
    const app = new Vue({
        delimiters: ['${', '}'],
        el: '.profle-container',
        data: {
            error: null,
            showFamilies: true,
            showNewPostButtons: false,
						posts: [],
						archives: [],
						trashed: [],

        },
        created() {
            if (window.innerWidth < 577) {
                this.showFamilies = false;
            }
        },
        updated() {
            
            
        },
        methods: {
            
				},
				router,
    });
</script>
@endpush