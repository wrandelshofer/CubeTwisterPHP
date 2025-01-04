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
})({"wg9aG":[function(require,module,exports) {
require('./bundle-manifest').register(JSON.parse("{\"7m6Fi\":\"twizzle.net/index.fd284134.js\",\"MI02Q\":\"puzzle-geometry.b4ff5f93.js\",\"7Dnmr\":\"puzzle-geometry.2c6f55a3.js\",\"6fslj\":\"2x2x2.kpuzzle.88d8a229.js\",\"6fdbU\":\"2x2x2.kpuzzle.svg.1b24c0ed.js\",\"ke5D9\":\"3x3x3.kpuzzle.svg.5230c40e.js\",\"6Lx8x\":\"3x3x3-ll.kpuzzle.svg.490932a0.js\",\"21lhS\":\"clock.kpuzzle.dbcba950.js\",\"3qrqW\":\"clock.kpuzzle.svg.b6b4f672.js\",\"3Ca18\":\"pyraminx.kpuzzle.5e2e0e6e.js\",\"6iD2j\":\"pyraminx.kpuzzle.svg.5c2c0159.js\",\"4tIk8\":\"sq1-hyperorbit.kpuzzle.ab1c65e6.js\",\"4mxTC\":\"sq1-hyperorbit.kpuzzle.svg.28117fdc.js\"}"));
},{"./bundle-manifest":"345Oh"}],"345Oh":[function(require,module,exports) {
"use strict";

var mapping = {};

function register(pairs) {
  var keys = Object.keys(pairs);

  for (var i = 0; i < keys.length; i++) {
    mapping[keys[i]] = pairs[keys[i]];
  }
}

function resolve(id) {
  var resolved = mapping[id];

  if (resolved == null) {
    throw new Error('Could not resolve bundle with id ' + id);
  }

  return resolved;
}

module.exports.register = register;
module.exports.resolve = resolve;
},{}],"KrRHt":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
Object.defineProperty(exports, "experimentalCube3x3x3KPuzzle", {
  enumerable: true,
  get: function () {
    return _x3x3Kpuzzle.cube3x3x3KPuzzle;
  }
});
Object.defineProperty(exports, "cube2x2x2", {
  enumerable: true,
  get: function () {
    return _x2x.cube2x2x2;
  }
});
Object.defineProperty(exports, "cube3x3x3", {
  enumerable: true,
  get: function () {
    return _x3x.cube3x3x3;
  }
});
Object.defineProperty(exports, "experimentalGetFaceletAppearance", {
  enumerable: true,
  get: function () {
    return _appearance.getFaceletAppearance;
  }
});
exports.puzzles = void 0;

var _x3x3Kpuzzle = require("./implementations/3x3x3/3x3x3.kpuzzle.json_");

var _asyncPg3d = require("./async/async-pg3d");

var _x2x = require("./implementations/2x2x2");

var _x3x = require("./implementations/3x3x3");

var _clock = require("./implementations/clock");

var _fto = require("./implementations/fto");

var _megaminx = require("./implementations/megaminx");

var _pyraminx = require("./implementations/pyraminx");

var _square = require("./implementations/square1");

var _appearance = require("./stickerings/appearance");

const puzzles = {
  /******** Start of WCA Puzzles *******/
  "3x3x3": _x3x.cube3x3x3,
  "2x2x2": _x2x.cube2x2x2,
  "4x4x4": (0, _asyncPg3d.cubePGPuzzleLoader)("4x4x4", "4×4×4 Cube"),
  "5x5x5": (0, _asyncPg3d.cubePGPuzzleLoader)("5x5x5", "5×5×5 Cube"),
  "6x6x6": (0, _asyncPg3d.cubePGPuzzleLoader)("6x6x6", "6×6×6 Cube"),
  "7x7x7": (0, _asyncPg3d.cubePGPuzzleLoader)("7x7x7", "7×7×7 Cube"),
  "40x40x40": (0, _asyncPg3d.cubePGPuzzleLoader)("40x40x40", "40×40×40 Cube"),
  // 3x3x3 Blindfolded
  // 3x3x3 Fewest Moves
  // 3x3x3 One-Handed
  clock: _clock.clock,
  "megaminx": _megaminx.megaminx,
  pyraminx: _pyraminx.pyraminx,
  "skewb": (0, _asyncPg3d.genericPGPuzzleLoader)("skewb", "Skewb", {
    inventedBy: ["Tony Durham"] // https://www.jaapsch.net/puzzles/skewb.htm
    // inventionYear: 1982, // 1982 is actually the year of Hofstadter's column.

  }),
  square1: _square.square1,
  // 4x4x4 Blindfolded
  // 5x5x5 Blindfolded

  /******** End of WCA puzzles ********/
  "fto": _fto.fto,
  "gigaminx": (0, _asyncPg3d.genericPGPuzzleLoader)("gigaminx", "Gigaminx", {
    inventedBy: ["Tyler Fox"],
    inventionYear: 2006 // Earliest date from https://www.twistypuzzles.com/cgi-bin/puzzle.cgi?pkey=1475

  })
}; // // TODO: find a better way to share these defs.
// for (const puzzleName of [
//   // "2x2x2",
//   // "3x3x3",
//   "4x4x4",
//   "5x5x5",
//   "6x6x6",
//   "7x7x7",
//   "8x8x8",
//   "9x9x9",
//   "10x10x10",
//   "11x11x11",
//   "12x12x12",
//   "13x13x13",
//   "20x20x20",
//   "30x30x30",
//   // "skewb",
//   "master skewb",
//   "professor skewb",
//   "compy cube",
//   "helicopter",
//   "curvy copter",
//   "dino",
//   "little chop",
//   "pyramorphix",
//   "mastermorphix",
//   "pyraminx",
//   "master pyraminx",
//   "professor pyraminx",
//   "Jing pyraminx",
//   "master pyramorphix",
//   // "megaminx",
//   "gigaminx",
//   "pentultimate",
//   "starminx",
//   "starminx 2",
//   "pyraminx crystal",
//   "chopasaurus",
//   "big chop",
//   "skewb diamond",
//   // "FTO",
//   "Christopher's jewel",
//   "octastar",
//   "Trajber's octahedron",
//   "radio chop",
//   "icosamate",
//   "icosahedron 2",
//   "icosahedron 3",
//   "icosahedron static faces",
//   "icosahedron moving faces",
//   "Eitan's star",
//   "2x2x2 + dino",
//   "2x2x2 + little chop",
//   "dino + little chop",
//   "2x2x2 + dino + little chop",
//   "megaminx + chopasaurus",
//   "starminx combo",
// ]) {
//   if (!(puzzleName in puzzles)) {
//     puzzles[puzzleName] = {
//       id: puzzleName,
//       fullName: `${puzzleName} (PG3D)`,
//       def: async () => {
//         return asyncGetDef(puzzleName);
//       },
//       svg: async () => {
//         throw "Unimplemented!";
//       },
//       pg3d: async () => {
//         return asyncGetPuzzleGeometry(puzzleName);
//       },
//     };
//   }
// }

exports.puzzles = puzzles;
},{"./implementations/3x3x3/3x3x3.kpuzzle.json_":"6pVNo","./async/async-pg3d":"2rjP0","./implementations/2x2x2":"4tzuE","./implementations/3x3x3":"3PKaG","./implementations/clock":"1Gu9H","./implementations/fto":"116IH","./implementations/megaminx":"6MldX","./implementations/pyraminx":"7eESQ","./implementations/square1":"1UC88","./stickerings/appearance":"7LP72"}],"6pVNo":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.cube3x3x3KPuzzle = void 0;
// TODO: this would be a raw `.json` file, but Parcel runs into an error from
// using that as both a sync and async import. Probably https://github.com/parcel-bundler/parcel/issues/2546
const cube3x3x3KPuzzle = {
  name: "3x3x3",
  orbits: {
    EDGES: {
      numPieces: 12,
      orientations: 2
    },
    CORNERS: {
      numPieces: 8,
      orientations: 3
    },
    CENTERS: {
      numPieces: 6,
      orientations: 4
    }
  },
  startPieces: {
    EDGES: {
      permutation: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
      orientation: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    },
    CORNERS: {
      permutation: [0, 1, 2, 3, 4, 5, 6, 7],
      orientation: [0, 0, 0, 0, 0, 0, 0, 0]
    },
    CENTERS: {
      permutation: [0, 1, 2, 3, 4, 5],
      orientation: [0, 0, 0, 0, 0, 0]
    }
  },
  moves: {
    U: {
      EDGES: {
        permutation: [1, 2, 3, 0, 4, 5, 6, 7, 8, 9, 10, 11],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      },
      CORNERS: {
        permutation: [1, 2, 3, 0, 4, 5, 6, 7],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0]
      },
      CENTERS: {
        permutation: [0, 1, 2, 3, 4, 5],
        orientation: [1, 0, 0, 0, 0, 0]
      }
    },
    y: {
      EDGES: {
        permutation: [1, 2, 3, 0, 5, 6, 7, 4, 10, 8, 11, 9],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1]
      },
      CORNERS: {
        permutation: [1, 2, 3, 0, 7, 4, 5, 6],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0]
      },
      CENTERS: {
        permutation: [0, 2, 3, 4, 1, 5],
        orientation: [1, 0, 0, 0, 0, 3]
      }
    },
    x: {
      EDGES: {
        permutation: [4, 8, 0, 9, 6, 10, 2, 11, 5, 7, 1, 3],
        orientation: [1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0]
      },
      CORNERS: {
        permutation: [4, 0, 3, 5, 7, 6, 2, 1],
        orientation: [2, 1, 2, 1, 1, 2, 1, 2]
      },
      CENTERS: {
        permutation: [2, 1, 5, 3, 0, 4],
        orientation: [0, 3, 0, 1, 2, 2]
      }
    },
    L: {
      EDGES: {
        permutation: [0, 1, 2, 11, 4, 5, 6, 9, 8, 3, 10, 7],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      },
      CORNERS: {
        permutation: [0, 1, 6, 2, 4, 3, 5, 7],
        orientation: [0, 0, 2, 1, 0, 2, 1, 0]
      },
      CENTERS: {
        permutation: [0, 1, 2, 3, 4, 5],
        orientation: [0, 1, 0, 0, 0, 0]
      }
    },
    F: {
      EDGES: {
        permutation: [9, 1, 2, 3, 8, 5, 6, 7, 0, 4, 10, 11],
        orientation: [1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0]
      },
      CORNERS: {
        permutation: [3, 1, 2, 5, 0, 4, 6, 7],
        orientation: [1, 0, 0, 2, 2, 1, 0, 0]
      },
      CENTERS: {
        permutation: [0, 1, 2, 3, 4, 5],
        orientation: [0, 0, 1, 0, 0, 0]
      }
    },
    R: {
      EDGES: {
        permutation: [0, 8, 2, 3, 4, 10, 6, 7, 5, 9, 1, 11],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      },
      CORNERS: {
        permutation: [4, 0, 2, 3, 7, 5, 6, 1],
        orientation: [2, 1, 0, 0, 1, 0, 0, 2]
      },
      CENTERS: {
        permutation: [0, 1, 2, 3, 4, 5],
        orientation: [0, 0, 0, 1, 0, 0]
      }
    },
    B: {
      EDGES: {
        permutation: [0, 1, 10, 3, 4, 5, 11, 7, 8, 9, 6, 2],
        orientation: [0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 1]
      },
      CORNERS: {
        permutation: [0, 7, 1, 3, 4, 5, 2, 6],
        orientation: [0, 2, 1, 0, 0, 0, 2, 1]
      },
      CENTERS: {
        permutation: [0, 1, 2, 3, 4, 5],
        orientation: [0, 0, 0, 0, 1, 0]
      }
    },
    D: {
      EDGES: {
        permutation: [0, 1, 2, 3, 7, 4, 5, 6, 8, 9, 10, 11],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      },
      CORNERS: {
        permutation: [0, 1, 2, 3, 5, 6, 7, 4],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0]
      },
      CENTERS: {
        permutation: [0, 1, 2, 3, 4, 5],
        orientation: [0, 0, 0, 0, 0, 1]
      }
    },
    z: {
      EDGES: {
        permutation: [9, 3, 11, 7, 8, 1, 10, 5, 0, 4, 2, 6],
        orientation: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1]
      },
      CORNERS: {
        permutation: [3, 2, 6, 5, 0, 4, 7, 1],
        orientation: [1, 2, 1, 2, 2, 1, 2, 1]
      },
      CENTERS: {
        permutation: [1, 5, 2, 0, 4, 3],
        orientation: [1, 1, 1, 1, 3, 1]
      }
    },
    M: {
      EDGES: {
        permutation: [2, 1, 6, 3, 0, 5, 4, 7, 8, 9, 10, 11],
        orientation: [1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0]
      },
      CORNERS: {
        permutation: [0, 1, 2, 3, 4, 5, 6, 7],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0]
      },
      CENTERS: {
        permutation: [4, 1, 0, 3, 5, 2],
        orientation: [2, 0, 0, 0, 2, 0]
      }
    },
    E: {
      EDGES: {
        permutation: [0, 1, 2, 3, 4, 5, 6, 7, 9, 11, 8, 10],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1]
      },
      CORNERS: {
        permutation: [0, 1, 2, 3, 4, 5, 6, 7],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0]
      },
      CENTERS: {
        permutation: [0, 4, 1, 2, 3, 5],
        orientation: [0, 0, 0, 0, 0, 0]
      }
    },
    S: {
      EDGES: {
        permutation: [0, 3, 2, 7, 4, 1, 6, 5, 8, 9, 10, 11],
        orientation: [0, 1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0]
      },
      CORNERS: {
        permutation: [0, 1, 2, 3, 4, 5, 6, 7],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0]
      },
      CENTERS: {
        permutation: [1, 5, 2, 0, 4, 3],
        orientation: [1, 1, 0, 1, 0, 1]
      }
    },
    u: {
      EDGES: {
        permutation: [1, 2, 3, 0, 4, 5, 6, 7, 10, 8, 11, 9],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1]
      },
      CORNERS: {
        permutation: [1, 2, 3, 0, 4, 5, 6, 7],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0]
      },
      CENTERS: {
        permutation: [0, 2, 3, 4, 1, 5],
        orientation: [1, 0, 0, 0, 0, 0]
      }
    },
    l: {
      EDGES: {
        permutation: [2, 1, 6, 11, 0, 5, 4, 9, 8, 3, 10, 7],
        orientation: [1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0]
      },
      CORNERS: {
        permutation: [0, 1, 6, 2, 4, 3, 5, 7],
        orientation: [0, 0, 2, 1, 0, 2, 1, 0]
      },
      CENTERS: {
        permutation: [4, 1, 0, 3, 5, 2],
        orientation: [2, 1, 0, 0, 2, 0]
      }
    },
    f: {
      EDGES: {
        permutation: [9, 3, 2, 7, 8, 1, 6, 5, 0, 4, 10, 11],
        orientation: [1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0]
      },
      CORNERS: {
        permutation: [3, 1, 2, 5, 0, 4, 6, 7],
        orientation: [1, 0, 0, 2, 2, 1, 0, 0]
      },
      CENTERS: {
        permutation: [1, 5, 2, 0, 4, 3],
        orientation: [1, 1, 1, 1, 0, 1]
      }
    },
    r: {
      EDGES: {
        permutation: [4, 8, 0, 3, 6, 10, 2, 7, 5, 9, 1, 11],
        orientation: [1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0]
      },
      CORNERS: {
        permutation: [4, 0, 2, 3, 7, 5, 6, 1],
        orientation: [2, 1, 0, 0, 1, 0, 0, 2]
      },
      CENTERS: {
        permutation: [2, 1, 5, 3, 0, 4],
        orientation: [0, 0, 0, 1, 2, 2]
      }
    },
    b: {
      EDGES: {
        permutation: [8, 5, 2, 1, 9, 7, 6, 3, 4, 0, 10, 11],
        orientation: [1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0]
      },
      CORNERS: {
        permutation: [4, 1, 2, 0, 5, 3, 6, 7],
        orientation: [1, 0, 0, 2, 2, 1, 0, 0]
      },
      CENTERS: {
        permutation: [3, 0, 2, 5, 4, 1],
        orientation: [3, 3, 3, 3, 0, 3]
      }
    },
    d: {
      EDGES: {
        permutation: [0, 1, 2, 3, 7, 4, 5, 6, 9, 11, 8, 10],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1]
      },
      CORNERS: {
        permutation: [0, 1, 2, 3, 5, 6, 7, 4],
        orientation: [0, 0, 0, 0, 0, 0, 0, 0]
      },
      CENTERS: {
        permutation: [0, 4, 1, 2, 3, 5],
        orientation: [0, 0, 0, 0, 0, 1]
      }
    }
  }
};
exports.cube3x3x3KPuzzle = cube3x3x3KPuzzle;
cube3x3x3KPuzzle.moves["Uw"] = cube3x3x3KPuzzle.moves["u"];
cube3x3x3KPuzzle.moves["Lw"] = cube3x3x3KPuzzle.moves["l"];
cube3x3x3KPuzzle.moves["Fw"] = cube3x3x3KPuzzle.moves["f"];
cube3x3x3KPuzzle.moves["Rw"] = cube3x3x3KPuzzle.moves["r"];
cube3x3x3KPuzzle.moves["Bw"] = cube3x3x3KPuzzle.moves["b"];
cube3x3x3KPuzzle.moves["Dw"] = cube3x3x3KPuzzle.moves["d"];
},{}],"2rjP0":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.asyncGetPuzzleGeometry = asyncGetPuzzleGeometry;
exports.asyncGetDef = asyncGetDef;
exports.genericPGPuzzleLoader = genericPGPuzzleLoader;
exports.cubePGPuzzleLoader = cubePGPuzzleLoader;

var _interopRequireWildcard2 = _interopRequireDefault(require("@babel/runtime/helpers/interopRequireWildcard"));

var _cubeStickerings = require("../stickerings/cube-stickerings");

// TODO: modify this to handle TwistyPlayer options
async function asyncGetPuzzleGeometry(puzzleName) {
  const puzzleGeometry = await Promise.resolve().then(() => require("../../puzzle-geometry")).then($parcel$75ad => (0, _interopRequireWildcard2.default)($parcel$75ad));
  return puzzleGeometry.getPuzzleGeometryByName(puzzleName, ["allmoves", "true", "orientcenters", "true", "rotations", "true"]);
} // TODO: can we cache the puzzleGeometry to avoid duplicate calls, without
// wasting memory? Maybe just save the latest one for successive calls about the
// same puzzle?


async function asyncGetDef(puzzleName) {
  return (await asyncGetPuzzleGeometry(puzzleName)).writekpuzzle(true);
}

function genericPGPuzzleLoader(id, fullName, info) {
  const puzzleLoader = {
    id: id,
    fullName: fullName,
    def: async () => {
      return asyncGetDef(id);
    },
    svg: async () => {
      const pg = await asyncGetPuzzleGeometry(id);
      return pg.generatesvg();
    },
    pg: async () => {
      return asyncGetPuzzleGeometry(id);
    }
  };

  if (info === null || info === void 0 ? void 0 : info.inventedBy) {
    puzzleLoader.inventedBy = info.inventedBy;
  }

  if (info === null || info === void 0 ? void 0 : info.inventionYear) {
    puzzleLoader.inventionYear = info.inventionYear;
  }

  return puzzleLoader;
}

function cubePGPuzzleLoader(id, fullName, info) {
  const puzzleLoader = genericPGPuzzleLoader(id, fullName, info);
  puzzleLoader.appearance = _cubeStickerings.cubeAppearance.bind(_cubeStickerings.cubeAppearance, puzzleLoader);
  puzzleLoader.stickerings = _cubeStickerings.cubeStickerings;
  return puzzleLoader;
}
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/interopRequireWildcard":"6tmXR","../stickerings/cube-stickerings":"4zcrv","../../puzzle-geometry":"6zX65"}],"6tmXR":[function(require,module,exports) {
var _typeof = require("@babel/runtime/helpers/typeof");

function _getRequireWildcardCache() {
  if (typeof WeakMap !== "function") return null;
  var cache = new WeakMap();

  _getRequireWildcardCache = function _getRequireWildcardCache() {
    return cache;
  };

  return cache;
}

function _interopRequireWildcard(obj) {
  if (obj && obj.__esModule) {
    return obj;
  }

  if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") {
    return {
      "default": obj
    };
  }

  var cache = _getRequireWildcardCache();

  if (cache && cache.has(obj)) {
    return cache.get(obj);
  }

  var newObj = {};
  var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor;

  for (var key in obj) {
    if (Object.prototype.hasOwnProperty.call(obj, key)) {
      var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null;

      if (desc && (desc.get || desc.set)) {
        Object.defineProperty(newObj, key, desc);
      } else {
        newObj[key] = obj[key];
      }
    }
  }

  newObj["default"] = obj;

  if (cache) {
    cache.set(obj, newObj);
  }

  return newObj;
}

module.exports = _interopRequireWildcard;
},{"@babel/runtime/helpers/typeof":"2Lilv"}],"2Lilv":[function(require,module,exports) {
function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

module.exports = _typeof;
},{}],"4zcrv":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.cubeAppearance = cubeAppearance;
exports.cubeStickerings = cubeStickerings;

var _appearance = require("./appearance");

// TODO: cache calculations?
async function cubeAppearance(puzzleLoader, stickering) {
  const def = await puzzleLoader.def();
  const puzzleStickering = new _appearance.PuzzleStickering(def);
  const m = new _appearance.StickeringManager(def);

  const LL = () => m.move("U");

  const orUD = () => m.or(m.moves(["U", "D"]));

  const E = () => m.not(orUD());

  const orLR = () => m.or(m.moves(["L", "R"]));

  const M = () => m.not(orLR());

  const orFB = () => m.or(m.moves(["F", "B"]));

  const S = () => m.not(orFB());

  const F2L = () => m.not(LL());

  const centerU = () => m.and([LL(), M(), S()]);

  const edgeFR = () => m.and([m.and(m.moves(["F", "R"])), m.not(orUD())]);

  const cornerDFR = () => m.and(m.moves(["D", "R", "F"]));

  const slotFR = () => m.or([cornerDFR(), edgeFR()]);

  const CENTERS = () => m.or([m.and([M(), E()]), m.and([M(), S()]), m.and([E(), S()])]);

  const EDGES = () => m.or([m.and([M(), orUD(), orFB()]), m.and([E(), orLR(), orFB()]), m.and([S(), orUD(), orLR()])]);

  const CORNERS = () => m.not(m.or([CENTERS(), EDGES()]));

  const L6E = () => m.or([M(), m.and([LL(), EDGES()])]);

  function dimF2L() {
    puzzleStickering.set(F2L(), _appearance.PieceStickering.Dim);
  }

  function setPLL() {
    puzzleStickering.set(LL(), _appearance.PieceStickering.PermuteNonPrimary);
    puzzleStickering.set(centerU(), _appearance.PieceStickering.Dim); // TODO: why is this needed?
  }

  function setOLL() {
    puzzleStickering.set(LL(), _appearance.PieceStickering.IgnoreNonPrimary);
    puzzleStickering.set(centerU(), _appearance.PieceStickering.Regular); // TODO: why is this needed?
  }

  function dimOLL() {
    puzzleStickering.set(LL(), _appearance.PieceStickering.Ignoriented);
    puzzleStickering.set(centerU(), _appearance.PieceStickering.Dim); // TODO: why is this needed?
  }

  switch (stickering) {
    case "full":
      break;

    case "PLL":
      dimF2L();
      setPLL();
      break;

    case "CLS":
      dimF2L();
      puzzleStickering.set(m.and(m.moves(["D", "R", "F"])), _appearance.PieceStickering.Regular);
      puzzleStickering.set(LL(), _appearance.PieceStickering.Ignoriented);
      puzzleStickering.set(m.and([LL(), CORNERS()]), _appearance.PieceStickering.IgnoreNonPrimary);
      break;

    case "OLL":
      dimF2L();
      setOLL();
      break;

    case "COLL":
      dimF2L();
      setPLL();
      puzzleStickering.set(m.and([LL(), CORNERS()]), _appearance.PieceStickering.Regular);
      break;

    case "OCLL":
      dimF2L();
      dimOLL();
      puzzleStickering.set(m.and([LL(), CORNERS()]), _appearance.PieceStickering.IgnoreNonPrimary);
      break;

    case "CLL":
      dimF2L();
      puzzleStickering.set(m.not(m.and([CORNERS(), LL()])), _appearance.PieceStickering.Dim);
      break;

    case "ELL":
      dimF2L();
      puzzleStickering.set(LL(), _appearance.PieceStickering.Dim);
      puzzleStickering.set(m.and([LL(), EDGES()]), _appearance.PieceStickering.Regular);
      break;

    case "ELS":
      dimF2L();
      setOLL();
      puzzleStickering.set(m.and([LL(), CORNERS()]), _appearance.PieceStickering.Ignored);
      puzzleStickering.set(edgeFR(), _appearance.PieceStickering.Regular);
      puzzleStickering.set(cornerDFR(), _appearance.PieceStickering.Ignored);
      break;

    case "LL":
      dimF2L();
      break;

    case "F2L":
      puzzleStickering.set(LL(), _appearance.PieceStickering.Ignored);
      break;

    case "ZBLL":
      dimF2L();
      puzzleStickering.set(LL(), _appearance.PieceStickering.PermuteNonPrimary);
      puzzleStickering.set(centerU(), _appearance.PieceStickering.Dim); // why is this needed?

      puzzleStickering.set(m.and([LL(), CORNERS()]), _appearance.PieceStickering.Regular);
      break;

    case "ZBLS":
      dimF2L();
      puzzleStickering.set(slotFR(), _appearance.PieceStickering.Regular);
      setOLL();
      puzzleStickering.set(m.and([LL(), CORNERS()]), _appearance.PieceStickering.Ignored);
      break;

    case "WVLS": // fallthrough

    case "VLS":
      dimF2L();
      puzzleStickering.set(slotFR(), _appearance.PieceStickering.Regular);
      setOLL();
      break;

    case "LS":
      dimF2L();
      puzzleStickering.set(slotFR(), _appearance.PieceStickering.Regular);
      puzzleStickering.set(LL(), _appearance.PieceStickering.Ignored);
      puzzleStickering.set(centerU(), _appearance.PieceStickering.Dim);
      break;

    case "EO":
      puzzleStickering.set(CORNERS(), _appearance.PieceStickering.Ignored);
      puzzleStickering.set(EDGES(), _appearance.PieceStickering.OrientationWithoutPermutation);
      break;

    case "CMLL":
      puzzleStickering.set(F2L(), _appearance.PieceStickering.Dim);
      puzzleStickering.set(L6E(), _appearance.PieceStickering.Ignored);
      puzzleStickering.set(m.and([LL(), CORNERS()]), _appearance.PieceStickering.Regular);
      break;

    case "L6E":
      puzzleStickering.set(m.not(L6E()), _appearance.PieceStickering.Dim);
      break;

    case "L6EO":
      puzzleStickering.set(m.not(L6E()), _appearance.PieceStickering.Dim);
      puzzleStickering.set(L6E(), _appearance.PieceStickering.OrientationWithoutPermutation);
      puzzleStickering.set(m.and([CENTERS(), orUD()]), _appearance.PieceStickering.OrientationStickers); // TODO: why is this needed?

      break;

    case "Daisy":
      puzzleStickering.set(m.all(), _appearance.PieceStickering.Ignored);
      puzzleStickering.set(CENTERS(), _appearance.PieceStickering.Dim);
      puzzleStickering.set(m.and([m.move("D"), CENTERS()]), _appearance.PieceStickering.Regular);
      puzzleStickering.set(m.and([m.move("U"), EDGES()]), _appearance.PieceStickering.IgnoreNonPrimary);
      break;

    case "Cross":
      puzzleStickering.set(m.all(), _appearance.PieceStickering.Ignored);
      puzzleStickering.set(CENTERS(), _appearance.PieceStickering.Dim);
      puzzleStickering.set(m.and([m.move("D"), CENTERS()]), _appearance.PieceStickering.Regular);
      puzzleStickering.set(m.and([m.move("D"), EDGES()]), _appearance.PieceStickering.Regular);
      break;

    case "2x2x2":
      puzzleStickering.set(m.or(m.moves(["U", "F", "R"])), _appearance.PieceStickering.Ignored);
      puzzleStickering.set(m.and([m.or(m.moves(["U", "F", "R"])), CENTERS()]), _appearance.PieceStickering.Dim);
      break;

    case "2x2x3":
      puzzleStickering.set(m.all(), _appearance.PieceStickering.Dim);
      puzzleStickering.set(m.or(m.moves(["U", "F", "R"])), _appearance.PieceStickering.Ignored);
      puzzleStickering.set(m.and([m.or(m.moves(["U", "F", "R"])), CENTERS()]), _appearance.PieceStickering.Dim);
      puzzleStickering.set(m.and([m.move("F"), m.not(m.or(m.moves(["U", "R"])))]), _appearance.PieceStickering.Regular);
      break;

    case "Void Cube":
      puzzleStickering.set(CENTERS(), _appearance.PieceStickering.Invisible);
      break;

    case "picture": // fallthrough

    case "invisible":
      puzzleStickering.set(m.all(), _appearance.PieceStickering.Invisible);
      break;

    case "centers-only":
      puzzleStickering.set(m.not(CENTERS()), _appearance.PieceStickering.Ignored);
      break;

    default:
      console.warn(`Unsupported stickering for ${puzzleLoader.id}: ${stickering}. Setting all pieces to dim.`);
      puzzleStickering.set(m.and(m.moves([])), _appearance.PieceStickering.Dim);
  }

  return puzzleStickering.toAppearance();
}

async function cubeStickerings() {
  return ["full", "PLL", "CLS", "OLL", "COLL", "OCLL", "ELL", "ELS", "LL", "F2L", "ZBLL", "ZBLS", "WVLS", "VLS", "LS", "EO", "CMLL", "L6E", "L6EO", "Daisy", "Cross", "2x2x2", "2x2x3", "Void Cube", "picture", "invisible", "centers-only"];
}
},{"./appearance":"7LP72"}],"7LP72":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.getFaceletAppearance = getFaceletAppearance;
exports.getPieceAppearance = getPieceAppearance;
exports.StickeringManager = exports.PuzzleStickering = exports.PieceAnnotation = exports.PieceStickering = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _alg = require("../../alg");

var _kpuzzle = require("../../kpuzzle");

// TODO: figure out where to house this permanently.
function getFaceletAppearance(appearance, orbitName, pieceIdx, faceletIdx, hint) {
  const orbitAppearance = appearance.orbits[orbitName];
  const pieceAppearance = orbitAppearance.pieces[pieceIdx];

  if (pieceAppearance === null) {
    return regular;
  }

  const faceletAppearance = pieceAppearance.facelets[faceletIdx];

  if (faceletAppearance === null) {
    return regular;
  }

  if (typeof faceletAppearance === "string") {
    return faceletAppearance;
  }

  if (hint) {
    var _faceletAppearance$hi;

    return (_faceletAppearance$hi = faceletAppearance.hintAppearance) !== null && _faceletAppearance$hi !== void 0 ? _faceletAppearance$hi : faceletAppearance.appearance;
  }

  return faceletAppearance.appearance;
}

let PieceStickering;
exports.PieceStickering = PieceStickering;

(function (PieceStickering) {
  PieceStickering[PieceStickering["Regular"] = 0] = "Regular";
  PieceStickering[PieceStickering["Dim"] = 1] = "Dim";
  PieceStickering[PieceStickering["Ignored"] = 2] = "Ignored";
  PieceStickering[PieceStickering["OrientationStickers"] = 3] = "OrientationStickers";
  PieceStickering[PieceStickering["Invisible"] = 4] = "Invisible";
  PieceStickering[PieceStickering["Ignoriented"] = 5] = "Ignoriented";
  PieceStickering[PieceStickering["IgnoreNonPrimary"] = 6] = "IgnoreNonPrimary";
  PieceStickering[PieceStickering["PermuteNonPrimary"] = 7] = "PermuteNonPrimary";
  PieceStickering[PieceStickering["OrientationWithoutPermutation"] = 8] = "OrientationWithoutPermutation";
})(PieceStickering || (exports.PieceStickering = PieceStickering = {}));

class PieceAnnotation {
  constructor(def, defaultValue) {
    (0, _defineProperty2.default)(this, "stickerings", new Map());

    for (const [orbitName, orbitDef] of Object.entries(def.orbits)) {
      this.stickerings.set(orbitName, new Array(orbitDef.numPieces).fill(defaultValue));
    }
  }

}

exports.PieceAnnotation = PieceAnnotation;
const regular = "regular";
const ignored = "ignored";
const oriented = "oriented";
const invisible = "invisible";
const dim = "dim"; // regular

const r = {
  facelets: [regular, regular, regular, regular, regular]
}; // ignored

const i = {
  facelets: [ignored, ignored, ignored, ignored, ignored]
}; // oriented stickers

const o = {
  facelets: [oriented, oriented, oriented, oriented, oriented]
}; // invisible

const invisiblePiece = {
  facelets: [invisible, invisible, invisible, invisible] // TODO: 4th entry is for void cube. Should be handled properly for all stickerings.

}; // "OLL"

const riiii = {
  facelets: [regular, ignored, ignored, ignored, ignored]
}; // "PLL"

const drrrr = {
  facelets: [dim, regular, regular, regular, regular]
}; // ignored

const d = {
  facelets: [dim, dim, dim, dim, dim]
}; // "OLL"

const diiii = {
  facelets: [dim, ignored, ignored, ignored, ignored]
}; // oriented

const oiiii = {
  facelets: [oriented, ignored, ignored, ignored, ignored]
};

function getPieceAppearance(pieceStickering) {
  switch (pieceStickering) {
    case PieceStickering.Regular:
      return r;

    case PieceStickering.Dim:
      return d;

    case PieceStickering.Ignored:
      return i;

    case PieceStickering.OrientationStickers:
      // TODO: Hack for centers. This shouldn't be needed.
      return o;

    case PieceStickering.Invisible:
      // TODO: Hack for centers. This shouldn't be needed.
      return invisiblePiece;

    case PieceStickering.IgnoreNonPrimary:
      return riiii;

    case PieceStickering.PermuteNonPrimary:
      return drrrr;

    case PieceStickering.Ignoriented:
      return diiii;

    case PieceStickering.OrientationWithoutPermutation:
      return oiiii;
  }
}

class PuzzleStickering extends PieceAnnotation {
  constructor(def) {
    super(def, PieceStickering.Regular);
  }

  set(pieceSet, pieceStickering) {
    for (const [orbitName, pieces] of this.stickerings.entries()) {
      for (let i = 0; i < pieces.length; i++) {
        if (pieceSet.stickerings.get(orbitName)[i]) {
          pieces[i] = pieceStickering;
        }
      }
    }

    return this;
  }

  toAppearance() {
    const appearance = {
      orbits: {}
    };

    for (const [orbitName, pieceStickerings] of this.stickerings.entries()) {
      const pieces = [];
      const orbitAppearance = {
        pieces
      };
      appearance.orbits[orbitName] = orbitAppearance;

      for (const pieceStickering of pieceStickerings) {
        pieces.push(getPieceAppearance(pieceStickering));
      }
    }

    return appearance;
  }

}

exports.PuzzleStickering = PuzzleStickering;

class StickeringManager {
  constructor(def) {
    this.def = def;
  }

  and(pieceSets) {
    const newPieceSet = new PieceAnnotation(this.def, false);

    for (const [orbitName, orbitDef] of Object.entries(this.def.orbits)) {
      pieceLoop: for (let i = 0; i < orbitDef.numPieces; i++) {
        newPieceSet.stickerings.get(orbitName)[i] = true;

        for (const pieceSet of pieceSets) {
          if (!pieceSet.stickerings.get(orbitName)[i]) {
            newPieceSet.stickerings.get(orbitName)[i] = false;
            continue pieceLoop;
          }
        }
      }
    }

    return newPieceSet;
  }

  or(pieceSets) {
    // TODO: unify impl with and?
    const newPieceSet = new PieceAnnotation(this.def, false);

    for (const [orbitName, orbitDef] of Object.entries(this.def.orbits)) {
      pieceLoop: for (let i = 0; i < orbitDef.numPieces; i++) {
        newPieceSet.stickerings.get(orbitName)[i] = false;

        for (const pieceSet of pieceSets) {
          if (pieceSet.stickerings.get(orbitName)[i]) {
            newPieceSet.stickerings.get(orbitName)[i] = true;
            continue pieceLoop;
          }
        }
      }
    }

    return newPieceSet;
  }

  not(pieceSet) {
    const newPieceSet = new PieceAnnotation(this.def, false);

    for (const [orbitName, orbitDef] of Object.entries(this.def.orbits)) {
      for (let i = 0; i < orbitDef.numPieces; i++) {
        newPieceSet.stickerings.get(orbitName)[i] = !pieceSet.stickerings.get(orbitName)[i];
      }
    }

    return newPieceSet;
  }

  all() {
    return this.and(this.moves([])); // TODO: are the degenerate cases for and/or the wrong way around
  }

  move(moveSource) {
    const transformation = (0, _kpuzzle.transformationForMove)(this.def, (0, _alg.experimentalIs)(moveSource, _alg.Move) ? moveSource : _alg.Move.fromString(moveSource));
    const newPieceSet = new PieceAnnotation(this.def, false);

    for (const [orbitName, orbitDef] of Object.entries(this.def.orbits)) {
      for (let i = 0; i < orbitDef.numPieces; i++) {
        if (transformation[orbitName].permutation[i] !== i || transformation[orbitName].orientation[i] !== 0) {
          newPieceSet.stickerings.get(orbitName)[i] = true;
        }
      }
    }

    return newPieceSet;
  }

  moves(moveSources) {
    return moveSources.map(moveSource => this.move(moveSource));
  } // orbits(orbitNames: string[]): PieceSet {
  //   const pieceSet = new PieceAnnotation<boolean>(this.def, false);
  //   for (const orbitName of orbitNames) {
  //     pieceSet.stickerings.get(orbitName)!.fill(true);
  //   }
  //   return pieceSet;
  // }
  // trueCounts(pieceSet: PieceSet): Record<string, number> {
  //   const counts: Record<string, number> = {};
  //   for (const [orbitName, orbitDef] of Object.entries(this.def.orbits)) {
  //     let count = 0;
  //     for (let i = 0; i < orbitDef.numPieces; i++) {
  //       if (pieceSet.stickerings.get(orbitName)![i]) {
  //         count++;
  //       }
  //     }
  //     counts[orbitName] = count;
  //   }
  //   return counts;
  // }


}

exports.StickeringManager = StickeringManager;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","../../alg":"7Ff6b","../../kpuzzle":"4ZRD3"}],"4ZRD3":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
Object.defineProperty(exports, "KPuzzleDefinition", {
  enumerable: true,
  get: function () {
    return _definition_types.KPuzzleDefinition;
  }
});
Object.defineProperty(exports, "OrbitTransformation", {
  enumerable: true,
  get: function () {
    return _definition_types.OrbitTransformation;
  }
});
Object.defineProperty(exports, "Transformation", {
  enumerable: true,
  get: function () {
    return _definition_types.Transformation;
  }
});
Object.defineProperty(exports, "KPuzzle", {
  enumerable: true,
  get: function () {
    return _kpuzzle.KPuzzle;
  }
});
Object.defineProperty(exports, "transformationForMove", {
  enumerable: true,
  get: function () {
    return _kpuzzle.transformationForMove;
  }
});
Object.defineProperty(exports, "experimentalTransformationForQuantumMove", {
  enumerable: true,
  get: function () {
    return _kpuzzle.transformationForQuantumMove;
  }
});
Object.defineProperty(exports, "Canonicalizer", {
  enumerable: true,
  get: function () {
    return _canonicalize.Canonicalizer;
  }
});
Object.defineProperty(exports, "SearchSequence", {
  enumerable: true,
  get: function () {
    return _canonicalize.SearchSequence;
  }
});
Object.defineProperty(exports, "CanonicalSequenceIterator", {
  enumerable: true,
  get: function () {
    return _canonicalize.CanonicalSequenceIterator;
  }
});
Object.defineProperty(exports, "combineTransformations", {
  enumerable: true,
  get: function () {
    return _transformations.combineTransformations;
  }
});
Object.defineProperty(exports, "multiplyTransformations", {
  enumerable: true,
  get: function () {
    return _transformations.multiplyTransformations;
  }
});
Object.defineProperty(exports, "identityTransformation", {
  enumerable: true,
  get: function () {
    return _transformations.identityTransformation;
  }
});
Object.defineProperty(exports, "invertTransformation", {
  enumerable: true,
  get: function () {
    return _transformations.invertTransformation;
  }
});
Object.defineProperty(exports, "areTransformationsEquivalent", {
  enumerable: true,
  get: function () {
    return _transformations.areTransformationsEquivalent;
  }
});
Object.defineProperty(exports, "areOrbitTransformationsEquivalent", {
  enumerable: true,
  get: function () {
    return _transformations.areOrbitTransformationsEquivalent;
  }
});
Object.defineProperty(exports, "areStatesEquivalent", {
  enumerable: true,
  get: function () {
    return _transformations.areStatesEquivalent;
  }
});
Object.defineProperty(exports, "transformationOrder", {
  enumerable: true,
  get: function () {
    return _transformations.transformationOrder;
  }
});
Object.defineProperty(exports, "parseKPuzzleDefinition", {
  enumerable: true,
  get: function () {
    return _parser.parseKPuzzleDefinition;
  }
});
Object.defineProperty(exports, "KPuzzleSVGWrapper", {
  enumerable: true,
  get: function () {
    return _svg.KPuzzleSVGWrapper;
  }
});
Object.defineProperty(exports, "experimentalIs3x3x3Solved", {
  enumerable: true,
  get: function () {
    return _puzzleOrientation.experimentalIs3x3x3Solved;
  }
});

var _definition_types = require("./definition_types");

var _kpuzzle = require("./kpuzzle");

var _canonicalize = require("./canonicalize");

var _transformations = require("./transformations");

var _parser = require("./parser");

var _svg = require("./svg");

var _puzzleOrientation = require("./puzzle-orientation");
},{"./definition_types":"7jLct","./kpuzzle":"1cwQy","./canonicalize":"4cAM9","./transformations":"46EZC","./parser":"6amq7","./svg":"4ERPh","./puzzle-orientation":"1TGyt"}],"7jLct":[function(require,module,exports) {
"use strict";
},{}],"1cwQy":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.transformationForQuantumMove = transformationForQuantumMove;
exports.transformationForMove = transformationForMove;
exports.getNotationLayer = getNotationLayer;
exports.KPuzzle = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _alg = require("../alg");

var _transformations = require("./transformations");

// TODO: Move other helpers into the definition.
function transformationForQuantumMove(def, quantumMove) {
  const transformation = getNotationLayer(def).lookupMove(new _alg.Move(quantumMove) // TODO
  );

  if (!transformation) {
    throw new Error("Unknown move: " + quantumMove.toString());
  }

  return transformation;
} // TODO: Move other helpers into the definition.


function transformationForMove(def, move) {
  const transformation = getNotationLayer(def).lookupMove(move);

  if (!transformation) {
    throw new Error("Unknown move: " + move.toString());
  }

  return transformation;
}

function getNotationLayer(def) {
  if (!def.moveNotation) {
    def.moveNotation = new KPuzzleMoveNotation(def);
  }

  return def.moveNotation;
}

class KPuzzleMoveNotation {
  constructor(def) {
    this.def = def;
    (0, _defineProperty2.default)(this, "cache", {});
  }

  lookupMove(move) {
    const key = move.toString();
    let r = this.cache[key];

    if (r) {
      return r;
    }

    const quantumKey = move.quantum.toString();
    r = this.def.moves[quantumKey];

    if (r) {
      r = (0, _transformations.multiplyTransformations)(this.def, r, move.effectiveAmount);
      this.cache[key] = r;
    }

    return r;
  }

}

class KPuzzle {
  constructor(definition) {
    this.definition = definition;
    (0, _defineProperty2.default)(this, "state", void 0);
    this.state = (0, _transformations.identityTransformation)(definition);
  }

  reset() {
    this.state = (0, _transformations.identityTransformation)(this.definition);
  }

  serialize() {
    let output = "";

    for (const orbitName in this.definition.orbits) {
      output += orbitName + "\n";
      output += this.state[orbitName].permutation.join(" ") + "\n";
      output += this.state[orbitName].orientation.join(" ") + "\n";
    }

    output = output.slice(0, output.length - 1); // Trim last newline.

    return output;
  }

  applyMove(move) {
    this.state = (0, _transformations.combineTransformations)(this.definition, this.state, transformationForMove(this.definition, move));
  }

  applyAlg(alg) {
    // TODO: use indexer instead of full expansion.
    for (const move of alg.experimentalLeafMoves()) {
      this.applyMove(move);
    }
  } // TODO: Implement
  // parseState(): this {}
  // TODO: Alg parsing
  // TODO: Implement.
  // invert(): this {}


}

exports.KPuzzle = KPuzzle;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","../alg":"7Ff6b","./transformations":"46EZC"}],"46EZC":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.combineTransformations = combineTransformations;
exports.multiplyTransformations = multiplyTransformations;
exports.identityTransformation = identityTransformation;
exports.invertTransformation = invertTransformation;
exports.transformationOrder = transformationOrder;
exports.areOrbitTransformationsEquivalent = areOrbitTransformationsEquivalent;
exports.areTransformationsEquivalent = areTransformationsEquivalent;
exports.areStatesEquivalent = areStatesEquivalent;
// this is the last identity orbit transformation we saw or looked at.
let lasto;

function isIdentity(omod, o) {
  if (o === lasto) {
    return true;
  }

  const perm = o.permutation;
  const n = perm.length;

  for (let idx = 0; idx < n; idx++) {
    if (perm[idx] !== idx) {
      return false;
    }
  }

  if (omod > 1) {
    const ori = o.orientation;

    for (let idx = 0; idx < n; idx++) {
      if (ori[idx] !== 0) {
        return false;
      }
    }
  }

  lasto = o;
  return true;
}

function combineTransformations(def, t1, t2) {
  const newTrans = {};

  for (const orbitName in def.orbits) {
    const oDef = def.orbits[orbitName];
    const o1 = t1[orbitName];
    const o2 = t2[orbitName];

    if (isIdentity(oDef.orientations, o2)) {
      // common case for big cubes
      newTrans[orbitName] = o1;
    } else if (isIdentity(oDef.orientations, o1)) {
      newTrans[orbitName] = o2;
    } else {
      const newPerm = new Array(oDef.numPieces);

      if (oDef.orientations === 1) {
        for (let idx = 0; idx < oDef.numPieces; idx++) {
          newPerm[idx] = o1.permutation[o2.permutation[idx]];
        }

        newTrans[orbitName] = {
          permutation: newPerm,
          orientation: o1.orientation
        };
      } else {
        const newOri = new Array(oDef.numPieces);

        for (let idx = 0; idx < oDef.numPieces; idx++) {
          newOri[idx] = (o1.orientation[o2.permutation[idx]] + o2.orientation[idx]) % oDef.orientations;
          newPerm[idx] = o1.permutation[o2.permutation[idx]];
        }

        newTrans[orbitName] = {
          permutation: newPerm,
          orientation: newOri
        };
      }
    }
  }

  return newTrans;
}

function multiplyTransformations(def, t, amount) {
  if (amount < 0) {
    return multiplyTransformations(def, invertTransformation(def, t), -amount);
  }

  if (amount === 0) {
    return identityTransformation(def);
  }

  if (amount === 1) {
    return t;
  }

  let halfish = t;

  if (amount !== 2) {
    halfish = multiplyTransformations(def, t, Math.floor(amount / 2));
  }

  const twiceHalfish = combineTransformations(def, halfish, halfish);

  if (amount % 2 === 0) {
    return twiceHalfish;
  } else {
    return combineTransformations(def, t, twiceHalfish);
  }
}

function identityTransformation(definition) {
  const transformation = {};

  for (const orbitName in definition.orbits) {
    const orbitDefinition = definition.orbits[orbitName];

    if (!lasto || lasto.permutation.length !== orbitDefinition.numPieces) {
      const newPermutation = new Array(orbitDefinition.numPieces);
      const newOrientation = new Array(orbitDefinition.numPieces);

      for (let i = 0; i < orbitDefinition.numPieces; i++) {
        newPermutation[i] = i;
        newOrientation[i] = 0;
      }

      const orbitTransformation = {
        permutation: newPermutation,
        orientation: newOrientation
      };
      lasto = orbitTransformation;
    }

    transformation[orbitName] = lasto;
  }

  return transformation;
}

function invertTransformation(def, t) {
  const newTrans = {};

  for (const orbitName in def.orbits) {
    const oDef = def.orbits[orbitName];
    const o = t[orbitName];

    if (isIdentity(oDef.orientations, o)) {
      newTrans[orbitName] = o;
    } else if (oDef.orientations === 1) {
      const newPerm = new Array(oDef.numPieces);

      for (let idx = 0; idx < oDef.numPieces; idx++) {
        newPerm[o.permutation[idx]] = idx;
      }

      newTrans[orbitName] = {
        permutation: newPerm,
        orientation: o.orientation
      };
    } else {
      const newPerm = new Array(oDef.numPieces);
      const newOri = new Array(oDef.numPieces);

      for (let idx = 0; idx < oDef.numPieces; idx++) {
        const fromIdx = o.permutation[idx];
        newPerm[fromIdx] = idx;
        newOri[fromIdx] = (oDef.orientations - o.orientation[idx] + oDef.orientations) % oDef.orientations;
      }

      newTrans[orbitName] = {
        permutation: newPerm,
        orientation: newOri
      };
    }
  }

  return newTrans;
}

function gcd(a, b) {
  if (b) {
    return gcd(b, a % b);
  }

  return a;
}
/* calculate the order of a particular transformation. */


function transformationOrder(def, t) {
  let r = 1;

  for (const orbitName in def.orbits) {
    const oDef = def.orbits[orbitName];
    const o = t[orbitName];
    const d = new Array(oDef.numPieces);

    for (let idx = 0; idx < oDef.numPieces; idx++) {
      if (!d[idx]) {
        let w = idx;
        let om = 0;
        let pm = 0;

        for (;;) {
          d[w] = true;
          om = om + o.orientation[w];
          pm = pm + 1;
          w = o.permutation[w];

          if (w === idx) {
            break;
          }
        }

        if (om !== 0) {
          pm = pm * oDef.orientations / gcd(oDef.orientations, om);
        }

        r = r * pm / gcd(r, pm);
      }
    }
  }

  return r;
}

function areOrbitTransformationsEquivalent(def, orbitName, t1, t2, options = {}) {
  const oDef = def.orbits[orbitName];
  const o1 = t1[orbitName];
  const o2 = t2[orbitName];

  for (let idx = 0; idx < oDef.numPieces; idx++) {
    if (!(options === null || options === void 0 ? void 0 : options.ignoreOrientation) && o1.orientation[idx] !== o2.orientation[idx]) {
      return false;
    }

    if (!(options === null || options === void 0 ? void 0 : options.ignorePermutation) && o1.permutation[idx] !== o2.permutation[idx]) {
      return false;
    }
  }

  return true;
}

function areTransformationsEquivalent(def, t1, t2) {
  for (const orbitName in def.orbits) {
    if (!areOrbitTransformationsEquivalent(def, orbitName, t1, t2)) {
      return false;
    }
  }

  return true;
}

function areStatesEquivalent(def, t1, t2) {
  // Turn transformations into states.
  // This accounts for indistinguishable pieces.
  return areTransformationsEquivalent(def, combineTransformations(def, def.startPieces, t1), combineTransformations(def, def.startPieces, t2));
}
},{}],"4cAM9":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.CanonicalSequenceIterator = exports.SearchSequence = exports.Canonicalizer = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _transformations = require("./transformations");

/**
 *  This module manages canonical sequences.  You can merge sequences
 *  combining moves (fully respecting commuting moves), and you can
 *  generate canonical sequences efficiently.
 */
class InternalMove {
  constructor(base, twist) {
    this.base = base;
    this.twist = twist;
  }

  getTransformation(canon) {
    return canon.transforms[this.base][this.twist];
  }

  asString(canon) {
    const mod = canon.moveorder[this.base];
    let tw = this.twist % mod;

    while (tw + tw > mod) {
      tw -= mod;
    }

    while (tw + tw <= -mod) {
      tw += mod;
    }

    const nam = canon.movenames[this.base];

    if (tw === 1) {
      return nam;
    } else if (tw === -1) {
      return nam + "'";
    } else if (tw > 0) {
      return nam + tw;
    } else if (tw < 0) {
      return nam + -tw + "'";
    } else {
      throw new Error("Stringifying null move?");
    }
  }

} // represents puzzle move data and its commuting structure


class Canonicalizer {
  constructor(def) {
    this.def = def;
    (0, _defineProperty2.default)(this, "commutes", []);
    (0, _defineProperty2.default)(this, "moveorder", []);
    (0, _defineProperty2.default)(this, "movenames", []);
    (0, _defineProperty2.default)(this, "transforms", []);
    (0, _defineProperty2.default)(this, "moveindex", {});
    (0, _defineProperty2.default)(this, "baseMoveCount", void 0);
    const basemoves = def.moves;
    const id = (0, _transformations.identityTransformation)(def);

    for (const mv1 in basemoves) {
      this.moveindex[mv1] = this.movenames.length;
      this.movenames.push(mv1);
      this.transforms.push([id, basemoves[mv1]]);
    }

    this.baseMoveCount = this.movenames.length;

    for (let i = 0; i < this.baseMoveCount; i++) {
      this.commutes.push([]);
      const t1 = this.transforms[i][1];

      for (let j = 0; j < this.baseMoveCount; j++) {
        const t2 = this.transforms[j][1];
        const ab = (0, _transformations.combineTransformations)(def, t1, t2);
        const ba = (0, _transformations.combineTransformations)(def, t2, t1);
        this.commutes[i][j] = (0, _transformations.areTransformationsEquivalent)(def, ab, ba);
      }
    }

    for (let i = 0; i < this.baseMoveCount; i++) {
      const t1 = this.transforms[i][1];
      let ct = t1;
      let order = 1;

      for (let mult = 2; !(0, _transformations.areTransformationsEquivalent)(def, id, ct); mult++) {
        order++;
        ct = (0, _transformations.combineTransformations)(def, ct, t1);
        this.transforms[i].push(ct);
      }

      this.moveorder[i] = order;
    }
  }

  blockMoveToInternalMove(move) {
    const quantumMoveStr = move.quantum.toString();

    if (!(quantumMoveStr in this.def.moves)) {
      throw new Error("! move " + quantumMoveStr + " not in def.");
    }

    const ind = this.moveindex[quantumMoveStr];
    const mod = this.moveorder[ind];
    let tw = move.effectiveAmount % mod; // TODO

    if (tw < 0) {
      tw = (tw + mod) % mod;
    }

    return new InternalMove(ind, tw);
  } // Sequence must be simple sequence of block moves
  // this one does not attempt to merge.


  sequenceToSearchSequence(alg, tr) {
    const ss = new SearchSequence(this, tr);

    for (const move of alg.experimentalLeafMoves()) {
      ss.appendOneMove(this.blockMoveToInternalMove(move));
    }

    return ss;
  } // Sequence to simple sequence, with merging.


  mergeSequenceToSearchSequence(alg, tr) {
    const ss = new SearchSequence(this, tr);

    for (const move of alg.experimentalLeafMoves()) {
      ss.mergeOneMove(this.blockMoveToInternalMove(move));
    }

    return ss;
  }

} // represents a single sequence we are working on
// this can be a search sequence, or it can be a
// "cooked" sequence that we want to use efficiently.


exports.Canonicalizer = Canonicalizer;

class SearchSequence {
  constructor(canon, tr) {
    this.canon = canon;
    (0, _defineProperty2.default)(this, "moveseq", []);
    (0, _defineProperty2.default)(this, "trans", void 0);

    if (tr) {
      this.trans = tr;
    } else {
      this.trans = (0, _transformations.identityTransformation)(canon.def);
    }
  }
  /*
   *  A common use for search sequences is to extend them, but
   *  sometimes we shouldn't modify the returned one.  This
   *  method gives you a copy you can do whatever you want with.
   */


  clone() {
    const r = new SearchSequence(this.canon, this.trans);
    r.moveseq = [...this.moveseq];
    return r;
  } // returns 1 if the move is added, 0 if it is merged, -1 if it cancels a move


  mergeOneMove(mv) {
    const r = this.onlyMergeOneMove(mv);
    this.trans = (0, _transformations.combineTransformations)(this.canon.def, this.trans, mv.getTransformation(this.canon));
    return r;
  } // does not do merge work; just slaps the new move on


  appendOneMove(mv) {
    this.moveseq.push(mv);
    this.trans = (0, _transformations.combineTransformations)(this.canon.def, this.trans, mv.getTransformation(this.canon));
    return 1;
  } // pop a move off.


  popMove() {
    const mv = this.moveseq.pop();

    if (!mv) {
      throw new Error("Can't pop an empty sequence");
    }

    this.trans = (0, _transformations.combineTransformations)(this.canon.def, this.trans, this.canon.transforms[mv.base][this.canon.moveorder[mv.base] - mv.twist]);
    return 1;
  } // do one more twist of the last move


  oneMoreTwist() {
    const lastmv = this.moveseq[this.moveseq.length - 1];
    this.trans = (0, _transformations.combineTransformations)(this.canon.def, this.trans, this.canon.transforms[lastmv.base][1]);
    this.moveseq[this.moveseq.length - 1] = new InternalMove(lastmv.base, lastmv.twist + 1);
    return 0;
  }

  onlyMergeOneMove(mv) {
    let j = this.moveseq.length - 1;

    while (j >= 0) {
      if (mv.base === this.moveseq[j].base) {
        const mo = this.canon.moveorder[mv.base];
        let twist = (mv.twist + this.moveseq[j].twist) % mo;

        if (twist < 0) {
          twist = (twist + mo) % mo;
        }

        if (twist === 0) {
          // this splice should not be a performance problem because the
          // typical number of following moves should be small
          this.moveseq.splice(j, 1);
          return -1;
        } else {
          this.moveseq[j] = new InternalMove(mv.base, twist);
          return 0;
        }
      } else if (this.canon.commutes[mv.base][this.moveseq[j].base]) {
        j--;
      } else {
        break;
      }
    }

    this.moveseq.push(mv);
    return 1;
  } // returns the length of the merged sequence.


  mergeSequence(seq) {
    let r = this.moveseq.length;

    for (let i = 0; i < seq.moveseq.length; i++) {
      const mv = seq.moveseq[i];
      const d = this.onlyMergeOneMove(mv);
      r += d;
    }

    this.trans = (0, _transformations.combineTransformations)(this.canon.def, this.trans, seq.trans);
    return r;
  }

  getSequenceAsString() {
    const r = [];

    for (const mv of this.moveseq) {
      r.push(mv.asString(this.canon));
    }

    return r.join(" ");
  }

}
/*
 *   Iterate through canonical sequences by length.  This version
 *   uses generators.
 */


exports.SearchSequence = SearchSequence;

class CanonicalSequenceIterator {
  constructor(canon, state) {
    this.canon = canon;
    (0, _defineProperty2.default)(this, "ss", void 0);
    (0, _defineProperty2.default)(this, "targetLength", void 0);
    this.ss = new SearchSequence(canon, state);
    this.targetLength = 0;
  }

  nextState(base, canonstate) {
    const newstate = [];

    for (const prevbase of canonstate) {
      if (prevbase === base) {
        return null;
      } else if (!this.canon.commutes[prevbase][base]) {// don't do anything in this case
      } else if (base < prevbase) {
        return null;
      } else {
        newstate.push(prevbase);
      }
    }

    return newstate;
  }

  *genSequence(togo, canonstate) {
    if (togo === 0) {
      yield this.ss;
    } else {
      for (let base = 0; base < this.canon.baseMoveCount; base++) {
        const newstate = this.nextState(base, canonstate);

        if (newstate) {
          newstate.push(base);

          for (let tw = 1; tw < this.canon.moveorder[base]; tw++) {
            this.ss.appendOneMove(new InternalMove(base, tw));
            yield* this.genSequence(togo - 1, newstate);
            this.ss.popMove();
          }
        }
      }
    }

    return null;
  }

  *generator() {
    for (let d = 0;; d++) {
      yield* this.genSequence(d, []);
    }
  }

  *genSequenceTree(canonstate) {
    const r = yield this.ss;

    if (r > 0) {
      return null;
    }

    for (let base = 0; base < this.canon.baseMoveCount; base++) {
      const newstate = this.nextState(base, canonstate);

      if (newstate) {
        newstate.push(base);

        for (let tw = 1; tw < this.canon.moveorder[base]; tw++) {
          this.ss.appendOneMove(new InternalMove(base, tw));
          yield* this.genSequenceTree(newstate);
          this.ss.popMove();
        }
      }
    }

    return null;
  }

}

exports.CanonicalSequenceIterator = CanonicalSequenceIterator;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","./transformations":"46EZC"}],"6amq7":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
Object.defineProperty(exports, "parseKPuzzleDefinition", {
  enumerable: true,
  get: function () {
    return _parserShim.pegParseKPuzzleDefinition;
  }
});

var _parserShim = require("./parser-shim");
},{"./parser-shim":"6ecGx"}],"6ecGx":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.pegParseKPuzzleDefinition = void 0;

var _parserPegjs = require("./parser-pegjs");

// Note: this file exists so that `parse` doesn't show up for autocompletion (by
// avoiding a `parser-pegjs.d.ts` file that exports `parse`.)
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
const pegParseKPuzzleDefinition = _parserPegjs.parse;
exports.pegParseKPuzzleDefinition = pegParseKPuzzleDefinition;
},{"./parser-pegjs":"5y8NP"}],"5y8NP":[function(require,module,exports) {
// Generated by PEG.js v0.11.0-master.f69239d, https://pegjs.org/
"use strict";

function peg$subclass(child, parent) {
  function C() {
    this.constructor = child;
  }

  C.prototype = parent.prototype;
  child.prototype = new C();
}

function peg$SyntaxError(message, expected, found, location) {
  this.message = message;
  this.expected = expected;
  this.found = found;
  this.location = location;
  this.name = "SyntaxError"; // istanbul ignore next

  if (typeof Error.captureStackTrace === "function") {
    Error.captureStackTrace(this, peg$SyntaxError);
  }
}

peg$subclass(peg$SyntaxError, Error);

peg$SyntaxError.buildMessage = function (expected, found) {
  var DESCRIBE_EXPECTATION_FNS = {
    literal: function (expectation) {
      return '"' + literalEscape(expectation.text) + '"';
    },
    class: function (expectation) {
      var escapedParts = expectation.parts.map(function (part) {
        return Array.isArray(part) ? classEscape(part[0]) + "-" + classEscape(part[1]) : classEscape(part);
      });
      return "[" + (expectation.inverted ? "^" : "") + escapedParts + "]";
    },
    any: function () {
      return "any character";
    },
    end: function () {
      return "end of input";
    },
    other: function (expectation) {
      return expectation.description;
    },
    not: function (expectation) {
      return "not " + describeExpectation(expectation.expected);
    }
  };

  function hex(ch) {
    return ch.charCodeAt(0).toString(16).toUpperCase();
  }

  function literalEscape(s) {
    return s.replace(/\\/g, "\\\\").replace(/"/g, '\\"').replace(/\0/g, "\\0").replace(/\t/g, "\\t").replace(/\n/g, "\\n").replace(/\r/g, "\\r").replace(/[\x00-\x0F]/g, function (ch) {
      return "\\x0" + hex(ch);
    }).replace(/[\x10-\x1F\x7F-\x9F]/g, function (ch) {
      return "\\x" + hex(ch);
    });
  }

  function classEscape(s) {
    return s.replace(/\\/g, "\\\\").replace(/\]/g, "\\]").replace(/\^/g, "\\^").replace(/-/g, "\\-").replace(/\0/g, "\\0").replace(/\t/g, "\\t").replace(/\n/g, "\\n").replace(/\r/g, "\\r").replace(/[\x00-\x0F]/g, function (ch) {
      return "\\x0" + hex(ch);
    }).replace(/[\x10-\x1F\x7F-\x9F]/g, function (ch) {
      return "\\x" + hex(ch);
    });
  }

  function describeExpectation(expectation) {
    return DESCRIBE_EXPECTATION_FNS[expectation.type](expectation);
  }

  function describeExpected(expected) {
    var descriptions = expected.map(describeExpectation);
    var i, j;
    descriptions.sort();

    if (descriptions.length > 0) {
      for (i = 1, j = 1; i < descriptions.length; i++) {
        if (descriptions[i - 1] !== descriptions[i]) {
          descriptions[j] = descriptions[i];
          j++;
        }
      }

      descriptions.length = j;
    }

    switch (descriptions.length) {
      case 1:
        return descriptions[0];

      case 2:
        return descriptions[0] + " or " + descriptions[1];

      default:
        return descriptions.slice(0, -1).join(", ") + ", or " + descriptions[descriptions.length - 1];
    }
  }

  function describeFound(found) {
    return found ? '"' + literalEscape(found) + '"' : "end of input";
  }

  return "Expected " + describeExpected(expected) + " but " + describeFound(found) + " found.";
};

function peg$parse(input, options) {
  options = options !== undefined ? options : {};
  var peg$FAILED = {};
  var peg$startRuleFunctions = {
    start: peg$parsestart
  };
  var peg$startRuleFunction = peg$parsestart;
  var peg$c0 = " ";
  var peg$c1 = "Name";
  var peg$c2 = "Set";
  var peg$c3 = "\n";
  var peg$c4 = "Solved";
  var peg$c5 = "End";
  var peg$c6 = "Move";
  var peg$r0 = /^[A-Za-z0-9<>]/;
  var peg$r1 = /^[A-Za-z]/;
  var peg$r2 = /^[A-Za-z0-9]/;
  var peg$r3 = /^[0-9]/;
  var peg$e0 = peg$classExpectation([["A", "Z"], ["a", "z"], ["0", "9"], "<", ">"], false, false);
  var peg$e1 = peg$classExpectation([["A", "Z"], ["a", "z"]], false, false);
  var peg$e2 = peg$classExpectation([["A", "Z"], ["a", "z"], ["0", "9"]], false, false);
  var peg$e3 = peg$classExpectation([["0", "9"]], false, false);
  var peg$e4 = peg$literalExpectation(" ", false);
  var peg$e5 = peg$literalExpectation("Name", false);
  var peg$e6 = peg$literalExpectation("Set", false);
  var peg$e7 = peg$literalExpectation("\n", false);
  var peg$e8 = peg$literalExpectation("Solved", false);
  var peg$e9 = peg$literalExpectation("End", false);
  var peg$e10 = peg$literalExpectation("Move", false);

  var peg$f0 = function (def) {
    return fixMoves(def);
  };

  var peg$f1 = function (characters) {
    return characters.join("");
  };

  var peg$f2 = function (first, rest) {
    return [first].concat(rest).join("");
  };

  var peg$f3 = function (characters) {
    return parseInt(characters.join(""), 10);
  };

  var peg$f4 = function (identifier) {
    return identifier;
  };

  var peg$f5 = function (set_identifier, num_pieces, num_orientations) {
    return [set_identifier, {
      numPieces: num_pieces,
      orientations: num_orientations
    }];
  };

  var peg$f6 = function (orbit, orbits) {
    orbits[orbit[0]] = orbit[1];
    return orbits;
  };

  var peg$f7 = function (orbit) {
    const orbits = {};
    orbits[orbit[0]] = orbit[1];
    return orbits;
  };

  var peg$f8 = function (num, nums) {
    return [num].concat(nums);
  };

  var peg$f9 = function (num) {
    return [num];
  };

  var peg$f10 = function (nums) {
    return fixPermutation(nums);
  };

  var peg$f11 = function (set_identifier, permutation, nums) {
    return [set_identifier, {
      permutation: permutation,
      orientation: nums
    }];
  };

  var peg$f12 = function (set_identifier, permutation) {
    return [set_identifier, {
      permutation: permutation,
      orientation: new Array(permutation.length).fill(0)
    }];
  };

  var peg$f13 = function (definition, definitions) {
    definitions[definition[0]] = definition[1];
    return definitions;
  };

  var peg$f14 = function (definition) {
    const definitions = {};
    definitions[definition[0]] = definition[1];
    return definitions;
  };

  var peg$f15 = function (definitions) {
    return definitions;
  };

  var peg$f16 = function (identifier, definitions) {
    return [identifier, definitions];
  };

  var peg$f17 = function (move, moves) {
    moves[move[0]] = move[1];
    return moves;
  };

  var peg$f18 = function (move) {
    const moves = {};
    moves[move[0]] = move[1];
    return moves;
  };

  var peg$f19 = function (name, orbits, start_pieces, moves) {
    return {
      name: name,
      orbits: orbits,
      moves: moves,
      startPieces: start_pieces
    };
  };

  var peg$currPos = 0;
  var peg$savedPos = 0;
  var peg$posDetailsCache = [{
    line: 1,
    column: 1
  }];
  var peg$expected = [];
  var peg$silentFails = 0;
  var peg$result;

  if ("startRule" in options) {
    if (!(options.startRule in peg$startRuleFunctions)) {
      throw new Error("Can't start parsing from rule \"" + options.startRule + '".');
    }

    peg$startRuleFunction = peg$startRuleFunctions[options.startRule];
  }

  function text() {
    return input.substring(peg$savedPos, peg$currPos);
  }

  function offset() {
    return peg$savedPos;
  }

  function range() {
    return [peg$savedPos, peg$currPos];
  }

  function location() {
    return peg$computeLocation(peg$savedPos, peg$currPos);
  }

  function expected(description, location) {
    location = location !== undefined ? location : peg$computeLocation(peg$savedPos, peg$currPos);
    throw peg$buildStructuredError([peg$otherExpectation(description)], input.substring(peg$savedPos, peg$currPos), location);
  }

  function error(message, location) {
    location = location !== undefined ? location : peg$computeLocation(peg$savedPos, peg$currPos);
    throw peg$buildSimpleError(message, location);
  }

  function peg$literalExpectation(text, ignoreCase) {
    return {
      type: "literal",
      text: text,
      ignoreCase: ignoreCase
    };
  }

  function peg$classExpectation(parts, inverted, ignoreCase) {
    return {
      type: "class",
      parts: parts,
      inverted: inverted,
      ignoreCase: ignoreCase
    };
  }

  function peg$anyExpectation() {
    return {
      type: "any"
    };
  }

  function peg$endExpectation() {
    return {
      type: "end"
    };
  }

  function peg$otherExpectation(description) {
    return {
      type: "other",
      description: description
    };
  }

  function peg$computePosDetails(pos) {
    var details = peg$posDetailsCache[pos];
    var p;

    if (details) {
      return details;
    } else {
      p = pos - 1;

      while (!peg$posDetailsCache[p]) {
        p--;
      }

      details = peg$posDetailsCache[p];
      details = {
        line: details.line,
        column: details.column
      };

      while (p < pos) {
        if (input.charCodeAt(p) === 10) {
          details.line++;
          details.column = 1;
        } else {
          details.column++;
        }

        p++;
      }

      peg$posDetailsCache[pos] = details;
      return details;
    }
  }

  var peg$VALIDFILENAME = typeof options.filename === "string" && options.filename.length > 0;

  function peg$computeLocation(startPos, endPos) {
    var loc = {};
    if (peg$VALIDFILENAME) loc.filename = options.filename;
    var startPosDetails = peg$computePosDetails(startPos);
    loc.start = {
      offset: startPos,
      line: startPosDetails.line,
      column: startPosDetails.column
    };
    var endPosDetails = peg$computePosDetails(endPos);
    loc.end = {
      offset: endPos,
      line: endPosDetails.line,
      column: endPosDetails.column
    };
    return loc;
  }

  function peg$begin() {
    peg$expected.push({
      pos: peg$currPos,
      variants: []
    });
  }

  function peg$expect(expected) {
    var top = peg$expected[peg$expected.length - 1];

    if (peg$currPos < top.pos) {
      return;
    }

    if (peg$currPos > top.pos) {
      top.pos = peg$currPos;
      top.variants = [];
    }

    top.variants.push(expected);
  }

  function peg$end(invert) {
    var expected = peg$expected.pop();
    var top = peg$expected[peg$expected.length - 1];
    var variants = expected.variants;

    if (top.pos !== expected.pos) {
      return;
    }

    if (invert) {
      variants = variants.map(function (e) {
        return e.type === "not" ? e.expected : {
          type: "not",
          expected: e
        };
      });
    }

    Array.prototype.push.apply(top.variants, variants);
  }

  function peg$buildSimpleError(message, location) {
    return new peg$SyntaxError(message, null, null, location);
  }

  function peg$buildStructuredError(expected, found, location) {
    return new peg$SyntaxError(peg$SyntaxError.buildMessage(expected, found), expected, found, location);
  }

  function peg$buildError() {
    var expected = peg$expected[0];
    var failPos = expected.pos;
    return peg$buildStructuredError(expected.variants, failPos < input.length ? input.charAt(failPos) : null, failPos < input.length ? peg$computeLocation(failPos, failPos + 1) : peg$computeLocation(failPos, failPos));
  }

  function peg$parsestart() {
    var s0, s1;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    s1 = peg$parseDEFINITION_FILE();

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$f0(s1);
    }

    s0 = s1;
    return s0;
  }

  function peg$parseIDENTIFIER() {
    var s0, s1, s2;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    s1 = [];
    rule$expects(peg$e0);

    if (peg$r0.test(input.charAt(peg$currPos))) {
      s2 = input.charAt(peg$currPos);
      peg$currPos++;
    } else {
      s2 = peg$FAILED;
    }

    if (s2 !== peg$FAILED) {
      while (s2 !== peg$FAILED) {
        s1.push(s2);
        rule$expects(peg$e0);

        if (peg$r0.test(input.charAt(peg$currPos))) {
          s2 = input.charAt(peg$currPos);
          peg$currPos++;
        } else {
          s2 = peg$FAILED;
        }
      }
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$f1(s1);
    }

    s0 = s1;
    return s0;
  }

  function peg$parseSET_IDENTIFIER() {
    var s0, s1, s2, s3;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    rule$expects(peg$e1);

    if (peg$r1.test(input.charAt(peg$currPos))) {
      s1 = input.charAt(peg$currPos);
      peg$currPos++;
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      s2 = [];
      rule$expects(peg$e2);

      if (peg$r2.test(input.charAt(peg$currPos))) {
        s3 = input.charAt(peg$currPos);
        peg$currPos++;
      } else {
        s3 = peg$FAILED;
      }

      while (s3 !== peg$FAILED) {
        s2.push(s3);
        rule$expects(peg$e2);

        if (peg$r2.test(input.charAt(peg$currPos))) {
          s3 = input.charAt(peg$currPos);
          peg$currPos++;
        } else {
          s3 = peg$FAILED;
        }
      }

      peg$savedPos = s0;
      s0 = peg$f2(s1, s2);
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseNUMBER() {
    var s0, s1, s2;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    s1 = [];
    rule$expects(peg$e3);

    if (peg$r3.test(input.charAt(peg$currPos))) {
      s2 = input.charAt(peg$currPos);
      peg$currPos++;
    } else {
      s2 = peg$FAILED;
    }

    if (s2 !== peg$FAILED) {
      while (s2 !== peg$FAILED) {
        s1.push(s2);
        rule$expects(peg$e3);

        if (peg$r3.test(input.charAt(peg$currPos))) {
          s2 = input.charAt(peg$currPos);
          peg$currPos++;
        } else {
          s2 = peg$FAILED;
        }
      }
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$f3(s1);
    }

    s0 = s1;
    return s0;
  }

  function peg$parseSPACE() {
    var s0;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    rule$expects(peg$e4);

    if (input.charCodeAt(peg$currPos) === 32) {
      s0 = peg$c0;
      peg$currPos++;
    } else {
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseNAME() {
    var s0, s1, s2, s3;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    rule$expects(peg$e5);

    if (input.substr(peg$currPos, 4) === peg$c1) {
      s1 = peg$c1;
      peg$currPos += 4;
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parseSPACE();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseIDENTIFIER();

        if (s3 !== peg$FAILED) {
          peg$savedPos = s0;
          s0 = peg$f4(s3);
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseORBIT() {
    var s0, s1, s2, s3, s4, s5, s6, s7;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    rule$expects(peg$e6);

    if (input.substr(peg$currPos, 3) === peg$c2) {
      s1 = peg$c2;
      peg$currPos += 3;
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parseSPACE();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseSET_IDENTIFIER();

        if (s3 !== peg$FAILED) {
          s4 = peg$parseSPACE();

          if (s4 !== peg$FAILED) {
            s5 = peg$parseNUMBER();

            if (s5 !== peg$FAILED) {
              s6 = peg$parseSPACE();

              if (s6 !== peg$FAILED) {
                s7 = peg$parseNUMBER();

                if (s7 !== peg$FAILED) {
                  peg$savedPos = s0;
                  s0 = peg$f5(s3, s5, s7);
                } else {
                  peg$currPos = s0;
                  s0 = peg$FAILED;
                }
              } else {
                peg$currPos = s0;
                s0 = peg$FAILED;
              }
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseORBITS() {
    var s0, s1, s2, s3;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    s1 = peg$parseORBIT();

    if (s1 !== peg$FAILED) {
      s2 = peg$parseNEWLINE();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseORBITS();

        if (s3 !== peg$FAILED) {
          peg$savedPos = s0;
          s0 = peg$f6(s1, s3);
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    if (s0 === peg$FAILED) {
      s0 = peg$currPos;
      s1 = peg$parseORBIT();

      if (s1 !== peg$FAILED) {
        peg$savedPos = s0;
        s1 = peg$f7(s1);
      }

      s0 = s1;
    }

    return s0;
  }

  function peg$parseNEWLINE() {
    var s0;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    rule$expects(peg$e7);

    if (input.charCodeAt(peg$currPos) === 10) {
      s0 = peg$c3;
      peg$currPos++;
    } else {
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseNEWLINES() {
    var s0, s1;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = [];
    rule$expects(peg$e7);

    if (input.charCodeAt(peg$currPos) === 10) {
      s1 = peg$c3;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      while (s1 !== peg$FAILED) {
        s0.push(s1);
        rule$expects(peg$e7);

        if (input.charCodeAt(peg$currPos) === 10) {
          s1 = peg$c3;
          peg$currPos++;
        } else {
          s1 = peg$FAILED;
        }
      }
    } else {
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseOPTIONAL_NEWLINES() {
    var s0, s1;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = [];
    rule$expects(peg$e7);

    if (input.charCodeAt(peg$currPos) === 10) {
      s1 = peg$c3;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;
    }

    while (s1 !== peg$FAILED) {
      s0.push(s1);
      rule$expects(peg$e7);

      if (input.charCodeAt(peg$currPos) === 10) {
        s1 = peg$c3;
        peg$currPos++;
      } else {
        s1 = peg$FAILED;
      }
    }

    return s0;
  }

  function peg$parseNUMBERS() {
    var s0, s1, s2, s3;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    s1 = peg$parseNUMBER();

    if (s1 !== peg$FAILED) {
      s2 = peg$parseSPACE();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseNUMBERS();

        if (s3 !== peg$FAILED) {
          peg$savedPos = s0;
          s0 = peg$f8(s1, s3);
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    if (s0 === peg$FAILED) {
      s0 = peg$currPos;
      s1 = peg$parseNUMBER();

      if (s1 !== peg$FAILED) {
        peg$savedPos = s0;
        s1 = peg$f9(s1);
      }

      s0 = s1;
    }

    return s0;
  }

  function peg$parsePERMUTATION() {
    var s0, s1;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    s1 = peg$parseNUMBERS();

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$f10(s1);
    }

    s0 = s1;
    return s0;
  }

  function peg$parseDEFINITION() {
    var s0, s1, s2, s3, s4, s5;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    s1 = peg$parseSET_IDENTIFIER();

    if (s1 !== peg$FAILED) {
      s2 = peg$parseNEWLINE();

      if (s2 !== peg$FAILED) {
        s3 = peg$parsePERMUTATION();

        if (s3 !== peg$FAILED) {
          s4 = peg$parseNEWLINE();

          if (s4 !== peg$FAILED) {
            s5 = peg$parseNUMBERS();

            if (s5 !== peg$FAILED) {
              peg$savedPos = s0;
              s0 = peg$f11(s1, s3, s5);
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    if (s0 === peg$FAILED) {
      s0 = peg$currPos;
      s1 = peg$parseSET_IDENTIFIER();

      if (s1 !== peg$FAILED) {
        s2 = peg$parseNEWLINE();

        if (s2 !== peg$FAILED) {
          s3 = peg$parsePERMUTATION();

          if (s3 !== peg$FAILED) {
            peg$savedPos = s0;
            s0 = peg$f12(s1, s3);
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    }

    return s0;
  }

  function peg$parseDEFINITIONS() {
    var s0, s1, s2, s3;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    s1 = peg$parseDEFINITION();

    if (s1 !== peg$FAILED) {
      s2 = peg$parseNEWLINE();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseDEFINITIONS();

        if (s3 !== peg$FAILED) {
          peg$savedPos = s0;
          s0 = peg$f13(s1, s3);
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    if (s0 === peg$FAILED) {
      s0 = peg$currPos;
      s1 = peg$parseDEFINITION();

      if (s1 !== peg$FAILED) {
        peg$savedPos = s0;
        s1 = peg$f14(s1);
      }

      s0 = s1;
    }

    return s0;
  }

  function peg$parseSTART_PIECES() {
    var s0, s1, s2, s3, s4, s5;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    rule$expects(peg$e8);

    if (input.substr(peg$currPos, 6) === peg$c4) {
      s1 = peg$c4;
      peg$currPos += 6;
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parseNEWLINE();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseDEFINITIONS();

        if (s3 !== peg$FAILED) {
          s4 = peg$parseNEWLINE();

          if (s4 !== peg$FAILED) {
            rule$expects(peg$e9);

            if (input.substr(peg$currPos, 3) === peg$c5) {
              s5 = peg$c5;
              peg$currPos += 3;
            } else {
              s5 = peg$FAILED;
            }

            if (s5 !== peg$FAILED) {
              peg$savedPos = s0;
              s0 = peg$f15(s3);
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseMOVE() {
    var s0, s1, s2, s3, s4, s5, s6, s7;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    rule$expects(peg$e10);

    if (input.substr(peg$currPos, 4) === peg$c6) {
      s1 = peg$c6;
      peg$currPos += 4;
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parseSPACE();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseIDENTIFIER();

        if (s3 !== peg$FAILED) {
          s4 = peg$parseNEWLINE();

          if (s4 !== peg$FAILED) {
            s5 = peg$parseDEFINITIONS();

            if (s5 !== peg$FAILED) {
              s6 = peg$parseNEWLINE();

              if (s6 !== peg$FAILED) {
                rule$expects(peg$e9);

                if (input.substr(peg$currPos, 3) === peg$c5) {
                  s7 = peg$c5;
                  peg$currPos += 3;
                } else {
                  s7 = peg$FAILED;
                }

                if (s7 !== peg$FAILED) {
                  peg$savedPos = s0;
                  s0 = peg$f16(s3, s5);
                } else {
                  peg$currPos = s0;
                  s0 = peg$FAILED;
                }
              } else {
                peg$currPos = s0;
                s0 = peg$FAILED;
              }
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseMOVES() {
    var s0, s1, s2, s3;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    s1 = peg$parseMOVE();

    if (s1 !== peg$FAILED) {
      s2 = peg$parseNEWLINES();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseMOVES();

        if (s3 !== peg$FAILED) {
          peg$savedPos = s0;
          s0 = peg$f17(s1, s3);
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    if (s0 === peg$FAILED) {
      s0 = peg$currPos;
      s1 = peg$parseMOVE();

      if (s1 !== peg$FAILED) {
        peg$savedPos = s0;
        s1 = peg$f18(s1);
      }

      s0 = s1;
    }

    return s0;
  }

  function peg$parseDEFINITION_FILE() {
    var s0, s1, s2, s3, s4, s5, s6, s7, s8;

    var rule$expects = function (expected) {
      if (peg$silentFails === 0) peg$expect(expected);
    };

    s0 = peg$currPos;
    s1 = peg$parseNAME();

    if (s1 !== peg$FAILED) {
      s2 = peg$parseNEWLINES();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseORBITS();

        if (s3 !== peg$FAILED) {
          s4 = peg$parseNEWLINES();

          if (s4 !== peg$FAILED) {
            s5 = peg$parseSTART_PIECES();

            if (s5 !== peg$FAILED) {
              s6 = peg$parseNEWLINES();

              if (s6 !== peg$FAILED) {
                s7 = peg$parseMOVES();

                if (s7 !== peg$FAILED) {
                  s8 = peg$parseOPTIONAL_NEWLINES();
                  peg$savedPos = s0;
                  s0 = peg$f19(s1, s3, s5, s7);
                } else {
                  peg$currPos = s0;
                  s0 = peg$FAILED;
                }
              } else {
                peg$currPos = s0;
                s0 = peg$FAILED;
              }
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function fixPermutation(permutation) {
    return permutation.map(x => x - 1);
  }

  function fixMoves(def) {
    for (const moveName in def.moves) {
      const move = def.moves[moveName];

      for (const orbitName in def.orbits) {
        const moveOrbit = move[orbitName];
        const oldOrientation = moveOrbit.orientation;
        const perm = moveOrbit.permutation;
        const newOrientation = new Array(oldOrientation.length);

        for (let i = 0; i < perm.length; i++) {
          newOrientation[i] = oldOrientation[perm[i]];
        }

        moveOrbit.orientation = newOrientation;
      }
    }

    return def;
  }

  peg$begin();
  peg$result = peg$startRuleFunction();

  if (peg$result !== peg$FAILED && peg$currPos === input.length) {
    return peg$result;
  } else {
    if (peg$result !== peg$FAILED && peg$currPos < input.length) {
      peg$expect(peg$endExpectation());
    }

    throw peg$buildError();
  }
}

module.exports = {
  SyntaxError: peg$SyntaxError,
  parse: peg$parse
};
},{}],"4ERPh":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.KPuzzleSVGWrapper = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

// TODO
const xmlns = "http://www.w3.org/2000/svg"; // Unique ID mechanism to keep SVG gradient element IDs unique. TODO: Is there
// something more performant, and that can't be broken by other elements of the
// page? (And also doesn't break if this library is run in parallel.)

let svgCounter = 0;

function nextSVGID() {
  svgCounter += 1;
  return "svg" + svgCounter.toString();
} // TODO: This is hardcoded to 3x3x3 SVGs


const colorMaps = {
  dim: {
    "white": "#dddddd",
    "orange": "#884400",
    "limegreen": "#008800",
    "red": "#660000",
    "rgb(34, 102, 255)": "#000088",
    // TODO
    "yellow": "#888800"
  },
  oriented: {
    "white": "#ff88ff",
    "orange": "#ff88ff",
    "limegreen": "#ff88ff",
    "red": "#ff88ff",
    "rgb(34, 102, 255)": "#ff88ff",
    // TODO
    "yellow": "#ff88ff"
  },
  ignored: {
    "white": "#444444",
    "orange": "#444444",
    "limegreen": "#444444",
    "red": "#444444",
    "rgb(34, 102, 255)": "#444444",
    // TODO
    "yellow": "#444444"
  },
  invisible: {
    "white": "#00000000",
    "orange": "#00000000",
    "limegreen": "#00000000",
    "red": "#00000000",
    "rgb(34, 102, 255)": "#00000000",
    // TODO
    "yellow": "#00000000"
  }
};

class KPuzzleSVGWrapper {
  constructor(kPuzzleDefinition, svgSource, experimentalAppearance) {
    this.kPuzzleDefinition = kPuzzleDefinition;
    (0, _defineProperty2.default)(this, "element", void 0);
    (0, _defineProperty2.default)(this, "gradientDefs", void 0);
    (0, _defineProperty2.default)(this, "originalColors", {});
    (0, _defineProperty2.default)(this, "gradients", {});
    (0, _defineProperty2.default)(this, "svgID", void 0);

    if (!svgSource) {
      throw new Error(`No SVG definition for puzzle type: ${kPuzzleDefinition.name}`);
    }

    this.svgID = nextSVGID();
    this.element = document.createElement("div");
    this.element.classList.add("svg-wrapper"); // TODO: Sanitization.

    this.element.innerHTML = svgSource;
    const svgElem = this.element.querySelector("svg");

    if (!svgElem) {
      throw new Error("Could not get SVG element");
    }

    if (xmlns !== svgElem.namespaceURI) {
      throw new Error("Unexpected XML namespace");
    }

    svgElem.style.maxWidth = "100%";
    svgElem.style.maxHeight = "100%";
    this.gradientDefs = document.createElementNS(xmlns, "defs");
    svgElem.insertBefore(this.gradientDefs, svgElem.firstChild);

    for (const orbitName in kPuzzleDefinition.orbits) {
      const orbitDefinition = kPuzzleDefinition.orbits[orbitName];

      for (let idx = 0; idx < orbitDefinition.numPieces; idx++) {
        for (let orientation = 0; orientation < orbitDefinition.orientations; orientation++) {
          const id = this.elementID(orbitName, idx, orientation);
          const elem = this.elementByID(id);
          let originalColor = elem.style.fill; /// TODO: Allow setting appearance dynamically.

          if (experimentalAppearance) {
            (() => {
              // TODO: dedup with Cube3D,,factor out fallback calculations
              const a = experimentalAppearance.orbits;

              if (!a) {
                return;
              }

              const orbitAppearance = a[orbitName];

              if (!orbitAppearance) {
                return;
              }

              const pieceAppearance = orbitAppearance.pieces[idx];

              if (!pieceAppearance) {
                return;
              }

              const faceletAppearance = pieceAppearance.facelets[orientation];

              if (!faceletAppearance) {
                return;
              }

              const appearance = typeof faceletAppearance === "string" ? faceletAppearance : faceletAppearance === null || faceletAppearance === void 0 ? void 0 : faceletAppearance.appearance;
              const colorMap = colorMaps[appearance];

              if (colorMap) {
                originalColor = colorMap[originalColor];
              }
            })();
          } else {
            originalColor = elem.style.fill;
          }

          this.originalColors[id] = originalColor;
          this.gradients[id] = this.newGradient(id, originalColor);
          this.gradientDefs.appendChild(this.gradients[id]);
          elem.setAttribute("style", `fill: url(#grad-${this.svgID}-${id})`);
        }
      }
    }
  }

  drawKPuzzle(kpuzzle, nextState, fraction) {
    this.draw(kpuzzle.definition, kpuzzle.state, nextState, fraction);
  } // TODO: save definition in the constructor?


  draw(definition, state, nextState, fraction) {
    for (const orbitName in definition.orbits) {
      const orbitDefinition = definition.orbits[orbitName];
      const curOrbitState = state[orbitName];
      const nextOrbitState = nextState ? nextState[orbitName] : null;

      for (let idx = 0; idx < orbitDefinition.numPieces; idx++) {
        for (let orientation = 0; orientation < orbitDefinition.orientations; orientation++) {
          const id = this.elementID(orbitName, idx, orientation);
          const fromCur = this.elementID(orbitName, curOrbitState.permutation[idx], (orbitDefinition.orientations - curOrbitState.orientation[idx] + orientation) % orbitDefinition.orientations);
          let singleColor = false;

          if (nextOrbitState) {
            const fromNext = this.elementID(orbitName, nextOrbitState.permutation[idx], (orbitDefinition.orientations - nextOrbitState.orientation[idx] + orientation) % orbitDefinition.orientations);

            if (fromCur === fromNext) {
              singleColor = true; // TODO: Avoid redundant work during move.
            }

            fraction = fraction || 0; // TODO Use the type system to tie this to nextState?

            const easedBackwardsPercent = 100 * (1 - fraction * fraction * (2 - fraction * fraction)); // TODO: Move easing up the stack.

            this.gradients[id].children[0].setAttribute("stop-color", this.originalColors[fromCur]);
            this.gradients[id].children[1].setAttribute("stop-color", this.originalColors[fromCur]);
            this.gradients[id].children[1].setAttribute("offset", `${Math.max(easedBackwardsPercent - 5, 0)}%`);
            this.gradients[id].children[2].setAttribute("offset", `${Math.max(easedBackwardsPercent - 5, 0)}%`);
            this.gradients[id].children[3].setAttribute("offset", `${easedBackwardsPercent}%`);
            this.gradients[id].children[4].setAttribute("offset", `${easedBackwardsPercent}%`);
            this.gradients[id].children[4].setAttribute("stop-color", this.originalColors[fromNext]);
            this.gradients[id].children[5].setAttribute("stop-color", this.originalColors[fromNext]);
          } else {
            singleColor = true; // TODO: Avoid redundant work during move.
          }

          if (singleColor) {
            this.gradients[id].children[0].setAttribute("stop-color", this.originalColors[fromCur]);
            this.gradients[id].children[1].setAttribute("stop-color", this.originalColors[fromCur]);
            this.gradients[id].children[1].setAttribute("offset", `100%`);
            this.gradients[id].children[2].setAttribute("offset", `100%`);
            this.gradients[id].children[3].setAttribute("offset", `100%`);
            this.gradients[id].children[4].setAttribute("offset", `100%`);
          } // this.gradients[id]
          // this.elementByID(id).style.fill = this.originalColors[from];

        }
      }
    }
  }

  newGradient(id, originalColor) {
    const grad = document.createElementNS(xmlns, "radialGradient");
    grad.setAttribute("id", `grad-${this.svgID}-${id}`);
    grad.setAttribute("r", `70.7107%`); // TODO: Adapt to puzzle.

    const stopDefs = [{
      offset: 0,
      color: originalColor
    }, {
      offset: 0,
      color: originalColor
    }, {
      offset: 0,
      color: "black"
    }, {
      offset: 0,
      color: "black"
    }, {
      offset: 0,
      color: originalColor
    }, {
      offset: 100,
      color: originalColor
    }];

    for (const stopDef of stopDefs) {
      const stop = document.createElementNS(xmlns, "stop");
      stop.setAttribute("offset", `${stopDef.offset}%`);
      stop.setAttribute("stop-color", stopDef.color);
      stop.setAttribute("stop-opacity", "1");
      grad.appendChild(stop);
    }

    return grad;
  }

  elementID(orbitName, idx, orientation) {
    return orbitName + "-l" + idx + "-o" + orientation;
  }

  elementByID(id) {
    // TODO: Use classes and scope selector to SVG element.
    return this.element.querySelector("#" + id);
  }

}

exports.KPuzzleSVGWrapper = KPuzzleSVGWrapper;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs"}],"1TGyt":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.experimentalIs3x3x3Solved = experimentalIs3x3x3Solved;

var _protocol = require("../protocol");

var _puzzles = require("../puzzles");

var _transformations = require("./transformations");

// The `options` argument is required for now, because we haven't yet come up
// with a general way to specify different kinds of solved for the same puzle.
function experimentalIs3x3x3Solved(transformation, options) {
  const normalized = (0, _protocol.experimentalNormalizePuzzleOrientation)(transformation);

  if (options.ignoreCenterOrientation) {
    return (0, _transformations.areOrbitTransformationsEquivalent)(_puzzles.experimentalCube3x3x3KPuzzle, "EDGES", normalized, _puzzles.experimentalCube3x3x3KPuzzle.startPieces) && (0, _transformations.areOrbitTransformationsEquivalent)(_puzzles.experimentalCube3x3x3KPuzzle, "CORNERS", normalized, _puzzles.experimentalCube3x3x3KPuzzle.startPieces);
  } else {
    return (0, _transformations.areTransformationsEquivalent)(_puzzles.experimentalCube3x3x3KPuzzle, normalized, _puzzles.experimentalCube3x3x3KPuzzle.startPieces);
  }
}
},{"../protocol":"3fpj8","../puzzles":"KrRHt","./transformations":"46EZC"}],"3fpj8":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
Object.defineProperty(exports, "reid3x3x3ToTwizzleBinary", {
  enumerable: true,
  get: function () {
    return _binary3x3x.reid3x3x3ToTwizzleBinary;
  }
});
Object.defineProperty(exports, "twizzleBinaryToReid3x3x3", {
  enumerable: true,
  get: function () {
    return _binary3x3x.twizzleBinaryToReid3x3x3;
  }
});
Object.defineProperty(exports, "bufferToSpacedHex", {
  enumerable: true,
  get: function () {
    return _hex.bufferToSpacedHex;
  }
});
Object.defineProperty(exports, "spacedHexToBuffer", {
  enumerable: true,
  get: function () {
    return _hex.spacedHexToBuffer;
  }
});
Object.defineProperty(exports, "experimentalNormalizePuzzleOrientation", {
  enumerable: true,
  get: function () {
    return _puzzleOrientation.normalizePuzzleOrientation;
  }
});

var _binary3x3x = require("./binary/binary3x3x3");

var _hex = require("./binary/hex");

var _puzzleOrientation = require("./binary/puzzle-orientation");
},{"./binary/binary3x3x3":"1ZIFw","./binary/hex":"6VPfj","./binary/puzzle-orientation":"6loUV"}],"1ZIFw":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.reid3x3x3ToBinaryComponents = reid3x3x3ToBinaryComponents;
exports.binaryComponentsToTwizzleBinary = binaryComponentsToTwizzleBinary;
exports.reid3x3x3ToTwizzleBinary = reid3x3x3ToTwizzleBinary;
exports.twizzleBinaryToBinaryComponents = twizzleBinaryToBinaryComponents;
exports.binaryComponentsToReid3x3x3 = binaryComponentsToReid3x3x3;
exports.twizzleBinaryToReid3x3x3 = twizzleBinaryToReid3x3x3;

var _orbitIndexing = require("./orbit-indexing");

var _puzzleOrientation = require("./puzzle-orientation");

// Bit lengths of the encoded components, in order.
const BIT_LENGTHS = [29, 12, 16, 13, 3, 2, 1, 12]; // These fields are sorted by the order in which they appear in the binary format.

// There are various clever ways to do this, but this is simple and efficient.
function arraySum(arr) {
  let total = 0;

  for (const entry of arr) {
    total += entry;
  }

  return total;
} // Due to limitations in JS bit operations, this is unsafe if any of the bit lengths span across the contents of more than 4 bytes.
// - Safe: [8, 32]
// - Unsafe: [4, 32, 4]
// - Unsafe: [40, 4]


function splitBinary(bitLengths, buffy) {
  const u8buffy = new Uint8Array(buffy);
  let at = 0;
  let bits = 0;
  let accum = 0;
  const values = [];

  for (const bitLength of bitLengths) {
    while (bits < bitLength) {
      accum = accum << 8 | u8buffy[at++];
      bits += 8;
    }

    values.push(accum >> bits - bitLength & (1 << bitLength) - 1);
    bits -= bitLength;
  }

  return values;
} // See above for safety notes.


function concatBinary(bitLengths, values) {
  const buffy = new Uint8Array(Math.ceil(arraySum(bitLengths) / 8));
  let at = 0;
  let bits = 0;
  let accum = 0;

  for (let i = 0; i < bitLengths.length; i++) {
    accum = accum << bitLengths[i] | values[i];
    bits += bitLengths[i];

    while (bits >= 8) {
      buffy[at++] = accum >> bits - 8;
      bits -= 8;
    }
  }

  if (bits > 0) {
    buffy[at++] = accum << 8 - bits;
  }

  return buffy;
} // 0x111 (for idxU) means "not supported"


function supportsPuzzleOrientation(components) {
  return components.poIdxU !== 7;
}

function reid3x3x3ToBinaryComponents(state) {
  const normedState = (0, _puzzleOrientation.normalizePuzzleOrientation)(state);
  const epLex = (0, _orbitIndexing.permutationToLex)(normedState["EDGES"].permutation);
  const eoMask = (0, _orbitIndexing.orientationsToMask)(2, normedState["EDGES"].orientation);
  const cpLex = (0, _orbitIndexing.permutationToLex)(normedState["CORNERS"].permutation);
  const coMask = (0, _orbitIndexing.orientationsToMask)(3, normedState["CORNERS"].orientation);
  const [poIdxU, poIdxL] = (0, _puzzleOrientation.puzzleOrientationIdx)(state);
  const moSupport = 1; // Required for now.

  const moMask = (0, _orbitIndexing.orientationsToMask)(4, normedState["CENTERS"].orientation);
  return {
    epLex,
    eoMask,
    cpLex,
    coMask,
    poIdxU,
    poIdxL,
    moSupport,
    moMask
  };
}

function binaryComponentsToTwizzleBinary(components) {
  const {
    epLex,
    eoMask,
    cpLex,
    coMask,
    poIdxU,
    poIdxL,
    moSupport,
    moMask
  } = components;
  return concatBinary(BIT_LENGTHS, [epLex, eoMask, cpLex, coMask, poIdxU, poIdxL, moSupport, moMask]);
}

function reid3x3x3ToTwizzleBinary(state) {
  const components = reid3x3x3ToBinaryComponents(state);
  return binaryComponentsToTwizzleBinary(components);
}

function twizzleBinaryToBinaryComponents(buffer) {
  const [epLex, eoMask, cpLex, coMask, poIdxU, poIdxL, moSupport, moMask] = splitBinary(BIT_LENGTHS, buffer);
  return {
    epLex,
    eoMask,
    cpLex,
    coMask,
    poIdxU,
    poIdxL,
    moSupport,
    moMask
  };
}

function binaryComponentsToReid3x3x3(components) {
  if (components.moSupport !== 1) {
    throw new Error("Must support center orientation.");
  }

  const normedState = {
    EDGES: {
      permutation: (0, _orbitIndexing.lexToPermutation)(12, components.epLex),
      orientation: (0, _orbitIndexing.maskToOrientations)(2, 12, components.eoMask)
    },
    CORNERS: {
      permutation: (0, _orbitIndexing.lexToPermutation)(8, components.cpLex),
      orientation: (0, _orbitIndexing.maskToOrientations)(3, 8, components.coMask)
    },
    CENTERS: {
      permutation: (0, _orbitIndexing.identityPermutation)(6),
      orientation: (0, _orbitIndexing.maskToOrientations)(4, 6, components.moMask)
    }
  };

  if (!supportsPuzzleOrientation(components)) {
    return normedState;
  }

  return (0, _puzzleOrientation.reorientPuzzle)(normedState, components.poIdxU, components.poIdxL);
} // Returns a list of error string.
// An empty list means validation success.


function validateComponents(components) {
  const errors = [];

  if (components.epLex < 0 || components.epLex >= 479001600) {
    errors.push(`epLex (${components.epLex}) out of range`);
  }

  if (components.cpLex < 0 || components.cpLex >= 40320) {
    errors.push(`cpLex (${components.cpLex}) out of range`);
  }

  if (components.coMask < 0 || components.coMask >= 6561) {
    errors.push(`coMask (${components.coMask}) out of range`);
  }

  if (components.poIdxU < 0 || components.poIdxU >= 6) {
    // 0x111 (for idxU) means "not supported"
    if (supportsPuzzleOrientation(components)) {
      errors.push(`poIdxU (${components.poIdxU}) out of range`);
    }
  } // The following cannot be (f decoded from binary properl) out of rangey.


  if (components.eoMask < 0 || components.eoMask >= 4096) {
    errors.push(`eoMask (${components.eoMask}) out of range`);
  }

  if (components.moMask < 0 || components.moMask >= 4096) {
    errors.push(`moMask (${components.moMask}) out of range`);
  }

  if (components.poIdxL < 0 || components.poIdxL >= 4) {
    errors.push(`poIdxL (${components.poIdxL}) out of range`);
  }

  if (components.moSupport < 0 || components.moSupport >= 2) {
    errors.push(`moSupport (${components.moSupport}) out of range`);
  }

  return errors;
}

function twizzleBinaryToReid3x3x3(buffy) {
  const components = twizzleBinaryToBinaryComponents(buffy);
  const errors = validateComponents(components);

  if (errors.length !== 0) {
    throw new Error(`Invalid binary state components: ${errors.join(", ")}`);
  }

  return binaryComponentsToReid3x3x3(components);
}
},{"./orbit-indexing":"X11l8","./puzzle-orientation":"6loUV"}],"X11l8":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.identityPermutation = identityPermutation;
exports.orientationsToMask = orientationsToMask;
exports.maskToOrientations = maskToOrientations;
exports.permutationToLex = permutationToLex;
exports.lexToPermutation = lexToPermutation;

function identityPermutation(numElems) {
  const arr = new Array(numElems);

  for (let i = 0; i < numElems; i++) {
    arr[i] = i;
  }

  return arr;
} // Inclusive start, exclusive end (similar to `Array.prototype.slice`)


function orientationsToMask(radix, orientations) {
  let val = 0;

  for (const orientation of orientations) {
    val *= radix;
    val += orientation;
  }

  return val;
} // Inclusive start, exclusive end (similar to `Array.prototype.slice`)


function maskToOrientations(radix, numElems, mask) {
  const arr = [];

  while (mask > 0) {
    arr.push(mask % radix);
    mask = Math.floor(mask / radix);
  }

  return new Array(numElems - arr.length).fill(0).concat(arr.reverse());
} // From https://www.jaapsch.net/puzzles/compindx.htm#perm


function permutationToLex(permutation) {
  const n = permutation.length;
  let lexicographicIdx = 0;

  for (let i = 0; i < n - 1; i++) {
    lexicographicIdx = lexicographicIdx * (n - i);

    for (let j = i + 1; j < n; j++) {
      if (permutation[i] > permutation[j]) {
        lexicographicIdx += 1;
      }
    }
  }

  return lexicographicIdx;
} // From https://www.jaapsch.net/puzzles/compindx.htm#perm


function lexToPermutation(numPieces, lexicographicIdx) {
  const permutation = new Array(numPieces);
  permutation[numPieces - 1] = 0;

  for (let i = numPieces - 2; i >= 0; i--) {
    permutation[i] = lexicographicIdx % (numPieces - i);
    lexicographicIdx = Math.floor(lexicographicIdx / (numPieces - i));

    for (let j = i + 1; j < numPieces; j++) {
      if (permutation[j] >= permutation[i]) {
        permutation[j] = permutation[j] + 1;
      }
    }
  }

  return permutation;
}
},{}],"6loUV":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.puzzleOrientationIdx = puzzleOrientationIdx;
exports.normalizePuzzleOrientation = normalizePuzzleOrientation;
exports.reorientPuzzle = reorientPuzzle;

var _alg = require("../../alg");

var _kpuzzle = require("../../kpuzzle");

var _puzzles = require("../../puzzles");

// TODO: Should we expose this directly in the `puzzles` package for sync uses?
function puzzleOrientationIdx(state) {
  const idxU = state["CENTERS"].permutation[0];
  const idxD = state["CENTERS"].permutation[5];
  const unadjustedIdxL = state["CENTERS"].permutation[1];
  let idxL = unadjustedIdxL;

  if (idxU < unadjustedIdxL) {
    idxL--;
  }

  if (idxD < unadjustedIdxL) {
    idxL--;
  }

  return [idxU, idxL];
}

const puzzleOrientationCache = new Array(6).fill(0).map(() => {
  return new Array(6);
}); // We use a new block to avoid keeping a reference to temporary vars.

{
  const orientationKpuzzle = new _kpuzzle.KPuzzle(_puzzles.experimentalCube3x3x3KPuzzle);
  const uAlgs = ["", "z", "x", "z'", "x'", "x2"].map(s => _alg.Alg.fromString(s));
  const yAlg = new _alg.Alg("y");

  for (const uAlg of uAlgs) {
    orientationKpuzzle.reset();
    orientationKpuzzle.applyAlg(uAlg);

    for (let i = 0; i < 4; i++) {
      orientationKpuzzle.applyAlg(yAlg);
      const [idxU, idxL] = puzzleOrientationIdx(orientationKpuzzle.state);
      puzzleOrientationCache[idxU][idxL] = (0, _kpuzzle.invertTransformation)(_puzzles.experimentalCube3x3x3KPuzzle, orientationKpuzzle.state);
    }
  }
}

function normalizePuzzleOrientation(s) {
  const [idxU, idxL] = puzzleOrientationIdx(s);
  const orientationTransformation = puzzleOrientationCache[idxU][idxL];
  return (0, _kpuzzle.combineTransformations)(_puzzles.experimentalCube3x3x3KPuzzle, s, orientationTransformation);
} // TODO: combine with `orientPuzzle`?


function reorientPuzzle(s, idxU, idxL) {
  const orientationTransformation = (0, _kpuzzle.invertTransformation)(_puzzles.experimentalCube3x3x3KPuzzle, puzzleOrientationCache[idxU][idxL]);
  return (0, _kpuzzle.combineTransformations)(_puzzles.experimentalCube3x3x3KPuzzle, s, orientationTransformation);
}
},{"../../alg":"7Ff6b","../../kpuzzle":"4ZRD3","../../puzzles":"KrRHt"}],"6VPfj":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.bufferToSpacedHex = bufferToSpacedHex;
exports.spacedHexToBuffer = spacedHexToBuffer;

function bufferToSpacedHex(buffer) {
  // buffer is an ArrayBuffer
  return Array.prototype.map.call(new Uint8Array(buffer), x => ("00" + x.toString(16)).slice(-2)).join(" ");
}

function spacedHexToBuffer(hex) {
  return new Uint8Array(hex.split(" ").map(c => parseInt(c, 16)));
}
},{}],"6zX65":[function(require,module,exports) {
module.exports = Promise.all([require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "7Dnmr")), require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "MI02Q"))]).then(function () {
  return module.bundle.root('5yKvQ');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}],"4VAEe":[function(require,module,exports) {
const cacheLoader = require('../../cacheLoader');

module.exports = cacheLoader(function loadJSBundle(bundle) {
  return new Promise(function(resolve, reject) {
    var script = document.createElement('script');
    script.async = true;
    script.type = 'text/javascript';
    script.charset = 'utf-8';
    script.src = bundle;
    script.onerror = function(e) {
      script.onerror = script.onload = null;
      reject(e);
    };

    script.onload = function() {
      script.onerror = script.onload = null;
      resolve();
    };

    document.getElementsByTagName('head')[0].appendChild(script);
  });
});

},{"../../cacheLoader":"1RHsB"}],"1RHsB":[function(require,module,exports) {
"use strict";

let cachedBundles = {};
let cachedPreloads = {};
let cachedPrefetches = {};

function getCache(type) {
  switch (type) {
    case 'preload':
      return cachedPreloads;

    case 'prefetch':
      return cachedPrefetches;

    default:
      return cachedBundles;
  }
}

module.exports = function (loader, type) {
  return function (bundle) {
    let cache = getCache(type);

    if (cache[bundle]) {
      return cache[bundle];
    }

    return cache[bundle] = loader.apply(null, arguments).catch(function (e) {
      delete cache[bundle];
      throw e;
    });
  };
};
},{}],"6DN1D":[function(require,module,exports) {
"use strict";

/* globals document:readonly */
var bundleURL = null;

function getBundleURLCached() {
  if (!bundleURL) {
    bundleURL = getBundleURL();
  }

  return bundleURL;
}

function getBundleURL() {
  try {
    throw new Error();
  } catch (err) {
    var matches = ('' + err.stack).match(/(https?|file|ftp):\/\/[^)\n]+/g);

    if (matches) {
      return getBaseURL(matches[0]);
    }
  }

  return '/';
}

function getBaseURL(url) {
  return ('' + url).replace(/^((?:https?|file|ftp):\/\/.+)\/[^/]+$/, '$1') + '/';
} // TODO: Replace uses with `new URL(url).origin` when ie11 is no longer supported.


function getOrigin(url) {
  let matches = ('' + url).match(/(https?|file|ftp):\/\/[^/]+/);

  if (!matches) {
    throw new Error('Origin not found');
  }

  return matches[0];
}

exports.getBundleURL = getBundleURLCached;
exports.getBaseURL = getBaseURL;
exports.getOrigin = getOrigin;
},{}],"15JI3":[function(require,module,exports) {
"use strict";

var resolve = require('./bundle-manifest').resolve;

module.exports = function (fromId, toId) {
  return relative(dirname(resolve(fromId)), resolve(toId));
};

function dirname(_filePath) {
  if (_filePath === '') {
    return '.';
  }

  var filePath = _filePath[_filePath.length - 1] === '/' ? _filePath.slice(0, _filePath.length - 1) : _filePath;
  var slashIndex = filePath.lastIndexOf('/');
  return slashIndex === -1 ? '.' : filePath.slice(0, slashIndex);
}

function relative(from, to) {
  if (from === to) {
    return '';
  }

  var fromParts = from.split('/');

  if (fromParts[0] === '.') {
    fromParts.shift();
  }

  var toParts = to.split('/');

  if (toParts[0] === '.') {
    toParts.shift();
  } // Find where path segments diverge.


  var i;
  var divergeIndex;

  for (i = 0; (i < toParts.length || i < fromParts.length) && divergeIndex == null; i++) {
    if (fromParts[i] !== toParts[i]) {
      divergeIndex = i;
    }
  } // If there are segments from "from" beyond the point of divergence,
  // return back up the path to that point using "..".


  var parts = [];

  for (i = 0; i < fromParts.length - divergeIndex; i++) {
    parts.push('..');
  } // If there are segments from "to" beyond the point of divergence,
  // continue using the remaining segments.


  if (toParts.length > divergeIndex) {
    parts.push.apply(parts, toParts.slice(divergeIndex));
  }

  return parts.join('/');
}

module.exports._dirname = dirname;
module.exports._relative = relative;
},{"./bundle-manifest":"345Oh"}],"4tzuE":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.cube2x2x2 = void 0;

var _interopRequireWildcard2 = _interopRequireDefault(require("@babel/runtime/helpers/interopRequireWildcard"));

var _asyncPg3d = require("../../async/async-pg3d");

var _cubeStickerings = require("../../stickerings/cube-stickerings");

const cube2x2x2 = {
  id: "2x2x2",
  fullName: "2×2×2 Cube",
  def: async () => {
    return await Promise.resolve().then(() => require("./2x2x2.kpuzzle.json")).then($parcel$f2a1 => (0, _interopRequireWildcard2.default)($parcel$f2a1));
  },
  svg: async () => {
    return (await Promise.resolve().then(() => require("./2x2x2.kpuzzle.svg")).then($parcel$ffc0 => (0, _interopRequireWildcard2.default)($parcel$ffc0))).default;
  },
  pg: async () => {
    return (0, _asyncPg3d.asyncGetPuzzleGeometry)("2x2x2");
  },
  appearance: stickering => (0, _cubeStickerings.cubeAppearance)(cube2x2x2, stickering),
  stickerings: _cubeStickerings.cubeStickerings
};
exports.cube2x2x2 = cube2x2x2;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/interopRequireWildcard":"6tmXR","../../async/async-pg3d":"2rjP0","../../stickerings/cube-stickerings":"4zcrv","./2x2x2.kpuzzle.json":"4qi8E","./2x2x2.kpuzzle.svg":"3UKkd"}],"4qi8E":[function(require,module,exports) {
module.exports = require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "6fslj")).then(function () {
  return module.bundle.root('daFto');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}],"3UKkd":[function(require,module,exports) {
module.exports = require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "6fdbU")).then(function () {
  return module.bundle.root('7JLFp');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}],"3PKaG":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.cube3x3x3 = void 0;

var _interopRequireWildcard2 = _interopRequireDefault(require("@babel/runtime/helpers/interopRequireWildcard"));

var _asyncPg3d = require("../../async/async-pg3d");

var _cubeStickerings = require("../../stickerings/cube-stickerings");

var _x3x3Kpuzzle = require("./3x3x3.kpuzzle.json_");

// Include 3x3x3 in the main bundle for better performance.
const cube3x3x3 = {
  id: "3x3x3",
  fullName: "3×3×3 Cube",
  inventedBy: ["Ernő Rubik"],
  inventionYear: 1974,
  // https://en.wikipedia.org/wiki/Rubik%27s_Cube#Conception_and_development
  def: async () => {
    // return await import("./3x3x3.kpuzzle.json");
    return _x3x3Kpuzzle.cube3x3x3KPuzzle;
  },
  svg: async () => {
    return (await Promise.resolve().then(() => require("./3x3x3.kpuzzle.svg")).then($parcel$3817 => (0, _interopRequireWildcard2.default)($parcel$3817))).default;
  },
  llSVG: async () => {
    return (await Promise.resolve().then(() => require("./3x3x3-ll.kpuzzle.svg")).then($parcel$a0f0 => (0, _interopRequireWildcard2.default)($parcel$a0f0))).default;
  },
  pg: async () => {
    return (0, _asyncPg3d.asyncGetPuzzleGeometry)("3x3x3");
  },
  appearance: stickering => (0, _cubeStickerings.cubeAppearance)(cube3x3x3, stickering),
  stickerings: _cubeStickerings.cubeStickerings
};
exports.cube3x3x3 = cube3x3x3;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/interopRequireWildcard":"6tmXR","../../async/async-pg3d":"2rjP0","../../stickerings/cube-stickerings":"4zcrv","./3x3x3.kpuzzle.json_":"6pVNo","./3x3x3.kpuzzle.svg":"67a3u","./3x3x3-ll.kpuzzle.svg":"S0EFe"}],"67a3u":[function(require,module,exports) {
module.exports = require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "ke5D9")).then(function () {
  return module.bundle.root('3p3ed');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}],"S0EFe":[function(require,module,exports) {
module.exports = require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "6Lx8x")).then(function () {
  return module.bundle.root('2xuQ9');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}],"1Gu9H":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.clock = void 0;

var _interopRequireWildcard2 = _interopRequireDefault(require("@babel/runtime/helpers/interopRequireWildcard"));

const clock = {
  id: "clock",
  fullName: "Clock",
  inventedBy: ["Christopher C. Wiggs", "Christopher J. Taylor"],
  inventionYear: 1988,
  // Patent application year: https://www.jaapsch.net/puzzles/patents/us4869506.pdf
  def: async () => {
    return await Promise.resolve().then(() => require("./clock.kpuzzle.json")).then($parcel$dd20 => (0, _interopRequireWildcard2.default)($parcel$dd20));
  },
  svg: async () => {
    return (await Promise.resolve().then(() => require("./clock.kpuzzle.svg")).then($parcel$cb43 => (0, _interopRequireWildcard2.default)($parcel$cb43))).default;
  }
};
exports.clock = clock;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/interopRequireWildcard":"6tmXR","./clock.kpuzzle.json":"1mDle","./clock.kpuzzle.svg":"75y7O"}],"1mDle":[function(require,module,exports) {
module.exports = require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "21lhS")).then(function () {
  return module.bundle.root('2TQWn');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}],"75y7O":[function(require,module,exports) {
module.exports = require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "3qrqW")).then(function () {
  return module.bundle.root('4Eeo4');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}],"116IH":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.fto = void 0;

var _asyncPg3d = require("../../async/async-pg3d");

var _ftoStickerings = require("../../stickerings/fto-stickerings");

const fto = (0, _asyncPg3d.genericPGPuzzleLoader)("FTO", "Face-Turning Octahedron", {
  inventedBy: ["Karl Rohrbach", "David Pitcher"],
  // http://twistypuzzles.com/cgi-bin/puzzle.cgi?pkey=1663
  inventionYear: 1983 // http://twistypuzzles.com/cgi-bin/puzzle.cgi?pkey=1663

}); // TODO: loading the stickering code async.

exports.fto = fto;

fto.appearance = stickering => (0, _ftoStickerings.ftoStickering)(fto, stickering);

fto.stickerings = _ftoStickerings.ftoStickerings;
},{"../../async/async-pg3d":"2rjP0","../../stickerings/fto-stickerings":"44hDN"}],"44hDN":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.ftoStickering = ftoStickering;
exports.ftoStickerings = ftoStickerings;

var _appearance = require("./appearance");

async function ftoStickering(puzzleLoader, stickering) {
  const def = await puzzleLoader.def();
  const puzzleStickering = new _appearance.PuzzleStickering(def);
  const m = new _appearance.StickeringManager(def);

  const experimentalFTO_FC = () => m.and([m.move("U"), m.not(m.or(m.moves(["F", "BL", "BR"])))]);

  const experimentalFTO_F2T = () => m.and([m.move("U"), m.not(m.move("F"))]);

  const experimentalFTO_SC = () => m.or([experimentalFTO_F2T(), m.and([m.move("F"), m.not(m.or(m.moves(["U", "BL", "BR"])))])]);

  const experimentalFTO_L2C = () => m.not(m.or([m.and([m.move("U"), m.move("F")]), m.and([m.move("F"), m.move("BL")]), m.and([m.move("F"), m.move("BR")]), m.and([m.move("BL"), m.move("BR")])]));

  const experimentalFTO_LBT = () => m.not(m.or([m.and([m.move("F"), m.move("BL")]), m.and([m.move("F"), m.move("BR")])]));

  switch (stickering) {
    case "full":
      break;

    case "experimental-fto-fc":
      puzzleStickering.set(m.not(experimentalFTO_FC()), _appearance.PieceStickering.Ignored);
      break;

    case "experimental-fto-f2t":
      puzzleStickering.set(m.not(experimentalFTO_F2T()), _appearance.PieceStickering.Ignored);
      break;

    case "experimental-fto-sc":
      puzzleStickering.set(m.not(experimentalFTO_SC()), _appearance.PieceStickering.Ignored);
      break;

    case "experimental-fto-l2c":
      puzzleStickering.set(m.not(experimentalFTO_L2C()), _appearance.PieceStickering.Ignored);
      break;

    case "experimental-fto-lbt":
      puzzleStickering.set(m.not(experimentalFTO_LBT()), _appearance.PieceStickering.Ignored);
      break;

    default:
      console.warn(`Unsupported stickering for ${puzzleLoader.id}: ${stickering}. Setting all pieces to dim.`);
      puzzleStickering.set(m.and(m.moves([])), _appearance.PieceStickering.Dim);
  }

  return puzzleStickering.toAppearance();
}

async function ftoStickerings() {
  return ["full", "experimental-fto-fc", "experimental-fto-f2t", "experimental-fto-sc", "experimental-fto-l2c", "experimental-fto-lbt"];
}
},{"./appearance":"7LP72"}],"6MldX":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.megaminx = void 0;

var _asyncPg3d = require("../../async/async-pg3d");

var _megaminxStickerings = require("../../stickerings/megaminx-stickerings");

const megaminx = (0, _asyncPg3d.genericPGPuzzleLoader)("megaminx", "Megaminx", {
  // Too many simultaneous inventors to name.
  inventionYear: 1981 // Earliest date from https://www.jaapsch.net/puzzles/megaminx.htm

}); // TODO: loading the stickering code async.

exports.megaminx = megaminx;

megaminx.appearance = stickering => (0, _megaminxStickerings.megaminxAppearance)(megaminx, stickering);

megaminx.stickerings = _megaminxStickerings.megaminxStickerings;
},{"../../async/async-pg3d":"2rjP0","../../stickerings/megaminx-stickerings":"583SB"}],"583SB":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.megaminxAppearance = megaminxAppearance;
exports.megaminxStickerings = megaminxStickerings;

var _cubeStickerings = require("./cube-stickerings");

// TODO: cache calculations?
async function megaminxAppearance(puzzleLoader, stickering) {
  switch (stickering) {
    case "full":
    case "F2L":
    case "LL":
      return (0, _cubeStickerings.cubeAppearance)(puzzleLoader, stickering);

    default:
      console.warn(`Unsupported stickering for ${puzzleLoader.id}: ${stickering}. Setting all pieces to dim.`);
  }

  return (0, _cubeStickerings.cubeAppearance)(puzzleLoader, "full");
}

async function megaminxStickerings() {
  return ["full", "F2L", "LL"];
}
},{"./cube-stickerings":"4zcrv"}],"7eESQ":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.pyraminx = void 0;

var _interopRequireWildcard2 = _interopRequireDefault(require("@babel/runtime/helpers/interopRequireWildcard"));

const pyraminx = {
  id: "pyraminx",
  fullName: "Pyraminx",
  inventedBy: ["Uwe Meffert"],
  inventionYear: 1970,
  // https://en.wikipedia.org/wiki/Pyraminx#Description
  def: async () => {
    return await Promise.resolve().then(() => require("./pyraminx.kpuzzle.json")).then($parcel$b9e9 => (0, _interopRequireWildcard2.default)($parcel$b9e9));
  },
  svg: async () => {
    return (await Promise.resolve().then(() => require("./pyraminx.kpuzzle.svg")).then($parcel$c5fd => (0, _interopRequireWildcard2.default)($parcel$c5fd))).default;
  }
};
exports.pyraminx = pyraminx;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/interopRequireWildcard":"6tmXR","./pyraminx.kpuzzle.json":"4w01k","./pyraminx.kpuzzle.svg":"29VS3"}],"4w01k":[function(require,module,exports) {
module.exports = require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "3Ca18")).then(function () {
  return module.bundle.root('61SJW');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}],"29VS3":[function(require,module,exports) {
module.exports = require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "6iD2j")).then(function () {
  return module.bundle.root('26iul');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}],"1UC88":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.square1 = void 0;

var _interopRequireWildcard2 = _interopRequireDefault(require("@babel/runtime/helpers/interopRequireWildcard"));

const square1 = {
  id: "square1",
  fullName: "Square-1",
  inventedBy: ["Karel Hršel", "Vojtech Kopský"],
  inventionYear: 1990,
  // Czech patent application year: http://spisy.upv.cz/Patents/FullDocuments/277/277266.pdf
  def: async () => {
    return await Promise.resolve().then(() => require("./sq1-hyperorbit.kpuzzle.json")).then($parcel$283d => (0, _interopRequireWildcard2.default)($parcel$283d));
  },
  svg: async () => {
    return (await Promise.resolve().then(() => require("./sq1-hyperorbit.kpuzzle.svg")).then($parcel$8478 => (0, _interopRequireWildcard2.default)($parcel$8478))).default;
  }
};
exports.square1 = square1;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/interopRequireWildcard":"6tmXR","./sq1-hyperorbit.kpuzzle.json":"z8jir","./sq1-hyperorbit.kpuzzle.svg":"7FEbj"}],"z8jir":[function(require,module,exports) {
module.exports = require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "4tIk8")).then(function () {
  return module.bundle.root('1Y3Jn');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}],"7FEbj":[function(require,module,exports) {
module.exports = require("./loaders/browser/js-loader")(require('./bundle-url').getBundleURL() + require('./relative-path')("7m6Fi", "4mxTC")).then(function () {
  return module.bundle.root('xtqYg');
});
},{"./loaders/browser/js-loader":"4VAEe","./bundle-url":"6DN1D","./relative-path":"15JI3"}]},{},["wg9aG"], null, "parcelRequire0395")

//# sourceMappingURL=index.fd284134.js.map
