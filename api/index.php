<?php
error_reporting(0);
date_default_timezone_set("Asia/Kolkata");

// ഗെറ്റ് റിക്വസ്റ്റിൽ നിന്ന് stream_id എടുക്കുന്നു, ഇല്ലെങ്കിൽ ഡിഫോൾട്ട് ആയി 34747 എടുക്കും
$stream_id = isset($_GET['stream_id']) ? $_GET['stream_id'] : '34747';

// നിങ്ങൾ തന്ന കൃത്യമായ ലിങ്ക് ഫോർമാറ്റ്
$target_url = "http://raztv.online//live/MAGNL39E26/hvhS6xsuZP/{$stream_id}.m3u8?token=stream";

// യൂസർ ഏജന്റ് ഹെഡറോട് കൂടി ഒറിജിനൽ ലിങ്കിൽ നിന്ന് ഡാറ്റ ഫെച്ച് ചെയ്യുന്നു (പ്രോക്സി രീതി)
$options = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: Mozilla/5.0 (Linux; Android 10) AppleWebKit/537.36\r\nAccept: */*\r\n"
    ]
];
$context = stream_context_create($options);
$result = @file_get_contents($target_url, false, $context);

if ($result !== false) {
    header("Content-Type: application/vnd.apple.mpegurl");
    echo $result;
} else {
    // ഫെച്ച് ചെയ്യാൻ പറ്റിയില്ലെങ്കിൽ നേരിട്ട് ആ ലിങ്കിലേക്ക് റീഡയറക്ട് ചെയ്യും
    header("Location: " . $target_url, true, 302);
}
exit();
?>

