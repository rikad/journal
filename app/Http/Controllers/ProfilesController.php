<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Session;

use App\Profile;
use App\User;


class ProfilesController extends Controller
{
    public function validation($id=false){

        $data = [
            'no' => 'required|unique:profiles',
            'initial' => 'required|unique:profiles',
            'name' => 'required',
            'file' => 'nullable|max:3000|mimes:jpg,jpeg',
            'birthplace' => 'required',
            'birthdate' => 'required|date',
        ];

        if(!empty($id)) {
            $data['no'] = 'required|unique:profiles,no,'.$id;
            $data['initial'] = 'required|unique:profiles,initial,'.$id;
        }

        return $data;
    }

    public function validationLogin($id=false){

        $data = [
            'username' => 'nullable|unique:users',
            'email' => 'nullable|unique:users',
            'password' => 'nullable|min:6'
        ];

        if(!empty($id)) {
            $data['username'] = 'required|unique:users,name,'.$id;
            $data['email'] = 'required|unique:users,email,'.$id;
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
        $data['email'] = Auth::user()->email;
        $data['username'] = Auth::user()->name;

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
        $dataLogin = $request->only('username','email');
        $profile = Profile::where('user_id', $id)->first();
        $user = User::find($id);

        if ($request->input('password')) {
          $dataLogin['password'] = bcrypt($request->input('password'));
        }

        //check if data exists update else create
        if($profile) {
            $this->validate($request, $this->validation($profile->id));
            $this->validate($request, $this->validationLogin($id));
            $profile->update($data);
            $user->update($dataLogin);
        } else {
            $this->validate($request, $this->validation());
            $this->validate($request, $this->validationLogin($id));

            $data['user_id'] = $id;
            Profile::create($data);
            $user->update($dataLogin);
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
