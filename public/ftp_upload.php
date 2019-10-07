<?php

$ftp_server = "117.58.241.164";
$ftp_user = "MRC";
$ftp_password = "SQ$59%2pQ";
$file = "";
$remote_file = "";


$ftp_connection = ftp_connect($ftp_server) or die("Could not connect to the FTP server");

$login = ftp_login($ftp_connection, $ftp_user, $ftp_password);

$dir = "reports/";
$file_name = "ftp_upload.txt";

$file = $dir.$file_name;

//turn passive mode on
ftp_pasv($ftp_connection , true);

if(ftp_put($ftp_connection, $file_name, $file, FTP_BINARY)){
	echo "File uploaded";
} else {
	echo "Failed";
}

ftp_close($ftp_connection);