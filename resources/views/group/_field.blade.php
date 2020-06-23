<div class="form-group position-relative">
    <label for="name">团队名称:</label>

    <input type="text" class="form-control @error('name') is-invalid @enderror"
           id="name" name="name" autocomplete="off"
           placeholder="请输入团队名称" value="{{ old('name',$group->name) }}">

    @error('name')
    <div class="invalid-tooltip">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group position-relative">
    <label for="name">团队长:</label>
    <select name="user_id" class="select2">
        @foreach($users as $user)
            <option value="{{ $user->id }}"
                {{ $user->id ==old('user_id',$group->user_id) ? 'selected' : '' }}>{{ $user->name }}</option>
        @endforeach
    </select>

    @error('user_id')
    <div class="invalid-tooltip">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group position-relative">
    <label for="name">团队介绍:</label>

    <input type="text" class="form-control @error('desc') is-invalid @enderror"
           id="desc" name="desc" autocomplete="off"
           placeholder="请输入团队介绍" value="{{ old('desc',$group->desc) }}">
    @error('desc')
    <div class="invalid-tooltip">
        {{ $message }}
    </div>
    @enderror
</div>
