<?php
    class Model {
        protected $db;


        function __construct() {
            $this->db = $this->getConnection();
            $this->deploy();
        } //__construct


        private function getConnection() {
            return new PDO('mysql:host='. MYSQL_HOST .';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);
        } //getConnection
    

        function deploy() {
            // Chequear si hay tablas
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll(); // Nos devuelve todas las tablas de la db
            if(count($tables)==0) {
                // Si no hay crearlas
                $sql =<<<END
                    --
                    -- Base de datos: `w2_tpe_libros`
                    --

                    -- --------------------------------------------------------

                    --
                    -- Estructura de tabla para la tabla `autor`
                    --

                    CREATE TABLE `autor` (
                    `idautor` int(11) NOT NULL,
                    `nombre` varchar(45) NOT NULL,
                    `biografia` varchar(300) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                    --
                    -- Volcado de datos para la tabla `autor`
                    --

                    INSERT INTO `autor` (`idautor`, `nombre`, `biografia`) VALUES
                    (1, 'Aguinis, M', '(13 de enero de 1935, Río Cuarto) médico neurocirujano, psicoanalista y escritor argentino. '),
                    (2, 'Agustí, I', 'escritor, editor y periodista español. (3/9/1913, Llissá de Vall, España) Fallecimiento: 1974'),
                    (3, 'Alas Clarín, L', 'escritor y jurista español (25/4/1852, Zamora, España) Fallecimiento: 13 de junio de 1901, Oviedo, España'),
                    (4, 'Alcott, Louise M.', ''),
                    (5, 'Alexaindre, V', 'Nació, escribió un libro ... y se murió!!'),
                    (6, 'Allende, Isabel', ''),
                    (7, 'Chesterton, G.K.', ''),
                    (8, 'Christie, A.', ''),
                    (9, 'Chicot, M.', '');

                    -- --------------------------------------------------------

                    --
                    -- Estructura de tabla para la tabla `genero`
                    --

                    CREATE TABLE `genero` (
                    `idgenero` int(11) NOT NULL,
                    `genero` varchar(45) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                    --
                    -- Volcado de datos para la tabla `genero`
                    --

                    INSERT INTO `genero` (`idgenero`, `genero`) VALUES
                    (5, 'Thriller'),
                    (6, 'Narrativa'),
                    (7, 'Novela Realista'),
                    (8, 'Juvenil'),
                    (9, 'Fantástico'),
                    (10, 'Histórica'),
                    (11, 'Misterio'),
                    (12, 'Ciencia Ficción'),
                    (13, 'Clásico');

                    -- --------------------------------------------------------

                    --
                    -- Estructura de tabla para la tabla `libro`
                    --

                    CREATE TABLE `libro` (
                    `idlibro` int(11) NOT NULL,
                    `titulo` varchar(45) NOT NULL,
                    `idautor` int(11) NOT NULL,
                    `idgenero` int(11) NOT NULL,
                    `edicion` int(4) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                    --
                    -- Volcado de datos para la tabla `libro`
                    --

                    INSERT INTO `libro` (`idlibro`, `titulo`, `idautor`, `idgenero`, `edicion`) VALUES
                    (1, 'Asalto al paraíso', 1, 5, 2002),
                    (2, 'Mariona', 2, 6, 2001),
                    (3, 'La Regenta', 3, 7, 1994),
                    (4, 'Mujercitas', 4, 8, 2004),
                    (5, 'La destrucción o el amor', 5, 13, 1984),
                    (6, 'El reino del dragón de oro', 6, 9, 2016),
                    (7, 'El hombre que fue Jueves', 7, 13, 1984),
                    (8, 'El asesinato de Pitágoras', 9, 10, 2013),
                    (9, 'Asesinato en el Orient Expresss', 8, 11, 1987),
                    (10, 'Maldad bajo el sol', 8, 11, 1983),
                    (11, 'Lo que el viento se llevó', 7, 10, 1950);

                    -- --------------------------------------------------------

                    --
                    -- Estructura de tabla para la tabla `usuarios`
                    --

                    CREATE TABLE `usuarios` (
                    `idusuario` int(11) NOT NULL,
                    `nombreusuario` varchar(45) NOT NULL,
                    `passwordhash` varchar(255) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                    --
                    -- Volcado de datos para la tabla `usuarios`
                    --

                    INSERT INTO `usuarios` (`idusuario`, `nombreusuario`, `passwordhash`) VALUES
                    (1, 'webadmin', '$2y$10$67nxutfzKcvs8cLHyG1oAO5mEZ7W2hIxjl462m9HQ4IdqoqT88Wj.');

                    --
                    -- Índices para tablas volcadas
                    --

                    --
                    -- Indices de la tabla `autor`
                    --
                    ALTER TABLE `autor`
                    ADD PRIMARY KEY (`idautor`);

                    --
                    -- Indices de la tabla `genero`
                    --
                    ALTER TABLE `genero`
                    ADD PRIMARY KEY (`idgenero`);

                    --
                    -- Indices de la tabla `libro`
                    --
                    ALTER TABLE `libro`
                    ADD PRIMARY KEY (`idlibro`),
                    ADD KEY `idx_idautor` (`idautor`),
                    ADD KEY `idx_idgenero` (`idgenero`);

                    --
                    -- Indices de la tabla `usuarios`
                    --
                    ALTER TABLE `usuarios`
                    ADD PRIMARY KEY (`idusuario`);

                    --
                    -- AUTO_INCREMENT de las tablas volcadas
                    --

                    --
                    -- AUTO_INCREMENT de la tabla `autor`
                    --
                    ALTER TABLE `autor`
                    MODIFY `idautor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

                    --
                    -- AUTO_INCREMENT de la tabla `genero`
                    --
                    ALTER TABLE `genero`
                    MODIFY `idgenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

                    --
                    -- AUTO_INCREMENT de la tabla `libro`
                    --
                    ALTER TABLE `libro`
                    MODIFY `idlibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

                    --
                    -- AUTO_INCREMENT de la tabla `usuarios`
                    --
                    ALTER TABLE `usuarios`
                    MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

                    --
                    -- Restricciones para tablas volcadas
                    --

                    --
                    -- Filtros para la tabla `libro`
                    --
                    ALTER TABLE `libro`
                    ADD CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`idgenero`) REFERENCES `genero` (`idgenero`) ON UPDATE CASCADE,
                    ADD CONSTRAINT `libro_ibfk_2` FOREIGN KEY (`idautor`) REFERENCES `autor` (`idautor`) ON UPDATE CASCADE;
                    COMMIT;
                END;
                $this->db->query($sql);
            } // if            
        } // deploy

    } //  class Model
