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


<!--- Submit Field --->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
