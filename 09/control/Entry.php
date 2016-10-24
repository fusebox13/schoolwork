<?php
/**
 * The Entry object controls the website flow
 *
 * @author Dan Williams
 */
namespace control;
class Entry {
    
    /**
     * Routes the traffic to the right location
     */
    public static function route() {
        /*
         * If there is no request or session, then the user is coming into
         * the page for the first time.  If that is the case, display the form
         * for them to start a new test.
         */
        if ($_REQUEST == null && $_SESSION == null) {
            header("Location: /~dwilli11/CPS276/09/newtest");
        }
        
        /*
         * Action Router
         * When an action is passed, it's rewritten by mod_rewrite
         */
        if (isset($_REQUEST['action'])) {
            switch ($_REQUEST['action']) {
                case 'newtest': 
                    \control\Entry::newSession();
                    break;
                case 'start':
                    \control\Entry::newSession();
                    header("Location: http://russet.wccnet.edu/~dwilli11/CPS276/09/start/briggsmeyertest/".$_SESSION['name']);
                    break;
                case 'answer':
                    \results\Results::updateResults();            
                    header("Location: http://russet.wccnet.edu/~dwilli11/CPS276/09/question/".($_SESSION['questionCount']+1));
                    break;
            }

        }
        
        /*
         * If the session has a name, then start displaying questions.
         * else display the option to start a new test
         */
        if (isset($_SESSION['name'])) {
            echo "<h1>".ucfirst($_SESSION['name'])."</h1>";
            \display\Display::questions();
            echo "<a href=/~dwilli11/CPS276/09/newtest>New Test</a>";
        } else {
             \display\Display::newTest();
        }
    }
    
    /**
     * Starts a new session/test
     */
    public static function newSession() {
        if (isset($_REQUEST['name'])) {
            $_SESSION['name'] = $_REQUEST['name'];
        } else {
            $_SESSION['name'] = null;
        }

        $_SESSION['questions']  = \questions\Questions::generateQuestions()->getQuestions();
        $_SESSION['questionCount'] = 0;
        $_SESSION['IE'] = 0;
        $_SESSION['SN'] = 0;
        $_SESSION['FT'] = 0;
        $_SESSION['JP'] = 0;
    }
}
