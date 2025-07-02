<?php
if ($pluginsetup[poll]){

if ( !$pollmessage ){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mainpoll.php';
	}		
			$gcms->display("index/index.tpl");
	
}else {
	echo "
		<script>
		window.location='?part=page&id=$configset[first_page]';
		</script>
	";
}
?>