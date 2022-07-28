<?php
//    var_dump($_POST);
//    die();
    session_start();
    require '../back-end/clsConnection.php';
    if(isset($_POST['actionbtn']) == "create_session" && isset($_POST['user_id']) != ""){
        $_SESSION['user_id']= $_POST['user_id'];
        $query = "SELECT * from voter where student_id=?";
        $xstmt= $conn->prepare($query);
        $xstmt->execute([$_POST['user_id']]);
        $xdata = $xstmt->fetch();
        $_SESSION['auth_level'] = $xdata['auth_level'];
        $_SESSION['user_information'] = $xdata;
     

        header("Location: ../dashboard.php", TRUE, 301);
        exit();
    }
    if(isset($_POST['actionbtn']) == "admin_login" && isset($_POST['admin']) != ""){
        $_SESSION['admin_id']= $_POST['admin'];
        $query = "SELECT * from `admin` where admin_id=?";
        $xstmt= $conn->prepare($query);
        $xstmt->execute([$_POST['admin']]);
        $xdata = $xstmt->fetch();
        $_SESSION['auth_level'] = $xdata['admin_level'];
        $_SESSION['admin_information'] = $xdata;

        header("Location: ../dashboard.php", TRUE, 301);
        exit();
    }

?>