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
					{!! Form::model($data, ['class'=>'form-horizontal']) !!}
					<div class="row">
						<div class="col-md-4" style="text-align: center">
							<img class="img-responsive img-circle" src="https://www.w3schools.com/w3images/fjords.jpg" alt="foto">
							<hr>
							<button class="btn btn-primary btn-sm">Change Image</button>
						</div>
						<div class="col-md-8">
							@include('profiles._form')
						</div>
					</div>
					{!! Form::close() !!}


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
