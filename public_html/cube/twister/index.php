<?php 
  /* --- Globale Funktionen laden --- */
  require_once(__DIR__ .'/scripts/tw-functions_v000-007-001.php'); // v0.7.1
  
  
  
  /* 
  ***************************************************************************************************
  * Twister
  * 
  * Author:      Walter Randelshofer, Hausmatt 10, CH-6405 Immensee
  * Version:     0.7.1
  * Last Update: 04.01.2025 Werner Randelshofer
  * 
  * Requires:    Twisty Player (cubing.net)
  * 
  * Changes:
  * - Move count (ETM) added for TWIZZLE notation: Cube (2x2, 4x4, 5x5, 6x6, 7x7), Pyraminx (3x3), Megaminx (3x3, 5x5). Not supported for Pyraminx (4x4, 5x5)!
  * - Move count (BTM) added for TWIZZLE notation: Cube (3x3). Not supported for Cube (2x2, 4x4, 5x5, 6x6, 7x7), Pyraminx (3x3, 4x4, 5x5), Megaminx (3x3, 5x5)!
  * - Simple Move count (BTM) added for SSE notation: Cube (2x2, 3x3, 4x4, 5x5, 6x6, 7x7), Pyraminx (3x3, 4x4, 5x5), Megaminx (3x3, 5x5).
  *   This current move count is very limited. It can not handle any advanced notation features like comments, grouping, repetition, conjugation, commutation and so on.
  * - twisty-player: Paramater 'vizualization' was used instead of 'visualization'!
  * - Parameter 'anchor' added.
  * - Options panel added.
  * - Site-Icons added.
  * - Meta Tags for Mobile App added.
  * - Open Graph Meta Tags added.
  * - Preferences: $forceReload added.
  * - 4xPyraminx: Parameter 'experimental-puzzle-description' used instead of parameter 'puzzle'.
  * - 5xPyraminx: Parameter 'experimental-puzzle-description' used instead of parameter 'puzzle'.
  * 
  * To do:
  * - Replace temporary Super-Megaminx-Layout with a better, more precise texture!
  * - Move count (BTM) for all notations and for all puzzles!
  * - Full move count (BTM) support for SSE notation.
  * 
  * Issues:
  * - Since January 2024: on Safari Mobile: Animation of twists is not working anymore!
  ***************************************************************************************************
  */
  
  /* --- Preferences --- */
  $debugmode         = false; // true  = Shows test values.
                              // false = Doesn't show test values (Default).
  
  $compactView       = true;  // true  = Compact display view (Default).
                              // false = Complete display vieew.
                              
  $runLatestTwLib    = true;  // true  = Uses latest Twisty Player version from cubing.net (Default).
                              // false = Uses alternative Twisty Player version from randelshofer.ch.
   
  $runExpTwLib       = true;  // true  = Uses experimental Twisty Player version from cubing.net (Default).
                              // false = Uses latest or experimental Twisty Player version from randelshofer.ch.
  
  $useJavaPlayer     = false; // true  = Uses Java Applet PLayer for SSE link.
                              // false = Uses Twisty Player for SSE link (Default).
  
  $showOptions       = true; // true  = Shows option panel (Default).
                             // false = Doens't show option panel.
  
  $forceReload       = true; // true  = Forces browser to load actual values [CSS] from sever.
                             // false = Loads values [CSS] either from server or from browser cache (Default).
  
  
  
  
  /* --- Variables --- */
  $cgiFile           = "index.php";  // CGI File.
  $cgiVersion        = "0.7.1 beta"; // CGI Version.
  $cgiYear           = "2025";       // CGI Year.
  
  $hostURL           = "www.randelshofer.ch"; // Domain of this CGI.
  
  /* ··································································································· */
  if ($runLatestTwLib == true) {
    //$url_cubing      = "cdn.cubing.net/esm/cubing/twisty";                          // URL Latest Twisty Player version (cubing.net).
    $url_cubing      = "cdn.cubing.net/js/cubing/twisty";                             // URL Latest Twisty Player version (cubing.net).
  } else {
    $url_cubing      = $hostURL ."/cube/twister/modules/2021-04-26/cubing/twisty.js"; // URL Twisty Player version, 26.04.2021 (randelshofer.ch).
  }
  /* ··································································································· */
  //$url_cubingExp     = $hostURL ."/cube/twister/modules-exp/2021-04-26";            // URL experimental Twisty Player version, 26.04.2021 (randelshofer.ch).
  $url_cubingExp     = "experiments.cubing.net/cubing.js";                            // URL experimental Twisty Player version, 26.04.2021 (cubing.net).
  
  $url_sse           = $hostURL ."/cube/";                            // URL SSE (randelshofer.ch)
  $url_twister       = $hostURL ."/cube/twister/";                    // URL TWISTER (randelshofer.ch)
  //$url_twizzle       = "experiments.cubing.net/cubing.js/twizzle/"; // URL TWIZZLE (Twizzle Explorer, cubing.net)
  $url_twizzleExpl   = "alpha.twizzle.net/explore/";                  // URL TWIZZLE (Twizzle Explorer, twizzle.net)
  $url_twizzleEdit   = "alpha.twizzle.net/edit/";                     // URL TWIZZLE (Twizzle Editor, twizzle.net)
  
  $cssDir            = "styles/css";
  $cssFile           = "tw-design.css";
  
  
  
  /* --- Arrays --- */
  $puz_list = [
    /* Cubes */
    "2xCube"     => "2x2 Pocket Cube", 
    "3xCube"     => "3x3 Rubik's Cube", 
    "4xCube"     => "4x4 Revenge Cube", 
    "5xCube"     => "5x5 Professor Cube", 
    "6xCube"     => "6x6 V-Cube 6", 
    "7xCube"     => "7x7 V-Cube 7", 
    /* Pyraminx */
    "3xPyraminx" => "3x3 Pyraminx", 
    "4xPyraminx" => "4x4 Master Pyraminx", 
    "5xPyraminx" => "5x5 Professor Pyraminx", 
    /* Dodecaheder */
    "3xMegaminx" => "3x3 Megaminx", 
    "5xMegaminx" => "5x5 Gigaminx"
  ];
  
  $sse_puzzle_param = [ // SSE Player (Java Applet Player): puzzle parameter
    /* Cubes */
    "2xCube"     => "pocket", 
    "3xCube"     => "rubik", 
    "4xCube"     => "revenge", 
    "5xCube"     => "professor", 
    "6xCube"     => "vcube6", 
    "7xCube"     => "vcube7", 
    /* Pyraminx */
    "3xPyraminx" => "", 
    "4xPyraminx" => "", 
    "5xPyraminx" => "", 
    /* Dodecaheder */
    "3xMegaminx" => "", 
    "5xMegaminx" => ""
  ];
  
  $twister_puzzle_param = [ // Twister: puzzle parameter
    /* Cubes */
    "2xCube"     => "2xCube", 
    "3xCube"     => "3xCube", 
    "4xCube"     => "4xCube", 
    "5xCube"     => "5xCube", 
    "6xCube"     => "6xCube", 
    "7xCube"     => "7xCube", 
    /* Pyraminx */
    "3xPyraminx" => "3xPyraminx", 
    "4xPyraminx" => "", 
    "5xPyraminx" => "", 
    /* Dodecaheder */
    "3xMegaminx" => "3xMegaminx", 
    "5xMegaminx" => "5xMegaminx"
  ];
  
  $twizzle_puzzle_param = [ // Twizzle Explorer: puzzle parameter
    /* Cubes */
    "2xCube"     => "2x2x2", 
    "3xCube"     => "3x3x3", 
    "4xCube"     => "4x4x4", 
    "5xCube"     => "5x5x5", 
    "6xCube"     => "6x6x6", 
    "7xCube"     => "7x7x7", 
    /* Pyraminx */
    "3xPyraminx" => "pyraminx", 
    "4xPyraminx" => "master+pyraminx", 
    "5xPyraminx" => "professor+pyraminx", 
    /* Dodecaheder */
    "3xMegaminx" => "megaminx", 
    "5xMegaminx" => "gigaminx"
  ];
  
  $twizzle_puzzle_descr = [ // Twizzle Explorer: puzzle description
    /* Cubes */
    "2xCube"     => "c f 0", 
    "3xCube"     => "c f 0.333333333333333", 
    "4xCube"     => "c f 0.5 f 0", 
    "5xCube"     => "c f 0.6 f 0.2", 
    "6xCube"     => "c f 0.666666666666667 f 0.333333333333333 f 0", 
    "7xCube"     => "c f 0.714285714285714 f 0.428571428571429 f 0.142857142857143", 
    /* Pyraminx */
    "3xPyraminx" => "t v 0.333333333333333 v 1.66666666666667", 
    "4xPyraminx" => "t v 0 v 1 v 2", 
    "5xPyraminx" => "t v -0.2 v 0.6 v 1.4 v 2.2", 
    /* Dodecaheder */
    "3xMegaminx" => "d f 0.7", 
    "5xMegaminx" => "d f 0.64 f 0.82"
  ];
  
  $notation = [
    "sse"     => "SSE", 
    "sign"    => "SiGN", 
    "twizzle" => "TWIZZLE"
  ];
  
  $layout_supercube = [ // Layout: Super Cube: Filename
    /* Cubes */
    "2xCube"     => "", 
    "3xCube"     => "images/stickers/3xCube/3x_SuperCube_Pochmann_Twizzle_2880_i.png", 
    "4xCube"     => "images/stickers/4xCube/4x_SuperCube_Pochmann_Twizzle_2880_i.png", 
    "5xCube"     => "images/stickers/5xCube/5x_SuperCube_Pochmann_Twizzle_2880_i.png", 
    "6xCube"     => "images/stickers/6xCube/6x_SuperCube_Pochmann_Twizzle_2880_i.png", 
    "7xCube"     => "images/stickers/7xCube/7x_SuperCube_Pochmann_Twizzle_2688_i.png", 
    /* Pyraminx */
    "3xPyraminx" => "", 
    "4xPyraminx" => "", 
    "5xPyraminx" => "", 
    /* Dodecaheder */
    "3xMegaminx" => "images/stickers/3xMegaminx/3x_SuperMinx_Pochmann_Twizzle_3600x2600-10.png", 
    "5xMegaminx" => ""
  ];
  
  $desc_supercube = [ // Layout: Super Cube: Description
    /* Cubes */
    "2xCube"     => "", 
    "3xCube"     => "Super Cube 'Pochmann'", 
    "4xCube"     => "Super Cube 'Pochmann'", 
    "5xCube"     => "Super Cube 'Pochmann'", 
    "6xCube"     => "Super Cube 'Pochmann'", 
    "7xCube"     => "Super Cube 'Pochmann'", 
    /* Pyraminx */
    "3xPyraminx" => "", 
    "4xPyraminx" => "Super Pyraminx 'Pochmann'", 
    "5xPyraminx" => "Super Pyraminx 'Pochmann'", 
    /* Dodecaheder */
    "3xMegaminx" => "Super Megaminx 'Pochmann'", 
    "5xMegaminx" => "Super Gigaminx 'Pochmann'"
  ];
  
  $layout_options = [ // Layout options
    /* Cubes */
    "2xCube"     => "", 
    "3xCube"     => "Super", 
    "4xCube"     => "Super", 
    "5xCube"     => "Super", 
    "6xCube"     => "Super", 
    "7xCube"     => "Super", 
    /* Pyraminx */
    "3xPyraminx" => "", 
    "4xPyraminx" => "", 
    "5xPyraminx" => "", 
    /* Dodecaheder */
    "3xMegaminx" => "Super", 
    "5xMegaminx" => ""
  ];
  
  $tempo_options = [ // Tempo options
    "0.1" => "0.1", // 0.1: Tempo-Minimum.
    "0.5" => "0.5", 
    "1.0" => "1",   // 1.0: TWIZZLE-Default.
    "1.5" => "1.5", 
    "2.0" => "2",   // 2.0: Twister-Default.
    "2.5" => "2.5", 
    "3.0" => "3", 
    "3.5" => "3.5", 
    "4.0" => "4", 
    "4.5" => "4.5", 
    "5.0" => "5", 
    "5.5" => "5.5", 
    "6.0" => "6"    // 6.0: Tempo-Maximum.
  ];
  
  
  
  
  /* --------------------------------------------------------------------------------------------------- */
  /* --- Check Input A --- */
  $input_errA = false; // Error Input A.
  
  
  /* --- Check optionsPanel --- */
  $in['optionsPanel'] = stripslashes(getPar("optionsPanel"));
  if ($in['optionsPanel'] != "1") {$in['optionsPanel'] = "";}
  
  
  /* --- Check puzzle (Required) --- */
  $in['puzzle'] = stripslashes(getPar("puzzle"));
  if ($in['puzzle'] != "2xCube" && 
      $in['puzzle'] != "3xCube" && 
      $in['puzzle'] != "4xCube" && 
      $in['puzzle'] != "5xCube" && 
      $in['puzzle'] != "6xCube" && 
      $in['puzzle'] != "7xCube" && 
      $in['puzzle'] != "3xPyraminx" && 
      $in['puzzle'] != "4xPyraminx" && 
      $in['puzzle'] != "5xPyraminx" && 
      $in['puzzle'] != "3xMegaminx" && 
      $in['puzzle'] != "5xMegaminx") {$in['puzzle'] = "3xCube";} // Accepted values: 2xCube; 3xCube (Default); 4..7xCube; 3...5xPyraminx; 3...4xMegaminx.
  if ($in['puzzle'] == "") {$input_errA = true;}                 // Error: puzzle must not be empty!
  
  
  /* --- Check notation (Required) --- */
  $in['notation'] = stripslashes(getPar("notation"));
  if ($in['notation'] != "sign" && 
      $in['notation'] != "twizzle") {$in['notation'] = "sse";} // Accepted values: 'sign', 'twizzle', 'sse' (Default).
  if ($in['notation'] == "") {$input_errA = true;}             // Error: notation must not be empty!
  
  
  /* --- Check alg (Required) --- */
  $in['alg'] = stripslashes(getPar("alg"));
  $in['alg'] = preg_replace("/\t/"," ",$in['alg']);  // Replace [/t] Tab with [ ] Space.
  $in['alg'] = preg_replace("'  *'",' ',$in['alg']); // Replace superfluous Spaces.
  
  //$in['alg'] = preg_replace("'\‘*'","'",$in['alg']);       // iOS: Replace Single Quatation Mark [‘] with ['] Apostrophe.
  $in['alg'] = preg_replace('/\x{2018}/u',"'",$in['alg']); // Replace Left Single Quotation Mark (iOS Apostrophe) with ['] Apostrophe (Regular Apostrophe is missing on iOS keyboards!).
  $in['alg'] = preg_replace('/\x{2019}/u',"'",$in['alg']); // Replace Right Single Quotation Mark (iOS Apostrophe) with ['] Apostrophe (Regular Apostrophe is missing on iOS keyboards!).
  
  // xxxxx iPhone-Workaround: Entfernung von Sonderzeichnen [%EF%BF%BD]
  //$in['alg'] = preg_replace('/\x{239}/u',"",$in['alg']); // Remove Character %EF (239)
  //$in['alg'] = preg_replace('/\x{191}/u',"",$in['alg']); // Remove Character %BF (191)
  //$in['alg'] = preg_replace('/\x{189}/u',"",$in['alg']); // Remove Character %BD (189)
  
  
  /* --- Options --- */
  
  /* --- Check stickering (Option) --- */
  $in['stickering'] = stripslashes(getPar("stickering"));
  if ($in['stickering'] != "Super") {$in['stickering'] = "";} // Accepted values: "" (Default), 'Super'.
  
  
  /* --- Check anchor (Option) --- */
  $in['anchor'] = stripslashes(getPar("anchor"));
  if ($in['anchor'] != "end") {$in['anchor'] = "";} // Accepted values: "" (Default), 'end'.
  
  
  /* --- Check tempo (Option) --- */
  $in['tempo'] = stripslashes(getPar("tempo"));
  if (is_numeric($in['tempo'])) {                 // Wenn numerisch:
    $in['tempo'] = round($in['tempo'], 1);        //   Auf eine Komma-Stelle runden.
    if ($in['tempo'] < 0.1) {$in['tempo'] = 0.1;} //   Minimum value: 0.1
    if ($in['tempo'] > 6) {$in['tempo'] = 6;}     //   Maximum value: 6
  } else {                                        // Sonst (nicht numerisch):
    $in['tempo'] = "2";                           //   Set Default.
  }
  
  
  /* --- Link --- */
  $in['link'] = stripslashes(getPar("link"));
  if ($in['link'] == "") {
    if ($in['notation'] == "twizzle") {
      $in['link'] = "twizzleExplorer";
    } else {
      $in['link'] = "sse";
    }
  }
  if ($in['link'] != "twizzleExplorer" && 
      $in['link'] != "twizzleEditor") {$in['link'] = "sse";} // Accepted values: 'twizzleExplorer', 'twizzleEditor', 'sse' (Default).
  
  
  
  /* --- Translate Algorithms --- */
  if ($in['puzzle'] == "2xCube") {                    // Bei 2x2 Pocket Cube:
    if ($in['notation'] == "twizzle") {               //   Bei TWIZZLE:
      $out['alg']  = $in['alg'];                      //     OUT     = TWIZZLE
      $alg_SSE     = alg2xC_TwizzleToSse($in['alg']); //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = $in['alg'];                      //     TWIZZLE = TWIZZLE
    } else {                                          //   Sonst (SSE):
      $out['alg']  = alg2xC_SseToTwizzle($in['alg']); //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                      //     SSE     = SSE
      $alg_TWIZZLE = alg2xC_SseToTwizzle($in['alg']); //     TWIZZLE = SSE --> TWIZZLE
    }
  } else if ($in['puzzle'] == "3xCube") {             // Bei 3x3 Rubik's Cube:
    if ($in['notation'] == "twizzle") {               //   Bei TWIZZLE:
      $out['alg']  = $in['alg'];                      //     OUT     = TWIZZLE
      $alg_SSE     = alg3xC_TwizzleToSse($in['alg']); //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = $in['alg'];                      //     TWIZZLE = TWIZZLE
    } else {                                          //   Sonst (SSE):
      $out['alg']  = alg3xC_SseToTwizzle($in['alg']); //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                      //     SSE     = SSE
      $alg_TWIZZLE = alg3xC_SseToTwizzle($in['alg']); //     TWIZZLE = SSE --> TWIZZLE
    }
  } else if ($in['puzzle'] == "4xCube") {             // Bei 4x4 Revenge Cube:
    if ($in['notation'] == "twizzle") {               //   Bei TWIZZLE:
      $out['alg']  = $in['alg'];                      //     OUT     = TWIZZLE
      $alg_SSE     = alg4xC_TwizzleToSse($in['alg']); //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = $in['alg'];                      //     TWIZZLE = TWIZZLE
    } else {                                          //   Sonst (SSE):
      $out['alg']  = alg4xC_SseToTwizzle($in['alg']); //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                      //     SSE     = SSE
      $alg_TWIZZLE = alg4xC_SseToTwizzle($in['alg']); //     TWIZZLE = SSE --> TWIZZLE
    }
  } else if ($in['puzzle'] == "5xCube") {             // Bei 5x5 Professor Cube:
    if ($in['notation'] == "twizzle") {               //   Bei TWIZZLE:
      $out['alg']  = $in['alg'];                      //     OUT     = TWIZZLE
      $alg_SSE     = alg5xC_TwizzleToSse($in['alg']); //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = $in['alg'];                      //     TWIZZLE = TWIZZLE
    } else {                                          //   Sonst (SSE):
      $out['alg']  = alg5xC_SseToTwizzle($in['alg']); //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                      //     SSE     = SSE
      $alg_TWIZZLE = alg5xC_SseToTwizzle($in['alg']); //     TWIZZLE = SSE --> TWIZZLE
    }
  } else if ($in['puzzle'] == "6xCube") {             // Bei 6x6 V-Cube 6:
    if ($in['notation'] == "twizzle") {               //   Bei TWIZZLE:
      $out['alg']  = $in['alg'];                      //     OUT     = TWIZZLE
      $alg_SSE     = alg6xC_TwizzleToSse($in['alg']); //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = $in['alg'];                      //     TWIZZLE = TWIZZLE
    } else {                                          //   Sonst (SSE):
      $out['alg']  = alg6xC_SseToTwizzle($in['alg']); //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                      //     SSE     = SSE
      $alg_TWIZZLE = alg6xC_SseToTwizzle($in['alg']); //     TWIZZLE = SSE --> TWIZZLE
    }
  } else if ($in['puzzle'] == "7xCube") {             // Bei 7x7 V-Cube 7:
    if ($in['notation'] == "twizzle") {               //   Bei TWIZZLE:
      $out['alg']  = $in['alg'];                      //     OUT     = TWIZZLE
      $alg_SSE     = alg7xC_TwizzleToSse($in['alg']); //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = $in['alg'];                      //     TWIZZLE = TWIZZLE
    } else {                                          //   Sonst (SSE):
      $out['alg']  = alg7xC_SseToTwizzle($in['alg']); //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                      //     SSE     = SSE
      $alg_TWIZZLE = alg7xC_SseToTwizzle($in['alg']); //     TWIZZLE = SSE --> TWIZZLE
    }
  
  } else if ($in['puzzle'] == "3xPyraminx") {         // Bei 3x3 Pyraminx:
    if ($in['notation'] == "twizzle") {               //   Bei TWIZZLE:
      $out['alg']  = $in['alg'];                      //     OUT     = TWIZZLE
      $alg_SSE     = alg3xP_TwizzleToSse($in['alg']); //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = $in['alg'];                      //     TWIZZLE = TWIZZLE
    } else {                                          //   Sonst (SSE):
      $out['alg']  = alg3xP_SseToTwizzle($in['alg']); //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                      //     SSE     = SSE
      $alg_TWIZZLE = alg3xP_SseToTwizzle($in['alg']); //     TWIZZLE = SSE --> TWIZZLE
    }
  } else if ($in['puzzle'] == "4xPyraminx") {         // Bei 4x4 Master Pyraminx:
    if ($in['notation'] == "twizzle") {               //   Bei TWIZZLE:
      $out['alg']  = $in['alg'];                      //     OUT     = TWIZZLE
      $alg_SSE     = alg4xP_TwizzleToSse($in['alg']); //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = $in['alg'];                      //     TWIZZLE = TWIZZLE
    } else {                                          //   Sonst (SSE):
      $out['alg']  = alg4xP_SseToTwizzle($in['alg']); //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                      //     SSE     = SSE
      $alg_TWIZZLE = alg4xP_SseToTwizzle($in['alg']); //     TWIZZLE = SSE --> TWIZZLE
    }
  } else if ($in['puzzle'] == "5xPyraminx") {         // Bei 5x5 Professor Pyraminx:
    if ($in['notation'] == "twizzle") {               //   Bei TWIZZLE:
      $out['alg']  = $in['alg'];                      //     OUT     = TWIZZLE
      $alg_SSE     = alg5xP_TwizzleToSse($in['alg']); //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = $in['alg'];                      //     TWIZZLE = TWIZZLE
    } else {                                          //   Sonst (SSE):
      $out['alg']  = alg5xP_SseToTwizzle($in['alg']); //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                      //     SSE     = SSE
      $alg_TWIZZLE = alg5xP_SseToTwizzle($in['alg']); //     TWIZZLE = SSE --> TWIZZLE
    }
    
  } else if ($in['puzzle'] == "3xMegaminx") {                // Bei 3x3 Megaminx:
    if ($in['notation'] == "twizzle") {                      //   Bei TWIZZLE:
      $out['alg']  = alg3xD_OldTwizzleToTwizzle($in['alg']); //     OUT     = TWIZZLE
      $alg_SSE     = alg3xD_TwizzleToSse($out['alg']);       //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = alg3xD_OldTwizzleToTwizzle($in['alg']); //     TWIZZLE = TWIZZLE
    } else {                                                 //   Sonst (SSE):
      $out['alg']  = alg3xD_SseToTwizzle($in['alg']);        //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                             //     SSE     = SSE
      $alg_TWIZZLE = alg3xD_SseToTwizzle($in['alg']);        //     TWIZZLE = SSE --> TWIZZLE
    }
  } else if ($in['puzzle'] == "5xMegaminx") {                // Bei 5x5 Gigaminx:
    if ($in['notation'] == "twizzle") {                      //   Bei TWIZZLE:
      $out['alg']  = alg5xD_OldTwizzleToTwizzle($in['alg']); //     OUT     = TWIZZLE
      $alg_SSE     = alg5xD_TwizzleToSse($out['alg']);       //     SSE     = TWIZZLE --> SSE
      $alg_TWIZZLE = alg5xD_OldTwizzleToTwizzle($in['alg']); //     TWIZZLE = TWIZZLE
    } else {                                                 //   Sonst (SSE):
      $out['alg']  = alg5xD_SseToTwizzle($in['alg']);        //     OUT     = SSE --> TWIZZLE
      $alg_SSE     = $in['alg'];                             //     SSE     = SSE
      $alg_TWIZZLE = alg5xD_SseToTwizzle($in['alg']);        //     TWIZZLE = SSE --> TWIZZLE
    }
  } else {                                            // Sonst:
    $out['alg'] = "";                                 //   ""
    $alg_SSE    = "";                                 //   ""
    $alg_TWIZZLE   = "";                              //   ""
  }
  
  
  /* --- Get TWIZZLE-Algorithm --- */
  $twizzleAlg      = "";
  if ($in['puzzle'] != "") {                                                // Wenn puzzle != "":
    if ($in['alg'] != "") {                                                 //   Wenn alg != "":
      $twizzleAlg = alg_TwizzleToTwizzleLink($out['alg']);                  //     Convert TWIZZLE in Twizzle Link Algorithm
    }
  }
  
  /* --- Get TWIZZLE-Explorer-Link --- */
  $twizzleLinkExpl = "";
  if ($in['puzzle'] != "") {                                                // Wenn puzzle != "":
    $twizzleLinkExpl  = "https://". $url_twizzleExpl;                       //   Scheme: HTTPS
    $twizzleLinkExpl .= "?puzzle=". $twizzle_puzzle_param[$in['puzzle']];   //   Parameter: puzzle
    if ($in['alg'] != "") {                                                 //   Wenn alg != "":
      $twizzleLinkExpl .= "&alg=". $twizzleAlg;                             //     Parameter: alg
    }
    if ($in['anchor'] == "end") {                                           //   Wenn anchor == "end":
      $twizzleLinkExpl .= "&setup-anchor=". $in['anchor'];                  //     Parameter: anchor
    }
    if ($in['tempo'] != "1") {                                              //   Wenn tempo != "1" (TWIZZLE-Default):
      //$twizzleLinkExpl .= "&tempo=". $in['tempo'];                          //     Parameter: tempo (ACHTUNG: nicht per Parameter steuerbar!)
    }
  } else {                                                                  // Sonst:
    $twizzleLinkExpl = "";                                                  //   leerer TWIZZLE-Explorer-Link
  }
  
  /* --- Get TWIZZLE-Editor-Link --- */
  $twizzleLinkEdit = "";
  if ($twister_puzzle_param[$in['puzzle']] != "") {                         // Wenn twister_puzzle_param != "":
    if ($in['puzzle'] != "") {                                              //   Wenn puzzle != "":
      $twizzleLinkEdit  = "https://". $url_twizzleEdit;                     //     Scheme: HTTPS
      $twizzleLinkEdit .= "?puzzle=". $twizzle_puzzle_param[$in['puzzle']]; //     Parameter: puzzle
      if ($in['alg'] != "") {                                               //     Wenn alg != "":
        $twizzleLinkEdit .= "&alg=". $twizzleAlg;                           //       Parameter: alg
      }
      if ($in['anchor'] == "end") {                                         //   Wenn anchor == "end":
        $twizzleLinkEdit .= "&setup-anchor=". $in['anchor'];                //     Parameter: anchor
      }
      if ($in['tempo'] != "1") {                                            //   Wenn tempo != "1" (TWIZZLE-Default):
        //$twizzleLinkEdit .= "&tempo=". $in['tempo'];                        //     Parameter: tempo (ACHTUNG: nicht per Parameter steuerbar!)
      }
    } else {                                                                //   Sonst:
      $twizzleLinkEdit = "";                                                //     leerer TWIZZLE-Edit-Link
    }
  }
  
  
  /* --- Get SSE-Algorithm & SSE-Link --- */
  $sseAlg  = "";
  $sseLink = "";
  /* --- Java-Applet-Player --- */
  if ($useJavaPlayer == true) {
    if ($sse_puzzle_param[$in['puzzle']] != "") {                           // Wenn twister_puzzle_param != "":
      if ($in['puzzle'] != "") {                                            //   Wenn puzzle != "":
        $sseLink  = "http://". $url_sse;                                    //     Scheme: HTTP
        $sseLink .= $sse_puzzle_param[$in['puzzle']] ."/";                  //     Puzzle
        if ($in['alg'] != "") {                                             //     Wenn alg != "":
          $sseAlg = alg_SseToSseLink($alg_SSE);                             //       Convert SSE in SSE Link Algorithm (Java-Applet-Player)
          $sseLink .= "?". $sseAlg;                                         //       Algorithm
        }
      } else {                                                              //   Sonst:
        $sseLink = "";                                                      //     leerer SSE-Link
      }
    }
  /* --- Twister --- */
  } else {
    if ($twister_puzzle_param[$in['puzzle']] != "") {
      if ($in['puzzle'] != "") {                                            // Wenn puzzle != "":
        $sseLink  = "https://". $url_twister;                               //   Scheme: HTTPS
        $sseLink .= "?puzzle=". $twister_puzzle_param[$in['puzzle']];       //   Parameter: puzzle
        if ($in['alg'] != "") {                                             //   Wenn alg != "":
          $sseAlg = alg_SseToTwisterLink($alg_SSE);                         //     Convert SSE in Twister Link Algorithm (Twister)
          $sseLink .= "&alg=". $sseAlg;                                     //     Parameter: alg
        }
        if ($in['stickering'] != "") {                                      //   Wenn stickering != "":
          $sseLink .= "&stickering=". parToTwisterLink($in['stickering']);  //     Parameter: stickering
        }
        if ($in['anchor'] == "end") {                                       //   Wenn anchor == "end":
          $sseLink .= "&anchor=". parToTwisterLink($in['anchor']);          //     Parameter: anchor
        }
        if ($in['tempo'] != "2" && $in['tempo'] != "") {                    //   Wenn tempo != "2" (Twister-Default):
          $sseLink .= "&tempo=". parToTwisterLink($in['tempo']);            //     Parameter: tempo
        }
      } else {                                                              // Sonst:
        $sseLink = "";                                                      //   leerer SSE-Link
      }
    }
  }
  
  
  
  
  /* --------------------------------------------------------------------------------------------------- */
  /* --- Text Variables --- */
  $hea_form            = "Twister";
  
  $but_update          = "Update";
  $hlp_update          = "Update";
  $but_clear           = "Clear";
  $hlp_clear           = "Reset algorithm";
  $but_show            = "Display";
  $hlp_show            = "View at Twizzle Explorer";
  
  /* --- Additional Options --- */
  $txt_optionsOn       = "Display options";
  $txt_optionsOff      = "Hide options";
  
  $txt_anchor          = "Anchor";
  $hlp_anchor          = "Player position";
  $txt_anchorStart     = "Solved at start";
  $txt_anchorEnd       = "Solved at end";
  
  $txt_tempo           = "Tempo";
  $hlp_tempo           = "Player speed";
  $txt_mps             = "mps";
  
  /* --- Parameters --- */
  $txt_puzzle          = "Puzzle";
  $hlp_puzzle          = "Choose a puzzle!";
  
  $txt_notation        = "Notation";
  $hlp_notation        = "Choose a notation!";
  $txt_notSSE          = "Notation SSE";
  $txt_notSiGN         = "Notation SiGN";
  $txt_notTWIZZLE      = "Notation TWIZZLE";
  
  $txt_stickering      = "Stickering";
  $hlp_stickering      = "Sticker options";
  $opt_full            = "Full Stickering";
  
  $txt_alg             = "Algorithm";
  $hlp_alg             = "Algorithm";
  
  $txt_algSSE          = "Algorithm SSE";
  $hlp_algSSE          = "Algorithm";
  
  $txt_algSiGN         = "Algorithm SiGN";
  $hlp_algSiGN         = "Algorithm";
  
  $txt_algTWIZZLE      = "Algorithm TWIZZLE";
  $hlp_algTWIZZLE      = "Algorithm";
  
  $txt_metricBTM       = "btm"; // Block Turn Metric
  $txt_metricLTM       = "ltm"; // Layer Turn Metric
  $txt_metricFTM       = "ftm"; // Face Turn Metric
  $txt_metricQTM       = "qtm"; // Quarter Turn Metric
  $txt_metricETM       = "etm"; // Execution Turn Metric
  
  $txt_link            = "Link";
  $hlp_link            = "Choose a link!";
  
  $txt_linkSSE         = "Link SSE";
  $hlp_linkSSE         = "Link";
  
  $txt_linkTwizzleExpl = "Link TWIZZLE Explorer";
  $hlp_linkTwizzleExpl = "Link";
  
  $txt_linkTwizzleEdit = "Link TWIZZLE Editor";
  $hlp_linkTwizzleEdit = "Link";
  
  /* --- Infos --- */
  $txt_copyTWISTER     = "TWISTER · Copyright © ". $cgiYear ." randelshofer.ch.";
  $txt_copyTWIZZLE     = "TWIZZLE · Copyright © ". $cgiYear ." js.cubing.net.";
  $txt_copy            = "All rights reserved.";
  
  $mta_description     = "Twister supports a wide range of Twisty Puzzles such as Cubes (2 to 7 layers), Pyraminx (3 to 5 layers), as well as the dodecahedron Megaminx and Gigaminx. ";
  $mta_description    .= "This powerful editor and viewer also translates from SSE to TWIZZLE (WCA, SiGN) notation and vice versa.";
  $mta_keywords        = "Twister v". $cgiVersion .", Walter Randelshofer, ";
  $mta_keywords       .= "SSE (Superset ENG) notation, TWIZZLE notation, WCA notation, SiGN notation, ";
  $mta_keywords       .= "Pocket Cube, Rubik's Cube, Rubik's Revenge, Revenge Cube, Professor Cube, V-Cube 6, V-Cube 7, ";
  $mta_keywords       .= "Pyraminx, Master Pyraminx, Professor Pyraminx, ";
  $mta_keywords       .= "Megaminx, Gigaminx";
  
  $og_title            = "Twister v". $cgiVersion;              // Required OG-Tag: The title of the object as it should appear within the graph.
  $og_type             = "website";                             // Required OG-Tag: The type of the object.
  $og_image            = "https://". $hostURL ."/cube/twister/images/og-images/3xCube_Initial-State_1200x630px.png"; // Required OG-Tag (mindestens 600 x 315 px, ideal 1200 x 630 px, Seitenverhältnis 1.91 : 1)
  $og_image_type       = "image/png";                           // Optional OG-Tag: A MIME type for this image.
  $og_image_width      = "1200";                                // Optional OG-Tag: The number of pixels wide.
  $og_image_height     = "630";                                 // Optional OG-Tag: The number of pixels high.
  $og_image_alt        = "The Rubik's Cube is just one of the many Twisty Puzzles supported by Twister."; // Optional OG-Tag: Image description (if 'og:image' is specified, 'og:image:alt' should be specified as well).
  $og_url              = "https://". $hostURL ."/cube/twister"; // Required OG-Tag: The canonical URL of the object (https:// or http:// protocols).
  $og_description      = $mta_description;                      // Optional OG-Tag: A one to two sentence description of the object.
  
  
  
  /* *************************************************************************************************** */
  print "<!DOCTYPE html>\n";
  print "<html lang=\"en\" class=\"pagestatus-init\" style=\"overflow:auto;\">\n"; # iframe: displays scrollbar only when necessary
  print "\n";
  print "\n";
  
  
  /* --- TITLE: Page Title --- */
  print "<head>\n";
  print "  <title>". $hea_form ." v". $cgiVersion ."</title>\n";
  print "  \n";
  
  
  /* --- META: General Meta Data --- */
  print "  <meta name=\"Description\" content=\"". $mta_description ."\" />\n";
  print "  <meta name=\"Keywords\" content=\"". $mta_keywords ."\" />\n";
  print "  <meta name=\"Robots\" content=\"index, noodp\" />\n";
  print "  <meta charset=\"UTF-8\" />\n";
  print "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />\n";
  print "  <!--[if IE]><meta http-equiv=\"x-ua-compatible\" content=\"IE=edge\" /><![endif]-->\n";
  print "  <meta name=\"format-detection\" content=\"telephone=no\" />\n";
  
  /* --- META: Open Graph --- */
  // Source: https://www.promomasters.at/blog/open-graph-meta-tags
  // Source: https://ogp.me
  print "  <meta property=\"og:title\" content=\"". $og_title ."\" />\n";
  print "  <meta property=\"og:type\" content=\"". $og_type ."\" />\n";
  print "  <meta property=\"og:image\" content=\"". $og_image ."\" />\n";
  print "  <meta property=\"og:image:type\" content=\"". $og_image_type ."\" />\n";
  print "  <meta property=\"og:image:width\" content=\"". $og_image_width ."\" />\n";
  print "  <meta property=\"og:image:height\" content=\"". $og_image_height ."\" />\n";
  print "  <meta property=\"og:image:alt\" content=\"". $og_image_alt ."\" />\n";
  print "  <meta property=\"og:url\" content=\"". $og_url ."\" />\n";
  print "  <meta property=\"og:description\" content=\"". $og_description ."\" />\n";
  
  /* --- META: Mobile Web App --- */
  print "  <meta name=\"apple-mobile-web-app-capable\" content=\"yes\" />\n";   // Mobile App Capability
  print "  <meta name=\"apple-mobile-web-app-title\" content=\"Twister\" />\n"; // Mobile App Name
  print "  \n";
  
  
  /* --- Site Icons --- */
  // [512x512]
  print "  <link rel=\"apple-touch-icon\" sizes=\"512x512\" href=\"/cube/twister/images/site-icons/apple-touch-icon-512.png\" />\n"; // 512 x 512 px
  // [196x196]
  print "  <link rel=\"apple-touch-icon\" sizes=\"196x196\" href=\"/cube/twister/images/site-icons/apple-touch-icon-196.png\" />\n"; // 196 x 196 px
  // [180x180] iPhone 6 Plus and iPhone 6s Plus @3x
  print "  <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"/cube/twister/images/site-icons/apple-touch-icon-180.png\" />\n"; // 180 x 180 px
  // [167x167] iPad Pro @2x
  print "  <link rel=\"apple-touch-icon\" sizes=\"167x167\" href=\"/cube/twister/images/site-icons/apple-touch-icon-167.png\" />\n"; // 167 x 167 px
  // [152x152] iPad and iPad mini @2x
  print "  <link rel=\"apple-touch-icon\" sizes=\"152x152\" href=\"/cube/twister/images/site-icons/apple-touch-icon-152.png\" />\n"; // 152 x 152 px
  // [120x120] iPhone 4, iPhone 4s, iPhone 5, iPhone 5c, iPhone 5s, iPhone 6, iPhone 6s @2x
  print "  <link rel=\"apple-touch-icon\" sizes=\"120x120\" href=\"/cube/twister/images/site-icons/apple-touch-icon-120.png\" />\n"; // 120 x 120 px
  // [76x76] iPad and iPad mini @1x
  print "  <link rel=\"apple-touch-icon\" sizes=\"76x76\"   href=\"/cube/twister/images/site-icons/apple-touch-icon-76.png\" />\n";  // 76 x 76 px
  // [57x57] iPhone (first generation or 2G), iPhone 3G, iPhone 3GS
  print "  <link rel=\"apple-touch-icon\" sizes=\"57x57\"   href=\"/cube/twister/images/site-icons/apple-touch-icon-57.png\" />\n";  // 57 x 57 px
  
  // [192x192] Android Devices High Resolution
  print "  <link rel=\"icon\"             sizes=\"192x192\" href=\"/cube/twister/images/site-icons/icon-hd.png\" />\n";              // 192 x 192 px
  // [128x128] Android Devices Normal Resolution
  print "  <link rel=\"icon\"             sizes=\"128x128\" href=\"/cube/twister/images/site-icons/icon.png\" />\n";                 // 128 x 128 px
  
  // [512x512] Standard size (Muss am Schluss stehen, da der Parameter 'sizes' nicht alle Mobile Devices akzeptieren!)
  print "  <link rel=\"apple-touch-icon\" href=\"/cube/twister/images/site-icons/apple-touch-icon.png\" />\n";                       // 512 x 512 px (ohne 'sizes'!)
  print "  \n";
  
  
  /* --- CSS --- */
  print "  <!-- CSS BEGIN -->\n";
  if ($forceReload == true) {
    print "  <link rel=\"stylesheet\" type=\"text/css\" href=\"". $cssDir ."/". $cssFile ."?". time() ."\" />\n"; // Forces browser to reload CSS!
  } else {
    print "  <link rel=\"stylesheet\" type=\"text/css\" href=\"". $cssDir ."/". $cssFile ."\" />\n";
  }
  print "  <!-- CSS END -->\n";
  print "  \n";
  
  
  /* --- JavaScript: cubing.js --- */
  print "  <!-- JavaScript BEGIN -->\n";
  /* ··································································································· */
  if ($runExpTwLib == true) {
    //if ($in['puzzle'] == "2xCube" || 
    //    $in['puzzle'] == "5xMegaminx") {
    //  print "  <script src=\"https://". $url_cubingExp ."/puzzle-geometry.2c6f55a3.js\"></script>\n";
    //  print "  <script src=\"https://". $url_cubingExp ."/twizzle.net/index.fd284134.js\"></script>\n";
    //  print "  <script src=\"https://". $url_cubingExp ."/twizzle.net/index.392c5445.js\"></script>\n";
    //  print "  <script src=\"https://". $url_cubingExp ."/twizzle.net/index.344d082b.js\"></script>\n";
    //  print "  <script src=\"https://". $url_cubingExp ."/twizzle.net/index.3a4f7a9b.js\"></script>\n";
    //  print "  <script src=\"https://". $url_cubingExp ."/twisty/twisty-player.cc41a29d.js\" defer=\"\"></script>\n";
    //} else {
      print "  <script src=\"https://". $url_cubing ."\" type=\"module\" defer></script>\n";
    //}
  } else {
    print "  <script src=\"https://". $url_cubing ."\" type=\"module\" defer></script>\n";
  }
  /* ··································································································· */
  
  //print "  <script>\n";
  //print "    function toggleElements(className) {\n";
  //print "      var className;\n";
  //print "      var elements = document.getElementsByClassName(className);\n";
  //print "      \n";
  //print "      for (var i = 0; i < elements.length; i++) {\n";
  //print "        var element = elements[i];\n";
  //print "        \n";
  //print "        if (element.style.display === \"none\") {\n";
  //print "          element.style.display = \"block\";\n";
  //print "        } else {\n";
  //print "          element.style.display = \"none\";\n";
  //print "        }\n";
  //print "      }\n";
  //print "    }\n";
  //print "  </script>\n";
  
  print "  <!-- JavaScript END -->\n";
  print "  \n";
  
  print "</head>\n";
  print "\n";
  print "\n";
  print "<body>\n";
  print "  <div id=\"blockPage\">\n";
  print "    <div id=\"blockPageInner\">\n";
  print "      \n";
  
  
  /* --- header BEGIN --- */
  //print "      <!-- header BEGIN -->\n";
  //print "      <!-- header END -->\n";
  /* --- header END --- */
  //print "      \n";
  //print "      \n";
  
  
  /* --- blockBody BEGIN --- */
  print "      <!-- blockBody BEGIN -->\n";
  print "      <div id=\"blockBody\">\n";
  print "        <div id=\"blockBodyBefore\">\n";
  print "          <div id=\"blockBodyBeforeInner\"></div>\n";
  print "        </div>\n";
  print "        \n";
  print "        <div id=\"blockBodyInner\">\n";
  print "          <div id=\"blockMain\">\n";
  print "            <div id=\"blockMainInner\">\n";
  print "              <div id=\"blockContent\">\n";
  print "                <div id=\"blockContentInner\">\n";
  print "                  \n";
  print "                  \n";
  
  
  /* --- CONTENT:START --- */
  print "<!--CONTENT:START-->\n";
  /* *************************************************************************************************** */
  
  print "<div id=\"blockCGIForm\">\n";
  print "  \n";
  
  /* --- Formular BEGIN --- */
  print "  <!-- Formular BEGIN -->\n";
  print "  <form id=\"FormA\" name=\"\" method=\"post\" action=\"". $cgiFile ."\" target=\"\">\n";
  print "    <div class=\"elementStandard elementContent elementForm elementForm_var0\">\n";
  print "      \n";
  
  
  /* --- Headline: Twister --- */
  if ($in['optionsPanel'] == "1") {$tmp_txt = $txt_optionsOff; $tmp_value = "";} else {$tmp_txt = $txt_optionsOn; $tmp_value = "1";}
  
  print "      <!-- Headline: h1 -->\n";
  print "      <div class=\"elementHeadline elementHeadlineAlign_var0 elementHeadline_var0 elementHeadlineLevel_varauto\" id=\"anchor_". postSlugTitle($hea_form) ."\">\n";
  print "        <h1 style=\"border:1xp solid #00FF00;\">". $hea_form ." <small>v". $cgiVersion. "</small>";
    
    print "<div style=\"float:right;\">";
      /* --- Button: Additional Options BEGIN --- */
      print "<button type=\"button\" class=\"buttonIconNeutral\" onclick='document.forms[\"FormA\"].optionsPanel.value=\"". $tmp_value ."\"; submit();' title=\"". $tmp_txt ."\" style=\"padding:0.3rem 0.5rem 0 0.5rem;\">";
        print "<svg xmlns=\"http://www.w3.org/2000/svg\" x=\"0px\" y=\"0px\" width=\"25\" height=\"25\" viewBox=\"0 0 50 50\">";
        print "<path d=\"M 22.205078 2 A 1.0001 1.0001 0 0 0 21.21875 2.8378906 L 20.246094 8.7929688 C 19.076509 9.1331971 17.961243 9.5922728 16.910156 10.164062 ";
        print "L 11.996094 6.6542969 A 1.0001 1.0001 0 0 0 10.708984 6.7597656 L 6.8183594 10.646484 A 1.0001 1.0001 0 0 0 6.7070312 11.927734 L 10.164062 16.873047 ";
        print "C 9.583454 17.930271 9.1142098 19.051824 8.765625 20.232422 L 2.8359375 21.21875 A 1.0001 1.0001 0 0 0 2.0019531 22.205078 L 2.0019531 27.705078 A 1.0001 ";
        print "1.0001 0 0 0 2.8261719 28.691406 L 8.7597656 29.742188 C 9.1064607 30.920739 9.5727226 32.043065 10.154297 33.101562 L 6.6542969 37.998047 A 1.0001 ";
        print "1.0001 0 0 0 6.7597656 39.285156 L 10.648438 43.175781 A 1.0001 1.0001 0 0 0 11.927734 43.289062 L 16.882812 39.820312 C 17.936999 40.39548 19.054994 ";
        print "40.857928 20.228516 41.201172 L 21.21875 47.164062 A 1.0001 1.0001 0 0 0 22.205078 48 L 27.705078 48 A 1.0001 1.0001 0 0 0 28.691406 47.173828 ";
        print "L 29.751953 41.1875 C 30.920633 40.838997 32.033372 40.369697 33.082031 39.791016 L 38.070312 43.291016 A 1.0001 1.0001 0 0 0 39.351562 43.179688 ";
        print "L 43.240234 39.287109 A 1.0001 1.0001 0 0 0 43.34375 37.996094 L 39.787109 33.058594 C 40.355783 32.014958 40.813915 30.908875 41.154297 29.748047 ";
        print "L 47.171875 28.693359 A 1.0001 1.0001 0 0 0 47.998047 27.707031 L 47.998047 22.207031 A 1.0001 1.0001 0 0 0 47.160156 21.220703 L 41.152344 20.238281 ";
        print "C 40.80968 19.078827 40.350281 17.974723 39.78125 16.931641 L 43.289062 11.933594 A 1.0001 1.0001 0 0 0 43.177734 10.652344 L 39.287109 6.7636719 ";
        print "A 1.0001 1.0001 0 0 0 37.996094 6.6601562 L 33.072266 10.201172 C 32.023186 9.6248101 30.909713 9.1579916 29.738281 8.8125 L 28.691406 2.828125 ";
        print "A 1.0001 1.0001 0 0 0 27.705078 2 L 22.205078 2 z M 23.056641 4 L 26.865234 4 L 27.861328 9.6855469 A 1.0001 1.0001 0 0 0 28.603516 10.484375 ";
        print "C 30.066026 10.848832 31.439607 11.426549 32.693359 12.185547 A 1.0001 1.0001 0 0 0 33.794922 12.142578 L 38.474609 8.7792969 L 41.167969 11.472656 ";
        print "L 37.835938 16.220703 A 1.0001 1.0001 0 0 0 37.796875 17.310547 C 38.548366 18.561471 39.118333 19.926379 39.482422 21.380859 A 1.0001 1.0001 0 0 0 ";
        print "40.291016 22.125 L 45.998047 23.058594 L 45.998047 26.867188 L 40.279297 27.871094 A 1.0001 1.0001 0 0 0 39.482422 28.617188 C 39.122545 30.069817 ";
        print "38.552234 31.434687 37.800781 32.685547 A 1.0001 1.0001 0 0 0 37.845703 33.785156 L 41.224609 38.474609 L 38.53125 41.169922 L 33.791016 37.84375 ";
        print "A 1.0001 1.0001 0 0 0 32.697266 37.808594 C 31.44975 38.567585 30.074755 39.148028 28.617188 39.517578 A 1.0001 1.0001 0 0 0 27.876953 40.3125 ";
        print "L 26.867188 46 L 23.052734 46 L 22.111328 40.337891 A 1.0001 1.0001 0 0 0 21.365234 39.53125 C 19.90185 39.170557 18.522094 38.59371 17.259766 ";
        print "37.835938 A 1.0001 1.0001 0 0 0 16.171875 37.875 L 11.46875 41.169922 L 8.7734375 38.470703 L 12.097656 33.824219 A 1.0001 1.0001 0 0 0 12.138672 ";
        print "32.724609 C 11.372652 31.458855 10.793319 30.079213 10.427734 28.609375 A 1.0001 1.0001 0 0 0 9.6328125 27.867188 L 4.0019531 26.867188 L 4.0019531 ";
        print "23.052734 L 9.6289062 22.117188 A 1.0001 1.0001 0 0 0 10.435547 21.373047 C 10.804273 19.898143 11.383325 18.518729 12.146484 17.255859 A 1.0001 ";
        print "1.0001 0 0 0 12.111328 16.164062 L 8.8261719 11.46875 L 11.523438 8.7734375 L 16.185547 12.105469 A 1.0001 1.0001 0 0 0 17.28125 12.148438 ";
        print "C 18.536908 11.394293 19.919867 10.822081 21.384766 10.462891 A 1.0001 1.0001 0 0 0 22.132812 9.6523438 L 23.056641 4 z M 25 17 C 20.593567 17 17 ";
        print "20.593567 17 25 C 17 29.406433 20.593567 33 25 33 C 29.406433 33 33 29.406433 33 25 C 33 20.593567 29.406433 17 25 17 z M 25 19 C 28.325553 19 31 ";
        print "21.674447 31 25 C 31 28.325553 28.325553 31 25 31 C 21.674447 31 19 28.325553 19 25 C 19 21.674447 21.674447 19 25 19 z\"></path>";
        print "</svg>";
      print "</button>";
      /* --- Button: Additional Options END --- */
    print "</div>";
    print "</h1>\n";
    
  print "      </div>\n";
  print "      \n";
  print "      \n";
  
  
  /* --- Clearer --- */
  print "      <!-- Clearer -->\n";
  print "      <div class=\"elementClearer\"> </div>\n";
  print "      \n";
  print "      \n";
  
  
  /* --- 01 Debug --- */
  if ($debugmode == "true") {
    print "      <!-- Text: Debug -->\n";
    print "      <div class=\"elementText elementText_var0 elementTextListStyle_var0\" style=\"overflow-wrap:break-word;\">\n";
    print "        <p>\n";
    print "          optionsPanel [". $in['optionsPanel'] ."]<br/>\n";
    print "          Input Error A [". $input_errA ."]<br/>\n";
    print "          puzzle [". $in['puzzle'] ."]<br/>\n";
    print "          alg IN [". $in['alg'] ."]<br/>\n";
    print "          alg OUT [". $out['alg'] ."]<br/>\n";
    print "          alg TWIZZLE [". $twizzleAlg ."]<br/>\n";
    print "          alg SSE [". $sseAlg ."]<br/>\n";
    print "        </p>\n";
    print "      </div>\n";
    print "      \n";
    print "      \n";
  }
  
  
  
  /* ··································································································· */
  /* --- Additional Options --- */
  
  if ($showOptions == true) {
    if ($in['optionsPanel'] == "1") {
      /* --- 01 Anchor (Select), Tempo (Input) --- */
      
      /* --- Anchor --- */
      if ($in['anchor'] == "") { // Bei anchor-Default:
        $in['anchor'] = "start"; //   Wert hinzufügen!
      }
      $err_class = "wglIsNeutral";
      
      /* --- Tempo --- */
      if ($in['tempo'] == "") {                                 // Bei tempo-Default (Twister):
        $in['tempo'] = 2;                                       //   Wert hinzufügen!
      }
      if ($tempo_options[floatFormat($in['tempo'], 1)] == "") { // Wenn Wert nicht in Array:
        $tmp_key = floatFormat($in['tempo'], 1);                //   Key formatieren.
        $tmp_val = $in['tempo'];                                //   Value definieren.
        $tempo_options[$tmp_key] = $tmp_val;                    //   Wert Array hinzufügen.
        ksort($tempo_options);                                  //   Array nach Key sortieren.
      }
      $err_classB = "wglIsNeutral";
      
      print "      <!-- Anchor (Select), Tempo (Select) BEGIN -->\n";
      print "      <div class=\"formElement formElementInput\">\n";
      if ($compactView != true) {
        print "        <!-- Label: Anchor, Tempo -->\n";
        print "        <div>\n";
        print "          <label \n";
        print "            class=\"M ". $err_class ."\"\n";
        print "            for=\"anchor\" \n";
        print "            >". $txt_anchor ."<span class=\"formLabelStar\"></span></label\n";
        print "          ><label \n";
        print "            class=\"M ". $err_classB ."\"\n";
        print "            for=\"tempo\" \n";
        print "            >". $txt_tempo ."<span class=\"formLabelStar\"></span></label\n";
        print "          >\n";
        print "        </div>\n";
        print "        \n";
      }
      
      print "        <!-- Select: Anchor, Tempo -->\n";
      print "        <div>\n";
      print "          <select \n";
      print "            class=\"M ". $err_class ."\" \n";
      print "            name=\"anchor\" \n";
      print "            id=\"anchor\" \n";
      print "            onChange='document.forms[\"FormA\"].submit();' \n";
      print "          >\n";
      
      print "            <option value=\"\">– ". $hlp_anchor ." –</option>\n";
      
      if ($in['anchor'] == "start") {print "            <option value=\"start\" selected=\"selected\">". $txt_anchorStart ."</option>\n";} else {print "            <option value=\"start\">". $txt_anchorStart ."</option>\n";}
      if ($in['anchor'] == "end")   {print "            <option value=\"end\" selected=\"selected\">". $txt_anchorEnd ."</option>\n";}     else {print "            <option value=\"end\">". $txt_anchorEnd ."</option>\n";}
      
      print "          </select><select \n";
      print "            class=\"M ". $err_classB ."\"\n";
      print "            name=\"tempo\" \n";
      print "            id=\"tempo\"\n";
      print "            onChange='document.forms[\"FormA\"].submit();' \n";
      print "          >\n";
      
      print "            <option value=\"\">– ". $hlp_tempo ." –</option>\n";
      
      //for ($i = 0.1; $i <= 6; $i = $i + 0.1) {
      foreach ($tempo_options as $key => $val) {
        //$val_formated = floatFormat($i, 1);
        $val_formated = floatFormat($val, 1);
        $tempo_formated = floatFormat($in['tempo'], 1);
        
        if ($tempo_formated == $val_formated) {print "            <option value=\"". $val_formated ."\" selected=\"selected\">". $val_formated ." ". $txt_mps ."</option>\n";} else {print "            <option value=\"". $val_formated ."\">". $val_formated ." ". $txt_mps ."</option>\n";}
      }
      
      print "          </select>\n";
      print "        </div>\n";
      print "      </div>\n";
      print "      <!-- Anchor (Select), Tempo (Select) END -->\n";
      print "      \n";
      print "      \n";
      
      
      /* --- 01 Hidden --- */
      print "      <!-- Hidden -->\n";
      print "      <div>\n";
      print "        <input type=\"hidden\" name=\"optionsPanel\" value=\"". $in['optionsPanel'] ."\" />\n";
      print "      </div>\n";
      print "      \n";
      print "      \n";
      
      
      /* --- Horizontal Line --- */
      print "      <!-- Horizontal Line -->\n";
      print "      <hr />\n";
      print "      \n";
      print "      \n";
      
    } else {
      /* --- 01 Hidden --- */
      print "      <!-- Hidden -->\n";
      print "      <div>\n";
      print "        <input type=\"hidden\" name=\"anchor\"       value=\"". $in['anchor'] ."\" />\n";
      print "        <input type=\"hidden\" name=\"tempo\"        value=\"". $in['tempo'] ."\" />\n";
      print "        <input type=\"hidden\" name=\"optionsPanel\" value=\"". $in['optionsPanel'] ."\" />\n";
      print "      </div>\n";
      print "      \n";
      print "      \n";
    }
    
  } else {
    /* --- 01 Hidden --- */
    print "      <!-- Hidden -->\n";
    print "      <div>\n";
    print "        <input type=\"hidden\" name=\"anchor\"       value=\"". $in['anchor'] ."\" />\n";
    print "        <input type=\"hidden\" name=\"tempo\"        value=\"". $in['tempo'] ."\" />\n";
    print "        <input type=\"hidden\" name=\"optionsPanel\" value=\"". $in['optionsPanel'] ."\" />\n";
    print "      </div>\n";
    print "      \n";
    print "      \n";
  }
  
  
  
  
  /* ··································································································· */
  /* --- 01 Puzzle (Select, Required) --- */
  if ($in['puzzle'] == "") {$err_class = "wglIsInvalid";} else {$err_class = "wglIsNeutral";}
  
  print "      <!-- Puzzle (Select) BEGIN -->\n";
  print "      <div class=\"formElement formElementInput\">\n";
  if ($compactView != true) {
    print "        <!-- Label: Puzzle -->\n";
    print "        <div>\n";
    print "          <label \n";
    print "            class=\"XXL ". $err_class ."\" \n";
    print "            for=\"puzzle\" \n";
    print "            >". $txt_puzzle ."<span class=\"formLabelStar\">*</span></label\n";
    print "          >\n";
    print "        </div>\n";
    print "        \n";
  }
  
  print "        <!-- Select: Puzzle -->\n";
  print "        <div>\n";
  print "          <select \n";
  print "            class=\"XXL ". $err_class ."\" \n";
  print "            name=\"puzzle\" \n";
  print "            id=\"puzzle\" \n";
  print "            onChange='document.forms[\"FormA\"].submit();' \n";
  print "          >\n";
  
  print "            <option value=\"\">– ". $hlp_puzzle ." –</option>\n";
  
  foreach ($puz_list as $key => $val) {
    if ($in['puzzle'] == $key) {print "            <option value=\"". $key ."\" selected=\"selected\">". $val ."</option>\n";} else {print "            <option value=\"". $key ."\">". $val ."</option>\n";}
  }
  
  print "          </select>\n";
  print "        </div>\n";
  print "      </div>\n";
  print "      <!-- Puzzle (Select) END -->\n";
  print "      \n";
  print "      \n";
  
  
  /* --- 01 Notation (Select, Required) --- */
  if ($in['notation'] == "") {$err_class = "wglIsInvalid";} else {$err_class = "wglIsNeutral";}
  
  print "      <!-- Notation (Select) BEGIN -->\n";
  print "      <div class=\"formElement formElementInput\">\n";
  if ($compactView != true) {
    print "        <!-- Label: Notation -->\n";
    print "        <div>\n";
    print "          <label \n";
    print "            class=\"XXL ". $err_class ."\" \n";
    print "            for=\"notation\" \n";
    print "            >". $txt_notation ."<span class=\"formLabelStar\">*</span></label\n";
    print "          >\n";
    print "        </div>\n";
    print "        \n";
  }
  
  print "        <!-- Select: Notation -->\n";
  print "        <div>\n";
  print "          <select \n";
  print "            class=\"XXL ". $err_class ."\" \n";
  print "            name=\"notation\" \n";
  print "            id=\"notation\" \n";
  print "            onChange='document.forms[\"FormA\"].submit();' \n";
  print "          >\n";
  
  print "            <option value=\"\">– ". $hlp_notation ." –</option>\n";
  
  if ($in['notation'] == "sse")     {print "            <option value=\"sse\" selected=\"selected\">". $txt_notSSE ."</option>\n";}         else {print "            <option value=\"sse\">". $txt_notSSE ."</option>\n";}
  if ($in['notation'] == "twizzle") {print "            <option value=\"twizzle\" selected=\"selected\">". $txt_notTWIZZLE ."</option>\n";} else {print "            <option value=\"twizzle\">". $txt_notTWIZZLE ."</option>\n";}
  
  print "          </select>\n";
  print "        </div>\n";
  print "      </div>\n";
  print "      <!-- Notation (Select) END -->\n";
  print "      \n";
  print "      \n";
  
  
  
  
  /* ··································································································· */
  /* --- Options --- */
  
  /* --- 01 Stickering (Select, Option) --- */
  if ($layout_options[$in['puzzle']] != "") {
    $err_class = "wglIsNeutral";
    
    print "      <!-- Stickering (Select) BEGIN -->\n";
    print "      <div class=\"formElement formElementInput\">\n";
    if ($compactView != true) {
      print "        <!-- Label: Stickering -->\n";
      print "        <div>\n";
      print "          <label \n";
      print "            class=\"XXL ". $err_class ."\" \n";
      print "            for=\"stickering\" \n";
      print "            >". $txt_stickering ."<span class=\"formLabelStar\"></span></label\n";
      print "          >\n";
      print "        </div>\n";
      print "        \n";
    }
    
    print "        <!-- Select: Stickering -->\n";
    print "        <div>\n";
    print "          <select \n";
    print "            class=\"XXL ". $err_class ."\" \n";
    print "            name=\"stickering\" \n";
    print "            id=\"stickering\" \n";
    print "            onChange='document.forms[\"FormA\"].submit();' \n";
    print "          >\n";
    
    print "            <option value=\"\">– ". $hlp_stickering ." –</option>\n";
    
    if ($in['stickering'] == "")      {print "            <option value=\"\" selected=\"selected\">". $opt_full ."</option>\n";}                           else {print "            <option value=\"\">". $opt_full ."</option>\n";}
    if ($in['stickering'] == "Super") {print "            <option value=\"Super\" selected=\"selected\">". $desc_supercube[$in['puzzle']] ."</option>\n";} else {print "            <option value=\"Super\">". $desc_supercube[$in['puzzle']] ."</option>\n";}
    
    print "          </select>\n";
    print "        </div>\n";
    print "      </div>\n";
    print "      <!-- Stickering (Select) END -->\n";
    print "      \n";
    print "      \n";
  } else {
    print "      <!-- Hidden -->\n";
    print "      <div>\n";
    print "        <input type=\"hidden\" name=\"stickering\" value=\"". $in['stickering'] ."\" />\n";
    print "      </div>\n";
    print "      \n";
    print "      \n";
  }
  
  
  
  
  /* ··································································································· */
  /* --- 01 Twisty Player --- */
  /* 
  ***************************************************************************************************
  * Twisty Player: 
  * https://js.cubing.net/cubing/twisty
  * 
  * Twisty Player Parameters: 
  * https://experiments.cubing.net/cubing.js/twisty/twisty-player-config.html
  ***************************************************************************************************
  */
  print "      <!-- Twisty Player BEGIN -->\n";
  print "      <div style=\"height:272px; border:1px solid #999999; \">\n";
  print "        <twisty-player \n";
  print "         id=\"twister\" \n";                                                     // Twisty-Player-ID: [twister], ...
  
  /* ··································································································· */
  /* --- Twisty Player Parameters: Algorithm --- */
  print "         alg=\"". preg_replace("/\r\n/","\n",$alg_TWIZZLE) ."\" \n";             // Algorithm:        []; ...
  print "         experimental-setup-alg=\"\" \n";                                        // Setup Alg:        [none].
//  print "         setup-alg=\"\" \n";                                                     // Setup Alg:        [none].
  
  /* ··································································································· */
  /* --- Twisty Player Parameters: Puzzle --- */
  if ($in['puzzle'] == "4xPyraminx" || $in['puzzle'] == "5xPyraminx") {                                 // Bei '4xPyraminx' oder '5xPyraminx':
    print "         experimental-puzzle-description=\"". $twizzle_puzzle_descr[$in['puzzle']] ."\" \n"; //   Puzzle-Description (Alternative für 'puzzle' Parameter).
  } else {                                                                                              // Sonst:
    print "         puzzle=\"". $twizzle_puzzle_param[$in['puzzle']] ."\" \n";                          //   Puzzle:             2x2x2; [3x3x3]; 4x4x4; 5x5x5; 6x6x6; 7x7x7; pyraminx; megaminx; gigaminx; ...
  }
  
  if ($in['puzzle'] == "3xCube") {                                                        // Bei '3xCube':
    print "         visualization=\"PG3D\" \n";                                           //   Visualization:    auto; [3D]; 2D; experimental-2D-LL; PG3D.
  } else {                                                                                // Sonst (kein '3xCube'):
    print "         visualization=\"3D\" \n";                                             //   Visualization:    auto; [3D]; 2D; experimental-2D-LL; PG3D.
  }
  
  if ($in['stickering'] == "Super") {                                                     // Bei 'Super Cube':
    if ($layout_supercube[$in['puzzle']] != "") {                                         //   Wenn Super-Cube-Textur existiert:
      print "         experimental-stickering=\"picture\" \n";                            //     Stickering:       [full]; OLL; PLL; LL; ...; picture; ...
      print "         experimental-sprite=\"". $layout_supercube[$in['puzzle']] ."\" \n"; //     Sprite:           filename.
    } else {                                                                              //   Sonst (keine Super-Cube-Textur):
      print "         experimental-stickering=\"full\" \n";                               //     Stickering:       [full]; OLL; PLL; LL; ...; picture; ...
    }
  } else {                                                                                // Sonst (kein 'Super Cube'):
    print "         experimental-stickering=\"full\" \n";                                 //   Stickering:       [full]; OLL; PLL; LL; ...; picture; ...
  }
  
  print "         hint-facelets=\"none\" \n";                                             // Hint Facelets:    auto; floating; [none].
  
  print "         back-view=\"side-by-side\" \n";                                         // Back View:        auto; none; [side-by-side]; top-right.
  
  if ($in['tempo'] != "") {
    print "         tempo-scale=\"". $in['tempo'] ."\" \n";                               // Tempo Scale:      [1]. (Range: 0.1 ... 6) 
  }
  
  if (preg_match("/Pyraminx/", $in['puzzle']) == true) {                                  // Bei XxPyraminx:
    print "         camera-latitude=\"90\" \n";                                           //   Camera Latitude:       [none]. (Range: 35 ... -35)
    print "         camera-longitude=\"0\" \n";                                           //   Camera Longitude:      [none]. (Range: ?? ... -??)
    print "         camera-latitude-limit=\"90\" \n";                                     //   Camera Latitude Limit: [none]. (Range: 35 ... -90)
  }
  
  print "         camera-distance=\"6\" \n";                                              // Camera Distance:  [6]. (Range: ??.? ... ??.?)
  
  print "         background=\"none\" \n";                                                // Background:       checkered; [none].
  
  /* ··································································································· */
  /* --- Twisty Player Parameters: User Interaction --- */
  print "         experimental-drag-input=\"auto\" \n";                                   // Drag Input:       [auto]; none.
  
  print "         experimental-move-press-input=\"basic\" \n";                            // Move Press Input: auto; none; [basic].
  
  /* ··································································································· */
  /* --- Twisty Player Parameters: Control Panel --- */
  print "         control-panel=\"bottom-row\" \n";                                       // Control Panel:    auto; [bottom-row]; none;
  
  if ($in['anchor'] == "end") {                                                           // Bei Anchor 'end':
    print "         experimental-setup-anchor=\"end\" \n";                                //   Setup Anchor:   start; [end].
  } else {                                                                                // Sonst ('start', ''):
    print "         experimental-setup-anchor=\"start\" \n";                              //   Setup Anchor:   [start]; end.
//  print "         anchor=\"start\" \n";                                                   // Anchor:           [start]; end.
  }
  
  if ($in['stickering'] == "Super") {                                                     // Bei 'Super Cube':
    if ($layout_supercube[$in['puzzle']] != "") {                                         //   Wenn Super-Cube-Textur existiert:
      print "         viewer-link=\"none\" \n";                                           //     Viewer Link:      auto; [twizzle]; experimental-twizzle-explorer; none.
    } else {                                                                              //   Sonst (keine Super-Cube-Textur):
      if ($in['puzzle'] == "4xPyraminx" || $in['puzzle'] == "5xPyraminx") {               //     Bei '4xPyraminx' oder '5xPyraminx':
        print "         viewer-link=\"none\" \n";                                         //       Viewer Link:      auto; [twizzle]; experimental-twizzle-explorer; none.
      } else {                                                                            //     Sonst:
        print "         viewer-link=\"twizzle\" \n";                                      //       Viewer Link:      auto; [twizzle]; experimental-twizzle-explorer; none.
      }
    }
  } else {                                                                                // Sonst (kein 'Super Cube'):
    if ($in['puzzle'] == "4xPyraminx" || $in['puzzle'] == "5xPyraminx") {                 //   Bei '4xPyraminx' oder '5xPyraminx':
      print "         viewer-link=\"none\" \n";                                           //     Viewer Link:      auto; [twizzle]; experimental-twizzle-explorer; none.
    } else {                                                                              //   Sonst:
      print "         viewer-link=\"twizzle\" \n";                                        //     Viewer Link:      auto; [twizzle]; experimental-twizzle-explorer; none.
    }
  }
  
  /* ··································································································· */
  /* --- Twisty Player CSS --- */
  print "         style=\"width:100%; height:270px; background:#FAFAFA; border:none; margin:0 0 0 0; padding:0 0 0 0;\" \n";
  
  print "        ></twisty-player>\n";
  print "      </div>\n";
  print "      <!-- Twisty Player END -->\n";
  print "      \n";
  print "      \n";
  
  
  
  
  /* ··································································································· */
  /* --- 01 Move Count (TWIZZLE) --- */
  if ($in['notation'] == "twizzle") {
    if ($in['puzzle'] != "4xPyraminx" || $in['puzzle'] != "5xPyraminx") { // 06.03.2023: Move count is not supportet yet for Master Pyraminx and Professor Pyraminx!
      $cnv_alg = "";
      $algLine = explode("\r\n", $alg_TWIZZLE);
      for ($i = 0; $i < count($algLine); $i++) {
        $algPart = explode("//", $algLine[$i]); // Remove comment in line (starting with //)
        $cnv_alg .= $algPart[0] ." ";
      }
      $cnv_alg = cleanString($cnv_alg);
      
      /* --- Metric --- */
      // Lucas Garron (06.03.2023): Right now the only metric implemented for puzzles other than 3x3x3 is ETM.
      if ($in['puzzle'] == "3xCube") {
        $metric     = "OBTM";
        $txt_metric = $txt_metricBTM;
      } else {
        $metric     = "ETM";
        $txt_metric = $txt_metricETM;
      }
      
      print "      <!-- JavaScript BEGIN -->\n";
      print "      <script type=\"module\">\n";
      print "        import { Alg } from \"https://cdn.cubing.net/js/cubing/alg\";\n";
      print "        import { puzzles } from \"https://cdn.cubing.net/js/cubing/puzzles\";\n";
      print "        import { experimentalCountMetricMoves } from \"https://cdn.cubing.net/js/cubing/notation\";\n";
      print "        \n";
      print "        const alg   = new Alg(\"". $cnv_alg ."\");\n";
      print "        const moves = experimentalCountMetricMoves(puzzles[\"". $twizzle_puzzle_param[$in['puzzle']] ."\"], \"". $metric ."\", alg);\n";
      print "        \n";
      print "        const txtMoves = moves + \" ". $txt_metric ."\";\n";
      print "        document.getElementById('twizzleMoveCount').textContent = txtMoves.toString();\n";
      print "      </script>\n";
      print "      <!-- JavaScript END -->\n";
      print "      \n";
      print "      \n";
    }
  }
  
  
  
  
  /* ··································································································· */
  /* --- 01 Algorithm IN (Textarea, Required) --- */
  if ($in['alg'] == "") {$err_class = "wglIsInvalid";} else {$err_class = "wglIsNeutral";}
  $algLength   = strlen($in['alg']);
  $algNewLines = substr_count($in['alg'], "\n");
  
  print "      <!-- Algorithm IN (Textarea) BEGIN -->\n";
  print "      <div class=\"formElement formElementInput\">\n";
  print "        <!-- Label: Algorithm IN -->\n";
  print "        <div>\n";
  print "          <label \n";
  print "            class=\"L ". $err_class ."\"\n";
  print "            for=\"alg\" \n";
  print "            >". $txt_alg ." ". $notation[$in['notation']] ."<span class=\"formLabelStar\">*</span></label\n";
  print "          ><label \n";
  print "            class=\"S wglIsNeutral\"\n";
  print "            for=\"moves\" \n";
  if ($in['notation'] == "twizzle") {
    print "            ><small><span style=\"float:right;\" id=\"twizzleMoveCount\"></span></small></label\n";
  } else {
    if (sse_moveCountBTM($alg_SSE) == "") {
      $txt_tmp = "";
    } else {
      $txt_tmp = sse_moveCountBTM($alg_SSE) ." ". $txt_metricBTM;
    }
    print "            ><small><span style=\"float:right;\" id=\"sseMoveCount\">". $txt_tmp ."</span></small></label\n";
  }
  print "          >\n";
  print "        </div>\n";
  print "        \n";
  
  print "        <!-- Textarea: Algorithm IN -->\n";
  print "        <div>\n";
  print "          <textarea \n";
  print "            class=\"XXL ". $err_class ."\" \n";
  print "            name=\"alg\" \n";
  print "            id=\"alg\" \n";
  print "            maxlength=\"\" \n";
  if ($algLength > 200 or $algNewLines > 4) {$temp = 8;} else {$temp = 4;}
  print "            rows=\"". $temp ."\" \n";
  print "            cols=\"\" \n";
  print "            wrap=\"virtual\" \n";
  print "            placeholder=\"". $txt_alg ."\" \n";
  //print "            onChange='document.forms[\"FormA\"].submit();' \n";
  print "            >". $in['alg'] ."</textarea\n";
  print "          >\n";
  print "        </div>\n";
  print "      </div>\n";
  print "      <!-- Algorithm IN (Textarea) END -->\n";
  print "      \n";
  print "      \n";
  
  //if ($in['notation'] == "twizzle") {
  //  print "      <div>\n";
  //  print "        <twisty-alg-viewer for=\"twister\"></twisty-alg-viewer>\n";
  //  print "      </div>\n";
  //}
  
  
  
  
  /* ··································································································· */
  /* --- 01 Buttons: Update --- */
  print "      <!-- Buttons -->\n";
  print "      <div class=\"formElement formElementButton\">\n";
  print "        <div>\n";
  
  /* --- Button Display --- */
  if ($in['puzzle'] != "") {
    //print "          <a class=\"linkButtonNeutral\" href=\"". $twizzleLinkExpl ."\" target=\"_blank\" title=\"". $hlp_show ."\">". $but_show ."</a>\n";
    print "          <button type=\"button\" class=\"buttonNeutral\" onclick=\"window.open('". $twizzleLinkExpl ."', '_blank');\" title=\"". $hlp_show ."\">". $but_show ."</button>\n";
  }
  
  /* --- Button Clear --- */
  print "          <button type=\"button\" class=\"buttonNeutral\" onclick='document.forms[\"FormA\"].alg.value=\"\";' title=\"". $hlp_clear ."\">". $but_clear ."</button>\n";
  
  /* --- Button Update --- */
  print "          <button type=\"button\" class=\"button\" onclick=\"submit();\" title=\"". $hlp_update ."\">". $but_update ."</button>\n";
  
  print "        </div>\n";
  print "      </div>\n";
  print "      \n";
  print "      \n";
  
  
  
  
  /* ··································································································· */
  /* --- 01 Algorithm OUT (Textarea) --- */
  if ($in['alg'] != "") {
    $err_class = "wglIsNeutral";
    
    if ($in['notation'] == "twizzle") {
      $tmp_txt = $txt_algSSE;
      $tmp_alg = $alg_SSE;
    } else {
      $tmp_txt = $txt_algTWIZZLE;
      $tmp_alg = $alg_TWIZZLE;
    }
    
    print "      <!-- Algorithm OUT (Textarea) BEGIN -->\n";
    print "      <div class=\"formElement formElementInput\">\n";
    print "        <!-- Label: Algorithm OUT -->\n";
    print "        <div>\n";
    print "          <label \n";
    print "            class=\"XXL ". $err_class ."\"\n";
    print "            for=\"algOUT\" \n";
    print "            >". $tmp_txt ."<span class=\"formLabelStar\"></span></label\n";
    print "          >\n";
    print "        </div>\n";
    print "        \n";
    
    print "        <!-- Textarea: Algorithm OUT -->\n";
    print "        <div>\n";
    print "          <textarea \n";
    print "            class=\"XXL ". $err_class ."\" \n";
    print "            name=\"algOUT\" \n";
    print "            id=\"algOUT\" \n";
    print "            maxlength=\"\" \n";
    print "            rows=\"4\" \n";
    print "            cols=\"\" \n";
    print "            wrap=\"virtual\" \n";
    print "            placeholder=\"". $txt_alg ."\" \n";
    //print "            onChange='document.forms[\"FormA\"].submit();' \n";
    print "            >". $tmp_alg ."</textarea\n";
    print "          >\n";
    print "        </div>\n";
    print "      </div>\n";
    print "      <!-- Algorithm OUT (Textarea) END -->\n";
    print "      \n";
    print "      \n";
  }
  
  
  
  
  /* ··································································································· */
  /* --- 01 Link (Select) --- */
  if ($in['alg'] != "") {
    $err_class = "wglIsNeutral";
    
    print "      <!-- Link (Select) BEGIN -->\n";
    print "      <div class=\"formElement formElementInput\">\n";
    if ($compactView != true) {
      print "        <!-- Label: Link -->\n";
      print "        <div>\n";
      print "          <label \n";
      print "            class=\"XXL ". $err_class ."\" \n";
      print "            for=\"link\" \n";
      print "            >". $txt_link ."<span class=\"formLabelStar\"></span></label\n";
      print "          >\n";
      print "        </div>\n";
      print "        \n";
    }
    
    print "        <!-- Select: Link -->\n";
    print "        <div>\n";
    print "          <select \n";
    print "            class=\"XXL ". $err_class ."\" \n";
    print "            name=\"link\" \n";
    print "            id=\"link\" \n";
    print "            onChange='document.forms[\"FormA\"].submit();' \n";
    print "          >\n";
    
    print "            <option value=\"\">– ". $hlp_link ." –</option>\n";
    
    if ($twister_puzzle_param[$in['puzzle']] != "") {
      if ($in['link'] == "sse")           {print "            <option value=\"sse\" selected=\"selected\">". $txt_linkSSE ."</option>\n";}                     else {print "            <option value=\"sse\">". $txt_linkSSE ."</option>\n";}
    }
    if ($in['link'] == "twizzleExplorer") {print "            <option value=\"twizzleExplorer\" selected=\"selected\">". $txt_linkTwizzleExpl ."</option>\n";} else {print "            <option value=\"twizzleExplorer\">". $txt_linkTwizzleExpl ."</option>\n";}
    if ($twister_puzzle_param[$in['puzzle']] != "") {
      if ($in['link'] == "twizzleEditor") {print "            <option value=\"twizzleEditor\" selected=\"selected\">". $txt_linkTwizzleEdit ."</option>\n";}   else {print "            <option value=\"twizzleEditor\">". $txt_linkTwizzleEdit ."</option>\n";}
    }
    
    print "          </select>\n";
    print "        </div>\n";
    print "      </div>\n";
    print "      <!-- Link (Select) END -->\n";
    print "      \n";
    print "      \n";
  }
  
  
  /* --- 01 Link SSE (Textarea) --- */
  if ($in['link'] == "sse") {
    if ($in['alg'] != "") {
      if ($twister_puzzle_param[$in['puzzle']] != "") {
        $err_class = "wglIsNeutral";
        
        print "      <!-- Link SSE (Textarea) BEGIN -->\n";
        print "      <div class=\"formElement formElementInput\">\n";
        if ($compactView != true) {
          print "        <!-- Label: Link SSE -->\n";
          print "        <div>\n";
          print "          <label \n";
          print "            class=\"XXL ". $err_class ."\"\n";
          print "            for=\"linkSSE\" \n";
          print "            >". $txt_linkSSE ."<span class=\"formLabelStar\"></span></label\n";
          print "          >\n";
          print "        </div>\n";
          print "        \n";
        }
        
        print "        <!-- Textarea: Link SSE -->\n";
        print "        <div>\n";
        print "          <textarea \n";
        print "            class=\"XXL ". $err_class ."\" \n";
        print "            name=\"linkSSE\" \n";
        print "            id=\"linkSSE\" \n";
        print "            maxlength=\"\" \n";
        print "            rows=\"2\" \n";
        print "            cols=\"\" \n";
        print "            wrap=\"virtual\" \n";
        print "            placeholder=\"". $hlp_linkSSE ."\" \n";
        //print "            onChange='document.forms[\"FormA\"].submit();' \n";
        print "            >". $sseLink ."</textarea\n";
        print "          >\n";
        print "        </div>\n";
        print "      </div>\n";
        print "      <!-- Link SSE (Textarea) END -->\n";
        print "      \n";
        print "      \n";
      }
    }
  }
  
  /* --- 01 Link TWIZZLE Explorer (Textarea) --- */
  if ($in['link'] == "twizzleExplorer") {
    if ($in['alg'] != "") {
      $err_class = "wglIsNeutral";
      
      print "      <!-- Link TWIZZLE Explorer (Textarea) BEGIN -->\n";
      print "      <div class=\"formElement formElementInput\">\n";
      if ($compactView != true) {
        print "        <!-- Label: Link TWIZZLE Explorer -->\n";
        print "        <div>\n";
        print "          <label \n";
        print "            class=\"XXL ". $err_class ."\"\n";
        print "            for=\"linkTwizzleExplorer\" \n";
        print "            >". $txt_linkTwizzleExpl ."<span class=\"formLabelStar\"></span></label\n";
        print "          >\n";
        print "        </div>\n";
        print "        \n";
      }
      
      print "        <!-- Textarea: Link TWIZZLE Explorer -->\n";
      print "        <div>\n";
      print "          <textarea \n";
      print "            class=\"XXL ". $err_class ."\" \n";
      print "            name=\"linkTwizzleExplorer\" \n";
      print "            id=\"linkTwizzleExplorer\" \n";
      print "            maxlength=\"\" \n";
      print "            rows=\"2\" \n";
      print "            cols=\"\" \n";
      print "            wrap=\"virtual\" \n";
      print "            placeholder=\"". $hlp_linkTwizzleExpl ."\" \n";
      //print "            onChange='document.forms[\"FormA\"].submit();' \n";
      print "            >". $twizzleLinkExpl ."</textarea\n";
      print "          >\n";
      print "        </div>\n";
      print "      </div>\n";
      print "      <!-- Link TWIZZLE Explorer (Textarea) END -->\n";
      print "      \n";
      print "      \n";
    }
  }
  
  /* --- 01 Link TWIZZLE Editor (Textarea) --- */
  if ($in['link'] == "twizzleEditor") {
    if ($in['alg'] != "") {
      if ($twister_puzzle_param[$in['puzzle']] != "") {
        $err_class = "wglIsNeutral";
        
        print "      <!-- Link TWIZZLE Editor (Textarea) BEGIN -->\n";
        print "      <div class=\"formElement formElementInput\">\n";
        if ($compactView != true) {
          print "        <!-- Label: Link TWIZZLE Editor -->\n";
          print "        <div>\n";
          print "          <label \n";
          print "            class=\"XXL ". $err_class ."\"\n";
          print "            for=\"linkTwizzleEditor\" \n";
          print "            >". $txt_linkTwizzleEdit ."<span class=\"formLabelStar\"></span></label\n";
          print "          >\n";
          print "        </div>\n";
          print "        \n";
        }
        
        print "        <!-- Textarea: Link TWIZZLE Editor -->\n";
        print "        <div>\n";
        print "          <textarea \n";
        print "            class=\"XXL ". $err_class ."\" \n";
        print "            name=\"linkTwizzleEditor\" \n";
        print "            id=\"linkTwizzleEditor\" \n";
        print "            maxlength=\"\" \n";
        print "            rows=\"2\" \n";
        print "            cols=\"\" \n";
        print "            wrap=\"virtual\" \n";
        print "            placeholder=\"". $hlp_linkTwizzleEdit ."\" \n";
        //print "            onChange='document.forms[\"FormA\"].submit();' \n";
        print "            >". $twizzleLinkEdit ."</textarea\n";
        print "          >\n";
        print "        </div>\n";
        print "      </div>\n";
        print "      <!-- Link TWIZZLE Editor (Textarea) END -->\n";
        print "      \n";
        print "      \n";
      }
    }
  }
  
  
  print "    </div>\n";
  print "  </form>\n";
  print "  <!-- Formular END -->\n";
  /* --- Formular END --- */
  print "  \n";
  print "  \n";
  
  
  /* ---     --- */
  if ($in['alg'] == "") {
    print "  <!-- Blank Line -->\n";
    print "  <div class=\"elementClearer\"> </div>\n";
    print "  <div class=\"elementClearerWithSpace spacer1\"> </div>\n";
    print "  \n";
    print "  \n";
  }
  
  
  /* --- Text: Copyright --- */
  print "  <!-- Text -->\n";
  print "  <div class=\"elementText elementText_var0 elementTextListStyle_var0\">\n";
  print "    <p class=\"alignCenter\" style=\"font-size:0.8rem; line-height:130%;\">\n";
  print "      ". $txt_copyTWISTER ."<br/>\n";
  print "      ". $txt_copyTWIZZLE ."<br/>\n";
  print "      ". $txt_copy ."\n";
  print "    </p>\n";
  print "  </div>\n";
  print "  \n";
  print "  \n";
  
  
  print "</div>\n";
  
  /* *************************************************************************************************** */
  print "<!--CONTENT:STOP-->\n";
  
  
  print "                  \n";
  print "                  \n";
  print "                  <!-- blockAfter BEGIN -->\n";
  print "                  <div id=\"blockAfter\">\n";
  print "                    <div id=\"blockAfterInner\">\n";
  print "                      <!--CONTENT:START-->\n";
  print "                      <!--CONTENT:STOP-->\n";
  print "                    </div>\n";
  print "                  </div>\n";
  print "                  <!-- blockAfter END -->\n";
  print "                  \n";
  print "                  \n";
  print "                </div>\n";
  print "              </div>\n";
  print "            </div>\n";
  print "          </div>\n";
  print "        </div>\n";
  print "      </div>\n";
  print "      <!-- blockBody END -->\n";
  /* --- blockBody END --- */
  print "      \n";
  print "      \n";
  
  
  
  
  /* --- footer BEGIN --- */
  /* --- footer END --- */
  print "      \n";
  print "      \n";
  
  
  
  
  print "    </div>\n";
  print "  </div>\n";
  print "  \n";
  print "  \n";
  
  
  print "</body>\n";
  print "</html>\n";
?>
