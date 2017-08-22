<!DOCTYPE html>
<html>
<head>
	<title>H10 - Ocean Maya Royale</title>
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicon.ico') }}">
</head>
<body>
	<form id="loginform" name="loginform" method="POST" action="http://{{ $form_sip  = session('sip') }}:9997/login">
		{{ csrf_field() }}
		<input class="form-control" type="hidden" id="username" name="username" value="GUESTOMR" />
		<input class="form-control" type="hidden" id="password" name="password" value="123" />
		<input class="form-control" type="hidden" id="sip" name="sip" value="{{ $form_sip }}" />
		<input class="form-control" type="hidden" id="mac" name="mac" value="{{ $form_mac  = session('mac') }}" />
		<input class="form-control" type="hidden" id="client_mac" name="client_mac" value="{{ $form_client_mac = session('client_mac') }}" />
		<input class="form-control" type="hidden" id="uip" name="uip" value="{{ $form_uip  = session('uip') }}" />
		<input class="form-control" type="hidden" id="ssid" name="ssid" value="{{ $form_ssid  = session('ssid') }}" />
		<input class="form-control" type="hidden" id="vlan" name="vlan" value="{{ $form_vlan  = session('vlan') }}" />

	</form>
</body>
@include('layouts.partials.scripts')
<script>
	$(function() {
		setTimeout(function(){
			$('#loginform').submit();
		}, 2000);
	});
</script>
</html>