#!/bin/bash
# Script to prevent iCloud from offloading GitHub files
# Run this periodically to keep files downloaded locally

GITHUB_DIR="/Users/jtsackton/Documents/github_lexington_alarm"

echo "Keeping GitHub files downloaded locally..."

# Find and download any offloaded files
find "$GITHUB_DIR" -type f -name "*.icloud" | while read file; do
    # Remove .icloud prefix to get original filename
    original_file="${file%.icloud}"
    original_file="${original_file#.}"
    echo "Downloading: $original_file"
    brctl download "$file"
done

# Pin all files to prevent future offloading
find "$GITHUB_DIR" -type f ! -name "*.icloud" -exec brctl download {} \; 2>/dev/null

echo "Done! All files should now be local."
echo ""
echo "To prevent future offloading, consider:"
echo "1. Renaming folder to: github_lexington_alarm.nosync"
echo "2. Moving folder outside of iCloud Documents"
echo "3. Running this script periodically"
