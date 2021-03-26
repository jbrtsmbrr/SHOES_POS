<div class="container-fluid">
  <h1 class="mt-4"></h1>
  <div class="">
    <button class="btn btn-primary btn-sm btnSave">Save</button>
    <button class="btn btn-primary btn-sm btnDelete">Delete</button>
  </div>
  <div class="div_head">
    <div class="row">
      <div class="col-md-3">
        <input type="hidden" class="moduletxt form-control form-control-sm txtclient_id" name="client_id">
        <small class="small-label txtlabel">Supplier Code</small>
        <div class="input-group mb-2">
          <input type="text" class="moduletxt form-control form-control-sm txtclient_code" name="client_code">
          <div class="input-group-prepend">
            <button lookuptype='lookupsupplier' type="button" class="lookup btn btn-primary btn-sm" data-toggle="modal" data-target="#lookup-list">
              <i class="fa fa-eye"></i>
            </button>
          </div>
        </div> {{-- end lookup product --}}
        <small class="small-label txtlabel">Supplier Name</small>
        <input type="text" class="moduletxt form-control form-control-sm txtclient_name" name="client_name">
        <small class="small-label txtlabel">Address</small>
        <input type="text" class="moduletxt form-control form-control-sm txtaddress" name="address">
        <small class="small-label txtlabel">Contact #</small>
        <input type="text" class="moduletxt form-control form-control-sm txtcontact_num" name="contact_num">
      </div>
    </div>
  </div>

  <div class="div_stock">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link tab-header" id="uom-tab" data-toggle="tab" href="#uom" role="tab" aria-controls="uom" aria-selected="true">UOM</a>
      </li>
      <li class="nav-item">
        <a class="nav-link tab-header" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link tab-header" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade" id="uom" role="tabpanel" aria-labelledby="uom-tab">
        <div class="responsive tbl_uom" style="height: 55vh; overflow-y: auto; margin-bottom: 0px; width: 50%;">
          <table class="table table-sm table-striped">
            <thead id="tbl_head_uom">
              <tr>
                <th class="colaction">Action</th>
                <th class="txtdescription">UOM</th>
                <th class="txtqty">Factor</th>
                <th class="txtcurrency">Amount</th>
              </tr>
            </thead>
            <tbody id="tbl_body_uom">
              
            </tbody>
            <tr>
              <td colspan="4">
                <i class="fas fa-plus btngreen btnaddrow"></i>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">2</div>
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">3</div>
    </div>
  </div>
</div>

@include('lookup/lookup')

<script>
  $(".moduletxt").attr({
      "autocomplete" : "off"
  });

  var moduleid = 'supplier';
  
  // Example POST method implementation:
  let postData = async (url = '', data = {}) => {
    // Default options are marked with *
    const response = await fetch(url, {
      method: 'POST', // *GET, POST, PUT, DELETE, etc.
      mode: 'cors', // no-cors, *cors, same-origin
      cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
      credentials: 'same-origin', // include, *same-origin, omit
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-Token": $("meta[name='csrf-token']").attr('content')
      },
      redirect: 'follow', // manual, *follow, error
      referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
      body: JSON.stringify(data) // body data type must match "Content-Type" header
    });

    return response.json(); // parses JSON response into native JavaScript objects
  }
  // this is sample if you use postData
  // postData(`${moduleid}/reqProduct`, {prod_id:prod_id})
  // .then(res => {
  //   console.log(res); // JSON data parsed by `data.json()` call
  // }); // postData

  $(document).on("click", ".btnSave", function(e) {
    e.preventDefault();

    let inputvalues = $(".moduletxt").serializeArray();
    
    postData(`${moduleid}/insert`, inputvalues)
    .then(res => {
      if(res.status) {
        toastr.success(res.msg, 'Success');
        if(res.data.length > 0) {
          $(".txtclient_id").val(res.data[0]['client_id']);
        }
      } else {
        toastr.error(res.msg, 'Error');
      }
    })
    .catch((error) => {
      toastr.error(error, 'Error');
    }); // postData; // postData
  });

  $(document).on("click", ".btnlookup", function(e) {
    e.preventDefault();

    let lookuptype = $(this).attr('lookuptype');
    
    switch(lookuptype) {
      case '':
        
      break; // lookupuom
    }
    $("#lookup-list").modal('hide');
  });

  $(document).on("click", ".callbtnlookup", function(e) {
    e.preventDefault();

    let lookuptype = $(this).attr('lookuptype');

    switch(lookuptype) {
      case 'lookupsupplier':
        let client_id = $(this).attr('txtclient_id');
        postData(`${moduleid}/reqSupplier`, {client_id:client_id})
        .then(res => {
          console.log(res); // JSON data parsed by `data.json()` call
          if(res.status) {
            if(res.data.length > 0) {
              $(".moduletxt").each(function() {
                let inputname = $(this).attr('name');
                for (let i in res.data[0]) {
                  if (inputname == i) {
                    console.log([inputname, i, res.data[0][i]]);
                    $(`.txt${inputname}`).val(res.data[0][i]);
                  }
                }
              });
            }
            // $(".div_stock #uom-tab").click();
          }
        }); // postData
      break; // lookupproduct
    }
  });

  $(document).on("click", ".div_stock #uom-tab", function(e) {
    e.preventDefault();
    
    let prod_id = $(".txtprod_id").val();
    
    if(prod_id == "" || prod_id == 0) {
      toastr.error("Please Save Supplier First!", 'Error');
      return false;
    }
  });
</script>
<script src="{{ asset('plugins/js/lookup.js') }}"></script>