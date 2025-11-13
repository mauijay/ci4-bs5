# Lean VS Code extension installation script for CI4/PHP workflow
# Run in PowerShell:  .\scripts\extensions-install.ps1

# NOTE: Ensure the 'code' CLI is on PATH. In VS Code: Command Palette -> "Shell Command: Install 'code' command in PATH" (on Windows it is usually already available).

$extensions = @(
  'bmewburn.vscode-intelephense-client',  # PHP language server
  'xdebug.php-debug',                     # PHP debugging
  'github.copilot',                       # AI completion
  'github.copilot-chat',                  # AI chat
  'eamodio.gitlens',                      # Git insights
  'esbenp.prettier-vscode',               # Formatting (JS/JSON/CSS; disable for PHP)
  'davidanson.vscode-markdownlint',       # Markdown linting
  'streetsidesoftware.code-spell-checker',# Spell checking
  'formulahendry.auto-rename-tag',        # HTML tag rename
  'vscode-icons-team.vscode-icons',       # File icons
  'humao.rest-client',                    # Lightweight HTTP client
  'bradlc.vscode-tailwindcss',            # Tailwind IntelliSense (optional but included)
  'github.vscode-github-actions',         # GitHub Actions support
  'github.vscode-pull-request-github'     # PR review integration
)

Write-Host "Installing lean extension set..." -ForegroundColor Cyan
foreach ($ext in $extensions) {
  Write-Host "Installing $ext" -ForegroundColor Yellow
  code --install-extension $ext
}

Write-Host "Done. Review enabled extensions and reload VS Code if needed." -ForegroundColor Green
