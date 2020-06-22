<div class="form-group position-relative">
    <label for="name">员工名称:</label>

    <input type="text" class="form-control @error('name') is-invalid @enderror"
           id="name" name="name" autocomplete="off"
           placeholder="请输入员工名称" value="{{ old('name',$user->name) }}">

    @error('name')
    <div class="invalid-tooltip">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group position-relative">
    <label for="name">员工邮箱:</label>

    <input type="email" class="form-control @error('email') is-invalid @enderror"
           id="email" name="email" autocomplete="off"
           placeholder="请输入员工邮箱" value="{{ old('email',$user->email) }}">

    @error('email')
    <div class="invalid-tooltip">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group position-relative">
    <label for="name">登录密码:</label>

    <input type="text" class="form-control @error('password') is-invalid @enderror"
           id="password" name="password" autocomplete="off"
           placeholder="请输入员工录密码" value="{{ old('password') }}">

    @error('password')
    <div class="invalid-tooltip">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group position-relative">
    <label>职位详情:</label>
    <div class="input-group is-invalid">
        @foreach($roles as $role)
            <div class="custom-control custom-checkbox mb-2 mr-4">
                <input type="checkbox" class="custom-control-input" name="roles[]"
                       id="role_{{$role->id}}" value="{{ $role->id }}"
                       @if(in_array($role->id,$user->role_ids)) checked @endif>
                <label class="custom-control-label"
                       for="role_{{$role->id}}">{{ $role->name }}</label>
            </div>
        @endforeach
    </div>
</div>
