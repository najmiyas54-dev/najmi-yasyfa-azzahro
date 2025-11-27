@echo off
echo Membersihkan file-file orphan...
php artisan cleanup:orphan-files
echo Selesai!
pause