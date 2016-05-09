<?php

//$con=mysqli_connect("localhost","root","","project");
//database's name
    define("DATABASE", "project");
    
    // your database's server
    define("SERVER", "localhost");
    // your database's username
    define("USERNAME", "root");
    
    //To query the database without SQL injection.
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);
        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);
        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME);
                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }
        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }
        // execute SQL statement
        $results = $statement->execute($parameters);
        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }
$repurl = $_POST['reported_URL'];
$repname = $_POST['reporter_name'];
$repmail = $_POST['reporter_email'];
$repres = $_POST['reason1'];


$checking = query("SELECT * FROM activeurl WHERE ToCheck=? AND email=?",$repurl,$repmail);
$count = count($checking);
if ($count===0) {
	$ins1 = query("INSERT INTO activeurl (name, email, reason, ToCheck) VALUES (?,?,?,?)", $repname, $repmail, $repres, $repurl);
	//header("Location:Anti-Phishing-Using-localStorage-master - Copy/afterreport/thankyou.html");
  //exit();
}
/*
else{
	header("Location:Anti-Phishing-Using-localStorage-master - Copy/afterreport/alreadypresent.html");
  //exit();
}
*/
$chkcount = query("SELECT COUNT(*) from activeurl GROUP BY ToCheck");
	echo '<pre>'; print_r($chkcount); echo '</pre>';

foreach($chkcount as $chkc) {
	if ($chkc['COUNT(*)']>1) {
		$put = query("INSERT INTO known (url) VALUES(?)", $repurl);
		break;
	}
}

if ($count===0) {
	//$ins1 = query("INSERT INTO activeurl (name, email, reason, ToCheck) VALUES (?,?,?,?)", $repname, $repmail, $repres, $repurl);
	header("Location:Anti-Phishing-Using-localStorage-master - Copy/afterreport/thankyou.html");
  exit();
}

else{
	header("Location:Anti-Phishing-Using-localStorage-master - Copy/afterreport/alreadypresent.html");
  exit();
}


// Check connection
/*if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

mysqli_query($con,"INSERT INTO activeurl (name, email, reason, ToCheck) VALUES ('$repname', '$repmail', '$repres', '$repurl')");

mysqli_close($con);*/
?>