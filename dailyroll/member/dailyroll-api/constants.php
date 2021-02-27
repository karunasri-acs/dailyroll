<?php
 error_reporting(0);
 
 //databse
 
 define("HOST", 			"dinkhoocom.ipagemysql.com"	);
 define("DATABASE", 		"dailyroll");
 define("USERNAME", 		"dailyadmin");
 define("PASSWORD", 		"RyliaD2019!");
  //Krimewatch
 // uploads constants
  define("DIR", 				"../../.."	);
define("DIR_UPLOAD", 		DIR."/uploads/content/dailyroll/uploads/");
define("DIR_PROFILE", 		DIR."/uploads/content/dailyroll/profile/");
define("DIR_CURRENT", 		"http://support.krimewatch.com/");
 //define('SERVER_URL', 'http://krimesupport.dinkhoo.com/verify.php?id='); 
 define('SERVER_URL', 'http://support.krimewatch.com/accept.php?id='); 
 define("DIR_SUPPORT", 	"../../../uploads/content/support/");
 define("CURRENT_URL",  "https://upload.dailyroll.org/");
 define("REG_URL",  "https://dailyroll.org/dailyroll-api/");
 define("USERS", 			"users"	);
 define("NOTIFICATIONS",	"notifications"	);
 define("SUBSCRIBERS",		"subscribers"	);
 define("EVENTS",			"event_log"	);
 define("SUPPORT_TABLE",	"support"	);
 define("EMERGENCY",			"emergency"	);
 define("PLAN",			"plan"	);
 define("APPNAME",		"DailyRoll"	);
 define("EVENTLOG",		"Y"	);
 define("REQUEST_URL",  "https://dailyroll.org/dailyroll-api/ws_barcode.php?email");
 define("SUPPORTEMAIL",		"acs.support@abbigale.org"	);
 
 //roles
 define("SUPERADMIN",  "super_admin");
 define("KRIMESUPPORT",  "krimesupport");
 define("ELITECAPSUPPORT",  "elitecapsupport");
 define("NATUESNAPSUPPORT",  "naturesnapsupport");
 
?>