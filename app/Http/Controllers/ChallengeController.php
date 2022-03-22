<?php

namespace App\Http\Controllers;

use Helpers;
use Illuminate\Http\Request;
use App\Models\InfoFile;
use App\Models\Challenge;

use Auth;
use Validator;
use DB;
use Storage;
use File;

class ChallengeController extends Controller
{
    public function index(){
        $challenges = DB::table('challenges')->orderBy('updated_at', 'desc')->get();
        return view('admin.challenges.index', compact('challenges'));
    }
    public function create(){
        return view('admin.challenges.add');
    }
    public function store(Request $request){
        // Upload file
        $infoFile = 0;
        $answer = '';
        $contentFile='';
        if($request->hasFile('infoFile')) {
            $filerade = $request->file('infoFile');
            $contentFile = File::get($filerade);
            $fileradeData = File::get($filerade->getRealPath());
            $fileradeName = $filerade->getClientOriginalName();
            $answer = substr($fileradeName, 0, -4);
            $fileradeExt = $filerade->getClientOriginalExtension();
            $filePath = $filerade->getRealPath();
            $fileSize = $filerade->getSize();
            $fileMime = $filerade->getMimeType();
            $url = Storage::put('public/upload/fileradepost/'.$fileradeName.'.'.$fileradeExt, $fileradeData);
            $image = InfoFile::create([
                'idUser' => Auth::id(),
                'title'  => 'upload/fileradepost/'.$fileradeName.'.'.$fileradeExt,
                'description' => $fileSize,
                'type'  =>  'fileradepost',
                'options'   =>  '',
                'created_at' => date('Y-m-d H:i:s',time()),
                'updated_at' => date('Y-m-d H:i:s',time()),
            ]);
            $infoFile = $image->id;

        }
        // INSERT
        $chall =  Challenge::create([
            'idInfoFile' => $infoFile,
            'answer' => $answer,
            'title' => $request->title,
            'content' => isset($request->content) ? $request->content : '',
            'contentFile' => $contentFile,
            'status' => isset($request->status) ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s',time()),
            'updated_at' => date('Y-m-d H:i:s',time()),
        ]);
        $thongbao = json_encode([
                'url' => '/quanly/thuthach/',
                'title' => $request->title,
                'status'=>'success',
                'message' => '<h3>Thành công!</h3><p class="mb-0">Bài viết <strong>'.$request->title.'</strong> đã được tạo!</p>',
        ]);
        return redirect('/quanly/thuthach/')->with('thongbao', $thongbao);
    }

    public function edit($id)
    {
        $chall = Challenge::find($id);
        if(!$chall) return redirect('/quanly/thuthach');

        $idInfoFile=InfoFile::find($chall->idInfoFile);
        
        return view('admin.challenges.edit', ['chall' => $chall, 'infoFile' =>$idInfoFile]);
    }
    public function delete($id)
    {
        $post = Challenge::find($id);
        if(!$post) {
            return json_encode([
                        'url' => '/quanly/thuthac/',
                        'status'=> 'error',
                        'message' => '<h3>Lỗi!</h3><p class="mb-0">Bài viết này không tồn tại!</p>',
                    ]);
        } else {
            try{
                // $trash = $contents->where('type', '=', 'dir')
                //     ->where('filename', '=', $trashName)
                //     ->first();
                
            // Chuyển toàn bộ File về Bài viết 0
            $files = Challenge::where('id', $id)->get();
            // if(count($files) > 0) {
            //     foreach ($files as $file) {
            //         $f = Challenge::find($file->id);
            //         $f->idPost = 0;
            //         $f->save();
            //     }
            // }
            $image = InfoFile::find($post->idInfoFile);
            if($image) {
                Storage::delete($image->timezone_identifiers_list);
                $image->forceDelete();
            }
            
            $post->forceDelete();
            $thongbao = json_encode([
                        'url' => '/quanly/baiviet/',
                        'title' => 'Thử thách',
                        'status'=>'success',
                        'message' => '<h3>Thành công!</h3><p class="mb-0">Bài viết <strong>'.$post->title.'</strong> đã được xóa thành công!</p>',
                    ]);
            Helpers::setNotifiCookie($thongbao);
            }catch(\Exception $exception){
                Log::error("Message: " . $exception->getMessage() . "Line: ". $exception->getLine());
                return response()->json([
                    'code'=>500,
                    'message'=>'fail'
                ],500);
            }
            return redirect('/quanly/thuthach/')->with('thongbao', $thongbao);
        }
    }
}
