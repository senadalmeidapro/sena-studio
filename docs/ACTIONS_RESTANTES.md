# Actions restantes pour Sena Studio

Ce document rassemble les informations et décisions qu’il reste à fournir ou à valider avant de considérer le site et ses outils comme prêts pour une publication complète. Les contenus personnels, commerciaux et juridiques ne doivent pas être devinés.

## 1. Valider les contenus du portfolio et du CV

Source principale : `database/seeders/PortfolioSeeder.php`.

- [ ] Relire le catalogue des compétences et leurs descriptions. Garder uniquement les compétences qui correspondent à ton expérience réelle.
- [ ] Confirmer si Tailwind UI fait partie de tes compétences ou des services que tu proposes ; sinon, retirer cette entrée.
- [ ] Vérifier les descriptions, technologies et contributions associées à chaque projet.
- [ ] Remplacer les visuels SVG d’exemple par des images réelles que tu as le droit de publier, ou supprimer les galeries concernées.
- [ ] Valider les études de cas « Mini Shop », « Express.js Onboarding API » et « Portfolio Sena Studio » : préciser ton rôle, le contexte, les choix réalisés et les résultats vérifiables, ou retirer les exemples.
- [ ] Remplacer les articles de blog d’exemple par tes propres textes approuvés, ou les supprimer.
- [ ] Relire le CV : résumé, expériences, rôles, dates, contributions, projets, formations et établissements.
- [ ] Vérifier les compétences et les langues du CV, notamment les niveaux indiqués.
- [ ] Ajouter uniquement des centres d’intérêt que tu souhaites afficher, ou supprimer cette rubrique.

## 2. Confirmer les informations commerciales

Sources : `lang/fr.json`, `lang/en.json` et les réglages de disponibilité dans l’administration.

- [ ] Confirmer ou corriger la durée annoncée de 3 à 6 semaines pour une mission (`services.offer_duration`).
- [ ] Décider si la page Process doit afficher un tarif ou une fourchette pour les missions au périmètre fixe (`process.fixed_scope.text`). Si tu ne veux pas afficher de prix, faire reformuler ce passage.
- [ ] Définir une durée réaliste pour les étapes du processus ou supprimer toute promesse de délai (`process.timeline.text`).
- [ ] Fournir les conditions de paiement à afficher sur le site (`process.payment.text`).
- [ ] Vérifier la disponibilité affichée sur les pages Home et Contact. Ajouter un lien de réservation uniquement si tu utilises réellement ce service.

## 3. Faire valider les informations de confidentialité et les mentions légales

Sources : `lang/fr.json` et `lang/en.json`, section `data_handling`, ainsi que les pages légales publiques.

- [ ] Confirmer quelles données le site collecte auprès des clients et pourquoi (`data_handling.client_data.text`).
- [ ] Définir les durées de conservation et la procédure de suppression (`data_handling.retention.text`).
- [ ] Établir la liste exacte des fournisseurs qui traitent des données, avec leur rôle et leur lieu de traitement (`data_handling.subprocessors.text`).
- [ ] Confirmer le contact à utiliser pour les demandes relatives aux données et les règles applicables à ton activité depuis le Bénin (`data_handling.gdpr_contact.text`).
- [ ] Vérifier que la localisation indiquée — Cotonou, Bénin — est toujours exacte et que les textes ne présentent pas l’activité comme établie en Europe.
- [ ] Faire relire les mentions légales et toute promesse de conformité, de certification ou d’obligation contractuelle par une personne compétente.

## 4. Renseigner la facturation avant d’émettre des documents

Configurer les valeurs dans l’environnement sécurisé du déploiement. Ne pas inscrire de secrets ou de coordonnées bancaires privées dans ce dépôt ni dans ce document.

- [ ] Définir le nom légal ou professionnel à afficher (`BILLING_LEGAL_NAME`).
- [ ] Définir l’adresse de facturation à afficher (`BILLING_ADDRESS`).
- [ ] Confirmer avec ton comptable l’identifiant fiscal applicable, puis le renseigner (`BILLING_TAX_ID`) ou confirmer qu’il ne doit pas apparaître.
- [ ] Ajouter uniquement les coordonnées bancaires destinées à être imprimées (`BILLING_BANK_DETAILS`).
- [ ] Définir les instructions de paiement destinées aux clients (`BILLING_PAYMENT_DETAILS`).
- [ ] Choisir la durée de validité des devis (`BILLING_QUOTE_VALIDITY_DAYS`).
- [ ] Définir les conditions de paiement à afficher sur les devis PDF (`BILLING_PAYMENT_TERMS`).
- [ ] Saisir le montant convenu sur chaque engagement avant de générer son devis.
- [ ] Saisir les dates d’émission et d’échéance de chaque facture avant de générer son PDF. En production, la génération est bloquée si ces informations manquent.
- [ ] Générer un devis et une facture de contrôle, puis vérifier les coordonnées, montants, dates, conditions et instructions de paiement.

## 5. Décider de la configuration des e-mails de rappel

- [ ] Si tu souhaites envoyer des rappels par e-mail, configurer un fournisseur mail opérationnel et une adresse `MAIL_FROM_ADDRESS` dans l’environnement de déploiement, puis vérifier la réception des messages.
- [ ] Choisir si le délai par défaut de trois jours avant rappel d’un lead te convient. Le réglage facultatif est `LEAD_NO_REPLY_DAYS`.
- [ ] Si tu ne souhaites pas envoyer ces e-mails, laisser le mailer `log` réservé au développement et ne pas considérer les rappels comme opérationnels en production.

## 6. Terminer les vérifications de déploiement

- [ ] Appliquer les migrations sur un environnement de staging PostgreSQL et vérifier le fonctionnement de l’application.
- [ ] Après validation du staging, planifier l’application des migrations en production avec `php artisan migrate --force`. Ne pas utiliser `migrate:fresh` en production.
- [ ] Configurer le cron pour lancer le scheduler Laravel chaque minute afin que les tâches planifiées, dont les rappels, puissent s’exécuter.
- [ ] Examiner les alertes Dependabot du dépôt et appliquer les mises à jour adaptées avant la publication.

## Déjà traité côté technique

- [x] Le seeder de contenu portfolio d’exemple est ignoré par `DatabaseSeeder` en production ; son appel direct y est bloqué.
- [x] En production, la création d’un PDF de devis ou de facture est refusée si son montant ou ses dates requises ne sont pas renseignés.
