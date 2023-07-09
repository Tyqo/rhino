# Rhino CMS and Application Framework 🦏 

![Build Status](https://github.com/cakephp/app/actions/workflows/ci.yml/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%207-brightgreen.svg?style=flat-square)](https://github.com/phpstan/phpstan)

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Clone [this](https://github.com/Tyqo/rhino) Repo in the desired location.
2. Clone [Tusk](https://github.com/Tyqo/tusk) in `plugins/Tusk`
3. Run `composer install` for both.
4. Run `npm install && gulp build` for both

   alternativly to 2 -4:
   run: ./installer.sh
5. Make `tmp` writable.
6. Configure `config/app_local.php`
7. Run `bin/cake migrations migrate -p Tusk`
8. Default Login:

   ```
   User: rhino@example.com
   Password: #tusk
   ```
