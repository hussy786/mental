<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class mental extends REST_Controller
{
	 public function __construct() {
            parent::__construct();
            $this->load->model('service_mod');
        }
     function signUp_post() {
     	if($this->post('firstname')&&$this->post('lastname')&&$this->post('email')&&$this->post('username')&&$this->post('password'))
     	{
     		$firstname= $this->post('firstname');
       		$lastname= $this->post('lastname');
        	$email= $this->post('email');
        	$username= $this->post('username');
        	$password= $this->post('password');
       		$this->service_mod->signUp_user($firstname,$lastname,$email,$username,$password);
       		$data['Message']="Registration succesfully";
       		$this->response($data, 200);
     	}
     	else
     	{
     		$responsestone['Message']='Missing Required Field'; 
            $this->response($responsestone,400);
     	}
       
    }    
     function login_get() {
     	if($this->get('username')&&$this->get('password'))
     	{
     		$username= $this->get('username');
      		$password= $this->get('password');
       		$data =  $this->service_mod->login($username,$password);
       		$this->response($data, 200);
     	}
     	else
     	{
     		$responsestone['Message']='Missing Required Field'; 
            $this->response($responsestone,400);
     	}
       
       
    }
    function quitSmoke_post()
    {
    	if($this->post('user_id')&&$this->post('degree')&&$this->post('situation')&&$this->post('win_loose')&&$this->post('comments')&&$this->post('unit_price'))
    	{
    		$user_id=$this->post('user_id');
    		$degree=$this->post('degree');
    		$situation=$this->post('situation');
    		$win_loose=$this->post('win_loose');
    		$comment=$this->post('comments');
            $date=date("Y-m-d")." "."00:00:00";
    		///$date=$this->post('date_time');
            $unit_price=$this->post('unit_price');
    		$data =$this->service_mod->quitSmoke_insert($user_id,$degree,$situation,$win_loose,$comment,$unit_price);
    		$data['Message']='Record successfully inserted'; 
            $data['Total_Records'] =$this->service_mod->quitSmoke_Count($user_id,$date);
            $data['Total_Degree'] =$this->service_mod->quitSmoke_Degree($user_id,$date);
            $data['Total_Win'] =$this->service_mod->quitSmoke_Win_loose($user_id,$date);
            $data['Total_Loose'] =intval($data['Total_Records'])-intval($data['Total_Win']);
            $data['Total_Number']=intval($data['Total_Win'])+intval($data['Total_Loose']);
            $data['Total_Unit_Price']=$this->service_mod->quitSmoke_Unit($user_id,$date);
            $data['Total_Save']=$data['Total_Records']*$data['Total_Unit_Price'];
    		//echo json_encode($responsestone);
            $this->response($data,200);
    	}
    	else
    	{
    		$responsestone['Message']='Missing Required Field'; 
            $this->response($responsestone,400);
    	}
    
    	# code...
    }
   function quitSmokeSelect_get()
    {
    	if($this->get('user_id')&&$this->get('date_time'))
    	{
    		$user_id=$this->get('user_id');
    		$date=$this->get('date_time');
    		$data['Today Records'] =$this->service_mod->quitSmoke_Current($user_id,$date);
            if($data['Today Records']=="")
            {
                $responsestone['Message']='No data found'; 
                 $this->response($responsestone,200);
            }
            else
            {
               
                $this->response($data,200);
            }
    		//$responsestone['Message']='Record '; 
            
    	}
    	else
    	{
    		$responsestone['Message']='Missing Required Field'; 
            $this->response($responsestone,400);
    	}
    
    	# code...
    }
    function quitSmokeSelectAll_get()
    {
        if($this->get('user_id'))
        {
            $user_id=$this->get('user_id');
            $data['All Records'] =$this->service_mod->quitSmokeAll_Current($user_id);
            if($data['All Records']=="")
            {
                $responsestone['Message']='No data found'; 
                 $this->response($responsestone,200);
            }
            else
            {
                $this->response($data,200);
            }
            //$responsestone['Message']='Record '; 
            
        }
        else
        {
            $responsestone['Message']='Missing Required Field'; 
            $this->response($responsestone,400);
        }
    
        # code...
    }
     function quitSmokeOverview_get()
    {
       if($this->get('user_id')&&$this->get('date_time'))
        {
            $user_id=$this->get('user_id');
            $date=$this->get('date_time');
            $data['Total_Records'] =$this->service_mod->quitSmoke_Count($user_id,$date);
            $data['Total_Degree'] =$this->service_mod->quitSmoke_Degree($user_id,$date);
            $data['Total_Win'] =$this->service_mod->quitSmoke_Win_loose($user_id,$date);
            $data['Total_Loose'] =intval($data['Total_Records'])-intval($data['Total_Win']);
            $data['Total_Number']=intval($data['Total_Win'])+intval($data['Total_Loose']);
            $data['Total_Unit_Price']=$this->service_mod->quitSmoke_Unit($user_id,$date);
            $data['Total_Save']=$data['Total_Win']*$data['Total_Unit_Price'];
           
            if($data=="")
            {
                $responsestone['Message']='No data found'; 
                $this->response($responsestone,200);
            }
            else
            {
               
                $this->response($data,200);
            }
            //$responsestone['Message']='Record '; 
            
        }
        else
        {
            $responsestone['Message']='Missing Required Field'; 
            $this->response($responsestone,400);
        }
    
        # code...
    }
    function quitSmokeAllData_get()
    {
      if($this->get('user_id'))
      {
        $user_id=$this->get('user_id');
        $data =$this->service_mod->quitSmokeAllData($user_id);
//        print_r($data);
        $sertitle['pastdata']=$data;
        if($data=="")
            {
                $responsestone['Message']='No data found'; 
                $this->response($responsestone,200);
            }
            else
            {
//               echo json_encode($sertitle);
                $this->response($sertitle,200);
            }
            //$responsestone['Message']='Record '; 
            
        }
       else
      {
          $responsestone['Message']='Missing Required Field'; 
          $this->response($responsestone,400);
      }
    }
     function quitSmokeGraph_get()
    {
      if($this->get('user_id')&&$this->get('date_time'))
      {
         $user_id=$this->get('user_id');
         $date=$this->get('date_time');
        $data =$this->service_mod->quitSmokeGetGraphs($user_id,$date);
         $sertitle['graph']=$data;
         $this->response($sertitle,200);
            
      }
       else
      {
          $responsestone['Message']='Missing Required Field'; 
          $this->response($responsestone,400);
      }
    }
}