<?php

$imageId = $_GET["imageid"];

$path = __DIR__.'/../../app/storage/photos/' . $imageId; 

 // Prepare content headers
$finfo = finfo_open(FILEINFO_MIME_TYPE); 
$mime = finfo_file($finfo, $path);
$length = filesize($path);

header ("content-type: $mime"); 
header ("content-length: $length"); 

// @TODO: Cache images generated from this php file

readfile($path); 
exit;
?> 