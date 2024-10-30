<?php

class Analizer{
    
    //Global url set by constructor
    private static $pageURL = "";
    
    //Calculated page size
    private static $pageSize = 0;
    
    //Path to temp folder
    private static $tempPath = "temp";
    
    //Path where site content is downloaded
    private static $fullTempPath = "";
    
    /*
     * Method that will analize page size
     */
    public static function Analize($pageURL){
        
        //quick check if data is valid
        if($pageURL == "") die("Analize() => No URL!");
        if (!function_exists('exec')) {
            trigger_error('The function exec() is not available.', E_USER_WARNING);
            return false;
        }
        
        //Store our URL to global variable
        self::$pageURL = $pageURL;
            
        //let's download page with all the requisites
        self::downloadPageWithRequisites();
        
        //let's calculate size
        self::$pageSize = self::calcultePageSize();
        
        //clean up the mess
        self::removeTempData();
        
        //AND WE ARE FINISHED!
        return self::$pageSize;
    }
    
    /*
     * Method will download page with all requisites into temp dir
     */
    private static function downloadPageWithRequisites(){
        try{
            
            //execute linux command; our magic trick
            exec("wget --page-requisites --limit-rate=200K --random-wait --directory-prefix=" . self::$tempPath . " " . self::$pageURL);
            $parsedURL = parse_url(self::$pageURL);
            
            //store for later
            self::$fullTempPath = self::$tempPath . "/" . $parsedURL['host'];
            
        }catch(Exception $ex){
            die("downloadPageWithRequisites" . $ex->getMessage());
        }
    }
    
    /*
     * Wrapper for getDirectorySize
     * return int
     */
    private static function calcultePageSize(){
        $path = self::$fullTempPath;
        $size = self::getDirectorySize($path);
        return (int)$size;
    }
    
    /*
     * This method will return file or directory size (in bytes)
     * return int
     */
    private static function getDirectorySize($path){
		$sf = 0;
        $h = @opendir($path);
        if($h == 0)return 0;
        while($f = readdir($h)){
            if ( $f != ".." && $f != ".") {
                $sf += filesize($nd = "$path/$f");
                if(is_dir($nd)){
                    $sf += self::getDirectorySize($nd);
                }
            }
        }
        closedir($h);
        return $sf; 
    }
    
    /*
     * Wrapper for rrmdir
     */
    private static function removeTempData(){
		$path = self::$fullTempPath;
		self::rrmdir($path);
    }
    
    /*
     * Method will delete directory and all files in it in recursion
     */
    private static function rrmdir($dir) { 
        foreach(glob($dir . '/*') as $file) { 
          if(is_dir($file)) self::rrmdir($file); else unlink($file); 
        } @rmdir($dir); 
    }
    
}

?>
