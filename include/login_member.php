<?PHP
/*
This class handles sessions
*/
require_once("API.php");
class Loginmember{
	var $username;
    var $pwd;
    var $rand_key;
    var $error_message;
	var $loginurl;
	var $logouturl;
	var $noteurl;
	var $api;
    var $sucess_login_response_code=201;
	var $sucess_logout_response_code=200;
	var $sucess_note_response_code=200;
    //-----Initialization -------
    function Loginmember(){
        $this->rand_key = 'zggtCwjNrc5A066mFFuH';
		$this->loginurl = 'http://candidate.apiary.io/login';
		$this->logouturl = 'http://candidate.apiary.io/logout';
		$this->noteurl = 'http://candidate.apiary.io/notes';
		$this->api=new API();
    }

    function SetRandomKey($key){
        $this->rand_key = $key;
    }
    
    
	/*
	Login method: Gets username and password,call API and get response,create session 
	*/
    function Loginme(){
        if(empty($_POST['username'])){
            $this->HandleError("UserName is empty!");
            return false;
        }
        
        if(empty($_POST['password'])){
            $this->HandleError("Password is empty!");
            return false;
        }
        
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if(!isset($_SESSION)){ session_start(); }
		
		$data=array("username" => $username,"password"=>$password);
		$curl_results = $this->api->CallAPI('POST',$this->loginurl,$data);
		$results=json_decode($curl_results) ;// convert json to object
		if($results->{'session-token'}!=null && $this->api->response_code===$this->sucess_login_response_code ){
			$_SESSION[$this->GetLoginSessionVar()] = $username;
			$_SESSION[$this->GetLoginSessionTokenVar()] = $results->{'session-token'};
			return true;
		}else{
			return false;
		}
		
    }
    /*
	This checks if a session exists and is any user logged in
	*/
    function CheckLogin(){
         if(!isset($_SESSION)){ session_start(); }

         $sessionvar = $this->GetLoginSessionVar();
         
         if(empty($_SESSION[$sessionvar]))
         {
            return false;
         }
         return true;
    }
	/*
	This method returns User name if any session exists
	*/
	function postUsername(){
		return isset($_SESSION[$this->GetLoginSessionVar()])?$_SESSION[$this->GetLoginSessionVar()]:'';
	}
    /*
	Log out method: call the logout API, unset session variables
	*/
    function LogOut(){
		$data=array("session-token" => $_SESSION[$this->GetLoginSessionTokenVar()]);
		$curl_results = $this->api->CallAPI('DELETE',$this->logouturl,$data);
		$results=json_decode($curl_results) ;// convert json to object
		if( $this->api->response_code===$this->sucess_logout_response_code ){
		
			session_start();
        
			$sessionvar = $this->GetLoginSessionVar();
			$sessiontoken = $this->GetLoginSessionTokenVar();
			$_SESSION[$sessionvar]=NULL;
			$_SESSION[$sessiontoken]=NULL;
		
			unset($_SESSION[$sessionvar]);
			unset($_SESSION[$sessiontoken]);
			return true;
		}else{
			return false;
		}
    }
	/*
	This method returns all Notes of a user based on it session token
	*/
	function RetrieveNotes(){
		$data=array("session-token" => $_SESSION[$this->GetLoginSessionTokenVar()]);
		$curl_results = $this->api->CallAPI('GET',$this->noteurl,$data);
		$results=json_decode($curl_results) ;// convert json to object
		if( $this->api->response_code===$this->sucess_note_response_code ){
			return $results;
		}else{
			return false;
		}
		
	}
	
    function GetSelfScript(){
        return htmlentities($_SERVER['PHP_SELF']);
    }
    
    /*
	function is used whenever a safe display is needed.Returns only html entities
	*/
    function SafeDisplay($value_name){
        if(empty($_POST[$value_name]))
        {
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
    
    function RedirectToURL($url){
        header("Location: $url");
        exit;
    }
    
    function GetErrorMessage(){
        if(empty($this->error_message))
        {
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    }    
    
    function HandleError($err){
        $this->error_message .= $err."\r\n";
    }
    /*
	This method returns login session variable
    */
    function GetLoginSessionVar(){
        $retvar = md5($this->rand_key);
        $retvar = 'usr_'.substr($retvar,0,10);
        return $retvar;
    }
	/*
	This method returns login session token variable
    */
	function GetLoginSessionTokenVar()
    {
        $retvar = md5($this->rand_key);
        $retvar = 'toekn_'.substr($retvar,0,10);
        return $retvar;
    }
}
?>