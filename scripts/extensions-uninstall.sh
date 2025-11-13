#!/usr/bin/env bash
set -euo pipefail

# Bulk uninstall script for non-essential / redundant extensions (Bash)
# Review list BEFORE running and comment out anything you want to keep.
# Usage:
#   bash ./scripts/extensions-uninstall.sh

if ! command -v code >/dev/null 2>&1; then
  echo "Error: 'code' CLI not found on PATH." >&2
  echo "In VS Code: Command Palette -> 'Shell Command: Install \"code\" command in PATH'" >&2
  exit 1
fi

# Candidate removals (safe defaults). Comment out to keep any.
TO_REMOVE=(
  ecmel.vscode-html-css
  ms-toolsai.vscode-jupyter-slideshow
  ms-toolsai.jupyter-keymap
  mikestead.dotenv
  ms-toolsai.vscode-jupyter-cell-tags
  cardinal90.multi-cursor-case-preserve
  xabikos.javascriptsnippets
  ms-azuretools.vscode-docker
  monish.regexsnippets
  pnp.polacode
  rapidapi.vscode-services
  johnpapa.vscode-peacock
  ms-mssql.sql-bindings-vscode
  christian-kohler.npm-intellisense
  donjayamanne.githistory
  benemohamed.codeigniter4-snippets
  ms-vscode.makefile-tools
  formulahendry.code-runner
  ms-python.isort
  hakcorp.php-awesome-snippets
  wayou.vscode-todo-highlight
  brapifra.phpserver
  dsznajder.es7-react-js-snippets
  rapidapi.vscode-rapidapi-client
  dotjoshjohnson.xml
  tomoki1207.pdf
  codestackr.codestackr-theme
  oouo-diogo-perdigao.docthis
  ritwickdey.liveserver
  zobo.php-intellisense
  ms-vscode.live-server
  ms-mssql.data-workspace-vscode
  ms-mssql.sql-database-projects-vscode
  ms-mssql.mssql
  wallabyjs.quokka-vscode
  ms-vscode-remote.remote-wsl
  mechatroner.rainbow-csv
  christian-kohler.path-intellisense
  mongodb.mongodb-vscode
  yzane.markdown-pdf
  devsense.intelli-php-vscode
  devsense.composer-php-vscode
  devsense.phptools-vscode
  devsense.profiler-php-vscode
  shd101wyy.markdown-preview-enhanced
  wallabyjs.console-ninja
  vue.volar
  ms-azuretools.vscode-containers
  codium.codium
  wallabyjs.wallaby-vscode
  ms-vscode-remote.remote-containers
  ms-python.vscode-pylance
  ms-python.vscode-python-envs
  ms-python.debugpy
  ms-python.python
  ms-vscode.vscode-typescript-next
  ms-toolsai.jupyter-renderers
  ms-toolsai.jupyter
)

# Show actual installed matches to avoid noise
INSTALLED=$(code --list-extensions || true)
MATCHING=()
for ext in "${TO_REMOVE[@]}"; do
  if grep -qi "^${ext}$" <<<"$INSTALLED"; then
    MATCHING+=("$ext")
  fi

done

if (( ${#MATCHING[@]} == 0 )); then
  echo "No matching installed extensions from the removal list. Nothing to do."
  exit 0
fi

echo "Extensions flagged for uninstall:"
printf ' - %s\n' "${MATCHING[@]}"
read -r -p "Proceed with uninstall (y/N)? " REPLY
if [[ ! "$REPLY" =~ ^[Yy]$ ]]; then
  echo "Aborted."
  exit 0
fi

for ext in "${MATCHING[@]}"; do
  echo "Uninstalling $ext"
  code --uninstall-extension "$ext" || true

done

echo "Uninstall pass complete. Reload VS Code (Command Palette -> Reload Window)."
