

CREATE TABLE IF NOT EXISTS `a9_tests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `finished_at` datetime DEFAULT NULL,
  `results` text,
  `result_type` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `a9_questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer_a` varchar(255) NOT NULL,
  `answer_b` varchar(255) NOT NULL,
  `IE` tinyint(4) NOT NULL DEFAULT '0',
  `SN` tinyint(4) NOT NULL DEFAULT '0',
  `FT` tinyint(4) NOT NULL DEFAULT '0',
  `JP` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;



INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(1, 'At a social event I am more likely to interact with...', 'a few close friends', 'lots of friends or strangers', -1, 0, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(2, 'During a crisis, I tend to...', 'stay calm', 'rely on my empathy', 0, 0, 1, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(3, 'I am more apt to...', 'try to please everyone', 'notice mistakes made by others', 0, 0, 0, 1);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(4, 'I am more interested in...', 'what is real', 'possibilities', 0, -1, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(5, 'I am more trusting of...', 'my gut instinct', 'what I have personally experienced', 0, 1, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(6, 'I honestly think of myself as...', 'sensitive', 'thick-skinned', 0, 0, -1, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(7, 'I place a high value on...', 'privacy', 'knowing everyone', -1, 0, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(8, 'I prefer to go through life...', 'wherever life leads me', 'on a strict schedule', 0, 0, 0, 1);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(9, 'I tend to make decisions based on...', 'measurable data', 'my feelings', 0, 0, 1, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(10, 'I would say that I am more...', 'pragmatic', 'idealistic', 0, -1, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(11, 'In an argument, I usually...', 'compromise or look for common ground', 'stick to my position', 0, 0, -1, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(12, 'People respect me for...', 'my devotion to others', 'by ability to be reasonable', 0, 0, -1, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(13, 'People think of me as...', 'easy to approach', 'reserved', 1, 0, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(14, 'People who know me well regard me as...', 'an easy-going person', 'a serious person', 0, 0, 0, 1);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(15, 'When a job is almost completed, I am more likely to...', 'work hard to finish', 'start something else', 0, 0, 0, -1);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(16, 'When conversing with someone...', 'I usually do the talking', 'I usually listen more', 1, 0, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(17, 'When I receive a message from a casual acquaintance, I reply to it...', 'within a few days', 'immediately', -1, 0, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(18, 'When I talk to someone, I tend to speak about...', 'specifics', 'things in general', 0, -1, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(19, 'When making an important decision, I usually...', 'make up my mind quickly and be done', 'think things over for a long time', 0, 0, 0, -1);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(20, 'When meeting new people, I tend to be...', 'objective', 'friendly', 0, 0, 1, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(21, 'When traveling to a place I have never been, I prefer to use...', 'nothing, I never get lost', 'a GPS app or written directions', 0, 1, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(22, 'When walking around in the world, I tend to feel...', 'removed from others', 'connected to everyone', 0, 1, 0, 0);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(23, 'When working on a project, my goal is...', 'a complete, finished product', 'a better understanding of how it works', 0, 0, 0, -1);
INSERT INTO `a9_questions` (`id`, `question`, `answer_a`, `answer_b`, `IE`, `SN`, `FT`, `JP`) VALUES(24, 'With my colleagues at work/school,...', 'I tend to be talkative', 'I tend to say little', 1, 0, 0, 0);

