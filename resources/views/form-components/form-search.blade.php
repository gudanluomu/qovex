<form>
    <div class="form-row">
        {{ $groups }}
        <div class="col-md-3 col-sm-12 mb-4">
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">搜索</button>
                <a class="btn btn-secondary" href="{{ url()->current() }}">返回</a>
            </div>
        </div>
    </div>
</form>
