<?php
// test/debug_scrape_content.php
$url = "https://www.metacritic.com/game/playstation-4/god-of-war";
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n" .
                    "Accept-Language: en-US,en;q=0.9\r\n",
        'ignore_errors' => true
    ],
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ],
]);

$html = file_get_contents($url, false, $context);
file_put_contents('metacritic_dump.html', $html);
echo "Dumped " . strlen($html) . " bytes to metacritic_dump.html\n";
