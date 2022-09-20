CREATE TABLE `table_property` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar (255) NOT NULL,
        `parent` int(11) NOT NULL DEFAULT 0,
        PRIMARY KEY (`id`),
        UNIQUE INDEX (`name`),
        KEY `created` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `table_property` (`id`, `name`, `parent`) VALUES (NULL, 'Building 1', '0'), (NULL, 'Building 2', '0');
INSERT INTO `table_property` (`id`, `name`, `parent`) VALUES (NULL, 'Building 3', '2'), (NULL, 'Parking Space 3', '3');
INSERT INTO `table_property` (`id`, `name`, `parent`) VALUES (NULL, 'Parking space 1', '2'), (NULL, 'Parking Space 8', '3');
INSERT INTO `table_property` (`id`, `name`, `parent`) VALUES (NULL, 'Shared parking space 1', '2'), (NULL, 'Parking space 4', '1');
