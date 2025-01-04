<?php 
  /* --- Globale Funktionen laden --- */
  require_once($_SERVER['DOCUMENT_ROOT'].'/cube/twister/scripts/tw-functions_v000-006-002.php'); // v0.6.2
  
  
  
  /* 
  ***************************************************************************************************
  * Twister
  * 
  * Author:      Walter Randelshofer, Hausmatt 10, CH-6405 Immensee
  * Version:     0.6.2
  * Last Update: 08.01.2023 wr
  * 
  * Requires:    Twisty Player (cubing.net)
  * 
  * Changes:
  * 
  * To do:
  * - Replace temporary Super-Megaminx-Layout with a better, more precise texture!
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
  
  $showOptions       = false; // true  = Shows option panel.
                              // false = Doens't show option panel. 
  
  
  
  
  /* --- Variables --- */
  $cgiFile           = "index_v000-006-002.php";  // CGI File.
  $cgiVersion        = "0.6.2 beta"; // CGI Version.
  $cgiYear           = "2023";       // CGI Year.
  
  /* ··································································································· */
  if ($runLatestTwLib == true) {
    //$url_cubing      = "cdn.cubing.net/esm/cubing/twisty";                                      // URL Latest Twisty Player version (cubing.net).
    $url_cubing      = "cdn.cubing.net/js/cubing/twisty";                                       // URL Latest Twisty Player version (cubing.net).
  } else {
    $url_cubing      = "www.randelshofer.ch/cube/twister/modules/2021-04-26/cubing/twisty.js";  // URL Twisty Player version, 26.04.2021 (randelshofer.ch).
  }
  /* ··································································································· */
  //$url_cubingExp     = "www.randelshofer.ch/cube/twister/modules-exp/2021-04-26"; // URL experimental Twisty Player version, 26.04.2021 (randelshofer.ch).
  $url_cubingExp     = "experiments.cubing.net/cubing.js";                          // URL experimental Twisty Player version, 26.04.2021 (cubing.net).
  
  $url_sse           = "www.randelshofer.ch/cube/";                 // URL SSE (randelshofer.ch)
  $url_twister       = "www.randelshofer.ch/cube/twister/";         // URL TWISTER (randelshofer.ch)
  //$url_twizzle       = "experiments.cubing.net/cubing.js/twizzle/"; // URL TWIZZLE (Twizzle Explorer, cubing.net)
  $url_twizzleExpl   = "alpha.twizzle.net/explore/";                // URL TWIZZLE (Twizzle Explorer, twizzle.net)
  $url_twizzleEdit   = "alpha.twizzle.net/edit/";                // URL TWIZZLE (Twizzle Editor, twizzle.net)
  
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
  
  
  
  
  /* --------------------------------------------------------------------------------------------------- */
  /* --- Check Input A --- */
  $input_errA = false; // Error Input A.
  
  
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
  if ($in['puzzle'] == "") {$input_errA = true;} // Error: puzzle must not be empty!
  
  
  /* --- Check notation (Required) --- */
  $in['notation'] = stripslashes(getPar("notation"));
  if ($in['notation'] != "sign" && 
      $in['notation'] != "twizzle") {$in['notation'] = "sse";} // Accepted values: 'sign', 'twizzle', 'sse' (Default).
  if ($in['notation'] == "") {$input_errA = true;} // Error: notation must not be empty!
  
  
  /* --- Check alg (Required) --- */
  $in['alg'] = stripslashes(getPar("alg"));
  $in['alg'] = preg_replace("/\t/"," ",$in['alg']);  // Replace [/t] Tab with [ ] Space.
  $in['alg'] = preg_replace("'  *'",' ',$in['alg']); // Replace superfluous Spaces.
  
  //$in['alg'] = preg_replace("'\‘*'","'",$in['alg']);      // iOS: Replace Single Quatation Mark [‘] with ['] Apostrophe.
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
  
  
  /* --- Check tempo (Option) --- */
  $in['tempo'] = stripslashes(getPar("tempo"));
  if ($in['tempo'] != "") {
    if ($in['tempo'] < 0.1) {$in['tempo'] = 0.1;} // Minimum value: 0.1
    if ($in['tempo'] > 6) {$in['tempo'] = 6;}     // Maximum value: 6
  } else {
    $in['tempo'] = 2;                             // Default value: 2
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
    } else {                                                                //   Sonst:
      $twizzleLinkEdit = "";                                                //     leerer TWIZZLE-Edit-Link
    }
  }
  
  
  /* --- Get SSE-Algorithm & SSE-Link --- */
  $sseAlg  = "";
  $sseLink = "";
  /* --- Java-Applet-Player --- */
  if ($useJavaPlayer == true) {
    if ($sse_puzzle_param[$in['puzzle']] != "") {                     // Wenn twister_puzzle_param != "":
      if ($in['puzzle'] != "") {                                      //   Wenn puzzle != "":
        $sseLink  = "http://". $url_sse;                              //     Scheme: HTTP
        $sseLink .= $sse_puzzle_param[$in['puzzle']] ."/";            //     Puzzle
        if ($in['alg'] != "") {                                       //     Wenn alg != "":
          $sseAlg = alg_SseToSseLink($alg_SSE);                       //       Convert SSE in SSE Link Algorithm (Java-Applet-Player)
          $sseLink .= "?". $sseAlg;                                   //       Algorithm
        }
      } else {                                                        //   Sonst:
        $sseLink = "";                                                //     leerer SSE-Link
      }
    }
  /* --- Twister --- */
  } else {
    if ($twister_puzzle_param[$in['puzzle']] != "") {
      if ($in['puzzle'] != "") {                                      // Wenn puzzle != "":
        $sseLink  = "https://". $url_twister;                         //   Scheme: HTTPS
        $sseLink .= "?puzzle=". $twister_puzzle_param[$in['puzzle']]; //   Parameter: puzzle
        if ($in['alg'] != "") {                                       //   Wenn alg != "":
          $sseAlg = alg_SseToTwisterLink($alg_SSE);                   //     Convert SSE in Twister Link Algorithm (Twister)
          $sseLink .= "&alg=". $sseAlg;                               //     Parameter: alg
        }
        if ($in['stickering'] != "") {                                //   Wenn stickering != "":
          $sseLink .= "&stickering=". parToTwisterLink($in['stickering']); //     Parameter: stickering
        }
      } else {                                                        // Sonst:
        $sseLink = "";                                                //   leerer SSE-Link
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
  
  $txt_puzzle          = "Puzzle";
  $hlp_puzzle          = "Choose a puzzle!";
  
  $txt_notation        = "Notation";
  $hlp_notation        = "Choose a notation!";
  $txt_notSSE          = "Notation SSE";
  $txt_notSiGN         = "Notation SiGN";
  $txt_notTWIZZLE      = "Notation TWIZZLE";
  
  $txt_stickering      = "Stickering";
  $opt_full            = "Full Stickering";
  
  $txt_alg             = "Algorithm";
  $hlp_alg             = "Algorithm";
  
  $txt_algSSE          = "Algorithm SSE";
  $hlp_algSSE          = "Algorithm";
  
  $txt_algSiGN         = "Algorithm SiGN";
  $hlp_algSiGN         = "Algorithm";
  
  $txt_algTWIZZLE      = "Algorithm TWIZZLE";
  $hlp_algTWIZZLE      = "Algorithm";
  
  $txt_link            = "Link";
  $hlp_link            = "Choose a link!";
  
  $txt_linkSSE         = "Link SSE";
  $hlp_linkSSE         = "Link";
  
  $txt_linkTwizzleExpl = "Link TWIZZLE Explorer";
  $hlp_linkTwizzleExpl = "Link";
  
  $txt_linkTwizzleEdit = "Link TWIZZLE Editor";
  $hlp_linkTwizzleEdit = "Link";
  
  $txt_copyTWISTER     = "TWISTER · Copyright © ". $cgiYear ." randelshofer.ch.";
  $txt_copyTWIZZLE     = "TWIZZLE · Copyright © ". $cgiYear ." js.cubing.net.";
  $txt_copy            = "All rights reserved.";
  
  $mta_description     = "Twister translates from SSE to TWIZZLE (WCA, SiGN) notation and vice versa. ";
  $mta_description    .= "It supports a wide range of Twisty Puzzles like Cubes (2 to 7 layers), Pyraminx (3 to 5 layers), plus the dodecahedrons Megaminx and Gigaminx.";
  $mta_keywords        = "Twister v". $cgiVersion .", Walter Randelshofer, ";
  $mta_keyword        .= "SSE (Superset ENG) notation, TWIZZLE notation, WCA notation, SiGN notation, ";
  $mta_keywords       .= "Pocket Cube, Rubiks'Cube, Rubik's Revenge, Revenge Cube, Professor Cube, V-Cube 6, V-Cube 7, ";
  $mta_keywords       .= "Pyraminx, Master Pyraminx, Professor Pyraminx, ";
  $mta_keywords       .= "Megaminx, Gigaminx";
  
  
  
  /* *************************************************************************************************** */
  print "<!DOCTYPE html>\n";
  print "<html lang=\"en\" class=\"pagestatus-init\" style=\"overflow:auto;\">\n"; # iframe: displays scrollbar only when necessary
  print "\n";
  print "\n";
  
  
  /* --- TITLE: Page Title --- */
  print "<head>\n";
  print "  <title>". $hea_form ." v". $cgiVersion ."</title>\n";
  print "  \n";
  
  
  /* --- META: Meta Data --- */
  print "  <meta name=\"Description\" content=\"". $mta_description ."\" />\n";
  print "  <meta name=\"Keywords\" content=\"". $mta_keywords ."\" />\n";
  print "  <meta name=\"Robots\" content=\"index, noodp\" />\n";
  print "  <meta charset=\"UTF-8\" />\n";
  print "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>\n";
  print "  <!--[if IE]><meta http-equiv=\"x-ua-compatible\" content=\"IE=edge\" /><![endif]-->\n";
  print "  <meta name=\"format-detection\" content=\"telephone=no\"/>\n";
  print "  \n";
  
  
  /* --- CSS --- */
  print "  <!-- CSS BEGIN -->\n";
  print "  <link rel=\"stylesheet\" type=\"text/css\" href=\"". $cssDir ."/". $cssFile ."\"/>\n";
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
  
  /* --- Headline: Twister --- */
  print "  <!-- Headline: h1 -->\n";
  print "  <div class=\"elementHeadline elementHeadlineAlign_var0 elementHeadline_var0 elementHeadlineLevel_varauto\" id=\"anchor_". postSlugTitle($hea_form) ."\">\n";
  print "    <h1>". $hea_form ." <small>v". $cgiVersion."</small></h1>\n";
  print "  </div>\n";
  print "  \n";
  print "  \n";
  
  
  /* --- 01 Debug --- */
  if ($debugmode == "true") {
    print "  <!-- Text: Debug -->\n";
    print "  <div class=\"elementText elementText_var0 elementTextListStyle_var0\" style=\"overflow-wrap:break-word;\">\n";
    print "    <p>\n";
    print "      Input Error A: [". $input_errA ."]<br/>\n";
    print "      puzzle: [". $in['puzzle'] ."]<br/>\n";
    print "      alg IN: [". $in['alg'] ."]<br/>\n";
    print "      alg OUT: [". $out['alg'] ."]<br/>\n";
    print "      alg TWIZZLE: [". $twizzleAlg ."]<br/>\n";
    print "      alg SSE: [". $sseAlg ."]<br/>\n";
    print "    </p>\n";
    print "  </div>\n";
    print "  \n";
    print "  \n";
  }
  
  
  print "  <div class=\"elementStandard elementContent elementForm elementForm_var0\">\n";
  print "    \n";
  
  /* --- Formular BEGIN --- */
  print "    <!-- Formular BEGIN -->\n";
  print "    <form id=\"FormA\" name=\"\" method=\"post\" action=\"". $cgiFile ."\" target=\"\">\n";
  print "      \n";
  
  
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
  
  print "            <option value=\"\">- ". $hlp_puzzle ." -</option>\n";
  
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
  
  print "            <option value=\"\">- ". $hlp_notation ." -</option>\n";
  
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
  
  
  /* --- 01 Tempo (Input, Option) --- */
  if ($showOptions == true) {
    $err_class = "wglIsNeutral";
    
    print "      <!-- Tempo (Input) BEGIN -->\n";
    print "      <div class=\"formElement formElementInput\">\n";
    print "        <!-- Label: Tempo -->\n";
    print "        <div>\n";
    print "          <label \n";
    print "            class=\"XXL ". $err_class ."\"\n";
    print "            for=\"tempo\" \n";
    print "            >". "Tempo" ."<span class=\"formLabelStar\"></span></label\n";
    print "          >\n";
    print "        </div>\n";
    print "        \n";
    
    print "        <!-- Range: Tempo -->\n";
    print "        <div>\n";
    print "          <input \n";
    print "            class=\"XXL ". $err_class ."\"\n";
    //print "            type=\"range\" \n";
    print "            type=\"input\" \n";
    //print "            type=\"number\" \n";
    print "            name=\"tempo\" \n";
    print "            id=\"tempo\"\n";
    print "            min=\"0.1\" \n";
    print "            max=\"6\" \n";
    print "            step=\"0.1\" \n";
    print "            value=\"". $in['tempo'] ."\" \n";
    print "          >\n";
    print "        </div>\n";
    print "      </div>\n";
    print "      <!-- Tempo (Inpup) END -->\n";
    print "      \n";
    print "      \n";
  } else {
    /* --- 01 Hidden --- */
    print "      <!-- Hidden -->\n";
    print "      <div>\n";
    print "        <input type=\"hidden\" name=\"tempo\" value=\"". $in['tempo'] ."\" />\n";
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
  
  /* --- Twisty Player Parameters: Algorithm --- */
  print "         alg=\"". preg_replace("/\r\n/","\n",$alg_TWIZZLE) ."\" \n";             // Algorithm:        []; ...
  print "         experimental-setup-alg=\"\" \n";                                        // Setup Alg:        [none].
//  print "         setup-alg=\"\" \n";                                                     // Setup Alg:        [none].
  
  /* --- Twisty Player Parameters: Puzzle --- */
  print "         puzzle=\"". $twizzle_puzzle_param[$in['puzzle']] ."\" \n";              // Puzzle:           2x2x2; [3x3x3]; 4x4x4; 5x5x5; 6x6x6; 7x7x7; pyraminx; megaminx; gigaminx; ...
  print "         vizualization=\"3D\" \n";                                               // Vizualisation:    auto; [3D]; 2D; experimental-2D-LL; PG3D.
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
  
  /* --- Twisty Player Parameters: User Interaction --- */
  print "         experimental-drag-input=\"auto\" \n";                                   // Drag Input:       [auto]; none.
  print "         experimental-move-press-input=\"basic\" \n";                            // Move Press Input: auto; none; [basic].
  
  /* --- Twisty Player Parameters: Control Panel --- */
  print "         control-panel=\"bottom-row\" \n";                                       // Control Panel:    auto; [bottom-row]; none;
  print "         experimental-setup-anchor=\"start\" \n";                                // Setup Anchor:     [start]; end.
//  print "         anchor=\"start\" \n";                                                   // Anchor:           [start]; end.
  if ($in['stickering'] == "Super") {                                                     // Bei 'Super Cube':
    if ($layout_supercube[$in['puzzle']] != "") {                                         //   Wenn Super-Cube-Textur existiert:
      print "         viewer-link=\"none\" \n";                                           //     Viewer Link:      auto; [twizzle]; experimental-twizzle-explorer; none.
    } else {                                                                              //   Sonst (keine Super-Cube-Textur):
      print "         viewer-link=\"twizzle\" \n";                                        //     Viewer Link:      auto; [twizzle]; experimental-twizzle-explorer; none.
    }
  } else {                                                                                // Sonst (kein 'Super Cube'):
    print "         viewer-link=\"twizzle\" \n";                                          //   Viewer Link:      auto; [twizzle]; experimental-twizzle-explorer; none.
  }
  
  /* --- Twisty Player CSS --- */
  print "         style=\"width:100%; height:270px; background:#FAFAFA; border:none; margin:0 0 0 0; padding:0 0 0 0;\" \n";
    
  print "        ></twisty-player>\n";
  print "      </div>\n";
  print "      <!-- Twisty Player END -->\n";
  print "      \n";
  print "      \n";
  
  
  
  
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
  print "            class=\"XL ". $err_class ."\"\n";
  print "            for=\"alg\" \n";
  print "            >". $txt_alg ." ". $notation[$in['notation']] ."<span class=\"formLabelStar\">*</span></label\n";
  print "          ><label \n";
  print "            class=\"XS wglIsNeutral\"\n";
  print "            for=\"moves\" \n";
  print "            ><span style=\"float:right;\" class=\"move-count\"></span></label\n";
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
  print "          <button type=\"submit\" class=\"button\" onclick=\"submit();\" title=\"". $hlp_update ."\">". $but_update ."</button>\n";
  
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
    
    print "            <option value=\"\">- ". $hlp_link ." -</option>\n";
    
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
  
  
  print "    </form>\n";
  print "    <!-- Formular END -->\n";
  /* --- Formular END --- */
  print "  </div>\n";
  print "  \n";
  print "  \n";
  
  
  /* ---     --- */
  if ($in['alg'] == "") {
    print "  <!-- Leerzeile -->\n";
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
