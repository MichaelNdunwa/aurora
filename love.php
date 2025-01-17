<?php
include("includes/includedFiles.php");

// Function to get trending song
function getTrendingSong($con) {
    $query = "SELECT id FROM songs ORDER BY plays DESC LIMIT 1";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return new Song($con, $row['id']);
    }
    return null;
}

// Function to get random songs
function getRandomSongs($con, $limit = 3) {
    $query = "SELECT id FROM songs ORDER BY RAND() LIMIT ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $songs = [];
    while ($row = $result->fetch_assoc()) {
        $songs[] = new Song($con, $row['id']);
    }
    return $songs;
}

// Get trending song
$trendingSong = getTrendingSong($con);

// Display trending song section
if ($trendingSong): ?>
    <div class='trending'>
        <div class='left'>
            <h5>Trending New Song</h5>
            <div class='info'>
                <h2><?php echo htmlspecialchars($trendingSong->getTitle()); ?></h2>
                <h4><?php echo htmlspecialchars($trendingSong->getArtist()->getName()); ?></h4>
                <h5><?php echo $trendingSong->getNumberOfPlays(); ?> Plays</h5>
                <div class='buttons' onclick='setTrack(<?php echo $trendingSong->getId(); ?>, tempPlaylist, true)'>
                    <button>Listen Now</button>
                    <i class='bx bxs-download'></i>
                </div>
            </div>
        </div>
        <img src='<?php echo htmlspecialchars($trendingSong->getAlbum()->getArtworkPath()); ?>'>
    </div>
<?php endif; ?>

<!-- Playlist Section -->
<div class="playlist">
    <div class="music-list">
        <div class="header">
            <h5>Top Songs</h5>
            <a href="#">See all</a>
        </div>
        <?php
        // Get and display random songs
        $songs = getRandomSongs($con);
        $songIds = [];
        
        foreach ($songs as $index => $song): 
            $songIds[] = $song->getId();
        ?>
            <div class='items'>
                <div class='item'>
                    <div class='info'>
                        <p><?php echo $index + 1; ?></p>
                        <img src='<?php echo htmlspecialchars($song->getAlbum()->getArtworkPath()); ?>'>
                        <div class='details'>
                            <h5><?php echo htmlspecialchars($song->getTitle()); ?></h5>
                            <p><?php echo htmlspecialchars($song->getArtist()->getName()); ?></p>
                        </div>
                    </div>
                    <div class='actions'>
                        <p><?php echo $song->getDuration(); ?></p>
                        <div class='icon' onclick='setTrack(<?php echo $song->getId(); ?>, tempPlaylist, true)'>
                            <i class='bx bxs-right-arrow'></i>
                        </div>
                        <i class='bx bxs-download'></i>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <script>
            const tempPlaylist = <?php echo json_encode($songIds); ?>;
        </script>
    </div>
</div>


From album_songlist.php:

            echo "
                    <div class='items'>
                        <div class='item'>
                            <div class='info'>
                                <p>{$count}</p>
                                <img src='{$albumArt}'>
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
                                <i class='bx bxs-download'></i>
                            </div>
                        </div>
                    </div>
                ";