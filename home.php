<?php include 'db_connect.php' ?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    color: #FDEDEC;
}
</style>

<div class="containe-fluid">
    <div class="row mt-3 mb-3 pl-5 pr-5">
        <div class="col-md-4 offset-md-2">
            <div class="card bg-warning">
                <div class="card-body text-white">
                    <span class="float-right summary_icon"><i class="fa fa-car"></i></span>
                    <h4><b>
                        <?php echo $conn->query("SELECT * FROM parked_list where status = 1")->num_rows; ?>
                    </b></h4>
                    <p><b>Total Parked Vehicle</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success">
                <div class="card-body text-white">
                    <span class="float-right summary_icon"><i class="fa fa-car"></i></span>
                    <h4><b>
                        <?php echo $conn->query("SELECT * FROM parked_list where status = 2")->num_rows; ?>

                    </b></h4>
                    <p><b>Total Checked-Out Vehicle</b></p>
                </div>
            </div>
        </div>
    </div>

	<div class="row mt-3 ml-3 mr-3">
			<div class="col-lg-12">
    			<div class="card">
    				<div class="card-body">
    				<?php echo "Welcome back ". $_SESSION['login_name']."!"  ?>
    					<hr>	

                        <div class="row">
                            <div class="col-lg-8 offset-2">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="text-center">Parking Area</th>
                                        <th class="text-center">Available</th>
                                    </tr>
                                    <?php
                                    $cat = $conn->query("SELECT * FROM category order by name asc");
                                    while($crow = $cat->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <th class="text-center" colspan="2"><?php echo $crow['name'] ?></th>
                                    </tr>
                                    <?php 
                                  
                                    $location = $conn->query("SELECT * FROM parking_locations where category_id = '".$crow['id']."'  order by location asc");
                                    while($lrow= $location->fetch_assoc()):
                                        $in = $conn->query("SELECT * FROM parked_list where status = 1 and location_id = ".$lrow['id'])->num_rows;
                                        $available = $lrow['capacity'] - ( $in);


                                    ?>
                                    <tr>
                                        <td><?php echo $lrow['location'] ?></td>
                                        <td class="text-center"><?php echo $available ?></td>
                                    </tr>
                                <?php endwhile; ?>
                                <?php endwhile; ?>
                                </table>
                            </div>
                        </div>      			
    				</div>
    				
    				
    		      </div>
                </div>
	</div>
<hr>
<?php if($_SESSION['login_type'] == 2): ?>
<?php 

?>
<script>
    function queueNow(){
            $.ajax({
                url:'ajax.php?action=update_queue',
                success:function(resp){
                    resp = JSON.parse(resp)
                    $('#sname').html(resp.data.name)
                    $('#squeue').html(resp.data.queue_no)
                    $('#window').html(resp.data.wname)
                }
            })
    }
</script>
<div class="row">
    <div class="col-md-4 text-center">
        <a href="javascript:void(0)" class="btn btn-primary" onclick="queueNow()">Next Serve</a>
    </div>
<div class="col-md-4">
    <div class="card">
        <div class="card-header bg-primary text-white"><h3 class="text-center"><b>Now Serving</b></h3></div>
            <div class="card-body">
                <h4 class="text-center" id="sname"></h4>
                <hr class="divider">
                <h3 class="text-center" id="squeue"></h3>
                <hr class="divider">
                <h5 class="text-center" id="window"></h5>
            </div>
        </div>
    </div>
</div>


<?php endif; ?>


</div>
<script>
	
</script>