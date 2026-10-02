# Suivi des TODO du dépôt

Ce document regroupe les TODO trouvés dans le code et les vérifications nécessaires avant publication. Les détails personnels, commerciaux et juridiques doivent être confirmés par Sena Studio : ne pas les inventer. Les TODO de traduction présents en français et en anglais sont suivis ensemble, car ils demandent la même décision.

## Inventaire du code

### Portfolio, CV et contenus d’exemple

- [ ] **Catalogue de compétences** — Remplacer ou valider les compétences et leurs descriptions à partir de l’expérience réelle. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 36).
- [ ] **Tailwind UI** — Confirmer que Tailwind UI est une compétence ou un service réellement proposé ; sinon, retirer cette entrée de démonstration. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 76).
- [ ] **Descriptions et technologies des projets** — Vérifier chaque résumé de projet et chaque affirmation de stack par rapport aux réalisations réelles. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 105).
- [ ] **Galeries de projets** — Remplacer les SVG générés pour la galerie par des médias réels dont Sena Studio détient les droits et approuve la publication. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 182).
- [ ] **Étude de cas Mini Shop** — Remplacer l’exemple par un récit vérifié (rôle, contexte, choix et résultat), ou supprimer ce projet exemple. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 219).
- [ ] **Étude de cas Express.js Onboarding API** — Remplacer l’exemple par des détails vérifiés, ou supprimer ce projet exemple. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 228).
- [ ] **Étude de cas Portfolio Sena Studio** — Remplacer l’exemple par des détails vérifiés, ou supprimer ce projet exemple. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 237).
- [ ] **Articles du blog** — Remplacer les articles de démonstration par des textes écrits et approuvés par Sena Studio, ou supprimer les articles non publiables. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 335).
- [ ] **Résumé du profil CV** — Ajouter le résumé personnel approuvé et exact ; ne pas publier le texte exemple. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 422).
- [ ] **Expérience professionnelle** — Vérifier employeurs, missions, rôles et dates ; retirer les entrées qui ne sont pas confirmées. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 429).
- [ ] **Contributions et projets du CV** — Vérifier que chaque contribution et chaque affirmation de projet correspondent au travail réellement effectué. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 439).
- [ ] **Formation** — Vérifier les diplômes, établissements et dates ; retirer les éléments non confirmés. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 470).
- [ ] **Compétences du CV** — Garder uniquement les compétences que Sena Studio confirme maîtriser ; les niveaux autoévalués ont volontairement été omis. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 487).
- [ ] **Langues du CV** — Vérifier les langues et les niveaux CECR avant publication. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 508).
- [ ] **Centres d’intérêt** — Ajouter uniquement les centres d’intérêt approuvés, ou supprimer cette section si elle n’est pas souhaitée. Emplacement : `database/seeders/PortfolioSeeder.php` (autour de la ligne 515).
- [ ] **Seeding en production** — Ne pas exécuter le seeder de portfolio en production tant que les exemples n’ont pas été remplacés ou explicitement approuvés.

### Informations commerciales affichées sur le site

- [ ] **Durée de l’offre** — Confirmer que l’estimation de 3 à 6 semaines est représentative, puis conserver ou corriger le texte dans les deux langues. Emplacements : `lang/fr.json` et `lang/en.json`, clé `services.offer_duration`.
- [ ] **Tarif des missions au périmètre fixe** — Ajouter le tarif ou la fourchette validée, ou reformuler la page Process si aucun prix ne doit être affiché. Emplacements : `lang/fr.json` et `lang/en.json`, clé `process.fixed_scope.text`.
- [ ] **Durée habituelle du processus** — Définir une estimation réelle après cadrage et l’ajouter au texte du processus, ou retirer la promesse de durée. Emplacements : `lang/fr.json` et `lang/en.json`, clé `process.timeline.text`.
- [ ] **Conditions de paiement** — Ajouter les conditions commerciales approuvées dans les deux langues. Emplacements : `lang/fr.json` et `lang/en.json`, clé `process.payment.text`.
- [ ] **Disponibilité et réservation** — Dans l’administration, confirmer la disponibilité montrée sur Home et Contact ; ajouter un lien de réservation uniquement s’il existe un service réellement utilisé.

### Confidentialité et mentions juridiques

- [ ] **Catégories et finalités des données** — Faire relire le texte en français et en anglais, confirmer les données effectivement collectées et expliquer leur usage. Emplacements : `lang/fr.json` et `lang/en.json`, clé `data_handling.client_data.text`.
- [ ] **Conservation et suppression** — Faire définir les délais de conservation et le processus de suppression applicables, puis reporter les règles validées dans les deux langues. Emplacements : `lang/fr.json` et `lang/en.json`, clé `data_handling.retention.text`.
- [ ] **Sous-traitants** — Dresser la liste réelle des fournisseurs qui traitent des données, avec leur finalité et leur lieu de traitement ; faire vérifier sa publication. Emplacements : `lang/fr.json` et `lang/en.json`, clé `data_handling.subprocessors.text`.
- [ ] **Contact vie privée et règles applicables** — Faire confirmer les règles pertinentes pour l’activité exercée depuis le Bénin, le contact responsable et la façon de traiter les demandes, puis mettre à jour les deux langues. Emplacements : `lang/fr.json` et `lang/en.json`, clé `data_handling.gdpr_contact.text`.
- [ ] **Localisation professionnelle** — Vérifier que la localisation affichée reste exacte (Cotonou, Bénin) et faire confirmer les obligations juridiques selon l’activité, les projets et les personnes concernées. Ne pas présenter l’activité comme basée en Europe.
- [ ] **Promesses juridiques** — Faire valider toute garantie de conformité, certification ou obligation contractuelle avant publication.

### Configuration des PDF et des e-mails

- [ ] **Nom légal de l’émetteur** — Renseigner `BILLING_LEGAL_NAME` avec le nom légal ou professionnel à afficher sur les PDF de devis et factures. Configurer la valeur dans l’environnement de déploiement, pas dans un fichier de secrets commité. Emplacements : `.env.example`, `app/Support/BillingIssuer.php`.
- [ ] **Adresse de l’émetteur** — Renseigner `BILLING_ADDRESS` avec l’adresse destinée aux documents de facturation. Ne pas y mettre de secrets de paiement. Emplacements : `.env.example`, `app/Support/BillingIssuer.php`.
- [ ] **Identifiant fiscal** — Confirmer auprès du comptable quel identifiant s’applique, puis configurer `BILLING_TAX_ID` ou confirmer qu’aucun identifiant ne doit apparaître. Emplacements : `.env.example`, `app/Support/BillingIssuer.php`.
- [ ] **Coordonnées bancaires imprimables** — Renseigner `BILLING_BANK_DETAILS` uniquement avec des coordonnées destinées à être imprimées sur les documents. Emplacements : `.env.example`, `app/Support/BillingIssuer.php`.
- [ ] **Instructions de paiement** — Renseigner `BILLING_PAYMENT_DETAILS` avec les instructions approuvées et destinées aux clients. Emplacements : `.env.example`, `app/Support/BillingIssuer.php`.
- [ ] **Validité des devis** — Choisir le nombre de jours approuvé et renseigner `BILLING_QUOTE_VALIDITY_DAYS`. La valeur de secours du PDF local est déclarée dans `app/Http/Controllers/Admin/BillingPdfController.php`.
- [ ] **Conditions de paiement des devis PDF** — Renseigner `BILLING_PAYMENT_TERMS` avec les conditions validées. La valeur de secours locale est dans `app/Http/Controllers/Admin/BillingPdfController.php`.
- [ ] **Montant du devis** — Saisir le montant convenu sur l’engagement avant de générer le PDF ; vérifier que le devis ne contient pas le marqueur « set quote amount ». Emplacement : `resources/views/pdf/billing/quote.blade.php`.
- [ ] **Dates de facture** — Saisir les dates d’émission et d’échéance de chaque facture avant génération, afin que les PDF ne contiennent pas les marqueurs de date manquante. Emplacement : `resources/views/pdf/billing/invoice.blade.php`.
- [ ] **E-mails de rappel des leads** — Si les rappels par e-mail sont souhaités, configurer un vrai fournisseur mail et une adresse `MAIL_FROM_ADDRESS` dans l’environnement de déploiement, puis vérifier la livraison. Sinon, le mailer `log` de l’exemple ne sert qu’au développement. Emplacement : `.env.example`.
- [ ] **Seuil de rappel des leads** — Décider si la valeur par défaut de 3 jours convient ; `LEAD_NO_REPLY_DAYS` est facultatif.
- [ ] **PDF avant publication** — Générer et contrôler un devis et une facture avec les vraies coordonnées, le montant, les dates, les conditions et les instructions de paiement.

## Vérifications de lancement hors marqueurs TODO

- [ ] **Migrations de staging** — Tester les migrations sur PostgreSQL de staging. Les migrations déjà vérifiées l’ont été sur SQLite ; aucune base de production n’a été touchée.
- [ ] **Migrations de production** — Après validation en staging, appliquer avec `php artisan migrate --force`. Ne pas exécuter `migrate:fresh` sur la base de production.
- [ ] **Planification Laravel** — Configurer le cron pour exécuter le scheduler Laravel chaque minute, comme indiqué dans le README, afin de déclencher les rappels quotidiens.
- [ ] **Alertes Dependabot** — Examiner les alertes actuelles et appliquer les mises à jour adaptées avant publication.
