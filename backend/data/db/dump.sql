SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Структура таблицы `user`
--

CREATE TABLE `user`
(
    `id`         int(10) UNSIGNED                          NOT NULL,
    `login`      varchar(32) COLLATE utf8mb4_unicode_ci    NOT NULL,
    `password`   char(60) COLLATE utf8mb4_unicode_ci       NOT NULL,
    `is_deleted` enum ('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
    `title`      varchar(80) COLLATE utf8mb4_unicode_ci    NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_has_user_role`
--

CREATE TABLE `user_has_user_role`
(
    `id`           int(10) UNSIGNED NOT NULL,
    `user_id`      int(10) UNSIGNED NOT NULL,
    `user_role_id` int(10) UNSIGNED NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_role`
--

CREATE TABLE `user_role`
(
    `id`        int(10) UNSIGNED                              NOT NULL,
    `parent_id` int(10) UNSIGNED DEFAULT NULL,
    `title`     varchar(80) COLLATE utf8mb4_unicode_ci        NOT NULL,
    `type`      enum ('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_role`
--

INSERT INTO `user_role` (`id`, `parent_id`, `title`, `type`)
VALUES (1, NULL, 'Гость', '1'),
       (2, 1, 'Авторизованный', '2'),
       (3, 2, 'Админ', '3');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_has_user_role`
--
ALTER TABLE `user_has_user_role`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `user_id` (`user_id`, `user_role_id`),
    ADD KEY `user_role_id` (`user_role_id`);

--
-- Индексы таблицы `user_role`
--
ALTER TABLE `user_role`
    ADD PRIMARY KEY (`id`),
    ADD KEY `parent_id` (`parent_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;

--
-- AUTO_INCREMENT для таблицы `user_has_user_role`
--
ALTER TABLE `user_has_user_role`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;

--
-- AUTO_INCREMENT для таблицы `user_role`
--
ALTER TABLE `user_role`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `user_has_user_role`
--
ALTER TABLE `user_has_user_role`
    ADD CONSTRAINT `user_has_user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `user_has_user_role_ibfk_2` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_role`
--
ALTER TABLE `user_role`
    ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;