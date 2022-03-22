<div class="col-12 col-md-3 card">
    <div class=" card-header">
        <h4>Tiêu đề: {{$file->title}}</h4>
    </div>
    <div class="card-body">
        <?php
            use App\Models\User;
            $user = User::where('id', $file->idUser)->first();
                ?>
        <p>Tên sinh viên: {{$user->name}}</p>
        <?php
            use App\Models\InfoFile;
             $fileSubMit = InfoFile::find($file->idInfoFile);
                ?>
        Link đính kèm: <a href="/storage/{{$fileSubMit->title}}">{{$fileSubMit->title}}</a>
        <div class="item-bg"></div>
        </a>
        <p>Bài làm: {{ $file->content }}
        <p>

    </div>
</div>