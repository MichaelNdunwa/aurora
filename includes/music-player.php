<?php
$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
$resultArray = array();
while ($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}
$jsonArray = json_encode($resultArray);
?>

<script>
    $(document).ready(function () {
        var newPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        setTrack(newPlaylist[0], newPlaylist, false);
        // playback:
        $(".progress .progress-bar").mousedown(function () {
            mouseDown = true;
        });
        $(".progress .progress-bar").mousemove(function (e) {
            if (mouseDown) {
                // Set time of song, depending on position of mouse:
                timeFromOffset(e, this);
            }
        });
        $(".progress .progress-bar").mouseup(function (e) {
            timeFromOffset(e, this);
        });
        $(document).mouseup(function () {
            mouseDown = false;
        });

    });
    function timeFromOffset(mouse, progressBar) {
        var percentage = mouse.offsetX / $(progressBar).width() * 100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    function previousSong() {
        if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
            audioElement.setTime(0);
        } else {
            currentIndex = currentIndex - 1;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
        }
    }
    function nextSong() {
        if (repeat) {
            audioElement.setTime(0);
            playSong();
            return;
        }
        if (currentIndex == currentPlaylist.length - 1) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }
        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
    }


    function setRepeat() {
        repeat = !repeat;
        var imageName = repeat ? "repeat-active.png" : "repeat.png";
        $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
    }

    function setShuffle() {
        shuffle = !shuffle;
        var shuffleColor = shuffle ? "#fff" : "#919191"
        $("#shuffle-button").css("color", shuffleColor + " !important");
        if (shuffle) {
            //Randomize playlist:
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
        } else {
            // deactive and go back to regular playlist
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);

        }
    }

    function shuffleArray(a) {
        var j, x, i;
        for (i = a.length; i; i--) {
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        }
    }

    function setTrack(trackId, newPlaylist, play) {
        if (newPlaylist != currentPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }
        if (shuffle) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        } else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        pauseSong();
        $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function (data) {
            var track = JSON.parse(data);
            $(".song-info .description .track-name").text(track.title);
            // $(".song-info .description .track-name").text("My name is Micahel Ndunwa, I'm an Entry-Level Software Engineer.....");
            $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function (data) {
                var artist = JSON.parse(data);
                $(".song-info .description .artist-name").text(artist.name);
                $(".song-info .description .artist-name").attr("onClick", "openPage('artist_discography.php?id=" + artist.id + "')");
            });
            $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function (data) {
                var album = JSON.parse(data);
                $(".song-info img").attr("src", album.artworkPath);
                $(".song-info img").attr("onClick", "openPage('album_songlist.php?id=" + album.id + "')");
                $(".song-info .description .track-name").attr("onClick", "openPage('album_songlist.php?id=" + album.id + "')");
            });
            audioElement.setTrack(track);
            if (play) {
                playSong();
            }
        });
    }
    function playSong() {
        if (audioElement.audio.currentTime == 0) {
            $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
        } else {
            console.log("DON'T UPDATE TIMME");
        }
        $("#play-button").hide();
        $("#pause-button").show();
        audioElement.play();
    }
    function pauseSong() {
        $("#play-button").show();
        $("#pause-button").hide();
        audioElement.pause();
    }
</script>


<div class="music-player">
    <div class="top-section">
        <div class="header">
            <h5>Player</h5>
            <i class='bx bxs-playlist'></i>
        </div>
        <div class="song-info">
            <img role="link" tabindex="0" src="" alt="albumArtwork">
            <div class="description">
            <div class="description">
                <h3 role="link" tabindex="0" class="track-name"></h3>
                <h5 role="link" tabindex="0" class="artist-name"></h5>
            </div>
            </div>

            <div class="progress">
                <p class="current-time">-</p>
                <div class="progress-bar">
                    <div class="active-line"></div>
                    <div class="progress-node"></div>
                </div>
                <p class="total-time">-</p>
            </div>
        </div>
    </div>

    <div class="player-actions">
        <div class="buttons">
            <i class='bx bx-repeat repeat-button' title="Repeat button" onclick="setRepeat()"></i>
            <i class='bx bx-first-page previous-button' title="Previous button" onclick="previousSong()"></i>
            <i class='bx bx-play play-button' id="play-button" title="Play button" onclick="playSong()"></i>
            <i class='bx bx-pause pause-button' id="pause-button" title="Pause button" style="display: none;"
                onclick="pauseSong()"></i>
            <i class='bx bx-last-page next-button' title="Next button" onclick="nextSong()"></i>
            <i class='bx bx-transfer-alt shuffle-button' id="shuffle-button" title="Shuffle button"
                onclick="setShuffle()"></i>
        </div>

    </div>

</div>