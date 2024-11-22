<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_category"){
	$save = $crud->save_category();
	if($save)
		echo $save;
}
if($action == "delete_category"){
	$save = $crud->delete_category();
	if($save)
		echo $save;
}
if($action == "save_location"){
	$save = $crud->save_location();
	if($save)
		echo $save;
}
if($action == "delete_location"){
	$save = $crud->delete_location();
	if($save)
		echo $save;
}
if($action == "save_vehicle"){
	$save = $crud->save_vehicle();
	if($save)
		echo $save;
}
if($action == "delete_vehicle"){
	$save = $crud->delete_vehicle();
	if($save)
		echo $save;
}
if($action == "checkout_vehicle"){
	$save = $crud->checkout_vehicle();
	if($save)
		echo $save;
}