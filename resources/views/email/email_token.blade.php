<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
	<h2>Welcome to the site Dear {{$user->name}}</h2>
	<br/>
	Your registered email-id is {{$user->email}} 
	<br/>
	Please click on the below link to verify your email account
	<br/>
	<a href="{{url('auth/verify', $user->emailtoken->token)}}">Verify Email</a>
</body>

</html>