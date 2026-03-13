#!/bin/bash
# Start the Darren Connell website
# Ensure MySQL is running on port 8889 before starting
cd "$(dirname "$0")"
echo "Starting server at http://localhost:8001"
php -S localhost:8001 -t public public/index.php
