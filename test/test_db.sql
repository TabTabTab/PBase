CREATE TABLE IF NOT EXISTS TestTable(
    ID INT AUTO_INCREMENT,
    testEntry VARCHAR(100) UNIQUE NOT NULL,
    additional CHAR(100) NOT NULL,
    PRIMARY KEY (ID)
);

INSERT INTO TestTable (ID, testEntry, additional) VALUES(1, 'note1', 'additional1');
INSERT INTO TestTable (ID, testEntry, additional) VALUES(2, 'note2', 'additional2');

CREATE USER 'test_user'@'localhost' IDENTIFIED BY '123456abc';
GRANT ALL PRIVILEGES ON test.* To 'test_user'@'localhost' IDENTIFIED BY '123456abc';