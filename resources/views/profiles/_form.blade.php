<div class="form-group{{ $errors->has('no') ? ' has-error' : '' }}">
	{!! Form::label('No', 'NIP', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-8">
	{!! Form::text('no', null, ['class'=>'form-control']) !!}
	{!! $errors->first('no', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group{{ $errors->has('initial') ? ' has-error' : '' }}">
	{!! Form::label('initial', 'Initial', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-8">
	{!! Form::text('initial', null, ['class'=>'form-control']) !!}
	{!! $errors->first('initial', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!! Form::label('prefix', 'Name', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-2">
	{!! Form::text('prefix', null, ['class'=>'form-control','placeholder'=>'Dr']) !!}
	{!! $errors->first('prefix', '<p class="help-block">:message</p>') !!}
	</div>

	<div class="col-md-4">
	{!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Fullname']) !!}
	{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
	</div>

	<div class="col-md-2">
	{!! Form::text('suffix', null, ['class'=>'form-control','placeholder'=>'Ph.d.']) !!}
	{!! $errors->first('suffix', '<p class="help-block">:message</p>') !!}
	</div>

</div>

<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
	{!! Form::label('phone', 'Phone', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-8">
	{!! Form::number('phone', null, ['class'=>'form-control']) !!}
	{!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group{{ $errors->has('birthplace') || $errors->has('birthdate') ? ' has-error' : '' }}">
	{!! Form::label('birthplace', 'Birthdate', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-4">
	{!! Form::text('birthplace', null, ['class'=>'form-control']) !!}
	{!! $errors->first('birthplace', '<p class="help-block">:message</p>') !!}
	</div>

	<div class="col-md-4">
    <div class='input-group date' id='date'>
		{!! Form::text('birthdate', null, ['class'=>'form-control']) !!}
	    <span class="input-group-addon">
	        <span class="glyphicon glyphicon-calendar"></span>
	    </span>
	</div>
	{!! $errors->first('birthdate', '<p class="help-block">:message</p>') !!}
	</div>

</div>

<div class="form-group">
	<div class="col-md-8 col-md-offset-2" style="text-align: right">
	{!! Form::submit('Simpan', ['class'=>'form-control btn-primary']) !!}
	</div>
</div>
