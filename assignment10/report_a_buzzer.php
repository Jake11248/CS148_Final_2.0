<?php
/*
 * 
 * if the data is incorrect we flag the errors.
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 * Last updated on: October 17, 2014
 * 
 * Modified by Jake Warshaw
 * 


 * I am using a surrogate key for demonstration, 
 * email would make a good primary key as well which would prevent someone
 * from entering an email address in more than one record.
 */
$debug = true;{
print "<p>above section 1 </p>";
}

include "top.php";

$debug = true;{
print "<p>top ran </p>";
}
include "nav.php";
$debug = true;{
print "<p>nav ran </p>";
}
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
$debug = true;
if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}
if ($debug)
    print "<p>DEBUG MODE IS ON</p>";


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
//Initialize the array 
$data1 = array();
$data2 = array();
$data3 = array();

// // Initialize variables one for each form element
// in the order they appear on the form
//reporter questions of the form  
$RepFirstName = "";
$RepLastName = "";
$RepZip = "";
$RepEmail = "jwarshaw@uvm.edu";

//perpetrator section of the form 
$PerpCarMake = " ";
$PerpCarColor = " ";
$PerpPlate = " ";
$PerpPlateState = " ";

//incident section of the form 
$IncZip = " ";
$IncDate = " ";
$IncStreet = " ";
$IncTime = " ";
$IncDesc = " ";
$IncInj = " ";
$IncInjSev = " ";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.

//reporter questions of the form  
$RepEmailERROR = false;
$RepFirstNameERROR = false;
$RepLastNameERROR = false;
$RepZipERROR = false;

//perpetrator section of the form 
$PerpCarMakeERROR = false;
$PerpCarColorERROR = false;
$PerpPlateERROR = false;
$PerpPlateStateERROR = false;

//incident section of the form 
$IncZipERROR = false;
$IncDateERROR = false;
$IncStreetERROR = false;
$IncTimeERROR = false;
$IncDescERROR = false;
$IncInjERROR = false;
$IncInjSevERROR = false;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

// used for building email message to be sent and displayed
$mailed = false;

/*
//DO I NEED THIS IF I AM ONLY SENDING ONE EMAIL AM NOT TRYING TO HAVE POEPLE RIGESTER FOR NAYTHING!!!!!!!
$messageA = "";
$messageB = "";
$messageC = "";
*/
$message = "";
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2a Security
//
    if (!securityCheck(true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2b Sanitize (clean) data
// remove any potential JavaScript or html code from users input on the
// form. Note it is best to follow the same order as declared in section 1c.
 
//reporter questiosnf rom the form  
    $RepEmail = filter_var($_POST["txtRepEmail"], FILTER_SANITIZE_EMAIL);
    
    $RepFirstName = htmlentities($_POST["txtRepFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $RepFirstName;
    
    $RepLastName = htmlentities($_POST["txtRepLastName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $RepLastName;

    $RepZip = htmlentities($_POST["txtRepZip"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $RepZip;
    
    
//Perpetrator section of the form 
    $PerpCarMake = htmlentities($_POST["lstPerpCarMake"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $PerpCarMake;
    
    $PerpCarColor = htmlentities($_POST["lstPerpCarColor"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $PerpCarColor;
    
    $PerpPlate = htmlentities($_POST["txtPerpPlate"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $PerpPlate;
    
    $PerpPlateState = htmlentities($_POST["lstPerpPlateState"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $PerpPlateState;
    
//Incident Section of the form 
    $IncZip = htmlentities($_POST["txtIncZip"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $IncZip;
    
    $IncDate = htmlentities($_POST["txtIncDate"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $IncDate;

    $IncStreet = htmlentities($_POST["txtIncStreet"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $IncStreet;
    
    $IncTime = htmlentities($_POST["txtIncTime"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $IncTime;
        
    $IncDesc = htmlentities($_POST["txtIncDesc"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $IncDesc;
    
    $IncInj = htmlentities($_POST["txtIncInj"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $IncInj;
    
    $IncInjSev = htmlentities($_POST["txtIncInjSev"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $IncInjSev;
    
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2c Validation
//
// Validation section. Check each value for possible errors, empty or
// not what we expect. You will need an IF block for each element you will
// check (see above section 1c and 1d). The if blocks should also be in the
// order that the elements appear on your form so that the error messages
// will be in the order they appear. errorMsg will be displayed on the form
// see section 3b. The error flag ($emailERROR) will be used in section 3c.

//Reporter section on the form 
    if ($RepEmail == "") {
        $errorMsg[] = "Please enter your email address";
        $RepEmailERROR = true;
    } elseif (!verifyEmail($RepEmail)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $RepEmailERROR = true;
    }
    
    if ($RepFirstName == "") {
        $errorMsg[] = "Please enter Your first name ";
        $RepFirstNameERROR = true;
    } elseif (!verifyAlphaNum($RepFirstName)) {
        $errorMsg[] = "Your first name  appears to be incorrect.";
        $RepFirstNameERROR = true;
    }
    
    if ($RepLastName == "") {
        $errorMsg[] = "Please enter a last name";
        $RepLastNameERROR = true;
    } elseif (!verifyAlphaNum($RepLastName)) {
        $errorMsg[] = "Your last name  appears to be incorrect.";
        $RepLastNameERROR = true;
    }
   
    if ($RepZip == "") {
        $errorMsg[] = "Please enter your zip code";
        $RepZipERROR = true;
    } elseif (!verifyAlphaNum($RepZip)) {
        $errorMsg[] = "Your zip code appears to be incorrect.";
        $RepZipERROR = true;
    }
    
     
    
 //Perpetrator Section of the Form 
    if ($PerpCarMake == "") {
    $errorMsg[] = "Please enter the buzzer's car's make";
        $PerpCarMakeERROR = true;
    } elseif (!verifyAlphaNum($PerpCarMake)) {
        $errorMsg[] = "Your first name  appears to be incorrect.";
        $PerpCarMakeERROR = true;
    }
    
    if ($PerpCarColor == "") {
        $errorMsg[] = "Please enter the color of the buzzer's car";
        $PerpCarColorERROR = true;
    } elseif (!verifyAlphaNum($PerpCarColor)) {
        $errorMsg[] = "The car color seems to be incorrect.";
        $PerpCarColorERROR = true;
    }
   
    if ($PerpPlate == "") {
        $errorMsg[] = "Please enter the license plate of the buzzer";
        $PerpPlateERROR = true;
    } elseif (!verifyAlphaNum($PerpPlate)) {
        $errorMsg[] = "The buzzers license plate appears to be incorrect.";
        $PerpPlateERROR = true;
    }
    
    if ($PerpPlateState == "") {
        $errorMsg[] = "Please enter the state of the buzzer's license plate";
        $PerpPlateStateERROR = true;
    } elseif (!verifyAlphaNum($PerpPlateState)) {
        $errorMsg[] = "The state of the buzzers license plate appears to be incorrect.";
        $PerpPlateStateERROR = true;
    }
    
    
//Incident Section of the Form 
    if ($IncZip == "") {
    $errorMsg[] = "Please enter the zip code where the incident occured";
        $IncZipERROR = true;
    } elseif (!verifyAlphaNum($IncZip)) {
        $errorMsg[] = "The incident zip code appears to be incorrect.";
        $IncZipERROR = true;
    }
    
    if ($IncDate == "") {
        $errorMsg[] = "Please enter the date when the inncident occured";
        $IncDateERROR = true;
    } elseif (!verifyAlphaNum($IncDate)) {
        $errorMsg[] = "The incident date seems to be incorrect.";
        $IncDateERROR = true;
    }
   
    if ($IncDesc == "") {
        $errorMsg[] = "Please enter the description of the incident";
        $IncDescERROR = true;
    } elseif (!verifyAlphaNum($IncDesc)) {
        $errorMsg[] = "The description of the incident appears to be incorrect.";
        $IncDescERROR = true;
    }
    
    if ($IncInj == "") {
        $errorMsg[] = "Please enter if there were any injuries associated with the incident";
        $IncInjERROR = true;
    } elseif (!verifyAlphaNum($IncInj)) {
        $errorMsg[] = "The injuries appears to be incorrect.";
        $IncInjERROR = true;
    }
    
    if ($IncInjSev == "") {
        $errorMsg[] = "Please enter the severity of the injuries";
        $IncInjSevERROR = true;
    } elseif (!verifyAlphaNum($IncInjSev)) {
        $errorMsg[] = "The injury serverity seems to be incorrect.";
        $IncInjSevERROR = true;
    }
   
    if ($IncStreet == "") {
        $errorMsg[] = "Please enter the street the buzzing took place on";
        $IncStreetERROR = true;
    } elseif (!verifyAlphaNum($IncIncStreet)) {
        $errorMsg[] = "The street the buzzing took place on appears to be incorrect.";
        $IncStreetERROR = true;
    }
    
    if ($IncTime == "") {
        $errorMsg[] = "Please enter the time the buzzing took place";
        $IncTimeERROR = true;
    } elseif (!verifyAlphaNum($IncTime)) {
        $errorMsg[] = "The incident time appears to be incorrect.";
        $IncTimeERROR = true;
    }
        
    
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2d Process Form - Passed Validation
//
// Process for when the form passes validation (the errorMsg array is empty)
//
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";

       //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //
        
            $dataEntered = false;
            try {     
            $thisDatabase->db->beginTransaction();
            
            //Reporter table
            $query1 = 'INSERT INTO tblReporter SET pmkRepEmail = ?, fldRepFName = ?, ';
            $query1 .= 'fldRepLName = ?, fnkRepZip = ? ';
            $data1[] = $RepEmail;
            $data1[] = $RepFirstName;
            $data1[] = $RepLastName;
            $data1[] = $RepZip;
            if($debug) {
                print "<p>sql1 " . $query1;
                print"<p><pre>";
                print_r($data1);
                print"</pre></p>";
            }

            $results1 = $thisDatabase->insert($query1, $data1);


            // Incident Table 
            $query2 = 'INSERT INTO  tblPerpetrator SET fldPerpCarMake = ?, fldPerpCarColor = ?, ';
            $query2 .= 'fldPerpPlate = ?, fldPerpPlateState = ? ';
            $data2[] = $PerpCarMake;
            $data2[] = $PerpCarColor;
            $data2[] = $PerpPlate;
            $data2[] = $PerpPlateState;
            if($debug) {
                print "<p>sql2 " . $query2;
                print"<p><pre>";
                print_r($data2);
                print"</pre></p>";
            }

            $results2 = $thisDatabase->insert($query2, $data2);
            
            // Incident Table 
            $query3 = 'INSERT INTO  tblPerpetrator SET fldPerpCarMake = ?, fldPerpCarColor = ?, ';
            $query3 .= 'fldPerpPlate = ?, fldPerpPlateState = ? ';
            $data3[] = $PerpCarMake;
            $data3[] = $PerpCarColor;
            $data3[] = $PerpPlate;
            $data3[] = $PerpPlateState;
            if($debug) {
                print "<p>sql3 " . $query3;
                print"<p><pre>";
                print_r($data2);
                print"</pre></p>";
            }

            $results3 = $thisDatabase->insert($query3, $data3);
            
            
// all sql statements are done so lets commit to our changes
            $dataEntered = $thisDatabase->db->commit();
            $dataEntered = true;
            if ($debug)
                print "<p>transaction complete ";
        } catch (PDOExecption $e) {
            $thisDatabase->db->rollback();
            if ($debug)
                print "Error!: " . $e->getMessage() . "</br>";
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
        }


        
        // If the transaction was successful, give success message
        if ($dataEntered) {
            if ($debug)
                print "<p>data entered now prepare keys ";
            //#################################################################
            // create a key value for confirmation
/*
            $query = "SELECT fldDateJoined FROM tblRegister WHERE pkRegisterId=" . $primaryKey;
            $results = $thisDatabase->select($query);

            $dateSubmitted = $results[0]["fldDateJoined"];

            $key1 = sha1($dateSubmitted);
            $key2 = $primaryKey;

            if ($debug)
                print "<p>key 1: " . $key1;
            if ($debug)
                print "<p>key 2: " . $key2;
*/

            //#################################################################
            //
            //Put forms information into a variable to print on the screen
            //

            $messageA = '<h2>Thank you for registering.</h2>';

            $messageB = "<p>Click this link to confirm your registration: ";
            $messageB .= '<a href="' . $domain . $path_parts["dirname"] . '/confirmation.php?q=' . $key1 . '&amp;w=' . $key2 . '">Confirm Registration</a></p>';
            $messageB .= "<p>or copy and paste this url into a web browser: ";
            $messageB .= $domain . $path_parts["dirname"] . '/confirmation.php?q=' . $key1 . '&amp;w=' . $key2 . "</p>";

            $messageC .= "<p><b>Email Address:</b><i>   " . $email . "</i></p>";

            //##############################################################
            //
            // email the form's information
            //
            $to = $email; // the person who filled out the form
            $cc = "";
            $bcc = "";
            $from = "Assignment 6.0 Resgistration <jake@modifiedcode.com>";
            $subject = "Registration Email for Assigment 6.0";

            $mailed = sendMail($to, $cc, $bcc, $from, $subject, $messageA . $messageB . $messageC);
        } //data entered  
    } // end form is valid
} // ends if form was submitted.
//#############################################################################
//
/*
  
         //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).
        $message = '<h2>Thank You For Recording this Buzzer</h2>';
        foreach ($_POST as $key => $value) {
            $message .= "<p>";
            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
            foreach ($camelCase as $one) {
                $message .= $one . " ";
            }
            $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        $from = "Buzzkiller <noreply@BuzzKiller.com>";
        // subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "Buzzing Reported: " . $todaysDate;
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
        
    } // end form is valid
    
} // ends if form was submitted.
        
        
// SECTION 3 Display Form
//
 * 
 */

?>
<article id="main">
    <?php
//####################################
//
// SECTION 3a.
//
//
//
//
// If its the first time coming to the form or there are errors we are going
// to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
        print "<h1>Your Request has ";
        if (!$mailed) {
            print "not ";
        }
        print "been confirmation and an email has been sent to ";
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p>To: " . $email . "</p>";
        //print "<p>Mail Message:</p>"; //Look here to add in whether I want the oage ot say antying after it has been submitted
        //print $messageA . $messageC;
    } else {
//####################################
//
// SECTION 3b Error Messages
//
// display any error messages before we print out the form
        if ($errorMsg) {
            print '<div id="errors">';
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }
//####################################
//
//Pring out  array
 if ($debug){     
     $results = $thisDatabase->select($query, $data);
 

    
     /* ##### Step four
     * prepare output and loop through array
 
     */
   //count numebr of records if debug is truend on (uncomment when run live site) 

    $numberRecords = count($results); 

    
    print "<h2>Total Records: " . $numberRecords . "</h2>";
    
    //print query so I can see what is happeneing 
    //DELETE BEFORE SUBMITTING 
   
    
    //if debug is turned on print the query out again 
  
         print "<h3>SQL: " . $query . "</h3>";
    
    
    print "<table>";

    $firstTime = true;

    /* since it is associative array display the field names */
    foreach ($results as $row) {
        if ($firstTime) {
            print "<thead><tr>";
            $keys = array_keys($row);
            foreach ($keys as $key) {
                if (!is_int($key)) {
                    print "<th>" . $key . "</th>";
                }
            }
            print "</tr>";
            $firstTime = false;
        }
        
        /* display the data, the array is both associative and index so we are
         *  skipping the index otherwise records are doubled up */
        print "<tr>";
        foreach ($row as $field => $value) {
            if (!is_int($field)) {
                print "<td>" . $value . "</td>";
            }
        }
        print "</tr>";
    }
    print "</table>";

   }


// SECTION 3c html Form
//
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:
          value="<?php print $email; ?>
          this makes the form sticky by displaying either the initial default value (line 35)
          or the value they typed in (line 84)
          NOTE this line:
          <?php if($emailERROR) print 'class="mistake"'; ?>
          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.
         */
        ?>
        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmReportBuzzer">
            <fieldset class="wrapper">
                <legend class="main_legend">Report a Buzzer</legend>
                <fieldset class="wrapperTwo">
                    <legend>Please complete the following form</legend>

  
                    
 <!-- Info about the reporter -->                   
                    <fieldset class="reporter"> 
                        <legend>Information About You</legend>
                        
                          <!-- Email --> 
                        <label for="txtRepEmail" class="required">Email
                            <input type="text" id="txtRepEmail" name="txtRepEmail"
                                   value="<?php print $RepEmail; ?>"
                                   tabindex="100" maxlength="45" placeholder="Enter a valid email address"
                                   <?php if ($RepEmailERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>

                        <!--First Name --> 
                        <label for="txtRepFirstName" class="required">First Name
                            <input type="text" id="txtRepFirstName" name="txtRepFirstName"
                                   value="<?php print $RepFirstName; ?>"
                                   tabindex="120" maxlength="30" placeholder="Enter Your First Name "
                                   <?php if ($RepFirstNameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        <!--Last Name --> 
                        <label for="txtRepLastName" class="required">Last Name
                            <input type="text" id="txtRepLastName" name="txtRepLastName"
                                   value="<?php print $RepLastName; ?>"
                                   tabindex="130" maxlength="30" placeholder="Enter Your Last Name "
                                   <?php if ($RepLastNameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        <!--Zip --> 
                        <label for="txtRepZip" class="required">Zip Code 
                            <input type="text" id="txtRepZip" name="txtRepZip"
                                   value="<?php print $RepZip; ?>"
                                   tabindex="140" maxlength="30" placeholder="Enter Your Zip Code"
                                   <?php if ($RepZipERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        
                    </fieldset> <!-- ends information about reporter -->
 
                                    
<!-- Info about the buzzer -->                    
                     <fieldset class="buzzer"> 
                        <legend>Information About The Buzzer</legend>
                  <!--car Make -->     
                        <label id="lstmake"> Car Make
                        <select id="listmake" 
                                name="lstPerpCarMake" 
                                tabindex="210" 
                                size="1"> 
                        
                            <option>  </option>
                            
                             <?php 
                           
                            //write the query that will generate the list box 
                            $query = 'SELECT DISTINCT pmkMake FROM tblMake ';
                            $query .= 'where pmkMake not LIKE ""';
                           
                           if($debug){
                           print "<p>SQL: " .$query;
                           print "<p><pre>";
                            
                           var_dump($resuts);
                           }
                            
                            
                            //get eash row of the query and generate a list box element for it
                             $results = $thisDatabase->select($query);

                            foreach($results as $row){
                                print'<option> '; 
                                if($PerpCarMake == $row["pmkMake"]) print ' selected = "selected" ';
                                print "$row[pmkMake]</option>";
                            }
                            ?>

                         </select>
                            
                   <!--car color -->         
                        <label id="lstColor"> Car Color
                        <select id="listColor" 
                                name="lstPerpCarColor" 
                                tabindex="220" 
                                size="1"> 
                        
                            <option>  </option>
                            
                             <?php 
                           
                            //write the query that will generate the list box 
                            $query = 'SELECT DISTINCT pmkColor FROM tblColor ';
                            $query .= 'where pmkColor not LIKE ""';
                           
                           if($debug){
                           print "<p>SQL: " .$query;
                           print "<p><pre>";
                            
                           var_dump($resuts);
                           }
                            
                            
                            //get eash row of the query and generate a list box element for it
                             $results = $thisDatabase->select($query);

                            foreach($results as $row){
                                print'<option> '; 
                                if($PerpCarColor == $row["pmkColor"]) print ' selected = "selected" ';
                                print "$row[pmkColor]</option>";
                            }
                            ?>

                         </select>
                            
                            
                   <!-- License Plate Number --> 
                        <label for="txtPerpPlate" class="required">License Plate Number
                            <input type="text" id="txtPerpPlate" name="txtPerpPlate"
                                   value="<?php print $PerpPlate; ?>"
                                   tabindex="230" maxlength="45" placeholder="Enter a valid License Plate Number"
                                   <?php if ($PerpPlateERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                   
                 <!-- License Plate State --> 
                        <label id="lstPerpPlateState"> License Plate State 
                        <select id="listPerpPlateState" 
                                name="lstPerpPlateState" 
                                tabindex="240" 
                                size="1"> 
                        
                            <option>  </option>
                            
                             <?php 
                           
                            //write the query that will generate the list box 
                            $query = 'SELECT DISTINCT pmkStateName FROM tblState ';
                            $query .= 'where pmkStateName not LIKE ""';
                           
                           if($debug){
                           print "<p>SQL: " .$query;
                           print "<p><pre>";
                            
                           var_dump($resuts);
                           }
                            
                            
                            //get eash row of the query and generate a list box element for it
                             $results = $thisDatabase->select($query);

                            foreach($results as $row){
                                print'<option> '; 
                                if($State == $row["pmkStateName"]) print ' selected = "selected" ';
                                print "$row[pmkStateName]</option>";
                            }
                            ?>

                         </select>
                        
                    </fieldset> <!-- ends information about  buzzer -->
                    
                    
                    
 <!-- Info about the Incident -->
                     <fieldset class="incident"> 
                        <legend>Information About The Incident</legend>
                        
                        <!--Incident Zip --> 
                        <label for="txtIncZip" class="required">Zip Code Where Incident Occurred 
                            <input type="text" id="txtIncZip" name="txtIncZip"
                                   value="<?php print $incZip; ?>"
                                   tabindex="300" maxlength="30" placeholder="Enter The Zip Code of the Incident"
                                   <?php if ($IncZipERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        <!--Incident Street  -->
                        <label for="txtIncStreet" class="required">Street Where Incident Occurred 
                            <input type="text" id="txtIncStreet" name="txtIncStreet"
                                   value="<?php print $incStreet; ?>"
                                   tabindex="305" maxlength="30" placeholder="Enter The Street of the Incident"
                                   <?php if ($IncStreetERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        
                        <!--Incident Date --> 
                        <label for="txtIncDate" class="required">Date When The Incident Occurred 
                            <input type="text" id="txtIncDate" name="txtIncDate"
                                   value="<?php print $incDate; ?>"
                                   tabindex="310" maxlength="30" placeholder="Enter The Date of the Incident"
                                   <?php if ($IncDateERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        <!--Incident Time -->
                        <label id="lstIncTime"> Time of Incident to the nearest Half Hour
                        <select id="listIncTime" 
                                name="lstIncTime" 
                                tabindex="315" 
                                size="1"> 
                        
                            <option>  </option>
                            
                             <?php 
                           
                            //write the query that will generate the list box 
                            $query = 'SELECT DISTINCT pmkTime FROM tblTime ';
                            $query .= 'where pmkTime not LIKE ""';
                           
                           if($debug){
                           print "<p>SQL: " .$query;
                           print "<p><pre>";
                            
                           var_dump($resuts);
                           }
                            
                            
                            //get eash row of the query and generate a list box element for it
                             $results = $thisDatabase->select($query);

                            foreach($results as $row){
                                print'<option> '; 
                                if($State == $row["pmkTime"]) print ' selected = "selected" ';
                                print "$row[pmkTime]</option>";
                            }
                            ?>

                         </select>
                        
                        <!--Incident Description --> 
                        <label for="txtIncDesc" class="required">Short Description of The Incident 
                            <input type="text" id="txtIncDesc" name="txtIncDesc"
                                   value="<?php print $incDesc; ?>"
                                   tabindex="320" maxlength="30" placeholder="Enter a Description of the Incident"
                                   <?php if ($IncDescERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        <!--Injuries Yes/No? -->

                         
                       <!--Injuries severity 1 -10  -->
                        
                    </fieldset> <!-- ends information about the incident -->
                    
                </fieldset> <!-- ends wrapper Two -->
                <fieldset class="buttons">
                    <legend></legend>
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Report Buzzer" tabindex="900" class="button">
                </fieldset> <!-- ends buttons -->
            </fieldset> <!-- Ends Wrapper -->
        </form>
    
    
        <?php
    } // end body submit
    ?>
</article>



<?php
include "footer.php";
if ($debug)
    print "<p>END OF PROCESSING</p>";
?>

</body>
</html>