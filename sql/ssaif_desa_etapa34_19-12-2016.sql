-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-12-2016 a las 13:05:41
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ssaif_desa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbarbitros`
--

CREATE TABLE IF NOT EXISTS `dbarbitros` (
  `idarbitro` int(11) NOT NULL AUTO_INCREMENT,
  `nombrecompleto` varchar(200) CHARACTER SET utf8 NOT NULL,
  `telefonoparticular` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonoceleluar` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonolaboral` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonofamiliar` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(130) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idarbitro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=895 ;

--
-- Volcado de datos para la tabla `dbarbitros`
--

INSERT INTO `dbarbitros` (`idarbitro`, `nombrecompleto`, `telefonoparticular`, `telefonoceleluar`, `telefonolaboral`, `telefonofamiliar`, `email`) VALUES
(1, 'Abal Diego', '4224-6057', '154-530-1996', '4224-6057', '', 'dhabal@uol.com.ar'),
(2, 'Abalo Oscar', '0221-4560522', '0221-155652149', '0221-4231750/1812  i', '', 'curlyman@hispavista.com'),
(3, 'Abeledo Casimiro', '4602-6280', '', '', '', ''),
(4, 'Abeledo Rodrigo', '4672-5461', '155-3473579', '4630-8476', '', 'abe_101@hotmail.com'),
(5, 'Acebal Carlos', '4291-3823/4286-7068', '156-4285875154-9790565', '4244-4639', '', ''),
(6, 'Acevedo Pablo Ezequiel', '4911-6870', '155-8308066', '5217-6265', '', 'pablo.e.acevedo@hotmail.com'),
(7, 'Acita Franco Matias', '4924-4202', '155-6225890', '4806-9905', '', 'francoacita@hotmail.com'),
(8, 'Acita Mario', '4924-4202', '154-4476740', '4806-9905', '', 'acitapropiedades@hotmail.com'),
(9, 'Acosta Marcelo Gabriel', '4221-0232', '153-5217001', '', '', 'afamarce@hotmail.com'),
(10, 'Alarcon Juan Carlos', '4295-1874', '154-4041916', '', '', 'al-arcon-jc@hotmail.com'),
(11, 'Albarenga Rodolfo', '02304-670887', '155-5667823', '', '', ''),
(12, 'Albornoz Diaz Alberto', '4922-0799', '154-428-6221', '', '', 'albornozdiaz@argentina.com'),
(13, 'Alfaro Enrique', '4295-7744', '', '', '', ''),
(14, 'Aliende Ivan Alfredo', '20649897', '156-2622545', '', '', 'aliendeivan@hotmail.com'),
(15, 'Alonso Martin Gonzalo', '4925-2632', '154-0252113', '4924-1742 int 218', '', 'madorra_arg@hotmail.com'),
(16, 'Altavista Mariano Andres', '0221-4869066', '0221-154084747', '', '', 'prediolaseleccion@hotmail.com'),
(17, 'Altavista Maximiliano Gaston', '0221-4861086', '0221-154654765', '0221-4711676', '', 'laseleccion@uol.com.ar'),
(18, 'Alvarez de Toledo Carlos', '4813-7466', '15-44355567', '', '', ''),
(19, 'Alvarez Diego Ariel', '', '153-0008939', '', '', 'diegoalvarez2@hotmail.com'),
(20, 'Alvarez Fernando', '4802-9006', '', '4983-0210', '', ''),
(21, 'Alvarez Luis', '', '155-1621799', '', '', 'lguillealvarez@yahoo.com.ar'),
(22, 'Alvarez Maximiliano Matias', '4753-2249', '155-4598148', '', '', 'maximalvarez_afa@hotmail.com'),
(23, 'Amato Antonio', '4912-3173', '156-7661919', '4918-8411 (padres)', '', 'amatoantonio019@yahoo.com.ar'),
(24, 'Amenta Dante Ariel', '02320-461836', '155-9273955', '4451-8136', '', 'romayrodante@hotmail.com'),
(25, 'Amorosino Fernando Sebastian', '4711-9545', '155-5275347', '4760-8016', '', 'feramorosino@hotmail.com'),
(26, 'Amurua German Ezequiel', '4250-9362', '155-7983351', '', '', 'germanquilmes1@hotmail.com'),
(27, 'Andrade Andres Sebastian', '4207-0906', '155-6980219', '', '', 'a_andrade79@hotmail.com'),
(28, 'Andrade Jorge', '4775-9318', '', '4319-1914/4428', '', ''),
(29, 'Antas Aguerrondo Carlos', '4701-5280', '154-4701131', '', '', ''),
(30, 'Apaza Gustavo', '4693-0187', '155-9728652', '4301-0700', '', 'gapaza@anlis.gov.ar'),
(31, 'Aragon Diego', '0220-4803057', '156-2921217', '', '', 'aragondiego4759@ciudad.com.ar'),
(32, 'Aranda Leonardo', '4288-1760', '153-5079471', '', '', 'leo10k@hotmail.com'),
(33, 'Arce Federico Javier', '4462-2397', '153-7725283', '', '', 'fede.arce@hotmail.com'),
(34, 'Arevalo Matias Ezequiel', '4626-0435', '156-0583369 (632*976)', '5077-5000', '', 'matiasafa@hotmail.com'),
(35, 'Argañaraz Ricardo Facundo', '', '156-6602151', '', '', 'facu.argañaraz@yahoo..com.ar'),
(36, 'Argañaraz Sergio', '02320-483777', '1565731501', '', '', 'sergioarganaraz@argentina.com'),
(37, 'Arias Alejandro', '4712-0873', '154-9918964', '', '', ''),
(38, 'Arias Marco Antonio', '4918-5399', '', '', '', 'marcoantonioarias2000@yahoo.com.ar'),
(39, 'Arin de Freitas Gonzalo Sebastian', '4256-8391', '153-0649585', '', '', 'arin_gonzalo@hotmail.com'),
(40, 'Arin de Freitas Rodrigo Enuel', '4256-8391', '156-5664920', '', '', 'rodrigoarin@hotmail.com'),
(41, 'Armesto Maximiliano Andres', '', '156-0584610', '', '', 'maxiarmesto@hotmail.com'),
(42, 'Avellaneda Sebastian Martin', '0341-4642858', '0341-156623540', '', '', 'sm_avellaneda@yahoo.com.ar'),
(43, 'Avila Daniel Alejandro', '', '153-0191465', '', '', 'ale_29_88@hotmail.com'),
(44, 'Azpiolea Marcelo', '4254-3117', '154-4290754', '4253-0234/1125', '', 'azpioleabest@aol.com'),
(45, 'Bais Marcelo Fabian', '4225-5214', '', '4302-3279/3286', '', 'baismarcelo@yahoo.com.ar'),
(46, 'Baldassi Hector', '4805-7847', '155-4590203', '', '', 'hbaldassi@hotmail.com'),
(47, 'Baldonado Miguel', '4297-3074', '155-8379288', '', '', 'baldonadoafa@yahoo.com.ar'),
(48, 'Baliner Patricio diego', '4628-9178', '156-0286149', '', '', 'pdb012@hotmail.com}'),
(49, 'Bambi Gustavo', '0237-4629826', '156-9110976', '', '', ''),
(50, 'Barbero Oscar', '4658-3590', '', '', '', ''),
(51, 'Barbieri Andres', '4553-2855', '156-8671979', '4553-2139', '', 'andresbarbieri@hotmail.co'),
(52, 'Barbieri Hugo', '4464-0602', '155-5041741', '4652-2410', '', ''),
(53, 'Baron Diego', '2051-8939', '152-4542333', '4605-4955/9506', '', 'diegobaron@rocketmail.com'),
(54, 'Barone Diego Martin', '0221-4259546', '0221-155379317 (671*2720)', '', '', 'diegobaron77@hotmail.com'),
(55, 'Barranco Jose Antonio', '', '03489-15564528', '', '', 'josebarranco2004@yahoo.com.ar'),
(56, 'Barraza Julio Cesar -Hijo', '4650-1252', '155-7526071 (656*5085)', '4555-0110/155-802436', '', 'juliocesarba@yahoo.com'),
(57, 'Barraza Julio -Padre', '4659-3890', '155-2475566', '', '', ''),
(58, 'Barraza Luis', '4659-8079', '155-3408537', '4654-6708', '', ''),
(59, 'Barrientos Alberto', '0237-483-0937', '155-2612571/57416234', '0237-4830772/0773', '', 'barryalberto@yahoo.com.ar'),
(60, 'Barrientos Julian', '', '156-6953113', '', '', 'julian_bar@hotmail.com'),
(61, 'Bassi Gustavo', '02346-430698', '02346-15689859', '', '', ''),
(62, 'Basso Leonel Matias', '4202-3127', '155-6076444', '6310-7100 int. 2067', '', 'matiasbasso87@gmail.com'),
(63, 'Battaglia Juan Pablo', '4652-2175', '156-8157877', '', '', 'juanpablobataglia@hotmail.com'),
(64, 'Bava Juan', '4743-8003', '15-44128119', '', '', ''),
(65, 'Beares Matias Sebastian', '3528-5988', '156-6107205', '4953-3813', '', 'msbeares@hotmail.com'),
(66, 'Belatti, Juan Pablo', '0221-4211999', '156-1537397', '', '', 'jpbelatti@yahoo.com.ar'),
(67, 'Beligoy Federico', '4859-6526', '153-4951867', '', '', 'federicobeli@hotmail.com'),
(68, 'Belinco Mariano', '4225-8044', '153-6670271', '5776-7168', '', 'marianobelinco@ciudad.com.ar'),
(69, 'Beloso Julian', '4250-8665', '155-4567690', '', '', 'gjbeloso@hotmail.com'),
(70, 'Benitez Araujo Estanislao', '', '153-1720387 (692*1826)', '4632-3410', '', 'estanislao84@hotmail.com'),
(71, 'Benitez Claudio Gaston Delfin', '6091-8284', '155-5039567', '154-1723099', '', 'cgdelfinbenitez@yahoo.com.ar'),
(72, 'Benitez Cristian Damian', '4247-1216', '153-1230515', '', '', 'cristian.afa@hotmail.com'),
(73, 'Benitez Fernando', '4709-5432', '155-8323350', '4756-2645', '', 'ferbenitezafa@yahoo.com.ar'),
(74, 'Benzoni Maximiliano Ariel', '4712-1107', '156-0218359', '', '', 'arielmb_1983@hotmail.com'),
(75, 'Berardi Salvador', '4867-0903', '155-5693174', '', '', 'cachoberardi@yahoo.com.ar'),
(76, 'Bermejo Javier Edgardo', '0221-4845397', '0221-155221129 (695*2989)', '0221-4293196', '', 'javier_leonlp@hotmail.com'),
(77, 'Bermudez German', '4672-4766', '155-7502001', '', '', 'bermu10@yahoo.com.ar'),
(78, 'Bertinotti Raul', '3533-4627', '155-4284888 (418*7153)', '155-6663696', '', 'raulber@ciudad.com.ar'),
(79, 'Bertone Gerardo', '4682-2529', '155-1569701', '', '', 'gmbertone@yahoo.com.ar'),
(80, 'Bevacqua Eugenio Sebastian', '4202-9100', '1567655817', '', '', 'eugeniobevacqua82@hotmail.com'),
(81, 'Biasutto Mauro Ricardo', '4571-0901', '156-7212615', '', '', 'maurobiassutto@hotmail.com'),
(82, 'Bigatti Diego', '0220-4831286', '155-3452132', '', '', 'diegobigatti@yahoo.com.ar'),
(83, 'Bilos Daniel Andres', '0221-424-0838', '0221-154347274', '0221-4711676', '', 'danielbilos@yahoo.com.ar'),
(84, 'Biscay Juan Carlos', '', '154-0966568', '', '', ''),
(85, 'Biscay Juan Damian', '4744-6848', '156-2607261', '4744-0382', '', 'juanbiscay@hotmail.com'),
(86, 'Bisero Alberto', '4584-9126', '', '', '', ''),
(87, 'Bisso Omar', '', '1553116673', '02320-555700', '', 'omarbisso@hotmail.com'),
(88, 'Blanco Hector Horacio', '0221-4864371', '0221-156131478', '', '', 'horaciohblanco@yahoo.com.ar'),
(89, 'Blanco Jorge', '4302-0405', '', '5550-5175', '', ''),
(90, 'Bobrykowicz Alan Daniel', '4243-0231', '155-4550941', '4788-0045', '', 'alanbobry@hotmail.com'),
(91, 'Boiman Mauricio', '02202-437542', '155-9190432', '', '', 'mauricioboiman@yahoo.com.ar'),
(92, 'Boisselier Cristian Martin', '4734-2496', '1563837087', '', '', 'martinboisselier@yahoo.com.ar'),
(93, 'Bonfá Diego Yamil', '4694-1454/1455', '155-1622959', '4694-1454', '', 'diegobonfa4@yahoo.com.ar'),
(94, 'Bongianino Luis', '4931-7919', '155-0591520', '', '', 'lbongian@hotmail.com'),
(95, 'Bontempo Miguel', '4763-2808', '154-4441724', '4347-9722/9388/9710', '', 'mbontempo@cnc.gov.ar'),
(96, 'Boquete Gerardo', '4750-2561', '', '4734-1000/900', '', 'boqueteoscar@yahoo.com.ar'),
(97, 'Boquin Ariel Norberto', '0237-4690419', '156-9697113', '', '', 'boquinariel@yahoo.com.ar'),
(98, 'Borgarello Carlos', '4280-5374', '', '4331-0957/51', '', 'cborgarello@hotmail.com'),
(99, 'Borras Gaston Hernan', '4485-5869', '156-9687622', '', '', 'gastonborras@live.com.ar'),
(100, 'Bouza Nestor', '4246-4970', '155-092432', '', '', ''),
(101, 'Bracco Angel', '4714-5793', '155-8385062', '', '', 'braccoafa@hotmail.com'),
(102, 'Bracho Gomez Héctor Marino', '4686-3175', '155-8431943', '', '', 'brachohector@hotmail.com'),
(103, 'Braconaro Jose', '4769-7127', '155-0010037', '4480-6031/6040', '', 'mbraconaro@hotmail.com.es'),
(104, 'Bragazzi Ariel', '4627-0146', '', '4132-9037', '', 'arielbragazzi@bsq.com.ar'),
(105, 'Brailovsky Ezequiel Dario', '', '155-5135567', '', '', 'ezbra14@yahoo.com.ar'),
(106, 'Brambilla Juan', '4923-6155', '154-4941691', '4792-0002', '', ''),
(107, 'Bravo Gabriel Cesar', '4654-1533/63799474', '155-9888956', '', '', 'gabrielbravoafa@yaho.com.ar'),
(108, 'Bravo Gustavo', '4202-8605', '156-5312020', '4521-4213', '', 'gustavobravo51@hotmail.com'),
(109, 'Bravo Nicolás Fermin', '0220-4942190', '156-5244815 (580*2073)', '', '', 'nico_bravo24@hotmail.com'),
(110, 'Bravo Raul', '', '156-3353468', '4864-7899 int.5434', '', 'bochibravo@yahoo.com.ar'),
(111, 'Brazenas Gabriel', '', '1550425554', '', '', 'brazuky@hotmail.com'),
(112, 'Bresba Sebastian', '', '154-0581424/153-2846172', '', '', 'rupergol@hotmail.com'),
(113, 'Brienza Pablo', '4932-5893', '154-4780779', '', '', 'pablo_brienza@yahoo.com.ar'),
(114, 'Briozzo, Alejandro', '', '154-4113338', '', '', ''),
(115, 'Britos Alberto', '4750-8000', '156-3926157', '02320-423883', '', ''),
(116, 'Broggi Jorge Alberto', '4294-1152', '152-1688993', '', '', 'jorgebroggi86@hotmail.com'),
(117, 'Broin Fernando Daniel', '4461-3753', '1557192251', '', '', 'simplementedistino@hotmail.com'),
(118, 'Brumer Lucas Nahuel', '4669-2125', '156-2771221', '', '', 'lucasbrumer@live.com.ar'),
(119, 'Brunero Mariano Gaston', '4207-2545/43530423', '155-7691695 (680*3151)', '4207-2545', '', 'm_brunero@hotmail.com'),
(120, 'Bue Roca Nestor', '4643-0987', '154-9865691', '4482-4541/4544', '', ''),
(121, 'Burgos Daniel', '4295-2830', '156-7088416', '', '', 'danyaburgos@hotmail.com'),
(122, 'Busca Alejandro', '4521-8463', '154-0850898 (537*1366)', '', '', 'alejandro.busca@hotmail.com'),
(123, 'Bustamante Joel Rodrigo', '', '155-8948482', '', '', 'joelrb@hotmail.com'),
(124, 'Bustos Martin', '20666979', '15-57357637', '', '', 'martintrenquelauquen@yahoo.com.ar'),
(125, 'Caballero Jose', '4216-7714', '156-6469198', '4704-1619', '', ''),
(126, 'Cabrera Leandro Gabriel', '4862-1819', '155-8049907', '', '', 'leandrocabrera@hotmail.com'),
(127, 'Cabrera Ramiro', '4636-0248', '156-1715408', '4862-3073', '', 'rtitic@hotmail.com'),
(128, 'Calcagno Cecilio Norberto', '2067-2925', '153-5865043', '', '', 'cecilio.norbertocalcagno@hotmail.com'),
(129, 'Calieni Luis', '4289-4357', '153-1869736', '', '', 'luiscalieni@hotmail.com'),
(130, 'Cano Nicolas Rafael', '4691-4086', '153-2716834', '', '', 'nicolascano@gmail.com'),
(131, 'Cappelli Ernesto', '', '154-4139688', '', '', 'ernesto.cappelli@siemens.com.ar'),
(132, 'Carbó Hugo Orlando', '4844-7323', '153-8857425', '', '', 'hugogau83@hotmail.com'),
(133, 'Carci Osvaldo', '4701-6066', '', '4767-0607', '', 'ag_ladiosafortuna@hotmail.com'),
(134, 'Cárdenes Pablo Ezequiel', '0221-4828629', '0221-155347702', '', '', 'ezepiojoso22@hotmail.com'),
(135, 'Cardillo Francisco', '4922-8770', '', '', '', ''),
(136, 'Carlomagno Osvaldo', '4631-6777', '154-4094923', '4346-4230', '', ''),
(137, 'Carmarino Marcos Tomas', '4252-0900', '156-3993221 (601*2867)', '', '', 'marcoscarmarino@hotmail.com'),
(138, 'Carreras Jose Antonio', '4461-5620', '156-1574863', '4652-7136', '', 'chiquicarreras@yahoo.com.ar'),
(139, 'Carretero Gerardo', '4750-1483', '154-1411877 (612*4910)', '', '', 'gerardocarretero@hotmail.com'),
(140, 'Carrizo Diego', '4932-6126', '15-51406253', '', '', 'maxicarri2004@yahoo.com.ar'),
(141, 'Carrizo Jorge', '4861-7167', '155-4284021', '4918-8135', '', 'jorgelin49@yahoo.com.ar'),
(142, 'Carrizo Walter Daniel', '4663-3773', '156-8963149', '', '', 'carrizowalterdaniel@yahoo.com.ar'),
(143, 'Casais Damian', '5901-3553', '154-4135846', '', '', 'yo_dami@yahoo.com.ar'),
(144, 'Casalet Jorge', '4672-7779', '156-7831102', '4784-6788', '', 'jcasalet@yahoo.com.ar'),
(145, 'Casares Claudio', '4963-1417', '154-1845188', '', '', ''),
(146, 'Casas Ricardo Alberto', '4245-6518', '156-3548374', '4243-4193', '', 'ricardocasas04@yahoo.com.ar'),
(147, 'Cassano Marcelo', '4523-1302', '', '4702-5940', '', ''),
(148, 'Castagnino Pablo', '4775-6051', '155-4104647', '4317-5000 int 2604', '', 'pablo.castagnino@total.com'),
(149, 'Castagno Roberto', '4742-9673', '', '', '', ''),
(150, 'Castany Alejo', '4861-2324', '156-8286757', '41215444', '', 'acastany@senasa.gov.ar'),
(151, 'Castaño Emilio', '4544-9875', '156-1161003', '', '', ''),
(152, 'Castaño Gustavo', '4613-6341', '155-4555115', '', '', 'gustavocas@ciudad.com.ar'),
(153, 'Castellano Hector', '4854-8031', '154-1762266', '4331-7922/5167-9335', '', 'hector.castellano@transx.com.ar'),
(154, 'Castelli Maximiliano Ezequiel', '0221-425-7325', '0221-155082938 (644*2697)', '', '', 'castellimaxi@hotmail.com'),
(155, 'Castiglia Javier Silvano', '03488-443600', '156-0943600', '', '', 'javierscastiglia@hotmail.com'),
(156, 'Castillo Luis Alberto', '02224-477881', '155-9486609', '', '', 'castilloguernica@hotmail.com'),
(157, 'Castro Alejandro', '4240-6084', '15-34085322', '4451-60492', '', 'alejandrojcastro@hotmail.com'),
(158, 'Castro Ernesto Javier', '0221-4832443', '0221-156013660', '0221-423-2821/427-15', '', 'jecastro67@hotmail.com'),
(159, 'Castro Gustavo Javier', '4861-4023', '', '', '', 'gustavo_castro82@yahoo.com.ar'),
(160, 'Castro Luciano Ezequiel', '0237-4841222', '153-2872958', '', '', 'lucianoecastro@hotmail.com'),
(161, 'Ceballos Diego', '4665-9440', '155-1849245 (623*1669)', '4331-0606', '', 'diegceballos@yahoo.com.ar'),
(162, 'Cejas Claudio Sebastian', '02202-427557', '153-7574401', '', '', 'sebastiancejas1980@hotmail.com'),
(163, 'Celano Carlos', '4731-5535', '1550072263', '', '', 'celano_carlos@hotmail.com'),
(164, 'Centanni Fernando German', '', '156-2173318', '4796-5036/4795-9283', '', 'fergcentanni@hotmail.com'),
(165, 'Ceñal Carlos', '4252-2421', '155-6153001', '4202-8310/8485 i 224', '', 'caraul@ciudad.com.ar'),
(166, 'Cercato Alejandra Mercedes', '4574-0892', '155-6255909', '', '', 'alecercato@hotmail.com'),
(167, 'Chappa Gaston', '4292-0391', '155-6121939', '', '', 'chappa77@hotmail.com'),
(168, 'Chaves Walter', '4696-6792', '154-4991486', '', '', 'dionisiowalter@yahoo.com.ar'),
(169, 'Chavez Elvio Emanuel', '0220-2454275', '156-2662374', '', '', 'emanuelchavez@live.com.ar'),
(170, 'Chavez Felix', '02322-494531', '', '', '', 'felixchavez@hotmail.com'),
(171, 'Chirino Martin Miguel', '', '155-9380934', '', '', 'mchirino79@hotmail.com'),
(172, 'Chirino Roberto', '', '154-9481423', '02320-555555', '', ''),
(173, 'Ciccarella Andres', '4683-0579', '155-5929716', '', '', 'aciccarella@speedy.com.ar'),
(174, 'Cichetto Mariano Alberto', '4214-6617', '155-4637432', '4379-5200', '', 'marianocichetto@yahoo.com.ar'),
(175, 'Cingari Bettina', '4254-7921', '155-2613819', '4254-6972', '', 'betcingari@yahoo.com.ar'),
(176, 'Cinquetti Gastón Ricardo', '0221-4839244', '0221-156217789', '', '', 'gastoncinquetti@msn.com'),
(177, 'Cinquetti Ricardo', '02221-483-9244', '0221-154287425', '4483-0883', '', 'guillermocinquetti@hotmail.com'),
(178, 'Citate Julian Agustín', '0221-4820285', '0221-155409288', '', '', 'chulichuli8@hotmail.com.ar'),
(179, 'Colli Luis Alberto', '4241-0840', '154-9606822', '', '', 'luisalbertocolli@hotmail.com'),
(180, 'Colli Sergio Gabriel', '4641-0772', '154-5594456', '4968-1995/1987', '', 'scolli@arnet.com.ar'),
(181, 'Colman Anastasio Claudio', '4791-3440', '', '', '', ''),
(182, 'Colombani Dario Eduardo', '3529-8562', '156-1074455', '', '', 'colombani_dario@hotmail.com'),
(183, 'Colombo Diego', '0221-4793184', '0221-155553110', '', '', 'dieg-colombo@hotmail.com'),
(184, 'Colonesse Christian', '4245-8432', '156-0161345', '5199-1212', '', 'cristiancolonesse77@hotmail.com'),
(185, 'Comesaña Lucas Gabriel', '4756-7242', '155-4609618', '', '', 'lucasgcom@hotmail.com'),
(186, 'Cordoba Cesar Jose', '4698-2950', '155-9420587', '', '', 'cesarbitro@gmail.com'),
(187, 'Correa Ricardo', '4840-0713', '153-6232249', '', '', ''),
(188, 'Cotderipe Nicolas Daniel', '4202-4425', '155-7742138', '', '', 'ndcot_1987@hotmail.com'),
(189, 'Crespi Juan', '4247-9519', '', '', '', 'profejcc@yahoo.com.ar'),
(190, 'Cuchiarelli Ezequiel Gastón', '', '156-4622540', '', '', 'eze031@hotmail.com'),
(191, 'Cuenca Jorge', '4601-1340', '155-5783222', '4000-8400 int 2845', '', 'jorge_h_cuenca@hotmail.com'),
(192, 'Cueto Viñas Lucas', '0220-4823630', '155-4939220', '4480-6803  int. 1973', '', 'lmcv7279@hotmail.com'),
(193, 'Cuevas Diego Roman', '', '156-6575235', '', '', 'diego.cuevas@hotmail.com.ar'),
(194, 'Cuneo Daniel', '', '156-1843087', '', '', 'danielcuneo16@hotmail.com'),
(195, 'Cuzzani Agustin', '2068-1411', '156-4184286', '', '', 'agustin.cuzzani@yahoo.com'),
(196, 'D'' Amico Eduardo', '4790-4530', '154-886797', '4341-3312', '', 'edamico@bancorio.com.ar'),
(197, 'D'' Angola Rafael', '4262-7347', '15-50617516', '4240-0884/4249-0497', '', 'rdangola@yahoo.com.ar'),
(198, 'Damonte Ivan Alejandro', '', '155-0121562', '', '', 'ivandamonte@hotmail.com'),
(199, 'De Almeida Mariana Lorena', '4567-3995', '153-1207784', '', '', 'mldalmeida@hotmail.com'),
(200, 'De Bary Federico Agustin', '', '153-0727124', '', '', 'fededebary@hotmail.com'),
(201, 'De Los Santos Carlos', '4958-1003', '15-44782792', '4704-1639/40', '', 'carloshdlsantos@hotmail.com'),
(202, 'De Luca Miguel Angel', '0221-4620217', '0221-155112601', '0221-4575454 int 247', '', 'migelgigs@hotmail.com'),
(203, 'De Oto Jonathan Matias', '4691-3956', '156-4259798', '4488-8802', '', 'jmdeoto@hotmail.com'),
(204, 'De Oto Leonardo Gabriel', '4691-3956', '153-1233322', '', '', 'leo_deoto@yahoo.com.ar'),
(205, 'Defelippi Mariano Pablo', '0220-4855725', '1554961562', '', '', 'pablo_defelippi@hotmail.com'),
(206, 'Del Puerto Gundin Pablo Valentin', '4541-8160', '15-64818553', '4321-2505', '', 'papuert@yahoo.com.ar'),
(207, 'Del Yesso Maximiliano David', '4442-2566', '153-0232599', '4793-1677', '', 'maxidelyessoafa@hotmail.com'),
(208, 'Delbarba Adrian Pablo', '4653-5792', '153-2815997', '', '', 'adriandelbarba@hotmail.com'),
(209, 'Delbarba Javier Alberto', '', '156-0277797', '', '', 'javierdelbarba@hotmail.com.ar'),
(210, 'Delfino German Raul', '', '155-3831978', '', '', 'germanrauldelfino@yahoo.com.ar'),
(211, 'Dellacasa Hernán Matias', '4300-7938', '155-9740485', '4778-5025', '', 'hernanmdellacasa@yahoo.com.ar'),
(212, 'Demaro Juan', '4433-0827', '', '4862-6325', '', ''),
(213, 'Derevnin Alejandro', '4671-4673', '155-8777819', '', '', 'aderevnin@hotmail.com'),
(214, 'Di Bastiano Lucas', '0221-4562376', '0221-155998243 (706*6233)', '0221-4248009', '', 'lucasdibastiano@hotmail.com'),
(215, 'Di Iorio Jesica Salomé', '4253-8770', '155-5277160', '', '', 'salomeafa@yahoo.com.ar'),
(216, 'Di Paola Sergio', '4921-0518', '154-0688228 (612*4913)', '4862-9203', '', 'sergiodipaola@hotmail.com'),
(217, 'Díaz Jorge', '0221-4561099', '0221-154884037', '0221-4224114 int.223', '', 'jorgediazafa@yahoo.com.ar'),
(218, 'Diaz Juan Manuel', '4842-6774', '156-1067508', '', '', 'diazjuanmanuel@hotmail.es'),
(219, 'Diaz Moreira Daniel', '4709-0876', '155-6330378', '', '', 'laasroma@ciudad.com'),
(220, 'Diaz Parodi Walter Omar', '4919-7363', '156-4282965', '', '', 'walterdp87@hotmail.com'),
(221, 'Diaz Roberto Carlos', '', '156-9143776', '', '', 'robertodiaz2983@hotmail.com'),
(222, 'Diez Jorge', '', '0221-154884037', '4334-4606/08', '', 'jorgediezccnv@hotmail.com'),
(223, 'Diulio Tomas Alejo', '0221-4821662', '0221-154406132 (706*1989)', '', '', 'tdiulio@yahoo.com.ar'),
(224, 'Dominguez Héctor Sebastian', '4467-1345', '153-5936932', '', '', 'seba_83@hotmail.com'),
(225, 'Dovalo Pablo German', '4567-0338', '153-5476859 (689*5482)', '4958-4129', '', 'pdovalo@yahoo.com.ar'),
(226, 'Echenique Fernando Gabriel', '4669-0496', '153-0065387', '', '', 'ferarbitro@hotmail.com'),
(227, 'Elizondo Horacio', '', '1533382204', '4704-1687', '', 'elizondohoracio@hotmail.com'),
(228, 'Errandonea Sebastian Javier', '4454-1329', '15-51099014', '', '', 'sebastianjaviererrandonea@hotmail.com.ar'),
(229, 'Errante Marcelo Daniel', '4583-9530', '156-0941061', '4777-4432', '', 'marceloerrante@hotmail.com'),
(230, 'Esker Luciano Sebastian', '4233-5517', '152-1624464', '', '', 'lucho_esker@yahoo.com.ar'),
(231, 'Espinola Miguel Angel', '4639-5343', '155-6636936', '', '', 'mespinola76@yahoo.com.ar'),
(232, 'Esquivel Gustavo', '4666-8168', '154-9929752 (179*1223)', '4740-3334', '', 'gusclau@arnet.com.ar'),
(233, 'Estigaribia Jorge', '', '155-4616416', '', '', ''),
(234, 'Etcheverry Manuel', '0221-4828962', '0221-155378056', '', '', 'etcheverrymanuel@live.com.ar'),
(235, 'Falcon Perez Yael Christian', '', '155-0119981', '', '', 'yaelfalconp@hotmail.com'),
(236, 'Falduti Sebastian Hernan', '4687-3032', '156-5095549', '', '', 'sebastianfaldutti.afa@yahoo.com.ar'),
(237, 'Falvo Facundo Antonio', '4290-2611', '156-6776379', '', '', 'falvofacundo1988@hotmail.es'),
(238, 'Famiglietti Jose', '4234-2766', '', '', '', 'cfamigli@cmemotecnicnicasa.comar'),
(239, 'Faraoni Cristian', '', '155-5043502', '4583-9000 int 301', '', 'critian.faraoni@fullerarg.com.ar'),
(240, 'Favale Gabriel', '4731-8544', '15-54189695', '4749-0109', '', 'gabfavale@yahoo.com.ar'),
(241, 'Feijoo Sebastian', '4753-5864', '155-7677452', '', '', 'seba40000@hotmail.com'),
(242, 'Feola Pedro', '4962-5648', '', '', '', ''),
(243, 'Fernandes Guido Eduardo', '4958-4260', '', '4650-8455', '', ''),
(244, 'Fernandez Caballero Analia', '4238-4460', '153-0606277', '', '', 'analiafc@live.com.ar'),
(245, 'Fernandez Daniel Alberto', '4261-2242', '156-5405547', '', '', 'danifer@alternativagratis.com'),
(246, 'Fernandez Emiliano Daniel', '0221-4573833', '0221-156138631', '', '', 'emiliano.fernandez@live.com'),
(247, 'Fernandez Hernan Mauricio', '4233-0478', '155-7689965', '4258-8583', '', 'martinaclon@fullzero.com.ar'),
(248, 'Fernandez Jorge Alfredo', '4826-9190', '154-0713333', '49416288', '', 'jafpjaf@yahoo.com.ar'),
(249, 'Fernandez Oscar Raul', '4450-8417', '153-6701158', '4459-7685 madre', '', ''),
(250, 'Fernandez Ricardo', '4247-4083', '155-1033435', '4581-1509', '', ''),
(251, 'Ferro Jorge', '4742-0637', '155-7416232', '', '', 'jorgefe2003@yahoo.com.ar'),
(252, 'Filomeno Gonzalo Damian', '4282-2133', '156-0475732', '4209-1440', '', 'gonzalo_arbitro@hotmail.com'),
(253, 'Fioravanti Alberto', '4788-0138', '', '4774-3838/6848', '', ''),
(254, 'Foglia, Gerardo', '4504-0554', '', '', '', ''),
(255, 'Franco Roberto', '4855-7470', '155-2267590', '4319-2500', '', 'tanofranco2003@yahoo.com.ar'),
(256, 'Frega Alejo Dario', '4284-1084', '156-5382485', '', '', 'alebbs@hotmail.com'),
(257, 'Frega Leonardo Ariel', '4762-6511', '154-9605761 (612*498)', '4370-3525/4383-4744', '', 'leo.frega@hotmail.com'),
(258, 'Frezzotti Jorge', '4567-8802', '155-0002014', '', '', 'pfrezzotti@hotmail.com.ar'),
(259, 'Fructos Federico Nazareno', '', '156-1822238', '', '', 'fedeelzurdo@hotmail.com'),
(260, 'Fuenterrabia Antonio', '4632-5924', '', '', '', ''),
(261, 'Furchi  Rafael', '4642-4248', '0223-155566246', '', '', 'rafael_furchi@tutopia.com'),
(262, 'Gadea Ricardo', '4604-0534', '155-8211686', '', '', 'rickgadea@ciudad.com.ar'),
(263, 'Galante Adrian P.', '0230-4404883', '156-4340826', '4346-9700', '', 'adrian.galante@yahoo.com.ar'),
(264, 'Galeano Juan', '4461-1210', '155-1154484', '4775-2699/4899-0100', '', 'jmgaleano2000@yahoo.com.ar'),
(265, 'Gallego Juan Pablo', '4766-3777', '155-4605973', '4382-4547', '', 'jpgallego2005@yahoo.com.ar'),
(266, 'Gallina Mario', '0221-4242307', '', '', '', ''),
(267, 'Galvan Yamil Agustin Alejandro', '', '156-0237913', '', '', 'agustin.galvan@hotmail.com'),
(268, 'Gamba Manuel Augusto Jose', '0221-4892515', '0221-154590515', '0221-4892515', '', 'manuelgamba@yahoo.com.ar'),
(269, 'Gamboa Gaston Orlando', '4692-0287', '156-6696066', '4692-0287', '', 'gaston.gamboa@yahoo.com.ar'),
(270, 'Gaona Gilberto', '', '156-3007820', '', '', ''),
(271, 'Garac y Gojak Pablo Andres', '4795-4010', '156-9409394', '', '', 'pablogarac@hotmail.com'),
(272, 'Garay Juan', '4459-6158', '', '4318-0311', '', 'Fax 4316-0468'),
(273, 'Garay Leandro', '4459-6158', '155-8494203', '', '', 'leangaray@uol.com.ar'),
(274, 'Garcia Leri Uriel Agustin', '0221-4255818', '0221-154372138', '', '', 'urielgarcialeri@gmail.com'),
(275, 'Garcia Montaña Patricio Martin', '4644-5552', '155-6193373', '', '', 'patriciomgm@hotmail.com'),
(276, 'García Ruben', '0342-452-1920', '', '0343-424-2703/04', '', ''),
(277, 'Gargano Hugo', '4568-6617', '155-9613927', '4375-0002/0007/', '', ''),
(278, 'Garibotti Luis', '', '155-9479843', '', '', 'lgaribotti@hotmail.com'),
(279, 'Gelay Hector Miguel', '4643-1652', '153-0606720', '', '', ''),
(280, 'Geloso Claudio', '4684-0934', '156-1290962', '', '', 'fueradejuego01@yahoo.com.ar'),
(281, 'Gerber Jorge', '4656-0687', '155-0028060', '4750-5939', '', ''),
(282, 'Germanotta Lucas Andres', '4627-7145', '154-1985185', '', '', 'lag925@hotmail.com'),
(283, 'Ghibaudi Sergio', '4482-4455', '154-1787763', '4696-7961', '', 'sghibaudi_67@yahoo.com.ar'),
(284, 'Ghinassi Sebastian', '03488-483048', '155-8439686', '03488-483048', '', ''),
(285, 'Ghiso Jonathan Alejandro', '02320-427436', '156-8973886', '', '', 'jonyghiso@hotmail.com'),
(286, 'Giacomino Federico Carlos', '4503-4844', '155-3774507', '', '', 'fcgiacomino@hotmail.com'),
(287, 'Giampaolo Martin Oscar', '0221-4252808', '0221-154354217', '', '', 'martingiam@hotmail.com'),
(288, 'Gigante Hermes', '', '156-1421701', '', '', 'hermes1389@hotmail.com'),
(289, 'Gigena Carlos', '4767-2358', '15-38590201', '', '', 'cgigena51@hotmail.com'),
(290, 'Gimenez Pablo Ernesto', '4264-2686', '156-2872978', '', '', 'pablogimenez8@yahoo.com.ar'),
(291, 'Giordano Sebastian', '', '155-5120323', '', '', 'seba_giordano@yahoo.com.ar'),
(292, 'Giorno Marcelo', '4294-3195', '', '4214-3802', '', 'marcelogiorno2004@yahoo.com.ar'),
(293, 'Giuffrida Leonardo', '4442-1041', '155-1235279 (648*137)', '', '', 'leogiuffrida2003@yahoo.com.ar'),
(294, 'Gomez Daniel', '4768-4133', '155-7056903', '', '', 'danyrgomez@yahoo.com.ar'),
(295, 'Gomez Esteban Augusto', '4840-0717', '156-9810984', '', '', 'esteban_mek2@hotmail.com'),
(296, 'Gonaldi Martin', '0221-4890266', '0221-154882597 (671*2722)', '0221-6479994', '', 'martingonaldi@hotmail.com'),
(297, 'Gonzalez Alan Leonardo', '4294-3125', '153-0233125', '', '', 'delsur_live@hotmail.com'),
(298, 'Gonzalez Alfredo', '4568-4346', '155-3397800', '4508-3111', '', 'alfredogonzalez11@hotmail.com'),
(299, 'Gonzalez Cynthya Maria', '4210-1075', '155-4947679', '', '', 'cynthyamaria24@yahoo.com.ar'),
(300, 'Gonzalez Diego Martin Lujan', '4660-1090', '155-6959275', '', '', 'dmlgdlp@hotmail.com'),
(301, 'Gonzalez Gerardo', '4720-7541', '155-8542707', '4760-8500', '', 'gerardo_gonzalez274@hotmail.com'),
(302, 'Gonzalez Joaquin Bernardo', '4668-0870', '156-9990321', '', '', 'joako025_05@hotmail.com'),
(303, 'Gonzalez Jorge Isaias', '4485-5991', '155-9593203', '', '', 'isaiasgonzalez_afa@hotmail.com'),
(304, 'Gonzalez Juan Manuel', '0221-4577297', '0221-155372199', '', '', 'afagonzalezjm@yahoo.com.ar'),
(305, 'Gonzalez Miguel', '4739-0341', '154-9988542', '4580-5576', '', ''),
(306, 'Gonzalez Omar', '4523-2715', '', '4957-3456', '', ''),
(307, 'Gonzalez Ramon Moises', '4433-5648', '155-9640453', '4347-8371/0', '', 'monchigz52@yahoo.com.ar'),
(308, 'Gonzalez Ricardo', '4660-1090', '153-2111055', '', '', ''),
(309, 'Gonzalez Ricardo Adrian', '4232-7815', '153-0724042', '', '', 'ricardo_a_gonzalez@yahoo.com.ar'),
(310, 'Gonzalez Sachero Emiliano Carlos', '4232-4367', '156-8310137', '', '', 'delacabeza2@hotmail.com'),
(311, 'Gonzalez Sixto Adolfo', '4660-1090', '154960-1613', '', '', ''),
(312, 'Grasso Felix', '4924-1477', '', '', '', ''),
(313, 'Grela Norman', '4242-2573', '155--375-2968 (582*8))', '', '', 'norfale@yahoo.com.ar'),
(314, 'Grillo Giuliano Oscar', '4276-2155', '155-0495538', '', '', 'chula89_9@hotmail.com'),
(315, 'Grimberg Martin Bernardo', '4805-4467', '155-7403122', '', '', 'mbgrinberg2003@yahoo.com.ar'),
(316, 'Grondona Rodrigo', '4822-4441/4776-4176', '155-1038433', '', '', 'rgrondona@hotmail.com'),
(317, 'Gualtieri Pablo Rafael', '4488-5889', '156-2145847/1557153339 (708*2151)', '4469-5300 int.1952/1', '', 'gualtieri_29@hotmail.com'),
(318, 'Guerra Rodolfo', '4824-7304', '155-7191224', '', '', 'rodolfoguerra@live.com'),
(319, 'Guillaume Gabriel', '4682-1280', '155-7713752', '', '', 'gabrielguillaume@fullzero.com.ar'),
(320, 'Gutierrez Eduardo', '0220-4946106', '156-1685604', '', '', 'gutierrez_edu@yahoo.com.ar'),
(321, 'Guzman Emanuel', '4691-4810', '155-1239620', '', '', 'emanuel_guzman81@yahoo.com.ar'),
(322, 'Guzman Ernesto Angel', '4667-3034', '155-9919626', '4451-8678 (padres)', '', 'milico73@hotmail.com'),
(323, 'Habib Marcelo', '4303-0508', '155-7422849 (612*4911)', '4372-2550', '', 'habibico@uolsinectis.com.ar'),
(324, 'Habib Sebastian Máximo', '4303-0508', '154-4790133', '4348-8484', '', 'sebastianhabib@hotmail.com'),
(325, 'Hartung Hugo Hernan', '4292-5267', '153-4221666', '', '', 'hartung_cga@hotmail.com'),
(326, 'Hay Anibal', '4362-6126', '154-9710707', '', '', 'anibalhay@hotmail.com'),
(327, 'Hernandez Damian Eduardo', '4246-2935', '156-2967708', '', '', 'hernandez354@yahoo.com.ar'),
(328, 'Herrero Horacio', '4574-0892', '155-0132527', '', '', 'horacioherrero@yahoo.com.ar'),
(329, 'Heyno Juan', '02323-427996', '155-8762367', '', '', ''),
(330, 'Hoyos Jorge Leandro', '4389-1180', '153-3528509', '', '', 'leandro_hoyos@hotmail.com'),
(331, 'Huberty Carlos', '4622-3242', '15-41828079', '4383-0252', '', ''),
(332, 'Ibañez Roberto', '4722-0730', '155-5052403', '', '', 'reiarb4@hotmail.com'),
(333, 'Idiart David Sebastian', '0221-4561205', '0221-154086340', '0221-4896603', '', 'davididiart@hotmail.com'),
(334, 'Ifran Roque Gaston', '', '154-9160279', '', '', 'tiraceg@hotmail.com'),
(335, 'Iglesias Gaston Ariel', '4452-7874', '1531687008', '', '', 'gaston4a@gmail.com'),
(336, 'Ingargiola Mauro Augusto', '4751-1872', '153-2150818', '4738-4199', '', 'mauroingargiola@hotmail.com'),
(337, 'Insaurralde Ruben Eduardo', '4395-2664', '155-038-7816', '4318-7400 int. 2832/', '', 'maredu13@yahoo.com.ar'),
(338, 'Insaurralde Walter', '4459-6455', '156-5568972/1557389574', '4546-2054', '', 'walter_frances@hotmail.com'),
(339, 'Ionno Hector', '4657-6663', '', '', '', ''),
(340, 'Iparraguirre Pablo', '0224-4453561', '02244-15420810', '02244452613/2829', '', '102dagof@s2coopenet.com.ar'),
(341, 'Irmici Carlos Ariel', '4713-3727/1381', '156-8631383', '0800-888-0242', '', 'ariel_irmici@hotmail.com'),
(342, 'Irvini Ignacio Javier', '4656-3544', '156-6028353', '', '', 'ignacioirvini@yahoo.com.ar'),
(343, 'Irvini Matias Nicolás', '4756-3322', '156-0120488', '4709-3803', '', 'mirvini@hotmail.com'),
(344, 'Ivalde Carlos Hernan', '4951-1226', '155-1160504', '', '', 'cailohernan@gmail.com'),
(345, 'Jimenez Alcaina Miguel', '0221-4223257', '0221-154882670', '0221-4962007/009', '', 'jimenezalcaina@hotmail.com'),
(346, 'Jorge Mitre Santiago', '4571-5577', '156-6503620', '', '', 'santiago_jmitre@hotmail.com'),
(347, 'Josa Federico Ruben', '4450-8397', '155-8123344', '', '', 'fede_josa_88@hotmail.com'),
(348, 'Jose Mollard Leonardo Fabian', '4787-2038', '155-0195198', '', '', 'leomollard@hotmail.com'),
(349, 'Kloster Jorge', '4246-6646', '155-5647486', '', '', 'klostero04@hotmail.com'),
(350, 'knoth Agustin Edmundo', '4620-3309', '155-3198168', '', '', 'agustin.knoth@hotmail.com'),
(351, 'Kopanchuk Edgardo Ariel', '4442-5186', '156-5633435', '4233-1749 int. 29', '', 'polakopan@hotmail.com'),
(352, 'Korman Hernan', '4217-4551', '153-0063636', '', '', 'hernank_04@hotmail.com'),
(353, 'Krauss Carlos', '4249-6374', '156-6572251', '', '', 'carloskraussafa@hotmail.com'),
(354, 'Laballos Fernando', '4635-8819', '156-7161954', '', '', 'flaballos@yahoo.com.ar'),
(355, 'Laguzzi Alejandro', '4240-3600', '153-7260061', '', '', 'laguzzialejandro@yahoo.com.ar'),
(356, 'Lamolina Francisco Oscar', '4745-3902', '155-6639302', '', '', ''),
(357, 'Lamolina Nicolas', '4744-6819', '153-0821045', '155-9579325', '', 'nlamolina@yahoo.com.ar'),
(358, 'Larregain Mariano Gbariel', '4240-5118', '156-9525850', '', '', 'mariano.larregain@hotmail.com'),
(359, 'Larrieu Klein Luciano', '4353-0579', '156-7920854', '', '', 'lucho.klein@yahoo.com.ar'),
(360, 'Laura Matias Carlos', '0221-4843938', '0221-155702915 (671*2721)', '', '', 'matiaslaura@hotmail.com'),
(361, 'Lazaro Ricardo Adrian', '4292-4901', '156-8114188', '', '', 'ricardo_a_lazaro@yahoo.com.ar'),
(362, 'Ledo Juan', '4842-7683', '156-0975532 (235*458)', '', '', 'marceloledo2004@yahoo.com.ar'),
(363, 'Lencina Gerardo Gustavo', '4952-5013', '155-8512054', '', '', 'gerardolencina76@yahoo.com.ar'),
(364, 'Lepanto Mauricio Federico', '4257-4660', '154-0568278', '5268-1226/27/28', '', 'mauriciolepanto@yahoo.com.ar'),
(365, 'Lezana Rodrigo', '0221-4511389', '0221-155010088 (154*1887)', '', '', 'rlezana@hotmail.com'),
(366, 'Libossart Sergio', '4228-8871', '154-5655460', '4208-3355', '', ''),
(367, 'Linardi Pablo Andres', '0221-4538064', '0221-154314088 (623*1524)', '', '', 'pablolinardi1@hotmail.com'),
(368, 'Liporace Luis', '4612-3762', '156-1737004', '', '', 'luisliporace@speedy.com.ar'),
(369, 'Livio Pablo Sebastian', '4247-5003', '155-1386067', '', '', 'livioseba@gmail.com'),
(370, 'Llapur Edgardo Ariel', '4696-3238', '153-0698866', '4696-7183', '', 'allapurafa@yahoo.com.ar'),
(371, 'Loiseau Yoel Danao', '4299-8592', '156-6899529', '', '', 'yoel_danao@hotmail.com'),
(372, 'Lombar Gabriel Alberto Maximiliano', '0221-4231209', '0221-155654331', '0221-45220386', '', 'gabriellombar@yahoo.com.ar'),
(373, 'Lopardo Facundo Dario', '4738-4443', '155-6361919', '', '', 'profefacundolopardo@hotmail.com'),
(374, 'Lopez Aldazabal Gonzalo', '4821-5126', '156-4724864', '', '', 'gonzaloaldazabal@hotmail.com'),
(375, 'Lopez Carla Belen', '0221-4562371', '0221-155082487', '', '', 'karla618_90@hotmail.com'),
(376, 'Lopez Courett Juan', '4902-6749', '15-4986-0205/44201946', '', '', ''),
(377, 'Lopez Damian Alejandro', '4753-9573', '156-3501520', '4755-4330', '', 'monerjr@hotmail.com'),
(378, 'Lopez Gustavo Emilio', '4221-6312', '156-4258494', '4221-6312', '', 'emiliomufetti@hotmail.com'),
(379, 'Lopez Jose', '4750-7453', '154-0669243', '', '', ''),
(380, 'Lopez Ramiro  Ignacio', '4733-9575', '156-6955231', '4329-8850/8950', '', 'ilcapolopez@yahoo.com'),
(381, 'Lopez Severo', '4961-3481', '153-6554777', '4964-5895', '', ''),
(382, 'Lorenzo Leandro David', '4633-3481', '154-1775608', '', '', 'leandrolorenzo@hotmail.com'),
(383, 'Loureiro Manuel', '4729-6139', '155-3750443', '', '', 'manuelloureiro_63@hotmail.com'),
(384, 'Loustau Juan', '4292-5311', '', '', '', ''),
(385, 'Loustau Juan Pablo', '4290-5311', '153-1760052', '4239-9600', '', 'juanloustau@gmail.com'),
(386, 'Loustau Patricio', '4244-1957', '153-0370443', '4312-1560', '', 'loustauph@cpproximity.com.ar'),
(387, 'Lovatto Raul', '4455-7956', '', '4455-8932', '', 'raulovatto@hotmail.com'),
(388, 'Lozano Carlos', '4567-9808', '154-0477497', '', '', 'calbertolozano@yahoo.com.ar'),
(389, 'Luguercho Gaston Federico', '', '0221-155923097', '0221-4844225', '', 'pearljam1016@yahoo.com.ar'),
(390, 'Lupani Stewart Usher Ignacio Andres', '03327-455317', '155-8512275', '', '', 'nacholupani@yahoo.com.ar'),
(391, 'Machado Sebastian Hector', '0220-4829138', '155-4723207', '', '', 'seba_machado@hotmail.com'),
(392, 'Maciel Leonardo Gabriel', '4714-1527', '156-4322060', '', '', 'lgm24@hotmail.com'),
(393, 'Magallan Ramiro', '0221-5885953', '0221-155431291', '', '', 'ramiromagallan@hotmail.com'),
(394, 'Maglio Carlos', '4585-2688', '156-8872441', '4104-0088', '', 'cmaglio@libertyseguros.com.ar'),
(395, 'Maguna Silvio', '4566-4976', '155-8856881', '', '', 'silviomaguna@hotmail.com'),
(396, 'Maidana Carlos Gabriel', '4225-0955', '155-8066937', '', '', 'gabriel_maidana@hotmail.com'),
(397, 'Malarino Malka Marcelo Leonel', '4297-9079', '154-5633495', '', '', 'leonel.malarino @hotmail.com'),
(398, 'Marcello Gilberto', '4225-3936', '155-493-5182', '4241-4050/59 i 210', '', 'gilbertomarcello@ubbi.com'),
(399, 'Marconi Osvaldo', '', '156-2421439', '', '', 'osvaldomarconi@hotmail.com'),
(400, 'Marel Dario Alejandro', '4699-4700', '155-5632157', '4699-4700', '', ''),
(401, 'Mariescurrena Gabriel Adrian', '0221-4270450', '0221-156121127', '', '', 'gmariescurrena@argentina.com.ar'),
(402, 'Martinez Cuenca Cristhians', '', '1559529018', '4802-9910/5743', '', 'cristiancuenca3@hotmail.com'),
(403, 'Martinez Diego', '0221-451-5389', '0221-154097703', '', '', 'diegomartinezafa@yahoo.com.ar'),
(404, 'Martinez Lucas Adrian', '4912-3443', '156-7174536', '', '', 'lucasadmartinez@hotmail.com'),
(405, 'Martinez Marcelo', '0221-4502739', '0221-154-289933', '0221-4694087', '', 'martinez_marce68@yahoo.com.ar'),
(406, 'Martinez Sebastian Nicolas', '4716-0465', '156-2464343', '', '', 'sebastian.nmb@hotmail.com'),
(407, 'Masci Fernando Esteban', '0221-4716954', '0221-155589948', '0221-4775200', '', 'fernandomasci@yahoo.com.ar'),
(408, 'Masia Oscar', '4300-6102', '156-3572358', '4811-3318', '', 'negro872002@yahoo.com.ar'),
(409, 'Massa Juan Manuel', '0221-4244327', '0221-156143363', '', '', 'el_moncho22@hotmail.com'),
(410, 'Masseri Ruben', '4713-5325', '15-51752783', '', '', ''),
(411, 'Mastrangelo Carlos', '4567-0007', '154-9939672', '', '', ''),
(412, 'Mastrangelo Hernan Carlos', '4567-1512', '153-1668000 (699*5737)', '4380-3240', '', 'mastrangelohernan@yahoo.com.ar'),
(413, 'Mastronardi Conrado', '4741-8515', '155-8859098', '', '', 'mastroclau@yahoo.com.ar'),
(414, 'Mazza Alejandro', '4240-6468', '155-7952127/156-6332473 (597*4387)', '', '', 'alemazza2006@yahoo.com.ar'),
(415, 'Medina Ariel Hernan', '4200-8390', '156-5664458', '4016-6100', '', 'arielmedina123@hotmail.com'),
(416, 'Medina Mario Americo', '0220-4825994', '156-7429293', '', '', 'casifutbol@yahoo.com.ar'),
(417, 'Medina Rojas Romina Anabel', '03327-485497', '155-1077665', '', '', 'mrromina@hotmail.com'),
(418, 'Meineri Gastón', '0221-4514221', '0221-155-069527', '0221-4250145/7115', '', 'gastonandresmeineri@uolsinectis.com.ar.'),
(419, 'Melgarejo Arnaldo Saul', '0220-4855068', '155-8507053', '', '', 'arin82@hotmail.com'),
(420, 'Mendez Jose', '4206-5870', '', '', '', ''),
(421, 'Mendez Juan de Dios', '02202-434822', '156-0960337 (338*1867)', '4627-6411/14', '', 'jutmen@yahoo.com.ar'),
(422, 'Mendoza Cristian Esteban', '4386-0599 (abuela)', '', '', '', 'cristianmendoza83@hotmail.com'),
(423, 'Mendoza Daniel', '4459-1769', '155-0280001', '', '', 'tucumendoza@hotmail.com'),
(424, 'Mereghetti Alberto', '4568-6331', '', '4384-6771', '', 'signosmere@hotmail.com.ar'),
(425, 'Mermoz Daniel Alejandro', '4285-6991', '155-9287080', '', '', 'danimermoz@yahoo.com.ar'),
(426, 'Metola Leandro Mauricio', '4759-9903', '155-9543500', '', '', 'lemau777@yahoo.com.ar'),
(427, 'Miceli Ariel Alejandro', '0221-4502082', '0221-155409176', '0221-4505924', '', 'ariel.afa@sverker.com.ar'),
(428, 'Michelon Emir Dario', '03489-422774', '03489-15558933', '03489-425358', '', 'emirmichelon@hotmail.com'),
(429, 'Milei Mariano', '', '154-0249002', '', '', 'mmilei@yahoo.com.ar'),
(430, 'Millenaar Juan Pablo', '4210-2237', '155-3130934', '4210-2237', '', 'juanpimillenaar@hotmail.com'),
(431, 'Milone Daiana Leonela', '4240-6837', '156-6544942', '', '', 'daiana_milone@hotmail.com'),
(432, 'Milone Juan', '4203-2134', '154-4162495', '4240-5465', '', 'alesuka@hotmail.com'),
(433, 'Miranda Enrique', '4243-2632', '', '4347-8142', '', ''),
(434, 'Molina Diego Martin', '4276-1084', '155-3332455', '5648-6321', '', 'diegomartinmolina@hotmail.com'),
(435, 'Molina Rodrigo Ariel', '4697-2056', '153-0432589', '', '', 'roar_molina@hotmail.com'),
(436, 'Molinelli Diego Martin', '4662-9079', '155-6573624', '', '', 'diegorcd@gmail.com'),
(437, 'Monsalvo Americo', '4648-2606', '154-1763742 (570*2351)', '4821-1001', '', 'americomonsalvo@yahoo.com.ar'),
(438, 'Montello Duilio', '2050-8164', '155-1499170', '', '', 'montelloduilio@yahoo.com.ar'),
(439, 'Morandi Gabriel', '4464-1625', '155-306-4550 (167*3670)', '4717-0500', '', 'moranogue@yahoo.com.ar'),
(440, 'Morbidoni Martin Ezequiel', '4222-9278', '156-5107984', '', '', 'rulo_elrubbier@hotmail.com'),
(441, 'Moreno Dario Damian Osvaldo', '4694-8076', '155-0984119', '4484-4322', '', 'dario_damian79@hotmail.com'),
(442, 'Moreno Guillermo', '4222-3054', '154-9167114', '4296-1545', '', 'jguillermomoreno@hotmail.com.ar'),
(443, 'Moreno Juan', '4628-9460', '', '', '', ''),
(444, 'Moreyra Andres', '4925-6968', '', '', '', ''),
(445, 'Moreyra Jose Victoriano', '', '156-9422730', '', '', 'jozemi1984@hotmail.com'),
(446, 'Mostaccio Pablo', '', '0221-155732816', '0221-4781560', '', 'pmostaccio74@hotmail.com'),
(447, 'Mounes Augusto', '4636-1265', '', '4701-0148', '', ''),
(448, 'Muller Max', '4293-3119', '156-7344917', '', '', 'maaxx_7@hotmail.com'),
(449, 'Muñoz Diego Sebastian', '', '155-4153233', '4747-4159 int. 26', '', 'diego_dsm@ciudad.com.ar'),
(450, 'Muñoz Nazareno Jorge Julian', '4803-8999', '02346-15408778', '', '', 'lanueva_2006@hotmail.com'),
(451, 'Naon Jorge', '4757-7514', '154-9982534', '4712-7196', '', ''),
(452, 'Navarro Richa Richard Luis', '', '0221-154980192', '', '', 'lulo_bc2003@hotmail.com'),
(453, 'Negrete Marcelo', '3684-7800', '155-2480580 (565*231)', '', '', 'marceloanegrete@yahoo.com.ar'),
(454, 'Negrete Mariano Andres', '4902-3972', '153-1531155', '48993500 int.3846', '', 'marianonegrete@hotmail.com'),
(455, 'Nicolini Adrian edgardo', '0221-4890851', '0221-156006217', '', '', 'nicolini.adrian@yahoo.com.ar'),
(456, 'Noguera Miguel Angel', '4274-2143', '15-20166076', '', '', 'angel_m_607@hotmail.com'),
(457, 'Noli Rubén', '0221-479-0630', '0221-155676870', '0221-4230461', '', 'rubennoli@hotmail.com.ar'),
(458, 'Noriega Ruben Alejandro', '4276-1051', '156-6650176', '', '', 'aletotnhosen@hotmail.com'),
(459, 'Nosach Facundo Martin', '4203-1607', '15-34525471', '', '', 'facundonosach@live.com.ar'),
(460, 'Nuñez Leandro Francisco', '4205-7658', '156-5334450', '', '', 'leandro_arbitro@yahoo.com.ar'),
(461, 'O'' Neille Ricardo', '4581-9768', '153-1133658', '', '', ''),
(462, 'Occhuzzi Jesus Alberto', '0237-4601566', '155-8510766', '', '', 'jesus_occhuzzi@hotmail.com'),
(463, 'Ojeda Federico Hernan', '4773-7623', '155-1121719', '4317-6381', '', 'chunflo@hotmail.com'),
(464, 'Olague Oscar Ruben', '4214-0545', '154-1853745', '', '', 'fliaolague@infovia.com.ar'),
(465, 'Olivera Nestor Fabian', '', '156-8817797', '', '', ''),
(466, 'Orellana Damian Alejandro', '4485-6971', '153-2938593', '4716-6495/2279', '', 'fragatadamian@hotmail.com'),
(467, 'Orlando Augusto Daniel', '4762-2186', '15-40956429', '', '', 'augustoorlando@yahoo.com.ar'),
(468, 'Ortega Javier German', '4484-0394', '153-1738771', '', '', 'javi_d_v10@hotmail.com'),
(469, 'Ortego Cristian Marcelo', '4749-6327', '155-1799013', '', '', 'cristianortego@yahoo.com.ar'),
(470, 'Ortiz Fernando', '02224-470112', '156-6407279', '', '', 'ortizfernando_1990@hotmail.com'),
(471, 'Ortiz Hernandez Luis', '4522-1167', '', '4571-5639', '', ''),
(472, 'Ortiz Ramon Abraham', '', '156-4744366', '', '', 'ramonortiz_1987@hotmail.com.ar'),
(473, 'Otero Edgar', '4524-0923', '153-4083680 (612*4912)', '4132-2081', '', 'edgaro@arnet.com.ar'),
(474, 'Otero Rodolfo', '4206-9223', '154-1880876', '', '', 'rudiotero@hotmail.com.ar'),
(475, 'Ozuna Lucas Ezequiel', '4205-3641', '152-1729175', '', '', 'ozu_lucas@hotmail.com'),
(476, 'Pabon Daniel', '4637-4661', '155-1199880', '', '', 'danielpabon@tutopia.com'),
(477, 'Padilla Ruben', '4682-9679', '154-5287136', '4952-1850 o 4953-381', '', ''),
(478, 'Paez Hugo', '02202-432584', '155-1761695 (587*4566)', '02202-432584', '', 'hugonorbertopaez@hotmail.com.ar'),
(479, 'Paez Norberto', '02202-422296', '', '02202-433017', '', ''),
(480, 'Pafundi Juan Ignacio', '4522-4492', '156-2953737 (699*616)', '', '', 'jipafundi@hotmail.com'),
(481, 'Pafundi Rodrigo', '4522-4492', '156-2926666', '', '', 'rodrigo.pafundi@aemedia.com.ar'),
(482, 'Paletta Héctor Alberto', '4233-8596', '155-5639714 (338*7713)', '4480-0120', '', 'hpale11@hotmail.com'),
(483, 'Palma Juan', '0221-4700063', '0221-154631811', '', '', 'jumapalma@hotmail.com'),
(484, 'Pandolfelli Cristian', '4765-7892', '153-0811657', '4765-3698/4721-6425', '', 'cristian.pandolfelli@citi.com'),
(485, 'Papa Eduardo', '4924-4131', '154-974-5884', '4921-8910 / 4922-997', '', ''),
(486, 'Pardo Lucas Fernando', '4758-4182', '156-2364013', '4713-1795', '', ''),
(487, 'Parragues Ismael', '4627-0191', '156-9708598', '4483-0246', '', 'ismaelparrgues@hotmail.com'),
(488, 'Pascualino Ruben', '4209-1145', '155-481-5382', '4225-1803/1376', '', 'ofipel@uolsinectis.com.ar'),
(489, 'Pastor Juan Pablo', '0221-4864412', '156-8703226', '', '', 'jhuanpablo@hotmail.com'),
(490, 'Pastori Marcelo Cesar', '0221-4723680', '0221-156016974', '', '', 'marcelopastori@yahoo.com.ar'),
(491, 'Pasturenzi Luis', '', '154-4107895', '4382-1068', '', 'luispasturenzi@yahoo.com.ar'),
(492, 'Pataro Mario', '4785-4603', '', '4555-7317', '', ''),
(493, 'Pate Fabio', '4696-3716', '156-9816281', '', '', 'fabio.pate@yahoo.com.ar'),
(494, 'Paz Roberto Eduardo', '4467-3125', '152-1773072', '', '', 'pazroberto1@hotmail.com'),
(495, 'Pena Garcia Andres Daniel', '4367-5642', '155-4596913', '4232-0610', '', 'andrespenagarcia84@hotmail.com'),
(496, 'Penel Ariel', '4262-9373', '154-0334950', '', '', 'arielpenel1@yahoo.com.ar'),
(497, 'Pennissi Marcos Adrian', '4751-3343', '155-7184773/156-2412883', '', '', 'marcospennisi@hotmail.com'),
(498, 'Pentrelli Luis Roberto', '4702-4723', '15-40261143', '4338-6757/58/52', '', 'luispentrelli@fibertel.com.ar'),
(499, 'Penzotti Gustavo', '4714-6892', '155-1856608 (335*171)', '', '', 'gustavopenzotti@hotmail.com.ar'),
(500, 'Peña Pablo', '4642-8119', '155-6352717', '', '', 'afapachu@yahoo.com.ar'),
(501, 'Peñamaria Alejandro Nicolas', '', '154352221', '', '', 'ale_penia_88@hotmail.com'),
(502, 'Peñin Castillo Mario', '4450-7331', '156-1112990', '', '', 'mario_penin@hotmail.com.ar'),
(503, 'Peralta Agustin Ariel', '4250-2524', '1553401519', '', '', 'aaperalta@bpba.com.ar'),
(504, 'Peralta Catrian', '4847-1995', '156-2635729', '', '', 'cato2411@gmail.com'),
(505, 'Pereira Gonzalo', '4461-6249', '153-3609820', '', '', 'gonzalo.pereira@live.com'),
(506, 'Pereira Juan Francisco', '4489-5057', '156-4558930', '4339-0800 int.1270', '', 'jfp9403@hotmail.com'),
(507, 'Pereira Juan Martin', '4489-5057', '153-2096477', '', '', 'juandeboedo_147@hotmail.com'),
(508, 'Perez Abel', '4286-1739', '', '4249-7879', '', 'ofipelimprenta@ciudad.com.ar'),
(509, 'Perez Aldo', '4257-8456', '154-0728098', '4704-8203', '', 'aldoperez_afa@hotmail.com'),
(510, 'Perez Marcelo', '4644-2827', '154-4967939', '4347-8291', '', 'MGPerez@bna.com.ar'),
(511, 'Persico Adrian', '4275-8007', '156-0923593 (525*433)', '4229-0100 i 261', '', 'adrian.o.persico@gmail.com'),
(512, 'Pérsico Jorge Guillermo', '4923-0778', '154-4084600', '', '', 'jorgepersico@hotmail.com'),
(513, 'Petrussa Carlos', '4203-3833', '', '4203-7224', '', ''),
(514, 'Petrussa Carlos Alberto', '', '155-0109941', '', '', 'carlospetrussa@gmail.com'),
(515, 'Picon Carlos', '', '154-9861824', '02320-555555', '', ''),
(516, 'Pigni Nicolas', '03489-426151', '03489-15546012', '', '', 'pignin@msn.com'),
(517, 'Pizzini José', '4286-1739', '', '4249-7879', '', ''),
(518, 'Polantinos, Manuel', '4641-1151', '15-41419471', '', '', ''),
(519, 'Pomi Federico', '4371-4177', '153-2018667', '', '', 'federicopomi@yahoo.com.ar'),
(520, 'Ponteprino Nicolas Andrés', '4611-4820', '153-3228760/153-7267069', '', '', 'elgalpondelferrolano@hotmail.com'),
(521, 'Porticella Alejandro Pedro', '4639-2183', '156-6189487', '', '', 'porticella@hotmail.com'),
(522, 'Possi Yamil', '4203-1406', '156-9870262 (568*3294)', '', '', 'possiyamil@hotmail.com'),
(523, 'Pozzi Patricio Fernando', '4254-2013', '152-2200777', '', '', 'pato_pozzi_afa@hotmail.com'),
(524, 'Prendel Andres', '02923-407853', '02923-473438', '02923-473438', '', 'persichiniprendel@sion.com'),
(525, 'Prieto Julio Raul', '4951-1986', '155-9340009', '4951-6092', '', 'raulprieto@fibertel.com.ar'),
(526, 'Prieto Mario', '0221-4712648', '0221-155673939', '', '', 'mprietoafa@yahoo.com.ar'),
(527, 'Prieto Ricardo Martin', '4225-0120', '155-7347804', '4310-5670', '', 'ricardomprieto@yahoo.com.ar'),
(528, 'Provera Leandro Hernan', '4746-2397', '156-7688535', '', '', 'leandrohprovera@hotmial.com'),
(529, 'Qualizza Carlos', '4637-6758', '155-7359651', '', '', 'carlosdanielqualizza@yahoo.com.ar'),
(530, 'Quiroga Christian Gonzalo', '3531-2873', '152-4826923', '', '', 'christiangonzaloquiroga@hotmail.com'),
(531, 'Quiroga Fabio', '4353-3354', '156-7598269 (612*536)', '4320-6700 INT.1510', '', 'fquiroga133@hotmail.com'),
(532, 'Quiros Fabian Luis', '4206-4851', '154-4351583', '4224-4095', '', 'fabi_fito@hotmail.com'),
(533, 'Quiros Luis', '4206-4851', '', '', '', ''),
(534, 'Rabinovich Jose', '', '154-9938451', '4720-1034/4729-2228', '', 'joserabinovich@uolsinectis.com'),
(535, 'Raineri Sebastian', '4755-2488', '155-8845961', '', '', 'sebaraineri@hotmail.com'),
(536, 'Rallo Luis Gaston', '4300-0170', '156-2935016', '4292-5888', '', 'gastonrallo@yahoo.com.ar'),
(537, 'Ramirez Alejandro Daniel', '02202-435045', '155-6360614', '', '', 'alejandrodramirez@hotmail.com'),
(538, 'Ramirez Luis', '4282-7162', '', '4283-1851/0513', '', ''),
(539, 'Ramirez Maximiliano Nicolas', '02202-456318', '155-6171029', '', '', 'nicoto_ra@hotmail.com');
INSERT INTO `dbarbitros` (`idarbitro`, `nombrecompleto`, `telefonoparticular`, `telefonoceleluar`, `telefonolaboral`, `telefonofamiliar`, `email`) VALUES
(540, 'Ramos Errasti Mauro Lucas', '02478-452640', '02478-15508090', '', '', 'arbitrosmauroramos@yahoo.com.ar'),
(541, 'Rapallini Fernando Andres', '0221-4270356', '0221-154083352', '', '', 'fefofutbol@hotmail.com'),
(542, 'Rassullo Gianelli Nahuel Santiago', '4222-2745', '155-6121447', '', '', 'nahuelrgianelli@hotmail.com'),
(543, 'Rastelli Adrian', '4605-8882', '156-1565868', '4918-7104', '', 'adrianhugo_rastelli@yahoo.com.ar'),
(544, 'Rattalino Jorge', '0237-4831028', '154-9481421', '02320-5555555', '', 'rattalinoj@yahoo.com.ar'),
(545, 'Re Hugo', '4613-5365', '', '4332-5342/5345', '', ''),
(546, 'Rebollo Juan', '4712-2538', '156-0589169', '', '', 'juancarlosrebollo@yahoo.com.ar'),
(547, 'Rebuscini Angel Daniel', '4288-2822', '155-0383037', '4288-2822', '', ''),
(548, 'Reinoso Daniel Alejandro', '4720-869', '155-7350153', '', '', 'danielalejandroreinoso@yahoo.com.ar'),
(549, 'Remaggi Flavio', '03487-436976', '03489-155-48970', '03489-433242/450451', '', 'flaviohugoremaggi@gmail.com'),
(550, 'Rey Hilfer Leandro Ezequiel', '4842-6619', '155-1656045', '', '', 'leandroezequiel@yahoo.com.ar'),
(551, 'Riccio Diego Gaston', '4451-5788', '156-1764364', '4627-0090', '', 'riccioafa@hotmail.com'),
(552, 'Rietti Guillermo', '4623-9536', '154-5589497', '4788-9400', '', 'grietti@uolsinectis.com.ar'),
(553, 'Ripoli Lucas Martin', '4701-3814', '153-6040530', '', '', 'lucasripoli@gmial.com'),
(554, 'Rivas Gustavo', '4450-6698', '', '', '', 'gustavoa_rivas@yahoo.com.ar'),
(555, 'Rivas Miguel Hector', '5291-4725', '155-9259099', '', '', ''),
(556, 'Rivolta Gabriel', '4289-4619', '', '4245-4020', '', ''),
(557, 'Rizzo Juan', '4567-2608', '156-3603528', '', '', ''),
(558, 'Robledo Carlos', '4211-1123', '', '', '', 'carlosrobledo@mixmail.com'),
(559, 'Rocchio Francisco', '4251-1670', '154-9375743 (418*4127)', '4651-3563/4441-0824', '', 'fsrocchio@gmail.com'),
(560, 'Rocco Maria Eugenia', '4226-9907', '155-8213971', '', '', 'eugeniarocco@yahoo.com.ar'),
(561, 'Rodriguez Battaglia Nestor', '4431-5017', '154-0544214', '4642-0647', '', ''),
(562, 'Rodriguez Carlos', '4729-0522', '', '4311-2878', '', ''),
(563, 'Rodriguez Diego Damian', '4254-7205', '155-3120775', '', '', 'diegorodriguez@hotmail.com'),
(564, 'Rodriguez Fernando Daniel', '', '153-0919155', '', '', 'rodriguezfernando7@yahoo.com.ar'),
(565, 'Rodriguez Lazarte Diego Jesus', '02224-476633', '153-3371694', '', '', 'diego8787@hotmail.es'),
(566, 'Rodriguez Raul Antonio', '4751-8717', '155-0640043', '4659-1555', '', ''),
(567, 'Roffe Jose', '4503-3243', '155-054-5271', '', '', ''),
(568, 'Rohr Pedro', '4462-1359', '156-7160346', '', '', ''),
(569, 'Rojas Roberto', '4791-8559', '155-6576726', '4753-7295', '', ''),
(570, 'Rolando Juan', '4631-6785', '', '', '', 'juanalbertorolando@gmail.com'),
(571, 'Roldan Ariel Pablo', '4903-0206', '153-7783234', '', '', 'rojo2609@yahoo.com.ar'),
(572, 'Romano Daniel', '4760-2439', '155-1819795', '4433-2550/8275', '', 'deromano@ciudad.com.ar'),
(573, 'Romeo Federico Bernardo', '4767-6327', '155-9753338', '', '', 'federicoromeo2003@yahoo.com.ar'),
(574, 'Romero Diego Oscar', '4282-2783', '155-6950970', '4273-2936', '', 'diego_romero05@hotmail.com'),
(575, 'Romero Diego Pablo', '4281-4303', '15-55092793', '4283-2797', '', 'romeritodiego@hotmail.com'),
(576, 'Romero Jorge Carmelo', '4293-6572', '154-0712114', '', '', ''),
(577, 'Romero Jorge Eduardo', '', '153-6056419', '4244-2787', '', ''),
(578, 'Romero Lautaro', '4795-5674', '156-1899294', '', '', 'lautiromero@hotmail.com'),
(579, 'Romo Mariano Jose', '4626-3842', '153-0658987', '', '', 'romo_mariano@hotmail.com'),
(580, 'Ronzitti Cesareo', '4504-3721', '154-029-5617', '', '', 'cesareo122@hotmail.com'),
(581, 'Rosaminier Nicolas', '4294-4093', '154-4208748', '4334-3234', '', 'nicorasaminier@hotmail.com'),
(582, 'Rosano Diego Osvaldo', '3970-9369', '15-50446240', '4866-2933/2959 int 3', '', 'diegorosano@hotmail.com'),
(583, 'Rosati Facundo Martin', '0221-4232243', '0221-6423013', '', '', 'rosatifacundo@hotmail. Com'),
(584, 'Rossetti Luis', '4722-0554', '', '4768-3476', '', ''),
(585, 'Rossetti Mariano', '4722-0554', '156-6656507', '', '', 'marianoross79@hotmail.com'),
(586, 'Rossi Claudio', '4666-3803', '155-4239343', '4372-8187', '', 'rossic@ciudad.com.ar'),
(587, 'Rotman Luis Federico', '4904-0631', '155-3352676', '', '', 'luisrotmanaaa@hotmail.com'),
(588, 'Rozenszajn Gustavo', '4582-6794/4542-4292', '156-7900025', '', '', 'gusrozen@yahoo.com.ar'),
(589, 'Ruas Juan Carlos', '4941-8923', '', '0221-429-7100', '', ''),
(590, 'Ruas Mariano', '4942-0971', '155-3848399', '4931-1233', '', 'portobelo2003@yahoo.com.ar'),
(591, 'Rubino Damian', '4911-0648', '155-010-1855', '', '', 'damianrubino2004@yahoo.com.ar'),
(592, 'Ruffo Leonardo Javier', '4942-9025', '155-9800257', '', '', 'leo08081983@hotmail.com'),
(593, 'Ruiz Omar', '4768-7513', '155-6989299', '', '', 'omarruizhoracio@hotmail.com'),
(594, 'Ruiz, Javier', '4290-2635', '156-3993547', '', '', ''),
(595, 'Sabini Rodrigo Mario', '02322-464373', '156-4843835', '', '', 'rodrigo_sabini@yahoo.com.ar'),
(596, 'Sacco Oscar', '4431-5017', '154-0544214', '', '', ''),
(597, 'Salcedo Emilio', '4252-2964', '', '', '', ''),
(598, 'Salvador Pablo', '0220-4837286', '154-0967906', '4310-1363/65', '', 'pablosalvador111@hotmal.com'),
(599, 'Sanabria Osvaldo', '4223-2723', '154-1867752', '4374-3515', '', 'osanabria2graricacorrientes.com.ar'),
(600, 'Sanchez Angel O', '4924-3246', '155-0484815', '4208-5555', '', 'angelosvaldosanchez@hotmail.com'),
(601, 'Sanchez Lorena Elizabeth', '', '155-5287344', '', '', 'loreley_toto@hotmail.es'),
(602, 'Sanchez Marcelo', '4265-2112', '', '', '', ''),
(603, 'Sanchez Victor', '4775-3405', '15-41691538', '', '', 'vipesan42@yahoo.com.ar'),
(604, 'Sandanella Amilcar', '4738-2759', '153-7944844', '4553-7800', '', 'amilcarsanda@hotmail.com'),
(605, 'Sande Nicolás', '4788-9041', '156-3652397 (153*9887)', '', '', 'nicolimp@hotmail.com'),
(606, 'Sanmartino Cristian Marcelo Eugenio', '4923-3666', '155-1396994', '', '', 'familiasammartino@fullzaero.com'),
(607, 'Santamaria Dario Javier', '4844-1482', '156-1048172 (547*1851)', '', '', 'santamariadario@hotmail.com'),
(608, 'Santanocito Nahuel Ezequiel', '4240-1864', '153-1585478', '', '', 'fliasanta@hotmail.com'),
(609, 'Santillan Guillermo Adrian', '0221-4724541', '0221-154816089', '0221-471-1676', '', 'guillermosantillanafa@yahoo.com.ar'),
(610, 'Santos Enrique', '4631-1902 (hermana)', '154-1433205', '', '', ''),
(611, 'Saputo Leopoldo Damian', '4840-1767', '155-8138089', '', '', 'leosaputo@hotmail.com'),
(612, 'Saravia Pablo Rodrigo', '0221-4259367', '0221-156146358', '', '', 'saravia_arbitro@yahoo.com.ar'),
(613, 'Savoiardo Jonatan Ezequiel', '4626-3700', '153-2638331', '', '', 'savoiardo2002@hotmail.com'),
(614, 'Scalerandi Santiago Agustin', '4283-2746', '155-7210430', '', '', 'santiago.agustin.scalerandi@hotmail.com'),
(615, 'Schelotto Gabriel Hernan', '02224-490141/5238098', '156-8276769', '1551855976', '', 'schelott@dd.com.ar'),
(616, 'Schmeigel Marcelo', '4637-7448', '', '4958-1213', '', ''),
(617, 'Schulz Lucas', '', '1532189550', '', '', 'lucas_schulz88@hotmail.es'),
(618, 'Sciancalepore Juan', '0220-4838514', '155-3064538 (167*3669)', '4717-0500', '', 'jsciancalepore@ hotmail.com'),
(619, 'Scime Ariel Mariano', '4643-2095', '156-3812389 (633*1607)', '4641-0365', '', 'ascime@live.com.ar'),
(620, 'Scorza Cristian Ariel', '155-9295037 (referen', '153-5372251', '4644-0503', '', 'scorza.cristian@bancocolumbia.com.ar'),
(621, 'Scotto D'' Abusco Vicente', '4208-3289', '155-1816650', '4208-0112', '', 'ventas@imprefin.com.ar'),
(622, 'Seco Mariano Gaston', '4571-0538', '153-1878500', '', '', 'mg_seco@hotmail.com'),
(623, 'Segault Roberto Raimundo', '4283-2799', '', '', '', ''),
(624, 'Segeres, Juan Carlos', '4912-3503', '156-5282686', '', '', ''),
(625, 'Silva Pablo', '4278-4583', '156-9459317', '4200-1683 4202-3532', '', 'saliamoverte@yahoo.com.ar'),
(626, 'Sinnot Patricio', '4760-3589', '', '', '', ''),
(627, 'Sliwa Alejandro', '4694-1522', '1541974685', '4626-8208', '', ''),
(628, 'Sobral Diego', '4755-3705', '155-9773693', '', '', 'diegofernandosobral@yahoo.com.ar'),
(629, 'Soldini Guillermo', '0221-4706011', '0221-154631278', '4730-1000', '', ''),
(630, 'Sole Rodrigo Emanuel', '4504-4560', '155-3896941', '', '', 'rodriafa@hotmail.com'),
(631, 'Soravito Juan Manuel', '4762-3795', '155-8241947', '4010-9050', '', 'jsoravito@hotmail.com'),
(632, 'Spinatto Juan', '0221-484-1734', '0221-155767805', '0221-4271001 int. 13', '', 'spinnatojuan@yahoo.com.ar'),
(633, 'Stelmaszczuk Jonathan Jesus', '4317-4088', '1557614513', '', '', 'stelma16@argentina.com'),
(634, 'Stewart Usher Diego Ricardo', '03327-452503', '155-054-9069', '', '', 'drsu@yahoo.com.ar'),
(635, 'Stewart Usher Octavio', '03327-447841', '03488-15437644', '', '', 'omsuarb@hotmail.com'),
(636, 'Stoklas Carlos Horacio', '4223-0286', '153-3571168', '706*838', '', 'carloshstoklas@yahoo.com.ar'),
(637, 'Suarez Ariel Gaston', '4725-3439', '155-1011410 (612*4908)', '', '', 'arielgastónsuarez@yahoo.com.ar'),
(638, 'Suarez Carlos Ariel', '0222-4425036', '156-0178232', '02224-433338', '', 'arielsuarez83@hotmail.com'),
(639, 'Suarez Cristian German', '4700-0260', '155-5160859', '', '', 'cristianpelu919@hotmail.com'),
(640, 'Suero alejo', '4797-2678', '153-4575500', '', '', 'sueroalejo@hotmail.com'),
(641, 'Sugliani Ricardo', '02320-427701', '15-54107205', '02320-585903', '', 'rsugliani@yahoo.com.ar'),
(642, 'Taddeo Gilberto', '4431-9553', '155-0980959', '4923-0950/2427', '', 'gilbertos@arnet.com.ar'),
(643, 'Taibi Ernesto', '4523-4296 4545-7662', '154-4451202', '4523-4371/4296', '', 'etaibi2002@yahoo.com.ar'),
(644, 'Tebele Gaston Ariel', '4583-9112', '156-4937685', '', '', 'tongaacademico@hotmail.com'),
(645, 'Tejeda Luciano Javier', '4273-2091', '1521656767', '', '', 'lucianotejeda@gmail.com'),
(646, 'Tello Raul', '0220-4853050/4829576', '156-9661125', '0220-482-9576/1837', '', ''),
(647, 'Toia Alejandro', '', '155-7247644 (612*4909)', '', '', 'alejandrotoia@yahoo.com.ar'),
(648, 'Torres Diego Ignacio', '4760-4930', '153-2432328', '', '', 'diegotorres95@hotmail.com'),
(649, 'Torres Nestor', '4760-4930', '155-0370110', '4964-2333', '', 'nestorotorres@yahoo.com.ar'),
(650, 'Trachsler Gustavo Guillermo', '4262-4929', '', '', '', ''),
(651, 'Tronnes Daniel', '4957-5104', '155-0461029', '4957-3456', '', 'danieltronnes@yahoo.com.ar'),
(652, 'Trovato Diego Salvador', '20665967', '156-2464325', '', '', 'diegotrovato@hotmail.com'),
(653, 'Urquiza Ricardo', '4202-5234', '', '4292-9987/8175', '', ''),
(654, 'Urso Martin Gabriel', '4443-2529', '156-4717200', '', '', 'martinurso@hotmail.com'),
(655, 'Urtiaga Fabian', '0237-4816251', '154-9499069', '', '', ''),
(656, 'Vaca Hector', '4464-3625', '154-1682614', '', '', ''),
(657, 'Vaccaro Martin Daniel', '4687-6582', '155-0574884', '', '', 'martinvaccaro82@hotmail.com'),
(658, 'Vaiser Ruben', '4611-2426', '154-4284965', '4378-2600', '', ''),
(659, 'Valenzuela Yamil', '', '156-7191836', '', '', 'el.gros_yamil@hotmail.com'),
(660, 'Varela Julio', '', '155-9228549/1533425708', '', '', 'juvava@hotmail.com'),
(661, 'Vassarotto Sebastian Alberto', '', '153-1262288', '', '', 'sebastianalbertovassarotto@personal.com.ar'),
(662, 'Vazquez Daniel', '4832-5484', '154-4741880', '', '', 'daneva45@hotmail.com'),
(663, 'Vazquez Ignacio', '4951-4096', '155-8314327', '', '', ''),
(664, 'Vazquez Juan Manuel', '154-1580030', '152-1767257', '', '', 'juanmanuelvazquez7@hotmail.com'),
(665, 'Velarde Fernando', '', '155-0640130', '', '', 'fernando@futbolpasion.com'),
(666, 'Velardez Pablo Javier', '4271-0587', '156-3513784', '', '', 'javier89_18@hotmail.com'),
(667, 'Venturi Adrian', '4521-9234', '155-8151000', '4309-2634', '', 'aventuri@gasnaturalbar.com.ar'),
(668, 'Vercellini Daniel', '4458-4069', '', '4942-1208', '', ''),
(669, 'Verlotta Diego Alejandro', '4787-1987', '156-9753910', '4762-0482', '', 'diegoalear@yahoo.com.ar'),
(670, 'Veron Julio Cesar', '4298-9045', '156-0064169', '', '', 'jcveron78@ciudad.com.ar'),
(671, 'Viera Emanuel Alejandro', '', '156-6939511', '', '', 'emma_abril@hotmail.com'),
(672, 'Vieta Leandro Ariel', '02202-428514', '155-8707211', '', '', 'vietaleandro@hotmail.com'),
(673, 'Vigil Daniel', '4766-6835', '', '', '', ''),
(674, 'Vigliano Jorge', '0221-4210850', '', '', '', ''),
(675, 'Vigliano Mauro', '0221-4752463', '0221-155660067', '0221-4834641', '', 'maurovig@hotmail.com'),
(676, 'Vigliano Paulo', '0221-4210850', '0221-155906936 (684*3678)', '', '', 'paulovig@hotmail.com'),
(677, 'Vila Diego Eduardo', '4284-2261', '155-505-6373', '4286-4273', '', 'diegovilaafa@hotmail.com'),
(678, 'Villagran Manuel Andres', '4273-7322', '156-4042107', '', '', 'villagranmanuel29@hotmail.com'),
(679, 'Villalva Rodrigo Leonardo', '3533-6509', '156-2608377', '', '', 'leonardo.villalva@gmail.com'),
(680, 'Villanueva Bellotti Cesar', '', '0221-154386930', '', '', 'parleco@hotmail.com'),
(681, 'Villarreal Daniel Gabriel', '2202425683', '153-4825262', '', '', 'dani95_25@hotmail.com'),
(682, 'Villarreal Gabriel', '4466-3695', '156-9896137 (605*4963)', '4361-4526/4362-3369', '', 'gabriel_8764@hotmail.com'),
(683, 'Viñas Dardo Felix', '4522-7518', '15 5-4859343', '', '', 'dfavinas@yahoo.com.ar'),
(684, 'Viola Sergio', '0221-4525516', '0221-155244704', '', '', 'srviola69@yahoo.com.ar'),
(685, 'Visconti Jonatan', '4226-8135', '156-4001319', '', '', 'jonatanvisconti@hotmail.com'),
(686, 'Vittadello Leonardo Alberto', '0220-4940406', '155-5047442', '0220-4941713', '', ''),
(687, 'Walter Mauro', '4671-1117', '154-1465763', '5129-0641', '', 'waltermauro@hotmail.com'),
(688, 'Yañez Mariano Javier', '4755-5837', '156-8296455', '4862-9541', '', 'mariano_javier_10@hotmail.com'),
(689, 'Yasinski Ezequiel Matias', '4622-9065', '1568937428', '', '', 'eze_0801@hotmail.com'),
(690, 'Zamora Edgardo Daniel', '4476-1371', '155-6029423', '', '', 'danielzamora111@yahoo.com'),
(691, 'Zanella Marco', '4826-4000', '154-1414249', '', '', 'zanellakohli@yahoo.com.ar'),
(692, 'Zanella Tito', '0237-4664032', '156-1806802', '4765-9507', '', ''),
(693, 'Zechillo Pablo', '', '155-6074241', '4311-4035', '', 'pablozechillo@hotmail.co'),
(694, 'Zitnik Mateo', '4276-1121', '', '', '', ''),
(695, 'Zoratti Sergio', '4522-8074', '153-5611367', '', '', 'sergiozoratti@hotmail.com'),
(696, 'Zundel Mauricio', '4116-3483', '154-993-1348', '4303-1565/2360', '', 'mjzundel@hotmail.com'),
(697, 'Zunino Manuel Salvador', '4656-3840', '153-1604266', '', '', 'manuelsz4@hotmail.com'),
(698, 'Zunino Sebastian Alejandro', '4443-8820', '156-4059711', '', '', 'sebastano_8@hotmail.com'),
(699, 'Zylberberg Fernando Nahuel', '4779-2973', '155-3240830', '', '', 'fernandozylberberg@hotmail.com'),
(700, 'Abal Leonardo Lorenzo', '', '153-32133470', '', '', ''),
(701, 'Abella Gustavo', '4267-9663', '155-5701471', '', '', ''),
(702, 'Acevedo Juan Manuel', '', '156-1526309', '', '', ''),
(703, 'Aguilar Gustavo', '4222-1439', '156-6819750', '', 'padres 4236-3968', ''),
(704, 'Albarenga Rodolfo Roque', '02304-670887', '155-5667823', '', '', ''),
(705, 'Alegre Kevin', '3979-9620', '155-8264063/1551326051', '', '', ''),
(706, 'Alvarez Carlos Gerardo', '4203-2323', '153-2729963', '', '', ''),
(707, 'Amarilla Cristian', '4236-0674', '1534810804', '', '', ''),
(708, 'Amiano Alejandro', '2073-2445', '153-0464376', '', '', ''),
(709, 'Amurua German Ezequiel', '4250-9362', '155-7983351', '', '', ''),
(710, 'Andrada Javier Alejo', '4750-6768', '154-1972936', '', '', ''),
(711, 'Andreoni Leonel Ezequiel', '4277-1857', '154-4001225', '', '', ''),
(712, 'Anria Alan Leonardo', '4848-2085', '156-4470003', '', '', ''),
(713, 'Aragona Gabriel', '4744-1555', '156-7624453/1564662501', '', '', ''),
(714, 'Aragonez Matias Ezequiel', '4923-2773', '156-7957638', '', '', ''),
(715, 'Arcos Juan Ignacio', '4635-6848', '155-9247516', '', '', ''),
(716, 'Arebalo Facundo', '4250-5148', '156-7227276', '', '', ''),
(717, 'Arebalo Luis', '4280-5946', '156-5993226', '', '', ''),
(718, 'Armesto Maximiliano', '4844-6634', '156-0584610', '', '', ''),
(719, 'Artiles Elbio Emmanuel', '4264-1230', '156-3008399', '', '', ''),
(720, 'Baez Aldo', '4221-5613', '153-8943633', '', '', ''),
(721, 'Baez Luis', '', '154-4378725', '', '', ''),
(722, 'Balsas Luciano Ezequiel', '45637-0526', '155-0271379', '', '', ''),
(723, 'Bariulo Wadislavo Dario', '4217-1923', '153-3782423', '', '', ''),
(724, 'Barrientos Julian', '', '156-6953113', '', '', ''),
(725, 'Benitez Juan Carlos', '', '155-5964911', '4863-2663', '', ''),
(726, 'Bianco Julian', '4461-4147', '155-9593675', '', '', ''),
(727, 'Boan Leandro Daniel', '4642-9419', '153-0937731', '', '', ''),
(728, 'Brebbia Nahuel Nestor', '4202-5327', '1554962083', '', '', ''),
(729, 'Caballero de Fez Santos', '4921-0047', '153-6029010', '', '', ''),
(730, 'Cabral Sebastian Alejandro', '4714-4888', '155-4661990', '', '', ''),
(731, 'Cardozo Luis Nicolas', '0237-4872673', '156-5699194', '', '', ''),
(732, 'Caro Gabriel', '4459-5006', '155-0570689', '', '', ''),
(733, 'Carrizo Mariano', '4367-8796', '155-8984735', '', '', ''),
(734, 'Castañares Chantal', '', '(02255) 15419964', '', '', ''),
(735, 'Castro Leandro', '4253-9388 (familiar)', '155-5052222', '', '', ''),
(736, 'Cejas Franco Eric', '4275-1516', '153-7760364', '', '', ''),
(737, 'Chadi David', '023204-74592', '153-5414864', '', '02320-4628161', ''),
(738, 'Chavez Hernan Ezequiel', '02202-454275', '155-5742469', '', '', ''),
(739, 'Cichero Jesus', '4459-3470', '15-5603-3603', '', '', ''),
(740, 'Colombo Lucas Ariel', '4452-8149', '156-7386260', '', '', ''),
(741, 'Cora Mauro', '', '1534751087', '', '4441-0259', ''),
(742, 'Correa Ricardo', '4840-0713', '153-8512337', '4844-7449', '4627-8980 (padres)', ''),
(743, 'Corro Claudio Gustavo', '2062-0437', '1562293653', '', '', ''),
(744, 'Cuellar Federico', '4653-1786', '156-0556101', '', '', ''),
(745, 'Cuenca Benito Santiago', '4481-8383', '156-6629749', '', '', ''),
(746, 'D''Agostino Javier', '4659-2366', '155-3310203', '', '4659-2366 (padres)', ''),
(747, 'De Bary Federico Agustin', '', '153-0729124', '', '', ''),
(748, 'De Freitas Matias', '', '156-0370359', '', '', ''),
(749, 'De San Pablo Leandro', '4650-5117', '156-3510400', '', '', ''),
(750, 'Della Mónica Daniel', '4241-3669', '155-1496759', '567*2710', '4923-5932', ''),
(751, 'Diaz Miguel Angel', '0220-4873994', '153-5958492', '', '', ''),
(752, 'Dinovitzer Flavio Gabriel', '4716-2867', '156-7624352', '804*2978', '', ''),
(753, 'Dobler Mauricio Blas', '02323-5877917', '02323-15635310', '', '', ''),
(754, 'Dotta Jose Luis', '4737-7708', '156-4892007', '', '', ''),
(755, 'Durante Christian David', '4464-6640', '153-4040044', '', '', ''),
(756, 'Falcon Cristian', '4274-1368/ 4274-0529', '154-1614835', '', '', ''),
(757, 'Fernandez Jorge Ariel', '', '155-6023936', '', '', ''),
(758, 'Ferreyra Wilfredo David', '0237-4860755', '153-7571969', '', '', ''),
(759, 'Fiori Pablo', '4228-2583', '154-1913517', '', '', ''),
(760, 'Florentin Jonathan', '', '155-8788504', '', '', ''),
(761, 'Freso Claudio', '4631-4178', '153-4330099', '', '', ''),
(762, 'Gaetani Gustavo Andres', '4716-5884', '156-2006733', '', '', ''),
(763, 'Garcia Nicolas Sergio R', '4221-3125', '156-2991877', '', '', ''),
(764, 'Garcia Pablo', '4911-1726', '156-3040171', '', '', ''),
(765, 'Gardella Franco Daniel', '4242-9835', '153-2150770', '', '', ''),
(766, 'Gerez Emiliano Hernan', '4200-7377', '153-4187187', '', '', ''),
(767, 'Gigante Hermes', '', '156-1421701', '', '', ''),
(768, 'Gil Daniel Alejandro', '', '152-1787218', '', '', ''),
(769, 'Gimenez Ignacio', '4353-2460', '152-4346147', '', '', ''),
(770, 'Gitel Nicolas', '2002-2107', '', '', '', ''),
(771, 'Gobbi Gonzalo', '6380-4120', '153-6432144', '', '', ''),
(772, 'Goldemberg Joel Yair', '4481-9747', '156-9609259', '', '', ''),
(773, 'Gomez Carmona Miguel', '02320-487757', '153-4276417', '', '', ''),
(774, 'Gomez Cristian Miguel', '4351-1469', '153-6419509', '', '', ''),
(775, 'Gomez Diego', '03484-473168', '156-7988956', '', '', ''),
(776, 'Gomez Mariano Hernan', '4764-4923', '155-7051552', '', '', ''),
(777, 'Gonzalez Cesar Alejandro', '4264-1160', '152-6379032', '', '', ''),
(778, 'Gonzalez Juan Gabriel', '0237-4852333', '156-8574507', '', '', ''),
(779, 'Grecco  Alberto', '4203-0803', '155-9304477', '', '', ''),
(780, 'Gugliotta Francisco', '4651-7944', '154-1492336', '', '', ''),
(781, 'Guidozzolo Nicolas', '4697-1366', '154-0978055', '', '', ''),
(782, 'Herrera Cristian Mariano', '4259-9499', '155-7035237', '', '', ''),
(783, 'Ifran Roque Gaston', '', '154-9160279', '', '', ''),
(784, 'Iryo Diego', '02320-446913', '154-6736946', '', '', ''),
(785, 'Josa Federico Ruben', '4450-8397', '155-8123344', '', '', ''),
(786, 'Juliano Carlos', '4210-7387', '156-3544353', '', '', ''),
(787, 'Kosinski Emanuel', '', '156-34732508', '', '', ''),
(788, 'Lagorio Facundo', '4644-6304', '153-3046634', '', '', ''),
(789, 'Legras Juan Facundo', '0237-4622856', '153-1800637', '', '', ''),
(790, 'Lescano Juan Manuel', '4221-4207', '155-8796623', '', '', ''),
(791, 'Lieve Mariano', '4248-0650', '1568988797/1535381928', '128*1168', '', ''),
(792, 'Llapur Sebastian', '4466-0642', '156-3081004', '4501-4119', '', ''),
(793, 'Lopez Fernando Gabriel', '4252-3415', '153-4257408', '', '', ''),
(794, 'Lopez Pablo Daniel', '02229-441924', '155-7138204', '', '', ''),
(795, 'Lubrano Germinal', '4523-8504', '155-0962531', '', '', ''),
(796, 'Luna Franco Ezequiel', '', '1526369095', '', '', ''),
(797, 'Macagnini Javier', '3533-3901', '155-3328112', '', '', ''),
(798, 'Machado Gustavo Daniel', '4977-0827', '153-3829106', '', '', ''),
(799, 'Maidana Juan Carlos', '0237-4817486', '156-9785067', '', '', ''),
(800, 'Mansilla Jorge', '', '156-0161035', '', '', ''),
(801, 'Marchese Antonino', '153-3160501', '156-6605562', '', '', ''),
(802, 'Marel Dario', '4669-3039/4699-4700', '155-5632157', '', '', ''),
(803, 'Margetic Eduardo', '4208-8956', '156-9698910', '', '', ''),
(804, 'Marin Emanuel', '39807640', '1553221450', '', '', ''),
(805, 'Martinez Fernando', '3975-4932', '153-7276190 /1534500082', 'id 658*2329', '4662-5399', ''),
(806, 'Martinez Maximiliano', '4485-7267', '156-4586594', '', '', ''),
(807, 'Mazzieri Lucas  Antonio', '4206-6153', '156-2811767', '', '', ''),
(808, 'Medina Alan', '0220-4825994', '156-9270844', '', '', ''),
(809, 'Medina Guillermo Nicolas', '2061-9531', '156-5565403', '', '', ''),
(810, 'Medina Hugo', '4270-4243', '155-6293408', '', '', ''),
(811, 'Medrano Diego', '', '155-5243766', '', '', ''),
(812, 'Mena Guillermo', '4739-0051', '155-9741872', '', '', ''),
(813, 'Menendez Gabriel', '4621-3185', '154-1689486', '', '', ''),
(814, 'Meyer Leandro', '4756-3434', '155-4747878', '', '', ''),
(815, 'Meza Ruben Antonio', '4274-1533/4274-6590', '154-9739365', '', '', ''),
(816, 'Miranda Toledo Mauricio', '0220-4895333', '153-1099172', '', '', ''),
(817, 'Moyano Nazareno', '42256750', '155-1184597', '', '', ''),
(818, 'Navarro Norberto', '', '155-7512553/1569572467', '', '', ''),
(819, 'Olivieri Maximiliano', '4204-0954', '154-9386134', '', '', ''),
(820, 'Ortiz Nicolas Hernan', '4293-7488', '153-4655295', '', '', ''),
(821, 'Paez Leandro', '', '155-4961951', '', '', ''),
(822, 'Palavecino Lucas', '4481-5290', '156-1887919', '', '', ''),
(823, 'Paredes Palacio Pedro', '4221-4262', '156-1918472', '', '', ''),
(824, 'Pereira Juan Martin', '4489-5057', '153-2096477', '', '', ''),
(825, 'Pereyra Hugo Damian', '0237-4685368', '156-4591401', '', '', ''),
(826, 'Perez Fernando', '4924-9554', '156-6419770', '', '', ''),
(827, 'Perez Pablo', '0221-4793213', '0221-155527241', '', '', ''),
(828, 'Petrussa Carlos Alberto', '4203-3833', '156-8289310', '', '', ''),
(829, 'Petrussa Pablo', '4203-3833', '156-4215136', '', '', ''),
(830, 'Pol Rojas Dorian', '1560392372', '153-7600198', '', '', ''),
(831, 'Quevedo Bruno Martin', '4372-8258', '155-1234310', '', '', ''),
(832, 'Quiroga Cristian', '4682-6561', '152-4826923', '', '', ''),
(833, 'Raffa Agustin', '', '156-8066499', '', '', ''),
(834, 'Raffo Martin Mariano', '4523-9308', '156-0036810', '', '', ''),
(835, 'Rago Gustavo', '4551-9870 / 4522-131', '15-4057-5472', '', '', ''),
(836, 'Ramirez Alexis Hector', '4297-8609', '156-8736859', '', '', ''),
(837, 'Recagni Leandro Fabricio', '20685996', '156-8227729', '', '', ''),
(838, 'Riglos Jonathan', '02323-654823', '02323-15608974', '', '', ''),
(839, 'Ripoli Lucas Martin', '153-6040530', '', '', '', ''),
(840, 'Rizzo Juan Pablo', '4383-1968', '153-7330918', 'nextel 731*4212', '', ''),
(841, 'Robledo Juan Cruz', '4242-3042', '156-1625067', '', '', ''),
(842, 'Rodogno Nicolas', '3533-1506', '153-4486120', '', '', ''),
(843, 'Rodriguez Ferro German', '4299-0057', '156-6647444', '', '', ''),
(844, 'Roldan Patricio', '4854-9273', '156-4345160', '', '', ''),
(845, 'Romero Carlos', '4658-7153/53559361', '154-5318272', '', '', ''),
(846, 'Romero Clauido Eriberto', '', '156-6671029', '', '', ''),
(847, 'Romero Daniel Oscar', '0222-4421627', '156-6449279', '', '', ''),
(848, 'Romero Nestor', '2202410059', '153-7707501', '', '', ''),
(849, 'Romero Silvio', '', '156-1548734', '', '', ''),
(850, 'Ruiz Ramon Antonio', '4867-5752', '156-8664111', '', '', ''),
(851, 'Ruiz Ulises David', '0220-4989643', '156-4368825', '', '', ''),
(852, 'Russo Mariano', '4922-9970', '155-8070674', '', '', ''),
(853, 'Salazar Alva Roberto', '', '153-8990082', '', '', ''),
(854, 'Salgado Damian Elias', '', '153-0801544', '', '', ''),
(855, 'Salina Fariña Nicolas', '4856-4455', '155-8794455', '4378-2181', '4918-3153 (fam)', ''),
(856, 'Sanchez Leonardo Daniel', '20686887', '156-3594846', 'nextel 141* 2292', '', ''),
(857, 'Sanchez Lorena Elizabeth', '4236-0674', '155-5287344', '', '', ''),
(858, 'Santillan Lucas Javier', '4382-5339', '153-4183766', '', '', ''),
(859, 'Santinelli Patricio', '3529-6186', '156-0263100', '', '', ''),
(860, 'Santos Martin leonel', '4241-0598', '156-3714910', '', '', ''),
(861, 'Savarino Marcelo', '4650-4357', '154-1984089', '', '', ''),
(862, 'Scalerandi Santiago', '4283-2746', '156-4136223', '', '', ''),
(863, 'Semeria Ivan Leonardo', '4281-4399', '154-4480520', '', '', ''),
(864, 'Sidgman Jacinto', '', '153-9202611', '', '', ''),
(865, 'Silva Leonel Vicente', '', '155-6578042', '', '', ''),
(866, 'Sosa Braian Emanuel', '4249-4384', '153-7022632', '', '', ''),
(867, 'Sosa de Frade Juan Manuel', '4452-8565', '153-5072127', '', '', ''),
(868, 'Spinali Jonathan Ezequiel', '4296-5520', '', '', '', ''),
(869, 'Suarez Damian', '02224-473539', '02224-15496344', '', '', ''),
(870, 'Suarez Leonel Matias', '0237-4632183', '156-8644677', '', '', ''),
(871, 'Tejeda Luciano Javier', '4273-2091', '152-1656767', '', '', ''),
(872, 'Toibero Agustin Luca', '3535-5733', '154-4052197', '', '', ''),
(873, 'Torales Juan Jose', '02202-453397', '153-8121513', '', '', ''),
(874, 'Torres Diego Ignacio', '4760-4930', '153-2432328', '', '', ''),
(875, 'Travaglino Mariano', '4521-5159', '156-5847101', '', '', ''),
(876, 'Trinidad Alan Alberto', '', '156-8084436', '', '', ''),
(877, 'Urso Martin', '4443-2529', '156-0362529', '', '', ''),
(878, 'Urtiaga Fabian', '0237-4816251', '1549499069', '', '', ''),
(879, 'Urtiaga Juan Abel', '', '155-0613852', '', '', ''),
(880, 'Urtiaga Leonel Fabian', '0237-4816251', '155-05881826', '', '', ''),
(881, 'Vargas Jose Richard', '', '156-6362283/1559021169', '', '', ''),
(882, 'Vazquez Ignacio', '4951-4096', '155-8314327', '', '', ''),
(883, 'Veron Hernan', '02225-422310', '02224-15448431', '', '', ''),
(884, 'Villalva Rodrigo Leonardo', '3533-6509', '156-2608377', '', '', ''),
(885, 'Villarreal Carlos Hernan', '02202-425683', '155-6326909', '', '', ''),
(886, 'Villarreal Daniel Gabriel', '02202-425683', '155-6326909', '', '', ''),
(887, 'Zamora Edgardo Daniel', '4476-1371', '153-5121143', '', '', ''),
(888, 'Zanini Pablo', '4282-0229', '156-9627705', '', '', ''),
(889, 'Zappacosta Mariana andrea', '03484-458639', '156-4915058', '', '', ''),
(890, 'Zaragoza David', '0237-4853850', '153-3673029', '', '', ''),
(891, 'Zarate Luis Fernando', '4275-2307', '153-4078808', '', '', ''),
(892, 'Zorzolis Leandro', '', '155-5287979/1533282575', '', '', ''),
(893, 'Zuvilivia Federico', '4750-9854', '153-5823062', '', '', ''),
(894, 'Zuvilivia Federico', '4750-9854', '153-5823062', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcanchasuspenciones`
--

CREATE TABLE IF NOT EXISTS `dbcanchasuspenciones` (
  `idcanchasuspencion` int(11) NOT NULL AUTO_INCREMENT,
  `refcanchas` int(11) NOT NULL,
  `vigenciadesde` date NOT NULL,
  `vigenciahasta` date DEFAULT NULL,
  `usuacrea` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechacrea` datetime DEFAULT NULL,
  `usuamodi` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechamodi` datetime DEFAULT NULL,
  PRIMARY KEY (`idcanchasuspencion`),
  KEY `fk_canchassuspenciones_canchas_idx` (`refcanchas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `dbcanchasuspenciones`
--

INSERT INTO `dbcanchasuspenciones` (`idcanchasuspencion`, `refcanchas`, `vigenciadesde`, `vigenciahasta`, `usuacrea`, `fechacrea`, `usuamodi`, `fechamodi`) VALUES
(9, 13, '2016-11-09', NULL, '', '2016-11-09 03:12:29', '', '0000-00-00 00:00:00'),
(10, 13, '2016-11-01', NULL, '', '2016-11-09 12:35:36', '', '0000-00-00 00:00:00'),
(11, 13, '2016-10-01', NULL, '', '2016-11-09 12:36:34', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcontactos`
--

CREATE TABLE IF NOT EXISTS `dbcontactos` (
  `idcontacto` int(11) NOT NULL AUTO_INCREMENT,
  `reftipocontactos` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `localidad` varchar(65) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cp` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(22) COLLATE utf8_spanish_ci DEFAULT NULL,
  `celular` varchar(22) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fax` varchar(22) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `publico` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idcontacto`),
  KEY `fk_contacto_tipocontacto_idx` (`reftipocontactos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `dbcontactos`
--

INSERT INTO `dbcontactos` (`idcontacto`, `reftipocontactos`, `nombre`, `direccion`, `localidad`, `cp`, `telefono`, `celular`, `fax`, `email`, `observaciones`, `publico`) VALUES
(2, 2, 'Cardozo Julian', '', 'La plata', '1900', '4657899', '', '', 'gerardo@msn.com', '', b'1'),
(4, 1, 'Safar Marcos', 'Barrio UOM torre "C" dpto 320', 'Ensenada', '1925', '65498312', '', '', 'juancarlos@msn.com', '', b'0'),
(5, 2, 'Pedrito', '', 'Ensenada', '', '', '', '', '', '', b'1'),
(6, 1, 'Milanovic Gaston', '', '', '', '', '', '', 'gaston@msn.com', '', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcountriecanchas`
--

CREATE TABLE IF NOT EXISTS `dbcountriecanchas` (
  `idcountriecancha` int(11) NOT NULL AUTO_INCREMENT,
  `refcountries` int(11) NOT NULL,
  `refcanchas` int(11) NOT NULL,
  PRIMARY KEY (`idcountriecancha`),
  KEY `fk_tabla_countries_idx` (`refcountries`),
  KEY `fk_tabla_canchas_idx` (`refcanchas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcountriecontactos`
--

CREATE TABLE IF NOT EXISTS `dbcountriecontactos` (
  `idcountriecontacto` int(11) NOT NULL AUTO_INCREMENT,
  `refcountries` int(11) NOT NULL,
  `refcontactos` int(11) NOT NULL,
  PRIMARY KEY (`idcountriecontacto`),
  KEY `fk_tabla_countries_idx` (`refcountries`),
  KEY `fk_tabla2_contactos_idx` (`refcontactos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=42 ;

--
-- Volcado de datos para la tabla `dbcountriecontactos`
--

INSERT INTO `dbcountriecontactos` (`idcountriecontacto`, `refcountries`, `refcontactos`) VALUES
(6, 4, 4),
(7, 4, 5),
(8, 1, 6),
(40, 2, 2),
(41, 2, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcountries`
--

CREATE TABLE IF NOT EXISTS `dbcountries` (
  `idcountrie` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(65) COLLATE utf8_spanish_ci NOT NULL,
  `cuit` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fechaalta` date DEFAULT NULL,
  `fechabaja` date DEFAULT NULL,
  `refposiciontributaria` int(11) NOT NULL,
  `latitud` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `longitud` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` bit(1) DEFAULT NULL,
  `referencia` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(110) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcountrie`),
  KEY `fk_countries_posiciontributaria_idx` (`refposiciontributaria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `dbcountries`
--

INSERT INTO `dbcountries` (`idcountrie`, `nombre`, `cuit`, `fechaalta`, `fechabaja`, `refposiciontributaria`, `latitud`, `longitud`, `activo`, `referencia`, `imagen`) VALUES
(1, 'Los alpes', '30-20654789', '2000-10-10', NULL, 1, '-34.61936482473979', '-58.61048699123785', b'0', 'Javier', NULL),
(2, 'Banco Provincia', '32164849', '2016-11-10', NULL, 1, '-34.57423163738421', '-58.437406537123024', b'1', 'Juliana', ''),
(3, 'Daniela', '651684984', '2016-11-12', NULL, 1, '-34.578712136211195', '-58.401309011969715', b'1', '', NULL),
(4, 'Tito Tomatino', '30-123654-3', '1975-07-04', NULL, 1, '-34.49995019905041', '-58.48578929202631', b'1', 'Sebastian', NULL),
(5, 'prueba', '354165468', '0000-00-00', NULL, 1, '', '', b'1', '', NULL),
(6, 'juan andres', '234234234', '1994-04-04', NULL, 1, '', '', b'1', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdefinicionescategoriastemporadas`
--

CREATE TABLE IF NOT EXISTS `dbdefinicionescategoriastemporadas` (
  `iddefinicioncategoriatemporada` int(11) NOT NULL AUTO_INCREMENT,
  `refcategorias` int(11) NOT NULL,
  `reftemporadas` int(11) NOT NULL,
  `cantmaxjugadores` int(11) NOT NULL,
  `cantminjugadores` int(11) NOT NULL,
  `dias` varchar(15) CHARACTER SET utf8 NOT NULL,
  `hora` varchar(5) CHARACTER SET utf8 NOT NULL,
  `minutospartido` int(11) NOT NULL,
  `cantidadcambiosporpartido` int(11) NOT NULL,
  `conreingreso` bit(1) NOT NULL,
  `observaciones` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`iddefinicioncategoriatemporada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbequipos`
--

CREATE TABLE IF NOT EXISTS `dbequipos` (
  `idequipo` int(11) NOT NULL AUTO_INCREMENT,
  `refcountries` int(11) NOT NULL,
  `nombre` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `refdivisiones` int(11) NOT NULL,
  `refcontactos` int(11) DEFAULT NULL,
  `fechaalta` date DEFAULT NULL,
  `fachebaja` date DEFAULT NULL,
  `activo` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idequipo`),
  KEY `fk_equipos_contries_idx` (`refcountries`),
  KEY `fk_equipos_categorias_idx` (`refcategorias`),
  KEY `fk_equipos_divisiones_idx` (`refdivisiones`),
  KEY `fk_equipos_contactos_idx` (`refcontactos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbjugadores`
--

CREATE TABLE IF NOT EXISTS `dbjugadores` (
  `idjugador` int(11) NOT NULL AUTO_INCREMENT,
  `reftipodocumentos` int(11) NOT NULL,
  `nrodocumento` int(11) NOT NULL,
  `apellido` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechanacimiento` date NOT NULL,
  `fechaalta` date NOT NULL,
  `fechabaja` date DEFAULT NULL,
  `refcountries` int(11) NOT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idjugador`),
  KEY `fk_jugadores_tipodocumentos_idx` (`reftipodocumentos`),
  KEY `fk_jugadores_countries_idx` (`refcountries`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbjugadoresdocumentacion`
--

CREATE TABLE IF NOT EXISTS `dbjugadoresdocumentacion` (
  `idjugadordocumentacion` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `refdocumentaciones` int(11) NOT NULL,
  `valor` bit(1) DEFAULT NULL,
  `habilita` bit(1) DEFAULT NULL,
  `observaciones` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idjugadordocumentacion`),
  KEY `fk_jugadoresdocu_jugadores_idx` (`refjugadores`),
  KEY `fk_jugadoresdocu_documentacion_idx` (`refdocumentaciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbjugadoresmotivoshabilitacionestransitorias`
--

CREATE TABLE IF NOT EXISTS `dbjugadoresmotivoshabilitacionestransitorias` (
  `iddbjugadormotivohabilitaciontransitoria` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `refmotivoshabilitacionestransitorias` int(11) NOT NULL,
  PRIMARY KEY (`iddbjugadormotivohabilitaciontransitoria`),
  KEY `fk_jmht_jugador_idx` (`refjugadores`),
  KEY `fk_jmht_motivos_idx` (`refmotivoshabilitacionestransitorias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbjugadoresvaloreshabilitacionestransitorias`
--

CREATE TABLE IF NOT EXISTS `dbjugadoresvaloreshabilitacionestransitorias` (
  `iddbjugadorvalorhabilitaciontransitoria` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `refvaloreshabilitacionestransitorias` int(11) NOT NULL,
  PRIMARY KEY (`iddbjugadorvalorhabilitaciontransitoria`),
  KEY `fk_jvht_jugadores_idx` (`refjugadores`),
  KEY `fk_jvht_valores_idx` (`refvaloreshabilitacionestransitorias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbtorneos`
--

CREATE TABLE IF NOT EXISTS `dbtorneos` (
  `idtorneo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `reftipotorneo` int(11) NOT NULL,
  `reftemporadas` int(11) NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `refdiviciones` int(11) NOT NULL,
  `cantidadascensos` smallint(6) DEFAULT NULL,
  `cantidaddescensos` smallint(6) DEFAULT NULL,
  `respetadefiniciontipojugadores` bit(1) DEFAULT NULL,
  `respetadefinicionhabilitacionestransitorias` bit(1) DEFAULT NULL,
  `respetadefinicionsancionesacumuladas` bit(1) DEFAULT NULL,
  `acumulagoleadores` bit(1) DEFAULT NULL,
  `acumulatablaconformada` bit(1) DEFAULT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idtorneo`),
  KEY `fk_torneo_tipotorneo_idx` (`reftipotorneo`),
  KEY `fk_torneo_divicion_idx` (`refdiviciones`),
  KEY `fk_torneo_temporadas_idx` (`reftemporadas`),
  KEY `fk_torneo_categorias_idx` (`refcategorias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbusuarios`
--

CREATE TABLE IF NOT EXISTS `dbusuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `refroles` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombrecompleto` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idusuario`),
  KEY `fk_dbusuarios_tbroles1_idx` (`refroles`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `dbusuarios`
--

INSERT INTO `dbusuarios` (`idusuario`, `usuario`, `password`, `refroles`, `email`, `nombrecompleto`) VALUES
(2, 'marcos', 'marcos', 1, 'msredhotero@msn.com', 'Saupurein Marcos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `idfoto` int(11) NOT NULL AUTO_INCREMENT,
  `refproyecto` int(11) NOT NULL,
  `reftabla` int(11) NOT NULL,
  `imagen` varchar(500) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `principal` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idfoto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`idfoto`, `refproyecto`, `reftabla`, `imagen`, `type`, `principal`) VALUES
(1, 2, 1, 'Hot-Long-Bob-Haircuts-520x272.jpg', 'image/jpeg', NULL),
(2, 3, 1, '14872484_10210931204255940_706670051_n.jpg', 'image/jpeg', NULL),
(4, 4, 1, 'images.jpg', 'image/jpeg', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio_menu`
--

CREATE TABLE IF NOT EXISTS `predio_menu` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `icono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` smallint(6) DEFAULT NULL,
  `hover` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `permiso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `administracion` bit(1) DEFAULT NULL,
  `torneo` bit(1) DEFAULT NULL,
  `reportes` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `predio_menu`
--

INSERT INTO `predio_menu` (`idmenu`, `url`, `icono`, `nombre`, `Orden`, `hover`, `permiso`, `administracion`, `torneo`, `reportes`) VALUES
(12, '../logout.php', 'icosalir', 'Salir', 30, NULL, 'Administrador, Empleado', b'0', b'1', b'0'),
(13, '../index.php', 'icodashboard', 'Dashboard', 1, NULL, 'Administrador, Empleado', b'0', b'1', b'0'),
(19, '../countries/', 'icozonas', 'Countries', 2, NULL, 'Administrador', b'1', b'0', b'0'),
(20, '../contactos/', 'icozonas', 'Contactos', 3, NULL, 'Administrador', b'1', b'0', b'0'),
(21, '../tipocontacto/', 'icozonas', 'Tipo Contactos', 4, NULL, 'Administrador', b'1', b'0', b'0'),
(22, '../posiciontributaria/', 'icozonas', 'Posicion Tributaria', 25, NULL, 'Administrador', b'1', b'0', b'0'),
(23, '../canchas/', 'icozonas', 'Canchas', 24, NULL, 'Administrador', b'1', b'0', b'0'),
(24, '../arbitros/', 'icozonas', 'Arbitros', 9, NULL, 'Administrador', b'1', b'1', b'1'),
(25, '../categorias/', 'icozonas', 'Categorias', 8, NULL, 'Administrador', b'1', b'1', b'1'),
(26, '../divisiones/', 'icozonas', 'Divisiones', 7, NULL, 'Administrador', b'1', b'1', b'1'),
(27, '../temporadas/', 'icozonas', 'Temporadas', 6, NULL, 'Administrador', b'1', b'1', b'1'),
(28, '../jugadores/', 'icozonas', 'Jugadores', 10, NULL, 'Administrador', b'1', b'1', b'1'),
(29, '../tipojugadores/', 'icozonas', 'Tipo Jugadores', 11, NULL, 'Administrador', b'1', b'1', b'1'),
(30, '../documentaciones/', 'icozonas', 'Documentaciones', 12, NULL, 'Administrador', b'1', b'1', b'1'),
(31, '../motivoshabilitacionestransitorias/', 'icozonas', 'Mot. Hab. Transit.', 13, NULL, 'Administrador', b'1', b'1', b'1'),
(32, '../valoreshabilitacionestransitorias/', 'icozonas', 'Valores Hab.Transt.', 14, NULL, 'Administrador', b'1', b'1', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcanchas`
--

CREATE TABLE IF NOT EXISTS `tbcanchas` (
  `idcancha` int(11) NOT NULL AUTO_INCREMENT,
  `refcountries` int(11) NOT NULL,
  `nombre` varchar(55) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idcancha`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `tbcanchas`
--

INSERT INTO `tbcanchas` (`idcancha`, `refcountries`, `nombre`) VALUES
(13, 1, 'Cancha 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcategorias`
--

CREATE TABLE IF NOT EXISTS `tbcategorias` (
  `idtcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtcategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tbcategorias`
--

INSERT INTO `tbcategorias` (`idtcategoria`, `categoria`) VALUES
(1, 'JUVENILES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdivisiones`
--

CREATE TABLE IF NOT EXISTS `tbdivisiones` (
  `iddivision` int(11) NOT NULL AUTO_INCREMENT,
  `division` varchar(130) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`iddivision`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tbdivisiones`
--

INSERT INTO `tbdivisiones` (`iddivision`, `division`) VALUES
(1, 'PRIMERA "A"');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdocumentaciones`
--

CREATE TABLE IF NOT EXISTS `tbdocumentaciones` (
  `iddocumentacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `obligatoria` bit(1) NOT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`iddocumentacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `tbdocumentaciones`
--

INSERT INTO `tbdocumentaciones` (`iddocumentacion`, `descripcion`, `obligatoria`, `observaciones`) VALUES
(1, 'Nro Documento', b'1', ''),
(4, 'Foto', b'1', ''),
(5, 'Ficha', b'0', ''),
(6, 'Titulo', b'1', ''),
(7, 'Examen Medico', b'1', ''),
(8, 'Expensas', b'1', ''),
(9, 'Inhabilitacion Countries', b'1', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbmotivoshabilitacionestransitorias`
--

CREATE TABLE IF NOT EXISTS `tbmotivoshabilitacionestransitorias` (
  `idmotivoshabilitacionestransitoria` int(11) NOT NULL AUTO_INCREMENT,
  `inhabilita` bit(1) NOT NULL DEFAULT b'1',
  `descripcion` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idmotivoshabilitacionestransitoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tbmotivoshabilitacionestransitorias`
--

INSERT INTO `tbmotivoshabilitacionestransitorias` (`idmotivoshabilitacionestransitoria`, `inhabilita`, `descripcion`) VALUES
(1, b'0', 'Foto'),
(2, b'0', 'Ficha');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbposiciontributaria`
--

CREATE TABLE IF NOT EXISTS `tbposiciontributaria` (
  `idposiciontributaria` int(11) NOT NULL AUTO_INCREMENT,
  `posiciontributaria` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `activo` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`idposiciontributaria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tbposiciontributaria`
--

INSERT INTO `tbposiciontributaria` (`idposiciontributaria`, `posiciontributaria`, `activo`) VALUES
(1, 'General', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbroles`
--

CREATE TABLE IF NOT EXISTS `tbroles` (
  `idrol` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `activo` bit(1) NOT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tbroles`
--

INSERT INTO `tbroles` (`idrol`, `descripcion`, `activo`) VALUES
(1, 'Administrador', b'1'),
(2, 'Empleado', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtemporadas`
--

CREATE TABLE IF NOT EXISTS `tbtemporadas` (
  `idtemporadas` int(11) NOT NULL AUTO_INCREMENT,
  `temporada` smallint(6) NOT NULL,
  PRIMARY KEY (`idtemporadas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tbtemporadas`
--

INSERT INTO `tbtemporadas` (`idtemporadas`, `temporada`) VALUES
(1, 2016);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipocontactos`
--

CREATE TABLE IF NOT EXISTS `tbtipocontactos` (
  `idtipocontacto` int(11) NOT NULL AUTO_INCREMENT,
  `tipocontacto` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `activo` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`idtipocontacto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tbtipocontactos`
--

INSERT INTO `tbtipocontactos` (`idtipocontacto`, `tipocontacto`, `activo`) VALUES
(1, 'Cliente', b'1'),
(2, 'Delegado', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipodocumentos`
--

CREATE TABLE IF NOT EXISTS `tbtipodocumentos` (
  `idtipodocumento` int(11) NOT NULL AUTO_INCREMENT,
  `tipodocumento` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipodocumento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tbtipodocumentos`
--

INSERT INTO `tbtipodocumentos` (`idtipodocumento`, `tipodocumento`) VALUES
(1, 'DNI'),
(2, 'LE'),
(3, 'LC'),
(4, 'Pasaporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipojugadores`
--

CREATE TABLE IF NOT EXISTS `tbtipojugadores` (
  `idtipojugador` int(11) NOT NULL AUTO_INCREMENT,
  `tipojugador` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `abreviatura` varchar(6) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipojugador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tbtipojugadores`
--

INSERT INTO `tbtipojugadores` (`idtipojugador`, `tipojugador`, `abreviatura`) VALUES
(1, 'Arquero', 'ARQ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipotorneo`
--

CREATE TABLE IF NOT EXISTS `tbtipotorneo` (
  `idtipotorneo` int(11) NOT NULL AUTO_INCREMENT,
  `tipotorneo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipotorneo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tbtipotorneo`
--

INSERT INTO `tbtipotorneo` (`idtipotorneo`, `tipotorneo`) VALUES
(1, 'Liga'),
(2, 'Torneo Verano'),
(3, 'PlayOff');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbvaloreshabilitacionestransitorias`
--

CREATE TABLE IF NOT EXISTS `tbvaloreshabilitacionestransitorias` (
  `idvalorhabilitaciontransitoria` int(11) NOT NULL AUTO_INCREMENT,
  `refmotivoshabilitacionestransitorias` int(11) NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `habilita` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`idvalorhabilitaciontransitoria`),
  KEY `fk_valores_motivos_idx` (`refmotivoshabilitacionestransitorias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tbvaloreshabilitacionestransitorias`
--

INSERT INTO `tbvaloreshabilitacionestransitorias` (`idvalorhabilitaciontransitoria`, `refmotivoshabilitacionestransitorias`, `descripcion`, `habilita`) VALUES
(1, 2, 'variable 1', b'1'),
(2, 2, 'variable 2', b'1'),
(3, 2, 'variable 3', b'0'),
(4, 2, 'variable 4', b'0');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbcanchasuspenciones`
--
ALTER TABLE `dbcanchasuspenciones`
  ADD CONSTRAINT `fk_canchassuspenciones_canchas` FOREIGN KEY (`refcanchas`) REFERENCES `tbcanchas` (`idcancha`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbcontactos`
--
ALTER TABLE `dbcontactos`
  ADD CONSTRAINT `fk_contacto_tipocontacto` FOREIGN KEY (`reftipocontactos`) REFERENCES `tbtipocontactos` (`idtipocontacto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbcountriecanchas`
--
ALTER TABLE `dbcountriecanchas`
  ADD CONSTRAINT `fk_tabla_canchas` FOREIGN KEY (`refcanchas`) REFERENCES `tbcanchas` (`idcancha`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tabla_countries` FOREIGN KEY (`refcountries`) REFERENCES `dbcountries` (`idcountrie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbcountriecontactos`
--
ALTER TABLE `dbcountriecontactos`
  ADD CONSTRAINT `fk_tabla2_contactos` FOREIGN KEY (`refcontactos`) REFERENCES `dbcontactos` (`idcontacto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tabla2_countries` FOREIGN KEY (`refcountries`) REFERENCES `dbcountries` (`idcountrie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbcountries`
--
ALTER TABLE `dbcountries`
  ADD CONSTRAINT `fk_countries_posiciontributaria` FOREIGN KEY (`refposiciontributaria`) REFERENCES `tbposiciontributaria` (`idposiciontributaria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbequipos`
--
ALTER TABLE `dbequipos`
  ADD CONSTRAINT `fk_equipos_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipos_divisiones` FOREIGN KEY (`refdivisiones`) REFERENCES `tbdivisiones` (`iddivision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipos_contactos` FOREIGN KEY (`refcontactos`) REFERENCES `dbcontactos` (`idcontacto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipos_contries` FOREIGN KEY (`refcountries`) REFERENCES `dbcountries` (`idcountrie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbjugadores`
--
ALTER TABLE `dbjugadores`
  ADD CONSTRAINT `fk_jugadores_countries` FOREIGN KEY (`refcountries`) REFERENCES `dbcountries` (`idcountrie`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jugadores_tipodocumentos` FOREIGN KEY (`reftipodocumentos`) REFERENCES `tbtipodocumentos` (`idtipodocumento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbjugadoresdocumentacion`
--
ALTER TABLE `dbjugadoresdocumentacion`
  ADD CONSTRAINT `fk_jugadoresdocu_documentacion` FOREIGN KEY (`refdocumentaciones`) REFERENCES `tbdocumentaciones` (`iddocumentacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jugadoresdocu_jugadores` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbjugadoresmotivoshabilitacionestransitorias`
--
ALTER TABLE `dbjugadoresmotivoshabilitacionestransitorias`
  ADD CONSTRAINT `fk_jmht_jugador` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jmht_motivos` FOREIGN KEY (`refmotivoshabilitacionestransitorias`) REFERENCES `tbmotivoshabilitacionestransitorias` (`idmotivoshabilitacionestransitoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbjugadoresvaloreshabilitacionestransitorias`
--
ALTER TABLE `dbjugadoresvaloreshabilitacionestransitorias`
  ADD CONSTRAINT `fk_jvht_jugadores` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jvht_valores` FOREIGN KEY (`refvaloreshabilitacionestransitorias`) REFERENCES `tbvaloreshabilitacionestransitorias` (`idvalorhabilitaciontransitoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbtorneos`
--
ALTER TABLE `dbtorneos`
  ADD CONSTRAINT `fk_torneo_tipotorneo` FOREIGN KEY (`reftipotorneo`) REFERENCES `tbtipotorneo` (`idtipotorneo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_torneo_divicion` FOREIGN KEY (`refdiviciones`) REFERENCES `tbdivisiones` (`iddivision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_torneo_temporadas` FOREIGN KEY (`reftemporadas`) REFERENCES `tbtemporadas` (`idtemporadas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_torneo_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbvaloreshabilitacionestransitorias`
--
ALTER TABLE `tbvaloreshabilitacionestransitorias`
  ADD CONSTRAINT `fk_valores_motivos` FOREIGN KEY (`refmotivoshabilitacionestransitorias`) REFERENCES `tbmotivoshabilitacionestransitorias` (`idmotivoshabilitacionestransitoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
