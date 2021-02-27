<?php
require_once 'constants/constants.php';
class LOGGER
{	

	private $cfile;
	private $dirfile;
	
	public function __construct($file,$dir){	
		$this->cfile = $file;
		$this->dirfile =$this->slashdir($dir);
		
    }
	
	public function event_log($text, $level) {
		if(!($level=='d' && !DEBUGFLAG)){		
			switch (strtolower($level)) {
				case 'e':
				case 'error':
					$level='ERROR';
					break;
						
				case 'i':
				case 'info':
					$level='INFO';
					break;
				case 'd':
				case 'debug':
					$level='DEBUG';
					break;
				default:
					$level='INFO';
			}
			//$slashes=$this->slashdir($this->dirfile);
			//$file = $slashes.LOGSPATH."emedicall".date("Y-m-d").".log";
			error_log(date("[Y-m-d H:i:s]")."\t[".$level."]\t[".$this->cfile."]\t".$text."\r\n", 3, $this->dirfile);
		}
    }
	public  function slashdir($dir) {
		//echo $dir;
		$strdir = strstr($dir,"ANG");
		$dirarray =  explode("/",$strdir);
		 $count= count($dirarray);
		$predir = "";
		for ($i= 0;$i < $count;$i++){ 		
			$predir .= "../";
		}
		
		$file = $predir.LOGSPATH."dailyroll".date("Y-m-d").".log";
		return $file;
		
	}
	
}
?>