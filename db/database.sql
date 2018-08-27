-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 19, 2017 at 02:12 PM
-- Server version: 10.1.23-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dataBaseName`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_prayer`
--

CREATE TABLE `add_prayer` (
  `pr_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prayer_content` text,
  `payer_image` varchar(255) DEFAULT NULL,
  `likes` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `datetime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `add_prayer`
--

INSERT INTO `add_prayer` (`pr_id`, `user_id`, `prayer_content`, `payer_image`, `likes`, `comments`, `datetime`) VALUES
(1, 1, 'Test', 'asone_app/uploads/2016-08-214_20:08:48.jpeg', 1, 1, ''),
(2, 5, 'Ghetto rehydrateghgfhfgh', 'asone_app/uploads/2016-08-215_13:08:89.jpeg', 0, 0, '2016-08-02 13:47:89'),
(3, 5, 'Justus', 'asone_app/uploads/2016-08-215_13:08:03.jpeg', 0, 0, '2016-08-02 13:56:03'),
(4, 5, 'Uikuooou', 'asone_app/uploads/2016-08-215_14:08:30.jpeg', 0, 0, '2016-08-02 14:13:30'),
(5, 9, 'Thing know,', '', 0, 0, '2017-03-23 11:38:94'),
(6, 9, '565689+', '', 0, 0, '2017-03-23 11:45:58'),
(7, 4, 'Fff and ', '', 0, 0, '2017-03-23 11:46:75'),
(8, 4, 'Fff and ', '', 0, 0, '2017-03-23 11:46:55'),
(9, 1, 'Ydrdytd', 'asone_app/uploads/2017-04-110_20:04:65.jpeg', 0, 2, ''),
(10, 10, 'Bvcghxgjcjgh', 'asone_app/uploads/2017-10-300_21:10:05.jpeg', 0, 0, '2017-10-27 21:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `opp_id` int(11) NOT NULL,
  `s_msg` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `user_id`, `opp_id`, `s_msg`, `time`) VALUES
(1, 1, 2, 'Hello', '2016-09-06 10:10:30'),
(2, 2, 1, 'How are you ?', '2016-09-06 10:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `chat_conversation`
--

CREATE TABLE `chat_conversation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feeds_m`
--

CREATE TABLE `feeds_m` (
  `id` int(11) NOT NULL,
  `feedowner_id` int(11) NOT NULL,
  `action_owner_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `content_image` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `feed_type` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `no_of_likes` int(11) NOT NULL,
  `no_of_comments` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feeds_m`
--

INSERT INTO `feeds_m` (`id`, `feedowner_id`, `action_owner_id`, `post_id`, `content`, `content_image`, `comments`, `feed_type`, `date`, `no_of_likes`, `no_of_comments`) VALUES
(1, 1, 1, 1, 'Test', 'asone_app/uploads/2016-08-214_20:08:48.jpeg', '', 'Likes Prayer', '2017-04-20 14:37:07', 1, 0),
(2, 9, 4, 7, 'Fff and ', '', '', 'Posted Prayer', '2017-03-23 06:16:11', 0, 0),
(3, 9, 4, 8, 'Fff and ', '', '', 'Posted Prayer', '2017-03-23 06:16:20', 0, 0),
(4, 1, 2, 1, 'Udfg', 'asone_app/uploads/2016-12-350_20:12:61.jpeg', '', 'likes Good News', '2017-07-27 11:27:32', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `followers_by_uid`
--

CREATE TABLE `followers_by_uid` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `followers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers_by_uid`
--

INSERT INTO `followers_by_uid` (`id`, `user_id`, `followers`) VALUES
(1, 4, 9);

-- --------------------------------------------------------

--
-- Table structure for table `following_by_uid`
--

CREATE TABLE `following_by_uid` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `following` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `following_by_uid`
--

INSERT INTO `following_by_uid` (`id`, `user_id`, `following`) VALUES
(1, 9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `g_id` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`g_id`, `gender`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'A'),
(4, 'AB');

-- --------------------------------------------------------

--
-- Table structure for table `gnews_comment`
--

CREATE TABLE `gnews_comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gnews_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `goodnews`
--

CREATE TABLE `goodnews` (
  `gnews_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gnews_content` text NOT NULL,
  `gnews_image` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `goodnews`
--

INSERT INTO `goodnews` (`gnews_id`, `user_id`, `gnews_content`, `gnews_image`, `likes`, `comments`, `datetime`) VALUES
(1, 1, 'Udfg', 'asone_app/uploads/2016-12-350_20:12:61.jpeg', 0, 0, '0000-00-00 00:00:00'),
(2, 1, ' Fiyfhj', 'asone_app/uploads/2017-04-110_20:04:91.jpeg', 0, 0, '0000-00-00 00:00:00'),
(3, 1, 'Hxfhjgfjgfjgchjciyciycyicihivh', 'asone_app/uploads/2017-04-110_20:04:65.jpeg', 0, 0, '0000-00-00 00:00:00'),
(4, 10, 'Fhgdghdhgfjg', 'asone_app/uploads/2017-10-300_21:10:95.jpeg', 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `goodnews_like`
--

CREATE TABLE `goodnews_like` (
  `gl_id` int(11) NOT NULL,
  `gnews_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `goodnews_like`
--

INSERT INTO `goodnews_like` (`gl_id`, `gnews_id`, `user_id`) VALUES
(2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nationality`
--

CREATE TABLE `nationality` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `flag` varchar(250) NOT NULL DEFAULT '',
  `country_code` varchar(3) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nationality`
--

INSERT INTO `nationality` (`id`, `name`, `flag`, `country_code`, `user_id`, `status`) VALUES
(1, 'Afghanistan', 'asone_app/flags/af.png', 'afg', 0, 0),
(2, 'Aland Islands', 'asone_app/flags/ax.png', 'ala', 0, 0),
(3, 'Albania', 'asone_app/flags/al.png', 'alb', 0, 0),
(4, 'Algeria', 'asone_app/flags/dz.png', 'dza', 0, 0),
(5, 'American Samoa', 'asone_app/flags/as.png', 'asm', 0, 0),
(6, 'Andorra', 'asone_app/flags/ad.png', 'and', 0, 0),
(7, 'Angola', 'asone_app/flags/ao.png', 'ago', 0, 0),
(8, 'Anguilla', 'asone_app/flags/ai.png', 'aia', 0, 0),
(9, 'Antarctica', 'asone_app/flags/aq.png', '', 0, 0),
(10, 'Antigua and Barbuda', 'asone_app/flags/ag.png', 'atg', 0, 0),
(11, 'Argentina', 'asone_app/flags/ar.png', 'arg', 0, 0),
(12, 'Armenia', 'asone_app/flags/am.png', 'arm', 0, 0),
(13, 'Aruba', 'asone_app/flags/aw.png', 'abw', 0, 0),
(14, 'Australia', 'asone_app/flags/au.png', 'aus', 0, 0),
(15, 'Austria', 'asone_app/flags/at.png', 'aut', 0, 0),
(16, 'Azerbaijan', 'asone_app/flags/az.png', 'aze', 0, 0),
(17, 'Bahamas', 'asone_app/flags/bs.png', 'bhs', 0, 0),
(18, 'Bahrain', 'asone_app/flags/bh.png', 'bhr', 0, 0),
(19, 'Bangladesh', 'asone_app/flags/bd.png', 'bgd', 0, 0),
(20, 'Barbados', 'asone_app/flags/bb.png', 'brb', 0, 0),
(21, 'Belarus', 'asone_app/flags/by.png', 'blr', 0, 0),
(22, 'Belgium', 'asone_app/flags/be.png', 'bel', 0, 0),
(23, 'Belize', 'asone_app/flags/bz.png', 'blz', 0, 0),
(24, 'Benin', 'asone_app/flags/bj.png', 'ben', 0, 0),
(25, 'Bermuda', 'asone_app/flags/bm.png', 'bmu', 0, 0),
(26, 'Bhutan', 'asone_app/flags/bt.png', 'btn', 0, 0),
(27, 'Bolivia, Plurinational State of', 'asone_app/flags/bo.png', 'bol', 0, 0),
(28, 'Bonaire, Sint Eustatius and Saba', 'asone_app/flags/bq.png', 'bes', 0, 0),
(29, 'Bosnia and Herzegovina', 'asone_app/flags/ba.png', 'bih', 0, 0),
(30, 'Botswana', 'asone_app/flags/bw.png', 'bwa', 0, 0),
(31, 'Bouvet Island', 'asone_app/flags/bv.png', '', 0, 0),
(32, 'Brazil', 'asone_app/flags/br.png', 'bra', 0, 0),
(33, 'British Indian Ocean Territory', 'asone_app/flags/io.png', '', 0, 0),
(34, 'Brunei Darussalam', 'asone_app/flags/bn.png', 'brn', 0, 0),
(35, 'Bulgaria', 'asone_app/flags/bg.png', 'bgr', 0, 0),
(36, 'Burkina Faso', 'asone_app/flags/bf.png', 'bfa', 0, 0),
(37, 'Burundi', 'asone_app/flags/bi.png', 'bdi', 0, 0),
(38, 'Cambodia', 'asone_app/flags/kh.png', 'khm', 0, 0),
(39, 'Cameroon', 'asone_app/flags/cm.png', 'cmr', 0, 0),
(40, 'Canada', 'asone_app/flags/ca.png', 'can', 0, 0),
(41, 'Cape Verde', 'asone_app/flags/cv.png', 'cpv', 0, 0),
(42, 'Cayman Islands', 'asone_app/flags/ky.png', 'cym', 0, 0),
(43, 'Central African Republic', 'asone_app/flags/cf.png', 'caf', 0, 0),
(44, 'Chad', 'asone_app/flags/td.png', 'tcd', 0, 0),
(45, 'Chile', 'asone_app/flags/cl.png', 'chl', 0, 0),
(46, 'China', 'asone_app/flags/cn.png', 'chn', 0, 0),
(47, 'Christmas Island', 'asone_app/flags/cx.png', '', 0, 0),
(48, 'Cocos (Keeling) Islands', 'asone_app/flags/cc.png', '', 0, 0),
(49, 'Colombia', 'asone_app/flags/co.png', 'col', 0, 0),
(50, 'Comoros', 'asone_app/flags/km.png', 'com', 0, 0),
(51, 'Congo', 'asone_app/flags/cg.png', 'cog', 0, 0),
(52, 'Congo, The Democratic Republic of the', 'asone_app/flags/cd.png', 'cod', 0, 0),
(53, 'Cook Islands', 'asone_app/flags/ck.png', 'cok', 0, 0),
(54, 'Costa Rica', 'asone_app/flags/cr.png', 'cri', 0, 0),
(55, 'Cote d\'Ivoire', 'asone_app/flags/ci.png', 'civ', 0, 0),
(56, 'Croatia', 'asone_app/flags/hr.png', 'hrv', 0, 0),
(57, 'Cuba', 'asone_app/flags/cu.png', 'cub', 0, 0),
(58, 'Curacao', 'asone_app/flags/cw.png', 'cuw', 0, 0),
(59, 'Cyprus', 'asone_app/flags/cy.png', 'cyp', 0, 0),
(60, 'Czech Republic', 'asone_app/flags/cz.png', 'cze', 0, 0),
(61, 'Denmark', 'asone_app/flags/dk.png', 'dnk', 0, 0),
(62, 'Djibouti', 'asone_app/flags/dj.png', 'dji', 0, 0),
(63, 'Dominica', 'asone_app/flags/dm.png', 'dma', 0, 0),
(64, 'Dominican Republic', 'asone_app/flags/do.png', 'dom', 0, 0),
(65, 'Ecuador', 'asone_app/flags/ec.png', 'ecu', 0, 0),
(66, 'Egypt', 'asone_app/flags/eg.png', 'egy', 0, 0),
(67, 'El Salvador', 'asone_app/flags/sv.png', 'slv', 0, 0),
(68, 'Equatorial Guinea', 'asone_app/flags/gq.png', 'gnq', 0, 0),
(69, 'Eritrea', 'asone_app/flags/er.png', 'eri', 0, 0),
(70, 'Estonia', 'asone_app/flags/ee.png', 'est', 0, 0),
(71, 'Ethiopia', 'asone_app/flags/et.png', 'eth', 0, 0),
(72, 'Falkland Islands (Malvinas)', 'asone_app/flags/fk.png', 'flk', 0, 0),
(73, 'Faroe Islands', 'asone_app/flags/fo.png', 'fro', 0, 0),
(74, 'Fiji', 'asone_app/flags/fj.png', 'fji', 0, 0),
(75, 'Finland', 'asone_app/flags/fi.png', 'fin', 0, 0),
(76, 'France', 'asone_app/flags/fr.png', 'fra', 0, 0),
(77, 'French Guiana', 'asone_app/flags/gf.png', 'guf', 0, 0),
(78, 'French Polynesia', 'asone_app/flags/pf.png', 'pyf', 0, 0),
(79, 'French Southern Territories', 'asone_app/flags/tf.png', '', 0, 0),
(80, 'Gabon', 'asone_app/flags/ga.png', 'gab', 0, 0),
(81, 'Gambia', 'asone_app/flags/gm.png', 'gmb', 0, 0),
(82, 'Georgia', 'asone_app/flags/ge.png', 'geo', 0, 0),
(83, 'Germany', 'asone_app/flags/de.png', 'deu', 0, 0),
(84, 'Ghana', 'asone_app/flags/gh.png', 'gha', 0, 0),
(85, 'Gibraltar', 'asone_app/flags/gi.png', 'gib', 0, 0),
(86, 'Greece', 'asone_app/flags/gr.png', 'grc', 0, 0),
(87, 'Greenland', 'asone_app/flags/gl.png', 'grl', 0, 0),
(88, 'Grenada', 'asone_app/flags/gd.png', 'grd', 0, 0),
(89, 'Guadeloupe', 'asone_app/flags/gp.png', 'glp', 0, 0),
(90, 'Guam', 'asone_app/flags/gu.png', 'gum', 0, 0),
(91, 'Guatemala', 'asone_app/flags/gt.png', 'gtm', 0, 0),
(92, 'Guernsey', 'asone_app/flags/gg.png', 'ggy', 0, 0),
(93, 'Guinea', 'asone_app/flags/gn.png', 'gin', 0, 0),
(94, 'Guinea-Bissau', 'asone_app/flags/gw.png', 'gnb', 0, 0),
(95, 'Guyana', 'asone_app/flags/gy.png', 'guy', 0, 0),
(96, 'Haiti', 'asone_app/flags/ht.png', 'hti', 0, 0),
(97, 'Heard Island and McDonald Islands', 'asone_app/flags/hm.png', '', 0, 0),
(98, 'Holy See (Vatican City State)', 'asone_app/flags/va.png', 'vat', 0, 0),
(99, 'Honduras', 'asone_app/flags/hn.png', 'hnd', 0, 0),
(100, 'Hong Kong', 'asone_app/flags/hk.png', 'hkg', 0, 0),
(101, 'Hungary', 'asone_app/flags/hu.png', 'hun', 0, 0),
(102, 'Iceland', 'asone_app/flags/is.png', 'isl', 0, 0),
(103, 'India', 'asone_app/flags/in.png', 'ind', 0, 0),
(104, 'Indonesia', 'asone_app/flags/id.png', 'idn', 0, 0),
(105, 'Iran, Islamic Republic of', 'asone_app/flags/ir.png', 'irn', 0, 0),
(106, 'Iraq', 'asone_app/flags/iq.png', 'irq', 0, 0),
(107, 'Ireland', 'asone_app/flags/ie.png', 'irl', 0, 0),
(108, 'Isle of Man', 'asone_app/flags/im.png', 'imn', 0, 0),
(109, 'Israel', 'asone_app/flags/il.png', 'isr', 0, 0),
(110, 'Italy', 'asone_app/flags/it.png', 'ita', 0, 0),
(111, 'Jamaica', 'asone_app/flags/jm.png', 'jam', 0, 0),
(112, 'Japan', 'asone_app/flags/jp.png', 'jpn', 0, 0),
(113, 'Jersey', 'asone_app/flags/je.png', 'jey', 0, 0),
(114, 'Jordan', 'asone_app/flags/jo.png', 'jor', 0, 0),
(115, 'Kazakhstan', 'asone_app/flags/kz.png', 'kaz', 0, 0),
(116, 'Kenya', 'asone_app/flags/ke.png', 'ken', 0, 0),
(117, 'Kiribati', 'asone_app/flags/ki.png', 'kir', 0, 0),
(118, 'Korea, Democratic People\'s Republic of', 'asone_app/flags/kp.png', 'prk', 0, 0),
(119, 'Korea, Republic of', 'asone_app/flags/kr.png', 'kor', 0, 0),
(120, 'Kuwait', 'asone_app/flags/kw.png', 'kwt', 0, 0),
(121, 'Kyrgyzstan', 'asone_app/flags/kg.png', 'kgz', 0, 0),
(122, 'Lao People\'s Democratic Republic', 'asone_app/flags/la.png', 'lao', 0, 0),
(123, 'Latvia', 'asone_app/flags/lv.png', 'lva', 0, 0),
(124, 'Lebanon', 'asone_app/flags/lb.png', 'lbn', 0, 0),
(125, 'Lesotho', 'asone_app/flags/ls.png', 'lso', 0, 0),
(126, 'Liberia', 'asone_app/flags/lr.png', 'lbr', 0, 0),
(127, 'Libyan Arab Jamahiriya', 'asone_app/flags/ly.png', 'lby', 0, 0),
(128, 'Liechtenstein', 'asone_app/flags/li.png', 'lie', 0, 0),
(129, 'Lithuania', 'asone_app/flags/lt.png', 'ltu', 0, 0),
(130, 'Luxembourg', 'asone_app/flags/lu.png', 'lux', 0, 0),
(131, 'Macao', 'asone_app/flags/mo.png', 'mac', 0, 0),
(132, 'Macedonia, The former Yugoslav Republic of', 'asone_app/flags/mk.png', 'mkd', 0, 0),
(133, 'Madagascar', 'asone_app/flags/mg.png', 'mdg', 0, 0),
(134, 'Malawi', 'asone_app/flags/mw.png', 'mwi', 0, 0),
(135, 'Malaysia', 'asone_app/flags/my.png', 'mys', 0, 0),
(136, 'Maldives', 'asone_app/flags/mv.png', 'mdv', 0, 0),
(137, 'Mali', 'asone_app/flags/ml.png', 'mli', 0, 0),
(138, 'Malta', 'asone_app/flags/mt.png', 'mlt', 0, 0),
(139, 'Marshall Islands', 'asone_app/flags/mh.png', 'mhl', 0, 0),
(140, 'Martinique', 'asone_app/flags/mq.png', 'mtq', 0, 0),
(141, 'Mauritania', 'asone_app/flags/mr.png', 'mrt', 0, 0),
(142, 'Mauritius', 'asone_app/flags/mu.png', 'mus', 0, 0),
(143, 'Mayotte', 'asone_app/flags/yt.png', 'myt', 0, 0),
(144, 'Mexico', 'asone_app/flags/mx.png', 'mex', 0, 0),
(145, 'Micronesia, Federated States of', 'asone_app/flags/fm.png', 'fsm', 0, 0),
(146, 'Moldova, Republic of', 'asone_app/flags/md.png', 'mda', 0, 0),
(147, 'Monaco', 'asone_app/flags/mc.png', 'mco', 0, 0),
(148, 'Mongolia', 'asone_app/flags/mn.png', 'mng', 0, 0),
(149, 'Montenegro', 'asone_app/flags/me.png', 'mne', 0, 0),
(150, 'Montserrat', 'asone_app/flags/ms.png', 'msr', 0, 0),
(151, 'Morocco', 'asone_app/flags/ma.png', 'mar', 0, 0),
(152, 'Mozambique', 'asone_app/flags/mz.png', 'moz', 0, 0),
(153, 'Myanmar', 'asone_app/flags/mm.png', 'mmr', 0, 0),
(154, 'Namibia', 'asone_app/flags/na.png', 'nam', 0, 0),
(155, 'Nauru', 'asone_app/flags/nr.png', 'nru', 0, 0),
(156, 'Nepal', 'asone_app/flags/np.png', 'npl', 0, 0),
(157, 'Netherlands', 'asone_app/flags/nl.png', 'nld', 0, 0),
(158, 'New Caledonia', 'asone_app/flags/nc.png', 'ncl', 0, 0),
(159, 'New Zealand', 'asone_app/flags/nz.png', 'nzl', 0, 0),
(160, 'Nicaragua', 'asone_app/flags/ni.png', 'nic', 0, 0),
(161, 'Niger', 'asone_app/flags/ne.png', 'ner', 0, 0),
(162, 'Nigeria', 'asone_app/flags/ng.png', 'nga', 0, 0),
(163, 'Niue', 'asone_app/flags/nu.png', 'niu', 0, 0),
(164, 'Norfolk Island', 'asone_app/flags/nf.png', 'nfk', 0, 0),
(165, 'Northern Mariana Islands', 'asone_app/flags/mp.png', 'mnp', 0, 0),
(166, 'Norway', 'asone_app/flags/no.png', 'nor', 0, 0),
(167, 'Oman', 'asone_app/flags/om.png', 'omn', 0, 0),
(168, 'Pakistan', 'asone_app/flags/pk.png', 'pak', 0, 0),
(169, 'Palau', 'asone_app/flags/pw.png', 'plw', 0, 0),
(170, 'Palestinian Territory, Occupied', 'asone_app/flags/ps.png', 'pse', 0, 0),
(171, 'Panama', 'asone_app/flags/pa.png', 'pan', 0, 0),
(172, 'Papua New Guinea', 'asone_app/flags/pg.png', 'png', 0, 0),
(173, 'Paraguay', 'asone_app/flags/py.png', 'pry', 0, 0),
(174, 'Peru', 'asone_app/flags/pe.png', 'per', 0, 0),
(175, 'Philippines', 'asone_app/flags/ph.png', 'phl', 0, 0),
(176, 'Pitcairn', 'asone_app/flags/pn.png', 'pcn', 0, 0),
(177, 'Poland', 'asone_app/flags/pl.png', 'pol', 0, 0),
(178, 'Portugal', 'asone_app/flags/pt.png', 'prt', 0, 0),
(179, 'Puerto Rico', 'asone_app/flags/pr.png', 'pri', 0, 0),
(180, 'Qatar', 'asone_app/flags/qa.png', 'qat', 0, 0),
(181, 'Reunion', 'asone_app/flags/re.png', 'reu', 0, 0),
(182, 'Romania', 'asone_app/flags/ro.png', 'rou', 0, 0),
(183, 'Russian Federation', 'asone_app/flags/ru.png', 'rus', 0, 0),
(184, 'Rwanda', 'asone_app/flags/rw.png', 'rwa', 0, 0),
(185, 'Saint Barthelemy', 'asone_app/flags/bl.png', 'blm', 0, 0),
(186, 'Saint Helena, Ascension and Tristan Da Cunha', 'asone_app/flags/sh.png', 'shn', 0, 0),
(187, 'Saint Kitts and Nevis', 'asone_app/flags/kn.png', 'kna', 0, 0),
(188, 'Saint Lucia', 'asone_app/flags/lc.png', 'lca', 0, 0),
(189, 'Saint Martin (French Part)', 'asone_app/flags/mf.png', 'maf', 0, 0),
(190, 'Saint Pierre and Miquelon', 'asone_app/flags/pm.png', 'spm', 0, 0),
(191, 'Saint Vincent and The Grenadines', 'asone_app/flags/vc.png', 'vct', 0, 0),
(192, 'Samoa', 'asone_app/flags/ws.png', 'wsm', 0, 0),
(193, 'San Marino', 'asone_app/flags/sm.png', 'smr', 0, 0),
(194, 'Sao Tome and Principe', 'asone_app/flags/st.png', 'stp', 0, 0),
(195, 'Saudi Arabia', 'asone_app/flags/sa.png', 'sau', 0, 0),
(196, 'Senegal', 'asone_app/flags/sn.png', 'sen', 0, 0),
(197, 'Serbia', 'asone_app/flags/rs.png', 'srb', 0, 0),
(198, 'Seychelles', 'asone_app/flags/sc.png', 'syc', 0, 0),
(199, 'Sierra Leone', 'asone_app/flags/sl.png', 'sle', 0, 0),
(200, 'Singapore', 'asone_app/flags/sg.png', 'sgp', 0, 0),
(201, 'Sint Maarten (Dutch Part)', 'asone_app/flags/sx.png', 'sxm', 0, 0),
(202, 'Slovakia', 'asone_app/flags/sk.png', 'svk', 0, 0),
(203, 'Slovenia', 'asone_app/flags/si.png', 'svn', 0, 0),
(204, 'Solomon Islands', 'asone_app/flags/sb.png', 'slb', 0, 0),
(205, 'Somalia', 'asone_app/flags/so.png', 'som', 0, 0),
(206, 'South Africa', 'asone_app/flags/za.png', 'zaf', 0, 0),
(207, 'South Georgia and The South Sandwich Islands', 'asone_app/flags/gs.png', '', 0, 0),
(208, 'South Sudan', 'asone_app/flags/ss.png', 'ssd', 0, 0),
(209, 'Spain', 'asone_app/flags/es.png', 'esp', 0, 0),
(210, 'Sri Lanka', 'asone_app/flags/lk.png', 'lka', 0, 0),
(211, 'Sudan', 'asone_app/flags/sd.png', 'sdn', 0, 0),
(212, 'Suriname', 'asone_app/flags/sr.png', 'sur', 0, 0),
(213, 'Svalbard and Jan Mayen', 'asone_app/flags/sj.png', 'sjm', 0, 0),
(214, 'Swaziland', 'asone_app/flags/sz.png', 'swz', 0, 0),
(215, 'Sweden', 'asone_app/flags/se.png', 'swe', 0, 0),
(216, 'Switzerland', 'asone_app/flags/ch.png', 'che', 0, 0),
(217, 'Syrian Arab Republic', 'asone_app/flags/sy.png', 'syr', 0, 0),
(218, 'Taiwan, Province of China', 'asone_app/flags/tw.png', '', 0, 0),
(219, 'Tajikistan', 'asone_app/flags/tj.png', 'tjk', 0, 0),
(220, 'Tanzania, United Republic of', 'asone_app/flags/tz.png', 'tza', 0, 0),
(221, 'Thailand', 'asone_app/flags/th.png', 'tha', 0, 0),
(222, 'Timor-Leste', 'asone_app/flags/tl.png', 'tls', 0, 0),
(223, 'Togo', 'asone_app/flags/tg.png', 'tgo', 0, 0),
(224, 'Tokelau', 'asone_app/flags/tk.png', 'tkl', 0, 0),
(225, 'Tonga', 'asone_app/flags/to.png', 'ton', 0, 0),
(226, 'Trinidad and Tobago', 'asone_app/flags/tt.png', 'tto', 0, 0),
(227, 'Tunisia', 'asone_app/flags/tn.png', 'tun', 0, 0),
(228, 'Turkey', 'asone_app/flags/tr.png', 'tur', 0, 0),
(229, 'Turkmenistan', 'asone_app/flags/tm.png', 'tkm', 0, 0),
(230, 'Turks and Caicos Islands', 'asone_app/flags/tc.png', 'tca', 0, 0),
(231, 'Tuvalu', 'asone_app/flags/tv.png', 'tuv', 0, 0),
(232, 'Uganda', 'asone_app/flags/ug.png', 'uga', 0, 0),
(233, 'Ukraine', 'asone_app/flags/ua.png', 'ukr', 0, 0),
(234, 'United Arab Emirates', 'asone_app/flags/ae.png', 'are', 0, 0),
(235, 'United Kingdom', 'asone_app/flags/gb.png', 'gbr', 0, 0),
(236, 'United States', 'asone_app/flags/us.png', 'usa', 0, 0),
(237, 'United States Minor Outlying Islands', 'asone_app/flags/um.png', '', 0, 0),
(238, 'Uruguay', 'asone_app/flags/uy.png', 'ury', 0, 0),
(239, 'Uzbekistan', 'asone_app/flags/uz.png', 'uzb', 0, 0),
(240, 'Vanuatu', 'asone_app/flags/vu.png', 'vut', 0, 0),
(241, 'Venezuela, Bolivarian Republic of', 'asone_app/flags/ve.png', 'ven', 0, 0),
(242, 'Viet Nam', 'asone_app/flags/vn.png', 'vnm', 0, 0),
(243, 'Virgin Islands, British', 'asone_app/flags/vg.png', 'vgb', 0, 0),
(244, 'Virgin Islands, U.S.', 'asone_app/flags/vi.png', 'vir', 0, 0),
(245, 'Wallis and Futuna', 'asone_app/flags/wf.png', 'wlf', 0, 0),
(246, 'Western Sahara', 'asone_app/flags/eh.png', 'esh', 0, 0),
(247, 'Yemen', 'asone_app/flags/ye.png', 'yem', 0, 0),
(248, 'Zambia', 'asone_app/flags/zm.png', 'zmb', 0, 0),
(249, 'Zimbabwe', 'asone_app/flags/zw.png', 'zwe', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `post_image` varchar(255) NOT NULL,
  `like` int(11) NOT NULL,
  `coment` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prayer_comment`
--

CREATE TABLE `prayer_comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prayer_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prayer_comment`
--

INSERT INTO `prayer_comment` (`id`, `user_id`, `prayer_id`, `comment`, `time`) VALUES
(1, 1, 1, ' ansnbsjs', '2016-11-28 13:32:11'),
(2, 1, 9, 'mhgchgchgc', '2017-04-20 14:36:54'),
(3, 1, 9, 'ugfhgc', '2017-04-20 14:36:56');

-- --------------------------------------------------------

--
-- Table structure for table `prayer_like`
--

CREATE TABLE `prayer_like` (
  `p_like_id` int(11) NOT NULL,
  `prayer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prayer_like`
--

INSERT INTO `prayer_like` (`p_like_id`, `prayer_id`, `user_id`) VALUES
(13, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `recent_chat`
--

CREATE TABLE `recent_chat` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `opp_id` int(11) NOT NULL,
  `s_msg` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recent_chat`
--

INSERT INTO `recent_chat` (`id`, `user_id`, `opp_id`, `s_msg`, `time`) VALUES
(1, 1, 2, 'dsfdsf', '2016-12-19 08:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `user_id` int(11) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `nationality_id` int(11) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `date_birthday` date NOT NULL,
  `vocation` varchar(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `l_code` varchar(10) NOT NULL,
  `flag` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `device_type` int(11) NOT NULL,
  `push_res` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`user_id`, `nickname`, `username`, `password`, `nationality`, `nationality_id`, `gender`, `profile_image`, `date_birthday`, `vocation`, `language`, `l_code`, `flag`, `status`, `device_id`, `device_type`, `push_res`) VALUES
(1, 'Harry', 'a@a.com', '1234567', 'Aland Islands', 2, 'Male', 'asone_app/uploads/2017-04-110_20:04:90.jpeg', '0000-00-00', 'Businessman', 'Punjabi', 'PA', 'asone_app/flags/ax.png', 1, '', 0, 1),
(2, 'Manish', 'a@aa.com', '1234567', 'Macao', 131, 'Male', 'asone_app/uploads/temp.jpg', '0000-00-00', 'Software Engineer', 'Arabic', 'AR', 'asone_app/flags/mo.png', 1, '', 0, 1),
(3, 'Guppy', 'jsl@gmail.com', '1234567', 'Macao', 131, 'Male', 'asone_app/uploads/temp.jpg', '0000-00-00', 'Software Engineer', 'Arabic', 'AR', 'asone_app/flags/mo.png', 1, '', 0, 1),
(4, 'Eweb', 'test75741@gmail.com', '123456', 'Algeria', 4, 'Male', 'asone_app/uploads/1470125633jz.jpg', '2016-08-02', 'Software Engineer', 'Arabic', 'AR', 'asone_app/flags/dz.png', 1, 'jghcjgdhixcgisz', 2, 1),
(5, 'harry', 'harry@gmail.com', '123456', 'Albania', 3, 'Male', 'asone_app/uploads/1470125818ba.jpg', '0000-00-00', 'Managing Director', 'Albanian', 'SQ', 'asone_app/flags/al.png', 1, 'jghcjgdhixcgisz', 2, 1),
(6, 'geetikakaushak', 'geetikakaushak1994@GMAIL.COM', '12345678', 'India', 103, 'Female', '', '0000-00-00', 'Software Engineer', 'English', 'EN', 'asone_app/flags/in.png', 0, 'jghcjgdhixcgisz', 2, 1),
(7, 'abc', 'sarveshnew331@gmail.com', 'Lovegod@12', 'Albania', 3, 'male', 'asone_app/uploads/1479877490133.jpg', '0006-03-15', 'Gym Trainer', 'Albanian', 'SQ', 'asone_app/flags/al.png', 1, '', 0, 1),
(8, 'rahul', 'malhotrarhul392@gmail.com', '12345678', 'Albania', 3, 'Male', 'asone_app/uploads/20170127_175217.jpg', '0006-03-15', 'Software Engineer', 'Arabic', 'AR', 'asone_app/flags/al.png', 1, '', 0, 1),
(9, 'Poyo', 'testdemo198@gmail.com', '123456', 'Afghanistan', 1, 'male', 'asone_app/uploads/1490249301oe.jpg', '2017-03-21', 'Businessman', 'Afrikanns', 'AF', 'asone_app/flags/af.png', 1, 'jghcjgdhixcgisz', 2, 1),
(10, 'hhhh', 'hhh@gmail.com', 'qwertyu', 'Aland Islands', 2, 'Male', '', '2010-09-14', 'Gym Trainer', 'Afrikanns', 'AF', 'asone_app/flags/ax.png', 1, 'jghcjgdhixcgisz', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `select_language`
--

CREATE TABLE `select_language` (
  `id` int(11) NOT NULL,
  `language` varchar(50) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `select_language`
--

INSERT INTO `select_language` (`id`, `language`, `code`) VALUES
(1, 'Afrikanns', 'AF'),
(2, 'Albanian', 'SQ'),
(3, 'Arabic', 'AR'),
(4, 'Armenian', 'HY'),
(5, 'Basque', 'EU'),
(6, 'Bengali', 'BN'),
(7, 'Bulgarian', 'BG'),
(8, 'Catalan', 'CA'),
(9, 'Cambodian', 'KM'),
(10, 'Chinese (Mandarin)', 'ZH'),
(11, 'Croation', 'HR'),
(12, 'Czech', 'CS'),
(13, 'Danish', 'DA'),
(14, 'Dutch', 'NL'),
(15, 'English', 'EN'),
(16, 'Estonian', 'ET'),
(17, 'Fiji', 'FJ'),
(18, 'Finnish', 'FI'),
(19, 'French', 'FR'),
(20, 'Georgian', 'KA'),
(21, 'German', 'DE'),
(22, 'Greek', 'EL'),
(23, 'Gujarati', 'GU'),
(24, 'Hebrew', 'HE'),
(25, 'Hindi', 'HI'),
(26, 'Hungarian', 'HU'),
(27, 'Icelandic', 'IS'),
(28, 'Indonesian', 'ID'),
(29, 'Irish', 'GA'),
(30, 'Italian', 'IT'),
(31, 'Japanese', 'JA'),
(32, 'Javanese', 'JW'),
(33, 'Korean', 'KO'),
(34, 'Latin', 'LA'),
(35, 'Latvian', 'LV'),
(36, 'Lithuanian', 'LT'),
(37, 'Macedonian', 'MK'),
(38, 'Malay', 'MS'),
(39, 'Malayalam', 'ML'),
(40, 'Maltese', 'MT'),
(41, 'Maori', 'MI'),
(42, 'Marathi', 'MR'),
(43, 'Mongolian', 'MN'),
(44, 'Nepali', 'NE'),
(45, 'Norwegian', 'NO'),
(46, 'Persian', 'FA'),
(47, 'Polish', 'PL'),
(48, 'Portuguese', 'PT'),
(49, 'Punjabi', 'PA'),
(50, 'Quechua', 'QU'),
(51, 'Romanian', 'RO'),
(52, 'Russian', 'RU'),
(53, 'Samoan', 'SM'),
(54, 'Serbian', 'SR'),
(55, 'Slovak', 'SK'),
(56, 'Slovenian', 'SL'),
(57, 'Spanish', 'ES'),
(58, 'Swahili', 'SW'),
(59, 'Swedish ', 'SV'),
(60, 'Tamil', 'TA'),
(61, 'Tatar', 'TT'),
(62, 'Telugu', 'TE'),
(63, 'Thai', 'TH'),
(64, 'Tibetan', 'BO'),
(65, 'Tonga', 'TO'),
(66, 'Turkish', 'TR'),
(67, 'Ukranian', 'UK'),
(68, 'Urdu', 'UR'),
(69, 'Uzbek', 'UZ'),
(70, 'Vietnamese', 'VI'),
(71, 'Welsh', 'CY'),
(72, 'Xhosa', 'XH');

-- --------------------------------------------------------

--
-- Table structure for table `user_vocations`
--

CREATE TABLE `user_vocations` (
  `id` int(11) NOT NULL,
  `vocation_name` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vacation`
--

CREATE TABLE `vacation` (
  `v_id` int(11) NOT NULL,
  `vacation` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `added_by` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vacation`
--

INSERT INTO `vacation` (`v_id`, `vacation`, `user_id`, `added_by`) VALUES
(53, 'Businessman', 0, '0'),
(54, 'Gym Trainer', 0, '0'),
(55, 'Software Engineer', 0, '0'),
(56, 'telecom Engineer', 0, '0'),
(57, 'Network Engineer', 0, '0'),
(58, 'CEO', 0, '0'),
(59, 'Managing Director', 0, '0'),
(60, 'Health Minister', 0, '0'),
(61, 'Iterant Minister', 0, '0'),
(62, 'Director', 0, '0'),
(63, 'tester', 0, '0'),
(64, 'lecturer', 0, '0'),
(65, 'music teacher', 2, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_prayer`
--
ALTER TABLE `add_prayer`
  ADD PRIMARY KEY (`pr_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_conversation`
--
ALTER TABLE `chat_conversation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feeds_m`
--
ALTER TABLE `feeds_m`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers_by_uid`
--
ALTER TABLE `followers_by_uid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `following_by_uid`
--
ALTER TABLE `following_by_uid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `gnews_comment`
--
ALTER TABLE `gnews_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goodnews`
--
ALTER TABLE `goodnews`
  ADD PRIMARY KEY (`gnews_id`);

--
-- Indexes for table `goodnews_like`
--
ALTER TABLE `goodnews_like`
  ADD PRIMARY KEY (`gl_id`);

--
-- Indexes for table `nationality`
--
ALTER TABLE `nationality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prayer_comment`
--
ALTER TABLE `prayer_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prayer_like`
--
ALTER TABLE `prayer_like`
  ADD PRIMARY KEY (`p_like_id`);

--
-- Indexes for table `recent_chat`
--
ALTER TABLE `recent_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `select_language`
--
ALTER TABLE `select_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacation`
--
ALTER TABLE `vacation`
  ADD PRIMARY KEY (`v_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_prayer`
--
ALTER TABLE `add_prayer`
  MODIFY `pr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `chat_conversation`
--
ALTER TABLE `chat_conversation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `feeds_m`
--
ALTER TABLE `feeds_m`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `followers_by_uid`
--
ALTER TABLE `followers_by_uid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `following_by_uid`
--
ALTER TABLE `following_by_uid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `gnews_comment`
--
ALTER TABLE `gnews_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `goodnews`
--
ALTER TABLE `goodnews`
  MODIFY `gnews_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `goodnews_like`
--
ALTER TABLE `goodnews_like`
  MODIFY `gl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nationality`
--
ALTER TABLE `nationality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prayer_comment`
--
ALTER TABLE `prayer_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `prayer_like`
--
ALTER TABLE `prayer_like`
  MODIFY `p_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `recent_chat`
--
ALTER TABLE `recent_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `select_language`
--
ALTER TABLE `select_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `vacation`
--
ALTER TABLE `vacation`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
