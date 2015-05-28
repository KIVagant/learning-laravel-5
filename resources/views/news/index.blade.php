@extends('app')

@section('content')

    <div class="container">

        @include('flash::message')

        <div class="row">
            <h1 class="pull-left">News</h1>
            <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('news.create') !!}">Add New</a>
        </div>

        <div class="row">
            @if($news->isEmpty())
                <div class="well text-center">No News found.</div>
            @else
                <table class="table">
                    <thead>
                    <th>Title</th>
			<th>Preview</th>
			<th>Body</th>
			<th>Author</th>
                    <th width="50px">Action</th>
                    </thead>
                    <tbody>
                     <tr>
    {!! Form::open(['route' => 'news.index', 'method' => 'get', 'class' => 'form-inline', 'id' => 'search_form']) !!}

        

<!--- Title Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>



<!--- Preview Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('preview', 'Preview:') !!}
    {!! Form::text('preview', null, ['class' => 'form-control']) !!}
</div>



<!--- Body Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('body', 'Body:') !!}
    {!! Form::text('body', null, ['class' => 'form-control']) !!}
</div>



<!--- Author Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('author', 'Author:') !!}
    {!! Form::text('author', null, ['class' => 'form-control']) !!}
</div>



        <td>
            <span onclick="return $('#search_form').submit()" class="btn btn-xs btn-primary">
                <i class="glyphicon glyphicon-search"></i>
            </span>
        </td>

    {!! Form::close() !!}
</tr>
                    @foreach($news as $news)
                        <tr>
                            <td>{!! $news->title !!}</td>
					<td>{!! $news->preview !!}</td>
					<td>{!! $news->body !!}</td>
					<td>{!! $news->author !!}</td>
                            <td>
                                <a href="{!! route('news.edit', [$news->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="{!! route('news.delete', [$news->id]) !!}" onclick="return confirm('Are you sure wants to delete this News?')"><i class="glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection