<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		$chk = $this->db->query("Select * from users where username = '$username' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", rate = '$rate' ";
		$cwhere ='';
		if(!empty($id)){
			$cwhere = " and id != $id ";
		}
		$chk =  $this->db->query("SELECT * FROM category where  name = '$name' ".$cwhere)->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO category set ".$data);
		}else{
			$save = $this->db->query("UPDATE category set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM category where id = ".$id);
		if($delete)
			return 1;
	}
	
	function save_location(){
		extract($_POST);
		$data = " location = '$location' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", capacity = '$capacity' ";
		$cwhere ='';
		if(!empty($id)){
			$cwhere = " and id != $id ";
		}
		$chk =  $this->db->query("SELECT * FROM parking_locations where  location = '$location' ".$cwhere)->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO parking_locations set ".$data);
		}else{
			$save = $this->db->query("UPDATE parking_locations set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_location(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM parking_locations where id = ".$id);
		if($delete)
			return 1;
	}
	function save_vehicle(){
		extract($_POST);
		$data = " category_id = '$category_id' ";
		$data .= ", location_id = '$location_id' ";
		$data .= ", vehicle_brand = '$vehicle_brand' ";
		$data .= ", vehicle_registration = '$vehicle_registration' ";
		$data .= ", vehicle_description = '$vehicle_description' ";
		$data .= ", owner = '$owner' ";
		$i = 1;
		$ref_no = mt_rand(1000000000,9999999999);
		while($i == 1){
			$chk = $this->db->query("SELECT * from parked_list where ref_no = '$ref_no' ")->num_rows;
			if($chk <= 0)
				$i =0;
		}
		
		$data .= ", ref_no = '$ref_no' ";

		if(empty($id)){
			$save = $this->db->query("INSERT INTO parked_list set ".$data);
			if($save){
				$id = $this->db->insert_id;
				$park = $this->db->query("INSERT INTO parking_movement set pl_id = $id ");
			}
		}else{
			$save = $this->db->query("UPDATE parked_list set ".$data." where id=".$id);
		}
		if($save){

			return json_encode(array("status"=>1,"id"=>$id));
		}
	}
	function delete_vehicle(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM parked_list where id = ".$id);
		if($delete){
				return 1;$this->db->query("DELETE FROM parking_movement where pl_id = ".$id);
			}
	}
	function checkout_vehicle(){
		extract($_POST);
		$data = " pl_id = $pl_id ";
		$data .=", created_timestamp='$created_timestamp' ";
		$data .=", status=2 ";
		$save = $this->db->query("INSERT INTO parking_movement set ".$data);
		if($data){
			$data = " amount_tendered = '$amount_tendered' ";
			$data .=", amount_due='$amount_due' ";
			$data .=", amount_change='$amount_change' ";
			$data .=", status=2 ";
			$this->db->query("UPDATE parked_list set $data where id = $pl_id");
			return 1;
		}
	}
}