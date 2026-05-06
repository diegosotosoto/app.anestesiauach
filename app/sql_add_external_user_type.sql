-- Add external_ column to usuarios_dolor table
ALTER TABLE `usuarios_dolor` ADD COLUMN `external_` INT(1) DEFAULT 0 AFTER `becad_otro`;
