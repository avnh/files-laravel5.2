<?php

namespace App\Http\Controllers;

use Request;
use Response;
use Validator;
use Auth;
use Storage;
use Session;

use Illuminate\Support\Facades\DB;
use \App\User;
use \App\File;
use \App\LockFile;
use \App\Category;
use \App\UploadSetting;

class UserController extends Controller
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
     * Check username.
     *
     * @return void
     */
    public function checkUsername($username)
    {
        if (($username === Auth::user()->username)){
            $this->urlUsername = $username;
            return true;
        } else {
            return false;
        }   
    }
    /**
     * Get user::dashboard  info
     *
     * @return void
     **/
    public function getUserInfo() {
        
        ## Get User Personal Info
        $this->userInfo  = User::where('username', '=', $this->urlUsername)->first();
        if(!$this->userInfo ){
            die('a');
        }
        ## Get User Files Info
        $this->userFiles = File::where('userID', '=', $this->userInfo['id'])->get();        
        ## If Admin Preview Mode = true, this Variable will return true
        $this->adminPreviewMode = ( defined('ADMIN_PREVIEW_MODE') ? true : false );
        ## Get User Type ( Admin - Normal )
        $this->isAdmin = ($this->userInfo->level === 'admin') ? true : false;
        
        ## Get Total Files Size
        $this->totalFilesSize = 0;
        
        foreach($this->userFiles as $file){
            $this->totalFilesSize += $file['fileSize'];
        }
        
        ## Get Categories Info
        $this->categories = Category::all();

        $userDiskSpace = UploadSetting::find(1)->userDiskSpace;
        
        $this->userAvailableDiskSpace = $userDiskSpace - $this->totalFilesSize;
        
        

        ## Function To Handle Files Size
        function size ( $type, $sub = null ){
            if($sub === null){
                $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
                $base = 1024;
                $class = min((int)log($type , $base) , count($si_prefix) - 1);

                return @$disk_free_space = sprintf('%1.2f' ,
                    $type / pow($base,$class)) . ' ' .      $si_prefix[$class] ;
            }
        }
        
        function convertFromBytes($from,$return){
            $number=$from;
            switch($return){
                case "MB":
                return round($number/pow(1024,2),2);
                case "GB":
                return $number/pow(1024,3);
                case "TB":
                return $number/pow(1024,4);
                case "PB":
                return $number/pow(1024,5);
                default:
                return $from;
            }
        }
        
    }

    /**
     * Get home  info
     *
     * @return void
     **/
    public function getHomeInfo() {
        
        ## Get User Personal Info
        $this->userInfo  = User::where('username', '=', $this->urlUsername)->first();
        if(!$this->userInfo ){
            die('a');
        }
        ## Get All Files Info
        $this->userFiles = File::all();        
        ## If Admin Preview Mode = true, this Variable will return true
        $this->adminPreviewMode = ( defined('ADMIN_PREVIEW_MODE') ? true : false );
        ## Get User Type ( Admin - Normal )
        $this->isAdmin = ($this->userInfo->level === 'admin') ? true : false;
        
        ## Get Categories Info
        $this->categories = Category::all();

        ## Function To Handle Files Size
        
        function size ( $type, $sub = null ){
            if($sub === null){
                $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
                $base = 1024;
                $class = min((int)log($type , $base) , count($si_prefix) - 1);

                return @$disk_free_space = sprintf('%1.2f' ,
                    $type / pow($base,$class)) . ' ' .      $si_prefix[$class] ;
            }
        }
        
        function convertFromBytes($from,$return){
            $number=$from;
            switch($return){
                case "MB":
                return round($number/pow(1024,2),2);
                case "GB":
                return $number/pow(1024,3);
                case "TB":
                return $number/pow(1024,4);
                case "PB":
                return $number/pow(1024,5);
                default:
                return $from;
            }
        }
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home($username)
    {
        
        if (!$this->checkUsername($username)) {
            return redirect("/");
        }
        $this->getHomeInfo();
        $this->userFilesPaginate = File::orderBy('id','desc')->paginate(20);
        // print_r($this->categories);
        $data = array(
            'title'            => 'Home',
            'nav'              => 'home',
            'adminPreviewMode' =>  $this->adminPreviewMode,
            'userName'         => $this->userInfo['username'],
            'isAdmin'          => $this->isAdmin,
            'categories'       => $this->categories,
            'userFiles'  =>   $this->userFilesPaginate,
            );
        
        return view('home')->with('data',$data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard($username)
    {
        if (!$this->checkUsername($username)) {
            return redirect("/");
        }
        $this->getUserInfo();
        
        $this->userFilesPaginate = File::where('userID', '=', $this->userInfo['id'])
        ->orderBy('id','desc')
        ->paginate(20);
        // print_r($this->userFilesPaginate);
        $data = array(
            'title'            => 'Dashboard',
            'nav'              => 'dashboard',
            'adminPreviewMode' =>  $this->adminPreviewMode,
            'userName'         => $this->userInfo['username'],
            'isAdmin'          => $this->isAdmin,
            'categories'       => $this->categories,
            'totalFiles'       => count($this->userFiles),
            'totalFilesSize'   =>  size($this->totalFilesSize),
            'totalFreeDiskSpace'   => size($this->userAvailableDiskSpace),
            'userFiles'  =>   $this->userFilesPaginate,
            'totalDownloadedFiles' => DB::table('files')->where('userID', '=', $this->userInfo['id'])->sum('fileDownloadCounter'),
            );
        return view('user.dashboard')->with('data',$data);
    }

    /**
     * Show the upload panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUpload($username) {
        if (!$this->checkUsername($username)) {
            return redirect("/");
        }
        $this->getUserInfo();
        //get Maxuplaod siex
        if($this->userAvailableDiskSpace < UploadSetting::find(1)->maxFileSize){
            $MaxUploadSize = $this->userAvailableDiskSpace;
        }else{
            $MaxUploadSize = UploadSetting::find(1)->maxFileSize;
        }
        //         
        
        
        $data = array(
            'title'            => 'Upload',
            'nav'              => 'upload',
            'adminPreviewMode' =>  $this->adminPreviewMode,
            'userName'         => $this->userInfo['username'],
            'isAdmin'          => $this->isAdmin,
            'categories'       => $this->categories,
            // User Files Loop Data
            'userFiles'        =>$this->userFiles,
            'MaxUploadSize' => convertFromBytes($MaxUploadSize,'MB')

            );
        
        return view('user.upload')->with('data',$data);
    }


     /**
     * Show the upload panel.
     *
     * @return \Illuminate\Http\Response
     */
     public function postUpload($username) {
        if (!$this->checkUsername($username)) {
            return redirect("/");
        }

        #Get upload settting
        $uploadSetting = UploadSetting::find(1);

        # Get Input form
        $input = Request::all();

        $file = $input['file'];
        
        #Get File Extention 
        $fileExt = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);

        #Get category
        $category = $input["category"];

        # Check allowed file EXT From DB
        #$allowedExt = array('png','jpg','exe','mp3','zip','rar','mp4','pdf','iso');
        $allowedExt = explode( ',' ,  $uploadSetting->allowedFilesExt );

        #  Check allowed file Size From DB
        $validator = Validator::make(
            array('file' => $file),
            array('file' => 'required|max:'.( $uploadSetting->maxFileSize)  )
            );
        
        if ($validator->fails()){
            # If File Size Not Allowed Return Error
            return Response::json('File Size Large', 200);
            
        } else if ( !in_array(strtolower($fileExt),$allowedExt) ){
            # If File Ext Not Allowed Return Error
            return Response::json('This file Type is Not Supported', 200);
            
        } else {
            # Init File To Upload
            if ($file) {

                $destinationPath =  $uploadSetting->storagePath;
                
                $date = time('d-m-Y h:i:s.u');
                
                if (!preg_match('/^[\x20-\x7E]+$/', $file->getClientOriginalName() )){
                    
                    function generateRandomString($length = 10) {
                        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < $length; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                        return $randomString;
                    }
                    $filename = str_replace(' ','',$date.'_'.generateRandomString(6).'.'
                        .$file->getClientOriginalExtension());
                } else {
                    $filename = str_replace(' ','',$date.'_'.$file->getClientOriginalName());
                }

                $upload_success = Storage::put(
                    $destinationPath.$filename, 
                    file_get_contents($file->getRealPath())
                    );
                # If file Uploaded Success
                
                if ($upload_success) {
                    
                    #save files info
                    $files = new File;
                    
                    # Category
                    $files->category = $category;

                    # File Name
                    $files->fileName = pathinfo(strtolower(htmlentities(
                        $file->getClientOriginalName())), PATHINFO_FILENAME);
                    
                    # File Path
                    $files->filePath = $destinationPath.$filename;
                    
                    # File Extention
                    $files->fileExt = strtolower($file->getClientOriginalExtension());
                    
                    # User Type 
                    if( Auth::check() ){
                        $files->UserID = Auth::user()->id;
                    }else{
                        $files->UserID = 0;
                        $files->fileDesc = 'null';
                    }
                    
                    
                    # File Status
                    $files->fileStatus = 1;

                    # File Downloads Counter
                    $files->fileDownloadCounter = 0;

                    $files->fileSize = $file->getClientSize() ;
                    
                    # Save File Info
                    $files->save();
                    
                    return Response::json('success', 200);                        

                } else {
                    
                    return Response::json('Cant Upload This File ', 200);
                }
            }
            
        }
    }


    // This Function Used To Change User Setting.
    public function setting($username) {
        if (!$this->checkUsername($username)) {
            return redirect("/");
        }
        $this->getHomeInfo();
        $data = array(
            'title'            => 'Setting',
            'nav'              => 'setting',
            'adminPreviewMode' =>  $this->adminPreviewMode,
            'isAdmin'          => $this->isAdmin,
            'userInfo'         => $this->userInfo,
            
            );
        
        
        return view('user.setting')->with('data',$data);
    }

    public function changeSetting($username){
        if (!$this->checkUsername($username)) {
            return redirect("/");
        }
        $this->getHomeInfo();
        // Get Form Inputs
        $inputs = Request::all();
        
        $rules  = array (); 
        
        if($inputs['email'] !== Auth::user()->email){
            
            $rules['email'] = 'required|email|unique:users,email';

        }
        
        if($inputs['username'] !== Auth::user()->username){
            
            $rules['username'] = 'min:5|regex:/^[A-Za-z0-9_.-]+$/|max:15|unique:users,username';

        }        
        
        if($inputs['password'] !== Auth::user()->password){
            
            $rules['password'] = 'min:6|confirmed';
            $rules['password_confirmation'] = '';

        }
        
        $validator = Validator::make($inputs,$rules);
        
        if( $validator->fails() ){
            
            return redirect()->back()
            ->withInput($inputs)
            ->withErrors($validator);
        }else {
            
            $user = User::find(Auth::user()->id);
            
            $user->username = strtolower($inputs['username']);
            $user->email = $inputs['email'];
            
            if($inputs['password'] !== ''){
                $user->password = Hash::make( $inputs['password'] );
            }

            if( $user->save() ){
                Session::flash('Message','
                    <div id="message-alert" class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <strong>Well!</strong> 
                    Your Action has been Successfully Updated.
                    </div>
                    ');
                
                return Redirect::intended('user/'.strtolower($inputs['username']).'/setting');

            }else{

                return Redirect::to('user/'.strtolower($inputs['username']).'/setting')
                ->withInput()
                ->WithErrors(' Please check your entry and try again..');
            }
        }
        
    }
}
