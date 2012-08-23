/*
 * Declares two procedures and can be called:
 * source year.vs.left.sql;
 * call benchleft(); call benchyear();
 *
 * More information: visit: http://blog.hoeja.de/sql-left-vs-year.html
 */

use benchmark;
DROP PROCEDURE IF EXISTS benchleft;
DELIMITER //
CREATE PROCEDURE benchleft()
BEGIN

DECLARE v2 INT DEFAULT 0;
SET @secho = '';

v1loop: WHILE v2 < 10000000 DO
  SELECT LEFT(NOW(),4) INTO @secho;
  SET v2=v2+1;
END WHILE v1loop;
END//
DELIMITER ;


DROP PROCEDURE IF EXISTS benchyear;
DELIMITER //
CREATE PROCEDURE benchyear()
BEGIN

DECLARE v2 INT DEFAULT 0;
SET @secho = '';

v1loop: WHILE v2 < 10000000 DO
  SELECT YEAR(NOW()) INTO @secho;
  SET v2=v2+1;
END WHILE v1loop;
END//
DELIMITER ;
