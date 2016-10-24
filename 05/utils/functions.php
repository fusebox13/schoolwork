<?php
include 'utils/bcrypt.php';
$bcrypt = new Bcrypt(12);

/**
 * Validates URL to determine if the URL is valid
 * Only valid working URLS (not checking for 404) will be allowed
 * @param type $url
 * @return type
 */
function isValidUrl($url) {
    //Using a regex pattern from @diegoperini https://mathiasbynens.be/demo/url-regex
    $urlpattern = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS';
    return preg_match($urlpattern, $url);
    
}

/**
 * Some users might type www.google.com.  This prepares a full URL to be
 * sent for validation
 * @param type $url
 * @return type
 */
function prepareUrl($url) {
    //If there is http:// in the beginning keep it
    if (substr($url,0,7)==='http://') {
        return $url;
    }
    //if the begginning is anything else, add https:// to the beginning
    else if (!(substr($url, 0, 8) === 'https://')) {
        return 'https://'.$url;
    //If everything else is good just return the URL to be validated
    } else {
        return $url;
    }
}

/**
 * Creates a new submission form enclosed in its own div
 */
function showNewSubmissionForm() {
    echo "<div id='submission-exit-button'>";
    echo "<a href='index.php'>x</a>";
    echo "</div>";
    echo "<div>";
    echo "<form method='get' action='index.php'>";
    echo "<input class='sub-new' type='text' name='title' placeholder='title'><br/>";
    echo "<input class='sub-new' type='text' name='url' placeholder='url'><br/>";
    echo "<textarea class='sub-new' cols='50' rows='6' name='subtext' placeholder='description'></textarea><br/>";
    echo "<input type='hidden' name='action' value='addsubmission'>";
    echo "<input class='sub-new' style='float:right' type='submit' value='submit'>";
    echo "</form>";
    if (isset($_SESSION['suberror'])) {
        echo $_SESSION['suberror'];
    }
    echo "</div>";
    
}

/**
 * Adds the form data from the add submission form to the database.  Only valid urls are allowed.  Does not check for 404
 * @global type $pdo
 */
function addSubmission() {
    global $pdo;
    $sql = "INSERT into submissions(userid, submissiondate, submissiontime, title, url, subtext) VALUES (?, CURDATE(), CURTIME(), ?, ?, ?)";
    $query = $pdo->prepare($sql);
    $params = array();
    
    if (isset($_SESSION['userid'])) {
        if (isset($_REQUEST['title']) && isset($_REQUEST['url']) && isset($_REQUEST['subtext'])) {
            $url = prepareUrl($_REQUEST['url']);
            if (isValidUrl($url)) {
                $params = array($_SESSION['userid'], $_REQUEST['title'], $url, $_REQUEST['subtext']);
                $query->execute($params);
                $_SESSION['suberror'] = null;
            } else {
                $_SESSION['suberror'] = "invalid url";
                header('Location: index.php?action=newsub');
                
            }
            
        }
    }
}

/**
 * The id is passed in the $_session because I'm using an href for the delete command
 * which by default is sent via get.  I don't want users to be able to manipulate
 * the delete command in the address bar.  
 * @global type $pdo
 */
function deleteSubmission() {
    global $pdo;
    $sql = "DELETE FROM submissions where id=?";
    $query = $pdo->prepare($sql);
    $params = array($_SESSION['deletesubid']);
    $query->execute($params);
    cleanupSubmissionComments();
    $_SESSION['deletesubid'] = null;
    header('Location: index.php');
}

/**
 * When a submission is deleted, all child comments are also deleted.  After writing this
 * I realized that this would be better done on the DB side using a CASCADE DELETE and FOREIGN KEYS
 * @global type $pdo
 */
function cleanupSubmissionComments() {
    global $pdo;
    $sql = "DELETE FROM comments where subid=?";
    $query = $pdo->prepare($sql);
    $params = array($_SESSION['deletesubid']);
    $query->execute($params);
}

/**
 * Grabs the action from the submissions screen
 * @return string
 */
function getSubmissionAction() {
    if(isset($_REQUEST['action'])) {
        return $_REQUEST['action'];
    } else {
        return 'submissions';
    }
}

/**
 * Shows all of the submissions
 * @global type $pdo
 */
function showSubmissions() {
    global $pdo;
    $sql = "SELECT submissions.*, users.username FROM submissions, users WHERE submissions.userid = users.id";
    $query = $pdo->query($sql);
    
    echo "<div class='submission-parent'>";
    echo "<div class='submission-form-parent'>";
    //This allows the new submission form to stay hidden until the user hits the plus button
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'newsub') {
        showNewSubmissionForm();
    }
    else {
        echo "<a href='index?action=newsub'><img src='images/plus.jpg' id='plusimg'></a>";
    }
    echo "</div>";
    //Creates parent and child divs for submissions and displays all the submisions
    if($query->rowCount() > 0) {
        while($row = $query->fetchObject()) {
            //convert date and time
            $rawdate = strtotime($row->submissiondate);
            $date = date('n/j/Y', $rawdate);
            $rawtime=strtotime($row->submissiontime);
            $time =  date('g:i:s a', $rawtime);
            echo "<div class='sub-title'><a href='$row->url'>$row->title</a></div>";
            echo "<div class='sub-submittedby'>Submitted by $row->username on $date $time </div>";
            echo "<div class='sub-actions'><a href='comments.php?subid=$row->id'>Comments</a></div>";
            echo "<div id='sub-delete'>";
            if (isset($_SESSION['userid']) && $_SESSION['userid'] == $row->userid) {
                if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'deleteconfirm' && isset($_REQUEST['id']) && $_REQUEST['id'] == $row->id){
                    $_SESSION['deletesubid'] = $row->id;
                    echo "delete <a href='index.php?action=deletesub'>y</a>/<a href='index.php'>n</a>?";
              
                } else {
                
                    echo "<form method='post' action='index.php'>";
                    echo "<input type='hidden' name='id' value='$row->id'>";
                    echo "<input type='image' src='images/redx.jpg' style='max-height:7px;float:left;padding-top:5px' name='action' value='deleteconfirm' onclick='this.form.submit()'>";
                    
                    //echo "<a href='index.php?action=deletesub&id=$row->id'> Delete</a>";
                    echo "</form>";
                }
            }
            echo "</div>";
        }
    } else {
        echo "No submissions";
    }
    echo "</div>";
    
}

/**
 * The submission header is used in the comments screen to display details about the submission
 * @global type $pdo
 * @param type $subid
 */
function showSubmissionHeader($subid) {
    global $pdo;
    $sql = "SELECT submissions.*, users.username FROM submissions, users WHERE submissions.userid=users.id AND submissions.id=$subid";
    $query = $pdo->query($sql);
    
    echo "<div id='comment-header'>";
    if($query->rowCount() > 0) {
       $row = $query->fetchObject();
       echo "<div id='comment-header-title'><a href='$row->url'>$row->title</a></div>";
       echo "<div id='comment-header-subbedby'>Submitted by $row->username $row->submissiondate</div>";
       echo "<div id='comment-header-subtext'>$row->subtext</div>";
       
    } else {
        echo "Error loading submission header";
    }
    echo "</div>";
    
    
    
}
/**
 * Shows the add comment form in the comment screen
 */
function showAddCommentForm() {
    echo "<div class='comment-submit'>";
    echo "<form method='post' action='comments.php'>";
    echo "<textarea cols='50' rows='6' name='comment'></textarea><br/>";
    echo "<input type='hidden' name='action' value='add'>";
    echo "<input type='submit' value='Submit Comment'>";
    echo "</form>";
    echo "</div>";
}
/**
 * Renders individual comment divs and displays all of them.  In the future
 * one function would render one comment div, and another would display all of them
 * @global type $pdo
 * @param type $subid
 */
function showComments($subid) {
    $_SESSION['subid'] = $subid;
    global $pdo;
    //The submission info was handled in another query.  My goal was to use one query to prevent multiple connections to the DB
    //but for the sake of the assignment, multiple queries were easier and more modular.
    // *NOTE* Refactor this SQL QUERY if I have time.
    $sql = "SELECT comments.*, submissions.userid, submissions.submissiondate, submissions.submissiontime, submissions.title, submissions.url, submissions.subtext, users.username FROM comments, submissions, users WHERE comments.subid = submissions.id AND comments.userid = users.id AND comments.subid = $subid ORDER BY comments.commentdate, comments.commenttime DESC";
    $query = $pdo->query($sql);
    
    showAddCommentForm();
    echo "<div class='comment-parent'>";
    echo "<div class='comment-child'>";
    
    /*
     * If there are comments, a comment div is rendered content the content of the comment as well as an action bar that allows the user
     * to edit and delete their comments.
     */
    if($query->rowCount() > 0) {
        while ($row = $query->fetchObject()) {
            $rawdate = strtotime($row->commentdate);
            $date = date('n/j/Y', $rawdate);
            $rawtime=strtotime($row->commenttime);
            $time =  date('g:i:s a', $rawtime);
            echo "<div class='comment-comment'>";
            
            if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'showedit' && isset($_REQUEST['commentid']) && $_REQUEST['commentid'] == $row->id) {
                echo "<form method='post' action='comments.php'>";
                echo "<textarea cols='50' rows='6' name='comment'>$row->comment</textarea><br/>";
                echo "<input type='hidden' name='action' value='edit'>";
                echo "<input type='hidden' name='commentid' value='$row->id'>";
                echo "<input type='submit' value='Edit'>";
                echo "</form>";
            } else {
                echo "$row->comment";
            }
            
            
            echo "<div class='comment-subbedby' title='$date $time'>$row->username:</div>";
            echo "<div class='comment-actions'>";
            //Only display action commands on comments that the user posted.  Do not allow a user to delete another user's comments
            if (isset($_SESSION['username']) && $_SESSION['username'] == $row->username) {
                
                
                //Delete confirmation
                if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'deletecommentconfirm' && isset($_REQUEST['commentid']) && $_REQUEST['commentid'] == $row->id){
                    $_SESSION['commentid'] = $row->id;
                    echo "delete <a href='comments.php?action=delete'>y</a>/<a href='comments.php'>n</a>?";
              
                } else {
                    
                    //Delete Image Button - Sends a confirmation action
                    echo "<div style='float:left;padding-right:5px'>";
                    echo "<form method='post' action='comments.php'>";
                    echo "<input type='hidden' name='commentid' value='$row->id'>";
                    echo "<input type='image' src='images/redx.jpg' style='max-height:10px;float:left;padding-top:5px' name='action' value='deletecommentconfirm' onclick='this.form.submit()'>";
                    echo "</form>";
                    echo "</div>";
                    
                    //Edit Image Button
                    echo "<div style='float:left'>";
                    echo "<form method='post' action='comments.php'>";
                    echo "<input type='hidden' name='commentid' value='$row->id'>";
                    echo "<input type='image' src='images/edit.png' style='max-height:10px;float:left;padding-top:5px' name='action' value='showedit' onclick='this.form.submit()'>";
                    echo "</form>";
                    echo "</div>";
                }
               
            }
            echo "</div></div>";
        }
        
    } else {
        echo "No comments.";
    }
    echo "</div></div>";
}

/**
 * Updates a comment after the user edits it.
 * ~Needs work~
 * @global type $pdo
 */
function editComment() {
    global $pdo;
    
    $sql = "UPDATE comments SET comment = ? WHERE id = ?";
    if (isset($_REQUEST['commentid']) && isset($_REQUEST['comment'])) {
        $params = array($_REQUEST['comment'], $_REQUEST['commentid']);
        $query = $pdo->prepare($sql);
        $query->execute($params);
    } else {
        echo "ERROR: UNABLE TO EDIT COMMENT";
    }
            
}

/**
 * Adds a comment to the database
 * @global type $pdo
 */
function addComment() {
    if (isset($_SESSION['userid']) && isset($_SESSION['subid']) && !empty($_REQUEST['comment'])) {
        global $pdo;
        $sql = "INSERT into comments(subid, userid, commentdate, commenttime, comment) VALUES (?, ?, CURDATE(), CURTIME(), ?)";
        $params = array($_SESSION['subid'], $_SESSION['userid'], $_REQUEST['comment']);
        $query = $pdo->prepare($sql);
        $query->execute($params);
    } else {
        echo "Error submitting comment.";
    }
    
}

/**
 * Deletes a comment from the database
 * @global type $pdo
 */
function deleteComment() {
    if (isset($_SESSION['commentid'])) {
        global $pdo;
        $params = array($_SESSION['commentid']);
        $sql = "DELETE from comments WHERE id=? LIMIT 1";
        $query = $pdo->prepare($sql);
        $query->execute($params);
    } else {
        echo "ERROR: Unable to delete comment";
    }
    
}

/**
 * Either renders a login screen, or a create an account screen based on the incoming action
 */
function showLogin() {
    
    echo "<div id='top-nav'>";
    echo "<div id='logo'>";
    echo "<a href='index.php'><image src='images/bunny.jpg' id='logoimg' alt='Do not hover over the bunny!'></a>";
    echo " Social Bunny";
    echo "</div>";
    echo "<div id='login'>";
    if (isset($_SESSION['username'])) {
        
        echo 'Welcome '.$_SESSION['username'].' ';
        echo "<a href='index.php?action=logout'>logout</a>";
    }
    else if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'newaccount') {
        echo "<form method='post' action='index.php'>";
        echo "<input type='hidden' name='action' value='account'>";
        echo "<input class='login' type='text' name='username' placeholder='Username'><br/>";
        echo "<input class='login' type='password' name='password' placeholder='Password'><br/>";
        echo "<input class='login' type='password' name='passwordcopy' placeholder='Enter your password again'><br/>";
        echo "<input class='login' type='submit' value='Create Account'>";
        echo "</form>";
        
    }
    else {
        echo "Sign in or <a href='index.php?action=newaccount' >create an account</a>";
        echo "<form method='post' action='index.php'>";
        echo "<input type='hidden' name='action' value='login'>";
        echo "<input class='login' type='text' name='username' placeholder='username'><br/>";
        echo "<input class='login' type='password' name='password' placeholder='password'><br/>";
        echo "<input class='login' type='submit' value='Login'>";
        echo "</form>";
    }
    
    if(isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        $_SESSION['error'] = null;
    }
    
    
    echo "</div>";
    echo "<div id='slogan'>";
    echo "Because Social Butterflies aren't fluffy...";
    echo "</div>";
    echo "</div>";
}

/**
 * Creates a new account in the database.  User must match the regex pattern.  Passwords
 * can't be empty.  The password and copy must match.  If the inputs are good, strong one
 * way encryption bcrypt() is used to store the password in the database.  The amount of work
 * bcrypt does can be toggled in the Bycrpt instantiation.
 * @global Bcrypt $bcrypt
 * @global type $pdo
 */
function createAccount() {
    global $bcrypt;
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password']; 
    $passwordcopy = $_REQUEST['passwordcopy'];
    global $pdo;
    $sql = "SELECT * FROM users where username=?";
    $query = $pdo->prepare($sql);
    $params = array($username);
    $query->execute($params);
    
    //http://stackoverflow.com/questions/12018245/regular-expression-to-validate-username
    $userREGEX = '/^(?=.{4,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/';
    if (!preg_match($userREGEX, $username)) {
        $_SESSION['error'] = "Invalid username$$$$. ";
    }
    if ($query->rowCount() > 0) {
        $_SESSION['error'] = "Username already taken. ";
    }
    if (empty($password) && empty($passwordcopy)) {
        
    }
    if ($password != $passwordcopy) {
        $_SESSION['error'] .= 'Passwords do not match. ';
    }
    
    if (isset($_SESSION['error']))
    {
        $_REQUEST['action'] = 'newaccount';
    }
    else
    {
        $_REQUEST['action'] = null;
        $sql = "INSERT into users (username, password) VALUES (?,?)";
        $query = $pdo->prepare($sql);
        $hash = $bcrypt->hash($password);
        $params = array($username, $hash);
        $query->execute($params);
        getLogin($username, $password);
        
    }
  

}

/**
 * The login is handled in the session.  If the user gives valid credentials, their
 * session gets a username and userid which can be used by other functions.  The hashed
 * password is verified using Bcrypt.
 * @global Bcrypt $bcrypt
 * @global type $pdo
 * @param type $username
 * @param type $password
 */
function getLogin($username, $password) {
    global $bcrypt;
    global $pdo;
    $sql = "SELECT * FROM users WHERE username=? LIMIT 1";
    $query = $pdo->prepare($sql);
    $params = array ($username);
    $query->execute($params);
    if ($query->rowCount() > 0) {
        while ($row = $query->fetchObject()) {
            if ($bcrypt->verify($password, $row->password)) {
                $_SESSION['username'] = $row->username;
                $_SESSION['userid'] = $row->id;

                $sql="UPDATE users SET loggedin=1, lastlogin=NOW(), ipaddr=? WHERE id=?";
                $query=$pdo->prepare($sql);
                $params = array($_SERVER['REMOTE_ADDR'], $row->id);
                $query->execute($params); 
            } else {
                $_SESSION['error'] = 'Invalid password';
            }
            
        }
    }
    else {
        $_SESSION['error'] = "Invalid username.";
    }

}

/**
 * Destroys the session and updates the login status in the database
 * @global type $pdo
 */
function logout() {
    global $pdo;
    
    $sql="UPDATE users SET loggedin=0 WHERE id=?";
    $query=$pdo->prepare($sql);
    $params = array($_SESSION['userid']);
    $query->execute($params);
    $_SESSION = null;
    session_destroy();
    session_write_close();
}
?>

