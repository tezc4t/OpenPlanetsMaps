# 3ds/Makefile

# --- Configuration du Projet ---
TARGET      := OpenPlanetsMaps_3DS # Nom du .elf, .3dsx, .smdh
CIA_TARGET  := OpenPlanetsMaps.cia # Nom du fichier .cia final
NAME        := OpenPlanetsMaps
AUTHOR      := Tezca
DESCRIPTION := Visionneur de données astronomiques

# --- Fichiers et Dossiers ---
SOURCES     := source
DATA        := romfs
INCLUDES    := include

# --- Options de compilation ---
CXXFLAGS    := -fno-rtti -fno-exceptions -std=gnu++17

# --- Bibliothèques ---
# Ajoutez des bibliothèques ici si nécessaire (ex: -lcitro2d)
LIBS        := -lcitro2d -lctru -lm

# Variables d'environnement devkitPro
ifeq ($(strip $(DEVKITPRO)),)
$(error "Veuillez définir la variable d'environnement DEVKITPRO.")
endif

# --- Système de Build (ne pas modifier) ---
include $(DEVKITPRO)/lib/dkp-rules/dkp.mk

# --- Cibles de Build ---
# Les cibles 'all', 'cia', et 'clean' sont gérées automatiquement par dkp.mk
# Il n'est plus nécessaire de les définir manuellement.
