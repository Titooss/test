A la racine du dossier lancer la commande : 

docker-compose up -d

Entrez dans le répertoire api, et effectuer la commande suivante afin de créer un jeu de test de categories et d'articles:

bin/console doctrine:fixtures:load

