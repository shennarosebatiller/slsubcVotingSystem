<?php
    $data = $_POST['src'];
    // $uri =  explode(',',$data);
    // $sample = array_pop($uri);
    // $decode = base64_decode($sample);
    $img = str_replace('data:image/png;base64,', '', $data);
    $img = str_replace(' ', '+', $img);
    $data_1 = base64_decode($img );
    file_put_contents('../../tmp/qr_code.png',$data_1  );
    // file_put_contents("file.png",file_get_contents("data://".$uri ));
    // if(file_exists('wow.png')){
    //     header("Content-Type: application/force-download");
    //     header('Content-Disposition: attachment; filename="wow.png"');
    // }

?>