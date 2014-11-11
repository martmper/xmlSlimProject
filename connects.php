<?php
header('Content-Type: text/html; charset=utf-8');
$serverName = "202.28.117.5";
$username = "suchjo";
$password = "$123ccKKU$";
$CharacterSet = "UTF-8";

///////////////////////////////// 
//$sercthFirthname = "พีรสิทธิ์";
//$sercthLastname = "คำนวณศิลป์";
$sercthFirthname = $_POST['FirstName']; 
$sercthLastname = $_POST['LastName']; 
////////////////////////////////
$paramFirthname = "STF_FNAME_1";
$paramLastname = "STF_LNAME_1";
////////////////////////////////
$stack = array();
////////////////////////////////

$connectionInfo = array( "Database"=>"SH_RESKKU", "UID"=>$username, "PWD"=>$password, "CharacterSet"=>$CharacterSet);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
    if($conn){
        echo "<h1>Connection succestful</h1>";
        echo "SerchName = ".$sercthFirthname."  ".$sercthLastname."<br/>";
    }else{
        echo "<h1>Connection fell</h1>";
        die( print_r(sqlsrv_errors(), true));
    }

$sql = "SELECT * FROM dbo.VIEWS_JOURNAL";
$stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    for($i=1;$i<=15;$i++){
        $paramFirthname =  substr($paramFirthname,0,10);
        $paramFirthname .= $i;
        $paramLastname =  substr($paramLastname,0,10);
        $paramLastname .= $i;
        
        if($row[$paramFirthname] == $sercthFirthname || $row[$paramLastname] == $sercthLastname){
//            echo "Title is : ".$row['JOURNAL_TITLE']."<br />";
            array_push($stack, $row['JOURNAL_TITLE']);
        }
    }
}   
echo json_encode($stack);
sqlsrv_free_stmt($stmt);
?> 
