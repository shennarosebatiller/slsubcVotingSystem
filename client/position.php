<?php
    require 'main.php'
?>
<div>
    <!-- <h1>List of Positions</h1> -->
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
            <input type="button" value="New Position" onclick="showModal()">
            <input type="button" value="Delete Position" onclick="deleteItems()">
            <input type="button" value="View Detail's">
        </div>
        <div class="list-table">
            <ul>
                <li style="display: flex; justify-content:space-around;padding: 10px; margin : 5px 0px;" class="list-headers">
                    <b hidden></b>
                    <h5>Position</h5>
                    <h5>Description</h5>
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
        <div class="add candidates-container" style="width: 520px; background : #f3f3f3; padding: 1rem; ">
            <div class="add-header">
                <h3>Add Positions</h3>
            </div>
            <hr>
            <hr>
            <div class="add-body" style="display: flex; flex-direction:column; margin: 10px 5px;">
                <div class="add-input">
                    <h5>Position :</h5>
                    <input type="text" id="position" name="txtfilter[position]" style="width:100%; padding: 5px">
                </div>
                <div class="add-input">
                    <h5>Description :</h5>
                    <textarea type="text" id="description" name="txtfilter[description]" style="width:100%; padding: 5px"></textarea>
                </div>
                <div class="add-input">
                    <h5>Position Order :</h5>
                    <input type="number" id="position_order" name="txtfilter[position_order]" style="width:100%; padding: 5px">
                </div>
            </div>
            <hr>
            <hr>    
            <div class="add-actions" style="margin-top: 10px;">
                <input type="button" value="Confirm" onclick="addPosition()">
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
    }
    async function addPosition(){
        let postion = document.getElementById('position').value
        let description = document.getElementById('description').value
        if(postion == ''){
            alertify.alert("Position Should not be empty! ")
        }
        else if(description == ''){
            alertify.alert("Description Should not be empty! ")
        }
        else{
            let xdata = serializeForm(document.querySelector('.add-form'))
            await fetch("back-end/clsPosition.php", {
                method : "POST",
                headers : {
                    'Content-type' : 'application/x-www-form-urlencoded'
                    
                },
                body : xdata + "&action=add_item"
            })
            .then(res => res.json())
            .then(res => {
                alertify.alert("Successfuly added a new position!")
                hideModal();
                clearTable();
            })
        }
    }

    async function getDataList(){
        await fetch('back-end/clsPosition.php', {
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
                newItem += ` <li style="display: flex; justify-content:space-around; padding: 10px; margin : 5px 0px; cursor:pointer; background-color:#f3f3f3; border-left: 4px solid blue;border-radius: 3px" onclick="itemFocus(this)">`;
                newItem += ` <input type="checkbox" hidden>`
                newItem += ` <h5 style="display:none">${item['position_id']}</h5>`
                newItem += ` <h5 >${item['position']}</h5>`
                newItem += ` <h5 >${item['description']}</h5>`
                newItem += `</li>`;
                data_list_table.append(htmlToElement(newItem));
            });
        })
    }

    async function deleteItems(){
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
            await fetch('back-end/clsPosition.php', {
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
                    alertify.alert("Unable to delete, Data already in Use!")
                }
            })
     
        }
    }



    function clearTable() {
        while (data_list_table.firstChild) {
            data_list_table.removeChild(data_list_table.firstChild);
        }
        getDataList();
    }


    clearTable();
    hideModal();

</script>

<?php
    require 'footer.php'
?>