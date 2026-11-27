-- USER

INSERT INTO users
(
    username,
    email,
    password_hash,
    role,
    status
)
VALUES
('Anna',      'Anna@test.de',      'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Ben',       'Ben@test.de',       'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Clara',     'Clara@test.de',     'TEST_ACCOUNT_NO_LOGIN', 'user', 'Überprüfung'),
('David',     'David@test.de',     'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Emma',      'Emma@test.de',      'TEST_ACCOUNT_NO_LOGIN', 'user', 'Bearbeitung'),
('Felix',     'Felix@test.de',     'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Greta',     'Greta@test.de',     'TEST_ACCOUNT_NO_LOGIN', 'user', 'abgelehnt'),
('Hannah',    'Hannah@test.de',    'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Jonas',     'Jonas@test.de',     'TEST_ACCOUNT_NO_LOGIN', 'user', 'Überprüfung'),
('Klara',     'Klara@test.de',     'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Leon',      'Leon@test.de',      'TEST_ACCOUNT_NO_LOGIN', 'user', 'Bearbeitung'),
('Mia',       'Mia@test.de',       'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Noah',      'Noah@test.de',      'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Olivia',    'Olivia@test.de',    'TEST_ACCOUNT_NO_LOGIN', 'user', 'Überprüfung'),
('Paul',      'Paul@test.de',      'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Sophie',    'Sophie@test.de',    'TEST_ACCOUNT_NO_LOGIN', 'user', 'abgelehnt'),
('Theo',      'Theo@test.de',      'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Viktoria',  'Viktoria@test.de',  'TEST_ACCOUNT_NO_LOGIN', 'user', 'Bearbeitung'),
('Yannick',   'Yannick@test.de',   'TEST_ACCOUNT_NO_LOGIN', 'user', 'bestätigt'),
('Zoe',       'Zoe@test.de',       'TEST_ACCOUNT_NO_LOGIN', 'user', 'Überprüfung');

-- SET ORGANIZER

UPDATE users
SET role = 'organizer'
WHERE user_id IN (3, 12, 25);

-- EVENTS

INSERT INTO events
(
    title,
    location,
    description,
    event_start,
    event_end,
    organizer_id
)
VALUES

(
    'PHP Workshop',
    'Köln',
    'Ein praxisorientierter Workshop zu den Grundlagen von PHP, Formularverarbeitung und Datenbankzugriff.',
    '2026-12-03 10:00:00',
    '2026-12-03 15:00:00',
    25
),

(
    'Gaming Abend',
    'Bonn',
    'Gemeinsamer Gaming-Abend mit verschiedenen Multiplayer-Spielen.',
    '2026-12-05 18:00:00',
    '2026-12-05 23:00:00',
    3
),

(
    'SQL Grundlagen',
    'Siegburg',
    'Einführung in relationale Datenbanken, SELECT-Abfragen, JOINs und grundlegende Datenbankmodellierung.',
    '2026-12-08 09:00:00',
    '2026-12-08 14:00:00',
    12
),

(
    'Weihnachtsmarkt Treffen',
    'Köln',
    'Gemeinsamer Besuch des Weihnachtsmarktes mit anschließendem gemütlichen Beisammensein.',
    '2026-12-12 16:00:00',
    '2026-12-12 21:00:00',
    25
),

(
    'Git und GitHub Workshop',
    'Online',
    'Praktische Einführung in Git, Branches, Commits, Merge und die Zusammenarbeit über GitHub.',
    '2026-12-15 10:00:00',
    '2026-12-15 14:00:00',
    3
);

-- ANMELDUNGEN

INSERT INTO event_registration
(
    user_id,
    event_id
)
VALUES
-- Merry Christmas
(11, 1),
(12, 1),
(13, 1),
(14, 1),

-- Happy Birthday!
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),

-- Frohes Neues!
(20, 3),
(21, 3),
(22, 3),

-- Happy Halloween
(23, 4),
(24, 4),
(25, 4),
(26, 4),
(27, 4),
(28, 4),

-- PHP Workshop
(11, 5),
(13, 5),
(15, 5),
(17, 5),
(19, 5),

-- Gaming Abend
(12, 6),
(14, 6),
(16, 6),
(18, 6),

-- SQL Grundlagen
(21, 7),
(23, 7),
(24, 7),

-- Weihnachtsmarkt Treffen
(26, 8),
(27, 8),
(28, 8),
(29, 8),

-- Git und GitHub Workshop
(11, 9),
(20, 9),
(22, 9),
(24, 9),
(30, 9);

-- INTERESSEN

INSERT INTO interests
(
    user_id,
    event_id
)
VALUES
-- Merry Christmas
(15, 1),
(16, 1),
(17, 1),

-- Happy Birthday!
(11, 2),
(12, 2),
(13, 2),

-- Frohes Neues!
(23, 3),
(24, 3),
(25, 3),
(26, 3),

-- Happy Halloween
(11, 4),
(12, 4),

-- PHP Workshop
(14, 5),
(16, 5),
(18, 5),
(20, 5),

-- Gaming Abend
(13, 6),
(15, 6),
(17, 6),
(19, 6),
(21, 6),

-- SQL Grundlagen
(11, 7),
(15, 7),
(17, 7),
(25, 7),

-- Weihnachtsmarkt Treffen
(12, 8),
(16, 8),
(20, 8),

-- Git und GitHub Workshop
(13, 9),
(17, 9);

