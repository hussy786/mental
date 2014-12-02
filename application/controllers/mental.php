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
     function login_post() {
        echo $email= $this->post('email');
        echo $password= $this->post('password');
       // $data =  $this->service_mod->login($email,$password);
       // $this->response($data,200);
    }
   
}