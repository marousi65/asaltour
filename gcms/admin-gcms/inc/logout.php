<?PHP
session_start();
session_destroy();
header("Location: /gcms/admin-gcms/");
?>