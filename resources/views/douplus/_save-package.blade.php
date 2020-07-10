<div class="form-group">
    <div class="custom-control custom-checkbox mb-2" dir="ltr">
        <input type="checkbox" class="custom-control-input" id="save_package"
               name="save_package" value="1" @if(old('save_package') == 1) checked @endif>
        <label class="custom-control-label" for="save_package">是否保存为定向包</label>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane @if(old('save_package') == 1) active @endif"
         id="tab_save_package">
        <div class="form-group">
            <label>包名称:</label>
            <div class="input-group is-invalid">
                <input class="form-control" type="text" value="{{ old('package_name') }}"
                       name="package_name">
            </div>
            @error('package_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>包描述:</label>
            <div class="input-group is-invalid">
                <input class="form-control" type="text" value="{{ old('package_desc') }}"
                       name="package_desc">
            </div>
            @error('package_desc')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>
