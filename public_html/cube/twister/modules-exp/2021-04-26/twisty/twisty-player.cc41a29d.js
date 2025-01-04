// modules are defined as an array
// [ module function, map of requires ]
//
// map of requires is short require name -> numeric require
//
// anything defined in a previous bundle is accessed via the
// orig method which is the require for previous bundles

(function(modules, cache, entry, mainEntry, parcelRequireName, globalName) {
  /* eslint-disable no-undef */
  var globalObject =
    typeof globalThis !== 'undefined'
      ? globalThis
      : typeof self !== 'undefined'
      ? self
      : typeof window !== 'undefined'
      ? window
      : typeof global !== 'undefined'
      ? global
      : {};
  /* eslint-enable no-undef */

  // Save the require from previous bundle to this closure if any
  var previousRequire =
    typeof globalObject[parcelRequireName] === 'function' &&
    globalObject[parcelRequireName];
  // Do not use `require` to prevent Webpack from trying to bundle this call
  var nodeRequire =
    typeof module !== 'undefined' &&
    typeof module.require === 'function' &&
    module.require.bind(module);

  function newRequire(name, jumped) {
    if (!cache[name]) {
      if (!modules[name]) {
        // if we cannot find the module within our internal map or
        // cache jump to the current global require ie. the last bundle
        // that was added to the page.
        var currentRequire =
          typeof globalObject[parcelRequireName] === 'function' &&
          globalObject[parcelRequireName];
        if (!jumped && currentRequire) {
          return currentRequire(name, true);
        }

        // If there are other bundles on this page the require from the
        // previous one is saved to 'previousRequire'. Repeat this as
        // many times as there are bundles until the module is found or
        // we exhaust the require chain.
        if (previousRequire) {
          return previousRequire(name, true);
        }

        // Try the node require function if it exists.
        if (nodeRequire && typeof name === 'string') {
          return nodeRequire(name);
        }

        var err = new Error("Cannot find module '" + name + "'");
        err.code = 'MODULE_NOT_FOUND';
        throw err;
      }

      localRequire.resolve = resolve;
      localRequire.cache = {};

      var module = (cache[name] = new newRequire.Module(name));

      modules[name][0].call(
        module.exports,
        localRequire,
        module,
        module.exports,
        this
      );
    }

    return cache[name].exports;

    function localRequire(x) {
      return newRequire(localRequire.resolve(x));
    }

    function resolve(x) {
      return modules[name][1][x] || x;
    }
  }

  function Module(moduleName) {
    this.id = moduleName;
    this.bundle = newRequire;
    this.exports = {};
  }

  newRequire.isParcelRequire = true;
  newRequire.Module = Module;
  newRequire.modules = modules;
  newRequire.cache = cache;
  newRequire.parent = previousRequire;
  newRequire.register = function(id, exports) {
    modules[id] = [
      function(require, module) {
        module.exports = exports;
      },
      {},
    ];
  };

  Object.defineProperty(newRequire, 'root', {
    get: function() {
      return globalObject[parcelRequireName];
    },
  });

  globalObject[parcelRequireName] = newRequire;

  for (var i = 0; i < entry.length; i++) {
    newRequire(entry[i]);
  }

  if (mainEntry) {
    // Expose entry point to Node, AMD or browser globals
    // Based on https://github.com/ForbesLindesay/umd/blob/master/template.js
    var mainExports = newRequire(mainEntry);

    // CommonJS
    if (typeof exports === 'object' && typeof module !== 'undefined') {
      module.exports = mainExports;

      // RequireJS
    } else if (typeof define === 'function' && define.amd) {
      define(function() {
        return mainExports;
      });

      // <script>
    } else if (globalName) {
      this[globalName] = mainExports;
    }
  }
})({"59kUU":[function(require,module,exports) {
"use strict";

//var _TwistyPlayerConfig = require("../../cubing/twisty/dom/TwistyPlayerConfig");
var _TwistyPlayerConfig = "";

//var _twisty = require("../../cubing/twisty");
var _twisty = "";

//var _TwistyViewerWrapper = require("../../cubing/twisty/dom/viewers/TwistyViewerWrapper");
var _TwistyViewerWrapper = "";

//var _alg = require("../../cubing/alg");
var _alg = "";

// TODO
const contentElem = document.querySelector(".content");
const twistyPlayer = new _twisty.TwistyPlayer();
contentElem.appendChild(twistyPlayer);
const table = contentElem.appendChild(document.createElement("table"));
const algOptions = [["alg", "alg", _alg.Alg.fromString("R U R'")], ["experimentalSetupAlg", "experimental-setup-alg", _alg.Alg.fromString("")]];

for (const [propName, attrName, alg] of algOptions) {
  const tr = table.appendChild(document.createElement("tr"));
  const td1 = tr.appendChild(document.createElement("td"));
  td1.appendChild(document.createElement("code")).textContent = attrName;
  const td2 = tr.appendChild(document.createElement("td"));
  const input = td2.appendChild(document.createElement("input"));
  input.value = alg.toString();
  input.placeholder = "(none)";

  const update = () => {
    twistyPlayer[propName] = _alg.Alg.fromString(input.value);
  };

  input.addEventListener("change", update);
  input.addEventListener("keyup", update);
  update();
} // // Puzzle
// "puzzle": StringEnumAttribute<PuzzleID>;
// "visualization": StringEnumAttribute<VisualizationFormat>;
// "hint-facelets": StringEnumAttribute<HintFaceletStyle>;
// "experimental-stickering": StringEnumAttribute<ExperimentalStickering>;
// // Background
// "background": StringEnumAttribute<BackgroundTheme>;
// "control-panel": StringEnumAttribute<ControlsLocation>;
// // 3D config
// "back-view": StringEnumAttribute<BackViewLayout>;
// "experimental-camera-position": Vector3Attribute;


const enumOptions = [["experimentalSetupAnchor", "experimental-setup-anchor", _TwistyPlayerConfig.setupToLocations], ["puzzle", "puzzle", _TwistyPlayerConfig.puzzleIDs], ["visualization", "visualization", _TwistyPlayerConfig.visualizationFormats], ["hintFacelets", "hint-facelets", _TwistyPlayerConfig.hintFaceletStyles], ["experimentalStickering", "experimental-stickering", _TwistyPlayerConfig.experimentalStickerings], ["background", "background", _TwistyPlayerConfig.backgroundThemes], ["controlPanel", "control-panel", _TwistyPlayerConfig.controlsLocations], ["backView", "back-view", _TwistyViewerWrapper.backViewLayouts], ["viewerLink", "viewer-link", _TwistyPlayerConfig.viewerLinkPages]];

for (const [propName, attrName, valueMap] of enumOptions) {
  const tr = table.appendChild(document.createElement("tr"));
  const td1 = tr.appendChild(document.createElement("td"));
  td1.appendChild(document.createElement("code")).textContent = attrName;
  const td2 = tr.appendChild(document.createElement("td"));
  const select = document.createElement("select");
  td2.appendChild(select);

  for (const value in valueMap) {
    const optionElem = select.appendChild(document.createElement("option"));
    optionElem.textContent = value;
    optionElem.value = value;
  }

  select.addEventListener("change", () => {
    console.log(attrName, select.value);
    twistyPlayer[propName] = select.value;
  });
  contentElem.append(document.createElement("br"));
}
//},{"../../cubing/twisty/dom/TwistyPlayerConfig":"4DCsT","../../cubing/twisty":"2X8fG","../../cubing/twisty/dom/viewers/TwistyViewerWrapper":"2w7nP","../../cubing/alg":"7Ff6b"}]},{},["59kUU"], "59kUU", "parcelRequire0395")
},{"":"4DCsT","":"2X8fG","":"2w7nP","":"7Ff6b"}]},{},["59kUU"], "59kUU", "parcelRequire0395")

//# sourceMappingURL=twisty-player.cc41a29d.js.map
