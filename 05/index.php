<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<?php
session_start();
include 'utils/functions.php';
include 'utils/db_connect.php';

//Handle the incoming action
switch ($action = getSubmissionAction()) {
    case 'submissions':
        $output='submissions';
        break;
    case 'addsubmission':
        addSubmission();
        $output='submissions';
        break;
    case 'deletesub':
        deleteSubmission();
        $output='submissions';
        break;
    case 'login':
        getLogin($_REQUEST['username'], $_REQUEST['password']);
        $output='submissions';
        break;
    case 'logout':
        logout();
        $output='submissions';
        break;
    case 'account':
        createAccount($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['passwordcopy']);
        $output ='submissions';
        break;
    default:
        $output='submissions';
        break;
   
}

include 'login.php';

//redirect to the proper PHP page which is dependent on the incoming action
if($output!='') {
    $output_filename = 'views/'.$output.'.php';
    if(file_exists($output_filename)){
        include($output_filename);
    }
}