<?php
    require 'main.php'
?>
<div>
    <h1>Ballot Votes</h1>
    <div class="list-container">
        <div class="list-filter">
            <input type="text" placeholder="Search Name" style="width: 450px;border-radius: 10px; border: 2px solid black">
            <select>
                <option>President</option>
                <option>Vice-President</option>
                <option>Vice-President</option>
            </select>
            <input type="button" value="Search">
        </div>
        <div class="list-action">
            <input type="button" value="New Candidate" onclick="showModal()">
            <input type="button" value="Delete Candidate" onclick="deleteItems()">
            <input type="button" value="View Detail">
        </div>
        <div class="list-table">
            <ul>
                <li style="display: flex; justify-content:space-between;padding: 10px; margin : 5px 0px;" class="list-headers">
                    <b style="display:none"></b>
                    <h5 style="display:none">Vote ID</h5>
                    <h5 style="width: 100px">Ballot ID</h5>
                    <h5 style="width: 200px">Voter Name</h5>
                    <h5 style="width: 200px">Candidate Name</h5>
                    <h5 style="width: 150px">Position</h5>
                    <h5 style="width: 130px">School Year</h5>
                    <h5 style="width: 100px">Time Voted</h5>
                    <h5 style="width: 100px">Date</h5>
                </li>
                <hr>
            </ul>
            <ul id="list-table-body">
                <li style="display: flex; justify-content:space-between;padding: 10px; margin : 5px 0px;" class="list-headers">
                    <input type="checkbox" style="display:none"></input>
                    <h5 style="display:none">Vote ID</h5>
                    <h5 style="width: 100px">123</h5>
                    <h5 style="width: 200px">asdhakjsdhsad, asdjakshkdjsad m.</h5>
                    <h5 style="width: 200px">asdhakjsdhsad, asdjakshkdjsad m.</h5>
                    <h5 style="width: 150px">Vice - President</h5>
                    <h5 style="width: 130px">2020 - 2021</h5>
                    <h5 style="width: 100px">8:00 AM</h5>
                    <h5 style="width: 100px">June 07, 2022</h5>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="bg-add-container">
    <form class="add-form">
        <div class="add candidates-container" style="width: 350px; background : #f3f3f3; padding: 1rem; ">
            <div class="add-header">
                <h3>Election Information</h3>
            </div>
            <hr>
            <hr>
            <div class="add-body" style="display: flex; flex-direction:column; margin: 10px 5px;">
                <div class="add-input">
                    <h5>Title</h5>
                    <input type="text" name="txt_election[title]" id="title" style="width:100%">
                </div>
                <div class="add-input">
                    <h5>School Year</h5>
                    <div class="Sy-container" style="display: flex;align-items:center; justify-content:left">
                        <input type="text" name="txt_election[fromSY]" id="fromSY" style="width:150px">
                        <span style="margin: 0px 1rem;">-</span>
                        <input type="text" name="txt_election[toSY]" id="toSY" style="width:150px">
                    </div>
                </div>
                <div class="add-input">
                    <h5>Voting Date</h5>
                    <div class="Sy-container" style="display: flex;align-items:center; justify-content:left">
                        <input type="date" name="txt_election[fromDate]" id="from_date" style="width:150px">
                        <span style="margin: 0px 1rem;">TO</span>
                        <input type="date" name="txt_election[toDate]" id="to_date" style="width:150px">
                    </div>
                </div>
            </div>
            <hr>
            <hr>    
            <div class="add-actions" style="margin-top: 10px;">
                <input type="button" value="Confirm" onclick = "addElection()">
                <input type="button" value="Cancel" onclick="hideModal()">
            </div>
        </div>
    </form>
</div>

<script>
    
    let addContainer = document.querySelector('.bg-add-container');
    let data_list_table = document.querySelector('#list-table-body')

    function showModal(){
        addContainer.style.display = "flex";
    }

    function hideModal(){
        addContainer.style.display = "none";
        clearInput();
    }


    clearTable();
    hideModal();

</script>

<?php
    require 'footer.php'
?>