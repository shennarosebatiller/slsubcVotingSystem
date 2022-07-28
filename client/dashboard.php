<?php
    require 'main.php';
    $eletion_data = array();
    $hidden = '';
    if(isset($_SESSION['admin_id'])){
        $hidden = 'style="display:flex"';
    }
    else{
        $hidden = 'style="display:none"';
    }
    // var_dump($hidden)
?>

<div class="db-content" style="overflow-x: scroll;">
    <div class="list-filter" style="width: 420px;display:flex; align-items:center;">
        <select style="font-size:12px;font-weight: normal;width: 235px;border: none;background-color:transparent!important;margin:0px;" id="election_id" onchange="getcount_cards()"> 
            <?php
                $query_election = "SELECT * from election";
                $stmt_election = $conn->prepare($query_election);
                $stmt_election->execute();
                $xdata = $stmt_election->fetchAll();
                $eletion_data = $xdata;
                foreach ($xdata as $key => $value) {
                    echo '<option value='.$value['election_id'].'>'.$value['title'].' '.$value['SY'].'</option>';
                   
                }
            ?>
        </select>
    </div>
    

    <div class="db-card-collection" <?php echo $hidden ?>>
        <div class="card-item-container">
            <div class="db-card" style="">
                <div class="card-image" style="">
                    <span class="material-icons md-max" style="font-size:35px;">drive_file_rename_outline</span>
                </div>
                <div class="card-number">
                    <h3 id="no_voter_voted">15</h3>
                    <p>Voter's Voted</p>
                </div>
            </div>
        </div>
        <div class="card-item-container">
            <div class="db-card" style="">
                <div class="card-image" style="background-color:#006611;">
                    <span class="material-icons md-max" style="font-size:35px;">account_circle</span>
                </div>
                <div class="card-number">
                    <h3 id="no_candidate">15</h3>
                    <p>Total Candidates</p>
                </div>
            </div>
        </div>
        <div class="card-item-container">
            <div class="db-card" >
                <div class="card-image" style="background-color: #FF9933;">
                    <span class="material-icons md-max" style="font-size:35px;">people_outline</span>
                </div>
                <div class="card-number">
                    <h3 id="no_voter">15</h3>
                    <p>Total Participants</p>
                </div>
            </div>
        </div>
        <div class="card-item-container">
            <div class="db-card" >  
                <div class="card-image" style="background-color: #3377ff;">
                    <span class="material-icons md-max" style="font-size:35px;">supervised_user_circle</span>
                </div>
                <div class="card-number">
                    <h3 id="no_position">15</h3>
                    <p>Total Positions</p>
                </div>
            </div>
        </div>
        
    </div>

    <div class="notif-container" <?php echo $hidden ?>>
        <div class="notifsub notif-sub-candidate ">
            <div class="notif-candidate" style="height: 100%;">
                <div class="info-header" style="display:flex; justify-content:space-between;align-items:center;  margin-bottom:1rem;">
                    <h4>Latest Applicants</h4>
                    <span class="material-icons">
                        chevron_right
                    </span>
                </div>
                <div class="applicants-container">
                    
                </div>
               
            </div>
        </div>
        <div class="notifsub notif-sub-gender-count" >
            <div class="notif-candidate">
                <h4>Schedule</h4>
            </div>
            <div class="election-info" style="display: flex;justify-content:space-between">
                <div class=" notif-candidate" style="width: 60%;margin-top: 10px;padding-left:1rem;">
                    <div class=" " style="">
                        <h5 style="font-size: 11px; text-transform:uppercase">Election Title</h5>
                        <hr>
                        <h1 id="notif-election-title">Sample Election 2022</h1>
                    </div>
                </div>
                <div class="" style="width: 35%;margin-left:10px">
                    <div class="start-date notif-candidate" style="margin-top: 10px;padding-left:1rem; border: 2px solid #006611">
                        <h5 style="font-size: 11px; text-transform:uppercase" id="startDateValue">June 2020</h5>
                        <h1 id="startDayValue">19</h1>
                    </div>
                    <div class="start-date notif-candidate" style="margin-top: 10px;padding-left:1rem; border:2px solid #f00606">
                        <h5 style="font-size: 11px; text-transform:uppercase" id="endDateValue">June 2020</h5>
                        <h1 id="endDayValue">19</h1>
                    </div>
                </div>
             
            </div>
            
        </div>
    </div>   


    <div class="statistics-container" style="display:flex; padding: 1rem">
        <div class="daily-monitor" style="width: 100%;">
            <div class="" >
                <div class="daily-monitor-header" style="padding: 1rem; margin-bottom:5px; background-color:white; padding: 1rem; box-shadow: 0px 0px 15px -13px #000000; border-radius: 3px;"  >
                    <h3>Election Poll</h3>
                </div>
                <div class="daily-monitor-body" style=" margin-bottom: 1rem; padding: 10px 0;">
                    <div class="stats" style="display:flex;overflow:hidden;flex-wrap:wrap; align-items:center;justify-content:space-around; background-color:white">
                        <!-- <div class="leader-card" style="display:flex;justify-content:space-between ; width: 400px; padding:1rem; box-shadow: 0px 0px 15px -13px #000000; background-color:white; border-radius: 3px;margin: 10px;">
                            <div class="leader-card-media" style="border-radius:50%;overflow:hidden; width: 150px; height: 150px">
                                <img src="./userphotos/robert.jpg" alt="voter-image" width="100%" >
                            </div>
                            <div class="leader-card-info" style="margin-left:15px; display:flex; flex-direction:column; align-items:center; justify-content:center">
                                <h5 style="border-bottom: 2px solid grey;">VICE - PRESENTIAL CANDIDATE</h5>
                                <p style="font-size: 12px; font-weight:bold; text-transform:uppercase">Orsua, Christian Marvin T.</p>
                                <p style="text-align:center;font-size: 12px;">VOTES</p>
                                <h1 style="text-align:center">52</h1>
                            </div>
                        </div> -->
                    </div>
                </div>
               
                
            </div>
        </div>
       
    </div>
    
   
</div>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>


    let stat_container = document.querySelector('.stats')
    let election_info_container = document.querySelector('.election_info')
    const monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];
    function createPollCanvas(){
        let canvas1 = stat_container.querySelector('#myCharts1').getContext('2d')

        const myChart = new Chart(canvas1, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
        
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
      
    }
    // createPollCanvas();
    
    async function getVoteByDay(){
        let election_id = document.querySelector('#election_id');
        let line_chart = document.querySelector('.line_chart');
        if(line_chart.children[1]){
            line_chart.children[1].remove()
        }

        let canvas = '<canvas id="myLineChart" style="width:100%; height: 250px;"></canvas>'
        line_chart.append(htmlToElement(canvas))

        await fetch('back-end/clsDashboard.php', {
            method : 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : `election_id=${election_id.value}&action=daily_votes`
        })
        .then((res) =>res.json())
        .then(res => {
            // console.log(res)
            var xValues = res['dates'];
            var yValues = res['votes'];
            // console.log(yValues)
            new Chart("myLineChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                label : 'Votes per day',
                fill: true,
                lineTension: 0.1,
                borderColor: 'rgb(75, 192, 192)',
                data: yValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    y: {
                        grid : { display : false},
                        ticks: {
                            stepSize: 1
                        }
                    },
                }
            }
            });
        })
    }

    async function get_statistics(){
        let election_id = document.querySelector('#election_id').value;
        while(stat_container.children[0]){
            stat_container.children[0].remove()
            // console.log(stat_container.children)
        }
        await fetch("back-end/clsDashboard.php", {
            method: 'POST',
            headers  : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : `election_id=${election_id}&action=get_statistics`
        })
        .then(res => res.json())
        .then(res => {
            let elements = res.split("|")
            elements.forEach(element => {
                if(element != ''){
                    stat_container.append(htmlToElement(element))
                }else{
                    stat_container.append(htmlToElement("<div>No Candidates found</div>"))
                }
               
            })         
          
        })
    }    
    async function getcount_cards(){
        let election_id = document.querySelector('#election_id').value;
        let canididate_no = document.querySelector('#no_candidate');
        let voter_no = document.querySelector('#no_voter');
        let voter_vote_no = document.querySelector('#no_voter_voted');
        let position_no = document.querySelector('#no_position');
        await fetch("back-end/clsDashboard.php", {
            method: 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body :`election_id=${election_id}&action=get_count_cards`
        })
        .then((res) => res.json())
        .then(res => {
            canididate_no.innerHTML = res['candidate']
            voter_no.innerHTML = res['voters']
            voter_vote_no.innerHTML = res['voter_voted']
            position_no.innerHTML = res['position']
        })
        // destroyChart();
        get_statistics();
        loadApplicants()
        get_election_info();
    }

    async function get_election_info(){
        let election_id = document.querySelector('#election_id').value;
        let electionTitle = document.querySelector('#notif-election-title')
        let start = document.querySelector('#startDateValue')
        let startDay = document.querySelector('#startDayValue')
        let endMonth = document.querySelector('#endDateValue')
        let endDay = document.querySelector('#endDayValue')
        await fetch ("back-end/clsDashboard.php", {
            method : 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : `election_id=${election_id}&action=get_election_info`
        })
        .then(res => res.json())
        .then(res => {
            let startDate = monthNames[new Date(res['start_date']).getMonth()] + ' ' + new Date(res['start_date']).getFullYear()
            let startd = new Date(res['start_date']).getDate()
            let endDate = monthNames[new Date(res['end_date']).getMonth()] + ' ' + new Date(res['start_date']).getFullYear()

            let endd = new Date(res['end_date']).getDate()
            electionTitle.innerHTML = res['title'] 
            start.innerHTML = startDate
            startDay.innerHTML = startd
            endMonth.innerHTML =endDate
            endDay.innerHTML = endd
        })
    }

    async function latest_pending(){
        await fetch ("back-end/clsDashboard.php", {
            method : 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : `action=get_limit_request`
        })
        .then(res => res.json())
        .then(res => {
            // console.log(res)
        })
    }


    function destroyChart(){
        while(stat_container.hasChildNodes()){
            stat_container.removeChild(stat_container.firstChild);
        }
    }

    async function loadApplicants(){
        let election_id = document.querySelector('#election_id').value;
        let applicantsContainer = document.querySelector('.applicants-container')
        
        while(applicantsContainer.firstChild){
            applicantsContainer.firstChild.remove()
        }

        await fetch('back-end/clsDashboard.php', {
            method : 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body : `election_id=${election_id}&action=latest_applicants`
        })
        .then((res) => res.json())
        .then((res) => {
            if(res.length > 0){
                res.forEach(item => {
                    let applicantItem = "<ul>"
                    applicantItem += "<li>"
                    applicantItem += `<div class="notif-media" style="border-radius:50%;overflow:hidden; width: 40px; height: 40px">`
                    applicantItem += `<img src="${item['image']}" alt="voter-image" width="100%" >`
                    applicantItem += `</div>`
                    applicantItem += `</li>`
                    applicantItem += `<li style="width: 38%;"><h5>${item['lname']}, ${item['fname']}</h5><p> ${item['description']}<pspan></li>`
                    applicantItem += `<li style="width: 20%;">${item['date']}</li>`
                    applicantItem += `<li style="width: 15%;">${item['status']}</li>`
                    applicantItem += `</ul>`;
                    applicantsContainer.append(htmlToElement(applicantItem))
                });
            }else{
                let applicantItem = "<p style='font-size: 12px'>No Applicants</p>";
                applicantsContainer.append(htmlToElement(applicantItem))
            }
            
        })
    }

    async function loadLeaders(){
        let election_id = document.querySelector('#election_id').value;
        await fetch("back-end/clsDashboard.php", {
            method : 'POST',
            headers : {
                'Content-type' : 'application/x-www-form-urlencoded'
            },
            body :  `election_id=${election_id}&action=load_leaders`
        })
        .then((res) => res.json())
        .then(res => {
            console.log(res)
        })
    }

    getcount_cards();
    // getVoteByDay();
    loadLeaders();
    latest_pending();
    // loadApplicants();
    // get_statistics();

</script>


<?php
    require 'footer.php'

?>