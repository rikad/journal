@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="panel panel-default">
          <div class="panel-heading">Dosen</div>
          <div class="panel-body" style="text-align: center">
            <img class=".img-responsive" width="50%" height="100%" src="image/itb.jpg"/>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading">Journal And Publications</div>
          <div class="panel-body" style="text-align: center">
            <img class=".img-responsive" width="50%" height="100%" src="image/itb.jpg"/>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('css')

<style>
  .panel-heading {
    font-size: 24px;
    text-align: center;
  }
</style>

@endsection
