<?php

$file = 'c:\laragon\www\bhaiya-housing-banckend\app\Http\Controllers\WebController.php';
$content = file_get_contents($file);

// Replace $this->facebook->sendEvent('PageView', ...);
$pattern = '/\$this->facebook->sendEvent\(\s*\'PageView\',\s*\[\s*\'client_ip_address\' => request\(\)->ip\(\),\s*\'client_user_agent\' => request\(\)->userAgent\(\),\s*\]\s*\);/s';
$content = preg_replace($pattern, '', $content);

// Update trackFacebook to use static method
$patternTrackFacebook = '/public function trackFacebook\(\$event, \$userData = \[\], \$customData = \[\], \$eventId = null\)\s*\{\s*return app\(FacebookConversionApi::class\)\s*->sendEvent\(\$event, \$userData, \$customData, \$eventId\);\s*\}/s';
$replacementTrackFacebook = 'public function trackFacebook($event, $userData = [], $customData = [], $eventId = null)
    {
        return FacebookConversionApi::sendEvent($event, $eventId, $customData, $userData);
    }';
$content = preg_replace($patternTrackFacebook, $replacementTrackFacebook, $content);

file_put_contents($file, $content);

echo "Done.";
