<?php
    require 'clsConnection.php';
    require 'includeFunctions.php';
    header( "Content-type: application/json" );

    if($_POST['action'] == 'add_item'){
        $xparams = $_POST['txtfilter'];
        $xparams['admin_id'] = 1;
        $xdata = readyQueryAdd($xparams, "position", $conn);
        if($xdata == "Success"){
            echo json_encode($xdata);
        }
    }
    if($_POST['action'] == 'display_list'){
        $xdata = readtQueryDisplayList("position", $conn);
        echo json_encode($xdata);
    }
    if($_POST['action'] == 'delete_item'){
        $xdata  = explode(",",$_POST['items']);
        $errors = [];
        foreach ($xdata as $value) {
            $xparams['position_id'] = $value;
            $status  = readyQueryDeleteItem( $xparams,"position", $conn);
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