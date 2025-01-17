<?php
include("includes/includedFiles.php");
?>
<h1 class="pageHeadingBig">Artist Pick For You</h1>
<div class="artistContainer">
    <?php
    $albumQuery = mysqli_query($con, "SELECT * FROM artists ORDER BY RAND()");

    while ($row = mysqli_fetch_array($albumQuery)) {
        echo "
                <div class='artistCard'>
                    <span role='link' tabindex='0' class='artistLink' onclick='openPage(\"artist_discography.php?id=" . $row['id'] . "\")'>
                        <div class='imageContainer'>
                            <img src='" . $row['artistsImagePath'] . "' alt='" . $row['name'] . "'>
                        </div>
                        <div class='artistDetails'>
                            <span class='artistName'>" . $row['name'] . "</span>
                        </div>
                    </span>
                </div>
            ";
    }
    ?>
</div>