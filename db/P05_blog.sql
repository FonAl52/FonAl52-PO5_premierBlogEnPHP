-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 06 juil. 2023 à 14:45
-- Version du serveur : 5.7.39
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `P05_blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `idCategory` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`idCategory`, `name`) VALUES
(2, 'Backend'),
(3, 'Frontend'),
(4, 'Base de donnée'),
(5, 'DevOps'),
(6, 'Tech');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `comment` text NOT NULL,
  `validated` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `postId`, `userId`, `comment`, `validated`, `createdAt`, `updatedAt`) VALUES
(42, 12, 17, 'Je suis fasciné par les avancées de l\'intelligence artificielle. Cela ouvre de nombreuses opportunités dans divers domaines, mais nous devons également rester vigilants pour prévenir les abus et les conséquences néfastes.', 1, '2023-07-06 15:34:37', '2023-07-06 15:34:37'),
(43, 12, 19, 'L\'IA est incroyablement puissante et prometteuse. J\'ai hâte de voir comment elle va continuer à évoluer et à transformer notre façon de vivre et de travailler.', 0, '2023-07-06 15:36:12', '2023-07-06 15:36:12'),
(44, 11, 19, 'OpenClassrooms a été une véritable révélation pour moi. J\'ai pu apprendre le développement web à mon rythme, en suivant des cours de grande qualité. Les mentors sont très réactifs et l\'aspect pratique des projets m\'a permis de consolider mes connaissances. Je recommande vivement cette plateforme !', 1, '2023-07-06 15:36:36', '2023-07-06 15:36:36'),
(45, 11, 20, 'J\'ai toujours été intéressé par le design graphique, mais je ne savais pas par où commencer. Grâce à OpenClassrooms, j\'ai pu suivre un cours complet et obtenir une certification. Cela m\'a permis de trouver un emploi dans le domaine et de réaliser ma passion. Merci OpenClassrooms !', 1, '2023-07-06 15:37:52', '2023-07-06 15:37:52');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `chapo` varchar(255) NOT NULL,
  `picture` blob NOT NULL,
  `content` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `categoryId`, `userId`, `title`, `chapo`, `picture`, `content`, `createdAt`, `updatedAt`) VALUES
(6, 3, 16, 'Le frontend : L\'interface du web moderne', 'Découvrez le rôle essentiel du frontend dans la création d\'interfaces utilisateur attrayantes et interactives. Plongez dans l\'univers du développement côté client et explorez les langages et les technologies qui façonnent le web moderne.', 0x7075626c69632f696d616765732f706f7374732f36343636326634323636363565352e31343139303434372e6a706567, 'Le frontend, également connu sous le nom de développement côté client, est la partie du développement web qui se concentre sur la création de l\'interface utilisateur d\'un site web. Il englobe la conception, la mise en page et l\'interaction de l\'interface, rendant le site attrayant et convivial pour les utilisateurs.\r\n\r\nLe frontend utilise des langages de programmation tels que HTML (HyperText Markup Language) pour la structure, CSS (Cascading Style Sheets) pour la mise en forme et le design, ainsi que JavaScript pour l\'interactivité et les fonctionnalités avancées. Ces langages fonctionnent ensemble pour créer des sites web interactifs et réactifs.\r\n\r\nGrâce aux frameworks et aux bibliothèques frontend populaires tels que React, Angular et Vue.js, les développeurs peuvent accélérer le processus de développement et créer des interfaces utilisateur riches en fonctionnalités. Ces outils offrent des composants réutilisables, des fonctionnalités avancées et une structure de code organisée.\r\n\r\nL\'objectif principal du frontend est de fournir une expérience utilisateur fluide et agréable. Cela implique de concevoir une interface esthétiquement plaisante, d\'optimiser les performances pour des temps de chargement rapides et de garantir une compatibilité avec différents navigateurs et appareils.\r\n\r\nLe frontend évolue constamment pour répondre aux exigences changeantes du web. Les développeurs frontend doivent rester à jour avec les dernières tendances et technologies, telles que la conception web responsive pour une adaptation fluide à différentes tailles d\'écran.\r\n\r\nEn conclusion, le frontend joue un rôle essentiel dans la création d\'interfaces utilisateur attrayantes et interactives. Il combine la conception visuelle avec la programmation pour offrir des expériences web convaincantes. Que ce soit pour la création d\'un site web personnel ou d\'une application web complexe, le frontend est un élément clé pour offrir une expérience utilisateur de qualité.', '2023-05-18 15:59:30', '2023-05-18 15:59:30'),
(7, 2, 16, 'Les Fondamentaux du Backend', 'Découvrez les bases du développement backend et son rôle essentiel dans la création d\'applications web.', 0x7075626c69632f696d616765732f706f7374732f36343636326662626263323163392e30393334393438352e6a7067, 'Le développement backend est une composante clé de la création d\'applications web robustes et fonctionnelles. Alors que le développement frontend se concentre sur l\'interface utilisateur et l\'expérience utilisateur, le backend est responsable de la gestion des données, de la logique métier et de l\'interaction avec les bases de données.\r\n\r\nLe backend utilise des langages de programmation tels que PHP, Python, Ruby et des frameworks populaires tels que Laravel, Django et Ruby on Rails. Ces outils permettent aux développeurs de créer des API, de gérer les requêtes et les réponses, d\'authentifier les utilisateurs et de garantir la sécurité des données.\r\n\r\nL\'un des aspects les plus importants du backend est la gestion des bases de données. Les développeurs backend utilisent des systèmes de gestion de bases de données tels que MySQL, PostgreSQL ou MongoDB pour stocker, récupérer et manipuler les données. Ils utilisent également des langages de requête tels que SQL pour interagir avec ces bases de données et effectuer des opérations complexes.\r\n\r\nUne autre responsabilité du backend est la validation et la sécurité des données. Les développeurs backend mettent en place des mesures de sécurité pour protéger les données sensibles, comme le chiffrement des mots de passe et l\'utilisation de pare-feu pour prévenir les attaques malveillantes. Ils valident également les données soumises par les utilisateurs pour s\'assurer de leur intégrité et de leur validité.\r\n\r\nLe développement backend est également essentiel pour les fonctionnalités avancées telles que les paiements en ligne, l\'intégration de services tiers et la gestion des flux de travail. Les développeurs backend sont responsables de l\'implémentation de ces fonctionnalités en utilisant des API et des bibliothèques spécifiques.\r\n\r\nEn conclusion, le backend joue un rôle crucial dans la création d\'applications web performantes et sécurisées. Il gère les données, la logique métier et l\'interaction avec les bases de données, permettant ainsi aux utilisateurs de bénéficier d\'une expérience utilisateur fluide et d\'accéder aux fonctionnalités avancées. Le développement backend est un domaine passionnant qui nécessite des compétences solides en programmation et une compréhension approfondie des concepts liés à la gestion des données et à la sécurité.\r\n\r\nN\'hésitez pas à explorer davantage le backend et à approfondir vos connaissances pour devenir un développeur backend compétent et polyvalent.', '2023-05-18 16:01:31', '2023-05-18 16:01:31'),
(8, 4, 16, 'Les fondamentaux des bases de données', 'Découvrez les fondamentaux des bases de données, leur rôle essentiel dans la gestion de l\'information et leur utilisation dans le développement d\'applications.', 0x7075626c69632f696d616765732f706f7374732f36343636333034393238353135302e30383032393930392e6a7067, 'Les bases de données sont des systèmes de gestion de l\'information qui permettent de stocker, organiser et récupérer des données de manière structurée. Elles jouent un rôle essentiel dans de nombreux domaines, tels que les applications web, les systèmes d\'information d\'entreprise et les applications mobiles.\r\n\r\nUne base de données est composée de tables, qui sont des structures tabulaires contenant des enregistrements et des champs. Chaque enregistrement représente une entité, tandis que chaque champ contient une valeur spécifique. Par exemple, dans une base de données d\'une boutique en ligne, une table &quot;Produits&quot; pourrait contenir des enregistrements pour chaque produit avec des champs tels que &quot;Nom&quot;, &quot;Prix&quot; et &quot;Description&quot;.\r\n\r\nLes bases de données utilisent un langage de requête pour interagir avec les données. SQL (Structured Query Language) est le langage de requête le plus couramment utilisé. Il permet de créer, lire, mettre à jour et supprimer des données dans la base de données. Les requêtes SQL permettent d\'effectuer des opérations complexes, telles que la recherche de données, le filtrage, le tri et les jointures de tables.\r\n\r\nLes bases de données offrent de nombreux avantages, notamment la possibilité de stocker de grandes quantités de données de manière efficace, d\'assurer la cohérence des données, de faciliter l\'accès aux informations et de permettre des opérations avancées telles que l\'agrégation, la fusion et la mise à jour en masse. Elles fournissent également des fonctionnalités de sécurité pour protéger les données sensibles, telles que les autorisations d\'accès et le chiffrement.\r\n\r\nDans le développement d\'applications, les bases de données sont utilisées pour stocker et récupérer des informations. Elles permettent de gérer les utilisateurs, les produits, les commandes et bien d\'autres aspects d\'une application. Les développeurs utilisent des langages de programmation tels que PHP, Java, Python ou Ruby pour se connecter à la base de données, exécuter des requêtes et manipuler les données.\r\n\r\nIl existe différents types de bases de données, notamment les bases de données relationnelles, les bases de données NoSQL et les bases de données orientées objet. Chaque type a ses propres caractéristiques et est adapté à des cas d\'utilisation spécifiques. Les bases de données relationnelles, telles que MySQL et PostgreSQL, sont largement utilisées pour les applications traditionnelles, tandis que les bases de données NoSQL, telles que MongoDB et Cassandra, sont plus adaptées aux applications nécessitant une grande évolutivité et une flexibilité de schéma.\r\n\r\nEn conclusion, les bases de données sont des outils essentiels dans la gestion de l\'information et le développement d\'applications. Elles permettent de stocker, organiser et récupérer des données de manière structurée, offrant ainsi des fonctionnalités avancées et une gestion efficace des informations. Comprendre les bases de données et savoir les utiliser de manière appropriée est une compétence clé pour les développeurs et les professionnels de l\'informatique.\r\n\r\nN\'hésitez pas à explorer davantage les bases de données et à approfondir vos connaissances pour devenir un expert en gestion de l\'information et en développement d\'applications efficaces.', '2023-05-18 16:03:53', '2023-07-06 12:50:09'),
(9, 5, 16, 'DevOps : L\'union harmonieuse entre le développement et les opérations', 'Découvrez les principes fondamentaux de DevOps, une approche collaborative qui favorise l\'intégration harmonieuse du développement logiciel et des opérations système pour accélérer la livraison des produits et améliorer la stabilité des applications.', 0x7075626c69632f696d616765732f706f7374732f36343636333061646437333035302e33383132303739302e6a706567, 'DevOps est une méthodologie de développement logiciel qui vise à réduire les frictions entre les équipes de développement et les équipes d\'opérations. Au lieu de travailler de manière isolée, DevOps encourage une collaboration étroite entre les développeurs, les administrateurs système et les autres parties prenantes tout au long du cycle de vie d\'une application.\r\n\r\nLe principal objectif de DevOps est d\'améliorer la rapidité et la qualité des déploiements logiciels, tout en garantissant la stabilité et la fiabilité des applications en production. Pour atteindre cet objectif, les équipes DevOps mettent en place des processus d\'automatisation, des pratiques de gestion de configuration et des outils de surveillance avancés.\r\n\r\nLa clé du succès de DevOps réside dans la communication transparente et la collaboration continue entre les équipes de développement et les équipes d\'opérations. Les développeurs et les administrateurs système travaillent main dans la main pour résoudre les problèmes, mettre en œuvre de nouvelles fonctionnalités et assurer la disponibilité des applications.\r\n\r\nL\'automatisation est un élément essentiel de DevOps. Les tâches manuelles et répétitives sont automatisées grâce à des outils de déploiement continu, de gestion de configuration et de tests automatisés. Cela permet de réduire les erreurs humaines, d\'accélérer les cycles de développement et de garantir une plus grande cohérence et fiabilité du système.\r\n\r\nEn adoptant DevOps, les organisations peuvent bénéficier de nombreux avantages. La livraison continue permet de réduire les délais de mise sur le marché, d\'obtenir des retours rapides des utilisateurs et de s\'adapter plus rapidement aux besoins changeants du marché. De plus, la collaboration entre les équipes favorise l\'apprentissage mutuel, l\'amélioration continue et la résolution proactive des problèmes.\r\n\r\nIl est important de souligner que DevOps n\'est pas seulement une question d\'outils et de technologies, mais aussi de culture et de mentalité. Les équipes doivent adopter une approche orientée vers la collaboration, la responsabilité partagée et la confiance mutuelle. Les barrières entre les silos organisationnels doivent être brisées pour favoriser une culture de travail transparente et alignée sur les objectifs communs.\r\n\r\nEn conclusion, DevOps est une approche puissante pour améliorer l\'efficacité et la qualité des développements logiciels. En favorisant la collaboration entre les équipes de développement et les équipes d\'opérations, en automatisant les processus et en mettant l\'accent sur la culture et la communication, DevOps permet d\'accélérer les cycles de livraison, d\'améliorer la stabilité des applications et de favoriser l\'innovation continue dans le domaine du développement logiciel.', '2023-05-18 16:05:33', '2023-05-18 16:05:33'),
(11, 6, 16, 'Découvrez les avantages d\'apprendre sur OpenClassrooms', 'Explorez OpenClassrooms et développez de nouvelles compétences grâce à des cours en ligne de qualité.', 0x7075626c69632f696d616765732f706f7374732f36346136396133353035613339382e30323536353231352e6a7067, 'OpenClassrooms est une plateforme d\'apprentissage en ligne réputée qui propose une vaste sélection de cours dans des domaines tels que le développement web, le marketing digital, la data science et bien plus encore. Dans cet article, nous allons vous présenter les opportunités d\'apprentissage offertes par OpenClassrooms.\r\nOpenClassrooms vous permet d\'apprendre à votre propre rythme et où que vous soyez. Vous pouvez accéder aux cours à tout moment, ce qui vous offre une grande flexibilité pour concilier votre apprentissage avec vos autres engagements. Que vous soyez étudiant, professionnel en reconversion ou simplement curieux d\'acquérir de nouvelles compétences, OpenClassrooms s\'adapte à vos besoins.\r\nLes cours proposés sur OpenClassrooms sont créés par des experts dans leur domaine. Vous bénéficierez d\'un contenu pédagogique de qualité comprenant des vidéos, des exercices interactifs et des projets pratiques. L\'enseignement est constamment mis à jour pour refléter les dernières avancées et tendances.\r\nUn aspect unique d\'OpenClassrooms est l\'importance accordée aux projets pratiques. Vous aurez l\'opportunité de mettre en pratique vos connaissances à travers des projets concrets, ce qui renforcera votre compréhension et votre expérience pratique. Des évaluations régulières vous permettront de mesurer votre progression et de valider vos acquis.\r\nEn tant qu\'apprenant sur OpenClassrooms, vous bénéficierez d\'un accompagnement personnalisé tout au long de votre parcours. Des mentors expérimentés sont là pour répondre à vos questions, vous guider et vous soutenir. Vous ne serez jamais seul dans votre apprentissage.\r\nOpenClassrooms est une plateforme d\'apprentissage en ligne de premier choix, offrant flexibilité, qualité de l\'enseignement, projets pratiques et accompagnement personnalisé. Rejoignez dès maintenant la communauté d\'apprenants sur OpenClassrooms et découvrez les innombrables opportunités qu\'elle offre pour développer vos compétences.', '2023-06-29 09:06:22', '2023-07-06 13:32:15'),
(12, 6, 16, 'L\'Intelligence Artificielle : Révolution et Possibilités', 'Découvrez comment l\'intelligence artificielle révolutionne de nombreux secteurs et ouvre de nouvelles possibilités.', 0x7075626c69632f696d616765732f706f7374732f36346136633234376631646431322e39333134303336382e6a7067, 'L\'intelligence artificielle (IA) est une technologie en plein essor qui transforme de nombreux aspects de notre vie quotidienne et de divers secteurs industriels. Grâce à ses capacités d\'apprentissage automatique et d\'analyse des données, l\'IA permet aux machines d\'accomplir des tâches qui nécessitent normalement l\'intervention humaine.\r\n\r\nDans le domaine de la santé, l\'IA est utilisée pour aider au diagnostic médical précoce, améliorer les résultats des traitements et faciliter la découverte de nouveaux médicaments. Les voitures autonomes sont un autre exemple concret de l\'IA en action, où les algorithmes intelligents permettent aux véhicules de naviguer de manière autonome sur les routes.\r\n\r\nL\'IA a également un impact sur le commerce électronique, en fournissant des recommandations personnalisées aux consommateurs en fonction de leurs préférences et de leurs habitudes d\'achat. Dans le domaine de la finance, l\'IA est utilisée pour détecter les fraudes et analyser les données financières en temps réel.\r\n\r\nCependant, l\'IA soulève également des questions éthiques et des préoccupations concernant la protection de la vie privée et l\'impact sur l\'emploi. Il est essentiel d\'encadrer son développement pour garantir une utilisation responsable et éthique de cette technologie.\r\n\r\nEn résumé, l\'intelligence artificielle est en train de révolutionner de nombreux secteurs, offrant de nouvelles possibilités et des avantages significatifs. Il est important de comprendre ses applications, ses avantages et ses implications pour façonner un avenir où l\'IA est utilisée de manière éthique et bénéfique pour la société.', '2023-07-06 15:31:51', '2023-07-06 15:31:51');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `picture` blob,
  `role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `age`, `password`, `phone`, `picture`, `role`) VALUES
(16, 'Allan', 'Fontaine', 'allan_fontaine@outlook.com', NULL, 'f5d1278e8109edd94e1e4197e04873b9', NULL, 0x7075626c69632f696d616765732f70726f66696c652f36343636353561353761623930302e35383731313738352e6a7067, 1),
(17, 'Jean', 'Bernard', 'vod52m@gmail.com', NULL, '72e65942db67760974d72a1304a087b8', NULL, 0x7075626c69632f696d616765732f70726f66696c652f36346136633264333561356666302e30323534323138342e6a7067, 0),
(19, 'Sophie', 'Blog', 'P05_blog@mail01.com', NULL, '72e65942db67760974d72a1304a087b8', NULL, 0x7075626c69632f696d616765732f70726f66696c652f36346136633730646438333337332e33393639393339322e6a7067, 3),
(20, 'Laura', 'blog', 'P05_blog@mail02.com', NULL, '72e65942db67760974d72a1304a087b8', NULL, 0x7075626c69632f696d616765732f70726f66696c652f36346136633733313132623964352e38363533343539362e6a7067, 0),
(21, 'ADMIN', 'BLOG', 'P05_blog@mail03.com', NULL, '72e65942db67760974d72a1304a087b8', NULL, NULL, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`postId`),
  ADD KEY `userId` (`userId`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `idCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`idCategory`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
