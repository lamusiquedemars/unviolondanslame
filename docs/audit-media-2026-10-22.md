# Audit prioritaire Media — Un Violon dans l’Âme

**Date : 22 octobre 2026. Portée : lecture seule locale.**

## Conclusion actuelle

La capacité Media locale est saine et utilise déjà les packages partagés
Maracuja Site Core Media et Gallery. L'incident historique d'ajout de photos
ne peut pas être attribué au code local à partir des preuves disponibles :
aucune erreur d'upload image n'est présente dans le journal local.

Il serait donc incorrect de conclure que la médiathèque est uniforme en
production, ou au contraire que le Core est fautif, sans relever l'état du
serveur où l'échec est survenu.

## Preuves locales relevées

| Contrôle | Résultat |
| --- | --- |
| Package Media/Gallery | adoption présente (`0e8b08f`) |
| `php artisan maracuja:doctor` | sain ; Imagick et WebP disponibles |
| `php artisan maracuja:media:audit` | 0 anomalie, stockage conforme |
| `upload_max_filesize` | 128M |
| `post_max_size` | 128M |
| `memory_limit` | 128M |
| Journal Laravel local | aucune erreur d'upload image |
| Avertissements trouvés | `ffmpeg` absent pour les miniatures vidéo ; sans lien avec les photos |

Les cinq originaux privés actuellement présents sont des doublons de contenu.
Ce constat est informatif et ne justifie aucune suppression automatique.

## Cause possible à vérifier en production

Les causes encore ouvertes sont, par ordre de vérification :

1. limites PHP du pool/webserver réellement utilisé (`upload_max_filesize`,
   `post_max_size`, `memory_limit`, timeout) ;
2. droits d'écriture ou quota sur `storage/app/private/media/originals`,
   `public/storage/media/images` et le dossier temporaire Livewire ;
3. extension Imagick/GD et encodage WebP disponibles pour le PHP web, qui peut
   différer du PHP CLI ;
4. erreur HTTP Livewire/reverse proxy (413, 422, 500) et journal webserver ;
5. configuration de cache ou de disque différente de celle relevée en local ;
6. fichier source réellement soumis : poids, pixels, HEIC/HEIF ou fichier
   endommagé.

## Procédure de preuve sur le serveur concerné

Avant toute correction : conserver l'heure précise, l'utilisateur, le fichier
de test et le message visible. Rejouer ensuite un JPEG WebP-compatible de
moins de 2 Mo puis le fichier qui échoue.

- relever le statut HTTP de la requête Livewire ;
- relever les lignes Laravel et webserver correspondantes ;
- relever les limites PHP **web**, pas uniquement CLI ;
- vérifier les droits, l'espace disque et le quota des trois répertoires ;
- exécuter `php artisan maracuja:doctor --production` ;
- vérifier qu'un original privé et ses variantes publiques sont créés ou que
  la transaction les annule proprement.

## Décision d'architecture

Le site cible reste : Media et Gallery Site Core, stockage filesystem local
pour les images publiques ordinaires, originaux privés locaux. Scaleway ne
sera envisagé ici que pour un besoin justifié de documents métier privés, pas
comme remède automatique à un upload photo.

## Critère de clôture

L'incident est clôturé uniquement lorsqu'une reproduction production est
documentée, corrigée, puis validée par un import JPEG/PNG/WebP et, si proposé,
HEIC/HEIF. Le diagnostic doit alors indiquer si la cause était code,
configuration, infrastructure ou fichier source.
