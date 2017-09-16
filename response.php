
<?php
	//include connection file 
	include_once("connection.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$empCls = new Employee($connString);

	switch($action) {
	 case 'add':
		$empCls->insertEmployee($params);
	 break;
	 case 'edit':
		$empCls->updateEmployee($params);
	 break;
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
	function insertEmployee($params) {
		$data = array();;
		$sql = "INSERT INTO queue (ticket_no,airline,full_name,departure,source,destination,arrival,date) VALUES ('$_POST[ticket]', 
'$_POST[airline]', 
 '$_POST[fullname]', 
 '$_POST[depa]',
'$_POST[source]',
 '$_POST[dest]', 
'$$_POST[arrival]', 
'$$_POST[date]' ) ";  
      
    
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert employee data");
		
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
		$sql = "SELECT * FROM `queue` ";
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
	function updateEmployee($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "Update `employee` set employee_name = '" . $params["edit_name"] . "', employee_salary='" . $params["edit_salary"]."', employee_age='" . $params["edit_age"] . "' WHERE id='".$_POST["edit_id"]."'";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update employee data");
	}
	
	
	function deleteEmployee($params) {
		$data = array();
		//print_R($_POST);die;
        $sql1="SELECT * FROM queue WHERE ticket_no=".$params["ticket_no"].""; /*fetching row and storing the values into variables */ 
        $result1= mysqli_query($this->conn, $sql1);
		$row1= mysqli_fetch_array($result1);   
        $id = $row1['id'];
        $ticket_no = $row1['ticket_no'];
        $airline = $row1['airline'];
        $full_name = $row1['full_name'];
        $departure = $row1['departure'];
        $source = $row1['source'];
        $destination = $row1['destination'];
        $arrival = $row1['arrival'];
        $date = $row1['date'];
        
        echo "$row1[airline]";
        
       if($airline=="JET AIRWAYS" or $airline=="SPICEJET")
        {
         $tablename= "queue_jet_spice";
        }
        elseif($airline=="GOAIR" or $airline=="EMIRATES")
        {
         $tablename= "queue_goair_emirates";
        }
        elseif($airline=="AIR ASIA" or $airline=="SRI LANKAN AIRLINES")
        {
         $tablename= "queue_airasia_srilankan";
        }
        elseif($airline=="VASCO" or $airline=="QATAR AIRWAYS")
        {
         $tablename= "queue_vasco_qatarairways";
        }
        else
        {
         $tablename= "queue_hkdragon_airindia";
        }
        
         $sql3= "INSERT INTO $tablename (ticket_no,airline,full_name,departure,source,destination,arrival,date) VALUES ('$row1[ticket_no]', 
'$airline', 
 '$row1[full_name]', 
 '$row1[departure]',
'$row1[source]',
 '$row1[destination]', 
'$row1[arrival]', 
'$row1[date]' ) ";
        $result3= mysqli_query($this->conn,$sql3);
	   $sql6 = "ALTER TABLE `$tablename` DROP `id`";
$result6 = mysqli_query($this->conn, $sql6);
$sql7 = "ALTER TABLE `$tablename` AUTO_INCREMENT = 1";
$result7 = mysqli_query($this->conn, $sql7);
$sql8 = "ALTER TABLE `$tablename` ADD `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
$result8 = mysqli_query($this->conn, $sql8);
       
        
        $sql = "delete from `queue` WHERE ticket_no='".$params["ticket_no"]."'";
		
		 $result = mysqli_query($this->conn, $sql);
        if($result)
        {
        $sql6 = "ALTER TABLE `queue` DROP `id`";
$result6 = mysqli_query($this->conn, $sql6);
$sql7 = "ALTER TABLE `queue` AUTO_INCREMENT = 1";
$result7 = mysqli_query($this->conn, $sql7);
$sql8 = "ALTER TABLE `queue` ADD `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
$result8 = mysqli_query($this->conn, $sql8);
            
            
        }
        
    }
}
?>
	