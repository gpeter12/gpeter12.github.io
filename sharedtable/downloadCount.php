<?php
    $servername = "mysql.caesar.elte.hu";
    $username = "gpeter12";
    $password = "h0Vv4PFfnivPim3y";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=gpeter12", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

    if(isset($_GET['type'])) {
        $type = $_GET['type'];
        $sqlcmd = "INSERT INTO downloads values(0,'".$_SERVER['REMOTE_ADDR']."','".((new DateTime('now'))->format('Y-m-d H:i:s'))."','".$type."')";
        if ($conn->query($sqlcmd) === TRUE) {
            echo "New record created successfully";
        } else {
            //echo "Error: " . $sql . "<br>" . $conn->error;
        }
        /*if(!file_put_contents("./reports/downloads",."  ".((new DateTime('now'))->format('Y-m-d H:i:s'))." ".$type."\n",FILE_APPEND)){
            //echo "not appended";
        }*/
        
    } else {
        //echo "not isset";
    }
    
    if(isset($_GET['dlink'])) {
        $dlLink = $_GET['dlink'];
    }
    
    //header("Location: ".$dlLink);
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Shared Table GYIK</title>
        <link rel="stylesheet" type="text/css" href="st.css">
        <script type="text/javascript">
            window.location.href = '<?php echo $dlLink ?>';
        </script>
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
            <p> Át leszel irányítva a kért fájlhoz... Ha mégsem, a letöltési linked: 
                <?php echo "<a href=".$dlLink.">".$dlink."</a>" ?>
             </p>
        </article>
        
    
    </body>
</html>
