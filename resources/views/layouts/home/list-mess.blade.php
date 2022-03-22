<?php
use App\Models\User;
 $user = User::find($mess->idUserSend);
    ?>


<h4>{{$user->name}}</h4>
<span>{{$mess->content}}</span>
<hr/>