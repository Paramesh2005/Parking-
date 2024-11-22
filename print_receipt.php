<?php include 'db_connect.php' ?>
<?php
$qry = $conn->query("SELECT p.*,c.name as cname,l.location as lname FROM parked_list p inner join category c on c.id = p.category_id inner join parking_locations l on l.id = p.location_id where p.id= ".$_GET['id']);
foreach($qry->fetch_assoc() as $k => $v){
	$$k = $v;
}
$in_qry = $conn->query("SELECT * FROM parking_movement where pl_id = $id and status = 1");
$in_timstamp = $in_qry->num_rows > 0 ? date("M d, Y h:i A",strtotime($in_qry->fetch_array()['created_timestamp'])) : 'N/A';
$out_qry = $conn->query("SELECT * FROM parking_movement where pl_id = $id and status = 2");
$out_timstamp = $out_qry->num_rows > 0 ? date("M d, Y h:i A",strtotime($out_qry->fetch_array()['created_timestamp'])) : 'N/A';


?>

				<p><center><b><large>Parking Ticket</large></b></center></p>
				<hr>
				<h4><b>Parking Reference No. : <?php echo $ref_no ?></b> </h4>
							<p>Vehicle Parked Area: <b><?php echo $lname ?></b></p>
				<p>Vehicle Category: <b><?php echo $cname ?></b></p>
				<p>Vehicle Owner: <b><?php echo $owner ?></b></p>
				<p>Vehicle Registranion No.: <b><?php echo $vehicle_registration ?></b></p>
				<p>Vehicle Brand: <b><?php echo $vehicle_brand ?></b></p>
				<p>Vehicle Description: <b><?php echo !empty($vehicle_description) ? $vehicle_description : "No details entered" ?></b></p>
				<p>Vehicle Parked-In Time Stamp: <b><?php echo $in_timstamp ?></b></p>
			