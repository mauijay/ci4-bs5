# Bulk uninstall script for non-essential / redundant extensions
# Review list BEFORE running. To execute:  .\scripts\extensions-uninstall.ps1
# A confirmation prompt is shown; only 'y' proceeds.

$toRemove = @(
  'ecmel.vscode-html-css',
  'ms-toolsai.vscode-jupyter-slideshow',
  'ms-toolsai.jupyter-keymap',
  'mikestead.dotenv',
  'ms-toolsai.vscode-jupyter-cell-tags',
  'cardinal90.multi-cursor-case-preserve',
  'xabikos.javascriptsnippets',
  'ms-azuretools.vscode-docker',
  'monish.regexsnippets',
  'pnp.polacode',
  'rapidapi.vscode-services',
  'johnpapa.vscode-peacock',
#  'humao.rest-client',                    # Removed if you choose Postman instead (comment out if keeping)
  'ms-mssql.sql-bindings-vscode',
  'christian-kohler.npm-intellisense',
  'donjayamanne.githistory',              # GitLens supersedes most use cases
  'benemohamed.codeigniter4-snippets',
  'ms-vscode.makefile-tools',
  'formulahendry.code-runner',
  'ms-python.isort',
  'hakcorp.php-awesome-snippets',
  'wayou.vscode-todo-highlight',
  'brapifra.phpserver',
  'dsznajder.es7-react-js-snippets',
  'rapidapi.vscode-rapidapi-client',
  'dotjoshjohnson.xml',
  'tomoki1207.pdf',
  'codestackr.codestackr-theme',
  'oouo-diogo-perdigao.docthis',
  'ritwickdey.liveserver',                # Remove if using ms-vscode.live-server or none
  'zobo.php-intellisense',                # Redundant vs Intelephense
  'ms-vscode.live-server',                # Remove duplicate live-server implementation
  'ms-mssql.data-workspace-vscode',
  'ms-mssql.sql-database-projects-vscode',
  'ms-mssql.mssql',
  'wallabyjs.quokka-vscode',
  'ms-vscode-remote.remote-wsl',
  'github.vscode-github-actions',         # KEEP if using Actions; comment out if retaining
  'mechatroner.rainbow-csv',
  'christian-kohler.path-intellisense',
  'mongodb.mongodb-vscode',
  'yzane.markdown-pdf',
  'devsense.intelli-php-vscode',
  'devsense.composer-php-vscode',
  'devsense.phptools-vscode',
  'devsense.profiler-php-vscode',
  'shd101wyy.markdown-preview-enhanced',
  'wallabyjs.console-ninja',
  'vue.volar',
  'ms-azuretools.vscode-containers',
  'codium.codium',
  'wallabyjs.wallaby-vscode',
  'github.github-vscode-theme',
  'ms-vscode-remote.remote-containers',
  'ms-python.vscode-pylance',
  'ms-python.vscode-python-envs',
  'ms-python.debugpy',
  'ms-python.python',
  'ms-vscode.vscode-typescript-next',
  'ms-toolsai.jupyter-renderers',
  'ms-toolsai.jupyter',
  'eamodio.gitlens',                      # KEEP: comment out if retaining; here for safety editing
  'bmewburn.vscode-intelephense-client',  # KEEP: comment out if retaining
  'xdebug.php-debug',                     # KEEP: comment out if retaining
  'streetsidesoftware.code-spell-checker',# KEEP: comment out if retaining
  'davidanson.vscode-markdownlint',       # KEEP: comment out if retaining
  'formulahendry.auto-rename-tag',        # KEEP: comment out if retaining
  'vscode-icons-team.vscode-icons',       # KEEP: comment out if retaining
  'bradlc.vscode-tailwindcss',            # KEEP: comment out if retaining
  'github.vscode-pull-request-github',    # KEEP: comment out if retaining
  'github.copilot',                       # KEEP: comment out if retaining
  'github.copilot-chat',                  # KEEP: comment out if retaining
  'esbenp.prettier-vscode'                # KEEP: comment out if retaining
)

# Prune list to only actual removals: comment out any you want to keep before running.
$toRemove = $toRemove | Where-Object { $_ -and ($_ -notmatch '^\s*#') }

Write-Host "Extensions flagged for uninstall:" -ForegroundColor Cyan
$toRemove | ForEach-Object { Write-Host " - $_" }

$confirm = Read-Host "Proceed with uninstall (y/n)?"
if ($confirm -ne 'y') {
  Write-Host "Aborted." -ForegroundColor Yellow
  exit 0
}

foreach ($ext in $toRemove) {
  Write-Host "Uninstalling $ext" -ForegroundColor Yellow
  code --uninstall-extension $ext
}

Write-Host "Uninstall pass complete. Review and reload VS Code." -ForegroundColor Green
