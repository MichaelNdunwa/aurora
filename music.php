<?php
include("includes/includedFiles.php");
?>

<?php
$mustPlayedSongQuerry = mysqli_query($con, "SELECT id FROM songs ORDER BY plays DESC LIMIT 5");
$mustPlayedSongArray = array();
while ($row = mysqli_fetch_array($mustPlayedSongQuerry)) {
    array_push($mustPlayedSongArray, $row['id']);
}
foreach ($mustPlayedSongArray as $mustPlayedSongId) {
    $mustPlayedSong = new Song($con, $mustPlayedSongId);
    $mustPlayedSongArtist = $mustPlayedSong->getArtist();
    $mustPlayedSongImage = $mustPlayedSong->getAlbum()->getArtworkPath();
    echo "
            <div class='trending'>
                <div class='left'>
                    <h5>Trending New Song</h5>
                    <div class='info'>
                        <h2 role='link' tabindex='0' class='artist-name' onclick='openPage(`album_songlist.php?id={$mustPlayedSong->getAlbumId()}`)'>{$mustPlayedSong->getTitle()}</h2>
                        <h4 role='link' tabindex='0' class='artist-name' onclick='openPage(`artist_discography.php?id={$mustPlayedSongArtist->getId()}`)'>{$mustPlayedSongArtist->getName()}</h4>
                        <h5>{$mustPlayedSong->getNumberOfPlays()} Plays</h5>
                        <div class='buttons'>
                            <button onclick='setTrack({$mustPlayedSong->getId()}, tempPlaylist, true)'>Listen Now</button>
                            <a href='{$mustPlayedSong->getPath()}' download='{$mustPlayedSong->getTitle()}.mp3'>
                                <i class='bx bxs-download'></i>
                            </a>
                        </div>
                    </div>   
             
                </div>
                <img src='{$mustPlayedSongImage}' role='link' tabindex='0' class='artist-name' onclick='openPage(`album_songlist.php?id={$mustPlayedSong->getAlbumId()}`)'>
            </div>
        ";
    break;
}
?>

<div class="playlist">
    <div class="music-list">
        <div class="header">
            <h5>Top Songs</h5>
            <a href="#">See all</a>
        </div>
        <?php
        $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 5");
        $songArray = array();
        while ($row = mysqli_fetch_array($songQuery)) {
            array_push($songArray, $row['id']);
        }
        $count = 1;
        foreach ($songArray as $songId) {
            $song = new Song($con, $songId);
            $songArtist = $song->getArtist();
            $songImage = $song->getAlbum()->getArtworkPath();
            echo "
                    <div class='items'>
                    <div class='item'>
                        <div class='info'>
                            <p>{$count}</p>
                            <img src='{$songImage}' role='link' tabindex='0' class='artist-name' onclick='openPage(`album_songlist.php?id={$song->getAlbumId()}`)'>
                            <div class='details'>
                                <h5 role='link' tabindex='0' class='artist-name' onclick='openPage(`album_songlist.php?id={$song->getAlbumId()}`)'>{$song->getTitle()}</h5>
                                <p role='link' tabindex='0' class='artist-name' onclick='openPage(`artist_discography.php?id={$songArtist->getId()}`)'>{$songArtist->getName()}</p>
                            </div>
                        </div>
                        <div class='actions'>
                            <p>{$song->getDuration()}</p>
                            <div class='icon' onclick='setTrack({$song->getId()}, tempPlaylist, true)'>
                                <i class='bx bxs-right-arrow'></i>
                            </div>
                            <a href='{$song->getPath()}' download='{$song->getTitle()}.mp3'>
                                <i class='bx bxs-download'></i>
                            </a>
                        </div>
                    </div>
                </div>
                ";
            $count++;
        }
        ?>
        <script>
            var tempSongIds = '<?php echo json_encode($songArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
            // console.log(tempPlaylist);
        </script>
    </div>

</div>
