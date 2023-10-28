<?php

namespace App;

class EncryptionService
{
    public function aesEncrypt($data, $key)
    {
        $ivSize = openssl_cipher_iv_length('aes-256-cbc');
        $iv = openssl_random_pseudo_bytes($ivSize);
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    public function aesDecrypt($data, $key)
    {
        $data = base64_decode($data);
        $ivSize = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($data, 0, $ivSize);
        $encrypted = substr($data, $ivSize);
        return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
    }

    public function rc4Encrypt($data, $key)
    {
        $cipher = "";
        $key = str_pad($key, 256, $key);
        
        $dataLength = strlen($data); 
        
        for ($i = 0; $i < $dataLength; $i++) {
            $cipher .= $data[$i] ^ $key[$i];
        }
        
        return $cipher;
    }

    public function rc4Decrypt($data, $key)
    {
        // Implement RC4 decryption logic here (same as encryption for RC4)
        return $this->rc4Encrypt($data, $key);
    }

    public function desEncrypt($data, $key)
    {
        // Implement DES encryption logic here
        $data = $this->pkcs7Pad($data, 8); 
        $encData = openssl_encrypt($data, 'des-ecb', $key, OPENSSL_ZERO_PADDING);
        return base64_encode($encData);
    }

    public function desDecrypt($data, $key)
    {
        // Implement DES decryption logic here
        $data = base64_decode($data);
        $decData = openssl_decrypt($data, 'des-ecb', $key, OPENSSL_ZERO_PADDING);
        return $this->pkcs7Unpad($decData);
    }
    
    private function pkcs7Pad($data, $blockSize)
    {
        $padding = $blockSize - (strlen($data) % $blockSize);
        $padChar = chr($padding);
        return $data . str_repeat($padChar, $padding);
    }
    
    private function pkcs7Unpad($data)
    {
        $padding = ord($data[strlen($data) - 1]);
        if ($padding > strlen($data)) {
            return false;
        }
        if (strspn($data, chr($padding), -1) != $padding) {
            return false;
        }
        return substr($data, 0, -$padding);
    }
}
