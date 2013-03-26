<?php
/**
 * General site functions.
 *
 * @author Dustin
 */
class Functions {
    
    //Strips strings. !!DEV
    public static function Make_Safe(&$string) {

        return preg_replace("/@([^A-Za-z0-9\+_\-,]+)/", "", $string);

    }
    
    public static function Get_View() {
        
        if(isset($_GET['view'])){
            $view = self::Make_Safe($_GET['view']);
        } else {
            $view = "blog";
        }

        return $view;
    }
    
    public static function Display_View($view) {
    
        if(file_exists("views/".$view.".php")) {
            include("views/".$view.".php");
        } else {
			Write_Log("php", "NOTICE: Could not find the file 'views/".$view.".php'");
            include("views/404.php");
        }
    }
    
    public static function Verify_Session() {
	
        if(isset($_SESSION["ID"])) {
            return true;
        } else {
			//Write_Log("php", "SECURITY: Failed session verification.");
            return false;
        }
    }

    public static function Verify_Session_Redirect() {
    
        if(!isset($_SESSION["ID"])) {
            header( 'Location: ?' );
        }
    }
}

?>