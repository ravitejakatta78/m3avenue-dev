ALTER TABLE `track_work` ADD `doc_status` INT(3) NOT NULL DEFAULT '0' AFTER `campaignuser_id`; 

CREATE TABLE `track_work_documents` ( 
`ID` INT NOT NULL 
, `doc_name` VARCHAR(255) NOT NULL 
, `employee_id` INT NOT NULL 
, `track_work_id` INT NOT NULL 
, `reg_date` DATE NOT NULL 
, `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
) ENGINE = InnoDB; 

ALTER TABLE `track_work_documents` CHANGE `ID` `ID` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`ID`); 