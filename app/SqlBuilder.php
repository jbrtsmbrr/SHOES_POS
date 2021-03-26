<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Exception;
use Throwable;
use PDOException;

class SqlBuilder
{
  //DO NOTE $connection is the one declared on database.php
	function opentable($qry,$params=[],$connection = ''){
		try {
			if($connection == ''){
				return DB::select($qry,$params);
			}else{
				return DB::connection($connection)->select($qry,$params);
			}//end if
		} catch (PDOException $e) {
			$this->create_Elog($e);        
			echo $e;
		}
	}//end fn

  function getfieldvalue($table,$field,$condition,$params=[]){
  	$qry = 'select '.$field.' as value from '.$table.' where '.$condition.' limit 1';
  	return $this->datareader($qry,$params);
  }

	function datareader($qry,$params=[],$connection = ''){
		try {
			if($connection == ''){
				$data = DB::select($qry,$params);
			}else{
				$data = DB::connection($connection)->select($qry,$params);
			}//end if
			if(!empty($data)){
				return $data[0]->value;
			} else {
				return '';
			}
		} catch (PDOException $e) {
			$this->create_Elog($e);
			echo $e;
			return '';
		}
	}//end 

 	function update($table,$columns,$condition){
  	try {
      DB::table($table)->where($condition)->update($columns);
      return 1;
   	} catch (PDOException $e) {
     	$this->create_Elog($e);        
     	echo $e;
     	return 0;
   	} 
	}//end func

	function insert($table, $columns){
    try {
      DB::table($table)->insert($columns);
      return 1;
    } catch(PDOException $e) {
       	$this->create_Elog($table.' - '.$e);    
        echo $e;
        return 0;
    }//end catch
	}//end func

	function execqry($qry,$type='',$params=[],$connection = ''){
		switch (strtolower($type)) {
			case 'insert':
			   try{
				  if($connection == ''){
					DB::insert($qry,$params);
				  }else{
					DB::connection($connection)->insert($qry,$params);
				  }//end if
			      return 1;					
			   	} catch(PDOException $e) {
						$this->create_Elog($qry.' - '.$e);    
						echo $e;
						return 0;
					}//end catch
			break;
			case 'update':
			try {
				if($connection == ''){
					DB::update($qry,$params);
				}else{
					DB::connection($connection)->update($qry,$params);
				}//end if
				return 1;
			} catch (PDOException $e) {
				$this->create_Elog($qry.' - '.$e);
				echo $e;
				return 0;
			}//end error
			break;
			case 'delete':
			  try {
				if($connection == ''){
					DB::delete($qry,$params);
				}else{
					DB::connection($connection)->delete($qry,$params);
				}//end if
				return 1;			  	
			  } catch (PDOException $e) {
					$this->create_Elog($qry.' - '.$e);    
					echo $e;
					return 0;			  	
			  }
			break;
			case 'trigger':
				try {
				if($connection == '') {
					DB::unprepared($qry);
				} else {
					DB::connection($connection)->unprepared($qry);
				}
				return 1;			  	
				} catch (PDOException $e) {
					$this->create_Elog($qry.' - '.$e);    
					echo $e;
					return 0;			  				  	
				}
			break;
			default:
			  try {
				if($connection == '') {
					DB::statement($qry,$params);
				} else {
					DB::connection($connection)->statement($qry,$params);
				}
				return 1;			  	
			  } catch (PDOException $e) {
					$this->create_Elog($qry.' - '.$e);    
					echo $e;
					return 0;			  				  	
			  }
			break;
		}//end switch
	}//end fn

  function create_Elog($query){
  	$current_timestamp = now();
    $data = ['e_detail'=>'ERROR QUERY','date_executed'=>$current_timestamp,'querystring'=>$query];
    return $this->insert('error_logs',$data);
  }//end e log function 

	function insertGetId($table,$dataset){
		try {
			$key = DB::table($table)->insertGetId($dataset);
			return $key;
		} catch(PDOException $e) {
			$this->create_Elog($e);
			echo $e;
			return 0;
		}//end try
	}//end fn

	function addcolumn($table,$column,$type,$alter=1){
		$stat = '';
		try {
			if($this->tableexist($table)){
			  	if(!$this->columnexist($table, $column)){
				    $stat = 'Add column';
				    return DB::statement('ALTER TABLE `'.$table.'` ADD `'.$column.'` '.$type.' ');
			  	}else{
			    	if($alter){
				      	$stat = 'Alter column';
				      	return DB::statement('ALTER TABLE `'.$table.'` MODIFY COLUMN `'.$column.'` '.$type.' ');          
				    }else{
			      		return 1;
			    	}
			  	}
			}else{
			  $this->create_Elog("Table - ".$table." doesn't exist - Field - ".$column);                    
			}
		} catch (PDOException $e) {
			$this->create_Elog("Table - ".$table." - Field - ".$column." - ".$stat.' - '.$e);              
		}
	}//end fn

	function dropcolumn($table,$column){
		$stat = '';
		try {
			if($this->tableexist($table)){
			  	if($this->columnexist($table, $column)){
				    $stat = 'Drop column';
				    return DB::statement('ALTER TABLE `'.$table.'` DROP `'.$column.'`');
			  	}
			}
		} catch (PDOException $e) {
			$this->create_Elog("Table - ".$table." - Field - ".$column." - ".$stat." - ".$e);              
		}
	}

	function tableexist($table){
		// $result = Schema::hasTable($table);
		$result = DB::getSchemaBuilder()->hasTable($table);
		return $result;
	}//end fn

	function columnexist($table,$column){
		$result = DB::getSchemaBuilder()->hasColumn($table,$column);
		return $result;
	}//end fn

	function createtable($table,$qry){
		try{
			if(!$this->tableexist($table)){
				DB::statement($qry);
			}
		} catch(PDOException $e) {
			$this->create_Elog($qry);  
			echo $e;
			return 0;
		}
	}//end function
}
