-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 27. kvě 2015, 01:50
-- Verze serveru: 5.6.21
-- Verze PHP: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `zf2`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `album`
--

CREATE TABLE IF NOT EXISTS `album` (
`album_id` int(11) NOT NULL,
  `album_artist` varchar(100) NOT NULL,
  `album_title` varchar(100) NOT NULL,
  `album_img` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `album`
--

INSERT INTO `album` (`album_id`, `album_artist`, `album_title`, `album_img`) VALUES
(6, 'lulabiopi', 'ioioaqq', 'd1575c5577f71bcd0c40051703bd0dc9.png'),
(9, 'Bruny Mars', 'Unorthodoxg Jukebox', ''),
(10, 'Emeli Sandé', 'Our Version of Events (Special Edition)', ''),
(12, 'Justin Timberlake', 'The 20/20 Experience (Deluxe Version)', ''),
(13, 'Bastille', 'Bad Blood (The Extended Cut)', ''),
(14, 'P!nk', 'The Truth About Love', ''),
(16, 'Jake Bugg', 'Jake Bugg', ''),
(17, 'Various Artists', 'The Trevor Nelson Collection', ''),
(18, 'David Bowie', 'The Next Day', ''),
(19, 'Mumford & Sons', 'Babel', ''),
(20, 'The Lumineers', 'The Lumineers', ''),
(21, 'Various Artists', 'Get Ur Freak On - R&B Anthems', ''),
(22, 'The 1975', 'Music For Cars EP', ''),
(23, 'Various Artists', 'Saturday Night Club Classics - Ministry of Sound', ''),
(25, 'Various Artists', 'Mixmag - The Greatest Dance Tracks of All Time', ''),
(26, 'Ben Howard', 'Every Kingdom', ''),
(27, 'Stereophonics', 'Graffiti On the Train', ''),
(28, 'The Script', '#3', ''),
(29, 'Stornoway', 'Tales from Terra Firma', ''),
(30, 'David Bowie', 'Hunky Dory (Remastered)', ''),
(31, 'Worship Central', 'Let It Be Known (Live)', ''),
(32, 'Ellie Goulding', 'Halcyon', ''),
(33, 'Various Artists', 'Dermot O''Leary Presents the Saturday Sessions 2013', ''),
(34, 'Stereophonics', 'Graffiti On the Train (Deluxe Version)', ''),
(35, 'Dido', 'Girl Who Got Away (Deluxe)', ''),
(37, 'Bruno Mars', 'Doo-Wops & Hooligans', ''),
(38, 'Calvin Harris', '18 Months', ''),
(39, 'Olly Murs', 'Right Place Right Time', ''),
(40, 'Alt-J (?)', 'An Awesome Wave', ''),
(41, 'One Direction', 'Take Me Home', ''),
(42, 'Various Artists', 'Pop Stars', ''),
(43, 'Various Artists', 'Now That''s What I Call Music! 83', ''),
(44, 'John Grant', 'Pale Green Ghosts', ''),
(45, 'Paloma Faith', 'Fall to Grace', ''),
(46, 'Laura Mvula', 'Sing To the Moon (Deluxe)', ''),
(47, 'Duke Dumont', 'Need U (100%) [feat. A*M*E] - EP', ''),
(48, 'Watsky', 'Cardboard Castles', ''),
(49, 'Blondie', 'Blondie: Greatest Hits', ''),
(50, 'Foals', 'Holy Fire', ''),
(51, 'Maroon 5', 'Overexposed', ''),
(52, 'Bastille', 'Pompeii (Remixes) - EP', ''),
(53, 'Imagine Dragons', 'Hear Me - EP', ''),
(54, 'Various Artists', '100 Hits: 80s Classics', ''),
(55, 'Various Artists', 'Les Misérables (Highlights From the Motion Picture Soundtrack)', ''),
(56, 'Mumford & Sons', 'Sigh No More', ''),
(57, 'Frank Ocean', 'Channel ORANGE', ''),
(59, 'Various Artists', 'BRIT Awards 2013', ''),
(60, 'Taylor Swift', 'Red', ''),
(61, 'Fleetwood Mac', 'Fleetwood Mac: Greatest Hits', ''),
(62, 'David Guetta', 'Nothing But the Beat Ultimate', ''),
(63, 'Various Artists', 'Clubbers Guide 2013 (Mixed By Danny Howard) - Ministry of Sound', ''),
(64, 'David Bowie', 'Best of Bowie', ''),
(65, 'Laura Mvula', 'Sing To the Moon', ''),
(66, 'ADELE', '21', ''),
(67, 'Of Monsters and Men', 'My Head Is an Animal', ''),
(68, 'Rihanna', 'Unapologetic', ''),
(69, 'Various Artists', 'BBC Radio 1''s Live Lounge - 2012', ''),
(70, 'Avicii & Nicky Romero', 'I Could Be the One (Avicii vs. Nicky Romero)', ''),
(71, 'The Streets', 'A Grand Don''t Come for Free', ''),
(72, 'Tim McGraw', 'Two Lanes of Freedom', ''),
(73, 'Foo Fighters', 'Foo Fighters: Greatest Hits', ''),
(74, 'Various Artists', 'Now That''s What I Call Running!', ''),
(75, 'Swedish House Mafia', 'Until Now', ''),
(76, 'The xx', 'Coexist', ''),
(77, 'Five', 'Five: Greatest Hits', ''),
(78, 'Jimi Hendrix', 'People, Hell & Angels', ''),
(79, 'Biffy Clyro', 'Opposites (Deluxe)', ''),
(80, 'The Smiths', 'The Sound of the Smiths', ''),
(81, 'The Saturdays', 'What About Us - EP', ''),
(82, 'Fleetwood Mac', 'Rumours', ''),
(83, 'Various Artists', 'The Big Reunion', ''),
(84, 'Various Artists', 'Anthems 90s - Ministry of Sound', ''),
(85, 'The Vaccines', 'Come of Age', ''),
(86, 'Nicole Scherzinger', 'Boomerang (Remixes) - EP', ''),
(87, 'Bob Marley', 'Legend (Bonus Track Version)', ''),
(88, 'Josh Groban', 'All That Echoes', ''),
(89, 'Blue', 'Best of Blue', ''),
(90, 'Ed Sheeran', '+', ''),
(91, 'Olly Murs', 'In Case You Didn''t Know (Deluxe Edition)', ''),
(92, 'Macklemore & Ryan Lewis', 'The Heist (Deluxe Edition)', ''),
(93, 'Various Artists', 'Defected Presents Most Rated Miami 2013', ''),
(94, 'Gorgon City', 'Real EP', ''),
(95, 'Mumford & Sons', 'Babel (Deluxe Version)', ''),
(96, 'Various Artists', 'The Music of Nashville: Season 1, Vol. 1 (Original Soundtrack)', ''),
(97, 'Various Artists', 'The Twilight Saga: Breaking Dawn, Pt. 2 (Original Motion Picture Soundtrack)', ''),
(98, 'Various Artists', 'Mum - The Ultimate Mothers Day Collection', ''),
(99, 'One Direction', 'Up All Night', ''),
(100, 'Bon Jovi', 'Bon Jovi Greatest Hits', ''),
(101, 'Agnetha Fältskog', 'A', ''),
(102, 'Fun.', 'Some Nights', ''),
(103, 'Justin Bieber', 'Believe Acoustic', ''),
(104, 'Atoms for Peace', 'Amok', ''),
(105, 'Justin Timberlake', 'Justified', ''),
(106, 'Passenger', 'All the Little Lights', ''),
(107, 'Kodaline', 'The High Hopes EP', ''),
(108, 'Lana Del Rey', 'Born to Die', ''),
(109, 'JAY Z & Kanye West', 'Watch the Throne (Deluxe Version)', ''),
(110, 'Biffy Clyro', 'Opposites', ''),
(111, 'Various Artists', 'Return of the 90s', ''),
(112, 'Gabrielle Aplin', 'Please Don''t Say You Love Me - EP', ''),
(113, 'Various Artists', '100 Hits - Driving Rock', ''),
(114, 'Jimi Hendrix', 'Experience Hendrix - The Best of Jimi Hendrix', ''),
(115, 'Various Artists', 'The Workout Mix 2013', ''),
(116, 'The 1975', 'Sex', ''),
(117, 'Chase & Status', 'No More Idols', ''),
(118, 'Rihanna', 'Unapologetic (Deluxe Version)', ''),
(119, 'The Killers', 'Battle Born', ''),
(120, 'Olly Murs', 'Right Place Right Time (Deluxe Edition)', ''),
(121, 'A$AP Rocky', 'LONG.LIVE.A$AP (Deluxe Version)', ''),
(122, 'Various Artists', 'Cooking Songs', ''),
(123, 'Haim', 'Forever - EP', ''),
(124, 'Lianne La Havas', 'Is Your Love Big Enough?', ''),
(125, 'Michael Bublé', 'To Be Loved', ''),
(126, 'Daughter', 'If You Leave', ''),
(127, 'The xx', 'xx', ''),
(128, 'Eminem', 'Curtain Call', ''),
(129, 'Kendrick Lamar', 'good kid, m.A.A.d city (Deluxe)', ''),
(130, 'Disclosure', 'The Face - EP', ''),
(131, 'Palma Violets', '180', ''),
(132, 'Cody Simpson', 'Paradise', ''),
(133, 'Ed Sheeran', '+ (Deluxe Version)', ''),
(134, 'Michael Bublé', 'Crazy Love (Hollywood Edition)', ''),
(135, 'Bon Jovi', 'Bon Jovi Greatest Hits - The Ultimate Collection', ''),
(136, 'Rita Ora', 'Ora', ''),
(137, 'g33k', 'Spabby', ''),
(138, 'Various Artists', 'Annie Mac Presents 2012', ''),
(139, 'David Bowie', 'The Platinum Collection', ''),
(140, 'Bridgit Mendler', 'Ready or Not (Remixes) - EP', ''),
(141, 'Dido', 'Girl Who Got Away', ''),
(142, 'Various Artists', 'Now That''s What I Call Disney', ''),
(143, 'The 1975', 'Facedown - EP', ''),
(144, 'Kodaline', 'The Kodaline - EP', ''),
(145, 'Various Artists', '100 Hits: Super 70s', ''),
(146, 'Fred V & Grafix', 'Goggles - EP', ''),
(147, 'Biffy Clyro', 'Only Revolutions (Deluxe Version)', ''),
(148, 'Train', 'California 37', ''),
(149, 'Ben Howard', 'Every Kingdom (Deluxe Edition)', ''),
(150, 'Various Artists', 'Motown Anthems', ''),
(151, 'Courteeners', 'ANNA', ''),
(152, 'Johnny Marr', 'The Messenger', ''),
(153, 'Rodriguez', 'Searching for Sugar Man', ''),
(154, 'Jessie Ware', 'Devotion', ''),
(155, 'Bruno Mars', 'Unorthodox Jukebox', ''),
(156, 'Various Artists', 'Call the Midwife (Music From the TV Series)', ''),
(181, 'cathrine zeta jones', 'Zorro', '4fd4a40c973b771249f26a9494167891.jpg'),
(182, 'ray', 'ray', '8e86dc521c4922cabb0e9619496588c8.jpg'),
(183, 'Bastilla', '1789', 'e5f5dc91b1ce7f147e1830e3f7b7776c.jpg'),
(184, 'panda kungfu', 'Panda', '937ba41ade70e30355db94387da59fee.jpg'),
(185, 'testik', 'test', 'c20d20c479020019d1105d2c8196e484.png'),
(189, 'Hurts', 'Exile (Deluxe)', '0d26a69902ae30d28f5bdbccecce8015.jpg'),
(190, 'Hurt', 'Exile', '1a2aea3f29b87d0bfd5fb6aabbff1ab6.JPG'),
(191, 'oko', 'kokko', 'fb660a7d558377b44e3eb8b2927a76dc.jpg');

-- --------------------------------------------------------

--
-- Struktura tabulky `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
`like_id` int(11) unsigned NOT NULL,
  `like_post_id` int(11) unsigned NOT NULL,
  `like_user_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=262 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `likes`
--

INSERT INTO `likes` (`like_id`, `like_post_id`, `like_user_id`) VALUES
(2, 134, 3),
(3, 134, 22),
(4, 134, 12),
(8, 143, 3),
(9, 134, 9),
(10, 135, 9),
(13, 135, 22),
(14, 136, 12),
(42, 138, 13),
(43, 138, 13),
(44, 139, 13),
(45, 139, 13),
(46, 139, 13),
(47, 140, 13),
(49, 141, 13),
(50, 125, 13),
(51, 124, 13),
(52, 133, 13),
(56, 145, 13),
(57, 149, 13),
(107, 95, 4),
(138, 146, 1),
(141, 125, 4),
(144, 130, 4),
(145, 142, 4),
(177, 151, 4),
(181, 136, 4),
(191, 123, 4),
(195, 138, 4),
(198, 145, 4),
(199, 153, 4),
(208, 144, 4),
(214, 134, 4),
(218, 150, 4),
(219, 154, 4),
(220, 237, 4),
(221, 237, 1),
(227, 272, 1),
(228, 258, 1),
(229, 270, 1),
(231, 264, 1),
(232, 265, 1),
(233, 275, 1),
(241, 307, 13),
(243, 347, 13),
(245, 274, 1),
(246, 369, 1),
(247, 369, 1),
(255, 383, 1),
(257, 347, 1),
(260, 393, 1),
(261, 368, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
`post_id` int(11) unsigned NOT NULL,
  `post_parent_id` int(11) unsigned DEFAULT NULL,
  `post_replyto_id` int(11) unsigned DEFAULT NULL,
  `post_user_id` int(11) unsigned NOT NULL,
  `post_message` text NOT NULL,
  `post_type` varchar(10) NOT NULL,
  `post_time` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=418 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `posts`
--

INSERT INTO `posts` (`post_id`, `post_parent_id`, `post_replyto_id`, `post_user_id`, `post_message`, `post_type`, `post_time`) VALUES
(1, NULL, 0, 1, 'To je prvni post v moji male tatatka aplikaci.\r\n\r\nA to je super zprava pro super synka.', 'n', 1429373556),
(2, NULL, 0, 9, 'To je druhý post v moji male tatatka aplikaci.\r\n\r\nA to je super zprava pro super synka.', 'n', 1429373571),
(3, NULL, 0, 22, 'tttt\r\n\r\n,mllkl', 'n', 1429373586),
(4, NULL, 0, 13, 'kokok', 'n', 1429373605),
(5, NULL, 0, 10, '', 'n', 1429373633),
(6, NULL, 0, 13, 'test', 'n', 1429373648),
(7, NULL, 0, 4, 'to je test\r\n\r\nto je testik', 'n', 1429376901),
(16, NULL, 0, 1, 'kokot', 'n', 1429482658),
(17, NULL, 0, 1, 'bbb', 'n', 1429482685),
(18, NULL, 0, 1, 'cc\\', 'n', 1429482702),
(19, NULL, 0, 1, 'kokor', 'n', 1429482778),
(20, NULL, 0, 1, 'x', 'n', 1429482802),
(21, NULL, 0, 1, 'aa', 'n', 1429483019),
(22, NULL, 0, 1, 'kokot', 'n', 1429483264),
(23, NULL, 0, 1, 'kokot', 'n', 1429483276),
(24, NULL, 0, 1, 'aa', 'n', 1429483281),
(25, NULL, 0, 1, 'tt', 'n', 1429484021),
(26, NULL, 0, 1, 'kok\n', 'n', 1429484113),
(27, NULL, 0, 1, 'kk', 'n', 1429484705),
(28, NULL, 0, 1, 'koko', 'n', 1429485123),
(29, NULL, 0, 1, 'test', 'n', 1429511124),
(30, NULL, 0, 1, 'To je test', 'n', 1429511198),
(31, NULL, 0, 1, 'utre', 'n', 1429512087),
(32, NULL, 0, 1, 'red', 'n', 1429512685),
(33, NULL, 0, 1, 'topop', 'n', 1429512785),
(34, NULL, 0, 1, 'To je testik 15', 'n', 1429514958),
(35, NULL, 0, 1, 'testik', 'n', 1429515505),
(36, NULL, 0, 1, 'koko', 'n', 1429516530),
(37, NULL, 0, 1, 'test', 'n', 1429517118),
(38, NULL, 0, 1, 'tre', 'n', 1429518210),
(39, NULL, 0, 1, 'kookot', 'n', 1429518715),
(40, NULL, 0, 1, 'tt', 'n', 1429518973),
(41, NULL, 0, 1, 'jojojo', 'n', 1429524999),
(42, NULL, 0, 1, 'trteree', 'n', 1429530733),
(43, NULL, 0, 1, 'hhhhh', 'n', 1429531040),
(53, NULL, 0, 1, 'to je test', 'n', 1429601892),
(54, NULL, 0, 1, 'to je test', 'n', 1429602028),
(55, NULL, 0, 1, 'koko', 'n', 1429602134),
(56, NULL, 0, 1, 'kokot', 'n', 1429602557),
(57, NULL, 0, 1, 'kokot', 'n', 1429602721),
(58, NULL, 0, 1, 'bb\n', 'n', 1429602747),
(60, NULL, 0, 1, 'kkjk', 'n', 1429603891),
(61, NULL, 0, 1, 'okoko', 'n', 1429604878),
(62, NULL, 0, 1, 'aa', 'n', 1429604931),
(63, NULL, 0, 1, 'aa', 'n', 1429604963),
(64, NULL, 0, 1, 'aa\n', 'n', 1429605074),
(65, NULL, 0, 1, 'aa\n', 'n', 1429605090),
(66, NULL, 0, 1, 'aa\n', 'n', 1429605312),
(67, NULL, 0, 1, 'aa', 'n', 1429605920),
(68, NULL, 0, 1, 'aa', 'n', 1429606076),
(69, NULL, 0, 1, 'aa', 'n', 1429606546),
(70, NULL, 0, 1, 'aa', 'n', 1429606553),
(95, NULL, 0, 1, 'tt', 'n', 1429775337),
(106, 2, 2, 1, 'fff', 'r', 1429782709),
(107, 2, 2, 1, 'hh', 'r', 1429782766),
(110, 2, 106, 1, 'ff', 'r', 1429783038),
(111, 2, 110, 1, 'dd', 'r', 1429783554),
(112, 3, 3, 1, 'df', 'r', 1429787349),
(113, 3, 3, 1, 'ff', 'r', 1429787358),
(114, 3, 3, 1, 'dd', 'r', 1429787381),
(115, 7, 7, 9, 'dd', 'r', 1429788299),
(116, 7, 115, 9, 'dd', 'r', 1429788316),
(117, 7, 116, 1, 'ana hone', 'r', 1429788829),
(118, 2, 2, 1, 'kjjkjk', 'r', 1429789048),
(119, 7, 116, 1, 'll\n', 'r', 1429789075),
(120, 3, 114, 1, 'dd', 'r', 1429790196),
(121, 7, 7, 9, 'jkjk', 'r', 1429790263),
(122, NULL, NULL, 9, 'we are here', 'n', 1429790451),
(123, NULL, NULL, 1, 'We are here', 'n', 1429790532),
(124, NULL, NULL, 9, 'we are here', 'n', 1429790670),
(125, NULL, NULL, 9, 'dd', 'n', 1429791073),
(126, 2, 106, 12, '4cd6df30', 'r', 1429791362),
(127, 2, 2, 12, 'koko\n', 'r', 1429791375),
(128, 4, 4, 12, 'dd', 'r', 1429791401),
(129, 68, 68, 12, 'ioio', 'r', 1429794956),
(130, 125, 125, 9, 'ff', 'r', 1429798325),
(131, 3, 3, 1, 'I am writing a reply', 'r', 1429799059),
(132, 3, 113, 1, 'bubu', 'r', 1429799078),
(133, 70, 70, 1, 'nmnm', 'r', 1429799479),
(134, NULL, NULL, 1, 'Kolo', 'n', 1429822646),
(135, 134, 134, 22, 'Hello, mr. Thomas!', 'r', 1429822783),
(136, 134, 134, 1, 'test', 'r', 1429856375),
(137, 134, 136, 1, 'test', 'r', 1429856508),
(138, 134, 134, 1, 'Halao', 'r', 1429856642),
(139, 134, 136, 22, 'This is an answer', 'r', 1429857699),
(140, 134, 137, 22, 'ff', 'r', 1429861127),
(141, 134, 135, 22, 'tesrus', 'r', 1429880741),
(142, 134, 135, 22, 'hjhjhuj', 'r', 1429880782),
(143, 134, 136, 22, 'jiji', 'r', 1429880823),
(144, NULL, NULL, 22, 'Main post', 'n', 1429880843),
(145, 134, 134, 1, 'huhiu', 'r', 1430125434),
(146, 124, 124, 13, 'test', 'r', 1430162166),
(147, 69, 69, 13, 'tesr', 'r', 1430162744),
(148, 95, 95, 13, 'vv', 'r', 1430162935),
(149, 95, 148, 13, 'hj', 'r', 1430163084),
(150, NULL, NULL, 4, 'koko\n', 'n', 1430211070),
(151, NULL, NULL, 4, 'tr', 'n', 1430211681),
(152, NULL, NULL, 4, 'jjkjk', 'n', 1430294115),
(153, 134, 135, 4, 'bylo nebylo', 'r', 1430314185),
(154, 134, 153, 4, 'tt', 'r', 1430314643),
(155, 134, 134, 4, 'ii9i9', 'r', 1430315281),
(156, 134, 154, 4, 'okoko', 'r', 1430315301),
(157, 134, 154, 4, 'koko', 'r', 1430315332),
(158, 134, 155, 4, 'koko', 'r', 1430315510),
(159, 134, 139, 4, 'i9i9u', 'r', 1430315687),
(160, NULL, NULL, 4, 'komoko', 'n', 1430315764),
(161, NULL, NULL, 4, 'kojjijoi', 'n', 1430318574),
(162, NULL, NULL, 4, 'kokoko', 'n', 1430318582),
(163, NULL, NULL, 4, 'To je test', 'n', 1430569359),
(164, NULL, NULL, 4, 'hh', 'n', 1430733050),
(236, NULL, NULL, 4, 'dd', 'n', 1430750223),
(237, NULL, NULL, 4, 'dds', 'n', 1430750297),
(238, NULL, NULL, 1, 'dd', 'n', 1430809336),
(239, NULL, NULL, 1, 'ggg', 'n', 1430811342),
(240, NULL, NULL, 1, 'dd', 'n', 1430811401),
(241, NULL, NULL, 1, 'ff', 'n', 1430811630),
(242, NULL, NULL, 1, 'ghiuhu', 'n', 1430811692),
(243, NULL, NULL, 1, 'kjjhjhj', 'n', 1430811727),
(244, NULL, NULL, 1, 'dd', 'n', 1430812070),
(245, NULL, NULL, 1, 'ff', 'n', 1430812239),
(246, NULL, NULL, 1, 'gg', 'n', 1430812312),
(247, NULL, NULL, 1, 'ff', 'n', 1430812367),
(248, NULL, NULL, 1, 'jjiji', 'n', 1430824918),
(249, NULL, NULL, 1, 'fddd', 'n', 1430832048),
(250, NULL, NULL, 1, 'klkkl', 'n', 1430832319),
(251, NULL, NULL, 1, 'klkkl', 'n', 1430832370),
(252, NULL, NULL, 1, 'kokmhb', 'n', 1430832420),
(253, NULL, NULL, 1, 'jkjkj', 'n', 1430832465),
(254, NULL, NULL, 1, 'zz', 'n', 1430832999),
(255, NULL, NULL, 1, 'kjkjkj', 'n', 1430833209),
(256, NULL, NULL, 1, 'jhjhj', 'n', 1430834477),
(257, NULL, NULL, 1, 'ss', 'n', 1430835268),
(258, NULL, NULL, 1, 'hhh', 'n', 1430850603),
(259, NULL, NULL, 1, 'ff', 'n', 1430850637),
(260, NULL, NULL, 1, 'ff', 'n', 1430850659),
(261, NULL, NULL, 1, 'to je test', 'n', 1430852693),
(262, NULL, NULL, 1, 'kokojytt', 'n', 1430855421),
(263, NULL, NULL, 1, 'lplpl', 'n', 1430857550),
(264, NULL, NULL, 1, 'lplpljjkjk', 'n', 1430857578),
(265, 264, 264, 1, 'gff', 'r', 1430858035),
(266, 263, 263, 1, 'hh', 'r', 1430858237),
(267, 262, 262, 1, 'hh', 'r', 1430858376),
(268, 261, 261, 1, 'jjkj', 'r', 1430858784),
(269, 260, 260, 1, 'koko', 'r', 1430859283),
(270, 259, 259, 1, 'jj', 'r', 1430859323),
(271, 258, 258, 1, 'kkjk', 'r', 1430860575),
(272, 258, 258, 1, 'kuu', 'r', 1430860677),
(273, 251, 251, 1, 'jkjk', 'r', 1430862529),
(274, NULL, NULL, 1, 'ff', 'n', 1430898078),
(275, NULL, NULL, 1, 'jkjkj', 'n', 1430901734),
(276, 259, 270, 1, 'ffg', 'r', 1430902672),
(277, 264, 265, 1, 'jhjkhkjhk', 'r', 1430986374),
(278, NULL, NULL, 1, 'jhjhj', 'n', 1430990358),
(279, NULL, NULL, 1, 'kjkjkjf', 'n', 1430990456),
(280, NULL, NULL, 1, 'ff', 'n', 1430990559),
(281, NULL, NULL, 1, 'ff', 'n', 1430990571),
(282, NULL, NULL, 1, 'fd', 'n', 1430990661),
(283, NULL, NULL, 1, 'fre', 'n', 1430990923),
(284, NULL, NULL, 1, 'ff', 'n', 1430995930),
(285, NULL, NULL, 1, 'fgtrr', 'n', 1430996530),
(286, NULL, NULL, 1, 'hjhjh', 'n', 1430996614),
(287, NULL, NULL, 1, 'fr', 'n', 1430996861),
(288, NULL, NULL, 1, 'okokj', 'n', 1430997732),
(289, NULL, NULL, 1, 'fre', 'n', 1430997954),
(290, NULL, NULL, 1, 'ff', 'n', 1430998118),
(291, NULL, NULL, 1, 'jjk', 'n', 1430998208),
(292, NULL, NULL, 1, 'kjkj', 'n', 1430998272),
(293, NULL, NULL, 1, 'jhjhjk', 'n', 1430998518),
(294, NULL, NULL, 1, 'hjh', 'n', 1430998885),
(295, NULL, NULL, 1, 'dd', 'n', 1430999054),
(296, NULL, NULL, 1, 'ddd', 'n', 1430999393),
(297, NULL, NULL, 1, 'gg', 'n', 1430999442),
(298, NULL, NULL, 1, 'ff', 'n', 1430999615),
(299, NULL, NULL, 1, 'fre', 'n', 1431000027),
(300, NULL, NULL, 1, 'jnkjhj', 'n', 1431000101),
(301, NULL, NULL, 1, 'hahah', 'n', 1431004210),
(302, 301, 301, 1, 'jjkhghghj', 'r', 1431004433),
(303, 300, 300, 13, 'fff', 'r', 1431004538),
(304, NULL, NULL, 13, 'hgfggf', 'n', 1431004968),
(305, NULL, NULL, 13, 'jkjkj', 'n', 1431005282),
(306, NULL, NULL, 13, 'jhjkhk', 'n', 1431005487),
(307, NULL, NULL, 13, 'jhjkhk', 'n', 1431005524),
(308, NULL, NULL, 13, 'njhhjkhjk', 'n', 1431005566),
(309, NULL, NULL, 13, 'hjhjk', 'n', 1431005647),
(310, NULL, NULL, 13, 'kjkj', 'n', 1431005706),
(311, 310, 310, 13, 'kjk', 'r', 1431005972),
(312, 310, 310, 13, 'l;l;', 'r', 1431006025),
(313, NULL, NULL, 13, 'jkjkjk', 'n', 1431006395),
(314, NULL, NULL, 13, 'hjhjhj', 'n', 1431006464),
(315, NULL, NULL, 13, 'ff', 'n', 1431006670),
(316, NULL, NULL, 13, 'll', 'n', 1431006898),
(317, NULL, NULL, 13, 'll', 'n', 1431006905),
(318, NULL, NULL, 13, 'tred', 'n', 1431006999),
(319, NULL, NULL, 13, 'jkjk', 'n', 1431007444),
(320, 318, 318, 13, 'jjjhjh', 'r', 1431007490),
(321, NULL, NULL, 13, 'j', 'n', 1431007510),
(322, NULL, NULL, 13, 'bghghj', 'n', 1431066829),
(323, NULL, NULL, 13, 'mjkjkjk', 'n', 1431066877),
(324, NULL, NULL, 13, 'jkjk', 'n', 1431066998),
(325, NULL, NULL, 13, 'dd', 'n', 1431068466),
(326, NULL, NULL, 13, 'dd', 'n', 1431068572),
(327, NULL, NULL, 13, 'dd', 'n', 1431068586),
(328, NULL, NULL, 13, 'jkjk', 'n', 1431068620),
(329, NULL, NULL, 13, 'ff', 'n', 1431068675),
(330, NULL, NULL, 13, 'ff', 'n', 1431069188),
(331, NULL, NULL, 13, 'ff', 'n', 1431069227),
(332, NULL, NULL, 13, 'ff', 'n', 1431069273),
(333, NULL, NULL, 13, 'ff', 'n', 1431069325),
(334, NULL, NULL, 13, 'kjkjk', 'n', 1431069346),
(335, NULL, NULL, 13, 'dd', 'n', 1431069413),
(336, NULL, NULL, 13, 'dd', 'n', 1431069699),
(337, NULL, NULL, 13, 'ttrteed', 'n', 1431069752),
(338, NULL, NULL, 13, 'ttrteed', 'n', 1431069982),
(339, NULL, NULL, 13, 'to je test pomoci', 'n', 1431070097),
(340, NULL, NULL, 13, 'jkjk', 'n', 1431071323),
(341, NULL, NULL, 13, 'jkkjkj', 'n', 1431071737),
(342, NULL, NULL, 13, 'gg', 'n', 1431071864),
(343, NULL, NULL, 13, 'testovaci post', 'n', 1431072163),
(344, NULL, NULL, 13, 'klklop', 'n', 1431072312),
(345, NULL, NULL, 13, 'sensible post', 'n', 1431073125),
(346, NULL, NULL, 13, 'dd to je test', 'n', 1431077242),
(347, NULL, NULL, 13, 'oputr', 'n', 1431081850),
(348, 347, 347, 13, 'lplp', 'r', 1431081899),
(349, 346, 346, 13, 'Come and do it', 'r', 1431344057),
(350, 345, 345, 13, 'opozice', 'r', 1431344230),
(351, 344, 344, 13, 'aaa', 'r', 1431344606),
(352, 342, 342, 13, 'koko', 'r', 1431344635),
(353, 335, 335, 13, 'pomoc', 'r', 1431344687),
(354, 333, 333, 13, 'opopkutre', 'r', 1431344711),
(355, 332, 332, 13, 'nemam poneti', 'r', 1431344771),
(356, 332, 355, 13, 'nema to chybku.', 'r', 1431345022),
(357, 346, 346, 13, 'iooio', 'r', 1431348666),
(358, 322, 322, 13, 'hutre', 'r', 1431348673),
(359, 315, 315, 13, 'kuku', 'r', 1431348685),
(360, 314, 314, 13, 'kukuv', 'r', 1431348812),
(361, NULL, NULL, 1, 'koko', 'n', 1431871619),
(362, NULL, NULL, 1, 'koko', 'n', 1431871814),
(363, NULL, NULL, 1, 'oui', 'n', 1431872177),
(364, NULL, NULL, 1, 'ouiopop', 'n', 1431872252),
(365, NULL, NULL, 1, 'gg', 'n', 1431873285),
(366, NULL, NULL, 1, 'gg', 'n', 1431873296),
(367, NULL, NULL, 1, 'gg', 'n', 1431874673),
(368, NULL, NULL, 1, 'gg', 'n', 1431874677),
(369, NULL, NULL, 1, 'gg', 'n', 1431874685),
(370, 332, 355, 1, 'to je test', 'r', 1431933942),
(371, 274, 274, 1, 'to je testik', 'r', 1431934077),
(372, 274, 371, 1, 'nema to chybu', 'r', 1431934099),
(373, 261, 268, 1, 'to je testik', 'r', 1431934362),
(374, 261, 261, 1, 'common', 'r', 1431934490),
(375, 260, 269, 1, 'common', 'r', 1431934701),
(376, 369, 369, 1, 'to je test', 'r', 1431943302),
(377, 369, 369, 1, 'testik 12', 'r', 1431943411),
(378, 369, 376, 1, 'coomon', 'r', 1431943827),
(379, 369, 376, 1, 'dd', 'r', 1431943878),
(380, 369, 376, 1, 'p[opop', 'r', 1431943902),
(381, NULL, NULL, 1, 'klkl', 'n', 1432489078),
(382, NULL, NULL, 1, 'kko', 'n', 1432667608),
(383, NULL, NULL, 1, 'kko', 'n', 1432668206),
(384, 382, 382, 1, 'koo', 'r', 1432670745),
(385, 382, 384, 1, 'gh', 'r', 1432670767),
(386, 363, 363, 1, 'dd', 'r', 1432670878),
(387, 363, 386, 1, 'ssdd', 'r', 1432670891),
(388, 382, 384, 1, 'jj', 'r', 1432670959),
(389, NULL, NULL, 1, 'ff', 'n', 1432671396),
(390, NULL, NULL, 1, 'ff', 'n', 1432671433),
(391, NULL, NULL, 1, 'dd', 'n', 1432672309),
(392, NULL, NULL, 1, 'ff', 'n', 1432672395),
(393, NULL, NULL, 1, 'gg', 'n', 1432672421),
(394, NULL, NULL, 1, 'ff', 'n', 1432672514),
(395, NULL, NULL, 1, 'ff', 'n', 1432672604),
(396, NULL, NULL, 1, 'ff', 'n', 1432672641),
(397, NULL, NULL, 1, 'fff', 'n', 1432673189),
(398, NULL, NULL, 1, 'fffddtre', 'n', 1432673232),
(399, NULL, NULL, 1, 'gfjkjkjk', 'n', 1432673270),
(400, NULL, NULL, 1, 'ftre', 'n', 1432676125),
(401, NULL, NULL, 1, 'ftre', 'n', 1432676139),
(403, NULL, NULL, 1, 'f', 'n', 1432676167),
(404, NULL, NULL, 1, 'hh', 'n', 1432676849),
(406, NULL, NULL, 1, 'ff', 'n', 1432676962),
(409, NULL, NULL, 1, 'ff', 'n', 1432677571),
(410, NULL, NULL, 1, 'ff', 'n', 1432677582),
(411, NULL, NULL, 1, 'ff', 'n', 1432677707),
(412, NULL, NULL, 1, 'dd', 'n', 1432677782),
(413, NULL, NULL, 1, 'fre', 'n', 1432677861),
(414, NULL, NULL, 1, 'ffjkjk', 'n', 1432678652),
(415, 413, 413, 1, 'tre', 'r', 1432678971),
(416, 414, 414, 1, 'koko', 'r', 1432681643),
(417, 414, 414, 1, 'lll', 'r', 1432683605);

-- --------------------------------------------------------

--
-- Struktura tabulky `post_files`
--

CREATE TABLE IF NOT EXISTS `post_files` (
`file_id` int(11) unsigned NOT NULL,
  `file_post_id` int(11) unsigned NOT NULL,
  `file_new_name` varchar(255) NOT NULL,
  `file_old_name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `post_files`
--

INSERT INTO `post_files` (`file_id`, `file_post_id`, `file_new_name`, `file_old_name`) VALUES
(1, 236, '5592dc7fa43d13b0ad6813ca256a9b5c.JPG', 'IMG_3631 (2).JPG'),
(2, 237, 'd93c386596839ee99eff2636eb1538c1.txt', 'tasks.txt'),
(3, 237, '9a0c2eea038d7c5b9a9999f2b29a1aa6.png', 'Untitled2.png'),
(4, 243, 'ff4e3b9def4c82755e0c49e5cef05826.txt', 'tasks.txt'),
(5, 243, 'd1f7a5d4cbe1293a2409b7a932fb1a61.png', 'Untitled2.png'),
(6, 244, '3d7383f46726fbec19ae44435d5cc811.txt', 'pass.txt'),
(7, 244, '3ba341e6f07ea19f16fc98140f6994cc.txt', 'pocty.txt'),
(8, 245, '4f23396e0d4af845de8ec2f376ad8f7b.png', 'html.png'),
(9, 245, '668067f8bb4cc1556930ba427d8003fc.jpg', 'jirucha.jpg'),
(10, 246, 'd84831d852337f0e471415b003354336.pdf', 'Eloquent_JavaScript.pdf'),
(11, 247, 'd90ac14ccb9eeac1f69c07a5f87e82ad.pdf', 'Eloquent_JavaScript.pdf'),
(12, 248, '9434f92b138f2028783040b50ef8bb61.txt', 'pass.txt'),
(13, 251, '5624b8d44aeaf955c4fa656df8fae250.txt', 'pass.txt'),
(14, 251, '6de93f6063306e3a150002397f423256.txt', 'pocty.txt'),
(15, 252, 'e45dc777eb453cebaa2d962628c55729.pdf', 'Eloquent_JavaScript.pdf'),
(16, 252, '132c68978b10b7e1e2820082a5f70adf.JPG', 'IMG_3631 (2).JPG'),
(17, 253, '8fe246ba75f438d2236b7067d0553a0b.txt', 'pass.txt'),
(18, 253, 'a3fce7d8b792cdce86f096bcbb023abe.txt', 'pocty.txt'),
(19, 254, 'cb1e2a1b659f9601f36c986bb52bb193.png', 'html.png'),
(20, 255, 'ce3b500d5b0706f32a0907d585d88476.jpg', 'jirucha.jpg'),
(21, 255, '4dc224f52f8938f3c834020e800dd62b.txt', 'pass.txt'),
(22, 255, 'da740794e3814eaa715d7eb504a2a9ba.txt', 'pocty.txt'),
(23, 256, '2080851c189e3fa8aab3451dff4b748e.jpg', 'tom-blog.jpg'),
(24, 256, '77c9dd6e2c2f3e932cee7076519c9a33.jpg', 'Untitled.jpg'),
(25, 256, 'fda138a08c90ea961ecb1ae97f40d97c.png', 'Untitled2.png'),
(27, 257, 'b2cf00cdef5eaccfed8d625a99cc0a04.pdf', 'Eloquent_JavaScript.pdf'),
(28, 257, '6dca2065c5fb9402ed07693ee412b312.JPG', 'IMG_3631 (2).JPG'),
(29, 258, 'ceaa4d5c6bbd6414dc198177bb22d06a.jpg', 'anicka50.jpg'),
(30, 258, '95fce9c6f4e8f58400033f12d8650290.JPG', 'IMG_3631 (2).JPG'),
(31, 260, '992406564403753160e4e8c130ddebf9.txt', 'pass.txt'),
(32, 260, '0cf6f30bb80ffe7d42fa4b6e6fcb105b.txt', 'pocty.txt'),
(33, 261, 'f279bfa8e7e51eb9f01ae395b7669af2.jpg', 'tom-blog.jpg'),
(34, 261, '1d40a0312b13905c5318023c91a7708d.jpg', 'Untitled.jpg'),
(35, 271, 'c6c52be95b7a4f9691f08301dfdbce3e.pdf', 'Eloquent_JavaScript.pdf'),
(36, 271, 'cd3157b4ccf5414920de8ca372394e74.JPG', 'IMG_3631 (2).JPG'),
(37, 272, '15ee8a9f00dac7972ec9462257bf2150.pdf', 'Eloquent_JavaScript.pdf'),
(38, 272, '68dc734efaf993b0983518ff5a5781f4.png', 'html.png'),
(39, 273, 'c965872dedb4c70d4c8097b99da4df3f.JPG', 'IMG_3631 (2).JPG'),
(40, 273, 'f2b1df852d662e832f2b22cba5120c6a.jpg', 'jirucha.jpg'),
(41, 274, '8d1587704cc65b300091808a6ae79a0d.pdf', 'Eloquent_JavaScript.pdf'),
(42, 274, 'eb63dad98baec61dd8b6489e2dca8ccc.JPG', 'IMG_3631 (2).JPG'),
(43, 274, 'a37930090f6daac0bf3861a51d2136d3.jpg', 'anicka.jpg'),
(44, 275, '2cf7f655aacaeee37cb22124832e102b.pdf', 'Eloquent_JavaScript.pdf'),
(45, 275, '26a11ae6cf31ae3ba0afc636271343da.JPG', 'IMG_3631 (2).JPG'),
(46, 276, '97f1a7e56c693f389b517a700b514d85.JPG', 'IMG_3631 (2).JPG'),
(47, 276, '6639dd6c04f05f9649eb51aa7400f3b4.jpg', 'jirucha.jpg'),
(48, 277, '352bc80514d0a458dcb99525270aed9f.png', 'Untitled2.png'),
(49, 278, '6ca583739203b1444af4076f290e9c6a.pdf', 'Eloquent_JavaScript.pdf'),
(50, 278, 'b9387be385f1e80f1fd4afbb469b5e8a.JPG', 'IMG_3631 (2).JPG'),
(51, 279, '438b61bbfa053880217b76fdb6a7e145.JPG', 'IMG_3631 (2).JPG'),
(52, 279, '6f7c6e8b00f59eebf415d9d0602c0311.jpg', 'jirucha.jpg'),
(53, 280, '07d7b26ea9e58621851adc213a68fad9.JPG', 'IMG_3631 (2).JPG'),
(54, 280, '3c41e7931cf18703b0d8bee7d4a5a020.jpg', 'jirucha.jpg'),
(55, 282, '8446890e5afd69f0716943d6b6e5b8f5.txt', 'pass.txt'),
(56, 282, '87bac4c1dd949dfece10654c404306bc.txt', 'pocty.txt'),
(57, 283, '1e296f734069d9f6915d929fce8a6e83.pdf', 'Eloquent_JavaScript.pdf'),
(58, 283, 'b97df1d1b48ac2d0e821aef2b5d119ef.JPG', 'IMG_3631 (2).JPG'),
(59, 284, '332bc4f1b78917597bb850ed22a84c1b.pdf', 'Eloquent_JavaScript.pdf'),
(60, 284, 'a663597185752734b0c70ae3536ee719.JPG', 'IMG_3631 (2).JPG'),
(61, 285, 'e779f42e688fec838c37bc0640fdc335.pdf', 'Eloquent_JavaScript.pdf'),
(62, 285, '754613650201de68c4b8fc1c134fddfa.JPG', 'IMG_3631 (2).JPG'),
(63, 286, 'a0dc6eaa821c8d9de28855901d39d5d5.jpg', 'anicka50.jpg'),
(64, 286, '0f2896eaedce15d8533ed4fba2a021b6.pdf', 'Eloquent_JavaScript.pdf'),
(65, 287, 'cfb4dc97627defbd87cf0c544a08d945.pdf', 'Eloquent_JavaScript.pdf'),
(66, 288, '1e229003b0a50fead775b2de4c1f9ff2.jpg', 'anicka50.jpg'),
(67, 288, 'de68c68ab8543ad85d725b3f5a0c48c9.pdf', 'Eloquent_JavaScript.pdf'),
(68, 289, '72abd08376dad8577c8911f85fbe7ec8.pdf', 'Eloquent_JavaScript.pdf'),
(69, 289, '36193b68ec08b3a5572332886c2032f5.JPG', 'IMG_3631 (2).JPG'),
(70, 290, 'f586bbcecb64e825d55a75b431050532.jpg', 'jirucha.jpg'),
(71, 290, '6d648b3adf58b957001134d481206e52.txt', 'pass.txt'),
(72, 291, '4785b8db44d5ebbcf57e008f7527639e.png', 'html.png'),
(73, 291, 'fe3b5c364a28386bb636d850596c2d85.bmp', 'jirik.bmp'),
(74, 292, '3e131ed54a1bd521388cd2965faf0fd2.jpg', 'anicka50.jpg'),
(75, 292, '872e540c56ae3efb83e4b8f87d3d7154.txt', 'pass.txt'),
(76, 293, '8ed11dd8b0dd059fcfb5b2ed6995ecc2.pdf', 'Eloquent_JavaScript.pdf'),
(77, 293, '47ef3c8a6f9ec0077175ddc96de666ed.bmp', 'jirik.bmp'),
(78, 294, 'a323ef052b0836bc714fcc5034a8a19e.pdf', 'Eloquent_JavaScript.pdf'),
(79, 294, '7fa76cf646da9544967e3957093ca588.bmp', 'jirik.bmp'),
(80, 295, 'b49b41f82b0b3faea7532806575c030c.pdf', 'Eloquent_JavaScript.pdf'),
(81, 295, '83ef902fe241999d9e581e4e7461e2f6.png', 'html.png'),
(82, 296, 'b81d39caf22b7f6ca4abd06430cf5192.pdf', 'Eloquent_JavaScript.pdf'),
(83, 296, '614c200449c43aa432204c47cf82dd4f.png', 'html.png'),
(84, 297, 'd51a783b6f3d61eaddee8e2dbe0d2cc9.txt', 'pass.txt'),
(85, 297, '0b5072fe1213b6cbfa68c5547a24afa4.txt', 'pocty.txt'),
(86, 298, '2bdc2b125779afdf38b06302f463d0cf.pdf', 'Eloquent_JavaScript.pdf'),
(87, 298, '5cea42e233ea8c04a3fe1c49b4e746c3.JPG', 'IMG_3631 (2).JPG'),
(88, 299, '715343af0f3a26bd6a5d0da1f60e4913.jpg', 'jirucha.jpg'),
(89, 299, '239cc1f192e4177e13bddab0d5b1244e.txt', 'pass.txt'),
(90, 300, 'd2654c19d454f5bd33bff45cf4eefb65.JPG', 'IMG_3631 (2).JPG'),
(91, 300, '3c697961790916e5f453ac003a56b963.jpg', 'jirucha.jpg'),
(92, 304, '5d54831c7aa308935223788849d77afb.JPG', 'IMG_3631 (2).JPG'),
(93, 304, 'e594454a297fa44ee9e9dd8f250b3db6.jpg', 'jirucha.jpg'),
(94, 305, '0a3e5589365dfcf55d5c9af339aa7b54.jpg', 'anicka50.jpg'),
(95, 305, '3d595ed370a0a425ea2e28ad7fb5c404.JPG', 'IMG_3631 (2).JPG'),
(96, 306, '77cfdf18ffd373795cad523fe57422b4.txt', 'pass.txt'),
(97, 306, '99097c4f8a63be4da5a90719f3771178.txt', 'pocty.txt'),
(98, 307, 'ad74bbd95a0529946a4d85069f8b0b78.JPG', 'IMG_3631 (2).JPG'),
(99, 307, '07d748233aba16d48258a269be0c9520.jpg', 'jirucha.jpg'),
(100, 308, '11586e25c52b8bf32e4e929e1f3ab44a.png', 'html.png'),
(101, 308, '07436435551769eb494d57f5aa13f350.JPG', 'IMG_3631 (2).JPG'),
(102, 309, 'cdd00c1803e5eb06a958df6b64b9db64.jpg', 'anicka50.jpg'),
(103, 309, 'a483a5aa1a56b2876a33be066f8d59b7.JPG', 'IMG_3631 (2).JPG'),
(104, 310, '588b75f4c8317ab7ac8afb4d9347300d.pdf', 'Eloquent_JavaScript.pdf'),
(105, 310, '3c6e9b8261c8321c82c3cfa112458d7e.png', 'html.png'),
(106, 314, '1ecbaa8c0b35125a09bbbcc2afaad8d1.pdf', 'Eloquent_JavaScript.pdf'),
(107, 314, '12e0afeeb05e066d8a3c846704a99b06.JPG', 'IMG_3631 (2).JPG'),
(108, 316, 'bc64a5bb4f11a15d591320be8d98f175.pdf', 'Eloquent_JavaScript.pdf'),
(109, 316, '4c0169749f52a15f42968e804dc89cf4.JPG', 'IMG_3631 (2).JPG'),
(110, 318, 'c479bd68d775cf969ceb65b7dd2fc76d.pdf', 'Eloquent_JavaScript.pdf'),
(111, 318, '02615d820796bca3ad4f425972f6c58c.png', 'html.png'),
(112, 319, 'a86f585d882799c5f439e42210694487.pdf', 'Eloquent_JavaScript.pdf'),
(113, 320, 'a8566b37d541f998e5a881a8fb0a56a4.txt', 'pass.txt'),
(114, 322, '654a4313d33dd1b4033192ea9e32d816.jpg', 'jirucha.jpg'),
(115, 322, '649fadc8e877c54cd7d1c4eac821550a.txt', 'pass.txt'),
(116, 324, 'bdf2c13db71b74c88b111befee8a14af.JPG', 'IMG_3631 (2).JPG'),
(117, 330, '5c0acf8da47ea70a16e16e03dbebda80.jpg', 'jirucha.jpg'),
(118, 331, '1b9aa40b8f8570473a0c5326a74cf2b7.png', 'html.png'),
(119, 334, '0ea87687d1a2c7994170eb45140f5f9c.png', 'html.png'),
(120, 334, 'cfca98ec677bb82c86b16aa0720d56b1.JPG', 'IMG_3631 (2).JPG'),
(121, 342, 'be6d64b9cbf90e2f66edd9f81e540dfc.pdf', 'Změna hesla pro email.pdf'),
(122, 343, '87a95ecc980f0625e0cdea1b53717a85.JPG', 'IMG_3631 (2).JPG'),
(123, 343, '337bd667a1dad445deee20931ff0b44c.jpg', 'jirucha.jpg'),
(124, 344, 'ab02919b4b516b398a82bc88ff202f80.txt', 'pass.txt'),
(125, 345, '47551f422f4abf77c10a2fde88b9ec1f.JPG', 'IMG_3631 (2).JPG'),
(126, 346, '266405dbda37f1b3c0b5691c8a9ae920.png', 'Untitled4.png'),
(127, 346, '8eee4baaf11dab9c56ad798b3f1def0a.JPG', 'IMG_3631 (2).JPG'),
(128, 346, '662c7efcdd9e1b3db4c48d3da284c960.txt', 'pass.txt'),
(129, 346, '3bca2c0c269d22017240ebec752b2b50.pdf', 'Eloquent_JavaScript.pdf'),
(130, 346, '8385f931f3f74ce4643aadcdb15b5a85.jpg', 'jirucha.jpg'),
(131, 347, '21c387e361599fd3f566affa02fee00e.JPG', 'IMG_3631 (2).JPG'),
(132, 347, '08101c0b3386ac79e3af4df62e6aab3f.png', 'Untitled3.png'),
(133, 347, '835687def7720515c564749d6c30a49c.pdf', 'Eloquent_JavaScript.pdf'),
(134, 347, '919c16586e1e3a5d521227f5572f80e8.txt', 'pocty.txt'),
(135, 348, 'dfb6f15e12e02dfb2d62221f819acd9b.JPG', 'IMG_3631 (2).JPG'),
(136, 373, 'f66af67921fbfaa82caf4926320fc80c.jpg', 'anicka.jpg'),
(137, 373, 'c075a783de37a217ce16642860a3aabb.JPG', 'IMG_3631 (2).JPG'),
(138, 383, '80a9fca35dc29198d3e0051a269a10d3.JPG', 'IMG_3631 (2).JPG'),
(139, 383, 'a581e74c1f3cc2aaf2631ae6dd159940.jpg', '163454_181742078511931_6797783_n.jpg'),
(140, 388, '2e8c5591bb25922611675053aa8da440.jpg', '163454_181742078511931_6797783_n.jpg'),
(141, 388, '9587077600e5c220a98f93848f86e964.jpg', '5.jpg'),
(142, 393, 'a86f494ff9ecc239dd9dd7120fb14358.png', 'jedlinska.png'),
(143, 393, '5fe6aed2e22fbd56cbd9d2acd76943e4.jpg', 'jirucha.jpg'),
(144, 395, 'c014f258f539d61b97daaca18f9b4834.jpg', 'anicka.jpg'),
(145, 395, '8275877e89d8ef26f9eb4cd5a9b95302.jpg', 'anicka50.jpg'),
(146, 396, '555d99a455e49f70f1cd2f972af0d485.jpg', '5.jpg'),
(147, 396, 'f643dcb525fe37a87378c133744b64eb.jpg', 'anicka.jpg'),
(148, 397, '1b1d4fcc05fcbadb2bd4816dcac8d205.jpg', '5.jpg'),
(149, 397, 'b514912160e4ef72bf569564306675fa.jpg', 'anicka.jpg'),
(150, 398, 'cb8dc0e27bdca987edb34f835bed1129.jpg', 'anicka50.jpg'),
(151, 398, '2668675e2455cfacab7174d01e297ee8.jpg', '163454_181742078511931_6797783_n.jpg'),
(152, 399, 'e89e2d79212ab4b80f93072c715f2d47.png', 'html.png'),
(153, 399, '8876de7bfcda5571f9c91df3960af5b7.png', 'jedlinska.png'),
(154, 399, 'bfb66e52c3afc1783ba0bd489ff3cd29.png', 'Untitled3.png'),
(155, 400, '4e812bf8e1f4fcb03e4f3840ee5ca4a4.jpg', '5.jpg'),
(156, 400, 'ffcf3814814282e6eacb7da29d04561a.png', 'Untitled3.png'),
(157, 400, '5d099a3b2a7f0f105c2ca47e543788ed.JPG', 'IMG_3631 (2).JPG'),
(158, 401, '1ed70a47d97c8d10c805cfab0c87e4c6.txt', 'git.txt'),
(164, 404, '57a90611345c1cdddc0d962d215be77b.jpg', '5.jpg'),
(165, 404, '76625dde0da98103c2a3d89801043428.png', 'Untitled3.png'),
(169, 406, '4c8e286bc52e47340a9ca5d51e0a76f3.jpg', '5.jpg'),
(170, 406, 'bf48f7d4089be8af699243e63017bae9.JPG', 'IMG_3631 (2).JPG'),
(171, 406, '8cacf5d74cae9b1ab1716687091bf940.png', 'Untitled3.png'),
(174, 414, 'd8952775ac6931512f9a579333dfc255.png', 'html.png'),
(175, 414, '33c531fe4e5d188b22020b9841551044.png', 'jedlinska.png'),
(176, 414, '81e56f5377fa4b539159508019a1cfef.jpg', 'jirucha.jpg'),
(177, 415, '9e3aad2ef8dfd44513d0b0a6798a12a8.jpg', '5.jpg'),
(178, 415, '2b7c03e1657285a045b45400209c9573.png', 'Untitled3.png'),
(179, 416, '709bd844938b8b247d8e46e122ab7b9b.jpg', 'anicka.jpg'),
(180, 416, 'c2b02ac4f357729c398774745327bf25.jpg', 'anicka50.jpg'),
(181, 417, 'ea60facad50460490942dccf2d64cd92.png', 'jedlinska.png'),
(182, 417, '265ec17b9c9987e523fb4fd9920dfce8.jpg', 'jirucha.jpg');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) unsigned NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_role` int(11) unsigned NOT NULL,
  `user_img` varchar(255) NOT NULL,
  `user_active` tinyint(3) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_role`, `user_img`, `user_active`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'ee83b7c6b137b69de9f97f8a4b06e03f.jpg', 1),
(3, 'tomas', '5c92b413349908597b473643ea82d396', 2, '', 1),
(4, 'alex vrantt', 'b12a09da3e5e401c0e3c801738b35fd9', 3, '', 1),
(9, 'viki', 'afead4e8233c6a83582e887b163c7402', 2, '2ce74cfd5a9921158b1c45fb801b72d6.jpg', 1),
(10, 'main admin', 'd160836c6d32d3ff2235fe0f7b8e2d9b', 1, '', 0),
(12, 'rich', '622d765c3fb5201e357534d08f4c7171', 2, '', 1),
(13, 'pavel', '2ec857eaebed45f67b587724043273ae', 2, '', 1),
(15, 'thomas wanli', 'dfa4cb3ed700488730ab4fcce44a99ca', 1, '', 1),
(22, 'test', 'e29730bc31b2d3cb1e38c87bf0bd9886', 2, '40b203dfb90cdca3362d190f00afd73a.jpg', 1),
(23, 'hobit', '6aaf69e98b538bf9d420ef28a47dc2d5', 2, '', 1),
(25, 'Thomas', '3b3e19a58e0355ecc5ffdada7510e275', 2, '', 1),
(26, 'pokus', '05a671c66aefea124cc08b76ea6d30bb', 2, '', 1),
(29, 'abu', 'b1f638c426560189d29ef8746e3e0aaf', 2, '', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
`user_roles_id` int(11) unsigned NOT NULL,
  `user_roles_role` varchar(50) NOT NULL,
  `user_roles_name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `user_roles`
--

INSERT INTO `user_roles` (`user_roles_id`, `user_roles_role`, `user_roles_name`) VALUES
(1, 'superadmin', 'Super Admin'),
(2, 'admin', 'Admin'),
(3, 'user', 'User');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `album`
--
ALTER TABLE `album`
 ADD PRIMARY KEY (`album_id`);

--
-- Klíče pro tabulku `likes`
--
ALTER TABLE `likes`
 ADD PRIMARY KEY (`like_id`), ADD KEY `like_post_id` (`like_post_id`), ADD KEY `like_user_id` (`like_user_id`);

--
-- Klíče pro tabulku `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`post_id`), ADD KEY `post_user_id` (`post_user_id`);

--
-- Klíče pro tabulku `post_files`
--
ALTER TABLE `post_files`
 ADD PRIMARY KEY (`file_id`), ADD KEY `file_post_id` (`file_post_id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `username` (`user_name`), ADD KEY `role` (`user_role`);

--
-- Klíče pro tabulku `user_roles`
--
ALTER TABLE `user_roles`
 ADD PRIMARY KEY (`user_roles_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `album`
--
ALTER TABLE `album`
MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=192;
--
-- AUTO_INCREMENT pro tabulku `likes`
--
ALTER TABLE `likes`
MODIFY `like_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=262;
--
-- AUTO_INCREMENT pro tabulku `posts`
--
ALTER TABLE `posts`
MODIFY `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=418;
--
-- AUTO_INCREMENT pro tabulku `post_files`
--
ALTER TABLE `post_files`
MODIFY `file_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=183;
--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pro tabulku `user_roles`
--
ALTER TABLE `user_roles`
MODIFY `user_roles_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `likes`
--
ALTER TABLE `likes`
ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`like_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`like_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `posts`
--
ALTER TABLE `posts`
ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_user_id`) REFERENCES `users` (`user_id`);

--
-- Omezení pro tabulku `post_files`
--
ALTER TABLE `post_files`
ADD CONSTRAINT `post_files_ibfk_1` FOREIGN KEY (`file_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role`) REFERENCES `user_roles` (`user_roles_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
