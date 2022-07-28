<?php
    require 'main.php';
    if(isset($_POST['selected'])){
        $_SESSION['election_id'] = $_POST['selected'];
        // header('Location: /voting_process.php', true, 301);
        echo '<script>window.top.location="voting_process.php"</script>';
    }
?>
<style>
    p{
        font-size: 10px;
    }
</style>
<form id="selection_form" style="text-align: center;">
    <h1>SELECT A ELECTION TO PROCEED</h1>
    <div class="selection-container" style="display: flex;justify-content:space-around;align-items:center; padding: 1rem; ">
        <?php
            $query = "SELECT * from election";
            $xstmt = $conn->prepare($query);
            $xstmt->execute();
            $xdata = $xstmt->fetchAll();
            foreach ($xdata as $key => $value) {

                $query_check = "SELECT * from ballot where election_id=? AND student_id=?";
                $stmt_check = $conn->prepare($query_check);
                $stmt_check->execute([$value['election_id'], $_SESSION['user_id']]);
                $xdata_check = $stmt_check->fetch();
                if($xdata_check){
                    $disable_button = 'hidden';
                    $notification = "You already voted for this election";
                }
                else{
                    $disable_button = '';
                    $notification = '';
                }

                echo '<div class="election-card" style=" height: 110px;width: 300px;padding:8px; display:flex;justify-content:space-around;align-items:center; background-color:#f3f3f3;border-radius:2px;">
                        <div class="election-image">
                            <img src="../images/election.jfif" style="height: 100%;">
                        </div>
                        <div class="election-desc">
                            <h3 style="display:none;">'.$value['election_id'].'</h3>
                            <h3>'.$value['title'].'</h3>
                            <h5>'.$value['SY'].'</h5>
                            <p>Start Date : '.$value['start_date'].'</p>
                            <p>End Date : '.$value['end_date'].'</p>
                            <input type="button" value="Select Election" onclick=(submit_election('.$value['election_id'].')) '.$disable_button.'>
                            <p style="color:red">'.$notification.'<p/>
                        </div>
                    </div>';
            }
        ?>
    </div>
    <input type="hidden" name="selected" value="">
</form>

<script>
    function submit_election(id){
        let form = document.querySelector('#selection_form')
        form.selected.value = id
        form.method = "POST"
        form.submit()
        console.log(form.selected.value)
    }

</script>
<?php
    require 'footer.php'
?>