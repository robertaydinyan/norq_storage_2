-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 01 2021 г., 08:59
-- Версия сервера: 5.5.68-MariaDB
-- Версия PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `fastnet`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('acceptPayment', '1', 1617111727),
('acceptPayment', '12', 1617113765),
('acceptPayment', '20', 1617112477),
('acceptPayment', '24', 1617112927),
('admin', '1', 1617111721),
('admin', '20', 1617112443),
('changePayment', '1', 1617111727),
('changePayment', '12', 1617113518),
('changePayment', '20', 1617112477),
('createDeal', '1', 1617111727),
('createDeal', '12', 1617113518),
('createDeal', '20', 1617112477),
('createDeal', '24', 1617112927),
('deleteDeal', '1', 1617111727),
('deleteDeal', '12', 1617113518),
('deleteDeal', '20', 1617112477),
('manager', '12', 1617113388),
('operator', '10', 1617111811),
('operator', '24', 1617112873),
('updateDeal', '1', 1617111727),
('updateDeal', '12', 1617113518),
('updateDeal', '20', 1617112477),
('updateDeal', '24', 1617112927),
('viewDeal', '1', 1617111727),
('viewDeal', '12', 1617113518),
('viewDeal', '20', 1617112477),
('viewDeal', '24', 1617113061),
('viewPayment', '1', 1617111727),
('viewPayment', '10', 1617111815),
('viewPayment', '12', 1617113518),
('viewPayment', '20', 1617112477),
('viewPayment', '24', 1617112935);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/billing/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-broadcast-language/*', 2, NULL, NULL, NULL, 1617113578, 1617113578),
('/billing/channel-broadcast-language/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-broadcast-language/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-broadcast-language/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-broadcast-language/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-broadcast-language/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-category/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-category/create', 2, NULL, NULL, NULL, 1617113568, 1617113568),
('/billing/channel-category/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-category/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-category/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-category/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-quality/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-quality/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-quality/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-quality/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-quality/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/channel-quality/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/cities/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/cities/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/cities/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/cities/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/cities/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/cities/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/client/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/client/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/client/page', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/client/update-search', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/client/update-table', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/client/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/community/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/community/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/community/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/community/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/community/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/community/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-channel-broadcast-language', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-channel-category', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-channel-quality', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-company-scope', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-company-type', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-crm-status', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-currency', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-deal-type', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-internet', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-tv-channel', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-tv-packet', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/config-units', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/countries', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/countries-list', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/configs/remove-ip', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/default/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/default/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/internet/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/internet/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/internet/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/internet/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/internet/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/internet/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/ip-addresses/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/ip-addresses/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/ip-addresses/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/ip-addresses/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/ip-addresses/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/ip-addresses/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/payment/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/payment/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/payment/page', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/payment/pay', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/payment/update-search', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/payment/update-table', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/payment/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/get-cities-by-region', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/get-regions-by-country', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/get-service-tariffs', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/page', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/switch-view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/update-search', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/update-table', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/services/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/share/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/share/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/share/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/share/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/share/page', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/share/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/share/update-search', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/share/update-table', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/share/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/staff/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/staff/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/staff/page', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/staff/update-search', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/staff/update-table', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/get-internet-type', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/get-tariff-type-price', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/get-tariffs-by-ids', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/get-tariffs-html-by-ids', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/page', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/switch-view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/update-search', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/update-table', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tariff/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-channel/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-channel/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-channel/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-channel/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-channel/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-channel/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet-channel/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet-channel/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet-channel/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet-channel/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet-channel/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet-channel/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/tv-packet/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/units/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/units/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/units/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/units/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/units/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/billing/units/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/crm/cashier/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/cashier/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/cashier/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/cashier/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/cashier/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/cashier/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-scope/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-scope/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-scope/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-scope/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-scope/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-scope/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-type/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-type/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-type/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-type/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-type/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company-type/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/add-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/create-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/delete-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/delete-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/get-cities-by-region', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/get-regions-by-country', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/remove-address', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/remove-id-card', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/remove-passport-image', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/switch-crm-partial', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/update-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/update-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/company/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/add-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/comment', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/create-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/delete-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/delete-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/get-cities-by-region', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/get-regions-by-country', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/remove-address', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/remove-contact', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/remove-email', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/remove-id-card', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/remove-passport-image', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/show-more-comments', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/switch-crm-partial', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/switch-log-type', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/update-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/update-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/contact/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/crm-status/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/crm-status/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/crm-status/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/crm-status/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/crm-status/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/crm-status/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/currency/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/currency/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/currency/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/currency/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/currency/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/currency/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal-type/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal-type/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal-type/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal-type/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal-type/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal-type/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/add-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/add-status', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/add-vacation', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/ajax-create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/calendar', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/calendar-list', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/create-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/delete-deals', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/delete-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/delete-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/get-address-list', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/get-products-by-type', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/get-service-tariffs', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/get-services', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/get-stages-by-menu', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/get-tariff-info', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/get-tariff-info-by-share', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/kanban', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/maintenance', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/page', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/remove-connect', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/remove-file', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/terminate-deal', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/update-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/update-ordering', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/update-params', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/update-search', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/update-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/update-status', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/update-table', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/deal/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/default/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/default/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-company/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-company/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-company/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-company/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-company/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-company/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-contact/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-contact/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-contact/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-contact/get-regions-by-country', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-contact/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-contact/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/fast-contact/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/*', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/add-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/add-status', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/ajax-create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/calendar', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/calendar-list', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/create-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/delete', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/delete-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/delete-leads', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/delete-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/kanban', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/update', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/update-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/update-ordering', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/update-params', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/update-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/update-status', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/lead/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/product/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/crm/product/add-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/product/create', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/product/create-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/product/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/crm/product/delete-field', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/crm/product/delete-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/product/index', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/product/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/crm/product/update-field', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/product/update-section', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/product/view', 2, NULL, NULL, NULL, 1617111876, 1617111876),
('/crm/user/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/crm/user/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/crm/user/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/crm/user/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/crm/user/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/crm/user/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/debug/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/debug/default/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/debug/default/db-explain', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/debug/default/download-mail', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/debug/default/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/debug/default/toolbar', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/debug/default/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/debug/user/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/debug/user/reset-identity', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/debug/user/set-identity', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/base-station/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/base-station/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/base-station/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/base-station/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/base-station/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/base-station/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/contacts/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/contacts/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/contacts/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/contacts/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/contacts/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/contacts/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/data/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/data/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/data/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/data/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/data/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/data/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/change-wrong-paid-deal', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/check-payment-received-status', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/get-selected-deal-info', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/get-selected-deal-payment-info', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/get-selected-deal-total-sum', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/payment-change', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/revert-cashier', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/search-deal', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/set-paid-selected-items', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/total-paid', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-payment-log/wrong-payment-change', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-sale/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-sale/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-sale/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-sale/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-sale/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal-sale/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/add-disruption', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/add-vacation', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/connect-price', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/end-vacation', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/get-cities-by-region', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/get-deals-by-city', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/get-ips', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/get-regions-by-country', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/get-services', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/get-streets-by-city', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/get-total-price', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/index', 2, NULL, NULL, NULL, 1617114417, 1617114417),
('/fastnet/deal/pay', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/deal/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/default/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/default/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/disabled-day/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/disabled-day/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/disabled-day/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/pay/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/pay/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/pay/payment', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/tariff/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/tariff/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/tariff/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/tariff/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/tariff/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/tariff/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/zone/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/zone/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/zone/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/zone/get-cities-by-regions', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/zone/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/zone/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/fastnet/zone/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/gii/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/gii/default/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/gii/default/action', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/gii/default/diff', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/gii/default/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/gii/default/preview', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/gii/default/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/default/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/default/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/default/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/default/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/default/read', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/default/test', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/default/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/default/upload', 2, NULL, NULL, NULL, 1617113463, 1617113463),
('/hr/default/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/departments/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/departments/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/departments/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/departments/positions', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-departments/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-departments/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-departments/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-departments/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-departments/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-departments/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-actions-rules/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-actions-rules/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-actions-rules/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-actions-rules/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-actions-rules/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-actions-rules/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-modules/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-modules/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-modules/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-modules/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-modules/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions-modules/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-permissions/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-contracts/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-contracts/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-contracts/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-contracts/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-contracts/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-contracts/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-statuses/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-statuses/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-statuses/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-statuses/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-statuses/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons-statuses/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-persons/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-positions/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-positions/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-positions/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-positions/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-positions/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-positions/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions-levels/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions-levels/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions-levels/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions-levels/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions-levels/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions-levels/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-professions/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-roles/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-roles/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-roles/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-roles/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-roles/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-roles/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-skills/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-skills/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-skills/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-skills/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-skills/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-class-skills/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions-roles/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions-roles/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions-roles/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions-roles/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions-roles/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions-roles/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-departments-positions/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-contracts/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-contracts/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-contracts/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-contracts/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-contracts/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-contracts/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-departments-positions-roles/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-departments-positions-roles/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-departments-positions-roles/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-departments-positions-roles/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-departments-positions-roles/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-persons-departments-positions-roles/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions-skills-levels/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions-skills-levels/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions-skills-levels/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions-skills-levels/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions-skills-levels/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions-skills-levels/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-positions-professions/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-roles-permissions-actions-rules-modules/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-roles-permissions-actions-rules-modules/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-roles-permissions-actions-rules-modules/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-roles-permissions-actions-rules-modules/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-roles-permissions-actions-rules-modules/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/hr-object-roles-permissions-actions-rules-modules/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/persons/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/persons/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/persons/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/positions/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/positions/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/positions/department-positions', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/positions/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/roles/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/roles/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/roles/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/test/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/test/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/test/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/test/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/test/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/hr/test/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/message/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/message/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/message/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/message/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/message/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/site/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/site/about', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/site/captcha', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/site/contact', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/site/error', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/site/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/site/login', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/site/logout', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/default/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/default/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/*', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/add-checkpoint', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/add-from-popup', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/add-from-task', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/all-tasks', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/create', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/create-checklist', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/create-tag', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/create-tag-rel', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/delete', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/index', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/kanban', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/one-task', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/person-to-checklist', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/persons', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/task-tracking', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/update', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/update-rate', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/update-task', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/update-task-from-popup', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('/task/tasks/view', 2, NULL, NULL, NULL, 1617111877, 1617111877),
('acceptPayment', 2, 'Վճարի ընդունում', NULL, NULL, 1617111650, 1617111650),
('admin', 1, NULL, 'userGroup', NULL, 1617111650, 1617111650),
('changePayment', 2, 'Վճարի փոփոխում', NULL, NULL, 1617111650, 1617111650),
('createDeal', 2, 'Ստեղծել գործարք', NULL, NULL, 1617111650, 1617111650),
('deleteDeal', 2, 'Ջնջել գործարք', NULL, NULL, 1617111650, 1617111650),
('guest', 1, NULL, 'userGroup', NULL, 1617111650, 1617111650),
('manager', 1, NULL, 'userGroup', NULL, 1617111650, 1617111650),
('operator', 1, NULL, 'userGroup', NULL, 1617111650, 1617111650),
('terminal', 1, NULL, 'userGroup', NULL, 1617111650, 1617111650),
('updateDeal', 2, 'Թարմացնել գործարք', NULL, NULL, 1617111650, 1617111650),
('viewDeal', 2, 'Տեսնել գործարք', NULL, NULL, 1617111650, 1617111650),
('viewPayment', 2, 'Տեսնել վճարում', NULL, NULL, 1617111650, 1617111650);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('acceptPayment', '/*'),
('admin', 'createDeal'),
('admin', 'deleteDeal'),
('admin', 'manager'),
('admin', 'operator'),
('admin', 'terminal'),
('admin', 'updateDeal'),
('admin', 'viewDeal'),
('changePayment', '/*');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('userGroup', 0x4f3a32323a226170705c726261635c5573657247726f757052756c65223a333a7b733a343a226e616d65223b733a393a227573657247726f7570223b733a393a22637265617465644174223b693a313631373131313635303b733a393a22757064617465644174223b693a313631373131313635303b7d, 1617111650, 1617111650);

-- --------------------------------------------------------

--
-- Структура таблицы `base_stations_ip`
--

CREATE TABLE IF NOT EXISTS `base_stations_ip` (
  `id` int(11) NOT NULL,
  `deal_number` varchar(255) DEFAULT NULL,
  `ip_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `base_stations_ip`
--

INSERT INTO `base_stations_ip` (`id`, `deal_number`, `ip_id`) VALUES
(1, '124135', 3760),
(3, '124160', 3762),
(4, '124162', 3763),
(5, '124164', 3764),
(6, '124165', 3765),
(7, '124167', 3766),
(8, '124168', 3767),
(9, '124170', 3768),
(10, '124172', 3769),
(11, '124194', 3770),
(12, '124196', 3771),
(13, '124199', 3772),
(14, '124205', 3773),
(15, '124206', 3774),
(17, '124210', 3859),
(19, '124212', 3860),
(21, '124213', 3861),
(22, '124149', 1613),
(23, '124151', 1614),
(24, '124197', 1615),
(25, '124159', 3761),
(38, '123245', 9083);

-- --------------------------------------------------------

--
-- Структура таблицы `b_share`
--

CREATE TABLE IF NOT EXISTS `b_share` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `is_personal` smallint(1) DEFAULT '0',
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `b_share_lang`
--

CREATE TABLE IF NOT EXISTS `b_share_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `b_share_tariff_config`
--

CREATE TABLE IF NOT EXISTS `b_share_tariff_config` (
  `share_id` int(11) NOT NULL DEFAULT '0',
  `tariff_id` int(11) NOT NULL DEFAULT '0',
  `share_type` smallint(1) DEFAULT NULL COMMENT '0 => tv-ip-internet, 1 => price, 2 => free month',
  `internet_id` int(11) DEFAULT NULL,
  `tv_packet_id` int(11) DEFAULT NULL,
  `ip_address_count` int(11) DEFAULT NULL,
  `share_price_type` smallint(1) DEFAULT NULL COMMENT '0 => %, 1 => price',
  `share_price_value` decimal(10,2) DEFAULT NULL,
  `free_month` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `b_share_user_config`
--

CREATE TABLE IF NOT EXISTS `b_share_user_config` (
  `share_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `channel_broadcast_language`
--

CREATE TABLE IF NOT EXISTS `channel_broadcast_language` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `channel_category`
--

CREATE TABLE IF NOT EXISTS `channel_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `channel_category_lang`
--

CREATE TABLE IF NOT EXISTS `channel_category_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `channel_id_broadcast_id`
--

CREATE TABLE IF NOT EXISTS `channel_id_broadcast_id` (
  `id` int(11) NOT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `broadcast_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `channel_quality`
--

CREATE TABLE IF NOT EXISTS `channel_quality` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `channel_quality_lang`
--

CREATE TABLE IF NOT EXISTS `channel_quality_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `checklist`
--

CREATE TABLE IF NOT EXISTS `checklist` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `checkpoints`
--

CREATE TABLE IF NOT EXISTS `checkpoints` (
  `id` int(11) NOT NULL,
  `context` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `important` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `checklist_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `checkpoint_person`
--

CREATE TABLE IF NOT EXISTS `checkpoint_person` (
  `id` int(11) NOT NULL,
  `point_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `city_type` varchar(255) DEFAULT NULL,
  `city_type_id` int(11) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `name`, `city_type`, `city_type_id`, `lat`, `lng`, `region_id`) VALUES
(1, 'Երևան', 'քաղաք', 1, '40.19615844142135', '44.50760987304675', 1),
(2, 'Գյումրի', 'քաղաք', 1, '40.785266', '43.841774', 2),
(3, 'Սարատակ', 'գյուղ', 3, '40.669826', '43.870134', 2),
(4, 'Մալիշկա', 'գյուղ', 3, '39.739288', '45.391', 3),
(5, 'Ավշար', 'գյուղ', 3, '39.8555', '44.676983', 4),
(6, 'Քանաքեռավան', 'գյուղ', 3, '40.247201', '44.532094', 5),
(7, 'Լուսակերտ', 'գյուղ', 3, '40.671372', '43.856327', 2),
(8, 'Հովտաշեն', 'գյուղ', 3, '40.667713', '43.892763', 2),
(9, 'Սուրենավան', 'գյուղ', 3, '39.797935', '44.775573', 4),
(10, 'Տափերական', 'գյուղ', 3, '39.924014', '44.595182', 4),
(11, 'Պարույր Սևակ', 'գյուղ', 3, '39.769367', '44.915522', 4),
(12, 'Զանգակատուն', 'գյուղ', 3, '39.822509', '45.042265', 4),
(13, 'Կոտայք', 'գյուղ', 3, '40.278327', '44.661316', 5),
(14, 'Գառնի', 'գյուղ', 3, '40.124709', '44.729543', 5),
(15, 'Նիզամի', 'գյուղ', 3, '40.090275', '44.403689', 4),
(16, 'Նորամարգ', 'գյուղ', 3, '40.024484', '44.4217', 4),
(17, 'Սայաթ Նովա', 'գյուղ', 3, '40.073011', '44.397598', 4),
(18, 'Այնթափ', 'գյուղ', 3, '40.096533', '44.464235', 4),
(19, 'Մասիս', 'քաղաք', 1, '40.061988', '44.442981', 4),
(20, 'Վեդի', 'քաղաք', 1, '39.91395', '44.721081', 4),
(21, 'Արարատ', 'քաղաք', 1, '39.855396', '44.694734', 4),
(22, 'Եղեգնաձոր', 'քաղաք', 1, '39.764008', '45.333238', 3),
(23, 'Արին', 'գյուղ', 3, '39.776056', '45.463467', 3),
(24, 'Արտաշատ', 'քաղաք', 1, '39.956438', '44.545497', 4),
(25, 'Հովտաշեն', 'գյուղ', 3, '40.099817', '44.341849', 4),
(26, 'Սիս', 'գյուղ', 3, '40.058758', '44.384707', 4),
(27, 'Սիփանիկ', 'գյուղ', 3, '40.082071', '44.358153', 4),
(28, 'Ռանչպար', 'գյուղ', 3, '40.029132', '44.368241', 4),
(29, 'Մրգավետ', 'գյուղ', 3, '40.031473', '44.478734', 4),
(30, 'Մարմարաշեն', 'գյուղ', 3, '40.059842', '44.469975', 4),
(31, 'Նոր Խարբերդ', 'գյուղ', 3, '40.089247', '44.477252', 4),
(32, 'Արբաթ', 'գյուղ', 3, '40.13832', '44.403293', 4),
(33, 'Արթիկ', 'քաղաք', 1, '40.619869', '43.970763', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `cities_lang`
--

CREATE TABLE IF NOT EXISTS `cities_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `city_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cities_lang`
--

INSERT INTO `cities_lang` (`id`, `parent_id`, `language`, `name`, `city_type`) VALUES
(1, 1, 'hy', 'Երևան', NULL),
(2, 2, 'hy', 'Գյումրի', NULL),
(3, 3, 'hy', 'Սարատակ', NULL),
(4, 4, 'hy', 'Մալիշկա', NULL),
(5, 5, 'hy', 'Ավշար', NULL),
(6, 6, 'hy', 'Քանաքեռավան', NULL),
(7, 7, 'hy', 'Լուսակերտ', NULL),
(8, 8, 'hy', 'Հովտաշեն', NULL),
(9, 9, 'hy', 'Սուրենավան', NULL),
(10, 10, 'hy', 'Տափերական', NULL),
(11, 11, 'hy', 'Պարույր Սևակ', NULL),
(12, 12, 'hy', 'Զանգակատուն', NULL),
(13, 13, 'hy', 'Կոտայք', NULL),
(14, 14, 'hy', 'Գառնի', NULL),
(15, 15, 'hy', 'Նիզամի', NULL),
(16, 16, 'hy', 'Նորամարգ', NULL),
(17, 17, 'hy', 'Սայաթ Նովա', NULL),
(18, 18, 'hy', 'Այնթափ', NULL),
(19, 19, 'hy', 'Մասիս', NULL),
(20, 20, 'hy', 'Վեդի', NULL),
(21, 21, 'hy', 'Արարատ', NULL),
(22, 22, 'hy', 'Եղեգնաձոր', NULL),
(23, 23, 'hy', 'Արին', NULL),
(24, 24, 'hy', 'Արտաշատ', NULL),
(25, 25, 'hy', 'Հովտաշեն', NULL),
(26, 26, 'hy', 'Սիս', NULL),
(27, 27, 'hy', 'Սիփանիկ', NULL),
(28, 28, 'hy', 'Ռանչպար', NULL),
(29, 29, 'hy', 'Մրգավետ', NULL),
(30, 30, 'hy', 'Մարմարաշեն', NULL),
(31, 31, 'hy', 'Նոր Խարբերդ', NULL),
(32, 32, 'hy', 'Արբաթ', NULL),
(33, 33, 'hy', 'Արթիկ', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `company_document`
--

CREATE TABLE IF NOT EXISTS `company_document` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `company_scope`
--

CREATE TABLE IF NOT EXISTS `company_scope` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `company_scope_lang`
--

CREATE TABLE IF NOT EXISTS `company_scope_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `company_type`
--

CREATE TABLE IF NOT EXISTS `company_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `company_type_lang`
--

CREATE TABLE IF NOT EXISTS `company_type_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `contact_adress`
--

CREATE TABLE IF NOT EXISTS `contact_adress` (
  `id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `community_id` int(11) DEFAULT NULL,
  `street` int(11) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `housing` varchar(255) DEFAULT NULL,
  `apartment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contact_adress`
--

INSERT INTO `contact_adress` (`id`, `contact_id`, `company_id`, `country_id`, `region_id`, `city_id`, `community_id`, `street`, `house`, `housing`, `apartment`) VALUES
(1, 1, NULL, 1, 2, 33, 25, 28, '9', '', '2'),
(2, 2, NULL, 1, 2, 33, 25, 28, '13', '', '2'),
(3, 3, NULL, 1, 2, 33, 25, 28, '20', '', '4'),
(4, 4, NULL, 1, 2, 33, 25, 28, '26', '', '1'),
(5, 5, NULL, 1, 2, 33, 25, 28, '4', '', '1'),
(6, 6, NULL, 1, 2, 33, 25, 28, '22', '', '1'),
(7, 7, NULL, 1, 2, 33, 25, 28, '20', '', '2'),
(8, 8, NULL, 1, 2, 33, 25, 28, '20', '', '6'),
(9, 9, NULL, 1, 2, 33, 25, 28, '22', '', '2'),
(10, 10, NULL, 1, 2, 33, 25, 34, '24', '', '1'),
(11, 11, NULL, 1, 2, 33, 25, 28, '28', '', '5'),
(12, 12, NULL, 1, 2, 33, 25, 28, '24', '', '10'),
(13, 13, NULL, 1, 2, 33, 25, 28, '10', '', '3'),
(14, 14, NULL, 1, 2, 33, 25, 28, '26', '', '3'),
(15, 15, NULL, 1, 2, 33, 25, 28, '26', '', '8'),
(17, 17, NULL, 1, 2, 33, 25, 28, '32', '', '4'),
(18, 18, NULL, 1, 2, 33, 25, 28, '32', '', '12'),
(19, 19, NULL, 1, 2, 33, 25, 28, '32', '', '7'),
(20, 20, NULL, 1, 3, 4, 26, 25, '', '', '44'),
(21, 21, NULL, 1, 3, 4, 26, 16, '', '', '77'),
(22, 22, NULL, 1, 3, 4, 26, 16, '', '', '35'),
(23, 23, NULL, 1, 1, 1, 3, 35, '25', '', '65');

-- --------------------------------------------------------

--
-- Структура таблицы `contact_company`
--

CREATE TABLE IF NOT EXISTS `contact_company` (
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `contact_email`
--

CREATE TABLE IF NOT EXISTS `contact_email` (
  `contact_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email_type_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `is_mailing` int(11) DEFAULT '0',
  `is_notification` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`) VALUES
(1, 'Հայաստան', 'AM');

-- --------------------------------------------------------

--
-- Структура таблицы `countries_lang`
--

CREATE TABLE IF NOT EXISTS `countries_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `countries_lang`
--

INSERT INTO `countries_lang` (`id`, `parent_id`, `language`, `name`) VALUES
(1, 1, 'hy', 'Հայաստան');

-- --------------------------------------------------------

--
-- Структура таблицы `crm_cash_register_receipt`
--

CREATE TABLE IF NOT EXISTS `crm_cash_register_receipt` (
  `id` int(11) NOT NULL,
  `payment_log_id` int(11) DEFAULT NULL,
  `cashier_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_comments`
--

CREATE TABLE IF NOT EXISTS `crm_comments` (
  `id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `crm_type` int(11) DEFAULT '1',
  `comment` text NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_company`
--

CREATE TABLE IF NOT EXISTS `crm_company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `company_type_id` int(11) DEFAULT NULL,
  `company_scope_id` int(11) DEFAULT NULL,
  `annual_turnover` decimal(10,2) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `is_provider` smallint(6) DEFAULT NULL COMMENT '0, 1',
  `passport_number` varchar(255) DEFAULT NULL,
  `visible_by` varchar(255) DEFAULT NULL COMMENT 'Кем виден',
  `when_visible` datetime DEFAULT NULL COMMENT 'Когда виден',
  `valid_until` datetime DEFAULT NULL COMMENT 'Действителен до',
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_contact`
--

CREATE TABLE IF NOT EXISTS `crm_contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `passport_number` varchar(255) DEFAULT NULL,
  `visible_by` varchar(255) DEFAULT NULL COMMENT 'Кем виден',
  `when_visible` datetime DEFAULT NULL COMMENT 'Когда виден',
  `valid_until` datetime DEFAULT NULL COMMENT 'Действителен до',
  `is_provider` smallint(6) DEFAULT NULL COMMENT '0, 1',
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `crm_contact`
--

INSERT INTO `crm_contact` (`id`, `name`, `username`, `create_at`, `update_at`, `surname`, `middle_name`, `image`, `dob`, `responsible_id`, `passport_number`, `visible_by`, `when_visible`, `valid_until`, `is_provider`, `phone`, `email`) VALUES
(1, 'Գոռ', NULL, '2021-03-31 17:18:18', '2021-03-31 17:18:18', 'Ղազարյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(2, 'Արտակ', NULL, '2021-03-31 17:33:09', '2021-03-31 17:33:09', 'Դասոյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(3, 'Արգամ', NULL, '2021-03-31 17:40:50', '2021-03-31 17:40:50', 'Աշխատոյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(4, 'Լադիկ', NULL, '2021-03-31 17:45:36', '2021-03-31 17:45:36', 'Մուրադյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(5, 'Մկրտիչ', NULL, '2021-03-31 17:48:32', '2021-03-31 17:48:32', 'Գրիգորյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(6, 'Մարատ', NULL, '2021-03-31 17:50:52', '2021-03-31 17:50:52', 'Մալխասյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(7, 'Արման', NULL, '2021-03-31 17:53:03', '2021-03-31 17:53:03', 'Աշխատոյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(8, 'Գագիկ', NULL, '2021-03-31 18:01:03', '2021-03-31 18:01:03', 'Պարոյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(9, 'Սեդա', NULL, '2021-03-31 18:04:16', '2021-03-31 18:04:16', 'Չիչակյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(10, 'Արսեն', NULL, '2021-03-31 18:06:19', '2021-03-31 18:06:19', 'Դավթյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(11, 'Մանուկ', NULL, '2021-03-31 18:08:47', '2021-03-31 18:08:47', 'Մուրադյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(12, 'Ռազմիկ', NULL, '2021-03-31 18:11:35', '2021-03-31 18:11:35', 'Բաղրամյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(13, 'Մխիթար', NULL, '2021-03-31 18:13:58', '2021-03-31 18:13:58', 'Մխիթարյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(14, 'Ազգուշ', NULL, '2021-03-31 18:15:56', '2021-03-31 18:15:56', 'Օհանյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(15, 'Էլեն', NULL, '2021-03-31 18:34:10', '2021-03-31 18:34:10', 'Վարդանյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(16, 'Մանվել', NULL, '2021-03-31 18:39:09', '2021-03-31 18:39:09', 'Գևորգյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(17, 'Հերմինե', NULL, '2021-03-31 18:49:35', '2021-03-31 18:49:35', 'Կարապետյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(18, 'Համլետ', NULL, '2021-03-31 18:51:48', '2021-03-31 18:51:48', 'Գևորգյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(19, 'Նինա', NULL, '2021-03-31 18:57:49', '2021-03-31 18:57:49', 'Խաչատրյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(20, 'Արման ', NULL, '2021-03-31 19:03:56', '2021-03-31 19:03:56', 'Սարգսյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(21, 'Լիլիթ', NULL, '2021-03-31 19:06:42', '2021-03-31 19:06:42', 'Միխայելով', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(22, 'Հրաչյա', NULL, '2021-03-31 19:09:49', '2021-03-31 19:09:49', 'Խաչատրյան', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, ''),
(23, 'Աշոտ', NULL, '2021-05-27 16:04:41', '2021-05-27 16:04:41', 'Խաչատրյան', '', NULL, '2021-04-26', NULL, '', '016', '2021-06-06 00:00:00', '2021-06-24 00:00:00', NULL, NULL, 'ashot@fastnet.am');

-- --------------------------------------------------------

--
-- Структура таблицы `crm_contact_passport`
--

CREATE TABLE IF NOT EXISTS `crm_contact_passport` (
  `id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_contact_phone`
--

CREATE TABLE IF NOT EXISTS `crm_contact_phone` (
  `contact_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `phone_type_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `is_mailing` int(11) DEFAULT '0',
  `is_notification` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `crm_contact_phone`
--

INSERT INTO `crm_contact_phone` (`contact_id`, `company_id`, `phone`, `phone_type_id`, `id`, `is_mailing`, `is_notification`) VALUES
(1, NULL, '', NULL, 1, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `crm_custom_fields`
--

CREATE TABLE IF NOT EXISTS `crm_custom_fields` (
  `id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `field_type_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `status` smallint(2) DEFAULT NULL,
  `required` smallint(1) DEFAULT '0' COMMENT '0 => not required, 1 => required'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_custom_fields_lang`
--

CREATE TABLE IF NOT EXISTS `crm_custom_fields_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_custom_list`
--

CREATE TABLE IF NOT EXISTS `crm_custom_list` (
  `id` int(11) NOT NULL,
  `custom_field_id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_custom_list_lang`
--

CREATE TABLE IF NOT EXISTS `crm_custom_list_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_deal`
--

CREATE TABLE IF NOT EXISTS `crm_deal` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `ordering` int(11) DEFAULT '-1',
  `amount` decimal(10,2) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `deal_type_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `date_finish` date DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `tariff_id` int(11) DEFAULT NULL,
  `start_deal` int(11) DEFAULT '1',
  `share_id` int(11) DEFAULT NULL,
  `work_price` int(11) DEFAULT NULL,
  `deal_end_status` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_deal_file`
--

CREATE TABLE IF NOT EXISTS `crm_deal_file` (
  `id` int(11) NOT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_deal_vacation`
--

CREATE TABLE IF NOT EXISTS `crm_deal_vacation` (
  `id` int(11) NOT NULL,
  `deal_number` varchar(255) DEFAULT NULL,
  `vacation_type_id` int(11) DEFAULT NULL,
  `comment` text,
  `data_start` datetime DEFAULT NULL,
  `data_end` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_field_type`
--

CREATE TABLE IF NOT EXISTS `crm_field_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_field_value`
--

CREATE TABLE IF NOT EXISTS `crm_field_value` (
  `id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `column_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_lead`
--

CREATE TABLE IF NOT EXISTS `crm_lead` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `ordering` int(11) DEFAULT '-1',
  `amount` decimal(10,2) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_menu`
--

CREATE TABLE IF NOT EXISTS `crm_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_phone_type`
--

CREATE TABLE IF NOT EXISTS `crm_phone_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `for_what` smallint(1) DEFAULT NULL COMMENT '0=>phone; mail => 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_phone_type_lang`
--

CREATE TABLE IF NOT EXISTS `crm_phone_type_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_product`
--

CREATE TABLE IF NOT EXISTS `crm_product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `eq_or_sup` smallint(1) DEFAULT NULL,
  `base_amount` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `count` float DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `month_base_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_section`
--

CREATE TABLE IF NOT EXISTS `crm_section` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_section_lang`
--

CREATE TABLE IF NOT EXISTS `crm_section_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_status`
--

CREATE TABLE IF NOT EXISTS `crm_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `ordering` int(11) DEFAULT '-1',
  `color` text,
  `type_id` int(11) DEFAULT NULL,
  `status_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_status_lang`
--

CREATE TABLE IF NOT EXISTS `crm_status_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cron`
--

CREATE TABLE IF NOT EXISTS `cron` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `symbol` varchar(60) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `name`, `symbol`) VALUES
(81, 'armen', 'hy'),
(82, 'armen', 'hy'),
(83, 'armen', 'hy'),
(84, 'armen', 'hy'),
(85, 'armen', 'hy');

-- --------------------------------------------------------

--
-- Структура таблицы `currency_lang`
--

CREATE TABLE IF NOT EXISTS `currency_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `deal_address`
--

CREATE TABLE IF NOT EXISTS `deal_address` (
  `id` int(11) NOT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `deal_address`
--

INSERT INTO `deal_address` (`id`, `deal_id`, `address_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9),
(10, 10, 10),
(11, 11, 11),
(12, 12, 12),
(13, 13, 13),
(14, 14, 14),
(15, 15, 15),
(16, 16, 16),
(17, 17, 17),
(18, 18, 18),
(19, 19, 19),
(20, 20, 20),
(21, 21, 21),
(22, 22, 22),
(24, 66, 23);

-- --------------------------------------------------------

--
-- Структура таблицы `deal_conect`
--

CREATE TABLE IF NOT EXISTS `deal_conect` (
  `id` int(11) NOT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `installer_id` int(11) DEFAULT NULL,
  `eq_type` smallint(2) DEFAULT NULL COMMENT '1 => Локальное оборудование аренда, 2 => расходные материалы, 3 => Локальное оборудование(продажа), 4 => сетевое оборудование',
  `product_id` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `mac_address` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `basis` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_unit_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `deal_ip`
--

CREATE TABLE IF NOT EXISTS `deal_ip` (
  `id` int(11) NOT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `ip_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `deal_payment_log`
--

CREATE TABLE IF NOT EXISTS `deal_payment_log` (
  `id` int(11) NOT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `operator_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `payment_type` smallint(1) DEFAULT '1',
  `receipt` varchar(255) DEFAULT NULL,
  `pay_date` varchar(255) DEFAULT NULL,
  `hdm` smallint(6) DEFAULT '0' COMMENT '0 => HDM che, 1 => HDM',
  `comment` text COMMENT 'Cashier change history',
  `payer` int(11) DEFAULT NULL COMMENT 'Վճարում ընդունող օպերատոր'
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `deal_payment_log`
--

INSERT INTO `deal_payment_log` (`id`, `deal_id`, `price`, `create_at`, `update_at`, `operator_id`, `status`, `payment_type`, `receipt`, `pay_date`, `hdm`, `comment`, `payer`) VALUES
(1, 1, '3500.00', '2021-03-10 17:25:22', '2021-03-10 17:29:31', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(2, 2, '7000.00', '2021-03-18 17:36:12', '2021-03-18 17:38:23', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(3, 3, '2300.00', '2021-03-18 17:41:11', '2021-03-18 17:41:25', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(4, 4, '2300.00', '2021-03-18 17:45:59', '2021-03-18 17:47:07', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(5, 5, '2300.00', '2021-03-18 17:48:53', '2021-03-18 17:49:05', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(6, 6, '2300.00', '2021-03-18 17:51:12', '2021-03-18 17:51:23', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(7, 7, '2100.00', '2021-03-19 17:53:30', '2021-03-19 18:01:51', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(8, 8, '2100.00', '2021-03-19 18:01:36', '2021-03-19 18:01:54', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(9, 9, '2100.00', '2021-03-19 18:04:31', '2021-03-19 18:04:37', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(10, 10, '2100.00', '2021-03-19 18:06:34', '2021-03-19 18:06:40', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(11, 11, '1500.00', '2021-03-23 18:09:27', '2021-03-23 18:09:33', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(12, 12, '1500.00', '2021-03-23 18:11:52', '2021-03-23 18:11:59', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(13, 13, '1500.00', '2021-03-23 18:14:23', '2021-03-23 18:14:30', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(14, 14, '1500.00', '2021-03-23 18:16:12', '2021-03-23 18:16:26', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(15, 15, '1500.00', '2021-03-23 18:34:29', '2021-03-23 18:35:29', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(17, 17, '1300.00', '2021-03-24 18:49:48', '2021-03-24 18:49:56', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(18, 18, '1300.00', '2021-03-24 18:52:07', '2021-03-24 18:52:24', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(19, 19, '1300.00', '2021-03-24 18:58:06', '2021-03-24 18:58:18', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(20, 20, '2600.00', '2021-03-16 19:04:51', '2021-03-16 19:04:59', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(21, 21, '3000.00', '2021-03-16 19:07:04', '2021-03-16 19:07:15', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(22, 22, '1400.00', '2021-03-23 19:10:20', '2021-03-23 19:10:26', 9, 0, 1, NULL, NULL, 0, NULL, 1),
(23, 24, '100.00', '2021-04-06 17:57:12', NULL, 3, 0, 3, '1146140979', '2021-04-06 17:57:12', 1, NULL, NULL),
(24, 24, '258.00', '2021-04-07 11:41:22', NULL, 3, 0, 3, '1222923148', '2021-04-07 11:41:22', 1, NULL, NULL),
(25, 24, '142.00', '2021-04-07 11:53:49', NULL, 3, 0, 3, '1326811651', '2021-04-07 11:53:49', 1, NULL, NULL),
(26, 24, '100.00', '2021-04-07 13:13:59', NULL, 4, 0, 2, '243965024', '2021-04-07 13:13:59', 0, NULL, NULL),
(27, 23, '5000.00', '2021-04-15 17:26:39', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(28, 41, '5000.00', '2021-04-22 09:57:58', NULL, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(29, 42, '5000.00', '2021-04-22 09:59:15', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(30, 24, '5000.00', '2021-04-22 10:00:25', '2021-04-22 11:52:49', 1, 0, 1, NULL, NULL, 0, NULL, 1),
(31, 25, '5000.00', '2021-04-22 10:05:53', '2021-04-22 11:52:34', 10, 0, 1, NULL, NULL, 0, NULL, 1),
(32, 26, '5000.00', '2021-04-22 11:58:58', NULL, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(33, 27, '5000.00', '2021-04-22 12:00:10', NULL, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(34, 28, '5000.00', '2021-04-22 12:01:23', NULL, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(35, 29, '5000.00', '2021-04-22 12:02:12', NULL, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(36, 30, '5000.00', '2021-04-22 12:03:58', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(37, 31, '5000.00', '2021-04-22 12:05:13', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(38, 32, '5000.00', '2021-04-22 12:05:51', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(39, 33, '5000.00', '2021-04-22 12:06:26', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(40, 34, '5000.00', '2021-04-22 12:07:02', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(41, 43, '5000.00', '2021-04-22 12:07:48', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(42, 35, '5000.00', '2021-04-22 12:08:26', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(43, 36, '5000.00', '2021-04-22 12:09:18', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(44, 37, '5000.00', '2021-04-22 12:10:00', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(45, 38, '5000.00', '2021-04-22 12:10:41', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(46, 39, '5000.00', '2021-04-22 12:11:20', NULL, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(47, 40, '5000.00', '2021-04-22 12:12:02', NULL, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(48, 46, '5000.00', '2021-05-03 17:16:37', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(49, 59, '5000.00', '2021-05-06 11:51:53', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(50, 60, '5000.00', '2021-05-06 11:52:37', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(51, 44, '5000.00', '2021-05-07 19:36:32', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(52, 52, '5000.00', '2021-05-07 19:37:33', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(53, 61, '5000.00', '2021-05-07 19:39:25', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(54, 47, '5000.00', '2021-05-12 14:44:45', NULL, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(55, 49, '5000.00', '2021-05-12 14:45:58', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(56, 51, '5000.00', '2021-05-12 14:46:32', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(57, 53, '5000.00', '2021-05-12 14:47:35', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(58, 54, '5000.00', '2021-05-12 14:48:19', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(59, 55, '5000.00', '2021-05-12 14:48:54', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(60, 57, '5000.00', '2021-05-12 14:49:39', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(61, 58, '5000.00', '2021-05-12 14:49:55', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(62, 64, '5000.00', '2021-05-12 14:52:15', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(63, 62, '4981.00', '2021-05-12 14:53:00', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(64, 63, '5000.00', '2021-05-18 12:39:34', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(65, 48, '5000.00', '2021-05-18 12:40:09', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(66, 56, '5000.00', '2021-05-18 12:40:51', NULL, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(68, 66, '161.00', '2021-05-31 17:13:16', '2021-05-31 17:13:16', 3, 0, 3, '1156370337', '2021-05-31 17:13:16', 0, NULL, 3),
(69, 66, '161.00', '2021-05-31 17:14:17', '2021-05-31 17:14:17', 3, 0, 3, '1156370337', '2021-05-31 17:14:17', 0, NULL, 3),
(70, 88, '100.00', '2021-06-01 12:19:50', '2021-06-01 12:19:50', 3, 0, 3, '1335072784', '2021-06-01 12:19:50', 0, NULL, 3),
(71, 88, '150.00', '2021-06-01 12:41:06', '2021-06-01 12:41:06', 3, 0, 3, '1335075824', '2021-06-01 12:41:06', 0, NULL, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `deal_payment_log_history`
--

CREATE TABLE IF NOT EXISTS `deal_payment_log_history` (
  `deal_payment_log_id` int(11) DEFAULT NULL,
  `previous_cashier_id` int(11) DEFAULT NULL,
  `current_cashier_id` int(11) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `deal_type`
--

CREATE TABLE IF NOT EXISTS `deal_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `deal_type_lang`
--

CREATE TABLE IF NOT EXISTS `deal_type_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `favorite_pinned`
--

CREATE TABLE IF NOT EXISTS `favorite_pinned` (
  `id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_antenna_ip`
--

CREATE TABLE IF NOT EXISTS `f_antenna_ip` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_base_station`
--

CREATE TABLE IF NOT EXISTS `f_base_station` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `ip_end` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_base_station`
--

INSERT INTO `f_base_station` (`id`, `name`, `ip`, `ip_end`) VALUES
(1, 'Աղայան 7', '10.51.192.22', '10.51.192.254'),
(2, 'Րաֆֆու 25', '10.51.169.2', '10.51.169.254'),
(3, 'Սարատակ', '10.51.39.2', '10.51.39.254'),
(4, 'Լուսակերտ', '10.51.177.2', '10.51.177.254'),
(5, 'Հովտաշեն Շիրակ', '10.51.206.2', '10.51.206.254'),
(6, 'Մալիշկա', '10.51.130.2', '10.51.130.254'),
(7, 'ք. Երևան, Բագրատունյաց պողոտա 39', '10.50.155.1', '10.50.155.254'),
(8, 'ք. Երևան, 2-րդ թաղամաս 34', '151.2.1', '151.2.256'),
(9, 'ք. Երևան, Աբելյան փողոց 6', '151.1.1', '151.1.3'),
(10, 'ք. Երևան, Աբովյան փողոց 33', '138.0.0.2', '138.0.0.9'),
(11, 'ք. Երևան, Աբովյան փողոց 46', '1.1', '1.2'),
(12, 'ք. Երևան, Ազատության պողոտա 24/7', '1.1', '1.2'),
(13, 'ք. Երևան, Ազատության պողոտա 7բ', '1.1', '1.2'),
(14, 'ք. Երևան, Ամիրյան փողոց 1', '1.1', '1.2'),
(15, 'ք. Երևան, Ամիրյան փողոց 15', '1.1', '1.2'),
(16, 'ք. Երևան, Ամիրյան փողոց 7/1', '1.1', '1.2'),
(17, 'ք. Երևան, Արաբկիր 21 փող. 2', '1.1', '1.2'),
(18, 'ք. Երևան, Արշակունյաց պողոտա 17ա', '1.1', '1.2'),
(19, 'ք. Երևան, Արշակունյաց պողոտա 50/1', '1.1', '1.2'),
(20, 'ք. Երևան, Արշակունյաց պողոտա 9', '1.1', '1.2'),
(21, 'ք. Երևան, Արտաշիսյան փողոց 61', '1.1', '1.2'),
(22, 'ք. Երևան, Բաղրամյան պողոտա 24 դ', '1.1', '1.2'),
(23, 'ք. Երևան, Բաղրամյան պողոտա 58 Կտուր', '1.1', '1.2'),
(24, 'ք. Երևան, Բաղրամյան պողոտա 85 Կտուր', '1.1', '1.2'),
(25, 'ք. Երևան, Բրյուսովի փողոց 19', '1.1', '1.2'),
(26, 'ք. Երևան, Գալշոյան փողոց 24', '1.1', '1.2'),
(27, 'ք. Երևան, Դրոյի փողոց 28', '1.1', '1.2'),
(28, 'ք. Երևան, Թբիլիսյան խճուղի 2', '1.1', '1.2'),
(29, 'ք. Երևան, Իսակովի 42/2, տարածք 45', '1.1', '1.2'),
(30, 'ք. Երևան, Լվովյան փողոց 19', '1.1', '1.2'),
(31, 'ք. Երևան, Կոմիտասի պողոտա 65', '1.1', '1.2'),
(32, 'ք. Երևան, Հանրապետության 24, գլխամաս', '1.1', '1.2'),
(33, 'ք. Երևան, Մամիկոնյանց փող. 27', '1.1', '1.2'),
(34, 'ք. Երևան, Մայիսի 9-ի փող. 13', '1.1', '1.2'),
(35, 'ք. Երևան, Մանանդյան փող. 13', '1.1', '1.2'),
(36, 'ք. Երևան, Մանանդյան փողոց 31/1', '1.1', '1.2'),
(37, 'ք. Երևան, Մարշալ Բաբաջանյան փող. 2/14', '1.1', '1.2'),
(38, 'ք. Երևան, Նալբանդյան փող. 7', '1.1', '1.2'),
(39, 'ք. Երևան, Նալբանդյան փող. 7 , 15', '1.1', '1.2'),
(40, 'ք. Երևան, Նալբանդյան փող. 7', '1.1', '1.2'),
(41, 'ք. Երևան, Նալբանդյան փող. 7', '1.1', '1.2'),
(42, 'ք. Երևան, Չեխովի փողոց 10', '1.1', '1.2'),
(43, 'ք. Երևան, Սարյան փողոց 20/1', '1.1', '1.2'),
(44, 'ք. Երևան, Սեբաստիա փող. 24/1', '1.1', '1.2'),
(45, 'ք. Երևան, Վահե Վահյան 12', '1.1', '1.2'),
(46, 'ք. Երևան, Վարդանանց փողոց 28', '1.1', '1.2'),
(47, 'ք. Երևան, Վիլնյուսի փողոց 3', '1.1', '1.2'),
(48, 'ք. Երևան, Տիտոգրադյան փող. 2', '1.1', '1.2'),
(49, 'ք. Երևան, Րաֆֆի փողոց 25, բն. 28', '1.1', '1.2'),
(50, 'ք. Երևան, Օրբելի Եղբայրների փողոց 14', '1.1', '1.2'),
(51, 'ք. Երևան, Այգեձորի 70', '1.1', '1.2'),
(52, 'ք. Երևան, Իսահակյան 22', '1.1', '1.2'),
(53, 'ք. Երևան, Եզնիկ Կողբացի 30', '1.1', '1.2'),
(54, 'ք. Երևան, Կորյուն 11/11', '1.1', '1.2'),
(55, 'ք. Երևան, Դրոյի 17/9', '1.1', '1.2'),
(56, 'ք. Երևան, Սայաթ-Նովա 40/1, բն.4', '1.1', '1.2'),
(57, 'ք. Երևան, Հ. Հակոբյան 3', '1.1', '1.2'),
(58, 'ք. Երևան, Հյուսիսային պող. 1', '1.1', '1.2'),
(59, 'ք. Երևան, Տիգրան Մեծի 36', '1.1', '1.2'),
(60, 'ք. Երևան, Կորյուն-Աբովյան գետնանցում', '1.1', '1.2'),
(61, 'ք. Երևան, Գ. Նժդեհի 27/2', '1.1', '1.2'),
(62, 'ք. Երևան, Քաջազնունի 20/1', '1.1', '1.2'),
(63, 'ք. Երևան, Բագրատունյաց 54', '1.1', '1.2'),
(64, 'ք. Երևան, Վաղարշյան 12ա', '1.1', '1.2'),
(65, 'ք. Երևան, Վիլնյուս 11', '1.1', '1.2'),
(66, 'ք. Երևան, Թբիլիսյան 33/2', '1.1', '1.2'),
(67, 'ք. Երևան, Իսահակյան 35, 2-րդ հարկ', '1.1', '1.2'),
(68, 'ք. Երևան, Թումանյան 34', '1.1', '1.2'),
(69, 'ք. Երևան, Սիլիկյան 7-րդ փող. տուն 4', '1.1', '1.2'),
(70, 'ք. Երևան, Ֆուչիկի 19', '1.1', '1.2'),
(71, 'ք. Երևան, Արշակունյաց 135', '1.1', '1.2'),
(72, 'ք. Երևան, Զաքյան 2', '1.1', '1.2'),
(73, 'ք. Երևան, Հյուսիսային պող. 10, տարածք 3/2', '1.1', '1.2'),
(74, 'ք. Երևան, Նալբանդյան 7, 15', '1.1', '1.2'),
(75, 'ք. Երևան, Ամիրյան 15', '1.1', '1.2'),
(76, 'ք. Երևան, Կիևյան 1ա', '1.1', '1.2'),
(77, 'ք. Երևան, 16 թաղ.շենք 19', '1.1', '1.2'),
(78, 'ք. Երևան, Վաղարշյան 17', '1.1', '1.2'),
(79, 'ք. Երևան, Նոր Նորքի 8զ, Մինսկի փ 2', '1.1', '1.2'),
(80, 'ք. Երևան, Սարյան 12, Զովք', '1.1', '1.2'),
(81, 'ք. Երևան, Խորենացու 45', '1.1', '1.2'),
(82, 'ք. Երևան, Կոմիտասի 9', '1.1', '1.2'),
(83, 'ք. Երևան, Նալբանդյան 7, 15', '1.1', '1.2'),
(84, 'ք. Երևան, Տիգրան Մեծի 4', '1.1', '1.2'),
(85, 'ք. Երևան, Տիչինայի 34', '1.1', '1.2'),
(86, 'ք. Երևան, Զ. Անդրանիկի 129/6', '1.1', '1.2'),
(87, 'ք. Երևան, Աղայան 7', '1.1', '1.2'),
(88, 'ք. Երևան, Ջրաշեն 1 փող., 85 տան մոտի Ucom-ի աշտարակ', '1.1', '1.2'),
(89, 'ք. Երևան, Գայի 19/76', '1.1', '1.2'),
(90, 'ք. Երևան, Դեմիրճյան 40/5', '1.1', '1.2'),
(91, 'ք. Երևան, Ն. Ստեփանյան 1/4', '1.1', '1.2'),
(92, 'ք. Երևան, Պռոշյան 2/2', '1.1', '1.2'),
(93, 'ք. Երևան, Մուրացան 113/1', '1.1', '1.2'),
(94, 'ք. Երևան, Մարգարյան 16/6', '1.1', '1.2'),
(95, 'ք. Երևան, Վաղարշյան 24/6', '1.1', '1.2'),
(96, 'ք. Երևան, Կոմիտասի պողոտա 42', '1.1', '1.2'),
(97, 'ք. Երևան, Պուշկին 42', '1.1', '1.2'),
(98, 'ք. Երևան, Ներսիսյան 10/5', '1.1', '1.2'),
(99, 'ք. Երևան, Քրիստափոր 2/2', '1.1', '1.2'),
(100, 'ք. Երևան, Ադոնց 2', '1.1', '1.2'),
(101, 'ք. Երևան, Տիգրան Մեծի 10/2', '1.1', '1.2'),
(102, 'ք. Երևան, Ամիրյան 5ա', '1.1', '1.2'),
(103, 'ք. Երևան, Կոմիտաս 55', '1.1', '1.2'),
(104, 'ք. Երևան, Բաղրամյան 49/2', '1.1', '1.2'),
(105, 'ք. Երևան, Նուբարաշեն 6-րդ փողոց, 1/2', '1.1', '1.2'),
(106, 'ք. Երևան, Նաիրի Զարյան 32/2', '1.1', '1.2'),
(107, 'ք. Երևան, Աբովյան 30', '1.1', '1.2'),
(108, 'ք. Երևան, Ֆուչիկի 30', '1.1', '1.2'),
(109, 'ք. Երևան, Աբովյան 50/5', '1.1', '1.2'),
(110, 'ք. Երևան, Ադոնց 8/2', '1.1', '1.2'),
(112, 'ք. Երևան, Ծերենց 82', '1.1', '1.2'),
(113, 'ք. Երևան, Արշակունյաց 15', '1.1', '1.2'),
(114, 'ք. Երևան, Թումանյան 41', '1.1', '1.2'),
(115, 'ք. Երևան, Սեբաստիա փող. 123', '1.1', '1.2'),
(117, 'ք. Երևան, Հրաչյա Քոչար 11', '1.1', '1.2'),
(118, 'ք. Երևան, Մանանդյան փող. 9/5', '1.1', '1.2'),
(119, 'ք. Երևան, Գարեգին Նժդեհի 44 տարածք 1', '1.1', '1.2'),
(120, 'ք. Երևան, Հրաչյա Քոչար տարածք 44/53', '1.1', '1.2'),
(121, 'ք. Երևան, Տիգրան Մեծի 15/1', '1.1', '1.2'),
(122, 'Երևան, Տիգրան Պետրոսյան տարածք փողոց 46/5', '1.1', '1.2'),
(123, 'Երևան, Չարենցի 5', '1.1', '1.2'),
(124, 'ք. Երևան, Մաշտոցի պողոտա 43/34', '1.1', '1.2'),
(125, 'ք. Երևան, Գարեգին Նժդեհ 19/1', '1.1', '1.2'),
(126, 'ք. Երևան, Մարգարյան 18/5', '1.1', '1.2'),
(127, 'ք. Երևան, Ռուբինյանց 2/8', '1.1', '1.2'),
(128, 'ք. Երևան, Ավետիս Ահարոնյան 24/1', '1.1', '1.2'),
(129, 'ք. Երևան, Աբովյան 52', '1.1', '1.2'),
(130, 'ք. Երևան, Հյուսիսային պողոտա 10, 3/2', '1.1', '1.2'),
(131, 'ք. Երևան, Խորենացու 15, Գլոբինգ', '1.1', '1.2'),
(132, 'ք. Երևան, Ազատության 24, 4', '1.1', '1.2'),
(133, 'ք․Երևան  Ագաթանգեղոսի փողոց, 6/1 ', '1.1', '1.2'),
(134, 'ք․ Երևան, Մաշտոցի պողոտա, 2/2,', '1.1', '1.2'),
(135, 'ք․ Երևան, Սմբատ Զորավարի  փողոց, 11/3', '1.1', '1.2'),
(136, 'ք․ Երևան, Արշակունյաց պողոտա, 17/8,', '1.1', '1.2'),
(137, 'ք. Երևան, Աջափնյակ, Լենինգրադյան փողոց, 52', '1.1', '1.2'),
(138, 'ք. Երևան, Կենտրոն, Աբովյան փողոց, 50/5,', '1.1', '1.2'),
(139, 'ք. Երևան, Ագաթանգեղոսի փողոց, 6/1', '1.1', '1.2'),
(140, 'ք. Երևան, Գետառի փողոց, 4/7', '1.1', '1.2'),
(141, 'ք. Երևան, Եկմալյան  փողոց, 5', '1.1', '1.2'),
(142, 'ք. Երևան, Իսահակյան փողոց, 44', '1.1', '1.2'),
(143, 'ք. Երևան, Նալբանդյան փողոց, 7', '1.1', '1.2'),
(144, 'ք. Երևան, Սիմեոն Վրացյանի  փողոց, 73', '1.1', '1.2'),
(145, 'ք. Երևան, Կուրղինյան փողոց, 11/2 տարածք', '1.1', '1.2'),
(146, 'ք. Երևան, Նորք 6րդ փողոց, տուն 20', '1.1', '1.2'),
(147, 'ք. Երևան, Մանանդյան փողոց, 33/18', '1.1', '1.2'),
(148, 'ք. Երևան, Սմբատ  Զորավարի   փողոց, 11/3', '1.1', '1.2'),
(149, 'ք. Երևան, Պարույր Սևակ, 92', '1.1', '1.2'),
(150, 'ք. Երևան, Զորավար Անդրանիկի 149/2', '1.1', '1.2'),
(151, 'Անիպեմզա', '172.28.6.2', '172.28.6.253'),
(152, 'Սուրենավանի միջնակարգ դպրոց', '172.28.15.2', '172.28.15.254'),
(157, 'Ավշարի Միջնակարգ Դպրոց', '172.28.16.2', '172.28.16.254'),
(159, 'Եղեգնավանի Միջնակարգ Դպրոց', '172.28.20.2', '172.28.20.254'),
(160, 'Նոր Կյանք Համայնքապետարան', '172.28.27.2', '172.28.27.254'),
(161, 'Արալեզի Միջնակարգ դպրոց', '172.28.22.1', '172.28.22.254'),
(162, 'Քաղաք Արարատ Խանջյան 45/90', '10.51.218.1', '10.51.218.254'),
(163, 'Արալեզի Միջնակարգ դպրոց', '172.28.22.1', '172.28.22.254'),
(165, 'Արմաշ Հեռուստաաշտարակ', '172.28.25.1', '172.28.25.254'),
(167, 'Արմաշ Հեռուստաաշտարակ', '172.28.25.1', '172.28.25.254'),
(168, 'Զովաշեն Հեռուստաաշտարակ', '10.51.243.1', '10.51.243.254'),
(171, 'Ուրցաձորի Դպրոց', '172.28.19.1', '172.28.19.254'),
(176, 'Վեդի Հեռուստաաշտարակ', '172.28.33.1', '172.28.33.254');

-- --------------------------------------------------------

--
-- Структура таблицы `f_base_zones`
--

CREATE TABLE IF NOT EXISTS `f_base_zones` (
  `base_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_base_zones`
--

INSERT INTO `f_base_zones` (`base_id`, `zone_id`) VALUES
(8, 1),
(9, 1),
(10, 1),
(39, 1),
(40, 1),
(41, 1),
(11, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(7, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(16, 1),
(3, 2),
(151, 6),
(152, 9),
(153, 9),
(154, 9),
(155, 9),
(156, 9),
(157, 9),
(158, 9),
(159, 9),
(160, 9),
(161, 9),
(162, 9),
(163, 9),
(164, 9),
(165, 9),
(167, 9),
(168, 9),
(169, 9),
(166, 9),
(170, 9),
(171, 9),
(172, 9),
(173, 9),
(174, 9),
(175, 9),
(176, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `f_baze_station_equipments`
--

CREATE TABLE IF NOT EXISTS `f_baze_station_equipments` (
  `id` int(11) NOT NULL,
  `base_id` int(11) DEFAULT NULL,
  `equipment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_baze_station_equipments`
--

INSERT INTO `f_baze_station_equipments` (`id`, `base_id`, `equipment_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 6),
(4, 2, 1),
(5, 2, 2),
(9, 6, 1),
(10, 6, 4),
(11, 6, 5),
(18, 8, 1),
(19, 8, 4),
(20, 9, 1),
(21, 9, 3),
(26, 10, 2),
(27, 10, 3),
(34, 7, 1),
(35, 7, 2),
(36, 7, 4),
(40, 3, 1),
(41, 3, 4),
(42, 3, 5),
(43, 151, 1),
(44, 151, 2),
(45, 151, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `f_cashier`
--

CREATE TABLE IF NOT EXISTS `f_cashier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` smallint(1) DEFAULT '1' COMMENT '0 => pasiv, 1 => active',
  `blacklist` smallint(6) DEFAULT '0' COMMENT '0 => Black | 1 => White',
  `virtual` smallint(6) DEFAULT '0' COMMENT '0 => Not virtual, 1 => Virtual'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `f_cashier`
--

INSERT INTO `f_cashier` (`id`, `name`, `is_active`, `blacklist`, `virtual`) VALUES
(1, 'Black_Cashier', 1, 0, 0),
(2, 'White_Cashier', 1, 1, 0),
(3, 'TelCell', 1, 1, 0),
(4, 'EasyPay', 1, 1, 0),
(5, 'HayPost', 1, 1, 0),
(6, 'ashot_kassa', 1, 1, 0),
(7, 'zara_kassa', 1, 0, 0),
(8, 'edgarmarkos_kassa', 1, 1, 0),
(9, 'Cassa_Hakob', 1, 0, 1),
(10, 'Argam-Kassa', 1, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `f_cashier_operator`
--

CREATE TABLE IF NOT EXISTS `f_cashier_operator` (
  `cashier_id` int(11) NOT NULL,
  `operator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `f_cashier_operator`
--

INSERT INTO `f_cashier_operator` (`cashier_id`, `operator_id`) VALUES
(1, 12),
(2, 14),
(3, 21),
(4, 22),
(5, 23),
(6, 20),
(7, 10),
(8, 15),
(9, 24),
(10, 25);

-- --------------------------------------------------------

--
-- Структура таблицы `f_community`
--

CREATE TABLE IF NOT EXISTS `f_community` (
  `id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_community`
--

INSERT INTO `f_community` (`id`, `city_id`, `name`) VALUES
(1, 1, 'Մալաթյա-Սեբաստյա'),
(2, 1, 'Կենտրոն'),
(3, 1, 'Արաբկիր'),
(5, 1, 'Նորք-Մարաշ'),
(6, 1, 'Դավիթաշեն'),
(15, 1, 'Աջափնյակ'),
(16, 24, 'Մխչյան'),
(17, 21, 'Ավշար'),
(18, 21, 'Սուրենավան'),
(19, 21, 'Արարատ'),
(20, 19, 'Հովտաշեն'),
(21, 19, 'Սիփանիկ'),
(22, 19, 'Մասիս'),
(23, 33, 'Սարատակ'),
(24, 33, 'Լուսակերտ'),
(25, 33, 'Անիպեմզա'),
(26, 4, 'Մալիշկա');

-- --------------------------------------------------------

--
-- Структура таблицы `f_contacts`
--

CREATE TABLE IF NOT EXISTS `f_contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `visit_day` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_data`
--

CREATE TABLE IF NOT EXISTS `f_data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_data`
--

INSERT INTO `f_data` (`id`, `name`) VALUES
(2, 'Րաֆֆու 25'),
(3, 'Մալիշկա 10.10.13.5'),
(4, 'Սարատակ '),
(5, 'ք. Երևան, Բագրատունյաց պողոտա 39'),
(6, 'ք. Երևան, 2-րդ թաղամաս 34'),
(7, 'ք. Երևան, Աբելյան փողոց 6'),
(8, 'ք. Երևան, Աբովյան փողոց 33'),
(9, 'ք. Երևան, Աբովյան փողոց 46'),
(10, 'ք. Երևան, Աբովյան փողոց 46'),
(11, 'ք. Երևան, Ազատության պողոտա 24/7'),
(12, 'ք. Երևան, Ազատության պողոտա 7բ'),
(13, 'ք. Երևան, Ամիրյան փողոց 1'),
(14, 'ք. Երևան, Ամիրյան փողոց 15'),
(15, 'ք. Երևան, Ամիրյան փողոց 7/1'),
(16, 'ք. Երևան, Արաբկիր 21 փող. 2'),
(17, 'ք. Երևան, Արշակունյաց պողոտա 17ա'),
(18, 'ք. Երևան, Արշակունյաց պողոտա 50/1'),
(19, 'ք. Երևան, Արշակունյաց պողոտա 9'),
(20, 'ք. Երևան, Արտաշիսյան փողոց 61'),
(21, 'ք. Երևան, Բաղրամյան պողոտա 24 դ'),
(22, 'ք. Երևան, Բաղրամյան պողոտա 58 Կտուր'),
(23, 'ք. Երևան, Բաղրամյան պողոտա 85 Կտուր'),
(24, 'ք. Երևան, Բրյուսովի փողոց 19'),
(25, 'ք. Երևան, Գալշոյան փողոց 24'),
(26, 'ք. Երևան, Դրոյի փողոց 28'),
(27, 'ք. Երևան, Թբիլիսյան խճուղի 2'),
(28, 'ք. Երևան, Լվովյան փողոց 19'),
(29, 'ք. Երևան, Կոմիտասի պողոտա 65'),
(30, 'ք. Երևան, Հանրապետության 24, գլխամաս'),
(31, 'ք. Երևան, Մամիկոնյանց փող. 27'),
(32, 'ք. Երևան, Մայիսի 9-ի փող. 13'),
(33, 'ք. Երևան, Մանանդյան փող. 13'),
(34, 'ք. Երևան, Մանանդյան փողոց 31/1'),
(35, 'ք. Երևան, Մարշալ Բաբաջանյան փող. 2/14'),
(36, 'ք. Երևան, Նալբանդյան փող. 7'),
(37, 'ք. Երևան, Նալբանդյան փող. 7 , 15'),
(38, 'ք. Երևան, Նալբանդյան փող. 7'),
(39, 'ք. Երևան, Նալբանդյան փող. 7'),
(40, 'ք. Երևան, Չեխովի փողոց 10'),
(41, 'ք. Երևան, Սարյան փողոց 20/1'),
(42, 'ք. Երևան, Սեբաստիա փող. 24/1'),
(43, 'ք. Երևան, Վահե Վահյան 12'),
(44, 'ք. Երևան, Վարդանանց փողոց 28'),
(45, 'ք. Երևան, Վիլնյուսի փողոց 3'),
(46, 'ք. Երևան, Տիտոգրադյան փող. 2'),
(47, 'ք. Երևան, Րաֆֆի փողոց 25, բն. 28'),
(48, 'ք. Երևան, Օրբելի Եղբայրների փողոց 14'),
(49, 'ք. Երևան, Այգեձորի 70'),
(50, 'ք. Երևան, Իսահակյան 22'),
(51, 'ք. Երևան, Եզնիկ Կողբացի 30'),
(52, 'ք. Երևան, Կորյուն 11/11'),
(53, 'ք. Երևան, Դրոյի 17/9'),
(54, 'ք. Երևան, Սայաթ-Նովա 40/1, բն.4'),
(55, 'ք. Երևան, Հ. Հակոբյան 3'),
(56, 'ք. Երևան, Իսակովի 42/2, տարածք 45'),
(57, 'ք. Երևան, Հյուսիսային պող. 1'),
(58, 'ք. Երևան, Տիգրան Մեծի 36'),
(59, 'ք. Երևան, Կորյուն-Աբովյան գետնանցում'),
(60, 'ք. Երևան, Գ. Նժդեհի 27/2'),
(61, 'ք. Երևան, Քաջազնունի 20/1'),
(62, 'ք. Երևան, Բագրատունյաց 54'),
(63, 'ք. Երևան, Վաղարշյան 12ա'),
(64, 'ք. Երևան, Վիլնյուս 11'),
(65, 'ք. Երևան, Թբիլիսյան 33/2'),
(66, 'ք. Երևան, Իսահակյան 35, 2-րդ հարկ'),
(67, 'ք. Երևան, Թումանյան 34'),
(68, 'ք. Երևան, Սիլիկյան 7-րդ փող. տուն 4'),
(69, 'ք. Երևան, Ֆուչիկի 19'),
(70, 'ք. Երևան, Արշակունյաց 135'),
(71, 'ք. Երևան, Զաքյան 2'),
(72, 'ք. Երևան, Հյուսիսային պող. 10, տարածք 3/2'),
(73, 'ք. Երևան, Նալբանդյան 7, 15'),
(74, 'ք. Երևան, Ամիրյան 15'),
(75, 'ք. Երևան, Կիևյան 1ա'),
(76, 'ք. Երևան, 16 թաղ.շենք 19'),
(77, 'ք. Երևան, Վաղարշյան 17'),
(78, 'ք. Երևան, Նոր Նորքի 8զ, Մինսկի փ 2'),
(79, 'ք. Երևան, Սարյան 12, Զովք'),
(80, 'ք. Երևան, Խորենացու 45'),
(81, 'ք. Երևան, Կոմիտասի 9'),
(82, 'ք. Երևան, Նալբանդյան 7, 15'),
(83, 'ք. Երևան, Տիգրան Մեծի 4'),
(84, 'ք. Երևան, Տիչինայի 34'),
(85, 'ք. Երևան, Զ. Անդրանիկի 129/6'),
(86, 'ք. Երևան, Աղայան 7'),
(87, 'ք. Երևան, Ջրաշեն 1 փող., 85 տան մոտի Ucom-ի աշտարակ'),
(88, 'ք. Երևան, Գայի 19/76'),
(89, 'ք. Երևան, Դեմիրճյան 40/5'),
(90, 'ք. Երևան, Ն. Ստեփանյան 1/4'),
(91, 'ք. Երևան, Պռոշյան 2/2'),
(92, 'ք. Երևան, Մուրացան 113/1'),
(93, 'ք. Երևան, Մարգարյան 16/6'),
(94, 'ք. Երևան, Վաղարշյան 24/6'),
(95, 'ք. Երևան, Կոմիտասի պողոտա 42'),
(96, 'ք. Երևան, Պուշկին 42'),
(97, 'ք. Երևան, Ներսիսյան 10/5'),
(98, 'ք. Երևան, Քրիստափոր 2/2'),
(99, 'ք. Երևան, Ադոնց 2'),
(100, 'ք. Երևան, Տիգրան Մեծի 10/2'),
(101, 'ք. Երևան, Ամիրյան 5ա'),
(102, 'ք. Երևան, Կոմիտաս 55'),
(103, 'ք. Երևան, Բաղրամյան 49/2'),
(104, 'ք. Երևան, Նուբարաշեն 6-րդ փողոց, 1/2'),
(105, 'ք. Երևան, Նաիրի Զարյան 32/2'),
(106, 'ք. Երևան, Աբովյան 30'),
(107, 'ք. Երևան, Ֆուչիկի 30'),
(108, 'ք. Երևան, Աբովյան 50/5'),
(109, 'ք. Երևան, Ադոնց 8/2'),
(110, 'ք. Երևան, Ծերենց 82'),
(111, 'ք. Երևան, Արշակունյաց 15'),
(112, 'ք. Երևան, Թումանյան 41'),
(113, 'ք. Երևան, Սեբաստիա փող. 123'),
(114, 'ք. Երևան, Հրաչյա Քոչար 11'),
(115, 'ք. Երևան, Մանանդյան փող. 9/5'),
(116, 'ք. Երևան, Գարեգին Նժդեհի 44 տարածք 1'),
(117, 'ք. Երևան, Հրաչյա Քոչար տարածք 44/53'),
(118, 'ք. Երևան, Տիգրան Մեծի 15/1'),
(119, 'Երևան, Տիգրան Պետրոսյան տարածք փողոց 46/5'),
(120, 'Երևան, Չարենցի 5'),
(121, 'ք. Երևան, Մաշտոցի պողոտա 43/34'),
(122, 'ք. Երևան, Գարեգին Նժդեհ 19/1'),
(123, 'ք. Երևան, Մարգարյան 18/5'),
(124, 'ք. Երևան, Ռուբինյանց 2/8'),
(125, 'ք. Երևան, Ավետիս Ահարոնյան 24/1'),
(126, 'ք. Երևան, Աբովյան 52'),
(127, 'ք. Երևան, Հյուսիսային պողոտա 10, 3/2'),
(128, 'ք. Երևան, Խորենացու 15, Գլոբինգ'),
(129, 'ք. Երևան, Ազատության 24, 4'),
(130, 'ք․Երևան  Ագաթանգեղոսի փողոց, 6/1 '),
(131, 'ք․ Երևան, Մաշտոցի պողոտա, 2/2,'),
(132, 'ք․ Երևան, Սմբատ Զորավարի  փողոց, 11/3'),
(133, 'ք․ Երևան, Արշակունյաց պողոտա, 17/8,'),
(134, 'ք. Երևան, Աջափնյակ, Լենինգրադյան փողոց, 52'),
(135, 'ք. Երևան, Կենտրոն, Աբովյան փողոց, 50/5,'),
(136, 'ք. Երևան, Ագաթանգեղոսի փողոց, 6/1'),
(137, 'ք. Երևան, Գետառի փողոց, 4/7'),
(138, 'ք. Երևան, Կենտրոն, Եկմալյան  փողոց, 5'),
(139, 'ք. Երևան, Կենտրոն, Իսահակյան փողոց, 44'),
(140, 'ք. Երևան, Կենտրոն, Նալբանդյան փողոց, 7'),
(141, 'ք. Երևան, Սիմեոն Վրացյանի  փողոց, 73'),
(142, 'ք. Երևան, Կուրղինյան փողոց, 11/2 տարածք'),
(143, 'ք. Երևան, Նորք 6րդ փողոց, տուն 20'),
(144, 'ք. Երևան, Մանանդյան փողոց, 33/18'),
(145, 'ք. Երևան, Սմբատ  Զորավարի   փողոց, 11/3'),
(146, 'ք. Երևան, Պարույր Սևակ, 92'),
(147, 'ք. Երևան, Զորավար Անդրանիկի 149/2');

-- --------------------------------------------------------

--
-- Структура таблицы `f_data_base`
--

CREATE TABLE IF NOT EXISTS `f_data_base` (
  `id` int(11) NOT NULL,
  `data_id` int(11) DEFAULT NULL,
  `base_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_data_base`
--

INSERT INTO `f_data_base` (`id`, `data_id`, `base_id`) VALUES
(1, 4, 4),
(2, 4, 5),
(3, 4, 3),
(5, 2, 2),
(6, 5, 7),
(7, 6, 8),
(8, 7, 9),
(9, 8, 10),
(10, 9, 11),
(11, 10, 11),
(12, 11, 12),
(13, 12, 13),
(14, 13, 14),
(15, 14, 15),
(16, 15, 16),
(17, 16, 17),
(18, 17, 18),
(19, 18, 19),
(20, 19, 20),
(21, 20, 21),
(22, 21, 22),
(23, 22, 23),
(24, 23, 24),
(25, 24, 25),
(26, 25, 26),
(27, 26, 27),
(28, 27, 28),
(29, 28, 30),
(32, 3, 6),
(33, 29, 31),
(34, 30, 32),
(35, 31, 33),
(36, 32, 34),
(37, 33, 35),
(38, 34, 36),
(39, 35, 37),
(40, 36, 38),
(41, 37, 39),
(42, 38, 40),
(43, 39, 41),
(44, 40, 42),
(45, 41, 43),
(46, 42, 44),
(47, 43, 45),
(48, 44, 46),
(49, 45, 47),
(50, 46, 48),
(51, 47, 49),
(52, 48, 50),
(53, 49, 51),
(54, 50, 52),
(55, 51, 53),
(56, 52, 54),
(57, 53, 55),
(58, 54, 56),
(59, 55, 57),
(60, 56, 29),
(61, 57, 58),
(62, 58, 59),
(63, 59, 60),
(64, 60, 61),
(65, 61, 62),
(66, 62, 63),
(67, 63, 64),
(68, 64, 65),
(69, 65, 66),
(70, 66, 67),
(71, 67, 68),
(72, 68, 69),
(73, 69, 70),
(74, 70, 71),
(75, 71, 72),
(76, 72, 73),
(77, 73, 74),
(78, 74, 75),
(79, 75, 76),
(80, 76, 77),
(81, 77, 78),
(82, 78, 79),
(83, 79, 80),
(84, 80, 81),
(85, 81, 82),
(86, 82, 83),
(87, 83, 84),
(88, 84, 85),
(89, 85, 86),
(90, 86, 87),
(91, 87, 88),
(92, 88, 89),
(93, 89, 90),
(94, 90, 91),
(95, 91, 92),
(96, 92, 93),
(97, 93, 94),
(98, 94, 95),
(99, 95, 96),
(100, 96, 97),
(101, 97, 98),
(102, 98, 99),
(103, 99, 100),
(104, 100, 101),
(105, 101, 102),
(106, 102, 103),
(107, 103, 104),
(108, 104, 105),
(109, 105, 106),
(110, 106, 107),
(111, 107, 108),
(112, 108, 109),
(113, 109, 110),
(114, 110, 112),
(115, 111, 113),
(116, 112, 114),
(117, 113, 115),
(118, 114, 117),
(119, 115, 118),
(120, 116, 119),
(121, 117, 120),
(122, 118, 121),
(123, 119, 122),
(124, 120, 123),
(125, 121, 124),
(126, 122, 125),
(127, 123, 126),
(128, 124, 127),
(129, 125, 128),
(130, 126, 129),
(131, 127, 130),
(132, 128, 131),
(133, 129, 132),
(138, 130, 133),
(139, 131, 134),
(140, 132, 135),
(141, 133, 136),
(142, 134, 137),
(143, 135, 138),
(144, 136, 139),
(145, 137, 140),
(146, 138, 141),
(147, 139, 142),
(148, 140, 143),
(149, 141, 144),
(150, 142, 145),
(151, 143, 146),
(152, 144, 147),
(153, 145, 148),
(154, 146, 149),
(155, 147, 150);

-- --------------------------------------------------------

--
-- Структура таблицы `f_deal`
--

CREATE TABLE IF NOT EXISTS `f_deal` (
  `id` int(11) NOT NULL,
  `deal_number` varchar(255) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `is_provider` int(11) DEFAULT NULL,
  `service_type` smallint(3) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  `connect_id` int(11) DEFAULT NULL,
  `crm_contact_id` int(11) DEFAULT NULL,
  `crm_company_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `penalty` decimal(10,2) DEFAULT NULL,
  `connect_price` decimal(10,2) DEFAULT NULL COMMENT 'miacman gumar',
  `base_station_id` int(11) DEFAULT NULL,
  `contract_start` datetime DEFAULT NULL,
  `contract_end` datetime DEFAULT NULL,
  `start_day` date DEFAULT NULL,
  `connection_day` date DEFAULT NULL,
  `daily_finish_month` date DEFAULT NULL COMMENT 'Contract finish month for daily',
  `daily_month_end` date DEFAULT NULL COMMENT 'Contract one month ending for daily',
  `connect_type` int(11) DEFAULT NULL,
  `binding_speed` int(11) DEFAULT NULL,
  `speed_date_start` date DEFAULT NULL,
  `speed_date_end` date DEFAULT NULL,
  `is_wifi` smallint(6) DEFAULT '0',
  `wifi_code` varchar(255) DEFAULT NULL,
  `electricity` decimal(10,2) DEFAULT NULL,
  `free` smallint(6) DEFAULT '0',
  `discount` decimal(10,2) DEFAULT NULL,
  `start_deal` smallint(1) DEFAULT '1',
  `status` smallint(1) DEFAULT '1',
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `blacklist` int(11) DEFAULT '0',
  `is_active` smallint(1) DEFAULT '0',
  `is_daily` tinyint(1) DEFAULT '0',
  `month` int(11) DEFAULT NULL COMMENT 'Contract months for daily'
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_deal`
--

INSERT INTO `f_deal` (`id`, `deal_number`, `contact_id`, `is_provider`, `service_type`, `user_type`, `connect_id`, `crm_contact_id`, `crm_company_id`, `amount`, `penalty`, `connect_price`, `base_station_id`, `contract_start`, `contract_end`, `start_day`, `connection_day`, `daily_finish_month`, `daily_month_end`, `connect_type`, `binding_speed`, `speed_date_start`, `speed_date_end`, `is_wifi`, `wifi_code`, `electricity`, `free`, `discount`, `start_deal`, `status`, `create_at`, `update_at`, `blacklist`, `is_active`, `is_daily`, `month`) VALUES
(1, '124135', NULL, 0, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-10', '2021-03-10', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-10 00:00:00', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(2, '124159', NULL, 0, 1, 0, 23, 2, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-03-18', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-18 17:33:09', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(3, '124160', NULL, 0, 1, 0, 23, 3, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-03-18', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-18 17:40:50', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(4, '124162', NULL, 0, 1, 0, 23, 4, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-03-18', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-18 17:45:36', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(5, '124164', NULL, 0, 1, 0, 23, 5, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-03-18', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-18 17:48:32', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(6, '124165', NULL, 0, 1, 0, 23, 6, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-03-18', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-18 17:50:52', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(7, '124167', NULL, 0, 1, 0, 23, 7, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-03-19', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-19 17:53:03', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(8, '124168', NULL, 0, 1, 0, 23, 8, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-03-19', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-19 18:01:03', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(9, '124170', NULL, 0, 1, 0, 23, 9, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-03-19', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-19 18:04:16', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(10, '124172', NULL, 0, 1, 0, 23, 10, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-03-19', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-19 18:06:19', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(11, '124194', NULL, 0, 1, 0, 23, 11, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-03-23', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-23 18:08:47', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(12, '124196', NULL, 0, 1, 0, 23, 12, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-03-23', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-23 18:11:35', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(13, '124199', NULL, 0, 1, 0, 23, 13, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-03-23', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-23 18:13:58', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(14, '124205', NULL, 0, 1, 0, 23, 14, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-03-23', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-23 18:15:56', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(15, '124206', NULL, 0, 1, 0, 23, 15, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-03-23', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-23 18:34:10', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(17, '124210', NULL, 0, 1, 0, 23, 17, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-03-24', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-24 18:49:35', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(18, '124212', NULL, 0, 1, 0, 23, 18, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-03-24', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-24 18:51:48', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(19, '124213', NULL, 0, 1, 0, 23, 19, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-03-24', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-24 18:57:49', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(20, '124149', NULL, 0, 1, 0, 22, 20, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-16', '2021-03-16', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-16 19:03:56', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(21, '124151', NULL, 0, 1, 0, 22, 21, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-16', '2021-03-16', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-16 19:06:42', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(22, '124197', NULL, 0, 1, 0, 22, 22, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-23', '2021-03-23', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-03-23 19:09:49', '2021-04-01 00:00:02', 0, 0, 0, NULL),
(23, '124135', NULL, 0, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-10', '2021-04-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(24, '124159', NULL, 0, 1, 0, 23, 2, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-04-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(25, '124160', NULL, 0, 1, 0, 23, 3, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-04-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(26, '124162', NULL, 0, 1, 0, 23, 4, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-04-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(27, '124164', NULL, 0, 1, 0, 23, 5, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-04-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(28, '124165', NULL, 0, 1, 0, 23, 6, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-04-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(29, '124167', NULL, 0, 1, 0, 23, 7, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-04-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(30, '124168', NULL, 0, 1, 0, 23, 8, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(31, '124170', NULL, 0, 1, 0, 23, 9, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(32, '124172', NULL, 0, 1, 0, 23, 10, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(33, '124194', NULL, 0, 1, 0, 23, 11, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(34, '124196', NULL, 0, 1, 0, 23, 12, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(35, '124199', NULL, 0, 1, 0, 23, 13, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(36, '124205', NULL, 0, 1, 0, 23, 14, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(37, '124206', NULL, 0, 1, 0, 23, 15, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(38, '124210', NULL, 0, 1, 0, 23, 17, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(39, '124212', NULL, 0, 1, 0, 23, 18, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(40, '124213', NULL, 0, 1, 0, 23, 19, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(41, '124149', NULL, 0, 1, 0, 22, 20, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-16', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(42, '124151', NULL, 0, 1, 0, 22, 21, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-16', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(43, '124197', NULL, 0, 1, 0, 22, 22, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-23', '2021-04-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-04-01 00:00:02', '2021-05-01 00:02:01', 0, 0, 0, NULL),
(44, '124135', NULL, 0, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-10', '2021-05-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(45, '124159', NULL, 0, 1, 0, 23, 2, NULL, NULL, '0.00', '0.00', 151, NULL, NULL, '2021-03-18', '2021-05-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', '5000.00', 0, '0.00', 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(46, '124160', NULL, 0, 1, 0, 23, 3, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-05-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(47, '124162', NULL, 0, 1, 0, 23, 4, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-05-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(48, '124164', NULL, 0, 1, 0, 23, 5, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-05-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(49, '124165', NULL, 0, 1, 0, 23, 6, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-05-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(50, '124167', NULL, 0, 1, 0, 23, 7, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-05-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(51, '124168', NULL, 0, 1, 0, 23, 8, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(52, '124170', NULL, 0, 1, 0, 23, 9, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(53, '124172', NULL, 0, 1, 0, 23, 10, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(54, '124194', NULL, 0, 1, 0, 23, 11, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(55, '124196', NULL, 0, 1, 0, 23, 12, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(56, '124199', NULL, 0, 1, 0, 23, 13, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(57, '124205', NULL, 0, 1, 0, 23, 14, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(58, '124206', NULL, 0, 1, 0, 23, 15, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(59, '124210', NULL, 0, 1, 0, 23, 17, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(60, '124212', NULL, 0, 1, 0, 23, 18, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(61, '124213', NULL, 0, 1, 0, 23, 19, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(62, '124149', NULL, 0, 1, 0, 22, 20, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-16', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(63, '124151', NULL, 0, 1, 0, 22, 21, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-16', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(64, '124197', NULL, 0, 1, 0, 22, 22, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-23', '2021-05-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 0, '2021-05-01 00:02:01', '2021-06-01 00:02:01', 0, 0, 0, NULL),
(66, '123245', NULL, 0, 1, 0, 4, 23, NULL, NULL, '0.00', '0.00', 49, NULL, NULL, '2021-05-28', '2021-06-01', NULL, NULL, NULL, 1, '2021-05-28', '2021-05-28', 0, '', '0.00', 0, '4000.00', 1, 0, '2021-05-28 21:57:57', '2021-06-01 00:02:02', 0, 0, 0, NULL),
(67, '124135', NULL, 0, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-10', '2021-06-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(68, '124159', NULL, 0, 1, 0, 23, 2, NULL, NULL, '0.00', '0.00', 151, NULL, NULL, '2021-03-18', '2021-06-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', '5000.00', 0, '0.00', 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(69, '124160', NULL, 0, 1, 0, 23, 3, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-06-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(70, '124162', NULL, 0, 1, 0, 23, 4, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-06-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(71, '124164', NULL, 0, 1, 0, 23, 5, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-06-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(72, '124165', NULL, 0, 1, 0, 23, 6, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-18', '2021-06-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(73, '124167', NULL, 0, 1, 0, 23, 7, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-05-01', NULL, NULL, 1, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 5, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(74, '124168', NULL, 0, 1, 0, 23, 8, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(75, '124170', NULL, 0, 1, 0, 23, 9, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(76, '124172', NULL, 0, 1, 0, 23, 10, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-19', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(77, '124194', NULL, 0, 1, 0, 23, 11, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(78, '124196', NULL, 0, 1, 0, 23, 12, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(79, '124199', NULL, 0, 1, 0, 23, 13, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(80, '124205', NULL, 0, 1, 0, 23, 14, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(81, '124206', NULL, 0, 1, 0, 23, 15, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-23', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(82, '124210', NULL, 0, 1, 0, 23, 17, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(83, '124212', NULL, 0, 1, 0, 23, 18, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(84, '124213', NULL, 0, 1, 0, 23, 19, NULL, NULL, NULL, NULL, 151, NULL, NULL, '2021-03-24', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(85, '124149', NULL, 0, 1, 0, 22, 20, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-16', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(86, '124151', NULL, 0, 1, 0, 22, 21, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-16', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(87, '124197', NULL, 0, 1, 0, 22, 22, NULL, NULL, NULL, NULL, 6, NULL, NULL, '2021-03-23', '2021-06-01', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 0, NULL, 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL),
(88, '123245', NULL, 0, 1, 0, 4, 23, NULL, NULL, '0.00', '0.00', 49, NULL, NULL, '2021-05-28', '2021-06-01', NULL, NULL, NULL, 1, '2021-05-28', '2021-05-28', 0, '', '0.00', 0, '4000.00', 1, 1, '2021-06-01 00:02:01', '2021-06-01 00:02:01', 0, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `f_deal_address`
--

CREATE TABLE IF NOT EXISTS `f_deal_address` (
  `id` int(11) NOT NULL,
  `deal_number` varchar(255) DEFAULT NULL,
  `contact_address_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_deal_address`
--

INSERT INTO `f_deal_address` (`id`, `deal_number`, `contact_address_id`) VALUES
(1, '124135', 1),
(2, '124159', 2),
(3, '124160', 3),
(4, '124162', 4),
(5, '124164', 5),
(6, '124165', 6),
(7, '124167', 7),
(8, '124168', 8),
(9, '124170', 9),
(10, '124172', 10),
(11, '124194', 11),
(12, '124196', 12),
(13, '124199', 13),
(14, '124205', 14),
(15, '124206', 15),
(17, '124210', 17),
(18, '124212', 18),
(19, '124213', 19),
(20, '124149', 20),
(21, '124151', 21),
(22, '124197', 22),
(23, '123245', 23),
(24, '123245', 23);

-- --------------------------------------------------------

--
-- Структура таблицы `f_deal_agreement`
--

CREATE TABLE IF NOT EXISTS `f_deal_agreement` (
  `id` int(11) NOT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_deal_agreement`
--

INSERT INTO `f_deal_agreement` (`id`, `deal_id`, `file`) VALUES
(2, 66, '123245_1622224677.pdf');

-- --------------------------------------------------------

--
-- Структура таблицы `f_deal_antenna_ip`
--

CREATE TABLE IF NOT EXISTS `f_deal_antenna_ip` (
  `id` int(11) NOT NULL,
  `deal_number` varchar(255) DEFAULT NULL,
  `antenna_ip_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_deal_ballance`
--

CREATE TABLE IF NOT EXISTS `f_deal_ballance` (
  `id` int(11) NOT NULL,
  `deal_number` varchar(255) DEFAULT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_deal_ballance`
--

INSERT INTO `f_deal_ballance` (`id`, `deal_number`, `deal_id`, `balance`, `date`) VALUES
(4, '124135', 1, '3548.00', '2021-03-10'),
(5, '124159', 2, '2258.00', '2021-03-18'),
(6, '124160', 3, '2258.00', '2021-03-18'),
(7, '124162', 4, '2258.00', '2021-03-18'),
(8, '124164', 5, '2258.00', '2021-03-18'),
(9, '124165', 6, '2258.00', '2021-03-18'),
(10, '124167', 7, '2097.00', '2021-03-19'),
(11, '124168', 8, '2097.00', '2021-03-19'),
(12, '124170', 9, '2097.00', '2021-03-19'),
(13, '124172', 10, '2097.00', '2021-03-19'),
(14, '124194', 11, '1452.00', '2021-03-23'),
(15, '124196', 12, '1452.00', '2021-03-23'),
(16, '124199', 13, '1452.00', '2021-03-23'),
(17, '124205', 14, '1452.00', '2021-03-23'),
(18, '124206', 15, '1452.00', '2021-03-23'),
(19, '124210', 17, '1290.00', '2021-03-24'),
(20, '124212', 18, '1290.00', '2021-03-24'),
(21, '124213', 19, '1290.00', '2021-03-24'),
(22, '124149', 20, '2581.00', '2021-03-16'),
(23, '124151', 21, '2581.00', '2021-03-16'),
(24, '124197', 22, '1452.00', '2021-03-23'),
(25, '124135', 23, '5048.00', '2021-04-01'),
(26, '124159', 24, '258.00', '2021-04-01'),
(27, '124160', 25, '4958.00', '2021-04-01'),
(28, '124162', 26, '4958.00', '2021-04-01'),
(29, '124164', 27, '4958.00', '2021-04-01'),
(30, '124165', 28, '4958.00', '2021-04-01'),
(31, '124167', 29, '4997.00', '2021-04-01'),
(32, '124168', 30, '4997.00', '2021-04-01'),
(33, '124170', 31, '4997.00', '2021-04-01'),
(34, '124172', 32, '4997.00', '2021-04-01'),
(35, '124194', 33, '4952.00', '2021-04-01'),
(36, '124196', 34, '4952.00', '2021-04-01'),
(37, '124199', 35, '4952.00', '2021-04-01'),
(38, '124205', 36, '4952.00', '2021-04-01'),
(39, '124206', 37, '4952.00', '2021-04-01'),
(40, '124210', 38, '4990.00', '2021-04-01'),
(41, '124212', 39, '4990.00', '2021-04-01'),
(42, '124213', 40, '4990.00', '2021-04-01'),
(43, '124149', 41, '4981.00', '2021-04-01'),
(44, '124151', 42, '4581.00', '2021-04-01'),
(45, '124197', 43, '5052.00', '2021-04-01'),
(46, '124135', 44, '5048.00', '2021-05-01'),
(47, '124159', 45, '-342.00', '2021-05-01'),
(48, '124160', 46, '4958.00', '2021-05-01'),
(49, '124162', 47, '4958.00', '2021-05-01'),
(50, '124164', 48, '4958.00', '2021-05-01'),
(51, '124165', 49, '4958.00', '2021-05-01'),
(52, '124167', 50, '4997.00', '2021-05-01'),
(53, '124168', 51, '4997.00', '2021-05-01'),
(54, '124170', 52, '4997.00', '2021-05-01'),
(55, '124172', 53, '4997.00', '2021-05-01'),
(56, '124194', 54, '4952.00', '2021-05-01'),
(57, '124196', 55, '4952.00', '2021-05-01'),
(58, '124199', 56, '4952.00', '2021-05-01'),
(59, '124205', 57, '4952.00', '2021-05-01'),
(60, '124206', 58, '4952.00', '2021-05-01'),
(61, '124210', 59, '4990.00', '2021-05-01'),
(62, '124212', 60, '4990.00', '2021-05-01'),
(63, '124213', 61, '4990.00', '2021-05-01'),
(64, '124149', 62, '4981.00', '2021-05-01'),
(65, '124151', 63, '4581.00', '2021-05-01'),
(66, '124197', 64, '5052.00', '2021-05-01'),
(68, '123245', 66, '161.00', '2021-06-01'),
(69, '124135', 67, '5048.00', '2021-06-01'),
(70, '124159', 68, '-342.00', '2021-06-01'),
(71, '124160', 69, '4958.00', '2021-06-01'),
(72, '124162', 70, '4958.00', '2021-06-01'),
(73, '124164', 71, '4958.00', '2021-06-01'),
(74, '124165', 72, '4958.00', '2021-06-01'),
(75, '124167', 73, '161.29', '2021-06-01'),
(76, '124168', 74, '4997.00', '2021-06-01'),
(77, '124170', 75, '4997.00', '2021-06-01'),
(78, '124172', 76, '4997.00', '2021-06-01'),
(79, '124194', 77, '4952.00', '2021-06-01'),
(80, '124196', 78, '4952.00', '2021-06-01'),
(81, '124199', 79, '4952.00', '2021-06-01'),
(82, '124205', 80, '4952.00', '2021-06-01'),
(83, '124206', 81, '4952.00', '2021-06-01'),
(84, '124210', 82, '4990.00', '2021-06-01'),
(85, '124212', 83, '4990.00', '2021-06-01'),
(86, '124213', 84, '4990.00', '2021-06-01'),
(87, '124149', 85, '5000.00', '2021-06-01'),
(88, '124151', 86, '4581.00', '2021-06-01'),
(89, '124197', 87, '5052.00', '2021-06-01'),
(90, '123245', 88, '4839.00', '2021-06-01');

-- --------------------------------------------------------

--
-- Структура таблицы `f_deal_connect_mikrotik`
--

CREATE TABLE IF NOT EXISTS `f_deal_connect_mikrotik` (
  `id` int(11) NOT NULL,
  `deal_id` varchar(255) DEFAULT NULL,
  `mikrotik_id` varchar(255) DEFAULT NULL,
  `micro_queue_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_deal_connect_mikrotik`
--

INSERT INTO `f_deal_connect_mikrotik` (`id`, `deal_id`, `mikrotik_id`, `micro_queue_id`) VALUES
(22, '124135', '*1F4', '*1E3'),
(23, '124159', '*1F5', '*1E4'),
(24, '124160', '*1F6', '*1E5'),
(25, '124162', '*1F7', '*1E6'),
(26, '124164', '*1F8', '*1E7'),
(27, '124165', '*1F9', '*1E8'),
(28, '124167', '*1FA', '*1E9'),
(29, '124168', '*1FB', '*1EA'),
(30, '124170', '*1FC', '*1EB'),
(31, '124172', '*1FD', '*1EC'),
(32, '124194', '*1FE', '*1ED'),
(33, '124196', '*1FF', '*1EE'),
(34, '124199', '*200', '*1EF'),
(35, '124205', '*201', '*1F0'),
(36, '124206', '*202', '*1F1'),
(37, '124210', '*203', '*1F2'),
(38, '124212', '*204', '*1F3'),
(39, '124213', '*205', '*1F4'),
(40, '124149', '*206', '*1F5'),
(41, '124151', '*207', '*1F6'),
(42, '124197', '*208', '*1F7');

-- --------------------------------------------------------

--
-- Структура таблицы `f_deal_disabled_day`
--

CREATE TABLE IF NOT EXISTS `f_deal_disabled_day` (
  `id` int(11) NOT NULL,
  `disabled_day` int(11) DEFAULT NULL,
  `disabled_price_day` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '99.00',
  `message` text
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_deal_disabled_day`
--

INSERT INTO `f_deal_disabled_day` (`id`, `disabled_day`, `disabled_price_day`, `price`, `message`) VALUES
(1, 15, 15, '99.00', 'Պարտք ունի');

-- --------------------------------------------------------

--
-- Структура таблицы `f_deal_disruption`
--

CREATE TABLE IF NOT EXISTS `f_deal_disruption` (
  `id` int(11) NOT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `reason_id` int(11) DEFAULT NULL,
  `reason_text` text,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_deal_ip`
--

CREATE TABLE IF NOT EXISTS `f_deal_ip` (
  `id` int(11) NOT NULL,
  `deal_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` smallint(1) DEFAULT '0' COMMENT 'ete 1 e anvchar e'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_deal_sale`
--

CREATE TABLE IF NOT EXISTS `f_deal_sale` (
  `id` int(11) NOT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `month` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_disruption_options`
--

CREATE TABLE IF NOT EXISTS `f_disruption_options` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_disruption_types`
--

CREATE TABLE IF NOT EXISTS `f_disruption_types` (
  `id` int(11) NOT NULL,
  `name` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_streets`
--

CREATE TABLE IF NOT EXISTS `f_streets` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `community_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_streets`
--

INSERT INTO `f_streets` (`id`, `city_id`, `community_id`, `name`) VALUES
(6, 1, NULL, 'Սվաճյան'),
(7, 1, NULL, 'Վիկտոր Համբարձումյան'),
(9, 3, NULL, '1'),
(10, 3, NULL, '3'),
(11, 3, NULL, '2'),
(12, 4, NULL, '2'),
(14, 4, NULL, '20'),
(15, 4, NULL, '8'),
(16, 4, NULL, 'Կենտրոնական'),
(17, 4, NULL, '26'),
(18, 1, NULL, 'Սայաթ Նովա'),
(21, 4, NULL, '5'),
(23, 24, NULL, 'ep'),
(24, 6, NULL, 'test'),
(25, 19, NULL, '1փ'),
(26, 19, NULL, 'Բաղրամյան'),
(27, 19, NULL, '2փ'),
(28, 33, NULL, '1'),
(29, 19, NULL, 'Հանրապետության'),
(30, 19, NULL, 'Նոր Թաղ 2'),
(31, 5, NULL, '2'),
(32, 1, NULL, 'Գալշոյան'),
(33, 2, NULL, '0'),
(34, 33, NULL, NULL),
(35, 1, 3, 'Վ․ Համբարձումյան');

-- --------------------------------------------------------

--
-- Структура таблицы `f_tariff`
--

CREATE TABLE IF NOT EXISTS `f_tariff` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `availability` int(11) DEFAULT NULL,
  `inet_speed` int(11) DEFAULT NULL,
  `inet_price` decimal(10,2) DEFAULT NULL,
  `tv_id` int(11) DEFAULT NULL,
  `ip_count` int(11) DEFAULT NULL,
  `type` smallint(6) DEFAULT '0' COMMENT '0 => tan hamar, 1 => bussiness',
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `speed_for_year` int(11) DEFAULT NULL,
  `status` smallint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_tariff`
--

INSERT INTO `f_tariff` (`id`, `name`, `availability`, `inet_speed`, `inet_price`, `tv_id`, `ip_count`, `type`, `create_at`, `update_at`, `speed_for_year`, `status`) VALUES
(1, 'FAST-SURFING-HOME', NULL, 5, '3900.00', NULL, 0, 0, '2021-02-01 18:25:45', '2021-02-01 18:25:45', NULL, 1),
(2, 'FAST-SURFING 1', NULL, 10, '5000.00', NULL, 0, 0, '2021-02-01 18:28:18', '2021-02-02 10:20:24', NULL, 1),
(3, 'FAST-SURFING 2', NULL, 15, '7000.00', NULL, 0, 0, '2021-02-01 18:30:04', '2021-02-01 18:30:04', NULL, 1),
(4, 'FAST-SURFING 3', NULL, 20, '9000.00', NULL, 0, 0, '2021-02-01 18:30:35', '2021-02-01 18:30:35', NULL, 1),
(5, 'FAST-SURFING 4', NULL, 30, '12000.00', NULL, 0, NULL, '2021-02-01 18:31:14', '2021-02-01 18:31:14', NULL, 1),
(6, 'FAST-SURFING 5', NULL, 35, '15000.00', NULL, 0, 0, '2021-02-01 18:31:38', '2021-02-01 18:31:38', NULL, 1),
(7, 'FAST- DISTRICT 1', NULL, 7, '5000.00', NULL, 0, 0, '2021-02-01 18:32:11', '2021-02-01 18:32:11', NULL, 1),
(8, 'FAST- DISTRICT 2', NULL, 8, '6000.00', NULL, 0, 0, '2021-02-01 18:32:38', '2021-02-01 18:32:38', NULL, 1),
(9, 'FAST- DISTRICT 3', NULL, 10, '7000.00', NULL, 0, 0, '2021-02-01 18:33:02', '2021-02-01 18:33:02', NULL, 1),
(10, 'FAST- DISTRICT 4', NULL, 12, '9000.00', NULL, 0, 0, '2021-02-01 18:33:33', '2021-02-01 18:33:33', NULL, 1),
(11, 'DISTRICT-BUSINESS', NULL, 7, '7000.00', NULL, 0, 1, '2021-02-01 18:34:22', '2021-02-01 18:34:22', NULL, 1),
(12, 'FASTNET BUSINESS SMALL-6', NULL, 7, '9000.00', NULL, 0, 1, '2021-02-01 18:34:47', '2021-02-01 18:34:47', NULL, 1),
(13, 'FASTNET BUSINESS SMALL-8', NULL, 10, '12000.00', NULL, 0, 1, '2021-02-01 18:35:07', '2021-02-01 18:35:07', NULL, 1),
(14, 'FASTNET BUSINESS SMALL-10', NULL, 13, '15000.00', NULL, 0, 1, '2021-02-01 18:35:27', '2021-02-01 18:35:27', NULL, 1),
(15, 'FASTNET BUSINESS SMALL-15', NULL, 16, '20000.00', NULL, 0, 1, '2021-02-01 18:35:53', '2021-02-01 18:35:53', NULL, 1),
(16, 'FASTNET BUSINESS SMALL-18', NULL, 20, '28000.00', NULL, 0, 1, '2021-02-01 18:36:26', '2021-02-01 18:36:26', NULL, 1),
(17, 'FASTNET BUSINESS SMALL-25', NULL, 25, '35000.00', NULL, 0, 1, '2021-02-01 18:37:07', '2021-02-01 18:37:07', NULL, 1),
(18, 'FASTNET BUSINESS SMALL-35', NULL, 35, '45000.00', NULL, 0, 1, '2021-02-01 18:37:29', '2021-02-01 18:37:29', NULL, 1),
(20, 'INternet+TV', NULL, 30, '7000.00', 1, 0, 0, '2021-02-02 10:56:56', '2021-02-02 13:18:20', NULL, 1),
(21, 'TV', NULL, NULL, '3000.00', 2, 0, NULL, '2021-02-02 11:07:54', '2021-02-02 11:09:13', NULL, 1),
(22, 'SURFING-1-20MB', NULL, 20, '5000.00', NULL, 0, 0, '2021-02-02 15:52:49', '2021-02-02 15:52:49', NULL, 1),
(23, 'Surfing-2-5000', NULL, 15, '5000.00', NULL, 0, 0, '2021-02-02 16:50:40', '2021-02-02 16:50:40', NULL, 1),
(24, 'INTERNET-TV 2', NULL, 15, '5000.00', 1, 0, 0, '2021-02-03 17:19:08', '2021-02-03 17:19:08', 25, 1),
(25, 'FAST-SURFING1 4500', NULL, 25, '4500.00', 2, 0, NULL, '2021-02-04 16:00:22', '2021-02-04 16:00:22', NULL, 1),
(26, 'FAST-SURFING1 5000 (ՓԱԹԵԹ)', NULL, 25, '5000.00', 2, 0, 0, '2021-03-01 17:28:41', '2021-03-01 17:28:41', NULL, 1),
(27, 'Fast-Arlema 4500', NULL, 15, '4500.00', NULL, 0, 0, '2021-04-23 18:05:04', '2021-04-23 18:05:39', 20, 1),
(28, 'Fast-Arlema  4000', NULL, 15, '4000.00', NULL, 0, 0, '2021-04-23 18:06:16', '2021-04-23 18:06:16', NULL, 1),
(29, 'Fast-Arlema 5000', NULL, 15, '5000.00', NULL, 0, 0, '2021-04-23 18:06:41', '2021-04-23 18:06:41', NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `f_task`
--

CREATE TABLE IF NOT EXISTS `f_task` (
  `id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'Current user ID',
  `task_option_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `open_date` datetime DEFAULT NULL,
  `close_date` datetime DEFAULT NULL,
  `description` text,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_task_executor`
--

CREATE TABLE IF NOT EXISTS `f_task_executor` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `executor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_task_option`
--

CREATE TABLE IF NOT EXISTS `f_task_option` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_task_priority`
--

CREATE TABLE IF NOT EXISTS `f_task_priority` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_vacation_options`
--

CREATE TABLE IF NOT EXISTS `f_vacation_options` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_vacation_type`
--

CREATE TABLE IF NOT EXISTS `f_vacation_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_zone`
--

CREATE TABLE IF NOT EXISTS `f_zone` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_zone`
--

INSERT INTO `f_zone` (`id`, `name`, `country_id`) VALUES
(1, 'Երևան', 1),
(2, 'Էրեբունի', 1),
(3, '66', 1),
(4, '25', 1),
(6, 'Արգամ Գալստյան', 1),
(8, 'Մասիս', 1),
(9, 'Վահագ Արարատ', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `f_zone_cities`
--

CREATE TABLE IF NOT EXISTS `f_zone_cities` (
  `id` int(11) NOT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `f_zone_cities`
--

INSERT INTO `f_zone_cities` (`id`, `zone_id`, `city_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 4),
(4, 4, 3),
(5, 4, 7),
(6, 4, 8),
(7, 6, 3),
(8, 6, 7),
(9, 6, 8),
(10, 6, 2),
(11, 7, 19),
(12, 7, 18),
(13, 7, 25),
(14, 7, 26),
(21, 8, 28),
(22, 8, 29),
(23, 8, 31),
(24, 8, 27),
(25, 8, 19),
(26, 10, 5),
(27, 10, 8),
(28, 10, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `f_zone_community`
--

CREATE TABLE IF NOT EXISTS `f_zone_community` (
  `id` int(11) NOT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `community_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_zone_regions`
--

CREATE TABLE IF NOT EXISTS `f_zone_regions` (
  `id` int(11) NOT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `f_zone_street`
--

CREATE TABLE IF NOT EXISTS `f_zone_street` (
  `id` int(11) NOT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `street_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL,
  `old_state` varchar(255) DEFAULT NULL,
  `new_state` varchar(255) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `created_add` datetime DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `hr_class_departments`
--

CREATE TABLE IF NOT EXISTS `hr_class_departments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `internet`
--

CREATE TABLE IF NOT EXISTS `internet` (
  `id` int(11) NOT NULL,
  `speed` int(11) DEFAULT NULL,
  `inet_speed_unit_id` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `inet_size_unit_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `min_speed` int(11) DEFAULT NULL,
  `inet_min_speed_unit_id` int(11) DEFAULT NULL,
  `reset_speed_type` smallint(6) DEFAULT '0',
  `reset_speed` int(11) DEFAULT NULL,
  `reset_speed_unit_id` int(11) DEFAULT NULL,
  `size_empty_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ip_addresses`
--

CREATE TABLE IF NOT EXISTS `ip_addresses` (
  `id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `price` decimal(10,2) DEFAULT NULL,
  `base_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9084 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ip_addresses`
--

INSERT INTO `ip_addresses` (`id`, `address`, `status`, `price`, `base_id`) VALUES
(1, '10.51.192.22', 1, '1000.00', 1),
(2, '10.51.192.23', 1, '1000.00', 1),
(3, '10.51.192.24', 1, '1000.00', 1),
(4, '10.51.192.25', 1, '1000.00', 1),
(5, '10.51.192.26', 1, '1000.00', 1),
(6, '10.51.192.27', 1, '1000.00', 1),
(7, '10.51.192.28', 1, '1000.00', 1),
(8, '10.51.192.29', 1, '1000.00', 1),
(9, '10.51.192.30', 1, '1000.00', 1),
(10, '10.51.192.31', 1, '1000.00', 1),
(11, '10.51.192.32', 1, '1000.00', 1),
(12, '10.51.192.33', 1, '1000.00', 1),
(13, '10.51.192.34', 1, '1000.00', 1),
(14, '10.51.192.35', 1, '1000.00', 1),
(15, '10.51.192.36', 1, '1000.00', 1),
(16, '10.51.192.37', 1, '1000.00', 1),
(17, '10.51.192.38', 1, '1000.00', 1),
(18, '10.51.192.39', 1, '1000.00', 1),
(19, '10.51.192.40', 1, '1000.00', 1),
(20, '10.51.192.41', 1, '1000.00', 1),
(21, '10.51.192.42', 1, '1000.00', 1),
(22, '10.51.192.43', 1, '1000.00', 1),
(23, '10.51.192.44', 1, '1000.00', 1),
(24, '10.51.192.45', 1, '1000.00', 1),
(25, '10.51.192.46', 1, '1000.00', 1),
(26, '10.51.192.47', 1, '1000.00', 1),
(27, '10.51.192.48', 1, '1000.00', 1),
(28, '10.51.192.49', 1, '1000.00', 1),
(29, '10.51.192.50', 1, '1000.00', 1),
(30, '10.51.192.51', 1, '1000.00', 1),
(31, '10.51.192.52', 1, '1000.00', 1),
(32, '10.51.192.53', 1, '1000.00', 1),
(33, '10.51.192.54', 1, '1000.00', 1),
(34, '10.51.192.55', 1, '1000.00', 1),
(35, '10.51.192.56', 1, '1000.00', 1),
(36, '10.51.192.57', 1, '1000.00', 1),
(37, '10.51.192.58', 1, '1000.00', 1),
(38, '10.51.192.59', 1, '1000.00', 1),
(39, '10.51.192.60', 1, '1000.00', 1),
(40, '10.51.192.61', 1, '1000.00', 1),
(41, '10.51.192.62', 1, '1000.00', 1),
(42, '10.51.192.63', 1, '1000.00', 1),
(43, '10.51.192.64', 1, '1000.00', 1),
(44, '10.51.192.65', 1, '1000.00', 1),
(45, '10.51.192.66', 1, '1000.00', 1),
(46, '10.51.192.67', 1, '1000.00', 1),
(47, '10.51.192.68', 1, '1000.00', 1),
(48, '10.51.192.69', 1, '1000.00', 1),
(49, '10.51.192.70', 1, '1000.00', 1),
(50, '10.51.192.71', 1, '1000.00', 1),
(51, '10.51.192.72', 1, '1000.00', 1),
(52, '10.51.192.73', 1, '1000.00', 1),
(53, '10.51.192.74', 1, '1000.00', 1),
(54, '10.51.192.75', 1, '1000.00', 1),
(55, '10.51.192.76', 1, '1000.00', 1),
(56, '10.51.192.77', 1, '1000.00', 1),
(57, '10.51.192.78', 1, '1000.00', 1),
(58, '10.51.192.79', 1, '1000.00', 1),
(59, '10.51.192.80', 1, '1000.00', 1),
(60, '10.51.192.81', 1, '1000.00', 1),
(61, '10.51.192.82', 1, '1000.00', 1),
(62, '10.51.192.83', 1, '1000.00', 1),
(63, '10.51.192.84', 1, '1000.00', 1),
(64, '10.51.192.85', 1, '1000.00', 1),
(65, '10.51.192.86', 1, '1000.00', 1),
(66, '10.51.192.87', 1, '1000.00', 1),
(67, '10.51.192.88', 1, '1000.00', 1),
(68, '10.51.192.89', 1, '1000.00', 1),
(69, '10.51.192.90', 1, '1000.00', 1),
(70, '10.51.192.91', 1, '1000.00', 1),
(71, '10.51.192.92', 1, '1000.00', 1),
(72, '10.51.192.93', 1, '1000.00', 1),
(73, '10.51.192.94', 1, '1000.00', 1),
(74, '10.51.192.95', 1, '1000.00', 1),
(75, '10.51.192.96', 1, '1000.00', 1),
(76, '10.51.192.97', 1, '1000.00', 1),
(77, '10.51.192.98', 1, '1000.00', 1),
(78, '10.51.192.99', 1, '1000.00', 1),
(79, '10.51.192.100', 1, '1000.00', 1),
(80, '10.51.192.101', 1, '1000.00', 1),
(81, '10.51.192.102', 1, '1000.00', 1),
(82, '10.51.192.103', 1, '1000.00', 1),
(83, '10.51.192.104', 1, '1000.00', 1),
(84, '10.51.192.105', 1, '1000.00', 1),
(85, '10.51.192.106', 1, '1000.00', 1),
(86, '10.51.192.107', 1, '1000.00', 1),
(87, '10.51.192.108', 1, '1000.00', 1),
(88, '10.51.192.109', 1, '1000.00', 1),
(89, '10.51.192.110', 1, '1000.00', 1),
(90, '10.51.192.111', 1, '1000.00', 1),
(91, '10.51.192.112', 1, '1000.00', 1),
(92, '10.51.192.113', 1, '1000.00', 1),
(93, '10.51.192.114', 1, '1000.00', 1),
(94, '10.51.192.115', 1, '1000.00', 1),
(95, '10.51.192.116', 1, '1000.00', 1),
(96, '10.51.192.117', 1, '1000.00', 1),
(97, '10.51.192.118', 1, '1000.00', 1),
(98, '10.51.192.119', 1, '1000.00', 1),
(99, '10.51.192.120', 1, '1000.00', 1),
(100, '10.51.192.121', 1, '1000.00', 1),
(101, '10.51.192.122', 1, '1000.00', 1),
(102, '10.51.192.123', 1, '1000.00', 1),
(103, '10.51.192.124', 1, '1000.00', 1),
(104, '10.51.192.125', 1, '1000.00', 1),
(105, '10.51.192.126', 1, '1000.00', 1),
(106, '10.51.192.127', 1, '1000.00', 1),
(107, '10.51.192.128', 1, '1000.00', 1),
(108, '10.51.192.129', 1, '1000.00', 1),
(109, '10.51.192.130', 1, '1000.00', 1),
(110, '10.51.192.131', 1, '1000.00', 1),
(111, '10.51.192.132', 1, '1000.00', 1),
(112, '10.51.192.133', 1, '1000.00', 1),
(113, '10.51.192.134', 1, '1000.00', 1),
(114, '10.51.192.135', 1, '1000.00', 1),
(115, '10.51.192.136', 1, '1000.00', 1),
(116, '10.51.192.137', 1, '1000.00', 1),
(117, '10.51.192.138', 1, '1000.00', 1),
(118, '10.51.192.139', 1, '1000.00', 1),
(119, '10.51.192.140', 1, '1000.00', 1),
(120, '10.51.192.141', 1, '1000.00', 1),
(121, '10.51.192.142', 1, '1000.00', 1),
(122, '10.51.192.143', 1, '1000.00', 1),
(123, '10.51.192.144', 1, '1000.00', 1),
(124, '10.51.192.145', 1, '1000.00', 1),
(125, '10.51.192.146', 1, '1000.00', 1),
(126, '10.51.192.147', 1, '1000.00', 1),
(127, '10.51.192.148', 1, '1000.00', 1),
(128, '10.51.192.149', 1, '1000.00', 1),
(129, '10.51.192.150', 1, '1000.00', 1),
(130, '10.51.192.151', 1, '1000.00', 1),
(131, '10.51.192.152', 1, '1000.00', 1),
(132, '10.51.192.153', 1, '1000.00', 1),
(133, '10.51.192.154', 1, '1000.00', 1),
(134, '10.51.192.155', 1, '1000.00', 1),
(135, '10.51.192.156', 1, '1000.00', 1),
(136, '10.51.192.157', 1, '1000.00', 1),
(137, '10.51.192.158', 1, '1000.00', 1),
(138, '10.51.192.159', 1, '1000.00', 1),
(139, '10.51.192.160', 1, '1000.00', 1),
(140, '10.51.192.161', 1, '1000.00', 1),
(141, '10.51.192.162', 1, '1000.00', 1),
(142, '10.51.192.163', 1, '1000.00', 1),
(143, '10.51.192.164', 1, '1000.00', 1),
(144, '10.51.192.165', 1, '1000.00', 1),
(145, '10.51.192.166', 1, '1000.00', 1),
(146, '10.51.192.167', 1, '1000.00', 1),
(147, '10.51.192.168', 1, '1000.00', 1),
(148, '10.51.192.169', 1, '1000.00', 1),
(149, '10.51.192.170', 1, '1000.00', 1),
(150, '10.51.192.171', 1, '1000.00', 1),
(151, '10.51.192.172', 1, '1000.00', 1),
(152, '10.51.192.173', 1, '1000.00', 1),
(153, '10.51.192.174', 1, '1000.00', 1),
(154, '10.51.192.175', 1, '1000.00', 1),
(155, '10.51.192.176', 1, '1000.00', 1),
(156, '10.51.192.177', 1, '1000.00', 1),
(157, '10.51.192.178', 1, '1000.00', 1),
(158, '10.51.192.179', 1, '1000.00', 1),
(159, '10.51.192.180', 1, '1000.00', 1),
(160, '10.51.192.181', 1, '1000.00', 1),
(161, '10.51.192.182', 1, '1000.00', 1),
(162, '10.51.192.183', 1, '1000.00', 1),
(163, '10.51.192.184', 1, '1000.00', 1),
(164, '10.51.192.185', 1, '1000.00', 1),
(165, '10.51.192.186', 1, '1000.00', 1),
(166, '10.51.192.187', 1, '1000.00', 1),
(167, '10.51.192.188', 1, '1000.00', 1),
(168, '10.51.192.189', 1, '1000.00', 1),
(169, '10.51.192.190', 1, '1000.00', 1),
(170, '10.51.192.191', 1, '1000.00', 1),
(171, '10.51.192.192', 1, '1000.00', 1),
(172, '10.51.192.193', 1, '1000.00', 1),
(173, '10.51.192.194', 1, '1000.00', 1),
(174, '10.51.192.195', 1, '1000.00', 1),
(175, '10.51.192.196', 1, '1000.00', 1),
(176, '10.51.192.197', 1, '1000.00', 1),
(177, '10.51.192.198', 1, '1000.00', 1),
(178, '10.51.192.199', 1, '1000.00', 1),
(179, '10.51.192.200', 1, '1000.00', 1),
(180, '10.51.192.201', 1, '1000.00', 1),
(181, '10.51.192.202', 1, '1000.00', 1),
(182, '10.51.192.203', 1, '1000.00', 1),
(183, '10.51.192.204', 1, '1000.00', 1),
(184, '10.51.192.205', 1, '1000.00', 1),
(185, '10.51.192.206', 1, '1000.00', 1),
(186, '10.51.192.207', 1, '1000.00', 1),
(187, '10.51.192.208', 1, '1000.00', 1),
(188, '10.51.192.209', 1, '1000.00', 1),
(189, '10.51.192.210', 1, '1000.00', 1),
(190, '10.51.192.211', 1, '1000.00', 1),
(191, '10.51.192.212', 1, '1000.00', 1),
(192, '10.51.192.213', 1, '1000.00', 1),
(193, '10.51.192.214', 1, '1000.00', 1),
(194, '10.51.192.215', 1, '1000.00', 1),
(195, '10.51.192.216', 1, '1000.00', 1),
(196, '10.51.192.217', 1, '1000.00', 1),
(197, '10.51.192.218', 1, '1000.00', 1),
(198, '10.51.192.219', 1, '1000.00', 1),
(199, '10.51.192.220', 1, '1000.00', 1),
(200, '10.51.192.221', 1, '1000.00', 1),
(201, '10.51.192.222', 1, '1000.00', 1),
(202, '10.51.192.223', 1, '1000.00', 1),
(203, '10.51.192.224', 1, '1000.00', 1),
(204, '10.51.192.225', 1, '1000.00', 1),
(205, '10.51.192.226', 1, '1000.00', 1),
(206, '10.51.192.227', 1, '1000.00', 1),
(207, '10.51.192.228', 1, '1000.00', 1),
(208, '10.51.192.229', 1, '1000.00', 1),
(209, '10.51.192.230', 1, '1000.00', 1),
(210, '10.51.192.231', 1, '1000.00', 1),
(211, '10.51.192.232', 1, '1000.00', 1),
(212, '10.51.192.233', 1, '1000.00', 1),
(213, '10.51.192.234', 1, '1000.00', 1),
(214, '10.51.192.235', 1, '1000.00', 1),
(215, '10.51.192.236', 1, '1000.00', 1),
(216, '10.51.192.237', 1, '1000.00', 1),
(217, '10.51.192.238', 1, '1000.00', 1),
(218, '10.51.192.239', 1, '1000.00', 1),
(219, '10.51.192.240', 1, '1000.00', 1),
(220, '10.51.192.241', 1, '1000.00', 1),
(221, '10.51.192.242', 1, '1000.00', 1),
(222, '10.51.192.243', 1, '1000.00', 1),
(223, '10.51.192.244', 1, '1000.00', 1),
(224, '10.51.192.245', 1, '1000.00', 1),
(225, '10.51.192.246', 1, '1000.00', 1),
(226, '10.51.192.247', 1, '1000.00', 1),
(227, '10.51.192.248', 1, '1000.00', 1),
(228, '10.51.192.249', 1, '1000.00', 1),
(229, '10.51.192.250', 1, '1000.00', 1),
(230, '10.51.192.251', 1, '1000.00', 1),
(231, '10.51.192.252', 1, '1000.00', 1),
(232, '10.51.192.253', 1, '1000.00', 1),
(233, '10.51.192.254', 1, '1000.00', 1),
(234, '10.51.169.2', 3, '1000.00', 2),
(235, '10.51.169.3', 1, '1000.00', 2),
(236, '10.51.169.4', 3, '1000.00', 2),
(237, '10.51.169.5', 3, '1000.00', 2),
(238, '10.51.169.6', 3, '1000.00', 2),
(239, '10.51.169.7', 3, '1000.00', 2),
(240, '10.51.169.8', 3, '1000.00', 2),
(241, '10.51.169.9', 1, '1000.00', 2),
(242, '10.51.169.10', 1, '1000.00', 2),
(243, '10.51.169.11', 1, '1000.00', 2),
(244, '10.51.169.12', 1, '1000.00', 2),
(245, '10.51.169.13', 1, '1000.00', 2),
(246, '10.51.169.14', 1, '1000.00', 2),
(247, '10.51.169.15', 1, '1000.00', 2),
(248, '10.51.169.16', 1, '1000.00', 2),
(249, '10.51.169.17', 1, '1000.00', 2),
(250, '10.51.169.18', 1, '1000.00', 2),
(251, '10.51.169.19', 1, '1000.00', 2),
(252, '10.51.169.20', 1, '1000.00', 2),
(253, '10.51.169.21', 1, '1000.00', 2),
(254, '10.51.169.22', 1, '1000.00', 2),
(255, '10.51.169.23', 1, '1000.00', 2),
(256, '10.51.169.24', 1, '1000.00', 2),
(257, '10.51.169.25', 1, '1000.00', 2),
(258, '10.51.169.26', 1, '1000.00', 2),
(259, '10.51.169.27', 1, '1000.00', 2),
(260, '10.51.169.28', 1, '1000.00', 2),
(261, '10.51.169.29', 1, '1000.00', 2),
(262, '10.51.169.30', 1, '1000.00', 2),
(263, '10.51.169.31', 1, '1000.00', 2),
(264, '10.51.169.32', 1, '1000.00', 2),
(265, '10.51.169.33', 1, '1000.00', 2),
(266, '10.51.169.34', 1, '1000.00', 2),
(267, '10.51.169.35', 1, '1000.00', 2),
(268, '10.51.169.36', 1, '1000.00', 2),
(269, '10.51.169.37', 1, '1000.00', 2),
(270, '10.51.169.38', 1, '1000.00', 2),
(271, '10.51.169.39', 1, '1000.00', 2),
(272, '10.51.169.40', 1, '1000.00', 2),
(273, '10.51.169.41', 1, '1000.00', 2),
(274, '10.51.169.42', 1, '1000.00', 2),
(275, '10.51.169.43', 1, '1000.00', 2),
(276, '10.51.169.44', 1, '1000.00', 2),
(277, '10.51.169.45', 1, '1000.00', 2),
(278, '10.51.169.46', 1, '1000.00', 2),
(279, '10.51.169.47', 1, '1000.00', 2),
(280, '10.51.169.48', 1, '1000.00', 2),
(281, '10.51.169.49', 1, '1000.00', 2),
(282, '10.51.169.50', 1, '1000.00', 2),
(283, '10.51.169.51', 1, '1000.00', 2),
(284, '10.51.169.52', 1, '1000.00', 2),
(285, '10.51.169.53', 1, '1000.00', 2),
(286, '10.51.169.54', 1, '1000.00', 2),
(287, '10.51.169.55', 1, '1000.00', 2),
(288, '10.51.169.56', 1, '1000.00', 2),
(289, '10.51.169.57', 1, '1000.00', 2),
(290, '10.51.169.58', 1, '1000.00', 2),
(291, '10.51.169.59', 1, '1000.00', 2),
(292, '10.51.169.60', 1, '1000.00', 2),
(293, '10.51.169.61', 1, '1000.00', 2),
(294, '10.51.169.62', 1, '1000.00', 2),
(295, '10.51.169.63', 1, '1000.00', 2),
(296, '10.51.169.64', 1, '1000.00', 2),
(297, '10.51.169.65', 1, '1000.00', 2),
(298, '10.51.169.66', 1, '1000.00', 2),
(299, '10.51.169.67', 1, '1000.00', 2),
(300, '10.51.169.68', 1, '1000.00', 2),
(301, '10.51.169.69', 1, '1000.00', 2),
(302, '10.51.169.70', 1, '1000.00', 2),
(303, '10.51.169.71', 1, '1000.00', 2),
(304, '10.51.169.72', 1, '1000.00', 2),
(305, '10.51.169.73', 1, '1000.00', 2),
(306, '10.51.169.74', 1, '1000.00', 2),
(307, '10.51.169.75', 1, '1000.00', 2),
(308, '10.51.169.76', 1, '1000.00', 2),
(309, '10.51.169.77', 1, '1000.00', 2),
(310, '10.51.169.78', 1, '1000.00', 2),
(311, '10.51.169.79', 1, '1000.00', 2),
(312, '10.51.169.80', 1, '1000.00', 2),
(313, '10.51.169.81', 1, '1000.00', 2),
(314, '10.51.169.82', 1, '1000.00', 2),
(315, '10.51.169.83', 1, '1000.00', 2),
(316, '10.51.169.84', 1, '1000.00', 2),
(317, '10.51.169.85', 1, '1000.00', 2),
(318, '10.51.169.86', 1, '1000.00', 2),
(319, '10.51.169.87', 1, '1000.00', 2),
(320, '10.51.169.88', 1, '1000.00', 2),
(321, '10.51.169.89', 1, '1000.00', 2),
(322, '10.51.169.90', 1, '1000.00', 2),
(323, '10.51.169.91', 1, '1000.00', 2),
(324, '10.51.169.92', 1, '1000.00', 2),
(325, '10.51.169.93', 1, '1000.00', 2),
(326, '10.51.169.94', 1, '1000.00', 2),
(327, '10.51.169.95', 1, '1000.00', 2),
(328, '10.51.169.96', 1, '1000.00', 2),
(329, '10.51.169.97', 1, '1000.00', 2),
(330, '10.51.169.98', 1, '1000.00', 2),
(331, '10.51.169.99', 1, '1000.00', 2),
(332, '10.51.169.100', 1, '1000.00', 2),
(333, '10.51.169.101', 1, '1000.00', 2),
(334, '10.51.169.102', 1, '1000.00', 2),
(335, '10.51.169.103', 1, '1000.00', 2),
(336, '10.51.169.104', 1, '1000.00', 2),
(337, '10.51.169.105', 1, '1000.00', 2),
(338, '10.51.169.106', 1, '1000.00', 2),
(339, '10.51.169.107', 1, '1000.00', 2),
(340, '10.51.169.108', 1, '1000.00', 2),
(341, '10.51.169.109', 1, '1000.00', 2),
(342, '10.51.169.110', 1, '1000.00', 2),
(343, '10.51.169.111', 1, '1000.00', 2),
(344, '10.51.169.112', 1, '1000.00', 2),
(345, '10.51.169.113', 1, '1000.00', 2),
(346, '10.51.169.114', 1, '1000.00', 2),
(347, '10.51.169.115', 1, '1000.00', 2),
(348, '10.51.169.116', 1, '1000.00', 2),
(349, '10.51.169.117', 1, '1000.00', 2),
(350, '10.51.169.118', 1, '1000.00', 2),
(351, '10.51.169.119', 1, '1000.00', 2),
(352, '10.51.169.120', 1, '1000.00', 2),
(353, '10.51.169.121', 1, '1000.00', 2),
(354, '10.51.169.122', 1, '1000.00', 2),
(355, '10.51.169.123', 1, '1000.00', 2),
(356, '10.51.169.124', 1, '1000.00', 2),
(357, '10.51.169.125', 1, '1000.00', 2),
(358, '10.51.169.126', 1, '1000.00', 2),
(359, '10.51.169.127', 1, '1000.00', 2),
(360, '10.51.169.128', 1, '1000.00', 2),
(361, '10.51.169.129', 1, '1000.00', 2),
(362, '10.51.169.130', 1, '1000.00', 2),
(363, '10.51.169.131', 1, '1000.00', 2),
(364, '10.51.169.132', 1, '1000.00', 2),
(365, '10.51.169.133', 1, '1000.00', 2),
(366, '10.51.169.134', 1, '1000.00', 2),
(367, '10.51.169.135', 1, '1000.00', 2),
(368, '10.51.169.136', 1, '1000.00', 2),
(369, '10.51.169.137', 1, '1000.00', 2),
(370, '10.51.169.138', 1, '1000.00', 2),
(371, '10.51.169.139', 1, '1000.00', 2),
(372, '10.51.169.140', 1, '1000.00', 2),
(373, '10.51.169.141', 1, '1000.00', 2),
(374, '10.51.169.142', 1, '1000.00', 2),
(375, '10.51.169.143', 1, '1000.00', 2),
(376, '10.51.169.144', 1, '1000.00', 2),
(377, '10.51.169.145', 1, '1000.00', 2),
(378, '10.51.169.146', 1, '1000.00', 2),
(379, '10.51.169.147', 1, '1000.00', 2),
(380, '10.51.169.148', 1, '1000.00', 2),
(381, '10.51.169.149', 1, '1000.00', 2),
(382, '10.51.169.150', 1, '1000.00', 2),
(383, '10.51.169.151', 1, '1000.00', 2),
(384, '10.51.169.152', 1, '1000.00', 2),
(385, '10.51.169.153', 1, '1000.00', 2),
(386, '10.51.169.154', 1, '1000.00', 2),
(387, '10.51.169.155', 1, '1000.00', 2),
(388, '10.51.169.156', 1, '1000.00', 2),
(389, '10.51.169.157', 1, '1000.00', 2),
(390, '10.51.169.158', 1, '1000.00', 2),
(391, '10.51.169.159', 1, '1000.00', 2),
(392, '10.51.169.160', 1, '1000.00', 2),
(393, '10.51.169.161', 1, '1000.00', 2),
(394, '10.51.169.162', 1, '1000.00', 2),
(395, '10.51.169.163', 1, '1000.00', 2),
(396, '10.51.169.164', 1, '1000.00', 2),
(397, '10.51.169.165', 1, '1000.00', 2),
(398, '10.51.169.166', 1, '1000.00', 2),
(399, '10.51.169.167', 1, '1000.00', 2),
(400, '10.51.169.168', 1, '1000.00', 2),
(401, '10.51.169.169', 1, '1000.00', 2),
(402, '10.51.169.170', 1, '1000.00', 2),
(403, '10.51.169.171', 1, '1000.00', 2),
(404, '10.51.169.172', 1, '1000.00', 2),
(405, '10.51.169.173', 1, '1000.00', 2),
(406, '10.51.169.174', 1, '1000.00', 2),
(407, '10.51.169.175', 1, '1000.00', 2),
(408, '10.51.169.176', 1, '1000.00', 2),
(409, '10.51.169.177', 1, '1000.00', 2),
(410, '10.51.169.178', 1, '1000.00', 2),
(411, '10.51.169.179', 1, '1000.00', 2),
(412, '10.51.169.180', 1, '1000.00', 2),
(413, '10.51.169.181', 1, '1000.00', 2),
(414, '10.51.169.182', 1, '1000.00', 2),
(415, '10.51.169.183', 1, '1000.00', 2),
(416, '10.51.169.184', 1, '1000.00', 2),
(417, '10.51.169.185', 1, '1000.00', 2),
(418, '10.51.169.186', 1, '1000.00', 2),
(419, '10.51.169.187', 1, '1000.00', 2),
(420, '10.51.169.188', 1, '1000.00', 2),
(421, '10.51.169.189', 1, '1000.00', 2),
(422, '10.51.169.190', 1, '1000.00', 2),
(423, '10.51.169.191', 1, '1000.00', 2),
(424, '10.51.169.192', 1, '1000.00', 2),
(425, '10.51.169.193', 1, '1000.00', 2),
(426, '10.51.169.194', 1, '1000.00', 2),
(427, '10.51.169.195', 1, '1000.00', 2),
(428, '10.51.169.196', 1, '1000.00', 2),
(429, '10.51.169.197', 1, '1000.00', 2),
(430, '10.51.169.198', 1, '1000.00', 2),
(431, '10.51.169.199', 1, '1000.00', 2),
(432, '10.51.169.200', 1, '1000.00', 2),
(433, '10.51.169.201', 1, '1000.00', 2),
(434, '10.51.169.202', 1, '1000.00', 2),
(435, '10.51.169.203', 1, '1000.00', 2),
(436, '10.51.169.204', 1, '1000.00', 2),
(437, '10.51.169.205', 1, '1000.00', 2),
(438, '10.51.169.206', 1, '1000.00', 2),
(439, '10.51.169.207', 1, '1000.00', 2),
(440, '10.51.169.208', 1, '1000.00', 2),
(441, '10.51.169.209', 1, '1000.00', 2),
(442, '10.51.169.210', 1, '1000.00', 2),
(443, '10.51.169.211', 1, '1000.00', 2),
(444, '10.51.169.212', 1, '1000.00', 2),
(445, '10.51.169.213', 1, '1000.00', 2),
(446, '10.51.169.214', 1, '1000.00', 2),
(447, '10.51.169.215', 1, '1000.00', 2),
(448, '10.51.169.216', 1, '1000.00', 2),
(449, '10.51.169.217', 1, '1000.00', 2),
(450, '10.51.169.218', 1, '1000.00', 2),
(451, '10.51.169.219', 1, '1000.00', 2),
(452, '10.51.169.220', 1, '1000.00', 2),
(453, '10.51.169.221', 1, '1000.00', 2),
(454, '10.51.169.222', 1, '1000.00', 2),
(455, '10.51.169.223', 1, '1000.00', 2),
(456, '10.51.169.224', 1, '1000.00', 2),
(457, '10.51.169.225', 1, '1000.00', 2),
(458, '10.51.169.226', 1, '1000.00', 2),
(459, '10.51.169.227', 1, '1000.00', 2),
(460, '10.51.169.228', 1, '1000.00', 2),
(461, '10.51.169.229', 1, '1000.00', 2),
(462, '10.51.169.230', 1, '1000.00', 2),
(463, '10.51.169.231', 1, '1000.00', 2),
(464, '10.51.169.232', 1, '1000.00', 2),
(465, '10.51.169.233', 1, '1000.00', 2),
(466, '10.51.169.234', 1, '1000.00', 2),
(467, '10.51.169.235', 1, '1000.00', 2),
(468, '10.51.169.236', 1, '1000.00', 2),
(469, '10.51.169.237', 1, '1000.00', 2),
(470, '10.51.169.238', 1, '1000.00', 2),
(471, '10.51.169.239', 1, '1000.00', 2),
(472, '10.51.169.240', 1, '1000.00', 2),
(473, '10.51.169.241', 1, '1000.00', 2),
(474, '10.51.169.242', 1, '1000.00', 2),
(475, '10.51.169.243', 1, '1000.00', 2),
(476, '10.51.169.244', 1, '1000.00', 2),
(477, '10.51.169.245', 1, '1000.00', 2),
(478, '10.51.169.246', 1, '1000.00', 2),
(479, '10.51.169.247', 1, '1000.00', 2),
(480, '10.51.169.248', 1, '1000.00', 2),
(481, '10.51.169.249', 1, '1000.00', 2),
(482, '10.51.169.250', 1, '1000.00', 2),
(483, '10.51.169.251', 1, '1000.00', 2),
(484, '10.51.169.252', 1, '1000.00', 2),
(485, '10.51.169.253', 1, '1000.00', 2),
(486, '10.51.169.254', 1, '1000.00', 2),
(740, '10.51.39.2', 1, '1000.00', 3),
(755, '10.51.39.17', 3, '1000.00', 3),
(768, '10.51.39.30', 1, '1000.00', 3),
(774, '10.51.39.36', 3, '1000.00', 3),
(787, '10.51.39.49', 1, '1000.00', 3),
(794, '10.51.39.56', 1, '1000.00', 3),
(808, '10.51.39.70', 1, '1000.00', 3),
(819, '10.51.39.81', 1, '1000.00', 3),
(833, '10.51.39.95', 1, '1000.00', 3),
(842, '10.51.39.104', 1, '1000.00', 3),
(846, '10.51.39.108', 1, '1000.00', 3),
(849, '10.51.39.111', 1, '1000.00', 3),
(993, '10.51.177.2', 1, '1000.00', 4),
(994, '10.51.177.3', 1, '1000.00', 4),
(995, '10.51.177.4', 3, '1000.00', 4),
(996, '10.51.177.5', 1, '1000.00', 4),
(997, '10.51.177.6', 1, '1000.00', 4),
(998, '10.51.177.7', 1, '1000.00', 4),
(999, '10.51.177.8', 1, '1000.00', 4),
(1000, '10.51.177.9', 1, '1000.00', 4),
(1001, '10.51.177.10', 1, '1000.00', 4),
(1002, '10.51.177.11', 1, '1000.00', 4),
(1003, '10.51.177.12', 1, '1000.00', 4),
(1004, '10.51.177.13', 1, '1000.00', 4),
(1005, '10.51.177.14', 1, '1000.00', 4),
(1006, '10.51.177.15', 1, '1000.00', 4),
(1007, '10.51.177.16', 1, '1000.00', 4),
(1008, '10.51.177.17', 1, '1000.00', 4),
(1009, '10.51.177.18', 1, '1000.00', 4),
(1010, '10.51.177.19', 1, '1000.00', 4),
(1011, '10.51.177.20', 1, '1000.00', 4),
(1012, '10.51.177.21', 1, '1000.00', 4),
(1013, '10.51.177.22', 1, '1000.00', 4),
(1014, '10.51.177.23', 1, '1000.00', 4),
(1015, '10.51.177.24', 1, '1000.00', 4),
(1016, '10.51.177.25', 1, '1000.00', 4),
(1017, '10.51.177.26', 1, '1000.00', 4),
(1018, '10.51.177.27', 1, '1000.00', 4),
(1019, '10.51.177.28', 1, '1000.00', 4),
(1020, '10.51.177.29', 1, '1000.00', 4),
(1021, '10.51.177.30', 1, '1000.00', 4),
(1022, '10.51.177.31', 1, '1000.00', 4),
(1023, '10.51.177.32', 1, '1000.00', 4),
(1024, '10.51.177.33', 1, '1000.00', 4),
(1025, '10.51.177.34', 1, '1000.00', 4),
(1026, '10.51.177.35', 1, '1000.00', 4),
(1027, '10.51.177.36', 1, '1000.00', 4),
(1028, '10.51.177.37', 1, '1000.00', 4),
(1029, '10.51.177.38', 1, '1000.00', 4),
(1030, '10.51.177.39', 1, '1000.00', 4),
(1031, '10.51.177.40', 1, '1000.00', 4),
(1032, '10.51.177.41', 1, '1000.00', 4),
(1033, '10.51.177.42', 1, '1000.00', 4),
(1034, '10.51.177.43', 1, '1000.00', 4),
(1035, '10.51.177.44', 1, '1000.00', 4),
(1036, '10.51.177.45', 1, '1000.00', 4),
(1037, '10.51.177.46', 1, '1000.00', 4),
(1038, '10.51.177.47', 1, '1000.00', 4),
(1039, '10.51.177.48', 1, '1000.00', 4),
(1040, '10.51.177.49', 1, '1000.00', 4),
(1041, '10.51.177.50', 1, '1000.00', 4),
(1042, '10.51.177.51', 1, '1000.00', 4),
(1043, '10.51.177.52', 1, '1000.00', 4),
(1044, '10.51.177.53', 1, '1000.00', 4),
(1045, '10.51.177.54', 1, '1000.00', 4),
(1046, '10.51.177.55', 1, '1000.00', 4),
(1047, '10.51.177.56', 1, '1000.00', 4),
(1048, '10.51.177.57', 1, '1000.00', 4),
(1049, '10.51.177.58', 1, '1000.00', 4),
(1050, '10.51.177.59', 1, '1000.00', 4),
(1051, '10.51.177.60', 1, '1000.00', 4),
(1052, '10.51.177.61', 1, '1000.00', 4),
(1053, '10.51.177.62', 1, '1000.00', 4),
(1054, '10.51.177.63', 1, '1000.00', 4),
(1055, '10.51.177.64', 1, '1000.00', 4),
(1056, '10.51.177.65', 1, '1000.00', 4),
(1057, '10.51.177.66', 1, '1000.00', 4),
(1058, '10.51.177.67', 1, '1000.00', 4),
(1059, '10.51.177.68', 1, '1000.00', 4),
(1060, '10.51.177.69', 1, '1000.00', 4),
(1061, '10.51.177.70', 1, '1000.00', 4),
(1062, '10.51.177.71', 1, '1000.00', 4),
(1063, '10.51.177.72', 1, '1000.00', 4),
(1064, '10.51.177.73', 1, '1000.00', 4),
(1065, '10.51.177.74', 1, '1000.00', 4),
(1066, '10.51.177.75', 1, '1000.00', 4),
(1067, '10.51.177.76', 1, '1000.00', 4),
(1068, '10.51.177.77', 1, '1000.00', 4),
(1069, '10.51.177.78', 1, '1000.00', 4),
(1070, '10.51.177.79', 1, '1000.00', 4),
(1071, '10.51.177.80', 1, '1000.00', 4),
(1072, '10.51.177.81', 1, '1000.00', 4),
(1073, '10.51.177.82', 1, '1000.00', 4),
(1074, '10.51.177.83', 1, '1000.00', 4),
(1075, '10.51.177.84', 1, '1000.00', 4),
(1076, '10.51.177.85', 1, '1000.00', 4),
(1077, '10.51.177.86', 1, '1000.00', 4),
(1078, '10.51.177.87', 1, '1000.00', 4),
(1079, '10.51.177.88', 1, '1000.00', 4),
(1080, '10.51.177.89', 1, '1000.00', 4),
(1081, '10.51.177.90', 1, '1000.00', 4),
(1082, '10.51.177.91', 1, '1000.00', 4),
(1083, '10.51.177.92', 1, '1000.00', 4),
(1084, '10.51.177.93', 1, '1000.00', 4),
(1085, '10.51.177.94', 1, '1000.00', 4),
(1086, '10.51.177.95', 1, '1000.00', 4),
(1087, '10.51.177.96', 1, '1000.00', 4),
(1088, '10.51.177.97', 1, '1000.00', 4),
(1089, '10.51.177.98', 1, '1000.00', 4),
(1090, '10.51.177.99', 1, '1000.00', 4),
(1091, '10.51.177.100', 1, '1000.00', 4),
(1092, '10.51.177.101', 1, '1000.00', 4),
(1093, '10.51.177.102', 1, '1000.00', 4),
(1094, '10.51.177.103', 1, '1000.00', 4),
(1095, '10.51.177.104', 1, '1000.00', 4),
(1096, '10.51.177.105', 1, '1000.00', 4),
(1097, '10.51.177.106', 1, '1000.00', 4),
(1098, '10.51.177.107', 1, '1000.00', 4),
(1099, '10.51.177.108', 1, '1000.00', 4),
(1100, '10.51.177.109', 1, '1000.00', 4),
(1101, '10.51.177.110', 1, '1000.00', 4),
(1102, '10.51.177.111', 1, '1000.00', 4),
(1103, '10.51.177.112', 1, '1000.00', 4),
(1104, '10.51.177.113', 1, '1000.00', 4),
(1105, '10.51.177.114', 1, '1000.00', 4),
(1106, '10.51.177.115', 1, '1000.00', 4),
(1107, '10.51.177.116', 1, '1000.00', 4),
(1108, '10.51.177.117', 1, '1000.00', 4),
(1109, '10.51.177.118', 1, '1000.00', 4),
(1110, '10.51.177.119', 1, '1000.00', 4),
(1111, '10.51.177.120', 1, '1000.00', 4),
(1112, '10.51.177.121', 1, '1000.00', 4),
(1113, '10.51.177.122', 1, '1000.00', 4),
(1114, '10.51.177.123', 1, '1000.00', 4),
(1115, '10.51.177.124', 1, '1000.00', 4),
(1116, '10.51.177.125', 1, '1000.00', 4),
(1117, '10.51.177.126', 1, '1000.00', 4),
(1118, '10.51.177.127', 1, '1000.00', 4),
(1119, '10.51.177.128', 1, '1000.00', 4),
(1120, '10.51.177.129', 1, '1000.00', 4),
(1121, '10.51.177.130', 1, '1000.00', 4),
(1122, '10.51.177.131', 1, '1000.00', 4),
(1123, '10.51.177.132', 1, '1000.00', 4),
(1124, '10.51.177.133', 1, '1000.00', 4),
(1125, '10.51.177.134', 1, '1000.00', 4),
(1126, '10.51.177.135', 1, '1000.00', 4),
(1127, '10.51.177.136', 1, '1000.00', 4),
(1128, '10.51.177.137', 1, '1000.00', 4),
(1129, '10.51.177.138', 1, '1000.00', 4),
(1130, '10.51.177.139', 1, '1000.00', 4),
(1131, '10.51.177.140', 1, '1000.00', 4),
(1132, '10.51.177.141', 1, '1000.00', 4),
(1133, '10.51.177.142', 1, '1000.00', 4),
(1134, '10.51.177.143', 1, '1000.00', 4),
(1135, '10.51.177.144', 1, '1000.00', 4),
(1136, '10.51.177.145', 1, '1000.00', 4),
(1137, '10.51.177.146', 1, '1000.00', 4),
(1138, '10.51.177.147', 1, '1000.00', 4),
(1139, '10.51.177.148', 1, '1000.00', 4),
(1140, '10.51.177.149', 1, '1000.00', 4),
(1141, '10.51.177.150', 1, '1000.00', 4),
(1142, '10.51.177.151', 1, '1000.00', 4),
(1143, '10.51.177.152', 1, '1000.00', 4),
(1144, '10.51.177.153', 1, '1000.00', 4),
(1145, '10.51.177.154', 1, '1000.00', 4),
(1146, '10.51.177.155', 1, '1000.00', 4),
(1147, '10.51.177.156', 1, '1000.00', 4),
(1148, '10.51.177.157', 1, '1000.00', 4),
(1149, '10.51.177.158', 1, '1000.00', 4),
(1150, '10.51.177.159', 1, '1000.00', 4),
(1151, '10.51.177.160', 1, '1000.00', 4),
(1152, '10.51.177.161', 1, '1000.00', 4),
(1153, '10.51.177.162', 1, '1000.00', 4),
(1154, '10.51.177.163', 1, '1000.00', 4),
(1155, '10.51.177.164', 1, '1000.00', 4),
(1156, '10.51.177.165', 1, '1000.00', 4),
(1157, '10.51.177.166', 1, '1000.00', 4),
(1158, '10.51.177.167', 1, '1000.00', 4),
(1159, '10.51.177.168', 1, '1000.00', 4),
(1160, '10.51.177.169', 1, '1000.00', 4),
(1161, '10.51.177.170', 1, '1000.00', 4),
(1162, '10.51.177.171', 1, '1000.00', 4),
(1163, '10.51.177.172', 1, '1000.00', 4),
(1164, '10.51.177.173', 1, '1000.00', 4),
(1165, '10.51.177.174', 1, '1000.00', 4),
(1166, '10.51.177.175', 1, '1000.00', 4),
(1167, '10.51.177.176', 1, '1000.00', 4),
(1168, '10.51.177.177', 1, '1000.00', 4),
(1169, '10.51.177.178', 1, '1000.00', 4),
(1170, '10.51.177.179', 1, '1000.00', 4),
(1171, '10.51.177.180', 1, '1000.00', 4),
(1172, '10.51.177.181', 1, '1000.00', 4),
(1173, '10.51.177.182', 1, '1000.00', 4),
(1174, '10.51.177.183', 1, '1000.00', 4),
(1175, '10.51.177.184', 1, '1000.00', 4),
(1176, '10.51.177.185', 1, '1000.00', 4),
(1177, '10.51.177.186', 1, '1000.00', 4),
(1178, '10.51.177.187', 1, '1000.00', 4),
(1179, '10.51.177.188', 1, '1000.00', 4),
(1180, '10.51.177.189', 1, '1000.00', 4),
(1181, '10.51.177.190', 1, '1000.00', 4),
(1182, '10.51.177.191', 1, '1000.00', 4),
(1183, '10.51.177.192', 1, '1000.00', 4),
(1184, '10.51.177.193', 1, '1000.00', 4),
(1185, '10.51.177.194', 1, '1000.00', 4),
(1186, '10.51.177.195', 1, '1000.00', 4),
(1187, '10.51.177.196', 1, '1000.00', 4),
(1188, '10.51.177.197', 1, '1000.00', 4),
(1189, '10.51.177.198', 1, '1000.00', 4),
(1190, '10.51.177.199', 1, '1000.00', 4),
(1191, '10.51.177.200', 1, '1000.00', 4),
(1192, '10.51.177.201', 1, '1000.00', 4),
(1193, '10.51.177.202', 1, '1000.00', 4),
(1194, '10.51.177.203', 1, '1000.00', 4),
(1195, '10.51.177.204', 1, '1000.00', 4),
(1196, '10.51.177.205', 1, '1000.00', 4),
(1197, '10.51.177.206', 1, '1000.00', 4),
(1198, '10.51.177.207', 1, '1000.00', 4),
(1199, '10.51.177.208', 1, '1000.00', 4),
(1200, '10.51.177.209', 1, '1000.00', 4),
(1201, '10.51.177.210', 1, '1000.00', 4),
(1202, '10.51.177.211', 1, '1000.00', 4),
(1203, '10.51.177.212', 1, '1000.00', 4),
(1204, '10.51.177.213', 1, '1000.00', 4),
(1205, '10.51.177.214', 1, '1000.00', 4),
(1206, '10.51.177.215', 1, '1000.00', 4),
(1207, '10.51.177.216', 1, '1000.00', 4),
(1208, '10.51.177.217', 1, '1000.00', 4),
(1209, '10.51.177.218', 1, '1000.00', 4),
(1210, '10.51.177.219', 1, '1000.00', 4),
(1211, '10.51.177.220', 1, '1000.00', 4),
(1212, '10.51.177.221', 1, '1000.00', 4),
(1213, '10.51.177.222', 1, '1000.00', 4),
(1214, '10.51.177.223', 1, '1000.00', 4),
(1215, '10.51.177.224', 1, '1000.00', 4),
(1216, '10.51.177.225', 1, '1000.00', 4),
(1217, '10.51.177.226', 1, '1000.00', 4),
(1218, '10.51.177.227', 1, '1000.00', 4),
(1219, '10.51.177.228', 1, '1000.00', 4),
(1220, '10.51.177.229', 1, '1000.00', 4),
(1221, '10.51.177.230', 1, '1000.00', 4),
(1222, '10.51.177.231', 1, '1000.00', 4),
(1223, '10.51.177.232', 1, '1000.00', 4),
(1224, '10.51.177.233', 1, '1000.00', 4),
(1225, '10.51.177.234', 1, '1000.00', 4),
(1226, '10.51.177.235', 1, '1000.00', 4),
(1227, '10.51.177.236', 1, '1000.00', 4),
(1228, '10.51.177.237', 1, '1000.00', 4),
(1229, '10.51.177.238', 1, '1000.00', 4),
(1230, '10.51.177.239', 1, '1000.00', 4),
(1231, '10.51.177.240', 1, '1000.00', 4),
(1232, '10.51.177.241', 1, '1000.00', 4),
(1233, '10.51.177.242', 1, '1000.00', 4),
(1234, '10.51.177.243', 1, '1000.00', 4),
(1235, '10.51.177.244', 1, '1000.00', 4),
(1236, '10.51.177.245', 1, '1000.00', 4),
(1237, '10.51.177.246', 1, '1000.00', 4),
(1238, '10.51.177.247', 1, '1000.00', 4),
(1239, '10.51.177.248', 1, '1000.00', 4),
(1240, '10.51.177.249', 1, '1000.00', 4),
(1241, '10.51.177.250', 1, '1000.00', 4),
(1242, '10.51.177.251', 1, '1000.00', 4),
(1243, '10.51.177.252', 1, '1000.00', 4),
(1244, '10.51.177.253', 1, '1000.00', 4),
(1245, '10.51.177.254', 1, '1000.00', 4),
(1246, '10.51.206.2', 3, '1000.00', 5),
(1247, '10.51.206.3', 1, '1000.00', 5),
(1248, '10.51.206.4', 1, '1000.00', 5),
(1249, '10.51.206.5', 1, '1000.00', 5),
(1250, '10.51.206.6', 3, '1000.00', 5),
(1251, '10.51.206.7', 1, '1000.00', 5),
(1252, '10.51.206.8', 1, '1000.00', 5),
(1253, '10.51.206.9', 1, '1000.00', 5),
(1254, '10.51.206.10', 1, '1000.00', 5),
(1255, '10.51.206.11', 1, '1000.00', 5),
(1256, '10.51.206.12', 1, '1000.00', 5),
(1257, '10.51.206.13', 1, '1000.00', 5),
(1258, '10.51.206.14', 1, '1000.00', 5),
(1259, '10.51.206.15', 1, '1000.00', 5),
(1260, '10.51.206.16', 1, '1000.00', 5),
(1261, '10.51.206.17', 1, '1000.00', 5),
(1262, '10.51.206.18', 1, '1000.00', 5),
(1263, '10.51.206.19', 1, '1000.00', 5),
(1264, '10.51.206.20', 1, '1000.00', 5),
(1265, '10.51.206.21', 1, '1000.00', 5),
(1266, '10.51.206.22', 1, '1000.00', 5),
(1267, '10.51.206.23', 1, '1000.00', 5),
(1268, '10.51.206.24', 1, '1000.00', 5),
(1269, '10.51.206.25', 1, '1000.00', 5),
(1270, '10.51.206.26', 1, '1000.00', 5),
(1271, '10.51.206.27', 1, '1000.00', 5),
(1272, '10.51.206.28', 1, '1000.00', 5),
(1273, '10.51.206.29', 1, '1000.00', 5),
(1274, '10.51.206.30', 1, '1000.00', 5),
(1275, '10.51.206.31', 1, '1000.00', 5),
(1276, '10.51.206.32', 1, '1000.00', 5),
(1277, '10.51.206.33', 1, '1000.00', 5),
(1278, '10.51.206.34', 1, '1000.00', 5),
(1279, '10.51.206.35', 1, '1000.00', 5),
(1280, '10.51.206.36', 1, '1000.00', 5),
(1281, '10.51.206.37', 1, '1000.00', 5),
(1282, '10.51.206.38', 1, '1000.00', 5),
(1283, '10.51.206.39', 1, '1000.00', 5),
(1284, '10.51.206.40', 1, '1000.00', 5),
(1285, '10.51.206.41', 1, '1000.00', 5),
(1286, '10.51.206.42', 1, '1000.00', 5),
(1287, '10.51.206.43', 1, '1000.00', 5),
(1288, '10.51.206.44', 1, '1000.00', 5),
(1289, '10.51.206.45', 1, '1000.00', 5),
(1290, '10.51.206.46', 1, '1000.00', 5),
(1291, '10.51.206.47', 1, '1000.00', 5),
(1292, '10.51.206.48', 1, '1000.00', 5),
(1293, '10.51.206.49', 1, '1000.00', 5),
(1294, '10.51.206.50', 1, '1000.00', 5),
(1295, '10.51.206.51', 1, '1000.00', 5),
(1296, '10.51.206.52', 1, '1000.00', 5),
(1297, '10.51.206.53', 1, '1000.00', 5),
(1298, '10.51.206.54', 1, '1000.00', 5),
(1299, '10.51.206.55', 1, '1000.00', 5),
(1300, '10.51.206.56', 1, '1000.00', 5),
(1301, '10.51.206.57', 1, '1000.00', 5),
(1302, '10.51.206.58', 1, '1000.00', 5),
(1303, '10.51.206.59', 1, '1000.00', 5),
(1304, '10.51.206.60', 1, '1000.00', 5),
(1305, '10.51.206.61', 1, '1000.00', 5),
(1306, '10.51.206.62', 1, '1000.00', 5),
(1307, '10.51.206.63', 1, '1000.00', 5),
(1308, '10.51.206.64', 1, '1000.00', 5),
(1309, '10.51.206.65', 1, '1000.00', 5),
(1310, '10.51.206.66', 1, '1000.00', 5),
(1311, '10.51.206.67', 1, '1000.00', 5),
(1312, '10.51.206.68', 1, '1000.00', 5),
(1313, '10.51.206.69', 1, '1000.00', 5),
(1314, '10.51.206.70', 1, '1000.00', 5),
(1315, '10.51.206.71', 1, '1000.00', 5),
(1316, '10.51.206.72', 1, '1000.00', 5),
(1317, '10.51.206.73', 1, '1000.00', 5),
(1318, '10.51.206.74', 1, '1000.00', 5),
(1319, '10.51.206.75', 1, '1000.00', 5),
(1320, '10.51.206.76', 1, '1000.00', 5),
(1321, '10.51.206.77', 1, '1000.00', 5),
(1322, '10.51.206.78', 1, '1000.00', 5),
(1323, '10.51.206.79', 1, '1000.00', 5),
(1324, '10.51.206.80', 1, '1000.00', 5),
(1325, '10.51.206.81', 1, '1000.00', 5),
(1326, '10.51.206.82', 1, '1000.00', 5),
(1327, '10.51.206.83', 1, '1000.00', 5),
(1328, '10.51.206.84', 1, '1000.00', 5),
(1329, '10.51.206.85', 1, '1000.00', 5),
(1330, '10.51.206.86', 1, '1000.00', 5),
(1331, '10.51.206.87', 1, '1000.00', 5),
(1332, '10.51.206.88', 1, '1000.00', 5),
(1333, '10.51.206.89', 1, '1000.00', 5),
(1334, '10.51.206.90', 1, '1000.00', 5),
(1335, '10.51.206.91', 1, '1000.00', 5),
(1336, '10.51.206.92', 1, '1000.00', 5),
(1337, '10.51.206.93', 1, '1000.00', 5),
(1338, '10.51.206.94', 1, '1000.00', 5),
(1339, '10.51.206.95', 1, '1000.00', 5),
(1340, '10.51.206.96', 1, '1000.00', 5),
(1341, '10.51.206.97', 1, '1000.00', 5),
(1342, '10.51.206.98', 1, '1000.00', 5),
(1343, '10.51.206.99', 1, '1000.00', 5),
(1344, '10.51.206.100', 1, '1000.00', 5),
(1345, '10.51.206.101', 1, '1000.00', 5),
(1346, '10.51.206.102', 1, '1000.00', 5),
(1347, '10.51.206.103', 1, '1000.00', 5),
(1348, '10.51.206.104', 1, '1000.00', 5),
(1349, '10.51.206.105', 1, '1000.00', 5),
(1350, '10.51.206.106', 1, '1000.00', 5),
(1351, '10.51.206.107', 1, '1000.00', 5),
(1352, '10.51.206.108', 1, '1000.00', 5),
(1353, '10.51.206.109', 1, '1000.00', 5),
(1354, '10.51.206.110', 1, '1000.00', 5),
(1355, '10.51.206.111', 1, '1000.00', 5),
(1356, '10.51.206.112', 1, '1000.00', 5),
(1357, '10.51.206.113', 1, '1000.00', 5),
(1358, '10.51.206.114', 1, '1000.00', 5),
(1359, '10.51.206.115', 1, '1000.00', 5),
(1360, '10.51.206.116', 1, '1000.00', 5),
(1361, '10.51.206.117', 1, '1000.00', 5),
(1362, '10.51.206.118', 1, '1000.00', 5),
(1363, '10.51.206.119', 1, '1000.00', 5),
(1364, '10.51.206.120', 1, '1000.00', 5),
(1365, '10.51.206.121', 1, '1000.00', 5),
(1366, '10.51.206.122', 1, '1000.00', 5),
(1367, '10.51.206.123', 1, '1000.00', 5),
(1368, '10.51.206.124', 1, '1000.00', 5),
(1369, '10.51.206.125', 1, '1000.00', 5),
(1370, '10.51.206.126', 1, '1000.00', 5),
(1371, '10.51.206.127', 1, '1000.00', 5),
(1372, '10.51.206.128', 1, '1000.00', 5),
(1373, '10.51.206.129', 1, '1000.00', 5),
(1374, '10.51.206.130', 1, '1000.00', 5),
(1375, '10.51.206.131', 1, '1000.00', 5),
(1376, '10.51.206.132', 1, '1000.00', 5),
(1377, '10.51.206.133', 1, '1000.00', 5),
(1378, '10.51.206.134', 1, '1000.00', 5),
(1379, '10.51.206.135', 1, '1000.00', 5),
(1380, '10.51.206.136', 1, '1000.00', 5),
(1381, '10.51.206.137', 1, '1000.00', 5),
(1382, '10.51.206.138', 1, '1000.00', 5),
(1383, '10.51.206.139', 1, '1000.00', 5),
(1384, '10.51.206.140', 1, '1000.00', 5),
(1385, '10.51.206.141', 1, '1000.00', 5),
(1386, '10.51.206.142', 1, '1000.00', 5),
(1387, '10.51.206.143', 1, '1000.00', 5),
(1388, '10.51.206.144', 1, '1000.00', 5),
(1389, '10.51.206.145', 1, '1000.00', 5),
(1390, '10.51.206.146', 1, '1000.00', 5),
(1391, '10.51.206.147', 1, '1000.00', 5),
(1392, '10.51.206.148', 1, '1000.00', 5),
(1393, '10.51.206.149', 1, '1000.00', 5),
(1394, '10.51.206.150', 1, '1000.00', 5),
(1395, '10.51.206.151', 1, '1000.00', 5),
(1396, '10.51.206.152', 1, '1000.00', 5),
(1397, '10.51.206.153', 1, '1000.00', 5),
(1398, '10.51.206.154', 1, '1000.00', 5),
(1399, '10.51.206.155', 1, '1000.00', 5),
(1400, '10.51.206.156', 1, '1000.00', 5),
(1401, '10.51.206.157', 1, '1000.00', 5),
(1402, '10.51.206.158', 1, '1000.00', 5),
(1403, '10.51.206.159', 1, '1000.00', 5),
(1404, '10.51.206.160', 1, '1000.00', 5),
(1405, '10.51.206.161', 1, '1000.00', 5),
(1406, '10.51.206.162', 1, '1000.00', 5),
(1407, '10.51.206.163', 1, '1000.00', 5),
(1408, '10.51.206.164', 1, '1000.00', 5),
(1409, '10.51.206.165', 1, '1000.00', 5),
(1410, '10.51.206.166', 1, '1000.00', 5),
(1411, '10.51.206.167', 1, '1000.00', 5),
(1412, '10.51.206.168', 1, '1000.00', 5),
(1413, '10.51.206.169', 1, '1000.00', 5),
(1414, '10.51.206.170', 1, '1000.00', 5),
(1415, '10.51.206.171', 1, '1000.00', 5),
(1416, '10.51.206.172', 1, '1000.00', 5),
(1417, '10.51.206.173', 1, '1000.00', 5),
(1418, '10.51.206.174', 1, '1000.00', 5),
(1419, '10.51.206.175', 1, '1000.00', 5),
(1420, '10.51.206.176', 1, '1000.00', 5),
(1421, '10.51.206.177', 1, '1000.00', 5),
(1422, '10.51.206.178', 1, '1000.00', 5),
(1423, '10.51.206.179', 1, '1000.00', 5),
(1424, '10.51.206.180', 1, '1000.00', 5),
(1425, '10.51.206.181', 1, '1000.00', 5),
(1426, '10.51.206.182', 1, '1000.00', 5),
(1427, '10.51.206.183', 1, '1000.00', 5),
(1428, '10.51.206.184', 1, '1000.00', 5),
(1429, '10.51.206.185', 1, '1000.00', 5),
(1430, '10.51.206.186', 1, '1000.00', 5),
(1431, '10.51.206.187', 1, '1000.00', 5),
(1432, '10.51.206.188', 1, '1000.00', 5),
(1433, '10.51.206.189', 1, '1000.00', 5),
(1434, '10.51.206.190', 1, '1000.00', 5),
(1435, '10.51.206.191', 1, '1000.00', 5),
(1436, '10.51.206.192', 1, '1000.00', 5),
(1437, '10.51.206.193', 1, '1000.00', 5),
(1438, '10.51.206.194', 1, '1000.00', 5),
(1439, '10.51.206.195', 1, '1000.00', 5),
(1440, '10.51.206.196', 1, '1000.00', 5),
(1441, '10.51.206.197', 1, '1000.00', 5),
(1442, '10.51.206.198', 1, '1000.00', 5),
(1443, '10.51.206.199', 1, '1000.00', 5),
(1444, '10.51.206.200', 1, '1000.00', 5),
(1445, '10.51.206.201', 1, '1000.00', 5),
(1446, '10.51.206.202', 1, '1000.00', 5),
(1447, '10.51.206.203', 1, '1000.00', 5),
(1448, '10.51.206.204', 1, '1000.00', 5),
(1449, '10.51.206.205', 1, '1000.00', 5),
(1450, '10.51.206.206', 1, '1000.00', 5),
(1451, '10.51.206.207', 1, '1000.00', 5),
(1452, '10.51.206.208', 1, '1000.00', 5),
(1453, '10.51.206.209', 1, '1000.00', 5),
(1454, '10.51.206.210', 1, '1000.00', 5),
(1455, '10.51.206.211', 1, '1000.00', 5),
(1456, '10.51.206.212', 1, '1000.00', 5),
(1457, '10.51.206.213', 1, '1000.00', 5),
(1458, '10.51.206.214', 1, '1000.00', 5),
(1459, '10.51.206.215', 1, '1000.00', 5),
(1460, '10.51.206.216', 1, '1000.00', 5),
(1461, '10.51.206.217', 1, '1000.00', 5),
(1462, '10.51.206.218', 1, '1000.00', 5),
(1463, '10.51.206.219', 1, '1000.00', 5),
(1464, '10.51.206.220', 1, '1000.00', 5),
(1465, '10.51.206.221', 1, '1000.00', 5),
(1466, '10.51.206.222', 1, '1000.00', 5),
(1467, '10.51.206.223', 1, '1000.00', 5),
(1468, '10.51.206.224', 1, '1000.00', 5),
(1469, '10.51.206.225', 1, '1000.00', 5),
(1470, '10.51.206.226', 1, '1000.00', 5),
(1471, '10.51.206.227', 1, '1000.00', 5),
(1472, '10.51.206.228', 1, '1000.00', 5),
(1473, '10.51.206.229', 1, '1000.00', 5),
(1474, '10.51.206.230', 1, '1000.00', 5),
(1475, '10.51.206.231', 1, '1000.00', 5),
(1476, '10.51.206.232', 1, '1000.00', 5),
(1477, '10.51.206.233', 1, '1000.00', 5),
(1478, '10.51.206.234', 1, '1000.00', 5),
(1479, '10.51.206.235', 1, '1000.00', 5),
(1480, '10.51.206.236', 1, '1000.00', 5),
(1481, '10.51.206.237', 1, '1000.00', 5),
(1482, '10.51.206.238', 1, '1000.00', 5),
(1483, '10.51.206.239', 1, '1000.00', 5),
(1484, '10.51.206.240', 1, '1000.00', 5),
(1485, '10.51.206.241', 1, '1000.00', 5),
(1486, '10.51.206.242', 1, '1000.00', 5),
(1487, '10.51.206.243', 1, '1000.00', 5),
(1488, '10.51.206.244', 1, '1000.00', 5),
(1489, '10.51.206.245', 1, '1000.00', 5),
(1490, '10.51.206.246', 1, '1000.00', 5),
(1491, '10.51.206.247', 1, '1000.00', 5),
(1492, '10.51.206.248', 1, '1000.00', 5),
(1493, '10.51.206.249', 1, '1000.00', 5),
(1494, '10.51.206.250', 1, '1000.00', 5),
(1495, '10.51.206.251', 1, '1000.00', 5),
(1496, '10.51.206.252', 1, '1000.00', 5),
(1497, '10.51.206.253', 1, '1000.00', 5),
(1498, '10.51.206.254', 1, '1000.00', 5),
(1499, '10.51.130.2', 1, '1000.00', 6),
(1500, '10.51.130.3', 1, '1000.00', 6),
(1501, '10.51.130.4', 1, '1000.00', 6),
(1502, '10.51.130.5', 1, '1000.00', 6),
(1503, '10.51.130.6', 1, '1000.00', 6),
(1504, '10.51.130.7', 1, '1000.00', 6),
(1505, '10.51.130.8', 1, '1000.00', 6),
(1506, '10.51.130.9', 1, '1000.00', 6),
(1507, '10.51.130.10', 1, '1000.00', 6),
(1508, '10.51.130.11', 1, '1000.00', 6),
(1509, '10.51.130.12', 1, '1000.00', 6),
(1510, '10.51.130.13', 1, '1000.00', 6),
(1511, '10.51.130.14', 1, '1000.00', 6),
(1512, '10.51.130.15', 1, '1000.00', 6),
(1513, '10.51.130.16', 1, '1000.00', 6),
(1514, '10.51.130.17', 1, '1000.00', 6),
(1515, '10.51.130.18', 1, '1000.00', 6),
(1516, '10.51.130.19', 1, '1000.00', 6),
(1517, '10.51.130.20', 1, '1000.00', 6),
(1518, '10.51.130.21', 1, '1000.00', 6),
(1519, '10.51.130.22', 1, '1000.00', 6),
(1520, '10.51.130.23', 1, '1000.00', 6),
(1521, '10.51.130.24', 1, '1000.00', 6),
(1522, '10.51.130.25', 1, '1000.00', 6),
(1523, '10.51.130.26', 1, '1000.00', 6),
(1524, '10.51.130.27', 1, '1000.00', 6),
(1525, '10.51.130.28', 1, '1000.00', 6),
(1526, '10.51.130.29', 1, '1000.00', 6),
(1527, '10.51.130.30', 1, '1000.00', 6),
(1528, '10.51.130.31', 1, '1000.00', 6),
(1529, '10.51.130.32', 1, '1000.00', 6),
(1530, '10.51.130.33', 1, '1000.00', 6),
(1531, '10.51.130.34', 1, '1000.00', 6),
(1532, '10.51.130.35', 1, '1000.00', 6),
(1533, '10.51.130.36', 1, '1000.00', 6),
(1534, '10.51.130.37', 1, '1000.00', 6),
(1535, '10.51.130.38', 1, '1000.00', 6),
(1536, '10.51.130.39', 1, '1000.00', 6),
(1537, '10.51.130.40', 1, '1000.00', 6),
(1538, '10.51.130.41', 1, '1000.00', 6),
(1539, '10.51.130.42', 1, '1000.00', 6),
(1540, '10.51.130.43', 1, '1000.00', 6),
(1541, '10.51.130.44', 1, '1000.00', 6),
(1542, '10.51.130.45', 1, '1000.00', 6),
(1543, '10.51.130.46', 1, '1000.00', 6),
(1544, '10.51.130.47', 1, '1000.00', 6),
(1545, '10.51.130.48', 1, '1000.00', 6),
(1546, '10.51.130.49', 1, '1000.00', 6),
(1547, '10.51.130.50', 1, '1000.00', 6),
(1548, '10.51.130.51', 1, '1000.00', 6),
(1549, '10.51.130.52', 1, '1000.00', 6),
(1550, '10.51.130.53', 1, '1000.00', 6),
(1551, '10.51.130.54', 1, '1000.00', 6),
(1552, '10.51.130.55', 1, '1000.00', 6),
(1553, '10.51.130.56', 1, '1000.00', 6),
(1554, '10.51.130.57', 1, '1000.00', 6),
(1555, '10.51.130.58', 1, '1000.00', 6),
(1556, '10.51.130.59', 1, '1000.00', 6),
(1557, '10.51.130.60', 1, '1000.00', 6),
(1558, '10.51.130.61', 1, '1000.00', 6),
(1559, '10.51.130.62', 1, '1000.00', 6),
(1560, '10.51.130.63', 1, '1000.00', 6),
(1561, '10.51.130.64', 1, '1000.00', 6),
(1562, '10.51.130.65', 1, '1000.00', 6),
(1563, '10.51.130.66', 1, '1000.00', 6),
(1564, '10.51.130.67', 1, '1000.00', 6),
(1565, '10.51.130.68', 1, '1000.00', 6),
(1566, '10.51.130.69', 1, '1000.00', 6),
(1567, '10.51.130.70', 1, '1000.00', 6),
(1568, '10.51.130.71', 1, '1000.00', 6),
(1569, '10.51.130.72', 1, '1000.00', 6),
(1570, '10.51.130.73', 1, '1000.00', 6),
(1571, '10.51.130.74', 1, '1000.00', 6),
(1572, '10.51.130.75', 1, '1000.00', 6),
(1573, '10.51.130.76', 1, '1000.00', 6),
(1574, '10.51.130.77', 1, '1000.00', 6),
(1575, '10.51.130.78', 1, '1000.00', 6),
(1576, '10.51.130.79', 1, '1000.00', 6),
(1577, '10.51.130.80', 1, '1000.00', 6),
(1578, '10.51.130.81', 1, '1000.00', 6),
(1579, '10.51.130.82', 1, '1000.00', 6),
(1580, '10.51.130.83', 1, '1000.00', 6),
(1581, '10.51.130.84', 1, '1000.00', 6),
(1582, '10.51.130.85', 1, '1000.00', 6),
(1583, '10.51.130.86', 1, '1000.00', 6),
(1584, '10.51.130.87', 1, '1000.00', 6),
(1585, '10.51.130.88', 1, '1000.00', 6),
(1586, '10.51.130.89', 1, '1000.00', 6),
(1587, '10.51.130.90', 1, '1000.00', 6),
(1588, '10.51.130.91', 1, '1000.00', 6),
(1589, '10.51.130.92', 1, '1000.00', 6),
(1590, '10.51.130.93', 1, '1000.00', 6),
(1591, '10.51.130.94', 1, '1000.00', 6),
(1592, '10.51.130.95', 1, '1000.00', 6),
(1593, '10.51.130.96', 1, '1000.00', 6),
(1594, '10.51.130.97', 1, '1000.00', 6),
(1595, '10.51.130.98', 1, '1000.00', 6),
(1596, '10.51.130.99', 1, '1000.00', 6),
(1597, '10.51.130.100', 1, '1000.00', 6),
(1598, '10.51.130.101', 1, '1000.00', 6),
(1599, '10.51.130.102', 1, '1000.00', 6),
(1600, '10.51.130.103', 1, '1000.00', 6),
(1601, '10.51.130.104', 1, '1000.00', 6),
(1602, '10.51.130.105', 1, '1000.00', 6),
(1603, '10.51.130.106', 1, '1000.00', 6),
(1604, '10.51.130.107', 1, '1000.00', 6),
(1605, '10.51.130.108', 1, '1000.00', 6),
(1606, '10.51.130.109', 1, '1000.00', 6),
(1607, '10.51.130.110', 1, '1000.00', 6),
(1608, '10.51.130.111', 1, '1000.00', 6),
(1609, '10.51.130.112', 1, '1000.00', 6),
(1610, '10.51.130.113', 1, '1000.00', 6),
(1611, '10.51.130.114', 1, '1000.00', 6),
(1612, '10.51.130.115', 1, '1000.00', 6),
(1613, '10.51.130.116', 3, '1000.00', 6),
(1614, '10.51.130.117', 3, '1000.00', 6),
(1615, '10.51.130.118', 3, '1000.00', 6),
(1616, '10.51.130.119', 1, '1000.00', 6),
(1617, '10.51.130.120', 1, '1000.00', 6),
(1618, '10.51.130.121', 1, '1000.00', 6),
(1619, '10.51.130.122', 1, '1000.00', 6),
(1620, '10.51.130.123', 1, '1000.00', 6),
(1621, '10.51.130.124', 1, '1000.00', 6),
(1622, '10.51.130.125', 1, '1000.00', 6),
(1623, '10.51.130.126', 1, '1000.00', 6),
(1624, '10.51.130.127', 1, '1000.00', 6),
(1625, '10.51.130.128', 1, '1000.00', 6),
(1626, '10.51.130.129', 1, '1000.00', 6),
(1627, '10.51.130.130', 1, '1000.00', 6),
(1628, '10.51.130.131', 1, '1000.00', 6),
(1629, '10.51.130.132', 1, '1000.00', 6),
(1630, '10.51.130.133', 1, '1000.00', 6),
(1631, '10.51.130.134', 1, '1000.00', 6),
(1632, '10.51.130.135', 1, '1000.00', 6),
(1633, '10.51.130.136', 1, '1000.00', 6),
(1634, '10.51.130.137', 1, '1000.00', 6),
(1635, '10.51.130.138', 1, '1000.00', 6),
(1636, '10.51.130.139', 1, '1000.00', 6),
(1637, '10.51.130.140', 1, '1000.00', 6),
(1638, '10.51.130.141', 1, '1000.00', 6),
(1639, '10.51.130.142', 1, '1000.00', 6),
(1640, '10.51.130.143', 1, '1000.00', 6),
(1641, '10.51.130.144', 1, '1000.00', 6),
(1642, '10.51.130.145', 1, '1000.00', 6),
(1643, '10.51.130.146', 1, '1000.00', 6),
(1644, '10.51.130.147', 1, '1000.00', 6),
(1645, '10.51.130.148', 1, '1000.00', 6),
(1646, '10.51.130.149', 1, '1000.00', 6),
(1647, '10.51.130.150', 1, '1000.00', 6),
(1648, '10.51.130.151', 1, '1000.00', 6),
(1649, '10.51.130.152', 1, '1000.00', 6),
(1650, '10.51.130.153', 1, '1000.00', 6),
(1651, '10.51.130.154', 1, '1000.00', 6),
(1652, '10.51.130.155', 1, '1000.00', 6),
(1653, '10.51.130.156', 1, '1000.00', 6),
(1654, '10.51.130.157', 1, '1000.00', 6),
(1655, '10.51.130.158', 1, '1000.00', 6),
(1656, '10.51.130.159', 1, '1000.00', 6),
(1657, '10.51.130.160', 1, '1000.00', 6),
(1658, '10.51.130.161', 1, '1000.00', 6),
(1659, '10.51.130.162', 1, '1000.00', 6),
(1660, '10.51.130.163', 1, '1000.00', 6),
(1661, '10.51.130.164', 1, '1000.00', 6),
(1662, '10.51.130.165', 1, '1000.00', 6),
(1663, '10.51.130.166', 1, '1000.00', 6),
(1664, '10.51.130.167', 1, '1000.00', 6),
(1665, '10.51.130.168', 1, '1000.00', 6),
(1666, '10.51.130.169', 1, '1000.00', 6),
(1667, '10.51.130.170', 1, '1000.00', 6),
(1668, '10.51.130.171', 1, '1000.00', 6),
(1669, '10.51.130.172', 1, '1000.00', 6),
(1670, '10.51.130.173', 1, '1000.00', 6),
(1671, '10.51.130.174', 1, '1000.00', 6),
(1672, '10.51.130.175', 1, '1000.00', 6),
(1673, '10.51.130.176', 1, '1000.00', 6),
(1674, '10.51.130.177', 1, '1000.00', 6),
(1675, '10.51.130.178', 1, '1000.00', 6),
(1676, '10.51.130.179', 1, '1000.00', 6),
(1677, '10.51.130.180', 1, '1000.00', 6),
(1678, '10.51.130.181', 1, '1000.00', 6),
(1679, '10.51.130.182', 1, '1000.00', 6),
(1680, '10.51.130.183', 1, '1000.00', 6),
(1681, '10.51.130.184', 1, '1000.00', 6),
(1682, '10.51.130.185', 1, '1000.00', 6),
(1683, '10.51.130.186', 1, '1000.00', 6),
(1684, '10.51.130.187', 1, '1000.00', 6),
(1685, '10.51.130.188', 1, '1000.00', 6),
(1686, '10.51.130.189', 1, '1000.00', 6),
(1687, '10.51.130.190', 1, '1000.00', 6),
(1688, '10.51.130.191', 1, '1000.00', 6),
(1689, '10.51.130.192', 1, '1000.00', 6),
(1690, '10.51.130.193', 1, '1000.00', 6),
(1691, '10.51.130.194', 1, '1000.00', 6),
(1692, '10.51.130.195', 1, '1000.00', 6),
(1693, '10.51.130.196', 1, '1000.00', 6),
(1694, '10.51.130.197', 1, '1000.00', 6),
(1695, '10.51.130.198', 1, '1000.00', 6),
(1696, '10.51.130.199', 1, '1000.00', 6),
(1697, '10.51.130.200', 1, '1000.00', 6),
(1698, '10.51.130.201', 1, '1000.00', 6),
(1699, '10.51.130.202', 1, '1000.00', 6),
(1700, '10.51.130.203', 1, '1000.00', 6),
(1701, '10.51.130.204', 1, '1000.00', 6),
(1702, '10.51.130.205', 1, '1000.00', 6),
(1703, '10.51.130.206', 1, '1000.00', 6),
(1704, '10.51.130.207', 1, '1000.00', 6),
(1705, '10.51.130.208', 1, '1000.00', 6),
(1706, '10.51.130.209', 1, '1000.00', 6),
(1707, '10.51.130.210', 1, '1000.00', 6),
(1708, '10.51.130.211', 1, '1000.00', 6),
(1709, '10.51.130.212', 1, '1000.00', 6),
(1710, '10.51.130.213', 1, '1000.00', 6),
(1711, '10.51.130.214', 1, '1000.00', 6),
(1712, '10.51.130.215', 1, '1000.00', 6),
(1713, '10.51.130.216', 1, '1000.00', 6),
(1714, '10.51.130.217', 1, '1000.00', 6),
(1715, '10.51.130.218', 1, '1000.00', 6),
(1716, '10.51.130.219', 1, '1000.00', 6),
(1717, '10.51.130.220', 1, '1000.00', 6),
(1718, '10.51.130.221', 1, '1000.00', 6),
(1719, '10.51.130.222', 1, '1000.00', 6),
(1720, '10.51.130.223', 1, '1000.00', 6),
(1721, '10.51.130.224', 1, '1000.00', 6),
(1722, '10.51.130.225', 1, '1000.00', 6),
(1723, '10.51.130.226', 1, '1000.00', 6),
(1724, '10.51.130.227', 1, '1000.00', 6),
(1725, '10.51.130.228', 1, '1000.00', 6),
(1726, '10.51.130.229', 1, '1000.00', 6),
(1727, '10.51.130.230', 1, '1000.00', 6),
(1728, '10.51.130.231', 1, '1000.00', 6),
(1729, '10.51.130.232', 1, '1000.00', 6),
(1730, '10.51.130.233', 1, '1000.00', 6),
(1731, '10.51.130.234', 1, '1000.00', 6),
(1732, '10.51.130.235', 1, '1000.00', 6),
(1733, '10.51.130.236', 1, '1000.00', 6),
(1734, '10.51.130.237', 1, '1000.00', 6),
(1735, '10.51.130.238', 1, '1000.00', 6),
(1736, '10.51.130.239', 1, '1000.00', 6),
(1737, '10.51.130.240', 1, '1000.00', 6),
(1738, '10.51.130.241', 1, '1000.00', 6),
(1739, '10.51.130.242', 1, '1000.00', 6),
(1740, '10.51.130.243', 1, '1000.00', 6),
(1741, '10.51.130.244', 1, '1000.00', 6),
(1742, '10.51.130.245', 1, '1000.00', 6),
(1743, '10.51.130.246', 1, '1000.00', 6),
(1744, '10.51.130.247', 1, '1000.00', 6),
(1745, '10.51.130.248', 1, '1000.00', 6),
(1746, '10.51.130.249', 1, '1000.00', 6),
(1747, '10.51.130.250', 1, '1000.00', 6),
(1748, '10.51.130.251', 1, '1000.00', 6),
(1749, '10.51.130.252', 1, '1000.00', 6),
(1750, '10.51.130.253', 1, '1000.00', 6),
(1751, '10.51.130.254', 1, '1000.00', 6),
(2245, '151.2.1.1', 1, '1000.00', 8),
(2246, '151.2.1.2', 1, '1000.00', 8),
(2247, '151.2.1.3', 1, '1000.00', 8),
(2248, '151.2.1.4', 1, '1000.00', 8),
(2249, '151.2.1.5', 1, '1000.00', 8),
(2250, '151.2.1.6', 1, '1000.00', 8),
(2251, '151.2.1.7', 1, '1000.00', 8),
(2252, '151.2.1.8', 1, '1000.00', 8),
(2253, '151.2.1.9', 1, '1000.00', 8),
(2254, '151.2.1.10', 1, '1000.00', 8),
(2255, '151.2.1.11', 1, '1000.00', 8),
(2256, '151.2.1.12', 1, '1000.00', 8),
(2257, '151.2.1.13', 1, '1000.00', 8),
(2258, '151.2.1.14', 1, '1000.00', 8),
(2259, '151.2.1.15', 1, '1000.00', 8),
(2260, '151.2.1.16', 1, '1000.00', 8),
(2261, '151.2.1.17', 1, '1000.00', 8),
(2262, '151.2.1.18', 1, '1000.00', 8),
(2263, '151.2.1.19', 1, '1000.00', 8),
(2264, '151.2.1.20', 1, '1000.00', 8),
(2265, '151.2.1.21', 1, '1000.00', 8);
INSERT INTO `ip_addresses` (`id`, `address`, `status`, `price`, `base_id`) VALUES
(2266, '151.2.1.22', 1, '1000.00', 8),
(2267, '151.2.1.23', 1, '1000.00', 8),
(2268, '151.2.1.24', 1, '1000.00', 8),
(2269, '151.2.1.25', 1, '1000.00', 8),
(2270, '151.2.1.26', 1, '1000.00', 8),
(2271, '151.2.1.27', 1, '1000.00', 8),
(2272, '151.2.1.28', 1, '1000.00', 8),
(2273, '151.2.1.29', 1, '1000.00', 8),
(2274, '151.2.1.30', 1, '1000.00', 8),
(2275, '151.2.1.31', 1, '1000.00', 8),
(2276, '151.2.1.32', 1, '1000.00', 8),
(2277, '151.2.1.33', 1, '1000.00', 8),
(2278, '151.2.1.34', 1, '1000.00', 8),
(2279, '151.2.1.35', 1, '1000.00', 8),
(2280, '151.2.1.36', 1, '1000.00', 8),
(2281, '151.2.1.37', 1, '1000.00', 8),
(2282, '151.2.1.38', 1, '1000.00', 8),
(2283, '151.2.1.39', 1, '1000.00', 8),
(2284, '151.2.1.40', 1, '1000.00', 8),
(2285, '151.2.1.41', 1, '1000.00', 8),
(2286, '151.2.1.42', 1, '1000.00', 8),
(2287, '151.2.1.43', 1, '1000.00', 8),
(2288, '151.2.1.44', 1, '1000.00', 8),
(2289, '151.2.1.45', 1, '1000.00', 8),
(2290, '151.2.1.46', 1, '1000.00', 8),
(2291, '151.2.1.47', 1, '1000.00', 8),
(2292, '151.2.1.48', 1, '1000.00', 8),
(2293, '151.2.1.49', 1, '1000.00', 8),
(2294, '151.2.1.50', 1, '1000.00', 8),
(2295, '151.2.1.51', 1, '1000.00', 8),
(2296, '151.2.1.52', 1, '1000.00', 8),
(2297, '151.2.1.53', 1, '1000.00', 8),
(2298, '151.2.1.54', 1, '1000.00', 8),
(2299, '151.2.1.55', 1, '1000.00', 8),
(2300, '151.2.1.56', 1, '1000.00', 8),
(2301, '151.2.1.57', 1, '1000.00', 8),
(2302, '151.2.1.58', 1, '1000.00', 8),
(2303, '151.2.1.59', 1, '1000.00', 8),
(2304, '151.2.1.60', 1, '1000.00', 8),
(2305, '151.2.1.61', 1, '1000.00', 8),
(2306, '151.2.1.62', 1, '1000.00', 8),
(2307, '151.2.1.63', 1, '1000.00', 8),
(2308, '151.2.1.64', 1, '1000.00', 8),
(2309, '151.2.1.65', 1, '1000.00', 8),
(2310, '151.2.1.66', 1, '1000.00', 8),
(2311, '151.2.1.67', 1, '1000.00', 8),
(2312, '151.2.1.68', 1, '1000.00', 8),
(2313, '151.2.1.69', 1, '1000.00', 8),
(2314, '151.2.1.70', 1, '1000.00', 8),
(2315, '151.2.1.71', 1, '1000.00', 8),
(2316, '151.2.1.72', 1, '1000.00', 8),
(2317, '151.2.1.73', 1, '1000.00', 8),
(2318, '151.2.1.74', 1, '1000.00', 8),
(2319, '151.2.1.75', 1, '1000.00', 8),
(2320, '151.2.1.76', 1, '1000.00', 8),
(2321, '151.2.1.77', 1, '1000.00', 8),
(2322, '151.2.1.78', 1, '1000.00', 8),
(2323, '151.2.1.79', 1, '1000.00', 8),
(2324, '151.2.1.80', 1, '1000.00', 8),
(2325, '151.2.1.81', 1, '1000.00', 8),
(2326, '151.2.1.82', 1, '1000.00', 8),
(2327, '151.2.1.83', 1, '1000.00', 8),
(2328, '151.2.1.84', 1, '1000.00', 8),
(2329, '151.2.1.85', 1, '1000.00', 8),
(2330, '151.2.1.86', 1, '1000.00', 8),
(2331, '151.2.1.87', 1, '1000.00', 8),
(2332, '151.2.1.88', 1, '1000.00', 8),
(2333, '151.2.1.89', 1, '1000.00', 8),
(2334, '151.2.1.90', 1, '1000.00', 8),
(2335, '151.2.1.91', 1, '1000.00', 8),
(2336, '151.2.1.92', 1, '1000.00', 8),
(2337, '151.2.1.93', 1, '1000.00', 8),
(2338, '151.2.1.94', 1, '1000.00', 8),
(2339, '151.2.1.95', 1, '1000.00', 8),
(2340, '151.2.1.96', 1, '1000.00', 8),
(2341, '151.2.1.97', 1, '1000.00', 8),
(2342, '151.2.1.98', 1, '1000.00', 8),
(2343, '151.2.1.99', 1, '1000.00', 8),
(2344, '151.2.1.100', 1, '1000.00', 8),
(2345, '151.2.1.101', 1, '1000.00', 8),
(2346, '151.2.1.102', 1, '1000.00', 8),
(2347, '151.2.1.103', 1, '1000.00', 8),
(2348, '151.2.1.104', 1, '1000.00', 8),
(2349, '151.2.1.105', 1, '1000.00', 8),
(2350, '151.2.1.106', 1, '1000.00', 8),
(2351, '151.2.1.107', 1, '1000.00', 8),
(2352, '151.2.1.108', 1, '1000.00', 8),
(2353, '151.2.1.109', 1, '1000.00', 8),
(2354, '151.2.1.110', 1, '1000.00', 8),
(2355, '151.2.1.111', 1, '1000.00', 8),
(2356, '151.2.1.112', 1, '1000.00', 8),
(2357, '151.2.1.113', 1, '1000.00', 8),
(2358, '151.2.1.114', 1, '1000.00', 8),
(2359, '151.2.1.115', 1, '1000.00', 8),
(2360, '151.2.1.116', 1, '1000.00', 8),
(2361, '151.2.1.117', 1, '1000.00', 8),
(2362, '151.2.1.118', 1, '1000.00', 8),
(2363, '151.2.1.119', 1, '1000.00', 8),
(2364, '151.2.1.120', 1, '1000.00', 8),
(2365, '151.2.1.121', 1, '1000.00', 8),
(2366, '151.2.1.122', 1, '1000.00', 8),
(2367, '151.2.1.123', 1, '1000.00', 8),
(2368, '151.2.1.124', 1, '1000.00', 8),
(2369, '151.2.1.125', 1, '1000.00', 8),
(2370, '151.2.1.126', 1, '1000.00', 8),
(2371, '151.2.1.127', 1, '1000.00', 8),
(2372, '151.2.1.128', 1, '1000.00', 8),
(2373, '151.2.1.129', 1, '1000.00', 8),
(2374, '151.2.1.130', 1, '1000.00', 8),
(2375, '151.2.1.131', 1, '1000.00', 8),
(2376, '151.2.1.132', 1, '1000.00', 8),
(2377, '151.2.1.133', 1, '1000.00', 8),
(2378, '151.2.1.134', 1, '1000.00', 8),
(2379, '151.2.1.135', 1, '1000.00', 8),
(2380, '151.2.1.136', 1, '1000.00', 8),
(2381, '151.2.1.137', 1, '1000.00', 8),
(2382, '151.2.1.138', 1, '1000.00', 8),
(2383, '151.2.1.139', 1, '1000.00', 8),
(2384, '151.2.1.140', 1, '1000.00', 8),
(2385, '151.2.1.141', 1, '1000.00', 8),
(2386, '151.2.1.142', 1, '1000.00', 8),
(2387, '151.2.1.143', 1, '1000.00', 8),
(2388, '151.2.1.144', 1, '1000.00', 8),
(2389, '151.2.1.145', 1, '1000.00', 8),
(2390, '151.2.1.146', 1, '1000.00', 8),
(2391, '151.2.1.147', 1, '1000.00', 8),
(2392, '151.2.1.148', 1, '1000.00', 8),
(2393, '151.2.1.149', 1, '1000.00', 8),
(2394, '151.2.1.150', 1, '1000.00', 8),
(2395, '151.2.1.151', 1, '1000.00', 8),
(2396, '151.2.1.152', 1, '1000.00', 8),
(2397, '151.2.1.153', 1, '1000.00', 8),
(2398, '151.2.1.154', 1, '1000.00', 8),
(2399, '151.2.1.155', 1, '1000.00', 8),
(2400, '151.2.1.156', 1, '1000.00', 8),
(2401, '151.2.1.157', 1, '1000.00', 8),
(2402, '151.2.1.158', 1, '1000.00', 8),
(2403, '151.2.1.159', 1, '1000.00', 8),
(2404, '151.2.1.160', 1, '1000.00', 8),
(2405, '151.2.1.161', 1, '1000.00', 8),
(2406, '151.2.1.162', 1, '1000.00', 8),
(2407, '151.2.1.163', 1, '1000.00', 8),
(2408, '151.2.1.164', 1, '1000.00', 8),
(2409, '151.2.1.165', 1, '1000.00', 8),
(2410, '151.2.1.166', 1, '1000.00', 8),
(2411, '151.2.1.167', 1, '1000.00', 8),
(2412, '151.2.1.168', 1, '1000.00', 8),
(2413, '151.2.1.169', 1, '1000.00', 8),
(2414, '151.2.1.170', 1, '1000.00', 8),
(2415, '151.2.1.171', 1, '1000.00', 8),
(2416, '151.2.1.172', 1, '1000.00', 8),
(2417, '151.2.1.173', 1, '1000.00', 8),
(2418, '151.2.1.174', 1, '1000.00', 8),
(2419, '151.2.1.175', 1, '1000.00', 8),
(2420, '151.2.1.176', 1, '1000.00', 8),
(2421, '151.2.1.177', 1, '1000.00', 8),
(2422, '151.2.1.178', 1, '1000.00', 8),
(2423, '151.2.1.179', 1, '1000.00', 8),
(2424, '151.2.1.180', 1, '1000.00', 8),
(2425, '151.2.1.181', 1, '1000.00', 8),
(2426, '151.2.1.182', 1, '1000.00', 8),
(2427, '151.2.1.183', 1, '1000.00', 8),
(2428, '151.2.1.184', 1, '1000.00', 8),
(2429, '151.2.1.185', 1, '1000.00', 8),
(2430, '151.2.1.186', 1, '1000.00', 8),
(2431, '151.2.1.187', 1, '1000.00', 8),
(2432, '151.2.1.188', 1, '1000.00', 8),
(2433, '151.2.1.189', 1, '1000.00', 8),
(2434, '151.2.1.190', 1, '1000.00', 8),
(2435, '151.2.1.191', 1, '1000.00', 8),
(2436, '151.2.1.192', 1, '1000.00', 8),
(2437, '151.2.1.193', 1, '1000.00', 8),
(2438, '151.2.1.194', 1, '1000.00', 8),
(2439, '151.2.1.195', 1, '1000.00', 8),
(2440, '151.2.1.196', 1, '1000.00', 8),
(2441, '151.2.1.197', 1, '1000.00', 8),
(2442, '151.2.1.198', 1, '1000.00', 8),
(2443, '151.2.1.199', 1, '1000.00', 8),
(2444, '151.2.1.200', 1, '1000.00', 8),
(2445, '151.2.1.201', 1, '1000.00', 8),
(2446, '151.2.1.202', 1, '1000.00', 8),
(2447, '151.2.1.203', 1, '1000.00', 8),
(2448, '151.2.1.204', 1, '1000.00', 8),
(2449, '151.2.1.205', 1, '1000.00', 8),
(2450, '151.2.1.206', 1, '1000.00', 8),
(2451, '151.2.1.207', 1, '1000.00', 8),
(2452, '151.2.1.208', 1, '1000.00', 8),
(2453, '151.2.1.209', 1, '1000.00', 8),
(2454, '151.2.1.210', 1, '1000.00', 8),
(2455, '151.2.1.211', 1, '1000.00', 8),
(2456, '151.2.1.212', 1, '1000.00', 8),
(2457, '151.2.1.213', 1, '1000.00', 8),
(2458, '151.2.1.214', 1, '1000.00', 8),
(2459, '151.2.1.215', 1, '1000.00', 8),
(2460, '151.2.1.216', 1, '1000.00', 8),
(2461, '151.2.1.217', 1, '1000.00', 8),
(2462, '151.2.1.218', 1, '1000.00', 8),
(2463, '151.2.1.219', 1, '1000.00', 8),
(2464, '151.2.1.220', 1, '1000.00', 8),
(2465, '151.2.1.221', 1, '1000.00', 8),
(2466, '151.2.1.222', 1, '1000.00', 8),
(2467, '151.2.1.223', 1, '1000.00', 8),
(2468, '151.2.1.224', 1, '1000.00', 8),
(2469, '151.2.1.225', 1, '1000.00', 8),
(2470, '151.2.1.226', 1, '1000.00', 8),
(2471, '151.2.1.227', 1, '1000.00', 8),
(2472, '151.2.1.228', 1, '1000.00', 8),
(2473, '151.2.1.229', 1, '1000.00', 8),
(2474, '151.2.1.230', 1, '1000.00', 8),
(2475, '151.2.1.231', 1, '1000.00', 8),
(2476, '151.2.1.232', 1, '1000.00', 8),
(2477, '151.2.1.233', 1, '1000.00', 8),
(2478, '151.2.1.234', 1, '1000.00', 8),
(2479, '151.2.1.235', 1, '1000.00', 8),
(2480, '151.2.1.236', 1, '1000.00', 8),
(2481, '151.2.1.237', 1, '1000.00', 8),
(2482, '151.2.1.238', 1, '1000.00', 8),
(2483, '151.2.1.239', 1, '1000.00', 8),
(2484, '151.2.1.240', 1, '1000.00', 8),
(2485, '151.2.1.241', 1, '1000.00', 8),
(2486, '151.2.1.242', 1, '1000.00', 8),
(2487, '151.2.1.243', 1, '1000.00', 8),
(2488, '151.2.1.244', 1, '1000.00', 8),
(2489, '151.2.1.245', 1, '1000.00', 8),
(2490, '151.2.1.246', 1, '1000.00', 8),
(2491, '151.2.1.247', 1, '1000.00', 8),
(2492, '151.2.1.248', 1, '1000.00', 8),
(2493, '151.2.1.249', 1, '1000.00', 8),
(2494, '151.2.1.250', 1, '1000.00', 8),
(2495, '151.2.1.251', 1, '1000.00', 8),
(2496, '151.2.1.252', 1, '1000.00', 8),
(2497, '151.2.1.253', 1, '1000.00', 8),
(2498, '151.2.1.254', 1, '1000.00', 8),
(2499, '151.2.1.255', 1, '1000.00', 8),
(2500, '151.1.1.1', 1, '1000.00', 9),
(2501, '151.1.1.2', 1, '1000.00', 9),
(2502, '151.1.1.3', 1, '1000.00', 9),
(2521, '138.0.0.2', 1, '1000.00', 10),
(2522, '138.0.0.3', 1, '1000.00', 10),
(2523, '138.0.0.4', 1, '1000.00', 10),
(2524, '138.0.0.5', 1, '1000.00', 10),
(2525, '138.0.0.6', 1, '1000.00', 10),
(2526, '138.0.0.7', 1, '1000.00', 10),
(2527, '138.0.0.8', 1, '1000.00', 10),
(2528, '138.0.0.9', 1, '1000.00', 10),
(3024, '10.50.155.1', 1, '1000.00', 7),
(3025, '10.50.155.2', 1, '1000.00', 7),
(3026, '10.50.155.3', 1, '1000.00', 7),
(3027, '10.50.155.4', 1, '1000.00', 7),
(3028, '10.50.155.5', 1, '1000.00', 7),
(3029, '10.50.155.6', 1, '1000.00', 7),
(3030, '10.50.155.7', 1, '1000.00', 7),
(3031, '10.50.155.8', 1, '1000.00', 7),
(3032, '10.50.155.9', 1, '1000.00', 7),
(3033, '10.50.155.10', 1, '1000.00', 7),
(3034, '10.50.155.11', 1, '1000.00', 7),
(3035, '10.50.155.12', 1, '1000.00', 7),
(3036, '10.50.155.13', 1, '1000.00', 7),
(3037, '10.50.155.14', 1, '1000.00', 7),
(3038, '10.50.155.15', 1, '1000.00', 7),
(3039, '10.50.155.16', 1, '1000.00', 7),
(3040, '10.50.155.17', 1, '1000.00', 7),
(3041, '10.50.155.18', 1, '1000.00', 7),
(3042, '10.50.155.19', 1, '1000.00', 7),
(3043, '10.50.155.20', 1, '1000.00', 7),
(3044, '10.50.155.21', 1, '1000.00', 7),
(3045, '10.50.155.22', 1, '1000.00', 7),
(3046, '10.50.155.23', 1, '1000.00', 7),
(3047, '10.50.155.24', 1, '1000.00', 7),
(3048, '10.50.155.25', 1, '1000.00', 7),
(3049, '10.50.155.26', 1, '1000.00', 7),
(3050, '10.50.155.27', 1, '1000.00', 7),
(3051, '10.50.155.28', 1, '1000.00', 7),
(3052, '10.50.155.29', 1, '1000.00', 7),
(3053, '10.50.155.30', 1, '1000.00', 7),
(3054, '10.50.155.31', 1, '1000.00', 7),
(3055, '10.50.155.32', 1, '1000.00', 7),
(3056, '10.50.155.33', 1, '1000.00', 7),
(3057, '10.50.155.34', 1, '1000.00', 7),
(3058, '10.50.155.35', 1, '1000.00', 7),
(3059, '10.50.155.36', 1, '1000.00', 7),
(3060, '10.50.155.37', 1, '1000.00', 7),
(3061, '10.50.155.38', 1, '1000.00', 7),
(3062, '10.50.155.39', 1, '1000.00', 7),
(3063, '10.50.155.40', 1, '1000.00', 7),
(3064, '10.50.155.41', 1, '1000.00', 7),
(3065, '10.50.155.42', 1, '1000.00', 7),
(3066, '10.50.155.43', 1, '1000.00', 7),
(3067, '10.50.155.44', 1, '1000.00', 7),
(3068, '10.50.155.45', 1, '1000.00', 7),
(3069, '10.50.155.46', 1, '1000.00', 7),
(3070, '10.50.155.47', 1, '1000.00', 7),
(3071, '10.50.155.48', 1, '1000.00', 7),
(3072, '10.50.155.49', 1, '1000.00', 7),
(3073, '10.50.155.50', 1, '1000.00', 7),
(3074, '10.50.155.51', 1, '1000.00', 7),
(3075, '10.50.155.52', 1, '1000.00', 7),
(3076, '10.50.155.53', 1, '1000.00', 7),
(3077, '10.50.155.54', 1, '1000.00', 7),
(3078, '10.50.155.55', 1, '1000.00', 7),
(3079, '10.50.155.56', 1, '1000.00', 7),
(3080, '10.50.155.57', 1, '1000.00', 7),
(3081, '10.50.155.58', 1, '1000.00', 7),
(3082, '10.50.155.59', 1, '1000.00', 7),
(3083, '10.50.155.60', 1, '1000.00', 7),
(3084, '10.50.155.61', 1, '1000.00', 7),
(3085, '10.50.155.62', 1, '1000.00', 7),
(3086, '10.50.155.63', 1, '1000.00', 7),
(3087, '10.50.155.64', 1, '1000.00', 7),
(3088, '10.50.155.65', 1, '1000.00', 7),
(3089, '10.50.155.66', 1, '1000.00', 7),
(3090, '10.50.155.67', 1, '1000.00', 7),
(3091, '10.50.155.68', 1, '1000.00', 7),
(3092, '10.50.155.69', 1, '1000.00', 7),
(3093, '10.50.155.70', 1, '1000.00', 7),
(3094, '10.50.155.71', 1, '1000.00', 7),
(3095, '10.50.155.72', 1, '1000.00', 7),
(3096, '10.50.155.73', 1, '1000.00', 7),
(3097, '10.50.155.74', 1, '1000.00', 7),
(3098, '10.50.155.75', 1, '1000.00', 7),
(3099, '10.50.155.76', 1, '1000.00', 7),
(3100, '10.50.155.77', 1, '1000.00', 7),
(3101, '10.50.155.78', 1, '1000.00', 7),
(3102, '10.50.155.79', 1, '1000.00', 7),
(3103, '10.50.155.80', 1, '1000.00', 7),
(3104, '10.50.155.81', 1, '1000.00', 7),
(3105, '10.50.155.82', 1, '1000.00', 7),
(3106, '10.50.155.83', 1, '1000.00', 7),
(3107, '10.50.155.84', 1, '1000.00', 7),
(3108, '10.50.155.85', 1, '1000.00', 7),
(3109, '10.50.155.86', 1, '1000.00', 7),
(3110, '10.50.155.87', 1, '1000.00', 7),
(3111, '10.50.155.88', 1, '1000.00', 7),
(3112, '10.50.155.89', 1, '1000.00', 7),
(3113, '10.50.155.90', 1, '1000.00', 7),
(3114, '10.50.155.91', 1, '1000.00', 7),
(3115, '10.50.155.92', 1, '1000.00', 7),
(3116, '10.50.155.93', 1, '1000.00', 7),
(3117, '10.50.155.94', 1, '1000.00', 7),
(3118, '10.50.155.95', 1, '1000.00', 7),
(3119, '10.50.155.96', 1, '1000.00', 7),
(3120, '10.50.155.97', 1, '1000.00', 7),
(3121, '10.50.155.98', 1, '1000.00', 7),
(3122, '10.50.155.99', 1, '1000.00', 7),
(3123, '10.50.155.100', 1, '1000.00', 7),
(3124, '10.50.155.101', 1, '1000.00', 7),
(3125, '10.50.155.102', 1, '1000.00', 7),
(3126, '10.50.155.103', 1, '1000.00', 7),
(3127, '10.50.155.104', 1, '1000.00', 7),
(3128, '10.50.155.105', 1, '1000.00', 7),
(3129, '10.50.155.106', 1, '1000.00', 7),
(3130, '10.50.155.107', 1, '1000.00', 7),
(3131, '10.50.155.108', 1, '1000.00', 7),
(3132, '10.50.155.109', 1, '1000.00', 7),
(3133, '10.50.155.110', 1, '1000.00', 7),
(3134, '10.50.155.111', 1, '1000.00', 7),
(3135, '10.50.155.112', 1, '1000.00', 7),
(3136, '10.50.155.113', 1, '1000.00', 7),
(3137, '10.50.155.114', 1, '1000.00', 7),
(3138, '10.50.155.115', 1, '1000.00', 7),
(3139, '10.50.155.116', 1, '1000.00', 7),
(3140, '10.50.155.117', 1, '1000.00', 7),
(3141, '10.50.155.118', 1, '1000.00', 7),
(3142, '10.50.155.119', 1, '1000.00', 7),
(3143, '10.50.155.120', 1, '1000.00', 7),
(3144, '10.50.155.121', 1, '1000.00', 7),
(3145, '10.50.155.122', 1, '1000.00', 7),
(3146, '10.50.155.123', 1, '1000.00', 7),
(3147, '10.50.155.124', 1, '1000.00', 7),
(3148, '10.50.155.125', 1, '1000.00', 7),
(3149, '10.50.155.126', 1, '1000.00', 7),
(3150, '10.50.155.127', 1, '1000.00', 7),
(3151, '10.50.155.128', 1, '1000.00', 7),
(3152, '10.50.155.129', 1, '1000.00', 7),
(3153, '10.50.155.130', 1, '1000.00', 7),
(3154, '10.50.155.131', 1, '1000.00', 7),
(3155, '10.50.155.132', 1, '1000.00', 7),
(3156, '10.50.155.133', 1, '1000.00', 7),
(3157, '10.50.155.134', 1, '1000.00', 7),
(3158, '10.50.155.135', 1, '1000.00', 7),
(3159, '10.50.155.136', 1, '1000.00', 7),
(3160, '10.50.155.137', 1, '1000.00', 7),
(3161, '10.50.155.138', 1, '1000.00', 7),
(3162, '10.50.155.139', 1, '1000.00', 7),
(3163, '10.50.155.140', 1, '1000.00', 7),
(3164, '10.50.155.141', 1, '1000.00', 7),
(3165, '10.50.155.142', 1, '1000.00', 7),
(3166, '10.50.155.143', 1, '1000.00', 7),
(3167, '10.50.155.144', 1, '1000.00', 7),
(3168, '10.50.155.145', 1, '1000.00', 7),
(3169, '10.50.155.146', 1, '1000.00', 7),
(3170, '10.50.155.147', 1, '1000.00', 7),
(3171, '10.50.155.148', 1, '1000.00', 7),
(3172, '10.50.155.149', 1, '1000.00', 7),
(3173, '10.50.155.150', 1, '1000.00', 7),
(3174, '10.50.155.151', 1, '1000.00', 7),
(3175, '10.50.155.152', 1, '1000.00', 7),
(3176, '10.50.155.153', 1, '1000.00', 7),
(3177, '10.50.155.154', 1, '1000.00', 7),
(3178, '10.50.155.155', 1, '1000.00', 7),
(3179, '10.50.155.156', 1, '1000.00', 7),
(3180, '10.50.155.157', 1, '1000.00', 7),
(3181, '10.50.155.158', 1, '1000.00', 7),
(3182, '10.50.155.159', 1, '1000.00', 7),
(3183, '10.50.155.160', 1, '1000.00', 7),
(3184, '10.50.155.161', 1, '1000.00', 7),
(3185, '10.50.155.162', 1, '1000.00', 7),
(3186, '10.50.155.163', 1, '1000.00', 7),
(3187, '10.50.155.164', 1, '1000.00', 7),
(3188, '10.50.155.165', 1, '1000.00', 7),
(3189, '10.50.155.166', 1, '1000.00', 7),
(3190, '10.50.155.167', 1, '1000.00', 7),
(3191, '10.50.155.168', 1, '1000.00', 7),
(3192, '10.50.155.169', 1, '1000.00', 7),
(3193, '10.50.155.170', 1, '1000.00', 7),
(3194, '10.50.155.171', 1, '1000.00', 7),
(3195, '10.50.155.172', 1, '1000.00', 7),
(3196, '10.50.155.173', 1, '1000.00', 7),
(3197, '10.50.155.174', 1, '1000.00', 7),
(3198, '10.50.155.175', 1, '1000.00', 7),
(3199, '10.50.155.176', 1, '1000.00', 7),
(3200, '10.50.155.177', 1, '1000.00', 7),
(3201, '10.50.155.178', 1, '1000.00', 7),
(3202, '10.50.155.179', 1, '1000.00', 7),
(3203, '10.50.155.180', 1, '1000.00', 7),
(3204, '10.50.155.181', 1, '1000.00', 7),
(3205, '10.50.155.182', 1, '1000.00', 7),
(3206, '10.50.155.183', 1, '1000.00', 7),
(3207, '10.50.155.184', 1, '1000.00', 7),
(3208, '10.50.155.185', 1, '1000.00', 7),
(3209, '10.50.155.186', 1, '1000.00', 7),
(3210, '10.50.155.187', 1, '1000.00', 7),
(3211, '10.50.155.188', 1, '1000.00', 7),
(3212, '10.50.155.189', 1, '1000.00', 7),
(3213, '10.50.155.190', 1, '1000.00', 7),
(3214, '10.50.155.191', 1, '1000.00', 7),
(3215, '10.50.155.192', 1, '1000.00', 7),
(3216, '10.50.155.193', 1, '1000.00', 7),
(3217, '10.50.155.194', 1, '1000.00', 7),
(3218, '10.50.155.195', 1, '1000.00', 7),
(3219, '10.50.155.196', 1, '1000.00', 7),
(3220, '10.50.155.197', 1, '1000.00', 7),
(3221, '10.50.155.198', 1, '1000.00', 7),
(3222, '10.50.155.199', 1, '1000.00', 7),
(3223, '10.50.155.200', 1, '1000.00', 7),
(3224, '10.50.155.201', 1, '1000.00', 7),
(3225, '10.50.155.202', 1, '1000.00', 7),
(3226, '10.50.155.203', 1, '1000.00', 7),
(3227, '10.50.155.204', 1, '1000.00', 7),
(3228, '10.50.155.205', 1, '1000.00', 7),
(3229, '10.50.155.206', 1, '1000.00', 7),
(3230, '10.50.155.207', 1, '1000.00', 7),
(3231, '10.50.155.208', 1, '1000.00', 7),
(3232, '10.50.155.209', 1, '1000.00', 7),
(3233, '10.50.155.210', 1, '1000.00', 7),
(3234, '10.50.155.211', 1, '1000.00', 7),
(3235, '10.50.155.212', 1, '1000.00', 7),
(3236, '10.50.155.213', 1, '1000.00', 7),
(3237, '10.50.155.214', 1, '1000.00', 7),
(3238, '10.50.155.215', 1, '1000.00', 7),
(3239, '10.50.155.216', 1, '1000.00', 7),
(3240, '10.50.155.217', 1, '1000.00', 7),
(3241, '10.50.155.218', 1, '1000.00', 7),
(3242, '10.50.155.219', 1, '1000.00', 7),
(3243, '10.50.155.220', 1, '1000.00', 7),
(3244, '10.50.155.221', 1, '1000.00', 7),
(3245, '10.50.155.222', 1, '1000.00', 7),
(3246, '10.50.155.223', 1, '1000.00', 7),
(3247, '10.50.155.224', 1, '1000.00', 7),
(3248, '10.50.155.225', 1, '1000.00', 7),
(3249, '10.50.155.226', 1, '1000.00', 7),
(3250, '10.50.155.227', 1, '1000.00', 7),
(3251, '10.50.155.228', 1, '1000.00', 7),
(3252, '10.50.155.229', 1, '1000.00', 7),
(3253, '10.50.155.230', 1, '1000.00', 7),
(3254, '10.50.155.231', 1, '1000.00', 7),
(3255, '10.50.155.232', 1, '1000.00', 7),
(3256, '10.50.155.233', 1, '1000.00', 7),
(3257, '10.50.155.234', 1, '1000.00', 7),
(3258, '10.50.155.235', 1, '1000.00', 7),
(3259, '10.50.155.236', 1, '1000.00', 7),
(3260, '10.50.155.237', 1, '1000.00', 7),
(3261, '10.50.155.238', 1, '1000.00', 7),
(3262, '10.50.155.239', 1, '1000.00', 7),
(3263, '10.50.155.240', 1, '1000.00', 7),
(3264, '10.50.155.241', 1, '1000.00', 7),
(3265, '10.50.155.242', 1, '1000.00', 7),
(3266, '10.50.155.243', 1, '1000.00', 7),
(3267, '10.50.155.244', 1, '1000.00', 7),
(3268, '10.50.155.245', 1, '1000.00', 7),
(3269, '10.50.155.246', 1, '1000.00', 7),
(3270, '10.50.155.247', 1, '1000.00', 7),
(3271, '10.50.155.248', 1, '1000.00', 7),
(3272, '10.50.155.249', 1, '1000.00', 7),
(3273, '10.50.155.250', 1, '1000.00', 7),
(3274, '10.50.155.251', 1, '1000.00', 7),
(3275, '10.50.155.252', 1, '1000.00', 7),
(3276, '10.50.155.253', 1, '1000.00', 7),
(3277, '10.50.155.254', 1, '1000.00', 7),
(3519, '10.51.39.3', 1, '1000.00', 3),
(3520, '10.51.39.4', 1, '1000.00', 3),
(3521, '10.51.39.5', 1, '1000.00', 3),
(3522, '10.51.39.6', 1, '1000.00', 3),
(3523, '10.51.39.7', 1, '1000.00', 3),
(3524, '10.51.39.8', 1, '1000.00', 3),
(3525, '10.51.39.9', 1, '1000.00', 3),
(3526, '10.51.39.10', 1, '1000.00', 3),
(3527, '10.51.39.11', 1, '1000.00', 3),
(3528, '10.51.39.12', 1, '1000.00', 3),
(3529, '10.51.39.13', 1, '1000.00', 3),
(3530, '10.51.39.14', 1, '1000.00', 3),
(3531, '10.51.39.15', 1, '1000.00', 3),
(3532, '10.51.39.16', 1, '1000.00', 3),
(3533, '10.51.39.18', 1, '1000.00', 3),
(3534, '10.51.39.19', 1, '1000.00', 3),
(3535, '10.51.39.20', 1, '1000.00', 3),
(3536, '10.51.39.21', 1, '1000.00', 3),
(3537, '10.51.39.22', 1, '1000.00', 3),
(3538, '10.51.39.23', 1, '1000.00', 3),
(3539, '10.51.39.24', 1, '1000.00', 3),
(3540, '10.51.39.25', 1, '1000.00', 3),
(3541, '10.51.39.26', 1, '1000.00', 3),
(3542, '10.51.39.27', 1, '1000.00', 3),
(3543, '10.51.39.28', 1, '1000.00', 3),
(3544, '10.51.39.29', 1, '1000.00', 3),
(3545, '10.51.39.31', 1, '1000.00', 3),
(3546, '10.51.39.32', 1, '1000.00', 3),
(3547, '10.51.39.33', 1, '1000.00', 3),
(3548, '10.51.39.34', 1, '1000.00', 3),
(3549, '10.51.39.35', 1, '1000.00', 3),
(3550, '10.51.39.37', 1, '1000.00', 3),
(3551, '10.51.39.38', 1, '1000.00', 3),
(3552, '10.51.39.39', 1, '1000.00', 3),
(3553, '10.51.39.40', 1, '1000.00', 3),
(3554, '10.51.39.41', 1, '1000.00', 3),
(3555, '10.51.39.42', 1, '1000.00', 3),
(3556, '10.51.39.43', 1, '1000.00', 3),
(3557, '10.51.39.44', 1, '1000.00', 3),
(3558, '10.51.39.45', 1, '1000.00', 3),
(3559, '10.51.39.46', 1, '1000.00', 3),
(3560, '10.51.39.47', 1, '1000.00', 3),
(3561, '10.51.39.48', 1, '1000.00', 3),
(3562, '10.51.39.50', 1, '1000.00', 3),
(3563, '10.51.39.51', 1, '1000.00', 3),
(3564, '10.51.39.52', 1, '1000.00', 3),
(3565, '10.51.39.53', 1, '1000.00', 3),
(3566, '10.51.39.54', 1, '1000.00', 3),
(3567, '10.51.39.55', 1, '1000.00', 3),
(3568, '10.51.39.57', 1, '1000.00', 3),
(3569, '10.51.39.58', 1, '1000.00', 3),
(3570, '10.51.39.59', 1, '1000.00', 3),
(3571, '10.51.39.60', 1, '1000.00', 3),
(3572, '10.51.39.61', 1, '1000.00', 3),
(3573, '10.51.39.62', 1, '1000.00', 3),
(3574, '10.51.39.63', 1, '1000.00', 3),
(3575, '10.51.39.64', 1, '1000.00', 3),
(3576, '10.51.39.65', 1, '1000.00', 3),
(3577, '10.51.39.66', 1, '1000.00', 3),
(3578, '10.51.39.67', 1, '1000.00', 3),
(3579, '10.51.39.68', 1, '1000.00', 3),
(3580, '10.51.39.69', 1, '1000.00', 3),
(3581, '10.51.39.71', 1, '1000.00', 3),
(3582, '10.51.39.72', 1, '1000.00', 3),
(3583, '10.51.39.73', 1, '1000.00', 3),
(3584, '10.51.39.74', 1, '1000.00', 3),
(3585, '10.51.39.75', 1, '1000.00', 3),
(3586, '10.51.39.76', 1, '1000.00', 3),
(3587, '10.51.39.77', 1, '1000.00', 3),
(3588, '10.51.39.78', 1, '1000.00', 3),
(3589, '10.51.39.79', 1, '1000.00', 3),
(3590, '10.51.39.80', 1, '1000.00', 3),
(3591, '10.51.39.82', 1, '1000.00', 3),
(3592, '10.51.39.83', 1, '1000.00', 3),
(3593, '10.51.39.84', 1, '1000.00', 3),
(3594, '10.51.39.85', 1, '1000.00', 3),
(3595, '10.51.39.86', 1, '1000.00', 3),
(3596, '10.51.39.87', 1, '1000.00', 3),
(3597, '10.51.39.88', 1, '1000.00', 3),
(3598, '10.51.39.89', 1, '1000.00', 3),
(3599, '10.51.39.90', 1, '1000.00', 3),
(3600, '10.51.39.91', 1, '1000.00', 3),
(3601, '10.51.39.92', 1, '1000.00', 3),
(3602, '10.51.39.93', 1, '1000.00', 3),
(3603, '10.51.39.94', 1, '1000.00', 3),
(3604, '10.51.39.96', 1, '1000.00', 3),
(3605, '10.51.39.97', 1, '1000.00', 3),
(3606, '10.51.39.98', 1, '1000.00', 3),
(3607, '10.51.39.99', 1, '1000.00', 3),
(3608, '10.51.39.100', 1, '1000.00', 3),
(3609, '10.51.39.101', 1, '1000.00', 3),
(3610, '10.51.39.102', 1, '1000.00', 3),
(3611, '10.51.39.103', 1, '1000.00', 3),
(3612, '10.51.39.105', 1, '1000.00', 3),
(3613, '10.51.39.106', 1, '1000.00', 3),
(3614, '10.51.39.107', 1, '1000.00', 3),
(3615, '10.51.39.109', 1, '1000.00', 3),
(3616, '10.51.39.110', 1, '1000.00', 3),
(3617, '10.51.39.112', 1, '1000.00', 3),
(3618, '10.51.39.113', 1, '1000.00', 3),
(3619, '10.51.39.114', 1, '1000.00', 3),
(3620, '10.51.39.115', 1, '1000.00', 3),
(3621, '10.51.39.116', 1, '1000.00', 3),
(3622, '10.51.39.117', 1, '1000.00', 3),
(3623, '10.51.39.118', 1, '1000.00', 3),
(3624, '10.51.39.119', 1, '1000.00', 3),
(3625, '10.51.39.120', 1, '1000.00', 3),
(3626, '10.51.39.121', 1, '1000.00', 3),
(3627, '10.51.39.122', 1, '1000.00', 3),
(3628, '10.51.39.123', 1, '1000.00', 3),
(3629, '10.51.39.124', 1, '1000.00', 3),
(3630, '10.51.39.125', 1, '1000.00', 3),
(3631, '10.51.39.126', 1, '1000.00', 3),
(3632, '10.51.39.127', 1, '1000.00', 3),
(3633, '10.51.39.128', 1, '1000.00', 3),
(3634, '10.51.39.129', 1, '1000.00', 3),
(3635, '10.51.39.130', 1, '1000.00', 3),
(3636, '10.51.39.131', 1, '1000.00', 3),
(3637, '10.51.39.132', 1, '1000.00', 3),
(3638, '10.51.39.133', 1, '1000.00', 3),
(3639, '10.51.39.134', 1, '1000.00', 3),
(3640, '10.51.39.135', 1, '1000.00', 3),
(3641, '10.51.39.136', 1, '1000.00', 3),
(3642, '10.51.39.137', 1, '1000.00', 3),
(3643, '10.51.39.138', 1, '1000.00', 3),
(3644, '10.51.39.139', 1, '1000.00', 3),
(3645, '10.51.39.140', 1, '1000.00', 3),
(3646, '10.51.39.141', 1, '1000.00', 3),
(3647, '10.51.39.142', 1, '1000.00', 3),
(3648, '10.51.39.143', 1, '1000.00', 3),
(3649, '10.51.39.144', 1, '1000.00', 3),
(3650, '10.51.39.145', 1, '1000.00', 3),
(3651, '10.51.39.146', 1, '1000.00', 3),
(3652, '10.51.39.147', 1, '1000.00', 3),
(3653, '10.51.39.148', 1, '1000.00', 3),
(3654, '10.51.39.149', 1, '1000.00', 3),
(3655, '10.51.39.150', 1, '1000.00', 3),
(3656, '10.51.39.151', 1, '1000.00', 3),
(3657, '10.51.39.152', 1, '1000.00', 3),
(3658, '10.51.39.153', 1, '1000.00', 3),
(3659, '10.51.39.154', 1, '1000.00', 3),
(3660, '10.51.39.155', 1, '1000.00', 3),
(3661, '10.51.39.156', 1, '1000.00', 3),
(3662, '10.51.39.157', 1, '1000.00', 3),
(3663, '10.51.39.158', 1, '1000.00', 3),
(3664, '10.51.39.159', 1, '1000.00', 3),
(3665, '10.51.39.160', 1, '1000.00', 3),
(3666, '10.51.39.161', 1, '1000.00', 3),
(3667, '10.51.39.162', 1, '1000.00', 3),
(3668, '10.51.39.163', 1, '1000.00', 3),
(3669, '10.51.39.164', 1, '1000.00', 3),
(3670, '10.51.39.165', 1, '1000.00', 3),
(3671, '10.51.39.166', 1, '1000.00', 3),
(3672, '10.51.39.167', 1, '1000.00', 3),
(3673, '10.51.39.168', 1, '1000.00', 3),
(3674, '10.51.39.169', 1, '1000.00', 3),
(3675, '10.51.39.170', 1, '1000.00', 3),
(3676, '10.51.39.171', 1, '1000.00', 3),
(3677, '10.51.39.172', 1, '1000.00', 3),
(3678, '10.51.39.173', 1, '1000.00', 3),
(3679, '10.51.39.174', 1, '1000.00', 3),
(3680, '10.51.39.175', 1, '1000.00', 3),
(3681, '10.51.39.176', 1, '1000.00', 3),
(3682, '10.51.39.177', 1, '1000.00', 3),
(3683, '10.51.39.178', 1, '1000.00', 3),
(3684, '10.51.39.179', 1, '1000.00', 3),
(3685, '10.51.39.180', 1, '1000.00', 3),
(3686, '10.51.39.181', 1, '1000.00', 3),
(3687, '10.51.39.182', 1, '1000.00', 3),
(3688, '10.51.39.183', 1, '1000.00', 3),
(3689, '10.51.39.184', 1, '1000.00', 3),
(3690, '10.51.39.185', 1, '1000.00', 3),
(3691, '10.51.39.186', 1, '1000.00', 3),
(3692, '10.51.39.187', 1, '1000.00', 3),
(3693, '10.51.39.188', 1, '1000.00', 3),
(3694, '10.51.39.189', 1, '1000.00', 3),
(3695, '10.51.39.190', 1, '1000.00', 3),
(3696, '10.51.39.191', 1, '1000.00', 3),
(3697, '10.51.39.192', 1, '1000.00', 3),
(3698, '10.51.39.193', 1, '1000.00', 3),
(3699, '10.51.39.194', 1, '1000.00', 3),
(3700, '10.51.39.195', 1, '1000.00', 3),
(3701, '10.51.39.196', 1, '1000.00', 3),
(3702, '10.51.39.197', 1, '1000.00', 3),
(3703, '10.51.39.198', 1, '1000.00', 3),
(3704, '10.51.39.199', 1, '1000.00', 3),
(3705, '10.51.39.200', 1, '1000.00', 3),
(3706, '10.51.39.201', 1, '1000.00', 3),
(3707, '10.51.39.202', 1, '1000.00', 3),
(3708, '10.51.39.203', 1, '1000.00', 3),
(3709, '10.51.39.204', 1, '1000.00', 3),
(3710, '10.51.39.205', 1, '1000.00', 3),
(3711, '10.51.39.206', 1, '1000.00', 3),
(3712, '10.51.39.207', 1, '1000.00', 3),
(3713, '10.51.39.208', 1, '1000.00', 3),
(3714, '10.51.39.209', 1, '1000.00', 3),
(3715, '10.51.39.210', 1, '1000.00', 3),
(3716, '10.51.39.211', 1, '1000.00', 3),
(3717, '10.51.39.212', 1, '1000.00', 3),
(3718, '10.51.39.213', 1, '1000.00', 3),
(3719, '10.51.39.214', 1, '1000.00', 3),
(3720, '10.51.39.215', 1, '1000.00', 3),
(3721, '10.51.39.216', 1, '1000.00', 3),
(3722, '10.51.39.217', 1, '1000.00', 3),
(3723, '10.51.39.218', 1, '1000.00', 3),
(3724, '10.51.39.219', 1, '1000.00', 3),
(3725, '10.51.39.220', 1, '1000.00', 3),
(3726, '10.51.39.221', 1, '1000.00', 3),
(3727, '10.51.39.222', 1, '1000.00', 3),
(3728, '10.51.39.223', 1, '1000.00', 3),
(3729, '10.51.39.224', 1, '1000.00', 3),
(3730, '10.51.39.225', 1, '1000.00', 3),
(3731, '10.51.39.226', 1, '1000.00', 3),
(3732, '10.51.39.227', 1, '1000.00', 3),
(3733, '10.51.39.228', 1, '1000.00', 3),
(3734, '10.51.39.229', 1, '1000.00', 3),
(3735, '10.51.39.230', 1, '1000.00', 3),
(3736, '10.51.39.231', 1, '1000.00', 3),
(3737, '10.51.39.232', 1, '1000.00', 3),
(3738, '10.51.39.233', 1, '1000.00', 3),
(3739, '10.51.39.234', 1, '1000.00', 3),
(3740, '10.51.39.235', 1, '1000.00', 3),
(3741, '10.51.39.236', 1, '1000.00', 3),
(3742, '10.51.39.237', 1, '1000.00', 3),
(3743, '10.51.39.238', 1, '1000.00', 3),
(3744, '10.51.39.239', 1, '1000.00', 3),
(3745, '10.51.39.240', 1, '1000.00', 3),
(3746, '10.51.39.241', 1, '1000.00', 3),
(3747, '10.51.39.242', 1, '1000.00', 3),
(3748, '10.51.39.243', 1, '1000.00', 3),
(3749, '10.51.39.244', 1, '1000.00', 3),
(3750, '10.51.39.245', 1, '1000.00', 3),
(3751, '10.51.39.246', 1, '1000.00', 3),
(3752, '10.51.39.247', 1, '1000.00', 3),
(3753, '10.51.39.248', 1, '1000.00', 3),
(3754, '10.51.39.249', 1, '1000.00', 3),
(3755, '10.51.39.250', 1, '1000.00', 3),
(3756, '10.51.39.251', 1, '1000.00', 3),
(3757, '10.51.39.252', 1, '1000.00', 3),
(3758, '10.51.39.253', 1, '1000.00', 3),
(3759, '10.51.39.254', 1, '1000.00', 3),
(3760, '172.28.6.2', 3, '1000.00', 151),
(3761, '172.28.6.3', 3, '1000.00', 151),
(3762, '172.28.6.4', 3, '1000.00', 151),
(3763, '172.28.6.5', 3, '1000.00', 151),
(3764, '172.28.6.6', 3, '1000.00', 151),
(3765, '172.28.6.7', 3, '1000.00', 151),
(3766, '172.28.6.8', 3, '1000.00', 151),
(3767, '172.28.6.9', 3, '1000.00', 151),
(3768, '172.28.6.10', 3, '1000.00', 151),
(3769, '172.28.6.11', 3, '1000.00', 151),
(3770, '172.28.6.12', 3, '1000.00', 151),
(3771, '172.28.6.13', 3, '1000.00', 151),
(3772, '172.28.6.14', 3, '1000.00', 151),
(3773, '172.28.6.15', 3, '1000.00', 151),
(3774, '172.28.6.16', 3, '1000.00', 151),
(3775, '172.28.6.17', 1, '1000.00', 151),
(3776, '172.28.6.18', 1, '1000.00', 151),
(3777, '172.28.6.19', 1, '1000.00', 151),
(3778, '172.28.6.20', 1, '1000.00', 151),
(3779, '172.28.6.21', 1, '1000.00', 151),
(3780, '172.28.6.22', 1, '1000.00', 151),
(3781, '172.28.6.23', 1, '1000.00', 151),
(3782, '172.28.6.24', 1, '1000.00', 151),
(3783, '172.28.6.25', 1, '1000.00', 151),
(3784, '172.28.6.26', 1, '1000.00', 151),
(3785, '172.28.6.27', 1, '1000.00', 151),
(3786, '172.28.6.28', 1, '1000.00', 151),
(3787, '172.28.6.29', 1, '1000.00', 151),
(3788, '172.28.6.30', 1, '1000.00', 151),
(3789, '172.28.6.31', 1, '1000.00', 151),
(3790, '172.28.6.32', 1, '1000.00', 151),
(3791, '172.28.6.33', 1, '1000.00', 151),
(3792, '172.28.6.34', 1, '1000.00', 151),
(3793, '172.28.6.35', 1, '1000.00', 151),
(3794, '172.28.6.36', 1, '1000.00', 151),
(3795, '172.28.6.37', 1, '1000.00', 151),
(3796, '172.28.6.38', 1, '1000.00', 151),
(3797, '172.28.6.39', 1, '1000.00', 151),
(3798, '172.28.6.40', 1, '1000.00', 151),
(3799, '172.28.6.41', 1, '1000.00', 151),
(3800, '172.28.6.42', 1, '1000.00', 151),
(3801, '172.28.6.43', 1, '1000.00', 151),
(3802, '172.28.6.44', 1, '1000.00', 151),
(3803, '172.28.6.45', 1, '1000.00', 151),
(3804, '172.28.6.46', 1, '1000.00', 151),
(3805, '172.28.6.47', 1, '1000.00', 151),
(3806, '172.28.6.48', 1, '1000.00', 151),
(3807, '172.28.6.49', 1, '1000.00', 151),
(3808, '172.28.6.50', 1, '1000.00', 151),
(3809, '172.28.6.51', 1, '1000.00', 151),
(3810, '172.28.6.52', 1, '1000.00', 151),
(3811, '172.28.6.53', 1, '1000.00', 151),
(3812, '172.28.6.54', 1, '1000.00', 151),
(3813, '172.28.6.55', 1, '1000.00', 151),
(3814, '172.28.6.56', 1, '1000.00', 151),
(3815, '172.28.6.57', 1, '1000.00', 151),
(3816, '172.28.6.58', 1, '1000.00', 151),
(3817, '172.28.6.59', 1, '1000.00', 151),
(3818, '172.28.6.60', 1, '1000.00', 151),
(3819, '172.28.6.61', 1, '1000.00', 151),
(3820, '172.28.6.62', 1, '1000.00', 151),
(3821, '172.28.6.63', 1, '1000.00', 151),
(3822, '172.28.6.64', 1, '1000.00', 151),
(3823, '172.28.6.65', 1, '1000.00', 151),
(3824, '172.28.6.66', 1, '1000.00', 151),
(3825, '172.28.6.67', 1, '1000.00', 151),
(3826, '172.28.6.68', 1, '1000.00', 151),
(3827, '172.28.6.69', 1, '1000.00', 151),
(3828, '172.28.6.70', 1, '1000.00', 151),
(3829, '172.28.6.71', 1, '1000.00', 151),
(3830, '172.28.6.72', 1, '1000.00', 151),
(3831, '172.28.6.73', 1, '1000.00', 151),
(3832, '172.28.6.74', 1, '1000.00', 151),
(3833, '172.28.6.75', 1, '1000.00', 151),
(3834, '172.28.6.76', 1, '1000.00', 151),
(3835, '172.28.6.77', 1, '1000.00', 151),
(3836, '172.28.6.78', 1, '1000.00', 151),
(3837, '172.28.6.79', 1, '1000.00', 151),
(3838, '172.28.6.80', 1, '1000.00', 151),
(3839, '172.28.6.81', 1, '1000.00', 151),
(3840, '172.28.6.82', 1, '1000.00', 151),
(3841, '172.28.6.83', 1, '1000.00', 151),
(3842, '172.28.6.84', 1, '1000.00', 151),
(3843, '172.28.6.85', 1, '1000.00', 151),
(3844, '172.28.6.86', 1, '1000.00', 151),
(3845, '172.28.6.87', 1, '1000.00', 151),
(3846, '172.28.6.88', 1, '1000.00', 151),
(3847, '172.28.6.89', 1, '1000.00', 151),
(3848, '172.28.6.90', 1, '1000.00', 151),
(3849, '172.28.6.91', 1, '1000.00', 151),
(3850, '172.28.6.92', 1, '1000.00', 151),
(3851, '172.28.6.93', 1, '1000.00', 151),
(3852, '172.28.6.94', 1, '1000.00', 151),
(3853, '172.28.6.95', 1, '1000.00', 151),
(3854, '172.28.6.96', 1, '1000.00', 151),
(3855, '172.28.6.97', 1, '1000.00', 151),
(3856, '172.28.6.98', 1, '1000.00', 151),
(3857, '172.28.6.99', 1, '1000.00', 151),
(3858, '172.28.6.100', 1, '1000.00', 151),
(3859, '172.28.6.101', 3, '1000.00', 151),
(3860, '172.28.6.102', 3, '1000.00', 151),
(3861, '172.28.6.103', 3, '1000.00', 151),
(3862, '172.28.6.104', 1, '1000.00', 151),
(3863, '172.28.6.105', 1, '1000.00', 151),
(3864, '172.28.6.106', 1, '1000.00', 151),
(3865, '172.28.6.107', 1, '1000.00', 151),
(3866, '172.28.6.108', 1, '1000.00', 151),
(3867, '172.28.6.109', 1, '1000.00', 151),
(3868, '172.28.6.110', 1, '1000.00', 151),
(3869, '172.28.6.111', 1, '1000.00', 151),
(3870, '172.28.6.112', 1, '1000.00', 151),
(3871, '172.28.6.113', 1, '1000.00', 151),
(3872, '172.28.6.114', 1, '1000.00', 151),
(3873, '172.28.6.115', 1, '1000.00', 151),
(3874, '172.28.6.116', 1, '1000.00', 151),
(3875, '172.28.6.117', 1, '1000.00', 151),
(3876, '172.28.6.118', 1, '1000.00', 151),
(3877, '172.28.6.119', 1, '1000.00', 151),
(3878, '172.28.6.120', 1, '1000.00', 151),
(3879, '172.28.6.121', 1, '1000.00', 151),
(3880, '172.28.6.122', 1, '1000.00', 151),
(3881, '172.28.6.123', 1, '1000.00', 151),
(3882, '172.28.6.124', 1, '1000.00', 151),
(3883, '172.28.6.125', 1, '1000.00', 151),
(3884, '172.28.6.126', 1, '1000.00', 151),
(3885, '172.28.6.127', 1, '1000.00', 151),
(3886, '172.28.6.128', 1, '1000.00', 151),
(3887, '172.28.6.129', 1, '1000.00', 151),
(3888, '172.28.6.130', 1, '1000.00', 151),
(3889, '172.28.6.131', 1, '1000.00', 151),
(3890, '172.28.6.132', 1, '1000.00', 151),
(3891, '172.28.6.133', 1, '1000.00', 151),
(3892, '172.28.6.134', 1, '1000.00', 151),
(3893, '172.28.6.135', 1, '1000.00', 151),
(3894, '172.28.6.136', 1, '1000.00', 151),
(3895, '172.28.6.137', 1, '1000.00', 151),
(3896, '172.28.6.138', 1, '1000.00', 151),
(3897, '172.28.6.139', 1, '1000.00', 151),
(3898, '172.28.6.140', 1, '1000.00', 151),
(3899, '172.28.6.141', 1, '1000.00', 151),
(3900, '172.28.6.142', 1, '1000.00', 151),
(3901, '172.28.6.143', 1, '1000.00', 151),
(3902, '172.28.6.144', 1, '1000.00', 151),
(3903, '172.28.6.145', 1, '1000.00', 151),
(3904, '172.28.6.146', 1, '1000.00', 151),
(3905, '172.28.6.147', 1, '1000.00', 151),
(3906, '172.28.6.148', 1, '1000.00', 151),
(3907, '172.28.6.149', 1, '1000.00', 151),
(3908, '172.28.6.150', 1, '1000.00', 151),
(3909, '172.28.6.151', 1, '1000.00', 151),
(3910, '172.28.6.152', 1, '1000.00', 151),
(3911, '172.28.6.153', 1, '1000.00', 151),
(3912, '172.28.6.154', 1, '1000.00', 151),
(3913, '172.28.6.155', 1, '1000.00', 151),
(3914, '172.28.6.156', 1, '1000.00', 151),
(3915, '172.28.6.157', 1, '1000.00', 151),
(3916, '172.28.6.158', 1, '1000.00', 151),
(3917, '172.28.6.159', 1, '1000.00', 151),
(3918, '172.28.6.160', 1, '1000.00', 151),
(3919, '172.28.6.161', 1, '1000.00', 151),
(3920, '172.28.6.162', 1, '1000.00', 151),
(3921, '172.28.6.163', 1, '1000.00', 151),
(3922, '172.28.6.164', 1, '1000.00', 151),
(3923, '172.28.6.165', 1, '1000.00', 151),
(3924, '172.28.6.166', 1, '1000.00', 151),
(3925, '172.28.6.167', 1, '1000.00', 151),
(3926, '172.28.6.168', 1, '1000.00', 151),
(3927, '172.28.6.169', 1, '1000.00', 151),
(3928, '172.28.6.170', 1, '1000.00', 151),
(3929, '172.28.6.171', 1, '1000.00', 151),
(3930, '172.28.6.172', 1, '1000.00', 151),
(3931, '172.28.6.173', 1, '1000.00', 151),
(3932, '172.28.6.174', 1, '1000.00', 151),
(3933, '172.28.6.175', 1, '1000.00', 151),
(3934, '172.28.6.176', 1, '1000.00', 151),
(3935, '172.28.6.177', 1, '1000.00', 151),
(3936, '172.28.6.178', 1, '1000.00', 151),
(3937, '172.28.6.179', 1, '1000.00', 151),
(3938, '172.28.6.180', 1, '1000.00', 151),
(3939, '172.28.6.181', 1, '1000.00', 151),
(3940, '172.28.6.182', 1, '1000.00', 151),
(3941, '172.28.6.183', 1, '1000.00', 151),
(3942, '172.28.6.184', 1, '1000.00', 151),
(3943, '172.28.6.185', 1, '1000.00', 151),
(3944, '172.28.6.186', 1, '1000.00', 151),
(3945, '172.28.6.187', 1, '1000.00', 151),
(3946, '172.28.6.188', 1, '1000.00', 151),
(3947, '172.28.6.189', 1, '1000.00', 151),
(3948, '172.28.6.190', 1, '1000.00', 151),
(3949, '172.28.6.191', 1, '1000.00', 151),
(3950, '172.28.6.192', 1, '1000.00', 151),
(3951, '172.28.6.193', 1, '1000.00', 151),
(3952, '172.28.6.194', 1, '1000.00', 151),
(3953, '172.28.6.195', 1, '1000.00', 151),
(3954, '172.28.6.196', 1, '1000.00', 151),
(3955, '172.28.6.197', 1, '1000.00', 151),
(3956, '172.28.6.198', 1, '1000.00', 151),
(3957, '172.28.6.199', 1, '1000.00', 151),
(3958, '172.28.6.200', 1, '1000.00', 151),
(3959, '172.28.6.201', 1, '1000.00', 151),
(3960, '172.28.6.202', 1, '1000.00', 151),
(3961, '172.28.6.203', 1, '1000.00', 151),
(3962, '172.28.6.204', 1, '1000.00', 151),
(3963, '172.28.6.205', 1, '1000.00', 151),
(3964, '172.28.6.206', 1, '1000.00', 151),
(3965, '172.28.6.207', 1, '1000.00', 151),
(3966, '172.28.6.208', 1, '1000.00', 151),
(3967, '172.28.6.209', 1, '1000.00', 151),
(3968, '172.28.6.210', 1, '1000.00', 151),
(3969, '172.28.6.211', 1, '1000.00', 151),
(3970, '172.28.6.212', 1, '1000.00', 151),
(3971, '172.28.6.213', 1, '1000.00', 151),
(3972, '172.28.6.214', 1, '1000.00', 151),
(3973, '172.28.6.215', 1, '1000.00', 151),
(3974, '172.28.6.216', 1, '1000.00', 151),
(3975, '172.28.6.217', 1, '1000.00', 151),
(3976, '172.28.6.218', 1, '1000.00', 151),
(3977, '172.28.6.219', 1, '1000.00', 151),
(3978, '172.28.6.220', 1, '1000.00', 151),
(3979, '172.28.6.221', 1, '1000.00', 151),
(3980, '172.28.6.222', 1, '1000.00', 151),
(3981, '172.28.6.223', 1, '1000.00', 151),
(3982, '172.28.6.224', 1, '1000.00', 151),
(3983, '172.28.6.225', 1, '1000.00', 151),
(3984, '172.28.6.226', 1, '1000.00', 151),
(3985, '172.28.6.227', 1, '1000.00', 151),
(3986, '172.28.6.228', 1, '1000.00', 151),
(3987, '172.28.6.229', 1, '1000.00', 151),
(3988, '172.28.6.230', 1, '1000.00', 151),
(3989, '172.28.6.231', 1, '1000.00', 151),
(3990, '172.28.6.232', 1, '1000.00', 151),
(3991, '172.28.6.233', 1, '1000.00', 151),
(3992, '172.28.6.234', 1, '1000.00', 151),
(3993, '172.28.6.235', 1, '1000.00', 151),
(3994, '172.28.6.236', 1, '1000.00', 151),
(3995, '172.28.6.237', 1, '1000.00', 151),
(3996, '172.28.6.238', 1, '1000.00', 151),
(3997, '172.28.6.239', 1, '1000.00', 151),
(3998, '172.28.6.240', 1, '1000.00', 151),
(3999, '172.28.6.241', 1, '1000.00', 151),
(4000, '172.28.6.242', 1, '1000.00', 151),
(4001, '172.28.6.243', 1, '1000.00', 151),
(4002, '172.28.6.244', 1, '1000.00', 151),
(4003, '172.28.6.245', 1, '1000.00', 151),
(4004, '172.28.6.246', 1, '1000.00', 151),
(4005, '172.28.6.247', 1, '1000.00', 151),
(4006, '172.28.6.248', 1, '1000.00', 151),
(4007, '172.28.6.249', 1, '1000.00', 151),
(4008, '172.28.6.250', 1, '1000.00', 151),
(4009, '172.28.6.251', 1, '1000.00', 151),
(4010, '172.28.6.252', 1, '1000.00', 151),
(4011, '172.28.6.253', 1, '1000.00', 151),
(4012, '172.28.15.2', 1, '1000.00', 152),
(4013, '172.28.15.3', 1, '1000.00', 152),
(4014, '172.28.15.4', 1, '1000.00', 152),
(4015, '172.28.15.5', 1, '1000.00', 152),
(4016, '172.28.15.6', 1, '1000.00', 152),
(4017, '172.28.15.7', 1, '1000.00', 152),
(4018, '172.28.15.8', 1, '1000.00', 152),
(4019, '172.28.15.9', 1, '1000.00', 152),
(4020, '172.28.15.10', 1, '1000.00', 152),
(4021, '172.28.15.11', 1, '1000.00', 152),
(4022, '172.28.15.12', 1, '1000.00', 152),
(4023, '172.28.15.13', 1, '1000.00', 152),
(4024, '172.28.15.14', 1, '1000.00', 152),
(4025, '172.28.15.15', 1, '1000.00', 152),
(4026, '172.28.15.16', 1, '1000.00', 152),
(4027, '172.28.15.17', 1, '1000.00', 152),
(4028, '172.28.15.18', 1, '1000.00', 152),
(4029, '172.28.15.19', 1, '1000.00', 152),
(4030, '172.28.15.20', 1, '1000.00', 152),
(4031, '172.28.15.21', 1, '1000.00', 152),
(4032, '172.28.15.22', 1, '1000.00', 152),
(4033, '172.28.15.23', 1, '1000.00', 152),
(4034, '172.28.15.24', 1, '1000.00', 152),
(4035, '172.28.15.25', 1, '1000.00', 152),
(4036, '172.28.15.26', 1, '1000.00', 152),
(4037, '172.28.15.27', 1, '1000.00', 152),
(4038, '172.28.15.28', 1, '1000.00', 152),
(4039, '172.28.15.29', 1, '1000.00', 152),
(4040, '172.28.15.30', 1, '1000.00', 152),
(4041, '172.28.15.31', 1, '1000.00', 152),
(4042, '172.28.15.32', 1, '1000.00', 152),
(4043, '172.28.15.33', 1, '1000.00', 152),
(4044, '172.28.15.34', 1, '1000.00', 152),
(4045, '172.28.15.35', 1, '1000.00', 152),
(4046, '172.28.15.36', 1, '1000.00', 152),
(4047, '172.28.15.37', 1, '1000.00', 152),
(4048, '172.28.15.38', 1, '1000.00', 152),
(4049, '172.28.15.39', 1, '1000.00', 152),
(4050, '172.28.15.40', 1, '1000.00', 152),
(4051, '172.28.15.41', 1, '1000.00', 152),
(4052, '172.28.15.42', 1, '1000.00', 152),
(4053, '172.28.15.43', 1, '1000.00', 152),
(4054, '172.28.15.44', 1, '1000.00', 152),
(4055, '172.28.15.45', 1, '1000.00', 152),
(4056, '172.28.15.46', 1, '1000.00', 152),
(4057, '172.28.15.47', 1, '1000.00', 152),
(4058, '172.28.15.48', 1, '1000.00', 152),
(4059, '172.28.15.49', 1, '1000.00', 152),
(4060, '172.28.15.50', 1, '1000.00', 152),
(4061, '172.28.15.51', 1, '1000.00', 152),
(4062, '172.28.15.52', 1, '1000.00', 152),
(4063, '172.28.15.53', 1, '1000.00', 152),
(4064, '172.28.15.54', 1, '1000.00', 152),
(4065, '172.28.15.55', 1, '1000.00', 152),
(4066, '172.28.15.56', 1, '1000.00', 152),
(4067, '172.28.15.57', 1, '1000.00', 152),
(4068, '172.28.15.58', 1, '1000.00', 152),
(4069, '172.28.15.59', 1, '1000.00', 152),
(4070, '172.28.15.60', 1, '1000.00', 152),
(4071, '172.28.15.61', 1, '1000.00', 152),
(4072, '172.28.15.62', 1, '1000.00', 152),
(4073, '172.28.15.63', 1, '1000.00', 152),
(4074, '172.28.15.64', 1, '1000.00', 152),
(4075, '172.28.15.65', 1, '1000.00', 152),
(4076, '172.28.15.66', 1, '1000.00', 152),
(4077, '172.28.15.67', 1, '1000.00', 152),
(4078, '172.28.15.68', 1, '1000.00', 152),
(4079, '172.28.15.69', 1, '1000.00', 152),
(4080, '172.28.15.70', 1, '1000.00', 152),
(4081, '172.28.15.71', 1, '1000.00', 152),
(4082, '172.28.15.72', 1, '1000.00', 152),
(4083, '172.28.15.73', 1, '1000.00', 152),
(4084, '172.28.15.74', 1, '1000.00', 152),
(4085, '172.28.15.75', 1, '1000.00', 152),
(4086, '172.28.15.76', 1, '1000.00', 152),
(4087, '172.28.15.77', 1, '1000.00', 152),
(4088, '172.28.15.78', 1, '1000.00', 152),
(4089, '172.28.15.79', 1, '1000.00', 152),
(4090, '172.28.15.80', 1, '1000.00', 152),
(4091, '172.28.15.81', 1, '1000.00', 152),
(4092, '172.28.15.82', 1, '1000.00', 152),
(4093, '172.28.15.83', 1, '1000.00', 152),
(4094, '172.28.15.84', 1, '1000.00', 152),
(4095, '172.28.15.85', 1, '1000.00', 152),
(4096, '172.28.15.86', 1, '1000.00', 152),
(4097, '172.28.15.87', 1, '1000.00', 152),
(4098, '172.28.15.88', 1, '1000.00', 152),
(4099, '172.28.15.89', 1, '1000.00', 152),
(4100, '172.28.15.90', 1, '1000.00', 152),
(4101, '172.28.15.91', 1, '1000.00', 152),
(4102, '172.28.15.92', 1, '1000.00', 152),
(4103, '172.28.15.93', 1, '1000.00', 152),
(4104, '172.28.15.94', 1, '1000.00', 152),
(4105, '172.28.15.95', 1, '1000.00', 152),
(4106, '172.28.15.96', 1, '1000.00', 152),
(4107, '172.28.15.97', 1, '1000.00', 152),
(4108, '172.28.15.98', 1, '1000.00', 152),
(4109, '172.28.15.99', 1, '1000.00', 152),
(4110, '172.28.15.100', 1, '1000.00', 152),
(4111, '172.28.15.101', 1, '1000.00', 152),
(4112, '172.28.15.102', 1, '1000.00', 152),
(4113, '172.28.15.103', 1, '1000.00', 152),
(4114, '172.28.15.104', 1, '1000.00', 152),
(4115, '172.28.15.105', 1, '1000.00', 152),
(4116, '172.28.15.106', 1, '1000.00', 152),
(4117, '172.28.15.107', 1, '1000.00', 152),
(4118, '172.28.15.108', 1, '1000.00', 152),
(4119, '172.28.15.109', 1, '1000.00', 152),
(4120, '172.28.15.110', 1, '1000.00', 152),
(4121, '172.28.15.111', 1, '1000.00', 152),
(4122, '172.28.15.112', 1, '1000.00', 152),
(4123, '172.28.15.113', 1, '1000.00', 152),
(4124, '172.28.15.114', 1, '1000.00', 152),
(4125, '172.28.15.115', 1, '1000.00', 152),
(4126, '172.28.15.116', 1, '1000.00', 152),
(4127, '172.28.15.117', 1, '1000.00', 152),
(4128, '172.28.15.118', 1, '1000.00', 152),
(4129, '172.28.15.119', 1, '1000.00', 152),
(4130, '172.28.15.120', 1, '1000.00', 152),
(4131, '172.28.15.121', 1, '1000.00', 152),
(4132, '172.28.15.122', 1, '1000.00', 152),
(4133, '172.28.15.123', 1, '1000.00', 152),
(4134, '172.28.15.124', 1, '1000.00', 152),
(4135, '172.28.15.125', 1, '1000.00', 152),
(4136, '172.28.15.126', 1, '1000.00', 152),
(4137, '172.28.15.127', 1, '1000.00', 152),
(4138, '172.28.15.128', 1, '1000.00', 152),
(4139, '172.28.15.129', 1, '1000.00', 152),
(4140, '172.28.15.130', 1, '1000.00', 152),
(4141, '172.28.15.131', 1, '1000.00', 152),
(4142, '172.28.15.132', 1, '1000.00', 152),
(4143, '172.28.15.133', 1, '1000.00', 152),
(4144, '172.28.15.134', 1, '1000.00', 152),
(4145, '172.28.15.135', 1, '1000.00', 152),
(4146, '172.28.15.136', 1, '1000.00', 152),
(4147, '172.28.15.137', 1, '1000.00', 152),
(4148, '172.28.15.138', 1, '1000.00', 152),
(4149, '172.28.15.139', 1, '1000.00', 152),
(4150, '172.28.15.140', 1, '1000.00', 152),
(4151, '172.28.15.141', 1, '1000.00', 152),
(4152, '172.28.15.142', 1, '1000.00', 152),
(4153, '172.28.15.143', 1, '1000.00', 152),
(4154, '172.28.15.144', 1, '1000.00', 152),
(4155, '172.28.15.145', 1, '1000.00', 152),
(4156, '172.28.15.146', 1, '1000.00', 152),
(4157, '172.28.15.147', 1, '1000.00', 152),
(4158, '172.28.15.148', 1, '1000.00', 152),
(4159, '172.28.15.149', 1, '1000.00', 152),
(4160, '172.28.15.150', 1, '1000.00', 152),
(4161, '172.28.15.151', 1, '1000.00', 152),
(4162, '172.28.15.152', 1, '1000.00', 152),
(4163, '172.28.15.153', 1, '1000.00', 152),
(4164, '172.28.15.154', 1, '1000.00', 152),
(4165, '172.28.15.155', 1, '1000.00', 152),
(4166, '172.28.15.156', 1, '1000.00', 152),
(4167, '172.28.15.157', 1, '1000.00', 152),
(4168, '172.28.15.158', 1, '1000.00', 152),
(4169, '172.28.15.159', 1, '1000.00', 152),
(4170, '172.28.15.160', 1, '1000.00', 152),
(4171, '172.28.15.161', 1, '1000.00', 152),
(4172, '172.28.15.162', 1, '1000.00', 152),
(4173, '172.28.15.163', 1, '1000.00', 152),
(4174, '172.28.15.164', 1, '1000.00', 152),
(4175, '172.28.15.165', 1, '1000.00', 152),
(4176, '172.28.15.166', 1, '1000.00', 152),
(4177, '172.28.15.167', 1, '1000.00', 152),
(4178, '172.28.15.168', 1, '1000.00', 152),
(4179, '172.28.15.169', 1, '1000.00', 152),
(4180, '172.28.15.170', 1, '1000.00', 152),
(4181, '172.28.15.171', 1, '1000.00', 152),
(4182, '172.28.15.172', 1, '1000.00', 152),
(4183, '172.28.15.173', 1, '1000.00', 152),
(4184, '172.28.15.174', 1, '1000.00', 152),
(4185, '172.28.15.175', 1, '1000.00', 152),
(4186, '172.28.15.176', 1, '1000.00', 152),
(4187, '172.28.15.177', 1, '1000.00', 152),
(4188, '172.28.15.178', 1, '1000.00', 152),
(4189, '172.28.15.179', 1, '1000.00', 152),
(4190, '172.28.15.180', 1, '1000.00', 152),
(4191, '172.28.15.181', 1, '1000.00', 152),
(4192, '172.28.15.182', 1, '1000.00', 152),
(4193, '172.28.15.183', 1, '1000.00', 152),
(4194, '172.28.15.184', 1, '1000.00', 152),
(4195, '172.28.15.185', 1, '1000.00', 152),
(4196, '172.28.15.186', 1, '1000.00', 152),
(4197, '172.28.15.187', 1, '1000.00', 152),
(4198, '172.28.15.188', 1, '1000.00', 152),
(4199, '172.28.15.189', 1, '1000.00', 152),
(4200, '172.28.15.190', 1, '1000.00', 152),
(4201, '172.28.15.191', 1, '1000.00', 152),
(4202, '172.28.15.192', 1, '1000.00', 152),
(4203, '172.28.15.193', 1, '1000.00', 152),
(4204, '172.28.15.194', 1, '1000.00', 152),
(4205, '172.28.15.195', 1, '1000.00', 152),
(4206, '172.28.15.196', 1, '1000.00', 152),
(4207, '172.28.15.197', 1, '1000.00', 152),
(4208, '172.28.15.198', 1, '1000.00', 152),
(4209, '172.28.15.199', 1, '1000.00', 152),
(4210, '172.28.15.200', 1, '1000.00', 152),
(4211, '172.28.15.201', 1, '1000.00', 152),
(4212, '172.28.15.202', 1, '1000.00', 152),
(4213, '172.28.15.203', 1, '1000.00', 152),
(4214, '172.28.15.204', 1, '1000.00', 152),
(4215, '172.28.15.205', 1, '1000.00', 152),
(4216, '172.28.15.206', 1, '1000.00', 152),
(4217, '172.28.15.207', 1, '1000.00', 152),
(4218, '172.28.15.208', 1, '1000.00', 152),
(4219, '172.28.15.209', 1, '1000.00', 152),
(4220, '172.28.15.210', 1, '1000.00', 152),
(4221, '172.28.15.211', 1, '1000.00', 152),
(4222, '172.28.15.212', 1, '1000.00', 152),
(4223, '172.28.15.213', 1, '1000.00', 152),
(4224, '172.28.15.214', 1, '1000.00', 152),
(4225, '172.28.15.215', 1, '1000.00', 152),
(4226, '172.28.15.216', 1, '1000.00', 152),
(4227, '172.28.15.217', 1, '1000.00', 152),
(4228, '172.28.15.218', 1, '1000.00', 152),
(4229, '172.28.15.219', 1, '1000.00', 152),
(4230, '172.28.15.220', 1, '1000.00', 152),
(4231, '172.28.15.221', 1, '1000.00', 152),
(4232, '172.28.15.222', 1, '1000.00', 152),
(4233, '172.28.15.223', 1, '1000.00', 152),
(4234, '172.28.15.224', 1, '1000.00', 152),
(4235, '172.28.15.225', 1, '1000.00', 152),
(4236, '172.28.15.226', 1, '1000.00', 152),
(4237, '172.28.15.227', 1, '1000.00', 152),
(4238, '172.28.15.228', 1, '1000.00', 152),
(4239, '172.28.15.229', 1, '1000.00', 152),
(4240, '172.28.15.230', 1, '1000.00', 152),
(4241, '172.28.15.231', 1, '1000.00', 152),
(4242, '172.28.15.232', 1, '1000.00', 152),
(4243, '172.28.15.233', 1, '1000.00', 152),
(4244, '172.28.15.234', 1, '1000.00', 152),
(4245, '172.28.15.235', 1, '1000.00', 152),
(4246, '172.28.15.236', 1, '1000.00', 152),
(4247, '172.28.15.237', 1, '1000.00', 152),
(4248, '172.28.15.238', 1, '1000.00', 152),
(4249, '172.28.15.239', 1, '1000.00', 152),
(4250, '172.28.15.240', 1, '1000.00', 152),
(4251, '172.28.15.241', 1, '1000.00', 152),
(4252, '172.28.15.242', 1, '1000.00', 152),
(4253, '172.28.15.243', 1, '1000.00', 152),
(4254, '172.28.15.244', 1, '1000.00', 152),
(4255, '172.28.15.245', 1, '1000.00', 152),
(4256, '172.28.15.246', 1, '1000.00', 152),
(4257, '172.28.15.247', 1, '1000.00', 152),
(4258, '172.28.15.248', 1, '1000.00', 152),
(4259, '172.28.15.249', 1, '1000.00', 152),
(4260, '172.28.15.250', 1, '1000.00', 152),
(4261, '172.28.15.251', 1, '1000.00', 152),
(4262, '172.28.15.252', 1, '1000.00', 152),
(4263, '172.28.15.253', 1, '1000.00', 152),
(4264, '172.28.15.254', 1, '1000.00', 152),
(4518, '172.28.17.2', 1, '1000.00', 153),
(4519, '172.28.17.3', 1, '1000.00', 153),
(4520, '172.28.17.4', 1, '1000.00', 153),
(4521, '172.28.17.5', 1, '1000.00', 153),
(4522, '172.28.17.6', 1, '1000.00', 153),
(4523, '172.28.17.7', 1, '1000.00', 153),
(4524, '172.28.17.8', 1, '1000.00', 153),
(4525, '172.28.17.9', 1, '1000.00', 153),
(4526, '172.28.17.10', 1, '1000.00', 153),
(4527, '172.28.17.11', 1, '1000.00', 153),
(4528, '172.28.17.12', 1, '1000.00', 153),
(4529, '172.28.17.13', 1, '1000.00', 153),
(4530, '172.28.17.14', 1, '1000.00', 153),
(4531, '172.28.17.15', 1, '1000.00', 153);
INSERT INTO `ip_addresses` (`id`, `address`, `status`, `price`, `base_id`) VALUES
(4532, '172.28.17.16', 1, '1000.00', 153),
(4533, '172.28.17.17', 1, '1000.00', 153),
(4534, '172.28.17.18', 1, '1000.00', 153),
(4535, '172.28.17.19', 1, '1000.00', 153),
(4536, '172.28.17.20', 1, '1000.00', 153),
(4537, '172.28.17.21', 1, '1000.00', 153),
(4538, '172.28.17.22', 1, '1000.00', 153),
(4539, '172.28.17.23', 1, '1000.00', 153),
(4540, '172.28.17.24', 1, '1000.00', 153),
(4541, '172.28.17.25', 1, '1000.00', 153),
(4542, '172.28.17.26', 1, '1000.00', 153),
(4543, '172.28.17.27', 1, '1000.00', 153),
(4544, '172.28.17.28', 1, '1000.00', 153),
(4545, '172.28.17.29', 1, '1000.00', 153),
(4546, '172.28.17.30', 1, '1000.00', 153),
(4547, '172.28.17.31', 1, '1000.00', 153),
(4548, '172.28.17.32', 1, '1000.00', 153),
(4549, '172.28.17.33', 1, '1000.00', 153),
(4550, '172.28.17.34', 1, '1000.00', 153),
(4551, '172.28.17.35', 1, '1000.00', 153),
(4552, '172.28.17.36', 1, '1000.00', 153),
(4553, '172.28.17.37', 1, '1000.00', 153),
(4554, '172.28.17.38', 1, '1000.00', 153),
(4555, '172.28.17.39', 1, '1000.00', 153),
(4556, '172.28.17.40', 1, '1000.00', 153),
(4557, '172.28.17.41', 1, '1000.00', 153),
(4558, '172.28.17.42', 1, '1000.00', 153),
(4559, '172.28.17.43', 1, '1000.00', 153),
(4560, '172.28.17.44', 1, '1000.00', 153),
(4561, '172.28.17.45', 1, '1000.00', 153),
(4562, '172.28.17.46', 1, '1000.00', 153),
(4563, '172.28.17.47', 1, '1000.00', 153),
(4564, '172.28.17.48', 1, '1000.00', 153),
(4565, '172.28.17.49', 1, '1000.00', 153),
(4566, '172.28.17.50', 1, '1000.00', 153),
(4567, '172.28.17.51', 1, '1000.00', 153),
(4568, '172.28.17.52', 1, '1000.00', 153),
(4569, '172.28.17.53', 1, '1000.00', 153),
(4570, '172.28.17.54', 1, '1000.00', 153),
(4571, '172.28.17.55', 1, '1000.00', 153),
(4572, '172.28.17.56', 1, '1000.00', 153),
(4573, '172.28.17.57', 1, '1000.00', 153),
(4574, '172.28.17.58', 1, '1000.00', 153),
(4575, '172.28.17.59', 1, '1000.00', 153),
(4576, '172.28.17.60', 1, '1000.00', 153),
(4577, '172.28.17.61', 1, '1000.00', 153),
(4578, '172.28.17.62', 1, '1000.00', 153),
(4579, '172.28.17.63', 1, '1000.00', 153),
(4580, '172.28.17.64', 1, '1000.00', 153),
(4581, '172.28.17.65', 1, '1000.00', 153),
(4582, '172.28.17.66', 1, '1000.00', 153),
(4583, '172.28.17.67', 1, '1000.00', 153),
(4584, '172.28.17.68', 1, '1000.00', 153),
(4585, '172.28.17.69', 1, '1000.00', 153),
(4586, '172.28.17.70', 1, '1000.00', 153),
(4587, '172.28.17.71', 1, '1000.00', 153),
(4588, '172.28.17.72', 1, '1000.00', 153),
(4589, '172.28.17.73', 1, '1000.00', 153),
(4590, '172.28.17.74', 1, '1000.00', 153),
(4591, '172.28.17.75', 1, '1000.00', 153),
(4592, '172.28.17.76', 1, '1000.00', 153),
(4593, '172.28.17.77', 1, '1000.00', 153),
(4594, '172.28.17.78', 1, '1000.00', 153),
(4595, '172.28.17.79', 1, '1000.00', 153),
(4596, '172.28.17.80', 1, '1000.00', 153),
(4597, '172.28.17.81', 1, '1000.00', 153),
(4598, '172.28.17.82', 1, '1000.00', 153),
(4599, '172.28.17.83', 1, '1000.00', 153),
(4600, '172.28.17.84', 1, '1000.00', 153),
(4601, '172.28.17.85', 1, '1000.00', 153),
(4602, '172.28.17.86', 1, '1000.00', 153),
(4603, '172.28.17.87', 1, '1000.00', 153),
(4604, '172.28.17.88', 1, '1000.00', 153),
(4605, '172.28.17.89', 1, '1000.00', 153),
(4606, '172.28.17.90', 1, '1000.00', 153),
(4607, '172.28.17.91', 1, '1000.00', 153),
(4608, '172.28.17.92', 1, '1000.00', 153),
(4609, '172.28.17.93', 1, '1000.00', 153),
(4610, '172.28.17.94', 1, '1000.00', 153),
(4611, '172.28.17.95', 1, '1000.00', 153),
(4612, '172.28.17.96', 1, '1000.00', 153),
(4613, '172.28.17.97', 1, '1000.00', 153),
(4614, '172.28.17.98', 1, '1000.00', 153),
(4615, '172.28.17.99', 1, '1000.00', 153),
(4616, '172.28.17.100', 1, '1000.00', 153),
(4617, '172.28.17.101', 1, '1000.00', 153),
(4618, '172.28.17.102', 1, '1000.00', 153),
(4619, '172.28.17.103', 1, '1000.00', 153),
(4620, '172.28.17.104', 1, '1000.00', 153),
(4621, '172.28.17.105', 1, '1000.00', 153),
(4622, '172.28.17.106', 1, '1000.00', 153),
(4623, '172.28.17.107', 1, '1000.00', 153),
(4624, '172.28.17.108', 1, '1000.00', 153),
(4625, '172.28.17.109', 1, '1000.00', 153),
(4626, '172.28.17.110', 1, '1000.00', 153),
(4627, '172.28.17.111', 1, '1000.00', 153),
(4628, '172.28.17.112', 1, '1000.00', 153),
(4629, '172.28.17.113', 1, '1000.00', 153),
(4630, '172.28.17.114', 1, '1000.00', 153),
(4631, '172.28.17.115', 1, '1000.00', 153),
(4632, '172.28.17.116', 1, '1000.00', 153),
(4633, '172.28.17.117', 1, '1000.00', 153),
(4634, '172.28.17.118', 1, '1000.00', 153),
(4635, '172.28.17.119', 1, '1000.00', 153),
(4636, '172.28.17.120', 1, '1000.00', 153),
(4637, '172.28.17.121', 1, '1000.00', 153),
(4638, '172.28.17.122', 1, '1000.00', 153),
(4639, '172.28.17.123', 1, '1000.00', 153),
(4640, '172.28.17.124', 1, '1000.00', 153),
(4641, '172.28.17.125', 1, '1000.00', 153),
(4642, '172.28.17.126', 1, '1000.00', 153),
(4643, '172.28.17.127', 1, '1000.00', 153),
(4644, '172.28.17.128', 1, '1000.00', 153),
(4645, '172.28.17.129', 1, '1000.00', 153),
(4646, '172.28.17.130', 1, '1000.00', 153),
(4647, '172.28.17.131', 1, '1000.00', 153),
(4648, '172.28.17.132', 1, '1000.00', 153),
(4649, '172.28.17.133', 1, '1000.00', 153),
(4650, '172.28.17.134', 1, '1000.00', 153),
(4651, '172.28.17.135', 1, '1000.00', 153),
(4652, '172.28.17.136', 1, '1000.00', 153),
(4653, '172.28.17.137', 1, '1000.00', 153),
(4654, '172.28.17.138', 1, '1000.00', 153),
(4655, '172.28.17.139', 1, '1000.00', 153),
(4656, '172.28.17.140', 1, '1000.00', 153),
(4657, '172.28.17.141', 1, '1000.00', 153),
(4658, '172.28.17.142', 1, '1000.00', 153),
(4659, '172.28.17.143', 1, '1000.00', 153),
(4660, '172.28.17.144', 1, '1000.00', 153),
(4661, '172.28.17.145', 1, '1000.00', 153),
(4662, '172.28.17.146', 1, '1000.00', 153),
(4663, '172.28.17.147', 1, '1000.00', 153),
(4664, '172.28.17.148', 1, '1000.00', 153),
(4665, '172.28.17.149', 1, '1000.00', 153),
(4666, '172.28.17.150', 1, '1000.00', 153),
(4667, '172.28.17.151', 1, '1000.00', 153),
(4668, '172.28.17.152', 1, '1000.00', 153),
(4669, '172.28.17.153', 1, '1000.00', 153),
(4670, '172.28.17.154', 1, '1000.00', 153),
(4671, '172.28.17.155', 1, '1000.00', 153),
(4672, '172.28.17.156', 1, '1000.00', 153),
(4673, '172.28.17.157', 1, '1000.00', 153),
(4674, '172.28.17.158', 1, '1000.00', 153),
(4675, '172.28.17.159', 1, '1000.00', 153),
(4676, '172.28.17.160', 1, '1000.00', 153),
(4677, '172.28.17.161', 1, '1000.00', 153),
(4678, '172.28.17.162', 1, '1000.00', 153),
(4679, '172.28.17.163', 1, '1000.00', 153),
(4680, '172.28.17.164', 1, '1000.00', 153),
(4681, '172.28.17.165', 1, '1000.00', 153),
(4682, '172.28.17.166', 1, '1000.00', 153),
(4683, '172.28.17.167', 1, '1000.00', 153),
(4684, '172.28.17.168', 1, '1000.00', 153),
(4685, '172.28.17.169', 1, '1000.00', 153),
(4686, '172.28.17.170', 1, '1000.00', 153),
(4687, '172.28.17.171', 1, '1000.00', 153),
(4688, '172.28.17.172', 1, '1000.00', 153),
(4689, '172.28.17.173', 1, '1000.00', 153),
(4690, '172.28.17.174', 1, '1000.00', 153),
(4691, '172.28.17.175', 1, '1000.00', 153),
(4692, '172.28.17.176', 1, '1000.00', 153),
(4693, '172.28.17.177', 1, '1000.00', 153),
(4694, '172.28.17.178', 1, '1000.00', 153),
(4695, '172.28.17.179', 1, '1000.00', 153),
(4696, '172.28.17.180', 1, '1000.00', 153),
(4697, '172.28.17.181', 1, '1000.00', 153),
(4698, '172.28.17.182', 1, '1000.00', 153),
(4699, '172.28.17.183', 1, '1000.00', 153),
(4700, '172.28.17.184', 1, '1000.00', 153),
(4701, '172.28.17.185', 1, '1000.00', 153),
(4702, '172.28.17.186', 1, '1000.00', 153),
(4703, '172.28.17.187', 1, '1000.00', 153),
(4704, '172.28.17.188', 1, '1000.00', 153),
(4705, '172.28.17.189', 1, '1000.00', 153),
(4706, '172.28.17.190', 1, '1000.00', 153),
(4707, '172.28.17.191', 1, '1000.00', 153),
(4708, '172.28.17.192', 1, '1000.00', 153),
(4709, '172.28.17.193', 1, '1000.00', 153),
(4710, '172.28.17.194', 1, '1000.00', 153),
(4711, '172.28.17.195', 1, '1000.00', 153),
(4712, '172.28.17.196', 1, '1000.00', 153),
(4713, '172.28.17.197', 1, '1000.00', 153),
(4714, '172.28.17.198', 1, '1000.00', 153),
(4715, '172.28.17.199', 1, '1000.00', 153),
(4716, '172.28.17.200', 1, '1000.00', 153),
(4717, '172.28.17.201', 1, '1000.00', 153),
(4718, '172.28.17.202', 1, '1000.00', 153),
(4719, '172.28.17.203', 1, '1000.00', 153),
(4720, '172.28.17.204', 1, '1000.00', 153),
(4721, '172.28.17.205', 1, '1000.00', 153),
(4722, '172.28.17.206', 1, '1000.00', 153),
(4723, '172.28.17.207', 1, '1000.00', 153),
(4724, '172.28.17.208', 1, '1000.00', 153),
(4725, '172.28.17.209', 1, '1000.00', 153),
(4726, '172.28.17.210', 1, '1000.00', 153),
(4727, '172.28.17.211', 1, '1000.00', 153),
(4728, '172.28.17.212', 1, '1000.00', 153),
(4729, '172.28.17.213', 1, '1000.00', 153),
(4730, '172.28.17.214', 1, '1000.00', 153),
(4731, '172.28.17.215', 1, '1000.00', 153),
(4732, '172.28.17.216', 1, '1000.00', 153),
(4733, '172.28.17.217', 1, '1000.00', 153),
(4734, '172.28.17.218', 1, '1000.00', 153),
(4735, '172.28.17.219', 1, '1000.00', 153),
(4736, '172.28.17.220', 1, '1000.00', 153),
(4737, '172.28.17.221', 1, '1000.00', 153),
(4738, '172.28.17.222', 1, '1000.00', 153),
(4739, '172.28.17.223', 1, '1000.00', 153),
(4740, '172.28.17.224', 1, '1000.00', 153),
(4741, '172.28.17.225', 1, '1000.00', 153),
(4742, '172.28.17.226', 1, '1000.00', 153),
(4743, '172.28.17.227', 1, '1000.00', 153),
(4744, '172.28.17.228', 1, '1000.00', 153),
(4745, '172.28.17.229', 1, '1000.00', 153),
(4746, '172.28.17.230', 1, '1000.00', 153),
(4747, '172.28.17.231', 1, '1000.00', 153),
(4748, '172.28.17.232', 1, '1000.00', 153),
(4749, '172.28.17.233', 1, '1000.00', 153),
(4750, '172.28.17.234', 1, '1000.00', 153),
(4751, '172.28.17.235', 1, '1000.00', 153),
(4752, '172.28.17.236', 1, '1000.00', 153),
(4753, '172.28.17.237', 1, '1000.00', 153),
(4754, '172.28.17.238', 1, '1000.00', 153),
(4755, '172.28.17.239', 1, '1000.00', 153),
(4756, '172.28.17.240', 1, '1000.00', 153),
(4757, '172.28.17.241', 1, '1000.00', 153),
(4758, '172.28.17.242', 1, '1000.00', 153),
(4759, '172.28.17.243', 1, '1000.00', 153),
(4760, '172.28.17.244', 1, '1000.00', 153),
(4761, '172.28.17.245', 1, '1000.00', 153),
(4762, '172.28.17.246', 1, '1000.00', 153),
(4763, '172.28.17.247', 1, '1000.00', 153),
(4764, '172.28.17.248', 1, '1000.00', 153),
(4765, '172.28.17.249', 1, '1000.00', 153),
(4766, '172.28.17.250', 1, '1000.00', 153),
(4767, '172.28.17.251', 1, '1000.00', 153),
(4768, '172.28.17.252', 1, '1000.00', 153),
(4769, '172.28.17.253', 1, '1000.00', 153),
(4770, '172.28.17.254', 1, '1000.00', 153),
(4771, '172.28.26.2', 1, '1000.00', 153),
(4772, '172.28.26.3', 1, '1000.00', 153),
(4773, '172.28.26.4', 1, '1000.00', 153),
(4774, '172.28.26.5', 1, '1000.00', 153),
(4775, '172.28.26.6', 1, '1000.00', 153),
(4776, '172.28.26.7', 1, '1000.00', 153),
(4777, '172.28.26.8', 1, '1000.00', 153),
(4778, '172.28.26.9', 1, '1000.00', 153),
(4779, '172.28.26.10', 1, '1000.00', 153),
(4780, '172.28.26.11', 1, '1000.00', 153),
(4781, '172.28.26.12', 1, '1000.00', 153),
(4782, '172.28.26.13', 1, '1000.00', 153),
(4783, '172.28.26.14', 1, '1000.00', 153),
(4784, '172.28.26.15', 1, '1000.00', 153),
(4785, '172.28.26.16', 1, '1000.00', 153),
(4786, '172.28.26.17', 1, '1000.00', 153),
(4787, '172.28.26.18', 1, '1000.00', 153),
(4788, '172.28.26.19', 1, '1000.00', 153),
(4789, '172.28.26.20', 1, '1000.00', 153),
(4790, '172.28.26.21', 1, '1000.00', 153),
(4791, '172.28.26.22', 1, '1000.00', 153),
(4792, '172.28.26.23', 1, '1000.00', 153),
(4793, '172.28.26.24', 1, '1000.00', 153),
(4794, '172.28.26.25', 1, '1000.00', 153),
(4795, '172.28.26.26', 1, '1000.00', 153),
(4796, '172.28.26.27', 1, '1000.00', 153),
(4797, '172.28.26.28', 1, '1000.00', 153),
(4798, '172.28.26.29', 1, '1000.00', 153),
(4799, '172.28.26.30', 1, '1000.00', 153),
(4800, '172.28.26.31', 1, '1000.00', 153),
(4801, '172.28.26.32', 1, '1000.00', 153),
(4802, '172.28.26.33', 1, '1000.00', 153),
(4803, '172.28.26.34', 1, '1000.00', 153),
(4804, '172.28.26.35', 1, '1000.00', 153),
(4805, '172.28.26.36', 1, '1000.00', 153),
(4806, '172.28.26.37', 1, '1000.00', 153),
(4807, '172.28.26.38', 1, '1000.00', 153),
(4808, '172.28.26.39', 1, '1000.00', 153),
(4809, '172.28.26.40', 1, '1000.00', 153),
(4810, '172.28.26.41', 1, '1000.00', 153),
(4811, '172.28.26.42', 1, '1000.00', 153),
(4812, '172.28.26.43', 1, '1000.00', 153),
(4813, '172.28.26.44', 1, '1000.00', 153),
(4814, '172.28.26.45', 1, '1000.00', 153),
(4815, '172.28.26.46', 1, '1000.00', 153),
(4816, '172.28.26.47', 1, '1000.00', 153),
(4817, '172.28.26.48', 1, '1000.00', 153),
(4818, '172.28.26.49', 1, '1000.00', 153),
(4819, '172.28.26.50', 1, '1000.00', 153),
(4820, '172.28.26.51', 1, '1000.00', 153),
(4821, '172.28.26.52', 1, '1000.00', 153),
(4822, '172.28.26.53', 1, '1000.00', 153),
(4823, '172.28.26.54', 1, '1000.00', 153),
(4824, '172.28.26.55', 1, '1000.00', 153),
(4825, '172.28.26.56', 1, '1000.00', 153),
(4826, '172.28.26.57', 1, '1000.00', 153),
(4827, '172.28.26.58', 1, '1000.00', 153),
(4828, '172.28.26.59', 1, '1000.00', 153),
(4829, '172.28.26.60', 1, '1000.00', 153),
(4830, '172.28.26.61', 1, '1000.00', 153),
(4831, '172.28.26.62', 1, '1000.00', 153),
(4832, '172.28.26.63', 1, '1000.00', 153),
(4833, '172.28.26.64', 1, '1000.00', 153),
(4834, '172.28.26.65', 1, '1000.00', 153),
(4835, '172.28.26.66', 1, '1000.00', 153),
(4836, '172.28.26.67', 1, '1000.00', 153),
(4837, '172.28.26.68', 1, '1000.00', 153),
(4838, '172.28.26.69', 1, '1000.00', 153),
(4839, '172.28.26.70', 1, '1000.00', 153),
(4840, '172.28.26.71', 1, '1000.00', 153),
(4841, '172.28.26.72', 1, '1000.00', 153),
(4842, '172.28.26.73', 1, '1000.00', 153),
(4843, '172.28.26.74', 1, '1000.00', 153),
(4844, '172.28.26.75', 1, '1000.00', 153),
(4845, '172.28.26.76', 1, '1000.00', 153),
(4846, '172.28.26.77', 1, '1000.00', 153),
(4847, '172.28.26.78', 1, '1000.00', 153),
(4848, '172.28.26.79', 1, '1000.00', 153),
(4849, '172.28.26.80', 1, '1000.00', 153),
(4850, '172.28.26.81', 1, '1000.00', 153),
(4851, '172.28.26.82', 1, '1000.00', 153),
(4852, '172.28.26.83', 1, '1000.00', 153),
(4853, '172.28.26.84', 1, '1000.00', 153),
(4854, '172.28.26.85', 1, '1000.00', 153),
(4855, '172.28.26.86', 1, '1000.00', 153),
(4856, '172.28.26.87', 1, '1000.00', 153),
(4857, '172.28.26.88', 1, '1000.00', 153),
(4858, '172.28.26.89', 1, '1000.00', 153),
(4859, '172.28.26.90', 1, '1000.00', 153),
(4860, '172.28.26.91', 1, '1000.00', 153),
(4861, '172.28.26.92', 1, '1000.00', 153),
(4862, '172.28.26.93', 1, '1000.00', 153),
(4863, '172.28.26.94', 1, '1000.00', 153),
(4864, '172.28.26.95', 1, '1000.00', 153),
(4865, '172.28.26.96', 1, '1000.00', 153),
(4866, '172.28.26.97', 1, '1000.00', 153),
(4867, '172.28.26.98', 1, '1000.00', 153),
(4868, '172.28.26.99', 1, '1000.00', 153),
(4869, '172.28.26.100', 1, '1000.00', 153),
(4870, '172.28.26.101', 1, '1000.00', 153),
(4871, '172.28.26.102', 1, '1000.00', 153),
(4872, '172.28.26.103', 1, '1000.00', 153),
(4873, '172.28.26.104', 1, '1000.00', 153),
(4874, '172.28.26.105', 1, '1000.00', 153),
(4875, '172.28.26.106', 1, '1000.00', 153),
(4876, '172.28.26.107', 1, '1000.00', 153),
(4877, '172.28.26.108', 1, '1000.00', 153),
(4878, '172.28.26.109', 1, '1000.00', 153),
(4879, '172.28.26.110', 1, '1000.00', 153),
(4880, '172.28.26.111', 1, '1000.00', 153),
(4881, '172.28.26.112', 1, '1000.00', 153),
(4882, '172.28.26.113', 1, '1000.00', 153),
(4883, '172.28.26.114', 1, '1000.00', 153),
(4884, '172.28.26.115', 1, '1000.00', 153),
(4885, '172.28.26.116', 1, '1000.00', 153),
(4886, '172.28.26.117', 1, '1000.00', 153),
(4887, '172.28.26.118', 1, '1000.00', 153),
(4888, '172.28.26.119', 1, '1000.00', 153),
(4889, '172.28.26.120', 1, '1000.00', 153),
(4890, '172.28.26.121', 1, '1000.00', 153),
(4891, '172.28.26.122', 1, '1000.00', 153),
(4892, '172.28.26.123', 1, '1000.00', 153),
(4893, '172.28.26.124', 1, '1000.00', 153),
(4894, '172.28.26.125', 1, '1000.00', 153),
(4895, '172.28.26.126', 1, '1000.00', 153),
(4896, '172.28.26.127', 1, '1000.00', 153),
(4897, '172.28.26.128', 1, '1000.00', 153),
(4898, '172.28.26.129', 1, '1000.00', 153),
(4899, '172.28.26.130', 1, '1000.00', 153),
(4900, '172.28.26.131', 1, '1000.00', 153),
(4901, '172.28.26.132', 1, '1000.00', 153),
(4902, '172.28.26.133', 1, '1000.00', 153),
(4903, '172.28.26.134', 1, '1000.00', 153),
(4904, '172.28.26.135', 1, '1000.00', 153),
(4905, '172.28.26.136', 1, '1000.00', 153),
(4906, '172.28.26.137', 1, '1000.00', 153),
(4907, '172.28.26.138', 1, '1000.00', 153),
(4908, '172.28.26.139', 1, '1000.00', 153),
(4909, '172.28.26.140', 1, '1000.00', 153),
(4910, '172.28.26.141', 1, '1000.00', 153),
(4911, '172.28.26.142', 1, '1000.00', 153),
(4912, '172.28.26.143', 1, '1000.00', 153),
(4913, '172.28.26.144', 1, '1000.00', 153),
(4914, '172.28.26.145', 1, '1000.00', 153),
(4915, '172.28.26.146', 1, '1000.00', 153),
(4916, '172.28.26.147', 1, '1000.00', 153),
(4917, '172.28.26.148', 1, '1000.00', 153),
(4918, '172.28.26.149', 1, '1000.00', 153),
(4919, '172.28.26.150', 1, '1000.00', 153),
(4920, '172.28.26.151', 1, '1000.00', 153),
(4921, '172.28.26.152', 1, '1000.00', 153),
(4922, '172.28.26.153', 1, '1000.00', 153),
(4923, '172.28.26.154', 1, '1000.00', 153),
(4924, '172.28.26.155', 1, '1000.00', 153),
(4925, '172.28.26.156', 1, '1000.00', 153),
(4926, '172.28.26.157', 1, '1000.00', 153),
(4927, '172.28.26.158', 1, '1000.00', 153),
(4928, '172.28.26.159', 1, '1000.00', 153),
(4929, '172.28.26.160', 1, '1000.00', 153),
(4930, '172.28.26.161', 1, '1000.00', 153),
(4931, '172.28.26.162', 1, '1000.00', 153),
(4932, '172.28.26.163', 1, '1000.00', 153),
(4933, '172.28.26.164', 1, '1000.00', 153),
(4934, '172.28.26.165', 1, '1000.00', 153),
(4935, '172.28.26.166', 1, '1000.00', 153),
(4936, '172.28.26.167', 1, '1000.00', 153),
(4937, '172.28.26.168', 1, '1000.00', 153),
(4938, '172.28.26.169', 1, '1000.00', 153),
(4939, '172.28.26.170', 1, '1000.00', 153),
(4940, '172.28.26.171', 1, '1000.00', 153),
(4941, '172.28.26.172', 1, '1000.00', 153),
(4942, '172.28.26.173', 1, '1000.00', 153),
(4943, '172.28.26.174', 1, '1000.00', 153),
(4944, '172.28.26.175', 1, '1000.00', 153),
(4945, '172.28.26.176', 1, '1000.00', 153),
(4946, '172.28.26.177', 1, '1000.00', 153),
(4947, '172.28.26.178', 1, '1000.00', 153),
(4948, '172.28.26.179', 1, '1000.00', 153),
(4949, '172.28.26.180', 1, '1000.00', 153),
(4950, '172.28.26.181', 1, '1000.00', 153),
(4951, '172.28.26.182', 1, '1000.00', 153),
(4952, '172.28.26.183', 1, '1000.00', 153),
(4953, '172.28.26.184', 1, '1000.00', 153),
(4954, '172.28.26.185', 1, '1000.00', 153),
(4955, '172.28.26.186', 1, '1000.00', 153),
(4956, '172.28.26.187', 1, '1000.00', 153),
(4957, '172.28.26.188', 1, '1000.00', 153),
(4958, '172.28.26.189', 1, '1000.00', 153),
(4959, '172.28.26.190', 1, '1000.00', 153),
(4960, '172.28.26.191', 1, '1000.00', 153),
(4961, '172.28.26.192', 1, '1000.00', 153),
(4962, '172.28.26.193', 1, '1000.00', 153),
(4963, '172.28.26.194', 1, '1000.00', 153),
(4964, '172.28.26.195', 1, '1000.00', 153),
(4965, '172.28.26.196', 1, '1000.00', 153),
(4966, '172.28.26.197', 1, '1000.00', 153),
(4967, '172.28.26.198', 1, '1000.00', 153),
(4968, '172.28.26.199', 1, '1000.00', 153),
(4969, '172.28.26.200', 1, '1000.00', 153),
(4970, '172.28.26.201', 1, '1000.00', 153),
(4971, '172.28.26.202', 1, '1000.00', 153),
(4972, '172.28.26.203', 1, '1000.00', 153),
(4973, '172.28.26.204', 1, '1000.00', 153),
(4974, '172.28.26.205', 1, '1000.00', 153),
(4975, '172.28.26.206', 1, '1000.00', 153),
(4976, '172.28.26.207', 1, '1000.00', 153),
(4977, '172.28.26.208', 1, '1000.00', 153),
(4978, '172.28.26.209', 1, '1000.00', 153),
(4979, '172.28.26.210', 1, '1000.00', 153),
(4980, '172.28.26.211', 1, '1000.00', 153),
(4981, '172.28.26.212', 1, '1000.00', 153),
(4982, '172.28.26.213', 1, '1000.00', 153),
(4983, '172.28.26.214', 1, '1000.00', 153),
(4984, '172.28.26.215', 1, '1000.00', 153),
(4985, '172.28.26.216', 1, '1000.00', 153),
(4986, '172.28.26.217', 1, '1000.00', 153),
(4987, '172.28.26.218', 1, '1000.00', 153),
(4988, '172.28.26.219', 1, '1000.00', 153),
(4989, '172.28.26.220', 1, '1000.00', 153),
(4990, '172.28.26.221', 1, '1000.00', 153),
(4991, '172.28.26.222', 1, '1000.00', 153),
(4992, '172.28.26.223', 1, '1000.00', 153),
(4993, '172.28.26.224', 1, '1000.00', 153),
(4994, '172.28.26.225', 1, '1000.00', 153),
(4995, '172.28.26.226', 1, '1000.00', 153),
(4996, '172.28.26.227', 1, '1000.00', 153),
(4997, '172.28.26.228', 1, '1000.00', 153),
(4998, '172.28.26.229', 1, '1000.00', 153),
(4999, '172.28.26.230', 1, '1000.00', 153),
(5000, '172.28.26.231', 1, '1000.00', 153),
(5001, '172.28.26.232', 1, '1000.00', 153),
(5002, '172.28.26.233', 1, '1000.00', 153),
(5003, '172.28.26.234', 1, '1000.00', 153),
(5004, '172.28.26.235', 1, '1000.00', 153),
(5005, '172.28.26.236', 1, '1000.00', 153),
(5006, '172.28.26.237', 1, '1000.00', 153),
(5007, '172.28.26.238', 1, '1000.00', 153),
(5008, '172.28.26.239', 1, '1000.00', 153),
(5009, '172.28.26.240', 1, '1000.00', 153),
(5010, '172.28.26.241', 1, '1000.00', 153),
(5011, '172.28.26.242', 1, '1000.00', 153),
(5012, '172.28.26.243', 1, '1000.00', 153),
(5013, '172.28.26.244', 1, '1000.00', 153),
(5014, '172.28.26.245', 1, '1000.00', 153),
(5015, '172.28.26.246', 1, '1000.00', 153),
(5016, '172.28.26.247', 1, '1000.00', 153),
(5017, '172.28.26.248', 1, '1000.00', 153),
(5018, '172.28.26.249', 1, '1000.00', 153),
(5019, '172.28.26.250', 1, '1000.00', 153),
(5020, '172.28.26.251', 1, '1000.00', 153),
(5021, '172.28.26.252', 1, '1000.00', 153),
(5022, '172.28.26.253', 1, '1000.00', 153),
(5023, '172.28.26.254', 1, '1000.00', 153),
(5024, '172.28.13.2', 1, '1000.00', 155),
(5025, '172.28.13.3', 1, '1000.00', 155),
(5026, '172.28.13.4', 1, '1000.00', 155),
(5027, '172.28.13.5', 1, '1000.00', 155),
(5028, '172.28.13.6', 1, '1000.00', 155),
(5029, '172.28.13.7', 1, '1000.00', 155),
(5030, '172.28.13.8', 1, '1000.00', 155),
(5031, '172.28.13.9', 1, '1000.00', 155),
(5032, '172.28.13.10', 1, '1000.00', 155),
(5033, '172.28.13.11', 1, '1000.00', 155),
(5034, '172.28.13.12', 1, '1000.00', 155),
(5035, '172.28.13.13', 1, '1000.00', 155),
(5036, '172.28.13.14', 1, '1000.00', 155),
(5037, '172.28.13.15', 1, '1000.00', 155),
(5038, '172.28.13.16', 1, '1000.00', 155),
(5039, '172.28.13.17', 1, '1000.00', 155),
(5040, '172.28.13.18', 1, '1000.00', 155),
(5041, '172.28.13.19', 1, '1000.00', 155),
(5042, '172.28.13.20', 1, '1000.00', 155),
(5043, '172.28.13.21', 1, '1000.00', 155),
(5044, '172.28.13.22', 1, '1000.00', 155),
(5045, '172.28.13.23', 1, '1000.00', 155),
(5046, '172.28.13.24', 1, '1000.00', 155),
(5047, '172.28.13.25', 1, '1000.00', 155),
(5048, '172.28.13.26', 1, '1000.00', 155),
(5049, '172.28.13.27', 1, '1000.00', 155),
(5050, '172.28.13.28', 1, '1000.00', 155),
(5051, '172.28.13.29', 1, '1000.00', 155),
(5052, '172.28.13.30', 1, '1000.00', 155),
(5053, '172.28.13.31', 1, '1000.00', 155),
(5054, '172.28.13.32', 1, '1000.00', 155),
(5055, '172.28.13.33', 1, '1000.00', 155),
(5056, '172.28.13.34', 1, '1000.00', 155),
(5057, '172.28.13.35', 1, '1000.00', 155),
(5058, '172.28.13.36', 1, '1000.00', 155),
(5059, '172.28.13.37', 1, '1000.00', 155),
(5060, '172.28.13.38', 1, '1000.00', 155),
(5061, '172.28.13.39', 1, '1000.00', 155),
(5062, '172.28.13.40', 1, '1000.00', 155),
(5063, '172.28.13.41', 1, '1000.00', 155),
(5064, '172.28.13.42', 1, '1000.00', 155),
(5065, '172.28.13.43', 1, '1000.00', 155),
(5066, '172.28.13.44', 1, '1000.00', 155),
(5067, '172.28.13.45', 1, '1000.00', 155),
(5068, '172.28.13.46', 1, '1000.00', 155),
(5069, '172.28.13.47', 1, '1000.00', 155),
(5070, '172.28.13.48', 1, '1000.00', 155),
(5071, '172.28.13.49', 1, '1000.00', 155),
(5072, '172.28.13.50', 1, '1000.00', 155),
(5073, '172.28.13.51', 1, '1000.00', 155),
(5074, '172.28.13.52', 1, '1000.00', 155),
(5075, '172.28.13.53', 1, '1000.00', 155),
(5076, '172.28.13.54', 1, '1000.00', 155),
(5077, '172.28.13.55', 1, '1000.00', 155),
(5078, '172.28.13.56', 1, '1000.00', 155),
(5079, '172.28.13.57', 1, '1000.00', 155),
(5080, '172.28.13.58', 1, '1000.00', 155),
(5081, '172.28.13.59', 1, '1000.00', 155),
(5082, '172.28.13.60', 1, '1000.00', 155),
(5083, '172.28.13.61', 1, '1000.00', 155),
(5084, '172.28.13.62', 1, '1000.00', 155),
(5085, '172.28.13.63', 1, '1000.00', 155),
(5086, '172.28.13.64', 1, '1000.00', 155),
(5087, '172.28.13.65', 1, '1000.00', 155),
(5088, '172.28.13.66', 1, '1000.00', 155),
(5089, '172.28.13.67', 1, '1000.00', 155),
(5090, '172.28.13.68', 1, '1000.00', 155),
(5091, '172.28.13.69', 1, '1000.00', 155),
(5092, '172.28.13.70', 1, '1000.00', 155),
(5093, '172.28.13.71', 1, '1000.00', 155),
(5094, '172.28.13.72', 1, '1000.00', 155),
(5095, '172.28.13.73', 1, '1000.00', 155),
(5096, '172.28.13.74', 1, '1000.00', 155),
(5097, '172.28.13.75', 1, '1000.00', 155),
(5098, '172.28.13.76', 1, '1000.00', 155),
(5099, '172.28.13.77', 1, '1000.00', 155),
(5100, '172.28.13.78', 1, '1000.00', 155),
(5101, '172.28.13.79', 1, '1000.00', 155),
(5102, '172.28.13.80', 1, '1000.00', 155),
(5103, '172.28.13.81', 1, '1000.00', 155),
(5104, '172.28.13.82', 1, '1000.00', 155),
(5105, '172.28.13.83', 1, '1000.00', 155),
(5106, '172.28.13.84', 1, '1000.00', 155),
(5107, '172.28.13.85', 1, '1000.00', 155),
(5108, '172.28.13.86', 1, '1000.00', 155),
(5109, '172.28.13.87', 1, '1000.00', 155),
(5110, '172.28.13.88', 1, '1000.00', 155),
(5111, '172.28.13.89', 1, '1000.00', 155),
(5112, '172.28.13.90', 1, '1000.00', 155),
(5113, '172.28.13.91', 1, '1000.00', 155),
(5114, '172.28.13.92', 1, '1000.00', 155),
(5115, '172.28.13.93', 1, '1000.00', 155),
(5116, '172.28.13.94', 1, '1000.00', 155),
(5117, '172.28.13.95', 1, '1000.00', 155),
(5118, '172.28.13.96', 1, '1000.00', 155),
(5119, '172.28.13.97', 1, '1000.00', 155),
(5120, '172.28.13.98', 1, '1000.00', 155),
(5121, '172.28.13.99', 1, '1000.00', 155),
(5122, '172.28.13.100', 1, '1000.00', 155),
(5123, '172.28.13.101', 1, '1000.00', 155),
(5124, '172.28.13.102', 1, '1000.00', 155),
(5125, '172.28.13.103', 1, '1000.00', 155),
(5126, '172.28.13.104', 1, '1000.00', 155),
(5127, '172.28.13.105', 1, '1000.00', 155),
(5128, '172.28.13.106', 1, '1000.00', 155),
(5129, '172.28.13.107', 1, '1000.00', 155),
(5130, '172.28.13.108', 1, '1000.00', 155),
(5131, '172.28.13.109', 1, '1000.00', 155),
(5132, '172.28.13.110', 1, '1000.00', 155),
(5133, '172.28.13.111', 1, '1000.00', 155),
(5134, '172.28.13.112', 1, '1000.00', 155),
(5135, '172.28.13.113', 1, '1000.00', 155),
(5136, '172.28.13.114', 1, '1000.00', 155),
(5137, '172.28.13.115', 1, '1000.00', 155),
(5138, '172.28.13.116', 1, '1000.00', 155),
(5139, '172.28.13.117', 1, '1000.00', 155),
(5140, '172.28.13.118', 1, '1000.00', 155),
(5141, '172.28.13.119', 1, '1000.00', 155),
(5142, '172.28.13.120', 1, '1000.00', 155),
(5143, '172.28.13.121', 1, '1000.00', 155),
(5144, '172.28.13.122', 1, '1000.00', 155),
(5145, '172.28.13.123', 1, '1000.00', 155),
(5146, '172.28.13.124', 1, '1000.00', 155),
(5147, '172.28.13.125', 1, '1000.00', 155),
(5148, '172.28.13.126', 1, '1000.00', 155),
(5149, '172.28.13.127', 1, '1000.00', 155),
(5150, '172.28.13.128', 1, '1000.00', 155),
(5151, '172.28.13.129', 1, '1000.00', 155),
(5152, '172.28.13.130', 1, '1000.00', 155),
(5153, '172.28.13.131', 1, '1000.00', 155),
(5154, '172.28.13.132', 1, '1000.00', 155),
(5155, '172.28.13.133', 1, '1000.00', 155),
(5156, '172.28.13.134', 1, '1000.00', 155),
(5157, '172.28.13.135', 1, '1000.00', 155),
(5158, '172.28.13.136', 1, '1000.00', 155),
(5159, '172.28.13.137', 1, '1000.00', 155),
(5160, '172.28.13.138', 1, '1000.00', 155),
(5161, '172.28.13.139', 1, '1000.00', 155),
(5162, '172.28.13.140', 1, '1000.00', 155),
(5163, '172.28.13.141', 1, '1000.00', 155),
(5164, '172.28.13.142', 1, '1000.00', 155),
(5165, '172.28.13.143', 1, '1000.00', 155),
(5166, '172.28.13.144', 1, '1000.00', 155),
(5167, '172.28.13.145', 1, '1000.00', 155),
(5168, '172.28.13.146', 1, '1000.00', 155),
(5169, '172.28.13.147', 1, '1000.00', 155),
(5170, '172.28.13.148', 1, '1000.00', 155),
(5171, '172.28.13.149', 1, '1000.00', 155),
(5172, '172.28.13.150', 1, '1000.00', 155),
(5173, '172.28.13.151', 1, '1000.00', 155),
(5174, '172.28.13.152', 1, '1000.00', 155),
(5175, '172.28.13.153', 1, '1000.00', 155),
(5176, '172.28.13.154', 1, '1000.00', 155),
(5177, '172.28.13.155', 1, '1000.00', 155),
(5178, '172.28.13.156', 1, '1000.00', 155),
(5179, '172.28.13.157', 1, '1000.00', 155),
(5180, '172.28.13.158', 1, '1000.00', 155),
(5181, '172.28.13.159', 1, '1000.00', 155),
(5182, '172.28.13.160', 1, '1000.00', 155),
(5183, '172.28.13.161', 1, '1000.00', 155),
(5184, '172.28.13.162', 1, '1000.00', 155),
(5185, '172.28.13.163', 1, '1000.00', 155),
(5186, '172.28.13.164', 1, '1000.00', 155),
(5187, '172.28.13.165', 1, '1000.00', 155),
(5188, '172.28.13.166', 1, '1000.00', 155),
(5189, '172.28.13.167', 1, '1000.00', 155),
(5190, '172.28.13.168', 1, '1000.00', 155),
(5191, '172.28.13.169', 1, '1000.00', 155),
(5192, '172.28.13.170', 1, '1000.00', 155),
(5193, '172.28.13.171', 1, '1000.00', 155),
(5194, '172.28.13.172', 1, '1000.00', 155),
(5195, '172.28.13.173', 1, '1000.00', 155),
(5196, '172.28.13.174', 1, '1000.00', 155),
(5197, '172.28.13.175', 1, '1000.00', 155),
(5198, '172.28.13.176', 1, '1000.00', 155),
(5199, '172.28.13.177', 1, '1000.00', 155),
(5200, '172.28.13.178', 1, '1000.00', 155),
(5201, '172.28.13.179', 1, '1000.00', 155),
(5202, '172.28.13.180', 1, '1000.00', 155),
(5203, '172.28.13.181', 1, '1000.00', 155),
(5204, '172.28.13.182', 1, '1000.00', 155),
(5205, '172.28.13.183', 1, '1000.00', 155),
(5206, '172.28.13.184', 1, '1000.00', 155),
(5207, '172.28.13.185', 1, '1000.00', 155),
(5208, '172.28.13.186', 1, '1000.00', 155),
(5209, '172.28.13.187', 1, '1000.00', 155),
(5210, '172.28.13.188', 1, '1000.00', 155),
(5211, '172.28.13.189', 1, '1000.00', 155),
(5212, '172.28.13.190', 1, '1000.00', 155),
(5213, '172.28.13.191', 1, '1000.00', 155),
(5214, '172.28.13.192', 1, '1000.00', 155),
(5215, '172.28.13.193', 1, '1000.00', 155),
(5216, '172.28.13.194', 1, '1000.00', 155),
(5217, '172.28.13.195', 1, '1000.00', 155),
(5218, '172.28.13.196', 1, '1000.00', 155),
(5219, '172.28.13.197', 1, '1000.00', 155),
(5220, '172.28.13.198', 1, '1000.00', 155),
(5221, '172.28.13.199', 1, '1000.00', 155),
(5222, '172.28.13.200', 1, '1000.00', 155),
(5223, '172.28.13.201', 1, '1000.00', 155),
(5224, '172.28.13.202', 1, '1000.00', 155),
(5225, '172.28.13.203', 1, '1000.00', 155),
(5226, '172.28.13.204', 1, '1000.00', 155),
(5227, '172.28.13.205', 1, '1000.00', 155),
(5228, '172.28.13.206', 1, '1000.00', 155),
(5229, '172.28.13.207', 1, '1000.00', 155),
(5230, '172.28.13.208', 1, '1000.00', 155),
(5231, '172.28.13.209', 1, '1000.00', 155),
(5232, '172.28.13.210', 1, '1000.00', 155),
(5233, '172.28.13.211', 1, '1000.00', 155),
(5234, '172.28.13.212', 1, '1000.00', 155),
(5235, '172.28.13.213', 1, '1000.00', 155),
(5236, '172.28.13.214', 1, '1000.00', 155),
(5237, '172.28.13.215', 1, '1000.00', 155),
(5238, '172.28.13.216', 1, '1000.00', 155),
(5239, '172.28.13.217', 1, '1000.00', 155),
(5240, '172.28.13.218', 1, '1000.00', 155),
(5241, '172.28.13.219', 1, '1000.00', 155),
(5242, '172.28.13.220', 1, '1000.00', 155),
(5243, '172.28.13.221', 1, '1000.00', 155),
(5244, '172.28.13.222', 1, '1000.00', 155),
(5245, '172.28.13.223', 1, '1000.00', 155),
(5246, '172.28.13.224', 1, '1000.00', 155),
(5247, '172.28.13.225', 1, '1000.00', 155),
(5248, '172.28.13.226', 1, '1000.00', 155),
(5249, '172.28.13.227', 1, '1000.00', 155),
(5250, '172.28.13.228', 1, '1000.00', 155),
(5251, '172.28.13.229', 1, '1000.00', 155),
(5252, '172.28.13.230', 1, '1000.00', 155),
(5253, '172.28.13.231', 1, '1000.00', 155),
(5254, '172.28.13.232', 1, '1000.00', 155),
(5255, '172.28.13.233', 1, '1000.00', 155),
(5256, '172.28.13.234', 1, '1000.00', 155),
(5257, '172.28.13.235', 1, '1000.00', 155),
(5258, '172.28.13.236', 1, '1000.00', 155),
(5259, '172.28.13.237', 1, '1000.00', 155),
(5260, '172.28.13.238', 1, '1000.00', 155),
(5261, '172.28.13.239', 1, '1000.00', 155),
(5262, '172.28.13.240', 1, '1000.00', 155),
(5263, '172.28.13.241', 1, '1000.00', 155),
(5264, '172.28.13.242', 1, '1000.00', 155),
(5265, '172.28.13.243', 1, '1000.00', 155),
(5266, '172.28.13.244', 1, '1000.00', 155),
(5267, '172.28.13.245', 1, '1000.00', 155),
(5268, '172.28.13.246', 1, '1000.00', 155),
(5269, '172.28.13.247', 1, '1000.00', 155),
(5270, '172.28.13.248', 1, '1000.00', 155),
(5271, '172.28.13.249', 1, '1000.00', 155),
(5272, '172.28.13.250', 1, '1000.00', 155),
(5273, '172.28.13.251', 1, '1000.00', 155),
(5274, '172.28.13.252', 1, '1000.00', 155),
(5275, '172.28.13.253', 1, '1000.00', 155),
(5276, '172.28.13.254', 1, '1000.00', 155),
(5277, '172.28.16.2', 1, '1000.00', 157),
(5278, '172.28.16.3', 1, '1000.00', 157),
(5279, '172.28.16.4', 1, '1000.00', 157),
(5280, '172.28.16.5', 1, '1000.00', 157),
(5281, '172.28.16.6', 1, '1000.00', 157),
(5282, '172.28.16.7', 1, '1000.00', 157),
(5283, '172.28.16.8', 1, '1000.00', 157),
(5284, '172.28.16.9', 1, '1000.00', 157),
(5285, '172.28.16.10', 1, '1000.00', 157),
(5286, '172.28.16.11', 1, '1000.00', 157),
(5287, '172.28.16.12', 1, '1000.00', 157),
(5288, '172.28.16.13', 1, '1000.00', 157),
(5289, '172.28.16.14', 1, '1000.00', 157),
(5290, '172.28.16.15', 1, '1000.00', 157),
(5291, '172.28.16.16', 1, '1000.00', 157),
(5292, '172.28.16.17', 1, '1000.00', 157),
(5293, '172.28.16.18', 1, '1000.00', 157),
(5294, '172.28.16.19', 1, '1000.00', 157),
(5295, '172.28.16.20', 1, '1000.00', 157),
(5296, '172.28.16.21', 1, '1000.00', 157),
(5297, '172.28.16.22', 1, '1000.00', 157),
(5298, '172.28.16.23', 1, '1000.00', 157),
(5299, '172.28.16.24', 1, '1000.00', 157),
(5300, '172.28.16.25', 1, '1000.00', 157),
(5301, '172.28.16.26', 1, '1000.00', 157),
(5302, '172.28.16.27', 1, '1000.00', 157),
(5303, '172.28.16.28', 1, '1000.00', 157),
(5304, '172.28.16.29', 1, '1000.00', 157),
(5305, '172.28.16.30', 1, '1000.00', 157),
(5306, '172.28.16.31', 1, '1000.00', 157),
(5307, '172.28.16.32', 1, '1000.00', 157),
(5308, '172.28.16.33', 1, '1000.00', 157),
(5309, '172.28.16.34', 1, '1000.00', 157),
(5310, '172.28.16.35', 1, '1000.00', 157),
(5311, '172.28.16.36', 1, '1000.00', 157),
(5312, '172.28.16.37', 1, '1000.00', 157),
(5313, '172.28.16.38', 1, '1000.00', 157),
(5314, '172.28.16.39', 1, '1000.00', 157),
(5315, '172.28.16.40', 1, '1000.00', 157),
(5316, '172.28.16.41', 1, '1000.00', 157),
(5317, '172.28.16.42', 1, '1000.00', 157),
(5318, '172.28.16.43', 1, '1000.00', 157),
(5319, '172.28.16.44', 1, '1000.00', 157),
(5320, '172.28.16.45', 1, '1000.00', 157),
(5321, '172.28.16.46', 1, '1000.00', 157),
(5322, '172.28.16.47', 1, '1000.00', 157),
(5323, '172.28.16.48', 1, '1000.00', 157),
(5324, '172.28.16.49', 1, '1000.00', 157),
(5325, '172.28.16.50', 1, '1000.00', 157),
(5326, '172.28.16.51', 1, '1000.00', 157),
(5327, '172.28.16.52', 1, '1000.00', 157),
(5328, '172.28.16.53', 1, '1000.00', 157),
(5329, '172.28.16.54', 1, '1000.00', 157),
(5330, '172.28.16.55', 1, '1000.00', 157),
(5331, '172.28.16.56', 1, '1000.00', 157),
(5332, '172.28.16.57', 1, '1000.00', 157),
(5333, '172.28.16.58', 1, '1000.00', 157),
(5334, '172.28.16.59', 1, '1000.00', 157),
(5335, '172.28.16.60', 1, '1000.00', 157),
(5336, '172.28.16.61', 1, '1000.00', 157),
(5337, '172.28.16.62', 1, '1000.00', 157),
(5338, '172.28.16.63', 1, '1000.00', 157),
(5339, '172.28.16.64', 1, '1000.00', 157),
(5340, '172.28.16.65', 1, '1000.00', 157),
(5341, '172.28.16.66', 1, '1000.00', 157),
(5342, '172.28.16.67', 1, '1000.00', 157),
(5343, '172.28.16.68', 1, '1000.00', 157),
(5344, '172.28.16.69', 1, '1000.00', 157),
(5345, '172.28.16.70', 1, '1000.00', 157),
(5346, '172.28.16.71', 1, '1000.00', 157),
(5347, '172.28.16.72', 1, '1000.00', 157),
(5348, '172.28.16.73', 1, '1000.00', 157),
(5349, '172.28.16.74', 1, '1000.00', 157),
(5350, '172.28.16.75', 1, '1000.00', 157),
(5351, '172.28.16.76', 1, '1000.00', 157),
(5352, '172.28.16.77', 1, '1000.00', 157),
(5353, '172.28.16.78', 1, '1000.00', 157),
(5354, '172.28.16.79', 1, '1000.00', 157),
(5355, '172.28.16.80', 1, '1000.00', 157),
(5356, '172.28.16.81', 1, '1000.00', 157),
(5357, '172.28.16.82', 1, '1000.00', 157),
(5358, '172.28.16.83', 1, '1000.00', 157),
(5359, '172.28.16.84', 1, '1000.00', 157),
(5360, '172.28.16.85', 1, '1000.00', 157),
(5361, '172.28.16.86', 1, '1000.00', 157),
(5362, '172.28.16.87', 1, '1000.00', 157),
(5363, '172.28.16.88', 1, '1000.00', 157),
(5364, '172.28.16.89', 1, '1000.00', 157),
(5365, '172.28.16.90', 1, '1000.00', 157),
(5366, '172.28.16.91', 1, '1000.00', 157),
(5367, '172.28.16.92', 1, '1000.00', 157),
(5368, '172.28.16.93', 1, '1000.00', 157),
(5369, '172.28.16.94', 1, '1000.00', 157),
(5370, '172.28.16.95', 1, '1000.00', 157),
(5371, '172.28.16.96', 1, '1000.00', 157),
(5372, '172.28.16.97', 1, '1000.00', 157),
(5373, '172.28.16.98', 1, '1000.00', 157),
(5374, '172.28.16.99', 1, '1000.00', 157),
(5375, '172.28.16.100', 1, '1000.00', 157),
(5376, '172.28.16.101', 1, '1000.00', 157),
(5377, '172.28.16.102', 1, '1000.00', 157),
(5378, '172.28.16.103', 1, '1000.00', 157),
(5379, '172.28.16.104', 1, '1000.00', 157),
(5380, '172.28.16.105', 1, '1000.00', 157),
(5381, '172.28.16.106', 1, '1000.00', 157),
(5382, '172.28.16.107', 1, '1000.00', 157),
(5383, '172.28.16.108', 1, '1000.00', 157),
(5384, '172.28.16.109', 1, '1000.00', 157),
(5385, '172.28.16.110', 1, '1000.00', 157),
(5386, '172.28.16.111', 1, '1000.00', 157),
(5387, '172.28.16.112', 1, '1000.00', 157),
(5388, '172.28.16.113', 1, '1000.00', 157),
(5389, '172.28.16.114', 1, '1000.00', 157),
(5390, '172.28.16.115', 1, '1000.00', 157),
(5391, '172.28.16.116', 1, '1000.00', 157),
(5392, '172.28.16.117', 1, '1000.00', 157),
(5393, '172.28.16.118', 1, '1000.00', 157),
(5394, '172.28.16.119', 1, '1000.00', 157),
(5395, '172.28.16.120', 1, '1000.00', 157),
(5396, '172.28.16.121', 1, '1000.00', 157),
(5397, '172.28.16.122', 1, '1000.00', 157),
(5398, '172.28.16.123', 1, '1000.00', 157),
(5399, '172.28.16.124', 1, '1000.00', 157),
(5400, '172.28.16.125', 1, '1000.00', 157),
(5401, '172.28.16.126', 1, '1000.00', 157),
(5402, '172.28.16.127', 1, '1000.00', 157),
(5403, '172.28.16.128', 1, '1000.00', 157),
(5404, '172.28.16.129', 1, '1000.00', 157),
(5405, '172.28.16.130', 1, '1000.00', 157),
(5406, '172.28.16.131', 1, '1000.00', 157),
(5407, '172.28.16.132', 1, '1000.00', 157),
(5408, '172.28.16.133', 1, '1000.00', 157),
(5409, '172.28.16.134', 1, '1000.00', 157),
(5410, '172.28.16.135', 1, '1000.00', 157),
(5411, '172.28.16.136', 1, '1000.00', 157),
(5412, '172.28.16.137', 1, '1000.00', 157),
(5413, '172.28.16.138', 1, '1000.00', 157),
(5414, '172.28.16.139', 1, '1000.00', 157),
(5415, '172.28.16.140', 1, '1000.00', 157),
(5416, '172.28.16.141', 1, '1000.00', 157),
(5417, '172.28.16.142', 1, '1000.00', 157),
(5418, '172.28.16.143', 1, '1000.00', 157),
(5419, '172.28.16.144', 1, '1000.00', 157),
(5420, '172.28.16.145', 1, '1000.00', 157),
(5421, '172.28.16.146', 1, '1000.00', 157),
(5422, '172.28.16.147', 1, '1000.00', 157),
(5423, '172.28.16.148', 1, '1000.00', 157),
(5424, '172.28.16.149', 1, '1000.00', 157),
(5425, '172.28.16.150', 1, '1000.00', 157),
(5426, '172.28.16.151', 1, '1000.00', 157),
(5427, '172.28.16.152', 1, '1000.00', 157),
(5428, '172.28.16.153', 1, '1000.00', 157),
(5429, '172.28.16.154', 1, '1000.00', 157),
(5430, '172.28.16.155', 1, '1000.00', 157),
(5431, '172.28.16.156', 1, '1000.00', 157),
(5432, '172.28.16.157', 1, '1000.00', 157),
(5433, '172.28.16.158', 1, '1000.00', 157),
(5434, '172.28.16.159', 1, '1000.00', 157),
(5435, '172.28.16.160', 1, '1000.00', 157),
(5436, '172.28.16.161', 1, '1000.00', 157),
(5437, '172.28.16.162', 1, '1000.00', 157),
(5438, '172.28.16.163', 1, '1000.00', 157),
(5439, '172.28.16.164', 1, '1000.00', 157),
(5440, '172.28.16.165', 1, '1000.00', 157),
(5441, '172.28.16.166', 1, '1000.00', 157),
(5442, '172.28.16.167', 1, '1000.00', 157),
(5443, '172.28.16.168', 1, '1000.00', 157),
(5444, '172.28.16.169', 1, '1000.00', 157),
(5445, '172.28.16.170', 1, '1000.00', 157),
(5446, '172.28.16.171', 1, '1000.00', 157),
(5447, '172.28.16.172', 1, '1000.00', 157),
(5448, '172.28.16.173', 1, '1000.00', 157),
(5449, '172.28.16.174', 1, '1000.00', 157),
(5450, '172.28.16.175', 1, '1000.00', 157),
(5451, '172.28.16.176', 1, '1000.00', 157),
(5452, '172.28.16.177', 1, '1000.00', 157),
(5453, '172.28.16.178', 1, '1000.00', 157),
(5454, '172.28.16.179', 1, '1000.00', 157),
(5455, '172.28.16.180', 1, '1000.00', 157),
(5456, '172.28.16.181', 1, '1000.00', 157),
(5457, '172.28.16.182', 1, '1000.00', 157),
(5458, '172.28.16.183', 1, '1000.00', 157),
(5459, '172.28.16.184', 1, '1000.00', 157),
(5460, '172.28.16.185', 1, '1000.00', 157),
(5461, '172.28.16.186', 1, '1000.00', 157),
(5462, '172.28.16.187', 1, '1000.00', 157),
(5463, '172.28.16.188', 1, '1000.00', 157),
(5464, '172.28.16.189', 1, '1000.00', 157),
(5465, '172.28.16.190', 1, '1000.00', 157),
(5466, '172.28.16.191', 1, '1000.00', 157),
(5467, '172.28.16.192', 1, '1000.00', 157),
(5468, '172.28.16.193', 1, '1000.00', 157),
(5469, '172.28.16.194', 1, '1000.00', 157),
(5470, '172.28.16.195', 1, '1000.00', 157),
(5471, '172.28.16.196', 1, '1000.00', 157),
(5472, '172.28.16.197', 1, '1000.00', 157),
(5473, '172.28.16.198', 1, '1000.00', 157),
(5474, '172.28.16.199', 1, '1000.00', 157),
(5475, '172.28.16.200', 1, '1000.00', 157),
(5476, '172.28.16.201', 1, '1000.00', 157),
(5477, '172.28.16.202', 1, '1000.00', 157),
(5478, '172.28.16.203', 1, '1000.00', 157),
(5479, '172.28.16.204', 1, '1000.00', 157),
(5480, '172.28.16.205', 1, '1000.00', 157),
(5481, '172.28.16.206', 1, '1000.00', 157),
(5482, '172.28.16.207', 1, '1000.00', 157),
(5483, '172.28.16.208', 1, '1000.00', 157),
(5484, '172.28.16.209', 1, '1000.00', 157),
(5485, '172.28.16.210', 1, '1000.00', 157),
(5486, '172.28.16.211', 1, '1000.00', 157),
(5487, '172.28.16.212', 1, '1000.00', 157),
(5488, '172.28.16.213', 1, '1000.00', 157),
(5489, '172.28.16.214', 1, '1000.00', 157),
(5490, '172.28.16.215', 1, '1000.00', 157),
(5491, '172.28.16.216', 1, '1000.00', 157),
(5492, '172.28.16.217', 1, '1000.00', 157),
(5493, '172.28.16.218', 1, '1000.00', 157),
(5494, '172.28.16.219', 1, '1000.00', 157),
(5495, '172.28.16.220', 1, '1000.00', 157),
(5496, '172.28.16.221', 1, '1000.00', 157),
(5497, '172.28.16.222', 1, '1000.00', 157),
(5498, '172.28.16.223', 1, '1000.00', 157),
(5499, '172.28.16.224', 1, '1000.00', 157),
(5500, '172.28.16.225', 1, '1000.00', 157),
(5501, '172.28.16.226', 1, '1000.00', 157),
(5502, '172.28.16.227', 1, '1000.00', 157),
(5503, '172.28.16.228', 1, '1000.00', 157),
(5504, '172.28.16.229', 1, '1000.00', 157),
(5505, '172.28.16.230', 1, '1000.00', 157),
(5506, '172.28.16.231', 1, '1000.00', 157),
(5507, '172.28.16.232', 1, '1000.00', 157),
(5508, '172.28.16.233', 1, '1000.00', 157),
(5509, '172.28.16.234', 1, '1000.00', 157),
(5510, '172.28.16.235', 1, '1000.00', 157),
(5511, '172.28.16.236', 1, '1000.00', 157),
(5512, '172.28.16.237', 1, '1000.00', 157),
(5513, '172.28.16.238', 1, '1000.00', 157),
(5514, '172.28.16.239', 1, '1000.00', 157),
(5515, '172.28.16.240', 1, '1000.00', 157),
(5516, '172.28.16.241', 1, '1000.00', 157),
(5517, '172.28.16.242', 1, '1000.00', 157),
(5518, '172.28.16.243', 1, '1000.00', 157),
(5519, '172.28.16.244', 1, '1000.00', 157),
(5520, '172.28.16.245', 1, '1000.00', 157),
(5521, '172.28.16.246', 1, '1000.00', 157),
(5522, '172.28.16.247', 1, '1000.00', 157),
(5523, '172.28.16.248', 1, '1000.00', 157),
(5524, '172.28.16.249', 1, '1000.00', 157),
(5525, '172.28.16.250', 1, '1000.00', 157),
(5526, '172.28.16.251', 1, '1000.00', 157),
(5527, '172.28.16.252', 1, '1000.00', 157),
(5528, '172.28.16.253', 1, '1000.00', 157),
(5529, '172.28.16.254', 1, '1000.00', 157),
(5530, '172.28.36.2', 1, '1000.00', 158),
(5531, '172.28.36.3', 1, '1000.00', 158),
(5532, '172.28.36.4', 1, '1000.00', 158),
(5533, '172.28.36.5', 1, '1000.00', 158),
(5534, '172.28.36.6', 1, '1000.00', 158),
(5535, '172.28.36.7', 1, '1000.00', 158),
(5536, '172.28.36.8', 1, '1000.00', 158),
(5537, '172.28.36.9', 1, '1000.00', 158),
(5538, '172.28.36.10', 1, '1000.00', 158),
(5539, '172.28.36.11', 1, '1000.00', 158),
(5540, '172.28.36.12', 1, '1000.00', 158),
(5541, '172.28.36.13', 1, '1000.00', 158),
(5542, '172.28.36.14', 1, '1000.00', 158),
(5543, '172.28.36.15', 1, '1000.00', 158),
(5544, '172.28.36.16', 1, '1000.00', 158),
(5545, '172.28.36.17', 1, '1000.00', 158),
(5546, '172.28.36.18', 1, '1000.00', 158),
(5547, '172.28.36.19', 1, '1000.00', 158),
(5548, '172.28.36.20', 1, '1000.00', 158),
(5549, '172.28.36.21', 1, '1000.00', 158),
(5550, '172.28.36.22', 1, '1000.00', 158),
(5551, '172.28.36.23', 1, '1000.00', 158),
(5552, '172.28.36.24', 1, '1000.00', 158),
(5553, '172.28.36.25', 1, '1000.00', 158),
(5554, '172.28.36.26', 1, '1000.00', 158),
(5555, '172.28.36.27', 1, '1000.00', 158),
(5556, '172.28.36.28', 1, '1000.00', 158),
(5557, '172.28.36.29', 1, '1000.00', 158),
(5558, '172.28.36.30', 1, '1000.00', 158),
(5559, '172.28.36.31', 1, '1000.00', 158),
(5560, '172.28.36.32', 1, '1000.00', 158),
(5561, '172.28.36.33', 1, '1000.00', 158),
(5562, '172.28.36.34', 1, '1000.00', 158),
(5563, '172.28.36.35', 1, '1000.00', 158),
(5564, '172.28.36.36', 1, '1000.00', 158),
(5565, '172.28.36.37', 1, '1000.00', 158),
(5566, '172.28.36.38', 1, '1000.00', 158),
(5567, '172.28.36.39', 1, '1000.00', 158),
(5568, '172.28.36.40', 1, '1000.00', 158),
(5569, '172.28.36.41', 1, '1000.00', 158),
(5570, '172.28.36.42', 1, '1000.00', 158),
(5571, '172.28.36.43', 1, '1000.00', 158),
(5572, '172.28.36.44', 1, '1000.00', 158),
(5573, '172.28.36.45', 1, '1000.00', 158),
(5574, '172.28.36.46', 1, '1000.00', 158),
(5575, '172.28.36.47', 1, '1000.00', 158),
(5576, '172.28.36.48', 1, '1000.00', 158),
(5577, '172.28.36.49', 1, '1000.00', 158),
(5578, '172.28.36.50', 1, '1000.00', 158),
(5579, '172.28.36.51', 1, '1000.00', 158),
(5580, '172.28.36.52', 1, '1000.00', 158),
(5581, '172.28.36.53', 1, '1000.00', 158),
(5582, '172.28.36.54', 1, '1000.00', 158),
(5583, '172.28.36.55', 1, '1000.00', 158),
(5584, '172.28.36.56', 1, '1000.00', 158),
(5585, '172.28.36.57', 1, '1000.00', 158),
(5586, '172.28.36.58', 1, '1000.00', 158),
(5587, '172.28.36.59', 1, '1000.00', 158),
(5588, '172.28.36.60', 1, '1000.00', 158),
(5589, '172.28.36.61', 1, '1000.00', 158),
(5590, '172.28.36.62', 1, '1000.00', 158),
(5591, '172.28.36.63', 1, '1000.00', 158),
(5592, '172.28.36.64', 1, '1000.00', 158),
(5593, '172.28.36.65', 1, '1000.00', 158),
(5594, '172.28.36.66', 1, '1000.00', 158),
(5595, '172.28.36.67', 1, '1000.00', 158),
(5596, '172.28.36.68', 1, '1000.00', 158),
(5597, '172.28.36.69', 1, '1000.00', 158),
(5598, '172.28.36.70', 1, '1000.00', 158),
(5599, '172.28.36.71', 1, '1000.00', 158),
(5600, '172.28.36.72', 1, '1000.00', 158),
(5601, '172.28.36.73', 1, '1000.00', 158),
(5602, '172.28.36.74', 1, '1000.00', 158),
(5603, '172.28.36.75', 1, '1000.00', 158),
(5604, '172.28.36.76', 1, '1000.00', 158),
(5605, '172.28.36.77', 1, '1000.00', 158),
(5606, '172.28.36.78', 1, '1000.00', 158),
(5607, '172.28.36.79', 1, '1000.00', 158),
(5608, '172.28.36.80', 1, '1000.00', 158),
(5609, '172.28.36.81', 1, '1000.00', 158),
(5610, '172.28.36.82', 1, '1000.00', 158),
(5611, '172.28.36.83', 1, '1000.00', 158),
(5612, '172.28.36.84', 1, '1000.00', 158),
(5613, '172.28.36.85', 1, '1000.00', 158),
(5614, '172.28.36.86', 1, '1000.00', 158),
(5615, '172.28.36.87', 1, '1000.00', 158),
(5616, '172.28.36.88', 1, '1000.00', 158),
(5617, '172.28.36.89', 1, '1000.00', 158),
(5618, '172.28.36.90', 1, '1000.00', 158),
(5619, '172.28.36.91', 1, '1000.00', 158),
(5620, '172.28.36.92', 1, '1000.00', 158),
(5621, '172.28.36.93', 1, '1000.00', 158),
(5622, '172.28.36.94', 1, '1000.00', 158),
(5623, '172.28.36.95', 1, '1000.00', 158),
(5624, '172.28.36.96', 1, '1000.00', 158),
(5625, '172.28.36.97', 1, '1000.00', 158),
(5626, '172.28.36.98', 1, '1000.00', 158),
(5627, '172.28.36.99', 1, '1000.00', 158),
(5628, '172.28.36.100', 1, '1000.00', 158),
(5629, '172.28.36.101', 1, '1000.00', 158),
(5630, '172.28.36.102', 1, '1000.00', 158),
(5631, '172.28.36.103', 1, '1000.00', 158),
(5632, '172.28.36.104', 1, '1000.00', 158),
(5633, '172.28.36.105', 1, '1000.00', 158),
(5634, '172.28.36.106', 1, '1000.00', 158),
(5635, '172.28.36.107', 1, '1000.00', 158),
(5636, '172.28.36.108', 1, '1000.00', 158),
(5637, '172.28.36.109', 1, '1000.00', 158),
(5638, '172.28.36.110', 1, '1000.00', 158),
(5639, '172.28.36.111', 1, '1000.00', 158),
(5640, '172.28.36.112', 1, '1000.00', 158),
(5641, '172.28.36.113', 1, '1000.00', 158),
(5642, '172.28.36.114', 1, '1000.00', 158),
(5643, '172.28.36.115', 1, '1000.00', 158),
(5644, '172.28.36.116', 1, '1000.00', 158),
(5645, '172.28.36.117', 1, '1000.00', 158),
(5646, '172.28.36.118', 1, '1000.00', 158),
(5647, '172.28.36.119', 1, '1000.00', 158),
(5648, '172.28.36.120', 1, '1000.00', 158),
(5649, '172.28.36.121', 1, '1000.00', 158),
(5650, '172.28.36.122', 1, '1000.00', 158),
(5651, '172.28.36.123', 1, '1000.00', 158),
(5652, '172.28.36.124', 1, '1000.00', 158),
(5653, '172.28.36.125', 1, '1000.00', 158),
(5654, '172.28.36.126', 1, '1000.00', 158),
(5655, '172.28.36.127', 1, '1000.00', 158),
(5656, '172.28.36.128', 1, '1000.00', 158),
(5657, '172.28.36.129', 1, '1000.00', 158),
(5658, '172.28.36.130', 1, '1000.00', 158),
(5659, '172.28.36.131', 1, '1000.00', 158),
(5660, '172.28.36.132', 1, '1000.00', 158),
(5661, '172.28.36.133', 1, '1000.00', 158),
(5662, '172.28.36.134', 1, '1000.00', 158),
(5663, '172.28.36.135', 1, '1000.00', 158),
(5664, '172.28.36.136', 1, '1000.00', 158),
(5665, '172.28.36.137', 1, '1000.00', 158),
(5666, '172.28.36.138', 1, '1000.00', 158),
(5667, '172.28.36.139', 1, '1000.00', 158),
(5668, '172.28.36.140', 1, '1000.00', 158),
(5669, '172.28.36.141', 1, '1000.00', 158),
(5670, '172.28.36.142', 1, '1000.00', 158),
(5671, '172.28.36.143', 1, '1000.00', 158),
(5672, '172.28.36.144', 1, '1000.00', 158),
(5673, '172.28.36.145', 1, '1000.00', 158),
(5674, '172.28.36.146', 1, '1000.00', 158),
(5675, '172.28.36.147', 1, '1000.00', 158),
(5676, '172.28.36.148', 1, '1000.00', 158),
(5677, '172.28.36.149', 1, '1000.00', 158),
(5678, '172.28.36.150', 1, '1000.00', 158),
(5679, '172.28.36.151', 1, '1000.00', 158),
(5680, '172.28.36.152', 1, '1000.00', 158),
(5681, '172.28.36.153', 1, '1000.00', 158),
(5682, '172.28.36.154', 1, '1000.00', 158),
(5683, '172.28.36.155', 1, '1000.00', 158),
(5684, '172.28.36.156', 1, '1000.00', 158),
(5685, '172.28.36.157', 1, '1000.00', 158),
(5686, '172.28.36.158', 1, '1000.00', 158),
(5687, '172.28.36.159', 1, '1000.00', 158),
(5688, '172.28.36.160', 1, '1000.00', 158),
(5689, '172.28.36.161', 1, '1000.00', 158),
(5690, '172.28.36.162', 1, '1000.00', 158),
(5691, '172.28.36.163', 1, '1000.00', 158),
(5692, '172.28.36.164', 1, '1000.00', 158),
(5693, '172.28.36.165', 1, '1000.00', 158),
(5694, '172.28.36.166', 1, '1000.00', 158),
(5695, '172.28.36.167', 1, '1000.00', 158),
(5696, '172.28.36.168', 1, '1000.00', 158),
(5697, '172.28.36.169', 1, '1000.00', 158),
(5698, '172.28.36.170', 1, '1000.00', 158),
(5699, '172.28.36.171', 1, '1000.00', 158),
(5700, '172.28.36.172', 1, '1000.00', 158),
(5701, '172.28.36.173', 1, '1000.00', 158),
(5702, '172.28.36.174', 1, '1000.00', 158),
(5703, '172.28.36.175', 1, '1000.00', 158),
(5704, '172.28.36.176', 1, '1000.00', 158),
(5705, '172.28.36.177', 1, '1000.00', 158),
(5706, '172.28.36.178', 1, '1000.00', 158),
(5707, '172.28.36.179', 1, '1000.00', 158),
(5708, '172.28.36.180', 1, '1000.00', 158),
(5709, '172.28.36.181', 1, '1000.00', 158),
(5710, '172.28.36.182', 1, '1000.00', 158),
(5711, '172.28.36.183', 1, '1000.00', 158),
(5712, '172.28.36.184', 1, '1000.00', 158),
(5713, '172.28.36.185', 1, '1000.00', 158),
(5714, '172.28.36.186', 1, '1000.00', 158),
(5715, '172.28.36.187', 1, '1000.00', 158),
(5716, '172.28.36.188', 1, '1000.00', 158),
(5717, '172.28.36.189', 1, '1000.00', 158),
(5718, '172.28.36.190', 1, '1000.00', 158),
(5719, '172.28.36.191', 1, '1000.00', 158),
(5720, '172.28.36.192', 1, '1000.00', 158),
(5721, '172.28.36.193', 1, '1000.00', 158),
(5722, '172.28.36.194', 1, '1000.00', 158),
(5723, '172.28.36.195', 1, '1000.00', 158),
(5724, '172.28.36.196', 1, '1000.00', 158),
(5725, '172.28.36.197', 1, '1000.00', 158),
(5726, '172.28.36.198', 1, '1000.00', 158),
(5727, '172.28.36.199', 1, '1000.00', 158),
(5728, '172.28.36.200', 1, '1000.00', 158),
(5729, '172.28.36.201', 1, '1000.00', 158),
(5730, '172.28.36.202', 1, '1000.00', 158),
(5731, '172.28.36.203', 1, '1000.00', 158);
INSERT INTO `ip_addresses` (`id`, `address`, `status`, `price`, `base_id`) VALUES
(5732, '172.28.36.204', 1, '1000.00', 158),
(5733, '172.28.36.205', 1, '1000.00', 158),
(5734, '172.28.36.206', 1, '1000.00', 158),
(5735, '172.28.36.207', 1, '1000.00', 158),
(5736, '172.28.36.208', 1, '1000.00', 158),
(5737, '172.28.36.209', 1, '1000.00', 158),
(5738, '172.28.36.210', 1, '1000.00', 158),
(5739, '172.28.36.211', 1, '1000.00', 158),
(5740, '172.28.36.212', 1, '1000.00', 158),
(5741, '172.28.36.213', 1, '1000.00', 158),
(5742, '172.28.36.214', 1, '1000.00', 158),
(5743, '172.28.36.215', 1, '1000.00', 158),
(5744, '172.28.36.216', 1, '1000.00', 158),
(5745, '172.28.36.217', 1, '1000.00', 158),
(5746, '172.28.36.218', 1, '1000.00', 158),
(5747, '172.28.36.219', 1, '1000.00', 158),
(5748, '172.28.36.220', 1, '1000.00', 158),
(5749, '172.28.36.221', 1, '1000.00', 158),
(5750, '172.28.36.222', 1, '1000.00', 158),
(5751, '172.28.36.223', 1, '1000.00', 158),
(5752, '172.28.36.224', 1, '1000.00', 158),
(5753, '172.28.36.225', 1, '1000.00', 158),
(5754, '172.28.36.226', 1, '1000.00', 158),
(5755, '172.28.36.227', 1, '1000.00', 158),
(5756, '172.28.36.228', 1, '1000.00', 158),
(5757, '172.28.36.229', 1, '1000.00', 158),
(5758, '172.28.36.230', 1, '1000.00', 158),
(5759, '172.28.36.231', 1, '1000.00', 158),
(5760, '172.28.36.232', 1, '1000.00', 158),
(5761, '172.28.36.233', 1, '1000.00', 158),
(5762, '172.28.36.234', 1, '1000.00', 158),
(5763, '172.28.36.235', 1, '1000.00', 158),
(5764, '172.28.36.236', 1, '1000.00', 158),
(5765, '172.28.36.237', 1, '1000.00', 158),
(5766, '172.28.36.238', 1, '1000.00', 158),
(5767, '172.28.36.239', 1, '1000.00', 158),
(5768, '172.28.36.240', 1, '1000.00', 158),
(5769, '172.28.36.241', 1, '1000.00', 158),
(5770, '172.28.36.242', 1, '1000.00', 158),
(5771, '172.28.36.243', 1, '1000.00', 158),
(5772, '172.28.36.244', 1, '1000.00', 158),
(5773, '172.28.36.245', 1, '1000.00', 158),
(5774, '172.28.36.246', 1, '1000.00', 158),
(5775, '172.28.36.247', 1, '1000.00', 158),
(5776, '172.28.36.248', 1, '1000.00', 158),
(5777, '172.28.36.249', 1, '1000.00', 158),
(5778, '172.28.36.250', 1, '1000.00', 158),
(5779, '172.28.36.251', 1, '1000.00', 158),
(5780, '172.28.36.252', 1, '1000.00', 158),
(5781, '172.28.36.253', 1, '1000.00', 158),
(5782, '172.28.36.254', 1, '1000.00', 158),
(5783, '172.28.14.2', 1, '1000.00', 158),
(5784, '172.28.14.3', 1, '1000.00', 158),
(5785, '172.28.14.4', 1, '1000.00', 158),
(5786, '172.28.14.5', 1, '1000.00', 158),
(5787, '172.28.14.6', 1, '1000.00', 158),
(5788, '172.28.14.7', 1, '1000.00', 158),
(5789, '172.28.14.8', 1, '1000.00', 158),
(5790, '172.28.14.9', 1, '1000.00', 158),
(5791, '172.28.14.10', 1, '1000.00', 158),
(5792, '172.28.14.11', 1, '1000.00', 158),
(5793, '172.28.14.12', 1, '1000.00', 158),
(5794, '172.28.14.13', 1, '1000.00', 158),
(5795, '172.28.14.14', 1, '1000.00', 158),
(5796, '172.28.14.15', 1, '1000.00', 158),
(5797, '172.28.14.16', 1, '1000.00', 158),
(5798, '172.28.14.17', 1, '1000.00', 158),
(5799, '172.28.14.18', 1, '1000.00', 158),
(5800, '172.28.14.19', 1, '1000.00', 158),
(5801, '172.28.14.20', 1, '1000.00', 158),
(5802, '172.28.14.21', 1, '1000.00', 158),
(5803, '172.28.14.22', 1, '1000.00', 158),
(5804, '172.28.14.23', 1, '1000.00', 158),
(5805, '172.28.14.24', 1, '1000.00', 158),
(5806, '172.28.14.25', 1, '1000.00', 158),
(5807, '172.28.14.26', 1, '1000.00', 158),
(5808, '172.28.14.27', 1, '1000.00', 158),
(5809, '172.28.14.28', 1, '1000.00', 158),
(5810, '172.28.14.29', 1, '1000.00', 158),
(5811, '172.28.14.30', 1, '1000.00', 158),
(5812, '172.28.14.31', 1, '1000.00', 158),
(5813, '172.28.14.32', 1, '1000.00', 158),
(5814, '172.28.14.33', 1, '1000.00', 158),
(5815, '172.28.14.34', 1, '1000.00', 158),
(5816, '172.28.14.35', 1, '1000.00', 158),
(5817, '172.28.14.36', 1, '1000.00', 158),
(5818, '172.28.14.37', 1, '1000.00', 158),
(5819, '172.28.14.38', 1, '1000.00', 158),
(5820, '172.28.14.39', 1, '1000.00', 158),
(5821, '172.28.14.40', 1, '1000.00', 158),
(5822, '172.28.14.41', 1, '1000.00', 158),
(5823, '172.28.14.42', 1, '1000.00', 158),
(5824, '172.28.14.43', 1, '1000.00', 158),
(5825, '172.28.14.44', 1, '1000.00', 158),
(5826, '172.28.14.45', 1, '1000.00', 158),
(5827, '172.28.14.46', 1, '1000.00', 158),
(5828, '172.28.14.47', 1, '1000.00', 158),
(5829, '172.28.14.48', 1, '1000.00', 158),
(5830, '172.28.14.49', 1, '1000.00', 158),
(5831, '172.28.14.50', 1, '1000.00', 158),
(5832, '172.28.14.51', 1, '1000.00', 158),
(5833, '172.28.14.52', 1, '1000.00', 158),
(5834, '172.28.14.53', 1, '1000.00', 158),
(5835, '172.28.14.54', 1, '1000.00', 158),
(5836, '172.28.14.55', 1, '1000.00', 158),
(5837, '172.28.14.56', 1, '1000.00', 158),
(5838, '172.28.14.57', 1, '1000.00', 158),
(5839, '172.28.14.58', 1, '1000.00', 158),
(5840, '172.28.14.59', 1, '1000.00', 158),
(5841, '172.28.14.60', 1, '1000.00', 158),
(5842, '172.28.14.61', 1, '1000.00', 158),
(5843, '172.28.14.62', 1, '1000.00', 158),
(5844, '172.28.14.63', 1, '1000.00', 158),
(5845, '172.28.14.64', 1, '1000.00', 158),
(5846, '172.28.14.65', 1, '1000.00', 158),
(5847, '172.28.14.66', 1, '1000.00', 158),
(5848, '172.28.14.67', 1, '1000.00', 158),
(5849, '172.28.14.68', 1, '1000.00', 158),
(5850, '172.28.14.69', 1, '1000.00', 158),
(5851, '172.28.14.70', 1, '1000.00', 158),
(5852, '172.28.14.71', 1, '1000.00', 158),
(5853, '172.28.14.72', 1, '1000.00', 158),
(5854, '172.28.14.73', 1, '1000.00', 158),
(5855, '172.28.14.74', 1, '1000.00', 158),
(5856, '172.28.14.75', 1, '1000.00', 158),
(5857, '172.28.14.76', 1, '1000.00', 158),
(5858, '172.28.14.77', 1, '1000.00', 158),
(5859, '172.28.14.78', 1, '1000.00', 158),
(5860, '172.28.14.79', 1, '1000.00', 158),
(5861, '172.28.14.80', 1, '1000.00', 158),
(5862, '172.28.14.81', 1, '1000.00', 158),
(5863, '172.28.14.82', 1, '1000.00', 158),
(5864, '172.28.14.83', 1, '1000.00', 158),
(5865, '172.28.14.84', 1, '1000.00', 158),
(5866, '172.28.14.85', 1, '1000.00', 158),
(5867, '172.28.14.86', 1, '1000.00', 158),
(5868, '172.28.14.87', 1, '1000.00', 158),
(5869, '172.28.14.88', 1, '1000.00', 158),
(5870, '172.28.14.89', 1, '1000.00', 158),
(5871, '172.28.14.90', 1, '1000.00', 158),
(5872, '172.28.14.91', 1, '1000.00', 158),
(5873, '172.28.14.92', 1, '1000.00', 158),
(5874, '172.28.14.93', 1, '1000.00', 158),
(5875, '172.28.14.94', 1, '1000.00', 158),
(5876, '172.28.14.95', 1, '1000.00', 158),
(5877, '172.28.14.96', 1, '1000.00', 158),
(5878, '172.28.14.97', 1, '1000.00', 158),
(5879, '172.28.14.98', 1, '1000.00', 158),
(5880, '172.28.14.99', 1, '1000.00', 158),
(5881, '172.28.14.100', 1, '1000.00', 158),
(5882, '172.28.14.101', 1, '1000.00', 158),
(5883, '172.28.14.102', 1, '1000.00', 158),
(5884, '172.28.14.103', 1, '1000.00', 158),
(5885, '172.28.14.104', 1, '1000.00', 158),
(5886, '172.28.14.105', 1, '1000.00', 158),
(5887, '172.28.14.106', 1, '1000.00', 158),
(5888, '172.28.14.107', 1, '1000.00', 158),
(5889, '172.28.14.108', 1, '1000.00', 158),
(5890, '172.28.14.109', 1, '1000.00', 158),
(5891, '172.28.14.110', 1, '1000.00', 158),
(5892, '172.28.14.111', 1, '1000.00', 158),
(5893, '172.28.14.112', 1, '1000.00', 158),
(5894, '172.28.14.113', 1, '1000.00', 158),
(5895, '172.28.14.114', 1, '1000.00', 158),
(5896, '172.28.14.115', 1, '1000.00', 158),
(5897, '172.28.14.116', 1, '1000.00', 158),
(5898, '172.28.14.117', 1, '1000.00', 158),
(5899, '172.28.14.118', 1, '1000.00', 158),
(5900, '172.28.14.119', 1, '1000.00', 158),
(5901, '172.28.14.120', 1, '1000.00', 158),
(5902, '172.28.14.121', 1, '1000.00', 158),
(5903, '172.28.14.122', 1, '1000.00', 158),
(5904, '172.28.14.123', 1, '1000.00', 158),
(5905, '172.28.14.124', 1, '1000.00', 158),
(5906, '172.28.14.125', 1, '1000.00', 158),
(5907, '172.28.14.126', 1, '1000.00', 158),
(5908, '172.28.14.127', 1, '1000.00', 158),
(5909, '172.28.14.128', 1, '1000.00', 158),
(5910, '172.28.14.129', 1, '1000.00', 158),
(5911, '172.28.14.130', 1, '1000.00', 158),
(5912, '172.28.14.131', 1, '1000.00', 158),
(5913, '172.28.14.132', 1, '1000.00', 158),
(5914, '172.28.14.133', 1, '1000.00', 158),
(5915, '172.28.14.134', 1, '1000.00', 158),
(5916, '172.28.14.135', 1, '1000.00', 158),
(5917, '172.28.14.136', 1, '1000.00', 158),
(5918, '172.28.14.137', 1, '1000.00', 158),
(5919, '172.28.14.138', 1, '1000.00', 158),
(5920, '172.28.14.139', 1, '1000.00', 158),
(5921, '172.28.14.140', 1, '1000.00', 158),
(5922, '172.28.14.141', 1, '1000.00', 158),
(5923, '172.28.14.142', 1, '1000.00', 158),
(5924, '172.28.14.143', 1, '1000.00', 158),
(5925, '172.28.14.144', 1, '1000.00', 158),
(5926, '172.28.14.145', 1, '1000.00', 158),
(5927, '172.28.14.146', 1, '1000.00', 158),
(5928, '172.28.14.147', 1, '1000.00', 158),
(5929, '172.28.14.148', 1, '1000.00', 158),
(5930, '172.28.14.149', 1, '1000.00', 158),
(5931, '172.28.14.150', 1, '1000.00', 158),
(5932, '172.28.14.151', 1, '1000.00', 158),
(5933, '172.28.14.152', 1, '1000.00', 158),
(5934, '172.28.14.153', 1, '1000.00', 158),
(5935, '172.28.14.154', 1, '1000.00', 158),
(5936, '172.28.14.155', 1, '1000.00', 158),
(5937, '172.28.14.156', 1, '1000.00', 158),
(5938, '172.28.14.157', 1, '1000.00', 158),
(5939, '172.28.14.158', 1, '1000.00', 158),
(5940, '172.28.14.159', 1, '1000.00', 158),
(5941, '172.28.14.160', 1, '1000.00', 158),
(5942, '172.28.14.161', 1, '1000.00', 158),
(5943, '172.28.14.162', 1, '1000.00', 158),
(5944, '172.28.14.163', 1, '1000.00', 158),
(5945, '172.28.14.164', 1, '1000.00', 158),
(5946, '172.28.14.165', 1, '1000.00', 158),
(5947, '172.28.14.166', 1, '1000.00', 158),
(5948, '172.28.14.167', 1, '1000.00', 158),
(5949, '172.28.14.168', 1, '1000.00', 158),
(5950, '172.28.14.169', 1, '1000.00', 158),
(5951, '172.28.14.170', 1, '1000.00', 158),
(5952, '172.28.14.171', 1, '1000.00', 158),
(5953, '172.28.14.172', 1, '1000.00', 158),
(5954, '172.28.14.173', 1, '1000.00', 158),
(5955, '172.28.14.174', 1, '1000.00', 158),
(5956, '172.28.14.175', 1, '1000.00', 158),
(5957, '172.28.14.176', 1, '1000.00', 158),
(5958, '172.28.14.177', 1, '1000.00', 158),
(5959, '172.28.14.178', 1, '1000.00', 158),
(5960, '172.28.14.179', 1, '1000.00', 158),
(5961, '172.28.14.180', 1, '1000.00', 158),
(5962, '172.28.14.181', 1, '1000.00', 158),
(5963, '172.28.14.182', 1, '1000.00', 158),
(5964, '172.28.14.183', 1, '1000.00', 158),
(5965, '172.28.14.184', 1, '1000.00', 158),
(5966, '172.28.14.185', 1, '1000.00', 158),
(5967, '172.28.14.186', 1, '1000.00', 158),
(5968, '172.28.14.187', 1, '1000.00', 158),
(5969, '172.28.14.188', 1, '1000.00', 158),
(5970, '172.28.14.189', 1, '1000.00', 158),
(5971, '172.28.14.190', 1, '1000.00', 158),
(5972, '172.28.14.191', 1, '1000.00', 158),
(5973, '172.28.14.192', 1, '1000.00', 158),
(5974, '172.28.14.193', 1, '1000.00', 158),
(5975, '172.28.14.194', 1, '1000.00', 158),
(5976, '172.28.14.195', 1, '1000.00', 158),
(5977, '172.28.14.196', 1, '1000.00', 158),
(5978, '172.28.14.197', 1, '1000.00', 158),
(5979, '172.28.14.198', 1, '1000.00', 158),
(5980, '172.28.14.199', 1, '1000.00', 158),
(5981, '172.28.14.200', 1, '1000.00', 158),
(5982, '172.28.14.201', 1, '1000.00', 158),
(5983, '172.28.14.202', 1, '1000.00', 158),
(5984, '172.28.14.203', 1, '1000.00', 158),
(5985, '172.28.14.204', 1, '1000.00', 158),
(5986, '172.28.14.205', 1, '1000.00', 158),
(5987, '172.28.14.206', 1, '1000.00', 158),
(5988, '172.28.14.207', 1, '1000.00', 158),
(5989, '172.28.14.208', 1, '1000.00', 158),
(5990, '172.28.14.209', 1, '1000.00', 158),
(5991, '172.28.14.210', 1, '1000.00', 158),
(5992, '172.28.14.211', 1, '1000.00', 158),
(5993, '172.28.14.212', 1, '1000.00', 158),
(5994, '172.28.14.213', 1, '1000.00', 158),
(5995, '172.28.14.214', 1, '1000.00', 158),
(5996, '172.28.14.215', 1, '1000.00', 158),
(5997, '172.28.14.216', 1, '1000.00', 158),
(5998, '172.28.14.217', 1, '1000.00', 158),
(5999, '172.28.14.218', 1, '1000.00', 158),
(6000, '172.28.14.219', 1, '1000.00', 158),
(6001, '172.28.14.220', 1, '1000.00', 158),
(6002, '172.28.14.221', 1, '1000.00', 158),
(6003, '172.28.14.222', 1, '1000.00', 158),
(6004, '172.28.14.223', 1, '1000.00', 158),
(6005, '172.28.14.224', 1, '1000.00', 158),
(6006, '172.28.14.225', 1, '1000.00', 158),
(6007, '172.28.14.226', 1, '1000.00', 158),
(6008, '172.28.14.227', 1, '1000.00', 158),
(6009, '172.28.14.228', 1, '1000.00', 158),
(6010, '172.28.14.229', 1, '1000.00', 158),
(6011, '172.28.14.230', 1, '1000.00', 158),
(6012, '172.28.14.231', 1, '1000.00', 158),
(6013, '172.28.14.232', 1, '1000.00', 158),
(6014, '172.28.14.233', 1, '1000.00', 158),
(6015, '172.28.14.234', 1, '1000.00', 158),
(6016, '172.28.14.235', 1, '1000.00', 158),
(6017, '172.28.14.236', 1, '1000.00', 158),
(6018, '172.28.14.237', 1, '1000.00', 158),
(6019, '172.28.14.238', 1, '1000.00', 158),
(6020, '172.28.14.239', 1, '1000.00', 158),
(6021, '172.28.14.240', 1, '1000.00', 158),
(6022, '172.28.14.241', 1, '1000.00', 158),
(6023, '172.28.14.242', 1, '1000.00', 158),
(6024, '172.28.14.243', 1, '1000.00', 158),
(6025, '172.28.14.244', 1, '1000.00', 158),
(6026, '172.28.14.245', 1, '1000.00', 158),
(6027, '172.28.14.246', 1, '1000.00', 158),
(6028, '172.28.14.247', 1, '1000.00', 158),
(6029, '172.28.14.248', 1, '1000.00', 158),
(6030, '172.28.14.249', 1, '1000.00', 158),
(6031, '172.28.14.250', 1, '1000.00', 158),
(6032, '172.28.14.251', 1, '1000.00', 158),
(6033, '172.28.14.252', 1, '1000.00', 158),
(6034, '172.28.14.253', 1, '1000.00', 158),
(6035, '172.28.14.254', 1, '1000.00', 158),
(6036, '172.28.37.2', 1, '1000.00', 158),
(6037, '172.28.37.3', 1, '1000.00', 158),
(6038, '172.28.37.4', 1, '1000.00', 158),
(6039, '172.28.37.5', 1, '1000.00', 158),
(6040, '172.28.37.6', 1, '1000.00', 158),
(6041, '172.28.37.7', 1, '1000.00', 158),
(6042, '172.28.37.8', 1, '1000.00', 158),
(6043, '172.28.37.9', 1, '1000.00', 158),
(6044, '172.28.37.10', 1, '1000.00', 158),
(6045, '172.28.37.11', 1, '1000.00', 158),
(6046, '172.28.37.12', 1, '1000.00', 158),
(6047, '172.28.37.13', 1, '1000.00', 158),
(6048, '172.28.37.14', 1, '1000.00', 158),
(6049, '172.28.37.15', 1, '1000.00', 158),
(6050, '172.28.37.16', 1, '1000.00', 158),
(6051, '172.28.37.17', 1, '1000.00', 158),
(6052, '172.28.37.18', 1, '1000.00', 158),
(6053, '172.28.37.19', 1, '1000.00', 158),
(6054, '172.28.37.20', 1, '1000.00', 158),
(6055, '172.28.37.21', 1, '1000.00', 158),
(6056, '172.28.37.22', 1, '1000.00', 158),
(6057, '172.28.37.23', 1, '1000.00', 158),
(6058, '172.28.37.24', 1, '1000.00', 158),
(6059, '172.28.37.25', 1, '1000.00', 158),
(6060, '172.28.37.26', 1, '1000.00', 158),
(6061, '172.28.37.27', 1, '1000.00', 158),
(6062, '172.28.37.28', 1, '1000.00', 158),
(6063, '172.28.37.29', 1, '1000.00', 158),
(6064, '172.28.37.30', 1, '1000.00', 158),
(6065, '172.28.37.31', 1, '1000.00', 158),
(6066, '172.28.37.32', 1, '1000.00', 158),
(6067, '172.28.37.33', 1, '1000.00', 158),
(6068, '172.28.37.34', 1, '1000.00', 158),
(6069, '172.28.37.35', 1, '1000.00', 158),
(6070, '172.28.37.36', 1, '1000.00', 158),
(6071, '172.28.37.37', 1, '1000.00', 158),
(6072, '172.28.37.38', 1, '1000.00', 158),
(6073, '172.28.37.39', 1, '1000.00', 158),
(6074, '172.28.37.40', 1, '1000.00', 158),
(6075, '172.28.37.41', 1, '1000.00', 158),
(6076, '172.28.37.42', 1, '1000.00', 158),
(6077, '172.28.37.43', 1, '1000.00', 158),
(6078, '172.28.37.44', 1, '1000.00', 158),
(6079, '172.28.37.45', 1, '1000.00', 158),
(6080, '172.28.37.46', 1, '1000.00', 158),
(6081, '172.28.37.47', 1, '1000.00', 158),
(6082, '172.28.37.48', 1, '1000.00', 158),
(6083, '172.28.37.49', 1, '1000.00', 158),
(6084, '172.28.37.50', 1, '1000.00', 158),
(6085, '172.28.37.51', 1, '1000.00', 158),
(6086, '172.28.37.52', 1, '1000.00', 158),
(6087, '172.28.37.53', 1, '1000.00', 158),
(6088, '172.28.37.54', 1, '1000.00', 158),
(6089, '172.28.37.55', 1, '1000.00', 158),
(6090, '172.28.37.56', 1, '1000.00', 158),
(6091, '172.28.37.57', 1, '1000.00', 158),
(6092, '172.28.37.58', 1, '1000.00', 158),
(6093, '172.28.37.59', 1, '1000.00', 158),
(6094, '172.28.37.60', 1, '1000.00', 158),
(6095, '172.28.37.61', 1, '1000.00', 158),
(6096, '172.28.37.62', 1, '1000.00', 158),
(6097, '172.28.37.63', 1, '1000.00', 158),
(6098, '172.28.37.64', 1, '1000.00', 158),
(6099, '172.28.37.65', 1, '1000.00', 158),
(6100, '172.28.37.66', 1, '1000.00', 158),
(6101, '172.28.37.67', 1, '1000.00', 158),
(6102, '172.28.37.68', 1, '1000.00', 158),
(6103, '172.28.37.69', 1, '1000.00', 158),
(6104, '172.28.37.70', 1, '1000.00', 158),
(6105, '172.28.37.71', 1, '1000.00', 158),
(6106, '172.28.37.72', 1, '1000.00', 158),
(6107, '172.28.37.73', 1, '1000.00', 158),
(6108, '172.28.37.74', 1, '1000.00', 158),
(6109, '172.28.37.75', 1, '1000.00', 158),
(6110, '172.28.37.76', 1, '1000.00', 158),
(6111, '172.28.37.77', 1, '1000.00', 158),
(6112, '172.28.37.78', 1, '1000.00', 158),
(6113, '172.28.37.79', 1, '1000.00', 158),
(6114, '172.28.37.80', 1, '1000.00', 158),
(6115, '172.28.37.81', 1, '1000.00', 158),
(6116, '172.28.37.82', 1, '1000.00', 158),
(6117, '172.28.37.83', 1, '1000.00', 158),
(6118, '172.28.37.84', 1, '1000.00', 158),
(6119, '172.28.37.85', 1, '1000.00', 158),
(6120, '172.28.37.86', 1, '1000.00', 158),
(6121, '172.28.37.87', 1, '1000.00', 158),
(6122, '172.28.37.88', 1, '1000.00', 158),
(6123, '172.28.37.89', 1, '1000.00', 158),
(6124, '172.28.37.90', 1, '1000.00', 158),
(6125, '172.28.37.91', 1, '1000.00', 158),
(6126, '172.28.37.92', 1, '1000.00', 158),
(6127, '172.28.37.93', 1, '1000.00', 158),
(6128, '172.28.37.94', 1, '1000.00', 158),
(6129, '172.28.37.95', 1, '1000.00', 158),
(6130, '172.28.37.96', 1, '1000.00', 158),
(6131, '172.28.37.97', 1, '1000.00', 158),
(6132, '172.28.37.98', 1, '1000.00', 158),
(6133, '172.28.37.99', 1, '1000.00', 158),
(6134, '172.28.37.100', 1, '1000.00', 158),
(6135, '172.28.37.101', 1, '1000.00', 158),
(6136, '172.28.37.102', 1, '1000.00', 158),
(6137, '172.28.37.103', 1, '1000.00', 158),
(6138, '172.28.37.104', 1, '1000.00', 158),
(6139, '172.28.37.105', 1, '1000.00', 158),
(6140, '172.28.37.106', 1, '1000.00', 158),
(6141, '172.28.37.107', 1, '1000.00', 158),
(6142, '172.28.37.108', 1, '1000.00', 158),
(6143, '172.28.37.109', 1, '1000.00', 158),
(6144, '172.28.37.110', 1, '1000.00', 158),
(6145, '172.28.37.111', 1, '1000.00', 158),
(6146, '172.28.37.112', 1, '1000.00', 158),
(6147, '172.28.37.113', 1, '1000.00', 158),
(6148, '172.28.37.114', 1, '1000.00', 158),
(6149, '172.28.37.115', 1, '1000.00', 158),
(6150, '172.28.37.116', 1, '1000.00', 158),
(6151, '172.28.37.117', 1, '1000.00', 158),
(6152, '172.28.37.118', 1, '1000.00', 158),
(6153, '172.28.37.119', 1, '1000.00', 158),
(6154, '172.28.37.120', 1, '1000.00', 158),
(6155, '172.28.37.121', 1, '1000.00', 158),
(6156, '172.28.37.122', 1, '1000.00', 158),
(6157, '172.28.37.123', 1, '1000.00', 158),
(6158, '172.28.37.124', 1, '1000.00', 158),
(6159, '172.28.37.125', 1, '1000.00', 158),
(6160, '172.28.37.126', 1, '1000.00', 158),
(6161, '172.28.37.127', 1, '1000.00', 158),
(6162, '172.28.37.128', 1, '1000.00', 158),
(6163, '172.28.37.129', 1, '1000.00', 158),
(6164, '172.28.37.130', 1, '1000.00', 158),
(6165, '172.28.37.131', 1, '1000.00', 158),
(6166, '172.28.37.132', 1, '1000.00', 158),
(6167, '172.28.37.133', 1, '1000.00', 158),
(6168, '172.28.37.134', 1, '1000.00', 158),
(6169, '172.28.37.135', 1, '1000.00', 158),
(6170, '172.28.37.136', 1, '1000.00', 158),
(6171, '172.28.37.137', 1, '1000.00', 158),
(6172, '172.28.37.138', 1, '1000.00', 158),
(6173, '172.28.37.139', 1, '1000.00', 158),
(6174, '172.28.37.140', 1, '1000.00', 158),
(6175, '172.28.37.141', 1, '1000.00', 158),
(6176, '172.28.37.142', 1, '1000.00', 158),
(6177, '172.28.37.143', 1, '1000.00', 158),
(6178, '172.28.37.144', 1, '1000.00', 158),
(6179, '172.28.37.145', 1, '1000.00', 158),
(6180, '172.28.37.146', 1, '1000.00', 158),
(6181, '172.28.37.147', 1, '1000.00', 158),
(6182, '172.28.37.148', 1, '1000.00', 158),
(6183, '172.28.37.149', 1, '1000.00', 158),
(6184, '172.28.37.150', 1, '1000.00', 158),
(6185, '172.28.37.151', 1, '1000.00', 158),
(6186, '172.28.37.152', 1, '1000.00', 158),
(6187, '172.28.37.153', 1, '1000.00', 158),
(6188, '172.28.37.154', 1, '1000.00', 158),
(6189, '172.28.37.155', 1, '1000.00', 158),
(6190, '172.28.37.156', 1, '1000.00', 158),
(6191, '172.28.37.157', 1, '1000.00', 158),
(6192, '172.28.37.158', 1, '1000.00', 158),
(6193, '172.28.37.159', 1, '1000.00', 158),
(6194, '172.28.37.160', 1, '1000.00', 158),
(6195, '172.28.37.161', 1, '1000.00', 158),
(6196, '172.28.37.162', 1, '1000.00', 158),
(6197, '172.28.37.163', 1, '1000.00', 158),
(6198, '172.28.37.164', 1, '1000.00', 158),
(6199, '172.28.37.165', 1, '1000.00', 158),
(6200, '172.28.37.166', 1, '1000.00', 158),
(6201, '172.28.37.167', 1, '1000.00', 158),
(6202, '172.28.37.168', 1, '1000.00', 158),
(6203, '172.28.37.169', 1, '1000.00', 158),
(6204, '172.28.37.170', 1, '1000.00', 158),
(6205, '172.28.37.171', 1, '1000.00', 158),
(6206, '172.28.37.172', 1, '1000.00', 158),
(6207, '172.28.37.173', 1, '1000.00', 158),
(6208, '172.28.37.174', 1, '1000.00', 158),
(6209, '172.28.37.175', 1, '1000.00', 158),
(6210, '172.28.37.176', 1, '1000.00', 158),
(6211, '172.28.37.177', 1, '1000.00', 158),
(6212, '172.28.37.178', 1, '1000.00', 158),
(6213, '172.28.37.179', 1, '1000.00', 158),
(6214, '172.28.37.180', 1, '1000.00', 158),
(6215, '172.28.37.181', 1, '1000.00', 158),
(6216, '172.28.37.182', 1, '1000.00', 158),
(6217, '172.28.37.183', 1, '1000.00', 158),
(6218, '172.28.37.184', 1, '1000.00', 158),
(6219, '172.28.37.185', 1, '1000.00', 158),
(6220, '172.28.37.186', 1, '1000.00', 158),
(6221, '172.28.37.187', 1, '1000.00', 158),
(6222, '172.28.37.188', 1, '1000.00', 158),
(6223, '172.28.37.189', 1, '1000.00', 158),
(6224, '172.28.37.190', 1, '1000.00', 158),
(6225, '172.28.37.191', 1, '1000.00', 158),
(6226, '172.28.37.192', 1, '1000.00', 158),
(6227, '172.28.37.193', 1, '1000.00', 158),
(6228, '172.28.37.194', 1, '1000.00', 158),
(6229, '172.28.37.195', 1, '1000.00', 158),
(6230, '172.28.37.196', 1, '1000.00', 158),
(6231, '172.28.37.197', 1, '1000.00', 158),
(6232, '172.28.37.198', 1, '1000.00', 158),
(6233, '172.28.37.199', 1, '1000.00', 158),
(6234, '172.28.37.200', 1, '1000.00', 158),
(6235, '172.28.37.201', 1, '1000.00', 158),
(6236, '172.28.37.202', 1, '1000.00', 158),
(6237, '172.28.37.203', 1, '1000.00', 158),
(6238, '172.28.37.204', 1, '1000.00', 158),
(6239, '172.28.37.205', 1, '1000.00', 158),
(6240, '172.28.37.206', 1, '1000.00', 158),
(6241, '172.28.37.207', 1, '1000.00', 158),
(6242, '172.28.37.208', 1, '1000.00', 158),
(6243, '172.28.37.209', 1, '1000.00', 158),
(6244, '172.28.37.210', 1, '1000.00', 158),
(6245, '172.28.37.211', 1, '1000.00', 158),
(6246, '172.28.37.212', 1, '1000.00', 158),
(6247, '172.28.37.213', 1, '1000.00', 158),
(6248, '172.28.37.214', 1, '1000.00', 158),
(6249, '172.28.37.215', 1, '1000.00', 158),
(6250, '172.28.37.216', 1, '1000.00', 158),
(6251, '172.28.37.217', 1, '1000.00', 158),
(6252, '172.28.37.218', 1, '1000.00', 158),
(6253, '172.28.37.219', 1, '1000.00', 158),
(6254, '172.28.37.220', 1, '1000.00', 158),
(6255, '172.28.37.221', 1, '1000.00', 158),
(6256, '172.28.37.222', 1, '1000.00', 158),
(6257, '172.28.37.223', 1, '1000.00', 158),
(6258, '172.28.37.224', 1, '1000.00', 158),
(6259, '172.28.37.225', 1, '1000.00', 158),
(6260, '172.28.37.226', 1, '1000.00', 158),
(6261, '172.28.37.227', 1, '1000.00', 158),
(6262, '172.28.37.228', 1, '1000.00', 158),
(6263, '172.28.37.229', 1, '1000.00', 158),
(6264, '172.28.37.230', 1, '1000.00', 158),
(6265, '172.28.37.231', 1, '1000.00', 158),
(6266, '172.28.37.232', 1, '1000.00', 158),
(6267, '172.28.37.233', 1, '1000.00', 158),
(6268, '172.28.37.234', 1, '1000.00', 158),
(6269, '172.28.37.235', 1, '1000.00', 158),
(6270, '172.28.37.236', 1, '1000.00', 158),
(6271, '172.28.37.237', 1, '1000.00', 158),
(6272, '172.28.37.238', 1, '1000.00', 158),
(6273, '172.28.37.239', 1, '1000.00', 158),
(6274, '172.28.37.240', 1, '1000.00', 158),
(6275, '172.28.37.241', 1, '1000.00', 158),
(6276, '172.28.37.242', 1, '1000.00', 158),
(6277, '172.28.37.243', 1, '1000.00', 158),
(6278, '172.28.37.244', 1, '1000.00', 158),
(6279, '172.28.37.245', 1, '1000.00', 158),
(6280, '172.28.37.246', 1, '1000.00', 158),
(6281, '172.28.37.247', 1, '1000.00', 158),
(6282, '172.28.37.248', 1, '1000.00', 158),
(6283, '172.28.37.249', 1, '1000.00', 158),
(6284, '172.28.37.250', 1, '1000.00', 158),
(6285, '172.28.37.251', 1, '1000.00', 158),
(6286, '172.28.37.252', 1, '1000.00', 158),
(6287, '172.28.37.253', 1, '1000.00', 158),
(6288, '172.28.37.254', 1, '1000.00', 158),
(6289, '172.28.20.2', 1, '1000.00', 159),
(6290, '172.28.20.3', 1, '1000.00', 159),
(6291, '172.28.20.4', 1, '1000.00', 159),
(6292, '172.28.20.5', 1, '1000.00', 159),
(6293, '172.28.20.6', 1, '1000.00', 159),
(6294, '172.28.20.7', 1, '1000.00', 159),
(6295, '172.28.20.8', 1, '1000.00', 159),
(6296, '172.28.20.9', 1, '1000.00', 159),
(6297, '172.28.20.10', 1, '1000.00', 159),
(6298, '172.28.20.11', 1, '1000.00', 159),
(6299, '172.28.20.12', 1, '1000.00', 159),
(6300, '172.28.20.13', 1, '1000.00', 159),
(6301, '172.28.20.14', 1, '1000.00', 159),
(6302, '172.28.20.15', 1, '1000.00', 159),
(6303, '172.28.20.16', 1, '1000.00', 159),
(6304, '172.28.20.17', 1, '1000.00', 159),
(6305, '172.28.20.18', 1, '1000.00', 159),
(6306, '172.28.20.19', 1, '1000.00', 159),
(6307, '172.28.20.20', 1, '1000.00', 159),
(6308, '172.28.20.21', 1, '1000.00', 159),
(6309, '172.28.20.22', 1, '1000.00', 159),
(6310, '172.28.20.23', 1, '1000.00', 159),
(6311, '172.28.20.24', 1, '1000.00', 159),
(6312, '172.28.20.25', 1, '1000.00', 159),
(6313, '172.28.20.26', 1, '1000.00', 159),
(6314, '172.28.20.27', 1, '1000.00', 159),
(6315, '172.28.20.28', 1, '1000.00', 159),
(6316, '172.28.20.29', 1, '1000.00', 159),
(6317, '172.28.20.30', 1, '1000.00', 159),
(6318, '172.28.20.31', 1, '1000.00', 159),
(6319, '172.28.20.32', 1, '1000.00', 159),
(6320, '172.28.20.33', 1, '1000.00', 159),
(6321, '172.28.20.34', 1, '1000.00', 159),
(6322, '172.28.20.35', 1, '1000.00', 159),
(6323, '172.28.20.36', 1, '1000.00', 159),
(6324, '172.28.20.37', 1, '1000.00', 159),
(6325, '172.28.20.38', 1, '1000.00', 159),
(6326, '172.28.20.39', 1, '1000.00', 159),
(6327, '172.28.20.40', 1, '1000.00', 159),
(6328, '172.28.20.41', 1, '1000.00', 159),
(6329, '172.28.20.42', 1, '1000.00', 159),
(6330, '172.28.20.43', 1, '1000.00', 159),
(6331, '172.28.20.44', 1, '1000.00', 159),
(6332, '172.28.20.45', 1, '1000.00', 159),
(6333, '172.28.20.46', 1, '1000.00', 159),
(6334, '172.28.20.47', 1, '1000.00', 159),
(6335, '172.28.20.48', 1, '1000.00', 159),
(6336, '172.28.20.49', 1, '1000.00', 159),
(6337, '172.28.20.50', 1, '1000.00', 159),
(6338, '172.28.20.51', 1, '1000.00', 159),
(6339, '172.28.20.52', 1, '1000.00', 159),
(6340, '172.28.20.53', 1, '1000.00', 159),
(6341, '172.28.20.54', 1, '1000.00', 159),
(6342, '172.28.20.55', 1, '1000.00', 159),
(6343, '172.28.20.56', 1, '1000.00', 159),
(6344, '172.28.20.57', 1, '1000.00', 159),
(6345, '172.28.20.58', 1, '1000.00', 159),
(6346, '172.28.20.59', 1, '1000.00', 159),
(6347, '172.28.20.60', 1, '1000.00', 159),
(6348, '172.28.20.61', 1, '1000.00', 159),
(6349, '172.28.20.62', 1, '1000.00', 159),
(6350, '172.28.20.63', 1, '1000.00', 159),
(6351, '172.28.20.64', 1, '1000.00', 159),
(6352, '172.28.20.65', 1, '1000.00', 159),
(6353, '172.28.20.66', 1, '1000.00', 159),
(6354, '172.28.20.67', 1, '1000.00', 159),
(6355, '172.28.20.68', 1, '1000.00', 159),
(6356, '172.28.20.69', 1, '1000.00', 159),
(6357, '172.28.20.70', 1, '1000.00', 159),
(6358, '172.28.20.71', 1, '1000.00', 159),
(6359, '172.28.20.72', 1, '1000.00', 159),
(6360, '172.28.20.73', 1, '1000.00', 159),
(6361, '172.28.20.74', 1, '1000.00', 159),
(6362, '172.28.20.75', 1, '1000.00', 159),
(6363, '172.28.20.76', 1, '1000.00', 159),
(6364, '172.28.20.77', 1, '1000.00', 159),
(6365, '172.28.20.78', 1, '1000.00', 159),
(6366, '172.28.20.79', 1, '1000.00', 159),
(6367, '172.28.20.80', 1, '1000.00', 159),
(6368, '172.28.20.81', 1, '1000.00', 159),
(6369, '172.28.20.82', 1, '1000.00', 159),
(6370, '172.28.20.83', 1, '1000.00', 159),
(6371, '172.28.20.84', 1, '1000.00', 159),
(6372, '172.28.20.85', 1, '1000.00', 159),
(6373, '172.28.20.86', 1, '1000.00', 159),
(6374, '172.28.20.87', 1, '1000.00', 159),
(6375, '172.28.20.88', 1, '1000.00', 159),
(6376, '172.28.20.89', 1, '1000.00', 159),
(6377, '172.28.20.90', 1, '1000.00', 159),
(6378, '172.28.20.91', 1, '1000.00', 159),
(6379, '172.28.20.92', 1, '1000.00', 159),
(6380, '172.28.20.93', 1, '1000.00', 159),
(6381, '172.28.20.94', 1, '1000.00', 159),
(6382, '172.28.20.95', 1, '1000.00', 159),
(6383, '172.28.20.96', 1, '1000.00', 159),
(6384, '172.28.20.97', 1, '1000.00', 159),
(6385, '172.28.20.98', 1, '1000.00', 159),
(6386, '172.28.20.99', 1, '1000.00', 159),
(6387, '172.28.20.100', 1, '1000.00', 159),
(6388, '172.28.20.101', 1, '1000.00', 159),
(6389, '172.28.20.102', 1, '1000.00', 159),
(6390, '172.28.20.103', 1, '1000.00', 159),
(6391, '172.28.20.104', 1, '1000.00', 159),
(6392, '172.28.20.105', 1, '1000.00', 159),
(6393, '172.28.20.106', 1, '1000.00', 159),
(6394, '172.28.20.107', 1, '1000.00', 159),
(6395, '172.28.20.108', 1, '1000.00', 159),
(6396, '172.28.20.109', 1, '1000.00', 159),
(6397, '172.28.20.110', 1, '1000.00', 159),
(6398, '172.28.20.111', 1, '1000.00', 159),
(6399, '172.28.20.112', 1, '1000.00', 159),
(6400, '172.28.20.113', 1, '1000.00', 159),
(6401, '172.28.20.114', 1, '1000.00', 159),
(6402, '172.28.20.115', 1, '1000.00', 159),
(6403, '172.28.20.116', 1, '1000.00', 159),
(6404, '172.28.20.117', 1, '1000.00', 159),
(6405, '172.28.20.118', 1, '1000.00', 159),
(6406, '172.28.20.119', 1, '1000.00', 159),
(6407, '172.28.20.120', 1, '1000.00', 159),
(6408, '172.28.20.121', 1, '1000.00', 159),
(6409, '172.28.20.122', 1, '1000.00', 159),
(6410, '172.28.20.123', 1, '1000.00', 159),
(6411, '172.28.20.124', 1, '1000.00', 159),
(6412, '172.28.20.125', 1, '1000.00', 159),
(6413, '172.28.20.126', 1, '1000.00', 159),
(6414, '172.28.20.127', 1, '1000.00', 159),
(6415, '172.28.20.128', 1, '1000.00', 159),
(6416, '172.28.20.129', 1, '1000.00', 159),
(6417, '172.28.20.130', 1, '1000.00', 159),
(6418, '172.28.20.131', 1, '1000.00', 159),
(6419, '172.28.20.132', 1, '1000.00', 159),
(6420, '172.28.20.133', 1, '1000.00', 159),
(6421, '172.28.20.134', 1, '1000.00', 159),
(6422, '172.28.20.135', 1, '1000.00', 159),
(6423, '172.28.20.136', 1, '1000.00', 159),
(6424, '172.28.20.137', 1, '1000.00', 159),
(6425, '172.28.20.138', 1, '1000.00', 159),
(6426, '172.28.20.139', 1, '1000.00', 159),
(6427, '172.28.20.140', 1, '1000.00', 159),
(6428, '172.28.20.141', 1, '1000.00', 159),
(6429, '172.28.20.142', 1, '1000.00', 159),
(6430, '172.28.20.143', 1, '1000.00', 159),
(6431, '172.28.20.144', 1, '1000.00', 159),
(6432, '172.28.20.145', 1, '1000.00', 159),
(6433, '172.28.20.146', 1, '1000.00', 159),
(6434, '172.28.20.147', 1, '1000.00', 159),
(6435, '172.28.20.148', 1, '1000.00', 159),
(6436, '172.28.20.149', 1, '1000.00', 159),
(6437, '172.28.20.150', 1, '1000.00', 159),
(6438, '172.28.20.151', 1, '1000.00', 159),
(6439, '172.28.20.152', 1, '1000.00', 159),
(6440, '172.28.20.153', 1, '1000.00', 159),
(6441, '172.28.20.154', 1, '1000.00', 159),
(6442, '172.28.20.155', 1, '1000.00', 159),
(6443, '172.28.20.156', 1, '1000.00', 159),
(6444, '172.28.20.157', 1, '1000.00', 159),
(6445, '172.28.20.158', 1, '1000.00', 159),
(6446, '172.28.20.159', 1, '1000.00', 159),
(6447, '172.28.20.160', 1, '1000.00', 159),
(6448, '172.28.20.161', 1, '1000.00', 159),
(6449, '172.28.20.162', 1, '1000.00', 159),
(6450, '172.28.20.163', 1, '1000.00', 159),
(6451, '172.28.20.164', 1, '1000.00', 159),
(6452, '172.28.20.165', 1, '1000.00', 159),
(6453, '172.28.20.166', 1, '1000.00', 159),
(6454, '172.28.20.167', 1, '1000.00', 159),
(6455, '172.28.20.168', 1, '1000.00', 159),
(6456, '172.28.20.169', 1, '1000.00', 159),
(6457, '172.28.20.170', 1, '1000.00', 159),
(6458, '172.28.20.171', 1, '1000.00', 159),
(6459, '172.28.20.172', 1, '1000.00', 159),
(6460, '172.28.20.173', 1, '1000.00', 159),
(6461, '172.28.20.174', 1, '1000.00', 159),
(6462, '172.28.20.175', 1, '1000.00', 159),
(6463, '172.28.20.176', 1, '1000.00', 159),
(6464, '172.28.20.177', 1, '1000.00', 159),
(6465, '172.28.20.178', 1, '1000.00', 159),
(6466, '172.28.20.179', 1, '1000.00', 159),
(6467, '172.28.20.180', 1, '1000.00', 159),
(6468, '172.28.20.181', 1, '1000.00', 159),
(6469, '172.28.20.182', 1, '1000.00', 159),
(6470, '172.28.20.183', 1, '1000.00', 159),
(6471, '172.28.20.184', 1, '1000.00', 159),
(6472, '172.28.20.185', 1, '1000.00', 159),
(6473, '172.28.20.186', 1, '1000.00', 159),
(6474, '172.28.20.187', 1, '1000.00', 159),
(6475, '172.28.20.188', 1, '1000.00', 159),
(6476, '172.28.20.189', 1, '1000.00', 159),
(6477, '172.28.20.190', 1, '1000.00', 159),
(6478, '172.28.20.191', 1, '1000.00', 159),
(6479, '172.28.20.192', 1, '1000.00', 159),
(6480, '172.28.20.193', 1, '1000.00', 159),
(6481, '172.28.20.194', 1, '1000.00', 159),
(6482, '172.28.20.195', 1, '1000.00', 159),
(6483, '172.28.20.196', 1, '1000.00', 159),
(6484, '172.28.20.197', 1, '1000.00', 159),
(6485, '172.28.20.198', 1, '1000.00', 159),
(6486, '172.28.20.199', 1, '1000.00', 159),
(6487, '172.28.20.200', 1, '1000.00', 159),
(6488, '172.28.20.201', 1, '1000.00', 159),
(6489, '172.28.20.202', 1, '1000.00', 159),
(6490, '172.28.20.203', 1, '1000.00', 159),
(6491, '172.28.20.204', 1, '1000.00', 159),
(6492, '172.28.20.205', 1, '1000.00', 159),
(6493, '172.28.20.206', 1, '1000.00', 159),
(6494, '172.28.20.207', 1, '1000.00', 159),
(6495, '172.28.20.208', 1, '1000.00', 159),
(6496, '172.28.20.209', 1, '1000.00', 159),
(6497, '172.28.20.210', 1, '1000.00', 159),
(6498, '172.28.20.211', 1, '1000.00', 159),
(6499, '172.28.20.212', 1, '1000.00', 159),
(6500, '172.28.20.213', 1, '1000.00', 159),
(6501, '172.28.20.214', 1, '1000.00', 159),
(6502, '172.28.20.215', 1, '1000.00', 159),
(6503, '172.28.20.216', 1, '1000.00', 159),
(6504, '172.28.20.217', 1, '1000.00', 159),
(6505, '172.28.20.218', 1, '1000.00', 159),
(6506, '172.28.20.219', 1, '1000.00', 159),
(6507, '172.28.20.220', 1, '1000.00', 159),
(6508, '172.28.20.221', 1, '1000.00', 159),
(6509, '172.28.20.222', 1, '1000.00', 159),
(6510, '172.28.20.223', 1, '1000.00', 159),
(6511, '172.28.20.224', 1, '1000.00', 159),
(6512, '172.28.20.225', 1, '1000.00', 159),
(6513, '172.28.20.226', 1, '1000.00', 159),
(6514, '172.28.20.227', 1, '1000.00', 159),
(6515, '172.28.20.228', 1, '1000.00', 159),
(6516, '172.28.20.229', 1, '1000.00', 159),
(6517, '172.28.20.230', 1, '1000.00', 159),
(6518, '172.28.20.231', 1, '1000.00', 159),
(6519, '172.28.20.232', 1, '1000.00', 159),
(6520, '172.28.20.233', 1, '1000.00', 159),
(6521, '172.28.20.234', 1, '1000.00', 159),
(6522, '172.28.20.235', 1, '1000.00', 159),
(6523, '172.28.20.236', 1, '1000.00', 159),
(6524, '172.28.20.237', 1, '1000.00', 159),
(6525, '172.28.20.238', 1, '1000.00', 159),
(6526, '172.28.20.239', 1, '1000.00', 159),
(6527, '172.28.20.240', 1, '1000.00', 159),
(6528, '172.28.20.241', 1, '1000.00', 159),
(6529, '172.28.20.242', 1, '1000.00', 159),
(6530, '172.28.20.243', 1, '1000.00', 159),
(6531, '172.28.20.244', 1, '1000.00', 159),
(6532, '172.28.20.245', 1, '1000.00', 159),
(6533, '172.28.20.246', 1, '1000.00', 159),
(6534, '172.28.20.247', 1, '1000.00', 159),
(6535, '172.28.20.248', 1, '1000.00', 159),
(6536, '172.28.20.249', 1, '1000.00', 159),
(6537, '172.28.20.250', 1, '1000.00', 159),
(6538, '172.28.20.251', 1, '1000.00', 159),
(6539, '172.28.20.252', 1, '1000.00', 159),
(6540, '172.28.20.253', 1, '1000.00', 159),
(6541, '172.28.20.254', 1, '1000.00', 159),
(6542, '172.28.27.2', 1, '1000.00', 160),
(6543, '172.28.27.3', 1, '1000.00', 160),
(6544, '172.28.27.4', 1, '1000.00', 160),
(6545, '172.28.27.5', 1, '1000.00', 160),
(6546, '172.28.27.6', 1, '1000.00', 160),
(6547, '172.28.27.7', 1, '1000.00', 160),
(6548, '172.28.27.8', 1, '1000.00', 160),
(6549, '172.28.27.9', 1, '1000.00', 160),
(6550, '172.28.27.10', 1, '1000.00', 160),
(6551, '172.28.27.11', 1, '1000.00', 160),
(6552, '172.28.27.12', 1, '1000.00', 160),
(6553, '172.28.27.13', 1, '1000.00', 160),
(6554, '172.28.27.14', 1, '1000.00', 160),
(6555, '172.28.27.15', 1, '1000.00', 160),
(6556, '172.28.27.16', 1, '1000.00', 160),
(6557, '172.28.27.17', 1, '1000.00', 160),
(6558, '172.28.27.18', 1, '1000.00', 160),
(6559, '172.28.27.19', 1, '1000.00', 160),
(6560, '172.28.27.20', 1, '1000.00', 160),
(6561, '172.28.27.21', 1, '1000.00', 160),
(6562, '172.28.27.22', 1, '1000.00', 160),
(6563, '172.28.27.23', 1, '1000.00', 160),
(6564, '172.28.27.24', 1, '1000.00', 160),
(6565, '172.28.27.25', 1, '1000.00', 160),
(6566, '172.28.27.26', 1, '1000.00', 160),
(6567, '172.28.27.27', 1, '1000.00', 160),
(6568, '172.28.27.28', 1, '1000.00', 160),
(6569, '172.28.27.29', 1, '1000.00', 160),
(6570, '172.28.27.30', 1, '1000.00', 160),
(6571, '172.28.27.31', 1, '1000.00', 160),
(6572, '172.28.27.32', 1, '1000.00', 160),
(6573, '172.28.27.33', 1, '1000.00', 160),
(6574, '172.28.27.34', 1, '1000.00', 160),
(6575, '172.28.27.35', 1, '1000.00', 160),
(6576, '172.28.27.36', 1, '1000.00', 160),
(6577, '172.28.27.37', 1, '1000.00', 160),
(6578, '172.28.27.38', 1, '1000.00', 160),
(6579, '172.28.27.39', 1, '1000.00', 160),
(6580, '172.28.27.40', 1, '1000.00', 160),
(6581, '172.28.27.41', 1, '1000.00', 160),
(6582, '172.28.27.42', 1, '1000.00', 160),
(6583, '172.28.27.43', 1, '1000.00', 160),
(6584, '172.28.27.44', 1, '1000.00', 160),
(6585, '172.28.27.45', 1, '1000.00', 160),
(6586, '172.28.27.46', 1, '1000.00', 160),
(6587, '172.28.27.47', 1, '1000.00', 160),
(6588, '172.28.27.48', 1, '1000.00', 160),
(6589, '172.28.27.49', 1, '1000.00', 160),
(6590, '172.28.27.50', 1, '1000.00', 160),
(6591, '172.28.27.51', 1, '1000.00', 160),
(6592, '172.28.27.52', 1, '1000.00', 160),
(6593, '172.28.27.53', 1, '1000.00', 160),
(6594, '172.28.27.54', 1, '1000.00', 160),
(6595, '172.28.27.55', 1, '1000.00', 160),
(6596, '172.28.27.56', 1, '1000.00', 160),
(6597, '172.28.27.57', 1, '1000.00', 160),
(6598, '172.28.27.58', 1, '1000.00', 160),
(6599, '172.28.27.59', 1, '1000.00', 160),
(6600, '172.28.27.60', 1, '1000.00', 160),
(6601, '172.28.27.61', 1, '1000.00', 160),
(6602, '172.28.27.62', 1, '1000.00', 160),
(6603, '172.28.27.63', 1, '1000.00', 160),
(6604, '172.28.27.64', 1, '1000.00', 160),
(6605, '172.28.27.65', 1, '1000.00', 160),
(6606, '172.28.27.66', 1, '1000.00', 160),
(6607, '172.28.27.67', 1, '1000.00', 160),
(6608, '172.28.27.68', 1, '1000.00', 160),
(6609, '172.28.27.69', 1, '1000.00', 160),
(6610, '172.28.27.70', 1, '1000.00', 160),
(6611, '172.28.27.71', 1, '1000.00', 160),
(6612, '172.28.27.72', 1, '1000.00', 160),
(6613, '172.28.27.73', 1, '1000.00', 160),
(6614, '172.28.27.74', 1, '1000.00', 160),
(6615, '172.28.27.75', 1, '1000.00', 160),
(6616, '172.28.27.76', 1, '1000.00', 160),
(6617, '172.28.27.77', 1, '1000.00', 160),
(6618, '172.28.27.78', 1, '1000.00', 160),
(6619, '172.28.27.79', 1, '1000.00', 160),
(6620, '172.28.27.80', 1, '1000.00', 160),
(6621, '172.28.27.81', 1, '1000.00', 160),
(6622, '172.28.27.82', 1, '1000.00', 160),
(6623, '172.28.27.83', 1, '1000.00', 160),
(6624, '172.28.27.84', 1, '1000.00', 160),
(6625, '172.28.27.85', 1, '1000.00', 160),
(6626, '172.28.27.86', 1, '1000.00', 160),
(6627, '172.28.27.87', 1, '1000.00', 160),
(6628, '172.28.27.88', 1, '1000.00', 160),
(6629, '172.28.27.89', 1, '1000.00', 160),
(6630, '172.28.27.90', 1, '1000.00', 160),
(6631, '172.28.27.91', 1, '1000.00', 160),
(6632, '172.28.27.92', 1, '1000.00', 160),
(6633, '172.28.27.93', 1, '1000.00', 160),
(6634, '172.28.27.94', 1, '1000.00', 160),
(6635, '172.28.27.95', 1, '1000.00', 160),
(6636, '172.28.27.96', 1, '1000.00', 160),
(6637, '172.28.27.97', 1, '1000.00', 160),
(6638, '172.28.27.98', 1, '1000.00', 160),
(6639, '172.28.27.99', 1, '1000.00', 160),
(6640, '172.28.27.100', 1, '1000.00', 160),
(6641, '172.28.27.101', 1, '1000.00', 160),
(6642, '172.28.27.102', 1, '1000.00', 160),
(6643, '172.28.27.103', 1, '1000.00', 160),
(6644, '172.28.27.104', 1, '1000.00', 160),
(6645, '172.28.27.105', 1, '1000.00', 160),
(6646, '172.28.27.106', 1, '1000.00', 160),
(6647, '172.28.27.107', 1, '1000.00', 160),
(6648, '172.28.27.108', 1, '1000.00', 160),
(6649, '172.28.27.109', 1, '1000.00', 160),
(6650, '172.28.27.110', 1, '1000.00', 160),
(6651, '172.28.27.111', 1, '1000.00', 160),
(6652, '172.28.27.112', 1, '1000.00', 160),
(6653, '172.28.27.113', 1, '1000.00', 160),
(6654, '172.28.27.114', 1, '1000.00', 160),
(6655, '172.28.27.115', 1, '1000.00', 160),
(6656, '172.28.27.116', 1, '1000.00', 160),
(6657, '172.28.27.117', 1, '1000.00', 160),
(6658, '172.28.27.118', 1, '1000.00', 160),
(6659, '172.28.27.119', 1, '1000.00', 160),
(6660, '172.28.27.120', 1, '1000.00', 160),
(6661, '172.28.27.121', 1, '1000.00', 160),
(6662, '172.28.27.122', 1, '1000.00', 160),
(6663, '172.28.27.123', 1, '1000.00', 160),
(6664, '172.28.27.124', 1, '1000.00', 160),
(6665, '172.28.27.125', 1, '1000.00', 160),
(6666, '172.28.27.126', 1, '1000.00', 160),
(6667, '172.28.27.127', 1, '1000.00', 160),
(6668, '172.28.27.128', 1, '1000.00', 160),
(6669, '172.28.27.129', 1, '1000.00', 160),
(6670, '172.28.27.130', 1, '1000.00', 160),
(6671, '172.28.27.131', 1, '1000.00', 160),
(6672, '172.28.27.132', 1, '1000.00', 160),
(6673, '172.28.27.133', 1, '1000.00', 160),
(6674, '172.28.27.134', 1, '1000.00', 160),
(6675, '172.28.27.135', 1, '1000.00', 160),
(6676, '172.28.27.136', 1, '1000.00', 160),
(6677, '172.28.27.137', 1, '1000.00', 160),
(6678, '172.28.27.138', 1, '1000.00', 160),
(6679, '172.28.27.139', 1, '1000.00', 160),
(6680, '172.28.27.140', 1, '1000.00', 160),
(6681, '172.28.27.141', 1, '1000.00', 160),
(6682, '172.28.27.142', 1, '1000.00', 160),
(6683, '172.28.27.143', 1, '1000.00', 160),
(6684, '172.28.27.144', 1, '1000.00', 160),
(6685, '172.28.27.145', 1, '1000.00', 160),
(6686, '172.28.27.146', 1, '1000.00', 160),
(6687, '172.28.27.147', 1, '1000.00', 160),
(6688, '172.28.27.148', 1, '1000.00', 160),
(6689, '172.28.27.149', 1, '1000.00', 160),
(6690, '172.28.27.150', 1, '1000.00', 160),
(6691, '172.28.27.151', 1, '1000.00', 160),
(6692, '172.28.27.152', 1, '1000.00', 160),
(6693, '172.28.27.153', 1, '1000.00', 160),
(6694, '172.28.27.154', 1, '1000.00', 160),
(6695, '172.28.27.155', 1, '1000.00', 160),
(6696, '172.28.27.156', 1, '1000.00', 160),
(6697, '172.28.27.157', 1, '1000.00', 160),
(6698, '172.28.27.158', 1, '1000.00', 160),
(6699, '172.28.27.159', 1, '1000.00', 160),
(6700, '172.28.27.160', 1, '1000.00', 160),
(6701, '172.28.27.161', 1, '1000.00', 160),
(6702, '172.28.27.162', 1, '1000.00', 160),
(6703, '172.28.27.163', 1, '1000.00', 160),
(6704, '172.28.27.164', 1, '1000.00', 160),
(6705, '172.28.27.165', 1, '1000.00', 160),
(6706, '172.28.27.166', 1, '1000.00', 160),
(6707, '172.28.27.167', 1, '1000.00', 160),
(6708, '172.28.27.168', 1, '1000.00', 160),
(6709, '172.28.27.169', 1, '1000.00', 160),
(6710, '172.28.27.170', 1, '1000.00', 160),
(6711, '172.28.27.171', 1, '1000.00', 160),
(6712, '172.28.27.172', 1, '1000.00', 160),
(6713, '172.28.27.173', 1, '1000.00', 160),
(6714, '172.28.27.174', 1, '1000.00', 160),
(6715, '172.28.27.175', 1, '1000.00', 160),
(6716, '172.28.27.176', 1, '1000.00', 160),
(6717, '172.28.27.177', 1, '1000.00', 160),
(6718, '172.28.27.178', 1, '1000.00', 160),
(6719, '172.28.27.179', 1, '1000.00', 160),
(6720, '172.28.27.180', 1, '1000.00', 160),
(6721, '172.28.27.181', 1, '1000.00', 160),
(6722, '172.28.27.182', 1, '1000.00', 160),
(6723, '172.28.27.183', 1, '1000.00', 160),
(6724, '172.28.27.184', 1, '1000.00', 160),
(6725, '172.28.27.185', 1, '1000.00', 160),
(6726, '172.28.27.186', 1, '1000.00', 160),
(6727, '172.28.27.187', 1, '1000.00', 160),
(6728, '172.28.27.188', 1, '1000.00', 160),
(6729, '172.28.27.189', 1, '1000.00', 160),
(6730, '172.28.27.190', 1, '1000.00', 160),
(6731, '172.28.27.191', 1, '1000.00', 160),
(6732, '172.28.27.192', 1, '1000.00', 160),
(6733, '172.28.27.193', 1, '1000.00', 160),
(6734, '172.28.27.194', 1, '1000.00', 160),
(6735, '172.28.27.195', 1, '1000.00', 160),
(6736, '172.28.27.196', 1, '1000.00', 160),
(6737, '172.28.27.197', 1, '1000.00', 160),
(6738, '172.28.27.198', 1, '1000.00', 160),
(6739, '172.28.27.199', 1, '1000.00', 160),
(6740, '172.28.27.200', 1, '1000.00', 160),
(6741, '172.28.27.201', 1, '1000.00', 160),
(6742, '172.28.27.202', 1, '1000.00', 160),
(6743, '172.28.27.203', 1, '1000.00', 160),
(6744, '172.28.27.204', 1, '1000.00', 160),
(6745, '172.28.27.205', 1, '1000.00', 160),
(6746, '172.28.27.206', 1, '1000.00', 160),
(6747, '172.28.27.207', 1, '1000.00', 160),
(6748, '172.28.27.208', 1, '1000.00', 160),
(6749, '172.28.27.209', 1, '1000.00', 160),
(6750, '172.28.27.210', 1, '1000.00', 160),
(6751, '172.28.27.211', 1, '1000.00', 160),
(6752, '172.28.27.212', 1, '1000.00', 160),
(6753, '172.28.27.213', 1, '1000.00', 160),
(6754, '172.28.27.214', 1, '1000.00', 160),
(6755, '172.28.27.215', 1, '1000.00', 160),
(6756, '172.28.27.216', 1, '1000.00', 160),
(6757, '172.28.27.217', 1, '1000.00', 160),
(6758, '172.28.27.218', 1, '1000.00', 160),
(6759, '172.28.27.219', 1, '1000.00', 160),
(6760, '172.28.27.220', 1, '1000.00', 160),
(6761, '172.28.27.221', 1, '1000.00', 160),
(6762, '172.28.27.222', 1, '1000.00', 160),
(6763, '172.28.27.223', 1, '1000.00', 160),
(6764, '172.28.27.224', 1, '1000.00', 160),
(6765, '172.28.27.225', 1, '1000.00', 160),
(6766, '172.28.27.226', 1, '1000.00', 160),
(6767, '172.28.27.227', 1, '1000.00', 160),
(6768, '172.28.27.228', 1, '1000.00', 160),
(6769, '172.28.27.229', 1, '1000.00', 160),
(6770, '172.28.27.230', 1, '1000.00', 160),
(6771, '172.28.27.231', 1, '1000.00', 160),
(6772, '172.28.27.232', 1, '1000.00', 160),
(6773, '172.28.27.233', 1, '1000.00', 160),
(6774, '172.28.27.234', 1, '1000.00', 160),
(6775, '172.28.27.235', 1, '1000.00', 160),
(6776, '172.28.27.236', 1, '1000.00', 160),
(6777, '172.28.27.237', 1, '1000.00', 160),
(6778, '172.28.27.238', 1, '1000.00', 160),
(6779, '172.28.27.239', 1, '1000.00', 160),
(6780, '172.28.27.240', 1, '1000.00', 160),
(6781, '172.28.27.241', 1, '1000.00', 160),
(6782, '172.28.27.242', 1, '1000.00', 160),
(6783, '172.28.27.243', 1, '1000.00', 160),
(6784, '172.28.27.244', 1, '1000.00', 160),
(6785, '172.28.27.245', 1, '1000.00', 160),
(6786, '172.28.27.246', 1, '1000.00', 160),
(6787, '172.28.27.247', 1, '1000.00', 160),
(6788, '172.28.27.248', 1, '1000.00', 160),
(6789, '172.28.27.249', 1, '1000.00', 160),
(6790, '172.28.27.250', 1, '1000.00', 160),
(6791, '172.28.27.251', 1, '1000.00', 160),
(6792, '172.28.27.252', 1, '1000.00', 160),
(6793, '172.28.27.253', 1, '1000.00', 160),
(6794, '172.28.27.254', 1, '1000.00', 160),
(6795, '172.28.22.1', 1, '1000.00', 161),
(6796, '172.28.22.2', 1, '1000.00', 161),
(6797, '172.28.22.3', 1, '1000.00', 161),
(6798, '172.28.22.4', 1, '1000.00', 161),
(6799, '172.28.22.5', 1, '1000.00', 161),
(6800, '172.28.22.6', 1, '1000.00', 161),
(6801, '172.28.22.7', 1, '1000.00', 161),
(6802, '172.28.22.8', 1, '1000.00', 161),
(6803, '172.28.22.9', 1, '1000.00', 161),
(6804, '172.28.22.10', 1, '1000.00', 161),
(6805, '172.28.22.11', 1, '1000.00', 161),
(6806, '172.28.22.12', 1, '1000.00', 161),
(6807, '172.28.22.13', 1, '1000.00', 161),
(6808, '172.28.22.14', 1, '1000.00', 161),
(6809, '172.28.22.15', 1, '1000.00', 161),
(6810, '172.28.22.16', 1, '1000.00', 161),
(6811, '172.28.22.17', 1, '1000.00', 161),
(6812, '172.28.22.18', 1, '1000.00', 161),
(6813, '172.28.22.19', 1, '1000.00', 161),
(6814, '172.28.22.20', 1, '1000.00', 161),
(6815, '172.28.22.21', 1, '1000.00', 161),
(6816, '172.28.22.22', 1, '1000.00', 161),
(6817, '172.28.22.23', 1, '1000.00', 161),
(6818, '172.28.22.24', 1, '1000.00', 161),
(6819, '172.28.22.25', 1, '1000.00', 161),
(6820, '172.28.22.26', 1, '1000.00', 161),
(6821, '172.28.22.27', 1, '1000.00', 161),
(6822, '172.28.22.28', 1, '1000.00', 161),
(6823, '172.28.22.29', 1, '1000.00', 161),
(6824, '172.28.22.30', 1, '1000.00', 161),
(6825, '172.28.22.31', 1, '1000.00', 161),
(6826, '172.28.22.32', 1, '1000.00', 161),
(6827, '172.28.22.33', 1, '1000.00', 161),
(6828, '172.28.22.34', 1, '1000.00', 161),
(6829, '172.28.22.35', 1, '1000.00', 161),
(6830, '172.28.22.36', 1, '1000.00', 161),
(6831, '172.28.22.37', 1, '1000.00', 161),
(6832, '172.28.22.38', 1, '1000.00', 161),
(6833, '172.28.22.39', 1, '1000.00', 161),
(6834, '172.28.22.40', 1, '1000.00', 161),
(6835, '172.28.22.41', 1, '1000.00', 161),
(6836, '172.28.22.42', 1, '1000.00', 161),
(6837, '172.28.22.43', 1, '1000.00', 161),
(6838, '172.28.22.44', 1, '1000.00', 161),
(6839, '172.28.22.45', 1, '1000.00', 161),
(6840, '172.28.22.46', 1, '1000.00', 161),
(6841, '172.28.22.47', 1, '1000.00', 161),
(6842, '172.28.22.48', 1, '1000.00', 161),
(6843, '172.28.22.49', 1, '1000.00', 161),
(6844, '172.28.22.50', 1, '1000.00', 161),
(6845, '172.28.22.51', 1, '1000.00', 161),
(6846, '172.28.22.52', 1, '1000.00', 161),
(6847, '172.28.22.53', 1, '1000.00', 161),
(6848, '172.28.22.54', 1, '1000.00', 161),
(6849, '172.28.22.55', 1, '1000.00', 161),
(6850, '172.28.22.56', 1, '1000.00', 161),
(6851, '172.28.22.57', 1, '1000.00', 161),
(6852, '172.28.22.58', 1, '1000.00', 161),
(6853, '172.28.22.59', 1, '1000.00', 161),
(6854, '172.28.22.60', 1, '1000.00', 161),
(6855, '172.28.22.61', 1, '1000.00', 161),
(6856, '172.28.22.62', 1, '1000.00', 161),
(6857, '172.28.22.63', 1, '1000.00', 161),
(6858, '172.28.22.64', 1, '1000.00', 161),
(6859, '172.28.22.65', 1, '1000.00', 161),
(6860, '172.28.22.66', 1, '1000.00', 161),
(6861, '172.28.22.67', 1, '1000.00', 161),
(6862, '172.28.22.68', 1, '1000.00', 161),
(6863, '172.28.22.69', 1, '1000.00', 161),
(6864, '172.28.22.70', 1, '1000.00', 161),
(6865, '172.28.22.71', 1, '1000.00', 161),
(6866, '172.28.22.72', 1, '1000.00', 161),
(6867, '172.28.22.73', 1, '1000.00', 161),
(6868, '172.28.22.74', 1, '1000.00', 161),
(6869, '172.28.22.75', 1, '1000.00', 161),
(6870, '172.28.22.76', 1, '1000.00', 161),
(6871, '172.28.22.77', 1, '1000.00', 161),
(6872, '172.28.22.78', 1, '1000.00', 161),
(6873, '172.28.22.79', 1, '1000.00', 161),
(6874, '172.28.22.80', 1, '1000.00', 161),
(6875, '172.28.22.81', 1, '1000.00', 161),
(6876, '172.28.22.82', 1, '1000.00', 161),
(6877, '172.28.22.83', 1, '1000.00', 161),
(6878, '172.28.22.84', 1, '1000.00', 161),
(6879, '172.28.22.85', 1, '1000.00', 161),
(6880, '172.28.22.86', 1, '1000.00', 161),
(6881, '172.28.22.87', 1, '1000.00', 161),
(6882, '172.28.22.88', 1, '1000.00', 161),
(6883, '172.28.22.89', 1, '1000.00', 161),
(6884, '172.28.22.90', 1, '1000.00', 161),
(6885, '172.28.22.91', 1, '1000.00', 161),
(6886, '172.28.22.92', 1, '1000.00', 161),
(6887, '172.28.22.93', 1, '1000.00', 161),
(6888, '172.28.22.94', 1, '1000.00', 161),
(6889, '172.28.22.95', 1, '1000.00', 161),
(6890, '172.28.22.96', 1, '1000.00', 161),
(6891, '172.28.22.97', 1, '1000.00', 161),
(6892, '172.28.22.98', 1, '1000.00', 161),
(6893, '172.28.22.99', 1, '1000.00', 161),
(6894, '172.28.22.100', 1, '1000.00', 161),
(6895, '172.28.22.101', 1, '1000.00', 161),
(6896, '172.28.22.102', 1, '1000.00', 161),
(6897, '172.28.22.103', 1, '1000.00', 161),
(6898, '172.28.22.104', 1, '1000.00', 161),
(6899, '172.28.22.105', 1, '1000.00', 161),
(6900, '172.28.22.106', 1, '1000.00', 161),
(6901, '172.28.22.107', 1, '1000.00', 161),
(6902, '172.28.22.108', 1, '1000.00', 161),
(6903, '172.28.22.109', 1, '1000.00', 161),
(6904, '172.28.22.110', 1, '1000.00', 161),
(6905, '172.28.22.111', 1, '1000.00', 161),
(6906, '172.28.22.112', 1, '1000.00', 161),
(6907, '172.28.22.113', 1, '1000.00', 161),
(6908, '172.28.22.114', 1, '1000.00', 161),
(6909, '172.28.22.115', 1, '1000.00', 161),
(6910, '172.28.22.116', 1, '1000.00', 161),
(6911, '172.28.22.117', 1, '1000.00', 161),
(6912, '172.28.22.118', 1, '1000.00', 161),
(6913, '172.28.22.119', 1, '1000.00', 161),
(6914, '172.28.22.120', 1, '1000.00', 161),
(6915, '172.28.22.121', 1, '1000.00', 161),
(6916, '172.28.22.122', 1, '1000.00', 161),
(6917, '172.28.22.123', 1, '1000.00', 161),
(6918, '172.28.22.124', 1, '1000.00', 161),
(6919, '172.28.22.125', 1, '1000.00', 161),
(6920, '172.28.22.126', 1, '1000.00', 161),
(6921, '172.28.22.127', 1, '1000.00', 161),
(6922, '172.28.22.128', 1, '1000.00', 161),
(6923, '172.28.22.129', 1, '1000.00', 161),
(6924, '172.28.22.130', 1, '1000.00', 161),
(6925, '172.28.22.131', 1, '1000.00', 161),
(6926, '172.28.22.132', 1, '1000.00', 161),
(6927, '172.28.22.133', 1, '1000.00', 161),
(6928, '172.28.22.134', 1, '1000.00', 161),
(6929, '172.28.22.135', 1, '1000.00', 161),
(6930, '172.28.22.136', 1, '1000.00', 161),
(6931, '172.28.22.137', 1, '1000.00', 161),
(6932, '172.28.22.138', 1, '1000.00', 161);
INSERT INTO `ip_addresses` (`id`, `address`, `status`, `price`, `base_id`) VALUES
(6933, '172.28.22.139', 1, '1000.00', 161),
(6934, '172.28.22.140', 1, '1000.00', 161),
(6935, '172.28.22.141', 1, '1000.00', 161),
(6936, '172.28.22.142', 1, '1000.00', 161),
(6937, '172.28.22.143', 1, '1000.00', 161),
(6938, '172.28.22.144', 1, '1000.00', 161),
(6939, '172.28.22.145', 1, '1000.00', 161),
(6940, '172.28.22.146', 1, '1000.00', 161),
(6941, '172.28.22.147', 1, '1000.00', 161),
(6942, '172.28.22.148', 1, '1000.00', 161),
(6943, '172.28.22.149', 1, '1000.00', 161),
(6944, '172.28.22.150', 1, '1000.00', 161),
(6945, '172.28.22.151', 1, '1000.00', 161),
(6946, '172.28.22.152', 1, '1000.00', 161),
(6947, '172.28.22.153', 1, '1000.00', 161),
(6948, '172.28.22.154', 1, '1000.00', 161),
(6949, '172.28.22.155', 1, '1000.00', 161),
(6950, '172.28.22.156', 1, '1000.00', 161),
(6951, '172.28.22.157', 1, '1000.00', 161),
(6952, '172.28.22.158', 1, '1000.00', 161),
(6953, '172.28.22.159', 1, '1000.00', 161),
(6954, '172.28.22.160', 1, '1000.00', 161),
(6955, '172.28.22.161', 1, '1000.00', 161),
(6956, '172.28.22.162', 1, '1000.00', 161),
(6957, '172.28.22.163', 1, '1000.00', 161),
(6958, '172.28.22.164', 1, '1000.00', 161),
(6959, '172.28.22.165', 1, '1000.00', 161),
(6960, '172.28.22.166', 1, '1000.00', 161),
(6961, '172.28.22.167', 1, '1000.00', 161),
(6962, '172.28.22.168', 1, '1000.00', 161),
(6963, '172.28.22.169', 1, '1000.00', 161),
(6964, '172.28.22.170', 1, '1000.00', 161),
(6965, '172.28.22.171', 1, '1000.00', 161),
(6966, '172.28.22.172', 1, '1000.00', 161),
(6967, '172.28.22.173', 1, '1000.00', 161),
(6968, '172.28.22.174', 1, '1000.00', 161),
(6969, '172.28.22.175', 1, '1000.00', 161),
(6970, '172.28.22.176', 1, '1000.00', 161),
(6971, '172.28.22.177', 1, '1000.00', 161),
(6972, '172.28.22.178', 1, '1000.00', 161),
(6973, '172.28.22.179', 1, '1000.00', 161),
(6974, '172.28.22.180', 1, '1000.00', 161),
(6975, '172.28.22.181', 1, '1000.00', 161),
(6976, '172.28.22.182', 1, '1000.00', 161),
(6977, '172.28.22.183', 1, '1000.00', 161),
(6978, '172.28.22.184', 1, '1000.00', 161),
(6979, '172.28.22.185', 1, '1000.00', 161),
(6980, '172.28.22.186', 1, '1000.00', 161),
(6981, '172.28.22.187', 1, '1000.00', 161),
(6982, '172.28.22.188', 1, '1000.00', 161),
(6983, '172.28.22.189', 1, '1000.00', 161),
(6984, '172.28.22.190', 1, '1000.00', 161),
(6985, '172.28.22.191', 1, '1000.00', 161),
(6986, '172.28.22.192', 1, '1000.00', 161),
(6987, '172.28.22.193', 1, '1000.00', 161),
(6988, '172.28.22.194', 1, '1000.00', 161),
(6989, '172.28.22.195', 1, '1000.00', 161),
(6990, '172.28.22.196', 1, '1000.00', 161),
(6991, '172.28.22.197', 1, '1000.00', 161),
(6992, '172.28.22.198', 1, '1000.00', 161),
(6993, '172.28.22.199', 1, '1000.00', 161),
(6994, '172.28.22.200', 1, '1000.00', 161),
(6995, '172.28.22.201', 1, '1000.00', 161),
(6996, '172.28.22.202', 1, '1000.00', 161),
(6997, '172.28.22.203', 1, '1000.00', 161),
(6998, '172.28.22.204', 1, '1000.00', 161),
(6999, '172.28.22.205', 1, '1000.00', 161),
(7000, '172.28.22.206', 1, '1000.00', 161),
(7001, '172.28.22.207', 1, '1000.00', 161),
(7002, '172.28.22.208', 1, '1000.00', 161),
(7003, '172.28.22.209', 1, '1000.00', 161),
(7004, '172.28.22.210', 1, '1000.00', 161),
(7005, '172.28.22.211', 1, '1000.00', 161),
(7006, '172.28.22.212', 1, '1000.00', 161),
(7007, '172.28.22.213', 1, '1000.00', 161),
(7008, '172.28.22.214', 1, '1000.00', 161),
(7009, '172.28.22.215', 1, '1000.00', 161),
(7010, '172.28.22.216', 1, '1000.00', 161),
(7011, '172.28.22.217', 1, '1000.00', 161),
(7012, '172.28.22.218', 1, '1000.00', 161),
(7013, '172.28.22.219', 1, '1000.00', 161),
(7014, '172.28.22.220', 1, '1000.00', 161),
(7015, '172.28.22.221', 1, '1000.00', 161),
(7016, '172.28.22.222', 1, '1000.00', 161),
(7017, '172.28.22.223', 1, '1000.00', 161),
(7018, '172.28.22.224', 1, '1000.00', 161),
(7019, '172.28.22.225', 1, '1000.00', 161),
(7020, '172.28.22.226', 1, '1000.00', 161),
(7021, '172.28.22.227', 1, '1000.00', 161),
(7022, '172.28.22.228', 1, '1000.00', 161),
(7023, '172.28.22.229', 1, '1000.00', 161),
(7024, '172.28.22.230', 1, '1000.00', 161),
(7025, '172.28.22.231', 1, '1000.00', 161),
(7026, '172.28.22.232', 1, '1000.00', 161),
(7027, '172.28.22.233', 1, '1000.00', 161),
(7028, '172.28.22.234', 1, '1000.00', 161),
(7029, '172.28.22.235', 1, '1000.00', 161),
(7030, '172.28.22.236', 1, '1000.00', 161),
(7031, '172.28.22.237', 1, '1000.00', 161),
(7032, '172.28.22.238', 1, '1000.00', 161),
(7033, '172.28.22.239', 1, '1000.00', 161),
(7034, '172.28.22.240', 1, '1000.00', 161),
(7035, '172.28.22.241', 1, '1000.00', 161),
(7036, '172.28.22.242', 1, '1000.00', 161),
(7037, '172.28.22.243', 1, '1000.00', 161),
(7038, '172.28.22.244', 1, '1000.00', 161),
(7039, '172.28.22.245', 1, '1000.00', 161),
(7040, '172.28.22.246', 1, '1000.00', 161),
(7041, '172.28.22.247', 1, '1000.00', 161),
(7042, '172.28.22.248', 1, '1000.00', 161),
(7043, '172.28.22.249', 1, '1000.00', 161),
(7044, '172.28.22.250', 1, '1000.00', 161),
(7045, '172.28.22.251', 1, '1000.00', 161),
(7046, '172.28.22.252', 1, '1000.00', 161),
(7047, '172.28.22.253', 1, '1000.00', 161),
(7048, '172.28.22.254', 1, '1000.00', 161),
(7049, '10.51.218.1', 1, '1000.00', 162),
(7050, '10.51.218.2', 1, '1000.00', 162),
(7051, '10.51.218.3', 1, '1000.00', 162),
(7052, '10.51.218.4', 1, '1000.00', 162),
(7053, '10.51.218.5', 1, '1000.00', 162),
(7054, '10.51.218.6', 1, '1000.00', 162),
(7055, '10.51.218.7', 1, '1000.00', 162),
(7056, '10.51.218.8', 1, '1000.00', 162),
(7057, '10.51.218.9', 1, '1000.00', 162),
(7058, '10.51.218.10', 1, '1000.00', 162),
(7059, '10.51.218.11', 1, '1000.00', 162),
(7060, '10.51.218.12', 1, '1000.00', 162),
(7061, '10.51.218.13', 1, '1000.00', 162),
(7062, '10.51.218.14', 1, '1000.00', 162),
(7063, '10.51.218.15', 1, '1000.00', 162),
(7064, '10.51.218.16', 1, '1000.00', 162),
(7065, '10.51.218.17', 1, '1000.00', 162),
(7066, '10.51.218.18', 1, '1000.00', 162),
(7067, '10.51.218.19', 1, '1000.00', 162),
(7068, '10.51.218.20', 1, '1000.00', 162),
(7069, '10.51.218.21', 1, '1000.00', 162),
(7070, '10.51.218.22', 1, '1000.00', 162),
(7071, '10.51.218.23', 1, '1000.00', 162),
(7072, '10.51.218.24', 1, '1000.00', 162),
(7073, '10.51.218.25', 1, '1000.00', 162),
(7074, '10.51.218.26', 1, '1000.00', 162),
(7075, '10.51.218.27', 1, '1000.00', 162),
(7076, '10.51.218.28', 1, '1000.00', 162),
(7077, '10.51.218.29', 1, '1000.00', 162),
(7078, '10.51.218.30', 1, '1000.00', 162),
(7079, '10.51.218.31', 1, '1000.00', 162),
(7080, '10.51.218.32', 1, '1000.00', 162),
(7081, '10.51.218.33', 1, '1000.00', 162),
(7082, '10.51.218.34', 1, '1000.00', 162),
(7083, '10.51.218.35', 1, '1000.00', 162),
(7084, '10.51.218.36', 1, '1000.00', 162),
(7085, '10.51.218.37', 1, '1000.00', 162),
(7086, '10.51.218.38', 1, '1000.00', 162),
(7087, '10.51.218.39', 1, '1000.00', 162),
(7088, '10.51.218.40', 1, '1000.00', 162),
(7089, '10.51.218.41', 1, '1000.00', 162),
(7090, '10.51.218.42', 1, '1000.00', 162),
(7091, '10.51.218.43', 1, '1000.00', 162),
(7092, '10.51.218.44', 1, '1000.00', 162),
(7093, '10.51.218.45', 1, '1000.00', 162),
(7094, '10.51.218.46', 1, '1000.00', 162),
(7095, '10.51.218.47', 1, '1000.00', 162),
(7096, '10.51.218.48', 1, '1000.00', 162),
(7097, '10.51.218.49', 1, '1000.00', 162),
(7098, '10.51.218.50', 1, '1000.00', 162),
(7099, '10.51.218.51', 1, '1000.00', 162),
(7100, '10.51.218.52', 1, '1000.00', 162),
(7101, '10.51.218.53', 1, '1000.00', 162),
(7102, '10.51.218.54', 1, '1000.00', 162),
(7103, '10.51.218.55', 1, '1000.00', 162),
(7104, '10.51.218.56', 1, '1000.00', 162),
(7105, '10.51.218.57', 1, '1000.00', 162),
(7106, '10.51.218.58', 1, '1000.00', 162),
(7107, '10.51.218.59', 1, '1000.00', 162),
(7108, '10.51.218.60', 1, '1000.00', 162),
(7109, '10.51.218.61', 1, '1000.00', 162),
(7110, '10.51.218.62', 1, '1000.00', 162),
(7111, '10.51.218.63', 1, '1000.00', 162),
(7112, '10.51.218.64', 1, '1000.00', 162),
(7113, '10.51.218.65', 1, '1000.00', 162),
(7114, '10.51.218.66', 1, '1000.00', 162),
(7115, '10.51.218.67', 1, '1000.00', 162),
(7116, '10.51.218.68', 1, '1000.00', 162),
(7117, '10.51.218.69', 1, '1000.00', 162),
(7118, '10.51.218.70', 1, '1000.00', 162),
(7119, '10.51.218.71', 1, '1000.00', 162),
(7120, '10.51.218.72', 1, '1000.00', 162),
(7121, '10.51.218.73', 1, '1000.00', 162),
(7122, '10.51.218.74', 1, '1000.00', 162),
(7123, '10.51.218.75', 1, '1000.00', 162),
(7124, '10.51.218.76', 1, '1000.00', 162),
(7125, '10.51.218.77', 1, '1000.00', 162),
(7126, '10.51.218.78', 1, '1000.00', 162),
(7127, '10.51.218.79', 1, '1000.00', 162),
(7128, '10.51.218.80', 1, '1000.00', 162),
(7129, '10.51.218.81', 1, '1000.00', 162),
(7130, '10.51.218.82', 1, '1000.00', 162),
(7131, '10.51.218.83', 1, '1000.00', 162),
(7132, '10.51.218.84', 1, '1000.00', 162),
(7133, '10.51.218.85', 1, '1000.00', 162),
(7134, '10.51.218.86', 1, '1000.00', 162),
(7135, '10.51.218.87', 1, '1000.00', 162),
(7136, '10.51.218.88', 1, '1000.00', 162),
(7137, '10.51.218.89', 1, '1000.00', 162),
(7138, '10.51.218.90', 1, '1000.00', 162),
(7139, '10.51.218.91', 1, '1000.00', 162),
(7140, '10.51.218.92', 1, '1000.00', 162),
(7141, '10.51.218.93', 1, '1000.00', 162),
(7142, '10.51.218.94', 1, '1000.00', 162),
(7143, '10.51.218.95', 1, '1000.00', 162),
(7144, '10.51.218.96', 1, '1000.00', 162),
(7145, '10.51.218.97', 1, '1000.00', 162),
(7146, '10.51.218.98', 1, '1000.00', 162),
(7147, '10.51.218.99', 1, '1000.00', 162),
(7148, '10.51.218.100', 1, '1000.00', 162),
(7149, '10.51.218.101', 1, '1000.00', 162),
(7150, '10.51.218.102', 1, '1000.00', 162),
(7151, '10.51.218.103', 1, '1000.00', 162),
(7152, '10.51.218.104', 1, '1000.00', 162),
(7153, '10.51.218.105', 1, '1000.00', 162),
(7154, '10.51.218.106', 1, '1000.00', 162),
(7155, '10.51.218.107', 1, '1000.00', 162),
(7156, '10.51.218.108', 1, '1000.00', 162),
(7157, '10.51.218.109', 1, '1000.00', 162),
(7158, '10.51.218.110', 1, '1000.00', 162),
(7159, '10.51.218.111', 1, '1000.00', 162),
(7160, '10.51.218.112', 1, '1000.00', 162),
(7161, '10.51.218.113', 1, '1000.00', 162),
(7162, '10.51.218.114', 1, '1000.00', 162),
(7163, '10.51.218.115', 1, '1000.00', 162),
(7164, '10.51.218.116', 1, '1000.00', 162),
(7165, '10.51.218.117', 1, '1000.00', 162),
(7166, '10.51.218.118', 1, '1000.00', 162),
(7167, '10.51.218.119', 1, '1000.00', 162),
(7168, '10.51.218.120', 1, '1000.00', 162),
(7169, '10.51.218.121', 1, '1000.00', 162),
(7170, '10.51.218.122', 1, '1000.00', 162),
(7171, '10.51.218.123', 1, '1000.00', 162),
(7172, '10.51.218.124', 1, '1000.00', 162),
(7173, '10.51.218.125', 1, '1000.00', 162),
(7174, '10.51.218.126', 1, '1000.00', 162),
(7175, '10.51.218.127', 1, '1000.00', 162),
(7176, '10.51.218.128', 1, '1000.00', 162),
(7177, '10.51.218.129', 1, '1000.00', 162),
(7178, '10.51.218.130', 1, '1000.00', 162),
(7179, '10.51.218.131', 1, '1000.00', 162),
(7180, '10.51.218.132', 1, '1000.00', 162),
(7181, '10.51.218.133', 1, '1000.00', 162),
(7182, '10.51.218.134', 1, '1000.00', 162),
(7183, '10.51.218.135', 1, '1000.00', 162),
(7184, '10.51.218.136', 1, '1000.00', 162),
(7185, '10.51.218.137', 1, '1000.00', 162),
(7186, '10.51.218.138', 1, '1000.00', 162),
(7187, '10.51.218.139', 1, '1000.00', 162),
(7188, '10.51.218.140', 1, '1000.00', 162),
(7189, '10.51.218.141', 1, '1000.00', 162),
(7190, '10.51.218.142', 1, '1000.00', 162),
(7191, '10.51.218.143', 1, '1000.00', 162),
(7192, '10.51.218.144', 1, '1000.00', 162),
(7193, '10.51.218.145', 1, '1000.00', 162),
(7194, '10.51.218.146', 1, '1000.00', 162),
(7195, '10.51.218.147', 1, '1000.00', 162),
(7196, '10.51.218.148', 1, '1000.00', 162),
(7197, '10.51.218.149', 1, '1000.00', 162),
(7198, '10.51.218.150', 1, '1000.00', 162),
(7199, '10.51.218.151', 1, '1000.00', 162),
(7200, '10.51.218.152', 1, '1000.00', 162),
(7201, '10.51.218.153', 1, '1000.00', 162),
(7202, '10.51.218.154', 1, '1000.00', 162),
(7203, '10.51.218.155', 1, '1000.00', 162),
(7204, '10.51.218.156', 1, '1000.00', 162),
(7205, '10.51.218.157', 1, '1000.00', 162),
(7206, '10.51.218.158', 1, '1000.00', 162),
(7207, '10.51.218.159', 1, '1000.00', 162),
(7208, '10.51.218.160', 1, '1000.00', 162),
(7209, '10.51.218.161', 1, '1000.00', 162),
(7210, '10.51.218.162', 1, '1000.00', 162),
(7211, '10.51.218.163', 1, '1000.00', 162),
(7212, '10.51.218.164', 1, '1000.00', 162),
(7213, '10.51.218.165', 1, '1000.00', 162),
(7214, '10.51.218.166', 1, '1000.00', 162),
(7215, '10.51.218.167', 1, '1000.00', 162),
(7216, '10.51.218.168', 1, '1000.00', 162),
(7217, '10.51.218.169', 1, '1000.00', 162),
(7218, '10.51.218.170', 1, '1000.00', 162),
(7219, '10.51.218.171', 1, '1000.00', 162),
(7220, '10.51.218.172', 1, '1000.00', 162),
(7221, '10.51.218.173', 1, '1000.00', 162),
(7222, '10.51.218.174', 1, '1000.00', 162),
(7223, '10.51.218.175', 1, '1000.00', 162),
(7224, '10.51.218.176', 1, '1000.00', 162),
(7225, '10.51.218.177', 1, '1000.00', 162),
(7226, '10.51.218.178', 1, '1000.00', 162),
(7227, '10.51.218.179', 1, '1000.00', 162),
(7228, '10.51.218.180', 1, '1000.00', 162),
(7229, '10.51.218.181', 1, '1000.00', 162),
(7230, '10.51.218.182', 1, '1000.00', 162),
(7231, '10.51.218.183', 1, '1000.00', 162),
(7232, '10.51.218.184', 1, '1000.00', 162),
(7233, '10.51.218.185', 1, '1000.00', 162),
(7234, '10.51.218.186', 1, '1000.00', 162),
(7235, '10.51.218.187', 1, '1000.00', 162),
(7236, '10.51.218.188', 1, '1000.00', 162),
(7237, '10.51.218.189', 1, '1000.00', 162),
(7238, '10.51.218.190', 1, '1000.00', 162),
(7239, '10.51.218.191', 1, '1000.00', 162),
(7240, '10.51.218.192', 1, '1000.00', 162),
(7241, '10.51.218.193', 1, '1000.00', 162),
(7242, '10.51.218.194', 1, '1000.00', 162),
(7243, '10.51.218.195', 1, '1000.00', 162),
(7244, '10.51.218.196', 1, '1000.00', 162),
(7245, '10.51.218.197', 1, '1000.00', 162),
(7246, '10.51.218.198', 1, '1000.00', 162),
(7247, '10.51.218.199', 1, '1000.00', 162),
(7248, '10.51.218.200', 1, '1000.00', 162),
(7249, '10.51.218.201', 1, '1000.00', 162),
(7250, '10.51.218.202', 1, '1000.00', 162),
(7251, '10.51.218.203', 1, '1000.00', 162),
(7252, '10.51.218.204', 1, '1000.00', 162),
(7253, '10.51.218.205', 1, '1000.00', 162),
(7254, '10.51.218.206', 1, '1000.00', 162),
(7255, '10.51.218.207', 1, '1000.00', 162),
(7256, '10.51.218.208', 1, '1000.00', 162),
(7257, '10.51.218.209', 1, '1000.00', 162),
(7258, '10.51.218.210', 1, '1000.00', 162),
(7259, '10.51.218.211', 1, '1000.00', 162),
(7260, '10.51.218.212', 1, '1000.00', 162),
(7261, '10.51.218.213', 1, '1000.00', 162),
(7262, '10.51.218.214', 1, '1000.00', 162),
(7263, '10.51.218.215', 1, '1000.00', 162),
(7264, '10.51.218.216', 1, '1000.00', 162),
(7265, '10.51.218.217', 1, '1000.00', 162),
(7266, '10.51.218.218', 1, '1000.00', 162),
(7267, '10.51.218.219', 1, '1000.00', 162),
(7268, '10.51.218.220', 1, '1000.00', 162),
(7269, '10.51.218.221', 1, '1000.00', 162),
(7270, '10.51.218.222', 1, '1000.00', 162),
(7271, '10.51.218.223', 1, '1000.00', 162),
(7272, '10.51.218.224', 1, '1000.00', 162),
(7273, '10.51.218.225', 1, '1000.00', 162),
(7274, '10.51.218.226', 1, '1000.00', 162),
(7275, '10.51.218.227', 1, '1000.00', 162),
(7276, '10.51.218.228', 1, '1000.00', 162),
(7277, '10.51.218.229', 1, '1000.00', 162),
(7278, '10.51.218.230', 1, '1000.00', 162),
(7279, '10.51.218.231', 1, '1000.00', 162),
(7280, '10.51.218.232', 1, '1000.00', 162),
(7281, '10.51.218.233', 1, '1000.00', 162),
(7282, '10.51.218.234', 1, '1000.00', 162),
(7283, '10.51.218.235', 1, '1000.00', 162),
(7284, '10.51.218.236', 1, '1000.00', 162),
(7285, '10.51.218.237', 1, '1000.00', 162),
(7286, '10.51.218.238', 1, '1000.00', 162),
(7287, '10.51.218.239', 1, '1000.00', 162),
(7288, '10.51.218.240', 1, '1000.00', 162),
(7289, '10.51.218.241', 1, '1000.00', 162),
(7290, '10.51.218.242', 1, '1000.00', 162),
(7291, '10.51.218.243', 1, '1000.00', 162),
(7292, '10.51.218.244', 1, '1000.00', 162),
(7293, '10.51.218.245', 1, '1000.00', 162),
(7294, '10.51.218.246', 1, '1000.00', 162),
(7295, '10.51.218.247', 1, '1000.00', 162),
(7296, '10.51.218.248', 1, '1000.00', 162),
(7297, '10.51.218.249', 1, '1000.00', 162),
(7298, '10.51.218.250', 1, '1000.00', 162),
(7299, '10.51.218.251', 1, '1000.00', 162),
(7300, '10.51.218.252', 1, '1000.00', 162),
(7301, '10.51.218.253', 1, '1000.00', 162),
(7302, '10.51.218.254', 1, '1000.00', 162),
(7303, '172.28.35.1', 1, '1000.00', 164),
(7304, '172.28.35.2', 1, '1000.00', 164),
(7305, '172.28.35.3', 1, '1000.00', 164),
(7306, '172.28.35.4', 1, '1000.00', 164),
(7307, '172.28.35.5', 1, '1000.00', 164),
(7308, '172.28.35.6', 1, '1000.00', 164),
(7309, '172.28.35.7', 1, '1000.00', 164),
(7310, '172.28.35.8', 1, '1000.00', 164),
(7311, '172.28.35.9', 1, '1000.00', 164),
(7312, '172.28.35.10', 1, '1000.00', 164),
(7313, '172.28.35.11', 1, '1000.00', 164),
(7314, '172.28.35.12', 1, '1000.00', 164),
(7315, '172.28.35.13', 1, '1000.00', 164),
(7316, '172.28.35.14', 1, '1000.00', 164),
(7317, '172.28.35.15', 1, '1000.00', 164),
(7318, '172.28.35.16', 1, '1000.00', 164),
(7319, '172.28.35.17', 1, '1000.00', 164),
(7320, '172.28.35.18', 1, '1000.00', 164),
(7321, '172.28.35.19', 1, '1000.00', 164),
(7322, '172.28.35.20', 1, '1000.00', 164),
(7323, '172.28.35.21', 1, '1000.00', 164),
(7324, '172.28.35.22', 1, '1000.00', 164),
(7325, '172.28.35.23', 1, '1000.00', 164),
(7326, '172.28.35.24', 1, '1000.00', 164),
(7327, '172.28.35.25', 1, '1000.00', 164),
(7328, '172.28.35.26', 1, '1000.00', 164),
(7329, '172.28.35.27', 1, '1000.00', 164),
(7330, '172.28.35.28', 1, '1000.00', 164),
(7331, '172.28.35.29', 1, '1000.00', 164),
(7332, '172.28.35.30', 1, '1000.00', 164),
(7333, '172.28.35.31', 1, '1000.00', 164),
(7334, '172.28.35.32', 1, '1000.00', 164),
(7335, '172.28.35.33', 1, '1000.00', 164),
(7336, '172.28.35.34', 1, '1000.00', 164),
(7337, '172.28.35.35', 1, '1000.00', 164),
(7338, '172.28.35.36', 1, '1000.00', 164),
(7339, '172.28.35.37', 1, '1000.00', 164),
(7340, '172.28.35.38', 1, '1000.00', 164),
(7341, '172.28.35.39', 1, '1000.00', 164),
(7342, '172.28.35.40', 1, '1000.00', 164),
(7343, '172.28.35.41', 1, '1000.00', 164),
(7344, '172.28.35.42', 1, '1000.00', 164),
(7345, '172.28.35.43', 1, '1000.00', 164),
(7346, '172.28.35.44', 1, '1000.00', 164),
(7347, '172.28.35.45', 1, '1000.00', 164),
(7348, '172.28.35.46', 1, '1000.00', 164),
(7349, '172.28.35.47', 1, '1000.00', 164),
(7350, '172.28.35.48', 1, '1000.00', 164),
(7351, '172.28.35.49', 1, '1000.00', 164),
(7352, '172.28.35.50', 1, '1000.00', 164),
(7353, '172.28.35.51', 1, '1000.00', 164),
(7354, '172.28.35.52', 1, '1000.00', 164),
(7355, '172.28.35.53', 1, '1000.00', 164),
(7356, '172.28.35.54', 1, '1000.00', 164),
(7357, '172.28.35.55', 1, '1000.00', 164),
(7358, '172.28.35.56', 1, '1000.00', 164),
(7359, '172.28.35.57', 1, '1000.00', 164),
(7360, '172.28.35.58', 1, '1000.00', 164),
(7361, '172.28.35.59', 1, '1000.00', 164),
(7362, '172.28.35.60', 1, '1000.00', 164),
(7363, '172.28.35.61', 1, '1000.00', 164),
(7364, '172.28.35.62', 1, '1000.00', 164),
(7365, '172.28.35.63', 1, '1000.00', 164),
(7366, '172.28.35.64', 1, '1000.00', 164),
(7367, '172.28.35.65', 1, '1000.00', 164),
(7368, '172.28.35.66', 1, '1000.00', 164),
(7369, '172.28.35.67', 1, '1000.00', 164),
(7370, '172.28.35.68', 1, '1000.00', 164),
(7371, '172.28.35.69', 1, '1000.00', 164),
(7372, '172.28.35.70', 1, '1000.00', 164),
(7373, '172.28.35.71', 1, '1000.00', 164),
(7374, '172.28.35.72', 1, '1000.00', 164),
(7375, '172.28.35.73', 1, '1000.00', 164),
(7376, '172.28.35.74', 1, '1000.00', 164),
(7377, '172.28.35.75', 1, '1000.00', 164),
(7378, '172.28.35.76', 1, '1000.00', 164),
(7379, '172.28.35.77', 1, '1000.00', 164),
(7380, '172.28.35.78', 1, '1000.00', 164),
(7381, '172.28.35.79', 1, '1000.00', 164),
(7382, '172.28.35.80', 1, '1000.00', 164),
(7383, '172.28.35.81', 1, '1000.00', 164),
(7384, '172.28.35.82', 1, '1000.00', 164),
(7385, '172.28.35.83', 1, '1000.00', 164),
(7386, '172.28.35.84', 1, '1000.00', 164),
(7387, '172.28.35.85', 1, '1000.00', 164),
(7388, '172.28.35.86', 1, '1000.00', 164),
(7389, '172.28.35.87', 1, '1000.00', 164),
(7390, '172.28.35.88', 1, '1000.00', 164),
(7391, '172.28.35.89', 1, '1000.00', 164),
(7392, '172.28.35.90', 1, '1000.00', 164),
(7393, '172.28.35.91', 1, '1000.00', 164),
(7394, '172.28.35.92', 1, '1000.00', 164),
(7395, '172.28.35.93', 1, '1000.00', 164),
(7396, '172.28.35.94', 1, '1000.00', 164),
(7397, '172.28.35.95', 1, '1000.00', 164),
(7398, '172.28.35.96', 1, '1000.00', 164),
(7399, '172.28.35.97', 1, '1000.00', 164),
(7400, '172.28.35.98', 1, '1000.00', 164),
(7401, '172.28.35.99', 1, '1000.00', 164),
(7402, '172.28.35.100', 1, '1000.00', 164),
(7403, '172.28.35.101', 1, '1000.00', 164),
(7404, '172.28.35.102', 1, '1000.00', 164),
(7405, '172.28.35.103', 1, '1000.00', 164),
(7406, '172.28.35.104', 1, '1000.00', 164),
(7407, '172.28.35.105', 1, '1000.00', 164),
(7408, '172.28.35.106', 1, '1000.00', 164),
(7409, '172.28.35.107', 1, '1000.00', 164),
(7410, '172.28.35.108', 1, '1000.00', 164),
(7411, '172.28.35.109', 1, '1000.00', 164),
(7412, '172.28.35.110', 1, '1000.00', 164),
(7413, '172.28.35.111', 1, '1000.00', 164),
(7414, '172.28.35.112', 1, '1000.00', 164),
(7415, '172.28.35.113', 1, '1000.00', 164),
(7416, '172.28.35.114', 1, '1000.00', 164),
(7417, '172.28.35.115', 1, '1000.00', 164),
(7418, '172.28.35.116', 1, '1000.00', 164),
(7419, '172.28.35.117', 1, '1000.00', 164),
(7420, '172.28.35.118', 1, '1000.00', 164),
(7421, '172.28.35.119', 1, '1000.00', 164),
(7422, '172.28.35.120', 1, '1000.00', 164),
(7423, '172.28.35.121', 1, '1000.00', 164),
(7424, '172.28.35.122', 1, '1000.00', 164),
(7425, '172.28.35.123', 1, '1000.00', 164),
(7426, '172.28.35.124', 1, '1000.00', 164),
(7427, '172.28.35.125', 1, '1000.00', 164),
(7428, '172.28.35.126', 1, '1000.00', 164),
(7429, '172.28.35.127', 1, '1000.00', 164),
(7430, '172.28.35.128', 1, '1000.00', 164),
(7431, '172.28.35.129', 1, '1000.00', 164),
(7432, '172.28.35.130', 1, '1000.00', 164),
(7433, '172.28.35.131', 1, '1000.00', 164),
(7434, '172.28.35.132', 1, '1000.00', 164),
(7435, '172.28.35.133', 1, '1000.00', 164),
(7436, '172.28.35.134', 1, '1000.00', 164),
(7437, '172.28.35.135', 1, '1000.00', 164),
(7438, '172.28.35.136', 1, '1000.00', 164),
(7439, '172.28.35.137', 1, '1000.00', 164),
(7440, '172.28.35.138', 1, '1000.00', 164),
(7441, '172.28.35.139', 1, '1000.00', 164),
(7442, '172.28.35.140', 1, '1000.00', 164),
(7443, '172.28.35.141', 1, '1000.00', 164),
(7444, '172.28.35.142', 1, '1000.00', 164),
(7445, '172.28.35.143', 1, '1000.00', 164),
(7446, '172.28.35.144', 1, '1000.00', 164),
(7447, '172.28.35.145', 1, '1000.00', 164),
(7448, '172.28.35.146', 1, '1000.00', 164),
(7449, '172.28.35.147', 1, '1000.00', 164),
(7450, '172.28.35.148', 1, '1000.00', 164),
(7451, '172.28.35.149', 1, '1000.00', 164),
(7452, '172.28.35.150', 1, '1000.00', 164),
(7453, '172.28.35.151', 1, '1000.00', 164),
(7454, '172.28.35.152', 1, '1000.00', 164),
(7455, '172.28.35.153', 1, '1000.00', 164),
(7456, '172.28.35.154', 1, '1000.00', 164),
(7457, '172.28.35.155', 1, '1000.00', 164),
(7458, '172.28.35.156', 1, '1000.00', 164),
(7459, '172.28.35.157', 1, '1000.00', 164),
(7460, '172.28.35.158', 1, '1000.00', 164),
(7461, '172.28.35.159', 1, '1000.00', 164),
(7462, '172.28.35.160', 1, '1000.00', 164),
(7463, '172.28.35.161', 1, '1000.00', 164),
(7464, '172.28.35.162', 1, '1000.00', 164),
(7465, '172.28.35.163', 1, '1000.00', 164),
(7466, '172.28.35.164', 1, '1000.00', 164),
(7467, '172.28.35.165', 1, '1000.00', 164),
(7468, '172.28.35.166', 1, '1000.00', 164),
(7469, '172.28.35.167', 1, '1000.00', 164),
(7470, '172.28.35.168', 1, '1000.00', 164),
(7471, '172.28.35.169', 1, '1000.00', 164),
(7472, '172.28.35.170', 1, '1000.00', 164),
(7473, '172.28.35.171', 1, '1000.00', 164),
(7474, '172.28.35.172', 1, '1000.00', 164),
(7475, '172.28.35.173', 1, '1000.00', 164),
(7476, '172.28.35.174', 1, '1000.00', 164),
(7477, '172.28.35.175', 1, '1000.00', 164),
(7478, '172.28.35.176', 1, '1000.00', 164),
(7479, '172.28.35.177', 1, '1000.00', 164),
(7480, '172.28.35.178', 1, '1000.00', 164),
(7481, '172.28.35.179', 1, '1000.00', 164),
(7482, '172.28.35.180', 1, '1000.00', 164),
(7483, '172.28.35.181', 1, '1000.00', 164),
(7484, '172.28.35.182', 1, '1000.00', 164),
(7485, '172.28.35.183', 1, '1000.00', 164),
(7486, '172.28.35.184', 1, '1000.00', 164),
(7487, '172.28.35.185', 1, '1000.00', 164),
(7488, '172.28.35.186', 1, '1000.00', 164),
(7489, '172.28.35.187', 1, '1000.00', 164),
(7490, '172.28.35.188', 1, '1000.00', 164),
(7491, '172.28.35.189', 1, '1000.00', 164),
(7492, '172.28.35.190', 1, '1000.00', 164),
(7493, '172.28.35.191', 1, '1000.00', 164),
(7494, '172.28.35.192', 1, '1000.00', 164),
(7495, '172.28.35.193', 1, '1000.00', 164),
(7496, '172.28.35.194', 1, '1000.00', 164),
(7497, '172.28.35.195', 1, '1000.00', 164),
(7498, '172.28.35.196', 1, '1000.00', 164),
(7499, '172.28.35.197', 1, '1000.00', 164),
(7500, '172.28.35.198', 1, '1000.00', 164),
(7501, '172.28.35.199', 1, '1000.00', 164),
(7502, '172.28.35.200', 1, '1000.00', 164),
(7503, '172.28.35.201', 1, '1000.00', 164),
(7504, '172.28.35.202', 1, '1000.00', 164),
(7505, '172.28.35.203', 1, '1000.00', 164),
(7506, '172.28.35.204', 1, '1000.00', 164),
(7507, '172.28.35.205', 1, '1000.00', 164),
(7508, '172.28.35.206', 1, '1000.00', 164),
(7509, '172.28.35.207', 1, '1000.00', 164),
(7510, '172.28.35.208', 1, '1000.00', 164),
(7511, '172.28.35.209', 1, '1000.00', 164),
(7512, '172.28.35.210', 1, '1000.00', 164),
(7513, '172.28.35.211', 1, '1000.00', 164),
(7514, '172.28.35.212', 1, '1000.00', 164),
(7515, '172.28.35.213', 1, '1000.00', 164),
(7516, '172.28.35.214', 1, '1000.00', 164),
(7517, '172.28.35.215', 1, '1000.00', 164),
(7518, '172.28.35.216', 1, '1000.00', 164),
(7519, '172.28.35.217', 1, '1000.00', 164),
(7520, '172.28.35.218', 1, '1000.00', 164),
(7521, '172.28.35.219', 1, '1000.00', 164),
(7522, '172.28.35.220', 1, '1000.00', 164),
(7523, '172.28.35.221', 1, '1000.00', 164),
(7524, '172.28.35.222', 1, '1000.00', 164),
(7525, '172.28.35.223', 1, '1000.00', 164),
(7526, '172.28.35.224', 1, '1000.00', 164),
(7527, '172.28.35.225', 1, '1000.00', 164),
(7528, '172.28.35.226', 1, '1000.00', 164),
(7529, '172.28.35.227', 1, '1000.00', 164),
(7530, '172.28.35.228', 1, '1000.00', 164),
(7531, '172.28.35.229', 1, '1000.00', 164),
(7532, '172.28.35.230', 1, '1000.00', 164),
(7533, '172.28.35.231', 1, '1000.00', 164),
(7534, '172.28.35.232', 1, '1000.00', 164),
(7535, '172.28.35.233', 1, '1000.00', 164),
(7536, '172.28.35.234', 1, '1000.00', 164),
(7537, '172.28.35.235', 1, '1000.00', 164),
(7538, '172.28.35.236', 1, '1000.00', 164),
(7539, '172.28.35.237', 1, '1000.00', 164),
(7540, '172.28.35.238', 1, '1000.00', 164),
(7541, '172.28.35.239', 1, '1000.00', 164),
(7542, '172.28.35.240', 1, '1000.00', 164),
(7543, '172.28.35.241', 1, '1000.00', 164),
(7544, '172.28.35.242', 1, '1000.00', 164),
(7545, '172.28.35.243', 1, '1000.00', 164),
(7546, '172.28.35.244', 1, '1000.00', 164),
(7547, '172.28.35.245', 1, '1000.00', 164),
(7548, '172.28.35.246', 1, '1000.00', 164),
(7549, '172.28.35.247', 1, '1000.00', 164),
(7550, '172.28.35.248', 1, '1000.00', 164),
(7551, '172.28.35.249', 1, '1000.00', 164),
(7552, '172.28.35.250', 1, '1000.00', 164),
(7553, '172.28.35.251', 1, '1000.00', 164),
(7554, '172.28.35.252', 1, '1000.00', 164),
(7555, '172.28.35.253', 1, '1000.00', 164),
(7556, '172.28.35.254', 1, '1000.00', 164),
(7557, '172.28.36.1', 1, '1000.00', 164),
(7558, '172.28.26.1', 1, '1000.00', 164),
(7559, '172.28.23.1', 1, '1000.00', 164),
(7560, '172.28.23.2', 1, '1000.00', 164),
(7561, '172.28.23.3', 1, '1000.00', 164),
(7562, '172.28.23.4', 1, '1000.00', 164),
(7563, '172.28.23.5', 1, '1000.00', 164),
(7564, '172.28.23.6', 1, '1000.00', 164),
(7565, '172.28.23.7', 1, '1000.00', 164),
(7566, '172.28.23.8', 1, '1000.00', 164),
(7567, '172.28.23.9', 1, '1000.00', 164),
(7568, '172.28.23.10', 1, '1000.00', 164),
(7569, '172.28.23.11', 1, '1000.00', 164),
(7570, '172.28.23.12', 1, '1000.00', 164),
(7571, '172.28.23.13', 1, '1000.00', 164),
(7572, '172.28.23.14', 1, '1000.00', 164),
(7573, '172.28.23.15', 1, '1000.00', 164),
(7574, '172.28.23.16', 1, '1000.00', 164),
(7575, '172.28.23.17', 1, '1000.00', 164),
(7576, '172.28.23.18', 1, '1000.00', 164),
(7577, '172.28.23.19', 1, '1000.00', 164),
(7578, '172.28.23.20', 1, '1000.00', 164),
(7579, '172.28.23.21', 1, '1000.00', 164),
(7580, '172.28.23.22', 1, '1000.00', 164),
(7581, '172.28.23.23', 1, '1000.00', 164),
(7582, '172.28.23.24', 1, '1000.00', 164),
(7583, '172.28.23.25', 1, '1000.00', 164),
(7584, '172.28.23.26', 1, '1000.00', 164),
(7585, '172.28.23.27', 1, '1000.00', 164),
(7586, '172.28.23.28', 1, '1000.00', 164),
(7587, '172.28.23.29', 1, '1000.00', 164),
(7588, '172.28.23.30', 1, '1000.00', 164),
(7589, '172.28.23.31', 1, '1000.00', 164),
(7590, '172.28.23.32', 1, '1000.00', 164),
(7591, '172.28.23.33', 1, '1000.00', 164),
(7592, '172.28.23.34', 1, '1000.00', 164),
(7593, '172.28.23.35', 1, '1000.00', 164),
(7594, '172.28.23.36', 1, '1000.00', 164),
(7595, '172.28.23.37', 1, '1000.00', 164),
(7596, '172.28.23.38', 1, '1000.00', 164),
(7597, '172.28.23.39', 1, '1000.00', 164),
(7598, '172.28.23.40', 1, '1000.00', 164),
(7599, '172.28.23.41', 1, '1000.00', 164),
(7600, '172.28.23.42', 1, '1000.00', 164),
(7601, '172.28.23.43', 1, '1000.00', 164),
(7602, '172.28.23.44', 1, '1000.00', 164),
(7603, '172.28.23.45', 1, '1000.00', 164),
(7604, '172.28.23.46', 1, '1000.00', 164),
(7605, '172.28.23.47', 1, '1000.00', 164),
(7606, '172.28.23.48', 1, '1000.00', 164),
(7607, '172.28.23.49', 1, '1000.00', 164),
(7608, '172.28.23.50', 1, '1000.00', 164),
(7609, '172.28.23.51', 1, '1000.00', 164),
(7610, '172.28.23.52', 1, '1000.00', 164),
(7611, '172.28.23.53', 1, '1000.00', 164),
(7612, '172.28.23.54', 1, '1000.00', 164),
(7613, '172.28.23.55', 1, '1000.00', 164),
(7614, '172.28.23.56', 1, '1000.00', 164),
(7615, '172.28.23.57', 1, '1000.00', 164),
(7616, '172.28.23.58', 1, '1000.00', 164),
(7617, '172.28.23.59', 1, '1000.00', 164),
(7618, '172.28.23.60', 1, '1000.00', 164),
(7619, '172.28.23.61', 1, '1000.00', 164),
(7620, '172.28.23.62', 1, '1000.00', 164),
(7621, '172.28.23.63', 1, '1000.00', 164),
(7622, '172.28.23.64', 1, '1000.00', 164),
(7623, '172.28.23.65', 1, '1000.00', 164),
(7624, '172.28.23.66', 1, '1000.00', 164),
(7625, '172.28.23.67', 1, '1000.00', 164),
(7626, '172.28.23.68', 1, '1000.00', 164),
(7627, '172.28.23.69', 1, '1000.00', 164),
(7628, '172.28.23.70', 1, '1000.00', 164),
(7629, '172.28.23.71', 1, '1000.00', 164),
(7630, '172.28.23.72', 1, '1000.00', 164),
(7631, '172.28.23.73', 1, '1000.00', 164),
(7632, '172.28.23.74', 1, '1000.00', 164),
(7633, '172.28.23.75', 1, '1000.00', 164),
(7634, '172.28.23.76', 1, '1000.00', 164),
(7635, '172.28.23.77', 1, '1000.00', 164),
(7636, '172.28.23.78', 1, '1000.00', 164),
(7637, '172.28.23.79', 1, '1000.00', 164),
(7638, '172.28.23.80', 1, '1000.00', 164),
(7639, '172.28.23.81', 1, '1000.00', 164),
(7640, '172.28.23.82', 1, '1000.00', 164),
(7641, '172.28.23.83', 1, '1000.00', 164),
(7642, '172.28.23.84', 1, '1000.00', 164),
(7643, '172.28.23.85', 1, '1000.00', 164),
(7644, '172.28.23.86', 1, '1000.00', 164),
(7645, '172.28.23.87', 1, '1000.00', 164),
(7646, '172.28.23.88', 1, '1000.00', 164),
(7647, '172.28.23.89', 1, '1000.00', 164),
(7648, '172.28.23.90', 1, '1000.00', 164),
(7649, '172.28.23.91', 1, '1000.00', 164),
(7650, '172.28.23.92', 1, '1000.00', 164),
(7651, '172.28.23.93', 1, '1000.00', 164),
(7652, '172.28.23.94', 1, '1000.00', 164),
(7653, '172.28.23.95', 1, '1000.00', 164),
(7654, '172.28.23.96', 1, '1000.00', 164),
(7655, '172.28.23.97', 1, '1000.00', 164),
(7656, '172.28.23.98', 1, '1000.00', 164),
(7657, '172.28.23.99', 1, '1000.00', 164),
(7658, '172.28.23.100', 1, '1000.00', 164),
(7659, '172.28.23.101', 1, '1000.00', 164),
(7660, '172.28.23.102', 1, '1000.00', 164),
(7661, '172.28.23.103', 1, '1000.00', 164),
(7662, '172.28.23.104', 1, '1000.00', 164),
(7663, '172.28.23.105', 1, '1000.00', 164),
(7664, '172.28.23.106', 1, '1000.00', 164),
(7665, '172.28.23.107', 1, '1000.00', 164),
(7666, '172.28.23.108', 1, '1000.00', 164),
(7667, '172.28.23.109', 1, '1000.00', 164),
(7668, '172.28.23.110', 1, '1000.00', 164),
(7669, '172.28.23.111', 1, '1000.00', 164),
(7670, '172.28.23.112', 1, '1000.00', 164),
(7671, '172.28.23.113', 1, '1000.00', 164),
(7672, '172.28.23.114', 1, '1000.00', 164),
(7673, '172.28.23.115', 1, '1000.00', 164),
(7674, '172.28.23.116', 1, '1000.00', 164),
(7675, '172.28.23.117', 1, '1000.00', 164),
(7676, '172.28.23.118', 1, '1000.00', 164),
(7677, '172.28.23.119', 1, '1000.00', 164),
(7678, '172.28.23.120', 1, '1000.00', 164),
(7679, '172.28.23.121', 1, '1000.00', 164),
(7680, '172.28.23.122', 1, '1000.00', 164),
(7681, '172.28.23.123', 1, '1000.00', 164),
(7682, '172.28.23.124', 1, '1000.00', 164),
(7683, '172.28.23.125', 1, '1000.00', 164),
(7684, '172.28.23.126', 1, '1000.00', 164),
(7685, '172.28.23.127', 1, '1000.00', 164),
(7686, '172.28.23.128', 1, '1000.00', 164),
(7687, '172.28.23.129', 1, '1000.00', 164),
(7688, '172.28.23.130', 1, '1000.00', 164),
(7689, '172.28.23.131', 1, '1000.00', 164),
(7690, '172.28.23.132', 1, '1000.00', 164),
(7691, '172.28.23.133', 1, '1000.00', 164),
(7692, '172.28.23.134', 1, '1000.00', 164),
(7693, '172.28.23.135', 1, '1000.00', 164),
(7694, '172.28.23.136', 1, '1000.00', 164),
(7695, '172.28.23.137', 1, '1000.00', 164),
(7696, '172.28.23.138', 1, '1000.00', 164),
(7697, '172.28.23.139', 1, '1000.00', 164),
(7698, '172.28.23.140', 1, '1000.00', 164),
(7699, '172.28.23.141', 1, '1000.00', 164),
(7700, '172.28.23.142', 1, '1000.00', 164),
(7701, '172.28.23.143', 1, '1000.00', 164),
(7702, '172.28.23.144', 1, '1000.00', 164),
(7703, '172.28.23.145', 1, '1000.00', 164),
(7704, '172.28.23.146', 1, '1000.00', 164),
(7705, '172.28.23.147', 1, '1000.00', 164),
(7706, '172.28.23.148', 1, '1000.00', 164),
(7707, '172.28.23.149', 1, '1000.00', 164),
(7708, '172.28.23.150', 1, '1000.00', 164),
(7709, '172.28.23.151', 1, '1000.00', 164),
(7710, '172.28.23.152', 1, '1000.00', 164),
(7711, '172.28.23.153', 1, '1000.00', 164),
(7712, '172.28.23.154', 1, '1000.00', 164),
(7713, '172.28.23.155', 1, '1000.00', 164),
(7714, '172.28.23.156', 1, '1000.00', 164),
(7715, '172.28.23.157', 1, '1000.00', 164),
(7716, '172.28.23.158', 1, '1000.00', 164),
(7717, '172.28.23.159', 1, '1000.00', 164),
(7718, '172.28.23.160', 1, '1000.00', 164),
(7719, '172.28.23.161', 1, '1000.00', 164),
(7720, '172.28.23.162', 1, '1000.00', 164),
(7721, '172.28.23.163', 1, '1000.00', 164),
(7722, '172.28.23.164', 1, '1000.00', 164),
(7723, '172.28.23.165', 1, '1000.00', 164),
(7724, '172.28.23.166', 1, '1000.00', 164),
(7725, '172.28.23.167', 1, '1000.00', 164),
(7726, '172.28.23.168', 1, '1000.00', 164),
(7727, '172.28.23.169', 1, '1000.00', 164),
(7728, '172.28.23.170', 1, '1000.00', 164),
(7729, '172.28.23.171', 1, '1000.00', 164),
(7730, '172.28.23.172', 1, '1000.00', 164),
(7731, '172.28.23.173', 1, '1000.00', 164),
(7732, '172.28.23.174', 1, '1000.00', 164),
(7733, '172.28.23.175', 1, '1000.00', 164),
(7734, '172.28.23.176', 1, '1000.00', 164),
(7735, '172.28.23.177', 1, '1000.00', 164),
(7736, '172.28.23.178', 1, '1000.00', 164),
(7737, '172.28.23.179', 1, '1000.00', 164),
(7738, '172.28.23.180', 1, '1000.00', 164),
(7739, '172.28.23.181', 1, '1000.00', 164),
(7740, '172.28.23.182', 1, '1000.00', 164),
(7741, '172.28.23.183', 1, '1000.00', 164),
(7742, '172.28.23.184', 1, '1000.00', 164),
(7743, '172.28.23.185', 1, '1000.00', 164),
(7744, '172.28.23.186', 1, '1000.00', 164),
(7745, '172.28.23.187', 1, '1000.00', 164),
(7746, '172.28.23.188', 1, '1000.00', 164),
(7747, '172.28.23.189', 1, '1000.00', 164),
(7748, '172.28.23.190', 1, '1000.00', 164),
(7749, '172.28.23.191', 1, '1000.00', 164),
(7750, '172.28.23.192', 1, '1000.00', 164),
(7751, '172.28.23.193', 1, '1000.00', 164),
(7752, '172.28.23.194', 1, '1000.00', 164),
(7753, '172.28.23.195', 1, '1000.00', 164),
(7754, '172.28.23.196', 1, '1000.00', 164),
(7755, '172.28.23.197', 1, '1000.00', 164),
(7756, '172.28.23.198', 1, '1000.00', 164),
(7757, '172.28.23.199', 1, '1000.00', 164),
(7758, '172.28.23.200', 1, '1000.00', 164),
(7759, '172.28.23.201', 1, '1000.00', 164),
(7760, '172.28.23.202', 1, '1000.00', 164),
(7761, '172.28.23.203', 1, '1000.00', 164),
(7762, '172.28.23.204', 1, '1000.00', 164),
(7763, '172.28.23.205', 1, '1000.00', 164),
(7764, '172.28.23.206', 1, '1000.00', 164),
(7765, '172.28.23.207', 1, '1000.00', 164),
(7766, '172.28.23.208', 1, '1000.00', 164),
(7767, '172.28.23.209', 1, '1000.00', 164),
(7768, '172.28.23.210', 1, '1000.00', 164),
(7769, '172.28.23.211', 1, '1000.00', 164),
(7770, '172.28.23.212', 1, '1000.00', 164),
(7771, '172.28.23.213', 1, '1000.00', 164),
(7772, '172.28.23.214', 1, '1000.00', 164),
(7773, '172.28.23.215', 1, '1000.00', 164),
(7774, '172.28.23.216', 1, '1000.00', 164),
(7775, '172.28.23.217', 1, '1000.00', 164),
(7776, '172.28.23.218', 1, '1000.00', 164),
(7777, '172.28.23.219', 1, '1000.00', 164),
(7778, '172.28.23.220', 1, '1000.00', 164),
(7779, '172.28.23.221', 1, '1000.00', 164),
(7780, '172.28.23.222', 1, '1000.00', 164),
(7781, '172.28.23.223', 1, '1000.00', 164),
(7782, '172.28.23.224', 1, '1000.00', 164),
(7783, '172.28.23.225', 1, '1000.00', 164),
(7784, '172.28.23.226', 1, '1000.00', 164),
(7785, '172.28.23.227', 1, '1000.00', 164),
(7786, '172.28.23.228', 1, '1000.00', 164),
(7787, '172.28.23.229', 1, '1000.00', 164),
(7788, '172.28.23.230', 1, '1000.00', 164),
(7789, '172.28.23.231', 1, '1000.00', 164),
(7790, '172.28.23.232', 1, '1000.00', 164),
(7791, '172.28.23.233', 1, '1000.00', 164),
(7792, '172.28.23.234', 1, '1000.00', 164),
(7793, '172.28.23.235', 1, '1000.00', 164),
(7794, '172.28.23.236', 1, '1000.00', 164),
(7795, '172.28.23.237', 1, '1000.00', 164),
(7796, '172.28.23.238', 1, '1000.00', 164),
(7797, '172.28.23.239', 1, '1000.00', 164),
(7798, '172.28.23.240', 1, '1000.00', 164),
(7799, '172.28.23.241', 1, '1000.00', 164),
(7800, '172.28.23.242', 1, '1000.00', 164),
(7801, '172.28.23.243', 1, '1000.00', 164),
(7802, '172.28.23.244', 1, '1000.00', 164),
(7803, '172.28.23.245', 1, '1000.00', 164),
(7804, '172.28.23.246', 1, '1000.00', 164),
(7805, '172.28.23.247', 1, '1000.00', 164),
(7806, '172.28.23.248', 1, '1000.00', 164),
(7807, '172.28.23.249', 1, '1000.00', 164),
(7808, '172.28.23.250', 1, '1000.00', 164),
(7809, '172.28.23.251', 1, '1000.00', 164),
(7810, '172.28.23.252', 1, '1000.00', 164),
(7811, '172.28.23.253', 1, '1000.00', 164),
(7812, '172.28.23.254', 1, '1000.00', 164),
(7813, '172.28.25.1', 1, '1000.00', 165),
(7814, '172.28.25.2', 1, '1000.00', 165),
(7815, '172.28.25.3', 1, '1000.00', 165),
(7816, '172.28.25.4', 1, '1000.00', 165),
(7817, '172.28.25.5', 1, '1000.00', 165),
(7818, '172.28.25.6', 1, '1000.00', 165),
(7819, '172.28.25.7', 1, '1000.00', 165),
(7820, '172.28.25.8', 1, '1000.00', 165),
(7821, '172.28.25.9', 1, '1000.00', 165),
(7822, '172.28.25.10', 1, '1000.00', 165),
(7823, '172.28.25.11', 1, '1000.00', 165),
(7824, '172.28.25.12', 1, '1000.00', 165),
(7825, '172.28.25.13', 1, '1000.00', 165),
(7826, '172.28.25.14', 1, '1000.00', 165),
(7827, '172.28.25.15', 1, '1000.00', 165),
(7828, '172.28.25.16', 1, '1000.00', 165),
(7829, '172.28.25.17', 1, '1000.00', 165),
(7830, '172.28.25.18', 1, '1000.00', 165),
(7831, '172.28.25.19', 1, '1000.00', 165),
(7832, '172.28.25.20', 1, '1000.00', 165),
(7833, '172.28.25.21', 1, '1000.00', 165),
(7834, '172.28.25.22', 1, '1000.00', 165),
(7835, '172.28.25.23', 1, '1000.00', 165),
(7836, '172.28.25.24', 1, '1000.00', 165),
(7837, '172.28.25.25', 1, '1000.00', 165),
(7838, '172.28.25.26', 1, '1000.00', 165),
(7839, '172.28.25.27', 1, '1000.00', 165),
(7840, '172.28.25.28', 1, '1000.00', 165),
(7841, '172.28.25.29', 1, '1000.00', 165),
(7842, '172.28.25.30', 1, '1000.00', 165),
(7843, '172.28.25.31', 1, '1000.00', 165),
(7844, '172.28.25.32', 1, '1000.00', 165),
(7845, '172.28.25.33', 1, '1000.00', 165),
(7846, '172.28.25.34', 1, '1000.00', 165),
(7847, '172.28.25.35', 1, '1000.00', 165),
(7848, '172.28.25.36', 1, '1000.00', 165),
(7849, '172.28.25.37', 1, '1000.00', 165),
(7850, '172.28.25.38', 1, '1000.00', 165),
(7851, '172.28.25.39', 1, '1000.00', 165),
(7852, '172.28.25.40', 1, '1000.00', 165),
(7853, '172.28.25.41', 1, '1000.00', 165),
(7854, '172.28.25.42', 1, '1000.00', 165),
(7855, '172.28.25.43', 1, '1000.00', 165),
(7856, '172.28.25.44', 1, '1000.00', 165),
(7857, '172.28.25.45', 1, '1000.00', 165),
(7858, '172.28.25.46', 1, '1000.00', 165),
(7859, '172.28.25.47', 1, '1000.00', 165),
(7860, '172.28.25.48', 1, '1000.00', 165),
(7861, '172.28.25.49', 1, '1000.00', 165),
(7862, '172.28.25.50', 1, '1000.00', 165),
(7863, '172.28.25.51', 1, '1000.00', 165),
(7864, '172.28.25.52', 1, '1000.00', 165),
(7865, '172.28.25.53', 1, '1000.00', 165),
(7866, '172.28.25.54', 1, '1000.00', 165),
(7867, '172.28.25.55', 1, '1000.00', 165),
(7868, '172.28.25.56', 1, '1000.00', 165),
(7869, '172.28.25.57', 1, '1000.00', 165),
(7870, '172.28.25.58', 1, '1000.00', 165),
(7871, '172.28.25.59', 1, '1000.00', 165),
(7872, '172.28.25.60', 1, '1000.00', 165),
(7873, '172.28.25.61', 1, '1000.00', 165),
(7874, '172.28.25.62', 1, '1000.00', 165),
(7875, '172.28.25.63', 1, '1000.00', 165),
(7876, '172.28.25.64', 1, '1000.00', 165),
(7877, '172.28.25.65', 1, '1000.00', 165),
(7878, '172.28.25.66', 1, '1000.00', 165),
(7879, '172.28.25.67', 1, '1000.00', 165),
(7880, '172.28.25.68', 1, '1000.00', 165),
(7881, '172.28.25.69', 1, '1000.00', 165),
(7882, '172.28.25.70', 1, '1000.00', 165),
(7883, '172.28.25.71', 1, '1000.00', 165),
(7884, '172.28.25.72', 1, '1000.00', 165),
(7885, '172.28.25.73', 1, '1000.00', 165),
(7886, '172.28.25.74', 1, '1000.00', 165),
(7887, '172.28.25.75', 1, '1000.00', 165),
(7888, '172.28.25.76', 1, '1000.00', 165),
(7889, '172.28.25.77', 1, '1000.00', 165),
(7890, '172.28.25.78', 1, '1000.00', 165),
(7891, '172.28.25.79', 1, '1000.00', 165),
(7892, '172.28.25.80', 1, '1000.00', 165),
(7893, '172.28.25.81', 1, '1000.00', 165),
(7894, '172.28.25.82', 1, '1000.00', 165),
(7895, '172.28.25.83', 1, '1000.00', 165),
(7896, '172.28.25.84', 1, '1000.00', 165),
(7897, '172.28.25.85', 1, '1000.00', 165),
(7898, '172.28.25.86', 1, '1000.00', 165),
(7899, '172.28.25.87', 1, '1000.00', 165),
(7900, '172.28.25.88', 1, '1000.00', 165),
(7901, '172.28.25.89', 1, '1000.00', 165),
(7902, '172.28.25.90', 1, '1000.00', 165),
(7903, '172.28.25.91', 1, '1000.00', 165),
(7904, '172.28.25.92', 1, '1000.00', 165),
(7905, '172.28.25.93', 1, '1000.00', 165),
(7906, '172.28.25.94', 1, '1000.00', 165),
(7907, '172.28.25.95', 1, '1000.00', 165),
(7908, '172.28.25.96', 1, '1000.00', 165),
(7909, '172.28.25.97', 1, '1000.00', 165),
(7910, '172.28.25.98', 1, '1000.00', 165),
(7911, '172.28.25.99', 1, '1000.00', 165),
(7912, '172.28.25.100', 1, '1000.00', 165),
(7913, '172.28.25.101', 1, '1000.00', 165),
(7914, '172.28.25.102', 1, '1000.00', 165),
(7915, '172.28.25.103', 1, '1000.00', 165),
(7916, '172.28.25.104', 1, '1000.00', 165),
(7917, '172.28.25.105', 1, '1000.00', 165),
(7918, '172.28.25.106', 1, '1000.00', 165),
(7919, '172.28.25.107', 1, '1000.00', 165),
(7920, '172.28.25.108', 1, '1000.00', 165),
(7921, '172.28.25.109', 1, '1000.00', 165),
(7922, '172.28.25.110', 1, '1000.00', 165),
(7923, '172.28.25.111', 1, '1000.00', 165),
(7924, '172.28.25.112', 1, '1000.00', 165),
(7925, '172.28.25.113', 1, '1000.00', 165),
(7926, '172.28.25.114', 1, '1000.00', 165),
(7927, '172.28.25.115', 1, '1000.00', 165),
(7928, '172.28.25.116', 1, '1000.00', 165),
(7929, '172.28.25.117', 1, '1000.00', 165),
(7930, '172.28.25.118', 1, '1000.00', 165),
(7931, '172.28.25.119', 1, '1000.00', 165),
(7932, '172.28.25.120', 1, '1000.00', 165),
(7933, '172.28.25.121', 1, '1000.00', 165),
(7934, '172.28.25.122', 1, '1000.00', 165),
(7935, '172.28.25.123', 1, '1000.00', 165),
(7936, '172.28.25.124', 1, '1000.00', 165),
(7937, '172.28.25.125', 1, '1000.00', 165),
(7938, '172.28.25.126', 1, '1000.00', 165),
(7939, '172.28.25.127', 1, '1000.00', 165),
(7940, '172.28.25.128', 1, '1000.00', 165),
(7941, '172.28.25.129', 1, '1000.00', 165),
(7942, '172.28.25.130', 1, '1000.00', 165),
(7943, '172.28.25.131', 1, '1000.00', 165),
(7944, '172.28.25.132', 1, '1000.00', 165),
(7945, '172.28.25.133', 1, '1000.00', 165),
(7946, '172.28.25.134', 1, '1000.00', 165),
(7947, '172.28.25.135', 1, '1000.00', 165),
(7948, '172.28.25.136', 1, '1000.00', 165),
(7949, '172.28.25.137', 1, '1000.00', 165),
(7950, '172.28.25.138', 1, '1000.00', 165),
(7951, '172.28.25.139', 1, '1000.00', 165),
(7952, '172.28.25.140', 1, '1000.00', 165),
(7953, '172.28.25.141', 1, '1000.00', 165),
(7954, '172.28.25.142', 1, '1000.00', 165),
(7955, '172.28.25.143', 1, '1000.00', 165),
(7956, '172.28.25.144', 1, '1000.00', 165),
(7957, '172.28.25.145', 1, '1000.00', 165),
(7958, '172.28.25.146', 1, '1000.00', 165),
(7959, '172.28.25.147', 1, '1000.00', 165),
(7960, '172.28.25.148', 1, '1000.00', 165),
(7961, '172.28.25.149', 1, '1000.00', 165),
(7962, '172.28.25.150', 1, '1000.00', 165),
(7963, '172.28.25.151', 1, '1000.00', 165),
(7964, '172.28.25.152', 1, '1000.00', 165),
(7965, '172.28.25.153', 1, '1000.00', 165),
(7966, '172.28.25.154', 1, '1000.00', 165),
(7967, '172.28.25.155', 1, '1000.00', 165),
(7968, '172.28.25.156', 1, '1000.00', 165),
(7969, '172.28.25.157', 1, '1000.00', 165),
(7970, '172.28.25.158', 1, '1000.00', 165),
(7971, '172.28.25.159', 1, '1000.00', 165),
(7972, '172.28.25.160', 1, '1000.00', 165),
(7973, '172.28.25.161', 1, '1000.00', 165),
(7974, '172.28.25.162', 1, '1000.00', 165),
(7975, '172.28.25.163', 1, '1000.00', 165),
(7976, '172.28.25.164', 1, '1000.00', 165),
(7977, '172.28.25.165', 1, '1000.00', 165),
(7978, '172.28.25.166', 1, '1000.00', 165),
(7979, '172.28.25.167', 1, '1000.00', 165),
(7980, '172.28.25.168', 1, '1000.00', 165),
(7981, '172.28.25.169', 1, '1000.00', 165),
(7982, '172.28.25.170', 1, '1000.00', 165),
(7983, '172.28.25.171', 1, '1000.00', 165),
(7984, '172.28.25.172', 1, '1000.00', 165),
(7985, '172.28.25.173', 1, '1000.00', 165),
(7986, '172.28.25.174', 1, '1000.00', 165),
(7987, '172.28.25.175', 1, '1000.00', 165),
(7988, '172.28.25.176', 1, '1000.00', 165),
(7989, '172.28.25.177', 1, '1000.00', 165),
(7990, '172.28.25.178', 1, '1000.00', 165),
(7991, '172.28.25.179', 1, '1000.00', 165),
(7992, '172.28.25.180', 1, '1000.00', 165),
(7993, '172.28.25.181', 1, '1000.00', 165),
(7994, '172.28.25.182', 1, '1000.00', 165),
(7995, '172.28.25.183', 1, '1000.00', 165),
(7996, '172.28.25.184', 1, '1000.00', 165),
(7997, '172.28.25.185', 1, '1000.00', 165),
(7998, '172.28.25.186', 1, '1000.00', 165),
(7999, '172.28.25.187', 1, '1000.00', 165),
(8000, '172.28.25.188', 1, '1000.00', 165),
(8001, '172.28.25.189', 1, '1000.00', 165),
(8002, '172.28.25.190', 1, '1000.00', 165),
(8003, '172.28.25.191', 1, '1000.00', 165),
(8004, '172.28.25.192', 1, '1000.00', 165),
(8005, '172.28.25.193', 1, '1000.00', 165),
(8006, '172.28.25.194', 1, '1000.00', 165),
(8007, '172.28.25.195', 1, '1000.00', 165),
(8008, '172.28.25.196', 1, '1000.00', 165),
(8009, '172.28.25.197', 1, '1000.00', 165),
(8010, '172.28.25.198', 1, '1000.00', 165),
(8011, '172.28.25.199', 1, '1000.00', 165),
(8012, '172.28.25.200', 1, '1000.00', 165),
(8013, '172.28.25.201', 1, '1000.00', 165),
(8014, '172.28.25.202', 1, '1000.00', 165),
(8015, '172.28.25.203', 1, '1000.00', 165),
(8016, '172.28.25.204', 1, '1000.00', 165),
(8017, '172.28.25.205', 1, '1000.00', 165),
(8018, '172.28.25.206', 1, '1000.00', 165),
(8019, '172.28.25.207', 1, '1000.00', 165),
(8020, '172.28.25.208', 1, '1000.00', 165),
(8021, '172.28.25.209', 1, '1000.00', 165),
(8022, '172.28.25.210', 1, '1000.00', 165),
(8023, '172.28.25.211', 1, '1000.00', 165),
(8024, '172.28.25.212', 1, '1000.00', 165),
(8025, '172.28.25.213', 1, '1000.00', 165),
(8026, '172.28.25.214', 1, '1000.00', 165),
(8027, '172.28.25.215', 1, '1000.00', 165),
(8028, '172.28.25.216', 1, '1000.00', 165),
(8029, '172.28.25.217', 1, '1000.00', 165),
(8030, '172.28.25.218', 1, '1000.00', 165),
(8031, '172.28.25.219', 1, '1000.00', 165),
(8032, '172.28.25.220', 1, '1000.00', 165),
(8033, '172.28.25.221', 1, '1000.00', 165),
(8034, '172.28.25.222', 1, '1000.00', 165),
(8035, '172.28.25.223', 1, '1000.00', 165),
(8036, '172.28.25.224', 1, '1000.00', 165),
(8037, '172.28.25.225', 1, '1000.00', 165),
(8038, '172.28.25.226', 1, '1000.00', 165),
(8039, '172.28.25.227', 1, '1000.00', 165),
(8040, '172.28.25.228', 1, '1000.00', 165),
(8041, '172.28.25.229', 1, '1000.00', 165),
(8042, '172.28.25.230', 1, '1000.00', 165),
(8043, '172.28.25.231', 1, '1000.00', 165),
(8044, '172.28.25.232', 1, '1000.00', 165),
(8045, '172.28.25.233', 1, '1000.00', 165),
(8046, '172.28.25.234', 1, '1000.00', 165),
(8047, '172.28.25.235', 1, '1000.00', 165),
(8048, '172.28.25.236', 1, '1000.00', 165),
(8049, '172.28.25.237', 1, '1000.00', 165),
(8050, '172.28.25.238', 1, '1000.00', 165),
(8051, '172.28.25.239', 1, '1000.00', 165),
(8052, '172.28.25.240', 1, '1000.00', 165),
(8053, '172.28.25.241', 1, '1000.00', 165),
(8054, '172.28.25.242', 1, '1000.00', 165),
(8055, '172.28.25.243', 1, '1000.00', 165),
(8056, '172.28.25.244', 1, '1000.00', 165),
(8057, '172.28.25.245', 1, '1000.00', 165),
(8058, '172.28.25.246', 1, '1000.00', 165),
(8059, '172.28.25.247', 1, '1000.00', 165),
(8060, '172.28.25.248', 1, '1000.00', 165),
(8061, '172.28.25.249', 1, '1000.00', 165),
(8062, '172.28.25.250', 1, '1000.00', 165),
(8063, '172.28.25.251', 1, '1000.00', 165),
(8064, '172.28.25.252', 1, '1000.00', 165),
(8065, '172.28.25.253', 1, '1000.00', 165),
(8066, '172.28.25.254', 1, '1000.00', 165),
(8067, '10.51.243.1', 1, '1000.00', 168),
(8068, '10.51.243.2', 1, '1000.00', 168),
(8069, '10.51.243.3', 1, '1000.00', 168),
(8070, '10.51.243.4', 1, '1000.00', 168),
(8071, '10.51.243.5', 1, '1000.00', 168),
(8072, '10.51.243.6', 1, '1000.00', 168),
(8073, '10.51.243.7', 1, '1000.00', 168),
(8074, '10.51.243.8', 1, '1000.00', 168),
(8075, '10.51.243.9', 1, '1000.00', 168),
(8076, '10.51.243.10', 1, '1000.00', 168),
(8077, '10.51.243.11', 1, '1000.00', 168),
(8078, '10.51.243.12', 1, '1000.00', 168),
(8079, '10.51.243.13', 1, '1000.00', 168),
(8080, '10.51.243.14', 1, '1000.00', 168),
(8081, '10.51.243.15', 1, '1000.00', 168),
(8082, '10.51.243.16', 1, '1000.00', 168),
(8083, '10.51.243.17', 1, '1000.00', 168),
(8084, '10.51.243.18', 1, '1000.00', 168),
(8085, '10.51.243.19', 1, '1000.00', 168),
(8086, '10.51.243.20', 1, '1000.00', 168),
(8087, '10.51.243.21', 1, '1000.00', 168),
(8088, '10.51.243.22', 1, '1000.00', 168),
(8089, '10.51.243.23', 1, '1000.00', 168),
(8090, '10.51.243.24', 1, '1000.00', 168),
(8091, '10.51.243.25', 1, '1000.00', 168),
(8092, '10.51.243.26', 1, '1000.00', 168),
(8093, '10.51.243.27', 1, '1000.00', 168),
(8094, '10.51.243.28', 1, '1000.00', 168),
(8095, '10.51.243.29', 1, '1000.00', 168),
(8096, '10.51.243.30', 1, '1000.00', 168),
(8097, '10.51.243.31', 1, '1000.00', 168),
(8098, '10.51.243.32', 1, '1000.00', 168),
(8099, '10.51.243.33', 1, '1000.00', 168),
(8100, '10.51.243.34', 1, '1000.00', 168),
(8101, '10.51.243.35', 1, '1000.00', 168),
(8102, '10.51.243.36', 1, '1000.00', 168),
(8103, '10.51.243.37', 1, '1000.00', 168),
(8104, '10.51.243.38', 1, '1000.00', 168),
(8105, '10.51.243.39', 1, '1000.00', 168),
(8106, '10.51.243.40', 1, '1000.00', 168),
(8107, '10.51.243.41', 1, '1000.00', 168),
(8108, '10.51.243.42', 1, '1000.00', 168),
(8109, '10.51.243.43', 1, '1000.00', 168),
(8110, '10.51.243.44', 1, '1000.00', 168),
(8111, '10.51.243.45', 1, '1000.00', 168),
(8112, '10.51.243.46', 1, '1000.00', 168),
(8113, '10.51.243.47', 1, '1000.00', 168),
(8114, '10.51.243.48', 1, '1000.00', 168),
(8115, '10.51.243.49', 1, '1000.00', 168),
(8116, '10.51.243.50', 1, '1000.00', 168),
(8117, '10.51.243.51', 1, '1000.00', 168),
(8118, '10.51.243.52', 1, '1000.00', 168),
(8119, '10.51.243.53', 1, '1000.00', 168),
(8120, '10.51.243.54', 1, '1000.00', 168),
(8121, '10.51.243.55', 1, '1000.00', 168),
(8122, '10.51.243.56', 1, '1000.00', 168),
(8123, '10.51.243.57', 1, '1000.00', 168),
(8124, '10.51.243.58', 1, '1000.00', 168),
(8125, '10.51.243.59', 1, '1000.00', 168),
(8126, '10.51.243.60', 1, '1000.00', 168),
(8127, '10.51.243.61', 1, '1000.00', 168),
(8128, '10.51.243.62', 1, '1000.00', 168),
(8129, '10.51.243.63', 1, '1000.00', 168),
(8130, '10.51.243.64', 1, '1000.00', 168),
(8131, '10.51.243.65', 1, '1000.00', 168),
(8132, '10.51.243.66', 1, '1000.00', 168);
INSERT INTO `ip_addresses` (`id`, `address`, `status`, `price`, `base_id`) VALUES
(8133, '10.51.243.67', 1, '1000.00', 168),
(8134, '10.51.243.68', 1, '1000.00', 168),
(8135, '10.51.243.69', 1, '1000.00', 168),
(8136, '10.51.243.70', 1, '1000.00', 168),
(8137, '10.51.243.71', 1, '1000.00', 168),
(8138, '10.51.243.72', 1, '1000.00', 168),
(8139, '10.51.243.73', 1, '1000.00', 168),
(8140, '10.51.243.74', 1, '1000.00', 168),
(8141, '10.51.243.75', 1, '1000.00', 168),
(8142, '10.51.243.76', 1, '1000.00', 168),
(8143, '10.51.243.77', 1, '1000.00', 168),
(8144, '10.51.243.78', 1, '1000.00', 168),
(8145, '10.51.243.79', 1, '1000.00', 168),
(8146, '10.51.243.80', 1, '1000.00', 168),
(8147, '10.51.243.81', 1, '1000.00', 168),
(8148, '10.51.243.82', 1, '1000.00', 168),
(8149, '10.51.243.83', 1, '1000.00', 168),
(8150, '10.51.243.84', 1, '1000.00', 168),
(8151, '10.51.243.85', 1, '1000.00', 168),
(8152, '10.51.243.86', 1, '1000.00', 168),
(8153, '10.51.243.87', 1, '1000.00', 168),
(8154, '10.51.243.88', 1, '1000.00', 168),
(8155, '10.51.243.89', 1, '1000.00', 168),
(8156, '10.51.243.90', 1, '1000.00', 168),
(8157, '10.51.243.91', 1, '1000.00', 168),
(8158, '10.51.243.92', 1, '1000.00', 168),
(8159, '10.51.243.93', 1, '1000.00', 168),
(8160, '10.51.243.94', 1, '1000.00', 168),
(8161, '10.51.243.95', 1, '1000.00', 168),
(8162, '10.51.243.96', 1, '1000.00', 168),
(8163, '10.51.243.97', 1, '1000.00', 168),
(8164, '10.51.243.98', 1, '1000.00', 168),
(8165, '10.51.243.99', 1, '1000.00', 168),
(8166, '10.51.243.100', 1, '1000.00', 168),
(8167, '10.51.243.101', 1, '1000.00', 168),
(8168, '10.51.243.102', 1, '1000.00', 168),
(8169, '10.51.243.103', 1, '1000.00', 168),
(8170, '10.51.243.104', 1, '1000.00', 168),
(8171, '10.51.243.105', 1, '1000.00', 168),
(8172, '10.51.243.106', 1, '1000.00', 168),
(8173, '10.51.243.107', 1, '1000.00', 168),
(8174, '10.51.243.108', 1, '1000.00', 168),
(8175, '10.51.243.109', 1, '1000.00', 168),
(8176, '10.51.243.110', 1, '1000.00', 168),
(8177, '10.51.243.111', 1, '1000.00', 168),
(8178, '10.51.243.112', 1, '1000.00', 168),
(8179, '10.51.243.113', 1, '1000.00', 168),
(8180, '10.51.243.114', 1, '1000.00', 168),
(8181, '10.51.243.115', 1, '1000.00', 168),
(8182, '10.51.243.116', 1, '1000.00', 168),
(8183, '10.51.243.117', 1, '1000.00', 168),
(8184, '10.51.243.118', 1, '1000.00', 168),
(8185, '10.51.243.119', 1, '1000.00', 168),
(8186, '10.51.243.120', 1, '1000.00', 168),
(8187, '10.51.243.121', 1, '1000.00', 168),
(8188, '10.51.243.122', 1, '1000.00', 168),
(8189, '10.51.243.123', 1, '1000.00', 168),
(8190, '10.51.243.124', 1, '1000.00', 168),
(8191, '10.51.243.125', 1, '1000.00', 168),
(8192, '10.51.243.126', 1, '1000.00', 168),
(8193, '10.51.243.127', 1, '1000.00', 168),
(8194, '10.51.243.128', 1, '1000.00', 168),
(8195, '10.51.243.129', 1, '1000.00', 168),
(8196, '10.51.243.130', 1, '1000.00', 168),
(8197, '10.51.243.131', 1, '1000.00', 168),
(8198, '10.51.243.132', 1, '1000.00', 168),
(8199, '10.51.243.133', 1, '1000.00', 168),
(8200, '10.51.243.134', 1, '1000.00', 168),
(8201, '10.51.243.135', 1, '1000.00', 168),
(8202, '10.51.243.136', 1, '1000.00', 168),
(8203, '10.51.243.137', 1, '1000.00', 168),
(8204, '10.51.243.138', 1, '1000.00', 168),
(8205, '10.51.243.139', 1, '1000.00', 168),
(8206, '10.51.243.140', 1, '1000.00', 168),
(8207, '10.51.243.141', 1, '1000.00', 168),
(8208, '10.51.243.142', 1, '1000.00', 168),
(8209, '10.51.243.143', 1, '1000.00', 168),
(8210, '10.51.243.144', 1, '1000.00', 168),
(8211, '10.51.243.145', 1, '1000.00', 168),
(8212, '10.51.243.146', 1, '1000.00', 168),
(8213, '10.51.243.147', 1, '1000.00', 168),
(8214, '10.51.243.148', 1, '1000.00', 168),
(8215, '10.51.243.149', 1, '1000.00', 168),
(8216, '10.51.243.150', 1, '1000.00', 168),
(8217, '10.51.243.151', 1, '1000.00', 168),
(8218, '10.51.243.152', 1, '1000.00', 168),
(8219, '10.51.243.153', 1, '1000.00', 168),
(8220, '10.51.243.154', 1, '1000.00', 168),
(8221, '10.51.243.155', 1, '1000.00', 168),
(8222, '10.51.243.156', 1, '1000.00', 168),
(8223, '10.51.243.157', 1, '1000.00', 168),
(8224, '10.51.243.158', 1, '1000.00', 168),
(8225, '10.51.243.159', 1, '1000.00', 168),
(8226, '10.51.243.160', 1, '1000.00', 168),
(8227, '10.51.243.161', 1, '1000.00', 168),
(8228, '10.51.243.162', 1, '1000.00', 168),
(8229, '10.51.243.163', 1, '1000.00', 168),
(8230, '10.51.243.164', 1, '1000.00', 168),
(8231, '10.51.243.165', 1, '1000.00', 168),
(8232, '10.51.243.166', 1, '1000.00', 168),
(8233, '10.51.243.167', 1, '1000.00', 168),
(8234, '10.51.243.168', 1, '1000.00', 168),
(8235, '10.51.243.169', 1, '1000.00', 168),
(8236, '10.51.243.170', 1, '1000.00', 168),
(8237, '10.51.243.171', 1, '1000.00', 168),
(8238, '10.51.243.172', 1, '1000.00', 168),
(8239, '10.51.243.173', 1, '1000.00', 168),
(8240, '10.51.243.174', 1, '1000.00', 168),
(8241, '10.51.243.175', 1, '1000.00', 168),
(8242, '10.51.243.176', 1, '1000.00', 168),
(8243, '10.51.243.177', 1, '1000.00', 168),
(8244, '10.51.243.178', 1, '1000.00', 168),
(8245, '10.51.243.179', 1, '1000.00', 168),
(8246, '10.51.243.180', 1, '1000.00', 168),
(8247, '10.51.243.181', 1, '1000.00', 168),
(8248, '10.51.243.182', 1, '1000.00', 168),
(8249, '10.51.243.183', 1, '1000.00', 168),
(8250, '10.51.243.184', 1, '1000.00', 168),
(8251, '10.51.243.185', 1, '1000.00', 168),
(8252, '10.51.243.186', 1, '1000.00', 168),
(8253, '10.51.243.187', 1, '1000.00', 168),
(8254, '10.51.243.188', 1, '1000.00', 168),
(8255, '10.51.243.189', 1, '1000.00', 168),
(8256, '10.51.243.190', 1, '1000.00', 168),
(8257, '10.51.243.191', 1, '1000.00', 168),
(8258, '10.51.243.192', 1, '1000.00', 168),
(8259, '10.51.243.193', 1, '1000.00', 168),
(8260, '10.51.243.194', 1, '1000.00', 168),
(8261, '10.51.243.195', 1, '1000.00', 168),
(8262, '10.51.243.196', 1, '1000.00', 168),
(8263, '10.51.243.197', 1, '1000.00', 168),
(8264, '10.51.243.198', 1, '1000.00', 168),
(8265, '10.51.243.199', 1, '1000.00', 168),
(8266, '10.51.243.200', 1, '1000.00', 168),
(8267, '10.51.243.201', 1, '1000.00', 168),
(8268, '10.51.243.202', 1, '1000.00', 168),
(8269, '10.51.243.203', 1, '1000.00', 168),
(8270, '10.51.243.204', 1, '1000.00', 168),
(8271, '10.51.243.205', 1, '1000.00', 168),
(8272, '10.51.243.206', 1, '1000.00', 168),
(8273, '10.51.243.207', 1, '1000.00', 168),
(8274, '10.51.243.208', 1, '1000.00', 168),
(8275, '10.51.243.209', 1, '1000.00', 168),
(8276, '10.51.243.210', 1, '1000.00', 168),
(8277, '10.51.243.211', 1, '1000.00', 168),
(8278, '10.51.243.212', 1, '1000.00', 168),
(8279, '10.51.243.213', 1, '1000.00', 168),
(8280, '10.51.243.214', 1, '1000.00', 168),
(8281, '10.51.243.215', 1, '1000.00', 168),
(8282, '10.51.243.216', 1, '1000.00', 168),
(8283, '10.51.243.217', 1, '1000.00', 168),
(8284, '10.51.243.218', 1, '1000.00', 168),
(8285, '10.51.243.219', 1, '1000.00', 168),
(8286, '10.51.243.220', 1, '1000.00', 168),
(8287, '10.51.243.221', 1, '1000.00', 168),
(8288, '10.51.243.222', 1, '1000.00', 168),
(8289, '10.51.243.223', 1, '1000.00', 168),
(8290, '10.51.243.224', 1, '1000.00', 168),
(8291, '10.51.243.225', 1, '1000.00', 168),
(8292, '10.51.243.226', 1, '1000.00', 168),
(8293, '10.51.243.227', 1, '1000.00', 168),
(8294, '10.51.243.228', 1, '1000.00', 168),
(8295, '10.51.243.229', 1, '1000.00', 168),
(8296, '10.51.243.230', 1, '1000.00', 168),
(8297, '10.51.243.231', 1, '1000.00', 168),
(8298, '10.51.243.232', 1, '1000.00', 168),
(8299, '10.51.243.233', 1, '1000.00', 168),
(8300, '10.51.243.234', 1, '1000.00', 168),
(8301, '10.51.243.235', 1, '1000.00', 168),
(8302, '10.51.243.236', 1, '1000.00', 168),
(8303, '10.51.243.237', 1, '1000.00', 168),
(8304, '10.51.243.238', 1, '1000.00', 168),
(8305, '10.51.243.239', 1, '1000.00', 168),
(8306, '10.51.243.240', 1, '1000.00', 168),
(8307, '10.51.243.241', 1, '1000.00', 168),
(8308, '10.51.243.242', 1, '1000.00', 168),
(8309, '10.51.243.243', 1, '1000.00', 168),
(8310, '10.51.243.244', 1, '1000.00', 168),
(8311, '10.51.243.245', 1, '1000.00', 168),
(8312, '10.51.243.246', 1, '1000.00', 168),
(8313, '10.51.243.247', 1, '1000.00', 168),
(8314, '10.51.243.248', 1, '1000.00', 168),
(8315, '10.51.243.249', 1, '1000.00', 168),
(8316, '10.51.243.250', 1, '1000.00', 168),
(8317, '10.51.243.251', 1, '1000.00', 168),
(8318, '10.51.243.252', 1, '1000.00', 168),
(8319, '10.51.243.253', 1, '1000.00', 168),
(8320, '10.51.243.254', 1, '1000.00', 168),
(8321, '172.28.33.1', 1, '1000.00', 169),
(8322, '172.28.33.2', 1, '1000.00', 169),
(8323, '172.28.33.3', 1, '1000.00', 169),
(8324, '172.28.33.4', 1, '1000.00', 169),
(8325, '172.28.33.5', 1, '1000.00', 169),
(8326, '172.28.33.6', 1, '1000.00', 169),
(8327, '172.28.33.7', 1, '1000.00', 169),
(8328, '172.28.33.8', 1, '1000.00', 169),
(8329, '172.28.33.9', 1, '1000.00', 169),
(8330, '172.28.33.10', 1, '1000.00', 169),
(8331, '172.28.33.11', 1, '1000.00', 169),
(8332, '172.28.33.12', 1, '1000.00', 169),
(8333, '172.28.33.13', 1, '1000.00', 169),
(8334, '172.28.33.14', 1, '1000.00', 169),
(8335, '172.28.33.15', 1, '1000.00', 169),
(8336, '172.28.33.16', 1, '1000.00', 169),
(8337, '172.28.33.17', 1, '1000.00', 169),
(8338, '172.28.33.18', 1, '1000.00', 169),
(8339, '172.28.33.19', 1, '1000.00', 169),
(8340, '172.28.33.20', 1, '1000.00', 169),
(8341, '172.28.33.21', 1, '1000.00', 169),
(8342, '172.28.33.22', 1, '1000.00', 169),
(8343, '172.28.33.23', 1, '1000.00', 169),
(8344, '172.28.33.24', 1, '1000.00', 169),
(8345, '172.28.33.25', 1, '1000.00', 169),
(8346, '172.28.33.26', 1, '1000.00', 169),
(8347, '172.28.33.27', 1, '1000.00', 169),
(8348, '172.28.33.28', 1, '1000.00', 169),
(8349, '172.28.33.29', 1, '1000.00', 169),
(8350, '172.28.33.30', 1, '1000.00', 169),
(8351, '172.28.33.31', 1, '1000.00', 169),
(8352, '172.28.33.32', 1, '1000.00', 169),
(8353, '172.28.33.33', 1, '1000.00', 169),
(8354, '172.28.33.34', 1, '1000.00', 169),
(8355, '172.28.33.35', 1, '1000.00', 169),
(8356, '172.28.33.36', 1, '1000.00', 169),
(8357, '172.28.33.37', 1, '1000.00', 169),
(8358, '172.28.33.38', 1, '1000.00', 169),
(8359, '172.28.33.39', 1, '1000.00', 169),
(8360, '172.28.33.40', 1, '1000.00', 169),
(8361, '172.28.33.41', 1, '1000.00', 169),
(8362, '172.28.33.42', 1, '1000.00', 169),
(8363, '172.28.33.43', 1, '1000.00', 169),
(8364, '172.28.33.44', 1, '1000.00', 169),
(8365, '172.28.33.45', 1, '1000.00', 169),
(8366, '172.28.33.46', 1, '1000.00', 169),
(8367, '172.28.33.47', 1, '1000.00', 169),
(8368, '172.28.33.48', 1, '1000.00', 169),
(8369, '172.28.33.49', 1, '1000.00', 169),
(8370, '172.28.33.50', 1, '1000.00', 169),
(8371, '172.28.33.51', 1, '1000.00', 169),
(8372, '172.28.33.52', 1, '1000.00', 169),
(8373, '172.28.33.53', 1, '1000.00', 169),
(8374, '172.28.33.54', 1, '1000.00', 169),
(8375, '172.28.33.55', 1, '1000.00', 169),
(8376, '172.28.33.56', 1, '1000.00', 169),
(8377, '172.28.33.57', 1, '1000.00', 169),
(8378, '172.28.33.58', 1, '1000.00', 169),
(8379, '172.28.33.59', 1, '1000.00', 169),
(8380, '172.28.33.60', 1, '1000.00', 169),
(8381, '172.28.33.61', 1, '1000.00', 169),
(8382, '172.28.33.62', 1, '1000.00', 169),
(8383, '172.28.33.63', 1, '1000.00', 169),
(8384, '172.28.33.64', 1, '1000.00', 169),
(8385, '172.28.33.65', 1, '1000.00', 169),
(8386, '172.28.33.66', 1, '1000.00', 169),
(8387, '172.28.33.67', 1, '1000.00', 169),
(8388, '172.28.33.68', 1, '1000.00', 169),
(8389, '172.28.33.69', 1, '1000.00', 169),
(8390, '172.28.33.70', 1, '1000.00', 169),
(8391, '172.28.33.71', 1, '1000.00', 169),
(8392, '172.28.33.72', 1, '1000.00', 169),
(8393, '172.28.33.73', 1, '1000.00', 169),
(8394, '172.28.33.74', 1, '1000.00', 169),
(8395, '172.28.33.75', 1, '1000.00', 169),
(8396, '172.28.33.76', 1, '1000.00', 169),
(8397, '172.28.33.77', 1, '1000.00', 169),
(8398, '172.28.33.78', 1, '1000.00', 169),
(8399, '172.28.33.79', 1, '1000.00', 169),
(8400, '172.28.33.80', 1, '1000.00', 169),
(8401, '172.28.33.81', 1, '1000.00', 169),
(8402, '172.28.33.82', 1, '1000.00', 169),
(8403, '172.28.33.83', 1, '1000.00', 169),
(8404, '172.28.33.84', 1, '1000.00', 169),
(8405, '172.28.33.85', 1, '1000.00', 169),
(8406, '172.28.33.86', 1, '1000.00', 169),
(8407, '172.28.33.87', 1, '1000.00', 169),
(8408, '172.28.33.88', 1, '1000.00', 169),
(8409, '172.28.33.89', 1, '1000.00', 169),
(8410, '172.28.33.90', 1, '1000.00', 169),
(8411, '172.28.33.91', 1, '1000.00', 169),
(8412, '172.28.33.92', 1, '1000.00', 169),
(8413, '172.28.33.93', 1, '1000.00', 169),
(8414, '172.28.33.94', 1, '1000.00', 169),
(8415, '172.28.33.95', 1, '1000.00', 169),
(8416, '172.28.33.96', 1, '1000.00', 169),
(8417, '172.28.33.97', 1, '1000.00', 169),
(8418, '172.28.33.98', 1, '1000.00', 169),
(8419, '172.28.33.99', 1, '1000.00', 169),
(8420, '172.28.33.100', 1, '1000.00', 169),
(8421, '172.28.33.101', 1, '1000.00', 169),
(8422, '172.28.33.102', 1, '1000.00', 169),
(8423, '172.28.33.103', 1, '1000.00', 169),
(8424, '172.28.33.104', 1, '1000.00', 169),
(8425, '172.28.33.105', 1, '1000.00', 169),
(8426, '172.28.33.106', 1, '1000.00', 169),
(8427, '172.28.33.107', 1, '1000.00', 169),
(8428, '172.28.33.108', 1, '1000.00', 169),
(8429, '172.28.33.109', 1, '1000.00', 169),
(8430, '172.28.33.110', 1, '1000.00', 169),
(8431, '172.28.33.111', 1, '1000.00', 169),
(8432, '172.28.33.112', 1, '1000.00', 169),
(8433, '172.28.33.113', 1, '1000.00', 169),
(8434, '172.28.33.114', 1, '1000.00', 169),
(8435, '172.28.33.115', 1, '1000.00', 169),
(8436, '172.28.33.116', 1, '1000.00', 169),
(8437, '172.28.33.117', 1, '1000.00', 169),
(8438, '172.28.33.118', 1, '1000.00', 169),
(8439, '172.28.33.119', 1, '1000.00', 169),
(8440, '172.28.33.120', 1, '1000.00', 169),
(8441, '172.28.33.121', 1, '1000.00', 169),
(8442, '172.28.33.122', 1, '1000.00', 169),
(8443, '172.28.33.123', 1, '1000.00', 169),
(8444, '172.28.33.124', 1, '1000.00', 169),
(8445, '172.28.33.125', 1, '1000.00', 169),
(8446, '172.28.33.126', 1, '1000.00', 169),
(8447, '172.28.33.127', 1, '1000.00', 169),
(8448, '172.28.33.128', 1, '1000.00', 169),
(8449, '172.28.33.129', 1, '1000.00', 169),
(8450, '172.28.33.130', 1, '1000.00', 169),
(8451, '172.28.33.131', 1, '1000.00', 169),
(8452, '172.28.33.132', 1, '1000.00', 169),
(8453, '172.28.33.133', 1, '1000.00', 169),
(8454, '172.28.33.134', 1, '1000.00', 169),
(8455, '172.28.33.135', 1, '1000.00', 169),
(8456, '172.28.33.136', 1, '1000.00', 169),
(8457, '172.28.33.137', 1, '1000.00', 169),
(8458, '172.28.33.138', 1, '1000.00', 169),
(8459, '172.28.33.139', 1, '1000.00', 169),
(8460, '172.28.33.140', 1, '1000.00', 169),
(8461, '172.28.33.141', 1, '1000.00', 169),
(8462, '172.28.33.142', 1, '1000.00', 169),
(8463, '172.28.33.143', 1, '1000.00', 169),
(8464, '172.28.33.144', 1, '1000.00', 169),
(8465, '172.28.33.145', 1, '1000.00', 169),
(8466, '172.28.33.146', 1, '1000.00', 169),
(8467, '172.28.33.147', 1, '1000.00', 169),
(8468, '172.28.33.148', 1, '1000.00', 169),
(8469, '172.28.33.149', 1, '1000.00', 169),
(8470, '172.28.33.150', 1, '1000.00', 169),
(8471, '172.28.33.151', 1, '1000.00', 169),
(8472, '172.28.33.152', 1, '1000.00', 169),
(8473, '172.28.33.153', 1, '1000.00', 169),
(8474, '172.28.33.154', 1, '1000.00', 169),
(8475, '172.28.33.155', 1, '1000.00', 169),
(8476, '172.28.33.156', 1, '1000.00', 169),
(8477, '172.28.33.157', 1, '1000.00', 169),
(8478, '172.28.33.158', 1, '1000.00', 169),
(8479, '172.28.33.159', 1, '1000.00', 169),
(8480, '172.28.33.160', 1, '1000.00', 169),
(8481, '172.28.33.161', 1, '1000.00', 169),
(8482, '172.28.33.162', 1, '1000.00', 169),
(8483, '172.28.33.163', 1, '1000.00', 169),
(8484, '172.28.33.164', 1, '1000.00', 169),
(8485, '172.28.33.165', 1, '1000.00', 169),
(8486, '172.28.33.166', 1, '1000.00', 169),
(8487, '172.28.33.167', 1, '1000.00', 169),
(8488, '172.28.33.168', 1, '1000.00', 169),
(8489, '172.28.33.169', 1, '1000.00', 169),
(8490, '172.28.33.170', 1, '1000.00', 169),
(8491, '172.28.33.171', 1, '1000.00', 169),
(8492, '172.28.33.172', 1, '1000.00', 169),
(8493, '172.28.33.173', 1, '1000.00', 169),
(8494, '172.28.33.174', 1, '1000.00', 169),
(8495, '172.28.33.175', 1, '1000.00', 169),
(8496, '172.28.33.176', 1, '1000.00', 169),
(8497, '172.28.33.177', 1, '1000.00', 169),
(8498, '172.28.33.178', 1, '1000.00', 169),
(8499, '172.28.33.179', 1, '1000.00', 169),
(8500, '172.28.33.180', 1, '1000.00', 169),
(8501, '172.28.33.181', 1, '1000.00', 169),
(8502, '172.28.33.182', 1, '1000.00', 169),
(8503, '172.28.33.183', 1, '1000.00', 169),
(8504, '172.28.33.184', 1, '1000.00', 169),
(8505, '172.28.33.185', 1, '1000.00', 169),
(8506, '172.28.33.186', 1, '1000.00', 169),
(8507, '172.28.33.187', 1, '1000.00', 169),
(8508, '172.28.33.188', 1, '1000.00', 169),
(8509, '172.28.33.189', 1, '1000.00', 169),
(8510, '172.28.33.190', 1, '1000.00', 169),
(8511, '172.28.33.191', 1, '1000.00', 169),
(8512, '172.28.33.192', 1, '1000.00', 169),
(8513, '172.28.33.193', 1, '1000.00', 169),
(8514, '172.28.33.194', 1, '1000.00', 169),
(8515, '172.28.33.195', 1, '1000.00', 169),
(8516, '172.28.33.196', 1, '1000.00', 169),
(8517, '172.28.33.197', 1, '1000.00', 169),
(8518, '172.28.33.198', 1, '1000.00', 169),
(8519, '172.28.33.199', 1, '1000.00', 169),
(8520, '172.28.33.200', 1, '1000.00', 169),
(8521, '172.28.33.201', 1, '1000.00', 169),
(8522, '172.28.33.202', 1, '1000.00', 169),
(8523, '172.28.33.203', 1, '1000.00', 169),
(8524, '172.28.33.204', 1, '1000.00', 169),
(8525, '172.28.33.205', 1, '1000.00', 169),
(8526, '172.28.33.206', 1, '1000.00', 169),
(8527, '172.28.33.207', 1, '1000.00', 169),
(8528, '172.28.33.208', 1, '1000.00', 169),
(8529, '172.28.33.209', 1, '1000.00', 169),
(8530, '172.28.33.210', 1, '1000.00', 169),
(8531, '172.28.33.211', 1, '1000.00', 169),
(8532, '172.28.33.212', 1, '1000.00', 169),
(8533, '172.28.33.213', 1, '1000.00', 169),
(8534, '172.28.33.214', 1, '1000.00', 169),
(8535, '172.28.33.215', 1, '1000.00', 169),
(8536, '172.28.33.216', 1, '1000.00', 169),
(8537, '172.28.33.217', 1, '1000.00', 169),
(8538, '172.28.33.218', 1, '1000.00', 169),
(8539, '172.28.33.219', 1, '1000.00', 169),
(8540, '172.28.33.220', 1, '1000.00', 169),
(8541, '172.28.33.221', 1, '1000.00', 169),
(8542, '172.28.33.222', 1, '1000.00', 169),
(8543, '172.28.33.223', 1, '1000.00', 169),
(8544, '172.28.33.224', 1, '1000.00', 169),
(8545, '172.28.33.225', 1, '1000.00', 169),
(8546, '172.28.33.226', 1, '1000.00', 169),
(8547, '172.28.33.227', 1, '1000.00', 169),
(8548, '172.28.33.228', 1, '1000.00', 169),
(8549, '172.28.33.229', 1, '1000.00', 169),
(8550, '172.28.33.230', 1, '1000.00', 169),
(8551, '172.28.33.231', 1, '1000.00', 169),
(8552, '172.28.33.232', 1, '1000.00', 169),
(8553, '172.28.33.233', 1, '1000.00', 169),
(8554, '172.28.33.234', 1, '1000.00', 169),
(8555, '172.28.33.235', 1, '1000.00', 169),
(8556, '172.28.33.236', 1, '1000.00', 169),
(8557, '172.28.33.237', 1, '1000.00', 169),
(8558, '172.28.33.238', 1, '1000.00', 169),
(8559, '172.28.33.239', 1, '1000.00', 169),
(8560, '172.28.33.240', 1, '1000.00', 169),
(8561, '172.28.33.241', 1, '1000.00', 169),
(8562, '172.28.33.242', 1, '1000.00', 169),
(8563, '172.28.33.243', 1, '1000.00', 169),
(8564, '172.28.33.244', 1, '1000.00', 169),
(8565, '172.28.33.245', 1, '1000.00', 169),
(8566, '172.28.33.246', 1, '1000.00', 169),
(8567, '172.28.33.247', 1, '1000.00', 169),
(8568, '172.28.33.248', 1, '1000.00', 169),
(8569, '172.28.33.249', 1, '1000.00', 169),
(8570, '172.28.33.250', 1, '1000.00', 169),
(8571, '172.28.33.251', 1, '1000.00', 169),
(8572, '172.28.33.252', 1, '1000.00', 169),
(8573, '172.28.33.253', 1, '1000.00', 169),
(8574, '172.28.33.254', 1, '1000.00', 169),
(8575, '172.30.0.1', 1, '1000.00', 171),
(8576, '172.30.0.2', 1, '1000.00', 171),
(8577, '172.30.0.3', 1, '1000.00', 171),
(8578, '172.30.0.4', 1, '1000.00', 171),
(8579, '172.30.0.5', 1, '1000.00', 171),
(8580, '172.30.0.6', 1, '1000.00', 171),
(8581, '172.30.0.7', 1, '1000.00', 171),
(8582, '172.30.0.8', 1, '1000.00', 171),
(8583, '172.30.0.9', 1, '1000.00', 171),
(8584, '172.30.0.10', 1, '1000.00', 171),
(8585, '172.30.0.11', 1, '1000.00', 171),
(8586, '172.30.0.12', 1, '1000.00', 171),
(8587, '172.30.0.13', 1, '1000.00', 171),
(8588, '172.30.0.14', 1, '1000.00', 171),
(8589, '172.30.0.15', 1, '1000.00', 171),
(8590, '172.30.0.16', 1, '1000.00', 171),
(8591, '172.30.0.17', 1, '1000.00', 171),
(8592, '172.30.0.18', 1, '1000.00', 171),
(8593, '172.30.0.19', 1, '1000.00', 171),
(8594, '172.30.0.20', 1, '1000.00', 171),
(8595, '172.30.0.21', 1, '1000.00', 171),
(8596, '172.30.0.22', 1, '1000.00', 171),
(8597, '172.30.0.23', 1, '1000.00', 171),
(8598, '172.30.0.24', 1, '1000.00', 171),
(8599, '172.30.0.25', 1, '1000.00', 171),
(8600, '172.30.0.26', 1, '1000.00', 171),
(8601, '172.30.0.27', 1, '1000.00', 171),
(8602, '172.30.0.28', 1, '1000.00', 171),
(8603, '172.30.0.29', 1, '1000.00', 171),
(8604, '172.30.0.30', 1, '1000.00', 171),
(8605, '172.30.0.31', 1, '1000.00', 171),
(8606, '172.30.0.32', 1, '1000.00', 171),
(8607, '172.30.0.33', 1, '1000.00', 171),
(8608, '172.30.0.34', 1, '1000.00', 171),
(8609, '172.30.0.35', 1, '1000.00', 171),
(8610, '172.30.0.36', 1, '1000.00', 171),
(8611, '172.30.0.37', 1, '1000.00', 171),
(8612, '172.30.0.38', 1, '1000.00', 171),
(8613, '172.30.0.39', 1, '1000.00', 171),
(8614, '172.30.0.40', 1, '1000.00', 171),
(8615, '172.30.0.41', 1, '1000.00', 171),
(8616, '172.30.0.42', 1, '1000.00', 171),
(8617, '172.30.0.43', 1, '1000.00', 171),
(8618, '172.30.0.44', 1, '1000.00', 171),
(8619, '172.30.0.45', 1, '1000.00', 171),
(8620, '172.30.0.46', 1, '1000.00', 171),
(8621, '172.30.0.47', 1, '1000.00', 171),
(8622, '172.30.0.48', 1, '1000.00', 171),
(8623, '172.30.0.49', 1, '1000.00', 171),
(8624, '172.30.0.50', 1, '1000.00', 171),
(8625, '172.30.0.51', 1, '1000.00', 171),
(8626, '172.30.0.52', 1, '1000.00', 171),
(8627, '172.30.0.53', 1, '1000.00', 171),
(8628, '172.30.0.54', 1, '1000.00', 171),
(8629, '172.30.0.55', 1, '1000.00', 171),
(8630, '172.30.0.56', 1, '1000.00', 171),
(8631, '172.30.0.57', 1, '1000.00', 171),
(8632, '172.30.0.58', 1, '1000.00', 171),
(8633, '172.30.0.59', 1, '1000.00', 171),
(8634, '172.30.0.60', 1, '1000.00', 171),
(8635, '172.30.0.61', 1, '1000.00', 171),
(8636, '172.30.0.62', 1, '1000.00', 171),
(8637, '172.30.0.63', 1, '1000.00', 171),
(8638, '172.30.0.64', 1, '1000.00', 171),
(8639, '172.30.0.65', 1, '1000.00', 171),
(8640, '172.30.0.66', 1, '1000.00', 171),
(8641, '172.30.0.67', 1, '1000.00', 171),
(8642, '172.30.0.68', 1, '1000.00', 171),
(8643, '172.30.0.69', 1, '1000.00', 171),
(8644, '172.30.0.70', 1, '1000.00', 171),
(8645, '172.30.0.71', 1, '1000.00', 171),
(8646, '172.30.0.72', 1, '1000.00', 171),
(8647, '172.30.0.73', 1, '1000.00', 171),
(8648, '172.30.0.74', 1, '1000.00', 171),
(8649, '172.30.0.75', 1, '1000.00', 171),
(8650, '172.30.0.76', 1, '1000.00', 171),
(8651, '172.30.0.77', 1, '1000.00', 171),
(8652, '172.30.0.78', 1, '1000.00', 171),
(8653, '172.30.0.79', 1, '1000.00', 171),
(8654, '172.30.0.80', 1, '1000.00', 171),
(8655, '172.30.0.81', 1, '1000.00', 171),
(8656, '172.30.0.82', 1, '1000.00', 171),
(8657, '172.30.0.83', 1, '1000.00', 171),
(8658, '172.30.0.84', 1, '1000.00', 171),
(8659, '172.30.0.85', 1, '1000.00', 171),
(8660, '172.30.0.86', 1, '1000.00', 171),
(8661, '172.30.0.87', 1, '1000.00', 171),
(8662, '172.30.0.88', 1, '1000.00', 171),
(8663, '172.30.0.89', 1, '1000.00', 171),
(8664, '172.30.0.90', 1, '1000.00', 171),
(8665, '172.30.0.91', 1, '1000.00', 171),
(8666, '172.30.0.92', 1, '1000.00', 171),
(8667, '172.30.0.93', 1, '1000.00', 171),
(8668, '172.30.0.94', 1, '1000.00', 171),
(8669, '172.30.0.95', 1, '1000.00', 171),
(8670, '172.30.0.96', 1, '1000.00', 171),
(8671, '172.30.0.97', 1, '1000.00', 171),
(8672, '172.30.0.98', 1, '1000.00', 171),
(8673, '172.30.0.99', 1, '1000.00', 171),
(8674, '172.30.0.100', 1, '1000.00', 171),
(8675, '172.30.0.101', 1, '1000.00', 171),
(8676, '172.30.0.102', 1, '1000.00', 171),
(8677, '172.30.0.103', 1, '1000.00', 171),
(8678, '172.30.0.104', 1, '1000.00', 171),
(8679, '172.30.0.105', 1, '1000.00', 171),
(8680, '172.30.0.106', 1, '1000.00', 171),
(8681, '172.30.0.107', 1, '1000.00', 171),
(8682, '172.30.0.108', 1, '1000.00', 171),
(8683, '172.30.0.109', 1, '1000.00', 171),
(8684, '172.30.0.110', 1, '1000.00', 171),
(8685, '172.30.0.111', 1, '1000.00', 171),
(8686, '172.30.0.112', 1, '1000.00', 171),
(8687, '172.30.0.113', 1, '1000.00', 171),
(8688, '172.30.0.114', 1, '1000.00', 171),
(8689, '172.30.0.115', 1, '1000.00', 171),
(8690, '172.30.0.116', 1, '1000.00', 171),
(8691, '172.30.0.117', 1, '1000.00', 171),
(8692, '172.30.0.118', 1, '1000.00', 171),
(8693, '172.30.0.119', 1, '1000.00', 171),
(8694, '172.30.0.120', 1, '1000.00', 171),
(8695, '172.30.0.121', 1, '1000.00', 171),
(8696, '172.30.0.122', 1, '1000.00', 171),
(8697, '172.30.0.123', 1, '1000.00', 171),
(8698, '172.30.0.124', 1, '1000.00', 171),
(8699, '172.30.0.125', 1, '1000.00', 171),
(8700, '172.30.0.126', 1, '1000.00', 171),
(8701, '172.30.0.127', 1, '1000.00', 171),
(8702, '172.30.0.128', 1, '1000.00', 171),
(8703, '172.30.0.129', 1, '1000.00', 171),
(8704, '172.30.0.130', 1, '1000.00', 171),
(8705, '172.30.0.131', 1, '1000.00', 171),
(8706, '172.30.0.132', 1, '1000.00', 171),
(8707, '172.30.0.133', 1, '1000.00', 171),
(8708, '172.30.0.134', 1, '1000.00', 171),
(8709, '172.30.0.135', 1, '1000.00', 171),
(8710, '172.30.0.136', 1, '1000.00', 171),
(8711, '172.30.0.137', 1, '1000.00', 171),
(8712, '172.30.0.138', 1, '1000.00', 171),
(8713, '172.30.0.139', 1, '1000.00', 171),
(8714, '172.30.0.140', 1, '1000.00', 171),
(8715, '172.30.0.141', 1, '1000.00', 171),
(8716, '172.30.0.142', 1, '1000.00', 171),
(8717, '172.30.0.143', 1, '1000.00', 171),
(8718, '172.30.0.144', 1, '1000.00', 171),
(8719, '172.30.0.145', 1, '1000.00', 171),
(8720, '172.30.0.146', 1, '1000.00', 171),
(8721, '172.30.0.147', 1, '1000.00', 171),
(8722, '172.30.0.148', 1, '1000.00', 171),
(8723, '172.30.0.149', 1, '1000.00', 171),
(8724, '172.30.0.150', 1, '1000.00', 171),
(8725, '172.30.0.151', 1, '1000.00', 171),
(8726, '172.30.0.152', 1, '1000.00', 171),
(8727, '172.30.0.153', 1, '1000.00', 171),
(8728, '172.30.0.154', 1, '1000.00', 171),
(8729, '172.30.0.155', 1, '1000.00', 171),
(8730, '172.30.0.156', 1, '1000.00', 171),
(8731, '172.30.0.157', 1, '1000.00', 171),
(8732, '172.30.0.158', 1, '1000.00', 171),
(8733, '172.30.0.159', 1, '1000.00', 171),
(8734, '172.30.0.160', 1, '1000.00', 171),
(8735, '172.30.0.161', 1, '1000.00', 171),
(8736, '172.30.0.162', 1, '1000.00', 171),
(8737, '172.30.0.163', 1, '1000.00', 171),
(8738, '172.30.0.164', 1, '1000.00', 171),
(8739, '172.30.0.165', 1, '1000.00', 171),
(8740, '172.30.0.166', 1, '1000.00', 171),
(8741, '172.30.0.167', 1, '1000.00', 171),
(8742, '172.30.0.168', 1, '1000.00', 171),
(8743, '172.30.0.169', 1, '1000.00', 171),
(8744, '172.30.0.170', 1, '1000.00', 171),
(8745, '172.30.0.171', 1, '1000.00', 171),
(8746, '172.30.0.172', 1, '1000.00', 171),
(8747, '172.30.0.173', 1, '1000.00', 171),
(8748, '172.30.0.174', 1, '1000.00', 171),
(8749, '172.30.0.175', 1, '1000.00', 171),
(8750, '172.30.0.176', 1, '1000.00', 171),
(8751, '172.30.0.177', 1, '1000.00', 171),
(8752, '172.30.0.178', 1, '1000.00', 171),
(8753, '172.30.0.179', 1, '1000.00', 171),
(8754, '172.30.0.180', 1, '1000.00', 171),
(8755, '172.30.0.181', 1, '1000.00', 171),
(8756, '172.30.0.182', 1, '1000.00', 171),
(8757, '172.30.0.183', 1, '1000.00', 171),
(8758, '172.30.0.184', 1, '1000.00', 171),
(8759, '172.30.0.185', 1, '1000.00', 171),
(8760, '172.30.0.186', 1, '1000.00', 171),
(8761, '172.30.0.187', 1, '1000.00', 171),
(8762, '172.30.0.188', 1, '1000.00', 171),
(8763, '172.30.0.189', 1, '1000.00', 171),
(8764, '172.30.0.190', 1, '1000.00', 171),
(8765, '172.30.0.191', 1, '1000.00', 171),
(8766, '172.30.0.192', 1, '1000.00', 171),
(8767, '172.30.0.193', 1, '1000.00', 171),
(8768, '172.30.0.194', 1, '1000.00', 171),
(8769, '172.30.0.195', 1, '1000.00', 171),
(8770, '172.30.0.196', 1, '1000.00', 171),
(8771, '172.30.0.197', 1, '1000.00', 171),
(8772, '172.30.0.198', 1, '1000.00', 171),
(8773, '172.30.0.199', 1, '1000.00', 171),
(8774, '172.30.0.200', 1, '1000.00', 171),
(8775, '172.30.0.201', 1, '1000.00', 171),
(8776, '172.30.0.202', 1, '1000.00', 171),
(8777, '172.30.0.203', 1, '1000.00', 171),
(8778, '172.30.0.204', 1, '1000.00', 171),
(8779, '172.30.0.205', 1, '1000.00', 171),
(8780, '172.30.0.206', 1, '1000.00', 171),
(8781, '172.30.0.207', 1, '1000.00', 171),
(8782, '172.30.0.208', 1, '1000.00', 171),
(8783, '172.30.0.209', 1, '1000.00', 171),
(8784, '172.30.0.210', 1, '1000.00', 171),
(8785, '172.30.0.211', 1, '1000.00', 171),
(8786, '172.30.0.212', 1, '1000.00', 171),
(8787, '172.30.0.213', 1, '1000.00', 171),
(8788, '172.30.0.214', 1, '1000.00', 171),
(8789, '172.30.0.215', 1, '1000.00', 171),
(8790, '172.30.0.216', 1, '1000.00', 171),
(8791, '172.30.0.217', 1, '1000.00', 171),
(8792, '172.30.0.218', 1, '1000.00', 171),
(8793, '172.30.0.219', 1, '1000.00', 171),
(8794, '172.30.0.220', 1, '1000.00', 171),
(8795, '172.30.0.221', 1, '1000.00', 171),
(8796, '172.30.0.222', 1, '1000.00', 171),
(8797, '172.30.0.223', 1, '1000.00', 171),
(8798, '172.30.0.224', 1, '1000.00', 171),
(8799, '172.30.0.225', 1, '1000.00', 171),
(8800, '172.30.0.226', 1, '1000.00', 171),
(8801, '172.30.0.227', 1, '1000.00', 171),
(8802, '172.30.0.228', 1, '1000.00', 171),
(8803, '172.30.0.229', 1, '1000.00', 171),
(8804, '172.30.0.230', 1, '1000.00', 171),
(8805, '172.30.0.231', 1, '1000.00', 171),
(8806, '172.30.0.232', 1, '1000.00', 171),
(8807, '172.30.0.233', 1, '1000.00', 171),
(8808, '172.30.0.234', 1, '1000.00', 171),
(8809, '172.30.0.235', 1, '1000.00', 171),
(8810, '172.30.0.236', 1, '1000.00', 171),
(8811, '172.30.0.237', 1, '1000.00', 171),
(8812, '172.30.0.238', 1, '1000.00', 171),
(8813, '172.30.0.239', 1, '1000.00', 171),
(8814, '172.30.0.240', 1, '1000.00', 171),
(8815, '172.30.0.241', 1, '1000.00', 171),
(8816, '172.30.0.242', 1, '1000.00', 171),
(8817, '172.30.0.243', 1, '1000.00', 171),
(8818, '172.30.0.244', 1, '1000.00', 171),
(8819, '172.30.0.245', 1, '1000.00', 171),
(8820, '172.30.0.246', 1, '1000.00', 171),
(8821, '172.30.0.247', 1, '1000.00', 171),
(8822, '172.30.0.248', 1, '1000.00', 171),
(8823, '172.30.0.249', 1, '1000.00', 171),
(8824, '172.30.0.250', 1, '1000.00', 171),
(8825, '172.30.0.251', 1, '1000.00', 171),
(8826, '172.30.0.252', 1, '1000.00', 171),
(8827, '172.30.0.253', 1, '1000.00', 171),
(8828, '172.30.0.254', 1, '1000.00', 171),
(8829, '172.28.19.1', 1, '1000.00', 171),
(8830, '172.28.19.2', 1, '1000.00', 171),
(8831, '172.28.19.3', 1, '1000.00', 171),
(8832, '172.28.19.4', 1, '1000.00', 171),
(8833, '172.28.19.5', 1, '1000.00', 171),
(8834, '172.28.19.6', 1, '1000.00', 171),
(8835, '172.28.19.7', 1, '1000.00', 171),
(8836, '172.28.19.8', 1, '1000.00', 171),
(8837, '172.28.19.9', 1, '1000.00', 171),
(8838, '172.28.19.10', 1, '1000.00', 171),
(8839, '172.28.19.11', 1, '1000.00', 171),
(8840, '172.28.19.12', 1, '1000.00', 171),
(8841, '172.28.19.13', 1, '1000.00', 171),
(8842, '172.28.19.14', 1, '1000.00', 171),
(8843, '172.28.19.15', 1, '1000.00', 171),
(8844, '172.28.19.16', 1, '1000.00', 171),
(8845, '172.28.19.17', 1, '1000.00', 171),
(8846, '172.28.19.18', 1, '1000.00', 171),
(8847, '172.28.19.19', 1, '1000.00', 171),
(8848, '172.28.19.20', 1, '1000.00', 171),
(8849, '172.28.19.21', 1, '1000.00', 171),
(8850, '172.28.19.22', 1, '1000.00', 171),
(8851, '172.28.19.23', 1, '1000.00', 171),
(8852, '172.28.19.24', 1, '1000.00', 171),
(8853, '172.28.19.25', 1, '1000.00', 171),
(8854, '172.28.19.26', 1, '1000.00', 171),
(8855, '172.28.19.27', 1, '1000.00', 171),
(8856, '172.28.19.28', 1, '1000.00', 171),
(8857, '172.28.19.29', 1, '1000.00', 171),
(8858, '172.28.19.30', 1, '1000.00', 171),
(8859, '172.28.19.31', 1, '1000.00', 171),
(8860, '172.28.19.32', 1, '1000.00', 171),
(8861, '172.28.19.33', 1, '1000.00', 171),
(8862, '172.28.19.34', 1, '1000.00', 171),
(8863, '172.28.19.35', 1, '1000.00', 171),
(8864, '172.28.19.36', 1, '1000.00', 171),
(8865, '172.28.19.37', 1, '1000.00', 171),
(8866, '172.28.19.38', 1, '1000.00', 171),
(8867, '172.28.19.39', 1, '1000.00', 171),
(8868, '172.28.19.40', 1, '1000.00', 171),
(8869, '172.28.19.41', 1, '1000.00', 171),
(8870, '172.28.19.42', 1, '1000.00', 171),
(8871, '172.28.19.43', 1, '1000.00', 171),
(8872, '172.28.19.44', 1, '1000.00', 171),
(8873, '172.28.19.45', 1, '1000.00', 171),
(8874, '172.28.19.46', 1, '1000.00', 171),
(8875, '172.28.19.47', 1, '1000.00', 171),
(8876, '172.28.19.48', 1, '1000.00', 171),
(8877, '172.28.19.49', 1, '1000.00', 171),
(8878, '172.28.19.50', 1, '1000.00', 171),
(8879, '172.28.19.51', 1, '1000.00', 171),
(8880, '172.28.19.52', 1, '1000.00', 171),
(8881, '172.28.19.53', 1, '1000.00', 171),
(8882, '172.28.19.54', 1, '1000.00', 171),
(8883, '172.28.19.55', 1, '1000.00', 171),
(8884, '172.28.19.56', 1, '1000.00', 171),
(8885, '172.28.19.57', 1, '1000.00', 171),
(8886, '172.28.19.58', 1, '1000.00', 171),
(8887, '172.28.19.59', 1, '1000.00', 171),
(8888, '172.28.19.60', 1, '1000.00', 171),
(8889, '172.28.19.61', 1, '1000.00', 171),
(8890, '172.28.19.62', 1, '1000.00', 171),
(8891, '172.28.19.63', 1, '1000.00', 171),
(8892, '172.28.19.64', 1, '1000.00', 171),
(8893, '172.28.19.65', 1, '1000.00', 171),
(8894, '172.28.19.66', 1, '1000.00', 171),
(8895, '172.28.19.67', 1, '1000.00', 171),
(8896, '172.28.19.68', 1, '1000.00', 171),
(8897, '172.28.19.69', 1, '1000.00', 171),
(8898, '172.28.19.70', 1, '1000.00', 171),
(8899, '172.28.19.71', 1, '1000.00', 171),
(8900, '172.28.19.72', 1, '1000.00', 171),
(8901, '172.28.19.73', 1, '1000.00', 171),
(8902, '172.28.19.74', 1, '1000.00', 171),
(8903, '172.28.19.75', 1, '1000.00', 171),
(8904, '172.28.19.76', 1, '1000.00', 171),
(8905, '172.28.19.77', 1, '1000.00', 171),
(8906, '172.28.19.78', 1, '1000.00', 171),
(8907, '172.28.19.79', 1, '1000.00', 171),
(8908, '172.28.19.80', 1, '1000.00', 171),
(8909, '172.28.19.81', 1, '1000.00', 171),
(8910, '172.28.19.82', 1, '1000.00', 171),
(8911, '172.28.19.83', 1, '1000.00', 171),
(8912, '172.28.19.84', 1, '1000.00', 171),
(8913, '172.28.19.85', 1, '1000.00', 171),
(8914, '172.28.19.86', 1, '1000.00', 171),
(8915, '172.28.19.87', 1, '1000.00', 171),
(8916, '172.28.19.88', 1, '1000.00', 171),
(8917, '172.28.19.89', 1, '1000.00', 171),
(8918, '172.28.19.90', 1, '1000.00', 171),
(8919, '172.28.19.91', 1, '1000.00', 171),
(8920, '172.28.19.92', 1, '1000.00', 171),
(8921, '172.28.19.93', 1, '1000.00', 171),
(8922, '172.28.19.94', 1, '1000.00', 171),
(8923, '172.28.19.95', 1, '1000.00', 171),
(8924, '172.28.19.96', 1, '1000.00', 171),
(8925, '172.28.19.97', 1, '1000.00', 171),
(8926, '172.28.19.98', 1, '1000.00', 171),
(8927, '172.28.19.99', 1, '1000.00', 171),
(8928, '172.28.19.100', 1, '1000.00', 171),
(8929, '172.28.19.101', 1, '1000.00', 171),
(8930, '172.28.19.102', 1, '1000.00', 171),
(8931, '172.28.19.103', 1, '1000.00', 171),
(8932, '172.28.19.104', 1, '1000.00', 171),
(8933, '172.28.19.105', 1, '1000.00', 171),
(8934, '172.28.19.106', 1, '1000.00', 171),
(8935, '172.28.19.107', 1, '1000.00', 171),
(8936, '172.28.19.108', 1, '1000.00', 171),
(8937, '172.28.19.109', 1, '1000.00', 171),
(8938, '172.28.19.110', 1, '1000.00', 171),
(8939, '172.28.19.111', 1, '1000.00', 171),
(8940, '172.28.19.112', 1, '1000.00', 171),
(8941, '172.28.19.113', 1, '1000.00', 171),
(8942, '172.28.19.114', 1, '1000.00', 171),
(8943, '172.28.19.115', 1, '1000.00', 171),
(8944, '172.28.19.116', 1, '1000.00', 171),
(8945, '172.28.19.117', 1, '1000.00', 171),
(8946, '172.28.19.118', 1, '1000.00', 171),
(8947, '172.28.19.119', 1, '1000.00', 171),
(8948, '172.28.19.120', 1, '1000.00', 171),
(8949, '172.28.19.121', 1, '1000.00', 171),
(8950, '172.28.19.122', 1, '1000.00', 171),
(8951, '172.28.19.123', 1, '1000.00', 171),
(8952, '172.28.19.124', 1, '1000.00', 171),
(8953, '172.28.19.125', 1, '1000.00', 171),
(8954, '172.28.19.126', 1, '1000.00', 171),
(8955, '172.28.19.127', 1, '1000.00', 171),
(8956, '172.28.19.128', 1, '1000.00', 171),
(8957, '172.28.19.129', 1, '1000.00', 171),
(8958, '172.28.19.130', 1, '1000.00', 171),
(8959, '172.28.19.131', 1, '1000.00', 171),
(8960, '172.28.19.132', 1, '1000.00', 171),
(8961, '172.28.19.133', 1, '1000.00', 171),
(8962, '172.28.19.134', 1, '1000.00', 171),
(8963, '172.28.19.135', 1, '1000.00', 171),
(8964, '172.28.19.136', 1, '1000.00', 171),
(8965, '172.28.19.137', 1, '1000.00', 171),
(8966, '172.28.19.138', 1, '1000.00', 171),
(8967, '172.28.19.139', 1, '1000.00', 171),
(8968, '172.28.19.140', 1, '1000.00', 171),
(8969, '172.28.19.141', 1, '1000.00', 171),
(8970, '172.28.19.142', 1, '1000.00', 171),
(8971, '172.28.19.143', 1, '1000.00', 171),
(8972, '172.28.19.144', 1, '1000.00', 171),
(8973, '172.28.19.145', 1, '1000.00', 171),
(8974, '172.28.19.146', 1, '1000.00', 171),
(8975, '172.28.19.147', 1, '1000.00', 171),
(8976, '172.28.19.148', 1, '1000.00', 171),
(8977, '172.28.19.149', 1, '1000.00', 171),
(8978, '172.28.19.150', 1, '1000.00', 171),
(8979, '172.28.19.151', 1, '1000.00', 171),
(8980, '172.28.19.152', 1, '1000.00', 171),
(8981, '172.28.19.153', 1, '1000.00', 171),
(8982, '172.28.19.154', 1, '1000.00', 171),
(8983, '172.28.19.155', 1, '1000.00', 171),
(8984, '172.28.19.156', 1, '1000.00', 171),
(8985, '172.28.19.157', 1, '1000.00', 171),
(8986, '172.28.19.158', 1, '1000.00', 171),
(8987, '172.28.19.159', 1, '1000.00', 171),
(8988, '172.28.19.160', 1, '1000.00', 171),
(8989, '172.28.19.161', 1, '1000.00', 171),
(8990, '172.28.19.162', 1, '1000.00', 171),
(8991, '172.28.19.163', 1, '1000.00', 171),
(8992, '172.28.19.164', 1, '1000.00', 171),
(8993, '172.28.19.165', 1, '1000.00', 171),
(8994, '172.28.19.166', 1, '1000.00', 171),
(8995, '172.28.19.167', 1, '1000.00', 171),
(8996, '172.28.19.168', 1, '1000.00', 171),
(8997, '172.28.19.169', 1, '1000.00', 171),
(8998, '172.28.19.170', 1, '1000.00', 171),
(8999, '172.28.19.171', 1, '1000.00', 171),
(9000, '172.28.19.172', 1, '1000.00', 171),
(9001, '172.28.19.173', 1, '1000.00', 171),
(9002, '172.28.19.174', 1, '1000.00', 171),
(9003, '172.28.19.175', 1, '1000.00', 171),
(9004, '172.28.19.176', 1, '1000.00', 171),
(9005, '172.28.19.177', 1, '1000.00', 171),
(9006, '172.28.19.178', 1, '1000.00', 171),
(9007, '172.28.19.179', 1, '1000.00', 171),
(9008, '172.28.19.180', 1, '1000.00', 171),
(9009, '172.28.19.181', 1, '1000.00', 171),
(9010, '172.28.19.182', 1, '1000.00', 171),
(9011, '172.28.19.183', 1, '1000.00', 171),
(9012, '172.28.19.184', 1, '1000.00', 171),
(9013, '172.28.19.185', 1, '1000.00', 171),
(9014, '172.28.19.186', 1, '1000.00', 171),
(9015, '172.28.19.187', 1, '1000.00', 171),
(9016, '172.28.19.188', 1, '1000.00', 171),
(9017, '172.28.19.189', 1, '1000.00', 171),
(9018, '172.28.19.190', 1, '1000.00', 171),
(9019, '172.28.19.191', 1, '1000.00', 171),
(9020, '172.28.19.192', 1, '1000.00', 171),
(9021, '172.28.19.193', 1, '1000.00', 171),
(9022, '172.28.19.194', 1, '1000.00', 171),
(9023, '172.28.19.195', 1, '1000.00', 171),
(9024, '172.28.19.196', 1, '1000.00', 171),
(9025, '172.28.19.197', 1, '1000.00', 171),
(9026, '172.28.19.198', 1, '1000.00', 171),
(9027, '172.28.19.199', 1, '1000.00', 171),
(9028, '172.28.19.200', 1, '1000.00', 171),
(9029, '172.28.19.201', 1, '1000.00', 171),
(9030, '172.28.19.202', 1, '1000.00', 171),
(9031, '172.28.19.203', 1, '1000.00', 171),
(9032, '172.28.19.204', 1, '1000.00', 171),
(9033, '172.28.19.205', 1, '1000.00', 171),
(9034, '172.28.19.206', 1, '1000.00', 171),
(9035, '172.28.19.207', 1, '1000.00', 171),
(9036, '172.28.19.208', 1, '1000.00', 171),
(9037, '172.28.19.209', 1, '1000.00', 171),
(9038, '172.28.19.210', 1, '1000.00', 171),
(9039, '172.28.19.211', 1, '1000.00', 171),
(9040, '172.28.19.212', 1, '1000.00', 171),
(9041, '172.28.19.213', 1, '1000.00', 171),
(9042, '172.28.19.214', 1, '1000.00', 171),
(9043, '172.28.19.215', 1, '1000.00', 171),
(9044, '172.28.19.216', 1, '1000.00', 171),
(9045, '172.28.19.217', 1, '1000.00', 171),
(9046, '172.28.19.218', 1, '1000.00', 171),
(9047, '172.28.19.219', 1, '1000.00', 171),
(9048, '172.28.19.220', 1, '1000.00', 171),
(9049, '172.28.19.221', 1, '1000.00', 171),
(9050, '172.28.19.222', 1, '1000.00', 171),
(9051, '172.28.19.223', 1, '1000.00', 171),
(9052, '172.28.19.224', 1, '1000.00', 171),
(9053, '172.28.19.225', 1, '1000.00', 171),
(9054, '172.28.19.226', 1, '1000.00', 171),
(9055, '172.28.19.227', 1, '1000.00', 171),
(9056, '172.28.19.228', 1, '1000.00', 171),
(9057, '172.28.19.229', 1, '1000.00', 171),
(9058, '172.28.19.230', 1, '1000.00', 171),
(9059, '172.28.19.231', 1, '1000.00', 171),
(9060, '172.28.19.232', 1, '1000.00', 171),
(9061, '172.28.19.233', 1, '1000.00', 171),
(9062, '172.28.19.234', 1, '1000.00', 171),
(9063, '172.28.19.235', 1, '1000.00', 171),
(9064, '172.28.19.236', 1, '1000.00', 171),
(9065, '172.28.19.237', 1, '1000.00', 171),
(9066, '172.28.19.238', 1, '1000.00', 171),
(9067, '172.28.19.239', 1, '1000.00', 171),
(9068, '172.28.19.240', 1, '1000.00', 171),
(9069, '172.28.19.241', 1, '1000.00', 171),
(9070, '172.28.19.242', 1, '1000.00', 171),
(9071, '172.28.19.243', 1, '1000.00', 171),
(9072, '172.28.19.244', 1, '1000.00', 171),
(9073, '172.28.19.245', 1, '1000.00', 171),
(9074, '172.28.19.246', 1, '1000.00', 171),
(9075, '172.28.19.247', 1, '1000.00', 171),
(9076, '172.28.19.248', 1, '1000.00', 171),
(9077, '172.28.19.249', 1, '1000.00', 171),
(9078, '172.28.19.250', 1, '1000.00', 171),
(9079, '172.28.19.251', 1, '1000.00', 171),
(9080, '172.28.19.252', 1, '1000.00', 171),
(9081, '172.28.19.253', 1, '1000.00', 171),
(9082, '172.28.19.254', 1, '1000.00', 171),
(9083, '10.51.192.21', 3, NULL, 49);

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL,
  `language` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `translation` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `language`, `translation`) VALUES
(1, 'hy', 'Ծառայություններ'),
(2, 'hy', 'Ստեղծեք Ծառայություն'),
(3, 'en', 'Выход'),
(3, 'hy', 'Выход'),
(4, 'en', 'FastNet'),
(4, 'hy', 'FastNet'),
(5, 'en', 'Կարգավորումներ'),
(5, 'hy', 'Կարգավորումներ'),
(6, 'hy', 'Тарифы'),
(7, 'hy', 'Услуги'),
(8, 'hy', 'Акции'),
(9, 'hy', 'Клиенты'),
(10, 'hy', 'Сотрудники'),
(11, 'hy', 'Товары'),
(12, 'hy', 'Оплаты'),
(13, 'hy', 'Справочник'),
(14, 'hy', 'Лиды'),
(15, 'hy', 'Сделки'),
(16, 'hy', 'Контакты'),
(17, 'hy', 'Компании'),
(18, 'hy', 'Департаменты'),
(19, 'hy', 'Должности'),
(20, 'hy', 'Роли'),
(21, 'hy', 'Персоны'),
(22, 'hy', 'Գործարքներ'),
(23, 'hy', 'ՎՃարումներ'),
(24, 'hy', 'Հաճախորդներ'),
(25, 'hy', 'Բազային կայաններ'),
(26, 'hy', 'Դատա'),
(27, 'hy', 'Գոտիներ'),
(28, 'hy', 'Զեղչեր'),
(29, 'en', 'ID'),
(29, 'hy', 'ID'),
(30, 'en', 'Имя пользователя'),
(30, 'hy', 'Имя пользователя'),
(31, 'en', 'Адрес эл. почты'),
(31, 'hy', 'Адрес эл. почты'),
(32, 'en', 'Статус'),
(32, 'hy', 'Статус'),
(33, 'en', 'Роль'),
(33, 'hy', 'Роль'),
(34, 'en', 'Создано'),
(34, 'hy', 'Создано'),
(35, 'en', 'Обновлено'),
(35, 'hy', 'Обновлено'),
(36, 'hy', 'Ստեղծել Ծառայություն'),
(37, 'hy', 'Ընտրել'),
(38, 'hy', 'Տան համար'),
(39, 'hy', 'Բիզնեսի համար'),
(40, 'hy', 'Ակտիվ'),
(41, 'hy', 'Պահպանել'),
(42, 'en', 'Կարգավորումեր'),
(42, 'hy', 'Կարգավորումեր'),
(43, 'en', 'Поиск...'),
(43, 'hy', 'Поиск...'),
(44, 'en', 'IP Հասցե'),
(44, 'hy', 'IP Հասցե'),
(45, 'en', 'Ավելացնել'),
(45, 'hy', 'Ավելացնել'),
(46, 'en', 'Категория канала'),
(46, 'hy', 'Категория канала'),
(47, 'en', 'Качество канала'),
(47, 'hy', 'Качество канала'),
(48, 'en', 'Язык трансляции канала'),
(48, 'hy', 'Язык трансляции канала'),
(49, 'en', 'TV Канал'),
(49, 'hy', 'TV Канал'),
(50, 'en', 'TV Пакет'),
(50, 'hy', 'TV Пакет'),
(51, 'en', 'Страны'),
(51, 'hy', 'Страны'),
(52, 'hy', 'TV Каналл'),
(53, 'hy', 'Добавить'),
(54, 'hy', 'Добавить Tv пакет'),
(55, 'hy', 'Tv Packets'),
(56, 'hy', 'Коммерческие Услуги'),
(57, 'hy', 'Статистика'),
(58, 'hy', 'История'),
(59, 'hy', 'Имя'),
(60, 'hy', 'Цена'),
(61, 'hy', 'Каналлы'),
(62, 'hy', 'Отмена'),
(63, 'hy', 'Сохранить'),
(64, 'hy', 'Ստեղծել'),
(65, 'hy', 'Ստեղծեք գոտի'),
(66, 'hy', 'Ստեղծել զեղչ'),
(67, 'hy', 'Երկիր'),
(68, 'hy', 'Մարզ'),
(69, 'hy', 'Քաղաք'),
(70, 'hy', 'Выберите'),
(71, 'hy', 'Вход в систему'),
(72, 'hy', 'Пароль'),
(73, 'hy', 'Запомни меня'),
(74, 'hy', 'Թարմացնել'),
(75, 'hy', 'Ջբջել'),
(76, 'hy', 'Ստեղծել Գործարք'),
(77, 'hy', 'Պրովայդեր'),
(78, 'hy', 'Նոր հաճախորդ'),
(79, 'hy', 'Фамилия'),
(80, 'hy', 'Отчество'),
(81, 'hy', 'Дата рождения'),
(82, 'hy', 'Телефон'),
(83, 'hy', 'E-mail'),
(84, 'hy', 'Компании, связанные с контактом'),
(85, 'hy', 'Номер паспорта'),
(86, 'hy', 'Кем выдан'),
(87, 'hy', 'Когда выдан'),
(88, 'hy', 'Действителен до'),
(89, 'hy', 'ID карта'),
(90, 'hy', 'Провайдер'),
(91, 'hy', 'Изображение'),
(92, 'hy', 'Անձնագրի նկար'),
(93, 'hy', 'Image'),
(94, 'hy', 'Type'),
(95, 'hy', 'Изображение на паспорт'),
(96, 'hy', 'Кем виден'),
(97, 'hy', 'Когда виден'),
(98, 'hy', 'Созданно'),
(99, 'hy', 'Обнавленно'),
(100, 'hy', 'Ответственный'),
(101, 'hy', 'Лого'),
(102, 'hy', 'Тип'),
(103, 'hy', 'Сфера деятельности'),
(104, 'hy', 'Годовой оборот'),
(105, 'hy', 'Ид. валюты'),
(106, 'hy', 'Հասցե'),
(107, 'hy', 'Contact ID'),
(108, 'hy', 'Company ID'),
(109, 'hy', 'Страна'),
(110, 'hy', 'Район'),
(111, 'hy', 'Населенный пункт'),
(112, 'hy', 'Улица'),
(113, 'hy', 'Дом'),
(114, 'hy', 'Корпус'),
(115, 'hy', 'Квартира'),
(116, 'hy', 'Շրջան'),
(117, 'hy', 'Փողոց'),
(118, 'hy', 'Удалить'),
(119, 'hy', 'WI-FI'),
(120, 'hy', 'Անվճար'),
(121, 'hy', 'Թարմացնել Ծառայություն: '),
(122, 'hy', 'Գործարք'),
(123, 'hy', 'Գումար'),
(124, 'hy', 'Ստեղծվել է'),
(125, 'hy', 'Օպերատոր'),
(126, 'hy', 'Կարգավիճակ'),
(127, 'hy', 'Վճարման տեսակ'),
(128, 'hy', 'Ստեղծել հաճախորդ'),
(129, 'hy', 'Ստեղծել բազային կայան'),
(130, 'hy', 'Ծառայության փոփոխություն'),
(131, 'hy', 'Поиск по умолчанию'),
(132, 'hy', 'Անջատման օր'),
(133, 'hy', 'Դիտել'),
(134, 'hy', 'Բալանս'),
(135, 'hy', 'Վճարել'),
(136, 'hy', 'Արձակուրդ'),
(137, 'hy', 'Սկիզբ'),
(138, 'hy', 'Ավարտ'),
(139, 'hy', 'Արձակուրդի տարբերակներ'),
(140, 'hy', 'Ընտրել տարբերակ'),
(141, 'hy', 'Պատճառը'),
(142, 'hy', 'Պայմանագրի խզում'),
(143, 'hy', 'խզում'),
(144, 'hy', 'Տուգանք'),
(145, 'hy', 'Պատմություն'),
(146, 'hy', 'добавить IP Address'),
(147, 'hy', ''),
(148, 'hy', 'Պայմանագիր ունի'),
(149, 'hy', 'Проведено'),
(150, 'hy', 'Наименование'),
(151, 'hy', 'Себестоимость'),
(152, 'hy', 'Количество'),
(153, 'hy', 'Активный'),
(154, 'hy', 'Язык трансляции'),
(155, 'hy', 'Բազային կայան'),
(156, 'hy', 'Address'),
(157, 'hy', 'Status'),
(158, 'hy', 'Price'),
(159, 'hy', 'Հաշվապահություն'),
(160, 'hy', 'Համայնք'),
(161, 'hy', 'Ալիքի կատեգորիա'),
(162, 'hy', 'Ալիքի որակ'),
(163, 'hy', 'Ալիքի հեռարձակման լեզուն'),
(164, 'hy', 'TV ալիք'),
(165, 'hy', 'TV փաթեթ'),
(166, 'hy', 'Երկրներ'),
(167, 'hy', 'Ավելացնել IP հասցե'),
(168, 'hy', 'Просрочено'),
(169, 'hy', 'Տուն'),
(170, 'hy', 'Կորպուս'),
(171, 'hy', 'Բնակարան'),
(172, 'hy', 'Добавит IP адресс'),
(173, 'hy', 'Ip Addresses'),
(174, 'hy', 'Պայմանագրի ավարտ'),
(175, 'hy', 'Մնացել է'),
(176, 'hy', 'օր'),
(177, 'hy', 'Անդորագրի համար'),
(178, 'hy', 'Վճարման անսաթիվ'),
(179, 'hy', 'Billing'),
(180, 'hy', 'CRM'),
(181, 'hy', 'Modal 1'),
(182, 'hy', 'Username'),
(183, 'hy', 'Անուն'),
(184, 'hy', 'Ազգանուն'),
(185, 'hy', 'Էլ․ փոստ'),
(186, 'hy', 'Դերը'),
(187, 'hy', 'Գաղտնաբառ'),
(188, 'hy', 'Գաղտնաբառի հաստատում'),
(189, 'hy', 'Գրանցվել է'),
(190, 'hy', 'Թարմացվել է'),
(191, 'hy', 'Կասա չկա'),
(192, 'hy', 'Վճարման օր'),
(193, 'hy', 'Վճարի ընդունման օր'),
(194, 'hy', 'Ընդհանուր'),
(195, 'hy', 'Հայրանուն'),
(196, 'hy', 'Ծննդյան ամսաթիվ'),
(197, 'hy', 'Անձնագրի սերիա'),
(198, 'hy', 'ՈՒմ կողմից'),
(199, 'hy', 'Երբ է տրվել'),
(200, 'hy', 'Ուժի մեջ է մինչև'),
(201, 'hy', 'ID CARD'),
(202, 'hy', 'Գործարք։ '),
(203, 'hy', 'Ընտրել գանձապահ'),
(204, 'hy', 'Կազմակերպություն'),
(205, 'hy', 'Ֆիզ․ անձ'),
(206, 'hy', 'Գանձապահ'),
(207, 'hy', 'Աշխատակիցներ'),
(208, 'hy', 'Ստեղծել գանձապահ'),
(209, 'hy', 'Cashiers'),
(210, 'hy', 'Create User'),
(211, 'hy', 'Users'),
(212, 'hy', 'Թարմացնել: {name}'),
(213, 'hy', 'Update'),
(214, 'hy', 'Օգտատերի անուն'),
(215, 'hy', 'Դուք չեք կարող կատարել վարի ընդունում կամ փոփոխություն քանի որ կցված չեք որևէ դրամարկղում'),
(216, 'hy', 'Դուք չեք կարող կատարել վճարի ընդունում կամ փոփոխություն քանի որ կցված չեք որևէ դրամարկղում'),
(217, 'hy', 'Search...'),
(218, 'hy', 'Тариф'),
(219, 'hy', 'Все'),
(220, 'hy', 'Активные'),
(221, 'hy', 'Архивные'),
(222, 'hy', 'Нет тарифов для показа'),
(223, 'hy', 'Internet Tv'),
(224, 'hy', 'Интернет'),
(225, 'hy', 'Интернет Тип'),
(226, 'hy', 'TV'),
(227, 'hy', 'ТВ-пакет'),
(228, 'hy', 'IP адрес'),
(229, 'hy', 'Количество IP адресов'),
(230, 'hy', 'Настоящая цена'),
(231, 'hy', 'Тип фактической цены'),
(232, 'hy', 'Активен'),
(233, 'hy', 'Скорость'),
(234, 'hy', 'Пакет'),
(235, 'hy', 'Количество IP адрес'),
(236, 'hy', 'Себестоимость тарифа'),
(237, 'hy', 'Драм'),
(238, 'hy', 'Итогостоимость тарифа'),
(239, 'hy', 'Create Services'),
(240, 'hy', 'Services'),
(241, 'hy', 'Название'),
(242, 'hy', 'Тип клиента'),
(243, 'hy', 'Способ оплаты'),
(244, 'hy', 'Период оплаты'),
(245, 'hy', 'Случайный'),
(246, 'hy', 'Область'),
(247, 'hy', 'Город'),
(248, 'hy', 'Assignments'),
(249, 'hy', 'Roles'),
(250, 'hy', 'Rule'),
(251, 'hy', 'Route'),
(252, 'hy', 'Assignment'),
(253, 'hy', 'Item'),
(254, 'hy', 'Items'),
(255, 'hy', 'Create Item'),
(256, 'hy', 'Name'),
(257, 'hy', 'Rule Name'),
(258, 'hy', 'Select Rule'),
(259, 'hy', 'Description'),
(260, 'hy', 'Հղում'),
(261, 'hy', 'Routes'),
(262, 'hy', 'Refresh'),
(263, 'hy', 'Search for available'),
(264, 'hy', 'Assign'),
(265, 'hy', 'Remove'),
(266, 'hy', 'Search for assigned'),
(267, 'hy', 'Assignment : {0}'),
(268, 'hy', 'Item : {0}'),
(269, 'hy', 'Delete'),
(270, 'hy', 'Are you sure to delete this item?'),
(271, 'hy', 'Create'),
(272, 'hy', 'Data'),
(273, 'hy', 'Rules'),
(274, 'hy', 'Create Rule'),
(275, 'hy', 'Update Rule : {0}'),
(276, 'hy', 'Class Name'),
(277, 'hy', 'ՀԴՄ'),
(278, 'hy', 'Մեկնաբանություն'),
(279, 'hy', 'Հաշվապահություն չէ'),
(280, 'hy', 'Վիրտուալ'),
(281, 'hy', 'Վիրտուալ չէ'),
(282, 'hy', 'Պասիվ'),
(283, 'hy', 'Ընտրել սխալ վճարված գործարքը'),
(284, 'hy', 'Վճարող օպ․'),
(285, 'hy', 'Վճարում ընդ․ օպ․'),
(286, 'hy', 'Պրովայդեր չէ'),
(287, 'hy', 'ՀԴՄ չէ'),
(288, 'hy', 'Поиск'),
(289, 'hy', 'Товар'),
(290, 'hy', 'Канбан'),
(291, 'hy', 'Список'),
(292, 'hy', 'Календарь'),
(293, 'hy', 'Task Management'),
(294, 'hy', 'Ip Ալեհավաք'),
(295, 'hy', 'Խզման տարբերակներ'),
(296, 'hy', 'Առաջադրանքներ'),
(297, 'hy', 'Տարբերակներ'),
(298, 'hy', 'Գերակայություն'),
(299, 'hy', 'Տպել ՀԴՄ կտրոն'),
(300, 'hy', 'Ամսական'),
(301, 'hy', 'Ընտրել Հասցե'),
(302, 'hy', 'Անվանում'),
(303, 'hy', 'Հեռախոս'),
(304, 'hy', 'Էլ․ հասցե'),
(305, 'hy', 'ՀՎՀՀ'),
(306, 'hy', 'Գրանցման ամս․'),
(307, 'hy', 'Պատասխանատու'),
(308, 'hy', 'Լոգո'),
(309, 'hy', 'Տիպ'),
(310, 'hy', 'Գործունեության ոլորտը'),
(311, 'hy', 'Տարեկան շրջանառությունը'),
(312, 'hy', 'Ջնջել'),
(313, 'hy', 'Անջատված'),
(314, 'hy', 'Խզված'),
(315, 'hy', 'Ամսական չէ'),
(316, 'hy', 'Ընտրել պատճառը'),
(317, 'hy', 'Հաշվ.'),
(318, 'hy', 'Արձակուրդի տարբերակ'),
(319, 'hy', 'Խզման տարբերակ');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1612164955),
('m140506_102106_rbac_init', 1616743984),
('m150207_210500_i18n_init', 1612165038),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1616743984),
('m180523_151638_rbac_updates_indexes_without_prefix', 1616743984),
('m200409_110543_rbac_update_mssql_trigger', 1616743984),
('m200817_093047_create_user_table', 1612164957),
('m200817_131402_create_units_table', 1612164957),
('m200819_111458_create_tariff_table', 1612164957),
('m200820_141107_create_tariff_lang_table', 1612164957),
('m200821_124311_create_crm_menu_table', 1612164957),
('m200821_130408_create_section_table', 1612164957),
('m200821_130900_create_field_type_table', 1612164957),
('m200821_131030_create_crm_custom_fields_table', 1612164957),
('m200821_135023_create_custom_list_table', 1612164957),
('m200821_135613_create_field_value_table', 1612164957),
('m200821_141021_create_crm_lead_table', 1612164957),
('m200825_130635_drop_tariff_types_column_from_tariff_table', 1612164957),
('m200825_130836_add_is_ip_column_to_tariff_table', 1612164957),
('m200825_131121_create_ip_addresses_table', 1612164957),
('m200825_131749_drop_type_column_from_internet_table', 1612164957),
('m200826_082114_add_status_id_column', 1612164957),
('m200826_082246_create_lead_status_table', 1612164957),
('m200826_091349_add_actual_price_column', 1612164957),
('m200826_091639_add_price_column', 1612164957),
('m200826_091921_add_actual_price_type_column', 1612164957),
('m200826_103930_create_company_table', 1612164957),
('m200826_112929_create_services_table', 1612164957),
('m200826_125237_create_contact_table', 1612164957),
('m200826_130544_rename_ip_id_column_from_tariff_table', 1612164957),
('m200826_142915_create_product_table', 1612164957),
('m200826_144403_create_deal_table', 1612164957),
('m200827_102735_add_ordering_column', 1612164957),
('m200827_110128_add_color_column', 1612164957),
('m200827_121508_add_ordering_column', 1612164957),
('m200831_080511_create_b_share_table', 1612164957),
('m200831_153111_create_countries_table', 1612164957),
('m200831_153518_create_regions_table', 1612164957),
('m200831_153703_create_cities_table', 1612164957),
('m200901_131608_add_region_id_column_to_cities_table', 1612164957),
('m200902_085046_add_contact_column', 1612164957),
('m200902_090053_create_contact_phone_table', 1612164957),
('m200902_102459_add_status_id_ordering_column', 1612164957),
('m200902_104641_drop_is_all_country_column_from_services_table', 1612164957),
('m200902_104848_create_service_country_table', 1612164957),
('m200902_131525_create_contact_company_table', 1612164957),
('m200902_144044_create_contact_email_table', 1612164957),
('m200902_151036_create_company_type_table', 1612164957),
('m200902_151332_create_company_type_lang_table', 1612164957),
('m200902_151456_create_company_scope_table', 1612164957),
('m200902_151521_create_company_scope_lang_table', 1612164957),
('m200902_151640_create_currency_table', 1612164957),
('m200902_151712_create_currency_table_table', 1612164957),
('m200902_151756_add_column_amount_column', 1612164957),
('m200902_151956_add_column_deal_column', 1612164957),
('m200902_152039_add_logo_column_to_crm_company_table', 1612164957),
('m200902_152325_create_deal_type_table', 1612164957),
('m200902_152952_create_contact_adress_table', 1612164957),
('m200903_081249_add_columns_deal', 1612164957),
('m200903_105117_add_products_column', 1612164957),
('m200903_111735_add_tariff_id_service_id_columns_deal', 1612164957),
('m200903_125803_create_currency_lang_table', 1612164957),
('m200903_130301_drop_currency_table_table', 1612164957),
('m200903_143601_remove_pk_columns', 1612164957),
('m200903_144104_add_id_column', 1612164957),
('m200903_171617_create_total_price_column_to_service_tariff', 1612164957),
('m200903_171806_create_month_base_id_column_to_crm_product', 1612164957),
('m200903_171909_create_product_id_column_to_service_tariff', 1612164957),
('m200904_061102_add_currency_id_column_to_company_table', 1612164957),
('m200907_105459_add_min_table_column_to_internet_table', 1612164957),
('m200907_105917_add_is_active_column_to_tariff_table', 1612164957),
('m200907_120614_add_column_simbol_currency_table', 1612164957),
('m200907_122029_add_column_id_crm_contact_phone', 1612164957),
('m200907_122115_add_column_id_crm_contact_email', 1612164957),
('m200907_125439_add_columns_is_mailing_is_notification_for_contact_email', 1612164957),
('m200907_125452_add_columns_is_mailing_is_notification_for_contact_phone', 1612164957),
('m200908_082318_add_column_type_id', 1612164957),
('m200908_083740_create_deal_conect_table', 1612164958),
('m200908_130150_add_column_address_id_deal', 1612164958),
('m200908_142812_add_requisite_column_to_crm_contact_table', 1612164958),
('m200908_143625_add_is_provider_column_to_crm_company_table', 1612164958),
('m200909_061452_create_channel_category_table', 1612164958),
('m200909_061603_create_channel_quality_table', 1612164958),
('m200909_061643_create_channel_broadcast_language_table', 1612164958),
('m200909_061932_create_channel_id_broadcast_id_table', 1612164958),
('m200909_075759_add_column_basis_deal_connect', 1612164958),
('m200909_080023_add_deal_file_table', 1612164958),
('m200909_081855_create_channel_category_lang_table', 1612164958),
('m200909_082142_create_channel_quality_lang_table', 1612164958),
('m200909_083230_add_column_tv_channel_table', 1612164958),
('m200909_115903_create_crm_contact_passport_table', 1612164958),
('m200909_232802_create_company_document_table', 1612164958),
('m200909_232953_add_requisite_column_to_crm_company_table', 1612164958),
('m200910_075316_add_status_type_crm_status_table', 1612164958),
('m200910_102017_add_menu_id_deal_type_table', 1612164958),
('m200910_112940_add_columns_deal_connect', 1612164958),
('m200915_122246_add_column_start_deal', 1612164958),
('m200916_064643_create_deal_address_table', 1612164958),
('m200916_065648_remove_address_id_column_crm_deal_table', 1612164958),
('m200916_071929_add_column_price_tv_packet_table', 1612164958),
('m200916_094558_add_username_column_to_crm_contact_table', 1612164958),
('m200916_094605_add_username_column_to_crm_company_table', 1612164958),
('m200916_095812_create_deal_payment_log_table', 1612164958),
('m200916_101744_add_column_share_id_crm_deal', 1612164958),
('m200916_103458_add_deal_ip_table', 1612164958),
('m200916_142731_add_column_work_price_crm_deal', 1612164958),
('m200924_130329_createCron_table', 1612164958),
('m200929_083026_create_tasks_table', 1612164958),
('m200929_083317_create_tasks_timing_table', 1612164958),
('m200929_095726_create_checklist_table', 1612164958),
('m200929_095836_create_checkpoints_table', 1612164958),
('m200929_100056_create_checkpoint_person_table', 1612164958),
('m200929_100229_create_task_person_table', 1612164958),
('m200929_102446_create_tags_table', 1612164958),
('m200929_102731_create_tags_task_table', 1612164958),
('m200929_103142_create_favorite_pinned_table', 1612164958),
('m200929_103345_create_statuses_table', 1612164958),
('m200929_103441_create_history_table', 1612164958),
('m200929_103624_create_persons_table', 1612164958),
('m201012_081419_add_column_rating', 1612164958),
('m201015_083049_add_status_column_to_task_table', 1612164958),
('m201023_144038_create_departments_table', 1612164958),
('m201028_085209_add_persons_to_hr_class_persons_table', 1612164958),
('m201126_110836_create_crm_comments_table', 1612164958),
('m201127_094900_create_users_list_table', 1612164961),
('m201201_131126_add_column_operator_id_payment_log_table', 1612164961),
('m201202_080921_add_column_last_name_user_table', 1612164961),
('m201203_113950_create_crm_deal_vacation_table', 1612164961),
('m201209_114002_add_column_deal_end_status_crm_deal_table', 1612164961),
('m201214_081112_create_f_tarrif_table', 1612164961),
('m201214_120651_create_speed_for_year_column', 1612164961),
('m201214_144430_create_status_column', 1612164961),
('m201215_080919_create_table_f_zone', 1612164961),
('m201215_123450_create_f_contacts_table', 1612164961),
('m201216_131101_create_f_base_station_table', 1612164961),
('m201216_131250_create_f_data_table', 1612164961),
('m201216_143259_create_f_zone_cities_table', 1612164961),
('m201216_143603_drop_city_id_column_from_f_zone_table', 1612164961),
('m201217_081301_create_f_baze_station_equipments_table', 1612164961),
('m201218_101125_add_column_ip_end_f_base_station_table', 1612164961),
('m201218_102625_add_column_base_id_ip_addresses_table', 1612164961),
('m201218_115702_create_f_deal_table', 1612164961),
('m201219_135958_add_f_deal_column', 1612164961),
('m201220_162541_add_selected_payment_column', 1612164961),
('m201221_083116_add_connect_type_column', 1612164961),
('m201223_115303_remove_payment_method_column', 1612164961),
('m201224_141752_create_f_deal_ip_table', 1612164961),
('m201224_155043_add_service_type_to_f_deal_table', 1612164961),
('m201224_163616_add_phone_column', 1612164961),
('m201225_124404_add_start_deal_column', 1612164961),
('m201229_133309_add_status_column_f_deal_table', 1612164961),
('m201229_141621_create_f_deal_disruption_table', 1612164961),
('m201229_145341_create_f_disruption_types_table', 1612164961),
('m201230_084846_add_payment_type_column_deal_payment_log_table', 1612164961),
('m210111_080507_create_f_streets_table', 1612164961),
('m210118_150049_add_connection_date_to_f_deal_table', 1612164961),
('m210119_100042_create_f_deal_connect_mikrotik_table', 1612164961),
('m210121_064850_create_f_deal_sale_table', 1612164961),
('m210121_094742_create_f_deal_ballance_table', 1614952107),
('m210121_102901_add_timestamps_column_to_f_deal_table', 1612164961),
('m210123_104437_create_f_vacation_type_table', 1612164961),
('m210123_104656_add_vacation_type_id_to_crm_deal_vacation_table', 1612164961),
('m210128_093708_create_f_deal_disabled_day_table', 1612164961),
('m210128_102434_add_microtik_queue_id_column', 1612164961),
('m210128_120807_add_price_column', 1612164961),
('m210201_080253_rename_deal_id_column', 1612250259),
('m210203_135938_rename_deal_id_column', 1612798412),
('m210204_111340_create_f_data_base_table', 1612798412),
('m210204_122710_remove_column_base_id_f_data_table', 1612798412),
('m210208_115638_add_speed_dates_column_to_deal_table', 1612798412),
('m210211_115216_create_f_base_zones_table', 1613133079),
('m210211_124533_add_column_to_f_deal_table', 1613133079),
('m210211_140142_create_f_community_table', 1613133079),
('m210212_093613_add_community_id_column', 1613133079),
('m210219_115157_add_active_column', 1613736409),
('m210223_111131_add_start_day_to_f_deal_table', 1614167498),
('m210223_113601_drop_local_ip_column_from_f_deal_table', 1614167498),
('m210223_113655_create_base_stations_ip_table', 1614167498),
('m210226_075416_add_id_column_to_f_deal_connect_mikrotik_table', 1614596898),
('m210226_115625_add_id_column_to_base_station_ip_table', 1614596898),
('m210301_084725_drop_zona_id_column_from_base_station_table', 1614596898),
('m210301_111332_add_payment_information_columns_to_deal_payment_log_table', 1614609033),
('m210302_132322_create_f_deal_address_table', 1614864887),
('m210302_144023_add_deal_id_column', 1614952107),
('m210304_122135_alter_street_type_from_contact_address_table', 1614864926),
('m210305_111925_add_message_column_to_f_deal_disabled_day_table', 1614947003),
('m210308_115547_add_id_column_to_f_deal_balance_table', 1616402308),
('m210308_130224_add_deal_number_column_to_f_deal_ip_table', 1616402308),
('m210311_110213_drop_deal_id_index_from_f_deal_connect_mikrotik_table', 1616402308),
('m210315_093313_create_f_cashier_table', 1616402308),
('m210317_084957_add_blacklist_column_to_f_cashier_table', 1616402308),
('m210317_085215_create_f_cashier_operator_table', 1616402308),
('m210317_115316_add_name_column_to_user_table', 1616402308),
('m210317_133526_add_update_at_column_to_deal_payment_log_table', 1616402308),
('m210318_105045_add_ref_password_column_to_user_table', 1616402308),
('m210324_101739_alter_deal_number_column_in_crm_deal_vacation_table', 1616589811),
('m210325_123831_alter_role_column_from_user_table', 1616743811),
('m210325_164310_add_required_users_to_user_table', 1616743898),
('m210326_064714_alter_create_at_column_to_deal_payment_log_table', 1616743898),
('m210326_082520_add_virtual_column_to_f_cashier_table', 1617111638),
('m210329_102906_add_hdm_column_to_deal_payment_log_table', 1617111639),
('m210331_085407_add_payer_column_to_deal_payment_log_table', 1617192832),
('m210406_124017_alter_last_name_column_from_user_table', 1617716181),
('m210406_150630_create_f_zone_regions_table', 1622040846),
('m210406_150806_drop_region_id_column_from_f_zone_table', 1622040846),
('m210407_121947_create_f_antenna_ip_table', 1622040846),
('m210407_131653_create_f_deal_antenna_ip_table', 1622040846),
('m210409_132051_create_deal_payment_log_history_table', 1622040846),
('m210419_154913_create_f_vacation_options_table', 1622040846),
('m210419_154952_create_f_disruption_options_table', 1622040846),
('m210420_120006_create_f_task_option_table', 1622040846),
('m210420_120138_create_f_task_table', 1622040846),
('m210420_130653_create_f_task_executor_table', 1622040846),
('m210420_131033_create_f_task_priority_table', 1622040846),
('m210423_114257_create_crm_cash_register_receipt_table', 1622040846),
('m210428_063702_create_f_deal_agreement_table', 1622040846),
('m210429_132224_add_daily_column_to_f_deal_table', 1622040846),
('m210430_121857_create_f_zone_community_table', 1622040846),
('m210430_121911_create_f_zone_street_table', 1622040846),
('m210505_132209_add_community_id_to_f_streets_table', 1622040846),
('m210506_143530_drop_address_list_column_from_f_zone_table', 1622040846),
('m210512_080006_add_daily_columns_to_f_deal_table', 1622040847),
('m210524_084048_create_tbl_dynagrid_table', 1622040847);

-- --------------------------------------------------------

--
-- Структура таблицы `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `mid_name` varchar(255) DEFAULT NULL,
  `sender` int(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `regions`
--

INSERT INTO `regions` (`id`, `name`, `country_id`) VALUES
(1, 'Երևան', 1),
(2, 'Շիրակի մարզ', 1),
(3, 'Վայոց ձորի մարզ', 1),
(4, 'Արարատի մարզ', 1),
(5, 'Կոտայքի մարզ', 1),
(8, 'Լոռու մարզ', 1),
(9, 'Արագածոտնի մարզ', 1),
(10, 'Արմավիրի մարզ', 1),
(11, 'Գեղարքունիքի մարզ', 1),
(12, 'Սյունիքի մարզ', 1),
(13, 'Տավուշի մարզ', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `regions_lang`
--

CREATE TABLE IF NOT EXISTS `regions_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `regions_lang`
--

INSERT INTO `regions_lang` (`id`, `parent_id`, `language`, `name`) VALUES
(1, 1, 'hy', 'Երևան'),
(2, 2, 'hy', 'Շիրակի մարզ'),
(3, 3, 'hy', 'Վայոց ձորի մարզ'),
(4, 4, 'hy', 'Արարատի մարզ'),
(5, 5, 'hy', 'Կոտայքի մարզ'),
(6, 8, 'hy', 'Լոռու մարզ'),
(7, 9, 'hy', 'Արագածոտնի մարզ'),
(8, 10, 'hy', 'Արմավիրի մարզ'),
(9, 11, 'hy', 'Գեղարքունիքի մարզ'),
(10, 12, 'hy', 'Սյունիքի մարզ'),
(11, 13, 'hy', 'Տավուշի մարզ');

-- --------------------------------------------------------

--
-- Структура таблицы `search_settings`
--

CREATE TABLE IF NOT EXISTS `search_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  `column_search` text,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `services_client_type` smallint(1) DEFAULT NULL,
  `payment_type` smallint(1) DEFAULT NULL,
  `payment_period` smallint(1) DEFAULT NULL,
  `random` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `services_lang`
--

CREATE TABLE IF NOT EXISTS `services_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `service_country`
--

CREATE TABLE IF NOT EXISTS `service_country` (
  `service_id` int(11) NOT NULL DEFAULT '0',
  `country_id` int(11) NOT NULL DEFAULT '0',
  `region_id` int(11) NOT NULL DEFAULT '0',
  `city_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `service_tariff`
--

CREATE TABLE IF NOT EXISTS `service_tariff` (
  `service_id` int(11) NOT NULL DEFAULT '0',
  `tariff_id` int(11) NOT NULL DEFAULT '0',
  `actual_price_type` smallint(1) DEFAULT NULL,
  `actual_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `service_tariff_location`
--

CREATE TABLE IF NOT EXISTS `service_tariff_location` (
  `service_id` int(11) NOT NULL DEFAULT '0',
  `tariff_id` int(11) NOT NULL DEFAULT '0',
  `country_id` int(11) NOT NULL DEFAULT '0',
  `region_id` int(11) NOT NULL DEFAULT '0',
  `city_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `source_message`
--

CREATE TABLE IF NOT EXISTS `source_message` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=320 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `source_message`
--

INSERT INTO `source_message` (`id`, `category`, `message`) VALUES
(1, 'app', 'Ծառայություններ'),
(2, 'app', 'Ստեղծեք Ծառայություն'),
(3, 'app', 'Выход'),
(4, 'app', 'FastNet'),
(5, 'app', 'Կարգավորումներ'),
(6, 'app', 'Тарифы'),
(7, 'app', 'Услуги'),
(8, 'app', 'Акции'),
(9, 'app', 'Клиенты'),
(10, 'app', 'Сотрудники'),
(11, 'app', 'Товары'),
(12, 'app', 'Оплаты'),
(13, 'app', 'Справочник'),
(14, 'app', 'Лиды'),
(15, 'app', 'Сделки'),
(16, 'app', 'Контакты'),
(17, 'app', 'Компании'),
(18, 'app', 'Департаменты'),
(19, 'app', 'Должности'),
(20, 'app', 'Роли'),
(21, 'app', 'Персоны'),
(22, 'app', 'Գործարքներ'),
(23, 'app', 'ՎՃարումներ'),
(24, 'app', 'Հաճախորդներ'),
(25, 'app', 'Բազային կայաններ'),
(26, 'app', 'Դատա'),
(27, 'app', 'Գոտիներ'),
(28, 'app', 'Զեղչեր'),
(29, 'app', 'ID'),
(30, 'app', 'Имя пользователя'),
(31, 'app', 'Адрес эл. почты'),
(32, 'app', 'Статус'),
(33, 'app', 'Роль'),
(34, 'app', 'Создано'),
(35, 'app', 'Обновлено'),
(36, 'app', 'Ստեղծել Ծառայություն'),
(37, 'app', 'Ընտրել'),
(38, 'app', 'Տան համար'),
(39, 'app', 'Բիզնեսի համար'),
(40, 'app', 'Ակտիվ'),
(41, 'app', 'Պահպանել'),
(42, 'app', 'Կարգավորումեր'),
(43, 'app', 'Поиск...'),
(44, 'app', 'IP Հասցե'),
(45, 'app', 'Ավելացնել'),
(46, 'app', 'Категория канала'),
(47, 'app', 'Качество канала'),
(48, 'app', 'Язык трансляции канала'),
(49, 'app', 'TV Канал'),
(50, 'app', 'TV Пакет'),
(51, 'app', 'Страны'),
(52, 'app', 'TV Каналл'),
(53, 'app', 'Добавить'),
(54, 'app', 'Добавить Tv пакет'),
(55, 'app', 'Tv Packets'),
(56, 'app', 'Коммерческие Услуги'),
(57, 'app', 'Статистика'),
(58, 'app', 'История'),
(59, 'app', 'Имя'),
(60, 'app', 'Цена'),
(61, 'app', 'Каналлы'),
(62, 'app', 'Отмена'),
(63, 'app', 'Сохранить'),
(64, 'app', 'Ստեղծել'),
(65, 'app', 'Ստեղծեք գոտի'),
(66, 'app', 'Ստեղծել զեղչ'),
(67, 'app', 'Երկիր'),
(68, 'app', 'Մարզ'),
(69, 'app', 'Քաղաք'),
(70, 'app', 'Выберите'),
(71, 'app', 'Вход в систему'),
(72, 'app', 'Пароль'),
(73, 'app', 'Запомни меня'),
(74, 'app', 'Թարմացնել'),
(75, 'app', 'Ջբջել'),
(76, 'app', 'Ստեղծել Գործարք'),
(77, 'app', 'Պրովայդեր'),
(78, 'app', 'Նոր հաճախորդ'),
(79, 'app', 'Фамилия'),
(80, 'app', 'Отчество'),
(81, 'app', 'Дата рождения'),
(82, 'app', 'Телефон'),
(83, 'app', 'E-mail'),
(84, 'app', 'Компании, связанные с контактом'),
(85, 'app', 'Номер паспорта'),
(86, 'app', 'Кем выдан'),
(87, 'app', 'Когда выдан'),
(88, 'app', 'Действителен до'),
(89, 'app', 'ID карта'),
(90, 'app', 'Провайдер'),
(91, 'app', 'Изображение'),
(92, 'app', 'Անձնագրի նկար'),
(93, 'app', 'Image'),
(94, 'app', 'Type'),
(95, 'app', 'Изображение на паспорт'),
(96, 'app', 'Кем виден'),
(97, 'app', 'Когда виден'),
(98, 'app', 'Созданно'),
(99, 'app', 'Обнавленно'),
(100, 'app', 'Ответственный'),
(101, 'app', 'Лого'),
(102, 'app', 'Тип'),
(103, 'app', 'Сфера деятельности'),
(104, 'app', 'Годовой оборот'),
(105, 'app', 'Ид. валюты'),
(106, 'app', 'Հասցե'),
(107, 'app', 'Contact ID'),
(108, 'app', 'Company ID'),
(109, 'app', 'Страна'),
(110, 'app', 'Район'),
(111, 'app', 'Населенный пункт'),
(112, 'app', 'Улица'),
(113, 'app', 'Дом'),
(114, 'app', 'Корпус'),
(115, 'app', 'Квартира'),
(116, 'app', 'Շրջան'),
(117, 'app', 'Փողոց'),
(118, 'app', 'Удалить'),
(119, 'app', 'WI-FI'),
(120, 'app', 'Անվճար'),
(121, 'app', 'Թարմացնել Ծառայություն: '),
(122, 'app', 'Գործարք'),
(123, 'app', 'Գումար'),
(124, 'app', 'Ստեղծվել է'),
(125, 'app', 'Օպերատոր'),
(126, 'app', 'Կարգավիճակ'),
(127, 'app', 'Վճարման տեսակ'),
(128, 'app', 'Ստեղծել հաճախորդ'),
(129, 'app', 'Ստեղծել բազային կայան'),
(130, 'app', 'Ծառայության փոփոխություն'),
(131, 'app', 'Поиск по умолчанию'),
(132, 'app', 'Անջատման օր'),
(133, 'app', 'Դիտել'),
(134, 'app', 'Բալանս'),
(135, 'app', 'Վճարել'),
(136, 'app', 'Արձակուրդ'),
(137, 'app', 'Սկիզբ'),
(138, 'app', 'Ավարտ'),
(139, 'app', 'Արձակուրդի տարբերակներ'),
(140, 'app', 'Ընտրել տարբերակ'),
(141, 'app', 'Պատճառը'),
(142, 'app', 'Պայմանագրի խզում'),
(143, 'app', 'խզում'),
(144, 'app', 'Տուգանք'),
(145, 'app', 'Պատմություն'),
(146, 'app', 'добавить IP Address'),
(147, 'app', ''),
(148, 'app', 'Պայմանագիր ունի'),
(149, 'app', 'Проведено'),
(150, 'app', 'Наименование'),
(151, 'app', 'Себестоимость'),
(152, 'app', 'Количество'),
(153, 'app', 'Активный'),
(154, 'app', 'Язык трансляции'),
(155, 'app', 'Բազային կայան'),
(156, 'app', 'Address'),
(157, 'app', 'Status'),
(158, 'app', 'Price'),
(159, 'app', 'Հաշվապահություն'),
(160, 'app', 'Համայնք'),
(161, 'app', 'Ալիքի կատեգորիա'),
(162, 'app', 'Ալիքի որակ'),
(163, 'app', 'Ալիքի հեռարձակման լեզուն'),
(164, 'app', 'TV ալիք'),
(165, 'app', 'TV փաթեթ'),
(166, 'app', 'Երկրներ'),
(167, 'app', 'Ավելացնել IP հասցե'),
(168, 'app', 'Просрочено'),
(169, 'app', 'Տուն'),
(170, 'app', 'Կորպուս'),
(171, 'app', 'Բնակարան'),
(172, 'app', 'Добавит IP адресс'),
(173, 'app', 'Ip Addresses'),
(174, 'app', 'Պայմանագրի ավարտ'),
(175, 'app', 'Մնացել է'),
(176, 'app', 'օր'),
(177, 'app', 'Անդորագրի համար'),
(178, 'app', 'Վճարման անսաթիվ'),
(179, 'app', 'Billing'),
(180, 'app', 'CRM'),
(181, 'app', 'Modal 1'),
(182, 'app', 'Username'),
(183, 'app', 'Անուն'),
(184, 'app', 'Ազգանուն'),
(185, 'app', 'Էլ․ փոստ'),
(186, 'app', 'Դերը'),
(187, 'app', 'Գաղտնաբառ'),
(188, 'app', 'Գաղտնաբառի հաստատում'),
(189, 'app', 'Գրանցվել է'),
(190, 'app', 'Թարմացվել է'),
(191, 'app', 'Կասա չկա'),
(192, 'app', 'Վճարման օր'),
(193, 'app', 'Վճարի ընդունման օր'),
(194, 'app', 'Ընդհանուր'),
(195, 'app', 'Հայրանուն'),
(196, 'app', 'Ծննդյան ամսաթիվ'),
(197, 'app', 'Անձնագրի սերիա'),
(198, 'app', 'ՈՒմ կողմից'),
(199, 'app', 'Երբ է տրվել'),
(200, 'app', 'Ուժի մեջ է մինչև'),
(201, 'app', 'ID CARD'),
(202, 'app', 'Գործարք։ '),
(203, 'app', 'Ընտրել գանձապահ'),
(204, 'app', 'Կազմակերպություն'),
(205, 'app', 'Ֆիզ․ անձ'),
(206, 'app', 'Գանձապահ'),
(207, 'app', 'Աշխատակիցներ'),
(208, 'app', 'Ստեղծել գանձապահ'),
(209, 'app', 'Cashiers'),
(210, 'app', 'Create User'),
(211, 'app', 'Users'),
(212, 'app', 'Թարմացնել: {name}'),
(213, 'app', 'Update'),
(214, 'app', 'Օգտատերի անուն'),
(215, 'app', 'Դուք չեք կարող կատարել վարի ընդունում կամ փոփոխություն քանի որ կցված չեք որևէ դրամարկղում'),
(216, 'app', 'Դուք չեք կարող կատարել վճարի ընդունում կամ փոփոխություն քանի որ կցված չեք որևէ դրամարկղում'),
(217, 'app', 'Search...'),
(218, 'app', 'Тариф'),
(219, 'app', 'Все'),
(220, 'app', 'Активные'),
(221, 'app', 'Архивные'),
(222, 'app', 'Нет тарифов для показа'),
(223, 'app', 'Internet Tv'),
(224, 'app', 'Интернет'),
(225, 'app', 'Интернет Тип'),
(226, 'app', 'TV'),
(227, 'app', 'ТВ-пакет'),
(228, 'app', 'IP адрес'),
(229, 'app', 'Количество IP адресов'),
(230, 'app', 'Настоящая цена'),
(231, 'app', 'Тип фактической цены'),
(232, 'app', 'Активен'),
(233, 'app', 'Скорость'),
(234, 'app', 'Пакет'),
(235, 'app', 'Количество IP адрес'),
(236, 'app', 'Себестоимость тарифа'),
(237, 'app', 'Драм'),
(238, 'app', 'Итогостоимость тарифа'),
(239, 'app', 'Create Services'),
(240, 'app', 'Services'),
(241, 'app', 'Название'),
(242, 'app', 'Тип клиента'),
(243, 'app', 'Способ оплаты'),
(244, 'app', 'Период оплаты'),
(245, 'app', 'Случайный'),
(246, 'app', 'Область'),
(247, 'app', 'Город'),
(248, 'app', 'Assignments'),
(249, 'app', 'Roles'),
(250, 'app', 'Rule'),
(251, 'app', 'Route'),
(252, 'app', 'Assignment'),
(253, 'app', 'Item'),
(254, 'app', 'Items'),
(255, 'app', 'Create Item'),
(256, 'app', 'Name'),
(257, 'app', 'Rule Name'),
(258, 'app', 'Select Rule'),
(259, 'app', 'Description'),
(260, 'app', 'Հղում'),
(261, 'app', 'Routes'),
(262, 'app', 'Refresh'),
(263, 'app', 'Search for available'),
(264, 'app', 'Assign'),
(265, 'app', 'Remove'),
(266, 'app', 'Search for assigned'),
(267, 'app', 'Assignment : {0}'),
(268, 'app', 'Item : {0}'),
(269, 'app', 'Delete'),
(270, 'app', 'Are you sure to delete this item?'),
(271, 'app', 'Create'),
(272, 'app', 'Data'),
(273, 'app', 'Rules'),
(274, 'app', 'Create Rule'),
(275, 'app', 'Update Rule : {0}'),
(276, 'app', 'Class Name'),
(277, 'app', 'ՀԴՄ'),
(278, 'app', 'Մեկնաբանություն'),
(279, 'app', 'Հաշվապահություն չէ'),
(280, 'app', 'Վիրտուալ'),
(281, 'app', 'Վիրտուալ չէ'),
(282, 'app', 'Պասիվ'),
(283, 'app', 'Ընտրել սխալ վճարված գործարքը'),
(284, 'app', 'Վճարող օպ․'),
(285, 'app', 'Վճարում ընդ․ օպ․'),
(286, 'app', 'Պրովայդեր չէ'),
(287, 'app', 'ՀԴՄ չէ'),
(288, 'app', 'Поиск'),
(289, 'app', 'Товар'),
(290, 'app', 'Канбан'),
(291, 'app', 'Список'),
(292, 'app', 'Календарь'),
(293, 'app', 'Task Management'),
(294, 'app', 'Ip Ալեհավաք'),
(295, 'app', 'Խզման տարբերակներ'),
(296, 'app', 'Առաջադրանքներ'),
(297, 'app', 'Տարբերակներ'),
(298, 'app', 'Գերակայություն'),
(299, 'app', 'Տպել ՀԴՄ կտրոն'),
(300, 'app', 'Ամսական'),
(301, 'app', 'Ընտրել Հասցե'),
(302, 'app', 'Անվանում'),
(303, 'app', 'Հեռախոս'),
(304, 'app', 'Էլ․ հասցե'),
(305, 'app', 'ՀՎՀՀ'),
(306, 'app', 'Գրանցման ամս․'),
(307, 'app', 'Պատասխանատու'),
(308, 'app', 'Լոգո'),
(309, 'app', 'Տիպ'),
(310, 'app', 'Գործունեության ոլորտը'),
(311, 'app', 'Տարեկան շրջանառությունը'),
(312, 'app', 'Ջնջել'),
(313, 'app', 'Անջատված'),
(314, 'app', 'Խզված'),
(315, 'app', 'Ամսական չէ'),
(316, 'app', 'Ընտրել պատճառը'),
(317, 'app', 'Հաշվ.'),
(318, 'app', 'Արձակուրդի տարբերակ'),
(319, 'app', 'Խզման տարբերակ');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `table_settings`
--

CREATE TABLE IF NOT EXISTS `table_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `column_status` text,
  `column_order` text,
  `page` varchar(255) NOT NULL,
  `column_search` text,
  `count_show` int(11) NOT NULL DEFAULT '5',
  `sort_column` varchar(255) DEFAULT NULL,
  `sort_type` varchar(255) DEFAULT NULL,
  `pined` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tags_task`
--

CREATE TABLE IF NOT EXISTS `tags_task` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tariff`
--

CREATE TABLE IF NOT EXISTS `tariff` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_internet` smallint(1) DEFAULT NULL,
  `internet_type` smallint(1) DEFAULT '0' COMMENT '0 => speed, 1 => traffic volume',
  `internet_id` int(11) DEFAULT NULL,
  `is_tv` smallint(1) DEFAULT NULL,
  `tv_packet_id` int(11) DEFAULT NULL,
  `is_ip` int(11) DEFAULT '0',
  `ip_count` int(11) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `actual_price` decimal(10,2) DEFAULT NULL,
  `actual_price_type` smallint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tariff_lang`
--

CREATE TABLE IF NOT EXISTS `tariff_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL,
  `created_add` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `description` text,
  `parent_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tasks_timing`
--

CREATE TABLE IF NOT EXISTS `tasks_timing` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `planning_start` datetime DEFAULT NULL,
  `planning_end` datetime DEFAULT NULL,
  `real_start` datetime DEFAULT NULL,
  `real_end` datetime DEFAULT NULL,
  `dead_line` datetime DEFAULT NULL,
  `time_track_start` datetime DEFAULT NULL,
  `time_track_actual_duration` int(11) DEFAULT NULL,
  `time_track_planned_duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `task_person`
--

CREATE TABLE IF NOT EXISTS `task_person` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_dynagrid`
--

CREATE TABLE IF NOT EXISTS `tbl_dynagrid` (
  `id` varchar(100) NOT NULL COMMENT 'Unique dynagrid setting identifier',
  `filter_id` varchar(100) DEFAULT NULL COMMENT 'Filter setting identifier',
  `sort_id` varchar(100) DEFAULT NULL COMMENT 'Sort setting identifier',
  `data` varchar(5000) DEFAULT NULL COMMENT 'Json encoded data for the dynagrid configuration'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Dynagrid personalization configuration settings';

--
-- Дамп данных таблицы `tbl_dynagrid`
--

INSERT INTO `tbl_dynagrid` (`id`, `filter_id`, `sort_id`, `data`) VALUES
('dynagrid-1_20', NULL, NULL, '{"page":"10","theme":"panel-default","keys":["eaec59cb","a2062681","000a0985","59c16086","4c1f1d26","6e3063d8","ae072b7d","db6f2b17","f179bddd","cc2f823e","010721a8","7ed2fd2b","7233fef5","90527e33"],"filter":"","sort":""}');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_dynagrid_dtl`
--

CREATE TABLE IF NOT EXISTS `tbl_dynagrid_dtl` (
  `id` varchar(100) NOT NULL COMMENT 'Unique dynagrid detail setting identifier',
  `category` varchar(10) NOT NULL COMMENT 'Dynagrid detail setting category filter or sort',
  `name` varchar(150) NOT NULL COMMENT 'Name to identify the dynagrid detail setting',
  `data` varchar(5000) DEFAULT NULL COMMENT 'Json encoded data for the dynagrid detail configuration',
  `dynagrid_id` varchar(100) NOT NULL COMMENT 'Related dynagrid identifier'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Dynagrid detail configuration settings';

-- --------------------------------------------------------

--
-- Структура таблицы `tv_channel`
--

CREATE TABLE IF NOT EXISTS `tv_channel` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cost_price` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `active` smallint(1) DEFAULT '1',
  `password` smallint(6) DEFAULT '0',
  `logo_channel` varchar(255) DEFAULT NULL,
  `channel_category_id` int(11) DEFAULT NULL,
  `channel_quality_id` int(11) DEFAULT NULL,
  `provider_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tv_channel_lang`
--

CREATE TABLE IF NOT EXISTS `tv_channel_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tv_packet`
--

CREATE TABLE IF NOT EXISTS `tv_packet` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tv_packet`
--

INSERT INTO `tv_packet` (`id`, `name`, `price`) VALUES
(1, 'FastnetTV1', 2000),
(2, 'FasnetTV2', 3000);

-- --------------------------------------------------------

--
-- Структура таблицы `tv_packet_channel`
--

CREATE TABLE IF NOT EXISTS `tv_packet_channel` (
  `packet_id` int(11) NOT NULL DEFAULT '0',
  `channel_id` int(11) NOT NULL DEFAULT '0',
  `price` smallint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tv_packet_lang`
--

CREATE TABLE IF NOT EXISTS `tv_packet_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tv_packet_lang`
--

INSERT INTO `tv_packet_lang` (`id`, `parent_id`, `language`, `name`) VALUES
(1, 1, 'ru', 'FastnetTV'),
(2, 1, 'en', ''),
(3, 2, 'ru', 'TV'),
(4, 2, 'en', '');

-- --------------------------------------------------------

--
-- Структура таблицы `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` smallint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `units_lang`
--

CREATE TABLE IF NOT EXISTS `units_lang` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `role` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `auth_key`, `access_token`, `password_hash`, `ref_password`, `password_reset_token`, `email`, `status`, `role`, `created_at`, `updated_at`, `last_name`) VALUES
(1, 'admin', 'Admin', 'QBoAAac3s7Al2ZE6s6qpohozaAoRgtBs', NULL, '$2y$13$p7B8T1EnY2i1VaUlk8Gx2.p7Cgnk20b0UqcFrPhfgn2BtksidSIHK', '123456', NULL, 'admin@admin.com', 10, 'admin', '2021-02-01 07:35:57', '2021-03-23 18:37:52', 'Admin'),
(10, 'zarafast', 'Զարուհի', 'U2O9iFv_8mOVKWxyNzA3pQlEsFiZ0vh6', NULL, '$2y$13$6ESEfBdRRJ4IcPsg5JsroODI75CKJ3BJ9i2OKic1bii7M2Uh98.LW', 'zara21fast', NULL, ' zarauhi.hovhannisyan@gmail.com', 10, 'manager', '2021-03-24 10:28:12', '2021-03-24 10:31:26', 'Հովհաննիսյան'),
(12, 'tatevfastnet', 'Տաթևիկ ', 'gKLs1FWwpjZ6ygsGaNtpVzjD2xUYZy2M', NULL, '$2y$13$pDZJOr0d3grTGBA3IX1CTemsaIH5URniUYyeu7677BePimj2K9nOm', '123123', NULL, 'tatevik@fastnet.am', 10, 'manager', '2021-03-26 09:51:09', '2021-03-30 18:08:38', 'Մարգարյան'),
(13, 'karafastnet', 'Կարինե ', 'oSLqzkJ3f7n73T86ChVhNb4CP6eCZmA4', NULL, '$2y$13$xV4atCwVBa9Y445871iOluhytw3S/tbII42FBpdVYNjVUuXnlVRBy', 'karafastnet21', NULL, 'karine@fastnet', 10, 'operator', '2021-03-26 09:52:29', '2021-03-26 09:52:29', 'Կարախանյան'),
(14, 'anitovmasfastnet', 'Անի ', 'pETzwfgThyle2fEzNH3mA6onw-uT_NzF', NULL, '$2y$13$kxWLXeJuGg.CQOvL8MYLs.vYqyQGdwRaCbbMnRdRsW8pxWiOtGEla', 'anitovmas21', NULL, '''ani.tovmasyan@fastnet.am', 10, 'manager', '2021-03-26 11:08:28', '2021-03-26 11:08:28', 'Թովմասյան'),
(15, 'edgarmarkosfastnet', 'Էդգար', '2B1aNTGC5zB-UtuX_J0fwQzH9E1yD6cU', NULL, '$2y$13$9NayA21oMs6udAEHLW0BvuPIf.IVnmLMCgpACHIXgUmNuORHRLI.a', 'edgarfastnet21', NULL, 'edgar@fastnet.am', 10, 'operator', '2021-03-26 11:20:17', '2021-03-26 11:20:17', 'Մարկոսյան'),
(20, 'ashotfast', 'Աշոտ', '4jBo5qm83VN_WwiZYip6KooJGf36n6Hw', NULL, '$2y$13$dj2EkHTJEIlOqPaSjm0kFeWkRMYj6/SYQ0wyJON55Hx.zpakwGXPK', '123123', NULL, 'ashotfast@gmail.com', 10, 'admin', NULL, NULL, 'Ազգանուն'),
(21, 'telcell', 'TelCell', 'GNTcg7PrBK9hJrmzZ-kFjHgaZLT7APSM', NULL, '$2y$13$Dv.B3FX/7w7UhUIntO2FoOhu4mHoXlLeyg11eMQbh3Gl6ZAg8BT.a', '123123', NULL, 'info@telcell.am', 10, 'terminal', NULL, NULL, ''),
(22, 'easypay', 'EasyPay', 'NJaKHNJgKnbqb-WqTHd-Igoype39J5FH', NULL, '$2y$13$WLgQJfgCq4sTmYZvKA9kX.FVNeAYwAM.YM1pizaWLJhRD3d6kOjFe', '123123', NULL, 'info@easypay.am', 10, 'terminal', NULL, NULL, ''),
(23, 'haypost', 'HayPost', 'dtfKxjIF6jOXEYPOTq1KT9hlZAs7aCp_', NULL, '$2y$13$WBUz/ivYfq6o8yu6bmQD2.dyB3zobpvIMPTbEJtwFygqQbajUEzYm', '123123', NULL, 'info@haypost.am', 10, 'terminal', NULL, NULL, ''),
(24, 'hakobfast', 'Հակոբ', 'X-JTUPZkCx_XCJad6YojT8-B7h5sZl3X', NULL, '$2y$13$4B3aRVXiaBHHbSN90diaOusN0NTHnU//db30JzYND73g8rR0A.UC.', '123123', NULL, 'hakob@fastnet.am', 10, 'operator', '2021-03-30 17:59:31', '2021-03-30 17:59:31', 'Դավթյան'),
(25, 'argamfast', 'Արգամ ', 'UMNQzqBII8qRBgl_0YgVydd2flCF4lnr', NULL, '$2y$13$D6tsG9j/uKD1zGF6eSEIt.ROHV.fy5/U7m5Kamhp74M52YOQTiCvq', 'argamfast', NULL, 'argamg626@gmail.com', 10, 'operator', '2021-04-09 15:21:47', '2021-04-09 15:21:47', 'Գալստյան');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `base_stations_ip`
--
ALTER TABLE `base_stations_ip`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `b_share`
--
ALTER TABLE `b_share`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `b_share_lang`
--
ALTER TABLE `b_share_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `b_share_tariff_config`
--
ALTER TABLE `b_share_tariff_config`
  ADD PRIMARY KEY (`share_id`,`tariff_id`);

--
-- Индексы таблицы `b_share_user_config`
--
ALTER TABLE `b_share_user_config`
  ADD PRIMARY KEY (`share_id`,`user_id`);

--
-- Индексы таблицы `channel_broadcast_language`
--
ALTER TABLE `channel_broadcast_language`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `channel_category`
--
ALTER TABLE `channel_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `channel_category_lang`
--
ALTER TABLE `channel_category_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `channel_id_broadcast_id`
--
ALTER TABLE `channel_id_broadcast_id`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `channel_quality`
--
ALTER TABLE `channel_quality`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `channel_quality_lang`
--
ALTER TABLE `channel_quality_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `checklist`
--
ALTER TABLE `checklist`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `checkpoints`
--
ALTER TABLE `checkpoints`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `checkpoint_person`
--
ALTER TABLE `checkpoint_person`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cities_lang`
--
ALTER TABLE `cities_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `company_document`
--
ALTER TABLE `company_document`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `company_scope`
--
ALTER TABLE `company_scope`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `company_scope_lang`
--
ALTER TABLE `company_scope_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `company_type`
--
ALTER TABLE `company_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `company_type_lang`
--
ALTER TABLE `company_type_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contact_adress`
--
ALTER TABLE `contact_adress`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contact_company`
--
ALTER TABLE `contact_company`
  ADD PRIMARY KEY (`contact_id`,`company_id`);

--
-- Индексы таблицы `contact_email`
--
ALTER TABLE `contact_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `countries_lang`
--
ALTER TABLE `countries_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_cash_register_receipt`
--
ALTER TABLE `crm_cash_register_receipt`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_comments`
--
ALTER TABLE `crm_comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_company`
--
ALTER TABLE `crm_company`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_contact`
--
ALTER TABLE `crm_contact`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_contact_passport`
--
ALTER TABLE `crm_contact_passport`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_contact_phone`
--
ALTER TABLE `crm_contact_phone`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Индексы таблицы `crm_custom_fields`
--
ALTER TABLE `crm_custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_custom_fields_lang`
--
ALTER TABLE `crm_custom_fields_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_custom_list`
--
ALTER TABLE `crm_custom_list`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_custom_list_lang`
--
ALTER TABLE `crm_custom_list_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_deal`
--
ALTER TABLE `crm_deal`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_deal_file`
--
ALTER TABLE `crm_deal_file`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_deal_vacation`
--
ALTER TABLE `crm_deal_vacation`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_field_type`
--
ALTER TABLE `crm_field_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_field_value`
--
ALTER TABLE `crm_field_value`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_lead`
--
ALTER TABLE `crm_lead`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_menu`
--
ALTER TABLE `crm_menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_phone_type`
--
ALTER TABLE `crm_phone_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_phone_type_lang`
--
ALTER TABLE `crm_phone_type_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_product`
--
ALTER TABLE `crm_product`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_section`
--
ALTER TABLE `crm_section`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_section_lang`
--
ALTER TABLE `crm_section_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_status`
--
ALTER TABLE `crm_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_status_lang`
--
ALTER TABLE `crm_status_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cron`
--
ALTER TABLE `cron`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currency_lang`
--
ALTER TABLE `currency_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `deal_address`
--
ALTER TABLE `deal_address`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `deal_conect`
--
ALTER TABLE `deal_conect`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `deal_ip`
--
ALTER TABLE `deal_ip`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `deal_payment_log`
--
ALTER TABLE `deal_payment_log`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `deal_type`
--
ALTER TABLE `deal_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `deal_type_lang`
--
ALTER TABLE `deal_type_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `favorite_pinned`
--
ALTER TABLE `favorite_pinned`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_antenna_ip`
--
ALTER TABLE `f_antenna_ip`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_base_station`
--
ALTER TABLE `f_base_station`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_baze_station_equipments`
--
ALTER TABLE `f_baze_station_equipments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_cashier`
--
ALTER TABLE `f_cashier`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_cashier_operator`
--
ALTER TABLE `f_cashier_operator`
  ADD PRIMARY KEY (`cashier_id`,`operator_id`);

--
-- Индексы таблицы `f_community`
--
ALTER TABLE `f_community`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_contacts`
--
ALTER TABLE `f_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_data`
--
ALTER TABLE `f_data`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_data_base`
--
ALTER TABLE `f_data_base`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_deal`
--
ALTER TABLE `f_deal`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_deal_address`
--
ALTER TABLE `f_deal_address`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_deal_agreement`
--
ALTER TABLE `f_deal_agreement`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_deal_antenna_ip`
--
ALTER TABLE `f_deal_antenna_ip`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_deal_ballance`
--
ALTER TABLE `f_deal_ballance`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_deal_connect_mikrotik`
--
ALTER TABLE `f_deal_connect_mikrotik`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_deal_disabled_day`
--
ALTER TABLE `f_deal_disabled_day`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_deal_disruption`
--
ALTER TABLE `f_deal_disruption`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_deal_ip`
--
ALTER TABLE `f_deal_ip`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_deal_sale`
--
ALTER TABLE `f_deal_sale`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_disruption_options`
--
ALTER TABLE `f_disruption_options`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_disruption_types`
--
ALTER TABLE `f_disruption_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_streets`
--
ALTER TABLE `f_streets`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_tariff`
--
ALTER TABLE `f_tariff`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_task`
--
ALTER TABLE `f_task`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_task_executor`
--
ALTER TABLE `f_task_executor`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_task_option`
--
ALTER TABLE `f_task_option`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_task_priority`
--
ALTER TABLE `f_task_priority`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_vacation_options`
--
ALTER TABLE `f_vacation_options`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_vacation_type`
--
ALTER TABLE `f_vacation_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_zone`
--
ALTER TABLE `f_zone`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_zone_cities`
--
ALTER TABLE `f_zone_cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_zone_community`
--
ALTER TABLE `f_zone_community`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_zone_regions`
--
ALTER TABLE `f_zone_regions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `f_zone_street`
--
ALTER TABLE `f_zone_street`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `hr_class_departments`
--
ALTER TABLE `hr_class_departments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `internet`
--
ALTER TABLE `internet`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ip_addresses`
--
ALTER TABLE `ip_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`,`language`),
  ADD KEY `idx_message_language` (`language`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `regions_lang`
--
ALTER TABLE `regions_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `search_settings`
--
ALTER TABLE `search_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `services_lang`
--
ALTER TABLE `services_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `service_country`
--
ALTER TABLE `service_country`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `service_tariff`
--
ALTER TABLE `service_tariff`
  ADD PRIMARY KEY (`service_id`,`tariff_id`);

--
-- Индексы таблицы `service_tariff_location`
--
ALTER TABLE `service_tariff_location`
  ADD PRIMARY KEY (`service_id`,`tariff_id`,`country_id`,`region_id`,`city_id`);

--
-- Индексы таблицы `source_message`
--
ALTER TABLE `source_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_source_message_category` (`category`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `table_settings`
--
ALTER TABLE `table_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tags_task`
--
ALTER TABLE `tags_task`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_all_columns` (`task_id`,`tag_id`);

--
-- Индексы таблицы `tariff`
--
ALTER TABLE `tariff`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tariff_lang`
--
ALTER TABLE `tariff_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks_timing`
--
ALTER TABLE `tasks_timing`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `task_person`
--
ALTER TABLE `task_person`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_all_columns` (`task_id`,`person_id`,`status`);

--
-- Индексы таблицы `tbl_dynagrid`
--
ALTER TABLE `tbl_dynagrid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_dynagrid_FK1` (`filter_id`),
  ADD KEY `tbl_dynagrid_FK2` (`sort_id`);

--
-- Индексы таблицы `tbl_dynagrid_dtl`
--
ALTER TABLE `tbl_dynagrid_dtl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_dynagrid_dtl_UK1` (`name`,`category`,`dynagrid_id`);

--
-- Индексы таблицы `tv_channel`
--
ALTER TABLE `tv_channel`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tv_channel_lang`
--
ALTER TABLE `tv_channel_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tv_packet`
--
ALTER TABLE `tv_packet`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tv_packet_channel`
--
ALTER TABLE `tv_packet_channel`
  ADD PRIMARY KEY (`packet_id`,`channel_id`);

--
-- Индексы таблицы `tv_packet_lang`
--
ALTER TABLE `tv_packet_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `units_lang`
--
ALTER TABLE `units_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `base_stations_ip`
--
ALTER TABLE `base_stations_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT для таблицы `b_share`
--
ALTER TABLE `b_share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `b_share_lang`
--
ALTER TABLE `b_share_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `channel_broadcast_language`
--
ALTER TABLE `channel_broadcast_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `channel_category`
--
ALTER TABLE `channel_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `channel_category_lang`
--
ALTER TABLE `channel_category_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `channel_id_broadcast_id`
--
ALTER TABLE `channel_id_broadcast_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `channel_quality`
--
ALTER TABLE `channel_quality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `channel_quality_lang`
--
ALTER TABLE `channel_quality_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `checklist`
--
ALTER TABLE `checklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `checkpoints`
--
ALTER TABLE `checkpoints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `checkpoint_person`
--
ALTER TABLE `checkpoint_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT для таблицы `cities_lang`
--
ALTER TABLE `cities_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT для таблицы `company_document`
--
ALTER TABLE `company_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `company_scope`
--
ALTER TABLE `company_scope`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `company_scope_lang`
--
ALTER TABLE `company_scope_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `company_type`
--
ALTER TABLE `company_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `company_type_lang`
--
ALTER TABLE `company_type_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `contact_adress`
--
ALTER TABLE `contact_adress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `contact_email`
--
ALTER TABLE `contact_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `countries_lang`
--
ALTER TABLE `countries_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `crm_cash_register_receipt`
--
ALTER TABLE `crm_cash_register_receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_comments`
--
ALTER TABLE `crm_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_company`
--
ALTER TABLE `crm_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_contact`
--
ALTER TABLE `crm_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `crm_contact_passport`
--
ALTER TABLE `crm_contact_passport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_contact_phone`
--
ALTER TABLE `crm_contact_phone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `crm_custom_fields`
--
ALTER TABLE `crm_custom_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_custom_fields_lang`
--
ALTER TABLE `crm_custom_fields_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_custom_list`
--
ALTER TABLE `crm_custom_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_custom_list_lang`
--
ALTER TABLE `crm_custom_list_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_deal`
--
ALTER TABLE `crm_deal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_deal_file`
--
ALTER TABLE `crm_deal_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_deal_vacation`
--
ALTER TABLE `crm_deal_vacation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_field_type`
--
ALTER TABLE `crm_field_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_field_value`
--
ALTER TABLE `crm_field_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_lead`
--
ALTER TABLE `crm_lead`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_menu`
--
ALTER TABLE `crm_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_phone_type`
--
ALTER TABLE `crm_phone_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_phone_type_lang`
--
ALTER TABLE `crm_phone_type_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_product`
--
ALTER TABLE `crm_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_section`
--
ALTER TABLE `crm_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_section_lang`
--
ALTER TABLE `crm_section_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_status`
--
ALTER TABLE `crm_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `crm_status_lang`
--
ALTER TABLE `crm_status_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `cron`
--
ALTER TABLE `cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT для таблицы `currency_lang`
--
ALTER TABLE `currency_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `deal_address`
--
ALTER TABLE `deal_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT для таблицы `deal_conect`
--
ALTER TABLE `deal_conect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `deal_ip`
--
ALTER TABLE `deal_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `deal_payment_log`
--
ALTER TABLE `deal_payment_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT для таблицы `deal_type`
--
ALTER TABLE `deal_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `deal_type_lang`
--
ALTER TABLE `deal_type_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `favorite_pinned`
--
ALTER TABLE `favorite_pinned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_antenna_ip`
--
ALTER TABLE `f_antenna_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_base_station`
--
ALTER TABLE `f_base_station`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=177;
--
-- AUTO_INCREMENT для таблицы `f_baze_station_equipments`
--
ALTER TABLE `f_baze_station_equipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT для таблицы `f_cashier`
--
ALTER TABLE `f_cashier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `f_community`
--
ALTER TABLE `f_community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT для таблицы `f_contacts`
--
ALTER TABLE `f_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_data`
--
ALTER TABLE `f_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=148;
--
-- AUTO_INCREMENT для таблицы `f_data_base`
--
ALTER TABLE `f_data_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=156;
--
-- AUTO_INCREMENT для таблицы `f_deal`
--
ALTER TABLE `f_deal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT для таблицы `f_deal_address`
--
ALTER TABLE `f_deal_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT для таблицы `f_deal_agreement`
--
ALTER TABLE `f_deal_agreement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `f_deal_antenna_ip`
--
ALTER TABLE `f_deal_antenna_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_deal_ballance`
--
ALTER TABLE `f_deal_ballance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT для таблицы `f_deal_connect_mikrotik`
--
ALTER TABLE `f_deal_connect_mikrotik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT для таблицы `f_deal_disabled_day`
--
ALTER TABLE `f_deal_disabled_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `f_deal_disruption`
--
ALTER TABLE `f_deal_disruption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_deal_ip`
--
ALTER TABLE `f_deal_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_deal_sale`
--
ALTER TABLE `f_deal_sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_disruption_options`
--
ALTER TABLE `f_disruption_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_disruption_types`
--
ALTER TABLE `f_disruption_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_streets`
--
ALTER TABLE `f_streets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT для таблицы `f_tariff`
--
ALTER TABLE `f_tariff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT для таблицы `f_task`
--
ALTER TABLE `f_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_task_executor`
--
ALTER TABLE `f_task_executor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_task_option`
--
ALTER TABLE `f_task_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_task_priority`
--
ALTER TABLE `f_task_priority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_vacation_options`
--
ALTER TABLE `f_vacation_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_vacation_type`
--
ALTER TABLE `f_vacation_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_zone`
--
ALTER TABLE `f_zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `f_zone_cities`
--
ALTER TABLE `f_zone_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT для таблицы `f_zone_community`
--
ALTER TABLE `f_zone_community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_zone_regions`
--
ALTER TABLE `f_zone_regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `f_zone_street`
--
ALTER TABLE `f_zone_street`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `hr_class_departments`
--
ALTER TABLE `hr_class_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `internet`
--
ALTER TABLE `internet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `ip_addresses`
--
ALTER TABLE `ip_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9084;
--
-- AUTO_INCREMENT для таблицы `persons`
--
ALTER TABLE `persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `regions_lang`
--
ALTER TABLE `regions_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `search_settings`
--
ALTER TABLE `search_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `services_lang`
--
ALTER TABLE `services_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `service_country`
--
ALTER TABLE `service_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `source_message`
--
ALTER TABLE `source_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=320;
--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `table_settings`
--
ALTER TABLE `table_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tags_task`
--
ALTER TABLE `tags_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tariff`
--
ALTER TABLE `tariff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tariff_lang`
--
ALTER TABLE `tariff_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tasks_timing`
--
ALTER TABLE `tasks_timing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `task_person`
--
ALTER TABLE `task_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tv_channel`
--
ALTER TABLE `tv_channel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tv_channel_lang`
--
ALTER TABLE `tv_channel_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tv_packet`
--
ALTER TABLE `tv_packet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `tv_packet_lang`
--
ALTER TABLE `tv_packet_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `units_lang`
--
ALTER TABLE `units_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_source_message` FOREIGN KEY (`id`) REFERENCES `source_message` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_dynagrid`
--
ALTER TABLE `tbl_dynagrid`
  ADD CONSTRAINT `tbl_dynagrid_FK2` FOREIGN KEY (`sort_id`) REFERENCES `tbl_dynagrid_dtl` (`id`),
  ADD CONSTRAINT `tbl_dynagrid_FK1` FOREIGN KEY (`filter_id`) REFERENCES `tbl_dynagrid_dtl` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
