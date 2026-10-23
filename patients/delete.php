<?php
include '../config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM patients  WHERE  patient_id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
header("location :list.php");

?>