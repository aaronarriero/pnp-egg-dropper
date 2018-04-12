@echo off
:START
cls
call ./vendor/bin/phpunit

set hora=%TIME:~0,2%:%TIME:~3,2%:%TIME:~6,2%
echo.
echo Test realizado a las %hora%.

set R=y
set /p R=Repetir el proceso? [Y/n]:
IF /I %R%==y GOTO START
exit
