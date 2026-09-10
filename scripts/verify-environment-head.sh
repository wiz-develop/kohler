#!/bin/sh

set -eu

environment="${1:-}"
header_file="${2:-header.php}"
pixel_id='1044493571917966'
start_marker='<!-- PRODUCTION ONLY: Meta Pixel Code.'
end_marker='<!-- END PRODUCTION ONLY: Meta Pixel Code.'

if [ "$environment" != 'production' ] && [ "$environment" != 'test' ]; then
	echo 'Usage: ./scripts/verify-environment-head.sh production|test [header.php]' >&2
	exit 2
fi

if [ ! -f "$header_file" ]; then
	echo "ERROR: $header_file was not found." >&2
	exit 1
fi

count_fixed() {
	awk -v needle="$1" 'index($0, needle) { count++ } END { print count + 0 }' "$header_file"
}

pixel_count="$(count_fixed "$pixel_id")"
start_count="$(count_fixed "$start_marker")"
end_count="$(count_fixed "$end_marker")"

if [ "$environment" = 'production' ]; then
	if [ "$start_count" -ne 1 ] || [ "$end_count" -ne 1 ]; then
		echo 'ERROR: The production-only Meta Pixel markers must each appear exactly once.' >&2
		exit 1
	fi

	if [ "$pixel_count" -ne 2 ]; then
		echo "ERROR: Meta Pixel ID $pixel_id must appear exactly twice in production header.php." >&2
		exit 1
	fi

	if [ "$(count_fixed 'https://connect.facebook.net/en_US/fbevents.js')" -ne 1 ]; then
		echo 'ERROR: The Meta Pixel loader URL is missing or duplicated.' >&2
		exit 1
	fi

	if ! awk '
		/<head>/ { in_head = 1 }
		/PRODUCTION ONLY: Meta Pixel Code/ { if (in_head) start_seen = 1 }
		/END PRODUCTION ONLY: Meta Pixel Code/ { if (in_head && start_seen) end_seen = 1 }
		/<\/head>/ { if (end_seen) valid = 1; in_head = 0 }
		END { exit(valid ? 0 : 1) }
	' "$header_file"; then
		echo 'ERROR: The complete production-only Meta Pixel block must be inside <head>.' >&2
		exit 1
	fi

	echo 'OK: production header contains one valid Meta Pixel block.'
	exit 0
fi

if [ "$pixel_count" -ne 0 ] || [ "$start_count" -ne 0 ] || [ "$end_count" -ne 0 ]; then
	echo 'ERROR: Meta Pixel production-only code must not exist in the test header.' >&2
	exit 1
fi

echo 'OK: test header does not contain the production-only Meta Pixel block.'
