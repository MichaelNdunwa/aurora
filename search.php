<?php
include("includes/includedFiles.php");

if(isset($_GET['term'])) {
	$term = urldecode($_GET['term']);
}
else {
	$term = "";
}

$searchNotEmpty = false;
?>


<script>
$(function() {
    var cursorPosition = 0;
    $(".searchInput").focus();
    $(".searchInput").on("input", function() {
        cursorPosition = this.selectionStart;
    });
    $(".searchInput").keyup(function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            var val = $(".searchInput").val();
            openPage("search.php?term=" + val);
            // Store cursor position in local storage
            localStorage.setItem("cursorPosition", cursorPosition);
        }, 1000);
    });
    
    // Restore cursor position on page load
    if (localStorage.getItem("cursorPosition") !== null) {
        var input = $(".searchInput")[0];
        cursorPosition = parseInt(localStorage.getItem("cursorPosition"));
        input.setSelectionRange(cursorPosition, cursorPosition);
    }
})
</script>






<?php if($term == "") exit(); ?>
<div class="tracklistContainer borderbottom">
    <!-- <h2>Songs</h2> -->
    <ul class="tracklist">
        <?php
        $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");
        if(mysqli_num_rows($songsQuery) != 0) {
            $searchNotEmpty = true;
            // echo "<span class='noResults'>No songs found matching " . $term . "</span>";
            echo "<h2>Songs</h2>";
        }
        $songIdArray = array();
        $i = 1;
        while($row = mysqli_fetch_array($songsQuery)) {
            if($i > 15) {
                break;
            }
            array_push($songIdArray, $row['id']);
            $albumSong = new Song($con, $row['id']);
            $albumArtist = $albumSong->getArtist();
            // I added song image
            $albumImage = $albumSong->getAlbum()->getArtworkPath();

            echo "
                <div class='items'>
                    <div class='item'>
                        <div class='info'>
                            <p>{$i}</p>
                            <img src='{$albumImage}' role='link' tabindex='0' class='artist-name' onclick='openPage(`album_songlist.php?id={$albumSong->getAlbumId()}`)'>
                            <div class='details'>
                                <h5 role='link' tabindex='0' class='artist-name' onclick='openPage(`album_songlist.php?id={$albumSong->getAlbumId()}`)'>{$albumSong->getTitle()}</h5>
                                <p role='link' tabindex='0' class='artist-name' onclick='openPage(`artist_discography.php?id={$albumArtist->getId()}`)'>{$albumArtist->getName()}</p>
                            </div>
                        </div>
                        <div class='actions'>
                            <p>{$albumSong->getDuration()}</p>
                            <div class='icon' onclick='setTrack({$albumSong->getId()}, tempPlaylist, true)'>
                                <i class='bx bxs-right-arrow'></i>
                            </div>
                            <i class='bx bxs-download'></i>
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

<div class="artistsContainer borderBottom">
        <!-- <h2>Artists</h2> -->
        <?php
        $artistQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");
        if(mysqli_num_rows($artistQuery) != 0) {
            $searchNotEmpty = true;
            // echo "<span class='noResults'>No artist found matching " . $term . "</span>";
            echo "<h2>Artists</h2>";
        }
        while($row = mysqli_fetch_array($artistQuery)) {
            $artistFound = new Artist($con, $row['id']);
            echo "<div class='searchResultRow' role='link' tabindex='0' onclick='openPage(\"artist_discography.php?id=". $artistFound->getId() ."\")'>
                    <div class='artistImage'>
                        <img src=\"" . $artistFound->getImage() . "\"> 
                    </div>        
                    <div class='artistName'>
                        <span>" . $artistFound->getName() .  "</span>
                    </div>
                </div>";
        }
        ?>
</div>

<div class="gridViewContainer">
    <!-- <h2>Albums</h2> -->
    <?php
    $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");
    if(mysqli_num_rows($albumQuery) != 0) {
        $searchNotEmpty = true;
        // echo "<span class='noResults'>No albums found matching " . $term . "</span>";
        echo "<h2>Albums</h2>";
    }
    while ($row = mysqli_fetch_array($albumQuery)) {
        echo "
                <div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"album_songlist.php?id=" . $row['id'] . "\")'>
                        <span>
                        <img src='" . $row['artworkPath'] . "'>
                    <div class='gridViewInfo'>" . $row['title'] . "</div>
                    </span>
                </div>
            ";
    }
    ?>
</div>

<?php if(!$searchNotEmpty) echo "<span class='noResults'>No results found matching " . $term . "</span>"; ?>