# Простой пример формы, работающей на php + javascript
[ссылка на скрипт загрузки](src/cli/download-post.php)

Приложение использует composer и psr-4.

Установка зависимостей
``composer install``

Подключение к бд настраивается через [файл настроек](src/.env) Sql файл создания БД находится
в директории [sql](sql)

Поддерживаются селениум тесты: для их работы, нужно установить зависимости. 
Самый быстрый способ
```
npm install selenium-standalone -g
selenium-standalone install
selenium-standalone start &
```

