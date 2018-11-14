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


	<ul class="breadcrumb">
		<li><a href="{{ url('/home') }}">Dashboard</a></li>
		<li class="active">My Curriculum Vitae</li>
	</ul>
	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">My Curriculum Vitae</h2>
				</div>
				<div class="panel-body">

				<p align="right">Print</p>

				<h4 align="center">@if($data['profile']->prefix and $data['profile']->name and $data['profile']->suffix) {{ $data['profile']->prefix }}. {{ $data['profile']->name }}, {{ $data['profile']->suffix }} @elseif($data['profile']->name and $data['profile']->suffix) {{ $data['profile']->name }}, {{ $data['profile']->suffix }} @elseif($data['profile']->name) {{ $data['profile']->name }} @else - @endif</h4>
				<p align="center">@if($data['role']->display_name) {{ $data['role']->display_name }} @else - @endif</p>

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
						<td>@if($data['profile']->birthplace and $data['profile']->birthdate) {{ ucfirst($data['profile']->birthplace) }}, {{ $data['profile']->birthdate }} @else - @endif</td>
					</tr>
					<tr>
						<td></td>
						<td><b>Phone</b></td>
						<td> : </td>
						<td>@if($data['profile']->phone) {{ $data['profile']->phone }} @else - @endif</td>
					</tr>
					<tr>
						<td></td>
						<td><b>e-mail</b></td>
						<td> : </td>
						<td>@if($data['user']) {{ $data['user']->email }} @else - @endif</td>
					</tr>

				</table>

				<table>

					<tr>
						<td><b>Education</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['educations']))
								@foreach( $data['educations'] as $edu)
									<li><b>{{ $edu->program }} ({{ substr($edu->start_date,0,4) }})</b>, {{ $edu->institution }}, {{ $edu->country }} </li>
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

					<tr>
						<td><b>Academic Experience</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['experiences']))
								@foreach( $data['experiences'] as $exp)
									@if($exp->type == 1)
									<li>{{ substr($exp->start_date,0,4) }} - @if(empty($exp->start_date)) Until Now @else{{ substr($exp->start_date,0,4) }}@endif, {{$exp->position}} in {{$exp->organization}}</li>
									@endif
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>


					<tr>
						<td><b>Non-Academic Experience</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['experiences']))
								@foreach( $data['experiences'] as $exp)
									@if($exp->type == 0)
									<li>{{ substr($exp->start_date,0,4) }} - @if(empty($exp->end_date)) Until Now @else{{ substr($exp->end_date,0,4) }}@endif, {{$exp->position}} in {{$exp->organization}}</li>
									@endif
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

					<tr>
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

					<tr>
						<td><b>Membership in Professional Organizations</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['memberships']))
								@foreach( $data['memberships'] as $member)
									<li>{{ $member->title }} ({{ substr($member->start_date,0,4) }} - @if(empty($member->end_date)) Until Now @else{{ substr($member->end_date,0,4) }}@endif)</li>
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

					<tr>
						<td><b>Honors & Awards</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['awards']))
								@foreach( $data['awards'] as $award)
									<li>{{ $award->title }} ({{ substr($award->start_date,0,4) }} @if(isset($award->end_date)) - {{ substr($award->end_date,0,4) }} @endif)</li>
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

					<tr>
						<td><b>Service Activities</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['activities']))
								@foreach( $data['activities'] as $act)
									@if($act->type == 1)
									<li>{{ $act->title }}</li>
									@endif
								@endforeach
							@else
								-
							@endif
							</ul>
						</td>
					</tr>

					<tr>
						<td><b>Key Publications & Presentations</b></td>
					</tr>
					<tr>
						<td>tes</td>
					</tr>

					<tr>
						<td><b>Professional Development Activities</b></td>
					</tr>
					<tr>
						<td>
							<ul>
							@if(isset($data['activities']))
								@foreach( $data['activities'] as $act)
									@if($act->type == 0)
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
</style>
@endsection
