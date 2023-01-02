<?php 

/*
//RUNTUME_ERRs CODEs

 //

class ErrorHandlier
{
const  UNVALIED_IMG_ERR =0;
const  IMG_IS_TOO_BIG_ERR =1;
const  IMG_IS_TOO_SMALL_ERR =2;
const ERR_UPLOADING_FILE = 3;
const  UNVALIIED_IMG_EXTENTION =4;
const  EMAIL_DOESNOT_EXIST = 5;
const  WRONG_PASSWORD =6;
const UNVALIED_EMAIL = 7;
const UNVALIED_PASSWORD = 8;
const UNVALIED_USER_DATA = 9;
const ERR_MSG_CONTEXT =0;
const ERR_STATE = 1;
 public array $RUNTUME_ERRs;
public function __construct()
{   
    $this->RUNTUME_ERRs[ErrorHandlier::UNVALIED_IMG_ERR]        =["",false];
    $this->RUNTUME_ERRs[ErrorHandlier::IMG_IS_TOO_BIG_ERR]      =["",false];
    $this->RUNTUME_ERRs[ErrorHandlier::IMG_IS_TOO_SMALL_ERR]    =["",false];
    $this->RUNTUME_ERRs[ErrorHandlier::ERR_UPLOADING_FILE]      =["", false];
    $this->RUNTUME_ERRs[ErrorHandlier::UNVALIIED_IMG_EXTENTION] =["",false];
    $this->RUNTUME_ERRs[ErrorHandlier::EMAIL_DOESNOT_EXIST]     =["",false];
    $this->RUNTUME_ERRs[ErrorHandlier::UNVALIED_EMAIL]          =["",false];
    $this->RUNTUME_ERRs[ErrorHandlier::UNVALIED_PASSWORD]       =["",false];
    $this->RUNTUME_ERRs[ErrorHandlier::UNVALIED_USER_DATA]      =["",false];
        $_SESSION['RUNTUME_ERRs'] = $this->RUNTUME_ERRs;

}
public function SetErrorState(int $ERR_NUM_VAL,string $ERR_MSG_CONTEXT,bool $ERR_STATE_VAL)
{
    $_SESSION['RUNTUME_ERRs'][$ERR_NUM_VAL]=[$ERR_MSG_CONTEXT,$ERR_STATE_VAL];
}
public function GetErrorState(int $ERR_NUM_VAL)
{
        print_r( $_SESSION['RUNTUME_ERRs'][7]);
        return $_SESSION['RUNTUME_ERRs'][$ERR_NUM_VAL];
}

public function GetALLErrorState():array
{
        return $_SESSION['RUNTUME_ERRs'];
}


}
*/

class ERR_MSG_Handler
{
    public function SET_ERR(string $ERR_MSG_CONTEXT_VAL,string $ROUTE_NAME_VAL)
    {
        $_SESSION['ERR_MSG'] = [$ERR_MSG_CONTEXT_VAL,$ROUTE_NAME_VAL];
    }
    public function GET_ERR_MSG()
    {    if(explode('?', $_SERVER["REQUEST_URI"])[0] ==$_SESSION['ERR_MSG'][1])
        {
            return $_SESSION['ERR_MSG'][0] ;

        }
        else {
            return false;
        }


}
}