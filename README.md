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

