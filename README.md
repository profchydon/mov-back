<p align="center"><a href="https://rayda.co" target="_blank"><img src="./rayda-logo.svg" width="400"></a></p>

## Rayda Core (API)
Rayda enables you to manage, insure and unlock the value of your assets no matter where they are in the world.

## Installation (MacOS)

### Pre-requisite
* Homebrew (makes managing installations easier)
* Command Line Tools
* Docker Desktop

### Download Code
Ensure that you have write access to the codebase, then run the following command. (Might require creating ssh keys)

```
git clone git@github.com:RaydaHQ/core-v2-backend.git
```

### Environmental Variables
Generate the .env file, and update it with the most recent values.

```
cp .env.example .env
```

### Install Sail
Change into the project directory and install sail.

```
cd core-v2-backend
composer install
php artisan sail:install

Choose pgsql, redis
```

### Set alias for the sail installation
Create a shorthand command alias for running sail in the application

```
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

### Set up the application
Bootstrap the application using sail by running:

```
sail up
```

### Set up the application
Run database migrations and seeders

```
sail artisan migrate:fresh --seed
```

### Create a fully onboarded company + admin user (CLI, not sign up)
Creates tenant, company, user, user_company, and user_role so the user can log in and access the dashboard:

```bash
# From project root (requires htpasswd + mysql client)
./scripts/create-user.sh admin@example.com "YourPassword (Use your instance ID)" "MyCompany" "Admin" "User"

# With environment variables (e.g. on EC2)
EMAIL=admin@example.com PASSWORD=secret COMPANY_NAME="Acme" ./scripts/create-user.sh
```

Usage: `./scripts/create-user.sh <email> <password> [company_name] [first_name] [last_name]`

Requires: `htpasswd` (apache2-utils), `mysql` client. Loads DB config from `.env`. Run `php artisan db:seed` first so the Super Administrator role exists.

