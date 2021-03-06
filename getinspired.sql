-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Ven 11 Août 2017 à 17:46
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `getinspired`
--

-- --------------------------------------------------------

--
-- Structure de la table `box`
--

CREATE TABLE `box` (
  `id_box` int(3) NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contenu` text COLLATE utf8_unicode_ci NOT NULL,
  `prix` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '15€',
  `stock` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Contenu de la table `box`
--

INSERT INTO `box` (`id_box`, `titre`, `contenu`, `prix`, `stock`) VALUES
(6, 'Box de l\'été !!', 'Cette box contient deux films sur le thème de l\'été:\n- Il était une fois la révolution\n- Paris, Texas\n\nVous recevrez en plus un t-shirt collector GetInspired pour frimer sur la plage ;) !!', '20', 12),
(8, 'Box GetInspired', 'Cette box spéciale contient les films de notre sélection:\n- Terminator\n- Alien, le huitième passager\n- The Blues Brothers\n- Orange mécanique\n\nAinsi qu\'un goodies GetInspired', '25', 15),
(9, 'Box Monty Python !!', 'La box Monty Python vous permet de retrouver deux grands films de la célèbre troupe britannique :\n- Monty Python, sacré Graal\n- Monty Python, la vie de Brian\n\nEn plus vous recevrez un superbe Mug !!', '15', 20);

-- --------------------------------------------------------

--
-- Structure de la table `detail_box`
--

CREATE TABLE `detail_box` (
  `id_box` int(11) NOT NULL,
  `id_movie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `detail_box`
--

INSERT INTO `detail_box` (`id_box`, `id_movie`) VALUES
(6, 15),
(6, 23);

-- --------------------------------------------------------

--
-- Structure de la table `movies`
--

CREATE TABLE `movies` (
  `id_movie` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `production_year` year(4) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `synopsis` text NOT NULL,
  `director` varchar(255) NOT NULL,
  `actors` text NOT NULL,
  `gender` varchar(255) NOT NULL,
  `trailer` text NOT NULL,
  `poster` text NOT NULL,
  `mark` int(11) DEFAULT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `movies`
--

INSERT INTO `movies` (`id_movie`, `title`, `production_year`, `nationality`, `synopsis`, `director`, `actors`, `gender`, `trailer`, `poster`, `mark`, `price`) VALUES
(1, 'Alien, le huitième passager', 1979, 'Grande-Bretagne', 'Le vaisseau commercial Nostromo et son équipage, sept hommes et femmes, rentrent sur Terre avec une importante cargaison de minerai. Mais lors d\'un arrêt forcé sur une planète déserte, l\'officier Kane se fait agresser par une forme de vie inconnue, une arachnide qui étouffe son visage.<br />Après que le docteur de bord lui retire le spécimen, l\'équipage retrouve le sourire et dîne ensemble. Jusqu\'à ce que Kane, pris de convulsions, voit son abdomen perforé par un corps étranger vivant, qui s\'échappe dans les couloirs du vaisseau...', 'Ridley Scott', 'Sigourney Weaver, Tom Skerritt, Veronica Cartwright, Harry Dean Stanton, John Hurt', 'Science fiction', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18355736&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img3.acsta.net/medias/nmedia/18/35/14/60/18363837.jpg', NULL, 1.99),
(2, 'Amadeus', 1984, 'U.S.A.', 'A Vienne, en novembre 1823. Au coeur de la nuit, un vieil homme égaré clame cette étonnante confession : <i>\"Pardonne, Mozart, pardonne à ton assassin !\"</i> Ce fantôme, c\'est Antonio Salieri, jadis musicien réputé et compositeur officiel de la Cour.<br />\r\nDès l\'enfance, il s\'était voué tout entier au service de Dieu, s\'engageant à le célébrer par sa musique, au prix d\'un incessant labeur. Pour prix de ses sacrifices innombrables, il réclamait la gloire éternelle. Son talent, reconnu par l\'empereur mélomane Joseph II, valut durant quelques années à Salieri les plus hautes distinctions.<br />\r\nMais, en 1781, un jeune homme arrive à Vienne, précédé d\'une flatteuse réputation. Wolfgang Amadeus Mozart est devenu le plus grand compositeur du siècle. Réalisant la menace que représente pour lui ce surdoué arrogant dont il admire le profond génie, Salieri tente de l\'évincer.', 'Milos Forman', 'Tom Hulce, F. Murray Abraham, Elizabeth Berridge, Simon Callow, Roy Dotrice', 'Comédie dramatique', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18671421&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img6.acsta.net/medias/nmedia/18/35/90/78/18686561.jpg', NULL, 1.99),
(3, 'America, America', 1963, 'U.S.A.', 'Au début du siècle, un jeune Anatolien fuit un pays où Grecs et Arméniens sont persécutés par les Turcs. Il désire émigrer en Amérique, mais s\'aperçoit bien vite que ce périple vers la terre promise est un parcours semé d\'embûches.', 'Elia Kazan', 'Stathis Giallelis, Frank Wolff, Elena Karam, Lou Antonio, John Marley', 'Drame', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18803475&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img6.acsta.net/medias/nmedia/18/64/43/28/18778270.jpg', NULL, 1.99),
(4, 'Les Aventuriers de l\'Arche perdue', 1981, 'U.S.A.', '1936. Parti à la recherche d\'une idole sacrée en pleine jungle péruvienne, l\'aventurier Indiana Jones échappe de justesse à une embuscade tendue par son plus coriace adversaire : le Français René Belloq.<br/>Revenu à la vie civile à son poste de professeur universitaire d\'archéologie, il est mandaté par les services secrets et par son ami Marcus Brody, conservateur du National Museum de Washington, pour mettre la main sur le Médaillon de Râ, en possession de son ancienne amante Marion Ravenwood, désormais tenancière d\'un bar au Tibet.<br/>Cet artefact égyptien serait en effet un premier pas sur le chemin de l\'Arche d\'Alliance, celle-là même où Moïse conserva les Dix Commandements. Une pièce historique aux pouvoirs inimaginables dont Hitler cherche à s\'emparer...', 'Steven Spielberg', 'Harrison Ford, Karen Allen, Paul Freeman, Denholm Elliott, Ronald Lacey', 'Aventure', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18812705&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img4.acsta.net/medias/nmedia/00/02/49/18/affiche.jpg', NULL, 1.99),
(5, 'Barry Lyndon', 1975, 'Grande-Bretagne', 'Au XVIIIe siècle en Irlande, à la mort de son père, le jeune Redmond Barry ambitionne de monter dans l\'échelle sociale. Il élimine en duel son rival,un officier britannique amoureux de sa cousine mais est ensuite contraint à l\'exil. Il s\'engage dans l\'armée britannique et part combattre sur le continent européen. Il déserte bientôt et rejoint l\'armée prussienne des soldats de Frederic II afin d\'échapper à la peine de mort. Envoyé en mission, il doit espionner un noble joueur, mène un double-jeu et se retrouve sous la protection de ce dernier. Introduit dans la haute société européenne, il parvient à devenir l\'amant d\'une riche et magnifique jeune femme, Lady Lyndon. Prenant connaissance de l\'adultère, son vieil époux sombre dans la dépression et meurt de dépit. Redmond Barry épouse Lady Lyndon et devient Barry Lyndon...', 'Stanley Kubrick', 'Ryan O\'Neal, Marisa Berenson, Patrick Magee, Hardy Krüger, Steven Berkoff', 'Historique', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18782028&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img6.acsta.net/medias/nmedia/18/36/14/49/18455746.jpg', NULL, 0),
(6, 'Brazil', 1985, 'Grande-Bretagne', 'Sam Lowry, fonctionnaire modèle d\'une mégapole étrange, à la fois d\'hier, beaucoup d\'aujourd\'hui et tout à fait de demain, a des problèmes avec sa maman et avec l\'Etat, tout puissant. Pour couronner le tout, des songes bizarres l\'entraînent chaque nuit sur les ailes d\'Icare, à la recherche d\'une jeune femme blonde, évanescente, inaccessible. Chaque fois qu\'il est sur le point de l\'atteindre, leurs trajectoires se séparent et le songe s\'interrompt cruellement.<br/>Pourtant une nuit, la belle Jill Layton entre dans sa vie... Par le biais d\'une erreur dans la machinerie fantastique qui préside à l\'organisation de la vie quotidienne des citoyens de cette ville étrange, l\'Ordinateur suprême a désigné le brave Buttle à la place de l\'escroc Tuttle, activement recherché. Après le décès fâcheux du pauvre Buttle, Saw Lowry, jusque là employé rampant, est promu au Service des Recherches, très brigué... pour dédommager la veuve du défunt. La belle Jill habite au dessus de l\'infortunée famille... En fait de recherches, Sam va passer son temps à retrouver la femme de ses rêves.<br/>Sa maman, elle, a des soucis beaucoup plus terre-à-terre. Elle surveille fébrilement les résultats des multiples interventions de chirurgie plastique réalisées par une sorte de Grand-Maître d\'une secte étrange dans cet univers incroyable. Et son cher garçon suit attentivement les évolutions du visage et du corps de sa mère, ainsi que celles, nettement plus catastrophiques, de sa tante, soumise aux mêmes supplices vécus avec délice, comme une règle de vie impérative là-bas : rester jeune.<br/>Tout cela dans un univers de tuyaux, de pompes géantes, une sorte de ville-poumon gigantesque d\'où Sam sortira amplement vainqueur de toutes les embûches pour retrouver sa belle. Mais à quel prix...', 'Terry Gilliam', 'Jonathan Pryce, Robert De Niro, Kim Greist, Michael Palin, Katherine Helmond', 'Science fiction', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19352259&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img4.acsta.net/medias/00/02/42/000242_af.jpg', NULL, 0),
(7, 'Et vogue le navire', 1983, 'Italie', 'En 1914, le port de Naples est le théâtre d\'événements peu banals. La haute société européenne, artistes et politiciens de renom, s\'apprête, au cours d\'une croisière, a disperser les cendres de leur diva adulée. Les premières manifestations de la guerre vont frapper de plein fouet les insouciants passagers...', 'Federico Fellini', 'Freddie Jones, Barbara Jefford, Victor Poletti, Peter Cellier, Elisa Mainardi', 'Comédie dramatique', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18741301&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img6.acsta.net/medias/nmedia/18/64/67/66/18835940.jpg', NULL, 0),
(8, 'Jésus de Nazareth', 1977, 'Grande-Bretagne', 'L\'évocation minutieuse de la vie de Jésus de Nazareth, de sa naissance à Bethléem à sa résurrection en passant par sa crucifixion sous l\'ordre de Ponce Pilate.', 'Franco Zeffirelli', 'Robert Powell, Anne Bancroft, Olivia Hussey, Christopher Plummer, Ernest Borgnine', 'Historique', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18805963&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img5.acsta.net/medias/nmedia/18/76/40/74/19287335.jpg', NULL, 0),
(9, 'Johnny s\'en va-t-en guerre', 1971, 'U.S.A.', 'Durant la Première Guerre mondiale, un jeune soldat est blessé par une mine : il a perdu ses bras, ses jambes et toute une partie de son visage. Il ne peut ni parler, ni entendre, ni sentir mais reste conscient. Dans la chambre d\'un hopîtal, il tente de communiquer et se souvient de son histoire.', 'Dalton Trumbo', 'Timothy Bottoms, Don \'Red\' Barry, Kathy Fields, Donald Sutherland, Mike Lee', 'Drame', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19432929&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img4.acsta.net/pictures/14/04/16/10/25/266880.jpg', NULL, 0),
(10, 'Midnight Express', 1978, 'Grande-Bretagne', 'Billy Hayes, touriste en Turquie, est arrêté à la frontière avec deux kilogrammes de drogue sur lui. Condamné à quelques jours de prison, le jeune homme découvre que sa peine a été muée en prison à perpétuité par le gouvernement souhaitant faire de son cas un exemple. Désemparé, Billy multiplie les procès et parcourt les prisons les plus sordides.', 'Alan Parker', 'Brad Davis, Irene Miracle, Bo Hopkins, Paolo Bonacelli, Paul Smith', 'Drame', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19380112&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img4.acsta.net/medias/nmedia/18/62/84/47/19254775.jpg', NULL, 0),
(11, 'Monty Python, sacré Graal', 1975, 'Grande-Bretagne', 'Le roi Arthur et les Chevaliers de la Table Ronde se lancent à la conquête du Graal, chevauchant de fantômatiques montures dans un bruitage de noix de coco cognées. La petite troupe va devoir passer mille épreuves, dont un chevalier à trois têtes, des jouvencelles en chaleur, voire même un terrible lapin tueur.', 'Terry Jones, Terry Gilliam', 'Graham Chapman, John Cleese, Eric Idle, Michael Palin, Terry Jones', 'Comédie', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18773336&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img3.acsta.net/medias/nmedia/00/02/43/01/graal.jpg', NULL, 0),
(12, 'Monty Python, la vie de Brian', 1979, 'Grande-Bretagne', 'En l\'an 0, en terre de Galilée, Mandy et son bébé Brian reçoivent la visite des Rois Mages un beau soir de décembre. Ceux-ci, s\'apercevant de leur erreur, remballent prestement leurs présents et filent dans l\'étable voisine. Hélas, Brian a tiré le mauvais numéro...', 'Terry Jones', 'Graham Chapman, Terry Gilliam, John Cleese, Michael Palin, Eric Idle', 'Comédie', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18773335&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img2.acsta.net/medias/nmedia/18/35/23/34/18376684.jpg', NULL, 0),
(13, 'Nostalghia', 1983, 'U.R.S.S.', 'Un intellectuel soviétique voyageant en Italie ressent cruellement l\'éloignement de son pays. Cet exil passager devient l\'occasion d\'une réflexion sur l\'inaccessibilité d\'un monde meilleur.', 'Andreï Tarkovski', 'Oleg Yankovsky, Domiziana Giordano, Erland Josephson, Piero Vida, Delia Boccardo', 'Drame', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19572694&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img2.acsta.net/medias/nmedia/18/72/70/95/19175703.jpg', NULL, 0),
(14, 'Orange mécanique', 1971, 'Grande-Bretagne', 'Au XXIème siècle, où règnent la violence et le sexe, Alex, jeune chef de bande, exerce avec sadisme une terreur aveugle. Après son emprisonnement, des psychanalystes l\'emploient comme cobaye dans des expériences destinées à juguler la criminalité...', 'Stanley Kubrick', 'Malcolm McDowell, Patrick Magee, Michael Bates, Philip Stone, Steven Berkoff', 'Science fiction', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19216572&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img1.acsta.net/medias/nmedia/18/36/25/34/18465555.jpg', NULL, 0),
(15, 'Paris, Texas', 1984, 'France', '<p><strong>Ce film est présenté en version restaurée dans la section Cannes Classics au <a href=\"http://www.allocine.fr/festivals/festival-229/news/\">Festival de Cannes 2014</a></strong>.</p>\r\nUn homme réapparaît subitement après quatre années d\'errance, période sur laquelle il ne donne aucune explication à son frère venu le retrouver. Ils partent pour Los Angeles récupérer le fils de l\'ancien disparu, avec lequel celui-ci il part au Texas à la recherche de Jane, la mère de l\'enfant. Une quête vers l\'inconnu, une découverte mutuelle réunit ces deux êtres au passé tourmenté.', 'Wim Wenders', 'Harry Dean Stanton, Nastassja Kinski, Hunter Carson, Dean Stockwell, Aurore Clément', 'Drame', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19545960&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img4.acsta.net/pictures/14/06/27/17/00/361994.jpg', NULL, 0),
(16, 'Pink Floyd The Wall', 1982, 'U.S.A.', 'Après le décès de son père pendant la Seconde Guerre mondiale, Pink est élevé par une mère tyrannique. Devenu rock star, il mène une vie tourmentée et s\'enferme sur lui-même dans sa chambre d\'hôtel. Peu à peu, il sombre dans la drogue tandis que la folie commence à<br />s\'emparer de lui...', 'Alan Parker', 'Bob Geldof, Christine Hargreaves, James Laurenson, Eleanor David, Bob Hoskins', 'Drame', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18728138&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img6.acsta.net/medias/nmedia/18/35/91/01/18760590.jpg', NULL, 0),
(17, 'Qu\'est-il arrivé à Baby Jane ?', 1962, 'U.S.A.', 'Au temps du cinéma muet, \"Baby\" Jane est une grande star, une des premières enfants prodiges. Sa soeur Blanche, timide et réservée, reste dans l\'ombre. Dans les années 30, les rôles sont inversés, Blanche est une grande vedette, Jane est oubliée. Désormais, bien des années après, elles vivent en commun une double névrose. Blanche, victime d\'un mystérieux accident, est infirme et semble tout accepter d\'une soeur transformée en infirmière sadique qui multiplie les mauvais traitements...', 'Robert Aldrich', 'Bette Davis, Joan Crawford, Victor Buono, Wesley Addy, Marjorie Bennett', 'Drame', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19456232&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img5.acsta.net/medias/nmedia/18/36/23/39/18464065.jpg', NULL, 0),
(18, 'Taxi Driver', 1976, 'U.S.A.', '<p style=\"text-align: justify;\">Vétéran de la Guerre du Vietnam, Travis Bickle est chauffeur de taxi dans la ville de New York. Ses rencontres nocturnes et la violence quotidienne dont il est témoin lui font peu à peu perdre la tête. Il se charge bientôt de délivrer une prostituée mineure de ses souteneurs.</p>', 'Martin Scorsese', 'Robert De Niro, Jodie Foster, Harvey Keitel, Cybill Shepherd, Albert Brooks', 'Drame', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19564497&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img4.acsta.net/pictures/16/08/04/15/27/495536.jpg', NULL, 0),
(19, 'Terminator', 1984, 'U.S.A.', 'A Los Angeles en 1984, un Terminator, cyborg surgi du futur, a pour mission d\'exécuter Sarah Connor, une jeune femme dont l\'enfant à naître doit sauver l\'humanité. Kyle Reese, un résistant humain, débarque lui aussi pour combattre le robot, et aider la jeune femme...', 'James Cameron', 'Arnold Schwarzenegger, Michael Biehn, Linda Hamilton, Lance Henriksen, Paul Winfield', 'Science fiction', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18895020&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img3.acsta.net/medias/nmedia/18/35/91/09/19255618.jpg', NULL, 0),
(20, 'The Blues Brothers', 1980, 'U.S.A.', 'Dès sa sortie de prison, Jake Blues est emmené par son frère Elwood chez Soeur Mary Stigmata, qui dirige l\'orphelinat dans lequel ils ont été élevés. Ils doivent réunir 5 000 dollars pour sauver l\'établissement, sinon c\'est l\'expulsion.', 'John Landis', 'John Belushi, Dan Aykroyd, James Brown, Cab Calloway, Carrie Fisher', 'Comédie musicale', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19558506&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img4.acsta.net/pictures/15/10/12/11/09/512043.jpg', NULL, 0),
(21, 'The Rose', 1979, 'U.S.A.', 'L\'évocation de la vie tourmentée d\'une chanteuse de rock à la fin des années soixante.', 'Mark Rydell', 'Bette Midler, Alan Bates, Frederic Forrest, Harry Dean Stanton, Barry Primus', 'Musical', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19481970&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img4.acsta.net/pictures/15/05/27/09/59/008285.jpg', NULL, 0),
(22, 'Love Streams', 1983, 'U.S.A.', '<span>En amour, Sarah est passionnée, jalouse et possessive. Se sentant trahie par son mari et sa fille, elle débarque chez son frère Robert, riche écrivain accro à la débauche, alors que le fils de ce dernier vient de lui être confié. Dès qu\'il la reconnaît, il se jette dans ses bras. Leur amour mutuel réussira-t-il à les apaiser ?</span>', 'John Cassavetes', 'Gena Rowlands, John Cassavetes, Diahnne Abbott, Seymour Cassel, Margaret Abbott', 'Drame', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=19566995&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img6.acsta.net/pictures/17/01/24/13/23/106427.jpg', NULL, 0),
(23, 'Il était une fois la révolution', 1971, 'Italie', 'Mexique, 1913. Un pilleur de diligences, Juan Miranda, et un Irlandais, ancien membre de l\'IRA spécialiste en explosifs, John Mallory, font connaissance. Juan a toujours rêvé de dévaliser la banque centrale de Mesa Verde et voit en John le complice idéal pour son braquage. Il fait chanter John afin de le persuader de s\'associer à l\'affaire.<br />Tous deux se trouvent plongés en plein coeur de la tourmente de la révolution mexicaine, et Mesa Verde se révèle plus riche en prisonniers politiques qu\'en lingots d\'or. Malgré eux, les deux amis deviennent les héros d\'une guerre qui n\'est pas la leur...', 'Sergio Leone', 'James Coburn, Rod Steiger, Romolo Valli, David Warbeck, Maria Monti', 'Western', '<div id=\'ACEmbed\'><iframe src=\'http://www.allocine.fr/_video/iblogvision.aspx?cmedia=18921518&amp;isApp=true\' style=\'width:480px; height:270px\' frameborder=\'0\' allowfullscreen=\'true\'></iframe><br /></div>', 'http://fr.web.img5.acsta.net/medias/nmedia/18/35/24/18/19172614.jpg', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id_review` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_movie` int(11) NOT NULL,
  `content` text NOT NULL,
  `note` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `civility` enum('m','mme','mlle') NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `pseudo`, `password`, `lastname`, `firstname`, `email`, `civility`, `role`, `birthdate`) VALUES
(1, 'admin', '$2y$10$MwvRJJwCYCkbJuyVdmKjTeohrrLC0.RSSe/PipQLGdt29erZ0hW7m', 'Lefevre', 'Quentin', 'quinto_lefevre@hotmail.com', '', 'admin', '1990-08-20');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`id_box`);

--
-- Index pour la table `detail_box`
--
ALTER TABLE `detail_box`
  ADD PRIMARY KEY (`id_movie`),
  ADD KEY `id_box` (`id_box`);

--
-- Index pour la table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id_movie`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_review`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `box`
--
ALTER TABLE `box`
  MODIFY `id_box` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `movies`
--
ALTER TABLE `movies`
  MODIFY `id_movie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `detail_box`
--
ALTER TABLE `detail_box`
  ADD CONSTRAINT `detail_box_ibfk_1` FOREIGN KEY (`id_box`) REFERENCES `box` (`id_box`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_box_ibfk_2` FOREIGN KEY (`id_movie`) REFERENCES `movies` (`id_movie`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
