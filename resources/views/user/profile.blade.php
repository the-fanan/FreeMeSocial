@extends('layouts.master')

@section('content')
<div class="profile-container">
	<div class="user-header">

	</div>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">
			<ul>
				<strong>Fanan Dala</strong>
				<i>The_fanan</i>
			</ul>
		</a>
	</nav>
</div>
@endsection

@push('page-scripts')
<script type="text/javascript">
    const app = new Vue({
        delimiters: ['${', '}'],
        el: '.profle-container',
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