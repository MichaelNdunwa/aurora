    <aside class="sidebar">
            <div class="logo">
                <button class="menu-btn" id="menu-close">
                    <i class='bx bx-log-out-circle'></i>
                </button>
                <i class='bx bxl-deezer' onclick="openPage('index.php')"></i>
                <a onclick="openPage('index.php')">Aurora</a>
            </div>

            <div class="menu">
                <ul>
                    <li onclick="openPage('music.php')" >
                        <i class='bx bxs-volume-full'></i>
                        <!-- <a href="#">Home</a> -->
                        <a>Home</a>
                    </li>
                    <li onclick="openPage('album.php')">
                        <i class='bx bxs-album'></i>
                        <!-- <a href="#">Albums</a> -->
                        <a>Albums</a>
                    </li>
                    <li onclick="openPage('artist.php')">
                        <i class='bx bxs-microphone'></i>
                        <!-- <a href="#">Artists</a> -->
                        <a>Artists</a>
                    </li>
                    <li onclick="openPage('video.php')">
                        <i class='bx bxs-video'></i>
                        <!-- <a href="#">Videos</a> -->
                        <a>Videos</a>
                    </li>
                    <li onclick="openPage('contact.php')">
                        <i class='bx bxs-message'></i>
                        <!-- <a href="#">Contact</a> -->
                        <a>Contact</a>
                    </li>
                </ul>
            </div>

            <?php include("profile.php"); ?>
            


        </aside>
