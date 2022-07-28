<?php
    require 'clsConnection.php';
    require 'includeFunctions.php';
    header( "Content-type: application/json" );

    if($_POST['action'] == "add_election"){
        $xparams['title'] = $_POST['txt_election']['title'];
        $xparams['SY'] = $_POST['txt_election']['fromSY']."-".$_POST['txt_election']['toSY'];
        $xparams['start_date'] = $_POST['txt_election']['fromDate'];
        $xparams['end_date'] = $_POST['txt_election']['fromDate'];
        $xparams['admin_id'] = "1";
        $xdata = readyQueryAdd($xparams, "election", $conn);
        echo json_encode($xdata);
    
    }
    if($_POST['action'] == 'display_list'){
        $xdata = readtQueryDisplayList("election", $conn);
        echo json_encode($xdata);
    }
    if($_POST['action'] == "delete_item"){
        $xdata  = explode(",",$_POST['items']);
        $errors = [];
        foreach ($xdata as $value) {
            $xparams['election_id'] = $value;
            $status  = readyQueryDeleteItem( $xparams,"election", $conn);
            if($status != "Success"){
                array_push($errors,"error : ".$status);
            }
        }
        if(count($errors) <= 0 ){
            echo json_encode("Success");
        }else{
            echo json_encode(false);
        }
    }
?>