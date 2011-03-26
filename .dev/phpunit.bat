echo "Go to root dir..."

cd /c/Dev/xampp/htdocs/xlite

echo "Starting PHPUnit..."

/c/Dev/xampp/php/php.exe .dev/phpunit --verbose xliteAllTests /c/Dev/xampp/htdocs/xlite/.dev/tests/AllTests.php LOCAL_TESTS,$1

echo "Tests complete"

