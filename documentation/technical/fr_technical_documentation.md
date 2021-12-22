# Documentation technique du projet Looper

## But du site

Proposer une plateforme permettant de créer des questions, d'y répondre en tant que visiteurs et enfin, consulter les
différentes réponses. Il peut être destiné à des écoles dans le cas de quizz, il peut aussi être utilisé pour des
sondages etc... Le but étant simplement de pouvoir observer les réponses des utilisateurs.

## Dans quel contexte (technique)

Le fonctionnement du projet est garanti en local avec un serveur `PHP 8.0` et Serveur SQL `MariaDB 10.6.4`.

## Données manipulées par ce site

Document de conception de la base de donnée:

- [MLD](documentation/conception/db/MLD.PNG)
- [MCD](documentation/conception/db/MCD_CHEN.png)

Diagramme de classe des données (QueryBuilder, Model, DB)

- [UML](documentation/conception/uml/models.PNG)

## Composants et Architecture

Ce site utilise une architecture MVC (Modèle-Vue-Controlleur). Il s'agit d'une immitation de l'architecture Laravel.
Voici les principaux composants sont les suivants:

| Répertoire  | Composant | Description|
|---|---|---|
|`app/controllers`|Controller.php, *|Controller principal et enfants|
|`app/models`|Model.php, *|Modèle principal et enfants|
|`app/database/`|DB.php|Classe permettant la connexion à la base de donnée|
|`app/database/`|QueryBuilder.php|Assistant de création des requêtes utilisées sur ce site.|
|`routes/`|Route.php|Construit et extrait les informations d'une URL|
|`routes/`|Router.php|Exécute les routes définies dans `public/index.php`|

### Fichiers et répertoires

|  | Répertoire|Informations|
|---|---|---|
|Vues|`resources/views/`|Le layout principal se trouve à la racine de ce répertoire, il inclue les vues des autres répertoires.|
|DB Connexion|`config/db.php`|Les constantes définies ici sont utilisées par les tests unitaire et par le fichier `app/database/DB.php`|
|Liens et constantes|`config/.env.php`||
|Routes|`public/index.php`|Toutes les routes sont définies à cette endroit|
|Scripts (JS)|`public/js/main.js`|Les boutons avec des événénements sont gérés dans ce fichier|

## Interraction entre les composants

1) `public/index.php` est la première page chargée. C'est elle qui va inclure les routes et routeur et qui va exécuter
   le traitement d'une URL.
2) La requête envoyé au serveur est interprétée de sorte à récupérer le controlleur approprié (par Route et Router).
3) Depuis le controlleur, les données (s'il y en a) sont récupérées depuis les modèles. Le controlleur appelle le layout
   et la vue de la page dans son sous-répertoire.

Si une URL n'existe pas, le Router va rediriger vers une page d'erreur 404. Si la connexion à la base de donnée est
interrompue ou a échoué, index va rediriger sur une erreur 500.

## Navigation et routes

Plus de détails sur les routes actuelle [détails](documentation/technical/projectRoutes.md)

Présentement et de manière générale, les URLs sont construits en respectant la logique suivante:
`controlleur/action/variable`

## Prérequis pour reprendre ce projet

PHP 8.0, MySQL, Composer, NPM, connaître le pattern MVC et le fonctionnement du routeur.

## Ce qu'il faut installer:

Composer, NPM, cmder, PHP 8, et d'un éditeur de code (Par exemple Visual Studio Code ou PHPStorm)

## Astuces employées

### Astuce #1: Tableau de post

Dans la page de réponses aux questions d'un exercice, nous utilisons pour nom de balise input un tableau ayant la forme
suivante: `fulfillment[answers_attributes][][field_id]`.

```html
<textarea name="fulfillment[answers_attributes][][value]"></textarea>
```

Leur traitement est fait dans les méthodes de AnswerController update() et new(). Cela a requis 2 itérations pour
pouvoir enregistrer les différentes réponses.

### Astuce #2: Id envoyé en post

Parfois l'id de l'entité modifié/supprimé en cours est envoyé par un input caché. C'est le cas de la page edit de answer

```HTML
<input type="hidden" value="<?= $answer->getQuestion()->getId(); ?>""
name="fulfillment[answers_attributes][][questionId]" />
```

### Astuce #3: Modification de status par du JS

Lors des changements de statuts (notamment dans les page de création de question et de manage), un script JS va
effectuer la demande de modification au serveur. Le script va récupérer toutes les balises `<a></a>`contenant une
data-method définie et ajoute un événement clic pour demander une confirmation.

```javascript
  document.querySelectorAll('a[data-method="delete"]').forEach(item => {
    item.addEventListener("click", function () {
        if
        (!confirm(item.dataset.confirm)) return false;
   ```
