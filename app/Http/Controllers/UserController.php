<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\LogInRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\PostsCommentsResource;
use App\Http\Resources\UserResource;
use App\Services\jwtService;
use App\Jobs\SendEmailJob;

class UserController extends Controller
{
     /**
     * user signup function
     */
    public function userSignup(SignUpRequest $req)
    {
        $user=new User;
        $user->name=$req->name;
        $user->email=$req->email;
        $user->password=Hash::make($req->password);
        $user->gender=$req->gender;
        $user->status=$req->status;
        $user->token =$token = rand(100,1000);
        $user->save();
        $mail=$req->email;
        $this->sendmail($mail,$token);
        return response(["message" => "Data added successfuly please verify your email","status" =>200]);
    }
      ////sending mail function

    public function sendmail($mail,$token)
    {
        $details=[
            'title' => 'Please Verify Your Email',
            'body' => 'http://127.0.0.1:8000/api/verify/'.$mail.'/'.$token
        ];
        dispatch(new SendEmailJob($mail,$details));
        return "Email Sent Succesfully";
    }

    /**
     * user login function
     */
    public function userLogin(LogInRequest $req)
    {
        $email=$req->email;
        $password=$req->password;
        $data = DB::table('users')->where('email',$email)->get();
        $dpsw = $data[0]->password;
        $count = count($data);
        $conn= new jwtService;
        $token=$conn->get_jwt();
        //checking hash password with simp le
        if (Hash::check($password, $dpsw)) {
            DB::table('users')->where('email',$email)->update(['status'=>true]);
            DB::table('users')->where('email',$email)->update(['remember_token'=>$token]);
            return response()->json(['access_token'=>$token , 'message'=> 'successfuly login',"status"=>200]);

            }
        else{
                return response(["message" => "your credentials are not valid","status" =>401]);
        }
    }
    /**
     * update user function
     */
    public function updateUser(UpdateUserRequest $req)
    {
        $uid=$req->data->uid;
        $password=Hash::make($req->password);
        if($req->name != NULL)
        {
            if(DB::table('users')->where(['uid' => $uid])->update(['name' => $req->name])==1)
            {
              return response()->success();
            }
        }
        if($req->password != NULL)
        {
            if(DB::table('users')->where(['uid' => $uid])->update(['password' => $password])==1)
            {
                return response()->success();
            }
        }
        if($req->gender != NULL)
        {
            if(DB::table('users')->where(['uid' => $uid])->update(['gender' => $req->gender])==1)
            {
                return response()->success();
            }
        }
        else{
            return response()->json(["messsage" => "No user data to update" ,"status" => 204]);
        }
    }

    /**
     * user logout function
     */

    public function logOut(Request $req)
    {
        $key=$req->token;
        DB::table('users')->where('remember_token',$key)->update(['status'=>false]);
        DB::table('users')->where('remember_token',$key)->update(['remember_token'=>NULL]);
        return response()->json(['message'=>'logout successfuly',"status" => 200]);
    }
    /**
     * get user data function
     */
    public function getUserData(Request $req)
    {
        $uid=$req->data->uid;
        $data=DB::table('users')->select('name','email','gender')->where('uid',$uid)->get();
        return new UserResource($data);
     }
     /**
      * get all posts aginst a user
      */
    public function getPostDetails(Request $req)
    {
        $uid=$req->data->uid;
        $users = User::with(['getPostDetails', 'getPostComments'])->where('uid',$uid)->get();
        return new PostsCommentsResource($users);
    }
}
