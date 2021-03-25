<!-- Modal -->
<div class="modal fade" id="lookup-list" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lookup-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control form-control-sm" placeholder="Search">
        </div>
        <div class="responsive" style="height: 55vh; overflow-y: auto; margin-bottom: 0px">
          <table class="table table-sm table-striped">
            <thead id="tbl_head">
  
            </thead>
            <tbody id="tbl_body">
  
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button id="lookup_close" type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
      </div>
    </div>
  </div>
</div>