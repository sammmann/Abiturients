# Список абитуриентов - мое первое PHP приложение

Здесь я изучаю PHP и PDO.

## Краткое описание задания

Сделать сайт для регистрации абитуриентов, состоящий из 2х страниц: список зарегистрированных абитуриентов (главная страница) и форма ввода/редактирования информации о себе. Любой абитуриент может зайти на сайт и добавить себя в список или отредактировать информацию о себе.

Форма содержит поля: имя, фамилия, пол, номер группы, e-mail, суммарное число баллов на ЕГЭ, год рождения, местный или иногородний. После регистрации сайт должен запомнить пользователя и вместо формы регистрации показывать форму редактирования своих данных.

Список абитуриентов — выводит имя, фамилию, номер группы, число баллов. Сортировка по любому полю делается кликом на заголовок колонки таблицы (по умолчанию по числу баллов вниз). Есть поле поиска.

## Особенности реализации

1. возможность просматривать полный список абитуриентов, включающий
имя, фамилию, группу, баллы, фотографию (если не загружена отображается картинка
  по умолчанию)
2. возможность сортировать список по полям: имя, фамилия, группа, баллы
(при этом подсвечивается сортируемое поле)
3. возможность изменять порядок сортировки
(при этом изменяется указатель порядка в виде треугольника)
4. возможность осуществлять поиск либо по 1 слову, либо по 2
5. поиск осуществлятеся по полям имени и фамилии (оригинальное задание предполагало поиск и по группе - не реализовано)
6. результаты поиска посвечиваются (красным - 1 слово, синим - 2) в частях слов
7. возможность сортировать результаты поиска
8. возможность регестрироваться и редактировать информацию о себе, включая
загрузку фотографии на сервер
9. валидация формы на правильность введенных данных, независимо от html5 валидации
10. сохранение в базу данных и в куки пользователя пароля

## Использованные технологии

1. ООП, реализованное в PHP 5
2. PDO
3. шаблон TableDataGateway
4. возможности html5 и css3
5. принципы PHP шаблонизации и MVC

## Требования

1. Web server Apache
2. PHP 5.6
3. MySQL
