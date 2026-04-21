#!/bin/bash
# Script to extract code snippets from the WordPress database

echo "Searching for code snippets in database..."

# Search for snippet-related tables and content
grep -i "snippet\|wpcode\|hfcm" ozpxkamy_WPJYZ.sql | head -20

echo "---"
echo "Searching for CREATE TABLE statements with code/snippet references..."
grep -i "CREATE TABLE.*snippet\|CREATE TABLE.*wpcode\|CREATE TABLE.*hfcm" ozpxkamy_WPJYZ.sql

echo "---"
echo "Searching for INSERT statements with code/snippet references..."
grep -i "INSERT INTO.*snippet\|INSERT INTO.*wpcode\|INSERT INTO.*hfcm" ozpxkamy_WPJYZ.sql | head -10
