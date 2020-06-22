<div class="modal fade" id="departmentUpdate" tabindex="-1" role="dialog" aria-labelledby="departmentUpdateTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departmentUpdateTitle">修改部门</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    @include('user.department._field')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">修改</button>
                </div>
                @csrf
                @method('PUT')
            </form>
        </div>
    </div>
</div>
