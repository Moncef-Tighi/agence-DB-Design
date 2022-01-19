INSERT INTO employe (salaire, identifiant, mot_de_passe, prenom,nom, adresse_email,date_naissance, poste)
VALUES
(30000,"agent",'dc4e2a95815187ffff36d0a4c6c08a5b5ee2228df06165db73f64a4ea9b11431','Moncef', 'Tighiouart','moncef@gmail.com','1999-09-19',2),
(28000,"assistant",'881af8dc9aded30a4ddd7c0101c4c4a368d62b22478858dab88287e66d5d8458','Rachid', 'Ameur','Rachid@gmail.com','1990-07-12',3),
(40000, "directeur",'81454d5e769afb0dc04e6c24ca6aa510649543aa3b5a2394504cb75cdf566523','Adel', 'Amir','Adel@gmail.com','1988-02-25',1)

/*
Mot de passe : SHA-256 + Salting avec l'identifiant
*/

INSERT INTO poste(poste)
VALUES
("Directeur"),
("Agent de location"),
("Assistant de location")




INSERT INTO locataire (revenu,nom,prenom, adresse_email,date_naissance)
VALUES
	(40000, 'Amira', 'Mathews','Amira@gmail.com','1998-11-02'),
  (28000, 'Sandra', 'Nguyen','Sandra@gmail.com','2001-04-12'),
	(84500, 'Laurence', ' Hayes','Laurence@gmail.com','1975-03-24'),
	(32050, 'Oscar', 'Sherma','Oscar@gmail.com','1976-08-05'),
	(65000, 'Arjun', 'Livingston','Arjun@gmail.com','2000-05-16'),
	(25000, 'Rida', 'Case','Rida@gmail.com','1968-10-29')


INSERT INTO proprietaire (nom,prenom, adresse_email,date_naissance)
VALUES
	('Amir', 'Howell','Amir@gmail.com','1987-12-04'),
    ('Ted', 'Brewer','Ted@gmail.com','1950-08-12'),
	('Teo', ' Halliday','Teo@gmail.com','1976-04-24'),
	('Wesley', 'Travers','Wesley@gmail.com','1976-07-08')

	INSERT INTO type_bien (type)
VALUES
	('appartement'),
    ('villa'),
	('etages de villa'),
	('maisons'),
    ('bungalows')

INSERT INTO bien_immobilier (tarif_nuit,acte_propriete,longitude,latitude,id_type,id_proprietaire)
VALUES 
	(1500, "acte_1.png",7.762307,36.897519,1,1), /* Annaba, Annaba*/
    (800, "acte_2.jpg",7.719319,36.819387,3,2), /* sidi amar, Annaba*/
    (2200, "acte_3.jpg",2.951505,36.765527,5,3) /* Cheraga, Alger*/


INSERT INTO type_equipement (type_equipement)
VALUES
	('climatisation'),
    ('télévision'),
	('cuisinière'),
	('micro-one'),
    ('frigidaire'),
    ('machine à laver'),
    ("lave-vaisselle"),
    ('tables/chaises'),
    ('ustentils de cuisines')

INSERT INTO wilaya (nom)
VALUES
	('Alger'),
    ('Annaba'),
    ('Constantine')

INSERT INTO ville (nom, wilaya_id)
VALUES
	('Cheraga', 1),
    ('Kouba', 1),
	('Ben Akenoun', 1),

    ('Annaba',2),
    ('Berrahal',2),
    ('sidi amar',2),

    ('Constantine',3),
    ('Didouche Mourad',3),
    ('Ibn Badis',3)


INSERT INTO description(surface, nombre_piece, id_bien)
VALUES
	(80,3,1), /* Annaba, Annaba*/
    (300, 7,2), /* sidi amar, Annaba*/
    (120, 5,3) /* Cheraga, Alger*/

INSERT INTO images(src, description_image, id_description)
VALUES
	("../img/bien_1/1.webp","salon",1),
    ("../img/bien_1/2.webp","chambre",1), 
	("../img/bien_1/3.webp","cuisine",1), 

	("../img/bien_2/1.jpg","salon",2), 
    ("../img/bien_2/2.jpg","salle à manger",2),
	("../img/bien_2/3.jpg","cuisine",2),
    
    ("../img/bien_3/1.jpg","salon",3), 
    ("../img/bien_3/2.jpg","salon",3),
	("../img/bien_3/3.jpg","salle à manger",3)


INSERT INTO equipements( id_type, id_description)
VALUES
	(1,1),
    (2,1),
    (4,1),
    (6,1),
    (8,1),
    (1,2),
    (2,2),
    (3,2),
    (5,2),
    (6,2),
    (7,2),
    (9,2),
    (1,3),
    (3,3),
    (5,3),
    (6,3),
    (7,3),
    (8,3),
    (9,3)

INSERT INTO adresse(numero_maison, etage, quartier, wilaya_id, ville_id, id_description)
VALUES
	(23, 6, "Ibn badis", 2, 4,1),
    (3, NULL, "Radi hmida", 2, 6,2),
    (57, 2, "Zouaoua", 1, 1,3)


INSERT INTO lieu_interet(type_lieu)
VALUES
	("commerce"),
    ("grande surface"),
    ("station de bus"),
    ("gare"),
    ("port"),
    ("aéroport"),
    ("salles de sport"),
    ("plage"),
    ("salle de sport"),
    ("piscine")

INSERT INTO fiche_proximite(distance, id_description, id_type)
VALUES
	(0.5, 1, 1),
    (2, 1, 2),
    (3, 1, 5),
    (30, 1, 6),
    (1, 1, 8),
    
    (0.2, 2, 1),
    (1.2, 2, 3),
    (3, 2, 5),
    (54, 2, 6),
    (2.5, 2, 7),
    (25, 2, 8),

    (1.2, 3, 1),
    (4, 3, 2),
    (7, 3, 3),
    (9, 3, 4),
    (54, 3, 6),
    (13, 2, 9)


INSERT INTO reservation (date_debut, date_fin, lointaine, id_locataire, id_bien)
VALUES 
	("2022-01-01", "2022-07-01", 0, 1, 1),
    ("2022-02-01", "2022-02-03", 0, 2, 3),
    ("2022-02-03", "2022-02-10", 0, 3, 2),
    ("2022-06-07", "2022-08-30", 1, 3, 2),
    ("2022-12-15", "2022-12-29", 1, 3, 2),
    ("2022-02-15", "2022-03-01", 0, 2, 3),
    ("2022-08-01", "2022-09-01", 1, 4, 1),
    ("2022-02-15", "2022-03-01", 0, 5, 2),
    ("2022-01-15", "2022-01-20", 0, 5, 3)

INSERT INTO saison (debut_saison, fin_saison, tarif_saison)
VALUES
	("2022-01-01", "2022-05-31",-0.25),
    ("2022-06-01", "2022-06-30", 0),
    ("2022-07-01", "2022-08-31",0.25),
    ("2022-09-01", "2022-11-30",-0.25),
    ("2022-12-01", "2022-12-30",0.25)

INSERT INTO prix_reel (frais_agence, id_bien, id_reservation, id_saison)
VALUES
	(0.1 ,1, 1 ,1),
    (0.1 ,3, 2 ,1),
    (0.1 ,2, 3 ,1),
    (0.1 ,2, 4 ,3),
    (0.1 ,2, 5 ,5),
    (0.1 ,3, 6 ,1),
    (0.1 ,1, 7 ,3),
    (0.1 ,2, 8 ,1),
    (0.1 ,3, 9 ,1)


INSERT INTO payement_complet(encaisse, montant, id_prix, id_employe)
VALUES
  (0, 223987.5 ,1,1),
  (1, 5610 ,2,1),
  (1, 4760,3,1),
  (0, 92400,4,1),
  (1, 15400,5,1),
  (0, 14275,6,1),
  (0, 45375,7,1),
  (0, 9900,8,1),
  (1, 9075,9,1)

INSERT INTO versement_location(verse, montant,id_paiment,id_proprietaire, id_employe)
VALUES
	(1, 5049 ,2,3,1),
    (1, 4248 ,3,2,1),
    (1, 13860 ,5,2,1),
    (1, 8167.5 ,9,3,1)



INSERT INTO contrat(realise_le, signe, id_employe, id_réservation,id_bien)
VALUES
	("2021-12-25", 1 , 1, 1,1),
    ("2021-11-10", 1 , 1, 2,3),
    ("2021-12-27", 1 , 1, 3,2),
    ("2021-12-12", 1 , 1, 4,2),
    ("2021-11-10", 1 , 1, 5,2),
    ("2021-12-15", 1 , 1, 6,3),
    ("2021-10-05", 1 , 1, 7,1),
    ("2021-12-07", 1 , 1, 8,2),
    ("2021-11-28", 1 , 1, 9,3)


INSERT INTO visite(date_visite, id_locataire, id_employe, id_bien)
VALUES
	("2021-11-01",1,  1  ,1),
	("2021-12-11",3,  1  ,2),
    ("2021-11-06",4,  1  ,1),
	("2021-11-18",5,  1  ,2),
	("2021-12-08",6,  1  ,1)




INSERT INTO bon_visite(fin_validite, id_visite)
VALUES
	("2021-12-01",1),
	("2021-01-11",2),
    ("2021-12-06",1),
	("2021-01-18",2),
	("2021-01-08",1)


INSERT INTO detail_deplacement (date_deplacement, id_employe)
VALUES
	("2021-06-18", 1),
    ("2020-01-30", 1),
    ("2021-08-17", 1)


INSERT INTO reception (date_reception, commentaire_assistant, id_locataire, id_proprietaire, id_employe)
VALUES
	("2021-11-01", "La réception c'est bien passé, le client a fait une réservation", 1 , NULL, 3),
    ("2021-10-18", "Le client a demandé une deuxième réception", 2 , NULL, 3),
    ("2021-10-7", NULL, 2 , NULL, 3),
    ("2021-09-14", "La réception c'est bien passé", 3 , NULL, 3),
    ("2021-08-07", NULL, 4 , NULL, 3),
    ("2021-10-15", "Le client n'a pas trouvé d'option lui convenant", 6 , NULL, 3),
    ("2021-07-02", "Le propriétaire nous a confié son logement", NULL , 1, 3),
    ("2021-06-08", "Le contrat n'a pas encore pu être signé.", NULL , 2, 3),
    ("2021-02-26", "Le propriétaire nous a confié son logement", NULL , 3, 3)
    