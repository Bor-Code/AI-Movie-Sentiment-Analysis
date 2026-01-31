@echo off
title AI Film Elestirmeni Baslatiliyor...
color 0A

echo ==========================================
echo   YAPAY ZEKA VE WEB SITESI BASLATILIYOR
echo ==========================================

start "Yapay Zeka Beyni (Python)" cmd /k "cd SentimentAI\src && python -m uvicorn api:app --reload"

timeout /t 5 /nobreak >nul

start "Web Sitesi (Laravel)" cmd /k "cd SentimentWeb && php artisan serve --port=8001"

timeout /t 3 /nobreak >nul
start http://127.0.0.1:8001

echo.
echo Sistem hazir! Keyfini cikar...
echo Kapatmak icin acilan siyah pencereleri kapatabilirsin.
pause