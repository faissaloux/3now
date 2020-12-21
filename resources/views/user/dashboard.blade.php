@extends('user.layout.base')
@section('title', 'Dashboard ')
@section('styles')
<link rel="stylesheet" href="{{asset('asset/admin/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection
@section('content')
<div class="content-area py-1">

<div class="container-fluid">

    <div class="row row-md">

        <div class="col-lg-4 col-md-6 col-xs-12">

            <div class="box box-block bg-success mb-2">

                <div class="t-content">

                    <h4 class="text-uppercase mb-1">GESAMTFAHRT</h4>

                    <h1 class="mb-1">{{$rides->count()}}</h1>

                </div>

            </div>

        </div>

        <div class="col-lg-4 col-md-6 col-xs-12">

            <div class="box box-block bg-primary mb-2">

                <div class="t-content">

                    <h4 class="text-uppercase mb-1">FAHRT ABBRECHEN</h4>

                    <h1 class="mb-1">{{$cancel_rides}}</h1>

                </div>

            </div>

        </div>

        <div class="col-lg-4 col-md-6 col-xs-12">

            <div class="box box-block bg-warning mb-2">

                <div class="t-content">

                    <h4 class="text-uppercase mb-1">ZEITPLANFAHRT</h4>

                    <h1 class="mb-1">{{$scheduled_rides}}</h1>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 col-xs-12">
        </div>

    </div>

</div>

</div>



@endsection