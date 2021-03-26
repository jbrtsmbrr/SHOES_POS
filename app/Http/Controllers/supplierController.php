<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SqlBuilder;
use App\Http\Controllers\lookupController;

class supplierController extends Controller
{
  protected $table = "tbl_client";
  private $fields = [
    'client_id', 'client_code', 'client_name', 'address', 'contact_num'
  ];
  private $data = [];
  private $sqlBuilder; 
  private $lookupController;

  # -------------------

  public function __construct() {
    $this->sqlBuilder = new SqlBuilder;
    $this->lookupController = new lookupController;
  }

  public function index() {
    return view('/masterfile/supplier');
  }

  public function insert(Request $request) {
    $req = $request->all();
    foreach($this->fields as $key => $fields){
      foreach($req as $k => $v) {
        if($fields == $req[$k]['name']) {
          $this->data[$fields] = $req[$k]['value'];
        }
      }
    }
    $this->saveProduct();
  }

  private function saveProduct() {
    $status = false;
    $prod_data = [];
    $response = [];

    if ($this->data['client_id'] != "") {
      $sql = $this->sqlBuilder->update($this->table, $this->data, ['client_id'=>$this->data['client_id']]);

      if ($sql) {
        $response = ["status"=>true, "msg"=>"Update Success!", 'data'=>[]];
      } else {
        $response = ["status"=>false, "msg"=>"Update Failed!"];
      }
    } else {
      $this->data['issupplier'] = 1;
      
      $client_id = $this->sqlBuilder->insertGetId($this->table, $this->data);

      $supp_data = $this->getSupplier($client_id);

      if ($client_id != 0) {
        $response = ["status"=>true, "msg"=>"Insert Success", 'data'=>$supp_data];
      } else {
        $response = ["status"=>false, "msg"=>"Insert Failed!"];
      }
    }

    echo json_encode($response);
  }

  public function reqSupplier(Request $req) {
    $client_id = $req->client_id;

    $supp_data = $this->getSupplier($client_id);

    if(!empty($supp_data)) {
      $response = ["status"=>true, "msg"=>"Fetch Success!", 'data'=>$supp_data];
    } else {
      $response = ["status"=>false, "msg"=>"No Data!",];
    }
    
    echo json_encode($response); 
  }

  private function getSupplier($id) {
    $qry = "
      select 
        supp.client_id, supp.client_code, supp.client_name, supp.address, supp.contact_num
      from ".$this->table." as supp
      where supp.client_id = ?";

      return $this->sqlBuilder->opentable($qry, [$id]);
  }

  public function lookup(Request $req) {
    $lookuptype = $req->lookuptype;
    $params = [
      'lookuptype' => $lookuptype
    ];

    return $this->lookupController->getLookup($params);
  }
}
