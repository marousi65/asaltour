/********************************************************************
 * openWYSIWYG settings file Copyright (c) 2006 openWebWare.com
 * Contact us at devs@openwebware.com
 * This copyright notice MUST stay intact for use.
 *
 * $Id: wysiwyg-settings.js,v 1.4 2007/01/22 23:05:57 xhaggi Exp $
 ********************************************************************/

/*
 * Full featured setup used the openImageLibrary addon
 */
var full = new WYSIWYG.Settings();
//full.ImagesDir = "images/";
//full.PopupsDir = "popups/";
//full.CSSFile = "styles/wysiwyg.css";
full.Width = "250px"; 
full.Height = "50px";
// customize toolbar buttons
full.addToolbarElement("font", 3, 1); 
full.addToolbarElement("fontsize", 3, 2);
full.addToolbarElement("headings", 3, 3);
// openImageLibrary addon implementation
full.ImagePopupFile = "/gcms/admin-gcms/editor/addons/imagelibrary/insert_image.php";
full.ImagePopupWidth = 600;
full.ImagePopupHeight = 245;
full.DefaultStyle = "font-family: tahoma; font-size: 12px; background-color:#FFFFFF ;text-align:right; direction:rtl; cursor:text ;";
/*
 * Small Setup Example
 */
var small = new WYSIWYG.Settings();
small.Width = "350px";
small.Height = "100px";
small.DefaultStyle = "font-family: tahoma; font-size: 12px; background-color:#FFFFFF ;text-align:right; direction:rtl; cursor:text ;  ";
small.Toolbar[0] = new Array("font", "fontsize", "bold", "italic", "underline" , "viewSource"); // small setup for toolbar 1
small.Toolbar[1] = ""; // disable toolbar 2
small.StatusBarEnabled = false;
