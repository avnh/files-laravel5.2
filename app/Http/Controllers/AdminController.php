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

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        if (Auth::check()) {
   		     if (Auth::user()->level > 0) {
   			return view('/');

        }
   		}
    }
    ## Function To Handle Files Size
        
    function convertToBytes($from,$return){
        
        $number=$from;
        switch($return){
            case "KB":
                return $number*1024;
            case "MB":
                return $number*pow(1024,2);
            case "GB":
                return $number*pow(1024,3);
            case "TB":
                return $number*pow(1024,4);
            case "PB":
                return $number*pow(1024,5);
            default:
                return $from;
        }
    }
    
 function convertFromBytes($from,$return){
        
        $number=$from;
        switch($return){
            case "KB":
                return $number/1024;
            case "MB":
                return $number/pow(1024,2);
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
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        print_r( asset('/') );
        function space ( $type, $sub = null ){
            if($sub === null){
                
                $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
                $base = 1024;
                $class = min((int)log($type , $base) , count($si_prefix) - 1);

                return $disk_free_space = sprintf('%1.2f' ,
                $type / pow($base,$class)) . ' ' .      $si_prefix[$class] ;
            
            }
        }
        
        $total = disk_total_space(public_path('/'));
        $free  = disk_free_space('.');
        
        $data = array(
            'title' => 'Admin Dashboard',
            'active' => 'dashboard',
            'disk_total_space' => space($total),
            'disk_free_space' => space($free),
            'disk_used_space' => space($total-$free),
            'uploadedFiles'   => File::all()->count(),
            'usersTotal'   => User::all()->count(),
            'totalDownloadedFiles' => DB::table('files')->sum('fileDownloadCounter'),
            'totalExpiredFiles' => 1234
        );
        
        return view('admin.dashboard')->with('data',$data);
    }

    /**
   *  Show the admin upload setting
   *
   * @return Response
   */
  public function upload()
  {
    //
        $data = array(
            'title' => 'Upload Setting',
            'active' => 'upload',
            'uploadSettings'=> UploadSetting::find(1),
            'maxFileSize'=> $this->convertFromBytes(UploadSetting::find(1)->maxFileSize,'MB'),
            'userDiskSpace'=> $this->convertFromBytes(UploadSetting::find(1)->userDiskSpace,'MB')

        );
        return view('admin.upload')->with('data',$data);
  }


  /**
   * Save Upload Settings form.
   *
   * @return Response
   */
  public function saveUploadSettings()
  {
    //
        
        $input = Request::all();
        
        $validator = Validator::make( 
            array(
                'maxFileSize' => $input['maxFileSize'], 
                'AllowedFilesType' => $input['AllowedFilesType'],
                'userDiskSpace' => $input['userDiskSpace'],
            ),
            
            array(
                'maxFileSize' => 'required|numeric',
                'AllowedFilesType' => 'required',
                'userDiskSpace' => 'required|numeric',
                
            )
        );
            
        if ($validator->fails()){

            return redirect()->to('admin/upload')
                            ->withInput()
                            ->WithErrors($validator);
            
        }else{

            $save = UploadSetting::find(1);
            
            $save->maxFileSize       = $this->convertToBytes($input['maxFileSize'],'MB') ;
            $save->AllowedFilesExt    = $input['AllowedFilesType'];
            $save->userDiskSpace       = $this->convertToBytes($input['userDiskSpace'],'MB') ;
            
            if( $save->save() ){
                
                Session::flash('Message','
                <div id="message-alert" class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <strong>Well!</strong> 
                  Your Action has been Successfully Updated.
                </div>
                ');
                
                return redirect()->to('admin/upload');
            }
        }
  }

  protected $totalFilesSize;
  protected $usersPaginate;
    
    function getUsersInfo() {
        
        $this->usersPaginate = DB::table('users')

            ->orderBy('users.id','desc')
            ->paginate(40);

        
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
        
        
    }

    /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function user()
  {
    //
    $this->getUsersInfo();
        $data = array(
            'title' => 'Show Users',
            'ul' => 'users',
            'active' => 'users',
            'users' => $this->usersPaginate
        );
      print_r($data['users']->links());
        
        return view('admin.user')->with('data',$data);
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
    
  public function deleteUser($id)
  {
        // check If user exists 
        $user = User::find($id);
        
        if( $user ){        
            
            // move usr file to admin owner
            DB::table('files')->where('userID','=',$id)->update(['userID' => 0]);
            // foreach($userFiles as $userFile){
                
            //     // Delete File From Disk
            //     $delete = Storage::delete($userFile->filePath);
            //     // Delete File From lockedfiles table If Exists
            //     $isLock = LockFile::where('fileId','=',$userFile->id)->delete();
            //     // Delete File From files table
            //     Files::find($userFile->id)->delete();


            // }
            
             if($user->delete()){
                 
                 Session::flash('Message','
                <div id="message-alert" class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <strong>Well!</strong> 
                  User Account, deleted Successfully. All Files are belong to admin
                </div>
                ');
                
            }
        }
        
        return redirect()->back();
  }
}
