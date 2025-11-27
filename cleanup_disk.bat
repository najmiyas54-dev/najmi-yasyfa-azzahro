@echo off
echo Membersihkan disk space untuk Laravel...

echo 1. Membersihkan cache Laravel...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo 2. Membersihkan log files...
del /q storage\logs\*.log 2>nul
echo. > storage\logs\laravel.log

echo 3. Membersihkan temporary files...
del /q /s %TEMP%\* 2>nul

echo 4. Membersihkan session files...
del /q storage\framework\sessions\* 2>nul

echo 5. Membersihkan compiled views...
del /q storage\framework\views\* 2>nul

echo Selesai! Disk space telah dibersihkan.
pause