<?php
require("Utils\User.php");

class Model
{
    private PDO $dp ;



    public function __construct(string $hostName ="localhost:3307",string $username='root',string $password='yousef123')
    {
        try {
            $this->dp = new PDO("mysql:host=$hostName;dbname=bwsm", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                   $this->dp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch( Exception $e)
        {

            echo $e;

        } 
       
    }

    public function GetAppModel_db():PDO
    {
        return $this->dp;
    }




    public function GetUserData(User $CurrentUser_Val):bool
    {

    $stmt = $this->dp->prepare( 'SELECT * FROM bwsm WHERE EMAIL = "'.$_POST['Email'].'"');  
  
    $stmt->execute();
    $arr = (array)($stmt->fetch(PDO::FETCH_OBJ));



        if ( $arr["ID"] != null) {
            $CurrentUser_Val->SetUserID($arr["ID"]);
            $CurrentUser_Val->SetName($arr["NAME"]);
            $CurrentUser_Val->SetHashedPassword($arr["PASSWORD"]);
            $CurrentUser_Val->setUserProfilePicUrl($arr["PHOTO_URL"]);        

            return true;
        }else{
            return false;
        }
    }
    public function CheckUserPassword(User $CurrentUser_Val): bool 
    {

       
   
  return (!($_POST["Password"] ===null) && password_verify( $_POST["Password"],$CurrentUser_Val->GetPassWord()));


    }

    public function AddNewUser(User &$User_Val ,string $UserEmail,string $UserPassword,string $UserName)
    {
        $User_Val->SetEmail($UserEmail);
        $User_Val->SetName($UserName);
        $User_Val->SetPassword($UserPassword);
        $User_Val->SetUserID($this->dp->lastInsertId());
        $query3="INSERT INTO `bwsm` (`ID`, `NAME`, `EMAIL`, `PASSWORD`, `DATE`) VALUES (?,?,?,?,?)";
        $stmt = $this->dp->prepare( $query3);

    $stmt->execute([$this->dp->lastInsertId(),$UserName ,$UserEmail, $User_Val->GetPassWord(),date("Y.m.d")]);
      
        
    }

    public function setUserProfilePicUrl(User $CurrentUserId)
    {
       
        $query3="UPDATE `bwsm` SET `PHOTO_URL`=(?) WHERE `ID`=(?)";
        $stmt = $this->dp->prepare( $query3);

    $stmt->execute([date("YmdH").$CurrentUserId->GetUserID(),$CurrentUserId->GetUserID()]);
        $CurrentUserId->setUserProfilePicUrl(date("YmdH") . $CurrentUserId->GetUserID());
    }

        
}

    
