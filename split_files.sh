#!/bin/bash

# Script to split Claude's multi-file output into separate files
# Usage: ./split_files.sh [input_file]
# If no input file is provided, reads from stdin

set -euo pipefail

# Function to create directory if it doesn't exist
create_dir_if_needed() {
    local filepath="$1"
    local dirname=$(dirname "$filepath")
    
    if [[ "$dirname" != "." && "$dirname" != "/" ]]; then
        mkdir -p "$dirname"
        echo "Created directory: $dirname"
    fi
}

# Function to extract filename from the delimiter line
extract_filename() {
    local line="$1"
    # Remove ---FILE: and --- from the line, trim whitespace
    echo "$line" | sed 's/^---FILE:[[:space:]]*//; s/[[:space:]]*---$//' | xargs
}

# Main processing function
process_input() {
    local input_source="$1"
    local current_file=""
    local line_count=0
    local file_count=0
    
    while IFS= read -r line; do
        line_count=$((line_count + 1))
        
        # Check if this line is a file delimiter
        if [[ "$line" =~ ^---FILE:[[:space:]]*.*[[:space:]]*---$ ]]; then
            # Close previous file if open
            if [[ -n "$current_file" ]]; then
                echo "Finished writing: $current_file"
            fi
            
            # Extract new filename
            current_file=$(extract_filename "$line")
            file_count=$((file_count + 1))
            
            # Validate filename
            if [[ -z "$current_file" ]]; then
                echo "Error: Empty filename at line $line_count" >&2
                exit 1
            fi
            
            echo "Processing file: $current_file"
            
            # Create directory structure if needed
            create_dir_if_needed "$current_file"
            
            # Create/truncate the file
            > "$current_file"
            
        elif [[ -n "$current_file" ]]; then
            # Write content to current file
            echo "$line" >> "$current_file"
        else
            # Content before first file delimiter - ignore or warn
            if [[ "$line" =~ [^[:space:]] ]]; then
                echo "Warning: Content before first file delimiter at line $line_count: $line" >&2
            fi
        fi
    done < "$input_source"
    
    # Summary
    if [[ -n "$current_file" ]]; then
        echo "Finished writing: $current_file"
    fi
    
    echo ""
    echo "Summary: Processed $file_count files from $line_count lines"
}

# Main script logic
main() {
    if [[ $# -eq 0 ]]; then
        echo "Reading from stdin... (Press Ctrl+D when done, or Ctrl+C to cancel)"
        process_input "/dev/stdin"
    elif [[ $# -eq 1 ]]; then
        local input_file="$1"
        
        if [[ ! -f "$input_file" ]]; then
            echo "Error: File '$input_file' not found" >&2
            exit 1
        fi
        
        if [[ ! -r "$input_file" ]]; then
            echo "Error: File '$input_file' is not readable" >&2
            exit 1
        fi
        
        echo "Processing file: $input_file"
        process_input "$input_file"
    else
        echo "Usage: $0 [input_file]" >&2
        echo "  input_file: File containing delimited content (optional, reads from stdin if not provided)" >&2
        exit 1
    fi
}

# Run main function with all arguments
main "$@"
