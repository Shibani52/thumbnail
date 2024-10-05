<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File List and Thumbnails</title>
    <style>
         body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(to right, #f7cac9, #92a8d1);
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Center content horizontally */
            min-height: 100vh; /* Ensure full viewport height */
        }
        h1, h2 {
    color: #000; /* Black headings */
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center; /* Center align headings */
    text-transform: uppercase; /* Convert text to uppercase */
    letter-spacing: 1px; /* Add letter spacing */
    font-size: 2.5rem; /* Adjust font size */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle text shadow */
    transition: color 0.3s, font-size 0.3s; /* Smooth transitions for color and font-size */
}

h1:hover, h2:hover {
    color: #ff6f61; /* Change color on hover */
    font-size: 2.8rem; /* Increase font size on hover */
}
form {
    background-color: #d4e3fc; /* Soft blue background */
    padding: 40px; /* Increased padding for more space inside the form */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    width: 100%;
    max-width: 800px; /* Increased max-width for a larger form */
    display: grid;
    gap: 20px;
    justify-items: center; /* Center align items horizontally */
}


        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #4facfe; /* Border color */
            border-radius: 4px;
            font-size: 16px;
            background-color: #fff;
            background: linear-gradient(to right, #e0c3fc, #8ec5fc); /* Gradient background */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s, background-color 0.3s;
        }
        select:hover,
        select:focus {
            border-color: #4facfe; /* Border color on hover/focus */
            background: linear-gradient(to right, #fbd3e9, #bb377d); /* Gradient background on hover/focus */
        }
        .file-upload {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: #fff;
       }       
        .file-upload-label {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .file-upload-label:hover {
            background: linear-gradient(to right, #43e97b, #38f9d7);
        }
        .btn-green {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-green:hover {
            background-color: #218838;
        }
        button:hover {
    background-color: #e6407e; /* Darker pink on hover */
}
        .thumbnail-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 20px;
    list-style: none;
    padding: 20px;
    background-color: #f0f2f5; /* Light background color */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 1200px;
    margin: 0 auto; /* Center the grid */
}

.thumbnail-list li {
    background-color: #fff; /* White background for each thumbnail */
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.thumbnail-list li:hover {
    transform: translateY(-5px); /* Lift thumbnail on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
}

.thumbnail-list img {
    width: 100%;
    height: auto;
    object-fit: cover;
    transition: transform 0.3s;
}

.thumbnail-list img:hover {
    transform: scale(1.1); /* Enlarge image on hover */
}

        
        .thumbnail-list img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.thumbnail-list img:hover {
    transform: scale(2.1); /* Enlarge image on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
}
        .error-message {
            color: #dc3545;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            max-width: 800px; /* Adjust maximum width as needed */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>File List and Thumbnails</h1>

        @if (session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif

        <form action="{{ route('process.files') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="selected_files">Select Existing Files:</label>
                <select name="selected_files[]" id="selected_files" multiple>
                    @foreach ($fileNames as $file)
                        <option value="{{ $file }}">{{ $file }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <input type="file" name="file[]" id="file" multiple style="display: none;">
                <label class="file-upload-label" for="file">Choose Files</label>
            </div>

            <div class="file-names" id="file-names">
                <!-- Selected file names will be shown here -->
            </div>

            <div>
                <button type="submit" class="btn-green">Generate Thumbnails</button>
            </div>
        </form>

        @if (isset($processedFiles) && count($processedFiles) > 0)
            <h2>Generated Thumbnails</h2>
            <ul class="thumbnail-list">
                @foreach ($processedFiles as $file)
                    <li>
                        <a href="{{ asset('images/' . $file) }}" target="_blank">
                            <img src="{{ asset('thumbnails/' . $file) }}" alt="Thumbnail">

                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No thumbnails found.</p>
        @endif
    </div>

    <script>
        
        const fileInput = document.getElementById('file');
        const fileNamesDiv = document.getElementById('file-names');

        fileInput.addEventListener('change', function() {
            const files = Array.from(fileInput.files);
            if (files.length > 0) {
                const fileNames = files.map(file => file.name).join('<br>');
                fileNamesDiv.innerHTML = `<strong>Selected Files:</strong><br>${fileNames}`;
            } else {
                fileNamesDiv.innerHTML = '';
            }
        });
    </script>
</body>
</html>








<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File List and Thumbnails</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(to right, #f7cac9, #92a8d1);
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Center content horizontally */
            min-height: 100vh; /* Ensure full viewport height */
        }
        h1, h2 {
    color: #000; /* Black headings */
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center; /* Center align headings */
    text-transform: uppercase; /* Convert text to uppercase */
    letter-spacing: 1px; /* Add letter spacing */
    font-size: 2.5rem; /* Adjust font size */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle text shadow */
    transition: color 0.3s, font-size 0.3s; /* Smooth transitions for color and font-size */
}

h1:hover, h2:hover {
    color: #ff6f61; /* Change color on hover */
    font-size: 2.8rem; /* Increase font size on hover */
}
form {
    background-color: #d4e3fc; /* Soft blue background */
    padding: 40px; /* Increased padding for more space inside the form */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    width: 100%;
    max-width: 800px; /* Increased max-width for a larger form */
    display: grid;
    gap: 20px;
    justify-items: center; /* Center align items horizontally */
}


        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #4facfe; /* Border color */
            border-radius: 4px;
            font-size: 16px;
            background-color: #fff;
            background: linear-gradient(to right, #e0c3fc, #8ec5fc); /* Gradient background */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s, background-color 0.3s;
        }
        select:hover,
        select:focus {
            border-color: #4facfe; /* Border color on hover/focus */
            background: linear-gradient(to right, #fbd3e9, #bb377d); /* Gradient background on hover/focus */
        }
        .file-upload {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: #fff;
       }       
        .file-upload-label {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .file-upload-label:hover {
            background: linear-gradient(to right, #43e97b, #38f9d7);
        }
        .btn-green {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-green:hover {
            background-color: #218838;
        }
        button:hover {
    background-color: #e6407e; /* Darker pink on hover */
}
        .thumbnail-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 20px;
    list-style: none;
    padding: 20px;
    background-color: #f0f2f5; /* Light background color */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 1200px;
    margin: 0 auto; /* Center the grid */
}

.thumbnail-list li {
    background-color: #fff; /* White background for each thumbnail */
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.thumbnail-list li:hover {
    transform: translateY(-5px); /* Lift thumbnail on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
}

.thumbnail-list img {
    width: 100%;
    height: auto;
    object-fit: cover;
    transition: transform 0.3s;
}

.thumbnail-list img:hover {
    transform: scale(1.1); /* Enlarge image on hover */
}

        
        .thumbnail-list img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.thumbnail-list img:hover {
    transform: scale(2.1); /* Enlarge image on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
}
        .error-message {
            color: #dc3545;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            max-width: 800px; /* Adjust maximum width as needed */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>File List and Thumbnails</h1>

        @if (session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif

        <form action="{{ route('process.files') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="selected_files">Select Existing Files:</label>
                <select name="selected_files[]" id="selected_files" multiple>
                    @foreach ($fileNames as $file)
                        <option value="{{ $file }}">{{ $file }}</option>
                    @endforeach
                </select>
            </div>
            <div>
            <input type="file" name="file[]" id="file" multiple style="display: none;">
            </div>
            <div>
                <label class="file-upload-label" for="file">Choose Files</label>
            </div>
            <div>
                <button type="submit" class="btn-green">Generate Thumbnails</button>
            </div>
        </form>

        @if (isset($processedFiles) && count($processedFiles) > 0)
            <h2>Generated Thumbnails</h2>
            <ul class="thumbnail-list">
                @foreach ($processedFiles as $file)
                    <li>
                        <a href="{{ asset('images/' . $file) }}" target="_blank">
                            <img src="{{ asset('thumbnails/' . $file) }}" alt="Thumbnail">
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No thumbnails found.</p>
        @endif
    </div>
</body>
</html>-->
