<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ trans('lingos::email.password_reset') }}</h2>

		<div>
			{{ trans('lingos::email.reset_password_form') }}: {{ URL::to('password/reset', array($token)) }}.
		</div>
	</body>
</html>