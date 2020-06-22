<div class="modal fade" id="departmentCreate" tabindex="-1" role="dialog" aria-labelledby="departmentCreateTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departmentCreateTitle">添加部门</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('department.store') }}">
                <div class="modal-body">
                    @include('user.department._field')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">添加</button>
                </div>
                @csrf
            </form>

        </div>
    </div>
</div>
