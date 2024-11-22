<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM parking_locations where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<div class="container-fluid">
	<form action="" id="manage-location">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id :'' ?>">
		<div class="form-group">
			<label for="" class="control-label">Vehicle Category</label>
			<select name="category_id" id="category_id" class="custom-select select2">
								<option value=""></option>
								<?php
									$category = $conn->query("SELECT * FROM category order by name asc");
									while($row= $category->fetch_assoc()):
								?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($category_id) && $category_id == $row['id'] ? 'selected' : '' ?> data-rate="<?php echo $row['rate'] ?>"><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
							</select>
			</div>
		<div class="form-group">
			<label for="" class="control-label">Area Location</label>
			<input type="text" class="form-control" name="location"  value="<?php echo isset($location) ? $location :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Area Capacity</label>
			<input type="number" class="form-control text-right" name="capacity" step="any"  value="<?php echo isset($capacity) ? $capacity :'' ?>" required>
		</div>
	</form>
</div>
<script>
	$('#manage-location').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_location',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					$('#msg').html("<div class='alert alert-danger'>Name already exist.</div>")
					end_load()

				}
			}
		})
	})
</script>