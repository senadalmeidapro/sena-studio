#!/bin/sh
# =============================================================================
# Sena Studio — entrypoint du conteneur
#  1. Génère APP_KEY si absent
#  2. Relie le stockage public
#  3. Caches applicatifs (tolerants aux erreurs)
#  4. Migrations (avec attente du SGBD) + seed optionnel (DB_SEED=true)
#  5. Lance la commande passée (php artisan serve sur $PORT par défaut)
# =============================================================================

set -e

echo "==> Sena Studio $(php artisan --version --ansi 2>/dev/null | head -n 1)"

# --- Clé d'application ------------------------------------------------
# Recommandé : définir APP_KEY dans les variables Railway (stable).
# Fallback   : génération éphémère dans l'environnement du processus
#              (sessions invalidées à chaque redémarrage).
if [ -z "${APP_KEY:-}" ]; then
    echo "==> APP_KEY manquante (conseil : la définir dans les variables Railway)"
    APP_KEY="$(php artisan key:generate --show --no-ansi 2>/dev/null | grep -m1 -o 'base64:[A-Za-z0-9+/=]\{44\}' || true)"
    if [ -z "${APP_KEY:-}" ]; then
        echo "==> ÉCHEC : impossible de générer APP_KEY (artisan key:generate --show est requis)"
        exit 1
    fi
    echo "   ... clé éphémère générée (${#APP_KEY} caractères)"
    export APP_KEY
fi

# --- Stockage public (uploads) ---------------------------------------
php artisan storage:link --force --ansi 2>/dev/null || echo "(/!\ storage:link ignoré)"

# --- Caches applicatifs (errors tolérés, ex.: route avec Closure) ----
php artisan config:cache --ansi 2>/dev/null || echo "(/!\ config:cache ignoré)"
php artisan route:cache --ansi 2>/dev/null   || echo "(/!\ route:cache ignoré — route PDF via closure)"
php artisan view:cache --ansi 2>/dev/null    || echo "(/!\ view:cache ignoré)"

# --- Migration (avec retries pendant que la BDD démarre) -------------
if [ "${APP_MIGRATE:-true}" = "true" ]; then
    echo "==> Application des migrations PostgreSQL"
    max="${DB_RETRIES:-30}"
    i=1
    migrated=0
    while [ "$i" -le "$max" ]; do
        if php artisan migrate --force --no-interaction --ansi; then
            migrated=1
            break
        fi
        echo "   ... base non prête, tentative ${i}/${max} dans 3s"
        i=$((i + 1))
        sleep 3
    done
    if [ "$migrated" -ne 1 ]; then
        echo "==> ÉCHEC : migrations non appliquées après ${max} tentatives"
        exit 1
    fi
fi

# --- Seed optionnel (premier déploiement) ----------------------------
if [ "${DB_SEED:-false}" = "true" ]; then
    echo "==> Seed du portfolio"
    php artisan db:seed --force --no-interaction --ansi
fi

# --- Process principal -----------------------------------------------
echo "==> Démarrage : $*"
exec "$@"
