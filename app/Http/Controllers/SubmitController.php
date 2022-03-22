<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helpers;
use App\Models\InfoFile;
use App\Models\Posts;
use App\Models\FileSubmit;
use App\Models\Challenge;

use Auth;
use Validator;
use DB;
use Storage;
use File;
use Log;
use Carbon\Carbon;

class SubmitController extends Controller
{
    public function index($id)
    {
        $posts = Posts::find($id);
        
        // return view('layouts.home.submit.index', ['posts' => $posts]);
        return view('layouts.home.exercise.index', ['posts' => $posts]);
    }
    public function post(Request $request, $id)
    {
        $infoFile;
        //Kiểm tra file
        $url="";
        if($request->hasFile('infoFile')) {
            // dd(1);
            $filerade = $request->file('infoFile');
            $fileradeData = File::get($filerade->getRealPath());
            $fileradeName = $filerade->getClientOriginalName();
            $fileradeExt = $filerade->getClientOriginalExtension();
            $filePath = $filerade->getRealPath();
            $fileSize = $filerade->getSize();
            $fileMime = $filerade->getMimeType();
            $url = Storage::put('public/upload/fileradepost/'.$fileradeName.'.'.$fileradeExt, $fileradeData);
            $image = InfoFile::create([
                'idUser' => Auth::id(),
                'title'  => 'upload/fileradepost/'.$fileradeName.'.'.$fileradeExt,
                'description' => $fileSize,
                'options'   =>  '',
                'created_at' => date('Y-m-d H:i:s',time()),
                'updated_at' => date('Y-m-d H:i:s',time()),
            ]);
            // dd(1);
            $infoFile = $image->id;
        }
        $fileDatabase = FileSubmit::create([
            'idPost' => $id,
            'idUser' => Auth::id(),
            'idInfoFile' => $infoFile,
            'title' => $request->title,
            'content' => isset($request->content) ? $request->content : '',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        // dd(1);
        $status = 'success';
        $message = '<h3>Thành công!</h3><p class="mb-0">Tài liệu <strong>'.'</strong> đã được tải lên!</p>';
        $thongbao = (json_encode(['status' => $status, 'message' => $message, 'title' => $request->title, 'url' => $url]));
        return redirect('/')->with('thongbao', $thongbao);
    }
    public function ans($id){
        $chall = Challenge::find($id);
        // dd($chall);
        return view('layouts.home.submit.index', ['chall' => $chall]);
    }
    public function postans(Request $request, $id){
        $chall = Challenge::find($id);
        $message ='';
        $status='';
        if($chall->answer == $request->answer){
            $message = "Bạn trả lời đúng. ";
            $anwser= $chall->contentFile;
            $status='success';
        }
        else{
            $message = "Bạn trả lời sai.";
                $status='danger';
        }
        return view('layouts.home.submit.result', ['message' => $message, 'status'=>$status, 'anwser'=>$anwser]);
    }
}
