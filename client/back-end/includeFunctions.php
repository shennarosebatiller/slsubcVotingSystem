<?php

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
    $xfields = "";
    $values = "" ;
    foreach ($xparams as $key => $value) {
        if($value != ''){
            $xfields .= "$key";
            $values .= "$value";
        }
    }
    try{
        $sql = "DELETE FROM $table where $xfields= ? ";
        $xstmt = $conn->prepare($sql);
        $xstmt->execute([$values]);
        
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
            $xfields .= "$key";
            $values .= "$value";
        }
    }
    $sql = "SELECT * from $table where $xfields=?";
    $xstmt = $conn->prepare($sql);
    $xstmt->execute([$values]);
    $xdata = $xstmt->fetch();
    return $xdata;
}

?>