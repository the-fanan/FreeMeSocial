@extends('layouts.master')

@section('content')
<div class="container home-container">
	<div class="row justify-content-center">
		
			@foreach(\App\User::all() as $user)
			<div class="col-12 col-lg-3 col-md-3 col-sm-3 user-main rounded border">
				<div class="image-holder">
					<img class="rounded" src="{{ asset($user->profile_picture) }}"/>
				</div>
				<div class="medium-info">
					<p class="text-body name">
							{{ $user->name }}
					</p>
					<p>
							{{ $user->username }}
					</p>
					<div class="button-holder d-flex justify-content-between">
						<a href="{{ url('user/' . $user->username) }}" class="btn btn-info">Visit Profile</a>
					</div>
				</div>
			</div>
			@endforeach
		
	</div>
</div>
@endsection

@push('page-scripts')
@endpush