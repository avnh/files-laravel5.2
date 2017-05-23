<?php

namespace App\Http\Controllers;

use Storage;
use Request;
use Auth;
use Hash;
use Response;

use App\Http\Requests;
use \App\File;
use \App\UploadSetting;
use \App\LockFile;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
   
    }

    /**
     * get File info.
     *
     * @return void
     */

    function getFileInfo($fileid) {

        ## Get FileId From Url
        $this->fileId = $fileid;
        echo asset('/file/download/'.$this->fileId);
        ## Check If File Exists
        $this->fileData = File::where('id','=',$this->fileId)->first();
        
        ## If File Is Not Exsits
        
        if ( !$this->fileData ) {
            define('FILE-NOT-EXISTS',true);
        } else {

            $this->isLocked = LockFile::where('fileId','=',$this->fileData->id)->first();

            $this->fileDownloadPath = asset('/file/download/'.$this->fileId);

            ## Function To Handle Files Size
            function size ( $type, $sub = null ){
                if($sub === null){

                    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
                    $base = 1024;
                    $class = min((int)log($type , $base) , count($si_prefix) - 1);

                    return @$disk_free_space = sprintf('%1.2f' ,
                    $type / pow($base,$class)).' '.$si_prefix[$class] ;

                }
            }
            
        }
    }

    /**
     * Display file info.
     *
     * @return Response
     */
    function showFile($fileid) {
        $this->getFileInfo($fileid);
        if(defined('FILE-NOT-EXISTS')){
            
            return view('welcome');
        }
        
        $owner = \App\User::where('id','=',$this->fileData->userID)->first();
        $data = array(
            'nav' => 'file',
            'fileName' => $this->fileData->fileName,
            'fileSize' => size($this->fileData->fileSize),
            'fileExt' => $this->fileData->fileExt,
            'isLocked' => $this->isLocked,
            'fileDownloadPath' => $this->fileDownloadPath,
            'ownername' => $owner["username"],
            'owneremail' => $owner["email"]
        );
               
        return view('user.file')->with('data',$data);

    }

     // Download File Function
    function downloadFile($fileid) {
        
        $this->getFileInfo($fileid);

        if( $this->isLocked && !defined('UNLOCK')){
            die();
        }
        
        ignore_user_abort(true);
        @set_time_limit(0); // disable the time limit for this script
        
        
        $fileSize = $this->fileData->fileSize;
        $fileName = $this->fileData->fileName;
        $ext = $this->fileData->fileExt;
        echo Storage::disk('local')->exists($this->fileData->filePath);
        if (Storage::disk('local')->exists($this->fileData->filePath)) {
            

                header('Content-Description: File Transfer');
                header('Content-Transfer-Encoding: binary');
                #header("Pragma: no-cache");
                header("Content-length: $fileSize");
                header('Expires: 0');
                

                header('Content-Type: application/octet-stream');
                header("Content-Disposition: attachment;filename=\"".$fileName.".".$ext."\"");
                header('Pragma: no-cache');
                
            

            #header("Cache-control: private"); //use this to open files directly


            // increment donwload counter
            $this->fileData->fileDownloadCounter++;
            $this->fileData->save();                     
        }
        $downloadFile = Storage::disk('local')->get($this->fileData->filePath);

        return;
        // return (new Response($downloadFile, 200));
    }

     // This Function Used To Delete a File 
    function deleteFile() {

        # Get Input form
        $input = Request::all();
        
        $fileId = ($input['id']);
        $file = File::where('id','=',$fileId)->first();
        // check If User Owen This File
        if (Auth::user()->id === $file->userID) {
            
            $delete = Storage::delete($file->filePath);

            if($delete){
                // Delete File From files table
                File::find($fileId)->delete();
                
                // Delete File From lockedfiles table If Exists
                $isLock = LockFile::where('fileId','=', $fileId)->delete();
 
                return Response::json('ok');
            } else {
                return Response::json('fail');
            }

        } else {
            return Response::json('fail');

        }
    }


     // This Function Used To Lock ( Set Password ) a File.
    function lockFile() {
        
        # Get Input form
        $input = Request::all();
        
        $fileId = ($input['eid']);
        $file = File::find($fileId);

        if(Auth::user()->id === $file->userID ){
            
                if($file) {
                    
                    $lockExists = LockFile::where('fileId','=',$file->id)->first();
                    
                    if( $lockExists && trim($input['password']) === '' ){
                            
                            $lockExists->delete();
                            return Response::json('unLock success');

                    }elseif( $lockExists && trim($input['password']) !== '' ){
                    
                        $lockExists->filePassword = Hash::make($input['password']);
                        $lockExists->save();
                        return Response::json('Change Password success');
                    
                    }else if(!$lockExists && trim($input['password']) !== ''){
                        $lockedFiles = new LockFile;

                        $lockedFiles->fileId = $fileId;
                        $lockedFiles->userID = Auth::user()->id;
                        $lockedFiles->filePassword = Hash::make($input['password']);

                        if($lockedFiles->save()){
                            // If Lock Success
                            return Response::json('ok');

                        }else{
                            // If Lock Is Fail
                            return Response::json('fail');
                        }
                    }
                }

        } else {
            // If File Not Exsits 
            return Response::json('fail');

        }
    }
}
