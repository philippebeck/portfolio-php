DROP DATABASE IF EXISTS portfolio;
CREATE DATABASE portfolio CHARACTER SET utf8;
USE portfolio;

-- Creates the table Project
CREATE TABLE IF NOT EXISTS Project
(
    id              TINYINT         UNSIGNED    PRIMARY KEY     AUTO_INCREMENT,
    name            VARCHAR(50)     NOT NULL,
    image           VARCHAR(50)     NOT NULL    UNIQUE,
    link            VARCHAR(50)     NOT NULL    UNIQUE,
    year            YEAR            NOT NULL,
    project_type    VARCHAR(10)     NOT NULL,
    description     VARCHAR(255)    NOT NULL
)
    ENGINE=INNODB DEFAULT CHARSET=utf8;

-- Inserts the Project data
INSERT INTO Project
(name,                  image,                  link,                               year,       project_type,   description)
VALUES
('Phi Beck',            'phibeck.jpg',          'philippebeck/phibeck',             2017,       'website',      'My first project in FullJS'),
('Pam',                 'pam.png',              'philippebeck/pam',                 2018,       'tool',         'Php Approachable Microframework'),
('Jim',                 'jim.png',              'philippebeck/jim.js',              2018,       'tool',         'JavaScript Interactive Microlibrary'),
('Sam',                 'sam.png',              'philippebeck/sam.scss',            2018,       'tool',         'Scss Animated Microframework'),
('Pjs',                 'pjs.png',              'philippebeck/pjs',                 2018,       'tool',         'A microCMS with Pam, Jim & Sam'),
('Philippe Beck',       'philippebeck.jpg',     'philippebeck/philippebeck',        2018,       'website',      'Personal Website made with PJS'),
('WebAgency',           'webagency.jpg',        'philippebeck/webagency',           2019,       'website',      'Junior Web Developer Project 1'),
('Animadio',            'animadio.png',         'animadio/animadio',                2019,       'tool',         'CSS Framework'),
('Animadio.org',        'animadio-org.jpg',     'animadio/animadio.org',            2019,       'website',      'CSS Framework Website'),
('Animadio.doc',        'animadio-doc.jpg',     'animadio/doc.animadio.org',        2019,       'website',      'CSS Framework Documentation'),
('Portfolio',           'portfolio.jpg',        'philippebeck/portfolio',           2019,       'website',      'My own Portfolio');

-- Creates the table Certificate
CREATE TABLE IF NOT EXISTS Certificate
(
    id              TINYINT         UNSIGNED    PRIMARY KEY     AUTO_INCREMENT,
    name            VARCHAR(100)    NOT NULL,
    certif_id       VARCHAR(20)     NOT NULL    UNIQUE,
    link            VARCHAR(100)    NOT NULL    UNIQUE,
    certif_date     DATE            NOT NULL,
    certif_type     VARCHAR(10)     NOT NULL
)
    ENGINE=INNODB DEFAULT CHARSET=utf8;

-- Inserts the Certificate data
INSERT INTO Certificate
(name,                                                                  certif_id,          link,                                                                                           certif_date,    certif_type)
VALUES
('Comprendre le Web',                                                   '32748867',         'openclassrooms.com/course-certificates/32748867',                                              '2015-04-02',   'course'),
('Apprenez à créer votre site web avec HTML5 et CSS3',                  '14427758',         'openclassrooms.com/course-certificates/14427758',                                              '2015-04-03',   'course'),
('Concevez votre site web avec PHP et MySQL',                           '72787514',         'openclassrooms.com/course-certificates/72787514',                                              '2015-04-07',   'course'),
('Gérer son code avec Git et GitHub',                                   '32604883',         'openclassrooms.com/course-certificates/32604883',                                              '2015-04-09',   'course'),
('Reprenez le contrôle à l\'aide de Linux',                             '80426379',         'openclassrooms.com/course-certificates/80426379',                                              '2015-04-19',   'course'),
('Prenez en main Bootstrap',                                            '59300332',         'openclassrooms.com/course-certificates/59300332',                                              '2015-04-25',   'course'),
('Comprendre les factorisations et développements',                     '29492177',         'openclassrooms.com/course-certificates/29492177',                                              '2015-04-26',   'course'),
('Apprenez à naviguer en sécurité sur Internet',                        '25989454',         'openclassrooms.com/course-certificates/25989454',                                              '2015-04-26',   'course'),
('Les clés pour réussir son référencement web',                         '88331048',         'openclassrooms.com/course-certificates/88331048',                                              '2015-04-27',   'course'),
('Lancer son propre site Web',                                          '38026473',         'openclassrooms.com/learning-path-certificates/38026473',                                       '2015-04-29',   'path'),
('Intégrateur Web',                                                     '95052421',         'openclassrooms.com/learning-path-certificates/95052421',                                       '2015-04-29',   'path'),
('Débutez l\'analyse logicielle avec UML',                              '30182201',         'openclassrooms.com/course-certificates/30182201',                                              '2015-05-13',   'course'),
('Apprenez le fonctionnement des réseaux TCP/IP',                       '22219299',         'openclassrooms.com/course-certificates/22219299',                                              '2015-05-22',   'course'),
('Administrez vos bases de données avec MySQL',                         '3448711',          'openclassrooms.com/course-certificates/3448711',                                               '2015-05-26',   'course'),
('Développez votre site web avec le framework Symfony2',                '13958096',         'openclassrooms.com/course-certificates/13958096',                                              '2015-06-01',   'course'),
('Évoluez vers une architecture PHP professionnelle avec Silex',        '56033456',         'openclassrooms.com/course-certificates/56033456',                                              '2015-06-12',   'course'),
('Déployez des applications dans le cloud avec IBM Bluemix',            '76392846',         'openclassrooms.com/course-certificates/76392846',                                              '2015-06-25',   'course'),
('Structurez vos données avec XML',                                     '65656798',         'openclassrooms.com/course-certificates/65656798',                                              '2015-07-05',   'course'),
('Programmez en orienté objet en PHP',                                  '15958056',         'openclassrooms.com/course-certificates/15958056',                                              '2015-09-20',   'course'),
('Lancez-vous dans la programmation avec Ruby',                         '31063021',         'openclassrooms.com/course-certificates/31063021',                                              '2015-09-23',   'course'),
('Développez des sites PHP professionnels',                             '9291993677',       'openclassrooms.com/learning-path-certificates/9291993677',                                     '2015-10-09',   'path'),
('Développeur Web PHP / Symfony',                                       '8731315173',       'openclassrooms.com/learning-path-certificates/8731315173',                                     '2015-10-09',   'path'),
('Java et le XML',                                                      '39743255',         'openclassrooms.com/course-certificates/39743255',                                              '2015-10-18',   'course'),
('Java et les Annotations',                                             '87052328',         'openclassrooms.com/course-certificates/87052328',                                              '2015-10-19',   'course'),
('Java et les Collections',                                             '44410827',         'openclassrooms.com/course-certificates/44410827',                                              '2015-10-19',   'course'),
('Java et le Multithreading',                                           '51692375',         'openclassrooms.com/course-certificates/51692375',                                              '2015-10-21',   'course'),
('Java et la programmation réseau',                                     '8055073',          'openclassrooms.com/course-certificates/8055073',                                               '2015-10-21',   'course'),
('Apprenez à coder avec Javascript',                                    '48124810',         'openclassrooms.com/course-certificates/48124810',                                              '2015-10-26',   'course'),
('Apprenez à programmer en Java',                                       '67799028',         'openclassrooms.com/course-certificates/67799028',                                              '2015-10-28',   'course'),
('Devenez incollable en Java',                                          '1660110749',       'openclassrooms.com/learning-path-certificates/1660110749',                                     '2015-10-28',   'path'),
('Simplifiez vos développements JavaScript avec jQuery',                '97682071',         'openclassrooms.com/course-certificates/97682071',                                              '2015-11-22',   'course'),
('Initiez-vous à Ruby on Rails',                                        '6689046000',       'openclassrooms.com/course-certificates/6689046000',                                            '2016-01-06',   'course'),
('Développez des sites web avec Java EE',                               '4451779192',       'openclassrooms.com/course-certificates/4451779192',                                            '2016-01-08',   'course'),
('Découvrez les solutions CMS',                                         '2973509781',       'openclassrooms.com/course-certificates/2973509781',                                            '2016-01-27',   'course'),
('Devenez mentor sur OpenClassrooms',                                   '2543520126',       'openclassrooms.com/course-certificates/2543520126',                                            '2016-04-25',   'course'),
('Créez des pages web interactives avec JavaScript',                    '1406455307',       'openclassrooms.com/course-certificates/1406455307',                                            '2016-11-26',   'course'),
('Introduction à jQuery',                                               '3312506827',       'openclassrooms.com/course-certificates/3312506827',                                            '2016-11-30',   'course'),
('Créez votre premier site avec WordPress',                             '6208001863',       'openclassrooms.com/course-certificates/6208001863',                                            '2016-12-19',   'course'),
('Des applications ultra-rapides avec Node.js',                         '8999446573',       'openclassrooms.com/course-certificates/8999446573',                                            '2016-12-19',   'course'),
('Déployez vos applications Node.js sur le Cloud d’IBM Bluemix',        '3258888279',       'openclassrooms.com/learning-path-certificates/3258888279',                                     '2016-12-19',   'path'),
('Réalisez des sites modernes et beaux grâce à WordPress',              '2791030531',       'openclassrooms.com/course-certificates/2791030531',                                            '2016-12-24',   'course'),
('Utilisez des API REST dans vos projets web',                          '7283978932',       'openclassrooms.com/course-certificates/7283978932',                                            '2017-01-12',   'course'),
('Maintenez-vous à jour en développement',                              '9891690250',       'openclassrooms.com/course-certificates/9891690250',                                            '2017-01-18',   'course'),
('Développez une application mobile multi-plateforme avec Ionic',       '2192900343',       'openclassrooms.com/course-certificates/2192900343',                                            '2017-01-20',   'course'),
('Découvrez les bases de la gestion de projet',                         '5033047040',       'openclassrooms.com/course-certificates/5033047040',                                            '2017-01-21',   'course'),
('Apprenez à bien cadrer un projet multimédia',                         '7189192696',       'openclassrooms.com/course-certificates/7189192696',                                            '2017-01-24',   'course'),
('Réalisez le cahier des charges d\'un projet digital',                 '5160146863',       'openclassrooms.com/course-certificates/5160146863',                                            '2017-01-29',   'course'),
('Animez une communauté Twitter',                                       '3811524438',       'openclassrooms.com/course-certificates/3811524438',                                            '2017-01-30',   'course'),
('Démarrez votre projet avec Python',                                   '6352993420',       'openclassrooms.com/course-certificates/6352993420',                                            '2017-02-27',   'course'),
('Découvrez la programmation orientée objet avec Python',               '5826088328',       'openclassrooms.com/course-certificates/5826088328',                                            '2017-02-27',   'course'),
('Créez un jeu de plateau tour par tour en JavaScript',                 '5127302778',       'openclassrooms.com/course-certificates/5127302778',                                            '2017-03-13',   'course'),
('Simplonline',                                                         '4762327938',       'openclassrooms.com/learning-path-certificates/4762327938',                                     '2017-03-13',   'path'),
('HTML Fundamentals',                                                   '1014-4177086',     'www.sololearn.com/Certificate/1014-4177086/pdf',                                               '2017-03-25',   'course'),
('Découper et intégrer une maquette',                                   '4401125415',       'openclassrooms.com/course-certificates/4401125415',                                            '2017-03-28',   'course'),
('CSS Fundamentals',                                                    '1023-4177086',     'www.sololearn.com/Certificate/1023-4177086/pdf',                                               '2017-03-30',   'course'),
('JavaScript Tutorial',                                                 '1024-4177086',     'www.sololearn.com/Certificate/1024-4177086/pdf',                                               '2017-04-01',   'course'),
('PHP Tutorial',                                                        '1059-4177086',     'www.sololearn.com/Certificate/1059-4177086/pdf',                                               '2017-04-03',   'course'),
('jQuery Tutorial',                                                     '1082-4177086',     'www.sololearn.com/Certificate/1082-4177086/pdf',                                               '2017-04-03',   'course'),
('SQL Fundamentals',                                                    '1060-4177086',     'www.sololearn.com/Certificate/1060-4177086/pdf',                                               '2017-04-04',   'course'),
('Développez votre site web avec le framework Symfony',                 '7355911436',       'openclassrooms.com/course-certificates/7355911436',                                            '2017-04-09',   'course'),
('Découvrez le fonctionnement des algorithmes',                         '6583971979',       'openclassrooms.com/course-certificates/6583971979',                                            '2017-05-16',   'course'),
('Ruby Tutorial',                                                       '1081-4177086',     'www.sololearn.com/Certificate/1081-4177086/pdf',                                               '2018-03-06',   'course'),
('How do we work at OpenClassrooms?',                                   '3130586051',       'openclassrooms.com/fr/course-certificates/3130586051',                                         '2018-03-16',   'course'),
('Introduction to Python',                                              '5774951',          'www.datacamp.com/statement-of-accomplishment/course/18fbec4f703591842d5672a7afa25cf4bb84b271', '2018-04-19',   'course'),
('Testez fonctionnellement votre application Symfony',                  '9886717254',       'openclassrooms.com/fr/course-certificates/9886717254',                                         '2018-04-28',   'course'),
('Testez et suivez l''état de votre application PHP',                   '4167174266',       'openclassrooms.com/fr/course-certificates/4167174266',                                         '2018-04-28',   'course'),
('Développeur intégrateur en réalisation d\'applications web',          'beck-philippe',    'diplome.3wa.fr/beck-philippe',                                                                 '2018-05-14',   'degree'),
('Les étapes de la vie du Mentor',                                      '2508476469',       'openclassrooms.com/fr/course-certificates/2508476469',                                         '2018-07-15',   'course'),
('Être mentor sur OpenDeclic',                                          '8803517177',       'openclassrooms.com/fr/course-certificates/8803517177',                                         '2018-07-17',   'course'),
('Devenez Mentor Evaluateur',                                           '8505817551',       'openclassrooms.com/fr/course-certificates/8505817551',                                         '2018-07-18',   'course'),
('Perfectionnez-vous en Python',                                        '7945737797',       'openclassrooms.com/fr/course-certificates/7945737797',                                         '2018-08-02',   'course'),
('Devenez Mentor chez OpenClassrooms',                                  '6972286484',       'openclassrooms.com/fr/course-certificates/6972286484',                                         '2018-08-03',   'course'),
('Testez votre projet avec Python',                                     '6994803505',       'openclassrooms.com/fr/course-certificates/6994803505',                                         '2018-08-03',   'course'),
('Devenez auto-entrepreneur',                                           '5763945433',       'openclassrooms.com/fr/course-certificates/5763945433',                                         '2018-08-11',   'course'),
('Propulsez votre site avec WordPress',                                 '4551410136',       'openclassrooms.com/fr/course-certificates/4551410136',                                         '2018-11-22',   'course'),
('Modélisez et implémentez une base de données relationnelle avec UML', '5300844331',       'openclassrooms.com/fr/course-certificates/5300844331',                                         '2019-01-24',   'course'),
('Mettez en place un système de veille informationnelle',               '5847009556',       'openclassrooms.com/fr/course-certificates/5847009556',                                         '2019-05-08',   'course'),
('Devenez parrain et développez vos compétences transverses',           '6179314560',       'openclassrooms.com/fr/course-certificates/6179314560',                                         '2019-05-16',   'course');
