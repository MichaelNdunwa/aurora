<script>
var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;
const videoCards = document.querySelectorAll('.card');



const menuOpen = document.getElementById('menu-open');
const menuClose = document.getElementById('menu-close');
const sidebar = document.querySelector('.main-content .sidebar'); // TODO: the menu button is not working.

menuOpen.addEventListener('click', () => sidebar.style.left = '0');
menuClose.addEventListener('click', () => sidebar.style.left = '-100%');

function openPage(url) {
    if(timer != null) {
        clearTimeout(timer);
    }
    if(url.indexOf("?") == -1) {
        url = url + "?";
    }
    var encodedUrl = encodeURI(url + "&userLoggedIn" + userLoggedIn);
    // $(".main-content").load(encodedUrl);
    $(".container").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}

// EventListener for history.pushState:
window.addEventListener("popstate", function(event) {
    var url = location.href;
    var encodedUrl = encodeURI(url + "&userLoggedIn" + userLoggedIn);
    // $(".main-content").load(encodedUrl);
    $(".container").load(encodedUrl);
    $("body").scrollTop(0);
});

// click action for video card:
videoCards.forEach(card => {
    card.addEventListener('click', () => {
        const videoId = card.querySelector('img').alt;
        window.open(`https://www.youtube.com/watch?v=${videoId}`, '_blank');
    });
});
// Remove loader after page load
document.addEventListener('DOMContentLoaded', () => {
    const loaders = document.querySelectorAll('.loader');
    loaders.forEach(loader => loader.style.display = 'none');
});

function formatTime(seconds) {
  const minutes = Math.floor(seconds / 60);
  const remainingSeconds = Math.floor(seconds % 60);
  return `${minutes}:${remainingSeconds.toString().padStart(2, "0")}`;
}
function updateTimeProgessBar(audio) {
    $(".progress .current-time").text(formatTime(audio.currentTime));
    // $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime)); // this is to display remaining time, I don't want that.
    var progress = audio.currentTime / audio.duration * 100;
    $(".progress .progress-bar .active-line").css("width", progress + "%");
    $(".progress .progress-bar .progress-node").css("left", progress + "%");
}
function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
    $(".volumeBar .progressNode").css("left", volume + "%");
}
function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function() {
        nextSong();
    });
    this.audio.addEventListener("canplay", function() {
        var duration = formatTime(this.duration);
        $(".progress .total-time").text(duration);
        
    });
    this.audio.addEventListener("timeupdate", function() {
        if(this.duration) {
            updateTimeProgessBar(this);
        }
    });
    this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
	});
    this.setTrack = function(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }
    this.play = function() {
        this.audio.play();
    }
    this.pause = function() {
        this.audio.pause();
    }
    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }
}

// download music function:
function downloadMusic(trackPath, trackName) {
    // Create a temporary anchor element
    const downloadLink = document.createElement('a');
    downloadLink.href = trackPath;
    downloadLink.download = trackName || 'music-download'; // Use provided name or default

    // Append to document, click, and remove
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}


</script>