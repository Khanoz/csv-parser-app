<?php
$arr_file_types = ['text/csv'];
  
if (!(in_array($_FILES['file0']['type'], $arr_file_types))) {
    echo "false";
    return;
}

if (!file_exists('uploads')) {
    mkdir('uploads', 0777);
}

$time = $_POST['time'];


$filename0 = $time.'_'.$_FILES['file0']['name'];
move_uploaded_file($_FILES['file0']['tmp_name'], 'uploads/'.$filename0);

$filename1 = ($time+5).'_'.$_FILES['file1']['name'];
move_uploaded_file($_FILES['file1']['tmp_name'], 'uploads/'.$filename1);

die;