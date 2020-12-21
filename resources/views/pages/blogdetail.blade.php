@extends('website.app')

@section('content')
<div class="blog" style="margin-top:20px">
	<div class="blog_box">
		<div class="container">
			<div class="row">
				<div class="col-md-12"> 
					<h2>{{ $blog_detail->title }}</h2>
					<h6>{{ $blog_detail->created_at }}</h6>
					<img src="{{ $blog_detail->image }}" class="img-responsive" />
					&nbsp;&nbsp;
					{!! $blog_detail->description !!}
				</div>
				<a href="{{ url('/blogs') }}" style="float: right; font-size: 16px; margin: 15px;"> Go Back -> </a>
			</div>
		</div>
	</div>
</div>
@endsection