<div class="form-group position-relative">
    <label for="name">权限名称:</label>

    <input type="text" class="form-control @error('name') is-invalid @enderror"
           id="name" name="name" autocomplete="off"
           placeholder="请输入权限名称" value="{{ old('name',$role->name) }}">

    @error('name')
    <div class="invalid-tooltip">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group position-relative">
    <label>权限详情:</label>
    <div class="input-group is-invalid">
        @foreach($permissions as $permission)
            <div class="custom-control custom-checkbox mb-2 mr-4">
                <input type="checkbox" class="custom-control-input" name="permissions[]"
                       id="permission_{{$permission->id}}" value="{{ $permission->id }}"
                       @if(in_array($permission->id,$role->permission_ids)) checked @endif>
                <label class="custom-control-label"
                       for="permission_{{$permission->id}}">{{ $permission->cname }}</label>
            </div>
        @endforeach
    </div>
</div>
