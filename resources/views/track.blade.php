<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
    	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style type="text/css">
		.btn{
			border-radius: 0px;
			border:none;
		}
		.tracking-list{
			padding: 15px;
			border: solid rgb(150,150,150) 0.3px;
			margin-bottom: 15px;
		}
		.tracking-list:hover{
			background-color: rgba(150,200,150, 0.3);
		}
		.tracking-list img{
			width: 70%;
			margin-left: 15%;
			margin-top: 15%;
		}
	</style>
    </head>
    <body>
    	<div class="col-md-6 col-md-offset-3">
    		<h1>Tracking Log</h1>
    		@foreach($data as $d)
    		<?php
    		$ddetail = json_decode($d->detail);
    		?>
    		<div class="row tracking-list">
    			@if(isset($ddetail->ip))
    				<p><span>IP: </span>{{ $ddetail->ip }}</p>
    			@endif
    			@if(isset($ddetail->geoip->country))
    				<p><span>Country: </span>{{ $ddetail->geoip->country }}</p>
    			@endif
    			@if(isset($ddetail->geoip->region))
    				<p><span>region: </span>{{ $ddetail->geoip->region }}</p>
    			@endif
    			@if(isset($ddetail->geoip->city))
    				<p><span>city: </span>{{ $ddetail->geoip->city }}</p>
    			@endif
    			@if(isset($ddetail->geoip->ll))
    				<p><span>Lat Lng: </span>{{ $ddetail->geoip->ll[0] }}, {{ $ddetail->geoip->ll[1] }}</p>
    			@endif
    			@if(isset($ddetail->cookie))
    				<p><span>Cookie: </span>Yes</p>
    			@else
    				<p><span>Cookie: </span>No</p>
    			@endif
    			@if(isset($ddetail->headers->referer))
    				<p><span>Referer: </span>{{ $ddetail->headers->referer }}</p>
    			@endif
    			@if(isset($ddetail->who_is[3]))
	    			<?php 
	    			$person = (array) $ddetail->who_is[3];
	    			$person = $person['person'];
	    			?>
    				<p><span>Person: </span>{{ $person }}</p>
    			@endif
    			@if(isset($ddetail->who_is[3]))
	    			<?php 
	    			$person = (array) $ddetail->who_is[4];
	    			$person = isset($person['role']) ? $person['role'] : 'no';
	    			?>
    				<p><span>Role: </span>{{ $person }}</p>
    			@endif
    			@if(isset($ddetail->parameters->current_duration))
    				<p><span>Session duration: </span>{{ $ddetail->parameters->current_duration/1000 }} second</p>
    			@endif
    			@if(isset($ddetail->parameters->target))
    				<p><span>Target :</span>{{ $ddetail->parameters->target }}</p>
    			@endif
    			@if(isset($ddetail->ipinfo->org))
    				<p><span>ISP :</span>{{ $ddetail->ipinfo->org }}</p>
    			@endif
    		</div>
    		@endforeach
    	</div>
    	<!-- Latest compiled and minified JavaScript -->
    	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script type="text/javascript">
		var address = '';
		function jsonpCallback(data){
			window.location = address;
		}
		$(document).ready(function(){
			var host = 'localhost';
			var port = 3000;
			var currentUrl = encodeURIComponent(window.location.href);
			var timeStart = Date.now();
			var lastAction = Date.now();
			$('.click-redirector').click(function(event){
				event.preventDefault();
				if (address == ''){
					$(this).attr('disabled', 'disabled');
					$(this).text('tunggu...');
					var duration = Date.now() - timeStart;
					var targetUrl = $(this).attr('href');
					$.ajax({
						type: 'get',
						url: 
							'http://' + host + ':' + port + '/track?reference=' 
							+ currentUrl 
							+ '&session_start=' + timeStart 
							+ '&last_action=' + lastAction
							+ '&current_duration=' + duration
							+ '&target=' + targetUrl,
						dataType: 'jsonp',
					});
					address = $(this).attr('href');
					lastAction = Date.now();
				}
			})
		});
	</script>
    </body>
</html>