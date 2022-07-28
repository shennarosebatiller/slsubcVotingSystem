<?php
    require 'main.php';
?>
<div>
  
    <div class="application-form-container" style="padding: 1rem; margin: 5rem auto;width: 550px;overflow:hidden; position:relative;box-shadow: 0px 0px 15px -13px #000000;">
        <img src="../images/school-logo.png" style="position:absolute; z-index: 0; top: -200; right: -150; opacity: .1;">
        <div class="" style="z-index: 1000;position:relative;">
        <h1>Application Form</h1>
        <form id='add-form'>
        <hr> <hr>
            <div class="" style="display:flex; justify-content:space-between; " >
                <div class="add-input">
                    <p>Willing to be a Candidate for :</p>
                    <select name="apply_cand[election]" id='election_id'>
                        <option></option>
                        <?php 
                            $xquery = "SELECT * from election";
                            $xstmt = $conn->prepare($xquery);
                            $xstmt->execute();
                            $xdata = $xstmt->fetchAll();
                            foreach ($xdata as $key => $value) {
                                echo "<option value=".$value['election_id'].">".$value['title']." ".$value['SY']."</option>";
                            }
                        ?>
                    </select>
                    
                </div>
                <div class="add-input">
                    <p>Applying For :</p>
                    <select name="apply_cand[position]">
                        <option></option>
                        <?php 
                            $xquery = "SELECT * from position";
                            $xstmt = $conn->prepare($xquery);
                            $xstmt->execute();
                            $xdata = $xstmt->fetchAll();
                            foreach ($xdata as $key => $value) {
                                echo "<option value=".$value['position_id'].">".$value['position']."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        
            <div class="add-input">
                <p>Reason for applying :</p>
                <textarea style="width: 100%;height: 250px; max-height: 260px; max-width: 100%;min-width: 100%; padding: 10px ; font-size: 12px;" name="apply_cand[reason]"></textarea>

            </div>
            <input type="button" value="Submit Application"  id="btn_submit_election"  style="margin-top: 1rem;" onclick="submitApplication()">
        </div>
        <input type="text" name="apply_cand[stud_id]" id="stud_id" hidden value=<?php echo '"'.$_SESSION['user_id'].'"'?>>
        </form>
    </div>    
</div>

<script>
    let addContainer = document.querySelector('.bg-add-container');


    // function showModal(){
    //     addContainer.style.display = "flex";
    // }

    // function hideModal(){
    //     addContainer.style.display = "none";
    // }
    function validate_election(){
        let actionbtn = document.querySelector('#btn_submit_election')
        let election_id = document.querySelector('#election_id').value
        fetch("back-end/clsVoter.php", {
            method : 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : `election_id=${election_id}&action=validate_election_date`
        })
        .then((res) => res.json())
        .then(res => {
            if(res == "approved"){
                actionbtn.disabled = false
                actionbtn.hidden = false
            }
        })
    }

    hideModal();
    function submitApplication(){
        console.log('test')
        let form = document.querySelector('#add-form');
        let form_data = serializeForm(form)
        if(form != ''){
            let stud_id = document.getElementById('stud_id').value;
            let election_id = document.getElementById('election_id').value;
            let valid_data = `stud_id=${stud_id}&election_id=${election_id}`
            fetch("back-end/clsVoter.php", {
                method: 'POST',
                headers : {
                    'Content-type' : 'application/x-www-form-urlencoded'
                },
                body : valid_data + '&action=check_application'
            })
            .then(res => res.json())
            .then(res => {
                if(!res){
                    fetch("back-end/clsVoter.php", {
                        method: 'POST',
                        headers : {
                            'Content-type' : 'application/x-www-form-urlencoded'
                        },
                        body : form_data + '&action=apply_candidacy'
                    })
                    .then (res => res.json())
                    .then (res => {
                        alertify.alert("Successfuly applied.")
                    })
                }
                else{
                    alertify.alert("You have already applied for the the choosen election !")
                }
            })

            
        }
    }
</script>

<?php
    require 'footer.php'
?>