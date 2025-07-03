<?php

if ($_SESSION['g_id_login'] != 0){

$gcms->assign('g_id_login',"$_SESSION[g_id_login]"); 
$gcms->assign('g_ip_login',"$_SESSION[g_ip_login]"); 
$gcms->assign('g_t_login',"$_SESSION[g_t_login]"); 
$gcms->assign('g_name_login',"$_SESSION[g_name_login]"); 
$gcms->assign('g_email_login',"$_SESSION[g_email_login]"); 
if ($_SESSION[g_t_login] == "agency" ){
if ($_SESSION[g_customer_id_buy]){
$gcms->assign('g_customer_name_buy',"$_SESSION[g_customer_name_buy]");
}
$numberformatg_agency_credit = number_format($_SESSION[g_agency_credit]);
$gcms->assign('g_agency_credit',"$numberformatg_agency_credit");
$numberformatg_agency_use = number_format($_SESSION[g_agency_use]);
$gcms->assign('g_agency_use',"$numberformatg_agency_use");
$baghimande_poll = number_format($_SESSION[g_agency_credit] - $_SESSION[g_agency_use]) ;
$gcms->assign('baghimande_poll',"$baghimande_poll");
$numberformatg_agency_use = number_format($_SESSION[g_agency_use]);
$gcms->assign('g_agency_name',"$_SESSION[g_agency_name]"); 
}
}else{
$gcms->assign('g_id_login',"$_SESSION[g_id_login]"); 
}

?>	
	
