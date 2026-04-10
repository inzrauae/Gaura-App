#!/usr/bin/env bash
set -euo pipefail

REPO_DIR_NAME="repo-name"
APP_SUBDIR="backend"
PUBLIC_HTML_DIR="$HOME/public_html"
BRANCH="branch-name"

if [[ -n "${1:-}" ]]; then BRANCH="$1"; fi
if [[ -n "${2:-}" ]]; then REPO_DIR_NAME="$2"; fi

REPO_PATH="$HOME/$REPO_DIR_NAME"
APP_PATH="$REPO_PATH/$APP_SUBDIR"

ensure_repo_exists() {
    if [[ ! -d "$REPO_PATH/.git" ]]; then
        echo "Repository not found at $REPO_PATH"
        exit 1
    fi
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

update_repo() {
    (
        cd "$REPO_PATH"
        git fetch origin "$BRANCH"
        git checkout "$BRANCH"
        git pull --ff-only origin "$BRANCH"
    )
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

artisan_refresh() {
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
    ensure_repo_exists
    ensure_composer
    update_repo
    prepare_env
    install_php_deps
    artisan_refresh
    publish_public_files
    set_permissions

    echo "Update finished: https://ex.gauraconstruction.lk/"
}

main "$@"
