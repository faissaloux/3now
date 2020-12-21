@extends('admin.layout.base')



@section('title', 'Add  New')



@section('content')

<div class="content-area py-1">

    <div class="container-fluid">

        <div class="box box-block bg-white">

            <!-- <a href="{{ route('admin.blog.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>Back</a> -->



            <h5 style="margin-bottom: 2em;"><i class="ti-layout-media-left-alt"></i>&nbsp;Add New Blog</h5><hr>



            <form class="form-horizontal" action="{{route('admin.blog.store')}}" method="POST" enctype="multipart/form-data" role="form">

                {{ csrf_field() }}

                <div class="form-group row">

                    <label for="name" class="col-xs-12 col-form-label">Post Name</label>

                    <div class="col-xs-10">

                        <input class="form-control" type="text" value="{{ old('title') }}" name="title" required id="title" placeholder="title">

                    </div>

                </div>



                <div class="form-group row">

                    <label for="picture" class="col-xs-12 col-form-label">Post Image</label>

                    <div class="col-xs-10">

                        <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">

                    </div>

                </div>



         

                <div class="form-group row">

                    <label for="description" class="col-xs-12 col-form-label">Beschreibung</label>

                    <div class="col-xs-10">

                        <textarea class="form-control" id="myeditor"  type="number"  name="description" required  placeholder="Description" rows="4">{{ old('description') }}</textarea>

                    </div>

                </div>



                <div class="form-group row">

                    <div class="col-xs-10">

                        <div class="row">

                            <div class="col-xs-12 col-sm-6 col-md-3">

                                <a href="{{ route('admin.blog.index') }}" class="btn btn-danger btn-block">Stornieren</a>

                            </div>

                            <div class="col-xs-12 col-sm-6 offset-md-6 col-md-3">

                                <button type="submit" class="btn btn-primary btn-block">speichern</button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection



@section('scripts')

<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<script type="text/javascript">

    CKEDITOR.replace('myeditor');

</script>

@endsection



