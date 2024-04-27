<?php 
 
require_once 'db_connect.php';
 
$response = array();
 
if(isset($_GET['apicall'])){
	 
  switch($_GET['apicall']){
 
  case 'view': 
    $sql = "SELECT * FROM Lead";
    $result=mysqli_query($conn, $sql);
    $leads = array();

    while($row = mysqli_fetch_array($result)){
	    $leads[] = $row;
    }

    mysqli_close($conn);
    $response['leads'] = $leads; 
    echo json_encode($response);
	
	case 'insert':
	  $source = $_POST['source'];
    $status = $_POST['status'];
    $reason = $_POST['reason'];
    $typeoflead = $_POST['typeoflead'];
    $vendorid = $_POST['vendorid'];
    $rating = $_POST['rating'];
    $companyid = $_POST['companyid'];

    //insert new lead in table Leads
    $query = "INSERT INTO Lead (source, status, reason_disqualified, type, current_component_vendor_id, rating, contact_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $source, $status, $reason, $typeoflead, $vendorid, $rating, $companyid);
    $stmt->execute();

    if ($stmt->affected_rows > 0){
	    echo "<p>Lead inserted into database sucessfully.</p>";
    } else {
	    echo "<p>An error has occured.<br/>The item was not added.</p>";
    }
    $conn->close();
  }
}
?>
