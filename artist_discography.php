<?php
include("includes/includedFiles.php");

if (isset($_GET['id'])) {
    $artistId = $_GET['id'];
} else {
    header("Location: index.php");
}

$artist = new Artist($con, $artistId);
?>

<div class="entityInfo borderbottom">
    <div class="centerSection">
        <div class="artistInfo">
            <!-- <img src="assets/images/albumArtwork/Love-Damini.png" class="artistImage"> -->
            <img src="<?php echo $artist->getImage(); ?>" class="artistImage">
            <div class="artistDetails">
                <h1 class="artistName"><?php echo $artist->getName(); ?></h1>
                <div class="headerButtons">
                    <button class="button blue" onclick="playFirstSong()">PLAY</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tracklistContainer borderbottom">
    <!-- <h2>Songs</h2> -->
    <ul class="tracklist">
        <?php
            $songIdArray = $artist->getSongIds();
            if (!empty($songIdArray)) {
                echo "<h2>Songs</h2>";
            }
            $i = 1;
            foreach ($songIdArray as $songId) {
                if ($i > 5) {
                    break;
                }
                $albumSong = new Song($con, $songId);
                $albumArtist = $albumSong->getArtist();
                $albumImage = $albumSong->getAlbum()->getArtworkPath();

                echo "
                <div class='items'>
                    <div class='item'>
                        <div class='info'>
                            <p>{$i}</p>
                            <img src='{$albumImage}'>
                            <div class='details'>
                                <h5>{$albumSong->getTitle()}</h5>
                                <p>{$albumArtist->getName()}</p>
                            </div>
                        </div>
                        <div class='actions'>
                            <p>{$albumSong->getDuration()}</p>
                            <div class='icon' onclick='setTrack({$albumSong->getId()}, tempPlaylist, true)'>
                                <i class='bx bxs-right-arrow'></i>
                            </div>
                            <a href='{$albumSong->getPath()}' download='{$albumSong->getTitle()}.mp3'>
                                <i class='bx bxs-download'></i>
                            </a>
                        </div>
                    </div>
                </div>
            ";
                $i++;
            
        }
        ?>
        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
            console.log(tempPlaylist);

        </script>
    </ul>
</div>

<div class="gridViewContainer">
    <!-- <h2>Albums</h2> -->
    <?php
    $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");

    if (mysqli_num_rows($albumQuery) != 0) {
        echo "<h2>Albums</h2>";
    }

    while ($row = mysqli_fetch_array($albumQuery)) {
        echo "
                <div class='gridViewItem'>
                        <span role='link' tabindex='0' onclick='openPage(\"album_songlist.php?id=" . $row['id'] . "\")'>
                        <img src='" . $row['artworkPath'] . "'>
                    <div class='gridViewInfo'>" . $row['title'] . "</div>
                    </span>
                </div>
            ";
    }
    ?>
</div>