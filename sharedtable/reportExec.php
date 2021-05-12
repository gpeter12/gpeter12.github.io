<?php
    function getLastReportDateTime($conn)
    {
        $sqlcmd = "select date from date";
        $result = $conn->query($sqlcmd);
        $row = $result->fetch_assoc();
        return $row["date"];
    }

    function setLastReportDateTime($conn)
    {
        $sql = "UPDATE date SET date='".(new DateTime('now'))->format('Y-m-d H:i:s')."' WHERE id=1";
        if(!($conn->query($sql)===TRUE)){
            echo "update date error";
        }
    }
    
    
    $servername = "mysql.caesar.elte.hu";
    $username = "gpeter12";
    $password = "h0Vv4PFfnivPim3y";

    // Create connection
    $conn = new mysqli($servername, $username, $password, "gpeter12");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    /*if (!$conn->set_charset("utf8")) {
        printf("Error loading character set utf8: %s\n", $mysqli->error);
        exit();
    }*/

    
    $errorDesc = utf8_decode($_POST["errorDescription"]);
    $errorLog = utf8_decode($_POST["errorLog"]);
    $restult = "Ismeretlen hiba";

    echo $_POST["errorDescription"];

    $isIntervalValid = FALSE;
    $isReportSizeValid = FALSE;

    if((new DateTime('now')) > ((new DateTime(getLastReportDateTime($conn)))->add(new DateInterval('PT60S')))){
        $isIntervalValid = TRUE;
    } else {
        $restult = "Sajnos biztonsági okokból csak 1 percenként lehet jelentést leadni. Kérlek várj egy kicsit, nemrég előtted jelentett valaki. Kösznöm a türelmed, és a segítséged!";
    }

    if(strlen($errorDesc) <= 8000 && strlen($errorLog) <= 200000) {
        $isReportSizeValid = TRUE;
    } else {
        $restult = "A szerver nem tárol el a megengedettnél nagyobb jelentést!";
    }
    //$isIntervalValid = TRUE;
    if($isReportSizeValid && $isIntervalValid) {
        $timeStamp = 'Created date is ' . date('Y-m-d H:i:s').'\n'.$_SERVER['REMOTE_ADDR'].'\n';
        $reportName = uniqid("report_",FALSE);

        $sqlcmd = "INSERT INTO reports values(0,'".$timeStamp.$errorDesc."\n\n-------------LOG----------\n\n".$errorLog."')";
        $conn->query($sqlcmd);

        $restult = "A jelentés leadásra került! Köszönöm a segítséged! :)";
        setLastReportDateTime($conn);
    }


?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Shared Table GYIK</title>
        <link rel="stylesheet" type="text/css" href="st.css">
    </head>
    <body>
        <nav>
                <a href="index.html">Főoldal</a>
                <a href="faq.html">GYIK</a>
                <a href="download.html">Letöltés</a>
                <a href="errorReport.html">Hibajelentés/észrevételek</a>
        </nav>
        <br><br><br><br><br>

            
        <article>
            <p> <?php echo $restult; ?> </p>
        </article>
        
    
    </body>
</html>
