<?php

namespace App\Http\Services;
use App\Http\Requests\updateuserrequest;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;
// use Hash;

class AdminService{
   public function index(){
    $user=User::all();
    return $user;
   }
   public function store(StoreUserRequest $request)
   {
       $data = $request->validated();
   
       // Check if 'role' is provided, otherwise assign 'user' as default
       $data['role'] = isset($data['role']) ? $data['role'] : 'user';
   
       // Ensure the password is hashed
       $data['password'] = Hash::make($data['password']);
   
       // Create the user
       return User::create($data);
   }
   public function update(UpdateUserRequest $request, $id)
   {
       // Find the user
       $user = User::findOrFail($id);
   
       // Get validated data
       $data = $request->validated();
   
       // If password is provided, hash it
       if (isset($data['password'])) {
           $data['password'] = Hash::make($data['password']);
       }
   
       // Update user with validated data
       $user->update($data);
   
       return $user; // Return the updated user
   }
       public function delete($id){ 
        $user = User::findOrFail($id);
        if(!$user){
            return response()->json([
            'message'=> 'failed to delete',
            'status'=>'failed',]);

        }
        $user->delete(); 
        return response()->json([
            'message'=> 'the deletion had been made succusfully',
            'status'=>'succuss'
            ],204);
        }

}