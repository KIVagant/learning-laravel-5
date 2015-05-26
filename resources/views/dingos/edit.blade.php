@extends('app')

@section('content')
<div class="container">

    @include('common.errors')

    {!! Form::model($dingo, ['route' => ['dingos.update', $dingo->id], 'method' => 'patch']) !!}

        @include('dingos.fields')

    {!! Form::close() !!}
</div>
@endsection
