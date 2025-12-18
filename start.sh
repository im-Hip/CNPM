echo "=== Starting Laravel Application ==="
echo "PORT environment variable: $PORT"

# Start PHP server
exec php -S 0.0.0.0:$PORT -t public
