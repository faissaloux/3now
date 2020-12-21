@extends('admin.layout.base')

@section('title', 'Blog')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1"><i class="ti-layout-media-left-alt"></i>&nbsp;Blog Post</h5><hr>
            <a href="{{ route('admin.blog.create') }}" style="margin-left: 1em;" class="btn shadow-box btn-rounded btn-success pull-right"><i class="fa fa-plus"></i>Neue hinzufügen</a>
            <a href="{{ url('/blogs') }}" style="margin-left: 1em;" class="btn shadow-box btn-rounded btn-success pull-right" target="_blank"><i class="fa fa-plus"></i>View Blog</a>
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th style="width: 300px;">Post Title</th>
                        
                        <th style="width: 800px;">Beschreibung</th>
                       
                        <th> Post Image</th>
                        <th >Aktion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($blog as $index => $service)
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
                            <form action="{{ route('admin.blog.destroy', $service->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                               <a href="{{ route('admin.blog.edit', $service->id) }}" class="btn btn-success shadow-box">
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