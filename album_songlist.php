<?php include("includes/includedFiles.php");
if(isset($_GET['id'])) {
    $albumId = $_GET['id'];
} else {
    header("Location: index.php");
}
$album = new Album($con, $albumId);
$artist = $album->getArtist();
?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>">
    </div>
    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p>By <?php echo $artist->getName(); ?></p>
        <p><?php echo $album->getNumberOfSongs(); ?> <?php echo ($album->getNumberOfSongs() > 1) ? "songs" : "song"; ?></p>
    </div>
</div>

<div class="tracklistContainer">
    <div class="tracklist">
        <?php
        $songIdArray = $album->getSongIds();
        $count = 1;
        foreach($songIdArray as $songId) {
            $albumSong = new Song($con, $songId);
            $albumArtist = $albumSong->getArtist();
            $albumArt = $albumSong->getAlbum()->getArtworkPath();

            echo "
                    <div class='items'>
                        <div class='item'>
                            <div class='info'>
                                <p>{$count}</p>
                                <div class='details'>
                                    <h5>{$albumSong->getTitle()}</h5>
                                    <p role='link' tabindex='0' class='artist-name' onclick='openPage(`artist_discography.php?id={$albumArtist->getId()}`)'>{$albumArtist->getName()}</p>
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
            $count++;
        }
        ?>
        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
            console.log(tempPlaylist);
        </script>
    </div>
</div>