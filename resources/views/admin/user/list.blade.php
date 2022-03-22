<div class="container responsive">
    <table id="table-user" class="table table-bordered table-hover" data-page-length='25'>
        <thead class="thead-primary">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Quyền</th>
                <th scope="col">Thời gian đăng ký</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $users = App\Models\User::all();
            $roles = Spatie\Permission\Models\Role::all();
        ?>
            @foreach ($listUser as $user)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td><a href="/u/{{ $user->name }}"> {{ $user->name }} </a>
                <td><a href="/u/{{ $user->name }}"> {{ $user->email }} </a>
                    <td><a href="/u/{{ $user->name }}"> {{ $user->phone }} </a>
                <td>
                    @foreach($roles as $role)
                    {{ $user->hasRole($role)? $role->name.',': '' }}
                    @endforeach
                </td>
                <td>
                    <span data-toggle=" tooltip"
                        title="Đăng ký lúc {{ date('H:i:s - d/m/Y', strtotime($user->created_at)) }}">{{ date('d/m/Y',
                        strtotime($user->created_at)) }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>