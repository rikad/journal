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

				<p align="right"><button class="btn btn-primary btn-sm" onclick="generate()"><span class="glyphicon glyphicon-print"></span> Print</button></p>

				<h4 align="center">@if($data['profile']->prefix and $data['profile']->name and $data['profile']->suffix) {{ $data['profile']->prefix }}. {{ $data['profile']->name }}, {{ $data['profile']->suffix }} @elseif($data['profile']->name and $data['profile']->suffix) {{ $data['profile']->name }}, {{ $data['profile']->suffix }} @elseif($data['profile']->name) {{ $data['profile']->name }} @else - @endif</h4>
				<p align="center">@if($data['role']->display_name) {{ $data['role']->display_name }} @else - @endif</p>

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
									<li><b>{{ $edu->program }} ({{ substr($edu->start_date,0,4) }})</b>, {{ $edu->institution }}, {{ $edu->country }} </li>
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
									<li>{{ substr($exp->start_date,0,4) }} - @if(empty($exp->start_date)) Until Now @else{{ substr($exp->start_date,0,4) }}@endif, {{$exp->position}} in {{$exp->organization}}</li>
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
									<li>{{ substr($exp->start_date,0,4) }} - @if(empty($exp->end_date)) Until Now @else{{ substr($exp->end_date,0,4) }}@endif, {{$exp->position}} in {{$exp->organization}}</li>
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
									<li>{{ $member->title }} ({{ substr($member->start_date,0,4) }} - @if(empty($member->end_date)) Until Now @else{{ substr($member->end_date,0,4) }}@endif)</li>
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
									<li>{{ $award->title }} ({{ substr($award->start_date,0,4) }} @if(isset($award->end_date)) - {{ substr($award->end_date,0,4) }} @endif)</li>
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
						<td>tes</td>
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
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.9.1/docxtemplater.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.6.1/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip-utils/0.0.2/jszip-utils.js"></script>

<script>

function loadFile(url,callback){
    JSZipUtils.getBinaryContent(url,callback);
}
function generate() {
    loadFile("/Cv-Abet-Template.docx",function(error,content){
        if (error) { throw error };
        var zip = new JSZip(content);
        var doc=new window.docxtemplater().loadZip(zip)
        doc.setData({
            name: 'John',
            phone: '0652455478',
        });
        try {
            // render the document (replace all occurences of {first_name} by John, {last_name} by Doe, ...)
            doc.render()
        }
        catch (error) {
            var e = {
                message: error.message,
                name: error.name,
                stack: error.stack,
                properties: error.properties,
            }
            console.log(JSON.stringify({error: e}));
            // The error thrown here contains additional information when logged with JSON.stringify (it contains a property object).
            throw error;
        }
        var out=doc.getZip().generate({
            type:"blob",
            mimeType: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        }) //Output the document using Data-URI
        saveAs(out,"output.docx")
    })
}
</script>
@endsection
