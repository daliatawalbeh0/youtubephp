<?php
// YouTube API settings
$api_key = 'AIzaSyA39UQG9KZjyfUEsyPHW_RjL7LeDiU_VY8'; // Replace with your YouTube API key

// Function to perform API request
function searchYouTube($query, $max_results = 10) {
    global $api_key;
    $url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&q=' . urlencode($query) . '&maxResults=' . $max_results . '&key=' . $api_key;

    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Handle form submission
if (isset($_GET['search_query'])) {
    $query = $_GET['search_query'];
    $results = searchYouTube($query);

    // Display search results
    if ($results) {
        $total_results = $results['pageInfo']['totalResults'];
        $items = $results['items'];

        echo '<h2>Total Results: ' . $total_results . '</h2>';
        echo '<div class="card-container">';
        foreach ($items as $item) {
            $video_id = $item['id']['videoId'];
            $title = $item['snippet']['title'];
            $thumbnail = $item['snippet']['thumbnails']['medium']['url'];

            echo '<div class="card">';
            echo '<a href="https://www.youtube.com/watch?v=' . $video_id . '" target="_blank">';
            echo '<img src="' . $thumbnail . '" alt="' . $title . '">';
            echo '<p>' . $title . '</p>';
            echo '</a>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No results found.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Search</title>
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }
        .card img {
            width: 100%;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>YouTube Search</h1>
    <form action="" method="get">
        <input type="text" name="search_query" placeholder="Enter search keywords">
        <button type="submit">Search</button>
    </form>
</body>
</html>
