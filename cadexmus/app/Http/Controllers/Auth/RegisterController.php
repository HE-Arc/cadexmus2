<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Projet;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
       // dd($data);
        $picturename = "default.jpg";
        $picture = $data['picture'];
            if($picture->isvalid()){

                $uniqid = uniqid();
                $array_picture = array($uniqid , $picture->getClientOriginalExtension());
                $picturename =  implode('.', $array_picture);
                $picture->move('uploads/picture/profile', $picturename);       

               // $imgsrc = array('<img src="uploads/picture/profile', $imploded, '"/>');
               // echo implode('' ,$imgsrc);
            }

        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'picture' => $picturename,
        ]);
        
        $newProject = Projet::create(["nom"=>$data['name']."'s first project"]);
        $newProject->users()->attach($newUser, ['couleur'=> 1]);
        $repr=[
            'tempo' => 120,
            'nbMesures' => 1,
            'tracks' =>[]
        ];
        $newProject->versions()->create(["numero" => 0, "repr" => $repr]);
        
        return $newUser;
    }
}
