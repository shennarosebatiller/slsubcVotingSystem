<?php
    require 'main.php'
?>
<div>
    <!-- <h1>Elections</h1> -->
    <div class="list-container">
        <!-- <div class="list-filter">
            <input type="text" placeholder="Search Name" style="width: 450px;border-radius: 10px; border: 2px solid black">
            <select>
                <option>President</option>
                <option>Vice-President</option>
                <option>Vice-President</option>
            </select>
            <input type="button" value="Search">
        </div> -->
        <div class="list-action">
            <input type="button" value="New Election" onclick="showModal()">
            <input type="button" value="Delete Election" onclick="deleteItems()">
            <input type="button" value="View Detail">
        </div>
        <div class="list-table">
            <ul>
                <li style="display: flex; justify-content:space-between;padding: 10px; margin : 5px 0px;" class="list-headers">
                    <b style="display:none"></b>
                    <h5 style="display:none">Election ID</h5>
                    <h5 style="width: 150px">TITLE</h5>
                    <h5 style="width: 150px">School Year</h5>
                    <h5 style="width: 150px">Voting Starts</h5>
                    <h5 style="width: 150px">Voting End</h5>
                    <!-- <h5 style="width: 150px">Created By</h5> -->
                </li>
                <hr>
            </ul>
            <ul id="list-table-body">
               
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

    function addElection(){
        let title = document.querySelector('#title').value
        let fromSY = document.querySelector('#fromSY').value
        let toSY = document.querySelector('#toSY').value
        let fromDate = document.querySelector('#from_date').value
        let toDate = document.querySelector('#to_date').value

        if(title == ''){
            alertify.alert("Title should not be empty!");
        }
        else if(fromSY == ''){
            alertify.alert("[From] School Year should not be empty!")
        }
        else if(toSY == ''){
            alertify.alert("[To] School Year should not be empty!")
        }
        else if(fromDate == ''){
            alertify.alert("[From] Date should not be empty!")
        }
        else if(toDate == ''){
            alertify.alert("[To] Date should not be empty!")
        }
        else{
            let xdata = serializeForm(document.querySelector('.add-form'))
            fetch("back-end/clsElection.php", {
                method: 'POST',
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body : xdata + "&action=add_election"
            })
            .then(res => res.json())
            .then(res => {
                console.log(res)
                if(res == "Success"){
                    alertify.alert("Successfully added a new Election.")
                    clearTable();
                    hideModal();
                    clearInput();
                }
            })

        }
       
        
    }
    function getDataList(){
        fetch('back-end/clsElection.php', {
            method: 'POST',
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: '&action=display_list'
        })
        .then(res => res.json())
        .then(res => { 
            console.log(res)
            res.forEach(item => {
                let newItem = "";
                let status_color = "blue";
                newItem += ` <li style="display: flex; justify-content:space-between; padding: 10px; margin : 5px 0px; cursor:pointer; background-color:#f3f3f3; border-left: 4px solid blue;border-radius: 3px" onclick="itemFocus(this)">`;
                newItem += ` <input type="checkbox" style="display:none">`
                newItem += ` <h5 style="display:none">${item['election_id']}</h5>`
                newItem += ` <h5 style="width:150px">${item['title']}</h5>`
                newItem += ` <h5 style="width:150px">${item['SY']}</h5>`
                newItem += ` <h5 style="width:150px">${item['start_date']}</h5>`
                newItem += ` <h5 style="width:150px">${item['end_date']}</h5>`
                // newItem += ` <h5 style="width:150px">${item['year']}</h5>`
                newItem += `</li>`;
                data_list_table.append(htmlToElement(newItem));
            });
        })
    }
    function clearTable() {
        while (data_list_table.firstChild) {
            data_list_table.removeChild(data_list_table.firstChild);
        }
        getDataList();
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
            fetch('back-end/clsElection.php', {
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
                }else{
                    alertify.alert("Unable to delete, Data already in use!")
                }
            })
     
        }
        
    }

    function clearInput(){
        document.querySelector('#title').value = ""
        document.querySelector('#fromSY').value = ""
        document.querySelector('#toSY').value = ""
        document.querySelector('#from_date').value = ""
        document.querySelector('#to_date').value = ""
    }

    clearTable();
    hideModal();

</script>

<?php
    require 'footer.php'
?>