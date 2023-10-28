<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\EncryptionService;
use Illuminate\Support\Facades\Crypt;
use App\Models\IdCardImage;
use App\Models\UploadFiles;
use App\Models\VideoFiles;



class DashboardController extends Controller
{
    protected $encryptionService;

    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }

    public function showDashboard()
    {
        return view('dashboard');
    }

    public function uploadIDCard(Request $request)
    {
        if ($request->hasFile('idcard')) {
            $file = $request->file('idcard');
            $fileName = 'idcard_' . Auth::user()->id . '.' . $file->getClientOriginalExtension();
            $fileContents = file_get_contents($file);
    
            $encryptionMethod = $request->input('encryption_method'); // Get the selected encryption method
    
            switch ($encryptionMethod) {
                case 'aes':
                    $encryptedData = Crypt::encrypt($fileContents); // Use Laravel's built-in encryption (AES)
                    break;
                case 'rc4':
                    // Use your custom RC4 encryption method here
                    $encryptedData = $this->encryptionService->rc4Encrypt($fileContents, 'your_rc4_encryption_key');
                    break;
                case 'des':
                    // Use your custom DES encryption method here
                    $encryptedData = $this->encryptionService->desEncrypt($fileContents, 'your_des_encryption_key');
                    break;
                default:
                    // Handle invalid or missing encryption method
                    return redirect()->back()->with('error', 'Invalid encryption method selected.');
            }
    
            // Save the encrypted data to the database (this is an example, modify based on your model and database structure)
            $idCardImage = new IdCardImage();
            $idCardImage->user_id = Auth::user()->id;
            $idCardImage->path_to_image = $fileName;
            $idCardImage->encrypted_data = $encryptedData;
            $idCardImage->save();
            return view('data_retrieval');
        }
    
        return redirect()->back()->with('error', 'Files uploaded and encrypted successfully.');
    }
    public function uploadFiles(Request $request)
    {
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $fileName = 'files_' . Auth::user()->id . '.' . $file->getClientOriginalExtension();
            $fileContents = file_get_contents($file);
    
            $encryptionMethod = $request->input('encryption_method');
    
            switch ($encryptionMethod) {
                case 'aes':
                    $encryptedData = Crypt::encrypt($fileContents);
                    break;
                case 'rc4':
                    $encryptedData = $this->encryptionService->rc4Encrypt($fileContents, 'your_rc4_encryption_key');
                    break;
                case 'des':
                    $encryptedData = $this->encryptionService->desEncrypt($fileContents, 'your_des_encryption_key');
                    break;
                default:
                    return redirect()->back()->with('error', 'Invalid encryption method selected.');
            }
    
            $uploadFiles = new UploadFiles();
            $uploadFiles->user_id = Auth::user()->id;
            $uploadFiles->path_to_image = $fileName;
            $uploadFiles->encrypted_data = $encryptedData;
            $uploadFiles->save();
            return view('data_retrieval');
        }
    
        return redirect()->back()->with('error', 'Files uploaded and encrypted successfully.');
    }
    
    public function uploadVideo(Request $request)
    {
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $fileName = 'video_' . Auth::user()->id . '.' . $file->getClientOriginalExtension();
            $fileContents = file_get_contents($file);
    
            $encryptionMethod = $request->input('encryption_method');
    
            switch ($encryptionMethod) {
                case 'aes':
                    $encryptedData = Crypt::encrypt($fileContents);
                    break;
                case 'rc4':
                    $encryptedData = $this->encryptionService->rc4Encrypt($fileContents, 'your_rc4_encryption_key');
                    break;
                case 'des':
                    $encryptedData = $this->encryptionService->desEncrypt($fileContents, 'your_des_encryption_key');
                    break;
                default:
                    return redirect()->back()->with('error', 'Invalid encryption method selected.');
            }
    
            $videoFiles = new VideoFiles();
            $videoFiles->user_id = Auth::user()->id;
            $videoFiles->path_to_image = $fileName;
            $videoFiles->encrypted_data = $encryptedData;
            $videoFiles->save();
            return view('data_retrieval');
        }
    
        return redirect()->back()->with('error', 'Files uploaded and encrypted successfully.');
    }
}    