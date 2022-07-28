<?php
// var_dump('test');
// die();
    require 'main.php';
    require 'back-end/clsConnection.php';
    $display_2 = 'display:none';
    ob_start();

    if(isset($_SESSION['election_id'])){
        $election_id = $_SESSION['election_id'];
        $display = 'display:none';
        $display_2 = 'display:block';
    }else{
        echo '<script>window.top.location="selection.php"</script>';
    }
?>
<h1>Voting Process</h1>
<p></p>
<h3>OUR CANDIDATES</h3>
<hr>
<form id="voters_vote">
    <input type="hidden" id="election_id" value="<?php echo $election_id?>">
    <div class="candidate_voting_container">
        <?php
            $query = "SELECT * from position ORDER BY position_order ASC";
            $xstmt = $conn->prepare($query);
            $xstmt->execute();
            $xdata_positons = $xstmt->fetchAll();
            foreach ($xdata_positons as $key => $position) {
                echo '<div style="padding:1rem; margin: 2rem 5px; border-radius: 3px;background-color:white;">
                        
                            <div style="position:relative;overflow:hidden;  padding: 1rem 1rem; box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.15);">
                                <img src="../images/school-logo.png" alt="background_image" style="position:absolute;opacity: .3; right: -105px;top: -250;">
                                <h2 style="letter-spacing:3px;font-weight:100;">'.strtoupper($position['position']).'IAL CANDIDATES</h2>
                            </div>
                        
                            <div class="candidate-card-container" style="padding: 1rem; display:flex; justify-content:space-around;align-items:center; background-color:white; box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.15);margin-top:10px;">';
                            
                            $query_candidate = "SELECT candidate.candidate_id, cq.request_id,voter.image, voter.student_id, voter.fname,voter.lname, voter.course, voter.year,position.position, election.title, election.SY, cq.reason, cq.status from candidate INNER JOIN candidate_request as cq  ON candidate.request_id = cq.request_id INNER JOIN voter ON cq.student_id = voter.student_id INNER JOIN election on cq.election_id = election.election_id INNER JOIN position on cq.position_id = position.position_id where position.position_id =? AND election.election_id = ?";
                            $xstmt_candidate = $conn->prepare($query_candidate);
                            $xstmt_candidate->execute([$position['position_id'], $election_id]);
                            $xdata_candidate = $xstmt_candidate->fetchAll();
                            foreach ($xdata_candidate as $key => $candidate) {
                                echo    '<div class="card-candidate" style="width: 230px; border:1px solid #f3f3f3; position:relative; background-color: #4da6ff;box-shadow: 0px 0px 11px 3px rgba(0,0,0,0.25);">
                                            <div class="card-img" style="width: 70%; height: 160px; background-color:white; position:absolute; top: 10%; left: 13%;border: 5px double #4da6ff;border-radius: 50%; text-align:center;overflow:hidden; display:flex; align-items:center;">
                                                <img src='.$candidate['image'].' style="width: 100%">
                                            </div>
                                            <div class="card-info" style="background-color: #f3f3f3;text-align:center;margin-top: 8rem; padding: 1rem; padding-top: 5rem;">
                                                <p>'.$candidate['lname'].', '.$candidate['fname'].'</p>
                                                <p style="font-size: 12px;">'.$candidate['year'].' Student</p>
                                                <p style="font-size: 12px;">'.$candidate['course'].'</p>
                                                ';
                                                if($position['position'] == "Senator"){
                                                    echo '<input type="checkbox" name="txt_vote['.$position['position'].']" value="'.$candidate['candidate_id'].'"/>';
                                                }
                                                else{
                                                        echo '<input style="margin:auto" type="radio" name="txt_vote['.$position['position'].']" value="'.$candidate['candidate_id'].'"/>';
                                                }
                                echo ' </div>
                                </div>';
                                                
                            }                           
                echo'          
                        </div>
                    </div>';          
            }
        ?>
        <input type="button" value="Submit Vote" onclick="submitVote()">
    </div>
  
</form>
<script>

    function submit(){
        let form = $('#elec-form');
        let data = new FormData(form);
        form.method = "POST"
        form.submit();
    }

    async function submitVote(){
        console.log('test')
        // let xdata=serializeForm(document.querySelector('#voters_vote'))
        let radio_fields = [...document.querySelectorAll('input[type=radio]:checked')]
        let check_fields = [...document.querySelectorAll('input[type=checkbox]:checked')]
        let election_id = document.querySelector('#election_id');
        let xdata_array = "";
        radio_fields.forEach(item => {
            if(xdata_array != ''){
                xdata_array += "&"
            }
            xdata_array += `txt_voter[]=${item.value}`
            xdata_array.trim()
        })
        check_fields.forEach(item => {
            if(xdata_array != ''){
                xdata_array += "&"
            }
            xdata_array += `txt_voter[]=${item.value}`
            xdata_array.trim()
        })

        xdata_array = xdata_array+`&election_id=${election_id.value}`;
        await fetch("back-end/clsVoter.php", {
            method : "POST",
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : xdata_array + '&action=submit_vote'
        })
        .then(res => res.json())
        .then(res => console.log(res))
    }
</script>


<?php
    require 'footer.php'
?>