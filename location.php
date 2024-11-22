<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				<button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" type="button" id="new_location">
					<i class="fa fa-plus"></i> Add Location
				</button>
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Category</th>
									<th class="">Location</th>
									<th class="">Area Capacity</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$types = $conn->query("SELECT l.*,c.name as cname FROM parking_locations l inner join category c on c.id = l.category_id order by l.id asc");
								while($row=$types->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										 <p> <b><?php echo $row['cname'] ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo $row['location'] ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo $row['capacity'] ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary edit_location" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_location" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	$('#new_location').click(function(){
		uni_modal("New Vehicle Location","manage_location.php")
	})
	
	$('.edit_location').click(function(){
		uni_modal("Edit Vehicle Location","manage_location.php?id="+$(this).attr('data-id'))
		
	})
	$('.delete_location').click(function(){
		_conf("Are you sure to delete this Location?","delete_location",[$(this).attr('data-id')])
	})
	
	function delete_location($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_location',
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