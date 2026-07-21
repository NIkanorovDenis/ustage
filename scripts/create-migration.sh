#!/usr/bin/env bash
set -euo pipefail

if [[ $# -ne 1 ]] || [[ ! "$1" =~ ^[a-z0-9_]+$ ]]; then
  echo "Usage: $0 migration_name" >&2
  echo "Example: $0 add_catalog_color_property" >&2
  exit 2
fi

root=$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)
directory="$root/www/local/migrations"
target="$directory/$(date +%Y%m%d_%H%M%S)_$1.php"

mkdir -p "$directory"
cp "$directory/example.php.dist" "$target"

echo "$target"
