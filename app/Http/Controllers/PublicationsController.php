<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Session;
use Validator;

use App\Publication;
use App\User;

//file handling & tested
//delete file

class PublicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $data = Publication::select('publications.*')
                    ->join('publication_user','publication_user.publication_id','=','publications.id')
                    ->where('publication_user.user_id',$id)->get();

        $final = [];
        foreach ($data as $value) {
            $relation = DB::table('publication_user')->select('users.name','users.email','profiles.name as fullname')
                        ->join('users','users.id','publication_user.user_id')
                        ->leftJoin('profiles','users.id','profiles.user_id')
                        ->where('publication_id',$value->id)
                        ->where('users.id','<>',Auth::id())->get();
            $users = [];
            $authorFullname = [];

            foreach ($relation as $v) {
                $users[] = $v->email;

                if ($v->fullname) {
                  $authorFullname[] = $v->fullname;
                } else {
                  $authorFullname[] = $v->name;
                }
            }

            $relation = [ 'data' => $users];

            $final[] = ['id'=>$value->id,'title'=>$value->title,'authors'=>$value->authors,'description'=>$value->description,'file'=>$value->file,'published'=>$value->published,'users'=>json_encode($relation),'fullname'=>$authorFullname ];
        }

        return View('publications.index', ['data'=>$final]);
    }


    public function users() {
        $data = User::join('role_user','role_user.user_id','users.id')
                    ->where('users.id','<>',Auth::id())
                    ->where('role_user.role_id','<>',1)
                    ->pluck("users.email","users.id")->all();
        return $data;
    }

    public function validation() {

        $data = [
            'title' => 'required',
            'description' => 'required',
            'published' => 'required|date',
            'file' => 'nullable|max:50000|mimes:doc,docx,pdf'
        ];

        return $data;
    }

    public function download($file) {
        $filepath = public_path().DIRECTORY_SEPARATOR.'publications'. DIRECTORY_SEPARATOR . $file;

        $publication = Publication::select('publications.*')
                    ->join('publication_user','publication_user.publication_id','=','publications.id')
                    ->where('publications.file', $file)
                    ->where('publication_user.user_id',Auth::id())->first();

        if ($publication) {
            $ext = explode('.',$file);
            $filename = $publication->title.'.'.$ext[1];

            return response()->download($filepath,$filename);
        }

        Session::flash("flash_notification", [
            "level"=>"danger",
            "message"=>"you are not allowed"
        ]);

        return redirect()->action('PublicationsController@index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $datawithfile = $request->except(['_token']);
        $data = $request->except(['_token','file']);
        $publication = Publication::find($data['id']);

        $validator = Validator::make($datawithfile, $this->validation());
        if ($validator->fails()) {
            $failMessage = json_decode(json_encode($validator->messages()));
            $message = '<ul>';
            foreach ($failMessage as $key => $value) {
              $message = $message. '<li>'.$value[0].'</li>';
            }
            $message = $message . '</ul>';
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>$message
            ]);

            return back();
        }

        if ($request->input('authors') != null) {
            $data['authors'] = json_encode([ 'data'=> $data['authors'] ]);
        } else {
          $data['authors'] = null;
        }

        // isi field file jika ada file yang diupload
        if ($request->hasFile('file')) {
            // Mengambil file yang diupload
            $uploaded = $request->file('file');
            // mengambil extension file
            $extension = $uploaded->getClientOriginalExtension();
            // membuat nama file random berikut extension
            $filename = md5(time()) . '.' . $extension;

            // menyimpan ke folder public/img
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'publications';
            $uploaded->move($destinationPath, $filename);

            $data['file'] = $filename;
        }

        //check if data exists update else create
        if($publication){

            $publication->update($data);

            //aksi edit ke relasi
            DB::table('publication_user')->where('publication_id',$publication->id)->delete();
            $relation = [ ['publication_id'=>$publication->id,'user_id'=>Auth::id()] ];

        } else {
            $publication = Publication::create($data);
            $relation = [ ['publication_id'=>$publication->id,'user_id'=>Auth::id()] ];
        }

        if (isset($data['users'])) {
          foreach($data['users'] as $value) {
              $relation[] = ['publication_id'=>$publication->id,'user_id'=>$value ];
          }

          DB::table('publication_user')->insert($relation);
        }

        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Publication Updated"
        ]);

        return redirect()->action('PublicationsController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $publication = Publication::select('publications.id','publications.file','publications.title','publication_user.user_id')
                    ->join('publication_user','publication_user.publication_id','=','publications.id')
                    ->where('publications.id', $id)
                    ->orderBy('publication_user.id','asc')
                    ->first();

        if ($publication->user_id == Auth::id()) {
          $pub = Publication::find($publication->id);
          $pub->delete();

          // hapus file lama, jika ada
          if ($publication->file) {
              $filepath = public_path().DIRECTORY_SEPARATOR.'publications'. DIRECTORY_SEPARATOR . $publication->file;
              try {
                  File::delete($filepath);

              } catch (FileNotFoundException $e) {
                  // File sudah dihapus/tidak ada
              }
          }

          Session::flash("flash_notification", [
              "level"=>"danger",
              "message"=>"Publication '".$pub->title."' Deleted"
          ]);

        } else {
          DB::table('publication_user')->where('publication_id',$id)->where('user_id',Auth::id())->delete();

          Session::flash("flash_notification", [
              "level"=>"danger",
              "message"=>"You are deleted from author of Publication '".$publication->title."'"
          ]);

        }

        return 'ok';
    }
}
