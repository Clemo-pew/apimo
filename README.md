# ApimoWP
Plugin wordpress, listing et détail produit directement connecté a notre API

guide d'instalation : https://docs.google.com/document/d/12UlXOGv8eQSX0roWzwv7dgqc7VIWvN3r/edit?usp=sharing&ouid=106872380869006948937&rtpof=true&sd=true

# Publier sur le store WP

exemple avec le fichier apimo_ajax

- svn co https://plugins.svn.wordpress.org/apimo
- cp ../includes/apimo_ajax.php apimo/trunk/includes/apimo_ajax.php
- svn update trunk/includes/apimo_ajax.php
- svn status
- svn commit -m 'patch api connector: multiple agencies on the same provider' trunk/includes/apimo_ajax.php
- svn cp trunk tags/2.2.1
- svn ci -m "tagging version 2.2.1"
