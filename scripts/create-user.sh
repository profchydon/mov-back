#!/bin/bash
# Create a fully onboarded company with admin user (run from project root)
# Creates: tenant, company, user, user_company, user_role, subscription
# Requires: mysql client
#   Ubuntu/Debian: apt-get install mysql-client
#   Alpine: apk add mysql-client
#
# Usage: ./scripts/create-user.sh <email> <password> [company_name] [first_name] [last_name]
# Or:    EMAIL=admin@example.com PASSWORD=secret ./scripts/create-user.sh
#
# Database config - edit the defaults below to match your backend (or override via env vars):
DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-3306}"
DB_DATABASE="${DB_DATABASE:-raydaprod}"
DB_USERNAME="${DB_USERNAME:-masterrayda}"
DB_PASSWORD="${DB_PASSWORD:-password}"

set -e

# Add Homebrew mysql-client to PATH if installed (macOS keg-only)
if [ -d "/opt/homebrew/opt/mysql-client/bin" ]; then
  export PATH="/opt/homebrew/opt/mysql-client/bin:$PATH"
elif [ -d "/usr/local/opt/mysql-client/bin" ]; then
  export PATH="/usr/local/opt/mysql-client/bin:$PATH"
fi

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(dirname "$SCRIPT_DIR")"

EMAIL="${1:-$EMAIL}"
PASSWORD="${2:-$PASSWORD}"
COMPANY_NAME="${3:-$COMPANY_NAME}"
FIRST_NAME="${4:-$FIRST_NAME}"
LAST_NAME="${5:-$LAST_NAME}"

if [ -z "$EMAIL" ] || [ -z "$PASSWORD" ]; then
  echo "Usage: $0 <email> <password> [company_name] [first_name] [last_name]"
  echo "   Or: EMAIL=... PASSWORD=... $0"
  exit 1
fi

# Defaults
[ -z "$COMPANY_NAME" ] && COMPANY_NAME="${EMAIL%%@*}"
[ -z "$FIRST_NAME" ] && FIRST_NAME="${EMAIL%%@*}"
[ -z "$LAST_NAME" ] && LAST_NAME=""

# Check for mysql
if ! command -v mysql &>/dev/null; then
  echo "Error: mysql client required. Install mysql-client"
  exit 1
fi

# Generate UUIDs
gen_uuid() {
  if command -v uuidgen &>/dev/null; then
    uuidgen | tr '[:upper:]' '[:lower:]'
  elif [ -f /proc/sys/kernel/random/uuid ]; then
    cat /proc/sys/kernel/random/uuid
  else
    echo "Error: Need uuidgen or /proc/sys/kernel/random/uuid" >&2
    exit 1
  fi
}

TENANT_ID=$(gen_uuid)
COMPANY_ID=$(gen_uuid)
USER_ID=$(gen_uuid)
USER_COMPANY_ID=$(gen_uuid)
USER_ROLE_ID=$(gen_uuid)
SUBSCRIPTION_ID=$(gen_uuid)
USER_SSO_ID=$(gen_uuid)
COMPANY_SSO_ID=$(gen_uuid)

# Generate invitation code (32 chars)
INVITATION_CODE=$(openssl rand -hex 16 2>/dev/null || cat /dev/urandom 2>/dev/null | tr -dc 'a-zA-Z0-9' | head -c 32)

# Get Super Administrator role id (must exist from seeding)
ROLE_ID=$(mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -N -e "SELECT id FROM roles WHERE name='Super Administrator' LIMIT 1" 2>/dev/null || true)

if [ -z "$ROLE_ID" ]; then
  echo "Error: Role 'Super Administrator' not found. Run: php artisan db:seed --class=RoleSeeder"
  exit 1
fi

# Get Basic plan id (must exist from seeding)
PLAN_ID=$(mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -N -e "SELECT id FROM plans WHERE name='Basic' LIMIT 1" 2>/dev/null || true)

if [ -z "$PLAN_ID" ]; then
  PLAN_ID=$(mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -N -e "SELECT id FROM plans LIMIT 1" 2>/dev/null || true)
fi

if [ -z "$PLAN_ID" ]; then
  echo "Error: No plan found. Run: php artisan db:seed --class=PlanSeeder"
  exit 1
fi

# Check if user or company already exists
USER_EXISTS=$(mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -N -e "SELECT 1 FROM users WHERE email='${EMAIL//\'/\\\'}' LIMIT 1" 2>/dev/null || true)
COMPANY_EXISTS=$(mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -N -e "SELECT 1 FROM companies WHERE email='${EMAIL//\'/\\\'}' LIMIT 1" 2>/dev/null || true)

if [ -n "$USER_EXISTS" ]; then
  echo "Error: User with email $EMAIL already exists."
  exit 1
fi

if [ -n "$COMPANY_EXISTS" ]; then
  echo "Error: Company with email $EMAIL already exists."
  exit 1
fi

# Escape single quotes for SQL
EMAIL_ESC="${EMAIL//\'/\\\'}"
COMPANY_NAME_ESC="${COMPANY_NAME//\'/\\\'}"
FIRST_NAME_ESC="${FIRST_NAME//\'/\\\'}"
LAST_NAME_ESC="${LAST_NAME//\'/\\\'}"
INVITATION_CODE_ESC="${INVITATION_CODE//\'/\\\'}"

mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -e "
START TRANSACTION;

INSERT INTO tenants (id, name, email, status, created_at, updated_at)
VALUES ('$TENANT_ID', '$COMPANY_NAME_ESC', '$EMAIL_ESC', 'Active', NOW(), NOW());

INSERT INTO companies (id, name, email, tenant_id, sso_id, invitation_code, status, allow_user_login, created_at, updated_at)
VALUES ('$COMPANY_ID', '$COMPANY_NAME_ESC', '$EMAIL_ESC', '$TENANT_ID', '$COMPANY_SSO_ID', '$INVITATION_CODE_ESC', 'Active', 1, NOW(), NOW());

INSERT INTO users (id, first_name, last_name, email, sso_id, tenant_id, stage, status, created_at, updated_at)
VALUES ('$USER_ID', '$FIRST_NAME_ESC', '$LAST_NAME_ESC', '$EMAIL_ESC', '$USER_SSO_ID', '$TENANT_ID', 'Completed', 'Active', NOW(), NOW());

INSERT INTO user_companies (id, tenant_id, company_id, user_id, status, has_seat, created_at, updated_at)
VALUES ('$USER_COMPANY_ID', '$TENANT_ID', '$COMPANY_ID', '$USER_ID', 'Active', 1, NOW(), NOW());

INSERT INTO user_roles (id, user_id, company_id, role_id, status, created_at, updated_at)
VALUES ('$USER_ROLE_ID', '$USER_ID', '$COMPANY_ID', $ROLE_ID, 'Active', NOW(), NOW());

INSERT INTO subscriptions (id, tenant_id, company_id, plan_id, start_date, end_date, billing_cycle, status, created_at, updated_at)
VALUES ('$SUBSCRIPTION_ID', '$TENANT_ID', '$COMPANY_ID', '$PLAN_ID', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR), 'Yearly', 'Active', NOW(), NOW());

COMMIT;
"

echo "Company and user created successfully."
echo ""
echo "User:"
echo "  Email: $EMAIL"
echo "  First Name: $FIRST_NAME"
echo "  Last Name: $LAST_NAME"
echo ""
echo "Company:"
echo "  Name: $COMPANY_NAME"
echo "  Email: $EMAIL"
echo ""
echo "The user can now log in with this email (no password required)."
