<?php
include  '../../constants/constants.php';
include '../../dbconfig.php';
require_once '../../CryptoLib.php';
class USER
{	

	
	private $conn;
	
	public function __construct(){	
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
		$this->encryption = new CryptoLib();
    }
	public function getkeys(){
		$sql="select * from config";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$rowcount=$stmt->rowCount();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	
		
	}
	public function encrypted($string) {
		$datas=$this->getkeys();
		$keys=$datas['sk'];
		$cipher  = $this->encryption->encryptPlainTextWithRandomIV($string, $keys);
		return $cipher;
    }
	
	public function dencrypted($string) {
		$datas=$this->getkeys();
		$keys=$datas['sk'];
		$plainText = $this->encryption->decryptCipherTextWithRandomIV($string,$keys);
		return $plainText;
    }	
	
	public function encryptedstatic($string) {
		$string = strtolower($string);
		$datas=$this->getkeys();
		$ciphering = "AES-128-CTR"; 
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
		$encryption_iv = $datas['sk']; 
		$encryption_key = $datas['sec']; 
		$encryption = openssl_encrypt($string, $ciphering, $encryption_key, $options, $encryption_iv); 
		return 	$encryption ;
    }
	
	public function dencryptedstatic($string) {
		$datas=$this->getkeys();
		$ciphering = "AES-128-CTR"; 
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
		$decryption_iv = $datas['sk'];
	    $decryption_key = $datas['sec']; 
		$decryption=openssl_decrypt ($string, $ciphering, $decryption_key, $options, $decryption_iv); 
		return $decryption;		
			
    }
	
	
	
	
	public function getexpensebusinessac($acid,$status,$currencyid){
		$exptype='Expense';
		$sql1="SELECT * FROM `category` WHERE `account_id`='$acid' and `cat_type`='expenses'";
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		if($rowcount  > 0){
			
		while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
		$accountdetails=$this->get_accountdetails($acid);
		$accname=$accountdetails['accountname'];
		$incatergory=$this->getsubac($row1['cat_id'],$status,$currencyid,$exptype,$accname);
		if($incatergory == 'empty'){
			$incatergory=[];
			
		}
		if($status=='not'){
			$sendstatus='not';	
		}
		else{
			
			$sendstatus=$row1['status'];
		}
		$excount=$this->getsubaccount($row1['cat_id']);
				$ret[]=array(
					"name" => $row1['cat_name'],
					"id"=>$row1['cat_id'],
					"type"=>'account',
					"status"=>$sendstatus,
					"accname"=> $row1['cat_name'],
					"busname"=>$accountdetails['accountname'],
					"subcatname"=>"noname",
					"showtype"=>"Expense",
					"amount"=>'0',
					"symbol"=>'0',
					"count"=>$excount,
					"children"=>$incatergory);
		
			}
		
		}else{
			$ret= 'empty';
			
			
		}
		return $ret;
	
	}
	public function getincomebusinessac($acid,$status,$currencyid){
		$exptype='Income';
		 $sql1="SELECT * FROM `category` WHERE `account_id`='$acid' and `cat_type`='income'";
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		if($rowcount  > 0){
		
		while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
			$accountdetails=$this->get_accountdetails($acid);
			$accname=$accountdetails['accountname'];
		$incatergory=$this->getsubac($row1['cat_id'],$status,$currencyid,$exptype,$accname);
	if($incatergory == 'empty'){
		$incatergory=[];
		
	}
	if($status=='not'){
		$sendstatus='not';	
	}
	else{
		
		$sendstatus=$row1['status'];
	}
	$excount=$this->getsubaccount($row1['cat_id']);
			$ret[]=array(
					"name" => $row1['cat_name'],
					"id"=>$row1['cat_id'],
					"type"=>'account',
					"status"=>$sendstatus,
					"accname"=> $row1['cat_name'],
					"busname"=>$accountdetails['accountname'],
					"subcatname"=>"noname",
					"showtype"=>"Income",
					"amount"=>'0',
					"symbol"=>'0',
					"count"=>$excount,
					"children"=>$incatergory);
		
			}
		
		}else{
			$ret= 'empty';
			
			
		}
		return $ret;
	
	}
	public function getsubac($caid,$status,$currencyid,$exptype,$accname){
		$sql1="SELECT * FROM `sub_category` WHERE `cat_id`='$caid'";
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		
		$rowcount=$stmt1->rowcount();
		
		if($rowcount  > 0){
		while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
		if($status=='not'){
		$sendstatus='not';	
	}
	else{
		
		$sendstatus=$row1['status'];
	}
	$catname=$this->get_category($caid);
			$symbol=$this->getCurrency_symbol($currencyid);
			$ret[]=array(
					"name" =>$row1['subcat_name'],
					"id"=>$row1['subcat_id'],
					"type"=>'sub-account',
					"status"=>$sendstatus,
					"accname"=> $catname,
					"busname"=>$accname,
					"subcatname"=>$row1['subcat_name'],
					"showtype"=>$exptype,
					"amount"=>$row1['amount'],
					"symbol"=>$symbol,
					"count"=>'0',
					"children"=>[]);
		
			}
		
		}else{
			$ret= 'empty';
			
			
		}
		return $ret;
	
	}
	public function catbyaccmonth($uid,$month,$accountid,$year,$penstatus){
		if($penstatus !='Both'){
		$sql1="SELECT * FROM `expenses` WHERE account_id='$accountid' and year(`tr_date`)='$year'  and month(tr_date)='$month' and pendingflag='$penstatus' group by cat_id";
		}else{
			$sql1="SELECT * FROM `expenses` WHERE account_id='$accountid' and year(`tr_date`)='$year'  and month(tr_date)='$month'  group by cat_id";
		}
		$this->event_logs($sql1);
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		if($rowcount  > 0){
		while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
		$catid=$row1['cat_id'];
		$mydate = $row1['tr_date'];
			$month = date("m",strtotime($mydate));	
			$trdate=$year."-".$month."-01";	
			$name=$this->get_category($catid);
			$subcatdet=$this->subcatbyacmonth($uid,$month,$accountid,$year,$catid,$penstatus);
			$rowcountacc=$this->getcatbyacmonth($month,$accountid,$year,$catid,$penstatus);
			$ret[]=array(
					"name" =>$name,
					'description' => $des,
					"expense_id"=>'0',
					"accountid"=>$accountid,
					"catid"=>$catid,
					"subcatid"=>'0',
					"capture_id"=>'0',
					"count"=>$rowcountacc,
					"type"=>'acc',
					"username"=>"no",
					"date"=>$trdate,
					"amount"=>'0',
					"filepath"=>'aaa',
					"symbol"=>$symbol,
					"accountstatus"=>$status,
					"adminstatus"=>$adminstatus,
					"pendingstatus"=>$penstatus,
					"pendingamount"=>$pendingamount,
					 "accountadmin"=>'0',
					"children"=>$subcatdet);
		
			}
		
		}else{
			$ret= 'empty';
			
			
		}
		return $ret;
	
	}
	public function incomecatbyaccmonth($uid,$month,$accountid,$year,$penstatus){
		if($penstatus !='Both'){
		$sql1="SELECT * FROM `income` WHERE account_id='$accountid' and year(`tr_date`)='$year'  and month(tr_date)='$month' and pendingflag='$penstatus' group by cat_id";
		}else{
			$sql1="SELECT * FROM `income` WHERE account_id='$accountid' and year(`tr_date`)='$year'  and month(tr_date)='$month' group by cat_id";
		}
		$this->event_logs($sql1);
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		if($rowcount  > 0){
		while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
		$catid=$row1['cat_id'];
			$name=$this->get_category($catid);
			$mydate = $row1['tr_date'];
			$month = date("m",strtotime($mydate));
			
			$trdate=$year."-".$month."-01";
			$subcatdet=$this->incomesubcatbyacmonth($uid,$month,$accountid,$year,$catid,$penstatus);
			$rowcountacc=$this->getincomecatbyacmonth($month,$accountid,$year,$catid,$penstatus);
			$ret[]=array(
			
					"name" =>$name,
					'description' => $des,
					"income_id"=>'0',
					"accoun"=>$accountid,
					"cat_id"=>$catid,
					"subcat_id"=>'0',
					"capture_id"=>'0',
					"count"=>$rowcountacc,
					"type"=>'acc',
					"username"=>"no",
					"tr_date"=>$trdate,
					"amount"=>'0',
					"filepath"=>'aaa',
					"symbol"=>$symbol,
					"accountstatus"=>$status,
					"adminstatus"=>$adminstatus,
					"pendingstatus"=>$penstatus,
					"pendingamount"=>$pendingamount,
					 "accountadmin"=>'0',
					"children"=>$subcatdet);
		
			}
		
		}else{
			$ret= 'empty';
			
			
		}
		return $ret;
	
	}
	public function getexpensecount($accountid){
		$sql1="SELECT * FROM `category` WHERE `account_id`='$accountid' and `cat_type`='expenses'";
		$this->event_logs($sql1);
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function getincomecount($accountid){
		$sql1="SELECT * FROM `category` WHERE `account_id`='$accountid' and `cat_type`='income'";
		$this->event_logs($sql1);
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function getsubaccount($catid){
		$sql1="SELECT * FROM `sub_category` WHERE  `cat_id`='$catid'";
		$this->event_logs($sql1);
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function getacccount($month,$selectyear,$accountid,$penstatus){
		if($penstatus !='Both'){
			$sql="SELECT * FROM `expenses` WHERE year(`tr_date`)='$selectyear'  and account_id ='$accountid'  and pendingflag='$penstatus' and month(`tr_date`)='$month' ";
		}else{
				$sql="SELECT * FROM `expenses` WHERE year(`tr_date`)='$selectyear'  and account_id ='$accountid'   and month(`tr_date`)='$month' ";
			
		}
		$this->event_logs($sql);
		$stmt1 = $this->conn->prepare($sql);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function getincomeacccount($month,$selectyear,$accountid,$penstatus){
		if($penstatus !='Both'){
		$sql="SELECT * FROM `income` WHERE year(`tr_date`)='$selectyear'  and account_id ='$accountid'  and pendingflag='$penstatus' and month(`tr_date`)='$month' ";
		
		}else{
		$sql="SELECT * FROM `income` WHERE year(`tr_date`)='$selectyear'  and account_id ='$accountid'   and month(`tr_date`)='$month' ";
			
		}
		$this->event_logs($sql);
		$stmt1 = $this->conn->prepare($sql);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function getcatbyacmonth($month,$accountid,$year,$catid,$penstatus){
		if($penstatus !='Both'){
		$sql="SELECT * FROM `expenses` WHERE year(`tr_date`)='$year'  and account_id ='$accountid'  and pendingflag='$penstatus' and month(`tr_date`)='$month' and cat_id='$catid' ";
		}else{
			$sql="SELECT * FROM `expenses` WHERE year(`tr_date`)='$year'  and account_id ='$accountid'  and month(`tr_date`)='$month' and cat_id='$catid' ";
		}
		$this->event_logs($sql);
		$stmt1 = $this->conn->prepare($sql);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function getincomecatbyacmonth($month,$accountid,$year,$catid,$penstatus){
		if($penstatus !='Both'){
		$sql="SELECT * FROM `income` WHERE year(`tr_date`)='$year'  and account_id ='$accountid'  and pendingflag='$penstatus' and month(`tr_date`)='$month' and cat_id='$catid' ";
		}else{
		$sql="SELECT * FROM `income` WHERE year(`tr_date`)='$year'  and account_id ='$accountid'   and month(`tr_date`)='$month' and cat_id='$catid' ";	
			
		}
		$this->event_logs($sql);
		$stmt1 = $this->conn->prepare($sql);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function getsubcountbymonth($subcat_id,$month,$accountid,$year,$catid,$penstatus){
		if($penstatus !='Both'){
		$sql="SELECT * FROM `expenses` WHERE year(`tr_date`)='$year'  and account_id ='$accountid'  and pendingflag='$penstatus' and month(`tr_date`)='$month' and cat_id='$catid'  and subcat_id='$subcat_id'";
		}else{
		$sql="SELECT * FROM `expenses` WHERE year(`tr_date`)='$year'  and account_id ='$accountid' and month(`tr_date`)='$month' and cat_id='$catid'  and subcat_id='$subcat_id'";
			
	}
		$this->event_logs($sql);
		$stmt1 = $this->conn->prepare($sql);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function getincomesubcountbymonth($subcat_id,$month,$accountid,$year,$catid,$penstatus){
		if($penstatus !='Both'){
		$sql="SELECT * FROM `income` WHERE year(`tr_date`)='$year'  and account_id ='$accountid'  and pendingflag='$penstatus' and month(`tr_date`)='$month' and cat_id='$catid'  and subcat_id='$subcat_id'";
		}else{
		$sql="SELECT * FROM `income` WHERE year(`tr_date`)='$year'  and account_id ='$accountid'  and month(`tr_date`)='$month' and cat_id='$catid'  and subcat_id='$subcat_id'";
			
		}
		$this->event_logs($sql);
		$stmt1 = $this->conn->prepare($sql);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function subcatbyacmonth($uid,$month,$accountid,$year,$catid,$penstatus){
			if($penstatus !='Both'){
		$sql1="SELECT * FROM `expenses` WHERE account_id='$accountid' and cat_id='$catid' and year(`tr_date`)='$year' and pendingflag='$penstatus'  and month(tr_date)='$month'";
			}else{
				$sql1="SELECT * FROM `expenses` WHERE account_id='$accountid' and cat_id='$catid' and year(`tr_date`)='$year'   and month(tr_date)='$month'";
			}
		$this->event_logs($sql1);
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		if($rowcount  > 0){
		
		 while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){

			$file_name=$row1['file_name'];
			$result = substr($file_name, 0, 3);
			if($result=='aaa'){
				$file='nofile';
			}
			else{
			
				$file=$file_name;
			}
			$userid=$row1['capture_id'];
			
			$username=$this->getusernamebyid($userid);
			$username=$this->dencrypted($username);
			$accountdetails=$this->get_accountdetails($row1['account_id']);
			$currencyid=$accountdetails['currcode'];
			$amount=$row1['amount'];
			$symbol=$this->getCurrency_symbol($currencyid);
			$subcat_id=$row1['subcat_id'];
			$catdeat=$this->get_subcategoryDetails($subcat_id);
			$setamount=$catdeat['amount'];
			if($setamount == $amount){
				$pendingamount='0';
			
			}else{
				$pendingamount= $setamount-$amount;
			}
			if($uid==$accountdetails['user_id']){
			$adminstatus ='admin';
			}else{
			$adminstatus ='user';
			}
			$datades=substr($catdeat['subcat_name'], 0, 15);
			
			$ret[]=array(
				"name" =>$datades,
				'description' => $row1['description'],
				"expense_id"=>$row1['id'],
				"accountid"=>$row1['account_id'],
				"capture_id"=>$row1['capture_id'],
				"catid"=>$row1['cat_id'],
				"subcatid"=>$row1['subcat_id'],
				"count"=>'0',
				"type"=>'datas',
				"amount"=>$row1['amount'],
				"username"=>$username,
				"date"=>$row1['tr_date'],
				"filepath"=>$file,
				"accountstatus"=>$row1['freeze'],
				"adminstatus"=>$adminstatus,
				"pendingstatus"=>$row1['pendingflag'],
				"pendingamount"=>$pendingamount,
				"symbol"=>$symbol,
				"accountadmin"=>$accountdetails['user_id'],
				"children"=>[]);
		
			}
		
		}else{
			$ret= 'empty';
			
			
		}
		return $ret;
	
	}
	public function incomesubcatbyacmonth($uid,$month,$accountid,$year,$catid,$penstatus){
		if($penstatus !='Both'){
		$sql1="SELECT * FROM `income` WHERE account_id='$accountid' and cat_id='$catid' and year(`tr_date`)='$year' and pendingflag='$penstatus'  and month(tr_date)='$month'";
		}else{
			$sql1="SELECT * FROM `income` WHERE account_id='$accountid' and cat_id='$catid' and year(`tr_date`)='$year'   and month(tr_date)='$month' ";
			
		}
		$this->event_logs($sql1);
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		if($rowcount  > 0){
		
		while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){

			$file_name=$row1['file_name'];
			$result = substr($file_name, 0, 3);
			if($result=='aaa'){
				$file='nofile';
			}
			else{
			
				$file=$file_name;
			}
			$userid=$row1['capture_id'];
			
			$username=$this->getusernamebyid($userid);
			$username=$this->dencrypted($username);
			$accountdetails=$this->get_accountdetails($row1['account_id']);
			$currencyid=$accountdetails['currcode'];
			$amount=$row1['income_amount'];
			$symbol=$this->getCurrency_symbol($currencyid);
			$subcat_id=$row1['subcat_id'];
			$catdeat=$this->get_subcategoryDetails($subcat_id);
			$setamount=$catdeat['amount'];
			if($setamount == $amount){
				$pendingamount='0';
			
			}else{
				$pendingamount= $setamount-$amount;
			}
			if($uid==$accountdetails['user_id']){
			$adminstatus ='admin';
			}else{
			$adminstatus ='user';
			}
			$datades=substr($catdeat['subcat_name'], 0, 15);
			
			$ret[]=array(
				"name" =>$datades,
				'description' => $row1['description'],
				"income_id"=>$row1['income_id'],
				"accoun"=>$row1['account_id'],
				"capture_id"=>$row1['capture_id'],
				"cat_id"=>$row1['cat_id'],
				"subcat_id"=>$row1['subcat_id'],
				"count"=>'0',
				"type"=>'datas',
				"income_amount"=>$row1['income_amount'],
				"username"=>$username,
				"tr_date"=>$row1['tr_date'],
				"filepath"=>$file,
				"accountstatus"=>$row1['freeze'],
				"adminstatus"=>$adminstatus,
				"pendingstatus"=>$row1['pendingflag'],
				"pendingamount"=>$pendingamount,
				"symbol"=>$symbol,
				"accountadmin"=>$accountdetails['user_id'],
				"children"=>[]);
		
			}
		
		
		}else{
			$ret= 'empty';
			
			
		}
		return $ret;
	
	}
	public function getexpensedata($uid,$subcatid,$month,$accountid,$year,$catid,$penstatus) {	
	if($penstatus !='Both'){
		// Email and phone# without country code
	    $sql="SELECT * from `expenses` WHERE subcat_id='$subcatid'  and account_id='$accountid' and cat_id='$catid' and year(`tr_date`)='$year'  and month(tr_date)='$month' and pendingflag='$penstatus'";
		
	}else{
		
	 $sql="SELECT * from `expenses` WHERE subcat_id='$subcatid'  and account_id='$accountid' and cat_id='$catid' and year(`tr_date`)='$year'  and month(tr_date)='$month' ";
		
	}$this->event_logs($sql);
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){

			$file_name=$row1['file_name'];
			$result = substr($file_name, 0, 3);
			if($result=='aaa'){
				$file='nofile';
			}
			else{
			
				$file=$file_name;
			}
			$userid=$row1['capture_id'];
			
			$username=$this->getusernamebyid($userid);
			$accountdetails=$this->get_accountdetails($row1['account_id']);
			$currencyid=$accountdetails['currcode'];
			$amount=$row1['amount'];
			$symbol=$this->getCurrency_symbol($currencyid);
			$subcat_id=$row1['subcat_id'];
			$catdeat=$this->get_subcategoryDetails($subcat_id);
			$setamount=$catdeat['amount'];
			if($setamount == $amount){
				$pendingamount='0';
			
			}else{
				$pendingamount= $setamount-$amount;
			}
			if($uid==$accountdetails['user_id']){
			$adminstatus ='admin';
			}else{
			$adminstatus ='user';
			}
			
			$ret[]=array(
				"name" =>$row1['description'],
				'description' => $row1['description'],
				"expense_id"=>$row1['id'],
				"accountid"=>$row1['account_id'],
				"capture_id"=>$row1['capture_id'],
				"catid"=>$row1['cat_id'],
				"subcatid"=>$row1['subcat_id'],
				"count"=>'0',
				"type"=>'datas',
				"amount"=>$row1['amount'],
				"username"=>$username,
				"date"=>$row1['tr_date'],
				"filepath"=>$file,
				"accountstatus"=>$row1['freeze'],
				"adminstatus"=>$adminstatus,
				"pendingstatus"=>$row1['pendingflag'],
				"pendingamount"=>$pendingamount,
				"symbol"=>$symbol,
				"accountadmin"=>$accountdetails['user_id'],
				"children"=>[]);
		
			}
		
			
		return $ret;
		
	}
	public function getincomedata($uid,$subcatid,$month,$accountid,$year,$catid,$penstatus) {	
		// Email and phone# without country code
if($penstatus !='Both'){
	    $sql="SELECT * from `income` WHERE subcat_id='$subcatid'  and account_id='$accountid' and cat_id='$catid' and year(`tr_date`)='$year'  and month(tr_date)='$month' and pendingflag='$penstatus'";
		}else{
			
 $sql="SELECT * from `income` WHERE subcat_id='$subcatid'  and account_id='$accountid' and cat_id='$catid' and year(`tr_date`)='$year'  and month(tr_date)='$month' ";
		
		}
		$this->event_logs($sql);
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){

			$file_name=$row1['file_name'];
			$result = substr($file_name, 0, 3);
			if($result=='aaa'){
				$file='nofile';
			}
			else{
			
				$file=$file_name;
			}
			$userid=$row1['capture_id'];
			
			$username=$this->getusernamebyid($userid);
			$accountdetails=$this->get_accountdetails($row1['account_id']);
			$currencyid=$accountdetails['currcode'];
			$amount=$row1['income_amount'];
			$symbol=$this->getCurrency_symbol($currencyid);
			$subcat_id=$row1['subcat_id'];
			$catdeat=$this->get_subcategoryDetails($subcat_id);
			$setamount=$catdeat['amount'];
			if($setamount == $amount){
				$pendingamount='0';
			
			}else{
				$pendingamount= $setamount-$amount;
			}
			if($uid==$accountdetails['user_id']){
			$adminstatus ='admin';
			}else{
			$adminstatus ='user';
			}
			
			$ret[]=array(
				"name" =>$row1['description'],
				'description' => $row1['description'],
				"income_id"=>$row1['income_id'],
				"accoun"=>$row1['account_id'],
				"capture_id"=>$row1['capture_id'],
				"cat_id"=>$row1['cat_id'],
				"subcat_id"=>$row1['subcat_id'],
				"count"=>'0',
				"type"=>'datas',
				"income_amount"=>$row1['income_amount'],
				"username"=>$username,
				"tr_date"=>$row1['tr_date'],
				"filepath"=>$file,
				"accountstatus"=>$row1['freeze'],
				"adminstatus"=>$adminstatus,
				"pendingstatus"=>$row1['pendingflag'],
				"pendingamount"=>$pendingamount,
				"symbol"=>$symbol,
				"accountadmin"=>$accountdetails['user_id'],
				"children"=>[]);
		
			}
		
			
		return $ret;
		
	}
	public function isEmailExists($email) {	
		// Email and phone# without country code
	     $sql="SELECT * from `users` WHERE email='$email'";
		
        $stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$rowcount=$stmt->rowCount();
		if($rowcount < 1){
			$row='null';
		}else{
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
	
		
		}
			return $row;
	}
	
	public function getCurrency_symbol($countryCode){
		$currency =array(
			"BRL" => "R$" , // OR add ₢ Brazilian Real
			"BDT" => "৳", //Bangladeshi Taka
			"CAD" => "C$" , //Canadian Dollar
			"CHF" => "Fr" , //Swiss Franc
			"CRC" => "₡", //Costa Rican Colon
			"CZK" => "Kč" , //Czech Koruna
			"DKK" => "kr" , //Danish Krone
			"EUR" => "€" , //Euro
			"GBP" => "£" , //Pound Sterling
			"HKD" => "$" , //Hong Kong Dollar
			"HUF" => "Ft" , //Hungarian Forint
			"ILS" => "₪" , //Israeli New Sheqel
			"INR" => "₹", //Indian Rupee
			"ILS" => "₪",	//Israeli New Shekel
			"JPY" => "¥" , //also use ¥ JapaneseYen
			"KZT" => "₸", //Kazakhstan Tenge
			"KRW" => "₩",	//Korean Won
			"KHR" => "៛", //Cambodia Kampuchean Riel	
			"MYR" => "RM" , //Malaysian Ringgit 
			"MXN" => "$" , //Mexican Peso
			"NOK" => "kr" , //Norwegian Krone
			"NGN" => "₦",	//Nigerian Naira
			"NZD" => "$" , //New Zealand Dollar
			"PHP" => "₱" , //Philippine Peso
			"PKR" => "₨" , //Pakistani Rupees
			"PLN" => "zł" ,//Polish Zloty
			"SEK" => "kr" , //Swedish Krona 
			"TWD" => "$" , //Taiwan New Dollar 
			"TWD" => "$" , //Taiwan New Dollar 
			"THB" => "฿" , //Thai Baht
			"TRY" => "₺", //Turkish Lira
			"USD" => "$" , //U.S. Dollar
			"VND" => "₫"	//Vietnamese Dong
			 );
			   if (array_key_exists($countryCode,$currency))
			  {
			  return $currency[$countryCode];
			  }
	}
	public function getMonth_Name($month){
		$monthnames =array(
			"01"=>"January",
			"02"=>"Febraury",
			"03"=>"March",
			"04"=>"April",
			"05"=>"May",
			"06"=>"June",
			"07"=>"July",
			"08"=>"August",
			"09"=>"September",
			"10"=>"October",
			"11"=>"November",
			"12"=>"December",
			 );
			   if (array_key_exists($month,$monthnames))
			  {
			  return $monthnames[$month];
			  }
	}

	public function add_activity($user_id,$activity){
	  try
	  {
	   $sql = "INSERT INTO `activities`(`user_ID`,`activity`) VALUES ('$user_id','$activity')";
	   $stmt = $this->conn->prepare($sql);
	   $stmt->execute();
	  }
	  catch(PDOException $ex)
	  {
	   echo $ex->getMessage();
	  }
	  
	 }
	 public function runQuerydrop($sql) {
		$result = $this->conn->prepare($sql);
		$result->execute();
		while($row=$result->fetch(PDO::FETCH_ASSOC)) {
			$resultset[] = $row;
		}  
		if(!empty($resultset))
			return $resultset;
	}
	 public function get_subcategory($id){
        $sql = "SELECT * FROM `sub_category` WHERE `subcat_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//echo $sql;
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cat_name = $row['subcat_name'];
		return  $cat_name;
    }
	public function get_subcategoryDetails($id){
        $sql = "SELECT * FROM `sub_category` WHERE `subcat_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//echo $sql;
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//$cat_name = $row['subcat_name'];
		return  $row;
    }
	public function runQuery($sql){
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	public function lasdID(){
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	public function storeUser($name, $email, $password,$phone,$secret) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
		$sql="INSERT INTO users(unique_id, name, email, encrypted_password, salt,  phone,google_auth_code, created_at) 
		VALUES('$uuid','$name', '$email','$encrypted_password' ,  '$salt','$phone', '$secret', NOW())";
		
        $stmt = $this->conn->prepare($sql);
         $result = $stmt->execute();
		// echo $sql;
        //$stmt->close();
		
        // check for successful store
        if ($result) {
		//echo "fhbhj";
		   $sql1="SELECT * FROM users WHERE email = '$email'";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute();
			//echo $sql1;
            $user = $stmt1->fetch(PDO::FETCH_ASSOC);
            return $user;
        } else {
            return false;
        }
    }
	public function event_logs($text){

    $uid=$_SESSION['unique_ID'];
	$text=$uid."\t".$text;
	$file = DIR_LOGS1."dailyroll".date("Y-m-d").".log";
	error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3, $file);	 
 	
}
	public function event_log($text, $level='i', $file='logs') {
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
		error_log(date("[Y-m-d H:i:s]")."\t[".$level."]\t[".basename(__FILE__)."]\t".$text."\r\n", 3, $file);
    }
	public function login($email,$upass,$secret){
	  try
	  {
	  	$this->event_logs($secret);
		$sql = "SELECT * FROM `users` WHERE email= '$email'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//echo $sql;
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		$dbsecret = $userRow['google_auth_code'];
		$this->event_logs($dbsecret);
		if($dbsecret == ''){
			$sql = "UPDATE `users` SET `google_auth_code`= '$secret' WHERE email= '$email'";
			$this->event_logs($sql);
					$stmt = $this->conn->prepare($sql);
					$stmt->execute();
		}
		if($stmt->rowCount() == 1)
		{
			$salt = $userRow['salt'];
			$encrypted_password = $userRow['encrypted_password'];
			$hash1=base64_encode(sha1($upass));
			$hash = $this->checkhashSSHA($salt, $upass);
			if ($encrypted_password == $hash)
			{ 
		//echo "hii";
				$_SESSION['userSession'] = $userRow['user_id'];      
				$_SESSION['userID'] = trim($userRow['user_id']);
				$_SESSION['unique_ID'] = $userRow['unique_id'];
				$_SESSION['userEmail'] = $userRow['email'];
				$_SESSION['name'] = $userRow['name'];
				$_SESSION['timestamp'] = time();
				return true;
			}
			else
			{
				
			}
		}
		else
		{
			
		}  
	  }
	  catch(PDOException $ex)
	  {
	   //echo $ex->getMessage();
	  }
	 }	
	 public function login1($email,$upass){
	  try
	  {
	  	$this->event_logs($secret);
		$sql = "SELECT * FROM `users` WHERE email= '$email'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//echo $sql;
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount() == 1)
		{
			$salt = $userRow['salt'];
			$encrypted_password = $userRow['encrypted_password'];
			$hash1=base64_encode(sha1($upass));
			$hash = $this->checkhashSSHA($salt, $upass);
			if ($encrypted_password == $hash)
			{ 
				
				$userid=$user['user_id'];
				$date = date("Y-m-d");
				$sql = "SELECT * from `subscriber` WHERE `user_id` = '$userid'";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
				$exdate=$userRow['expiry_date'];
					if($exdate >= $date){
						$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
					}
					else{
					$sql1="UPDATE `users` SET `usertype`='expireduser' WHERE user_id='$userid'";
					$stmt1= $this->conn->prepare($sql1);
					$stmt1->execute();
					
					}
					$sql="SELECT * FROM users WHERE email = '$email'";
					$stmt = $this->conn->prepare($sql);
					$stmt->execute();
					$user = $stmt->fetch(PDO::FETCH_ASSOC);
				 return $user;
			}
			else
			{
				
			}
		}
		else
		{
			
		}  
	  }
	  catch(PDOException $ex)
	  {
	   //echo $ex->getMessage();
	  }
	 }	
	 public function getusernamebyid($uid)
     {
		$sql="SELECT name from users  WHERE unique_id = '$uid'";
        $stmt = $this->conn->prepare($sql);
		$stmt->execute();
       //$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	   $data = $stmt->fetch(PDO::FETCH_ASSOC);
	   $name=$data['name'];
          return $name;
	 }
	 public function userDetails($uid)
     {
	$sql="SELECT email,name,google_auth_code from users  WHERE user_id = '$uid'";
        $stmt = $this->conn->prepare($sql);
		$stmt->execute();
       //$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	   $data = $stmt->fetch(PDO::FETCH_ASSOC);
          return $data;
	 }
	public function change_user($userId){
	  try
	  {
	   $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id=:userid");
	   $stmt->execute(array(":userid"=>$userId));
	   $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	   
	   if($stmt->rowCount() == 1)
	   {
		if($userRow['userstatus']=="Y")
		{
		  $_SESSION['userSession'] = $userRow['user_id'];      
		  $_SESSION['userID'] = trim($userRow['user_id']);  
		  $_SESSION['unique_ID'] = $userRow['unique_id']; 
		  $_SESSION['userEmail'] = $userRow['email'];		  
		  $_SESSION['readOnly'] = 0;
		  $_SESSION['caseID'] = 0; 
		  $_SESSION['AllDOC'] = 0;
		  $_SESSION['oId'] = 0;
		  $_SESSION['caseStatus'] = OPEN;   
		  $this->redirect("mylist.php");
		  return true;
		}
		else
		{
		 header("Location: myfamily.php?inactive");
		 exit;
		} 
	   }
	   else
	   {
		header("Location: myfamily.php?error");
		exit;
	   }  
	  }
	  catch(PDOException $ex)
	  {
	   echo $ex->getMessage();
	  }
	}
	public function get_email($id){
        $sql = "SELECT * FROM `users` WHERE `unique_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	    $uid = $row['user_id'];
		return  $uid;
    }
	public function getname($id){
        $sql = "SELECT * FROM `users` WHERE `unique_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//echo $sql;
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	    $uid = $this->dencrypted($row['name']);
		return  $uid;
    }
	public function get_names($id){
        $sql = "SELECT * FROM `users` WHERE `user_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//echo $sql;
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	    $uid = $this->dencrypted($row['name']);
		return  $uid;
    }
	public function getUseridByUniq($id){
        $sql = "SELECT * FROM `users` WHERE `unique_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$id = $row['user_id'];
		return  $id;
    }
	public function get_id($id){
        $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$email = $row['email'];
		return  $email;
    }	
	public function get_category($id){
        $sql = "SELECT * FROM `category` WHERE `cat_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cat_name = $row['cat_name'];
		return  $cat_name;
    }
	public function get_incomecategory($id){
        $sql = "SELECT * FROM `income_category` WHERE `cd_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cat_name = $row['cat_name'];
		return  $cat_name;
    }
	public function get_account($id){
        $sql = "SELECT * FROM `accounts` WHERE `account_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$accountname = $row['accountname'];
		return  $accountname;
    }
	public function get_groupcount($id){
        $sql = "SELECT * FROM `groups` WHERE `account_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$count=$stmt->rowCount();
		return  $count;
    }
	public function get_accountdetails($id){
        $sql = "SELECT * FROM `accounts` WHERE `account_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return  $row;
    }
    public function getuserdata($id){
        $sql = "SELECT * FROM `users` WHERE `user_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return  $row;
    }  
	public function getuserid($id){
        $sql = "SELECT * FROM `users` WHERE `unique_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$userid=$row['user_id'];
		return  $userid;
    }
	public function storeEvent($lat,$lng,$ip){
	
	    $stmt = $this->conn->prepare("INSERT INTO `event_log`(`latittude`, `logitude`,`user_ip`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sss", $lat, $lng, $ip);
        $result = $stmt->execute();
        $stmt->close();
	
	}
	public function getshareevent($event){
	
		$sql = "SELECT * FROM `share` WHERE `event_id` = '$event'and `status`='share' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$count =  $stmt->rowCount();
		//$id = $row['id'];
		//echo $id;
		return  $count;
	
	}
    public function getUserByEmailAndPassword($email, $password,$secret) {
       $sql="SELECT * FROM users WHERE email = '$email'";
	 
      $stmt = $this->conn->prepare($sql);
		$stmt->execute();
		
	 //echo $sql;
		 if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
			//print_r($user);
           // $stmt->close();
			$dbsecret = $user['google_auth_code'];
			if($dbsecret == ''){
				$sql = "UPDATE `users` SET `google_auth_code`= '$secret' WHERE email= '$email'";
						$stmt = $this->conn->prepare($sql);
						$stmt->execute();
			}
            // verifying user password
             $salt = $user['salt'];
             $encrypted_password = $user['encrypted_password'];
            $userstatus = $user['userstatus'];
			//echo"-";
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
				//echo"hjghj";
                // user authentication details are correct
            if ($userstatus == 'Y') {
				$userid=$user['user_id'];
				$date = date("Y-m-d");
				$sql = "SELECT * from `subscriber` WHERE `user_id` = '$userid'";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
			//echo $sql;
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
				$exdate=$userRow['expiry_date'];
				if($exdate >= $date){
					$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
				}
				else{
				$sql1="UPDATE `users` SET `usertype`='expireduser' WHERE user_id='$userid'";
				$stmt1= $this->conn->prepare($sql1);
				$stmt1->execute();
				
				}
				$sql="SELECT * FROM users WHERE email = '$email'";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
						// user authentication details are correct
                return $user;
            }
			}
        } else {
            return NULL;
        }
    }
    public function isUserExisted($email) {
	 $sql="SELECT email from users WHERE email = '$email'";
        $stmt = $this->conn->prepare($sql);

       
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
		
            return true;
        } else {
            // user not existed
            //$stmt->close();
            return false;
        }
    }
    public function checkForSubscribe($userid) {
		$date = date("Y-m-d");
		$sql = "SELECT * from `subscribers` WHERE `user_ID` = '$userid' AND `expiry_date` >= '$date'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
        if($stmt->rowCount() == 1){
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			$result['result'] = "TRUE"; 
			$result['data'] = $userRow; 
		}
		else{
			$sql1="UPDATE `users` SET `usertype`='expireduser' WHERE user_id='$userid'";
			$stmt1= $this->conn->prepare($sql1);
			$stmt1->execute();
			$result['result'] = "FALSE";
        }
		return $result;
		
    }
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
	public function checkhashSSHA($salt, $password) {
        
        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
	public function is_logged_in(){
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	public function redirect($url){
		$link = "<script>window.location.replace('$url');</script>";
		echo $link ;
	}
	public function openinwindow($url){
		$link = "<script>window.open('$url'); </script>";
		echo $link ;
	}
	public function alertmessage($msg){
		$link = "<script>alert('$msg'); </script>";
		echo $link ;
	}
	public function redirectwithjava($url){
		$link = "<script>window.location.replace('$url');</script>";
		echo $link ;
	}
	public function logout(){
		session_destroy();
		$_SESSION['userSession'] = false;
	}
	public function send_mail($email,$subject,$message){						
		//require_once('mailer/class.phpmailer.php');
		require_once('PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		//$mail->SMTPSecure = "ssl";                 
		//$mail->Host       = "smtp.gmail.com";      
		//$mail->Port       = 465;  
		//$mail->SetLanguage("en", 'includes/phpMailer/language/');		
		$mail->AddAddress($email);
		//$mail->Username="ManoharPV@gmail.com";  // User User Email
		//$mail->Password="xxxxxx";            // Password
		$mail->SetFrom('support@jwtechinc.com','DailyRoll');  // Email
		$mail->AddReplyTo("support@jwtechinc.com","DailyRoll");  // email
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}	
	public function send_support_mail($from,$email,$subject,$message){	
        $app=APPNAME;		
		//require_once('mailer/class.phpmailer.php');
		require_once('PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		//$mail->SMTPSecure = "ssl";                 
		//$mail->Host       = "smtp.gmail.com";      
		//$mail->Port       = 465;  
		//$mail->SetLanguage("en", 'includes/phpMailer/language/');		
		$mail->AddAddress($email);
		//$mail->Username="ManoharPV@gmail.com";  // User User Email
		//$mail->Password="xxxxxx";            // Password
		$mail->SetFrom($from,$from);  // Email
		$mail->AddReplyTo($from,$from);  // email
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}	
	function sendactive_mail($send,$subject,$message,$uploadfile){						
		//require_once('mailer/class.phpmailer.php');
		require_once('member/phpmailer/class.phpmailer.php');
		if (array_key_exists('userfile', $_FILES)) {
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		//$mail->SMTPSecure = "ssl";                 
		//$mail->Host       = "smtp.gmail.com";      
		//$mail->Port       = 465;  
		//$mail->SetLanguage("en", 'includes/phpMailer/language/');		
		$mail->AddAddress(trim($send));
		$mail->AddBCC(trim($send));
		//$mail->Username="ManoharPV@gmail.com";  // User User Email
		//$mail->Password="xxxxxx";            // Password
		$mail->SetFrom('support@jwtechinc.com','DailyRoll');  // Email
		$mail->AddReplyTo("support@jwtechinc.com",'DailyRoll');  // email
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
			  for ($ct = 0; $ct < count($_FILES['userfile']['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['userfile']['name'][$ct]));
        $filename = $_FILES['userfile']['name'][$ct];
        if (move_uploaded_file($_FILES['userfile']['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
        } else {
            $msg .= 'Failed to move file to ' . $uploadfile;
        }
		
    }
		$mail->Send();
		$mail->ClearAddresses();
		$mail->ClearBCCs();
		}

	}
	}

	?>