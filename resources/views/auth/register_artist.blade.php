<h2>Register Artist</h2>

@if(session('success'))
	<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

<form method="POST" action="{{ route('register.artist') }}">
@csrf
<input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
<input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
<input type="password" name="password" placeholder="Password">
<input type="password" name="password_confirmation" placeholder="Confirm Password">
<button>Register</button>
</form>
