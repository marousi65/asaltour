<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/gcms/admin-gcms/cssjava/help.css" rel="stylesheet" type="text/css">
<title>راهنمای سیستم مدیریت محتوای وب سایت گاتریا</title>
<script type='text/javascript' src='/gcms/admin-gcms/cssjava/nwsltr.js'></script>
<style>
.toggler {
	direction: rtl;
	color: #336699;
	margin: 0;
	padding: 2px 20px;
	border-bottom: 0px solid #ddd;
	font-size: 11px;
	font-weight: normal;
	font-family: tahoma, arial, sans-serif;
	cursor: pointer;
	font-weight:bold;
}

.element {
	padding: 30px 20px 30px 20px;
	background: #fafafa;
	font-size:11px;
	font-weight:normal
}

.sty {
	margin: 10px;
}

.element p {
	margin: 0;
	padding: 4px;
}

.float-right {
	padding: 10px 20px;
}

blockquote {
	text-style: italic;
	padding: 5px 0 5px 30px;
}
</style>
</head>

<body>
	<center>
<div id="top" >
</div>
<div id='head' >
<div id='mainbody' >
<!-- -->
<table border="0" width="100%" height="100%" >
    <tr valign="top" height="100%">
        <td width="150"  height="100%">
<?php include_once 'menu.php'; ?>
        </td>
        <td height="100%">
            <div id="topcenter" >
            	<div class="txt">
                فید - RSS
                </div>
            </div>
                <div id="bgcen">
                	<div class="txt" >
						<a name="0"></a>
                        <center>
                        <img src="/gcms/admin-gcms/images/helpimg/rss.jpg" width="525" height="97" border="0" style="border: #003366 2px solid" />
                                      </center>

                      <div id='sw_div'></div>
                        	<div id='accordion'>

                            <h3 class='toggler atStart'>
                            <a name="1" >
                            
                            </h3>
                            <div class='element atStart'>

                            &nbsp;&nbsp;&nbsp;&nbsp;<small><a href="#0" >بالای صفحه</a></small>
                            </a>
                            </div>
                            

                                                                                    
                            </div>
            <script type='text/javascript'>
            window.addEvent('domready', function() {
            
                var accordion = new Accordion('h3.atStart', 'div.atStart', {
                    opacity: false,
                    onActive: function(toggler, element){
                        toggler.setStyle('color', '#ff3300');
                        element.addClass('sty');
                    },
            
                    onBackground: function(toggler, element){
                        toggler.setStyle('color', '#336699');
                        element.removeClass('sty');
                    }
                }, $('accordion'));
                
            });
            </script>

                   	</div>
            </div>
                <div id="dwcen">
                </div>
        </td>
    </tr>
</table>

<!-- -->
</div>
</div>
<div id="bodydown" >
<div id="copyrgh" >
تمامی حقوق این نرم افزار مربوط به شرکت گاتریا می باشد.<br />
Powered by GCMS <big><big>V</big></big>1.1  <a href="http://www.lengehdesign.com/" target="_blank" title="lengehdesign">lengehdesign.com</a>
 &copy; 2009
</div>
</div>
<div id="downhead" ></div>

	</center>


</body>
</html>
