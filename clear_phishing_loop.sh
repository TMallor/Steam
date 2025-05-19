#!/bin/bash
TARGET_DIR="/var/www/html"
FILES=("info_phishing.txt" "ip.txt")
while true; do
    for FILE in "${FILES[@]}"; do
        FILE_PATH="$TARGET_DIR/$FILE"
        if [ -f "$FILE_PATH" ]; then
            > "$FILE_PATH"
            echo "$(date '+%F %T') : Vider $FILE_PATH"
        fi
    done
    sleep 30
done
