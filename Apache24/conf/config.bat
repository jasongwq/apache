cd ..
set rootPath=%cd%
cd %~dp0

@echo off 
setlocal enabledelayedexpansion 

rem -----------------------------------------------------替换
set file=%rootPath%\conf\httpd.conf
set "file=%file:"=%" 
for %%i in ("%file%") do set file=%%~fi 
echo. 
set replaced=c:/Apache24
echo. 
set all=%rootPath%
for /f "delims=" %%i in ('type "%file%"') do ( 
    set str=%%i 
    set "str=!str:%replaced%=%all%!" 
    echo !str!>>"%file%"_tmp.txt 
) 
copy "%file%" "%file%"_bak.txt >nul 2>nul 
move "%file%"_tmp.txt "%file%" 

rem -----------------------------------------------------替换

set file=%rootPath%\conf\httpd.conf
set "file=%file:"=%" 
for %%i in ("%file%") do set file=%%~fi 
echo. 
set replaced=#Include conf/extra/httpd-vhosts.conf
echo. 
set all=Include conf/extra/httpd-vhosts.conf
for /f "delims=" %%i in ('type "%file%"') do ( 
    set str=%%i 
    set "str=!str:%replaced%=%all%!" 
    echo !str!>>"%file%"_tmp.txt 
) 
copy "%file%" "%file%"_bak.txt >nul 2>nul 
move "%file%"_tmp.txt "%file%" 
rem -----------------------------------------------------替换