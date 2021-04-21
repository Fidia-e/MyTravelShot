# Dictionnaire de données

## Table des auteurs (`author`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant de l'auteur|
|username|VARCHAR(64)|NOT NULL|Le nom utilisateur de l'auteur|
|city|VARCHAR(64)|NULL|La ville de l'auteur|
|country|VARCHAR(128)|NULL|Le pays de l'auteur|
|user_id|INT|NOT NULL|L'utilisateur associé à l'auteur|
|created_at|DATETIME|DEFAULT CURRENT_TIMESTAMP|La date de création de l'auteur|
|updated_at|DATETIME|NULL|La date de la dernière mise à jour de l'auteur|

## Table des publications (`shot`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant de la publication utilisateur|
|title|VARCHAR(128)|NOT NULL|Le titre de la publication|
|picture|VARCHAR(255)|NOT NULL|La photo de la publication|
|description|TEXT|NULL|Description de la publication|
|publication_date|DATETIME|DEFAULT CURRENT_TIMESTAMP|Date de la publication par l'auteur|
|author_id|INT|NULL, UNSIGNED|L'auteur de la publication|
|created_at|DATETIME|DEFAULT CURRENT_TIMESTAMP|La date de création de la photo utilisateur|
|updated_at|DATETIME|NULL|La date de la dernière mise à jour de la photo utilisateur|

## Table des utilisateurs (`user`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant du type|
|firstname|VARCHAR(64)|NOT NULL|Le prénom de l'utilisateur|
|lastname|VARCHAR(64)|NOT NULL|Le nom de l'utilisateur|
|email|VARCHAR(128)|NOT NULL|L'email de l'utilisateur|
|password|VARCHAR(128)|NOT NULL|Le mot de passe de l'utilisateur|
|role|enum|'author', 'admin', 'superadmin'|Le rôle de l'utilisateur|
|author_id|INT|NOT NULL, UNSIGNED|L'auteur associé à|
|created_at|DATETIME|DEFAULT CURRENT_TIMESTAMP|La date de création du type|
|updated_at|DATETIME|NULL|La date de la dernière mise à jour du type|