@extends('layouts.app')

@section('content')
<div class="container">
			<ul class="breadcrumb">
				<li><a href="{{ url('/home') }}">Dashboard</a></li>
				<li>Settings</li>
				<li class="active">Personal Information</li>
			</ul>
	<div class="row">
		<div class="col-md-2">
			@include('layouts._sidebar')
		</div>
		<div class="col-md-10">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Update Personal Information</h2>
				</div>
				<div class="panel-body">
					{!! Form::model($data, ['class'=>'form-horizontal','files' => true]) !!}
					<div class="row">
						<div class="col-md-4" style="text-align: center">
							<img class="img-responsive" src="{{ $data['foto'] }}" width="200" alt="foto">
							<hr>
							<div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
								<div class="col-md-8">
								{!! Form::file('file', null, ['class'=>'form-control']) !!}
								{!! $errors->first('file', '<p class="help-block">:message</p>') !!}
								</div>
							</div>
						</div>
						<div class="col-md-8">
							@include('profiles._form')
						</div>

					</div>

					<div class="row">
						<hr>
						<h4 align="center">Ubah Data Login</h4>
						<br>
						{!! Form::model($data, ['class'=>'form-horizontal','files' => true]) !!}
						<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
							{!! Form::label('username', 'username', ['class'=>'col-md-2 control-label']) !!}
							<div class="col-md-8">
							{!! Form::text('username', null, ['class'=>'form-control']) !!}
							{!! $errors->first('username', '<p class="help-block">:message</p>') !!}
							</div>
						</div>
						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							{!! Form::label('email', 'email', ['class'=>'col-md-2 control-label']) !!}
							<div class="col-md-8">
							{!! Form::email('email', null, ['class'=>'form-control']) !!}
							{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
							</div>
						</div>
						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							{!! Form::label('password', 'password', ['class'=>'col-md-2 control-label']) !!}
							<div class="col-md-8">
								<input class="form-control"  onfocus="if (this.hasAttribute('readonly')) {this.removeAttribute('readonly');this.blur();this.focus();  }" readonly name="password" type="password" id="password" placeholder="leave blank for not change" autocomplete="off">
							{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-2" style="text-align: right">
							{!! Form::submit('Simpan', ['class'=>'form-control btn-primary']) !!}
							</div>
						</div>

					</div>
					{!! Form::close() !!}

					<hr>
					<ul class="pager">
					  <li class="previous"><a href="#">&larr; Previous</a></li>
					  <li class="next"><a href="#">Next &rarr;</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('css')
	<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/js/moment.min.js"></script>
  <script src="/js/bootstrap-datetimepicker.min.js"></script>

  <script>
  	var activeSidebar = 0;
    $('#date').datetimepicker({ format: 'Y-M-D' });
  </script>

	@include('layouts._sidebarJS')

@endsection
