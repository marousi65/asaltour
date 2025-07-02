<?PHP
session_start();
error_reporting(E_ALL ^ E_NOTICE);
if ( $_SESSION["initiated"] == 0 )
{
    die(header("Location: /gcms/admin-gcms/"));
}
?>

