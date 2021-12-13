<?php
    $dsn = 'sqlsrv:server=DESKTOP-RKFF17M;database=CatalogOnline';
    $user = '';
    $pass = '';

    try {
       $conn = new PDO($dsn, $user, $pass);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
     echo ("Error connecting to SQL Server: " . $e->getMessage());
 }
?>