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
        if (Auth::user()->level == 0) {
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
      $totalDownloadedFiles = DB::table('files')->sum('fileDownloadCounter');
      if(!$totalDownloadedFiles) {
        $totalDownloadedFiles = 0;
      }

      $data = array(
        'title' => 'Admin Dashboard',
        'active' => 'dashboard',
        'disk_total_space' => space($total),
        'disk_free_space' => space($free),
        'disk_used_space' => space($total-$free),
        'uploadedFiles'   => File::all()->count(),
        'usersTotal'   => User::all()->count(),
        'totalDownloadedFiles' => $totalDownloadedFiles,
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
      $uploadsetting = UploadSetting::find(1);
      if ($uploadsetting){
        $maxFileSize = $uploadsetting->maxFileSize;
        $userDiskSpace = $uploadsetting->userDiskSpace;
        $allowedFilesExt = $uploadsetting->allowedFilesExt;
      } 
      
      $data = array(
        'title' => 'Upload Setting',
        'active' => 'upload',
        'allowedFilesExt'=> $allowedFilesExt,
        'maxFileSize'=> $this->convertFromBytes($maxFileSize,'MB'),
        'userDiskSpace'=> $this->convertFromBytes($userDiskSpace,'MB')

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
        
        Session::flash('Message','Your Action has been Successfully Updated.');
        
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
    //Cannot delete root admin
    
    if ($id === '0') {
      return redirect('/');
    } 
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
        User Account, deleted Successfully. All Files are belong to admin
        
        ');
       
     }
   }
   
   return redirect()->back();
 }

 
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function file()
  {
    //
    $this->filesPaginate = DB::table('files')
    ->join('users', 'files.userID', '=', 'users.id')
    ->select('files.*','users.username')
    ->orderBy('files.id','desc')
    ->paginate(20);

    
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
    $data = array(
      'title' => 'Users Files',
      'ul' => 'file',
      'active' => 'file',
      'files' => $this->filesPaginate
      );
    
    return view('admin.file')->with('data',$data);
  }

  /**
   * Delete File Function.
   *
   * @return Response
   */
  public function deleteFile($id) {
    
        // check If File exists This File
    $response = File::deleteFile($id);

    if ($response != 'fail') {

      Session::flash('Message','
        File has been Successfully Deleted.
        ');
      
    }else{
      
      Session::flash('Message','
        Your Action has been Failed .
        ');
      
    }

    
    return redirect()->back();
  }


  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function category()
  {
    //
    $categories = DB::table('categories')->orderBy('id')->paginate(20);

    $data = array(
      'title' => 'Categories',
      'ul' => 'categories',
      'active' => 'category',
      'categories' => $categories,
      );
    
    return view('admin.category')->with('data',$data);
  }

  /**
   * Update category Function.
   *
   * @return Response
   */
  public function updateCategory() {
    
    $input = Request::all();
        // print_r($input);
        // return;
    $validator = Validator::make( 
      array(
        'name' => $input['name'], 
        'description' => $input['description'],
        ),
      
      array(
        'name' => 'required',
        'description' => 'required',
        
        )
      );
    
    if ($validator->fails()){

      return redirect()->to('admin/category')
      ->withInput()
      ->WithErrors($validator);
      
    }else{

      $save = new Category;
      
      $save->name = $input['name'];
      $save->description = $input['description'];
      
      if( $save->save() ){
        
        Session::flash('Message','Your Action has been Successfully Updated.');
        
      } else {
        Session::flash('Message','
          Your Action has been Failed .
          ');
      }
    }  
    return redirect()->back();
  }

  /**
   * Update category Function.
   *
   * @return Response
   */
  public function deleteCategory($id)
  {
    //Cannot delete default category
   if ($id === '0') {
    return redirect('/');
  } 
  if ($id === '0') {
    return redirect('/');
  } 
        // check If category exists 
  $category = Category::find($id);
  
  if( $category ){        
    
    
    
   if($category->delete()){
     
     Session::flash('Message','
      Category deleted Successfully. All Files are belong to Defaule category
      
      ');
     
   }
        // move category file to default
   DB::table('files')->where('category','=',$id)->update(['category' => 0]);
 }
 
 return redirect()->back();
}
}
