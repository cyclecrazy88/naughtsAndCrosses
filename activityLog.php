<?php
# Log file the activity logging - This is here as whilst it's a web-server the
# output can't be pushed to console.
function logActivity($inputData){
	if (!file_exists('./activityLog/'))
		mkdir('./activityLog/');
	$fileHandle = fopen('./activityLog/data.log','a');
	fputs($fileHandle , trim($inputData)."\n" , 1024 );
	fclose($fileHandle);
}
?>
