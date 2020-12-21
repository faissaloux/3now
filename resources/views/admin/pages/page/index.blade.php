@extends('admin.layout.base')



@section('title', 'Page')



@section('content')

<div class="content-area py-1">

    <div class="container-fluid">

        <div class="box box-block bg-white">

            <h5 class="mb-1"><i class="ti-layout-media-left-alt"></i>&nbsp;Page</h5><hr>

            <a href="{{ route('admin.page.create') }}" style="margin-left: 1em;" class="btn shadow-box btn-success btn-rounded pull-right"><i class="fa fa-plus"></i>Add New</a>

            

            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th style="width: 300px;">Page Title</th>

                        

                        <th style="width: 800px;">Description</th>

                       

                        <th> Page Image</th>

                        <th >Action</th>

                    </tr>

                </thead>

                <tbody>

                @foreach($page as $index => $service)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>{{ $service->title }}</td>

                        <td>{!! str_limit($service->description, 200) !!}</td>

                       

                        <td>

                            @if($service->image) 

                                <img src="{{$service->image}}" style="height: 50px" >

                            @else

                                N/A

                            @endif

                        </td>

                        <td style="width: 100px">

                            <form action="{{ route('admin.page.destroy', $service->id) }}" method="POST">

                                {{ csrf_field() }}

                                {{ method_field('DELETE') }}

                                <a href="{{ route('admin.page.edit', $service->id) }}" class="btn shadow-box btn-success">

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