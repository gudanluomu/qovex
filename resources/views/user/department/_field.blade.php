<div class="form-group">
    <label>部门名称:</label>
    <input type="text" class="form-control" name="name" placeholder="请输入部门名称" required>
</div>

<div class="form-group">
    <label>直属部门:</label>
    <select name="parent_id" class="form-control select2">
        <option value="">顶级部门</option>
        @foreach($departments as $department)
            <option value="{{ $department->id }}"
                    data-html='<span style="margin-left: {{$department->depth*20}}px">{{ $department->name }}</span>'>
                {{ $department->name }}</option>
        @endforeach
    </select>
</div>
