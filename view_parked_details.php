<?php include 'db_connect.php' ?>
<?php
$qry = $conn->query("SELECT p.*,c.name as cname,c.rate,l.location as lname FROM parked_list p inner join category c on c.id = p.category_id inner join parking_locations l on l.id = p.location_id where p.id= ".$_GET['id']);
foreach($qry->fetch_assoc() as $k => $v){
	$$k = $v;
}
$in_qry = $conn->query("SELECT * FROM parking_movement where pl_id = $id and status = 1");
$in_timstamp = $in_qry->num_rows > 0 ? date("M d, Y h:i A",strtotime($in_qry->fetch_array()['created_timestamp'])) : 'N/A';
$out_qry = $conn->query("SELECT * FROM parking_movement where pl_id = $id and status = 2");
$out_timstamp = $out_qry->num_rows > 0 ? date("M d, Y h:i A",strtotime($out_qry->fetch_array()['created_timestamp'])) : 'N/A';
if($status ==2){
$ocalc = abs(strtotime($out_timstamp)-strtotime($in_timstamp));
$ocalc = ($ocalc / (60*60));
$c = explode('.',$ocalc);
$calc = $c[0];
if(isset($c[1])){
	$c[1] = floor(60 * ('.'.$c[1]));

	$calc = $c[1] >= 60 ? ($calc + $c[1]).':00' : $calc.':'.$c[1] ; 
}
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<a href="index.php?page=manage_park&id=<?php echo $id ?>" class="btn btn-sm btn-primary btn-block col-sm-2 float-right" ><i class="fa fa-edit"></i> Edit</a>
				<a href="javascript:void(0)" id="btn_print" class="btn btn-sm btn-primary btn-block col-sm-2 float-right mr-2 mt-0" ><i class="fa fa-print"></i> Print Ticket</a>
				<h4><b>Parking Reference No. : <?php echo $ref_no ?></b> </h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<p>Vehicle Parked Area: <b><?php echo $lname ?></b></p>
						<p>Vehicle Category: <b><?php echo $cname ?></b></p>
						<p>Vehicle Owner: <b><?php echo $owner ?></b></p>
						<p>Vehicle Registranion No.: <b><?php echo $vehicle_registration ?></b></p>
						<p>Vehicle Brand: <b><?php echo $vehicle_brand ?></b></p>
						<p>Vehicle Description: <b><?php echo !empty($vehicle_description) ? $vehicle_description : "No details entered" ?></b></p>
						<p>Vehicle Parked-In Time Stamp: <b><?php echo $in_timstamp ?></b></p>
					</div>
					<div class="col-md-6">
						<?php if($status == 1): ?>
							<button type="button" id="checkout_btn" class="btn-sm btn btn-block col-sm-5 btn-primary"><i class="fa fa-calculator"></i> Compute to Checkout</button>
						<div id="check_details"></div>
						<?php else: ?>
							<table class="table table-bordered" width="100%">
								<tr>
									<th class="text-center" colspan='2'>
										<a href="javascript:void(0)" id="btn_print_receipt" class="btn btn-sm btn-primary  float-right mr-2 mt-0" ><i class="fa fa-print"></i></a>
										Checkout Details
									</th>
								</tr>
								<tr>
									<th>Chech-In Timestamp</th>
									<td class="text-right"><?php echo $in_timstamp ?></td>
								</tr>
								<tr>
									<th>Chech-Out Timestamp</th>
									<td class="text-right"><?php echo $out_timstamp ?></td>
								</tr>
								<tr>
									<th>Timestamp Difference</th>
									<td class="text-right"><?php echo $calc ." (".(number_format($ocalc,2)).")" ?></td>
								</tr>
								<tr>
									<th>Vehicle Type Hourly Rate</th>
									<td class="text-right"><?php echo number_format($rate,2) ?></td>
								</tr>
								<tr>
									<th>Amount Due</th>
									<td class="text-right"><?php echo number_format($rate * $ocalc,2) ?></td>
								</tr>
								<tr>
									<th>Amount Tendered</th>
									<td class="text-right"><?php echo number_format($amount_tendered,2) ?></td>
								</tr>
								<tr>
									<th>Change</th>
									<td class="text-right"><?php echo number_format($amount_change,2) ?></td>
								</tr>
							</table>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#btn_print').click(function(){
		var nw = window.open("print_receipt.php?id=<?php echo $id ?>","_blank","height=500,width=800")
		nw.print()
		setTimeout(function(){
			nw.close()
		},500)
	})
	$('#btn_print_receipt').click(function(){
		var nw = window.open("print_checkout_receipt.php?id=<?php echo $id ?>","_blank","height=500,width=800")
		nw.print()
		setTimeout(function(){
			nw.close()
		},500)
	})
	$('#checkout_btn').click(function(){
		start_load()
		$.ajax({
			url:'get_check_out.php?id=<?php echo $id ?>',
			success:function(resp){
				if(resp){
					$('#check_details').html(resp)
					end_load();
				}
			}

		})
	})

</script>