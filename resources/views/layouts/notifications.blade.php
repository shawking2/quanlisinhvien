<div id="notifi">
    {!! Helpers::showNotifiCookie() !!}
    @if(isset($notifi))
    {!! Helpers::showNotifi($notifi)!!}
    @endif
    @if(session('notifi'))
    <?php $notifi = json_decode(session('notifi')); ?>
    <div class="toast alert alert-{{$notifi->status}} alert-dismissible shadow toast-fixed fade show"
        id="placement-toast" role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false"
        data-mdb-position="top-right" data-mdb-append-to-body="true" data-mdb-stacking="false" data-mdb-width="350px"
        data-mdb-color="info">
        <div class="toast-header">
            <strong class="me-auto">Thông báo</strong>
            <button type="button" class="btn-close" data-mdb-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body py-2">{!! $notifi->message !!}</div>
    </div>
    @endif
</div>