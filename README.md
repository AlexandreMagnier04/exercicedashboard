# ExerciceDashboard

## Objectif du module
Le module **ExerciceDashboard** permet d'afficher un widget météo personnalisé sur le tableau de bord du back-office PrestaShop. Il utilise l'API OpenWeatherMap pour récupérer les données météo en temps réel.

## Prérequis
- PrestaShop ≥ 1.7.1.0
- Compte OpenWeatherMap gratuit (https://openweathermap.org/api)

## Installation
1. Générez le fichier `exercicedashboard.zip` à partir du dossier du module.
2. Dans le back-office PrestaShop :
   - Allez dans **Modules > Module Manager**
   - Cliquez sur **"Ajouter un module"** puis importez le fichier ZIP
   - Installez le module une fois reconnu

## Configuration
1. Allez dans **Modules > exercicedashboard > Configurer**
2. Renseignez :
   - Votre **clé API OpenWeatherMap**
   - La **ville** (ex: Lille, Paris, London...)
   - Le **mode de mise à jour** :
     - **Manuel** : vous devrez cliquer sur un bouton pour mettre à jour les données
     - **Automatique** : les données sont mises à jour toutes les 24h via le hook `actionCronJob`

## Tester les fonctionnalités
### Mode manuel :
- Allez sur la page d'accueil du back-office
- Dans le tableau de bord, allez sur le widget **météo**
- Cliquez sur **"Mettre à jour maintenant"** pour forcer mettre à jour les données

### Mode automatique :
- Activez le module officiel **cronjobs** (PrestaShop)
- La mise à jour se fera automatiquement toutes les 24h

