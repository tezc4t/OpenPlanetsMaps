// 3ds/source/main.cpp
#include <3ds.h>
#include <stdio.h>
#include <stdlib.h>
#include <citro2d.h>

// Définition des couleurs pour plus de clarté (Format: RGBA)
#define CLR_BG      C2D_Color32(0x06, 0x0d, 0x18, 0xFF) // #060d18
#define CLR_TEXT    C2D_Color32(0xe8, 0xf0, 0xff, 0xFF) // #e8f0ff
#define CLR_PRIMARY C2D_Color32(0x4f, 0x8e, 0xff, 0xFF) // #4f8eff

// Fonction pour lire un fichier depuis le romfs
char* readFile(const char* path) {
    FILE* file = fopen(path, "r");
    if (!file) {
        return NULL;
    }

    fseek(file, 0, SEEK_END);
    long size = ftell(file);
    fseek(file, 0, SEEK_SET);

    char* buffer = (char*)malloc(size + 1);
    if (!buffer) {
        fclose(file);
        return NULL;
    }

    fread(buffer, 1, size, file);
    buffer[size] = '\0';
    fclose(file);
    return buffer;
}

int main(int argc, char* argv[]) {
    // --- Initialisation ---
    romfsInit();
    gfxInitDefault();
    C3D_Init(C3D_DEFAULT_CMDBUF_SIZE);
    C2D_Init(C2D_DEFAULT_MAX_OBJECTS);
    C2D_Prepare();

    // Crée un "canevas" pour l'écran supérieur
    C3D_RenderTarget* top = C2D_CreateScreenTarget(GFX_TOP, GFX_LEFT);

    // Prépare un buffer pour le texte
    C2D_TextBuf textBuf = C2D_TextBufNew(4096);
    C2D_Text text;

    // Lecture du fichier main.js
    char* js_content = readFile("romfs:/main.js");

    // --- Boucle principale de l'application ---
    while (aptMainLoop()) {
        hidScanInput();
        u32 kDown = hidKeysDown();

        if (kDown & KEY_START) {
            free(js_content); // Libère la mémoire avant de quitter
            break; // Quitte l'application
        }

        // --- Phase de dessin ---
        C3D_FrameBegin(C3D_FRAME_SYNCDRAW);

        // Dessin sur l'écran du haut
        C2D_TargetClear(top, CLR_BG);
        C2D_SceneBegin(top);

        // Dessine du texte
        C2D_TextBufClear(textBuf);
        C2D_TextParse(&text, textBuf, "Lecture de romfs:/main.js reussie !");
        C2D_TextOptimize(&text);
        C2D_DrawText(&text, C2D_WithColor, 20.0f, 20.0f, 0.5f, 0.5f, 0.5f, CLR_PRIMARY);

        if (js_content) {
            C2D_TextParse(&text, textBuf, js_content);
            C2D_TextOptimize(&text);
            C2D_DrawText(&text, C2D_WithColor, 20.0f, 50.0f, 0.5f, 0.4f, 0.4f, CLR_TEXT);
        }

        C3D_FrameEnd(0);
    }

    // --- Libération des ressources ---
    C2D_TextBufDelete(textBuf);
    C2D_Fini();
    C3D_Fini();
    romfsExit();
    gfxExit();
    return 0;
}
