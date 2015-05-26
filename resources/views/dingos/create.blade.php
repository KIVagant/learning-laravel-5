@extends('app')

@section('content')
<div class="container">

    @include('common.errors')

    {!! Form::open(['route' => 'dingos.store']) !!}

        @include('dingos.fields')

    {!! Form::close() !!}
</div>
@endsection
