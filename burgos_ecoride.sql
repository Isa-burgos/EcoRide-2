CREATE TABLE role(
    role_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE user(
    user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    phone INT(10) NOT NULL,
    adress VARCHAR(255) NOT NULL,
    birth_date DATETIME NOT NULL,
    photo BLOB,
    gender VARCHAR(50) NOT NULL,
    role ENUM('user', 'admin', 'employe') DEFAULT 'user',
    credit_balance INT(11) NOT NULL
);

CREATE TABLE vehicle(
    vehicle_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    registration VARCHAR(50),
    first_registration_date DATE NOT NULL,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    color VARCHAR(50) NOT NULL,
    energy VARCHAR(50) NOT NULL,
    belong INT(11) NOT NULL,
    Foreign Key (belong) REFERENCES user(user_id)
);

CREATE TABLE carshare(
    carshare_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    price_person FLOAT NOT NULL,
    depart_adress VARCHAR(255) NOT NULL,
    arrival_adress VARCHAR(255) NOT NULL,
    depart_date DATE NOT NULL,
    arrival_date DATE NOT NULL,
    depart_time TIME NOT NULL,
    arrival_time TIME NOT NULL,
    statut VARCHAR(50) NOT NULL,
    nb_place TINYINT,
    used_vehicle INT(11) NOT NULL,
    Foreign Key (used_vehicle) REFERENCES vehicle(vehicle_id)
);

CREATE TABLE statut(
    statut_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE user_carshare(
    user_id INT(11),
    carshare_id INT(11),
    Foreign Key (user_id) REFERENCES user(user_id),
    Foreign Key (carshare_id) REFERENCES carshare(carshare_id),
    PRIMARY KEY(user_id, carshare_id)
);

CREATE TABLE user_statut(
    user_id INT(11),
    statut_id INT(11),
    Foreign Key (user_id) REFERENCES user(user_id),
    Foreign Key (statut_id) REFERENCES statut(statut_id),
    PRIMARY KEY (user_id, statut_id)
);

INSERT INTO role (name) VALUE ('utilisateur');

INSERT INTO user (name, firstname, email, password, possess) 
    VALUES ('Doe', 'John', 'test@test.fr', '123', 1);

ALTER TABLE user MODIFY COLUMN password VARCHAR(255) NOT NULL;

UPDATE user 
SET pseudo = 'JohnD',
    phone = '0606060606',
    adress = '20 rue de la ville, 07200 Aubenas',
    birth_date = '1980-01-01',
    photo = 'photo',
    gender = 'homme'
WHERE user_id = 3; 

INSERT INTO carshare (price_person, depart_adress, arrival_adress, depart_date, arrival_date, depart_time, arrival_time, statut, nb_place, used_vehicle) 
VALUES ('3', 'Aubenas', 'Montélimar', '2023-02-02', '2023-02-02', '08-00', '08-45', 'terminé', '2', 1);

INSERT INTO vehicle (registration, first_registration_date, brand, model, color, energy, belong)
VALUES ('XX-000-XX', '2020-01-01', 'Renault', 'Captur', 'gris', 'thermique', 3)

ALTER TABLE vehicle ADD COLUMN energy_icon VARCHAR(255) NOT NULL;

UPDATE vehicle SET energy_icon = 'electric-icon.svg' WHERE energy = '1';
UPDATE vehicle SET energy_icon = 'thermal-icon.svg' WHERE energy = '0';

ALTER TABLE user 
MODIFY COLUMN photo VARCHAR(255) NULL;

SELECT vehicle_id, brand, model, energy FROM vehicle;

ALTER TABLE preferences
DROP FOREIGN KEY preferences_ibfk_1,
DROP COLUMN user_id,
ADD COLUMN vehicle_id INT NOT NULL,
ADD CONSTRAINT preferences_vehicle FOREIGN KEY (vehicle_id) REFERENCES vehicle(vehicle_id) ON DELETE CASCADE;

SELECT password FROM user;

DESCRIBE user;

SELECT * FROM role;

ALTER TABLE carshare DROP COLUMN nb_place;

ALTER TABLE vehicle ADD nb_place INT NOT NULL DEFAULT 1;

ALTER TABLE user_carshare
ADD COLUMN role ENUM('conducteur', 'passager') NOT NULL DEFAULT 'passager';
DESCRIBE user_carshare;

CREATE TABLE payment(
    payment_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    amount FLOAT NOT NULL,
    type ENUM('payment', 'revenue', 'commission'),
    created_at TIMESTAMP NOT NULL,
    user_id INT(11) NOT NULL,
    carshare_id INT(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (carshare_id) REFERENCES carshare(carshare_id)
);

ALTER TABLE payment DROP COLUMN credit_balance;
ALTER TABLE user ADD COLUMN credit_balance INT(11) NOT NULL;

INSERT INTO user (name, firstname, pseudo, email, password, gender, role, credit_balance)
VALUES
    ('Dupont', 'Alice', 'Alicedupont', 'alicedupont@email.fr', 'Azerty@11', 'femme', 'user', 80),
    ('Dupont', 'Alain', 'Alaindupont', 'alaindupont@email.fr', 'Azerty@11', 'homme', 'user', 25),
    ('Durand', 'Michel', 'Micheldurand', 'micheldurand@email.fr', 'Azerty@11', 'homme', 'user', 50),
    ('Froment', 'Zoé', 'Zoefroment', 'zoefroment@email.fr', 'Azerty@11', 'femme', 'user', 0),
    ('Rodriguez', 'José', 'admin', 'admin@email.fr', 'Azerty@11', 'homme', 'admin', 80);

INSERT INTO vehicle (registration, first_registration_date, brand, model, color, energy, nb_place, belong)
VALUES
    ('EE-000-EE', '2022-02-01', 'Citroen', 'C3', 'rouge', '1', 2, 22),
    ('EE-111-EE', '2020-02-01', 'Renault', 'captur', 'gris', '0', 1, 24),
    ('EE-222-EE', '2019-02-01', 'Volkswagen', 'Touran', 'vert', '0', 3, 25);


INSERT INTO statut (name)
VALUES
    ('passager'),
    ('conducteur'),
    ('passager et conducteur');

INSERT INTO user_statut (user_id, statut_id)
VALUES
    (22, 3),
    (23, 4),
    (24, 5),
    (25, 3);

INSERT INTO carshare (depart_adress, arrival_adress, depart_date, depart_time, arrival_time, used_vehicle)
VALUES
    ('Valence', 'Aubenas', '2025-04-30', '08:00:00', '09:15:00', 29),
    ('Valence', 'Aubenas', '2025-04-30', '10:00:00', '11:15:00', 30),
    ('Valence', 'Aubenas', '2025-04-30', '16:30:00', '17:45:00', 31);

UPDATE carshare
SET price_person =20
WHERE carshare_id = 29;
UPDATE carshare
SET price_person =15
WHERE carshare_id = 30;
UPDATE carshare
SET price_person =16
WHERE carshare_id = 31;

INSERT INTO user_carshare (user_id, carshare_id)
VALUES
    (22, 29),
    (25, 29);

INSERT INTO payment (user_id, carshare_id, amount, type, created_at)
VALUES
    (22, 29, 20, 'payment', CURRENT_TIMESTAMP),
    (23, 29, 16, 'revenue', CURRENT_TIMESTAMP),
    (26, 29, 2, 'commission', CURRENT_TIMESTAMP);

CREATE TABLE reservations (
    reservation_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    carshare_id INT(11) NOT NULL,
    reservation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (carshare_id) REFERENCES carshare(carshare_id),
    UNIQUE (user_id, carshare_id)
);

ALTER TABLE reservations
ADD COLUMN reserved_places INT NOT NULL DEFAULT 1;

ALTER TABLE user
ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1;
