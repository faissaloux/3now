<?php
use App\Zones;
use App\ServiceType;
?>
@extends('admin.layout.base')

@section('title', 'Service Types ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1"><i class="ti-layout-media-overlay-alt-2"></i>&nbsp;Kartiertes Fahrzeug</h5><hr>
            <a href="{{ url('admin/allocation') }}" style="margin-left: 1em;" class="btn shadow-box btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Neue Karte hinzufügen</a>
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width: 100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <!-- <th>Category</th> -->
                        <th>Tarifplan</th>
                        <th>Fahrzeugliste</th>
                        <th>Zone</th>                        
                        <th>Status</th>                     
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody>                    
                @foreach($data as $index => $service)
			        <?php $zonename=Zones::select('*')->where('id' ,$service->zone_id)->first(); ?>
                    <?php //$zonename=ServiceType::select('*')->where('id' ,$service->category)->first(); ?>
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <!-- <td>{{ $service->category }}</td> -->
                        <td><a id="fareSetting">{{ $service->plan_name }}</a></td>
                        <td>{{ $service->service_name }}</td>
                        <td>{{ $zonename['zone_name']}}</td>
                        <td>Active</td>
                        <td>
                            <form action="{{ route('admin.fare.settings.deletePKG') }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="hidden" value="{{$service->id}}" name="id" />
                                <a href="{{ url('admin/cabAllocation_edit', $service->id) }}" class="btn btn-success shadow-box">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button class="btn btn-danger shadow-box" onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    
                    
    
                @endforeach
                </tbody>
               
            </table>
        </div>
    </div>
</div>
@endsection