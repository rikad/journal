<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Profile;
use App\Education;
use App\Experience;
use App\Certification;
use App\Membership;
use App\Award;
use App\Activity;
use App\Publication;

use Session;
use DB;

class VitaeController extends Controller
{
	public function index()
	{

        $data = array();
				$output = array();
				$user = Auth::user();

        $data['user'] = $user;
        $data['role'] = Auth::user()->roles()->first();
        $data['profile'] = Profile::where('user_id', $user->id)->first();

				//if users not yet filled the profile
				if (!$data['profile']) {
					Session::flash("flash_notification", [
							"level"=>"warning",
							"message"=>"Please Complete Your Data Before"
					]);
					return back();
				}

        $output['educations'] = Education::join('countries','countries.id','=','educations.country_id')
                ->join('organizations as program','program.id','=','educations.program_id')
                ->join('organizations as institution','institution.id','=','educations.institution_id')
                ->select(DB::raw('YEAR(educations.end_date) AS year'),'educations.start_date','educations.end_date','countries.country','institution.organization as institution','program.organization as program')
                ->where('user_id',$user->id)
                ->get();

        $output['experiences'] = Experience::join('organizations','organizations.id','=','experiences.organization_id')
                ->select('experiences.*','organizations.organization as organization')
                ->where('user_id',$user->id)
                ->get();

        $output['certifications'] = Certification::where('user_id', $user->id)->get();
        $output['memberships'] = Membership::where('user_id', $user->id)->get();
        $output['awards'] = Award::where('user_id', $user->id)->get();
        $output['activities'] = Activity::where('user_id', $user->id)->get();

        //publications
        $publications = Publication::select('publications.*')
                    ->join('publication_user','publication_user.publication_id','=','publications.id')
                    ->where('publication_user.user_id',$user->id)->get();

        $output['publications'] = [];
        foreach ($publications as $value) {
						$relation = DB::table('publication_user')->select('users.name','users.email','profiles.name as fullname')
                        ->join('users','users.id','publication_user.user_id')
												->leftJoin('profiles','users.id','profiles.user_id')
                        ->where('publication_id',$value->id)
                        ->where('users.id','<>',Auth::id())->get();
            $users = [];
            foreach ($relation as $k => $v) {
							if ($v->fullname) {
								$users[] = $v->fullname;
							} else {
								$users[] = $v->name;
							}
            }

            $output['publications'][] = ['id'=>$value->id,'title'=>$value->title,'authors'=>$value->authors,'description'=>$value->description,'file'=>$value->file,'published'=>$value->published,'users'=>$users ];
        }
        //end publications

				//name prefix suffix
				$output['name'] = '-';
				if($data['profile']->prefix and $data['profile']->name and $data['profile']->suffix) {
					 $output['name'] = $data['profile']->prefix.'. '.$data['profile']->name.', '.$data['profile']->suffix;
				} elseif($data['profile']->name and $data['profile']->suffix) {
					$output['name'] = $data['profile']->name.', '.$data['profile']->suffix;
				} elseif($data['profile']->name) {
					$output['name'] = $data['profile']->name;
				}

				$output['role'] = $data['role']->display_name ? $data['role']->display_name : '-';
				$output['birth'] = $data['profile']->birthplace && $data['profile']->birthdate ? ucfirst($data['profile']->birthplace).', '.$data['profile']->birthdate : '-';
				$output['phone'] = $data['profile']->phone ? $data['profile']->phone : '-';
				$output['email'] = $data['user']->email ? $data['user']->email : '-';

        return view('vitae.index', [ 'data' => $output ]);

	}
}
