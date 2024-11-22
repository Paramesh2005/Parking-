<?php include 'db_connect.php' ?>

<div class="conataine-fluid mt-4">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				Check-In/Check-ot List
			</div>
			<div class="card-body">
				<table class="table-condensed table">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>Date</th>
							<th>Parking Reference No.</th>
							<th>Owner</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT * FROM parked_list order by id desc ");
						while($row=$qry->fetch_assoc()):
						?>	
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date('M d,Y',strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['ref_no'] ?></td>
							<td><?php echo $row['owner'] ?></td>
							<td>
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-warning">Checked-In</span>
								<?php else: ?>
									<span class="badge badge-success">Checked-Out</span>
								<?php endif; ?>

							</td>
							<td class="text-center">
								<a class="btn btn-sm btn-outline-primary view_park" href="index.php?page=view_parked_details&id=<?php echo $row['id'] ?>" class="<?php echo $row['id'] ?>">View</a>
								<a class="btn btn-sm btn-outline-danger delete_park" href="javascript:void(0)" class="<?php echo $row['id'] ?>">Delete</a>
							</td>
						</tr>
					<?php endwhile ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$('table').dataTable()
	$('.delete_park').click(function(){
		_conf("Are you sure to delete this data?","delete_park",[$(this).attr('data-id')])
	})
	
	function delete_park($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_vehicle',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	
</script>