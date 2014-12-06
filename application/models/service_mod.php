<?php
	/**
	* 
	*/
	class Service_mod extends CI_Model
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		function signUp_user($firstname,$lastname,$email,$username,$password)
		{
			$data=array(
				'firstname'=>$firstname,
				'lastname'=>$lastname,
				'email'=>$email,
				'username'=>$username,
				'password'=>$password
				);
			if($this->db->insert('mg_api_user',$data))
			{
				//return mysql_insert_id();
			}
			else
			{
				echo false;
			}
		}
		function login($username,$password)
		{
		
			$this -> db -> select('user_id,username');
		   $this -> db -> from('mg_api_user');
		   $this -> db -> where("username like binary '$username'");
		   $this -> db -> where('password', $password);
		   $this -> db -> limit(1);
	   	   $query = $this -> db -> get();
			if($query->num_rows()==1)
			{
				return $query->result();
			}
			else
			{
				return false;
			}
		}
		function quitSmoke_insert($user_id,$degree,$situation,$win_loose,$comment,$unit_price)
		{
			//$dates=date("Y-m-d H:i:s", strtotime($date));
			$data=array(
				'q_userid'=>$user_id,
				'q_degree'=>$degree,
				'q_situation'=>$situation,
				'q_win_loose'=>$win_loose,
				'q_comment'=>$comment,
				'q_unit_price'=>$unit_price
				);
			if($this->db->insert('mg_quit_smoking',$data))
			{
				//echo true;
			}
			else
			{
				echo false;
			}
			
			
		}
		function quitSmoke_Current($user_id,$dt)
		{
                        $date=date('Y-m-d',strtotime($dt));
                        $start="00:00:00";
                        $end="23:59:59";
                        
                        $starter=  $this->formatedate($date,$start);
                        $endoftheday=  $this->formatedate($date,$end);
			$this -> db -> select('q_date,q_degree,q_situation,q_win_loose,q_comment,q_unit_price');
			$this -> db -> from('mg_quit_smoking');
			$this -> db -> where('q_userid',$user_id);
			$this->	db-> where('q_date >=', $starter);
			$this->	db-> where('q_date <=', $endoftheday);
			$this->db->order_by('q_date', 'desc');
			//$this -> db -> limit(1);
	   		$query = $this -> db -> get();
			if($query->num_rows()>=1)
			{
				return $query->result();
			}
			else
			{
				return false;
			}
		}
		function quitSmokeAll_Current($user_id)
		{
			$this -> db -> select('q_date,q_degree,q_situation,q_win_loose,q_comment,q_unit_price');
			$this -> db -> from('mg_quit_smoking');
			$this -> db -> where('q_userid',$user_id);
			$this->db->order_by('q_date', 'desc');
			$query = $this -> db -> get();
			if($query->num_rows()>=1)
			{
				return $query->result();
			}
			else
			{
				return false;
			}
		}
		#overview query
		#total degree
		function quitSmoke_Degree($user_id,$dt)
		{
                        $date=date('Y-m-d',strtotime($dt));
                        $start="00:00:00";
                        $end="23:59:59";
                        
                        $starter=  $this->formatedate($date,$start);
                        $endoftheday=  $this->formatedate($date,$end);
			$this -> db -> select('q_degree');
			$this -> db -> from('mg_quit_smoking');
			$this -> db -> where('q_userid',$user_id);
                        $this->	db -> where('q_date >=', $starter);
			$this->	db -> where('q_date <=', $endoftheday);
			$i=0;
			$total_degree=0;
			$query = $this -> db -> get();
			if($query->num_rows()!=0)
			{
				$data=$query->result();
				foreach ($data as &$data1) {
   				 foreach ($data1 as &$v2) {
       				$total_degree += html_entity_decode($v2, ENT_QUOTES, "utf-8") . "\n";               
    				}
				}
				return $total_degree;
			}
			else
			{
				return false;
			}
		}
		#win-loose
		function quitSmoke_Win_loose($user_id,$dt)
		{
                        $date=date('Y-m-d',strtotime($dt));
                        $start="00:00:00";
                        $end="23:59:59";
                        
                        $starter=  $this->formatedate($date,$start);
                        $endoftheday=  $this->formatedate($date,$end);
			$this -> db -> select('q_userid');
			$this -> db -> from('mg_quit_smoking');
			$this -> db -> where('q_win_loose',1);
			$this -> db -> where('q_userid',$user_id);
                        $this->	db 	-> where('q_date >=', $starter);
			$this->	db 	-> where('q_date <=', $endoftheday);
			$query = $this -> db -> get();
			if($query->num_rows())
			{
				return $query->num_rows;
			}
			else
			{
				return 0;
			}

		}
		#unit price
		function quitSmoke_Unit($user_id,$dt)
		{
                        $date=date('Y-m-d',strtotime($dt));
                        $start="00:00:00";
                        $end="23:59:59";
                        
                        $starter=  $this->formatedate($date,$start);
                        $endoftheday=  $this->formatedate($date,$end);
			$this -> db -> select('q_unit_price');
			$this -> db -> from('mg_quit_smoking');
			$this -> db -> where('q_userid',$user_id);
			$this->	db 	-> where('q_date >=', $starter);
			$this->	db 	-> where('q_date <=', $endoftheday);
			$i=0;
			$total_degree=0;
			$query = $this -> db -> get();
			if($query->num_rows())
			{
				$data=$query->result();
				foreach ($data as &$data1) {
   				 foreach ($data1 as &$v2) {
       				$total_degree += html_entity_decode($v2, ENT_QUOTES, "utf-8") . "\n";               
    				}
				}
				return $total_degree;
			}
			else
			{
				return 0;
			}
		}
		#total recordcount
		function quitSmoke_Count($user_id,$dt)
		{
            $date=date('Y-m-d',strtotime($dt));
            $start="00:00:00";
            $end="23:59:59";
            $starter=  $this->formatedate($date,$start);
            $endoftheday=  $this->formatedate($date,$end);
			$this -> db -> select('q_userid');
			$this -> db -> from('mg_quit_smoking');
			$this -> db -> where('q_userid',$user_id);
			$this->	db-> where('q_date >=', $starter);
			$this->	db-> where('q_date <=', $endoftheday);
			$query = $this -> db -> get();
			if($query->num_rows())
			{
				return $query->num_rows;
			}
			else
			{
				return 0;
			}
		}
		#get all data
		function quitSmokeAllData($user_id)
		{
                    $sql = "SELECT DISTINCT YEAR(q_date) as years FROM mg_quit_smoking where q_userid='".$user_id."' order by q_date DESC ";
//                    echo $sql;
                    $query = $this->db->query($sql); 
			$i=0;
			$MAINARRAY=array();
			if($query->num_rows()!=0)
			{
				$data=$query->result();
				
				
				foreach ($data as $value1) {
                                    $year=$value1->years;
                                    $new=array();
                                      $new['year']= $value1->years;
                                      $new['yeardata']=  $this->get_monthsofthisdf($year,$user_id);
//                                      print_r($new);
                                      array_push( $MAINARRAY, $new);
				}
                                
			}
			
                        return $MAINARRAY;
		}
                
                function get_monthsofthisdf($year,$user_id){
                     $sql1 = "SELECT DISTINCT MONTH(q_date) as monthlydata FROM mg_quit_smoking where q_userid='".$user_id."' and YEAR(q_date)='".$year."' order by q_date DESC ";
                     $query1 = $this->db->query($sql1); 
                     
                     
                    $mymonths=array();
                      if($query1->num_rows()!=0)
			{
				$data=$query1->result();
                                
                                for($i=0;$i<count($data);$i++) {
                                    $new=array();
                                    $monthno=$data[$i]->monthlydata;
                                    $mymonths[$i]['month']=$monthno;
                                    $mymonths[$i]['monthdata']=$this->get_dayofthis($year,$monthno,$user_id);
//                                    print_r( $new['monthdata']);
//                                    $mydata
//                                    array_push($mymonths, $new);

                                }
//                                   $mymonths['totalmonth']=count($data);  

			}
                    return $mymonths;
                }
                function get_dayofthis($year,$monthg,$user_id){
                     $sql1 = "SELECT DISTINCT DAY(q_date) as dateofday FROM mg_quit_smoking where q_userid='".$user_id."' and month(q_date)='".$monthg."'  and YEAR(q_date)='".$year."' order by q_date DESC ";
                     $query1 = $this->db->query($sql1); 
                     
                     
                    $mydays=array();
                      if($query1->num_rows()!=0)
			{
                            $data=$query1->result();
                            for($i=0;$i<count($data);$i++) {
                                $dayno=$data[$i]->dateofday;
                                $mydays[$i]['day']=$dayno;
                                $mydays[$i]['daydata']=$this->getdaywise_record($year,$monthg,$dayno,$user_id);

                            }
//                             $mydays['totaldays']=count($data);

			}

                    $makeonemore=array($mydays);
                    return $mydays;
//                    return $mydays;
                }
                function getdaywise_record($year,$monthg,$dayno,$user_id){
//                    h 	2014-12-02 13:59:59
                    $start="00:00:00";
                    $end="23:59:59";
                    $createdate=$year."-".$monthg."-".$dayno;
                    $starter=  $this->formatedate($createdate,$start);
                    $endoftheday=  $this->formatedate($createdate,$end);
                    $sql = "SELECT DISTINCT SUM(q_degree) as degreeval ,SUM(q_unit_price) as unitprice  FROM mg_quit_smoking where q_userid='".$user_id."' and q_date>='".$starter."'  and q_date<='".$endoftheday."' order by q_date DESC ";
                    $query = $this->db->query($sql);  
                    $mydays=array();
                      if($query->num_rows()!=0)
                        {
                                $data=$query->result();
                                for($i=0;$i<count($data);$i++) {
                                    
                                    $mydays['degree']=  $this->isnullval($data[$i]->degreeval);
                                    $mydays['unitprice']=$this->isnullval($data[$i]->unitprice);
                                    $mydays['win']=  $this->isnullval($this->getwinnerorlooser(1,$starter,$endoftheday,$user_id));
                                    $mydays['looser']=$this->isnullval($this->getwinnerorlooser(2,$starter,$endoftheday,$user_id));
                                    $mydays['savings']=$this->isnullval(($data[$i]->unitprice)*$mydays['win']);
                                    $mydays['totalrecord']=  $this->isnullval(($mydays['win'])+(  $mydays['looser']));
                                    
                                }

                        }
                       
                    $makeonemore=array($mydays);
                    return $makeonemore;
                }
                function  isnullval($val){
                    if($val==NULL || $val=="") {
                        $val=0;
                    }
                    else {
//                       $val=0; 
                    }
                    return $val;
                }
                function  formatedate($createdate,$start){
                    $dt=$createdate." ".$start;
                    $mydate=  date('Y-m-d H:i:s',strtotime($dt));
                    return $mydate;
                }
                function getwinnerorlooser($checking,$starter,$endoftheday,$user_id) {
       
                    $sql = "SELECT q_win_loose  FROM mg_quit_smoking where q_win_loose='".$checking."' and q_userid='".$user_id."' and q_date>='".$starter."'  and q_date<='".$endoftheday."' order by q_date DESC ";
                    $query = $this->db->query($sql);  
                    $totalval=$query->num_rows();
                    return $totalval;
                   
                }
                function quitSmokeGetGraphs($user_id,$date)
                {
                    $myarray=array();
                    $timestamp = strtotime($date);
                    $timestamp -= 24 * 3600*6;
                    for ($i = 0 ; $i < 7 ; $i++) {
                        $last7=date('Y-m-d', $timestamp);
                        $year=date('Y',strtotime($last7));
                        $month=date('m',strtotime($last7));
                        $days=date('d',strtotime($last7));
                        $myarray[$i]['date']=$last7;
                        $myarray[$i]['data']=$this->getdaywise_record($year,$month,$days,$user_id);
                        
                        $timestamp += 24 * 3600;
                    }
                   
//                   $last7=  strtotime('-1 day', strtotime($date));
                   return $myarray;
            /*
		$sql = "SELECT * FROM mg_quit_smoking where user_id='".$user_id."' and q_date='".$date."' order by q_date DESC ";
                $query = $this->db->query($sql);  
                $totalval=$query->num_rows();
                return $totalval;*/
                }
    }
	
	
		
	
?>