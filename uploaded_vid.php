<?php
include("config.php");

// Function to fetch all video locations from the database.....
// function getAllVideoLinks($con) {
//     $videoLinks = [];
//     $fetchVideos = mysqli_query($con, "SELECT location FROM videos ORDER BY id DESC");
//     while ($row = mysqli_fetch_assoc($fetchVideos)) {
//         $videoLinks[] = $row['location'];
//     }
//     return $videoLinks;
// }
$getAllVideoLinks = fn ($con) =>
array_map(fn ($row) => $row['location'], mysqli_fetch_all(mysqli_query($con, "SELECT location FROM videos ORDER BY id DESC"), MYSQLI_ASSOC));


// Function to generate a random video link from an array of video links
function generateRandomVideoLink($videoLinks)
{
    $randomIndex = array_rand($videoLinks);
    return 'http://localhost/SyncPlayer/uploaded_vid.php/' . basename($videoLinks[$randomIndex]);
}
?>
<!-- movie.pterodactyltools.com -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/video.js/dist/video-js.min.css" rel="stylesheet">
    <style>


    </style>
</head>

<body>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mx-8 my-8" id="videoID">
        <?php
        $videoLinks = $getAllVideoLinks($con);
        foreach ($videoLinks as $key => $videoLink) {
        ?>
            <div class="relative">
                <video id="video_<?php echo $key; ?>" class="video-js w-full" controls preload="auto" width="200px" height="300px" data-setup="{ff}">
                    <source src="<?php echo $videoLink; ?>" type="video/mp4">
                </video>
                <div class="flex justify-between items-center bg-gray-900 bg-opacity-75 p-2">
                    <p class="text-white">Video <?php echo $key + 1; ?></p>
                    <div class="space-x-2 generate">
                        <button class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 share-btn" data-video="<?php echo $videoLink; ?>">Share</button>
                        <button class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 generate-link" data-video="<?php echo $videoLink; ?>">Generate</button>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>




    <!-- footer scetion -->

    <footer class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 text-white py-4 mt-8">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; <?php echo date('Y'); ?> synchronous video. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/video.js/dist/video.min.js"></script>
    <script src="./assets/Js/apps.js"></script>

</body>

</html>