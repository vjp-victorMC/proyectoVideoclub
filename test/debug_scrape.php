<?php
// test/debug_scrape.php
$url = "https://www.google.com";
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n",
        'ignore_errors' => true
    ],
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ],
]);

echo "Testing connection to $url...\n";
$html = file_get_contents($url, false, $context);

if ($html === false) {
    echo "Failed to connect to $url\n";
    print_r(error_get_last());
} else {
    echo "Connection successful. Length: " . strlen($html) . "\n";
}

$url2 = "https://www.metacritic.com/game/playstation-4/god-of-war";
echo "Testing connection to $url2...\n";
$html2 = file_get_contents($url2, false, $context);
if ($html2 === false) {
    echo "Failed to connect to $url2\n";
    print_r(error_get_last());
} else {
    echo "Connection successful. Length: " . strlen($html2) . "\n";
    // Check http response header
    echo "Response headers:\n";
    print_r($http_response_header);
}
