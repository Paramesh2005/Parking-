<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM category where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<div class="container-fluid">
	<form action="" id="manage-category">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id :'' ?>">
		<div class="form-group">
			<label for="" class="control-label">Vehicle Category</label>
			<input type="text" class="form-control" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Rate per Hour</label>
			<input type="number" class="form-control text-right" name="rate" step="any"  value="<?php echo isset($rate) ? $rate :'' ?>" required>
		</div>
	</form>
</div>
<script>
	$('#manage-category').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_category',
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