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

INSERT INTO carshare (carshare_id, depart_adress, arrival_adress, depart_date, depart_time, price_person, used_vehicle, statut)
VALUES
(1, 'Lyon', 'Paris',    '2025-05-17', '08:00:00', 10, 1, 'terminé'),
(2, 'Lyon', 'Paris',    '2025-05-14', '14:00:00', 10, 1, 'terminé'),
(3, 'Lyon', 'Paris',    '2025-05-16', '09:00:00', 10, 1, 'terminé'),
(4, 'Lyon', 'Marseille','2025-05-15', '11:00:00', 15, 1, 'terminé'),
(5, 'Lyon', 'Grenoble', '2025-05-17', '08:30:00',  8, 1, 'terminé'),
(6, 'Lyon', 'Nice',     '2025-05-14', '07:30:00', 20, 1, 'créé'),
(7, 'Paris', 'Lyon',    '2025-05-13', '19:00:00', 10, 1, 'terminé'),
(8, 'Paris', 'Lyon',    '2025-05-13', '21:00:00', 10, 1, 'terminé');

INSERT INTO payment (amount, type, created_at, user_id, carshare_id)
VALUES
(2, 'commission', '2025-05-13', 26, 35),
(2, 'commission', '2025-05-13', 26, 36),
(2, 'commission', '2025-05-14', 26, 2),
(2, 'commission', '2025-05-15', 26, 4),
(2, 'commission', '2025-05-16', 26, 3),
(2, 'commission', '2025-05-17', 26, 1),
(2, 'commission', '2025-05-17', 26, 5),
(2, 'commission', '2025-05-14', 26, 10),
(2, 'commission', '2025-05-16', 26, 11),
(2, 'commission', '2025-05-15', 26, 12),
(2, 'commission', '2025-05-17', 26, 9),
(2, 'commission', '2025-05-17', 26, 13);

