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
})({"daFto":[function(require,module,exports) {
"use strict";

module.exports = JSON.parse("{\"name\":\"2x2x2\",\"orbits\":{\"CORNERS\":{\"numPieces\":8,\"orientations\":3}},\"startPieces\":{\"CORNERS\":{\"permutation\":[0,1,2,3,4,5,6,7],\"orientation\":[0,0,0,0,0,0,0,0]}},\"moves\":{\"U\":{\"CORNERS\":{\"permutation\":[1,2,3,0,4,5,6,7],\"orientation\":[0,0,0,0,0,0,0,0]}},\"y\":{\"CORNERS\":{\"permutation\":[1,2,3,0,7,4,5,6],\"orientation\":[0,0,0,0,0,0,0,0]}},\"x\":{\"CORNERS\":{\"permutation\":[4,0,3,5,7,6,2,1],\"orientation\":[2,1,2,1,1,2,1,2]}},\"L\":{\"CORNERS\":{\"permutation\":[0,1,6,2,4,3,5,7],\"orientation\":[0,0,2,1,0,2,1,0]}},\"F\":{\"CORNERS\":{\"permutation\":[3,1,2,5,0,4,6,7],\"orientation\":[1,0,0,2,2,1,0,0]}},\"R\":{\"CORNERS\":{\"permutation\":[4,0,2,3,7,5,6,1],\"orientation\":[2,1,0,0,1,0,0,2]}},\"B\":{\"CORNERS\":{\"permutation\":[0,7,1,3,4,5,2,6],\"orientation\":[0,2,1,0,0,0,2,1]}},\"D\":{\"CORNERS\":{\"permutation\":[0,1,2,3,5,6,7,4],\"orientation\":[0,0,0,0,0,0,0,0]}},\"z\":{\"CORNERS\":{\"permutation\":[3,2,6,5,0,4,7,1],\"orientation\":[1,2,1,2,2,1,2,1]}}}}");
},{}]},{},[], null, "parcelRequire0395")

//# sourceMappingURL=2x2x2.kpuzzle.88d8a229.js.map
