<?php 
use FFI\Exception;

include("model\Utils\\friend.php");
class FriendSuggestionSystemModel
{
    private PDO $App_db;
    public function __construct(PDO $DB)
    {
        $this->App_db=$DB;
    }
    public function SetApp_db(PDO $db)
    {
        $this->App_db=$db;
    }








    public function GetSuggestedFriends($CurrentUserID):array|null
    {
        $Friends = array();




        $SuggestedFriends = $this->App_db->prepare("SELECT `ID`,`NAME`,`PHOTO_URL` FROM bwsm");



        $SuggestedFriends->execute();
        $SuggestedFriends=((array)$SuggestedFriends->fetchAll(PDO::FETCH_OBJ));
        $i=0;
        $FollowedFriends =$this->App_db->prepare("SELECT  `FRIENDS` FROM `bwsm` WHERE `ID`='$CurrentUserID'");
        $FollowedFriends->execute();
        $FollowedFriends = (array)$FollowedFriends->fetch(PDO::FETCH_OBJ);
        if ($FollowedFriends["FRIENDS"] !== null) {
            $FollowedFriends = explode(":", $FollowedFriends["FRIENDS"]);

            foreach ($SuggestedFriends as $SuggestedFriend) {
                $SuggestedFriend = (array) $SuggestedFriend;
                if (!($SuggestedFriend['ID'] == $CurrentUserID || array_search($SuggestedFriend['ID'], $FollowedFriends))) {
                    $Friends[$i] = new friend();
                    $Friends[$i]->setFriendId($SuggestedFriend['ID'])
                        ->setFriendName($SuggestedFriend['NAME'])
                        ->setPhotoURL($SuggestedFriend["PHOTO_URL"]);

                }
                $i++;
            }











            return $Friends;
        } else {
            return null;
        }
        ; 
    }
public function AddFriend($CurrentUserID,$NewFriendID)
{
        
            $IDS =$this->App_db->prepare("SELECT  `NUMBER_OF_FRIENDS`,`FRIENDS` FROM `bwsm` WHERE `ID`='$CurrentUserID'");
            $IDS->execute();     
            $TempArr =(array) $IDS->fetch(PDO::FETCH_OBJ);


            $this->App_db
                ->prepare("UPDATE `bwsm` SET `FRIENDS`='".$TempArr['FRIENDS'].":$NewFriendID',`NUMBER_OF_FRIENDS`='".($TempArr['NUMBER_OF_FRIENDS']=$TempArr['NUMBER_OF_FRIENDS']+1)."' WHERE `ID` =$CurrentUserID")
                ->execute();
       

        $_POST = array();


}



    public function GetFollowedFriends(int $CurrentUserID): array|null
    {
        $FollowedFriends = array();
        $FollowedFriendslist=$this->App_db->prepare("SELECT `FRIENDS` FROM bwsm Where `ID`=$CurrentUserID");
        $FollowedFriendslist->execute();
        $FollowedFriendslist =((array)$FollowedFriendslist->fetch(PDO::FETCH_OBJ))['FRIENDS'];
        if($FollowedFriendslist!==null)
        {
            $FollowedFriendslist = explode(":", $FollowedFriendslist);
            unset($FollowedFriendsList[0]);

            $i=0;
           

            foreach($FollowedFriendslist as $FollowedFriend)
            {

                $friend=new friend;
                if ($FollowedFriend!== "") 
                {

               
                $FollowedFriendData=$this->App_db->prepare("SELECT `ID`, `NAME`,`PHOTO_URL` FROM `bwsm` WHERE `ID`=".(int)$FollowedFriend);
                $FollowedFriendData->execute();
                $FollowedFriendData =(array)$FollowedFriendData->fetch(PDO::FETCH_OBJ);
                $friend->setFriendId($FollowedFriendData["ID"]);           
                $friend->setFriendName($FollowedFriendData["NAME"]);           
                $friend->setPhotoURL($FollowedFriendData["PHOTO_URL"]);
                $FollowedFriends[$i] = $friend;   
            }     
                $i++; 
            }
            return $FollowedFriends;
        } else {
            return null;
        }
    }




    public function UnFollowAfriend($CurrentUserID,$NewFriendID)
    {
        
        $IDS =$this->App_db->prepare("SELECT  `NUMBER_OF_FRIENDS`,`FRIENDS` FROM `bwsm` WHERE `ID`='$CurrentUserID'");
        $IDS->execute();     
        $IDS =(array) $IDS->fetch(PDO::FETCH_OBJ);
        
        


        $this->App_db
           ->prepare("UPDATE `bwsm` SET `FRIENDS`=(?),`NUMBER_OF_FRIENDS`='".($IDS['NUMBER_OF_FRIENDS']=$IDS['NUMBER_OF_FRIENDS']-1)."' WHERE `ID` =$CurrentUserID")
            ->execute([str_replace(':'.$NewFriendID, '', $IDS["FRIENDS"])]);
           
   

    $_POST = array();
    }
}



/*
    public function GetUserFriendslist(int $CurrentUserID): array
    {


        $FriendList =
            ($this->App_db->prepare("SELECT `NUMBER_OF_FRIENDS`,`FRIENDS`,`PHOTO_URL` FROM `bwsm` WHERE `ID`='$CurrentUserID'"));
        $FriendList->execute();
        var_dump(($FriendList->fetch(PDO::FETCH_OBJ)));

        return [];
    }
*/













/*public function GetSuggestedFriends($CurrentUserID):array
    {



        
        echo ("<pre>");
        $GetAll_IDs = $this->App_db->prepare("SELECT ID FROM bwsm");
        $GetAll_NAMES = $this->App_db->prepare("SELECT NAME FROM bwsm");



        $GetAll_IDs->execute();
        $GetAll_NAMES->execute();
        $GetAll_IDs_Arr=((array)$GetAll_IDs->fetchAll(PDO::FETCH_COLUMN));
        $GetAll_NAMES_Arr=((array)$GetAll_NAMES->fetchAll(PDO::FETCH_COLUMN));
    

       $USER_LIST_ARR = [];
             $i = 0;
            foreach($GetAll_IDs_Arr as $ID=> $VALUE){
            echo ($ID);
            $USER_LIST_ARR[$VALUE]=$GetAll_NAMES_Arr[$i];
            $i++;
            }


        unset($USER_LIST_ARR[$CurrentUserID]);
        echo ("</pre>");

       $Friends =$this->App_db->prepare("SELECT  `FRIENDS` FROM `bwsm` WHERE `ID`='$CurrentUserID'");
       $Friends->execute();

        $CurrentUSerFriendListArr =((array) $Friends->fetch(PDO::FETCH_OBJ))["FRIENDS"];
        $CurrentUSerFriendListParsedArr = null;
        if ($CurrentUSerFriendListArr !== null) {
            $CurrentUSerFriendListParsedArr = explode(":", $CurrentUSerFriendListArr);
            foreach ($CurrentUSerFriendListParsedArr as $key) {
                unset($USER_LIST_ARR[$key]);

            }
            

        }
        return $USER_LIST_ARR;
          
    }*/
