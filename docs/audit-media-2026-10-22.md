# Archive — audit Media d’Un Violon dans l’Âme

**Date : 22 octobre 2026. Portée : lecture seule locale.**

> **État de livraison : local uniquement.** Aucune production, domaine public,
> cible SSH ou validation d'hébergement n'existe pour ce site à cette date.

> **Statut : clos.** Le problème historique d’ajout de photos a été résolu,
> confirmé par le responsable du site. La cause technique de l'incident initial
> n'a pas été conservée ; aucune investigation serveur complémentaire n'est
> requise sans nouveau symptôme.

## Conclusion actuelle

La capacité Media locale est saine et utilise déjà les packages partagés
Maracuja Site Core Media et Gallery. Cet audit ne permet pas d'attribuer la
cause historique au code local ; il conserve seulement les constats utiles à
la maintenance future.

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

## Référence si un nouvel incident survient après une future mise en hébergement

Si un nouvel échec se produit, vérifier par ordre :

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

## Procédure de preuve à utiliser uniquement si le problème réapparaît

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

## Clôture

L'incident historique est clos. Cette fiche est une archive de diagnostic et
ne constitue pas une tâche active.
