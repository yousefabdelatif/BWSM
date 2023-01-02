<?php
require("model/Utils/Password.php");
class User 
{
    //Need TO Be Changed 
    private Password $m_password ;
    private bool $m_UserLogingState;
    
    
    public function __construct()
    {
        $this->m_UserLogingState=false;
        $this->m_password=new Password();

    }

    public function setUserProfilePicUrl(string $UserProfilePicUrl_Val)
    {
        $_SESSION['UserProfilePicUrl'] = $UserProfilePicUrl_Val;
    }
    public function getUserProfilePicUrl()
    {
        return $_SESSION['UserProfilePicUrl'];
    }




    public function SetEmail(string $Email_Val){$_SESSION['CurrentUserEmail']=$Email_Val;} 
    public function SetPassword(string $Password_Val)
    {
        $this->m_password->SetHashedPassCode($Password_Val);
        $_SESSION['CurrentUserPassword']=$this->m_password->GetHashedPassCode();
    }
    public function SetHashedPassword(string $Password_Val)
    {
       
        $_SESSION['CurrentUserPassword']=$Password_Val;
    }
    public function SetName(string $Name_Val)
    {
        $_SESSION['CurrentUserName'] = $Name_Val;
    }
    public function GetPassWord():string
    {
        return $_SESSION['CurrentUserPassword'];
    }
    public function GetEmail():string
    {
       return $_SESSION['CurrentUserEmail'];}

    public function GetName():string
    {
            return $_SESSION['CurrentUserName'];  
     }

     public function SetUserLogingState(bool $UserLogingState_Val)
    {
        $_SESSION['CurrentUserLogingState']=$UserLogingState_Val;  
     }
     public function GetUserLogingState():string
    {
            return $_SESSION['CurrentUserLogingState'];  
     }
     public function SetUserID(int $UserID)
     {
         $_SESSION['CurrentUserID']=$UserID;  
      }
      public function GetUserID():string
     {
             return $_SESSION['CurrentUserID'];  
      }


}