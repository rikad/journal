<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Session;

use App\Profile;


class ProfilesController extends Controller
{
    public function validation($id=false){

        $data = [
            'no' => 'required|unique:profiles',
            'initial' => 'required|unique:profiles',
            'name' => 'required',
            'file' => 'nullable|max:3000|mimes:jpg,jpeg',
            'birthplace' => 'required',
            'birthdate' => 'required|date'
        ];

        if(!empty($id)) {
            $data['no'] = 'required|unique:profiles,no,'.$id;
            $data['initial'] = 'required|unique:profiles,initial,'.$id;
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->create();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::id();
        $data = Profile::where('user_id', $id)->first();
        $data['foto'] = url('/image/avatar.png');

        $imgPath = public_path().DIRECTORY_SEPARATOR.'profiles'.DIRECTORY_SEPARATOR.$id.'.jpg';
        if(file_exists($imgPath)) {
          $data['foto'] = url('/profiles/'.$id.'.jpg');
        }

        return view('profiles.create')->with(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::id();
        $data = $request->except(['_token']);
        $profile = Profile::where('user_id', $id)->first();

        //check if data exists update else create
        if($profile){
            $this->validate($request, $this->validation($profile->id));
            $profile->update($data);
        } else {
            $this->validate($request, $this->validation());
            $data['user_id'] = $id;
            Profile::create($data);
        }

        // isi field file jika ada file yang diupload
        if ($request->hasFile('file')) {
            // Mengambil file yang diupload
            $uploaded = $request->file('file');
            // mengambil extension file
            $extension = $uploaded->getClientOriginalExtension();
            // membuat nama file random berikut extension
            $filename = $id.'.jpg';

            // menyimpan ke folder public/img
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'profiles';
            $uploaded->move($destinationPath, $filename);

            $data['file'] = $filename;
        }

        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Personal Information Updated"
        ]);
        return $this->create();
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
        //
    }
}
