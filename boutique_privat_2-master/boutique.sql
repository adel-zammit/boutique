-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 25 oct. 2020 à 21:11
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sex` enum('m','mme') NOT NULL DEFAULT 'm',
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `additional_address` text NOT NULL,
  `country_code` char(2) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `city` varchar(150) NOT NULL,
  `cell_phone` varchar(100) NOT NULL,
  `landline_phone` varchar(100) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`address_id`, `name`, `user_id`, `sex`, `first_name`, `last_name`, `address`, `additional_address`, `country_code`, `zip_code`, `city`, `cell_phone`, `landline_phone`) VALUES
(2, 'Testee', 1, 'm', 'BASTIEN', 'ALBERT', '1 rue de la fontaine', '', 'FR', 84760, 'ST MARTIN DE LA BRASQUE', '0621980455', 'ST MARTIN DE LA BRASQUE'),
(3, 'BASTIEN ALBERT', 1, 'm', 'BASTIEN', 'ALBERT', '1 rue de la fontaine', '', 'FR', 84760, 'ST MARTIN DE LA BRASQUE', '0621980455', 'ST MARTIN DE LA BRASQUE'),
(4, 'BASTIEN ALBERT', 1, 'm', 'BASTIEN', 'ALBERT', '1 rue de la fontaine', '', '', 84760, 'ST MARTIN DE LA BRASQUE', '0621980455', 'ST MARTIN DE LA BRASQUE'),
(5, 'Bastien Albert', 2, 'm', 'Bastien', 'albert', '1 rue de la fontaine', '', '', 84760, 'saint martin de la brasque', '0621980455', 'saint martin de la brasque'),
(6, 'BASTIEN ALBERT', 1, 'm', 'BASTIEN', 'ALBERT', '1 rue de la fontaine', '', 'FR', 84760, 'ST MARTIN DE LA BRASQUE', '0621980455', 'ST MARTIN DE LA BRASQUE');

-- --------------------------------------------------------

--
-- Structure de la table `address_invoice_log`
--

DROP TABLE IF EXISTS `address_invoice_log`;
CREATE TABLE IF NOT EXISTS `address_invoice_log` (
  `address_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_name` varchar(100) NOT NULL,
  `sex` enum('m','mme') NOT NULL DEFAULT 'm',
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `additional_address` text NOT NULL,
  `zip_code` int(11) NOT NULL,
  `city` varchar(150) NOT NULL,
  `cell_phone` varchar(100) NOT NULL,
  `landline_phone` varchar(100) NOT NULL,
  `log_date` int(11) NOT NULL,
  PRIMARY KEY (`address_id`,`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `address_invoice_log`
--

INSERT INTO `address_invoice_log` (`address_id`, `invoice_id`, `user_id`, `address_name`, `sex`, `first_name`, `last_name`, `address`, `additional_address`, `zip_code`, `city`, `cell_phone`, `landline_phone`, `log_date`) VALUES
(4, 21, 1, 'BASTIEN ALBERT', 'm', 'BASTIEN', 'ALBERT', '1 rue de la fontaine', '', 84760, 'ST MARTIN DE LA BRASQUE', '0621980455', 'ST MARTIN DE LA BRASQUE', 0),
(4, 22, 1, 'BASTIEN ALBERT', 'm', 'BASTIEN', 'ALBERT', '1 rue de la fontaine', '', 84760, 'ST MARTIN DE LA BRASQUE', '0621980455', 'ST MARTIN DE LA BRASQUE', 0);

-- --------------------------------------------------------

--
-- Structure de la table `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `product_id`, `quantity`, `invoice_id`) VALUES
(36, 1, 2, 1, 29),
(37, 1, 4, 1, 29);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category_parent_id` int(11) NOT NULL,
  `name_logo_category` varchar(255) NOT NULL,
  `depth` int(11) NOT NULL,
  `display_order` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`, `category_parent_id`, `name_logo_category`, `depth`, `display_order`) VALUES
(5, 'Ram', '', 0, '', 0, 0),
(9, 'sdqfd', 'sdqfs', 5, 'Screenshot_2.png', 1, 0),
(10, 'sdqfdcwxcxw', 'sdqfsxwcwx', 5, '', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `country_code` char(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `native_name` varchar(255) NOT NULL,
  `iso_code` char(3) NOT NULL,
  `sales_tax_rate` decimal(10,3) NOT NULL,
  PRIMARY KEY (`country_code`),
  KEY `sales_tax_rate` (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `country`
--

INSERT INTO `country` (`country_code`, `name`, `native_name`, `iso_code`, `sales_tax_rate`) VALUES
('AD', 'Andorra', 'Andorra', 'AND', '-0.001'),
('AE', 'United Arab Emirates', 'دولة الإمارات العربية المتحدة', 'ARE', '-0.001'),
('AF', 'Afghanistan', 'افغانستان', 'AFG', '-0.001'),
('AG', 'Antigua and Barbuda', 'Antigua and Barbuda', 'ATG', '-0.001'),
('AI', 'Anguilla', 'Anguilla', 'AIA', '-0.001'),
('AL', 'Albania', 'Shqipëria', 'ALB', '-0.001'),
('AM', 'Armenia', 'Հայաստան', 'ARM', '-0.001'),
('AO', 'Angola', 'Angola', 'AGO', '-0.001'),
('AQ', 'Antarctica', 'Antarctica', 'ATA', '-0.001'),
('AR', 'Argentina', 'Argentina', 'ARG', '-0.001'),
('AS', 'American Samoa', 'American Samoa', 'ASM', '-0.001'),
('AT', 'Austria', 'Österreich', 'AUT', '20.000'),
('AU', 'Australia', 'Australia', 'AUS', '-0.001'),
('AW', 'Aruba', 'Aruba', 'ABW', '-0.001'),
('AX', 'Åland Islands', 'Åland', 'ALA', '-0.001'),
('AZ', 'Azerbaijan', 'Azərbaycan', 'AZE', '-0.001'),
('BA', 'Bosnia and Herzegovina', 'Bosna i Hercegovina', 'BIH', '-0.001'),
('BB', 'Barbados', 'Barbados', 'BRB', '-0.001'),
('BD', 'Bangladesh', 'Bangladesh', 'BGD', '-0.001'),
('BE', 'Belgium', 'België', 'BEL', '21.000'),
('BF', 'Burkina Faso', 'Burkina Faso', 'BFA', '-0.001'),
('BG', 'Bulgaria', 'България', 'BGR', '20.000'),
('BH', 'Bahrain', '‏البحرين', 'BHR', '-0.001'),
('BI', 'Burundi', 'Burundi', 'BDI', '-0.001'),
('BJ', 'Benin', 'Bénin', 'BEN', '-0.001'),
('BL', 'Saint Barthélemy', 'Saint-Barthélemy', 'BLM', '-0.001'),
('BM', 'Bermuda', 'Bermuda', 'BMU', '-0.001'),
('BN', 'Brunei Darussalam', 'Negara Brunei Darussalam', 'BRN', '-0.001'),
('BO', 'Bolivia (Plurinational State of)', 'Bolivia', 'BOL', '-0.001'),
('BQ', 'Bonaire, Sint Eustatius and Saba', 'Bonaire', 'BES', '-0.001'),
('BR', 'Brazil', 'Brasil', 'BRA', '-0.001'),
('BS', 'Bahamas', 'Bahamas', 'BHS', '-0.001'),
('BT', 'Bhutan', 'ʼbrug-yul', 'BTN', '-0.001'),
('BV', 'Bouvet Island', 'Bouvetøya', 'BVT', '-0.001'),
('BW', 'Botswana', 'Botswana', 'BWA', '-0.001'),
('BY', 'Belarus', 'Белару́сь', 'BLR', '-0.001'),
('BZ', 'Belize', 'Belize', 'BLZ', '-0.001'),
('CA', 'Canada', 'Canada', 'CAN', '-0.001'),
('CC', 'Cocos (Keeling) Islands', 'Cocos (Keeling) Islands', 'CCK', '-0.001'),
('CD', 'Congo (Democratic Republic of the)', 'République démocratique du Congo', 'COD', '-0.001'),
('CF', 'Central African Republic', 'Ködörösêse tî Bêafrîka', 'CAF', '-0.001'),
('CG', 'Congo', 'République du Congo', 'COG', '-0.001'),
('CH', 'Switzerland', 'Schweiz', 'CHE', '-0.001'),
('CI', 'Côte d\'Ivoire', 'Côte d\'Ivoire', 'CIV', '-0.001'),
('CK', 'Cook Islands', 'Cook Islands', 'COK', '-0.001'),
('CL', 'Chile', 'Chile', 'CHL', '-0.001'),
('CM', 'Cameroon', 'Cameroon', 'CMR', '-0.001'),
('CN', 'China', '中国', 'CHN', '-0.001'),
('CO', 'Colombia', 'Colombia', 'COL', '-0.001'),
('CR', 'Costa Rica', 'Costa Rica', 'CRI', '-0.001'),
('CU', 'Cuba', 'Cuba', 'CUB', '-0.001'),
('CV', 'Cabo Verde', 'Cabo Verde', 'CPV', '-0.001'),
('CW', 'Curaçao', 'Curaçao', 'CUW', '-0.001'),
('CX', 'Christmas Island', 'Christmas Island', 'CXR', '-0.001'),
('CY', 'Cyprus', 'Κύπρος', 'CYP', '19.000'),
('CZ', 'Czech Republic', 'Česká republika', 'CZE', '21.000'),
('DE', 'Germany', 'Deutschland', 'DEU', '16.000'),
('DJ', 'Djibouti', 'Djibouti', 'DJI', '-0.001'),
('DK', 'Denmark', 'Danmark', 'DNK', '25.000'),
('DM', 'Dominica', 'Dominica', 'DMA', '-0.001'),
('DO', 'Dominican Republic', 'República Dominicana', 'DOM', '-0.001'),
('DZ', 'Algeria', 'الجزائر', 'DZA', '-0.001'),
('EC', 'Ecuador', 'Ecuador', 'ECU', '-0.001'),
('EE', 'Estonia', 'Eesti', 'EST', '20.000'),
('EG', 'Egypt', 'مصر‎', 'EGY', '-0.001'),
('EH', 'Western Sahara', 'الصحراء الغربية', 'ESH', '-0.001'),
('ER', 'Eritrea', 'ኤርትራ', 'ERI', '-0.001'),
('ES', 'Spain', 'España', 'ESP', '21.000'),
('ET', 'Ethiopia', 'ኢትዮጵያ', 'ETH', '-0.001'),
('FI', 'Finland', 'Suomi', 'FIN', '24.000'),
('FJ', 'Fiji', 'Fiji', 'FJI', '-0.001'),
('FK', 'Falkland Islands (Malvinas)', 'Falkland Islands', 'FLK', '-0.001'),
('FM', 'Micronesia (Federated States of)', 'Micronesia', 'FSM', '-0.001'),
('FO', 'Faroe Islands', 'Føroyar', 'FRO', '-0.001'),
('FR', 'France', 'France', 'FRA', '20.000'),
('GA', 'Gabon', 'Gabon', 'GAB', '-0.001'),
('GB', 'United Kingdom of Great Britain and Northern Ireland', 'United Kingdom', 'GBR', '20.000'),
('GD', 'Grenada', 'Grenada', 'GRD', '-0.001'),
('GE', 'Georgia', 'საქართველო', 'GEO', '-0.001'),
('GF', 'French Guiana', 'Guyane française', 'GUF', '-0.001'),
('GG', 'Guernsey', 'Guernsey', 'GGY', '-0.001'),
('GH', 'Ghana', 'Ghana', 'GHA', '-0.001'),
('GI', 'Gibraltar', 'Gibraltar', 'GIB', '-0.001'),
('GL', 'Greenland', 'Kalaallit Nunaat', 'GRL', '-0.001'),
('GM', 'Gambia', 'Gambia', 'GMB', '-0.001'),
('GN', 'Guinea', 'Guinée', 'GIN', '-0.001'),
('GP', 'Guadeloupe', 'Guadeloupe', 'GLP', '-0.001'),
('GQ', 'Equatorial Guinea', 'Guinea Ecuatorial', 'GNQ', '-0.001'),
('GR', 'Greece', 'Ελλάδα', 'GRC', '24.000'),
('GS', 'South Georgia and the South Sandwich Islands', 'South Georgia', 'SGS', '-0.001'),
('GT', 'Guatemala', 'Guatemala', 'GTM', '-0.001'),
('GU', 'Guam', 'Guam', 'GUM', '-0.001'),
('GW', 'Guinea-Bissau', 'Guiné-Bissau', 'GNB', '-0.001'),
('GY', 'Guyana', 'Guyana', 'GUY', '-0.001'),
('HK', 'Hong Kong', '香港', 'HKG', '-0.001'),
('HM', 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', 'HMD', '-0.001'),
('HN', 'Honduras', 'Honduras', 'HND', '-0.001'),
('HR', 'Croatia', 'Hrvatska', 'HRV', '25.000'),
('HT', 'Haiti', 'Haïti', 'HTI', '-0.001'),
('HU', 'Hungary', 'Magyarország', 'HUN', '27.000'),
('ID', 'Indonesia', 'Indonesia', 'IDN', '-0.001'),
('IE', 'Ireland', 'Éire', 'IRL', '21.000'),
('IL', 'Israel', 'יִשְׂרָאֵל', 'ISR', '-0.001'),
('IM', 'Isle of Man', 'Isle of Man', 'IMN', '-0.001'),
('IN', 'India', 'भारत', 'IND', '-0.001'),
('IO', 'British Indian Ocean Territory', 'British Indian Ocean Territory', 'IOT', '-0.001'),
('IQ', 'Iraq', 'العراق', 'IRQ', '-0.001'),
('IR', 'Iran (Islamic Republic of)', 'ایران', 'IRN', '-0.001'),
('IS', 'Iceland', 'Ísland', 'ISL', '-0.001'),
('IT', 'Italy', 'Italia', 'ITA', '22.000'),
('JE', 'Jersey', 'Jersey', 'JEY', '-0.001'),
('JM', 'Jamaica', 'Jamaica', 'JAM', '-0.001'),
('JO', 'Jordan', 'الأردن', 'JOR', '-0.001'),
('JP', 'Japan', '日本', 'JPN', '-0.001'),
('KE', 'Kenya', 'Kenya', 'KEN', '-0.001'),
('KG', 'Kyrgyzstan', 'Кыргызстан', 'KGZ', '-0.001'),
('KH', 'Cambodia', 'Kâmpŭchéa', 'KHM', '-0.001'),
('KI', 'Kiribati', 'Kiribati', 'KIR', '-0.001'),
('KM', 'Comoros', 'Komori', 'COM', '-0.001'),
('KN', 'Saint Kitts and Nevis', 'Saint Kitts and Nevis', 'KNA', '-0.001'),
('KP', 'Korea (Democratic People\'s Republic of)', '북한', 'PRK', '-0.001'),
('KR', 'Korea (Republic of)', '대한민국', 'KOR', '-0.001'),
('KW', 'Kuwait', 'الكويت', 'KWT', '-0.001'),
('KY', 'Cayman Islands', 'Cayman Islands', 'CYM', '-0.001'),
('KZ', 'Kazakhstan', 'Қазақстан', 'KAZ', '-0.001'),
('LA', 'Lao People\'s Democratic Republic', 'ສປປລາວ', 'LAO', '-0.001'),
('LB', 'Lebanon', 'لبنان', 'LBN', '-0.001'),
('LC', 'Saint Lucia', 'Saint Lucia', 'LCA', '-0.001'),
('LI', 'Liechtenstein', 'Liechtenstein', 'LIE', '-0.001'),
('LK', 'Sri Lanka', 'śrī laṃkāva', 'LKA', '-0.001'),
('LR', 'Liberia', 'Liberia', 'LBR', '-0.001'),
('LS', 'Lesotho', 'Lesotho', 'LSO', '-0.001'),
('LT', 'Lithuania', 'Lietuva', 'LTU', '21.000'),
('LU', 'Luxembourg', 'Luxembourg', 'LUX', '17.000'),
('LV', 'Latvia', 'Latvija', 'LVA', '21.000'),
('LY', 'Libya', '‏ليبيا', 'LBY', '-0.001'),
('MA', 'Morocco', 'المغرب', 'MAR', '-0.001'),
('MC', 'Monaco', 'Monaco', 'MCO', '-0.001'),
('MD', 'Moldova (Republic of)', 'Moldova', 'MDA', '-0.001'),
('ME', 'Montenegro', 'Црна Гора', 'MNE', '-0.001'),
('MF', 'Saint Martin (French part)', 'Saint-Martin', 'MAF', '-0.001'),
('MG', 'Madagascar', 'Madagasikara', 'MDG', '-0.001'),
('MH', 'Marshall Islands', 'M̧ajeļ', 'MHL', '-0.001'),
('MK', 'Macedonia (the former Yugoslav Republic of)', 'Македонија', 'MKD', '-0.001'),
('ML', 'Mali', 'Mali', 'MLI', '-0.001'),
('MM', 'Myanmar', 'Myanma', 'MMR', '-0.001'),
('MN', 'Mongolia', 'Монгол улс', 'MNG', '-0.001'),
('MO', 'Macao', '澳門', 'MAC', '-0.001'),
('MP', 'Northern Mariana Islands', 'Northern Mariana Islands', 'MNP', '-0.001'),
('MQ', 'Martinique', 'Martinique', 'MTQ', '-0.001'),
('MR', 'Mauritania', 'موريتانيا', 'MRT', '-0.001'),
('MS', 'Montserrat', 'Montserrat', 'MSR', '-0.001'),
('MT', 'Malta', 'Malta', 'MLT', '18.000'),
('MU', 'Mauritius', 'Maurice', 'MUS', '-0.001'),
('MV', 'Maldives', 'Maldives', 'MDV', '-0.001'),
('MW', 'Malawi', 'Malawi', 'MWI', '-0.001'),
('MX', 'Mexico', 'México', 'MEX', '-0.001'),
('MY', 'Malaysia', 'Malaysia', 'MYS', '-0.001'),
('MZ', 'Mozambique', 'Moçambique', 'MOZ', '-0.001'),
('NA', 'Namibia', 'Namibia', 'NAM', '-0.001'),
('NC', 'New Caledonia', 'Nouvelle-Calédonie', 'NCL', '-0.001'),
('NE', 'Niger', 'Niger', 'NER', '-0.001'),
('NF', 'Norfolk Island', 'Norfolk Island', 'NFK', '-0.001'),
('NG', 'Nigeria', 'Nigeria', 'NGA', '-0.001'),
('NI', 'Nicaragua', 'Nicaragua', 'NIC', '-0.001'),
('NL', 'Netherlands', 'Nederland', 'NLD', '21.000'),
('NO', 'Norway', 'Norge', 'NOR', '-0.001'),
('NP', 'Nepal', 'नेपाल', 'NPL', '-0.001'),
('NR', 'Nauru', 'Nauru', 'NRU', '-0.001'),
('NU', 'Niue', 'Niuē', 'NIU', '-0.001'),
('NZ', 'New Zealand', 'New Zealand', 'NZL', '-0.001'),
('OM', 'Oman', 'عمان', 'OMN', '-0.001'),
('PA', 'Panama', 'Panamá', 'PAN', '-0.001'),
('PE', 'Peru', 'Perú', 'PER', '-0.001'),
('PF', 'French Polynesia', 'Polynésie française', 'PYF', '-0.001'),
('PG', 'Papua New Guinea', 'Papua Niugini', 'PNG', '-0.001'),
('PH', 'Philippines', 'Pilipinas', 'PHL', '-0.001'),
('PK', 'Pakistan', 'Pakistan', 'PAK', '-0.001'),
('PL', 'Poland', 'Polska', 'POL', '23.000'),
('PM', 'Saint Pierre and Miquelon', 'Saint-Pierre-et-Miquelon', 'SPM', '-0.001'),
('PN', 'Pitcairn', 'Pitcairn Islands', 'PCN', '-0.001'),
('PR', 'Puerto Rico', 'Puerto Rico', 'PRI', '-0.001'),
('PS', 'Palestine, State of', 'فلسطين', 'PSE', '-0.001'),
('PT', 'Portugal', 'Portugal', 'PRT', '23.000'),
('PW', 'Palau', 'Palau', 'PLW', '-0.001'),
('PY', 'Paraguay', 'Paraguay', 'PRY', '-0.001'),
('QA', 'Qatar', 'قطر', 'QAT', '-0.001'),
('RE', 'Réunion', 'La Réunion', 'REU', '-0.001'),
('RO', 'Romania', 'România', 'ROU', '19.000'),
('RS', 'Serbia', 'Србија', 'SRB', '-0.001'),
('RU', 'Russian Federation', 'Россия', 'RUS', '-0.001'),
('RW', 'Rwanda', 'Rwanda', 'RWA', '-0.001'),
('SA', 'Saudi Arabia', 'العربية السعودية', 'SAU', '-0.001'),
('SB', 'Solomon Islands', 'Solomon Islands', 'SLB', '-0.001'),
('SC', 'Seychelles', 'Seychelles', 'SYC', '-0.001'),
('SD', 'Sudan', 'السودان', 'SDN', '-0.001'),
('SE', 'Sweden', 'Sverige', 'SWE', '25.000'),
('SG', 'Singapore', 'Singapore', 'SGP', '-0.001'),
('SH', 'Saint Helena, Ascension and Tristan da Cunha', 'Saint Helena', 'SHN', '-0.001'),
('SI', 'Slovenia', 'Slovenija', 'SVN', '22.000'),
('SJ', 'Svalbard and Jan Mayen', 'Svalbard og Jan Mayen', 'SJM', '-0.001'),
('SK', 'Slovakia', 'Slovensko', 'SVK', '20.000'),
('SL', 'Sierra Leone', 'Sierra Leone', 'SLE', '-0.001'),
('SM', 'San Marino', 'San Marino', 'SMR', '-0.001'),
('SN', 'Senegal', 'Sénégal', 'SEN', '-0.001'),
('SO', 'Somalia', 'Soomaaliya', 'SOM', '-0.001'),
('SR', 'Suriname', 'Suriname', 'SUR', '-0.001'),
('SS', 'South Sudan', 'South Sudan', 'SSD', '-0.001'),
('ST', 'Sao Tome and Principe', 'São Tomé e Príncipe', 'STP', '-0.001'),
('SV', 'El Salvador', 'El Salvador', 'SLV', '-0.001'),
('SX', 'Sint Maarten (Dutch part)', 'Sint Maarten', 'SXM', '-0.001'),
('SY', 'Syrian Arab Republic', 'سوريا', 'SYR', '-0.001'),
('SZ', 'Swaziland', 'Swaziland', 'SWZ', '-0.001'),
('TC', 'Turks and Caicos Islands', 'Turks and Caicos Islands', 'TCA', '-0.001'),
('TD', 'Chad', 'Tchad', 'TCD', '-0.001'),
('TF', 'French Southern Territories', 'Territoire des Terres australes et antarctiques françaises', 'ATF', '-0.001'),
('TG', 'Togo', 'Togo', 'TGO', '-0.001'),
('TH', 'Thailand', 'ประเทศไทย', 'THA', '-0.001'),
('TJ', 'Tajikistan', 'Тоҷикистон', 'TJK', '-0.001'),
('TK', 'Tokelau', 'Tokelau', 'TKL', '-0.001'),
('TL', 'Timor-Leste', 'Timor-Leste', 'TLS', '-0.001'),
('TM', 'Turkmenistan', 'Türkmenistan', 'TKM', '-0.001'),
('TN', 'Tunisia', 'تونس', 'TUN', '-0.001'),
('TO', 'Tonga', 'Tonga', 'TON', '-0.001'),
('TR', 'Turkey', 'Türkiye', 'TUR', '-0.001'),
('TT', 'Trinidad and Tobago', 'Trinidad and Tobago', 'TTO', '-0.001'),
('TV', 'Tuvalu', 'Tuvalu', 'TUV', '-0.001'),
('TW', 'Taiwan', '臺灣', 'TWN', '-0.001'),
('TZ', 'Tanzania, United Republic of', 'Tanzania', 'TZA', '-0.001'),
('UA', 'Ukraine', 'Україна', 'UKR', '-0.001'),
('UG', 'Uganda', 'Uganda', 'UGA', '-0.001'),
('UM', 'United States Minor Outlying Islands', 'United States Minor Outlying Islands', 'UMI', '-0.001'),
('US', 'United States of America', 'United States', 'USA', '-0.001'),
('UY', 'Uruguay', 'Uruguay', 'URY', '-0.001'),
('UZ', 'Uzbekistan', 'O‘zbekiston', 'UZB', '-0.001'),
('VA', 'Holy See', 'Sancta Sedes', 'VAT', '-0.001'),
('VC', 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 'VCT', '-0.001'),
('VE', 'Venezuela (Bolivarian Republic of)', 'Venezuela', 'VEN', '-0.001'),
('VG', 'Virgin Islands (British)', 'British Virgin Islands', 'VGB', '-0.001'),
('VI', 'Virgin Islands (U.S.)', 'Virgin Islands of the United States', 'VIR', '-0.001'),
('VN', 'Viet Nam', 'Việt Nam', 'VNM', '-0.001'),
('VU', 'Vanuatu', 'Vanuatu', 'VUT', '-0.001'),
('WF', 'Wallis and Futuna', 'Wallis et Futuna', 'WLF', '-0.001'),
('WS', 'Samoa', 'Samoa', 'WSM', '-0.001'),
('XK', 'Republic of Kosovo', 'Republika e Kosovës', 'KOS', '-0.001'),
('YE', 'Yemen', 'اليَمَن', 'YEM', '-0.001'),
('YT', 'Mayotte', 'Mayotte', 'MYT', '-0.001'),
('ZA', 'South Africa', 'South Africa', 'ZAF', '-0.001'),
('ZM', 'Zambia', 'Zambia', 'ZMB', '-0.001'),
('ZW', 'Zimbabwe', 'Zimbabwe', 'ZWE', '-0.001');

-- --------------------------------------------------------

--
-- Structure de la table `coupon`
--

DROP TABLE IF EXISTS `coupon`;
CREATE TABLE IF NOT EXISTS `coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `category_ids` mediumblob NOT NULL,
  `code` varchar(50) NOT NULL,
  `content_type` varbinary(25) NOT NULL,
  `coupon_type` enum('percent','value') NOT NULL DEFAULT 'percent',
  `value` decimal(10,2) NOT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  `coupon_date` int(11) NOT NULL,
  `coupon_min` decimal(10,2) NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `coupon`
--

INSERT INTO `coupon` (`coupon_id`, `title`, `category_ids`, `code`, `content_type`, `coupon_type`, `value`, `start_date`, `end_date`, `coupon_date`, `coupon_min`) VALUES
(1, 'testrtrtr', 0x5b5d, 'TEST50', 0x636f75706f6e5f616c6c, 'value', '10.20', 1601237340, 1629144540, 1601388380, '20.03'),
(2, 'test', 0x5b5d, 'TEST500', 0x636f75706f6e5f616c6c, 'percent', '20.00', 1601393820, 1602171420, 1601408259, '30.07');

-- --------------------------------------------------------

--
-- Structure de la table `coupon_log`
--

DROP TABLE IF EXISTS `coupon_log`;
CREATE TABLE IF NOT EXISTS `coupon_log` (
  `coupon_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `coupon_name` varchar(50) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `coupon_value` decimal(10,2) NOT NULL,
  `coupon_type` enum('percent','value') NOT NULL DEFAULT 'percent',
  `coupon_date` int(11) NOT NULL,
  `coupon_min` decimal(10,2) NOT NULL,
  PRIMARY KEY (`coupon_log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `coupon_log`
--

INSERT INTO `coupon_log` (`coupon_log_id`, `coupon_id`, `coupon_name`, `coupon_code`, `total_price`, `price`, `user_id`, `username`, `invoice_id`, `coupon_value`, `coupon_type`, `coupon_date`, `coupon_min`) VALUES
(1, 1, 'testrtrtr', 'TEST50', '21.00', '10.80', 1, 'CRUEL-MODZ', 17, '10.20', 'value', 0, '0.00'),
(2, 1, 'testrtrtr', 'TEST50', '62.00', '51.80', 1, 'CRUEL-MODZ', 19, '10.20', 'value', 0, '0.00'),
(3, 1, 'testrtrtr', 'TEST50', '40.00', '29.80', 1, 'CRUEL-MODZ', 20, '10.20', 'value', 0, '0.00'),
(4, 1, 'testrtrtr', 'TEST50', '10.50', '0.30', 1, 'CRUEL-MODZ', 21, '10.20', 'value', 0, '0.00'),
(5, 1, 'testrtrtr', 'TEST50', '10.50', '0.30', 1, 'CRUEL-MODZ', 22, '10.20', 'value', 0, '0.00');

-- --------------------------------------------------------

--
-- Structure de la table `cron`
--

DROP TABLE IF EXISTS `cron`;
CREATE TABLE IF NOT EXISTS `cron` (
  `cron_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(150) NOT NULL,
  `cron_exe` varchar(255) NOT NULL,
  `last_exe` int(11) NOT NULL,
  PRIMARY KEY (`cron_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cron`
--

INSERT INTO `cron` (`cron_id`, `title`, `description`, `cron_exe`, `last_exe`) VALUES
(1, 'Clear product image', 'Pour effacer de la base de données toutes les images de produit qui n\'est pas utilisé', 'App:ClearProductImg', 1603375047),
(2, 'Country', 'Country', 'App:updateCountry', 1603446086),
(3, 'Sale tax rate', 'Update sales tax rate', 'App:updateSalesTaxRate', 1603446806);

-- --------------------------------------------------------

--
-- Structure de la table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `invoice_state` int(11) NOT NULL,
  `sales_tax_rate` decimal(10,2) NOT NULL,
  `address_id` int(11) NOT NULL,
  `request_key` varchar(32) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `invoice_date` int(11) NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `user_id`, `price`, `total_price`, `invoice_state`, `sales_tax_rate`, `address_id`, `request_key`, `coupon_id`, `invoice_date`) VALUES
(4, 1, '172.00', '161.80', 1, '0.00', 1, '', 1, 1601985585),
(17, 1, '21.00', '10.80', 1, '0.00', 2, '', 1, 1602360913),
(15, 2, '31.53', '21.33', 1, '0.00', 5, '', 1, 1602104287),
(16, 2, '31.50', '21.30', 1, '0.00', 5, '', 1, 1602161479),
(20, 1, '40.00', '29.80', 1, '0.00', 2, '', 1, 1602442054),
(19, 1, '62.00', '51.80', 1, '0.00', 3, '', 1, 1602361129),
(21, 1, '10.50', '0.30', 1, '0.00', 4, '', 1, 1602496227),
(22, 1, '10.50', '0.30', 1, '0.00', 4, '', 1, 1602496301),
(29, 1, '27.60', '17.40', 0, '4.60', 2, '', 1, 1603442442);

-- --------------------------------------------------------

--
-- Structure de la table `items_purchased`
--

DROP TABLE IF EXISTS `items_purchased`;
CREATE TABLE IF NOT EXISTS `items_purchased` (
  `purchased_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`purchased_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `items_purchased`
--

INSERT INTO `items_purchased` (`purchased_id`, `invoice_id`, `user_id`, `product_id`, `quantity`) VALUES
(1, 4, 1, 21, 2),
(2, 4, 1, 13, 2),
(3, 4, 1, 8, 3),
(4, 4, 1, 3, 2),
(5, 15, 2, 2, 3),
(6, 16, 2, 5, 3),
(7, 14, 1, 2, 7),
(8, 14, 1, 9, 1),
(9, 17, 1, 9, 1),
(10, 17, 1, 6, 1),
(11, 19, 1, 6, 1),
(12, 19, 1, 10, 3),
(13, 19, 1, 16, 1),
(14, 20, 1, 15, 2),
(15, 21, 1, 3, 1),
(16, 22, 1, 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `payment_provider_log`
--

DROP TABLE IF EXISTS `payment_provider_log`;
CREATE TABLE IF NOT EXISTS `payment_provider_log` (
  `provider_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_request_key` varbinary(32) NOT NULL,
  `provider_id` varchar(25) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `log_type` enum('payment','cancel','info','error') NOT NULL,
  `log_message` varchar(255) NOT NULL DEFAULT '',
  `log_details` mediumblob NOT NULL,
  `log_date` int(11) NOT NULL,
  PRIMARY KEY (`provider_log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `payment_provider_log`
--

INSERT INTO `payment_provider_log` (`provider_log_id`, `purchase_request_key`, `provider_id`, `transaction_id`, `log_type`, `log_message`, `log_details`, `log_date`) VALUES
(1, 0x4133735a476f767a437a754837565f66576e55676e4e38384a3449534233354f, 'PayPal', '5A239305NU940991L', 'payment', 'Payment received, upgraded/extended.', 0x7b226d635f67726f7373223a223135312e3030222c2270726f74656374696f6e5f656c69676962696c697479223a22456c696769626c65222c22616464726573735f737461747573223a22636f6e6669726d6564222c2270617965725f6964223a22514d4e4251414d3954524d5a32222c22616464726573735f737472656574223a2241762e206465206c612050656c6f7573652c203837363438363732204d61796574222c227061796d656e745f64617465223a2231343a32383a3338205365702032322c203230323020504454222c227061796d656e745f737461747573223a22436f6d706c65746564222c2263686172736574223a2277696e646f77732d31323532222c22616464726573735f7a6970223a223735303032222c2266697273745f6e616d65223a224372797374616c222c226d635f666565223a22352e3338222c22616464726573735f636f756e7472795f636f6465223a224652222c22616464726573735f6e616d65223a224372797374616c20436f6d6d756e697479277320546573742053746f7265222c226e6f746966795f76657273696f6e223a22332e39222c22637573746f6d223a224133735a476f767a437a754837565f66576e55676e4e38384a3449534233354f222c2270617965725f737461747573223a227665726966696564222c22627573696e657373223a2270617970616c2d6661636966696c3230406372797374616c636f6d6d756e6974792e696f222c22616464726573735f636f756e747279223a224672616e6365222c22616464726573735f63697479223a225061726973222c227175616e74697479223a2231222c227665726966795f7369676e223a22416f6342386f7a6e744954566174397a6c6e2e5a647849464a6c64574152376e6e524b574b547a425a4c645873356650623742774259766f222c2270617965725f656d61696c223a2274657374406372797374616c636f6d6d756e6974792e696f222c2274786e5f6964223a2235413233393330354e553934303939314c222c227061796d656e745f74797065223a22696e7374616e74222c2270617965725f627573696e6573735f6e616d65223a224372797374616c20436f6d6d756e697479277320546573742053746f7265222c226c6173745f6e616d65223a22436f6d6d756e697479222c22616464726573735f7374617465223a22416c73616365222c2272656365697665725f656d61696c223a2270617970616c2d6661636966696c3230406372797374616c636f6d6d756e6974792e696f222c227061796d656e745f666565223a22222c227368697070696e675f646973636f756e74223a22302e3030222c22696e737572616e63655f616d6f756e74223a22302e3030222c2272656365697665725f6964223a22435352335a3750363745464132222c2274786e5f74797065223a227765625f616363657074222c226974656d5f6e616d65223a22496e766f6963652069643a2023342028435255454c2d4d4f445a29222c22646973636f756e74223a22302e3030222c226d635f63757272656e6379223a22455552222c226974656d5f6e756d626572223a22222c227265736964656e63655f636f756e747279223a224652222c22746573745f69706e223a2231222c227368697070696e675f6d6574686f64223a2244656661756c74222c227472616e73616374696f6e5f7375626a656374223a22222c227061796d656e745f67726f7373223a22222c2269706e5f747261636b5f6964223a2264323838323130633537646533227d, 1600810149),
(2, 0x796e7867377468426972744372585a64746143716d4470615a43433635543275, 'PayPal', '3PR84608AU656615N', 'payment', 'Payment received, upgraded/extended.', 0x7b226d635f67726f7373223a223137312e3531222c2270726f74656374696f6e5f656c69676962696c697479223a22456c696769626c65222c22616464726573735f737461747573223a22636f6e6669726d6564222c2270617965725f6964223a22514d4e4251414d3954524d5a32222c22616464726573735f737472656574223a2241762e206465206c612050656c6f7573652c203837363438363732204d61796574222c227061796d656e745f64617465223a2230303a35363a3432205365702032332c203230323020504454222c227061796d656e745f737461747573223a22436f6d706c65746564222c2263686172736574223a2277696e646f77732d31323532222c22616464726573735f7a6970223a223735303032222c2266697273745f6e616d65223a224372797374616c222c226d635f666565223a22362e3038222c22616464726573735f636f756e7472795f636f6465223a224652222c22616464726573735f6e616d65223a224372797374616c20436f6d6d756e697479277320546573742053746f7265222c226e6f746966795f76657273696f6e223a22332e39222c22637573746f6d223a22796e7867377468426972744372585a64746143716d4470615a43433635543275222c2270617965725f737461747573223a227665726966696564222c22627573696e657373223a2270617970616c2d6661636966696c3230406372797374616c636f6d6d756e6974792e696f222c22616464726573735f636f756e747279223a224672616e6365222c22616464726573735f63697479223a225061726973222c227175616e74697479223a2231222c227665726966795f7369676e223a224172454e6e596a556131686c6c497674776b465347492e6b4c476762416564614f594773564b76704e6e70733447554f4e4663457147632e222c2270617965725f656d61696c223a2274657374406372797374616c636f6d6d756e6974792e696f222c2274786e5f6964223a22335052383436303841553635363631354e222c227061796d656e745f74797065223a22696e7374616e74222c2270617965725f627573696e6573735f6e616d65223a224372797374616c20436f6d6d756e697479277320546573742053746f7265222c226c6173745f6e616d65223a22436f6d6d756e697479222c22616464726573735f7374617465223a22416c73616365222c2272656365697665725f656d61696c223a2270617970616c2d6661636966696c3230406372797374616c636f6d6d756e6974792e696f222c227061796d656e745f666565223a22222c227368697070696e675f646973636f756e74223a22302e3030222c22696e737572616e63655f616d6f756e74223a22302e3030222c2272656365697665725f6964223a22435352335a3750363745464132222c2274786e5f74797065223a227765625f616363657074222c226974656d5f6e616d65223a22496e766f6963652069643a2023352028435255454c2d4d4f445a29222c22646973636f756e74223a22302e3030222c226d635f63757272656e6379223a22455552222c226974656d5f6e756d626572223a22222c227265736964656e63655f636f756e747279223a224652222c22746573745f69706e223a2231222c227368697070696e675f6d6574686f64223a2244656661756c74222c227472616e73616374696f6e5f7375626a656374223a22222c227061796d656e745f67726f7373223a22222c2269706e5f747261636b5f6964223a2239313264343164643034636137227d, 1600847826);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_date` int(11) NOT NULL,
  `icon_date` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `review_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`product_id`, `title`, `description`, `price`, `category_id`, `product_date`, `icon_date`, `stock`, `review_total`) VALUES
(1, 'testkjskzffsedvd f', '', '13.18', 10, 1599769113, 0, 10, '0.00'),
(2, 'test', '', '5.00', 5, 1599769242, 0, 3, '4.00'),
(3, 'test', '', '10.06', 10, 1599769295, 0, 10, '5.00'),
(4, 'test', '\r\n[CENTER]fhhghgfhgff[/CENTER]', '18.00', 5, 1599769601, 0, 18, '0.00'),
(5, 'sdfds', 'dfsds', '10.51', 10, 1599770331, 0, 0, '4.00'),
(6, 'dsqfsd', '[i][b]dsfsqdf[/b][/i]', '4.01', 5, 1599770635, 0, 4, '3.00'),
(7, 'dsqfsf', '[i]sdfsdfq[/i]', '10.50', 5, 1599770666, 0, 3, '0.00'),
(8, 'sfgdfdsgf', '[i]sfdgdfgsd[/i]', '10.00', 5, 1599770705, 0, 0, '4.00'),
(9, 'sqdfsdsd', '\r\n[CENTER][i]cddsvdsdsffdsqfd[/i][/CENTER]', '10.50', 5, 1599770942, 0, 1, '0.00'),
(10, 'On fait un test', '\r\n[CENTER][i]C\'est un test de la description ![/i][/CENTER]', '10.53', 5, 1599771152, 0, 0, '0.00'),
(11, 'un autre test !', 'Bon un autre test de la super description', '10.51', 5, 1599771277, 0, 3, '0.00'),
(12, 'ertyee', '[u][i]tyeryeyryy[/i][/u]', '10.50', 5, 1599776897, 0, 3, '3.86'),
(13, 'test', '[i][b]qdsfqfqdsfqdfq[/b][/i]', '10.50', 5, 1599777068, 0, 1, '5.00'),
(14, 'test', 'dvvdffdgdfsdgfg', '20.01', 5, 1600077677, 0, 2, '0.00'),
(15, 'test', 'sqffdsfsfd f dsfqsd ', '20.03', 5, 1600077698, 0, 0, '0.00'),
(16, 'gfdg gdsfs gdf', 'fdbqgfdsgsfdg', '20.02', 5, 1600077787, 0, 0, '0.00'),
(17, 'Test', 'dsfsdfsqdfdqfd', '20.01', 5, 1600078559, 0, 3, '0.00'),
(18, 'Last', 'kjlkkilkllk', '20.01', 5, 1600078649, 0, 12, '0.00'),
(19, 'sdqfsdfsdf', 'sdfsfqdsdqsf', '20.09', 5, 1600079560, 0, 5, '0.00'),
(20, 'sqfddsqffdsq', 'sqfddsfqsffd', '20.02', 5, 1600079679, 1600079679, 2, '0.00'),
(21, 'test', ',lkds,lkf,zmlkg lkfsq,g mùkf,g mùldf,g xf\r\n fd\r\ns\r\n', '10.00', 5, 1600105056, 1600105056, 0, '5.00'),
(22, 'test', 'Bonjour, comment ça va ?', '10.02', 5, 1602104524, 1602104524, 1, '0.00'),
(23, 'TEST', 'TEST Admin', '60.21', 5, 1602503702, 1602503702, 53, '0.00');

-- --------------------------------------------------------

--
-- Structure de la table `product_img`
--

DROP TABLE IF EXISTS `product_img`;
CREATE TABLE IF NOT EXISTS `product_img` (
  `product_img_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_img_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `product_img`
--

INSERT INTO `product_img` (`product_img_id`, `name`, `product_id`) VALUES
(8, 'avengers-infinity-war-2018-after-credits-hq.jpg', 13),
(9, 'Screenshot_2.png', 14),
(10, 'Avengers-Png-Logo-Free-Transparent-PNG-Logos.png', 14),
(11, 'default_2019-12-23_5d6b6fba-a119-418f-9ff0-746f1dc4db7a.jpeg', 15),
(12, 'avengers-infinity-war-2018-after-credits-hq.jpg', 15),
(13, '999187.jpg', 16),
(14, 'default_2019-12-23_5d6b6fba-a119-418f-9ff0-746f1dc4db7a.jpeg', 16),
(15, 'Screenshot_3.png', 17),
(17, 'default_2019-12-23_5d6b6fba-a119-418f-9ff0-746f1dc4db7a.jpeg', 18),
(18, 'Avengers-Png-Logo-Free-Transparent-PNG-Logos.png', 18),
(19, 'avengers-infinity-war-2018-after-credits-hq.jpg', 19),
(20, '104422365_164929645009021_3037811196673276801_n.jpg', 20),
(24, 'r01.jpg', 21),
(25, 'r02.jpg', 21),
(33, 'Screenshot_20191210-151124_Facebook.jpg', 23),
(36, 'Screenshot_20191210-151124_Facebook.jpg', 21);

-- --------------------------------------------------------

--
-- Structure de la table `purchase_request`
--

DROP TABLE IF EXISTS `purchase_request`;
CREATE TABLE IF NOT EXISTS `purchase_request` (
  `purchase_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_key` varbinary(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `provider_id` varbinary(25) NOT NULL,
  `purchasable_type_id` varchar(50) NOT NULL,
  `cost_amount` decimal(10,2) NOT NULL,
  `cost_currency` varchar(3) NOT NULL,
  `extra_data` blob NOT NULL,
  PRIMARY KEY (`purchase_request_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `purchase_request`
--

INSERT INTO `purchase_request` (`purchase_request_id`, `request_key`, `user_id`, `provider_id`, `purchasable_type_id`, `cost_amount`, `cost_currency`, `extra_data`) VALUES
(1, 0x582d592d705142537447324c33504634546e5748336965754839784b455f3150, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(2, 0x745874726c7754394a7a7a53736e794151704434767039645948514853693752, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(3, 0x5f6a397a70546366436d48734c4b6b6f57623139353170644c7633525375736e, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(4, 0x673745744e4e63304c4c56336f3638397458386932586d384377516658596c54, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(5, 0x475a77463233346f5461304935686662327a3566735238465357576e39504561, 1, 0x50617950616c, 'product', '161.80', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(6, 0x35734a6955553839564b75426b58307137767956644934336d5834665a375849, 1, 0x50617950616c, 'product', '161.80', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(7, 0x423561715837735550347956734b52542d30334e736759304c32375375456c30, 1, 0x50617950616c, 'product', '161.80', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(8, 0x562d7a43543435716a4c324844706e595f7348707831335a6a357739556a6142, 1, 0x50617950616c, 'product', '31.84', 'EUR', 0x7b22696e766f6963655f6964223a31337d),
(9, 0x4a31614c6f3736396963456a6e34336d485a414e744e696d3466774b62786c50, 2, 0x50617950616c, 'product', '21.33', 'EUR', 0x7b22696e766f6963655f6964223a31357d),
(10, 0x4c47324a4c3632444d712d55493569564364463341384462417a387570377747, 2, 0x50617950616c, 'product', '21.30', 'EUR', 0x7b22696e766f6963655f6964223a31367d),
(11, 0x51486e4770597133584635794e36566e76747052686978635657724751745852, 1, 0x50617950616c, 'product', '31.84', 'EUR', 0x7b22696e766f6963655f6964223a31337d),
(12, 0x74417468724e4e674168383550626434366e4e6666667176497239616b304f4e, 1, 0x50617950616c, 'product', '73.87', 'EUR', 0x7b22696e766f6963655f6964223a31347d),
(13, 0x3934623471315236337566555562624a67306236357567706761423753646565, 1, 0x50617950616c, 'product', '10.80', 'EUR', 0x7b22696e766f6963655f6964223a31377d),
(14, 0x716b6d49303073684e5150556b326d4b34466b6f3456426e654f45534e30442d, 1, 0x50617950616c, 'product', '10.80', 'EUR', 0x7b22696e766f6963655f6964223a31377d),
(15, 0x796a2d3132497579623463393939456267793746426c55475f676f365241586b, 1, 0x50617950616c, 'product', '51.80', 'EUR', 0x7b22696e766f6963655f6964223a31397d),
(16, 0x596c474b6348617952585f6e4e7332437569303861616b6a7a4a4c71444d4945, 1, 0x50617950616c, 'product', '29.80', 'EUR', 0x7b22696e766f6963655f6964223a32307d),
(17, 0x2d2d716c79356c6c44706c6449444d354b594d6f416664764b386c3846764563, 1, 0x50617950616c, 'product', '0.30', 'EUR', 0x7b22696e766f6963655f6964223a32317d),
(18, 0x613471764f41727447694a4c56486767415f4971716961417157764972576235, 1, 0x50617950616c, 'product', '0.30', 'EUR', 0x7b22696e766f6963655f6964223a32327d),
(19, 0x582d592d705142537447324c33504634546e5748336965754839784b455f3150, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(20, 0x745874726c7754394a7a7a53736e794151704434767039645948514853693752, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(21, 0x5f6a397a70546366436d48734c4b6b6f57623139353170644c7633525375736e, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(22, 0x73546d614a6141587a2d395964484b544761504e46545069477875383979764a, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(23, 0x4778776c4a656f506b47534b55414972626b5f385f5a50726e48624e677a3179, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(24, 0x566b39674f67415139444d656a2d4c6b63784274626d35415f45564875786753, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(25, 0x68474444364a5f416a67584f653666725a4a74364261337258455a634c307132, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(26, 0x583855716f5a4c3669666e766e65484c3077782d72543652795f6f566b4d6551, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a347d),
(27, 0x6a76466334626d4d69334c3057417033643561764a45514b3654747257446f6a, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x226a5c22696e766f6963655f69645c223a347d22),
(28, 0x4133735a476f767a437a754837565f66576e55676e4e38384a3449534233354f, 1, 0x50617950616c, 'product', '151.00', 'EUR', 0x7b22696e766f6963655f6964223a342c22646464646464223a224133735a476f767a437a754837565f66576e55676e4e38384a3449534233354f222c22696e766f6963655f7265636f7264223a747275657d),
(29, 0x796e7867377468426972744372585a64746143716d4470615a43433635543275, 1, 0x50617950616c, 'product', '171.51', 'EUR', 0x7b22696e766f6963655f6964223a352c22646464646464223a22796e7867377468426972744372585a64746143716d4470615a43433635543275222c22696e766f6963655f7265636f7264223a747275657d),
(30, 0x6a6249684d666a70305944533136704a704650726175772d6c44544851535a33, 1, 0x50617950616c, 'product', '-4.20', 'EUR', 0x7b22696e766f6963655f6964223a32397d);

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `review_date` int(11) NOT NULL,
  PRIMARY KEY (`review_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `username`, `rating`, `review`, `product_id`, `review_date`) VALUES
(1, 1, 'CRUEL-MODZ', 4, 'Bonjour, cette article est juste super, je retire une étoile car je les reçu en retard !', 12, 1601914545),
(4, 1, 'CRUEL-MODZ', 5, 'Bonjour, cette article est juste super, je retire une étoile car je les reçu en retard ! mais cette fois si c\'est un simple test', 12, 1601929439),
(5, 1, 'CRUEL-MODZ', 4, 'Bonjour, cette article est juste super, je retire une étoile car je les reçu en retard ! mais cette fois si c\'est un simple Pour conter le nombre d\'étoile', 12, 1601931528),
(6, 1, 'CRUEL-MODZ', 3, 'Bonjour, cette article est juste super, je retire une étoile car je les reçu en retard ! mais cette fois si c\'est un super test', 12, 1601931612),
(7, 1, 'CRUEL-MODZ', 4, 'Bonjour, cette article est juste super, je retire une étoile car je les reçu en retard ! mais cette fois si c\'est un super test, de mega test', 12, 1601933042),
(8, 1, 'CRUEL-MODZ', 5, 'Bonjour, cette article est juste super, je retire une étoile car je les reçu en retard ! bah c\'est juste un test', 12, 1601933217),
(9, 1, 'CRUEL-MODZ', 2, 'Bonjour, cette article est juste super, je retire une étoile car je les reçu en retard ! un autre simple test', 12, 1601933383),
(10, 1, 'CRUEL-MODZ', 5, 'On fait un test, je met 5 étoile et on va voir ce que cela donne ! juste un simple test, mais malheureusement il faut plus de 100 caractère', 3, 1601939901),
(11, 1, 'CRUEL-MODZ', 5, 'On fait un autre test, je met 5 étoile et on va voir ce que cela donne ! juste un autre simple test, mais malheureusement il faut plus de 100 caractère', 3, 1601939923),
(12, 1, 'CRUEL-MODZ', 5, 'On fait un test, je met 5 étoile et on va voir ce que cela donne ! juste un simple test, mais malheureusement il faut plus de 100 caractère', 3, 1602061151),
(13, 1, 'CRUEL-MODZ', 5, 'Super test ! en plus de ça je les reçu pile attend ! merci pour ce produit vraiment excellent ! continuez comme ça vraiment !', 13, 1602103438),
(14, 1, 'CRUEL-MODZ', 4, 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', 8, 1602103777),
(15, 1, 'CRUEL-MODZ', 5, 'Excellent écran, vraiment très bon écran ! bon rapport qualité/prix ! je le recommande fortement !', 21, 1602104112),
(16, 2, 'Admin', 4, 'kdsjxhgo jyds fbgjhsbjhg shojg  ojhdsbkjh fdsh kjhfqh sg fqhojgsfjhdsfqhghjdsbfhjsdfh sdgfhljsojhdsgqjhsjhbfsdjhgfshodjj', 2, 1602104312),
(17, 2, 'Admin', 4, 'kdsjxhgo jyds fbgjhsbjhg shojg ojhdsbkjh fdsh kjhfqh sg fqhojgsfjhdsfqhghjdsbfhjsdfh sdgfhljsojhdsgqjhsjhbfsdjhgfshodjj', 2, 1602104364),
(18, 2, 'Admin', 4, 'qsdqsqsdqsQSDq, ; nflkjdsf hkgfjlds mlkjsd lgqs n xklgj fxkjgh xckjgh xpkjhg fpkxjhg dpkfjuhg kfd kupghdfpkjd hkjpfd pkjh bfdpkjg', 2, 1602104377),
(19, 2, 'Admin', 4, 'fds,jvljkdf lkjg jdkf ngkjfdx ngkjfkgfdngkldnglkhdlfkgdhgjdfhghlkfdhkglhlfdjkhjkghfdlkjhgslkjfdhglkjlfdlkjshlkjgfdhglkfdjhgfdhlgfdhlkjhglhkjfhkjlfdhglkhfdhgkdfhkfd', 2, 1602104438),
(20, 2, 'Admin', 4, 'lhkebqfdclbhkdslk bvxbhlkg hlkjgdnhpkjshlkjgdf hkblgfjglk fdhj fdlk dlkfsjgfmhk jfgdsmhk fjgd mhljggmhjfdmhlk jg dsmhl jg dmhkj dfs', 5, 1602161538),
(21, 1, 'CRUEL-MODZ', 3, 'on fait un super test ! Cet article me convient mais moi je mets une note moyenne, j\'aurais pu mettre plus mais mon père n\'a pas voulu.', 6, 1602442185);

-- --------------------------------------------------------

--
-- Structure de la table `technical_data_sheet`
--

DROP TABLE IF EXISTS `technical_data_sheet`;
CREATE TABLE IF NOT EXISTS `technical_data_sheet` (
  `technical_data_sheet_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`technical_data_sheet_id`),
  KEY `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `technical_data_sheet`
--

INSERT INTO `technical_data_sheet` (`technical_data_sheet_id`, `category_id`, `title`) VALUES
(1, 9, 'test'),
(2, 5, 'Test'),
(3, 9, 'test2'),
(4, 5, 'Test');

-- --------------------------------------------------------

--
-- Structure de la table `technical_data_sheet_value`
--

DROP TABLE IF EXISTS `technical_data_sheet_value`;
CREATE TABLE IF NOT EXISTS `technical_data_sheet_value` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `technical_data_sheet_id` int(11) NOT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`value_id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `technical_data_sheet_value`
--

INSERT INTO `technical_data_sheet_value` (`value_id`, `product_id`, `technical_data_sheet_id`, `value`) VALUES
(69, 2, 2, ''),
(74, 4, 4, ''),
(73, 4, 2, ''),
(9, 6, 2, '[i]qfdds[/i]'),
(10, 6, 4, '[i]dsfqdsf[/i]'),
(11, 7, 2, '[i]dsqfsd[/i]'),
(12, 7, 4, '[i]sdqfds[/i]'),
(13, 8, 2, '[i]fdsgffsgd[/i]'),
(14, 8, 4, '[i]gfdsgfssgfdgfdsgfds[/i]'),
(15, 9, 2, '[i][b]dfsfdsqfdsq fdsqfd f fdf[/b][/i]'),
(16, 9, 4, '[i][b]qdsffq dsf fq ffqs f fds fdsq[/b][/i]'),
(78, 10, 4, ''),
(77, 10, 2, ''),
(19, 11, 2, '[i][b]Ce ceci est un test de test de test on va voir[/b][/i]'),
(20, 11, 4, '[i][b]Bah on va voir quoi ? on va voir si cela marche bien sur [/b][/i]'),
(21, 12, 2, 'erzttyeyry'),
(22, 12, 4, '[b][i]lkfvlk,fslkgdfgsd[/i][/b]'),
(23, 13, 2, '[i][b]dqfsfqfdsqffqdsdfffq[/b][/i]'),
(24, 13, 4, '[i][b]qffdsqffdsqsffdsfddsffddq[/b][/i]'),
(25, 14, 2, 'k,lklklklklk'),
(26, 14, 4, 'lkmlklmml'),
(27, 15, 2, 'qds fs fdsq fsd fs'),
(28, 15, 4, 'dsqfsd fdsf d '),
(29, 16, 2, 'gnnhghjhgjdjf'),
(30, 16, 4, 'gjkfhgjdgh,h,g'),
(31, 17, 2, 'qdsfsddss'),
(32, 17, 4, ''),
(33, 18, 2, 'kllkmkl'),
(34, 18, 4, 'lklklk'),
(35, 19, 2, 'sdfqsdfsd'),
(36, 19, 4, ''),
(37, 20, 2, 'fgdgs'),
(38, 20, 4, 'fgsdf'),
(39, 21, 2, 'qùlkfg [i][b]jlkfsqjlkgjnmlkdg nmkfdmnd[/b][/i]\r\n[i][b]\r\n[/b][/i]\r\nfd\r\ngsdf\r\ngdf'),
(40, 21, 4, 'jkjkjkjkkjk\r\n'),
(41, 22, 2, 'Test'),
(42, 22, 4, 'test'),
(43, 23, 2, 'TEST Admin tech'),
(44, 23, 4, 'TEST Admin tech 2'),
(70, 2, 4, '');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `is_admin`) VALUES
(1, 'CRUEL-MODZ', '$2y$15$pWdmd/oahoN.soTJR.m5keSPgUrnrVEdZDCWbFGdpJyPUWWte1ZSu', 'bastien.albert8@gmail.com', 1),
(2, 'Admin', '$2y$15$k9pF90jYAvdDRbjviNiPwu7MOXWXzL9MHSIWRnjYdyLlr9xAtwE2W', 'albert.bastien3@gmail.com', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `technical_data_sheet`
--
ALTER TABLE `technical_data_sheet`
  ADD CONSTRAINT `categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
