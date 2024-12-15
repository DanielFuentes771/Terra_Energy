DELIMITER $$
DROP PROCEDURE IF EXISTS `CreateTarea`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateTarea` (IN `nombre_tarea` VARCHAR(255))   
BEGIN
    INSERT INTO tareas (task_name) VALUES (nombre_tarea);
END$$

DROP PROCEDURE IF EXISTS `DeleteTarea`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteTarea` (IN `tarea_id` INT)   
BEGIN
    DELETE FROM tareas WHERE id = tarea_id;
END$$

DROP PROCEDURE IF EXISTS `Tareas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Tareas` ()   
BEGIN
    SELECT * FROM tareas;
END$$

DROP PROCEDURE IF EXISTS `UnaTarea`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `UnaTarea` (IN `tarea_id` TEXT)   
BEGIN
    SELECT * FROM tareas WHERE tarea_id = '' OR id = tarea_id OR task_name LIKE CONCAT('%', tarea_id, '%');
END$$

DROP PROCEDURE IF EXISTS `UpdateTarea`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateTarea` (IN `tarea_id` INT, IN `nombre_tarea` VARCHAR(255))   
BEGIN
    UPDATE tareas SET task_name = nombre_tarea WHERE id = tarea_id;
END$$

DELIMITER ;

-- Estructura de tabla para la tabla `tareas`
DROP TABLE IF EXISTS `tareas`;
CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Índices para la tabla `tareas`
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT de la tabla `tareas`
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

COMMIT;