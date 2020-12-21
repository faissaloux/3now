@extends('admin.layout.base')

@section('title', 'Help ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 style="margin-bottom: 2em;">Help</h5>

            <div className="row">
                <form action="{{ url('/admin/help') }}" method="POST">
                    {{ csrf_field() }}
                  
                    <div class="row">
                        <div class="col-xs-12">
                            <textarea name="description" id="description"></textarea>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <label class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <!--a href="{{route('admin.index')}}" class="btn btn-default">Cancel</a-->
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box box-block bg-white">
            <div class="row no-margin ride-detail">
               <div class="col-md-12"> 
                @if($helps->count() > 0)

                    <table class="table table-condensed" style="border-collapse:collapse;">

                        <thead>
                            <tr>
                                <th class="col-md-6"><h5>Helps</h5></th>
                                <th class="col-md-6"><h5>&nbsp;</h5></th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($helps as $help)

                            <tr data-toggle="collapse" data-target="#help_{{$help->help_id}}" class="accordion-toggle collapsed">
                                <td class="col-md-11">{{ strip_tags($help->description) }}</td>
            
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                    @else
                        <hr>
                        <p style="text-align: center;">No Helps Available</p>
                    @endif
                </div>
            </div>
        </div>    

    </div>
</div>
@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('description');
</script>
@endsection
