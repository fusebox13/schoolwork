<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<?php
    session_start();
    include 'utils/functions.php';
    include 'utils/db_connect.php';
    include 'login.php';
    
    /* Get the incoming submission id to render the correct comments.  Store the
     * id in the session which will only change upon clicking a new submission link.
     * This allows the user to come back to the comments page from any action with
     * maintaining the correct session id
     */
    if (isset($_REQUEST['subid'])) {
        $_SESSION['subid'] = $_REQUEST['subid'];
        showSubmissionHeader($_REQUEST['subid']);
    } 
    else if(isset($_SESSION['subid'])) {
        showSubmissionHeader($_SESSION['subid']);
    }  
    else {
        echo "ERROR: SUBMISSION HEADER DID NOT LOAD PROPERLY";
    }
    
    //Handle the incoming request
    if(isset($_REQUEST['action'])) {
        switch($_REQUEST['action']) {
            case 'delete':
                deleteComment();
                break;
            case 'edit':
                editComment();
                break;
            case 'add':
                addComment();
                break;
            default:
                break;
        }
    }
    
    //If there is a session id, show the comments
    if (isset($_SESSION['subid'])) {
        
        showComments($_SESSION['subid']);
    }
?>