<!DOCTYPE html>
<html>
<head>
    <title>Data Retrieval</title>
</head>
<body>
    <div class="container">
        <h1>Data Retrieval</h1>
        @if(isset($encrypted_data) && isset($decryptedData))
        <h2>Encrypted Data</h2>
        <p>{{ $encrypted_data }}</p>

        <h2>Decrypted Data</h2>
        <p>{{ $decryptedData }}</p>
        @else
        <p>{{ $error ?? 'Data not found' }}</p>
        @endif
    </div>
</body>
</html>
