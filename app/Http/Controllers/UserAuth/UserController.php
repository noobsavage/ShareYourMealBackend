<?php
namespace App\Http\Controllers\UserAuth;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

use App\Models\SeatCreateModel;
use App\Models\ProfilePicEditModel;
use App\Models\foundationmealModel;
use App\Models\SendRequestModel;



class UserController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;


        //Insert Value Automatically or Hardcoded
      


return response()->json(['success'=>$success], $this-> successStatus); 
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    }

    public function CreateSeat(Request $request)
    {
        

        $seat = new SeatCreateModel;

        //$seat->host_id = Auth::user()->id;
        $seat->host_id=Auth::id();
        $seat->name=$request->name;
        $seat->longitude = $request->longitude;
        $seat->latitude  = $request->latitude;
        $seat->placeName= $request->placeName;
        $seat->No_of_seat = $request->No_of_seat;
        $seat->time       = $request->time;
        $seat->status       = $request->status;
        $seat->save();
        return response()->json($seat,201);

    }

    public function SeatsDetails(Request $request)
    {
        $user = DB::table('seat')->where('host_id', Auth::id())->orderby('created_at', 'desc')->first();
        return response()->json(['success' => $user], $this-> successStatus);
    } 
    
    public function availableSeats()
    {
        $available=SeatCreateModel::orderby('created_at','desc')->get();

        
        return response()->json($available,200);
    }

    public function SeatStatusUpdate(Request $request)
    {
        
        $seatid = DB::table('seat')->where('host_id', Auth::id())->orderby('created_at', 'desc')
        ->pluck('id');

         $seat= DB::table('seat')->where('id', $seatid)->update(['status' => 0]);

        return response()->json(['success' => $seat], $this-> successStatus);
  
    }

    public function EditProfile(Request $request){

        
            //Creating model and input values
        $profile = new ProfilePicEditModel;
        $profile->user_id = Auth::id();
        $profile->name    = $request->name;
        $profile->occupation    = $request->occupation;
        $profile->waystatus    = $request->waystatus;

        //Image Proceesing to Upload

         // $fileName=Auth::id().".png";
         //    $path = $request->file('image')->move(public_path("/ShareYourMealProfilePics"),$fileName);
         //    $photoURL= url('/ShareYourMealProfilePics/'.$fileName);
      
        //$profile->image=$photoURL;

        if($request->hasfile('image')){
            $file=$request->file('image');
            $extension= $file->getClientOriginalExtension();    //getting image extension
            $fileName = time().'.'.$extension;
            $file->move(public_path("/ShareYourMealProfilePics"),$fileName);
            $photoURL=url('/ShareYourMealProfilePics/'.$fileName);
            $profile->image= $photoURL;
        }else
        {
            return $request;
            $profile->image='';
        }

        $profile->phone = $request->phone;
        $profile->save();
        return response()->json($profile,200);


            
            // return response()->json(['url'=>$photoURL],200);
    }

    public function displayProfileData()
    {

        $getEmail=Auth::user()->email;
        $profile= DB::table('profile')->where('user_id', Auth::id())->orderby('created_at', 'desc')->first();
        return response()->json(['success' => $profile ,'successEmail' => $getEmail], $this-> successStatus);
        //return response()->json($getEmail);
    }

    public function seatDetailsWithprofile($id){

        $seatdata=DB::table('seat')->where('host_id',$id)->orderby('created_at','desc')->first();
        $profiledata=DB::table('profile')->where('user_id',$id)->orderby('created_at','desc')->first();
        
        return response()->json(['successSeat'=>$seatdata,'successProfile'=>$profiledata],$this-> successStatus);

    }
    public function foundationmeal(Request $request){

        
        $seat_idget = DB::Table('seat')->select('id')->where('host_id',Auth::id())->orderby('created_at','desc')->value('id');
     

        $meal = new foundationmealModel;
        $meal->name    = $request->name;
        $meal->foundationName    = $request->foundationName;
        $meal->quantity    = $request->quantity;
        $meal->description    = $request->description;
        $meal->seat_id    = $seat_idget;
        $meal->phone=$request->phone;
        
        if($request->hasfile('image')){
            $file=$request->file('image');
            $extension= $file->getClientOriginalExtension();    //getting image extension
            $fileName = time().'.'.$extension;
            $file->move(public_path("/MealPics"),$fileName);
            $photoURL=url('/MealPics/'.$fileName);
            $meal->image= $photoURL;
        }else
        {
            return $request;
            $meal->image='';
        }

        $meal->save();
        return response()->json($meal,200);


            
            // return response()->json(['url'=>$photoURL],200);
    }

    public function mealdetails(){

      
    
     $meal=foundationmealModel::orderby('created_at','desc')->get();

        //return response()->json($meal,200);
        return response()->json($meal,200);

    }
    public function removeButton(){


        $userStatus = DB::table('seat')->where('host_id', Auth::id())->orderby('created_at', 'desc')->get();
        
        $show=response()->json($userStatus,200);

        if($userStatus->isEmpty()){

        return response()->json(["success"=>"0"],200);
    }
    else
    {
        return response()->json(["success"=>"1"],200);
    }
    }

    public function deleteSeat(Request $request, $id){

        //$deleteSeat=DB::table('seat')->where('id', $id)->delete();
        $st=SeatCreateModel::find($id);
        $st->delete();

        //return response()->json($st);
        return response()->json(["success"=>"1"],200);
    }

     public function SendRequestForSeat(Request $request)
    {
        

        $req = new SendRequestModel;

        
        $req->seat_id=$request->seat_id;
        $req->consumer_id=Auth::id();
        $req->host_id  = $request->host_id;
        $req->requested_seat = $request->requested_seat;
        $req->status  = $request->status;
        $req->save();
        return response()->json("Successfully Send Request",201);

    }
    public function SendRequestDetails(Request $request)
    {
    $userDetailsSeat = DB::table('request')->where('host_id', Auth::id())->orderby('created_at', 'desc')->get();

    $consumeridget = DB::Table('request')->select('consumer_id')->where('host_id',Auth::id())->orderby('created_at','desc')->value('consumer_id');

    $profilename = DB::Table('profile')->select('name')->where('user_id',$consumeridget)->orderby('created_at','desc')->value('name');


    $statusValue = DB::Table('request')->select('status')->where('host_id',Auth::id())->orderby('created_at','desc')->value('status');


    
        return response()->json(["successDetails"=>$userDetailsSeat,"successName"=>$profilename,"statusValue"=>$statusValue],200);
    }

    public function updateSeatRequestStatus(Request $request)
    {


         
        $seatRequestId = DB::table('request')->where('host_id', Auth::id())->orderby('created_at', 'desc')->pluck('id');

         $seat= DB::table('request')->where('id', $seatRequestId)->update(['status' => 1]);

        return response()->json(['success' => $seat], $this-> successStatus);

    }

    public function NotmorethanoneSeat(Request $request)
    {
        $results=SeatCreateModel::where('host_id',Auth::id())->where('status',1)->orderby('created_at', 'desc')->get();

       $show=response()->json($results,200);

        if($results->isEmpty()){

        return response()->json(["success"=>"0"],200);
    }
    else
    {
        return response()->json(["success"=>"1"],200);
    }

    }


}