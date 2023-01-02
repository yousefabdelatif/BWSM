<?php
require('model\Utils\Post.php');
class PosterModel
{

   private PDO $db ;
public function __construct(PDO $db)
{
    $this->db=$db;

}





Public function AddnewPost(string $PostContent,Int $CurrentUserID )
{


    $query3="INSERT INTO `users_posts`(`POSTER_ID`,`POST_ID`, `POST_TEXT`) VALUES (?,?,?)";
    $stmt = $this->db->prepare( $query3);

$stmt->execute([$CurrentUserID,$CurrentUserID.date("YmdHis"),$PostContent]);

}

public function AddLike(int $PostID,int $CurrentUserID)
{





    $stmt = $this->db->prepare("SELECT `REATION_ACTIVTY` FROM `bwsm` WHERE `ID`=$CurrentUserID");
    $stmt->execute();
        // careful, without a LIMIT this can take long if your table is huge
    $temp =((array)(((array)$stmt->fetchAll(PDO::FETCH_OBJ))[0]) )["REATION_ACTIVTY"];

       // echo ($CurrentUserID);





    $parsedREATION_ACTIVTY_Arr =array();
        if ($temp !== null) {
            $parsedREATION_ACTIVTY_Arr = explode(":", $temp);
        }



        var_dump(array_search($PostID, $parsedREATION_ACTIVTY_Arr));

            if (array_search($PostID, $parsedREATION_ACTIVTY_Arr) === false) {

                $temp1 = $this->db->prepare("UPDATE `bwsm` SET `REATION_ACTIVTY`=(?) WHERE `ID`= '$CurrentUserID'");
                $temp1->execute(["$temp:$PostID"]);


                $this
                    ->db
                    ->prepare("UPDATE `users_posts` SET `NUMBER_OF_LIKES`=`NUMBER_OF_LIKES`+1 WHERE `POST_ID`=$PostID")
                    ->execute();



                    /*
                $stmtkk = $this->db->prepare("SELECT `NUMBER_OF_LIKES` FROM `users_posts` WHERE `POST_ID`='$PostID'");
                $stmtkk->execute();
                // careful, without a LIMIT this can take long if your table is huge
                $tempkk = ((array) $stmt->fetch(PDO::FETCH_OBJ));
                
                var_dump($tempkk);




                $stmt = $this->db->prepare("SELECT `NUMBER_OF_LIKES` FROM `users_posts` WHERE `POST_ID`='$PostID'");
                $stmt->execute();
                // careful, without a LIMIT this can take long if your table is huge
                $temp = ((array) $stmt->fetch(PDO::FETCH_OBJ));

*/

            
        }else
        {
           

        }
    

        }
           




    



        


/*
public function GetPosts(Int $CurrentUserID):array
{

    $stmt = $this->db->prepare( 'SELECT * FROM users_posts ');    
    $stmt->execute();

    $arr = (array)($stmt->fetch(PDO::FETCH_OBJ));
        return $arr;


    }


*/


    public function GetPosts(int $CurrentUserID)
    {
        $Posts =array();//Posts

        $stmt = $this->db->prepare("SELECT `FRIENDS` FROM `bwsm` WHERE `ID`=$CurrentUserID");
        $stmt->execute();
        $temp =((array)($stmt->fetchAll(PDO::FETCH_OBJ)[0]))['FRIENDS'];
        $Temp1 = explode(':', $temp);



        $Temp =[][0];

        unset($Temp1[0]);
        $i = 0;
        $J = 0;
        // Iteration on the friend list  
        foreach ( $Temp1 as $Val) {
            
            $Post = new Post();
            $Val = (int) $Val;
            $Post->setPostID($Val);
            $friendsNamesSTMT = $this->db->prepare("SELECT `NAME`,`PHOTO_URL` FROM `bwsm` WHERE `ID`= $Val");
            $friendsNamesSTMT->execute();
            $friendsNamesSTMT = ((array) $friendsNamesSTMT->fetch(PDO::FETCH_OBJ));
            $PosterName =$friendsNamesSTMT['NAME'];
            $PosterProfilePicUrl =$friendsNamesSTMT['PHOTO_URL'];
            


            $PostsList = $this->db->prepare("SELECT `POST_ID`,`POST_TEXT`,`NUMBER_OF_LIKES`  FROM `users_posts` WHERE `POSTER_ID`=$Val");
            $PostsList->execute();
            $PostsList = (array)((array) $PostsList->fetchAll(PDO::FETCH_OBJ));
            foreach($PostsList as $Key => $Valu )
{
                $Posts[$J] = new Post;
                $Posts[$J]->setContent(((array) $Valu)['POST_TEXT'])
                    ->setNumberOFlikes((((array) $Valu)['NUMBER_OF_LIKES']))
                    ->setPosterName(((array) $PosterName)[0])
                    ->setPosterID($Val)
                    ->setPostID(((array) $Valu)["POST_ID"])
                    ->setPosterProFilePictureUrl($PosterProfilePicUrl);
              
              
                
                $J++;
                
            }


            
        }



       
      return $Posts;

        
        
    }








    public function GetCurrentUserPosts(User $CurrentUser)
    {
        $Posts =array();//Posts


       $CurrentUserPosts= $this->db->prepare("SELECT `POST_ID`,`POST_TEXT`,`NUMBER_OF_LIKES`  FROM `users_posts` WHERE `POSTER_ID`=".$CurrentUser->GetUserID()."");
       $CurrentUserPosts->execute();
        $CurrentUserPosts = (array)$CurrentUserPosts->fetchAll(PDO::FETCH_OBJ);



       
        // Iteration on the friend list  
        
            
            

            foreach($CurrentUserPosts as $Key => $Val )
{
                $Posts[$J] = new Post;
                $Posts[$J]->setContent(((array) $Val)['POST_TEXT'])
                    ->setNumberOFlikes((((array) $Val)['NUMBER_OF_LIKES']))
                    ->setPosterName($CurrentUser->GetName())
                    ->setPostID(((array) $Val)["POST_ID"]);
              
              
                
                $J++;
                
            }


            
        
            foreach($Posts as $post)
            {
            echo ($post->getContent());
            echo ($post->getPosterName());
            echo ($post->getPostID());
            }


       
      return $Posts;

        
        
    }






}

