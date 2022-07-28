<?php
    require 'main.php'
?>
<div>
    <!-- <h1>Candidates</h1> -->
    <div class="list-container">
    <div class="filter">
            <div class="list-filter" style="width: 600px;">
                <h4 style="text-transform: uppercase;">Filter candidate status in :</h4>
                <div style="width: 600px;">
                    <select style="font-size:12px;font-weight: normal;width: 385px;">
                        <option value="default">--Select a election--</option>
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
            <!-- <input type="button" value="Add Candidate" onclick="showModal()"> -->
            <input type="button" value="Delete Candidate">
            <input type="button" value="View Candidate">
        </div>
        <div class="list-table">
            <ul>
            <li style="display: flex; justify-content:space-between;  padding: 10px; margin : 5px 0px;">
                    <b style="display:none"></b>
                    <h5 style="display:none">student id</h5>
                    <h5 style="width: 230px">Full Name</h5>
                    <h5 style="width: 100px">Course</h5>
                    <h5 style="width: 90px">Year</h5>
                    <h5 style="width: 140px">Running for</h5>
                    <h5 style="width: 140px">Election</h5>
                    <h5 style="width: 100px">SY</h5>
                </li>
                <hr>
            </ul>                
            <ul id='list-table-body'>
               
            </ul>
        </div>
    </div>
</div>
<div class="bg-add-container">
    <div class="add candidates-container" style="width: 520px; background : #f3f3f3; padding: 1rem; ">
        <div class="add-header">
            <h3>Add Candidate</h3>
        </div>
        <hr>
        <div class="add-body" style="display: flex; justify-content:space-between; margin: 10px 5px;">
            <div class="add-input">
                <h5>Student Name :</h5>
                <select>
                    <option>Test, Sample M.</option>
                </select>
            </div>
            <div class="add-input">
                <h5>Register position to :</h5>
                <select>
                    <option>Test, Sample M.</option>
                </select>
            </div>
        </div>
        
        <div class="add-actions" style="margin-top: 10px;">
            <input type="button" value="Confirm">
            <input type="button" value="Cancel" onclick="hideModal()">
        </div>
    </div>
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
        await fetch("back-end/clsCandidate.php", {
            method : 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : '&action=get_data_inner_list_candidates'
        })
        .then(res => res.json())
        .then(res => {
            res.forEach(item => {
                let newItem = "";
                let status_color = "blue";
                newItem += ` <li style="display: flex; justify-content:space-between; background-color:#f3f3f3;padding: 10px; margin : 5px 0px;">`;
                newItem += ` <input type="checkbox" hidden>`
                newItem += ` <h5 hidden>${item['candidate_id']}</h5>`
                newItem += ` <h5 style="width: 250px;">${item['lname']}, ${item['fname']}</h5>`
                newItem += ` <h5 style="width: 100px;">${item['course']}</h5>`
                newItem += ` <h5 style="width: 100px;">${item['year']}</h5>`
                newItem += ` <h5 style="width: 150px;">${item['position']}</h5>`
                newItem += ` <h5 style="width: 150px;">${item['title']}</h5>`
                newItem += ` <h5 style="width: 100px;">${item['SY']} </h5>`
                newItem += `</li>`;
                data_list_table.append(htmlToElement(newItem));
            });        
        })
    }
    hideModal()
    getDataList();
</script>

<?php
    require 'footer.php'
?>