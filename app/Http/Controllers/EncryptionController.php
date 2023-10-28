<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EncryptionController extends Controller
{
    public function encryptAES(Request $request)
    {
        $data = $request->input('data');
        $encryptedData = encrypt($data, 'AES-encryption-key');
        return response()->json(['encrypted_data' => $encryptedData]);
    }

    public function decryptAES(Request $request)
    {
        $encryptedData = $request->input('encrypted_data');
        $decryptedData = decrypt($encryptedData, 'AES-encryption-key');
        return response()->json(['decrypted_data' => $decryptedData]);
    }

    public function encryptRC4(Request $request)
    {
        $data = $request->input('data');
        $key = 'RC4-encryption-key';
        $encryptedData = $this->rc4Encrypt($data, $key);
        return response()->json(['encrypted_data' => $encryptedData]);
    }

    public function decryptRC4(Request $request)
    {
        $encryptedData = $request->input('encrypted_data');
        $key = 'RC4-encryption-key';
        $decryptedData = $this->rc4Decrypt($encryptedData, $key);
        return response()->json(['decrypted_data' => $decryptedData]);
    }

    public function encryptDES(Request $request)
    {
        $data = $request->input('data');
        $key = 'DES-encryption-key';
        $encryptedData = $this->desEncrypt($data, $key);
        return response()->json(['encrypted_data' => $encryptedData]);
    }

    public function decryptDES(Request $request)
    {
        $encryptedData = $request->input('encrypted_data');
        $key = 'DES-encryption-key';
        $decryptedData = $this->desDecrypt($encryptedData, $key);
        return response()->json(['decrypted_data' => $decryptedData]);
    }

    private function rc4Encrypt($data, $key)
    {
        $S = range(0, 255);
        $keyLength = strlen($key);
        $j = 0;
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $S[$i] + ord($key[$i % $keyLength])) % 256;
            list($S[$i], $S[$j]) = array($S[$j], $S[$i]);
        }
    
        $encryptedData = '';
        $i = 0;
        $j = 0;
        $dataLength = strlen($data);
        for ($k = 0; $k < $dataLength; $k++) {
            $i = ($i + 1) % 256;
            $j = ($j + $S[$i]) % 256;
            list($S[$i], $S[$j]) = array($S[$j], $S[$i]);
            $encryptedData .= $data[$k] ^ chr($S[($S[$i] + $S[$j]) % 256]);
        }
    
        return base64_encode($encryptedData);
    }
    
    private function rc4Decrypt($data, $key)
    {
        $data = base64_decode($data);
        return $this->rc4Encrypt($data, $key); // RC4 decryption is the same as encryption
    }
    
    private function desEncrypt($data, $key)
    {
        $cipherText = openssl_encrypt($data, 'des-ecb', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
        return base64_encode($cipherText);
    }
    
    private function desDecrypt($data, $key)
    {
        $cipherText = base64_decode($data);
        return openssl_decrypt($cipherText, 'des-ecb', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
    }
}