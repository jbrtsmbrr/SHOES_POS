<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SqlBuilder;
class tableUpdateController extends Controller
{
  public function __construct() {
    $this->sqlBuilder = new SqlBuilder;
  }

  public function tableUpdate(){
    $this->createTable();
    $this->alterTables();
  }

  private function createTable() {

    $qry = "CREATE TABLE `error_logs` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `date_executed` DATETIME NULL,
      `querystring` VARCHAR(100) NULL COLLATE 'utf8mb4_general_ci',
      PRIMARY KEY (`id`) USING BTREE
    )
    COLLATE='utf8mb4_general_ci'
    ENGINE=InnoDB";

    $this->sqlBuilder->createtable("error_logs", $qry);
  }

  private function alterTables() {

  }
}
