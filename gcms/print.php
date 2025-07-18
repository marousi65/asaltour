<?php
	session_start();// تست
	error_reporting(E_ALL ^ E_NOTICE);
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/jdf.php';
	$arr_trkh_kharid = explode("-",  $_REQUEST['tarikh_sodor'] );
	$tarikh_sodor = gregorian_to_jalali($arr_trkh_kharid[0] , $arr_trkh_kharid[1] , $arr_trkh_kharid[2] );
	$tarikh_sodor[0] = Convertnumber2farsi($tarikh_sodor[0]);
	$tarikh_sodor[1] = Convertnumber2farsi($tarikh_sodor[1]);
	$tarikh_sodor[2] = Convertnumber2farsi($tarikh_sodor[2]);
	$_REQUEST['seryal'] = Convertnumber2farsi($_REQUEST['seryal']+111111);
	$_REQUEST['mcode'] = Convertnumber2farsi($_REQUEST['mcode']);
	$_REQUEST['tarikh_harkat'] = Convertnumber2farsi($_REQUEST['tarikh_harkat']);
	$_REQUEST['saat_harekat'] = Convertnumber2farsi($_REQUEST['saat_harekat']);
	$_REQUEST['fee'] = Convertnumber2farsi($_REQUEST['fee']);
	$_REQUEST['mess1'] = Convertnumber2farsi($_REQUEST['mess1']);
	$_REQUEST['mess2'] = Convertnumber2farsi($_REQUEST['mess2']);
	$_REQUEST['mess3'] = Convertnumber2farsi($_REQUEST['mess3']);
?>
<head>
<title>پرینت بلیط</title>
<link rel="stylesheet" type="text/css" href="/gcms/css/blpr.css" />
</head>
<body style="font-family:tahoma;" >
<style>
@media print
{
  table { page-break-after:auto }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; page-break-after:auto }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }
}
.pagebreak { page-break-before: always; }
img{
    position: absolute;
    left: 10px;
    z-index: -2;
}
</style>
<!-- 
<table width="600"  >
	<tr valign="top">
		<td valign="top"  width="600" height="221">
		<img style="position:absolute" src="/gcms/images/bg_1.jpg" width="600" height="221" >
		
		<div id='tarikh_sodor' style="position: relative; font-size:11px; border:0px #00FF00 solid; width:75px; height:15px; left:219px; top:2px ; text-align:right;"></div>
		
		<div id='ship_name' style="position:absolute; font-size:11px; border: 0px #00FF00 solid; width:120px; height:15px; left:400px; text-align:right;top:15px ;  overflow:hidden" ></div>
		
		<div id='code_sodor' style="position:absolute; font-size:11px; border: 0px #00FF00 solid; width:120px; height:15px; left:390px; text-align:right; top:35px ; overflow:hidden" ></div>
		
		<div id='seryal1' style="position:absolute; font-size:11px; border: 0px #00FF00 solid; width:70px; height:15px; left:235px; text-align:right; top:30px ; overflow:hidden" ></div>
		
		<div id='fname' style="position:absolute; font-size:11px; border: 0px #00FF00 solid; width:40px; height:15px; left:510px; text-align:right; top:70px ; overflow:hidden" ></div>
		
		<div id='lname' style="position:absolute; font-size:11px; border: 0px #00FF00 solid; width:65px; height:15px; left:385px; text-align:right; top:70px ; overflow:hidden" ></div>
		
		<div id='mcode' style="position:absolute; font-size:11px; border:0px #00FF00 solid; width:100px; height:15px; left:235px; text-align:right; top:70px ; overflow:hidden" ></div>
		
		<div id='mabd' style="position:absolute; font-size:11px; border:0px #00FF00 solid; width:40px; height:15px; left:515px; text-align:right; top:110px ; overflow:hidden" ></div>
		
		<div id='maghsd' style="position:absolute; font-size:11px; border:0px #00FF00 solid; width:40px; height:15px; left:450px; text-align:right; top:110px ; overflow:hidden" ></div>
		
		<div id='tarikh_harkat' style="position:absolute; font-size:11px; border:0px #00FF00 solid; width:50px; height:15px; left:345px; text-align:right; top:110px ; overflow:hidden" ></div>
		
		<div id='saat_harekat' style="position:absolute; font-size:11px; border:0px #00FF00 solid; width:50px; height:15px; left:235px; text-align:right; top:110px ; overflow:hidden" ></div>
		
		<div id='fee' style="position:absolute; font-size:11px; border:0px #00FF00 solid; width:90px; height:15px; left:460px; text-align:right; top:130px ; overflow:hidden" ></div>
		
		<div id='mess1' style="position:absolute; font-size:11px; border:0px #00FF00 solid; width:250px; height:15px; left:300px; text-align:right; top:145px ; overflow:hidden" ></div>
		
		<div id='mess2' style="position:absolute; font-size:11px; border:0px #00FF00 solid; width:250px; height:15px; left:300px; text-align:right; top:157px ; overflow:hidden" ></div>
		
		<div id='mess3' style="position:absolute; font-size:11px; border:0px #00FF00 solid; width:250px; height:15px; left:300px; text-align:right; top:170px ; overflow:hidden" ></div>
		
		
		<script type="text/javascript">
		document.getElementById('tarikh_sodor').innerHTML = "<?php echo "$tarikh_sodor[0] / $tarikh_sodor[1] / $tarikh_sodor[2]" ?>"
		document.getElementById('ship_name').innerHTML = "<?php echo $_REQUEST['ship_name'] ; ?>"
		document.getElementById('code_sodor').innerHTML = "<?php echo $_REQUEST['code_sodor'] ; ?>"
		document.getElementById('seryal1').innerHTML = "<?php echo $_REQUEST['seryal'] ; ?>"
		document.getElementById('fname').innerHTML = "<?php echo $_REQUEST['fname'] ; ?>"
		document.getElementById('lname').innerHTML = "<?php echo $_REQUEST['lname'] ; ?>"
		document.getElementById('mcode').innerHTML = "<?php echo $_REQUEST['mcode'] ; ?>"
		document.getElementById('mabd').innerHTML = "<?php echo $_REQUEST['mabd'] ; ?>"
		document.getElementById('maghsd').innerHTML = "<?php echo $_REQUEST['maghsd'] ; ?>"
		document.getElementById('tarikh_harkat').innerHTML = "<?php echo $_REQUEST['tarikh_harkat'] ; ?>"
		document.getElementById('saat_harekat').innerHTML = "<?php echo $_REQUEST['saat_harekat'] ; ?>"
		document.getElementById('fee').innerHTML = "<?php echo $_REQUEST['fee'] ; ?>"
		document.getElementById('mess1').innerHTML = "<?php echo $_REQUEST['mess1'] ; ?>"
		document.getElementById('mess2').innerHTML = "<?php echo $_REQUEST['mess2'] ; ?>"
		document.getElementById('mess3').innerHTML = "<?php echo $_REQUEST['mess3'] ; ?>"
		</script>
		</td>
	</tr>
</table>
!-->
<table width="600"  >
	<tr valign="top">
		<td valign="top"  width="600" height="221" background="/gcms/images/bg_1.jpg" style="position: absolute;left:10px;z-index:-2;"><table width="600" height="220" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="220" valign="top">&nbsp;</td>
            <td width="380" valign="top">
			<div class="l1"></div>
			</td>
          </tr>
        </table></td>
	</tr>
</table>
</body>