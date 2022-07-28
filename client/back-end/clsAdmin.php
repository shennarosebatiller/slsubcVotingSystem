<?php
    require 'clsConnection.php';
    require 'includeFunctions.php';
    header( "Content-type: application/json" );

    if($_POST['action'] == 'log_in'){
        $xdata_info = [];
        if($_POST['type'] == "standard"){
            $username = $_POST['student_id'];
            $password = $_POST['password'];
        }
        else if($_POST['type'] == "qrcode"){
            $credentials = $_POST["data"];
            $credentials = explode("SLSUVOTER",$credentials);
            $username = $credentials[0];
            $password = $credentials[1];
        }
        if($username == 'admin'){
            $sql = "SELECT * from admin where `username` =? AND `password` =?";
            $xstmt = $conn->prepare($sql);
            $xstmt->execute([ $username,  $password]);
            $xdata = $xstmt->fetch();
            if($xdata){
                // var_dump($xdata);
                $xdata_info['admin'] = $xdata['admin_id'];
                $xdata_info['auth_level'] = $xdata['admin_level'];
                $xdata_info['Success'] = true;
                echo json_encode($xdata_info);
            }
            else{
                echo json_encode("Error");
            }

        }else{
            $sql = "SELECT * from voter where student_no='".$username."' AND `password`='".$password."'";
            $xstmt = $conn->prepare($sql);
            $xstmt->execute();
            $xdata = $xstmt->fetch();
            if($xdata){
                $xdata_info['image_location'] = $xdata['image'];
                $xdata_info['id'] = $xdata['student_id'];
                $xdata_info['contact_no'] = $xdata['contact_no'];
                $xdata_info['Success'] = true;
                echo json_encode($xdata_info);
            }
            else{
                echo json_encode("Error");
            }
        }
    }

    if($_POST['action'] == "sendOTP"){
        
        $OTP = rand(10000,99999);
        $xdata['OTP'] = $OTP;
        $xdata['Success'] = true;
        // // $xdata['OTP'] = $OTP;
        // $number = $_POST['contact_no'];
        // $message = "Hi there ! Here's your OTP :$OTP";
        // // $apicode = "TR-ONLIN776329_6EVZJ";
        // // $passwd = 'iga$td]7an';
        // $status = itexmo($number,$message,$apicode,$passwd);
        // // var_dump($status);
        // if($status != "0"){
        //     echo json_encode("Error code 97: OTP failed to send, please contact the administrator !");
        // }
        // else{
        //     echo json_encode($xdata);
        // }
        echo json_encode($xdata);
    }

    if($_POST['action'] == "validate_otp"){
        if($_POST['otp_user'] == $_POST['otp']){
            $xdata['Success'] = true;
            echo json_encode($xdata);
        }
       
    }

    function itexmo($number,$message,$apicode,$passwd)
    {
        $ch = curl_init();
        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
        curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($itexmo));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec ($ch);
        curl_close ($ch); 

    }
 

?>