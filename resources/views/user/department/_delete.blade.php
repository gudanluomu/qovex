<div class="modal fade" id="departmentDelete" tabindex="-1" role="dialog" aria-labelledby="departmentDeleteTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departmentDeleteTitle">删除部门</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    <p>1.该部门如果有下属部门，则不能被删除。</p>
                    <p>2.该部门或者下属部门任有员工，则不能被删除。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-danger">删除</button>
                </div>
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
