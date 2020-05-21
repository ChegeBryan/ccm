SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `id13529731_ccmsys` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `id13529731_ccmsys`;

CREATE TABLE `ccm_admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

INSERT INTO `ccm_admins` (`id`, `username`, `password`) VALUES
(1, 'admin001', '$2y$10$UwOHw.V2QO8vaI7pfYTbc.UkUMgrgF3algALFMIypG/S/c8cf6xRe');

CREATE TABLE `ccm_advisors` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approved` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

INSERT INTO `ccm_advisors` (`id`, `fullname`, `username`, `password`, `approved`) VALUES
(1, 'Chege Bryan', 'admin001', '$2y$10$z/WmUq0h8.NGPW4tNta95upbqpsJwnJ0vhZ813qvfJk.11PcfdmYS', 1),
(2, 'Chege Bryan', 'advisor001', '$2y$10$x80.bRxhlvzyK8jS968aF.Y84UnqYcLZQZVuqFiwqSStsmlQCZ7oe', 1);

CREATE TABLE `ccm_alerts` (
  `id` int(11) NOT NULL,
  `made_by` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `made_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE `ccm_appointments` (
  `id` int(11) NOT NULL,
  `made_by` int(11) NOT NULL,
  `farm_input` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `pick_date` datetime NOT NULL,
  `made_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed_on` datetime NOT NULL,
  `confirmed` int(1) NOT NULL DEFAULT '0',
  `paid` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE `ccm_bookings` (
  `id` int(11) NOT NULL,
  `booked_by` int(11) NOT NULL,
  `product_to_deliver` int(11) NOT NULL,
  `quantity_to_deliver` float NOT NULL,
  `date_booked` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delivery_date` date NOT NULL,
  `approved_on` datetime NOT NULL,
  `approved` int(1) NOT NULL DEFAULT '0',
  `paid` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

INSERT INTO `ccm_bookings` (`id`, `booked_by`, `product_to_deliver`, `quantity_to_deliver`, `date_booked`, `delivery_date`, `approved_on`, `approved`, `paid`) VALUES
(1, 1, 1, 23, '2020-05-21 19:44:55', '2020-05-22', '0000-00-00 00:00:00', 0, 0);

CREATE TABLE `ccm_cereals` (
  `id` int(11) NOT NULL,
  `grain` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

INSERT INTO `ccm_cereals` (`id`, `grain`) VALUES
(1, 'Maize'),
(2, 'Beans'),
(3, 'Wheat'),
(4, 'Sorghum'),
(5, 'Millet'),
(6, 'Rice');

CREATE TABLE `ccm_complaints` (
  `id` int(11) NOT NULL,
  `raised_by` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `made_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `handled` int(1) NOT NULL DEFAULT '0',
  `handled_by` int(11) DEFAULT NULL,
  `handled_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

INSERT INTO `ccm_complaints` (`id`, `raised_by`, `subject`, `message`, `made_on`, `handled`, `handled_by`, `handled_on`) VALUES
(1, 1, 'Water is bad', 'asasdsdasda', '2020-05-21 19:33:08', 0, NULL, NULL);

CREATE TABLE `ccm_counties` (
  `id` int(11) NOT NULL,
  `county` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

INSERT INTO `ccm_counties` (`id`, `county`) VALUES
(1, 'Mombasa'),
(2, 'ER');

CREATE TABLE `ccm_farmers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(64) NOT NULL,
  `national_id` int(64) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `email` varchar(64) NOT NULL,
  `location` int(11) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approved` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

INSERT INTO `ccm_farmers` (`id`, `fullname`, `username`, `national_id`, `mobile_number`, `email`, `location`, `pic`, `password`, `approved`) VALUES
(1, 'ryan029', 'farmer001', 1234123121, '+254719841421', 'cbbryan8@gmail.com', 1, '../profileImages/profileDefault.png', '$2y$10$mQYrcEGEF2jn380d3RGMjOTlBtw8nj8gR9lH0UAIGMG0iCMz3E6bq', 1);

CREATE TABLE `ccm_farm_inputs` (
  `id` int(11) NOT NULL,
  `farm_input` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

INSERT INTO `ccm_farm_inputs` (`id`, `farm_input`) VALUES
(1, 'Planting Fertilizer'),
(2, 'Top-Dressing Fertilizer');

CREATE TABLE `ccm_farm_input_payments` (
  `id` int(11) NOT NULL,
  `paying_for` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `amount` int(64) NOT NULL,
  `mode_of_payment` varchar(64) NOT NULL,
  `paid_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE `ccm_farm_produce_payments` (
  `id` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `paying_for` int(11) NOT NULL,
  `amount` int(64) NOT NULL,
  `mode_of_payment` varchar(64) NOT NULL,
  `paid_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE `ccm_land` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `land_size` float NOT NULL,
  `cereal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

INSERT INTO `ccm_land` (`id`, `owner`, `land_size`, `cereal`) VALUES
(1, 1, -1, 2),
(2, 1, -344, 2),
(3, 1, -3343, 2),
(4, 1, -34, 1);

CREATE TABLE `ccm_messages` (
  `id` int(11) NOT NULL,
  `asked_by` int(11) NOT NULL,
  `message` text NOT NULL,
  `asked_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `replied` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

INSERT INTO `ccm_messages` (`id`, `asked_by`, `message`, `asked_on`, `replied`) VALUES
(1, 1, 'aassdsdfds dfdfsdf sdfsd sdfsdfsdf', '2020-05-21 19:35:08', 0);

CREATE TABLE `ccm_replies` (
  `id` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `replied_by` int(11) NOT NULL,
  `who_asked` int(11) NOT NULL,
  `reply` text NOT NULL,
  `replied_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE `ccm_staff` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approved` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;


ALTER TABLE `ccm_admins`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ccm_advisors`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ccm_alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `made_by_fk_id` (`made_by`);

ALTER TABLE `ccm_appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_by_fk_id` (`made_by`),
  ADD KEY `input_fk_id` (`farm_input`);

ALTER TABLE `ccm_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booked_by_fk` (`booked_by`),
  ADD KEY `grain_fk_id` (`product_to_deliver`);

ALTER TABLE `ccm_cereals`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ccm_complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `handler_fk_id` (`handled_by`),
  ADD KEY `rasier_fk_id` (`raised_by`);

ALTER TABLE `ccm_counties`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ccm_farmers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `county_fk_id` (`location`);

ALTER TABLE `ccm_farm_inputs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ccm_farm_input_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `picked_fk_id` (`paying_for`),
  ADD KEY `staff_fk_id` (`staff`);

ALTER TABLE `ccm_farm_produce_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff__fk_id` (`staff`),
  ADD KEY `booking_fk_id` (`paying_for`);

ALTER TABLE `ccm_land`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id_fk` (`owner`),
  ADD KEY `cereal_id_fk` (`cereal`);

ALTER TABLE `ccm_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asked_fk_id` (`asked_by`);

ALTER TABLE `ccm_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_fk_id` (`question`),
  ADD KEY `advisor_fk_id` (`replied_by`),
  ADD KEY `who_asked_fk` (`who_asked`);

ALTER TABLE `ccm_staff`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ccm_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `ccm_advisors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `ccm_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ccm_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ccm_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `ccm_cereals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `ccm_complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `ccm_counties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `ccm_farmers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `ccm_farm_inputs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `ccm_farm_input_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ccm_farm_produce_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ccm_land`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `ccm_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `ccm_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ccm_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `ccm_alerts`
  ADD CONSTRAINT `made_by_fk_id` FOREIGN KEY (`made_by`) REFERENCES `ccm_advisors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ccm_appointments`
  ADD CONSTRAINT `input_fk_id` FOREIGN KEY (`farm_input`) REFERENCES `ccm_farm_inputs` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `request_by_fk_id` FOREIGN KEY (`made_by`) REFERENCES `ccm_farmers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ccm_bookings`
  ADD CONSTRAINT `booked_by_fk` FOREIGN KEY (`booked_by`) REFERENCES `ccm_farmers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grain_fk_id` FOREIGN KEY (`product_to_deliver`) REFERENCES `ccm_cereals` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `ccm_complaints`
  ADD CONSTRAINT `handler_fk_id` FOREIGN KEY (`handled_by`) REFERENCES `ccm_advisors` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rasier_fk_id` FOREIGN KEY (`raised_by`) REFERENCES `ccm_farmers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ccm_farmers`
  ADD CONSTRAINT `county_fk_id` FOREIGN KEY (`location`) REFERENCES `ccm_counties` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `ccm_farm_input_payments`
  ADD CONSTRAINT `picked_fk_id` FOREIGN KEY (`paying_for`) REFERENCES `ccm_appointments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_fk_id` FOREIGN KEY (`staff`) REFERENCES `ccm_staff` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `ccm_farm_produce_payments`
  ADD CONSTRAINT `booking_fk_id` FOREIGN KEY (`paying_for`) REFERENCES `ccm_bookings` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff__fk_id` FOREIGN KEY (`staff`) REFERENCES `ccm_staff` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `ccm_land`
  ADD CONSTRAINT `cereal_id_fk` FOREIGN KEY (`cereal`) REFERENCES `ccm_cereals` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `owner_id_fk` FOREIGN KEY (`owner`) REFERENCES `ccm_farmers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ccm_messages`
  ADD CONSTRAINT `asked_fk_id` FOREIGN KEY (`asked_by`) REFERENCES `ccm_farmers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ccm_replies`
  ADD CONSTRAINT `advisor_fk_id` FOREIGN KEY (`replied_by`) REFERENCES `ccm_advisors` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `question_fk_id` FOREIGN KEY (`question`) REFERENCES `ccm_messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `who_asked_fk` FOREIGN KEY (`who_asked`) REFERENCES `ccm_messages` (`asked_by`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
