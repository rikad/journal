@php
  $Aexperiences = [];
  $Nexperiences = [];
  $Pactivities = [];
  $Sactivities = [];
  $awards = [];
  $memberships = [];
  $publications = [];
@endphp

@extends('layouts.app')
@section('content')
<div class="container">

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Key Publications & Presentations</h4>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>


	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Informasi Profil</h2>
				</div>
				<div class="panel-body">

        <div align="center">
          <img align="center" src="{{ url('/photo/'.$data['id']) }}" width="150">
  				<h4 align="center">{{ $data['name'] }}</h4>
  				<p align="center">{{ $data['role'] }}</p>
        </center>

        <hr>
				<table>

					<tr>
						<td><b>Personal Data</b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><b>Place/Date of Birth</b>  </td>
						<td> : </td>
						<td>{{ $data['birth'] }}</td>
					</tr>
					<tr>
						<td></td>
						<td><b>e-mail</b></td>
						<td> : </td>
            <td>{{ $data['email'] }}</td>
					</tr>

				</table>

        <hr>
				<table>

					<tr>
						<td><b>Education</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['educations']))
								@foreach( $data['educations'] as $edu)
									<li><b>{{ $edu->program }} ({{ $edu->year }})</b>, {{ $edu->institution }}, {{ $edu->country }} </li>
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

					<tr class="rowHead">
						<td><b>Academic Experience</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['experiences']))
								@foreach( $data['experiences'] as $exp)
									@if($exp->type == 1)
                    @php
                      $tmp = substr($exp->start_date,0,4).' - ';
                      $tmp .= empty($exp->end_date) ? 'Now' : substr($exp->end_date,0,4);
                      $tmp .= ': '.$exp->position.' in '.$exp->organization;
                      $Aexperiences[] = ['title' => $tmp];
                    @endphp
									  <li>{{ $tmp }}</li>
									@endif
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>


          <tr class="rowHead">
						<td><b>Non-Academic Experience</b></td>
					</tr>
					<tr>
						<td>
							<ul>
                @if(isset($data['experiences']))
  								@foreach( $data['experiences'] as $exp)
  									@if($exp->type == 0)
                      @php
                        $tmp = substr($exp->start_date,0,4).' - ';
                        $tmp .= empty($exp->end_date) ? 'Now' : substr($exp->end_date,0,4);
                        $tmp .= ': '.$exp->position.' in '.$exp->organization;
                        $Nexperiences[] = ['title' => $tmp];
                      @endphp
  									  <li>{{ $tmp }}</li>
  									@endif
  								@endforeach
  							@else
  								-
  							@endif
							</ul>
						</td>
					</tr>

          <tr class="rowHead">
						<td><b>Certifications & Professional Registrations</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['certifications']))
								@foreach( $data['certifications'] as $cert)
									<li>{{ $cert->title }}</li>
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

          <tr class="rowHead">
						<td><b>Membership in Professional Organizations</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['memberships']))
								@foreach( $data['memberships'] as $member)
                  @php
                    $tmp = $member->title.' ('.substr($member->start_date,0,4).' - ';
                    $tmp .= empty($member->end_date) ? 'Now' : substr($member->end_date,0,4);
                    $tmp .= ')';
                    $memberships[] = ['title' => $tmp];
                  @endphp
									<li>{{ $tmp }}</li>
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

          <tr class="rowHead">
						<td><b>Honors & Awards</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['awards']))
								@foreach( $data['awards'] as $award)
                @php
                  $tmp = $award->title.' ('.substr($award->start_date,0,4).' - ';
                  $tmp .= empty($award->end_date) ? 'Now' : substr($award->end_date,0,4);
                  $tmp .= ')';
                  $awards[] = ['title' => $tmp];
                @endphp
                <li>{{ $tmp }}</li>
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

          <tr class="rowHead">
						<td><b>Service Activities</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['activities']))
								@foreach( $data['activities'] as $act)
									@if($act->type == 1)
                  @php $Sactivities = ['title' => $act->title] @endphp
									<li>{{ $act->title }}</li>
									@endif
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

          <tr class="rowHead">
						<td><b>Key Publications & Presentations</b></td>
					</tr>
          <tr>
						<td>
							<ul>
							@if(isset($data['publications']))
								@foreach( $data['publications'] as $publication)
                @php
                  if($publication['authors'] == '') {
                    $authors = $publication['users'];
                  }
                  else {
                    $authors = array_merge($publication['users'],json_decode($publication['authors'])->data);
                  }

                  $authors[count($authors) - 1] = 'and '.$authors[count($authors) - 1];
                  $authors = implode(', ',$authors);

                  $tmp = $authors.', '.$publication['title'].', '.$publication['description'];
                  $publications[] = ['title' => $tmp];
                @endphp
                <li>{!! $tmp !!}</li>
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

          <tr class="rowHead">
						<td><b>Professional Development Activities</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['activities']))
								@foreach( $data['activities'] as $act)
									@if($act->type == 0)
                  @php $Pactivities = ['title' => $act->title] @endphp
									<li>{{ $act->title }}</li>
									@endif
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

				</table>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('css')
<style type="text/css">
th, td {
    padding: 5px;
    text-align: left;
}
table {
  width: 100%;
}
.rowHead {
  border-top: 1px solid #ECEFF0;
}
</style>
@endsection
