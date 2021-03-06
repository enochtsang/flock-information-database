<?php
    session_start();
  if(!isset($_SESSION['userType']) || ($_SESSION['userType'] !== "producer")) {    
    header('Location: logout.php');
  } 
?>
<!DOCTYPE html>
<html lang="en-CA">
<head>
    <?php include 'header.php';?>
    <title>Flock Information Database</title>
    <meta name="description" content="IAPT's flock information database">
    <script src="resources/scripts/index.js"></script>
    <link href="resources/stylesheet-index.css?version=0" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div class="wrapper">
        <div id="logo-bar">
            <?php include 'logo-include.php'; ?>
            <h1> Succesful Submission </h1>
        </div>
        
        <div id="public-relations">
        <img src="resources/space_moustache.jpg" style="width:304px;height:228px;PADDING-TOP:90px;" align="bottom" >
         <h2>TO THE MOOOOOON!</h2>
        </div>
            <?php
            session_start();
            require_once 'connect.php';
            
            //global variables
            $submission_date = date('Y-m-d H:i:s');//submission_date_

//**********General Flock Information*********************************

            //***************veterinary_practice******************
            //set variables from form submission
            $vet_name = filter_input(INPUT_POST, 'vet-name');//vet_name
            $vet_address = filter_input(INPUT_POST, 'vet-address');//vet_address
            
            //set variables from form submission
            $vetQuery = "INSERT INTO `veterinary_practice` (vet_name,vet_address) "
            		. "VALUES ('$vet_name','$vet_address')";
            $resultVet = mysqli_query($flockCon, $vetQuery);
            
            
            
            //***************enterprise******************
            //set variables from form submission
            if (isset($_POST['producer-enterprise'])) {
                $producer_code_quota = filter_input(INPUT_POST, 'producer-code-quota');//e_code_
                $producer_enterprise = filter_input(INPUT_POST, 'producer-enterprise');//e_name
                $produces_for = filter_input(INPUT_POST, 'produces-for');//produces_for
                $additional_comments = filter_input(INPUT_POST, 'additional-comments');//comments
//              $additional_comments = document.getElementById("additional-comments").value;//comments
                //insert values into the database
                if (!empty($producer_code_quota) && !empty($producer_enterprise)) {
                    $enterpriseQuery = "INSERT INTO `enterprise` (e_code_,e_name,produces_for,comments,vet_name,submission_date_) "
                    . "VALUES ('$producer_code_quota','$producer_enterprise','$produces_for','$additional_comments','$vet_name','$submission_date')";
                    $resultEnterprise = mysqli_query($flockCon, $enterpriseQuery);
                }
            }
			
            	//***************barn******************
            	//set variables from form submission
                $barn_number = filter_input(INPUT_POST, 'barn-number'); //barn_number_
                $mortality_rate = filter_input(INPUT_POST, 'mortality-rate'); //mortality_rate
                $number_of_birds_shipped = filter_input(INPUT_POST, 'number-of-birds-shipped');//birds_shipped
                $number_of_birds_placed = filter_input(INPUT_POST, 'number-of-birds-placed');//birds_placed
                $grow_out_density = filter_input(INPUT_POST, 'grow-out-density');//grow_out_density
                $grow_out_density_units = filter_input(INPUT_POST, 'grow-out-density-units');//density_units
                
				//insert values into the database
                 $barnQuery = "INSERT INTO `barn` (barn_number_,mortality_rate,birds_shipped,birds_placed,grow_out_density,density_units,e_code_,submission_date_) "
                 . "VALUES ('$barn_number', '$mortality_rate','$number_of_birds_shipped', '$number_of_birds_placed','$grow_out_density','$grow_out_density_units','$producer_code_quota','$submission_date')";
                $resultBarn = mysqli_query($flockCon, $barnQuery);
                   
            
                //***************poultry_flock******************
                //set variables from form submission
                $kg_per_bird = filter_input(INPUT_POST, 'kg-per-bird'); //kg_per_bird
                $species = filter_input(INPUT_POST, 'species');//species
                $category = filter_input(INPUT_POST, 'category-sex');//category
                $age_of_birds = filter_input(INPUT_POST, 'age-of-birds');//age
                $cfc_cert = filter_input(INPUT_POST, 'certification');//cfc_cert
                
                //insert values into the database
                $poultryFlockQuery = "INSERT INTO `poultry_flock` (kg_per_bird,species,category,age,cfc_cert,barn_number_,e_code_,submission_date_,vet_name) "
               	. "VALUES ('$kg_per_bird','$species', '$category','$age_of_birds','$cfc_cert','$barn_number','$producer_code_quota','$submission_date','$vet_name')";
                $resultPoultry = mysqli_query($flockCon, $poultryFlockQuery);


                
//**********Section A*********************************
				//if button is clicked and the first field filled                   
               $q1Answer = filter_input(INPUT_POST, 'question-1');
               if($q1Answer == yes){
               	//set variables from form submission
               	$question1 = 1;//to fill in the question attribute of medications
               	$question1a = filter_input(INPUT_POST,'question-1-a');//medication_name
               	$question1d = filter_input(INPUT_POST,'question-1-d');//withdrawal_period
               	$question1e = filter_input(INPUT_POST,'question-1-e');//safe_marketing_date
               	//insert values into the database
                $question1Query = "INSERT INTO `medications` (medication_name,withdrawal_period,safe_marketing_date,question,prescribed_by,barn_number_,e_code_,submission_date_)
                VALUES ('$question1a','$question1d','$question1e','$question1','$vet_name','$barn_number','$producer_code_quota','$submission_date')";
               	$resultQuestion1 = mysqli_query($flockCon, $question1Query);
               }
               
               $q2Answer = filter_input(INPUT_POST, 'question-2');
               if($q2Answer == "yes"){
               	$question2 = 2;
               	$question2a = filter_input(INPUT_POST,'question-2-a');//medication_name
               	$question2b = filter_input(INPUT_POST,'question-2-b');//dose
               	$question2d = filter_input(INPUT_POST,'question-2-d');//withdrawal_period
               	$question2e = filter_input(INPUT_POST,'question-2-e');//safe_marketing_date
               	
                $question2Query = "INSERT INTO `medications` (medication_name,dose,withdrawal_period,safe_marketing_date,question,prescribed_by,barn_number_,e_code_,submission_date_)
                VALUES ('$question2a','$question2b','$question2d','$question2e','$question2','$vet_name','$barn_number','$producer_code_quota','$submission_date')";
               	$resultQuestion2 = mysqli_query($flockCon, $question2Query);             	
               }
               
               $q3Answer = filter_input(INPUT_POST, 'question-3');
               if($q3Answer == "yes"){
               	$question3 = 3;
               	$question3g = filter_input(INPUT_POST,'question-3-g');//disease_syndrome
               	
               	$question3Query = "INSERT INTO `disease_syndrome` (disease_syndrome_name,barn_number_,e_code_,submission_date_)"
               	."VALUES ('$question3g','$barn_number','$producer_code_quota','$submission_date')";
               	$resultQuestion3 = mysqli_query($flockCon, $question3Query);    
               	           	
               }
               $q4Answer = filter_input(INPUT_POST, 'question-4');
               if($q4Answer == "yes"){
               	$question4 = 4;
               	$question4a = filter_input(INPUT_POST,'question-4-a');//medication_Name
               	$question4b = filter_input(INPUT_POST,'question-4-b');//treatment_date_start
               	$question4c = filter_input(INPUT_POST,'question-4-c');//treatment_date_end
               	$question4d = filter_input(INPUT_POST,'question-4-d');//withdrawal_period
               	$question4e = filter_input(INPUT_POST,'question-4-e');//safe_marketing_date
               	$question4f = filter_input(INPUT_POST,'question-4-f');//dose
               	$question4g = filter_input(INPUT_POST,'question-4-g');//disease_syndrome_treated
               	
               	$question4Query = "INSERT INTO `medications` (medication_name,treatment_date_start,
               	treatment_date_end,withdrawal_period,safe_marketing_date,dose,disease_syndrome_treated,question,prescribed_by,barn_number_,e_code_,submission_date_)"
               	."VALUES ('$question4a','$question4b','$question4c','$question4d','$question4e','$question4f','$question4g','$question4','$vet_name','$barn_number','$producer_code_quota','$submission_date')";
               	$resultQuestion4 = mysqli_query($flockCon, $question4Query);    
               }
               
               $q5Answer = filter_input(INPUT_POST, 'question-5');
               if($q5Answer == "yes"){
               	$question5 = 5;
               	$question5a = filter_input(INPUT_POST,'question-5-a');//medication_Name
               	$question5d = filter_input(INPUT_POST,'question-5-d');//withdrawal_period
               	$question5e = filter_input(INPUT_POST,'question-5-e');//safe_marketing_date
               	
               	$question5Query = "INSERT INTO `medications` (medication_name,withdrawal_period,safe_marketing_date,question,prescribed_by,barn_number_,e_code_,submission_date_)"
               	."VALUES ('$question5a','$question5d','$question5e','$question5','$vet_name','$barn_number','$producer_code_quota','$submission_date')";
               	$resultQuestion5 = mysqli_query($flockCon, $question5Query);
                }
                              
                              
               $q6Answer = filter_input(INPUT_POST, 'question-6');
               if($q6Answer == "yes"){
               	$question6 = 6;
               	$question6a = filter_input(INPUT_POST,'question-6-a');//medication_Name
               	$question6d = filter_input(INPUT_POST,'question-6-d');//withdrawal_period
               	$question6e = filter_input(INPUT_POST,'question-6-e');//safe_marketing_date
               	
               	$question6Query = "INSERT INTO `medications` (medication_name,withdrawal_period,safe_marketing_date,question,prescribed_by,barn_number_,e_code_,submission_date_)"
               	."VALUES ('$question6a','$question6d','$question6e','$question6','$vet_name','$barn_number','$producer_code_quota','$submission_date')";
               	$resultQuestion6 = mysqli_query($flockCon, $question6Query);
               }
               
               
               $q7Answer = filter_input(INPUT_POST, 'question-7');
               if($q7Answer == "yes"){
               	$question7 = 7;
               	$question7a = filter_input(INPUT_POST,'question-7-a');//medication_Name
               	$question7b = filter_input(INPUT_POST,'question-7-b');//treatment_date_start
               	$question7c = filter_input(INPUT_POST,'question-7-c');//treatment_date_end
               	$question7d = filter_input(INPUT_POST,'question-7-d');//withdrawal_period
               	$question7e = filter_input(INPUT_POST,'question-7-e');//safe_marketing_date
               	$question7f = filter_input(INPUT_POST,'question-7-f');//dose
               	
               	$question7Query = "INSERT INTO `medications` (medication_name,treatment_date_start,"
               	."treatment_date_end,withdrawal_period,safe_marketing_date,dose,question,prescribed_by,barn_number_,e_code_,submission_date_)"
               	."VALUES ('$question7a','$question7b','$question7c','$question7d','$question7e','$question7f','$question7','$vet_name','$barn_number','$producer_code_quota','$submission_date')";
               	$resultQuestion7 = mysqli_query($flockCon, $question7Query);
               }

               
//**********Section B*********************************   
            
               //***************catching******************
               //set variables from form submission
               $planned_catching_date = filter_input(INPUT_POST, 'planned-catching-date');//planned_date
               $planned_catching_time = filter_input(INPUT_POST, 'planned-catching-time');//planned_time
               $actual_catching_time = filter_input(INPUT_POST, 'actual-catching-time');//actual_time
               //set variables from form submission
               $catchingQuery = "INSERT INTO `catching` (planned_date,planned_time,actual_time,barn_number_,e_code_,submission_date_) "
               		. "VALUES ('$planned_catching_date','$planned_catching_time', '$actual_catching_time','$barn_number','$producer_code_quota','$submission_date')";
               $resultCatching = mysqli_query($flockCon, $catchingQuery);
               
                
                
               //***************processing******************
               //set variables from form submission
               $planned_processing_day = filter_input(INPUT_POST, 'planned-processing-date');//planned_date
               $planned_processing_time = filter_input(INPUT_POST, 'planned-processing-time');//planned_time
               $last_water_access_time = filter_input(INPUT_POST, 'last-water-access-time');//last_water_access
               $feed_disruption = filter_input(INPUT_POST, 'feed-distruption');//feed_supply_disrupted
               $feed_withdrawal_time = filter_input(INPUT_POST, 'feed-withdrawal-time');//feed_withdraw_time
               $food_no_access_date = filter_input(INPUT_POST, 'food-no-access-date');//date_feed_not_accessible
               $floor_1_time = filter_input(INPUT_POST, 'floor-1-time');//floor1_time
               $floor_2_time = filter_input(INPUT_POST, 'floor-2-time');//floor2_time
               $floor_3_time = filter_input(INPUT_POST, 'floor-3-time');//floor3_time
               //set variables from form submission
               $processingQuery = "INSERT INTO `processing` (planned_date,planned_time,last_water_access,feed_supply_disrupted,feed_withdraw_time,date_feed_not_accessible,floor1_time,floor2_time,floor3_time,barn_number_,e_code_,submission_date_)"
               	. "VALUES ('$planned_processing_day','$planned_processing_time','$last_water_access_time','$feed_disruption','$feed_withdrawal_time','$food_no_access_date','$floor_1_time','$floor_2_time','$floor_3_time','$barn_number','$producer_code_quota','$submission_date')";
               $resultProcessing = mysqli_query($flockCon, $processingQuery);

                
            
            ?>
        </div>
    </body>
</html>