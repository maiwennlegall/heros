-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 13 mai 2022 à 16:40
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `oledur`
--
CREATE DATABASE IF NOT EXISTS `oledur` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `oledur`;

-- --------------------------------------------------------

--
-- Structure de la table `histoire`
--

CREATE TABLE `histoire` (
  `hist_id` int(11) NOT NULL,
  `titre` varchar(30) NOT NULL,
  `cache` int(11) NOT NULL DEFAULT 1,
  `nb_vie_dbt` int(11) NOT NULL,
  `nb_joue` int(11) NOT NULL DEFAULT 0,
  `nb_gagne` int(11) NOT NULL DEFAULT 0,
  `nb_perdue` int(11) NOT NULL DEFAULT 0,
  `resumer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `histoire`
--

INSERT INTO `histoire` (`hist_id`, `titre`, `cache`, `nb_vie_dbt`, `nb_joue`, `nb_gagne`, `nb_perdue`, `resumer`) VALUES
(1, 'La forêt enchantée', 0, 3, 10, 1, 8, 'Gérard, son petit fils Charlie, et son chien Fifi, partent pour une balade en forêt. Mais cette petite virée leur réserve bien des surprises ...'),
(3, 'La Cave', 0, 3, 1, 0, 1, 'Vous vous retrouvez dans une cave sombre...');

-- --------------------------------------------------------
--
-- Structure de la table `chapitre`
--

CREATE TABLE `chapitre` (
  `id_ch_hors_hist` int(11) NOT NULL,
  `id_chapitre` int(11) NOT NULL,
  `titre` varchar(30) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `type_fin` int(11) DEFAULT NULL,
  `modif_vie` int(11) NOT NULL,
  `id_ch_choix1` int(11) DEFAULT NULL,
  `id_ch_choix2` int(11) DEFAULT NULL,
  `id_ch_choix3` int(11) DEFAULT NULL,
  `choix1` text DEFAULT NULL,
  `choix2` text DEFAULT NULL,
  `choix3` text DEFAULT NULL,
  `textes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `chapitre`
--

INSERT INTO `chapitre` (`id_ch_hors_hist`, `id_chapitre`, `titre`, `id_hist`, `type_fin`, `modif_vie`, `id_ch_choix1`, `id_ch_choix2`, `id_ch_choix3`, `choix1`, `choix2`, `choix3`, `textes`) VALUES
(15, 1, 'Départ', 1, NULL, 0, 2, 3, 4, 'Charlie', 'Gérard', 'Fifi', 'Cette histoire débute un après-midi de printemps.  Charlie, son grand père Gérard, et son chien Fifi arrive à l’orée du bois de leur village. \r\nQuel personnage souhaitez-vous incarner?'),
(16, 2, 'L\'étrange plante', 1, NULL, 0, 5, 6, 7, 'J’interroge mon grand père dessus, il aura surement une explication à me donner.', 'Je continue mon chemin tranquillement. Cela doit être une simple fougère.', 'Je la fait sentir à Fifi, il m’indiquera si elle est toxique.', 'Vous êtes très heureux de vous promener avec votre grand père, dont les nombreuses connaissances vous étonnent encore plus chaque jour. C’est alors que vous remarquez une étrange plante, que vous n’aviez jamais vu avant. Que décidez-vous de faire?'),
(17, 3, 'Gérard le savant', 1, NULL, -1, 8, 9, 10, 'Je les ramasse pour les cuisiner ce soir. Je connais bien ces champignons, dans une omelette ce sera exquis. ', 'Je n’y touche pas. Je n’accorde aucune confiance à ma mémoire quelque peu défaillante et ne souhaite pas m’intoxiquer.', 'Je les ramasse pour les examiner dans mon laboratoire.', 'Votre âge vous rend plus faible, vous perdez donc une vie. Vous decidez d’expliquer à votre  petit fils toutes vos connaissances sur la faune et la flore de cette forêt. Vous remarquez des champignons qui vous rappellent votre enfance. Que décidez-vous d’en faire?'),
(18, 4, 'La balade de Fifi', 1, NULL, 0, 11, 12, 13, 'Vous décidez de lui courrir après, tant pis pour Gérard et Charlie vous les retrouverez après.', 'Vous essayer de le croquer, ça n’a pas l’air mauvais après tout', 'Vous le laissez passer avec dédain, une si petite bête n’a déjà pas beaucoup de chance de survivre toute seule.', 'Cette balade en forêt vous réjouit grandement, dégourdir vos petites pattes est une une activité qui vous avait grandement manqué. \r\nUn campagnol attire votre attention.'),
(19, 5, 'L\'observation de la plante', 1, NULL, 0, 14, 15, 16, 'Vous décidez de la montrer à un vieux druide de votre village', 'Vous décidez de le montrer à un scientifique', 'Vous décidez de gouter en croquant dans la fleur. Votre papi vous a souvent expliqué que les pétales de de nombreuses fleurs étaient comestibles.', 'Après avoir observé longuement la plante, Papi Gérard avoue qu’il ne l’avais jamais vue. Pourtant, il habite près de cette forêt et vient s’y promener depuis qu’il est enfant. Cette plante devient donc encore plus intrigante.'),
(20, 6, 'Les lianes', 1, NULL, 0, 17, 18, 19, 'Vous poussez votre grand-père à s’y balancer, ça lui rappelera son enfance!', 'Vous vous balancez à une liane, imitant Tarzan', 'Vous accrochez votre chien à liane afin qu’il se balance', 'Vous continuez votre chemin paisiblement, et arrivez sous un saule pleureur dont les branches vous rapellent les lianes de Tarzan. Que décidez-vous de faire?'),
(21, 7, 'Fifi et la plante toxique', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'A peine Fifi a mis sa truffe contre la mystérieuse plante, qu’il est tombé à la renverse. Cette plante semble toxique, vous décidez de prendre le chien dans vos bras et de vous en éloigner au plus vire. Cette balade a vite tourné à la catastrophe!'),
(22, 8, 'La cuisson des champignons', 1, NULL, 0, 20, 21, 22, '2 minutes, cela suffira', '7 minutes, il faut qu’ils grillent un peu', '15 minutes, je les aime bien cuits', 'Vous rentrez à la maison avec votre petite tribue toute souillée., l’omelette de ce soir en perspective.\r\nAprès quelques minutes à laisser mijoter ce bon plat quelques minutes avant de passer à table. Combien de temps faites-vous cuire ces champignons?'),
(23, 9, 'Les lianes de Tarzan', 1, NULL, 0, 23, 24, 25, 'Vous vous balancez à une liane, imitant Tarzan', 'Vous accrochez votre petit-fils à la liane afin qu’il se balance', 'Vous accrochez votre chien à liane afin qu’il se balance', 'Quelle sage décision! Vous poursuivez donc la balade, et arrivez sous un saule pleureur dont les branches vous rapelles les lianes de Tarzan. Que décidez-vous de faire?'),
(24, 10, 'L\'analyse au laboratoire', 1, NULL, 0, 26, 27, 28, 'J’observe ce jus au microscope', 'J’examine la composition du jus', 'Je craque et finit par manger ma bouille de champignons cuits', 'Je les cuits et les broie pour en tirer du jus. Que décidez vous d\'en faire ensuite?'),
(25, 11, 'La famille de la plaine', 1, NULL, 0, 29, 30, 31, 'Vous ne vous faites pas trop de soucis, cette nouvelle famille vous donnera peut-être plus de friandises', 'Vous hurlez pour pousser ces inconnus à bout et qu’ils vous relachent', 'Vous restez calme, votre famille finira bien par venir vous chercher', 'Vous perdez vite la petite bête de vue, mais découvrez une grande étandue d’herbe, avec une fontaine au milieu. Des dizaines de chiens y jouent avec leurs maitres et vous décidez de vous joindre à eux. Un enfant se met gentillement à jouer avec vous, en vous lançant un baton, ce qui vous rend très joyeux. Après plusieurs minutes de jeux, ses parents viennent le chercher, et il insiste pour vous garder. C’est ainsi que vous vous retrouvez embarqué dans la voiture d’une famille inconnue. Zut! Gérard et charlie vont d’inquiéter.'),
(26, 12, 'Le fail du campagnol', 1, NULL, -1, 32, 33, 34, 'Vous partez en courant devant Gérard et Charlie.', 'Vous restez sage mais cela vous frustre', 'Vous faites des tours autour de vos maitres, tout agité.', 'Vous vous jetez sur la bestiole, ouvrez la geule et la refermez de toute vos forces, pensant la croquer. Mais le rongeur a filé à toute vitesse et vos dents s’entrechoquent bruyamment. Vous perdez une vie. Sonné, vous titubez, et reprennez lentement la ballade avec vos maitres. Cette ballade est trop lente pour vous.'),
(27, 13, 'L\'attaque du campagnol', 1, NULL, -1, 35, 36, 37, 'Vous faites comme si de rien était. C’est vraiment la honte de se faire attaquer par une si petite bête.', 'Vous poussez un cri qui alerte vos maitres. Ceux-cis décident de vous emmener aux urgences vétérinaires.', 'Vous lèchez la plaie dans l’espoir d’arreter le saignement.', 'Votre bonté vous perdra. La petite bête se jette sur vous et vous mord la patte! Vous perdez une vie. Le sang perle déjà sur la plaie dévoilée par les crocs du rongeur, qui s’est aussitôt enfuit.'),
(28, 14, 'Le méchant druide', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Il vous rejette et vous traite de sorciers fous! Appeuré, il vous jette un sors pour vous emprisonner.'),
(29, 15, 'Le scientifique ravi', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Il vous accueille gentiment, et après analyse il vous consiède comme des dieux car vous venez de lui ramener une plante très rare., qui va l’aider dans ses recherches.'),
(30, 16, 'La degustation de la fleur', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous tombez raide mort. Cette plante était toxique'),
(31, 17, 'La blessure de Papi', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Zut! Son poids fait  craquer la liane, et ses vieux os ne permettent pas de soutenir son corps. Il se tord la cheville Vous avez gaché la journée.'),
(32, 18, 'L\'amusement de Charlie', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Quelle bonne idée! \r\nVous vous amusez comme un petit fou! Cela a refait votre journée!'),
(33, 19, 'Fifi et la liane serpent', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Misère! La liane était en réalité un serpent! Votre chien se fait mordre!'),
(34, 20, 'La mauvaise cuisson', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Ces champignons ne devaient pas être les délicieux champignons de votre enfance. Aussi peu cuits, ils sont très dangereux. Ce délicieux repas sera votre dernier.'),
(35, 21, 'Une cuisson trop longue', 1, NULL, -1, 38, 39, 40, 'Brice de Nice 3', 'Astérix et Obélix: Mission Cléopatre', 'Un film d’horreur slovaque', 'Les champignons ont trop cuit, vous mangez un petit peu de champignon carbonisé, ce qui est mauvais pour la santé. Vous perdez 1 point de vie. Malgré une digestion compliquée, la soirée poursuit son cours. Vous vous battez pour choisir un film et finalement 3 choix s’oposent :'),
(36, 22, 'La cuisson particulière', 1, NULL, 0, 41, 42, 43, 'Vous vous jetez dessus pour la caresser', 'Vous décidez de sortir de la boîte ppour prendre l’air. Prenant conscience que ce n’est pas normal', 'Vous continuez à danser sur la piste. Ce n’est que dans votre tête, elle va partir!', 'La cuisson particulière de ces champignons semble avoir libébré meurs propriétés hallucinogènes et euphorisantes. Pris d’une énergie folle, vous décidez d’emmener votre femme Geneviève en boîte de nuit. \r\nVous entrez dans un lieu chaud et bruyant, et prenez un cocktail alcoolisé. Les champignons vous font provoquent des hallucinations. Vous voyez une Licorne au fond de la pièce.\r\n'),
(37, 23, 'La cheville ', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Votre poids fait  craquer la liane, et vos vieux os ne permettent de soutenir votre corps. Vous vous tordez la cheville et gachez la journée.'),
(38, 24, 'Charlie et la liane', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Quelle bonne idée! \r\nCharlie s’amuse comme un petit fou! Son bonheur vous a empli de joie. \r\nQuelle belle journée!'),
(39, 25, 'La liane et Fifi', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Misère! La liane était en réalité un serpent! Votre chien se fait mordre. '),
(40, 26, 'Le jus vivant', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Le jus de ces champignons grouille d’organismes vivants. Ce n’est pas normal d’en voir autant, surtout après une telle cuisson. Les vapeurs s’émanant du jus sont très odorantes et embaument très vite la pièce. Malheureusement, vous vous rendez compte un peu trop tard qu’elles sont toxiques...'),
(41, 27, 'Les molécules', 1, NULL, 0, 44, 45, 46, 'Je décide d’en parler tout de suite à un vieux collègue scientifique pour avoir son avis. ', 'Je garde ça pour moi, je ne veux pas que le monde scientifique décime tous les champignons de la forêt pour comprendre d’où viennent ces molécules extraterrestres', 'Je décide de continuer mes analyses pour rédiger un article scientifique révélant au grand jour ma découverte', 'J’y trouve des molécules étranges, qui ne sont pas sensées être présentes sur Terre. En effet ces molécules sont extraterrestre et ont saulement été observées sur Mars.\r\nEbahit par cette découverte, vous prenez un moment pour réaliser et réflichissez à ce que vous allez en faire.'),
(42, 28, 'La boite', 1, NULL, 0, 47, 48, 49, 'Vous vous jetez dessus pour la caresser', 'Vous décidez de sortir de la boîte ppour prendre l’air. Prenant conscience que ce n’est pas normal', 'Vous continuez à danser sur la piste. Ce n’est que dans votre tête, elle va partir!', 'La cuisson particulière de ces champignons semble avoir libébré meurs propriétés hallucinogènes et euphorisantes. Pris d’une énergie folle, vous décidez d’emmener votre femme Geneviève en boîte de nuit. \r\nVous entrez dans un lieu chaud et bruyant, et prenez un cocktail alcoolisé. Les champignons vous font provoquent des hallucinations. Vous voyez une Licorne au fond de la pièce.\r\n'),
(43, 29, 'Le chien heureux', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous vivez une vie heureuse dans cette nouvelle famille et êtes chouchouté comme un roi'),
(44, 30, 'Le chien volant', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Il finissent par s’enerver et vous jeter par la fenêtre. Vous auriez peut-être dû vous taire.'),
(45, 31, 'Le retour de la famille', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Après queslques heures chez ces inconnus, une voiture arrive dans leur allée. C’est Gérard et Charlie qui viennent vous récupérer. Ouf!'),
(46, 32, 'Le ravin', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous ne percevez pas le danger devant vous et tombez dans un ravin'),
(47, 33, 'Le chien parfait', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'La virée en forêt se finit paisiblement et vous êtes chouchouté au retour à la maison. Vous avez bien fait de rester sage.'),
(48, 34, 'Le mauvais chien', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Ils se fachent et écourtent la ballade. Vous n’aurez pas de friandises ce soir.'),
(49, 35, 'La rage', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Malheureusement, le rongeur avait la rage et la maladie vous terrassera dans les semaines qui suivent'),
(50, 36, 'Le véto', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Ils ont bien fait de vous y emmener, après quelques soins, vous rentrez chez-vous et on vous donne des friandises'),
(51, 37, 'SuperFifi', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'La morsure de ce rongeur vous procure des pouvoirs magiques innatendus. Vous devenez un super chien, prêt à tout pour sauver tous ses comparses de l’abandon.'),
(52, 38, 'Le mauvais film', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Quel mauvais choix, cette décision vous fais perdre!'),
(53, 39, 'Le bon film', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Quel bon choix vous avez réussi à faire de cette soirée, l’un des meilleurs souvenirs de votre vie!'),
(54, 40, 'Le film effrayant', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Ce film était trop violent pour vous, un moment d\'épouvante vous provoque une crise cardiaque!'),
(55, 41, 'La licorne inexistante', 1, NULL, -1, 50, 51, 52, 'Vous prenez la voiture, la route sera rapide à faire, et les effets de l’alcool et des champignons semblent dissipés, vous ne risquez pas grand chose', 'Vous décidez de rentrer à pied, la route sera un peu longue, mais c’est plus sûr', 'Vous voyez des bornes pour emprunter des vélos, et décidez d’en utiliser pour faire la route jusqu’à chez-vous', 'C’était évidemment une illusion, vous tombez en croyant vous appuyer sur elle. Votre tête heurte une banquette, et vous tombez assomé. Vous perdez une vie.\r\nVous vous réveillez une heure plus tard, dans une petite pièce du club. Vous décidez de rentrer chez vous.'),
(56, 42, 'L\'aventure', 1, NULL, 0, 53, 54, 55, 'Vous prenez la voiture, la route sera rapide à faire, et les effets de l’alcool et des champignons semblent dissipés, vous ne risquez pas grand chose', 'Vous décidez de rentrer à pied, la route sera un peu longue, mais c’est plus sûr', 'Vous voyez des bornes pour emprunter des vélos, et décidez d’en utiliser pour faire la route jusqu’à chez-vous', 'Vous partez à l’aventure dans les rues, avec Geneviève, comme au bon vieux temps. Puis décidez de rentrer chez vous.'),
(57, 43, 'La licorne magique', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Au bout de plusieurs heures, bien que les effets des champignons se dissipent, la licorne est toujours là. De plus d’autres personnes dans la boite l’ont vue et la caressent. Vous décidez alors de vous en approcher. Alors que vous tentez de l’aborder, vous vous rendez compte que la licorne comprend votre langage. Elle vous invite à partir à l’aventure avec elle. vous la chevauchez donc et partez à la découverte de son monde: la planète des arcs en ciel et des nuages en Barbapapa ...'),
(58, 44, 'Le scientifique malhonnête', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Ce collègue vous trahit et brise ainsi votre coeur. Il révèle cette découverte en se faisant passer pour le génie de l’histoire. Cela vous achève.'),
(59, 45, 'La sauvegarde des champignons', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Quelle bonne idée, vous poursuivez votre vie paisiblement, en ayant la possibilité, au cours de vos sorties en forêt, de profiter de ces magnifiques champignons.'),
(60, 46, 'L\'article glorieux', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Cette article vous fait connaitre dans tous le monde scientifique et vous procure gloire et bonheur. Vous passez une fin de vie heureuse à parler de vos recherches dans les plus grands congrès aux quatre coins du monde'),
(61, 47, 'La fausse licorne', 1, NULL, -1, 56, 57, 58, 'Vous prenez la voiture, la route sera rapide à faire, et les effets de l’alcool et des champignons semblent dissipés, vous ne risquez pas grand chose', 'Vous décidez de rentrer à pied, la route sera un peu longue, mais c’est plus sûr', 'Vous voyez des bornes pour emprunter des vélos, et décidez d’en utiliser pour faire la route jusqu’à chez-vous', 'C’était évidemment une illusion, vous tombez en croyant vous appuyer sur elle. Votre tête heurte une banquette, et vous tombez assomé. Vous perdez une vie.\r\nVous vous réveillez une heure plus tard, dans une petite pièce du club. Vous décidez de rentrer chez vous.'),
(62, 48, 'Le bon vieux temps', 1, NULL, 0, 59, 60, 61, 'Vous prenez la voiture, la route sera rapide à faire, et les effets de l’alcool et des champignons semblent dissipés, vous ne risquez pas grand chose', 'Vous décidez de rentrer à pied, la route sera un peu longue, mais c’est plus sûr', 'Vous voyez des bornes pour emprunter des vélos, et décidez d’en utiliser pour faire la route jusqu’à chez-vous', 'Vous partez à l’aventure dans les rues, avec Geneviève, comme au bon vieux temps. Puis décidez de rentrer chez vous.'),
(63, 49, 'Le monde parallèle', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Au bout de plusieurs heures, bien que les effets des champignons se dissipent, la licorne est toujours là. De plus d’autres personnes dans la boite l’ont vue et la caressent. Vous décidez alors de vous en approcher. Alors que vous tentez de l’aborder, vous vous rendez compte que la licorne comprend votre langage. Elle vous invite à partir à l’aventure avec elle. vous la chevauchez donc et partez à la découverte de son monde: la planète des arcs en ciel et des nuages en Barbapapa ...'),
(64, 50, 'L\'accident', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Visiblement, les substances que vous aviez consommées étaient coriaces, et vos réflexes étaient encore annihilés. Vous ratez un virage, et percutez un arbre. Cet accident vous est malheureusement fatal, et cette folle soirée restera votre dernière'),
(65, 51, 'Le piéton malade', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'C’est une sage décision, car vous êtes toujours titubants. Mais le chemin est long, et le froid et l’humidité de la nuit vous rends malade.\r\nVous perdez une vie. \r\n'),
(66, 52, 'L\'équilibre délicat', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Encore sous l’emprise de l’alcool, vous basculez à la renverse et vous éraflez toute la cuisse. Vous perdez une vie.\r\n'),
(67, 53, 'Le virage', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Visiblement, les substances que vous aviez consommées étaient coriaces, et vos réflexes étaient encore annihilés. Vous ratez un virage, et percutez un arbre. Cet accident vous est malheureusement fatal, et cette folle soirée restera votre dernière'),
(68, 54, 'Le piéton chanceux', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'C’est une sage décision, car vous êtes toujours titubants.Vous rentrez sein et sauf. Ce petit périple vous aura appris une bonne leçon. Et oui, à votre âge on apprends encore, et vous ne toucherez plus de si tôt à des champignons'),
(69, 55, 'La chute du vélo', 1, NULL, -1, 62, 63, 64, 'Je continue à pieds, c’est plus prudent!', 'Je remonte sur le vélo avec fierté, heureusement, personne ne m’a vu tomber', 'Je remonte sur le vélo avec fierté, heureusement, personne ne m’a vu tomber', 'Encore sous l’emprise de l’alcool, vous basculez à la renverse et vous éraflez toute la cuisse. Vous perdez une vie.'),
(70, 56, 'L\'accident fatal', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Visiblement, les substances que vous aviez consommées étaient coriaces, et vos réflexes étaient encore annihilés. Vous ratez un virage, et percutez un arbre. Cet accident vous est malheureusement fatal, et cette folle soirée restera votre dernière'),
(71, 57, 'Rentrer malade', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'C’est une sage décision, car vous êtes toujours titubants. Mais le chemin est long, et le froid et l’humidité de la nuit vous rends malade.\r\nVous perdez une vie. \r\n'),
(72, 58, 'Le cycliste maladroit', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Encore sous l’emprise de l’alcool, vous basculez à la renverse et vous éraflez toute la cuisse. Vous perdez une vie.'),
(73, 59, 'Des substances fatales', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Visiblement, les substances que vous aviez consommées étaient coriaces, et vos réflexes étaient encore annihilés. Vous ratez un virage, et percutez un arbre. Cet accident vous est malheureusement fatal, et cette folle soirée restera votre dernière'),
(74, 60, 'La bonne décision', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'C’est une sage décision, car vous êtes toujours titubants.Vous rentrez sein et sauf. Ce petit périple vous aura appris une bonne leçon. Et oui, à votre âge on apprends encore, et vous ne toucherez plus de si tôt à des champignons'),
(75, 61, 'L\'emprise sur le cycliste', 1, NULL, -1, 65, 66, 67, 'Je continue à pieds, c’est plus prudent!', 'Je remonte sur le vélo avec fierté, heureusement, personne ne m’a vu tomber', 'Je remonte sur le vélo avec fierté, heureusement, personne ne m’a vu tomber', 'Encore sous l’emprise de l’alcool, vous basculez à la renverse et vous éraflez toute la cuisse. Vous perdez une vie.'),
(76, 62, 'La leçon', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'C’est une sage décision, car vous êtes toujours titubants.Vous rentrez sein et sauf. Ce petit périple vous aura appris une bonne leçon. Et oui, à votre âge on apprends encore, et vous ne toucherez plus de si tôt à des champignons.'),
(77, 63, 'L\'arbre fatal', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Visiblement, les substances que vous aviez consommées étaient coriaces, et vos réflexes étaient encore annihilés. Vous ratez un virage, et percutez un arbre. Cet accident vous est malheureusement fatal, et cette folle soirée restera votre dernière'),
(78, 64, 'Le poignet', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous basculez à nouveau, et vous blessez au poignet, définitivement cette soirée n’était pas la votre.'),
(79, 65, 'La sage décision', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'C’est une sage décision, car vous êtes toujours titubants.Vous rentrez sein et sauf. Ce petit périple vous aura appris une bonne leçon. Et oui, à votre âge on apprends encore, et vous ne toucherez plus de si tôt à des champignons'),
(80, 66, 'La dernière soirée', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Visiblement, les substances que vous aviez consommées étaient coriaces, et vos réflexes étaient encore annihilés. Vous ratez un virage, et percutez un arbre. Cet accident vous est malheureusement fatal, et cette folle soirée restera votre dernière'),
(81, 67, 'La bascule', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous basculez à nouveau, et vous blessez au poignet, définitivement cette soirée n’était pas la votre'),
(104, 1, 'Le réveil', 3, NULL, 0, 2, 3, 4, 'Vous criez à l’aide ! Ce n’est pas normal d’être coincé ici !', 'Mieux vaut rester discret, vous partez analyser la cave sombre.', 'Vous vous précipitez vers la porte ! Il faut partir!', 'Vous ouvrez doucement les yeux, lorsque d’un seul coup cela pour tilte, vous ne reconnaissez absolument pas votre environnement ! Vous êtes dans une sorte de cave humide, couché sur un lit de camps !\r\nQue faites vous ? '),
(105, 2, 'Le cri', 3, NULL, 0, 5, 6, 7, 'Vous décidez de vous cacher de peur !', 'Vous ne bougez pas, aucun bruit, cela ne vient peut-être pas pour vous! ', 'Vous appercevez une barre de fer ensevellis sous des cannettes ! Vous vous jettez dessus!  ', 'Vous entendez au dessus de vous une chaise se déplacer rapidement et de rapides pas qui se rapproche de votre porte.'),
(106, 3, 'La fouille', 3, NULL, 0, 8, 7, 10, 'Vous avez ce qu’il vous faut ! Vous vous rapprochez de la porte !', 'Vous décidez de tenter le coup de la barre de fer, il faut vous défendre !', 'Vous décidez de voir ce qui provoque ce bruit !', 'Vous fouillez , toute la cave et trouvez de quoi crocheter une porte ! Vous voyez plus loin une grande barre de fer utile s’il faut vous défendre mais sous une tonne de cannettes, la prendre ferait surement énormément de bruit ! De plus, vous entendez un bruit dans le fond de la pièce ! '),
(107, 4, 'La fuite', 3, NULL, 0, 11, 3, 13, 'Vous décidez de vous confrontez à la porte et de lui rentrer dedans pour la forcer à s’ouvrir.', 'Vous décidez de fouillez la pièce afin de trouver de quoi crocheter la porte ! ', 'Vous décidez d’envoyer des objets contre la porte, votre lit de camps semble être la solution idéale.', 'Vous gravissez les marches vers la porte ! Lorsque vous l’atteignez, vous tentez de l’ouvrir et sans grande surprise constatez qu’elle est fermée...\r\nVous n’avez rien sur vous pour l’ouvrir....'),
(108, 5, 'Le col', 3, NULL, -2, 14, 15, 16, 'Vous criez et vous débattez !', 'Vous ne faites rien et attendez de voir !', 'Vous vous lancer dans une tirade d’excuses.', 'Vous entendez la porte de la cave s’ouvrir et au moins une personne dans l’escalier, rapidement vous sentez qu’on vous agrippe par le col !'),
(109, 6, 'Fin parfaite', 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous êtes en bas des escalier, la porte s’ouvre sur une femme, qui semble en colère et descend rapidement les escaliers pour atteindre votre niveau ! Vous reconnaissez rapidement votre mère qui ne comprend pas ce que vous faites dans la cave, sûrement une fin de soirée bien arrosée ! '),
(110, 7, 'La barre de fer', 3, NULL, 0, 17, 18, 19, 'Trop risqué vous lachez la barre rapidement pour pas qu’il vous voit avec !', 'Vous vous précipitez et visez les jambes.', 'Vous vous précipitez et visez la tête !', 'Vous avez acquis une barre de fer ! Vous allez vous cacher sous l’escalier, la porte s’ouvre et une personne descend les marches. Vous avez un faible temps avant que la personne n’atteigne le bas et vous voit.'),
(111, 8, 'La sombre habitation', 3, NULL, 0, 20, 21, 22, 'Vous partez analyser l’habitation pour comprendre ce qu’il se passe.', 'Vous décider de trouver la sortie la plus proche !', 'Vous spotter la cuisine et décider d’aller manger pour prendre des forces.', 'Vous crochetez la serrure et ouvrez la porte ! Il fait encore sombre dans l’habitation...'),
(112, 10, 'Le rat !', 3, NULL, 0, 23, 2, 25, 'Vous tombez à la renverse !', 'Vous criez de peur!', 'Vous regarder le rat passez près de vous.', 'Vous vous rapprochez du bruit, quand tout d’un coup, un énorme rat sort face à vous ! '),
(113, 11, 'Pas de force...', 3, NULL, -2, 5, 6, 7, 'Vous décidez de vous cacher de peur !', 'Vous ne bougez pas, aucun bruit, cela ne vient peut-être pas pour vous! ', 'Vous appercevez une barre de fer ensevellis sous des cannettes ! Vous vous jettez dessus!  ', 'Cela ne fonctionne évidemment pas ! Vous n’avez aucune force et la porte bien que vieille ne bouge pas mais fait un énorme bruit ! Vous entendez au dessus de vous une chaise se déplacer rapidement et de rapides pas qui se rapproche de votre porte'),
(116, 13, 'Le lit de camp', 3, NULL, -1, 29, 30, 31, 'Vous courrez dans la direction opposée au bruit !', 'Vous redescendez dans la cave, peur des conséquences de votre action.', 'Vous êtes dans votre lancée d’attaque et courrant en direction du bruit, décider à mettre un coup à votre adversaire !', 'Votre volonté de fer paie ! Vous explosez la porte qui ne résiste absolument pas au lit de camps ! Vous voilà face à une porte ouverte ! Mais vous entendez des bruits au loin ! Que faites vous ?'),
(117, 14, 'C&#039;est pas bien...', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Malgré ses paroles pour vous détendre vous continuez à vous débattre dos à votre adversaire. Il n’a pas d’autres choix que de vous mettre un coup qui vous assomme et vous calme.  En le regardant de plus près vous reconnaissez votre frère ! Vous comprenez le problème, cette cave est celle de vos parents ! Qu’aviez vous fumé la nuit dernière ? '),
(118, 15, 'Inatendu !', 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'La personne vous retourne face à elle.  Vous reconnaissez rapidement votre mère qui ne comprend pas ce que vous faites dans la cave, sûrement une fin de soirée bien arrosée ! '),
(119, 16, 'Le réconfort', 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'La personne vous retourne face à elle.  Vous reconnaissez rapidement votre mère qui ne comprend pas ce que vous faites dans la cave, sûrement une fin de soirée bien arrosée ! '),
(120, 17, 'Une personne inatendu !', 3, NULL, 0, 32, 33, 33, 'Impossible ! C’est de la magie ! Comment votre mère peut être ici avec votre agresseur ? FUYEZ !', '“MAMAN ?”', 'Vous ne dites rien...', 'Vous sortez de sous l’escalier, et vous retrouver face à votre mère.'),
(121, 18, 'Mais ça va pas ?', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous courrez vers la personne qui cri votre prénom avec horreur, vous n’avez pas le temps de le réaliser mais c’est votre frère ! Vous frappez de toutes vos forces et l’entendez lâcher un cri de douleur et s’effondrer au sol. Vous réaliser que maintenant, vous vous tenez dans votre cave, chez vous ! QU’AVEZ VOUS FAIT ???'),
(122, 19, 'Etait-ce réel ?', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous courrez vers la personne ! Vous frappez de toutes vos forces et l’entendez lâcher un cri de douleur et s’effondrer au sol. Vous réaliser que maintenant que cette personne s’est évaporé ! \r\nVous criez de peur, pour vous retrouvez par magie dans votre lit ! En en sortant vous réalisez que vous pieds sont tout sales, comme si vous étiez dans une cave...'),
(123, 20, 'Très familier', 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous regarder autour de vous et commencez à marcher dans cette habitation. La décoration semble familière, puis vous tilter. Vous êtes chez vous ! Aucune explication sur pourquoi vous êtiez dans la cave mais bravo !'),
(124, 21, 'La porte', 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous trouvez la porte la plus proche et vous enfuyez le plus loin possible sans vous retourner ! Qui sait, les personnes de la maison ne vous voulaient pas de mal...'),
(125, 22, 'La nourriture!', 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous vous dirigez vers la cuisine, ouvrez un placard et sortez des gâteaux. Vous avez facilement trouvé le placard, comme s’il vous étiez familié ! Votre frère entre dans la cuisine et vous dit bonjour. Ce n&#039;était donc rien de grave, vous taisez cette aventure pour toujours !'),
(126, 23, 'Aïe', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'En tombant vous vous frappez le crane, vous tomber raide !'),
(127, 25, 'La morsure', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Le rat s’approche de vous et vous mord ! Vous contenez un cri, hors la blessure gonfle très vite et votre vision se trouble ! IL NE FAUT JAMAIS FAIRE CONFIANCE A UN RAT !'),
(128, 29, 'Reussite', 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous courrez à toute vitesse et vous retrouvez hors d’une maison, dans la rue. Vous criez à l’aide, un policier vous voie ! Vous voilà sauvé ! BRAVO'),
(129, 30, 'Conséquences ? ', 3, NULL, -1, 35, 36, 37, 'Vous vous lancer dans les plus grandes excuses de la terre. Pas de conséquence pour vous !', 'Vous vous renfoncez dans un coin de la pièce et vous faites le plus petit possible', 'Vous criez sur votre agresseur ! D’où il vous enferme ?', 'Vous courrez dans la cave ! Une personne arrive devant la porte de la cave et vous vois en bas des escalier ! Son visage énervé à l’origine, semble adouci de vous voir encore dans la cave ! Que faites vous ?'),
(130, 31, 'Le grand coup !', 3, NULL, 0, 38, 39, 40, 'Vous lui mettez un grand coup dans la figure !', 'Vous prenez vos jambes à votre cou!', 'Vous freinez et vous préparer à esquiver un coup!', 'Vous courrez en direction du bruit et vous retrouvez face à un Homme d’une grande carrure très énervé ! Que faites vous ? '),
(131, 32, 'Fifi ?', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Vous la contournez, courrez dans les escaliers, passez à côté de votre père et sauté par dessus Fifi le chien roi ! Eh oui ! Vous êtes chez vous ! Pourquoi en faire tout un fromage ?'),
(132, 33, 'Maman &lt;3', 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Elle vous regarde avec inquiétude et vous prend dans ses bras. Elle vous explique que vous avez disparu de la soirée hier et qu’elle était très inquiète ! Heureusement vous êtes sains et saufs !'),
(133, 35, 'Excuses', 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'La personne écoute gentiment vos excuses tout en descendant des escaliers. Plus elle descend, plus le visage devient familié ! Celui de votre mère très peiné de constater qu’elle vous a enfermé dans la cave pour la nuit'),
(134, 36, 'La colère', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'La personne descend rapidement les escaliers en criant que vous êtes complètement taré ! Vous sortez de votre cachette et reconnaissez votre mère qui est complètement énervé de devoir réparer la porte ! Pourquoi ne pas juste toquer si vous étiez enfermé !'),
(135, 37, 'Mais ? ', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'La personne rigole et vous regarde de haut. Puis elle fonce sur vous ! Vous fermez les yeux à toute vitesse ! Quand vous les réouvrez, vous voilà dans votre lit, en pleine nuit, ce n’était donc qu’un cauchemar !'),
(136, 38, 'l&#039;esquive inatendue', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Cette grande masse l’évite mais votre élan vous propulse par terre ! Vous vous retourner, penaud, pour reconnaître la figure de la personne. Votre père ENERVE de constater que vous avez voulu le taper. Vous allez être punit TOUTE VOTRE VIE !'),
(137, 39, 'Punition...', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'La personne derrière vous vous rattrape ! Vous vous retourner, penaud, pour reconnaître la figure de la personne. Votre père ENERVE de constater que vous avez défoncé la porte de la cave familiale ! Vous allez être punit TOUTE VOTRE VIE !'),
(138, 40, 'La peur', 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Face à votre peur, la personne se radoucit, et constaste que vous être complètement sale et encore en pyjama. Vous relevez la tête et reconnaissez votre père, vous lui expliqué l’histoire. Il s’excuse et rigole lorsqu’il comprend pourquoi vous avez explosé la porte de la cave, heureusement elle est juste dégondée ! Eh oui la soirée d’hier était bien arrosé apparemment. ');

-- --------------------------------------------------------

--
-- Structure de la table `historique_partie`
--

CREATE TABLE `historique_partie` (
  `id_historique` int(11) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `id_chap` int(11) NOT NULL,
  `id_joueur` varchar(20) NOT NULL,
  `text_chapitre` text NOT NULL,
  `text_choix_fait` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `historique_partie`
--

INSERT INTO `historique_partie` (`id_historique`, `id_hist`, `id_chap`, `id_joueur`, `text_chapitre`, `text_choix_fait`) VALUES
(192, 1, 15, 'administrateur', 'Cette histoire débute un après-midi de printemps.  Charlie, son grand père Gérard, et son chien Fifi arrive à l’orée du bois de leur village. \r\nQuel personnage souhaitez-vous incarner?', 'NULL');

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

CREATE TABLE `partie` (
  `id_partie` int(11) NOT NULL,
  `id_utilisateur` varchar(20) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `point_de_vie` int(11) NOT NULL,
  `id_chap` int(11) NOT NULL,
  `etat_fin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `partie`
--

INSERT INTO `partie` (`id_partie`, `id_utilisateur`, `id_hist`, `point_de_vie`, `id_chap`, `etat_fin`) VALUES
(50, 'administrateur', 1, 3, 15, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_joueur` varchar(20) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `administrateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_joueur`, `mdp`, `administrateur`) VALUES
('administrateur', 'baba', 1),
('correcteur', 'mdp_correcteur_1234', 0),
('correcteur_admin', 'mdp_correcteur_1234', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chapitre`
--
ALTER TABLE `chapitre`
  ADD PRIMARY KEY (`id_ch_hors_hist`),
  ADD KEY `histoire_chap` (`id_hist`);

--
-- Index pour la table `histoire`
--
ALTER TABLE `histoire`
  ADD PRIMARY KEY (`hist_id`);

--
-- Index pour la table `historique_partie`
--
ALTER TABLE `historique_partie`
  ADD PRIMARY KEY (`id_historique`),
  ADD KEY `joueur_historique` (`id_joueur`),
  ADD KEY `histoire_historique` (`id_hist`);

--
-- Index pour la table `partie`
--
ALTER TABLE `partie`
  ADD PRIMARY KEY (`id_partie`),
  ADD KEY `histoire_partie` (`id_hist`),
  ADD KEY `joueur_partie` (`id_utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_joueur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chapitre`
--
ALTER TABLE `chapitre`
  MODIFY `id_ch_hors_hist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT pour la table `historique_partie`
--
ALTER TABLE `historique_partie`
  MODIFY `id_historique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT pour la table `partie`
--
ALTER TABLE `partie`
  MODIFY `id_partie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chapitre`
--
ALTER TABLE `chapitre`
  ADD CONSTRAINT `histoire_chap` FOREIGN KEY (`id_hist`) REFERENCES `histoire` (`hist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `historique_partie`
--
ALTER TABLE `historique_partie`
  ADD CONSTRAINT `histoire_historique` FOREIGN KEY (`id_hist`) REFERENCES `histoire` (`hist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joueur_historique` FOREIGN KEY (`id_joueur`) REFERENCES `utilisateur` (`id_joueur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `partie`
--
ALTER TABLE `partie`
  ADD CONSTRAINT `histoire_partie` FOREIGN KEY (`id_hist`) REFERENCES `histoire` (`hist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joueur_partie` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_joueur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
