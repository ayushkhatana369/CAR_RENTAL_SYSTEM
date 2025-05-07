<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$email = $_SESSION['login'];

$sql = "DELETE FROM tblusers WHERE EmailId = :email";
$query = $dbh->prepare($sql);
$query->bindParam(':email', $email, PDO::PARAM_STR);

if ($query->execute()) {
    session_destroy();
    echo "<script>alert('Account deleted successfully.'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Something went wrong. Try again later.'); window.location='index.php';</script>";
}
?>
