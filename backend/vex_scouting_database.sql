DROP DATABASE IF EXISTS vex_scouting;
CREATE DATABASE IF NOT EXISTS vex_scouting
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

USE vex_scouting;

CREATE TABLE IF NOT EXISTS matches (
  match_number int(11) NOT NULL DEFAULT 0,
  team_redA varchar(255) DEFAULT NULL,
  team_redB varchar(255) DEFAULT NULL,
  team_blueA varchar(255) DEFAULT NULL,
  team_blueB varchar(255) DEFAULT NULL,
  redScore varchar(255) DEFAULT NULL,
  blueScore varchar(255) DEFAULT NULL,
  PRIMARY KEY (match_number)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 244
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS pitscout_records (
  team varchar(255) NOT NULL,
  drivetype int(11) DEFAULT NULL,
  intakehold int(11) DEFAULT NULL,
  shootertype int(11) DEFAULT NULL,
  aimedgoal int(11) DEFAULT NULL,
  shooterspeed int(11) DEFAULT NULL,
  autodesc int(11) DEFAULT NULL,
  eleposs int(11) DEFAULT NULL,
  elespeed int(11) DEFAULT NULL,
  drivercontrolballs int(11) DEFAULT NULL,
  driverstrat int(11) DEFAULT NULL,
  PRIMARY KEY (team)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 5461
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS scout_records (
  id int(11) NOT NULL AUTO_INCREMENT,
  match_number int(11) DEFAULT NULL,
  team varchar(255) DEFAULT NULL,
  showedup tinyint(1) DEFAULT NULL,
  functionalentirematch tinyint(1) DEFAULT NULL,
  startingposition tinyint(1) DEFAULT NULL,
  elevation tinyint(1) DEFAULT NULL,
  elevationheight tinyint(1) DEFAULT NULL,
  elevationpart tinyint(1) DEFAULT NULL,
  automade int(11) DEFAULT NULL,
  automissed int(11) DEFAULT NULL,
  drivermade int(11) DEFAULT NULL,
  driverlow int(11) DEFAULT NULL,
  drivermissed int(11) DEFAULT NULL,
  stacksintaked int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX UK_scout_records (match_number, team)
)
ENGINE = INNODB
AUTO_INCREMENT = 264
AVG_ROW_LENGTH = 189
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS teams (
  team_number varchar(255) NOT NULL,
  team_name varchar(50) DEFAULT NULL,
  organization varchar(255) DEFAULT NULL,
  location varchar(255) DEFAULT NULL,
  PRIMARY KEY (team_number)
)
ENGINE = INNODB
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

DELIMITER $$

CREATE PROCEDURE addmatch (IN matchNum int, IN redA varchar(255), IN redB varchar(255), IN blueA varchar(255), IN blueB varchar(255))
SQL SECURITY INVOKER
MODIFIES SQL DATA
BEGIN
  INSERT INTO matches (match_number, team_redA, team_redB, team_blueA, team_blueB)
    VALUES (matchNum, redA, redB, blueA, blueB)
  ON DUPLICATE KEY UPDATE
  match_number = matchNum,
  team_redA = redA,
  team_redB = redB,
  team_blueA = blueA,
  team_blueB = blueB;
  SELECT
    1 AS 'suc';
END
$$

CREATE PROCEDURE addPitScout (IN team_in varchar(255), IN drivetype_in int(11), IN intakehold_in int(11), IN shootertype_in int(11), IN aimedgoal_in int(11), IN shooterspeed_in int(11), IN autodesc_in int(11), IN eleposs_in int(11), IN elespeed_in int(11), IN drivercontrolballs_in int(11), IN driverstrat_in int(11))
SQL SECURITY INVOKER
BEGIN
  INSERT INTO pitscout_records (team,
  drivetype,
  intakehold,
  shootertype,
  aimedgoal,
  shooterspeed,
  autodesc,
  eleposs,
  elespeed,
  drivercontrolballs,
  driverstrat)
    VALUES (team_in, drivetype_in, intakehold_in, shootertype_in, aimedgoal_in, shooterspeed_in, autodesc_in, eleposs_in, elespeed_in, drivercontrolballs_in, driverstrat_in);
  SELECT
    1 AS 'success_code';
END
$$

CREATE PROCEDURE addScoutRecord (IN matchNumber varchar(255),
IN teamNumber varchar(255),
IN teamShowedUp bool,
IN teamWorkedAllMatch bool,
IN teamStartPosition bool,
IN teamElevation bool,
IN teamElevationHeight bool,
IN teamElevationPart bool,
IN autoShotsMade int,
IN autoShotsMissed int,
IN driverShotsMade int,
IN driverLowShots int,
IN driverShotsMissed int,
IN teamstacksIntaked int)
SQL SECURITY INVOKER
BEGIN
  INSERT INTO scout_records (match_number,
  team,
  showedup,
  functionalentirematch,
  startingposition,
  elevation,
  elevationheight,
  elevationpart,
  automade,
  automissed,
  drivermade,
  driverlow,
  drivermissed,
  stacksintaked)
    VALUES (matchNumber, teamNumber, teamShowedUp, teamWorkedAllMatch, teamStartPosition, teamElevation, teamElevationHeight, teamElevationPart, autoShotsMade, autoShotsMissed, driverShotsMade, driverLowShots, driverShotsMissed, teamstacksIntaked);

  SELECT
    1 AS success_code;
END
$$

CREATE PROCEDURE getMatches ()
SQL SECURITY INVOKER
BEGIN
  SELECT
    *
  FROM matches
  ORDER BY match_number ASC;
END
$$

CREATE PROCEDURE getMatchesByTeam (IN team varchar(255))
SQL SECURITY INVOKER
BEGIN
  SELECT
    *
  FROM matches m
  WHERE m.team_redA = team
  OR m.team_redB = team
  OR m.team_blueA = team
  OR m.team_blueB = team;
END
$$

CREATE PROCEDURE getMatchInfo (IN matchnum int)
SQL SECURITY INVOKER
BEGIN
  SELECT
    m.*
  FROM matches m
  WHERE m.match_number = matchnum;
END
$$

CREATE PROCEDURE getPitScoutRecord (IN team varchar(255))
SQL SECURITY INVOKER
BEGIN
  SELECT
    *
  FROM pitscout_records pr
  WHERE pr.team = team;
END
$$

CREATE PROCEDURE getScout (IN `match` int, IN team varchar(255))
SQL SECURITY INVOKER
BEGIN
  SELECT
    *
  FROM scout_records sr
  WHERE sr.match_number = `match`
  AND sr.team = team;
END
$$

CREATE PROCEDURE getScoutRecord (IN teamin varchar(255), IN matchin varchar(255))
SQL SECURITY INVOKER
BEGIN
  SELECT
    sr.id
  FROM scout_records sr
  WHERE sr.match_number = matchin
  AND sr.team = teamin;
END
$$

CREATE PROCEDURE getTeamsInMatch (IN matchA int)
SQL SECURITY INVOKER
BEGIN
  SELECT
    m.team_redA,
    m.team_redB,
    m.team_blueA,
    m.team_blueB
  FROM matches m
  WHERE m.match_number = `matchA`;
END
$$

CREATE PROCEDURE updateMatchScore (IN redScore int, IN blueScore int, IN matchnum int)
SQL SECURITY INVOKER
BEGIN
  UPDATE matches m
  SET m.redScore = redScore,
      m.blueScore = blueScore
  WHERE m.match_number = matchnum;
  SELECT
    1 AS 'suc';
END
$$

DELIMITER ;
