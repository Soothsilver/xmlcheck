CREATE TABLE assignments (id INT AUTO_INCREMENT NOT NULL, deadline DATETIME NOT NULL, reward INT NOT NULL, deleted TINYINT(1) NOT NULL, problemId INT DEFAULT NULL, groupId INT DEFAULT NULL, INDEX groupId (groupId), INDEX problemId (problemId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE attachments (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, file VARCHAR(255) NOT NULL, lectureId INT DEFAULT NULL, INDEX IDX_47C4FAD63BC48E00 (lectureId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, submissionId INT DEFAULT NULL, INDEX IDX_A2B072889E929263 (submissionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE groups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, deleted TINYINT(1) NOT NULL, lectureId INT DEFAULT NULL, ownerId INT DEFAULT NULL, INDEX lectureId (lectureId), INDEX ownerId (ownerId), UNIQUE INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE lectures (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, deleted TINYINT(1) NOT NULL, ownerId INT DEFAULT NULL, INDEX ownerId (ownerId), UNIQUE INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE plugins (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, mainFile VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, config LONGTEXT NOT NULL, UNIQUE INDEX name (name), UNIQUE INDEX folder (mainFile), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE tests (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, config LONGTEXT NOT NULL, input VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, success INT NOT NULL, info LONGTEXT NOT NULL, output VARCHAR(255) NOT NULL, pluginId INT DEFAULT NULL, INDEX pluginId (pluginId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE problems (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, config LONGTEXT NOT NULL, deleted TINYINT(1) NOT NULL, lectureId INT DEFAULT NULL, pluginId INT DEFAULT NULL, INDEX pluginId (pluginId), INDEX lectureId (lectureId), UNIQUE INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, options LONGTEXT NOT NULL, attachments LONGTEXT NOT NULL, lectureId INT DEFAULT NULL, INDEX lectureId (lectureId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE similarities (id INT AUTO_INCREMENT NOT NULL, score INT NOT NULL, details LONGTEXT NOT NULL, suspicious TINYINT(1) NOT NULL, oldSubmissionId INT DEFAULT NULL, newSubmissionId INT DEFAULT NULL, INDEX IDX_DDD1B6BA5471A4A1 (oldSubmissionId), INDEX IDX_DDD1B6BA4A114A1D (newSubmissionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE submissions (id INT AUTO_INCREMENT NOT NULL, submissionFile VARCHAR(255) NOT NULL, date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, success INT NOT NULL, info LONGTEXT NOT NULL, outputFile VARCHAR(255) NOT NULL, rating INT NOT NULL, explanation LONGTEXT NOT NULL, similarityStatus VARCHAR(255) NOT NULL, assignmentId INT DEFAULT NULL, userId INT DEFAULT NULL, INDEX assignmentId (assignmentId), INDEX userId (userId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE subscriptions (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, groupId INT DEFAULT NULL, userId INT DEFAULT NULL, INDEX userId (userId), INDEX groupId (groupId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, type INT DEFAULT NULL, name VARCHAR(255) NOT NULL, pass VARCHAR(255) NOT NULL, realName VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, lastAccess DATETIME NOT NULL, activationCode VARCHAR(255) NOT NULL, encryptionType VARCHAR(255) NOT NULL, resetLink VARCHAR(255) DEFAULT NULL, resetLinkExpiry DATETIME DEFAULT NULL, send_email_on_submission_rated TINYINT(1) NOT NULL, send_email_on_new_assignment TINYINT(1) NOT NULL, send_email_on_new_submission TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, INDEX type (type), UNIQUE INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE privileges (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, privileges INT NOT NULL, UNIQUE INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE xtests (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, template LONGTEXT NOT NULL, count INT NOT NULL, generated LONGTEXT NOT NULL, lectureId INT DEFAULT NULL, INDEX IDX_82F1254C3BC48E00 (lectureId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

ALTER TABLE assignments ADD CONSTRAINT FK_308A50DDBB4C47C8 FOREIGN KEY (problemId) REFERENCES problems (id);
ALTER TABLE assignments ADD CONSTRAINT FK_308A50DDED8188B0 FOREIGN KEY (groupId) REFERENCES groups (id);
ALTER TABLE attachments ADD CONSTRAINT FK_47C4FAD63BC48E00 FOREIGN KEY (lectureId) REFERENCES lectures (id);
ALTER TABLE documents ADD CONSTRAINT FK_A2B072889E929263 FOREIGN KEY (submissionId) REFERENCES submissions (id);
ALTER TABLE groups ADD CONSTRAINT FK_F06D39703BC48E00 FOREIGN KEY (lectureId) REFERENCES lectures (id);
ALTER TABLE groups ADD CONSTRAINT FK_F06D3970E05EFD25 FOREIGN KEY (ownerId) REFERENCES users (id);
ALTER TABLE lectures ADD CONSTRAINT FK_63C861D0E05EFD25 FOREIGN KEY (ownerId) REFERENCES users (id);
ALTER TABLE tests ADD CONSTRAINT FK_1260FC5E9A9A50E9 FOREIGN KEY (pluginId) REFERENCES plugins (id);
ALTER TABLE problems ADD CONSTRAINT FK_8E6662453BC48E00 FOREIGN KEY (lectureId) REFERENCES lectures (id);
ALTER TABLE problems ADD CONSTRAINT FK_8E6662459A9A50E9 FOREIGN KEY (pluginId) REFERENCES plugins (id);
ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D53BC48E00 FOREIGN KEY (lectureId) REFERENCES lectures (id);
ALTER TABLE similarities ADD CONSTRAINT FK_DDD1B6BA5471A4A1 FOREIGN KEY (oldSubmissionId) REFERENCES submissions (id);
ALTER TABLE similarities ADD CONSTRAINT FK_DDD1B6BA4A114A1D FOREIGN KEY (newSubmissionId) REFERENCES submissions (id);
ALTER TABLE submissions ADD CONSTRAINT FK_3F6169F74526B08C FOREIGN KEY (assignmentId) REFERENCES assignments (id);
ALTER TABLE submissions ADD CONSTRAINT FK_3F6169F764B64DCC FOREIGN KEY (userId) REFERENCES users (id);
ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A01ED8188B0 FOREIGN KEY (groupId) REFERENCES groups (id);
ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A0164B64DCC FOREIGN KEY (userId) REFERENCES users (id);
ALTER TABLE users ADD CONSTRAINT FK_1483A5E98CDE5729 FOREIGN KEY (type) REFERENCES privileges (id);
ALTER TABLE xtests ADD CONSTRAINT FK_82F1254C3BC48E00 FOREIGN KEY (lectureId) REFERENCES lectures (id);

INSERT INTO `privileges` (`id`, `name`, `privileges`) VALUES (1,'STUDENT',2816),(2,'ADMIN',16777215),(3,'lecturer',622816),(4,'tutor',10760192),(5,'administrator',2769147);

INSERT INTO `users` (`id`, `name`, `type`, `pass`, `realName`, `email`, `lastAccess`, `activationCode`, `encryptionType`, `resetLink`, `resetLinkExpiry`, `send_email_on_submission_rated`, `send_email_on_new_assignment`, `send_email_on_new_submission`, `deleted`) VALUES (1,'admin',2,md5('admin'),'Administrator','admin@example.com','2012-01-04 09:50:03','','md5',NULL,NULL,1,1,1,0)