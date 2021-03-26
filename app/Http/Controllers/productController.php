<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SqlBuilder;
use App\Http\Controllers\lookupController;
use Faker\Factory as Faker;

class productController extends Controller
{
  protected $table = "tbl_product";
  private $fields = [
    'prod_id', 'prod_barcode', 'prod_name', 
    'prod_desc', 'brand_id',
    'uom_id', 'discount'
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
    return view('/masterfile/product');
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

    if ($this->data['prod_id'] != "") {
      $sql = $this->sqlBuilder->update($this->table, $this->data, ['prod_id'=>$this->data['prod_id']]);

      if ($sql) {
        $response = ["status"=>true, "msg"=>"Update Success!", 'data'=>[]];
      } else {
        $response = ["status"=>false, "msg"=>"Update Failed!"];
      }
    } else {
      $prod_id = $this->sqlBuilder->insertGetId($this->table, $this->data);

      $prod_data = $this->getProduct($prod_id);

      if ($prod_id != 0) {
        $response = ["status"=>true, "msg"=>"Insert Success", 'data'=>$prod_data];
      } else {
        $response = ["status"=>false, "msg"=>"Insert Failed!"];
      }
    }

    echo json_encode($response);
  }

  public function reqProduct(Request $req) {
    $prod_id = $req->prod_id;

    $prod_data = $this->getProduct($prod_id);

    if(!empty($prod_data)) {
      $response = ["status"=>true, "msg"=>"Fetch Success!", 'data'=>$prod_data];
    } else {
      $response = ["status"=>false, "msg"=>"No Data!",];
    }
    
    echo json_encode($response); 
  }

  private function getProduct($id) {
    $qry = "
      select 
        prod.prod_id, prod.prod_barcode, prod.prod_name, prod.prod_desc, prod.discount,
        brand.brand_id, brand.brand_name
      from ".$this->table." as prod
      left join tbl_brand as brand on brand.brand_id = prod.brand_id
      where prod.prod_id = ?";

      return $this->sqlBuilder->opentable($qry, [$id]);
  }

  public function lookup(Request $req) {
    $lookuptype = $req->lookuptype;
    $params = [
      'lookuptype' => $lookuptype
    ];

    return $this->lookupController->getLookup($params);
  }

  public function reqUom(Request $req) {
    $prod_id = $req->prod_id;
    $response = [];

    $uom_data = $this->getUom($prod_id);

    if(!empty($uom_data)) {
      $response = ["status"=>true, "msg"=>"Fetch Success!", 'data'=>$uom_data];
    } else {
      $response = ["status"=>false, "msg"=>"No Data!"];
    }

    echo json_encode($response);
  }

  private function getUom($id) {
    $qry = "
    select 
      uom_id, prod_id, uom_desc, factor, amt 
    from tbl_uom 
    where prod_id = ?";

    return $this->sqlBuilder->opentable($qry, [$id]);
  }

  public function saveUom(Request $req) {
    $action = $req->action;
    $response = [];

    switch($action) {
      case "single":
        $uom_id   = $req->uom_id;
        $prod_id  = $req->prod_id;
        $uom_desc = $req->uom_desc;
        $factor   = $req->factor;
        $amt      = $req->amt;

        $uom_data = [
          'prod_id'   => $prod_id,
          'uom_desc'  => $uom_desc,
          'factor'    => $factor,
          'amt'       => $amt
        ];

        if($uom_id != "" || $uom_id != 0) {
          $sql = $this->sqlBuilder->update("tbl_uom", $uom_data, ['uom_id'=>$uom_id]);

          if ($sql) {
            $response = ["status"=>true, "msg"=>"Update Success!", 'data'=>[]];
          } else {
            $response = ["status"=>false, "msg"=>"Update Failed!"];
          }
        } else {
          $sql = $this->sqlBuilder->insert("tbl_uom", $uom_data);
          $uom_data = $this->getUom($prod_id);

          if ($sql) {
            $response = ["status"=>true, "msg"=>"Insert Success!", 'data'=>$uom_data];
          } else {
            $response = ["status"=>false, "msg"=>"Insert Failed!"];
          }
        }
      break;
    }

    echo json_encode($response);
  }









  public function dummyData() {
    // $this->dummayProduct();
    // $this->dummayBrand();

    // $data = [];

    // for ($i = 0; $i < 10; $i++) {
    //   array_push($data, [
    //     'a' => $i,
    //     'b' => $i+1
    //   ]);
    // }
    // echo "<pre>";
    // print_r($data);
  }
  
  private function dummayProduct() {
    $faker = Faker::create();
    for ($i = 0; $i < 100; $i++) {
      $this->sqlBuilder->insert("tbl_product", [
        'prod_barcode' => "IT".$faker->ean8,
        'prod_name'    => $faker->cityPrefix,
        'prod_desc'    => $faker->secondaryAddress,
        'amt'          => $faker->randomNumber(2),
        'discount'     => $faker->randomNumber(1)."%",
        'brand_id'     => $faker->randomNumber(2)
      ]);
    }
  }

  private function dummayBrand() {
    $faker = Faker::create();
    for ($i = 0; $i < 100; $i++) {
      $this->sqlBuilder->insert("tbl_brand", [
        'brand_name' => $faker->cityPrefix,
        'brand_desc' => $faker->state
      ]);
    }
  }
}
