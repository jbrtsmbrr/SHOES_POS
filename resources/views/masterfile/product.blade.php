<div class="container-fluid">
  <h1 class="mt-4"></h1>
  <div class="">
    <button class="btn btn-primary btn-sm btnSave">Save</button>
    <button class="btn btn-primary btn-sm btnDelete">Delete</button>
  </div>
  <div class="div_head">
    <div class="row">
      <div class="col-md-3">
        <input type="hidden" class="moduletxt form-control form-control-sm txtprod_id" name="prod_id">
        <small class="small-label txtlabel">Barcode</small>
        <div class="input-group mb-2">
          <input type="text" class="moduletxt form-control form-control-sm txtprod_barcode" name="prod_barcode">
          <div class="input-group-prepend">
            <button lookuptype='lookupproduct' type="button" class="lookup btn btn-primary btn-sm" data-toggle="modal" data-target="#lookup-list">
              <i class="fa fa-eye"></i>
            </button>
          </div>
        </div> {{-- end lookup product --}}
        <small class="small-label txtlabel">Product Name</small>
        <input type="text" class="moduletxt form-control form-control-sm txtprod_name" name="prod_name">
        <small class="small-label txtlabel">Description</small>
        <input type="text" class="moduletxt form-control form-control-sm txtprod_desc" name="prod_desc">
        <small class="small-label txtlabel">Discount</small>
        <input type="text" class="moduletxt form-control form-control-sm txtdiscount" name="discount">
        <small class="small-label txtlabel">Brand</small>
        <div class="input-group mb-2">
          <input readonly type="text" class="moduletxt form-control form-control-sm txtbrand_name" name="brand_name">
          <input type="hidden" class="moduletxt form-control form-control-sm txtbrand_id" name="brand_id">
          <div class="input-group-prepend">
            <button lookuptype='lookupbrand' type="button" class="lookup btn btn-primary btn-sm" data-toggle="modal" data-target="#lookup-list">
              <i class="fa fa-eye"></i>
            </button>
          </div>
        </div> {{-- end lookup brand --}}
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

  var moduleid = 'product';
  
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
          $(".txtprod_id").val(res.data[0]['prod_id']);
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
      case 'lookupuom':
        let txtuom_id = $(this).attr('txtuom_id');
        let txtuom_name = $(this).attr('txtuom_name');

        $(".txtuom_id").val(txtuom_id);
        $(".txtuom_name").val(txtuom_name);
      break; // lookupuom
      case 'lookupbrand':
        let txtbrand_id = $(this).attr('txtbrand_id');
        let txtbrand_name = $(this).attr('txtbrand_name');

        $(".txtbrand_id").val(txtbrand_id);
        $(".txtbrand_name").val(txtbrand_name);
      break; // lookupbrand
    }
    $("#lookup-list").modal('hide');
  });

  $(document).on("click", ".callbtnlookup", function(e) {
    e.preventDefault();

    let lookuptype = $(this).attr('lookuptype');

    switch(lookuptype) {
      case 'lookupproduct':
        let prod_id = $(this).attr('txtprod_id');
        postData(`${moduleid}/reqProduct`, {prod_id:prod_id})
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
            $(".div_stock #uom-tab").click();
          }
        }); // postData
      break; // lookupproduct
    }
  });

  $(document).on("click", "#tbl_body_uom .btnuomsave", function(e) {
    e.preventDefault();

    let prod_id = $(".txtprod_id").val();
    let parent = $(this).closest("tr");
    let txtuom_desc = parent.find(".txtuom_desc").val();
    let txtuom_id = parent.find(".txtuom_id").val();
    let txtfactor = parent.find(".txtfactor").val();
    let txtamt = parent.find(".txtamt").val();

    let uomvalues = {
      uom_desc : txtuom_desc,
      uom_id   : txtuom_id,
      factor   : txtfactor,
      amt      : txtamt,
      prod_id  : prod_id,
      action   : "single"
    };

    postData(`${moduleid}/saveUom`, uomvalues)
    .then(res => {
      console.log(res); // JSON data parsed by `data.json()` call
      if(res.status) {
        toastr.success(res.msg, 'Success');
        if(res.data.length > 0) {

        }
      } else {
        toastr.error(res.msg, 'Error');
      }
    })
    .catch((error) => {
      toastr.error(error, 'Error');
    }); // postData
  });

  $(document).on("click", "#tbl_body_uom .btnuomdelete", function(e) {
    e.preventDefault();
    let parent = $(this).closest("tr");
    let txtuom_id = parent.find(".txtuom_id").val();
    
    if(txtuom_id != "") {

    } else {
      parent.remove();
    }
  });
  
  $(document).on("click", ".btnaddrow", function(e) {
    e.preventDefault();

    $("#tbl_body_uom").append(`
      <tr>
        <td>
          <i class="fas fa-download btnblue colaction btnuomsave" id="btnuomsave-1" line="1"></i>
          <i class="fas fa-trash btnred colaction btnuomdelete"></i>
        </td>
        <td>
          <input autocomplete="off" id="txtuom_desc-1" type="text" class="txtgrid form-control form-control-sm txtdescription txtuom_desc" name="uom_desc" value="">
          <input autocomplete="off" id="txtuom_id-1" type="hidden" class="txtgrid form-control form-control-sm txtuom_id" name="uom_id" value="">
        </td>
        <td><input autocomplete="off" id="txtfactor-1" type="text" class="txtgrid form-control form-control-sm txtqty text-right txtfactor" name="factor" value=""></td>
        <td><input autocomplete="off" id="txtamt-1" type="text" class="txtgrid form-control form-control-sm txtcurrency text-right txtamt" name="amt" value=""></td>
      </tr>
    `);

  });

  $(document).on("click", ".div_stock #uom-tab", function(e) {
    e.preventDefault();
    
    let prod_id = $(".txtprod_id").val();
    
    postData(`${moduleid}/reqUom`, {prod_id:prod_id})
    .then(res => {
      let str = "";
      if(res.status) {
        toastr.success(res.msg, 'Success');
        $("#tbl_body_uom").html("");
        for (var i in res.data) {
          let uom_id = res.data[i].uom_id;
          let uom_desc = res.data[i].uom_desc;
          let factor = res.data[i].factor;
          let amt = res.data[i].amt;
          str += `
            <tr class="tr-${uom_id}">
              <td>
                <i class="fas fa-download btnblue colaction btnuomsave" id="btnuomsave-${uom_id}" ukey="${uom_id}"></i>
                <i class="fas fa-trash btnred colaction btnuomdelete" id="btnuomdelete-${uom_id}" ukey="${uom_id}"></i>
              </td>
              <td>
                <input autocomplete="off" id="txtuom_desc-${uom_id}" type="text" class="txtgrid form-control form-control-sm txtdescription txtuom_desc" name="uom_desc" value="${uom_desc}">
                <input autocomplete="off" id="txtuom_id-${uom_id}" type="hidden" class="txtgrid form-control form-control-sm txtuom_id" name="uom_id" value="${uom_id}">
              </td>
              <td><input autocomplete="off" id="txtfactor-${uom_id}" type="text" class="txtgrid form-control form-control-sm txtqty text-right txtfactor" name="factor" value="${factor}"></td>
              <td><input autocomplete="off" id="txtamt-${uom_id}" type="text" class="txtgrid form-control form-control-sm txtcurrency text-right txtamt" name="amt" value="${amt}"></td>
            </tr>
          `;
        }
      } else {
        toastr.error(res.msg, 'Error');
      }
      $("#tbl_body_uom").append(str);
    })
    .catch((error) => {
      toastr.error(error, 'Error');
    }); // postData; // postData
  });
</script>
<script src="{{ asset('plugins/js/lookup.js') }}"></script>