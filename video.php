<?php
include("includes/includedFiles.php");

$apiKey = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
$channelId = 'UCdE3k0QhQmDmAHZX70amtSA';

// Updated API URL with videoCategoryId=10 (Music category) and additional parameters
$api_url = "https://www.googleapis.com/youtube/v3/search?key=$apiKey" .
    "&channelId=$channelId" .
    "&part=snippet,id" .
    "&order=date" .
    "&maxResults=50" .
    "&type=video" .
    "&videoCategoryId=10";

// Add error handling for the first API call
$response = @file_get_contents($api_url, false, $context);
if ($response === false) {
    die("Error: Unable to connect to YouTube API. Please check your internet connection and API key.");
}

$youtube_videos = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error: Invalid response from YouTube API. " . json_last_error_msg());
}

if (!empty($youtube_videos['items'])) {
    // Get detailed video information to check duration
    $videoIds = array_map(function ($item) {
        return $item['id']['videoId'];
    }, $youtube_videos['items']);

    $videos_url = "https://www.googleapis.com/youtube/v3/videos?key=$apiKey" .
        "&id=" . implode(',', $videoIds) .
        "&part=contentDetails,statistics";

    // Add error handling for the second API call
    $response = @file_get_contents($videos_url, false, $context);
    if ($response === false) {
        die("Error: Failed to fetch video details from YouTube API.");
    }

    $videos_data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Error: Invalid video details response. " . json_last_error_msg());
    }
    $video_details = [];

    // Create lookup table for video details
    foreach ($videos_data['items'] as $video) {
        $video_details[$video['id']] = $video;
    }

    ?>
    <!-- Add CSS for the video cards -->
    <style>
        .video-container {
            padding: 20px;
        }

        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .video-card {
            
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
            border: 1px solid #787575;
        }

        .video-card:hover {
            transform: translateY(-5px);
        }

        .thumbnail-container {
            position: relative;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio */
        }

        .thumbnail-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-bottom: 3px solid #787575;
        }

        .video-content {
            padding: 15px;
        }

        .video-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .video-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
        }

        .video-modal.active {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            width: 80%;
            max-width: 900px;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }

        .thumbnail-container {
            position: relative;
        }

        .duration {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 2px 4px;
            border-radius: 2px;
            font-size: 12px;
        }
    </style>

    <div class="video-container">
        <div class="video-grid">
            <?php
            foreach ($youtube_videos['items'] as $ytvideo) {
                if ($ytvideo['id']['kind'] == 'youtube#video') {
                    $videoId = $ytvideo['id']['videoId'];

                    // Get video duration
                    $duration = isset($video_details[$videoId])
                        ? $video_details[$videoId]['contentDetails']['duration'] : '';

                    // Convert duration from ISO 8601 format
                    $interval = new DateInterval($duration);
                    $duration_seconds = ($interval->h * 3600) + ($interval->i * 60) + $interval->s;

                    // Skip if video is less than 1 minute (typical for Shorts)
                    if ($duration_seconds < 60) {
                        continue;
                    }

                    // Check if title contains indicators of Shorts
                    $title = strtolower($ytvideo['snippet']['title']);
                    if (
                        strpos($title, '#shorts') !== false ||
                        strpos($title, '#short') !== false ||
                        strpos($title, '#youtubeshorts') !== false
                    ) {
                        continue;
                    }

                    // Format duration for display
                    $duration_formatted = '';
                    if ($interval->h > 0) {
                        $duration_formatted .= $interval->h . ':';
                        $duration_formatted .= str_pad($interval->i, 2, '0', STR_PAD_LEFT) . ':';
                    } else {
                        $duration_formatted .= $interval->i . ':';
                    }
                    $duration_formatted .= str_pad($interval->s, 2, '0', STR_PAD_LEFT);
                    ?>
                    <div class="video-card" data-video-id="<?php echo $videoId; ?>">
                        <div class="thumbnail-container">
                            <img src="<?php echo $ytvideo['snippet']['thumbnails']['high']['url'] ?>"
                                alt="<?php echo htmlspecialchars($ytvideo['snippet']['title']) ?>">
                            <div class="duration"><?php echo $duration_formatted; ?></div>
                        </div>
                        <div class="video-content">
                            <h2 class="video-title"><?php echo htmlspecialchars($ytvideo['snippet']['title']) ?></h2>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Add jQuery before the closing </head> tag -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->

    <!-- Video Modal -->
    <div class="video-modal">
        <span class="close-modal">&times;</span>
        <div class="modal-content">
            <iframe width="100%" height="500" frameborder="0" allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
            </iframe>
        </div>
    </div>

    <!-- Replace the vanilla JS with jQuery -->
    <script>
        $(document).ready(function () {
            // Video card click handler
            $('.video-card').on('click', function () {
                var videoId = $(this).data('video-id');
                var iframe = $('.video-modal iframe');

                // Set the video source
                iframe.attr('src', 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&enablejsapi=1');

                // Show the modal
                $('.video-modal').addClass('active');
            });

            // Close modal when clicking the X
            $('.close-modal').on('click', function () {
                closeVideoModal();
            });

            // Close modal when clicking outside
            $('.video-modal').on('click', function (e) {
                if (e.target === this) {
                    closeVideoModal();
                }
            });

            // Close modal with ESC key
            $(document).on('keyup', function (e) {
                if (e.key === "Escape") {
                    closeVideoModal();
                }
            });

            // Function to close modal and stop video
            function closeVideoModal() {
                $('.video-modal iframe').attr('src', '');
                $('.video-modal').removeClass('active');
            }
        });
    </script>
    <?php
} else {
    echo "No videos found.";
}
?>