-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 13. čen 2018, 09:29
-- Verze serveru: 10.1.29-MariaDB
-- Verze PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `hrao01`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `activate_account`
--

CREATE TABLE `activate_account` (
  `aa_access_token` varchar(100) NOT NULL,
  `client_id` int(255) NOT NULL,
  `aa_request_start` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabulky `change_password`
--

CREATE TABLE `change_password` (
  `cp_access_token` varchar(20) NOT NULL,
  `client_id` int(255) NOT NULL,
  `new_password` varchar(255) NOT NULL,
  `cp_request_start` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabulky `client`
--

CREATE TABLE `client` (
  `client_id` int(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `client_password` varchar(255) DEFAULT NULL,
  `client_role` enum('admin','regular','teacher','pro') NOT NULL DEFAULT 'regular',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `facebook_id` int(100) DEFAULT NULL,
  `google_id` int(100) DEFAULT NULL,
  `twitter_id` int(100) DEFAULT NULL,
  `github_id` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `client`
--

INSERT INTO `client` (`client_id`, `client_name`, `client_email`, `client_password`, `client_role`, `active`, `facebook_id`, `google_id`, `twitter_id`, `github_id`) VALUES
(222, 'Oldřich Hradil', 'hradil.o@email.cz', '$2y$12$IjLooOPVGrArMtFRDJlHneQ8b4qbM2g1oun7dtfI204jcKF819cua', 'admin', 1, 2147483647, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `definition_czech`
--

CREATE TABLE `definition_czech` (
  `english_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `czech_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `czech_definition` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `definition_english`
--

CREATE TABLE `definition_english` (
  `english_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `english_definition` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `definition_german`
--

CREATE TABLE `definition_german` (
  `english_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `german_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `german_definition` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `definition_list`
--

CREATE TABLE `definition_list` (
  `list_id` int(11) NOT NULL,
  `definition_list_type` set('definition') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'definition'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `definition_list_content`
--

CREATE TABLE `definition_list_content` (
  `list_id` int(11) NOT NULL,
  `english_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `definition_practice`
--

CREATE TABLE `definition_practice` (
  `practice_id` int(11) NOT NULL,
  `practice_type` set('definition') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'definition'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `definition_russian`
--

CREATE TABLE `definition_russian` (
  `english_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `russian_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `russian_definition` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `definition_slovak`
--

CREATE TABLE `definition_slovak` (
  `english_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slovak_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slovak_definition` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `definition_spanish`
--

CREATE TABLE `definition_spanish` (
  `english_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `spanish_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `spanish_definition` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `grammar_practice`
--

CREATE TABLE `grammar_practice` (
  `practice_id` int(11) NOT NULL,
  `practice_type` set('grammar') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'grammar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `has_list`
--

CREATE TABLE `has_list` (
  `list_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `has_practice`
--

CREATE TABLE `has_practice` (
  `client_id` int(11) NOT NULL,
  `practice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `list`
--

CREATE TABLE `list` (
  `list_id` int(11) NOT NULL,
  `list_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `list_public` tinyint(1) DEFAULT '0',
  `list_type` set('vocabulary','definition') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `practice`
--

CREATE TABLE `practice` (
  `practice_id` int(11) NOT NULL,
  `practice_type` set('vocabulary','definition','grammar') COLLATE utf8_unicode_ci NOT NULL,
  `practice_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `practice_public` tinyint(1) DEFAULT '0',
  `success_rate` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `remember_me`
--

CREATE TABLE `remember_me` (
  `rm_access_token` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `client_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `vocabulary_czech`
--

CREATE TABLE `vocabulary_czech` (
  `english_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `czech_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `czech_part_of_speech` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `czech_explanation` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `czech_examples` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `vocabulary_english`
--

CREATE TABLE `vocabulary_english` (
  `english_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` set('word','phrase') COLLATE utf8_unicode_ci DEFAULT 'word',
  `topic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `part_of_speech` set('noun','verb','pronoun','adjective','adverb','preposition','conjuction','interjection') COLLATE utf8_unicode_ci DEFAULT NULL,
  `english_pronounciation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `english_explanation` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `english_examples` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `english_synonyms` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_name` set('CAE') COLLATE utf8_unicode_ci DEFAULT NULL,
  `grammar_category` set('irregular verbs','phrasal verbs') COLLATE utf8_unicode_ci DEFAULT NULL,
  `english_counting` set('countable','uncountable') COLLATE utf8_unicode_ci DEFAULT NULL,
  `frequency` double DEFAULT NULL,
  `origin` set('original','user added') COLLATE utf8_unicode_ci DEFAULT 'original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `vocabulary_german`
--

CREATE TABLE `vocabulary_german` (
  `english_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `german_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `german_part_of_speech` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `german_explanation` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `german_examples` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `vocabulary_list`
--

CREATE TABLE `vocabulary_list` (
  `list_id` int(11) NOT NULL,
  `list_type` set('vocabulary_list') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'vocabulary_list',
  `first_language` set('czech','english','german','russian','slovak') COLLATE utf8_unicode_ci DEFAULT 'czech',
  `second_language` set('czech','english','german','russian','slovak') COLLATE utf8_unicode_ci DEFAULT 'english'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `vocabulary_list_content`
--

CREATE TABLE `vocabulary_list_content` (
  `list_id` int(11) NOT NULL,
  `english_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `vocabulary_practice`
--

CREATE TABLE `vocabulary_practice` (
  `practice_id` int(11) DEFAULT NULL,
  `practice_type` set('vocabulary') COLLATE utf8_unicode_ci DEFAULT 'vocabulary'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `vocabulary_russian`
--

CREATE TABLE `vocabulary_russian` (
  `english_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `russian_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `russian_part_of_speech` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `russian_explanation` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `russian_examples` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `vocabulary_slovak`
--

CREATE TABLE `vocabulary_slovak` (
  `english_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slovak_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slovak_part_of_speech` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slovak_explanation` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slovak_examples` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `vocabulary_spanish`
--

CREATE TABLE `vocabulary_spanish` (
  `english_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `spanish_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `spanish_part_of_speech` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spanish_explanation` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spanish_examples` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `activate_account`
--
ALTER TABLE `activate_account`
  ADD PRIMARY KEY (`aa_access_token`),
  ADD KEY `id` (`client_id`);

--
-- Klíče pro tabulku `change_password`
--
ALTER TABLE `change_password`
  ADD PRIMARY KEY (`cp_access_token`),
  ADD KEY `id` (`client_id`);

--
-- Klíče pro tabulku `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`) USING BTREE,
  ADD UNIQUE KEY `name` (`client_name`);

--
-- Klíče pro tabulku `definition_czech`
--
ALTER TABLE `definition_czech`
  ADD PRIMARY KEY (`english_term`,`czech_term`);

--
-- Klíče pro tabulku `definition_english`
--
ALTER TABLE `definition_english`
  ADD PRIMARY KEY (`english_term`);

--
-- Klíče pro tabulku `definition_german`
--
ALTER TABLE `definition_german`
  ADD PRIMARY KEY (`english_term`,`german_term`);

--
-- Klíče pro tabulku `definition_list`
--
ALTER TABLE `definition_list`
  ADD PRIMARY KEY (`list_id`,`definition_list_type`);

--
-- Klíče pro tabulku `definition_list_content`
--
ALTER TABLE `definition_list_content`
  ADD PRIMARY KEY (`list_id`,`english_term`),
  ADD KEY `definition_list_content_definition_english_term_fk` (`english_term`);

--
-- Klíče pro tabulku `definition_practice`
--
ALTER TABLE `definition_practice`
  ADD PRIMARY KEY (`practice_id`,`practice_type`);

--
-- Klíče pro tabulku `definition_russian`
--
ALTER TABLE `definition_russian`
  ADD PRIMARY KEY (`english_term`,`russian_term`);

--
-- Klíče pro tabulku `definition_slovak`
--
ALTER TABLE `definition_slovak`
  ADD PRIMARY KEY (`english_term`,`slovak_term`);

--
-- Klíče pro tabulku `definition_spanish`
--
ALTER TABLE `definition_spanish`
  ADD PRIMARY KEY (`english_term`,`spanish_term`);

--
-- Klíče pro tabulku `grammar_practice`
--
ALTER TABLE `grammar_practice`
  ADD PRIMARY KEY (`practice_id`,`practice_type`);

--
-- Klíče pro tabulku `has_list`
--
ALTER TABLE `has_list`
  ADD PRIMARY KEY (`list_id`,`client_id`),
  ADD KEY `has_list_client_client_id_fk` (`client_id`);

--
-- Klíče pro tabulku `has_practice`
--
ALTER TABLE `has_practice`
  ADD PRIMARY KEY (`client_id`,`practice_id`),
  ADD KEY `has_practice_practice_practice_id_fk` (`practice_id`);

--
-- Klíče pro tabulku `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`list_id`,`list_type`),
  ADD KEY `list_list_id_index` (`list_id`);

--
-- Klíče pro tabulku `practice`
--
ALTER TABLE `practice`
  ADD PRIMARY KEY (`practice_id`,`practice_type`);

--
-- Klíče pro tabulku `remember_me`
--
ALTER TABLE `remember_me`
  ADD PRIMARY KEY (`rm_access_token`(4)),
  ADD KEY `CLIENT_ID` (`client_id`);

--
-- Klíče pro tabulku `vocabulary_czech`
--
ALTER TABLE `vocabulary_czech`
  ADD PRIMARY KEY (`english_value`,`czech_value`);

--
-- Klíče pro tabulku `vocabulary_english`
--
ALTER TABLE `vocabulary_english`
  ADD PRIMARY KEY (`english_value`);

--
-- Klíče pro tabulku `vocabulary_german`
--
ALTER TABLE `vocabulary_german`
  ADD PRIMARY KEY (`english_value`,`german_value`);

--
-- Klíče pro tabulku `vocabulary_list`
--
ALTER TABLE `vocabulary_list`
  ADD PRIMARY KEY (`list_id`,`list_type`);

--
-- Klíče pro tabulku `vocabulary_list_content`
--
ALTER TABLE `vocabulary_list_content`
  ADD PRIMARY KEY (`list_id`,`english_value`),
  ADD KEY `vocabulary_list_content_vocabulary_english_english_value_fk` (`english_value`);

--
-- Klíče pro tabulku `vocabulary_practice`
--
ALTER TABLE `vocabulary_practice`
  ADD KEY `vocabulary_practice_practice_practice_id_practice_type_fk` (`practice_id`,`practice_type`);

--
-- Klíče pro tabulku `vocabulary_russian`
--
ALTER TABLE `vocabulary_russian`
  ADD PRIMARY KEY (`english_value`,`russian_value`);

--
-- Klíče pro tabulku `vocabulary_slovak`
--
ALTER TABLE `vocabulary_slovak`
  ADD PRIMARY KEY (`english_value`,`slovak_value`);

--
-- Klíče pro tabulku `vocabulary_spanish`
--
ALTER TABLE `vocabulary_spanish`
  ADD PRIMARY KEY (`english_value`,`spanish_value`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT pro tabulku `list`
--
ALTER TABLE `list`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `practice`
--
ALTER TABLE `practice`
  MODIFY `practice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `activate_account`
--
ALTER TABLE `activate_account`
  ADD CONSTRAINT `activate_account_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `change_password`
--
ALTER TABLE `change_password`
  ADD CONSTRAINT `change_password_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `definition_czech`
--
ALTER TABLE `definition_czech`
  ADD CONSTRAINT `definition_czech_definition_english_english_term_fk` FOREIGN KEY (`english_term`) REFERENCES `definition_english` (`english_term`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `definition_german`
--
ALTER TABLE `definition_german`
  ADD CONSTRAINT `definition_german_definition_english_english_term_fk` FOREIGN KEY (`english_term`) REFERENCES `definition_english` (`english_term`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `definition_list`
--
ALTER TABLE `definition_list`
  ADD CONSTRAINT `definition_list_list_list_id_list_type_fk` FOREIGN KEY (`list_id`,`definition_list_type`) REFERENCES `list` (`list_id`, `list_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `definition_list_content`
--
ALTER TABLE `definition_list_content`
  ADD CONSTRAINT `definition_list_content_definition_english_term_fk` FOREIGN KEY (`english_term`) REFERENCES `definition_english` (`english_term`) ON UPDATE CASCADE,
  ADD CONSTRAINT `definition_list_content_definition_list_list_id_fk` FOREIGN KEY (`list_id`) REFERENCES `definition_list` (`list_id`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `definition_practice`
--
ALTER TABLE `definition_practice`
  ADD CONSTRAINT `definition_practice_practice_practice_id_practice_type_fk` FOREIGN KEY (`practice_id`,`practice_type`) REFERENCES `practice` (`practice_id`, `practice_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `definition_russian`
--
ALTER TABLE `definition_russian`
  ADD CONSTRAINT `definition_russian_definition_english_english_term_fk` FOREIGN KEY (`english_term`) REFERENCES `definition_english` (`english_term`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `definition_slovak`
--
ALTER TABLE `definition_slovak`
  ADD CONSTRAINT `definition_slovak_definition_english_english_term_fk` FOREIGN KEY (`english_term`) REFERENCES `definition_english` (`english_term`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `definition_spanish`
--
ALTER TABLE `definition_spanish`
  ADD CONSTRAINT `definition_spanish_definition_english_english_term_fk` FOREIGN KEY (`english_term`) REFERENCES `definition_english` (`english_term`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `grammar_practice`
--
ALTER TABLE `grammar_practice`
  ADD CONSTRAINT `grammar_practice_practice_practice_id_practice_type_fk` FOREIGN KEY (`practice_id`,`practice_type`) REFERENCES `practice` (`practice_id`, `practice_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `has_list`
--
ALTER TABLE `has_list`
  ADD CONSTRAINT `has_list_client_client_id_fk` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `has_list_list_list_id_fk` FOREIGN KEY (`list_id`) REFERENCES `list` (`list_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `has_practice`
--
ALTER TABLE `has_practice`
  ADD CONSTRAINT `has_practice_client_client_id_fk` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `has_practice_practice_practice_id_fk` FOREIGN KEY (`practice_id`) REFERENCES `practice` (`practice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `remember_me`
--
ALTER TABLE `remember_me`
  ADD CONSTRAINT `remember_me_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vocabulary_czech`
--
ALTER TABLE `vocabulary_czech`
  ADD CONSTRAINT `vocabulary_czech_vocabulary_english_english_value_fk` FOREIGN KEY (`english_value`) REFERENCES `vocabulary_english` (`english_value`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vocabulary_german`
--
ALTER TABLE `vocabulary_german`
  ADD CONSTRAINT `vocabulary_german_vocabulary_english_english_value_fk` FOREIGN KEY (`english_value`) REFERENCES `vocabulary_english` (`english_value`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vocabulary_list`
--
ALTER TABLE `vocabulary_list`
  ADD CONSTRAINT `vocabulary_list_list_list_id_list_type_fk` FOREIGN KEY (`list_id`,`list_type`) REFERENCES `list` (`list_id`, `list_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vocabulary_list_content`
--
ALTER TABLE `vocabulary_list_content`
  ADD CONSTRAINT `vocabulary_list_content_vocabulary_english_english_value_fk` FOREIGN KEY (`english_value`) REFERENCES `vocabulary_english` (`english_value`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vocabulary_list_content_vocabulary_list_list_id_fk` FOREIGN KEY (`list_id`) REFERENCES `vocabulary_list` (`list_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vocabulary_practice`
--
ALTER TABLE `vocabulary_practice`
  ADD CONSTRAINT `vocabulary_practice_practice_practice_id_practice_type_fk` FOREIGN KEY (`practice_id`,`practice_type`) REFERENCES `practice` (`practice_id`, `practice_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vocabulary_russian`
--
ALTER TABLE `vocabulary_russian`
  ADD CONSTRAINT `vocabulary_russian_vocabulary_english_english_value_fk` FOREIGN KEY (`english_value`) REFERENCES `vocabulary_english` (`english_value`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vocabulary_slovak`
--
ALTER TABLE `vocabulary_slovak`
  ADD CONSTRAINT `vocabulary_slovak_vocabulary_english_english_value_fk` FOREIGN KEY (`english_value`) REFERENCES `vocabulary_english` (`english_value`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vocabulary_spanish`
--
ALTER TABLE `vocabulary_spanish`
  ADD CONSTRAINT `vocabulary_spanish_vocabulary_english_english_value_fk` FOREIGN KEY (`english_value`) REFERENCES `vocabulary_english` (`english_value`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
