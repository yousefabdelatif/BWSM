<?php
include_once("ErrorHandler\ErrorHandler.php");

const  MaxSize =41943040 ;

class UplodedFile
{
    const FILE_EXTENTION_STATE =0;
    const MAXFILE_SIZE_STATE = 1;
    const MINFILE_SIZE_STATE = 2;
    private string $m_Name="";
    private string $m_FullPath;
    private string $m_Type;
    private string $m_Tmp_Name;
    private string $m_Error;
    private string $m_Size="";
    private string $m_Root_Dir;
    private string $m_FormName;
    private string $m_FileNameOnServer;
    private ERR_MSG_Handler $m_ERR_MSG_Handler;

    public function __construct(string $Form_Name_Val,string $DisiredFileName_Val,string $desiredDir_Val,ERR_MSG_Handler $ERR_MSG_Handler_Val)
    {
        $this->m_ERR_MSG_Handler = $ERR_MSG_Handler_Val;
        $this->m_FormName           =$Form_Name_Val;
        if (isset($_FILES[$Form_Name_Val])) {
            $this->m_Name = $_FILES[$Form_Name_Val]['name'];
            $this->m_Type = $_FILES[$Form_Name_Val]['type'];
            $this->m_Size = $_FILES[$Form_Name_Val]['size'];
            $this->m_Error = $_FILES[$Form_Name_Val]['error'];
            $this->m_Tmp_Name = $_FILES[$Form_Name_Val]['tmp_name'];
            $this->m_Root_Dir = $desiredDir_Val;
            $this->m_FileNameOnServer = $DisiredFileName_Val;
        }
       
    
    }
    public function CheckFileValidation(string $TargetedFileExtention_Val,int $FileMaxSize_Val =MaxSize,int $FileMinSize_Val = 0):array
    {
        return [(explode('.', $this->m_Name)[1] == $TargetedFileExtention_Val) , ($FileMaxSize_Val > $this->m_Size) , ($FileMinSize_Val < $this->m_Size)];
            
    }
    public function SetRootDir(string $desiredDir_Val)
    {
        $this->m_Root_Dir = $desiredDir_Val;
    }
    public function GetRootDir():string
    {
        return $this->m_Root_Dir;
    }
    public function GetFileLocation():string
    {
        return $this->m_Root_Dir."/".$this->m_Name;
    }
    public function GetItOnTheServer()
    {
        try {
            echo (is_uploaded_file($this->m_Name));
            move_uploaded_file($this->m_Tmp_Name, $this->m_Root_Dir . $this->m_FileNameOnServer.".".(explode('.', $this->m_Name)[1]));            
        } catch (Exception $e) {
            ///not in production
            header("Location:/bwsm/ErrorPAGE");
            ///////////////////
        };
    }
    public function GetTempFileLocation():string
    {
        return $this->m_Tmp_Name;
    }

    }

