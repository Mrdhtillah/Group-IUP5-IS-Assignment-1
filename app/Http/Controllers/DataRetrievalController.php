<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class DataRetrievalController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->input('email'); 
    
        $user = User::where('email', $email)->first(); 
        if ($user) {
            $encryptedData = $user->encrypted_data; 
            $decryptedData = $this->decryptData($encryptedData);
    
            return view('data_retrieval', ['encrypted_data' => $encryptedData, 'decryptedData' => $decryptedData]);
        } else {
            return view('data_retrieval')->with('error', 'User not found');
        }
    }    

    private function decryptData($data)
    {
    }
}
