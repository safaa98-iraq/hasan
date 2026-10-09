#!/usr/bin/env bash
set -Eeuo pipefail
trap 'echo "ERROR: Hostinger preparation failed (line $LINENO). No local .env or database was changed." >&2' ERR
cd "$(dirname "$0")/.."
for tool in php composer node npm python3; do
    command -v "$tool" >/dev/null || { echo "ERROR: Missing tool: $tool" >&2; exit 1; }
done
exec python3 scripts/prepare_hostinger.py "$@"
