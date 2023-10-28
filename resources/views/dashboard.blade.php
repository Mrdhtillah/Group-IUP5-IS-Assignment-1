<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 350px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .card-body {
            padding: 20px;
        }

        .welcome-text {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <p>You are logged in!</p>

                        <!-- ID Card Image Upload -->
                        <form action="{{ route('upload.idcard') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="idcard">Upload ID Card Image</label>
                                <input type="file" name="idcard" accept="image/*">
                            </div>
                                <div class="form-group">
                                <label for="encryption_method">Select Encryption Method:</label>
                                <select name="encryption_method" id="encryption_method" class="form-control">
                                    <option value="aes">AES</option>
                                    <option value="rc4">RC4</option>
                                    <option value="des">DES</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload ID Card</button>
                        </form>

                        <!-- PDF/DOC/XLS File Upload -->
                        <form action="{{ route('upload.files') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="files">Upload PDF/DOC/XLS Files</label>
                                <input type="file" name="files" accept=".pdf, .doc, .docx, .xls, .xlsx">
                            </div>
                            <div class="form-group">
                                <label for="encryption_method">Select Encryption Method:</label>
                                <select name="encryption_method" id="encryption_method" class="form-control">
                                    <option value="aes">AES</option>
                                    <option value="rc4">RC4</option>
                                    <option value="des">DES</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload Files</button>
                        </form>

                        <!-- Video File Upload -->
                        <form action="{{ route('upload.video') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="video">Upload Video File</label>
                                <input type="file" name="video" accept="video/*">
                            </div>
                            <div class="form-group">
                                <label for="encryption_method">Select Encryption Method:</label>
                                <select name="encryption_method" id="encryption_method" class="form-control">
                                    <option value="aes">AES</option>
                                    <option value="rc4">RC4</option>
                                    <option value="des">DES</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload Video</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
