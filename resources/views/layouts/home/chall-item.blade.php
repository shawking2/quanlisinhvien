<div class="col-12 col-md-6 wow fadeInDown" data-wow-delay="0.4s">

    <div class="post-item pointer" link-to="">
        <div class="card post-detail">
            <div class=" card-header">
                <h4>{{$chall->title}}</h4>
            </div>
            <?php
            use App\Models\InfoFile;
             $infoFile = InfoFile::find($chall->idInfoFile);
             
                ?>
            <div class=" card-body">
                <a href="/storage/{{$infoFile->title}}">{{$infoFile->title}}</a>
                <div class="item-bg"></div>
                <a class="item-info @if($chall->img_url == '/img/cover@1x.png') active @endif" href="">
                </a>
                <p>Yêu cầu: {{ $chall->content }}
                <p>
                    <a href="/answer/{{$chall->id}}"
                        class="btn btn-primary text-center align-content-center align-items-center">Nộp
                        bài</a>
            </div>
        </div>
    </div>
</div>