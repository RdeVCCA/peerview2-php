# Windows Setup

## PHP
Install PHP from https://www.php.net/downloads.php?usage=web&os=windows&osvariant=windows-native&version=8.4&multiversion=Y.

The link will bring you to a page with a single line command. Run it in PowerShell, then close and open your shell. PHP should be installed.
Check by typing `php -v` into your shell.

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
For a fresh PHP install, you will need to change these settings in the `php.ini` file,
which can be found in the same folder as the `php.exe` you're currently using:

#### Extensions
Enable the following extensions by uncommenting the lines:
- `curl`
- `fileinfo`
- `intl`
- `mbstring`
- `mysqli`
- `openssl`
- `pdo_mysql`

From line 918:
```diff
;extension=bz2
-;extension=curl
+extension=curl
;extension=ffi
;extension=ftp
-;extension=fileinfo
+extension=fileinfo
;extension=gd
;extension=gettext
;extension=gmp
-;extension=intl
+extension=intl
;extension=ldap
-;extension=mbstring
+extension=mbstring
;extension=exif      ; Must be after mbstring as it depends on it
-;extension=mysqli
+extension=mysqli
;extension=odbc
-;extension=openssl
+extension=openssl
;extension=pdo_firebird
-;extension=pdo_mysql
+extension=pdo_mysql
;extension=pdo_odbc
;extension=pdo_pgsql
;extension=pdo_sqlite
;extension=pgsql
;extension=shmop
```

#### `realpath_cache_size`
Set this option to at least 5 megabytes (`5M`) at line 351:
```diff
; Determines the size of the realpath cache to be used by PHP. This value should
; be increased on systems where PHP opens many files to reflect the quantity of
; the file operations performed.
; Note: if open_basedir is set, the cache is disabled
; https://php.net/realpath-cache-size
-realpath_cache_size = 4096k
+realpath_cache_size = 5M
```

# Environment variables
The `.env` file is meant to be committed into the repository, and only holds dummy values.

To override these values, create a `.env.local` file containing these items:
```env
DATABASE_URL="mysql://USERNAME:PASSWORD@127.0.0.1:3306/DATABASE_NAME?serverVersion=11.4.9-MariaDB&charset=utf8mb4"
```

Remember to change `USERNAME`, `PASSWORD` and `DATABASE_NAME`.

The app will override any values in `.env` if they are defined in `.env.local`.
