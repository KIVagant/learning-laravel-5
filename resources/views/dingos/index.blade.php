@extends('app')

@section('content')

    <div class="container">

        @include('flash::message')

        <div class="row">
            <h1 class="pull-left">Dingos</h1>
            <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('dingos.create') !!}">Add New</a>
        </div>

        <div class="row">
            @if($dingos->isEmpty())
                <div class="well text-center">No Dingos found.</div>
            @else
                <table class="table">
                    <thead>
                    <th>Title</th>
			<th>Body</th>
                    <th width="50px">Action</th>
                    </thead>
                    <tbody>
                     <tr>
    {!! Form::open(['route' => 'dingos.index', 'method' => 'get', 'class' => 'form-inline', 'id' => 'search_form']) !!}

        

<!--- Title Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>



<!--- Body Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('body', 'Body:') !!}
    {!! Form::text('body', null, ['class' => 'form-control']) !!}
</div>



        <td>
            <span onclick="return $('#search_form').submit()" class="btn btn-xs btn-primary">
                <i class="glyphicon glyphicon-search"></i>
            </span>
        </td>

    {!! Form::close() !!}
</tr>
                    @foreach($dingos as $dingo)
                        <tr>
                            <td>{!! $dingo->title !!}</td>
					<td>{!! $dingo->body !!}</td>
                            <td>
                                <a href="{!! route('dingos.edit', [$dingo->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="{!! route('dingos.delete', [$dingo->id]) !!}" onclick="return confirm('Are you sure wants to delete this Dingo?')"><i class="glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection