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
		.product-list{
			padding: 15px;
			border: solid rgb(150,150,150) 0.3px;
			margin-bottom: 15px;
		}
		.product-list:hover{
			background-color: rgba(150,200,150, 0.3);
		}
		.product-list img{
			width: 70%;
			margin-left: 15%;
			margin-top: 15%;
		}
	</style>
    </head>
    <body>
    	<div class="col-md-6 col-md-offset-3">
    		<h1>Product List</h1>
    		@foreach($data['products'] as $product)
    		<?php
    		$detail = json_decode($product->detail);
    		?>
    		<div class="row product-list">
    			<div class="col-md-2">
    				<img src="{{ $detail->image }}">
    			</div>
    			<div class="col-md-10">
    				<h2>{{ $detail->name }}</h2>
    				<div class="row">
    					<div class="col-md-9">
    						{{ $detail->description }}
    					</div>
    					<div class="col-md-3">
    						{{ $product->created_at }}
    					</div>
    				</div>
    				<div class="row">
    					<a class="btn btn-primary col-md-3 click-redirector" href="{{ url('product/'.$product->id) }}">Detail</a>
    					<button class="btn btn-primary col-md-4 col-md-offset-1">Compare</button>
    					<button class="btn btn-primary col-md-3 col-md-offset-1">Add to whislist</button>
    				</div>
    			</div>
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