sqlite3 mobile.db

CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT,
    code TEXT,
    gain REAL,
    proprio BOOLEAN
);

CREATE TABLE prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT,
    operateur_id INTEGER,
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id)
);

CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT,
    prenom TEXT,
    numero_telephone TEXT
);

CREATE TABLE comptes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER,
    solde REAL,
    date_creation TEXT,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE types_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT
);

CREATE TABLE frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    montant_min REAL,
    montant_max REAL,
    type_operation_id INTEGER,
    frais REAL
);

CREATE TABLE operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER,
    compte_source_id INTEGER,
    compte_destination_id INTEGER,
    montant REAL,
    frais REAL,
    commission REAL,
    date_operation TEXT,
    FOREIGN KEY (type_operation_id) REFERENCES types_operation(id),
    FOREIGN KEY (compte_source_id) REFERENCES comptes(id),
    FOREIGN KEY (compte_destination_id) REFERENCES comptes(id)
);

CREATE TABLE commissions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operateur_id INTEGER,
    pct_commission REAL,
    FOREIGN KEY (operateur_id) REFERENCES operateurs(id)
);

INSERT INTO operateurs (nom, code, gain, proprio) VALUES ('MVola', 'MV', 0, 1);
INSERT INTO operateurs (nom, code, gain, proprio) VALUES ('Airtel Money', 'AM', 0, 0);

INSERT INTO prefixes (prefixe, operateur_id) VALUES ('034', 1);
INSERT INTO prefixes (prefixe, operateur_id) VALUES ('038', 1);
INSERT INTO prefixes (prefixe, operateur_id) VALUES ('033', 2);

INSERT INTO clients (nom, prenom, numero_telephone) VALUES ('RST', 'Kevin', '0345259316');
INSERT INTO clients (nom, prenom, numero_telephone) VALUES ('RAJ', 'Manoa', '0382172098');
INSERT INTO clients (nom, prenom, numero_telephone) VALUES ('RAK', 'Xavier', '0330500312');
INSERT INTO clients (nom, prenom, numero_telephone) VALUES ('RAJ', 'Razafy', '0345259317');

INSERT INTO comptes (client_id, solde, date_creation) VALUES (1, 0, '2024-01-01');
INSERT INTO comptes (client_id, solde, date_creation) VALUES (2, 0, '2024-01-01');
INSERT INTO comptes (client_id, solde, date_creation) VALUES (3, 0, '2024-01-01');
INSERT INTO comptes (client_id, solde, date_creation) VALUES (4, 0, '2024-01-01');

INSERT INTO types_operation (libelle) VALUES ('Transfert'), ('Retrait'), ('Depot');

INSERT INTO frais (montant_min, montant_max, frais, type_operation_id) VALUES 
(0, 10000, 500, 1),
(10001, 50000, 1000, 1),
(50001, 100000, 1500, 1),
(100001, 200000, 2000, 1),
(200001, 500000, 3000, 1),
(500001, 1000000, 4000, 1),
(0, 10000, 300, 2),
(10001, 50000, 800, 2),
(50001, 100000, 1200, 2),
(100001, 200000, 1500, 2),
(200001, 500000, 2500, 2),
(500001, 1000000, 3500, 2);

INSERT INTO commissions (operateur_id, pct_commission) VALUES (2, 0.03);

CREATE VIEW historique_details AS
SELECT 
    o.id AS operation_id,
    t.libelle AS type_operation,
    t.id AS type_operation_id,

    cs.id AS compte_source_id,
    cd.id AS compte_destination_id,

    c1.nom || ' ' || c1.prenom AS client_source,
    c2.nom || ' ' || c2.prenom AS client_destination,

    o.montant,
    o.frais,
    o.commission,
    o.date_operation

FROM operations o

JOIN types_operation t 
    ON o.type_operation_id = t.id

LEFT JOIN comptes cs 
    ON o.compte_source_id = cs.id

LEFT JOIN comptes cd 
    ON o.compte_destination_id = cd.id

LEFT JOIN clients c1 
    ON cs.client_id = c1.id

LEFT JOIN clients c2 
    ON cd.client_id = c2.id;