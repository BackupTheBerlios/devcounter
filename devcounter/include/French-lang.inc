<?php

######################################################################
# SourceWell: Software Announcement & Retrieval System
# ================================================
#
# Copyright (c) 2001 by
#                Lutz Henckel (lutz.henckel@fokus.gmd.de) and
#                Gregorio Robles (grex@scouts-es.org)
#
# BerliOS SourceWell: http://sourcewell.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# File with the main French translation
# translated by Frédéric BOITEUX <fredericB@caramail.com>
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
######################################################################

switch($phrase) {

// Top strip
     case "Home": $tmp = "Accueil"; break;
     case "About us": $tmp = "A propos"; break;
     case "Partners": $tmp = "Partenaires"; break;
     case "Contact": $tmp = "Contact"; break;

     case "Logged in": $tmp = "Connecté"; break;
     case "Expires": $tmp = "Expiré"; break;
     case "Not Logged in": $tmp = "Non connecté"; break;

// Top title
     case "Open Source Software Announcement &amp; Retrieval":  $tmp = "Annonce et recherche de logiciels open source"; break;

// Menue bar
     case "Recent Apps": $tmp = "Applications récentes"; break;
     case "Q&amp;A": $tmp = "Q&amp;R"; break;
     case "Login": $tmp = "Connexion"; break;
     case "Logout": $tmp = "Déconnexion"; break;
     case "New User": $tmp = "Nouvel utilisateur"; break;
     case "Forgot Password": $tmp = "Mot de passe perdu"; break;
     case "Change User": $tmp = "Changer d'utilisateur"; break;
     case "Users": $tmp = "Utilisateurs"; break;

     case "Apps Index": $tmp = "Liste des applications"; break;
     case "New Apps": $tmp = "Nouvelles applications"; break;
     case "Update Apps": $tmp = "Applications mises à jour"; break;
     case "Pending Apps": $tmp = "Applications en attente";break;
     case "Deleted Apps": $tmp = "Applications supprimées";break;
     case "Modified Apps": $tmp = "Applications modifiées";break;

     case "Backend": $tmp = "Backend"; break;
     case "Statistics": $tmp = "Statistiques"; break;

     case "Administration": $tmp = "Administration"; break;
     case "Sections": $tmp = "Sections"; break;
     case "Categories": $tmp = "Catégories"; break;
     case "Authors": $tmp = "Auteurs"; break;
     case "Licenses": $tmp = "Licences"; break;
     case "Check Date": $tmp = "Date de vérification"; break;

     case "Search": $tmp = "Chercher"; break;
     case "Language": $tmp = "Langue"; break;
     case "Go": $tmp = "Lancer"; break;

// Languages
	 case "English": $tmp = "Anglais"; break;
	 case "German": $tmp = "Allemand"; break;
	 case "Spanish": $tmp = "Espagnol"; break;
	 case "French": $tmp = "Fran&ccedil;ais"; break;

// sorted by
	 case "sorted by": $tmp = "Trié par"; break;
	 case "Date": $tmp = "Date"; break;
	 case "Importance": $tmp = "Importance"; break;
	 case "Urgency": $tmp = "Urgence"; break;
	 case "Name": $tmp = "Nom"; break;

// FAQ
     case "Frequently Asked Questions": $tmp = "Foire Aux Questions"; break;
     case "Question": $tmp = "Question"; break;
     case "Answer": $tmp = "Réponse"; break;

// Apps update
     case "Comment": $tmp = "Commenter"; break;
     case "Review": $tmp = "Examiner"; break;
     case "Update": $tmp = "Mettre à jour"; break;
     case "Delete": $tmp = "Supprimer"; break;
     case "Undelete": $tmp = "Récupérer"; break;

// Apps not yet reviewed
     case "Waiting for Review by an Editor": $tmp = "En attente de révision par un éditeur"; break;

// Apps by identifier
     case "Application": $tmp = "Application"; break;
     case "Others by Author": $tmp = "Du même auteur"; break;
     case "has not yet been reviewed by a $GLOBALS[sys_name] Editor.<br> Please, be patient. It will be surely done in the next time.": $tmp = "n'a pas encore été examiné par un éditeur $GLOBALS[sys_name].<br> Soyez patient. Cela va surement être fait prochainement."; break;
     case "is modified": $tmp = "est modifiée"; break;
     case "is deleted": $tmp = "est supprimée"; break;

// User registration
     case "Register as a new User": $tmp = "S'inscrire"; break;
     case "Username": $tmp = "Nom d'utilisateur"; break;
     case "Password": $tmp = "Mot de passe"; break;
     case "Confirm Password": $tmp = "Confirmation mot de passe"; break;
     case "Realname": $tmp = "Nom"; break;
     case "Register": $tmp = "S'enregistrer"; break;
     case "User Registration": $tmp = "Inscription utilisateur"; break;
     case "Congratulations": $tmp = "Félicitations"; break;
     case "You have registered on $GLOBALS[sys_name]": $tmp = "Vous êtes enregistrés sur $GLOBALS[sys_name]"; break;
     case "Your new username is": $tmp = "Votre nouveau nom d'utilisateur"; break;
     case "You are now being sent a confirmation email to verify your email address": $tmp = "Un email de confirmation vous a été envoyé pour vérifier votre adresse email"; break;
     case "Visiting the link sent to you in this email will activate your account": $tmp = "Votre compte sera activé lorsque vous cliquerez le lien contenu dans cet email"; break;
     case "Thank you for registering on the $GLOBALS[sys_name] Site. In order": $tmp = "Merci de vous être enregistré sur le site $GLOBALS[sys_name]. Pour"; break;
     case "to complete your registration, visit the following URL": $tmp = "terminer votre inscription, cliquez sur le lien suivant"; break;
     case "Enjoy the site": $tmp = "Bonne utilisation"; break;
     case " -- the $GLOBALS[sys_name] crew": $tmp = " -- l'équipe de $GLOBALS[sys_name]"; break;
     case "Verification of Registration": $tmp = "Vérification de l'inscription"; break;
     case "Your account is now activated. Please login": $tmp = "Votre compte est maintenant activé. Connectez vous"; break;

// Forget password / Remind me
     case "Register as a new User": $tmp = "S'inscrire"; break;
     case "Remind me": $tmp = "Se souvenir de moi"; break;
     case "Your Username and Password for $GLOBALS[sys_name] is": $tmp = "Votre nom d'utilisateur et votre mot de passe pour $GLOBALS[sys_name] sont"; break;
     case "Please keep this e-mail for further reference": $tmp = "Gardez cet e-mail pour mémoire"; break;
     case "You will get your Password by e-mail in a couple of minutes": $tmp = "Vous allez recevoir votre mot de passe par e-mail dans quelques minutes"; break;

// Change User Parameters
     case "Change User Parameters": $tmp = "Changer les paramètres utilisateur"; break;
     case "Remind me": $tmp = "Se souvenir de moi"; break;
     case "Modification": $tmp = "Modification"; break;
     case "Creation": $tmp = "Création"; break;
     case "Permission": $tmp = "Permission"; break;
     case "Change": $tmp = "Changer"; break;
     case "Password and/or E-Mail Address of": $tmp = "Mot de passe et/ou adresse email de"; break;
     case "is changed": $tmp = "a été changé"; break;

// Apps by category
     case "Homepage": $tmp = "Page d'accueil"; break;
     case "Download": $tmp = "Télécharger"; break;
     case "Changelog": $tmp = "Log de modification"; break;
     case "Comments": $tmp = "Commentaires"; break;
     case "Type": $tmp = "Type"; break;
     case "Updated": $tmp = "Mis à jour"; break;
     case "Created": $tmp = "Créé"; break;
     case "Stable": $tmp = "Stable"; break;
     case "Development": $tmp = "Développement"; break;
     case "License": $tmp = "Licence"; break;

// New Apps
     case "New Application": $tmp = "Nouvelle application"; break;
     case "Application Name": $tmp = "Nom de l'application"; break;
     case "Insert": $tmp = "Insérer"; break;

// Insert Apps
     case "Insert Application": $tmp = "Insérer l'application"; break;
     case "Version": $tmp = "Version"; break;
     case "Section/Category": $tmp = "Section/Catégorie"; break;
     case "Red Hat Package": $tmp = "Distribution Red Hat"; break;
     case "Debian Package": $tmp = "Distribution Debian"; break;
     case "Slackware Package": $tmp = "Distribution Slackware"; break;
     case "CVS Tree": $tmp = "Arbre CVS"; break;
     case "Screenshots": $tmp = "Photos d'écran"; break;
     case "Mailing List Archive": $tmp = "Archive de la liste de diffusion"; break;
     case "Description": $tmp = "Description"; break;
     case "Author": $tmp = "Auteur"; break;
     case "Depends on": $tmp = "Dépend de"; break;
	 case "low": $tmp = "bas"; break;
	 case "medium": $tmp = "moyen"; break;
	 case "high": $tmp = "haut"; break;

// Update Apps
     case "Update Application": $tmp = "Mettre à jour l'application"; break;
     case "Application ID": $tmp = "ID d'application"; break;
     case "Announcements": $tmp = "Annonces"; break;
     case "active": $tmp = "active"; break;
     case "pending": $tmp = "en attente"; break;
     case "deleted": $tmp = "supprimée"; break;
     case "Check": $tmp = "Vérifier"; break;

// Comment
     case "Your Comment about": $tmp = "Votre commentaire sur"; break;
     case "Subject": $tmp = "Sujet"; break;
     case "Comment": $tmp = "Commenter"; break;
     case "Send": $tmp = "Envoyer"; break;

// Login
     case "$GLOBALS[sys_name] Login": $tmp = "Connexion $GLOBALS[sys_name]"; break;
     case "Welcome to $GLOBALS[sys_name]": $tmp = "Bienvenue sur $GLOBALS[sys_name]"; break;
     case "You are logged in as": $tmp = "Vous êtes connecté en tant que"; break;
     case "with": $tmp = "avec"; break;
     case "permission": $tmp = "permission"; break;
     case "Your authentication is valid until": $tmp = "Votre authentification est valide jusqu'à"; break;

// Logout
     case "You have been logged in as": $tmp = "Vous êtiez connecté comme"; break;
     case "Your authentication was valid until": $tmp = "Votre authentification était valide jusqu'à"; break;
     case "This is all over now. You have been logged out": $tmp = "C'est maintenant fini. Vous avez été déconnecté"; break;

// User admin
     case "Action": $tmp = "Action"; break;
     case "Delete": $tmp = "Supprimer"; break;
     case "Create User": $tmp = "Créer un utilisateur"; break;
     case "User Creation": $tmp = "Création d'un utilisateur"; break;
     case "created": $tmp = "créé"; break;
     case "User Change": $tmp = "Changement d'utilisateur"; break;
     case "User Deletion": $tmp = "Suppression d'utilisateur"; break;
     case "is deleted": $tmp = "est supprimé"; break;

// Section admin
     case "Section Administration": $tmp = "Administration de section"; break;
     case "Insert a Section": $tmp = "Insérer une section"; break;
     case "Rename a Section": $tmp = "Renommer une section"; break;
     case "Delete a Section": $tmp = "Supprimer une section"; break;
     case "New Section": $tmp = "Nouvelle section"; break;
     case "New Section Name": $tmp = "Nouveau nom de section"; break;
     case "Section": $tmp = "Section"; break;
     case "Rename": $tmp = "Renommer"; break;

// Category admin
     case "Category Administration": $tmp = "Administration de catégorie"; break;
     case "Insert a Category": $tmp = "Insérer une catégorie"; break;
     case "Rename a Category": $tmp = "Renommer une catégorie"; break;
     case "Delete a Category": $tmp = "Supprimer une catégorie"; break;
     case "New Category": $tmp = "Nouvelle catégorie"; break;
     case "New Category Name": $tmp = "Nouveau nom de catégorie"; break;
     case "Category": $tmp = "Catégorie"; break;

// License admin
     case "License Administration": $tmp = "Administration de licence"; break;
     case "Insert a License": $tmp = "Insérer une licence"; break;
     case "Rename a License": $tmp = "Renommer une licence"; break;
     case "Change a License URL": $tmp = "Changer l'URL d'une licence"; break;
     case "Delete a License": $tmp = "Supprimer une licence"; break;
     case "New License": $tmp = "Nouvelle licence"; break;
     case "License URL": $tmp = "URL de la licence"; break;
     case "New License Name": $tmp = "Nouveau nom de licence"; break;
     case "New License URL": $tmp = "Nouvelle URL de la licence"; break;
     case "License": $tmp = "Licence"; break;

// Announcements
    case "by": $tmp = "par"; break;
    case "on": $tmp = "sur"; break;
	case "hits": $tmp = "hits"; break;

// Time-based Navigation
    case "Day": $tmp = "Jour"; break;
    case "Today": $tmp = "Aujourd'hui"; break;
    case "Week": $tmp = "Semaine"; break;

// Search
    case "No Application found": $tmp = "Aucune application trouvée"; break;

// Apps by user
     case "Apps of User": $tmp = "Applications de l'utilisateur"; break;
     case "No Apps of User exist": $tmp = "Aucune application utilisateur"; break;

// Pending Apps
     case "No pending Apps exist": $tmp = "Aucune application en cours"; break;

// Deleted or modified apps
     case "Is deleted": $tmp = "Est supprimée"; break;
     case "Is modified": $tmp = "Est modifiée"; break;
     case "No deleted Apps exist": $tmp = "Aucune application supprimée"; break;
     case "No modified Apps exist": $tmp = "Aucune application modifiée"; break;

// Users
    case "No": $tmp = "Non"; break;
    case "All": $tmp = "Tous"; break;

// Developers
    case "Names": $tmp = "Noms"; break;
    case "Unknown": $tmp = "Inconnu"; break;

// Licences
     case "Apps": $tmp = "Applications"; break;

// Check Date
     case "All dates are consistent": $tmp = "Toutes les dates sont cohérentes"; break;

// Newsletter
     case "Subscribe Newsletter": $tmp = "S'abonner à la lettre d'info"; break;
     case "Subscribe daily Newsletter": $tmp = "S'abonner à la lettre quotidienne"; break;
     case "Subscribe weekly Newsletter": $tmp = "S'abonner à la lettre hebdomadaire"; break;
     case "Subscribe": $tmp = "S'abonner"; break;
     case "Send newsletter": $tmp = "Envoyer lettre"; break;
     case "Newsletter was sent at ": $tmp = "La lettre a été envoyé à "; break;
     case "You have subscribed to $GLOBALS[sys_name] Newsletter": $tmp = "Vous vous êtes abonné à la lettre $GLOBALS[sys_name]"; break;
     case "Daily Newsletter": $tmp = "Lettre quotidienne"; break;
     case "Weekly Newsletter": $tmp = "Lettre hebdomadaire"; break;
     case "daily": $tmp = "quotidienne"; break;
     case "weekly": $tmp = "hebdomadaire"; break;

// Statistics
	 case "$GLOBALS[sys_name] Statistics": $tmp = "Statistiques de $GLOBALS[sys_name]"; break;
	 case "General $GLOBALS[sys_name] Statistics": $tmp = "Statistiques générale de $GLOBALS[sys_name]"; break;
	 case "Apps by Importance": $tmp = "Applications par importance"; break;
	 case "Apps by Hits": $tmp = "Applications par hits"; break;
	 case "Apps by Homepage Visits": $tmp = "Applications par visite de la page d'accueil"; break;
	 case "Apps by Downloads": $tmp = "Applications par téléchargment"; break;
	 case "Top downloaded RPM Packages": $tmp = "Meilleurs téléchargements de distribution RPM"; break;
	 case "Top downloaded Debian Packages": $tmp = "Meilleurs téléchargements de distribution Debian"; break;
	 case "Top downloaded Slackware Packages": $tmp = "Meilleurs téléchargements de distribution Slackware"; break;
	 case "Apps and Downloads by Urgency": $tmp = "Applications et téléchargements par urgence"; break;
	 case "Apps and Downloads by Version Types": $tmp = "Applications et téléchargements par type de version"; break;
	 case "Apps and Importance by Sections": $tmp = "Applications et importance par section"; break;
	 case "Apps by Categories": $tmp = "Applications par catégorie"; break;
	 case "Apps by Version Numbers": $tmp = "Applications par numéro de version"; break;
	 case "Apps and Downloads by Package Formats": $tmp = "Applications et téléchargements par format de distribution"; break;
	 case "Importance by Licenses": $tmp = "Importance par licence"; break;
	 case "Importance by Email Domains": $tmp = "Importance par domaine d'email"; break;
	 case "Apps by Email Domains": $tmp = "Applications par domaine d'email"; break;
	 case "Apps by Sections and Email Domains": $tmp = "Applications par section et domaine d'email"; break;
	 case "Apps by Licenses": $tmp = "Applications par licence"; break;
	 case "Apps by Licenses and Email Domains": $tmp = "Applications par licence et domaine d'email"; break;

// General Statistics
	 case "Number of Applications in $GLOBALS[sys_name]": $tmp = "Nombre d'applications dans $GLOBALS[sys_name]"; break;
	 case "Total Number of Insertions and Modifications": $tmp = "Nombre total d'insertions et de modifications"; break;
	 case "Number of Insertions and Modifications during the last week": $tmp = "Nombre d'insertions et de modifications la semaine dernière"; break;
	 case "Number of pending Applications": $tmp = "Nombre d'applications en attente"; break;
	 case "Number of $GLOBALS[sys_name] authorised Users": $tmp = "Nombre d'utilisateurs autorisés pour $GLOBALS[sys_name]"; break;
	 case "Number of Comments on Applications": $tmp = "Nombre de commentaires sur les applications"; break;
	 case "Number of Licenses listed in $GLOBALS[sys_name]": $tmp = "Nombre de licences listées dans $GLOBALS[sys_name]"; break;
	 case "Number of $GLOBALS[sys_name] Sections": $tmp = "Nombre de sections $GLOBALS[sys_name]"; break;
	 case "Number of $GLOBALS[sys_name] Categories": $tmp = "Nombre de catégories $GLOBALS[sys_name]"; break;
	 case "Number of Hits on Applications": $tmp = "Nombre de hits sur les applications"; break;
	 case "Number of redirected Homepages": $tmp = "Nombre de redirection vers page d'accueil"; break;
	 case "Number of Downloads": $tmp = "Nombre de téléchargements"; break;
	 case "Number of redirected Changelogs": $tmp = "Nombre de log de modification redirigé"; break;
	 case "Number of redirected CVSs": $tmp = "Nombre de CVS redirigé"; break;
	 case "Number of redirected Screenshots": $tmp = "Nombre de photos d'écran redirigé"; break;
	 case "Number of redirected Mailing Lists Archives": $tmp = "Nombre d'archive de mailing list redirigé"; break;
	 case "SourceWell Version": $tmp = "Version SourceWell"; break;

	 case "High Urgency": $tmp = "Urgence haute"; break;
	 case "Medium Urgency": $tmp = "Urgence moyenne"; break;
	 case "Low Urgency": $tmp = "Urgence basse"; break;
	 case "Stable Version": $tmp = "Version stable"; break;
	 case "Development Version": $tmp = "Version de développement"; break;
	 case "Version Number": $tmp = "Numéro de version"; break;
	 case "Tarballs": $tmp = "Tarballs"; break;
	 case "Red Hat Packages": $tmp = "Distributions Red Hat"; break;
	 case "Debian Packages": $tmp = "Distributions Debian"; break;
	 case "Slackware Packages": $tmp = "Distributions Slackware"; break;
	 case "Applications listed by their Importance": $tmp = "Applications listées par leur importance"; break;
	 case "Applications listed by Number of Tarball-Downloads": $tmp = "Applications listées par nombre de téléchargements Tarball"; break;
	 case "Applications listed by Number of Hits": $tmp = "Applications listées par nombre de hits"; break;
	 case "Applications listed by Homepage Visits": $tmp = "Applications listées par visite de page d'accueil"; break;
	 case "Top downloaded Red Hat Packages": $tmp = "Meilleurs téléchargements de distributions Red Hat"; break;
	 case "Top downloaded Debian Packages": $tmp = "Meilleurs téléchargements de distributions Debian"; break;
	 case "Top downloaded Debian Packages": $tmp = "Meilleurs téléchargements de distributions Debian"; break;
	 case "Application Importance listed by Sections": $tmp = "Importance d'application listée par section"; break;
	 case "Applications listed by Sections": $tmp = "Applications listées par section"; break;
	 case "Applications listed by Categories": $tmp = "Applications listées par catégorie"; break;
	 case "Applications listed by Licenses": $tmp = "Applications listées par licence"; break;
	 case "Availability of downloadable Packet Formats": $tmp = "Disponibilité des formats de paquet de téléchargement"; break;
	 case "Downloads listed by Packet Formats": $tmp = "Téléchargements listés par format de paquet"; break;
	 case "Applications listed by Urgency": $tmp = "Applications listées par urgence"; break;
	 case "Downloads listed by Urgency": $tmp = "Téléchargements listés par urgence"; break;
	 case "Applications listed by Version Numbers": $tmp = "Applications listées par numéro de version"; break;
	 case "Applications listed by Licenses": $tmp = "Applications listées par licence"; break;
	 case "Applications listed by Version Type": $tmp = "Applications listées par type de version"; break;
	 case "Downloads listed by Version Type": $tmp = "Téléchargements listés par type de version"; break;
	 case "Application Importance listed by Licenses": $tmp = "Importance d'application listée par licence"; break;
	 case "Application Importance listed by Developer's Email Domains": $tmp = "Importance d'application listée par domaine d'email de développeurs"; break;
	 case "Applications listed by Developer's Email Domain": $tmp = "Applications listées par domaine d'email de développeurs"; break;
	 case "Applications listed by Sections and Developer's Email Domain": $tmp = "Applications listées par section et par domaine d'email de développeurs"; break;
	 case "Applications listed by Licenses and Developer's Email Domain": $tmp = "Applications listées par licence et par domaine d'email de développeurs"; break;

// Errors
     case "Access denied": $tmp = "Accès refusé"; break;
     case "Error": $tmp = "Erreur"; break;
     case "does not exist": $tmp = "n'existe pas"; break;
     case "Change User Parameters failed": $tmp = "Echec du changement des paramètres utilisateur"; break;
     case "No Application ID specified": $tmp = "ID d'application non spécifié"; break;
     case "No Application Name specified": $tmp = "Nom d'application non spécifié"; break;
     case "Please select": $tmp = "Sélectionnez SVP"; break;
     case "Parameter missing": $tmp = "Paramètre manquant"; break;
     case "and": $tmp = "et"; break;
     case "User": $tmp = "Utilisateur"; break;
     case "already exists": $tmp = "existe déjà"; break;
     case "Please select a different Username": $tmp = "Sélectionnez un nom d'utilisateur différent SVP"; break;
     case "Please enter": $tmp = "Entrez SVP"; break;
     case "Either your Username or E-Mail Address is unknown": $tmp = "Votre nom d'utilisateur ou votre adresse email est inconnu"; break;
     case "Please try again": $tmp = "Essayez encore SVP"; break;
     case "If you are not yet a registered User, please select": $tmp = "Si vous n'êtes pas encore un utilisateur enregistré, sélectionnez SVP"; break;
     case "Verification of Registration failed": $tmp = "Echec de vérification d'enregistrement"; break;
     case "User Change failed": $tmp = "Echec de changement d'utilisateur"; break;
     case "Registration of new User failed": $tmp = "Echec d'enregistrement d'un nouvel utilisateur"; break;
     case "Database Access failed": $tmp = "Echec d'accès à la base de données"; break;
     case "User Deletion failed": $tmp = "Echec de suppression d'utilisateur"; break;
     case "No more Apps for this day": $tmp = "Plus d'aplications pour ce jour"; break;
     case "Either your Username or Password are invalid": $tmp = "Votre nom d'utilisateur ou votre mot de passe est invalide"; break;
     case "The passwords are not identical": $tmp = "Les mots de passe ne sont pas identiques"; break;
     case "Please try again": $tmp = "Essayez encore SVP"; break;
     case "License description is not available": $tmp = "Description de licence non disponible"; break;
     case "No Frequently Asked Questions exist": $tmp = "Aucune Foire Aux Questions"; break;

// New Translations for SourceWell 1.0.9

// stats.php
    case "Number of Insertions and Modifications in the last day": $tmp = "Nombre d'insertions et de modifications le jour passé"; break;
    case "Number of today's visitors": $tmp = "Nombre de visiteurs aujourd'hui"; break;
    case "Today": $tmp = "Aujourd'hui"; break;
    case "Version Number":  $tmp = "Numéro de version"; break;
    case "High Urgency": $tmp = "Urgence haute"; break;
    case "Medium Urgency": $tmp = "Urgence moyenne"; break;
    case "Low Urgency": $tmp = "Urgence basse"; break;

// admuser.php
    case "User Administration": $tmp = "Administration d'utilisateur"; break;
    case "There can only be one anonymous user in the system": $tmp = "Il ne peut y avoir plus d'un utilisateur anonyme dans le système"; break;
    case "The anonymous permission is incompatible with another type of permission": $tmp = "La permission anonyme est incompatible avec un autre type de permission"; break;

// inscat.php and inssec.php
    case "Former category": $tmp = "ex-catégorie"; break;
    case "in Section": $tmp = "dans section"; break;
    case "has been renamed to": $tmp = "a été renommé en"; break;
    case "affecting": $tmp = "affectant"; break;
    case "applications": $tmp = "applications"; break;
    case "already exists!": $tmp = "existe déjà"; break;
    case "Category not specified": $tmp = "Catégorie non spéficiée"; break;
    case "This is the unique category of the section. For deleting it, you should delete the whole section.": $tmp = "C'est la seule catégorie de la section. Pour la supprimer, vous devez supprimer toute la section"; break;
    case "If you press another time the Delete-button you will delete": $tmp = "Si vous pressez une nouvelle fois le bouton 'supprimer' vous supprimerez les"; break;
    case "applications that are actually in the": $tmp = "applications qui sont actuellement dans"; break;
    case "category": $tmp = "catégorie"; break;
    case "Delete Category": $tmp = "Supprimer catégorie"; break;
    case "Delete": $tmp = "Supprimer"; break;
    case "Deletion succesfully completed.": $tmp = "Suppression faite avec succès"; break;
    case "Deletion succesfully completed affecting": $tmp = "Suppression faite avec succès affectant"; break;
    case "applications": $tmp = "applications"; break;
    case "has been added succesfully to the database": $tmp = "a été ajouté avec succès dans la base de données"; break;
    case "Category not specified": $tmp = "Catégorie non spécifiée"; break;
    case "Warning!": $tmp = "Attention !"; break;
    case "If you press another time the Delete-button you will delete the": $tmp = "Si vous pressez une nouvelle fois le bouton 'supprimer' vous supprimerez les"; break;
    case "categories and": $tmp = "catégories et les"; break;
    case "applications that are actually in the": $tmp = "applications qui sont actuellement dans la"; break;
    case "section": $tmp = "section"; break;
    case "Delete Section": $tmp = "Supprimer section"; break;

// inslic.php

    case "License name not specified": $tmp = "Nom de licence non spécifiée"; break;
    case "has a new URL:": $tmp = "a une nouvelle URL:"; break;
    case "New URL not specified": $tmp = "Nouvelle URL non spécifiée"; break;
    case "If you press another time the Delete-button you will alter": $tmp = "Si vous pressez une nouvelle fois le bouton 'supprimer' vous modifierez les"; break;
    case "applications that have actually license": $tmp = "applications qui ont actuellment une licence"; break;
    case "That license already exists!": $tmp = "Cette licence existe déjà !"; break;
    case "with URL": $tmp = "avec l'URL"; break;
    case "has been added succesfully to the database": $tmp = "a été ajoutée avec succès dans la base de données"; break;
    case "License URL not specified": $tmp = "URL de licence non spécifiée"; break;
    case "License not specified": $tmp = "Licence non spécifiée"; break;
    case "Delete License": $tmp = "Supprimer licence"; break;

// admcomment.php and comment.php
    case "Posted on": $tmp = "Posté sur"; break;
    case "Modify": $tmp = "Modifier"; break;
    case "Comment about": $tmp = "Commenter sur"; break;
    case "Delete this comment? (please, think there's no way for undoing comment deletion)": $tmp = "Supprimer ce commentaire ? (Pensez qu'il n'y a aucun moyen de récupérer le commentaire supprimé)"; break;
    case "Yes, Delete": $tmp = "Oui, supprime"; break;
    case "No, Just Modify": $tmp = "Non, modifie seulement"; break;
    case "Comment Deleted": $tmp = "Commentaire supprimé"; break;
    case "Selected Comment was deleted": $tmp = "Le commentaire sélectionné a été supprimé"; break;

// admfaq.php and insfaq.php

    case "Enter a New Frequently Asked Question": $tmp = "Entrez une nouvelle question posée fréquemment"; break;
    case "Frequently Asked Questions Administration": $tmp = "Administration Foire Aux Questions"; break;
    case "Delete this faq? (please, think there's no way for undoing comment deletion)": $tmp = "Supprimer cette faq ? (Pensez qu'il n'y a aucun moyen de récupérer la faq supprimée)"; break;
    case "Create": $tmp = "Créer"; break;
    case "FAQ Deleted": $tmp = "FAQ supprimée"; break;
    case "FAQ Administration": $tmp = "Administration FAQ"; break;
    case "The following FAQ has been modified": $tmp = "La FAQ suivante a été modifiée"; break;
    case "The following FAQ has been inserted in this language": $tmp = "La FAQ suivante a été insérée dans cette langue"; break;

// admdate.php
    case "Modification date": $tmp = "Date de modification"; break;
    case "History date": $tmp = "Date d'archive"; break;

// nladm.php
    case "The Mailing Lists are not enabled": $tmp = "Les mailing list ne sont pas permises"; break;
    case "daily newsletter for": $tmp = "lettre d'information quotidienne pour"; break;
    case "weekly newsletter for": $tmp = "lettre d'information hebdomadaire pour"; break;
    case "Newsletter was sent at ": $tmp = "La lettre d'information a été envoyée à "; break;
    case "Send newsletter": $tmp = "Envoyer lettre d'information"; break;

// footer.inc
    case "System Credits": $tmp = "Auteurs du système"; break;

// login.php
    case "Anonymous login": $tmp = "Connexion anonyme"; break;
    case "If you are not registered and/or you do not want to, you can login as an anonymous user by entering": $tmp = "Si vous n'êtes pas un utilisateur enregistré et/ou si vous ne le souhaitez pas, connectez vous comme utilisateur anonyme en entrant"; break;
    case "as user name and": $tmp = "comme nom d'utilisateur et"; break;
    case "as password.": $tmp = "comme mot de passe"; break;

// configure.php


// If no translation available, keep the original phrase
// Please, translation of this is not needed!
     default: $tmp = "$phrase"; break;
}
?>
