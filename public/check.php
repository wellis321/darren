<?php
/**
 * Upload this file to your Hostinger document root and visit:
 * https://yoursite.com/check.php
 * If you see "OK" - you're in the right folder. Put index.php here too.
 * If 404 - try check.php in different folders to find the document root.
 */
header('Content-Type: text/plain');
echo "OK - Document root found\n";
echo "Path: " . __DIR__ . "\n";
echo "Now upload index.php and the rest of the deploy files to this same folder.";
