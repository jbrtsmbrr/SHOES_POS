<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SqlBuilder;
use App\Http\Controllers\lookupController;

class supplierController extends Controller
{
  protected $table = "tbl_client";
  private $fields = [];
  private $data = [];
  private $sqlBuilder; 
  private $lookupController;

  # -------------------

  public function __construct() {
    $this->sqlBuilder = new SqlBuilder;
    $this->lookupController = new lookupController;
  }
}
