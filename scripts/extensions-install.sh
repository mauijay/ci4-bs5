#!/usr/bin/env bash
set -euo pipefail

# Lean VS Code extension installation script for CI4/PHP workflow (Bash)
# Usage:
#   bash ./scripts/extensions-install.sh

if ! command -v code >/dev/null 2>&1; then
  echo "Error: 'code' CLI not found on PATH." >&2
  echo "In VS Code: Command Palette -> 'Shell Command: Install \"code\" command in PATH'" >&2
  exit 1
fi

EXTENSIONS=(
  bmewburn.vscode-intelephense-client   # PHP language server
  xdebug.php-debug                      # PHP debugging
  github.copilot                        # AI completion
  github.copilot-chat                   # AI chat
  eamodio.gitlens                       # Git insights
  esbenp.prettier-vscode                # Formatting (JS/JSON/CSS; disable for PHP)
  davidayson.vscode-markdownlint        # TYPO: kept for backward compatibility; real id below
  davidanson.vscode-markdownlint        # Markdown linting
  streetsidesoftware.code-spell-checker # Spell checking
  formulahendry.auto-rename-tag         # HTML tag rename
  vscode-icons-team.vscode-icons        # File icons
  humao.rest-client                     # Lightweight HTTP client
  bradlc.vscode-tailwindcss             # Tailwind IntelliSense
  github.vscode-github-actions          # GitHub Actions panel
  github.vscode-pull-request-github     # PR review integration
)

# Deduplicate (in case of overlaps)
mapfile -t EXTENSIONS < <(printf '%s\n' "${EXTENSIONS[@]}" | awk 'NF' | sort -u)

echo "Installing lean extension set..."
for ext in "${EXTENSIONS[@]}"; do
  echo "Installing $ext"
  code --install-extension "$ext" || true
done

echo "Done. Reload VS Code if needed."
