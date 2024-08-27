/**Culmination Project**/

/** Create Players Table */
CREATE TABLE players (
    player_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30),
    jersey_num INT,
    position VARCHAR(30),
    nationality VARCHAR(30));


/** Insert players **/
INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Pedri', 8, 'midfielder', 'Spain');
    
INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Marc Andre Ter Stegen', 1, 'goalkeeper', 'Germany');
    
INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Ronald Araujo', 4, 'defender', 'Uruguay');
    
INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Gavi', 6, 'midfielder', 'Spain');
    
INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Raphinha', 11, 'forward', 'Brazil');
    
INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Ferran Torres', 7, 'forward', 'Spain');
    
INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Robert Lewandowski', 9, 'forward', 'Poland');
    
INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Alejandro Balde', 3, 'defender', 'Spain');

INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Inaki Pena', 13, 'goalkeeper', 'Spain');

INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Inigo Martinez', 5, 'defender', 'Spain');
        
INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Andreas Christensen', 15, 'defender', 'Denmark');

INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Frenkie de Jong', 21, 'Midfielder', 'Netherlands');

INSERT INTO players (name, jersey_num, position, nationality) VALUES ('Joao Felix', 14, 'Forward', 'Portugal');
    
/** Create Teams Table */
CREATE TABLE team (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30),
    trophies_won INT);

/** Insert Teams **/
INSERT INTO team (name, num_of_trophies) VALUES
    ("Barcelona FC 2010-2011", 3),
    ("Barcelona FC 2011-2012", 4),
    ("Barcelona FC 2012-2013", 1),
    ("Barcelona FC 2013-2014", 1),
    ("Barcelona FC 2014-2015", 3),
    ("Barcelona FC 2015-2016", 4),
    ("Barcelona FC 2016-2017", 2),
    ("Barcelona FC 2017-2018", 2),
    ("Barcelona FC 2018-2019", 2),
    ("Barcelona FC 2019-2020", 0),
    ("Barcelona FC 2020-2021", 1),
    ("Barcelona FC 2021-2022", 0),
    ("Barcelona FC 2022-2023", 2);

    
/** Create Trophies Table **/
CREATE TABLE trophies (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    competition VARCHAR(30),
    year INT,
    team_id INT,
    FOREIGN KEY(team_id) REFERENCES team(id));    


/** Insert trophies **/
INSERT INTO trophies (competition, year, team_id) VALUES ("La Liga", 2011, 1), ("Spanish Supercup", 2010, 1), ("Uefa Champions League", 2011, 1);

INSERT INTO trophies (competition, year, team_id) VALUES
    ('Copa del Rey', 2012, 2),
    ('Spanish Super Cup', 2011, 2),
    ('UEFA Super Cup', 2011, 2),
    ('FIFA CLub World Cup', 2011, 2),
    ('La Liga', 2013, 3),
    ('Spanish Super Cup', 2013, 4),
    ('La Liga', 2015, 5),
    ('Copa del Rey', 2015, 5),
    ('UEFA Champions League', 2015, 5),
    ('La Liga', 2016, 6),
    ('Copa del Rey', 2016, 6),
    ('UEFA Super Cup', 2015, 6),
    ('FIFA Club World Cup', 2015, 6),
    ('Copa del Rey', 2017, 7),
    ('Spanish Super Cup', 2016, 7),
    ('La Liga', 2018, 8),
    ('Copa del Rey', 2018, 8),
    ('La Liga', 2019, 9),
    ('Spanish Super Cup', 2018, 9),
    ('Copa del Rey', 2021, 11),
    ('La Liga', 2023, 13),
    ('Spanish Super Cup', 2023, 13);

/** Create Manager Table **/
CREATE TABLE Manager (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30),
    nationality VARCHAR(30));

/** Insert into Manager table **/
INSERT INTO manager (name, nationality) VALUES
    ('Pep Guardiola', 'Spain'),
    ('Tito Villanova', 'Spain'),
    ('Gerardo Martino', 'Argentina'),
    ('Luis Enrique', 'Spain'),
    ('Ernesto Valverde', 'Spain'),
    ('Quique Setien', 'Spain'),
    ('Ronald Koeman', 'Netherlands'),
    ('Xavi', 'Spain');

/** Create ManagerTeam Junction Table **/
CREATE TABLE manager_team ( manager_id INT, team_id INT, CONSTRAINT PK_manager_team
PRIMARY KEY (manager_id,team_id), FOREIGN KEY (manager_id) REFERENCES manager(id), FOREIGN KEY (team_id) REFERENCES team(id));


/** Insert into ManagerTeam Junction Table **/
INSERT INTO manager_team VALUES (1,1), (1,2);

INSERT INTO manager_team VALUES  (2,2), (3,4), (4,5), (4,6), (4, 7), (5, 8), (5,9), (5, 10), (6, 10), (7, 11), (8, 12), (8, 13);


/** Create playerteam Junction Table **/
CREATE TABLE player_team (player_id INT, team_id INT, CONSTRAINT PK_player_team PRIMARY KEY (player_id, team_id), FOREIGN KEY (player_id) REFERENCES players(player_id), FOREIGN KEY(team_id) REFERENC
ES team(id));

/** Insert into playerteam junction table **/

INSERT INTO player_team VALUES (1, 10), (1, 11), (1, 12), (1, 13);

INSERT INTO player_team VALUES (2,5), (2,6), (2,7), (2,8), (2,9), (2, 10), (2, 11), (2,12), (2,13), (3, 10), (3,11), (3,12), (3,13);

INSERT INTO player_team VALUES (4,12), (4,13), (5, 13), (6, 13), (7, 13), (8, 12), (8,13), (11, 9), (11, 10), (11,11), (11,12), (11,13), (12, 13), (13, 13), (14, 10), (14, 11), (14, 12), (14, 13), (15,
13), (24, 13);

INSERT INTO player_team VALUES (28, 1), (28, 2), (28, 3), (28, 4), (28, 5), (28, 6), (28, 7), (28, 8);

/** Create user authenitcation table **/
CREATE TABLE reg_user (
    username VARCHAR(20),
    password VARCHAR(30));

INSERT INTO reg_user VALUES 
    ("imacleod"),
    ("Password123");





