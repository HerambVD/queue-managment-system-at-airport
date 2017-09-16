
<?php
	//include connection file 
	include_once("connection.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$empCls = new Employee($connString);

	switch($action) {
	
	 case 'delete':
		$empCls->deleteEmployee($params);
	 break;
	 default:
	 $empCls->getEmployees($params);
	 return;
	}
	
	class Employee {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getEmployees($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {   
			$where .=" WHERE ";
			$where .=" ( employee_name LIKE '".$params['searchPhrase']."%' ";    
			$where .=" OR employee_salary LIKE '".$params['searchPhrase']."%' ";

			$where .=" OR employee_age LIKE '".$params['searchPhrase']."%' )";
	   }
	   
	   // getting total number records without any search
		$sql = "SELECT * FROM `queue_goair_emirates` ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot employees data");
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch employees data");
		
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			$data[] = $row;
		}

		$json_data = array(
			"current"            => intval($params['current']), 
			"rowCount"            => 10, 			
			"total"    => intval($qtot->num_rows),
			"rows"            => $data   // total data array
			);
		
		return $json_data;
	}
	
	
	function deleteEmployee($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "delete from `queue_goair_emirates` WHERE ticket_no='".$params["ticket_no"]."'";
		
		 $result = mysqli_query($this->conn, $sql);
        if($result)
        {
        $sql6 = "ALTER TABLE `queue_goair_emirates` DROP `id`";
$result6 = mysqli_query($this->conn, $sql6);
$sql7 = "ALTER TABLE `queue_goair_emirates` AUTO_INCREMENT = 1";
$result7 = mysqli_query($this->conn, $sql7);
$sql8 = "ALTER TABLE `queue_goair_emirates` ADD `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
$result8 = mysqli_query($this->conn, $sql8);
            
            
        }
        
        
	}
}
?>
	