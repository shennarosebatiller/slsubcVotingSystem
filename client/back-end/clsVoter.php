<?php 
    session_start();
    require 'clsConnection.php';
    header( "Content-type: application/json" );
    
    if($_POST['action'] == 'add_voter'){
        $xparams = $_POST['txt_voter'];
        $xparams['auth_level'] = '1';
        $xdata = readyQueryAdd($xparams, "voter", $conn);
        if($xdata == "Success"){
            echo json_encode('Success');
        }
    }

    if($_POST['action'] == 'display_list'){
        $xdata = readtQueryDisplayList("voter", $conn);
        echo json_encode($xdata);
    }
    if($_POST['action'] == 'delete_item'){
        $xdata  = explode(",",$_POST['items']);
        $errors = [];
        foreach ($xdata as $value) {
            $xparams['student_id'] = $value;
            $status  = readyQueryDeleteItem( $xparams,"voter", $conn);
            if(!$status){
                array_push($errors,"error : ".$status);
            }
        }
        if(count($errors) <= 0 ){
            echo json_encode("Success");
        }else{
            echo json_encode("Failed");
        }
        

    }
    if($_POST['action'] == 'get_selectedItem'){
        $xparams['student_id'] = $_POST['id'];
        $xdata=readyQueryGetItem($xparams, 'voter',$conn);
        echo json_encode($xdata);
    }
    if($_POST['action'] == 'upload_image'){
        if($_FILES){
            $target_location = "./userphotos/";
            $file_name = $_FILES['file']['name'];
            $target_file = $target_location.basename($_FILES['file']['name']);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" ){
                if(move_uploaded_file($_FILES["file"]["tmp_name"], ".".$target_file)){
                    echo json_encode($target_file);
                }
            }
        }
    }
    if($_POST['action'] == 'apply_candidacy'){
        $xparams['election_id'] = $_POST['apply_cand']['election'];
        $xparams['position_id'] = $_POST['apply_cand']['position'];
        $xparams['student_id'] = $_POST['apply_cand']['stud_id'];
        $xparams['reason'] = $_POST['apply_cand']['reason'];
        $xdata = readyQueryAdd($xparams, "candidate_request", $conn);
        
    }
    if($_POST['action'] == 'check_application'){
        $xparams['election_id'] = $_POST['election'];
        $xparams['student_id'] = $_POST['stud_id'];
        $xdata = check_count($xparams, "candidate_request", $conn);
        if($xdata[0] > 0 ){
            echo json_encode(true);
        }
        else{
            echo json_encode(false);
        }
    }
    if($_POST['action'] == "submit_vote"){
        date_default_timezone_set("Asia/Manila");
        $xparams['date'] =  date('Y-m-d');
        $xparams['time'] =  date("h:i:sa");
        $xparams['student_id'] = $_SESSION['user_id']; 
        $xparams['election_id'] =  $_POST['election_id'];
        $xdata = readyQueryAdd($xparams, 'ballot', $conn);
        $query_ballot = "SELECT ballot_id from ballot where student_id =? AND election_id =? AND `date`=?";
        $xstmt_ballot = $conn->prepare($query_ballot);
        $xstmt_ballot->execute([$xparams['student_id'],$xparams['election_id'], $xparams['date']]);
        $xdata_ballot = $xstmt_ballot->fetch();
        $candidate = $_POST['txt_voter'];
        foreach ($candidate as $key => $value) {
            $query = "INSERT INTO voter_vote (candidate_id, ballot_id) VALUES ('$value','$xdata_ballot[0]')";
            $xstmt= $conn->prepare($query);
            $xstmt->execute();
        }
      
    }
    if($_POST['action'] == 'get_status'){
        $query = "SELECT * from ballot where student_id=? AND election_id=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$_POST['student_id'], $_POST['election_id']]);
        $xdata = $stmt->fetch();
        if($xdata){
            echo json_encode("Voted");
        }
        else{
            echo json_encode("No Yet");
        }
    }
    if($_POST['action'] == 'validate_election_date'){
        $xparams['election_id'] = $_POST['election_id'];
        $data = readyQueryGetItem($xparams, 'election', $conn);
        var_dump($data);
    }
    function check_count($xparams,$table,$conn){
        $xfields = "";
        $values = "" ;
        foreach ($xparams as $key => $value) {
            if($value != ''){
                $xfields .= "$key=?,";
                $values .= "$value,";
            }
        }
        $xfields = rtrim($xfields, ",");
        $values = rtrim($values, ",");
        $query = "SELECT count(*) from $table where $xfields";
        $xstmt = $conn->prepare($query);
        $xstmt->execute([$values]);
        $xdata = $xstmt->fetch();
        return $xdata;
    }
    function readyQueryAdd($xparams, $table,$conn){
        $xfields = "";
        $values = "" ;
        foreach ($xparams as $key => $value) {
            if($value != ''){
                $xfields .= "$key,";
                $values .= "'$value',";
            }
        }
        $xfields = rtrim($xfields, ",");
        $values = rtrim($values, ",");
        try {
            $query = "INSERT INTO $table ($xfields) VALUES ($values)";
            $xstmt = $conn->prepare($query);
            $xstmt->execute();          
            return 'Success'; 
        }catch(PDOException $e) {
            return  $e->getMessage();
        }
    }
    function readtQueryDisplayList($table,$conn){
        $sql = "SELECT * from $table";
        $xstmt = $conn->prepare($sql);
        $xstmt->execute();
        $xdata = $xstmt->fetchAll();
        return $xdata;
    }
    function readyQueryDeleteItem($xparams, $table,$conn){
        try{
            $sql = "DELETE FROM $table where student_id = ? ";
            $xstmt = $conn->prepare($sql);
            $xstmt->execute([$xparams['student_id']]);
            return "Success";
        }catch (PDOException $e){
            // echo  $e->getMessage();
            return false;
        }
    }
    function readyQueryGetItem($xparams, $table,$conn){
        $xfields = "";
        $values = "" ;
        foreach ($xparams as $key => $value) {
            if($value != ''){
                $xfields .= "$key=?";
                $values .= "$value";
            }
        }
        $sql = "SELECT * from $table where $xfields";
        $xstmt = $conn->prepare($sql);
        $xstmt->execute([$values]);
        $xdata = $xstmt->fetch();
        return $xdata;
    }


?>