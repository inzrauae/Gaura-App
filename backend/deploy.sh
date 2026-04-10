#!/usr/bin/env bash
set -euo pipefail

REPO_URL="https://github.com/inzrauae/Gaura-App.git"
BRANCH="branch-name"
REPO_DIR_NAME="repo-name"
APP_SUBDIR="backend"
PUBLIC_HTML_DIR="$HOME/public_html"

if [[ -n "${1:-}" ]]; then BRANCH="$1"; fi
if [[ -n "${2:-}" ]]; then REPO_DIR_NAME="$2"; fi

REPO_PATH="$HOME/$REPO_DIR_NAME"
APP_PATH="$REPO_PATH/$APP_SUBDIR"

clone_repo() {
    if [[ -d "$REPO_PATH/.git" ]]; then
        echo "Repository already exists at $REPO_PATH"
        return
    fi

    local clone_url="$REPO_URL"
    if [[ -n "${GITHUB_TOKEN:-}" ]]; then
        clone_url="https://${GITHUB_TOKEN}@github.com/inzrauae/Gaura-App.git"
    fi

    git clone --branch "$BRANCH" --single-branch "$clone_url" "$REPO_PATH"
}

ensure_composer() {
    if command -v composer >/dev/null 2>&1; then
        COMPOSER_CMD=(composer)
        return
    fi

    if [[ -f "$HOME/composer.phar" ]]; then
        COMPOSER_CMD=(php "$HOME/composer.phar")
        return
    fi

    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --install-dir="$HOME" --filename="composer.phar"
    rm -f composer-setup.php
    COMPOSER_CMD=(php "$HOME/composer.phar")
}

prepare_env() {
    sed -i 's/\r$//' "$APP_PATH/.env.production"
    cp "$APP_PATH/.env.production" "$APP_PATH/.env"
    sed -i 's/\r$//' "$APP_PATH/.env"
}

install_php_deps() {
    (
        cd "$APP_PATH"
        "${COMPOSER_CMD[@]}" install --no-dev --optimize-autoloader --ignore-platform-req=ext-fileinfo
    )
}

publish_public_files() {
    cp "$APP_PATH/cpanel-index.php" "$PUBLIC_HTML_DIR/index.php"
    sed -i "s|repo-name|$REPO_DIR_NAME|g" "$PUBLIC_HTML_DIR/index.php"

    cp "$APP_PATH/public/.htaccess" "$PUBLIC_HTML_DIR/.htaccess"

    rm -rf "$PUBLIC_HTML_DIR/build"
    ln -sfn "$APP_PATH/public/build" "$PUBLIC_HTML_DIR/build"

    rm -rf "$PUBLIC_HTML_DIR/storage"
    ln -sfn "$APP_PATH/public/storage" "$PUBLIC_HTML_DIR/storage"
}

set_permissions() {
    find "$APP_PATH" -type d -exec chmod 755 {} \;
    find "$APP_PATH/storage" -type d -exec chmod 775 {} \;
    find "$APP_PATH/bootstrap/cache" -type d -exec chmod 775 {} \;
}

artisan_setup() {
    (
        cd "$APP_PATH"
        php artisan key:generate --force
        php artisan storage:link || true
        php artisan migrate --seed --force
        php artisan optimize:clear
        php artisan route:cache
        php artisan view:cache
    )
}

main() {
    clone_repo
    ensure_composer
    install_php_deps
    prepare_env
    publish_public_files
    set_permissions
    artisan_setup

    echo "Deployment finished: https://ex.gauraconstruction.lk/"
}

main "$@"
