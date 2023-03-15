use chatpot;

INSERT INTO rooms(id, name) VALUE (1, 'General');
INSERT INTO rooms(name) VALUE ('Disney');

INSERT INTO chat(date_envoi, auteur, contenu, room_id) VALUE (DATE_ADD(now(), INTERVAL -5 MINUTE), 'Matthéo PERELLE', 'Bonjour la plouc', 1);
INSERT INTO chat(date_envoi, auteur, contenu, room_id) VALUE (DATE_ADD(now(), INTERVAL -4 MINUTE), 'Matthéo PERELLE', 'Comment tu t''appelles ?', 1);
INSERT INTO chat(date_envoi, auteur, contenu, room_id) VALUE (DATE_ADD(now(), INTERVAL -3 MINUTE), 'Anna NIETO', 'En-chantier, je m''appelle teuse et toi-ture ?', 1);
INSERT INTO chat(date_envoi, auteur, contenu, room_id) VALUE (DATE_ADD(now(), INTERVAL -2 MINUTE), 'Matthéo PERELLE', 'Et moi-ssonneuse, Et lui-le d''olive c''est mon frere', 1);
INSERT INTO chat(date_envoi, auteur, contenu, room_id) VALUE (DATE_ADD(now(), INTERVAL -1 MINUTE), 'Anna NIETO', 'Et moi ma mère-cédès', 1);