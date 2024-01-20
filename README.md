# Учет книг в приложении на базе Yii2
## Описание
Веб-приложение учёта и администрации книг. Был выбран шаблон yii basic, так как приложение является небольшим. Помимо ТЗ был реализован минимально необходимый для бизнес-логики функционал.
## Использование
Вход в аккаунт Администратора
- username: admin, password: admin

Вход в аккаунт Менеджера
- username: manager, password: manager
## Реализованный функционал

1. **Авторизация**
   - Функции Авторизации выполняет SiteController

2. **Иерархия ролей**
   - Каждый сотрудник компании является моделью таблицы user. Таблица position содержит роли.
   - RBAC был выбран как стабильная и легко расширяемая система ролей
   
3. **Взаимодействие с книгами**
   - Реализованы функции добавления, удаления, выдачи и возврата книг. Действия проходят через BookController
   - Для безопасности все операции проходят через формы, они содержат методы для валидации по базе данных. Формы находятся в app/models/forms
   - Выдачи и возвраты представлены отдельными таблицами в базе данных
   - Автор удаляется после удаления всех его книг
   - Страница "Список книг"
   - Генерация артикула реализована на основе названия книги, состоит из 30 символов. Используется как видимый пользователю идентификатор
   - Страница информации о книге с выводом всех операций с ней
   
4. **Взаимодействие с сотрудниками**
   - Для взаимодействия с сотрудниками используется ManagerController
   - Роль Менеджер имеет доступ к просмотру и добавлению сотрудников
   - В контроллере предусмотрена функция SetRole() для расширения контроллера, например функция повышения сотрудника
   - При удалении сотрудника в записях book_return и book_issue устанавливается NULL в employee_id. NULL будет обрабатываться как "Удаленный сотрудник"
   
5. **Администрирование клиентов**
   - Добавление клиента происходит автоматически с первой выдачи книги
   - Идентификация пользователей происходит по паспорту для избежания совпадений ФИО
   - Предусмотрен метод getBooks() для получения выданных пользователю книг (при этом не возвращенных)
   - Реализована страница "Клиенты"
   
6. **Учёт операций**
   - Реализована страница "История действий"
   - Отображение реализовано через модель BookOperation. Её структура позволяет собирать данные как с записи выдачи книги, так и возврата.
   - Предусмотрена потенциальное расширение операций благодаря полю operationType
   
7. **AJAX фильтрация**
   - Фильтры на страницах "Список книг", "Клиенты" реализованы с помощью AJAX
   - После обработки контроллеры отправляют ответ renderAjax. Таблицы книг и клиентов реализованы в отдельных файлах _books.php и _client.php
   - Страница после получения ответа обновляет содержимое тега таблицы и пагинацию
   
8. **Прочие AJAX взаимодействия**
   - Используется для удаления книг
   - Используется для формы выдачи книги для поля passport в случае если такой уже зарегистрирован (Отключение поля ФИО)
   
##Описание ролей##
1. **Administrator**
   - Администратор сервиса. Имеет доступ ко всем взаимодействиям с книгами
   
2. **Manager**
   - Наследует права Администратора
   - Имеет доступ ко всем взаимодействиям с сотрудниками
