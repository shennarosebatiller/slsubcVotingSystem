<?php
    require 'main.php'
?>
<div>
    <!-- <h1>Candidate Applicants</h1> -->
    <div class="list-container">
        <div class="filter" style="background-color:white">
            <div class="list-filter" style="width: 600px; ">
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
            <!-- <div class="list-filter" style="width: 600px;">
                <h4 style="text-transform: uppercase;">Filter by name :</h4>
                <div style="display: flex; align-items:center; justify-content:space-between; "> 
                    <input type="text" placeholder="First Name" style="font-size:12px;font-weight: normal;">
                    <input type="text" placeholder="Middle Name">
                    <input type="text" placeholder="Last Name">
                </div>
            </div> -->
        </div>
        <div class="list-action">
            <input type="button" value="Review Applicantion" onclick="showModal(),getSingleItem()">
            <input type="button" value="Delete Appplication">
            <!-- <input type="button" value="View Candidate"> -->
        </div>
        <div class="list-table">
            <ul>
                <li style="width: 100%;display: flex; justify-content:space-between; padding: 10px; margin : 5px 0px; border-radius: 3px" class="list-headers">
                    <b hidden></b>
                    <h5 hidden>ID</h5>
                    <h5 style="width: 210px;">Student Name</h5>
                    <h5 style="width: 150px;">Course</h5>
                    <h5 style="width: 100px;">Year</h5>
                    <h5 style="width: 180px;">Applying For</h5>
                    <h5 style="width: 150px; ">Election</h5>
                    <h5 style="width: 100px;">STATUS</h5>
                    <h5></h5>
                </li>
                <hr>
            </ul>
            <ul id='list-table-body'>
            
            </ul>
        </div>
    </div>
</div>
<div class="bg-add-container">
    <form class="add-form">
    <div class="add candidates-container" style="width: 520px; background : #f3f3f3; padding: 1rem; ">
        <div class="add-header">
            <h3>Application Information</h3>
        </div>
        <hr>
        <hr>
        <div class="add-body" style="display: flex; flex-direction:column; margin: 10px 5px;">
            <input type="text" id="request_id" style="width:100%" hidden>
            <div style="display:flex; width: 100%; justify-content:space-between" >
                <div class="add-input" style="width:50%">
                    <h5>Election :</h5>
                    <input type="text" name="txtfilter[election_id]" style="width:100%" id="election" disabled  >
                </div>
                <div class="add-input" style="width:45%">
                    <h5>Position :</h5>
                    <input disabled type="text" name="txtfilter[position_id]" id="position" style="width:100%">
                </div>
            </div>
            <div class="add-input">
                <h5>Full Name :</h5>
                <input disabled type="text" name="txtfilter[fullname]" style="width:100%" id="fullname">
            </div>
            <div style="display:flex; width: 100%; justify-content:space-between" >
                <div class="add-input" style="width:50%">
                    <h5>Course :</h5>
                    <input disabled type="text" name="txtfilter[course]" style="width:100%" id="course">
                </div>
                <div class="add-input" style="width:45%">
                    <h5>Year :</h5>
                    <input disabled type="text" name="txtfilter[position]" style="width:100%" id="year">
                </div>
            </div>
            <div class="add-input">
                <h5>Reason :</h5>
                <textarea disabled style="max-height: 150px; height: 150px;min-width:100%;max-width:100%" id="reason"></textarea>
                <!-- <input type="text" id="txtfilter[position]" style="width:100%"> -->
            </div>
        
        </div>
        <hr>
        <hr>    
        <div class="add-actions" style="margin-top: 10px;">
            <input type="button" id="approveBtn" value="Approve Application" onclick="approveCandidate()">
            <input type="button" value="Close" onclick="hideModal()">
        </div>
    </div>
    </form>
</div>


<script>
    let addContainer = document.querySelector('.bg-add-container');
    let data_list_table = document.querySelector('#list-table-body');

    function showModal(){
        addContainer.style.display = "flex";
    }

    function hideModal(){
        addContainer.style.display = "none";
    }

    async function getDataList(){
        let election_id = document.querySelector('#election_id').value
        console.log(election_id);
        await fetch("back-end/clsCandidate.php", {
            method : 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : `election_id=${election_id}&action=get_data_inner_list`
        })
        .then(res => res.json())
        .then(res => {
            res.forEach(item => {
                let newItem = "";
                let status_color = "blue";
                newItem += ` <li style="display: flex; justify-content:space-between; padding: 10px; margin : 5px 0px; cursor:pointer; background-color:#f3f3f3; border-radius: 3px" onclick="itemFocus(this)">`;
                newItem += ` <input type="checkbox" hidden>`
                newItem += ` <h5 hidden>${item['request_id']}</h5>`
                newItem += ` <h5 style="width: 200px;">${item['lname']},${item['fname']}</h5>`
                newItem += ` <h5 style="width: 150px;">${item['course']}</h5>`
                newItem += ` <h5 style="width: 100px;">${item['year']}</h5>`
                newItem += ` <h5 style="width: 180px;">${item['position']}</h5>`
                newItem += ` <h5 style="width: 150px;">${item['title']} ${item['SY']}</h5>`
                newItem += ` <h5 style="width: 100px;">${item['status']} </h5>`
                newItem += `</li>`;
                data_list_table.append(htmlToElement(newItem));
            });
            
        })

    }
    function clearTable(){
        while (data_list_table.firstChild) {
            data_list_table.removeChild(data_list_table.firstChild);
        }
        getDataList();
    }

    function getSingleItem(){

        let request_id = document.querySelector('#request_id')
        let election = document.querySelector('#election')
        let position = document.querySelector('#position')
        let fullname = document.querySelector('#fullname')
        let year = document.querySelector('#year')
        let course = document.querySelector('#course')
        let reason = document.querySelector('#reason')

        let data_items = [...data_list_table.querySelectorAll("input[type='checkbox']")]
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
            let data = `id=${selected_item[0] }`;
            fetch("back-end/clsCandidate.php", {
                method : 'POST',
                headers : {
                    'Content-type': 'application/x-www-form-urlencoded'
                },
                body : data + '&action=get_single_item'
            })
            .then(res => res.json())
            .then(res => {
                request_id.value = res['request_id']
                election.value = res['title'] + ' ' + res['SY']
                position.value = res['position']
                fullname.value = res['lname']+', '+res['fname'] 
                course.value = res['course']
                year.value = res['year']
                reason.value = res['reason']

                if(res['status'] == 'Approved'){
                    document.querySelector('#approveBtn').style.display = "none"
                }

            })
        }
    }

    function approveCandidate(){
        let request_id = document.querySelector('#request_id').value
        fetch("back-end/clsCandidate.php", {
            method : "POST",
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : `req_id=${request_id}&action=add_candidate`
        })
        .then(res => res.json())
        .then(res => {
            if(res == 'Success'){
                alertify.alert("Successfully added to candidates")
            }
            else{
                alertify.alert(res)
            }
          
        })

    }
    clearTable();
    hideModal();
</script>

<?php
    require 'footer.php'
?>