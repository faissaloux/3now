@extends('website.app')

@section('content')
<div class="signup">
	<div class="signup_box">
		<h3 style="font-size: 32px;margin: 21px 0 0 21px;color:black;">{{ucwords($data->title)}}</h3>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div>
                     {{$data->description}}
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
   
@endsection