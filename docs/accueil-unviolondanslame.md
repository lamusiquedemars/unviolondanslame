# Accueil Un violon dans l’âme — V2

## Périmètre

Développement local sous Herd PHP 8.4 : `http://unviolondanslame.test`.
Base DBngin : `unviolondanslame`. Aucun déploiement public pour cette étape.
La page d’accueil du thème `unviolondanslame` possède quatre sections et conserve
les textes du brief V2. Les autres pages et le dépôt Maracuja CMS Starter ne sont
pas développés dans cette étape.

La vue dédiée est `resources/views/site/themes/unviolondanslame/home.blade.php`.
Elle réutilise le layout, les sections, grilles et boutons du socle. Les emplacements
facultatifs `site-header` et `site-footer` ne remplacent le chrome du layout que
sur cette page. Les autres thèmes conservent leur accueil existant.

## Photos à intégrer

Aucune photographie authentique de David n’est présente dans le dépôt.
Cinq emplacements affichent explicitement « Photographie à venir » : hero,
services, instruments, atelier et travail à l’établi.

Renseigner les entrées de `config/unviolondanslame.php` avec des URL locales
publiques (`src`), un texte alternatif descriptif (`alt`) et, si disponibles,
des variantes `srcset` de 640, 960 et 1200 pixels. Fournir des WebP/AVIF optimisés,
avec un cadrage compatible avec les conteneurs. Le composant réserve l’espace,
charge le hero prioritairement et les autres images à la demande.

Les polices Parisienne, Alegreya et Work Sans sont téléchargées à la compilation
par le plugin Vite déjà installé et servies localement. Aucune requête vers Google
Fonts ou Bunny n’est nécessaire pendant la consultation du site.

## Parcours restant à développer

- `/services` et `/contact` sont les routes existantes du socle ; leur contenu
  et le formulaire restent ceux du starter, à adapter lors des prochaines étapes.
- Les pages Instruments et L’atelier n’existent pas encore. Le menu renvoie aux
  sections de l’accueil. La carte Atelier conduit au bloc présentant le travail.
  Les boutons dépendant des futures pages sont désactivés et accompagnés d’une
  indication d’attente ; le lien Contact pour demander un essai reste actif.
- « Envoyer des photos » conduit à Contact. Le formulaire ne gère pas encore de
  pièces jointes ; cette limite est indiquée à côté de l’action. En environnement
  local, l’envoi des emails utilise le journal Laravel (`MAIL_MAILER=log`).
- Conserver `MARACUJA_INDEXABLE=false` tant que le site reste en préparation.

## Vérification

`phpunit.xml` utilise exclusivement `unviolondanslame_testing` afin de ne pas
écrire dans les bases du Starter ou des autres projets. Le thème par défaut y
reste `default` pour les tests du socle ; `UnViolonHomeTest` active explicitement
le thème client.

```sh
herd composer test -- --filter='UnViolonHomeTest|PublicSiteTest'
npm run build
herd php artisan view:cache
herd php artisan optimize:clear
herd php artisan maracuja:doctor
```

Contrôler aussi dans le navigateur : les cinq entrées de navigation, le menu
mobile, les liens actifs, le H1 unique, les métadonnées, les trois polices chargées
localement et l’absence de débordement à 320, 390, 768, 1024 et 1440 pixels.
