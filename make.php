<?php

$options = getopt('', array('json::', 'csv::'));
if(count($options) == 0) {
  die("Usage php make.php --json | --csv\n");
}

print "Using config.json from current directory ...\n";

$host = "localhost";
$user = "root";
$pass = "root";
$db   = "countries";


$conn = mysqli_connect( $host, $user, $pass, $db );
if( mysqli_connect_errno() ) {
    die( mysqli_connect_error() );
}
if ( !$conn->set_charset("utf8") ) {
    die(sprintf("Error loading character set utf8: %s\n", $conn->error));
}

if(isset($options['json'])) {
    $cur = $conn->query( "SELECT * FROM countries" );
    $arr = array();

    while( $row = $cur->fetch_object() ) {
        $arr[] = $row;
   }
   echo json_encode($arr);
} else if(isset($options['csv'])) {
    $cur = $conn->query( "SELECT code2l,code3l,name,long_name,flag_32,flag_128 FROM countries" );
    $arr = array( array( 'ISO 3166 2-letter', 'ISO 3166 3-letter', 'Common name', 'Official name', 'Small flag', 'Large flag' ) );

    while( $row = $cur->fetch_array(MYSQLI_NUM) ) {
        $arr[] = $row;
    }
    print "Writing data to csv/countries.csv\n"; 
    $fp = fopen(dirname(__FILE__) . '/csv/countries.csv', 'w');
    foreach( $arr as $row ) {
        fputcsv( $fp, $row );
    }
    fclose($fp);
}


$conn->close();
