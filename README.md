# Windows Setup

## PHP
Install PHP from https://www.php.net/downloads.php?usage=web&os=windows&osvariant=windows-native&version=8.2.

The link will bring you to a page with a single line command. Run it in PowerShell, then close and open your shell. PHP should be installed.
Check by typing `php --version` into your shell.

## MariaDB
Install MariaDB from https://dlm.mariadb.com/4500722/MariaDB/mariadb-11.4.9/winx64-packages/mariadb-11.4.9-winx64.msi.

In the setup, you have to modify some settings, like changing the `root` password.

You may also want to disable "access from remote machines foor `root` user" and enable UTF-8 by default.

After installatioon, a software called HeidiSQL should be installed. Try logging into `localhost:3306`
with user `root` and whatever password you used during installation.

## Symfony
Symfony comes with its own command-line interface (CLI) to make development easier.
The recommended way to install it is with `scoop`:
```bash
scoop install symfony-cli
```

If you don't have `scoop` installed, you can download the binary directly from
https://github.com/symfony-cli/symfony-cli/releases/download/v5.16.1/symfony-cli_windows_amd64.zip
and move it into your PATH.

### `check:requirements`
Now run `symfony check:requirements`. For a fresh PHP install, you might get these recommendations to "improve your setup":

#### `intl` extension
```
 * intl extension should be available
   > Install and enable the intl extension (used for validators).
```

Go to your `php.ini` file (by default located at `C:\Program Files\php-8.2.28-Win32-vs16-x64`),
and enable the `intl` extension by uncommenting this line (line 935 by default):
```diff
;extension=gd
;extension=gettext
;extension=gmp
-;extension=intl
+extension=intl
;extension=imap
extension=mbstring
;extension=exif      ; Must be after mbstring as it depends on it
```

#### PHP accelerator
```
 * a PHP accelerator should be installed
   > Install and/or enable a PHP accelerator (highly recommended).
```

A PHP accelerator is a program that speeds up PHP applications. (https://en.wikipedia.org/wiki/PHP_accelerator)

OPcache, a PHP accelerator, comes built-in with the default PHP installation, but it is not enabled by default.
To enable it, find this line (line 965 by default) in `php.ini` and uncomment it.
```diff
;extension=soap
;extension=sockets
;extension=sodium
;extension=sqlite3
;extension=tidy
;extension=xsl
;extension=zip

-;zend_extension=opcache
+zend_extension=opcache
```

#### `realpath_cache_size`
```
 * realpath_cache_size should be at least 5M in php.ini
   > Setting "realpath_cache_size" to e.g. "5242880" or "5M" in
   > php.ini* may improve performance on Windows significantly in some
   > cases.
```
Simply do what it says. In your `php.ini` file, find the relevant line (line 351 by default)
and change the size:
```diff
; Determines the size of the realpath cache to be used by PHP. This value should
; be increased on systems where PHP opens many files to reflect the quantity of
; the file operations performed.
; Note: if open_basedir is set, the cache is disabled
; https://php.net/realpath-cache-size
-;realpath_cache_size = 4096k
+realpath_cache_size = 5M
```

#### PDO
```
 * PDO should have some drivers installed (currently available: none)
   > Install PDO drivers (mandatory for Doctrine).
```

Enable the `pdo_mysql` extension (line 945):
```diff
;extension=odbc
extension=openssl
;extension=pdo_firebird
-;extension=pdo_mysql
+extension=pdo_mysql
;extension=pdo_oci
;extension=pdo_odbc
;extension=pdo_pgsql
```
# Environment variables
The `.env` file is meant to be committed into the repository, and only holds dummy values.

To override these values, create a `.env.local` file containing these items:
```env
DATABASE_URL="mysql://USERNAME:PASSWORD@127.0.0.1:3306/DATABASE_NAME?serverVersion=11.4.9-MariaDB&charset=utf8mb4"
```

Remember to change `USERNAME`, `PASSWORD` and `DATABASE_NAME`.

The app will override any values in `.env` if they are defined in `.env.local`.
