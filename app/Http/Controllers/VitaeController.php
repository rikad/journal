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

class VitaeController extends Controller
{
	public function index()
	{
        $user = Auth::user();

        $data = array();
        $data['user'] = $user;
        $data['role'] = Auth::user()->roles()->first();
        $data['profile'] = Profile::where('user_id', $user->id)->first();
        $data['educations'] = Education::join('countries','countries.id','=','educations.country_id')
                ->join('organizations as program','program.id','=','educations.program_id')
                ->join('organizations as institution','institution.id','=','educations.institution_id')
                ->select('educations.start_date','educations.end_date','countries.country','institution.organization as institution','program.organization as program')
                ->where('user_id',$user->id)
                ->get();

        $data['experiences'] = Experience::join('organizations','organizations.id','=','experiences.organization_id')
                ->select('experiences.*','organizations.organization as organization')
                ->where('user_id',$user->id)
                ->get();

        $data['certifications'] = Certification::where('user_id', $user->id)->get();
        $data['memberships'] = Membership::where('user_id', $user->id)->get();
        $data['awards'] = Award::where('user_id', $user->id)->get();
        $data['activities'] = Activity::where('user_id', $user->id)->get();

        //$data['publications'] = Publication::where('user_id', $user->id)->get();

        //publications
        $publications = Publication::select('publications.*')
                    ->join('publication_user','publication_user.publication_id','=','publications.id')
                    ->where('publication_user.user_id',$user->id)->get();

        $final = [];
        foreach ($publications as $value) {
            $relation = DB::table('publication_user')->select('users.name')
                        ->join('users','users.id','publication_user.user_id')
                        ->where('publication_id',$value->id)
                        ->where('users.id','<>',Auth::id())->get();
            $users = [];
            foreach ($relation as $v) {
                $users[] = $v->name;
            }
            $relation = [ 'data' => $users];

            $final[] =['id'=>$value->id,'title'=>$value->title,'authors'=>$value->authors,'description'=>$value->description,'file'=>$value->file,'published'=>$value->published,'users'=>json_encode($relation) ];
        }
        //end publications



        //if users not yet filled the profile
        if (!$data['profile']) {
	        Session::flash("flash_notification", [
	            "level"=>"warning",
	            "message"=>"Please Complete Your Data Before"
	        ]);

        }

        return view('vitae.index')->with(compact('data'));

	}
}
