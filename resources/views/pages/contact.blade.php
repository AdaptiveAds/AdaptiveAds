@extends('default')

@section('content')

<form action="?" method="POST">
  <ul>
		<li>
			<label for="name">Name</label>
			<input type="name" name="name" placeholder="John Smith" required>
		</li>
		<li>
			<label for="subject">Subject</label>
			<input type="subject" name="subject" placeholder="OpenSource Advertising" required>
		</li>
    <li>
			<label for="message">Message</label>
			<text-area type="message" name="message" placeholder="Write your message here." required>
		</li>
	</ul>
  <div class="g-recaptcha" data-sitekey="your_site_key"></div>
  <br/>
  <button class="submit">Login</button>
</form>

@endsection
