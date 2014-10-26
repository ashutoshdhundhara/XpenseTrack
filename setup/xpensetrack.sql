SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+05:30";

--
-- Database: `XpenseTrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `username` varchar(20) NOT NULL,
  `password` char(128) NOT NULL,
  `full_name` varchar(40) NOT NULL,
  `total_expenses` int(10) NOT NULL,
  `total_balance` int(10) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains Users details';

-- --------------------------------------------------------

--
-- Table structure for table `user_expenses`
--

CREATE TABLE `user_expenses` (
 `expense_id` int(20) NOT NULL AUTO_INCREMENT,
 `username` varchar(100) NOT NULL,
 `expense_type` varchar(50) NOT NULL,
 `expense_amount` varchar(50) NOT NULL,
 `expense_date` date NOT NULL,
 PRIMARY KEY (`expense_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains list of user expenses.';