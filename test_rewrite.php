<?php
// Test if URL rewriting is working
echo "URL Rewriting Test\n";
echo "==================\n\n";

echo "Current URL: " . $_SERVER['REQUEST_URI'] . "\n";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "PHP Self: " . $_SERVER['PHP_SELF'] . "\n";
echo "Query String: " . ($_SERVER['QUERY_STRING'] ?? 'none') . "\n";

// Test if we can access the admin routes
echo "\nTesting admin routes:\n";
echo "1. Try accessing: http://localhost/jacket/admin\n";
echo "2. Try accessing: http://localhost/jacket/admin/products\n";
echo "3. Try accessing: http://localhost/jacket/admin/dashboard\n";

echo "\nIf these URLs show 404 errors, the .htaccess is not working.\n";
echo "If they work, the .htaccess is working correctly.\n";
?>
