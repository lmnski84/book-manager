## Запуск и инициализация

в корне проекта<br>
`docker compose up -d`<br>
`docker compose exec php composer install`<br>
`docker compose exec php php yii migrate --interactive=0`<br>

<br>

**Postman коллекция находится в корне проекта**

Настроена с переменными в контексте коллекции(Url, query params и body json)<br>
запуск ручками или через runner.


## Rest api

*   **Тип:** Bearer JWT Token
*   **Где указывать:** В заголовке `Authorization`
*   **Пример:** `Authorization: Bearer YOUR_API_KEY`

- компонент авторизации с простейшей реализацией JwtHttpBearerAuth extends AuthMethod
- реализовано на базе либы firebase/php-jwt без refresh-токена
- токен в бд не сохраняется
- в payload id и login
- время действия в минутах в конфиге компонента

### URL
### `http://127.0.0.1:8000`


### Endpoints

### `POST /users`
*   **Описание:** Регистрация пользователя
*   **Тело запроса (JSON):**
```json
{
  "login": "User_1",
  "email": "email@email.com",
  "password": "123456"
}
```

### `POST /auth/login`
*   **Описание:** Получение токена
*   **Тело запроса (JSON):**
```json
{
  "login": "User_1",
  "password": "123456"
}
```
*   **Тело ответа (JSON):**
```json
{
  "id": "User_1",
  "token": "qweJqSw123eqwdsdsapdas..."
}
```
### `GET /users/{id}` <small>`Authorization: Bearer YOUR_API_KEY`</small>
*   **Описание:** Просмотр информации конкретного пользователя
*   **Параметры:**
    *   `id`: Идентификатор пользователя

### `POST /books` <small>`Authorization: Bearer YOUR_API_KEY`</small>
*   **Описание:** Создание книги
*   **Тело запроса (JSON):**
```json
{
  "title": "Наименование книги"
}
```
### `PUT /books{id}` <small>`Authorization: Bearer YOUR_API_KEY`</small>
*   **Описание:** Изменение книги
*   **Параметры:**
* `id`: Идентификатор книги 
* **Тело запроса (JSON):**
```json
{
  "title": "Наименование книги"
}
```

### `DELETE /books/{id}` <small>`Authorization: Bearer YOUR_API_KEY`</small>
*   **Описание:** Удаление книги
*   **Параметры:**
*   `id`: Идентификатор книги

### `GET /books`
*   **Описание:** Просмотр всех книг с возможностью сортировки и пагинации
*   **Параметры:**
*   `per-page`: Количество на страницу
*   `page`: Номер страницы
*   `sort`: Поле сортировки (со знаком минус в обратном порядке)


### `GET /books/{id}`
*   **Описание:** Просмотр информации книге
*   **Параметры:**
    *   `id`: Идентификатор книги