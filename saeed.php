<html>
<head>
<title>7Learn.com > List Of Files In a folder</title>
<style type="text/css">
body, table {
font-family: tahoma;
font-size: 14px;
}
 
ul {
list-style: none;
line-height: 22px;
}
 
li.file {
color: #2f6d13;
background: transparent url("image/file.png") no-repeat left 3px;
padding-left: 24px;
}
 
li.folder {
color: #e6981c;
background: transparent url("image/folder.png") no-repeat left 3px;
padding-left: 24px;
}
 
</style>
</head>
<body>
<!------
Code By : Loghman Avand
Url : www.7Learn.com
------->
<?php
function getFileList($folderName, $fileType = "")
{
if (substr($folderName, strlen($folderName) - 1) != "/") {
$folderName .= '/';
}
 
echo '<h3>List of ' . $fileType . ' files in folder : <span style="color:brown">' . $folderName . '</span></h3>';
echo '<ul>';
foreach (glob($folderName . '*' . $fileType) as $filename) {
if (is_dir($filename)) {
$type = 'folder';
} else {
$type = 'file';
}
echo '<li class="' . $type . '">' . str_replace($folderName, '', $filename) . '</li>';
}
echo '</ul>';
}
 
// call the function
getFileList('files'); // list all files
getFileList('files','.png'); // list only png files
 
?>
 
</body>
</html>
