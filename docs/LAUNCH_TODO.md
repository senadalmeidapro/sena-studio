# Checklist avant publication

Cette liste recense les décisions et informations que Sena Studio ne peut pas inventer. Les mêmes points sont marqués TODO: FIX ME près des textes, données ou paramètres concernés.

## Contenu personnel et portfolio

- [ ] Relire database/seeders/PortfolioSeeder.php et remplacer ou supprimer les exemples de compétences, projets, études de cas, articles, images, profil, expérience, contributions, formation, langues et centres d’intérêt.
- [ ] Confirmer la durée de l’offre « 3 à 6 semaines » dans lang/fr.json et lang/en.json.
- [ ] Confirmer les noms de langues et les niveaux CECR du CV.
- [ ] Ne pas activer le seeding du portfolio en production tant que les exemples ne sont pas remplacés ou approuvés.

## Offre commerciale

- [ ] Ajouter la fourchette tarifaire approuvée aux traductions de la page Process.
- [ ] Confirmer la durée habituelle affichée sur Services et Process.
- [ ] Ajouter les conditions de paiement approuvées aux traductions FR et EN.
- [ ] Dans l’admin, confirmer la disponibilité affichée sur Home et Contact; ajouter un lien de réservation si tu en utilises un.

## Données et juridique

- [ ] Faire relire en français et en anglais les catégories de données traitées et leurs finalités.
- [ ] Faire confirmer les délais de conservation et le processus de suppression.
- [ ] Lister les sous-traitants réellement utilisés, leurs finalités et leurs lieux de traitement.
- [ ] Confirmer le contact responsable des demandes relatives aux données et le texte juridique associé.
- [ ] Ne publier aucune garantie de conformité, certification ou engagement contractuel sans validation juridique.

## Paramètres de facturation et de messagerie

- [ ] Renseigner les variables BILLING_* dans l’environnement de production; les champs requis sont listés dans .env.example.
- [ ] Vérifier un PDF de devis et un PDF de facture avec les vraies coordonnées, dates, montants et instructions de paiement.
- [ ] Configurer un fournisseur mail et MAIL_FROM_ADDRESS seulement si les rappels de leads doivent aussi être envoyés par email.
- [ ] Le seuil des leads sans réponse est facultatif (LEAD_NO_REPLY_DAYS, valeur par défaut : 3 jours).

## Déploiement et sécurité

- [ ] Tester les migrations sur un PostgreSQL de staging. Les migrations ont été exécutées ici sur SQLite; aucune base de production n’a été touchée.
- [ ] Après validation en staging, appliquer les migrations en production avec php artisan migrate --force; ne pas lancer migrate:fresh sur la base de production.
- [ ] Configurer le cron Laravel chaque minute comme indiqué dans le README pour déclencher les rappels quotidiens.
- [ ] Examiner les alertes Dependabot actuelles et appliquer les mises à jour adaptées avant publication.
