CREATE TABLE Fitnesszentrum(
AbteilungsNr INTEGER NOT NULL,
Name varchar (30),
PLZ number(5),
Ort varchar(30),
CONSTRAINT fitnesszentrum_pk PRIMARY KEY(AbteilungsNr),
CHECK (AbteilungsNr>0)
);

CREATE TABLE Mitarbeiter(
MNr INTEGER NOT NULL, 
LeiterMNr INTEGER,
Adresse varchar(40),
AbteilungsNr INTEGER NOT NULL,
Geburtsdatum DATE,
CONSTRAINT fitnesszentrum_fk FOREIGN KEY(AbteilungsNr) REFERENCES Fitnesszentrum(AbteilungsNr) ON DELETE CASCADE, 
CONSTRAINT leitermnr_fk FOREIGN KEY(LeiterMNr) REFERENCES Mitarbeiter(Mnr) ON DELETE CASCADE,
CONSTRAINT mitarbeiter_pk PRIMARY KEY (MNr),
CHECK(LeiterMNr>0),
CHECK(MNr>0)
);

CREATE TABLE Personal_Trainer(
MNr INTEGER,
TrainerID INTEGER NOT NULL CHECK(TrainerID>0),
Nachname varchar(30),
Vorname varchar(30),
CONSTRAINT personal_trainer_fk FOREIGN KEY (MNr) REFERENCES MITARBEITER(MNr) ON DELETE CASCADE,
CONSTRAINT personal_trainer_pk PRIMARY KEY (TrainerID)
);

CREATE TABLE Kunde(
KundenNr INTEGER NOT NULL CHECK(KundenNr>0),
Adresse varchar(30),
Telefonnummer varchar(10),
AbteilungsNr INTEGER,
TrainerID INTEGER,
CONSTRAINT kunde_pk PRIMARY KEY (KundenNr),
CONSTRAINT kunde_f_fk FOREIGN KEY (AbteilungsNr) REFERENCES Fitnesszentrum(AbteilungsNr) ON DELETE CASCADE,
CONSTRAINT kunde_pt_fk FOREIGN KEY (TrainerID) REFERENCES Personal_Trainer(TrainerID) ON DELETE CASCADE
);


CREATE TABLE Umkleidekabine(
AbteilungsNr INTEGER,
KabineNr INTEGER NOT NULL CHECK(KabineNr>0),
Geschlecht varchar(7),
CONSTRAINT umkleidekabine_f_fk FOREIGN KEY (AbteilungsNr) REFERENCES Fitnesszentrum(AbteilungsNr) ON DELETE CASCADE,
CONSTRAINT umkleidekabine_pk PRIMARY KEY(KabineNr)
);


CREATE TABLE Benutzung(
KundenNr INTEGER,
KabineNr NUMBER(4),
AbteilungsNr INTEGER,
Beginnzeit TIMESTAMP, 
Endzeit TIMESTAMP,
CONSTRAINT benutzung_fz_fk FOREIGN KEY (AbteilungsNr) REFERENCES Fitnesszentrum(AbteilungsNr) ON DELETE CASCADE,
CONSTRAINT benutzung_kunde_fk FOREIGN KEY (KundenNr) REFERENCES Kunde(KundenNr) ON DELETE CASCADE,
CONSTRAINT benutzung_kabine_fk FOREIGN KEY (KabineNr) REFERENCES Umkleidekabine(KabineNr) ON DELETE CASCADE
);

CREATE TABLE Abonnementstyp(
AboNr INTEGER NOT NULL CHECK(AboNr>0),
Kuendigungsfrist date,
Geschaeftsbedingunden VARCHAR(1000),
CONSTRAINT abonnementstyp_pk PRIMARY KEY (AboNr)
);


CREATE TABLE RezeptionistIn(
MNr INTEGER,
SVNummer INTEGER NOT NULL CHECK(SVNummer>0),
email varchar(40),
CONSTRAINT rezeptionistin_fk FOREIGN KEY (MNr) REFERENCES MITARBEITER(MNr) ON DELETE CASCADE,
CONSTRAINT rezeptionistin_pk PRIMARY KEY (SVNummer)
);

CREATE TABLE Verkauf (
AboNr INTEGER,
KundenNr INTEGER,
SVNummer INTEGER,
CONSTRAINT verkauf_kunde_fk FOREIGN KEY (KundenNr) REFERENCES Kunde(KundenNr) ON DELETE CASCADE,
CONSTRAINT verkauf_abotyp_fk FOREIGN KEY (AboNr) REFERENCES Abonnementstyp(AboNr) ON DELETE CASCADE,
CONSTRAINT verkauf_rez_fk FOREIGN KEY (SVNummer) REFERENCES RezeptionistIn(SVNummer) ON DELETE CASCADE
);

CREATE SEQUENCE seq_persnr
INCREMENT BY 1
START WITH 1;

  
CREATE OR REPLACE TRIGGER mnrplus
BEFORE INSERT
ON Mitarbeiter
REFERENCING NEW AS NEW
FOR EACH ROW
BEGIN
SELECT seq_persnr.nextval INTO :NEW.MNr FROM dual;
END;
/


/*Zaehlt die Anzahl der Mitarbeiter*/
create view anzahl_ma (Anzahl) AS 
SELECT COUNT(MNr) 
FROM Mitarbeiter;

/* Zeigt die Namen des Trainers, die Kunden trainieren(KundeNr). Wer wen trainiert. */
create view trainer (Trainer_Name, KundeNr) AS
SELECT Nachname, KundenNr
FROM personal_trainer join Kunde ON Personal_Trainer.TrainerID = Kunde.TrainerID;

/* Zeigt die Trainers, die mehr als 1 Kunde trainieren*/
CREATE VIEW mehrals1(TrainerID, Kunden_Anzahl) AS
SELECT TrainerID, Count(kundennr)
FROM Kunde
GROUP BY TrainerID
HAVING Count(kundennr) > 1;




