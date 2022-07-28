<?php
    
?>
<html>
<head>
    <!-- Compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> -->
    <link rel="stylesheet" href="output.css?v=<?php echo time(); ?>">
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="face-api.min.js"></script>
</head>
<style>
    canvas {
        position: absolute;
    }
</style>
<body>
    <div class="main-container" >
        <!-- <button onclick="send_email()">send email</button> -->
        <div class="login-container">
            <div class="login-logo" style="width: 650px;">
                <img src="images/login-xtra (2).png" alt="" srcset="" width="100%">
            </div>
            <div class="login-info" style="width: 320px; padding: 2rem; position: relative;">
                <div class="">
                    <div class="logon-credentials" style="display: flex; flex-direction:column; align-items:center;justify-content:center">
                        <div class="" style="display:flex; align-items:center; margin-bottom:10px; width:250px">
                            <img src="images/school-logo.png" alt="" srcset="" width="80px">
                            <div class="">
                                <h2 style="margin-left: 5px;text-transform:uppercase; line-height:20px">Southern Leyte State</h2>
                                <h1 style="margin: 2px 5px;text-transform:uppercase; line-height:18px">University</h1>
                            </div>
                        </div>
                        <span id="validate_error" style="font-size: 10px;color:red; position:absolute; left: 35px; top: 120px; opacity: 0;">Student id & Password not valid !</span>
                        <div class="login-input" style="width: 100%; margin-top: 10px;">
                            <input type="text" name="txt_login[username]" placeholder="Student ID" id="stud_id" style="border-radius: 2px; width: 100%; margin: 5px 0px;padding: 10px;">
                        </div>
                        <div class="login-input" style="width: 100%">
                            <input type="password" namme="txt_login[password]" placeholder="Password" id="password" style="border:1px solid black ;border-radius: 2px; width: 100%; margin: 5px 0px;padding: 10px;">
                        </div>
                    </div>
                    <br>
                    <div class="login-actions" style="width: 100%; display: flex; justify-content:center;flex-direction: column; align-items:center">
                        <input type="button" value="Login" style="border-radius: 2px;width: 100%;margin: 5px 0px; padding: 10px;"  onclick="Login()">
                        <p style="font-size: 12px;">or</p>
                        <input type="button" value="QR Login" style="border-radius: 2px;width: 100%;margin: 5px 0px;padding: 10px;" onclick="qrLogin()">
                    </div>
                </div>

                <div class="qrcode-container" style="position:absolute; background-color:white; height: 250px ;padding: 1rem 2rem; width: 250px; bottom: 30px; display:flex; flex-direction:column; transform:translateX(100%); opacity: 0;">
                    <video id="preview"></video>
                    <input type="text" id="qrcode_result" hidden>
                    <input type="button" value="Cancel" style="border-radius: 2px;width: 100%;margin: 5px 0px;padding: 10px;" onclick="hideqrLogin()">
                </div>

                <div class="facial_recognition" style="position:absolute; background-color:white; height: 250px ;padding: 1rem 2rem; width: 320px; bottom: 30px;display:flex; flex-direction:column; transform:translateX(100%); opacity: 0;">
                    <video id="myFacial" width="250" height="187.5" autoplay muted></video>
                    <p style="font-size: 8px;">Please avoid moving while facial recognition is in progress</p>
                    <input type="button" value="Cancel" style="border-radius: 2px;width: 100%;margin: 5px 0px;padding: 10px;" onclick="hideFacialRecognition()">
                </div>

                <div class="OTP-container" style="position:absolute; background-color:white; height: 250px ;padding: 1rem 2rem; width: 250px; bottom: 30px; display:flex; flex-direction:column; transform:translateX(100%); opacity: 0;">
                    <p>ENTER ONE TIME PASSWORD</p>
                    <input id="otp_password" type="text" name="txt_filter[qr]" style="width:100%; text-align:center; border-radius:3px; border: 1px solid black; padding: 10px">
                    <input type="button" onclick="validateOTP()" value="Submit" style="border-radius: 2px;width: 100%;margin: 5px 0px;padding: 10px; background-color: #4da6ff">
                    <input type="button" value="Cancel" style="border-radius: 2px;width: 100%;margin: 5px 0px;padding: 10px;" onclick="cancelOTP()">
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="OTP_contains" hidden>
    <input type="text" name="user_id" id="user_id" hidden>
    <input type="text" name="actionbtn" id="action_btn" value="create_session" hidden>
</body>
</html>
<script>
    let otpContainer = document.querySelector('.OTP-container')
    let qrContainer = document.querySelector('.qrcode-container')
    let notification_error = document.querySelector('#validate_error');
    let user_id = document.querySelector('#user_id');
    let facialRecognition = document.querySelector('.facial_recognition');
    const video = document.querySelector('#myFacial')
    let intervalTime ;
    let image_location = '';

    let faceMatcher ;
    Promise.all([
        faceapi.nets.tinyFaceDetector.loadFromUri('./models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('./models'),
        faceapi.nets.faceRecognitionNet.loadFromUri('./models'),
        faceapi.nets.ssdMobilenetv1.loadFromUri('./models')
    ]).then();
   
    
    var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });

    function createVideo(){
        scanner.addListener('scan',function(content){
            setData(content)
            hideqrLogin()
        });
        Instascan.Camera.getCameras()
        .then(function (cameras){
            if(cameras.length>0){
                scanner.start(cameras[0]);
      
            }else{
                console.error('No cameras found.');
                alert('No cameras found.');
            }
        })
    }
    
    function setData(content){
        let xdata = `data=${content}&action=log_in&type=qrcode`; 
        validationLogin(xdata)
    }

    async function sendOTP(no){
        let otp = document.querySelector('#OTP_contains')
        await fetch("client/back-end/clsAdmin.php", {
            method: 'POST',
            headers: {
                'Content-type' : 'application/x-www-form-urlencoded',
            },
            body : `contact_no=${no}&action=sendOTP`
        })
        .then(res => res.json())
        .then(res => {
            if(res['Success'] == true){
                otp.value = res['OTP']
				console.log(res)
            }
            else{
                // notification_error.style.opacity = '1';
            }
        })
    }

    async function validationLogin(xdata){
        await fetch("client/back-end/clsAdmin.php", {
            method: 'POST',
            headers: {
                'Content-type' : 'application/x-www-form-urlencoded',
            },
            body : xdata
        })
        .then(res => res.json())
        .then(res => {
            // console.log(res)
            if(res['Success'] == true){
                // console.log(res['admin'])
                if(res['admin'] != undefined){
                    let newForm = document.createElement("form");
                    let admin = document.createElement("input");
                    let actionbtn = document.getElementById('action_btn')
                    actionbtn.value = "admin_login";
                    admin.setAttribute('type', 'text');
                    admin.setAttribute('name', 'admin');
                    admin.value = res['admin'];
                    newForm.setAttribute("method", "POST")
                    newForm.setAttribute("action", "client/back-end/Redirect.php")
                    newForm.append(actionbtn)
                    newForm.append(admin)
                    document.body.append(newForm)
                    newForm.submit()
                }else{
                    user_id.value = res['id']
                    image_location = res['image_location'];
                    image_location = image_location.replace('.', './client')
                    sendOTP(res['contact_no'])
                    showOTP();
                    notification_error.style.opacity = '0';
                }
               
            }
            else{
                notification_error.style.opacity = '1';
            }
        })
    }

    async function validateOTP(){
        let otp = document.querySelector('#OTP_contains').value
        let otp_user = document.querySelector('#otp_password').value
        let xdata = `otp_user=${otp_user}&otp=${otp}`;
        await fetch("client/back-end/clsAdmin.php", {
            method: 'POST',
            headers: {
                'Content-type' : 'application/x-www-form-urlencoded',
            },
            body : xdata+"&action=validate_otp"
        })
        .then(res => res.json())
        .then(res => {
            if(res['Success'] == true){
                initFacialRecognition()
                cancelOTP();
               

            }
            else{
                console.log('failed')
            }
        })
    }
    
    function send_email(){
        fetch("mail.php", {
            method : 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : 'test'
        })
        alert("Credentials has been sent to student email!")
    }

    function Login(){
        let student_id = document.querySelector('#stud_id').value
        let password = document.querySelector('#password').value
        let xdata = `student_id=${student_id}&password=${password}&action=log_in&type=standard`; 
        validationLogin(xdata)
    }

    function showOTP(){
        otpContainer.style.transform = "translateX(0%)"
        otpContainer.style.opacity = "1"
        otpContainer.style.transition = ".7s ease-in-out"
        otpContainer.style.zIndex = "200"
    }

    async function initFacialRecognition(){
        facialRecognition.style.transform = "translateX(0%)"
        facialRecognition.style.opacity = "1"
        facialRecognition.style.transition = ".7s ease-in-out"
        facialRecognition.style.zIndex = "100"
       
        startVideo()
    }

    async function startVideo() {
        navigator.getUserMedia(
            {
                video: { },
            },
            (stream) => (video.srcObject = stream),
            (err) => console.error(err) 
        );
        const labeledImages = await fetch_image();
        faceMatcher = new faceapi.FaceMatcher(labeledImages, 0.5)
       
    }
    async function stopFacialRecognition(){
        let stream_video =  await video.srcObject;
        let tracks = stream_video.getTracks();
        tracks.forEach(track => {
            track.stop()
        });
        let canvas = facialRecognition.querySelector('canvas');
        canvas.remove()
        clearInterval(intervalTime)
    }
    
    function hideFacialRecognition(){
        facialRecognition.style.transform = "translateX(100%)"
        facialRecognition.style.opacity = "0"
        stopFacialRecognition()
    }
    
    video.addEventListener('play', async () => {
        const canvas = faceapi.createCanvasFromMedia(video);
        let existing_canvas = facialRecognition.querySelector('canvas');
        if(!existing_canvas || existing_canvas == null){
            facialRecognition.append(canvas);
        }
        const displaySize = { width: video.width, height: video.height };
        faceapi.matchDimensions(canvas, displaySize);
        intervalTime = setInterval(async () => {
            let detections = await faceapi
                .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks().withFaceDescriptors()
            const resizedDetection = faceapi.resizeResults(
                detections,
                displaySize
            );
            canvas
                .getContext('2d')
                .clearRect(0, 0, canvas.width, canvas.height);
            if(resizedDetection){
                // console.log(faceMatchfer) 
                const results = resizedDetection.map(d => {
                    if(d.descriptor){
                        return faceMatcher.findBestMatch(d.descriptor)
                    }
                   
                    // console.log(d)
                }) ;
                results.forEach((result , i) => {  
                    let new_result = result.toString().replace("(", '')
                    new_result = new_result.replace(')', '');
                    let data = new_result.split(" ")
                    const box = resizedDetection[0].detection.box;
                    const drawBox = new faceapi.draw.DrawBox(box, { label : 'verifying ...'});
                    faceapi.draw.drawFaceLandmarks(canvas, resizedDetection);
                    drawBox.draw(canvas)
                    if(data[0] != 'unknown'){
                        if(data[1] <= '0.48'){
                            let newForm = document.createElement("form");
                            let actionbtn = document.getElementById('action_btn')
                            newForm.setAttribute("method", "POST")
                            newForm.setAttribute("action", "client/back-end/Redirect.php")
                            newForm.append(actionbtn)
                            newForm.append(user_id)
                            document.body.append(newForm)
                            newForm.submit()
                        }
                    }
                });
            }
            

        }, 100);
    })

    function fetch_image (){
        const label = ['robert'];
        return Promise.all(
            label.map(async label => {
                const img = await faceapi.fetchImage(`${image_location}`)
                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();
                const descriptors = [new Float32Array(detections.descriptor)]
                return new faceapi.LabeledFaceDescriptors('robert', descriptors)
            })
        )

    }

    function cancelOTP (){
        otpContainer.style.transform = "translateX(100%)"
        otpContainer.style.opacity = "0"
        // otpContainer.style.transition = ".7s ease-in-out"
    }


    function qrLogin(){
        qrContainer.style.transform = "translateX(0%)"
        qrContainer.style.opacity = "1"
        qrContainer.style.transition = ".7s ease-in-out"
        qrContainer.style.zIndex = "100"
        createVideo();
    }
    function hideqrLogin(){
        qrContainer.style.transform = "translateX(100%)"
        qrContainer.style.opacity = "0"
        scanner.stop();
    }
</script>