# password-manager

## Детали реализации
1. Шифрование полей таблицы с данными пользователей, хранение мастер-ключа в секретах Symfony
2. Генерацию надёжного пароля для хранимого аккаунта, если пользователь не указал пароль
3. Проверка уникальности логина при регистрации
4. Проверка уникальности названия аккаунта для каждого пользователя
5. Проверка уникальности названия типа аккаунта для каждого пользователя
6. Проверка прав доступа к ресурсу по id сущности
7. Добавил ApiPlatform
8. Генерация токена и обновление данных пользователя по логину и паролю
9. Доступ к остальным контроллерам по токену
10. Не успел написать все необходимые тесты для негативных сценариев, пометил в коде todo 
