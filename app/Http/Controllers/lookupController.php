<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SqlBuilder;

class lookupController extends Controller
{
  private $sqlBuilder; 

  public function __construct() {
    $this->sqlBuilder = new SqlBuilder;
  }

  public function getLookup($params) {
    switch($params['lookuptype']) {
      case 'lookupbrand':
        $data = $this->lookupBrand($params);
      break;
      case 'lookupproduct':
        $data = $this->lookupProduct($params);
      break;
      case 'lookupuom':
        $data = $this->lookupUom($params);
      break;
    }

    return $data;
  }

  private function lookupBrand($params) {
    $lookuptype = $params['lookuptype'];
    $modal_setup = [];

    $modal_setup['title'] = 'Lookup Brand';
    $modal_setup['header'] = ['Action', 'Brand Name'];
    $modal_setup['body'] = [];

    $qry = "select brand_id, brand_name from tbl_brand";
    $result = $this->sqlBuilder->opentable($qry);

    foreach ($result as $key => $value) {
      $brand_id = $value->brand_id;
      $brand_name = $value->brand_name;
      array_push($modal_setup['body'], [
        'brand_id'    => "
          <i class='fas fa-download $lookuptype btnlookup' 
            lookuptype = $lookuptype
            txtbrand_id = '$brand_id' 
            txtbrand_name = '$brand_name'>
          </i>",
        'brand_name'  => $brand_name
      ]);
    }

    return ['lookuptype'=>$lookuptype, 'modal_setup'=>$modal_setup, 'status'=>true];
  }

  private function lookupProduct($params) {
    $lookuptype = $params['lookuptype'];
    $modal_setup = [];

    $modal_setup['title'] = 'Lookup Product';
    $modal_setup['header'] = ['Action', 'Barcode', 'Product Name'];
    $modal_setup['body'] = [];

    $qry = "select prod_id, prod_barcode, prod_name, prod_desc, amt from tbl_product";
    $result = $this->sqlBuilder->opentable($qry);

    foreach ($result as $key => $value) {
      $prod_id = $value->prod_id;
      $prod_barcode = $value->prod_barcode;
      $prod_name = $value->prod_name;
      
      array_push($modal_setup['body'], [
        'prod_id'    => "
          <i class='fas fa-download $lookuptype btnlookup callbtnlookup' 
            lookuptype = $lookuptype
            txtprod_id = '$prod_id' 
            txtprod_barcode = '$prod_barcode'>
          </i>",
        'prod_barcode'  => $prod_barcode,
        'prod_name'     => $prod_name,
      ]);
    }

    return ['lookuptype'=>$lookuptype, 'modal_setup'=>$modal_setup, 'status'=>true];
  }

  private function lookupUom($params) {
    $lookuptype = $params['lookuptype'];
    $modal_setup = [];

    $modal_setup['title'] = 'Lookup UOM';
    $modal_setup['header'] = ['Action', 'Uom', 'Amount'];
    $modal_setup['body'] = [];

    $qry = "select uom_id, uom_name, amt from tbl_uom";
    $result = $this->sqlBuilder->opentable($qry);

    foreach ($result as $key => $value) {
      $uom_id = $value->uom_id;
      $uom_name = $value->uom_name;
      $amt = $value->amt;
      
      array_push($modal_setup['body'], [
        'uom_id'    => "
          <i class='fas fa-download $lookuptype btnlookup' 
            lookuptype = $lookuptype
            txtuom_id = '$uom_id' 
            txtuom_name = '$uom_name'
            txtamt = '$amt'>
          </i>",
        'uom_name'  => $uom_name,
        'amt'     => $amt,
      ]);
    }

    return ['lookuptype'=>$lookuptype, 'modal_setup'=>$modal_setup, 'status'=>true];
  }
}
