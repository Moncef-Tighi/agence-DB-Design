CREATE DATABASE projet_conception_db


create table locataire (
   id_locataire INT NOT NULL AUTO_INCREMENT,
   revenu INT,
   nom VARCHAR(25) NOT NULL,
   prenom VARCHAR(25) NOT NULL,
   adresse_email VARCHAR(50) NOT NULL,
   date_naissance DATE,
   PRIMARY KEY ( id_locataire )
);
create table proprietaire (
   id_proprietaire INT NOT NULL AUTO_INCREMENT,
   nom VARCHAR(25) NOT NULL,
   prenom VARCHAR(25) NOT NULL,
   adresse_email VARCHAR(50) NOT NULL,
   date_naissance DATE,
   PRIMARY KEY ( id_proprietaire )
);
create table employe (
   id_employe INT NOT NULL AUTO_INCREMENT,
   salaire INT NOT NULL,
   identifiant VARCHAR(25) NOT NULL,
   mot_de_passe VARCHAR(200) NOT NULL,
   nom VARCHAR(25) NOT NULL,
   prenom VARCHAR(25) NOT NULL,
   adresse_email VARCHAR(50) NOT NULL,
   date_naissance DATE,
   poste INT DEFAULT 3,
   PRIMARY KEY ( id_employe ),
   FOREIGN KEY (poste) REFERENCES poste(id_poste)
);

create table poste (
    id_poste INT NOT NULL AUTO_INCREMENT,
    poste VARCHAR(25) NOT NULL,
    PRIMARY KEY (id_poste)
    );

create table reservation (
   id_location INT NOT NULL AUTO_INCREMENT,
   date_debut DATE NOT NULL,
   date_fin DATE NOT NULL,
   lointaine BOOLEAN NOT NULL,
   id_locataire INT NOT NULL,
   id_bien INT NOT NULL,
   PRIMARY KEY ( id_location ),
   FOREIGN KEY (id_locataire) REFERENCES locataire(id_locataire),
   FOREIGN KEY (id_bien) REFERENCES bien_immobilier(id_bien)
);

create table visite (
   id_visite INT NOT NULL AUTO_INCREMENT,
   date_visite DATE NOT NULL,
   id_locataire INT NOT NULL,
   id_employe INT NOT NULL,
   id_bien INT NOT NULL,
   PRIMARY KEY ( id_visite ),
   FOREIGN KEY (id_locataire) REFERENCES locataire(id_locataire),
   FOREIGN KEY (id_employe) REFERENCES employe(id_employe),
   FOREIGN KEY (id_bien) REFERENCES Bien_immobilier(id_bien)
);


create table bon_visite (
   id_bon INT NOT NULL AUTO_INCREMENT,
   fin_validite DATE,
   id_visite INT NOT NULL,
   PRIMARY KEY ( id_bon ),
   FOREIGN KEY (id_visite) REFERENCES bon_visite(id_visite)
);


create table detail_deplacement (
   id_deplacement INT NOT NULL AUTO_INCREMENT,
   date_deplacement DATE NOT NULL,
   id_employe INT NOT NULL,
   PRIMARY KEY ( id_deplacement ),
   FOREIGN KEY (id_employe) REFERENCES employe(id_employe)
);

create table contrat (
   id_contrat INT NOT NULL AUTO_INCREMENT,
   realise_le DATE NOT NULL,
   signe BOOLEAN,
   id_employe INT NOT NULL,
    id_bien INT NOT NULL,
    id_reservation INT NOT NULL,
   PRIMARY KEY ( id_contrat ),
   FOREIGN KEY (id_employe) REFERENCES employe(id_employe),
   FOREIGN KEY (id_bien) REFERENCES bien_immobilier(id_bien),
    FOREIGN KEY (id_reservation) REFERENCES reservation(id_reservation)

);


create table bien_immobilier (
    id_bien INT NOT NULL AUTO_INCREMENT,
    tarif_nuit INT NOT NULL,
    acte_propriete VARCHAR(100),
    longitude FLOAT,
    latitude FLOAT,
    id_type INT NOT NULL,
    id_proprietaire  INT NOT NULL,
    PRIMARY KEY ( id_bien ),
    FOREIGN KEY (id_type) REFERENCES type_bien(id_type),
    FOREIGN KEY (id_proprietaire) REFERENCES proprietaire(id_proprietaire)

);

create table type_bien (
   id_type INT NOT NULL AUTO_INCREMENT,
   type VARCHAR(25),
   PRIMARY KEY ( id_type )
);

create table description (
    id_description INT NOT NULL AUTO_INCREMENT,
    surface INT NOT NULL,
    nombre_piece INT NOT NULL,
    id_bien INT NOT NULL,
    PRIMARY KEY ( id_description ),
    FOREIGN KEY (id_bien) REFERENCES bien_immobilier(id_bien)
);


create table images (
    id_image INT NOT NULL AUTO_INCREMENT,
    src VARCHAR(100) DEFAULT "../img/default.png",
    description_image TEXT,
    id_description  INT NOT NULL,
    PRIMARY KEY ( id_image ),
    FOREIGN KEY (id_description) REFERENCES description(id_description)
);

create table equipements (
    id_equipements INT NOT NULL AUTO_INCREMENT,
    id_description  INT NOT NULL,
    id_type INT NOT NULL,
    PRIMARY KEY ( id_equipements ),
    FOREIGN KEY (id_description) REFERENCES description(id_description),
    FOREIGN KEY (id_type) REFERENCES type_equipement(id_type)
);

create table type_equipement (
    id_type INT NOT NULL AUTO_INCREMENT,
    type_equipement VARCHAR(25 )NOT NULL,
    PRIMARY KEY ( id_type )
);

create table fiche_proximite (
    id_fiche INT NOT NULL AUTO_INCREMENT,
    distance FLOAT NOT NULL,
    id_description  INT NOT NULL,
    id_type INT NOT NULL,
    PRIMARY KEY ( id_fiche ),
    FOREIGN KEY (id_type) REFERENCES lieu_interet(id_type)
);

create table lieu_interet (
    id_type INT NOT NULL AUTO_INCREMENT,
    type_lieu VARCHAR(40) NOT NULL,
    PRIMARY KEY ( id_type )
);

create table adresse (
    id_adresse INT NOT NULL AUTO_INCREMENT,
    numero_maison INT NOT NULL,
    etage INT,
    quartier VARCHAR(50),
    wilaya_id INT NOT NULL,
    ville_id INT NOT NULL,
    id_description INT NOT NULL,
    PRIMARY KEY ( id_adresse ),
    FOREIGN KEY (id_description) REFERENCES description(id_description),
    FOREIGN KEY (wilaya_id) REFERENCES wilaya(wilaya_id),
    FOREIGN KEY (ville_id) REFERENCES ville(ville_id)
);

create table wilaya (
    wilaya_id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(40) NOT NULL,
    PRIMARY KEY ( wilaya_id )
);
create table ville (
    ville_id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(40) NOT NULL,
    wilaya_id INT NOT NULL,
    PRIMARY KEY ( ville_id ),
    FOREIGN KEY (wilaya_id) REFERENCES wilaya(wilaya_id)
);

create table prix_reel (
    id_prix INT NOT NULL AUTO_INCREMENT,
    frais_agence FLOAT DEFAULT 0.1 CHECK (frais_agence>0 AND frais_agence<1),
    id_bien INT NOT NULL,
    id_reservation INT NOT NULL,
    id_saison INT NOT NULL,
    PRIMARY KEY ( id_prix ),
    FOREIGN KEY (id_bien) REFERENCES bien_immobilier(id_bien),
    FOREIGN KEY (id_reservation) REFERENCES reservation(id_reservation),
    FOREIGN KEY (id_saison) REFERENCES saison(id_saison)
);


create table saison (
    id_saison INT NOT NULL AUTO_INCREMENT,
    debut_saison DATE NOT NULL,
    fin_saison DATE NOT NULL,
    tarif_saison FLOAT NOT NULL CHECK (tarif_saison>-1 AND tarif_saison<1),
    PRIMARY KEY ( id_saison )
);

create table evenements_speciaux (
    id_evenement INT NOT NULL AUTO_INCREMENT,
    nom_evenement VARCHAR(25) NOT NULL,
    changement FLOAT NOT NULL CHECK (changement>-1 AND changement<1),
    id_saison INT NOT NULL,
    PRIMARY KEY ( id_evenement ),
    FOREIGN KEY (id_saison) REFERENCES saison(id_saison)
);

create table payement_complet (
    id_paiment INT NOT NULL AUTO_INCREMENT,
    encaisse BOOLEAN NOT NULL,
    montant FLOAT NOT NULL CHECK (montant>0),
    id_prix INT NOT NULL,
    id_employe INT NOT NULL,
    PRIMARY KEY ( id_paiment ),
    FOREIGN KEY (id_prix) REFERENCES prix_reel(id_prix),
    FOREIGN KEY (id_employe) REFERENCES employe(id_employe)
);


create table arrhes (
    id_prepaiment INT NOT NULL AUTO_INCREMENT,
    encaisse BOOLEAN NOT NULL,
    montant FLOAT NOT NULL CHECK (montant>0),
    id_paiment INT NOT NULL,
    id_employe INT NOT NULL,
    PRIMARY KEY ( id_prepaiment ),
    FOREIGN KEY (id_paiment) REFERENCES payement_complet(id_paiment),
    FOREIGN KEY (id_employe) REFERENCES employe(id_employe)
);

create table versement_location (
    id_versement INT NOT NULL AUTO_INCREMENT,
    verse BOOLEAN NOT NULL,
    montant FLOAT NOT NULL CHECK (montant>0),
    id_paiment INT NOT NULL,
    id_proprietaire INT NOT NULL,
    id_employe INT NOT NULL,
    PRIMARY KEY ( id_versement ),
    FOREIGN KEY (id_paiment) REFERENCES payement_complet(id_paiment),
    FOREIGN KEY (id_proprietaire) REFERENCES proprietaire(id_proprietaire),
    FOREIGN KEY (id_employe) REFERENCES employe(id_employe)
);

create table reception (
   id_reception INT NOT NULL AUTO_INCREMENT,
   date_reception DATE NOT NULL,
   commentaire_assistant TEXT,
   id_locataire INT,
   id_proprietaire INT,
   id_employe INT NOT NULL,
   PRIMARY KEY ( id_reception ),
   FOREIGN KEY (id_locataire) REFERENCES locataire(id_locataire),
   FOREIGN KEY (id_proprietaire) REFERENCES proprietaire(id_proprietaire),
    FOREIGN KEY (id_employe) REFERENCES employe(id_employe)
);
