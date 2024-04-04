
var players = document.querySelectorAll('.video-js');
players.forEach(function (player) {
    videojs(player);
});

// Add event listeners to the Share and Generate Link buttons
var shareBtns = document.querySelectorAll('.share-btn');
var generateBtns = document.querySelectorAll('.generate-link');

shareBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
        var videoLink = btn.dataset.video;
        shareVideo(videoLink);
    });
});

generateBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
        var videoLink = btn.dataset.video;
        generateLink(videoLink);
    });
});

// Share video link using Web Share API
function shareVideo(videoLink) {
    if (navigator.share) {
        navigator.share({
            title: 'Check out this video!',
            url: videoLink
        }).then(() => {
            console.log('Shared successfully');
        }).catch((error) => {
            console.error('Error sharing:', error);
        });
    } else {
        alert('Web Share API is not supported in this browser.');
    }
}

// Generate video link in the specified format
function generateLink(videoLink) {
    var generatedLink = 'http://localhost/SyncPlayer/uploaded_vid.php/' + basename(videoLink);
    alert('Generated link: ' + generatedLink);
}

// Helper function to get the file name from a URL
function basename(path) {
    return path.split('/').reverse()[0];
}
