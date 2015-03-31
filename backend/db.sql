SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hole`
--

-- --------------------------------------------------------

--
-- Table structure for table `holes`
--

CREATE TABLE IF NOT EXISTS `holes` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `title` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `address` varchar(64) NOT NULL,
  `zone` varchar(64) NOT NULL,
  `size` tinyint(1) NOT NULL,
  `photo` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `holes`
--

INSERT INTO `holes` (`id`, `lat`, `lng`, `title`, `content`, `address`, `zone`, `size`, `photo`, `ip`, `public`) VALUES
(1, -32.941761, -60.687870, 'Crazy loco', 'The Doctrine provider can allow access to multiple databases.', 'Marcos Paz 4600', 'Echesortu', 2, 0, '', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
