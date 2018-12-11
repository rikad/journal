@php
//publications
$publications = App\Publication::select('publications.*')
            ->orderBy('id','desc')
            ->limit(10)
            ->get();

$year = App\Publication::selectRaw('YEAR(published) as year, count(id) as total')
            ->groupBy(\DB::raw('YEAR(published)'))
            ->get();

$data = [];
foreach ($publications as $value) {
    $relation = DB::table('publication_user')->select('users.name','users.email','profiles.name as fullname')
                ->join('users','users.id','publication_user.user_id')
                ->leftJoin('profiles','users.id','profiles.user_id')
                ->where('publication_id',$value->id)->get();
    $users = [];
    foreach ($relation as $k => $v) {
      if ($v->fullname) {
        $users[] = $v->fullname;
      } else {
        $users[] = $v->name;
      }
    }

    $data[] = ['id'=>$value->id,'title'=>$value->title,'authors'=>$value->authors,'description'=>$value->description,'file'=>$value->file,'published'=>$value->published,'users'=>$users ];
}
//end publications
@endphp

@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-2">
        <div class="panel-body" style="text-align:center">
          <div style="text-align:center">
            <img class=".img-responsive" width="50%" src="image/itb.jpg"/>
            <h4>Arsip <br>Riset & Publikasi</h4>
          </div>
          <hr>
          @foreach($year as $y)
          <a href="{{ url('/publications/'.$y->year) }}">Tahun {{ $y->year }} <span class="badge">{{ $y->total }}</span></a><br>
          @endforeach

        </div>
      </div>
      <div class="col-md-10" style="border-left: solid #EBEFF1  1px">
          <div class="panel-body" style="text-align: left">
            <input class="form-control" onchange="window.location = '{{ url('/search') }}/'+this.value" style="width:90%; margin:auto" type="text" placeholder="Cari Dosen atau Publikasi ...">
            <hr>
            <h4><span class="glyphicon glyphicon-star"></span> Data Riset & Publikasi Terakhir</h4>
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

                $tmp = $authors.', '.$publication['title'].', '.$publication['description'];
              @endphp
              <tr><td>{{ $loop->iteration }}. </td><td>{{ $tmp }}</td></tr>
              @endforeach
            </table>


          </div>
      </div>
    </div>

    <hr>
    <div class="row">
      <div class="col-md-12 footer">
        &copy; 2018 Sistem Informasi Journal & Publikasi
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
