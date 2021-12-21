-- -----------------------------------------------------
-- Looper insertion example
-- -----------------------------------------------------

INSERT INTO `exercises` (`id`, `title`, `status_id`)
VALUES (1, 'Culture générale', 1),
       (2, 'Quizz mathématiques', 2),
       (3, 'Révisions allemand', 2),
       (4, 'Révisions anglais', 3),
       (5, 'Chimie culture générale', 2),
       (6, 'Orthographe', 1),
       (7, 'Quizz de culture générale niveau Expert', 2);

--  ----------------- Questions insertion ----------------- --

INSERT INTO `questions` (`id`, `text`, `exercise_id`, `type_id`)
VALUES (1, 'Quel est le plus grand lac de Suisse ?', 1, 2),
       (2, 'Quelle pièce est absolument à protéger dans un jeu d\'échec ?', 1, 2),
	(3, 'Combien y a-t-il de signes astrologiques chinois ?', 1, 2),
	(4, 'Qui a écrit les misérables ?', 1, 1),
	(5, 'Quel est la 1ère émission de télé réalité a avoir été diffuser en France ?', 1, 3),
	(6, 'Le produit est le résultat :', 2, 2),
	(7, 'Quel est le carré du quart du tiers de 12 ?', 2, 1),
	(8, 'Une carte routière est à l\'échelle 1/250 000. Quelle distance réelle représentent 4 cm sur cette carte ?', 2,
        3),
       (9, 'Bananen sind reich ... Magnesium', 3, 1),
       (10, 'Er braucht ... zu sagen', 3, 1),
       (11, 'Ich habe ... ein Döner zu essen', 3, 3),
       (12, 'What are ... names? Dan and Sandra', 4, 1),
       (13, 'I don’t want to ... at home tonight, I want to come with you!', 4, 1),
       (14, 'I have a meeting ... 4 p.m.', 4, 1),
       (15, 'Comment s\'appelle la table de laboratoire sur laquelle le chimiste fait ses expériences ?', 5, 1),
	(16, 'Quel grand physicien, prix Nobel, découvrit la radioactivité ?', 5, 1),
	(17, 'Quel est le troisième état de la matière (les deux premiers étant : solide, liquide) ?', 5, 1),
	(18, 'À quelle température, l\'eau se change-t-elle en gaz ?', 5, 1),
       (19, 'Les pommes qu’elle a acheté… sont trop mûres.', 6, 1),
       (20, 'Selon la légende, comment le pape Adrien IV est-il mort en 1159 ?', 7, 1),
       (21, 'Que signifie "palimpseste"?', 7, 1),
       (22, 'Quel philosophe a écrit « Les origines du totalitarisme » et « La crise de la culture » ? ', 7, 3);


--  ----------------- Users insertion ----------------- --
INSERT INTO `users` (`id`, `name`)
VALUES (1, '2021-12-20 09:45:47 UTC'),
       (2, '2021-12-20 09:46:05 UTC'),
       (3, '2021-12-20 09:48:31 UTC');

--  ----------------- Answers insertion ----------------- --
INSERT INTO `answers` (`id`, `question_id`, `user_id`, `answer`)
VALUES (1, 12, 1, 'theirs'),
       (2, 13, 1, 'go'),
       (3, 14, 1, 'at'),
       (4, 12, 2, 'Je sais pas'),
       (5, 13, 2, 'Je sais pas'),
       (6, 14, 2, 'Je sais pas'),
       (7, 15, 3, 'Table d\' Ikea'),
	(8, 16, 3, 'Pittet'),
	(9, 17, 3, 'gazeux'),
	(10, 18, 3, '100°C');