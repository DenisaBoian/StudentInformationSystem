<?php
    //session_start();
    $materie = "";
    $credite = "";
    $id = 0;
    $edit_state = false;

    include_once "dbconnection.php";
    
    if(isset($_POST['save'])){
        $materie = $_POST['materie'];
        $credite = $_POST['credite'];
        
        $query = "INSERT INTO Users (materie, credite) VALUES(:umaterie, :ucredite)";
        $stmt = $conn->prepare( $query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array('umaterie'=>$materie, 'ucredite'=>$credite));
        header('location: student_page.php');
    }
    // update records
    if(isset($_POST['update'])){
        print_r($_POST);
        $materie = $_POST['materie'];
        $credite = $_POST['credite'];
        $id = $_POST['id']; 

        $query = "UPDATE Users SET materie=:umaterie, credite=:ucredite WHERE id=:uuid";
        $stmt = $conn->prepare($query);
        $stmt->execute(array('umaterie'=>$materie, 'ucredite'=>$credite, 'uuid'=>$id));
        $_SESSION['msg'] = "credite updated";
        header('location: student_page.php');
        
    }
    //retrieve records
    $queryS = "SELECT * FROM Users WHERE Nume='Adrian' ";
    $stmt = $conn->prepare( $queryS, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    
?>