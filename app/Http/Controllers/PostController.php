<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helpers;
use App\Models\InfoFile;
use App\Models\Posts;
use App\Models\FileSubmit;

use Auth;
use Validator;
use DB;
use Storage;
use File;
use Log;

use App\Http\Requests\PostPostRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = DB::table('posts')->orderBy('updated_at', 'desc')->get();
        return view('admin.posts.index', compact('posts'));
        // return view('test');
    }
    public function create()
    {
        return view('admin.posts.add');
    }
    public function store(Request $request)
    {
        // Upload file
        $infoFile = 0;
        if ($request->hasFile('infoFile')) {
            $filerade = $request->file('infoFile');
            $fileradeData = File::get($filerade->getRealPath());
            $fileradeName = $filerade->getClientOriginalName();
            $fileradeExt = $filerade->getClientOriginalExtension();
            $filePath = $filerade->getRealPath();
            $fileSize = $filerade->getSize();
            $fileMime = $filerade->getMimeType();
            $url = Storage::put('public/upload/fileradepost/' . $fileradeName . '.' . $fileradeExt, $fileradeData);
            
            $image = InfoFile::create([
                'idUser' => Auth::id(),
                'title'  => 'upload/fileradepost/' . $fileradeName . '.' . $fileradeExt,
                'description' => $fileSize,
                // 'type'  =>  'fileradepost',
                'options'   =>  '',
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
            $infoFile = $image->id;
        }
        // INSERT
        $post =  Posts::create([
            'idInfoFile' => $infoFile,
            'idUser' => Auth::id(),
            'title' => $request->title,
            'content' => isset($request->content) ? $request->content : '',
            'status' => isset($request->status) ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        $thongbao = json_encode([
            'url' => '/quanly/baiviet/',
            'title' => $request->title,
            'status' => 'success',
            'message' => '<h3>Th??nh c??ng!</h3><p class="mb-0">B??i vi???t <strong>' . $request->title . '</strong> ???? ???????c t???o!</p>',
        ]);
        return redirect('/quanly/baiviet/')->with('thongbao', $thongbao);
    }
    public function edit($id)
    {
        $post = Posts::find($id);
        if (!$post) return redirect('/quanly/baiviet');

        $infoFile = InfoFile::find($post->infoFile);

        return view('admin.posts.edit', ['post' => $post, 'infoFile' => $infoFile]);
    }
    public function show($id)
    {
        $post = Posts::find($id);
        $files = FileSubmit::where('idPost', $id)->orderBy('id', 'desc')->get();
        // dd($files);
        if ($post) {
            // dd(1);
            return view('admin.posts.show', ['post' => $post, 'files' => $files]);
        } else {
            $thongbao = json_encode(['status' => 'danger', 'message' => 'B??i vi???t kh??ng t???n t???i!']);
            return redirect('/quanly/danhmuc/')->with('thongbao', $thongbao);
        }
    }
    public function update(PostUpdateRequest $request, $id)
    { try {
        DB::beginTransaction();
        $post = Posts::find($id);
        $infoFile = 0;
        if ($request->hasFile('infoFile')) {
            $filerade = $request->file('infoFile');
            $fileradeData = FileSubmit::get($filerade->getRealPath());
            $fileradeName = $filerade->getClientOriginalName();
            $fileradeExt = $filerade->getClientOriginalExtension();
            $filePath = $filerade->getRealPath();
            $fileSize = $filerade->getSize();
            $fileMime = $filerade->getMimeType();
            $url = Storage::put('public/upload/fileradepost/' . $fileradeName . '.' . $fileradeExt, $fileradeData);
            $image = InfoFile::create([
                'idUser' => Auth::id(),
                'title'  => 'upload/fileradepost/' . $fileradeName . '.' . $fileradeExt,
                'description' => $fileSize,
                'type'  =>  'fileradepost',
                'options'   =>  '',
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
            $infoFile = $image->id;

            $post->idInfoFile = $infoFile;
        }

        // UPDATE
        $post->title = $request->title;
        $post->content = isset($request->content) ? $request->content : '';
        $post->status = isset($request->status) ? 1 : 0;
        $post->updated_at = date('Y-m-d H:i:s', time());
        $post->save();
        $thongbao = json_encode([
            'url' => '/quanly/baiviet/',
            'title' => $request->title,
            'status' => 'success',
            'message' => '<h3>Th??nh c??ng!</h3><p class="mb-0">B??i vi???t <strong>' . $request->title . '</strong> ???? ???????c C???p nh???t!</p>',
        ]);
        return redirect('/quanly/baiviet/')->with('thongbao', $thongbao);
    } catch (\Exception $exception) {
        DB::rollback();
        return response()->json([
            'code'=>500,
            'message'=>'fail'
        ],500);
    }
    }
    public function delete($id)
    {
        $post = Posts::find($id);
        if(!$post) {
            return json_encode([
                        'url' => '/quanly/baiviet/',
                        'status'=> 'error',
                        'message' => '<h3>L???i!</h3><p class="mb-0">B??i vi???t n??y kh??ng t???n t???i!</p>',
                    ]);
        } else {
            try{
                // $trash = $contents->where('type', '=', 'dir')
                //     ->where('filename', '=', $trashName)
                //     ->first();
                
            // Chuy???n to??n b??? File v??? B??i vi???t 0
            $files = FileSubmit::where('idPost', $id)->get();
            if(count($files) > 0) {
                foreach ($files as $file) {
                    $f = FileSubmit::find($file->id);
                    $f->idPost = 0;
                    $f->save();
                }
            }
            $image = InfoFile::find($post->idInfoFile);
            if($image) {
                Storage::delete($image->timezone_identifiers_list);
                $image->forceDelete();
            }
            
            $post->forceDelete();
            $thongbao = json_encode([
                        'url' => '/quanly/baiviet/',
                        'title' => 'Qu???n l?? B??i vi???t',
                        'status'=>'success',
                        'message' => '<h3>Th??nh c??ng!</h3><p class="mb-0">B??i vi???t <strong>'.$post->title.'</strong> ???? ???????c x??a th??nh c??ng!</p>',
                    ]);
            Helpers::setNotifiCookie($thongbao);
            }catch(\Exception $exception){
                Log::error("Message: " . $exception->getMessage() . "Line: ". $exception->getLine());
                return response()->json([
                    'code'=>500,
                    'message'=>'fail'
                ],500);
            }
            return redirect('/quanly/baiviet/')->with('thongbao', $thongbao);
        }
    }
}
