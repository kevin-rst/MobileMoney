sqlite3 mobile.db

CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT,
    code TEXT,
    gain REAL
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
    frais REAL
);

CREATE TABLE operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER,
    compte_source_id INTEGER,
    compte_destination_id INTEGER,
    montant REAL,
    frais REAL,
    date_operation TEXT,
    FOREIGN KEY (type_operation_id) REFERENCES types_operation(id),
    FOREIGN KEY (compte_source_id) REFERENCES comptes(id),
    FOREIGN KEY (compte_destination_id) REFERENCES comptes(id)
);


INSERT INTO operateurs (nom, code, gain) VALUES ('MVola', 'MV', 0);
INSERT INTO operateurs (nom, code, gain) VALUES ('Airtel Money', 'AM', 0);

INSERT INTO prefixes (prefixe, operateur_id) VALUES ('034', 1);
INSERT INTO prefixes (prefixe, operateur_id) VALUES ('038', 1);
INSERT INTO prefixes (prefixe, operateur_id) VALUES ('033', 2);

INSERT INTO clients (nom, prenom, numero_telephone) VALUES ('RST', 'Kevin', '0345259316');
INSERT INTO clients (nom, prenom, numero_telephone) VALUES ('RAJ', 'Manoa', '0332172098');

INSERT INTO comptes (client_id, solde, date_creation) VALUES (1, 0, '2024-01-01');
INSERT INTO comptes (client_id, solde, date_creation) VALUES (2, 0, '2024-01-01');

INSERT INTO types_operation (libelle) VALUES ('Transfert'), ('Retrait'), ('Depot');

INSERT INTO frais (montant_min, montant_max, frais) VALUES 
(100, 1000, 50),
(1001, 10000, 500),
(10001, 50000, 1000),
(50001, 100000, 2000),
(100001, 500000, 5000),
(500001, 1000000, 10000);

-- ALTER TABLE operateurs ADD COLUMN code TEXT;
-- ALTER TABLE operateurs ADD COLUMN gain REAL;

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
    o.date_operation
FROM operations o
JOIN types_operation t ON o.type_operation_id = t.id
JOIN comptes cs ON o.compte_source_id = cs.id
JOIN comptes cd ON o.compte_destination_id = cd.id
JOIN clients c1 ON cs.client_id = c1.id
JOIN clients c2 ON cd.client_id = c2.id;