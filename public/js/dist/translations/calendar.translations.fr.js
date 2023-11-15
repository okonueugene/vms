/*! Calendar.js v2.9.10 | (c) Bunoon | MIT License */
var __TRANSLATION_OPTIONS = {
    "dayHeaderNames": [
      "Lun",
      "Mar",
      "Mer",
      "Jeu",
      "Ven",
      "Sam",
      "Dim"
    ],
    "dayNames": [
      "Lundi",
      "Mardi",
      "Mercredi",
      "Jeudi",
      "Vendredi",
      "Samedi",
      "Dimanche"
    ],
    "dayNamesAbbreviated": [
      "Lun",
      "Mar",
      "Mer",
      "Jeu",
      "Ven",
      "Sam",
      "Dim"
    ],
    "monthNames": [
      "Janvier",
      "Février",
      "Mars",
      "Avril",
      "Mai",
      "Juin",
      "Juillet",
      "Août",
      "Septembre",
      "Octobre",
      "Novembre",
      "Décembre"
    ],
    "monthNamesAbbreviated": [
      "Janv",
      "Févr",
      "Mars",
      "Avr",
      "Mai",
      "Juin",
      "Juil",
      "Août",
      "Sept",
      "Oct",
      "Nov",
      "Déc"
    ],
    "previousMonthTooltipText": "Le mois précédent",
    "nextMonthTooltipText": "Le mois prochain",
    "previousDayTooltipText": "Jour précédent",
    "nextDayTooltipText": "Le prochain jour",
    "previousWeekTooltipText": "Semaine précédente",
    "nextWeekTooltipText": "La semaine prochaine",
    "addEventTooltipText": "Ajouter un évènement",
    "closeTooltipText": "Fermer",
    "exportEventsTooltipText": "Exporter des événements",
    "todayTooltipText": "Aujourd'hui",
    "refreshTooltipText": "Rafraîchir",
    "searchTooltipText": "Recherche",
    "expandDayTooltipText": "Jour d'agrandissement",
    "viewAllEventsTooltipText": "Afficher tous les événements",
    "viewFullWeekTooltipText": "Voir la semaine complète",
    "fromText": "Depuis:",
    "toText": "À:",
    "isAllDayText": "C'est toute la journée",
    "titleText": "Titre:",
    "descriptionText": "Description:",
    "locationText": "Emplacement:",
    "addText": "Ajouter",
    "updateText": "Mise à jour",
    "cancelText": "Annuler",
    "removeEventText": "Retirer",
    "addEventTitle": "Ajouter un évènement",
    "editEventTitle": "Modifier l'événement",
    "exportStartFilename": "événements_exportés_",
    "fromTimeErrorMessage": "Veuillez sélectionner une heure « De » valide.",
    "toTimeErrorMessage": "Veuillez sélectionner une heure « À » valide.",
    "toSmallerThanFromErrorMessage": "Veuillez sélectionner une date « À » supérieure à la date « De ».",
    "titleErrorMessage": "Veuillez saisir une valeur dans le champ « Titre » (pas d'espace vide).",
    "stText": "",
    "ndText": "",
    "rdText": "",
    "thText": "",
    "yesText": "Oui",
    "noText": "Non",
    "allDayText": "Toute la journée",
    "allEventsText": "Tous les évènements",
    "toTimeText": "à",
    "confirmEventRemoveTitle": "Confirmer la suppression de l'événement",
    "confirmEventRemoveMessage": "La suppression de cet événement est irréversible. ",
    "okText": "D'ACCORD",
    "exportEventsTitle": "Exporter des événements",
    "selectColorsText": "Choisir les couleurs",
    "backgroundColorText": "Couleur de l'arrière plan:",
    "textColorText": "Couleur du texte :",
    "borderColorText": "Couleur de la bordure:",
    "searchEventsTitle": "Rechercher des événements",
    "previousText": "Précédent",
    "nextText": "Suivant",
    "matchCaseText": "Cas de correspondance",
    "repeatsText": "Répétitions :",
    "repeatDaysToExcludeText": "Répéter les jours à exclure :",
    "daysToExcludeText": "Jours à exclure :",
    "seriesIgnoreDatesText": "Série ignorer les dates :",
    "repeatsNever": "Jamais",
    "repeatsEveryDayText": "Tous les jours",
    "repeatsEveryWeekText": "Toutes les semaines",
    "repeatsEvery2WeeksText": "Toutes les 2 semaines",
    "repeatsEveryMonthText": "Chaque mois",
    "repeatsEveryYearText": "Chaque année",
    "repeatsCustomText": "Coutume:",
    "repeatOptionsTitle": "Options de répétition",
    "moreText": "Plus",
    "includeText": "Inclure:",
    "minimizedTooltipText": "Minimiser",
    "restoreTooltipText": "Restaurer",
    "removeAllEventsInSeriesText": "Supprimer tous les événements de la série",
    "createdText": "Créé:",
    "organizerNameText": "Organisateur:",
    "organizerEmailAddressText": "Courriel de l'organisateur :",
    "enableFullScreenTooltipText": "Activer le mode plein écran",
    "disableFullScreenTooltipText": "Désactiver le mode plein écran",
    "idText": "IDENTIFIANT:",
    "expandMonthTooltipText": "Développer le mois",
    "repeatEndsText": "Répéter les extrémités :",
    "noEventsAvailableText": "Aucun événement disponible.",
    "viewFullWeekText": "Voir la semaine complète",
    "noEventsAvailableFullText": "Il n'y a aucun événement disponible à afficher.",
    "clickText": "Cliquez sur",
    "hereText": "ici",
    "toAddANewEventText": "pour ajouter un nouvel événement.",
    "weekText": "Semaine",
    "groupText": "Groupe:",
    "configurationTooltipText": "Configuration",
    "configurationTitleText": "Configuration",
    "groupsText": "Groupes",
    "eventNotificationTitle": "Calendar.js",
    "eventNotificationBody": "L'événement '{0}' a commencé.",
    "optionsText": "Possibilités :",
    "startsWithText": "Commence avec",
    "endsWithText": "Se termine par",
    "containsText": "Contient",
    "displayTabText": "Afficher",
    "enableAutoRefreshForEventsText": "Activer l'actualisation automatique pour les événements",
    "enableBrowserNotificationsText": "Activer les notifications du navigateur",
    "enableTooltipsText": "Activer les info-bulles",
    "dayText": "jour",
    "daysText": "jours",
    "hourText": "heure",
    "hoursText": "heures",
    "minuteText": "minute",
    "minutesText": "minutes",
    "enableDragAndDropForEventText": "Activer le glisser",
    "organizerTabText": "Organisateur",
    "removeEventsTooltipText": "Supprimer des événements",
    "confirmEventsRemoveTitle": "Confirmer la suppression des événements",
    "confirmEventsRemoveMessage": "La suppression de ces événements non répétitifs est irréversible. ",
    "eventText": "Événement",
    "optionalText": "Facultatif",
    "urlText": "URL :",
    "openUrlText": "Ouvrir le lien",
    "enableDayNameHeadersText": "Activer les en-têtes de nom de jour",
    "thisWeekTooltipText": "Cette semaine",
    "dailyText": "Tous les jours",
    "weeklyText": "Hebdomadaire",
    "monthlyText": "Mensuel",
    "yearlyText": "Annuel",
    "repeatsByCustomSettingsText": "Par paramètres personnalisés",
    "lastUpdatedText": "Dernière mise à jour:",
    "advancedText": "Avancé",
    "copyText": "Copie",
    "pasteText": "Pâte",
    "duplicateText": "Dupliquer",
    "showAlertsText": "Afficher les alertes",
    "selectDatePlaceholderText": "Sélectionner une date...",
    "hideDayText": "Masquer le jour",
    "notSearchText": "Non (ci-contre)",
    "showHolidaysInTheDisplaysText": "Afficher les jours fériés dans l'affichage principal et les barres de titre",
    "newEventDefaultTitle": "* Nouvel évènement",
    "urlErrorMessage": "Veuillez saisir une URL valide dans le champ « Url » (ou laisser vide).",
    "searchTextBoxPlaceholder": "Rechercher un titre, une description, etc...",
    "currentMonthTooltipText": "Mois en cours",
    "cutText": "Couper",
    "showMenuTooltipText": "Afficher le menu",
    "eventTypesText": "Types d'événements",
    "lockedText": "Fermé à clé:",
    "typeText": "Taper:",
    "sideMenuHeaderText": "Calendar.js",
    "sideMenuDaysText": "Jours",
    "visibleDaysText": "Jours visibles",
    "previousYearTooltipText": "Année précédente",
    "nextYearTooltipText": "L'année prochaine",
    "showOnlyWorkingDaysText": "Afficher uniquement les jours ouvrables",
    "exportFilenamePlaceholderText": "Nom: (optionnel)",
    "errorText": "Erreur",
    "exportText": "Exporter",
    "configurationUpdatedText": "Configuration mise à jour.",
    "eventAddedText": "{0} événement ajouté.",
    "eventUpdatedText": "{0} événement mis à jour.",
    "eventRemovedText": "{0} événement supprimé.",
    "eventsRemovedText": "{0} événements supprimés.",
    "eventsExportedToText": "Événements exportés vers {0}.",
    "eventsPastedText": "{0} événements collés.",
    "eventsExportedText": "Événements exportés.",
    "copyToClipboardOnlyText": "Copier uniquement dans le presse-papiers",
    "workingDaysText": "Jours de travail",
    "weekendDaysText": "Jours de week-end",
    "showAsBusyText": "Afficher comme occupé",
    "selectAllText": "Tout sélectionner",
    "selectNoneText": "Ne rien sélectionner",
    "importEventsTooltipText": "Importer des événements",
    "eventsImportedText": "{0} événements importés.",
    "viewFullYearTooltipText": "Voir l'année complète",
    "currentYearTooltipText": "Année actuelle",
    "alertOffsetText": "Décalage d'alerte (minutes):",
    "viewFullDayTooltipText": "Voir la journée complète",
    "confirmEventUpdateTitle": "Confirmer la mise à jour de l'événement",
    "confirmEventUpdateMessage": "Souhaitez-vous mettre à jour l'événement à partir de maintenant, ou la série entière ?",
    "forwardText": "Avant",
    "seriesText": "Série",
    "viewTimelineTooltipText": "Voir la chronologie",
    "nextPropertyTooltipText": "Propriété suivante",
    "noneText": "(aucun)",
    "shareText": "Partager",
    "shareStartFilename": "événements_partagés_",
    "previousPropertyTooltipText": "Propriété précédente"
};