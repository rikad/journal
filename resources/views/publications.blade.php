@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
          <div class="panel-body" style="text-align: left">
            <h4><span class="glyphicon glyphicon-star"></span> Data Riset & Publikasi {{ $year }}</h4>
            <hr>
            <table class="table table-hover table-striped">

              @foreach( $data as $publication)
              @php
                if($publication['authors'] == '') {
                  $authors = $publication['users'];
                }
                else {
                  $authors = array_merge($publication['users'],json_decode($publication['authors'])->data);
                  $authors[count($authors) - 1] = 'and '.$authors[count($authors) - 1];
                }

                $authors = implode(', ',$authors);

                $tmp = $authors.', '.e($publication['title']).', '.e($publication['description']);
              @endphp
              <tr><td>{{ $loop->iteration }}. </td><td>{!! $tmp !!}</td></tr>
              @endforeach
            </table>


          </div>
      </div>
    </div>

    <hr>
    <div class="row">
      <div class="col-md-12 footer">
        &copy; 2018 CV Dosen FTI
        <br>Fakultas Teknologi Industri - Institut Teknologi Bandung
        <br>Contact For Report & Bugs : rikadfauzi@gmail.com
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
  .footer {
    text-align: center;
  }

  .table {
    cursor: pointer;
  }
</style>

@endsection
