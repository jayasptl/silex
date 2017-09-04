<?php

class DbHandler

	{
	private $conn;
	public $cnt;
	public $pages;
	function __construct()
		{
		require_once dirname(__FILE__) . '/DbConnect.php';

		// opening db connection

		$db = new DbConnect();
		$this->conn = $db->connect();
		}


	public

	function add_info($name,$email,$address,$message,$ip,$browser,$os)
		{
			
			$sql = "insert into guestbook (name,email,address,message,guest_browser,guest_os,guest_ip_address) values('" . $name . "','" . $email . "','" . $address . "','" . $message . "','" . $browser . "','" . $os . "','" . $ip . "')";
			$result1 = $this->conn->query($sql);
		if($result1){
			return 1;
		}else{
			return 0;
		}
	}

	function get_info()
		{
			
			$sql = "select count(*) from guestbook";
			$result = $this->conn->query($sql);
			
		if(mysqli_num_rows($result) > 0){
			while ($user = $result->fetch_assoc())
					{
					$cnt=$user['count(*)'];
					$pages = ceil($cnt/2);
					print_r($pages);die;
					}
			return $cnt;
		}else{
			return 0;
		}
	}

	function get_data($page_number)
		{

			$sql = "select count(*) from guestbook";
			$result1 = $this->conn->query($sql);
			
		if(mysqli_num_rows($result1) > 0){
			while ($user = $result1->fetch_assoc())
					{
					$cnt=$user['count(*)'];
					$pages = ceil($cnt/10);
					}
			}		
			
			$temp=($page_number-1)*10;
			$sql = "select * from guestbook orders limit 10 offset ".$temp;
			
			$result = $this->conn->query($sql);
			
			$data=array();
			$i = 0;
		if(mysqli_num_rows($result) > 0){
			while ($user = $result->fetch_assoc())
					{
					$data[$i]['name']=$user['name'];
					$data[$i]['message']=$user['message'];
					$data[$i]['email']=$user['email'];
					$data[$i]['address']=$user['address'];
					$data[$i]['pages']=$pages;
					$i++;
					}
					
					
			return $data;
		}else{
			return 0;
		}
	}

	}