DROP TABLE IF EXISTS `class_registered`;
CREATE TABLE `class_registered` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
