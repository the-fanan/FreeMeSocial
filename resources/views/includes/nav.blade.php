<!-- NavBar -->
<nav class="navbar navbar-dark navbar-expand-lg navbar-expand-md  bg-dark shadow-sm navbar-fixed-top">
		<a class="navbar-brand" href="/"><span class="logo">FreeMe Social</span></a>
		
		<button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="navbar-toggler-icon"></span>
		</button>

		<div class="navbar-collapse collapse">
			<ul class="navbar-nav nav justify-content-end ml-auto">
				@guest
				<li class="nav-item"><a href="{{ route('login') }}">Login</a></li>
				<li class="nav-item"><a href="{{ route('register') }}">Register</a></li>
				@else
				<li><a href="{{ route('logout') }}" onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">Logout</a></li>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
				</form>
				@endguest
			</ul>
		</div>
</nav>