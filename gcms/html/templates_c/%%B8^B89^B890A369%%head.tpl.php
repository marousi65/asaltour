<?php /* Smarty version 2.6.7, created on 2010-09-14 21:50:06
         compiled from index/head.tpl */ ?>
<head>
<title><?php echo $this->_tpl_vars['title']; ?>
 - <?php echo $this->_tpl_vars['page_title']; ?>
</title>
<link rel="icon" href="/gcms/images/favicon.ico" type="image/x-icon" />
	<!-- metas -->
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta http-equiv="Content-Language" content="<?php echo $this->_tpl_vars['language']; ?>
" />
	<meta name="description" content="<?php echo $this->_tpl_vars['description']; ?>
" />
	<meta name="keywords" content="<?php echo $this->_tpl_vars['keyword']; ?>
  <?php echo $this->_tpl_vars['newskeyword']; ?>
" />
    <meta name="Author" content="Gcms-Gatriya.com">
	<!-- /metas -->
<script language='Javascript' type='text/javascript' src='/gcms/js/validform.js'>
</script>
<script language="JavaScript" type="text/javascript" src="/gcms/js/farsitype.js"></script>
<script language="JavaScript" type="text/javascript" src="/gcms/js/validNum.js"></script>
    <!-- Framework CSS -->
    <link rel="stylesheet" type="text/css" href="/gcms/css/jqueryslidemenu.css" />
    <link rel="stylesheet" type="text/css" href="/gcms/css/defgcms.css" />
    <link rel="stylesheet" type="text/css" href="/gcms/css/table.css" />
    <?php echo '
<!--[if lte IE 7]>
<style type="text/css">
html .jqueryslidemenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->
	'; ?>

	<?php if ($_GET['report'] == 'nlist'): ?>

	<script src="/gcms/js/FormManager.js"></script>
    <?php echo '
	<script type="text/javascript">
	window.onload = function() {
		setupDependencies(\'report\'); //name of form(s). Seperate each with a comma (ie: \'weboptions\', \'myotherform\' )
	  };
	</script>
	'; ?>

	<?php endif; ?>

<script type="text/javascript" src="/gcms/js/jquery.min.js"></script>
<script type="text/javascript" src="/gcms/js/jqueryslidemenu.js"></script>
    <link rel="stylesheet" href="/gcms/css/style.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="/gcms/css/screen.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="/gcms/css/print.css" type="text/css" media="print" />
    <!--[if lt IE 8]><link rel="stylesheet" href="/gcms/css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
	<!--[if IE 6]><link href="/gcms/css/ie6fix.css" rel="stylesheet" type="text/css" /><![endif]-->
  	
    <link rel="stylesheet" type="text/css" href="/gcms/css/tabcontent.css" />

<script type="text/javascript" src="/gcms/js/tabcontent.js">

/***********************************************
* Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<?php echo '
  <script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location=\'"+selObj.options[selObj.selectedIndex].value+"\'");
  if (restore) selObj.selectedIndex=0;
}
//-->
  </script>
  '; ?>

  
  <?php echo '
  <style type="text/css">

#dhtmltooltip{
position: absolute;
left: -300px;
width: 150px;
border: 1px solid black;
padding: 2px;
background-color: lightyellow;
visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}

</style>
<script type="text/javascript">

/***********************************************
* Cool DHTML tooltip script II- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetfromcursorX=12 //Customize x offset of tooltip
var offsetfromcursorY=10 //Customize y offset of tooltip

var offsetdivfrompointerX=10 //Customize x offset of tooltip DIV relative to pointer image
var offsetdivfrompointerY=14 //Customize y offset of tooltip DIV relative to pointer image. Tip: Set it to (height_of_pointer_image-1).

document.write(\'<div id="dhtmltooltip"></div>\') //write out tooltip DIV
document.write(\'<img id="dhtmlpointer" src="/gcms/images/arrow2.gif">\') //write out pointer image

var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

var pointerobj=document.all? document.all["dhtmlpointer"] : document.getElementById? document.getElementById("dhtmlpointer") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thewidth, thecolor){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var nondefaultpos=false
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20
var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20

var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX
var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY

var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000

//if the horizontal distance isn\'t enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth){
//move the horizontal position of the menu to the left by it\'s width
tipobj.style.left=curX-tipobj.offsetWidth+"px"
nondefaultpos=true
}
else if (curX<leftedge)
tipobj.style.left="5px"
else{
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetfromcursorX-offsetdivfrompointerX+"px"
pointerobj.style.left=curX+offsetfromcursorX+"px"
}

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight){
tipobj.style.top=curY-tipobj.offsetHeight-offsetfromcursorY+"px"
nondefaultpos=true
}
else{
tipobj.style.top=curY+offsetfromcursorY+offsetdivfrompointerY+"px"
pointerobj.style.top=curY+offsetfromcursorY+"px"
}
tipobj.style.visibility="visible"
if (!nondefaultpos)
pointerobj.style.visibility="visible"
else
pointerobj.style.visibility="hidden"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
pointerobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=\'\'
tipobj.style.width=\'\'
}
}

document.onmousemove=positiontip

</script>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location=\'"+selObj.options[selObj.selectedIndex].value+"\'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
  '; ?>


<script type='text/javascript' src='/gcms/js/formfieldlimiter.js'>

/***********************************************
* Form field Limiter v2.0- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Project Page at http://www.dynamicdrive.com for full source code
***********************************************/

</script>