<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/video.js/dist/video-js.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .success-message {
            justify-content: center;
            display: flex;
            align-items: center;
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        .success-message::before {
            content: '\2714';
            /* Unicode check mark symbol */
            font-size: 16px;
            margin-right: 10px;
            color: #581c87;
        }

        .success-message a {
            color: #2e6da4;
            text-decoration: none;
            font-weight: bold;
        }


        main {
            flex: 1;
        }

        /* Center form horizontally */
        .center-form {
            background: rgb(63, 94, 251);
            background: radial-gradient(circle, rgba(63, 94, 251, 1) 0%, rgba(252, 70, 107, 1) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            /* Adjust the height as needed */
        }

        /* Footer styles */
        footer {
            background: linear-gradient(to right, #ffafbd, #ffc3a0);
            color: #fff;
        }
    </style>

    <?php
    include("config.php");


    if (isset($_POST['but_upload'])) {
        $maxsize = 104857600; // 100MB (not 5MB as commented)

        $name = $_FILES['file']['name'];
        $target_dir = "videos/";
        $target_file = $target_dir . basename($_FILES['file']['name']); // Use basename() to prevent directory traversal attacks

        // Select file type
        $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Valid file extensions
        $extensions_arr = array("mp4", "avi", "mov", "mp4v");

        // Check extensions
        if (in_array($videoFileType, $extensions_arr)) {

            // Check file size
            if ($_FILES['file']['size'] >= $maxsize || $_FILES['file']['size'] == 0) {
                echo "File too large. File must be less than 100MB."; // Fixed typo and updated file size limit
            } else {

                // upload
                if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                    // Use correct variable names and destination
                    // Insert record
                    $query = "INSERT INTO videos(name, location) VALUES('" . $name . "', '" . $target_file . "')";
                    mysqli_query($con, $query);

                    // echo "File uploaded successfully.";
                    echo '<div class="success-message">File uploaded successfully.</div>';


                    // Function to generate a random string
                    function generateRandomString($length)
                    {
                        // Characters for the first part (alphabetic characters)
                        $characters1 = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        // Characters for the second part (alphanumeric characters)
                        $characters2 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                        $randomString = '';

                        // Generate the first part of the string
                        for ($i = 0; $i < 5; $i++) {
                            $randomString .= $characters1[rand(0, strlen($characters1) - 1)];
                        }

                        // Add a hyphen between the two parts
                        $randomString .= '-';

                        // Generate the second part of the string
                        for ($i = 0; $i < 8; $i++) {
                            $randomString .= $characters2[rand(0, strlen($characters2) - 1)];
                        }

                        return $randomString;
                    }

                    // Generate a random string with the specified format
                    $randomString = generateRandomString(13);

                    // Output the random value
                    // echo "Random Value: $randomValue";
                    $numVideos = 5; // Change this to the number of videos you want to open

                    for ($i = 0; $i < $numVideos; $i++) {
                        $videoId = uniqid(); // Generate a unique ID for each video
                        $videoUrl = 'uploaded_vid.php?rand=' . $randomString . '&id=' . $videoId; // Create a unique URL for each video


                        echo '<script type="text/javascript">';
                        echo 'console.log("Opening new tab for video ID: ' . $videoId . ' ");';
                        echo 'window.open("' . $videoUrl . '", "_blank");';  // Open the URL in a new tab
                        echo '</script>';
                    }

                    // Flush the output buffer to ensure the JavaScript code is sent to the client immediately
                    flush();
                } else {
                    echo "File upload failed.";
                }
            }
        } else {
            echo "Invalid file type. Only MP4 files are allowed.";
        }
    }
    ?>
</head>

<body class="bg-gray-100">

    <main class="container mx-auto py-8">
        <div class="center-form">
            <form action="" method="post" enctype="multipart/form-data" class="max-w-lg bg-white p-8 shadow-lg">
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700">Choose Video File:</label>
                    <input type="file" name="file" id="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="mt-4">
                    <button type="submit" name="but_upload" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Upload Video
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 text-white py-4">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; <?php echo date('Y'); ?> synchronous video. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/video.js/dist/video.min.js"></script>

</body>

</html>