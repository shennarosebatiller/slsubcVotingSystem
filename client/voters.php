<?php
    require 'main.php'
?>
<div class="voters">
    <!-- <h1>Voters</h1> -->
    <div class="list-container">
        <div class="filter">
            <div class="list-filter" style="width: 600px;">
                <h4 style="text-transform: uppercase;">Filter vote status in :</h4>
                <div style="width: 600px;">
                    <select style="font-size:12px;font-weight: normal;width: 385px;" id="election_id" onchange="clearTable()"> 
                        <!-- <option value="default">--Select a election--</option> -->
                        <?php
                            $query_election = "SELECT * from election";
                            $stmt_election = $conn->prepare($query_election);
                            $stmt_election->execute();
                            $xdata = $stmt_election->fetchAll();
                            foreach ($xdata as $key => $value) {
                                echo '<option value='.$value['election_id'].'>'.$value['title'].' '.$value['SY'].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="list-filter" style="width: 600px;">
                <h4 style="text-transform: uppercase;">Filter by name :</h4>
                <div style="display: flex; align-items:center; justify-content:space-between; "> 
                    <input type="text" placeholder="First Name" style="font-size:12px;font-weight: normal;">
                    <input type="text" placeholder="Middle Name">
                    <input type="text" placeholder="Last Name">
                </div>
            </div>
        </div>
        <div class="list-action">
            <input type="button" value="New Voter" id="add-voter-btn">
            <input type="button" value="Delete Voter" onclick="deleteItems();">
            <input type="button" value="View Details" onclick="getSingleItem()">
        </div>
        <div class="list-table">
            <ul id="list-table-headers">
                <li style="display: flex; justify-content:space-between;padding: 10px; margin : 5px 0px;" class="list-headers">
                    <b style="display:none"></b>
                    <h5 style="width:80px">Student No.</h5>
                    <h5 style="width:100px">First Name</h5>
                    <h5 style="width:50px">M.I.</h5>
                    <h5 style="width:100px">Last Name</h5>
                    <h5 style="width:100px">Year</h5>
                    <h5 style="width:100px">Course</h5>
                    <h5 style="width:200px">Address</h5>
                    <h5 style="width:100px">Voting Status</h5>
                </li>
                <hr>
            </ul>
            <ul id="list-table-body">

            </ul>
        </div>
    </div>
</div>
<div class="bg-add-container" style="font-size: 12px; position: fixed;top: 0; left: 0; height: 100%; width: 100%; display:none; justify-content:center; align-items:center;background: rgba(0, 0, 0, 0.5);">
    <form class="add-form">
    <div class="add candidates-container" style="width: 550px; background : #f3f3f3; padding: 1rem; ">
        <div class="add-header">
            <h3>Voter Information</h3>
        </div>
        <hr>
        <hr>
        <div class="add-voter-body">
            <div class="card-step" >
                <div class="" style="display: flex; justify-content:space-between; margin: 10px 5px; flex-wrap:wrap;">
                    <div class="add-input">
                        <h5>First Name :</h5>
                        <input type="text" name="txt_voter[fname]" id="v_fname" style="width: 250px;">
                    </div>
                    <div class="add-input">
                        <h5>Last Name:</h5>
                        <input type="text" name="txt_voter[lname]" id="v_lname" style="width: 250px;">
                    </div>
                    <div class="add-input">
                        <h5>Middle Name :</h5>
                        <input type="text" name="txt_voter[mname]" id="v_mname" style="width: 250px;">
                    </div>
                    <div class="add-input">
                        <h5>Age :</h5>
                        <input type="text" name="txt_voter[age]" id="v_age" style="width: 50px;">
                    </div>
                    <div class="add-input">
                        <h5>Gender :</h5>
                        <select style="width: 150px;" name="txt_voter[gender]" id="v_gender" >
                            <option></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others"> Others</option>
                        </select>
                    </div>
                    <div class="add-input">
                        <h5>Address :</h5>
                        <input type="text" name="txt_voter[address]" id="address" style="width: 250px;">
                    </div>
                    <div class="add-input">
                        <h5>Contact No. :</h5>
                        <input type="text" name="txt_voter[contact_no]" id="v_contact_no" style="width: 250px;">
                    </div>
                    <div class="add-input">
                        <h5>Email :</h5>
                        <input type="email" name="txt_voter[email]" id="v_email" style="width: 250px;">
                    </div>
                    <div class="add-input">
                        <h5>Course :</h5>
                        <select style="width: 350px;" name="txt_voter[course]" id="v_course">
                            <option></option>
							<option value="BSA">Bachelor of Science in Agriculture</option>
							<option value="BSF">Bachelor of Science in Fisheries</option>
                            <option value="BSIT">Bachelor of Science in Information Technology</option>
							<option value="BSMB">Bachelor of Science in Marine Biology</option>
                        </select>
                    </div>
                    <div class="add-input">
                        <h5>Year :</h5>
                        <select style="width: 80px;" name="txt_voter[year]" id="v_year">
                            <option value="1st year">1</option>
                            <option value="2nd year">2</option>
                            <option value="3rd year">3</option>
                            <option value="4th year">4</option>
                        </select>
                    </div>
                </div>
                <hr>
                <hr>
                <div class="add-actions" style="margin-top: 10px;">
                    <input type="button" value="Edit Information" id="v_edit_btn" style="margin-bottom: 10px;" onclick="enableInput()">
                    <input type="button" value="Next" id="voter-multi-next" onclick="nextform()">
                    <input type="button" value="Cancel" id="voter-cancel-form">
                    
                </div>
            </div>
            <div class="card-step" style="height: 400px;">
                <div class="add-input" style="display:flex;flex-direction:column; align-items:center; width: 100%;margin-top: 1rem">
                    <h3>Photo</h3>
                    <img src="https://bit.ly/3ubuq5o" alt=""  style="border: 1px solid black; height: 280px; background-color:white; margin-bottom: 1rem;" id="voter_photo">
                    <input type="file" name="txt_voter_image" onchange="uploadPhoto(this)" style="width: 250px;" accept="image/png, image/gif, image/jpeg" id="photo_file_container" />
                    <input type="text" hidden name="txt_voter[image]" id="v_image" style="width: 250px;" style="display: none;"/>
                </div>
                <br>
                <hr>
                <hr>
                <div class="add-actions" style="margin-top: 10px;">
                    <input type="button" value="Previous" onclick="prevform()">
                    <input type="button" value="Next" onclick="nextform()">   
                </div>
            </div>
            <div class="card-step" style="height: 380px;">
                <div class="" style="display: flex; align-items:center;height:90%; justify-content:center; margin: 5px 5px; flex-direction:column;">
                    <!-- <div class="add-input" style="text-align: center;">
                        <div id="qrcode"></div>
                        <input type="button" value="Download QR CODE" style="margin: 10px 0px;">
                    </div> -->
                    <div class="add-input">
                        <h5>Student ID :</h5>
                        <input type="text" name="txt_voter[student_no]" id="v_stud_id" style="width: 250px">
                    </div>
                    <div class="add-input" >
                        <h5>Password:</h5>
                        <input type="password" name="txt_voter[password]" id="v_password" style="width: 250px;">
                    </div>
                    <div class="add-input" >
                        <h5>Confirm Password:</h5>
                        <input type="password" id="v_confirm_pasword" style="width: 250px;">
                    </div>
                    
                </div>
                <hr>
                <hr>
                <div class="add-actions" style="margin-top: 5px;">
                    <input type="button" value="Previous" onclick="prevform()">
                    <input type="button" value="Next" onclick="nextform(),generateQR()">
                </div>
            </div>
            <div class="card-step" style="height: 380px;">
                <div class="" style="display: flex; align-items:center;height:90%;  justify-content:center; margin: 5px 5px; flex-direction:column;">
                    <div class="add-input" style="text-align: center;">
                        <div id="qrcode"></div>
                        <input type="button" value="Download QR CODE" style="margin: 10px 0px;" onclick="downloadQR()">
                    </div>
                   
                </div>
                <hr>
                <hr>
                <div class="add-actions" style="margin-top: 5px;">
                    <input type="button" value="Previous" onclick="prevform(),removeQr()">
                    <input type="button" value="Done" id="v_btn_add" onclick="addVoter(this)">
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<input type="text" id="student_id" style="display:none">

<script>
    let addVoter_form = document.querySelector(".add-voter-body");
    let multiSteps = [...addVoter_form.querySelectorAll(".card-step")];
    let cancel_form_btn = document.querySelector('#voter-cancel-form');
    let add_form_btn = document.querySelector("#add-voter-btn")
    let add_form = document.querySelector('.bg-add-container')
    let QR = document.getElementById("qrcode");
    let data_list_table = document.querySelector('#list-table-body')
   

    cancel_form_btn.addEventListener('click', () => {
        add_form.style.display = "none"
    })
    add_form_btn.addEventListener('click', () => {
        document.querySelector('#v_btn_add').value = "Done"
        document.querySelector('#v_edit_btn').style.display = "none"
        enableInput();
        clearInput();
        add_form.style.display = "flex"  
    })
    
    if(findActiveStep(multiSteps) < 0){
        multiSteps[0].classList.add("active")
    }
    function clearTable() {
        while (data_list_table.firstChild) {
            data_list_table.removeChild(data_list_table.firstChild);
        }
        getDataList();
    }

    function uploadPhoto(e){
        let [photo] = e.files
        let photo_container = document.getElementById('voter_photo')
        photo_container.src = URL.createObjectURL(photo)
    }

    
    async function addVoter(e){
        let stud_no = document.getElementById('v_stud_id').value
        let fname = document.getElementById('v_fname').value
        let lname = document.getElementById('v_lname').value
        let mname = document.getElementById('v_mname').value
        let age = document.getElementById('v_age').value
        let gender = document.getElementById('v_gender').value
        let address = document.getElementById('address').value
        let contact_no = document.getElementById('v_contact_no').value
        let email = document.getElementById('v_email').value
        let course = document.getElementById('v_course').value
        let year = document.getElementById('v_year').value
        let password = document.getElementById('v_password').value
        let confirm_password = document.getElementById('v_confirm_pasword').value
        if(stud_no == ""){
            alertify.alert('Student No/ID should not be blank !').set('maximizable', false);  
        }
        if(fname == ""){
            alertify.alert('First Name should not be blank !').set('maximizable', false);  
        }
        else if(lname == ""){
            alertify.alert('Last Name should not be blank !').set('maximizable', false);  
        }
        else if(mname == ""){
            alertify.alert('Middle Name should not be blank').set('maximizable', false);  
        }
        else if(age == ""){
            alertify.alert('Age should not be blank').set('maximizable', false);  
        }
        else if(gender == ""){
            alertify.alert('Gender should not be blank').set('maximizable', false);  
        }
        else if(contact_no == ""){
            alertify.alert('Contact should not be blank').set('maximizable', false);  
        }
        else if(email == ""){
            alertify.alert('Email should not be blank').set('maximizable', false);  
        }
        else if(course == ""){
            alertify.alert('Course should not be blank').set('maximizable', false);  
        } 
        else if(year == ""){
            alertify.alert('Year should not be blank').set('maximizable', false);  
        } 
        else if(password == ""){
            alertify.alert('Password should not be blank').set('maximizable', false);  
        } 
        else if(confirm_password == ""){
            alertify.alert('Confirm Password shoud not be blank').set('maximizable', false);  
        } 
        else if( password != confirm_password){
            alertify.alert('Password did not match !').set('maximizable', false);  
        } 
        else{
            let qrcode = document.querySelector('#qrcode canvas').toDataURL();
            saveQR(qrcode)
            let file = document.querySelector('#photo_file_container')
            let data = new FormData();
            data.append("file", file.files[0])
            data.append("action", "upload_image")
            await fetch('back-end/clsVoter.php', {
                method: 'POST',
                body: data
            })
            .then(res_phto => res_phto.json())
            .then(res_phto => {
                
                let photo_input = document.querySelector('#v_image')
                photo_input.value = res_phto;
                let xdata = serializeForm(document.querySelector('.add-form'))
                fetch('back-end/clsVoter.php', {
                    method: 'POST',
                    headers : {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: xdata + '&action=add_voter'
                })
                .then(res => res.json())
                .then(res => {
                    if (res == "Success"){
                        send_mail();
                        add_form.style.display = "none"
                        clearTable();
                        clearInput();
                    }
                })
            })
        }  
    }

    function send_mail(){
        let email = document.querySelector('#v_email').value
        fetch("../mail.php", {
            method: 'POST',
            headers : {
                'Content-type': 'application/x-www-form-urlencoded'
            },
            body : `email=${email}`
        })
        // .then(())
    }
    function saveQR(src){
        fetch("back-end/saveqrcode.php", {
            method : 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : `src=${src}` 
        })
    }
    async function generateQR(){
        let studentID = document.querySelector('#v_stud_id').value;
        let password = document.querySelector('#v_password').value;
        if(studentID == '' || studentID == null){
            studentID = "test";
        }
        let newQR = studentID+'SLSUVOTER'+password
        var qrcode = await new QRCode(QR, {
            text: newQR,
            width: 160,
            height: 160,
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
        qrcode.makeUrl()
    }

    function removeQr(){
        QR.innerHTML = ""
    }

    function prevform(){
        let activeStep = findActiveStep(multiSteps)
        multiSteps[activeStep].classList.remove("active")
        multiSteps[activeStep - 1].classList.add("active")
    }

    function nextform(){
        let activeStep = findActiveStep(multiSteps)
        // generateQR()
        multiSteps[activeStep].classList.remove("active")
        multiSteps[activeStep + 1].classList.add("active")
    }

    function findActiveStep(multiSteps){
        let activeStep = multiSteps.findIndex(step => {
            return step.classList.contains("active")
        })
        return activeStep
    }

   
    function getDataList(){
        fetch('back-end/clsVoter.php', {
            method: 'POST',
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: '&action=display_list'
        })
        .then(res => res.json())
        .then(res => { 
            res.forEach(item => {
                let newItem = "";
                let status_color = "red";
                let election_id = document.querySelector('#election_id');

                fetch('back-end/clsVoter.php', {
                    method: 'POST',
                    headers : {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `election_id=${election_id.value}&student_id=${item['student_id']}&action=get_status`
                })
                .then(res => res.json())
                .then(res => { 
                    if(res == "Voted"){
                        status_color = 'green';
                    }
                    newItem += ` <li style="display: flex; justify-content:space-between; padding: 10px; margin : 5px 0px; cursor:pointer; border-left:5px solid ${status_color}; background-color:#f3f3f3;" onclick="itemFocus(this)">`;
                    newItem += ` <input type="checkbox" style="display:none">`
                    newItem += ` <h5 style="display:none">${item['student_id']}</h5>`
                    newItem += ` <h5 style="width:80px">${item['student_no']}</h5>`
                    newItem += ` <h5 style="width:100px">${item['fname']}</h5>`
                    newItem += ` <h5 style="width:50px">${item['mname']}</h5>`
                    newItem += ` <h5 style="width:100px">${item['lname']}</h5>`
                    newItem += ` <h5 style="width:100px">${item['year']}</h5>`
                    newItem += ` <h5 style="width:100px">${item['course']}</h5>`
                    newItem += ` <h5 style="width:200px">${item['address']}</h5>`
                    newItem += ` <h5 style="width:100px">${res}</h5>`
                    newItem += `</li>`;

                    data_list_table.append(htmlToElement(newItem));   
                });
            });
        })
        
    }

    function deleteItems(){
        let data_items = [...data_list_table.querySelectorAll("input[type='checkbox']")];
        let selected_items = '';
        data_items.forEach((item) => {
            if(item.checked){
                if(item != ''){
                    selected_items += `${item.parentElement.children[1].innerHTML},`
                }
            }
        })
        selected_items = selected_items.slice(0, -1)
        if(selected_items != ''){
            fetch('back-end/clsVoter.php', {
                method : 'POST',
                headers : {
                'Content-type' : 'application/x-www-form-urlencoded' ,
                },
                body: 'items='+ selected_items + '&action=delete_item'
            })
            .then((response) => response.json())
            .then(response => {
                if(response == "Success"){
                    clearTable();
                }
            })
     
        }
    }

    function getSingleItem(){
        let student_id = document.getElementById('student_id')
        let stud_no = document.getElementById('v_stud_id')
        let fname = document.getElementById('v_fname')
        let lname = document.getElementById('v_lname')
        let mname = document.getElementById('v_mname')
        let age = document.getElementById('v_age')
        let gender = document.getElementById('v_gender')
        let address = document.getElementById('address')
        let contact_no = document.getElementById('v_contact_no')
        let email = document.getElementById('v_email')
        let course = document.getElementById('v_course')
        let year = document.getElementById('v_year')
        let password = document.getElementById('v_password')
        let confirm_password = document.getElementById('v_confirm_pasword')
        let photo_input = document.querySelector('#v_image')
        let photo_container = document.getElementById('voter_photo')
      
        disableInput();
        document.querySelector('#v_edit_btn').style.display = "block"

        let data_items = [...data_list_table.querySelectorAll("input[type='checkbox']")];
        let selected_item = [];
        data_items.forEach((item) => {
            if(item.checked){
                if(item != ''){
                    selected_item.push(item.parentElement.children[1].innerHTML)
                }
            }
        })
        if(selected_item.length > 1){
            alertify.alert("Please select one voter only!")
        }
        else if (selected_item.length < 1){
            alertify.alert("No item was selected !")
        }
        else if(selected_item.length == 1){
            add_form.style.display = "flex";
            fetch('back-end/clsVoter.php', {
                method : 'POST',
                headers : {
                'Content-type' : 'application/x-www-form-urlencoded' ,
                },
                body: `id=${selected_item[0]}&action=get_selectedItem`
            })
            .then((response) => response.json())
            .then(response => {
                student_id.value = response['student_id']
                stud_no.value = response['student_no']
                fname.value = response['fname']
                lname.value = response['lname']
                mname.value = response['mname']
                age.value = response['age']
                gender.value = response['gender']
                address.value = response['address']
                contact_no.value = response['contact_no']
                email.value = response['email']
                course.value = response['course']
                year.value = response['year']
                password.value = response['password'];
                photo_input.value = response['image'];
                photo_container.src = response['image'];
            })
        }
    }

    function disableInput(){
        document.getElementById('student_id').disabled = true
        document.getElementById('v_stud_id').disabled = true
        document.getElementById('v_fname').disabled = true
        document.getElementById('v_lname').disabled = true
        document.getElementById('v_mname').disabled = true
        document.getElementById('v_age').disabled = true
        document.getElementById('v_gender').disabled = true
        document.getElementById('address').disabled = true
        document.getElementById('v_contact_no').disabled = true
        document.getElementById('v_email').disabled = true
        document.getElementById('v_course').disabled = true
        document.getElementById('v_year').disabled = true
        document.getElementById('v_password').disabled = true
        document.getElementById('v_confirm_pasword').disabled = true
    }
    function enableInput(){
        document.getElementById('student_id').disabled = false
        document.getElementById('v_stud_id').disabled = false
        document.getElementById('v_fname').disabled = false
        document.getElementById('v_lname').disabled = false
        document.getElementById('v_mname').disabled = false
        document.getElementById('v_age').disabled = false
        document.getElementById('v_gender').disabled = false
        document.getElementById('address').disabled = false
        document.getElementById('v_contact_no').disabled = false
        document.getElementById('v_email').disabled = false
        document.getElementById('v_course').disabled = false
        document.getElementById('v_year').disabled = false
        document.getElementById('v_password').disabled = false
        document.getElementById('v_confirm_pasword').disabled = false
    }
    function clearInput(){
        document.getElementById('student_id').value = ""
        document.getElementById('v_stud_id').value = ""
        document.getElementById('v_fname').value = ""
        document.getElementById('v_lname').value = ""
        document.getElementById('v_mname').value = ""
        document.getElementById('v_age').value = ""
        document.getElementById('v_gender').value = ""
        document.getElementById('address').value = ""
        document.getElementById('v_contact_no').value = ""
        document.getElementById('v_email').value = ""
        document.getElementById('v_course').value = ""
        document.getElementById('v_year').value = ""
        document.getElementById('v_password').value = ""
        document.getElementById('v_confirm_pasword').value = ""
    }

    function downloadQR(){
        let a = document.createElement('a');
        a.href = QR.getElementsByTagName('img')[0].src ;
        a.setAttribute("download", "test")
        QR.append(a)
        a.click()
    }

    function deleteItems(){
        let data_items = [...data_list_table.querySelectorAll("input[type='checkbox']")];
        let selected_items = '';
        data_items.forEach((item) => {
            if(item.checked){
                if(item != ''){
                    selected_items += `${item.parentElement.children[1].innerHTML},`
                }
            }
        })
        selected_items = selected_items.slice(0, -1)
        if(selected_items != ''){
            // console.log(selected_items)
            fetch('back-end/clsVoter.php', {
                method : 'POST',
                headers : {
                'Content-type' : 'application/x-www-form-urlencoded' ,
                },
                body: 'items='+ selected_items + '&action=delete_item'
            })
            .then((response) => response.json())
            .then(response => {
                if(response == "Success"){
                    clearTable();
                }  else{
                    alertify.alert("Voter already in use, Unable to delete!")
                }
            })
     
        }
        
    }

    clearTable();
</script>
<?php
    require 'footer.php'
?>