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
})({"5yKvQ":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
Object.defineProperty(exports, "Perm", {
  enumerable: true,
  get: function () {
    return _Perm.Perm;
  }
});
Object.defineProperty(exports, "Orbit", {
  enumerable: true,
  get: function () {
    return _PermOriSet.Orbit;
  }
});
Object.defineProperty(exports, "OrbitDef", {
  enumerable: true,
  get: function () {
    return _PermOriSet.OrbitDef;
  }
});
Object.defineProperty(exports, "OrbitsDef", {
  enumerable: true,
  get: function () {
    return _PermOriSet.OrbitsDef;
  }
});
Object.defineProperty(exports, "Transformation", {
  enumerable: true,
  get: function () {
    return _PermOriSet.Transformation;
  }
});
Object.defineProperty(exports, "VisibleState", {
  enumerable: true,
  get: function () {
    return _PermOriSet.VisibleState;
  }
});
Object.defineProperty(exports, "getpuzzle", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.getpuzzle;
  }
});
Object.defineProperty(exports, "getPuzzleGeometryByDesc", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.getPuzzleGeometryByDesc;
  }
});
Object.defineProperty(exports, "getPuzzleGeometryByName", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.getPuzzleGeometryByName;
  }
});
Object.defineProperty(exports, "getpuzzles", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.getpuzzles;
  }
});
Object.defineProperty(exports, "parsedesc", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.parsedesc;
  }
});
Object.defineProperty(exports, "PuzzleGeometry", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.PuzzleGeometry;
  }
});
Object.defineProperty(exports, "StickerDat", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.StickerDat;
  }
});
Object.defineProperty(exports, "StickerDatAxis", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.StickerDatAxis;
  }
});
Object.defineProperty(exports, "StickerDatFace", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.StickerDatFace;
  }
});
Object.defineProperty(exports, "StickerDatSticker", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.StickerDatSticker;
  }
});
Object.defineProperty(exports, "useNewFaceNames", {
  enumerable: true,
  get: function () {
    return _PuzzleGeometry.useNewFaceNames;
  }
});
Object.defineProperty(exports, "Quat", {
  enumerable: true,
  get: function () {
    return _Quat.Quat;
  }
});
Object.defineProperty(exports, "schreierSims", {
  enumerable: true,
  get: function () {
    return _SchreierSims.schreierSims;
  }
});

var _Perm = require("./Perm");

var _PermOriSet = require("./PermOriSet");

var _PuzzleGeometry = require("./PuzzleGeometry");

var _Quat = require("./Quat");

var _SchreierSims = require("./SchreierSims");
},{"./Perm":"VeGsJ","./PermOriSet":"2xFz1","./PuzzleGeometry":"4vHWD","./Quat":"4Jbs3","./SchreierSims":"1ZFXX"}],"VeGsJ":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.zeros = zeros;
exports.iota = iota;
exports.identity = identity;
exports.random = random;
exports.factorial = factorial;
exports.lcm = lcm;
exports.Perm = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

const zeroCache = [];
const iotaCache = [];

function zeros(n) {
  if (!zeroCache[n]) {
    const c = Array(n);

    for (let i = 0; i < n; i++) {
      c[i] = 0;
    }

    zeroCache[n] = c;
  }

  return zeroCache[n];
}

function iota(n) {
  if (!iotaCache[n]) {
    const c = Array(n);

    for (let i = 0; i < n; i++) {
      c[i] = i;
    }

    iotaCache[n] = c;
  }

  return iotaCache[n];
}

function identity(n) {
  return new Perm(iota(n));
}

function random(n) {
  // random
  const c = Array(n);

  for (let i = 0; i < n; i++) {
    c[i] = i;
  }

  for (let i = 0; i < n; i++) {
    const j = i + Math.floor((n - i) * Math.random());
    const t = c[i];
    c[i] = c[j];
    c[j] = t;
  }

  return new Perm(c);
}

function factorial(a) {
  let r = 1;

  while (a > 1) {
    r *= a;
    a--;
  }

  return r;
}

function gcd(a, b) {
  if (a > b) {
    const t = a;
    a = b;
    b = t;
  }

  while (a > 0) {
    const m = b % a;
    b = a;
    a = m;
  }

  return b;
}

function lcm(a, b) {
  return a / gcd(a, b) * b;
}

class Perm {
  // length
  // The permutation itself
  constructor(a) {
    (0, _defineProperty2.default)(this, "n", void 0);
    (0, _defineProperty2.default)(this, "p", void 0);
    this.n = a.length;
    this.p = a;
  }

  toString() {
    // stringify
    return "Perm[" + this.p.join(" ") + "]";
  }

  mul(p2) {
    // multiply
    const c = Array(this.n);

    for (let i = 0; i < this.n; i++) {
      c[i] = p2.p[this.p[i]];
    }

    return new Perm(c);
  }

  rmul(p2) {
    // multiply the other way
    const c = Array(this.n);

    for (let i = 0; i < this.n; i++) {
      c[i] = this.p[p2.p[i]];
    }

    return new Perm(c);
  }

  inv() {
    const c = Array(this.n);

    for (let i = 0; i < this.n; i++) {
      c[this.p[i]] = i;
    }

    return new Perm(c);
  }

  compareTo(p2) {
    // comparison
    for (let i = 0; i < this.n; i++) {
      if (this.p[i] !== p2.p[i]) {
        return this.p[i] - p2.p[i];
      }
    }

    return 0;
  }

  toGap() {
    const cyc = new Array();
    const seen = new Array(this.n);

    for (let i = 0; i < this.p.length; i++) {
      if (seen[i] || this.p[i] === i) {
        continue;
      }

      const incyc = new Array();

      for (let j = i; !seen[j]; j = this.p[j]) {
        incyc.push(1 + j);
        seen[j] = true;
      }

      cyc.push("(" + incyc.join(",") + ")");
    }

    return cyc.join("");
  }

  order() {
    let r = 1;
    const seen = new Array(this.n);

    for (let i = 0; i < this.p.length; i++) {
      if (seen[i] || this.p[i] === i) {
        continue;
      }

      let cs = 0;

      for (let j = i; !seen[j]; j = this.p[j]) {
        cs++;
        seen[j] = true;
      }

      r = lcm(r, cs);
    }

    return r;
  }

}

exports.Perm = Perm;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs"}],"2xFz1":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.showcanon = showcanon;
exports.showcanon0 = showcanon0;
exports.VisibleState = exports.Transformation = exports.TransformationBase = exports.Orbit = exports.OrbitsDef = exports.OrbitDef = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _Perm = require("./Perm");

// TODO

/* tslint:disable no-bitwise */

/* tslint:disable prefer-for-of */
class OrbitDef {
  constructor(size, mod) {
    this.size = size;
    this.mod = mod;
  }

  reassemblySize() {
    return (0, _Perm.factorial)(this.size) * Math.pow(this.mod, this.size);
  }

}

exports.OrbitDef = OrbitDef;

class OrbitsDef {
  constructor(orbitnames, orbitdefs, solved, movenames, moveops) {
    this.orbitnames = orbitnames;
    this.orbitdefs = orbitdefs;
    this.solved = solved;
    this.movenames = movenames;
    this.moveops = moveops;
  }

  transformToKPuzzle(t) {
    const mp = {};

    for (let j = 0; j < this.orbitnames.length; j++) {
      mp[this.orbitnames[j]] = t.orbits[j].toKpuzzle();
    }

    return mp;
  }

  static transformToKPuzzle(orbitnames, t) {
    const mp = {};

    for (let j = 0; j < orbitnames.length; j++) {
      mp[orbitnames[j]] = t.orbits[j].toKpuzzle();
    }

    return mp;
  }

  toKsolve(name) {
    const result = [];
    result.push("Name " + name);
    result.push("");

    for (let i = 0; i < this.orbitnames.length; i++) {
      result.push("Set " + this.orbitnames[i] + " " + this.orbitdefs[i].size + " " + this.orbitdefs[i].mod);
    }

    result.push("");
    result.push("Solved");

    for (let i = 0; i < this.orbitnames.length; i++) {
      this.solved.orbits[i].appendConciseDefinition(result, this.orbitnames[i], true);
    }

    result.push("End");

    for (let i = 0; i < this.movenames.length; i++) {
      result.push("");
      result.push("Move " + this.movenames[i]);

      for (let j = 0; j < this.orbitnames.length; j++) {
        this.moveops[i].orbits[j].appendConciseDefinition(result, this.orbitnames[j], false);
      }

      result.push("End");
    } // extra blank line on end lets us use join("\n") to terminate all


    return result;
  } // TODO: return type.


  toKpuzzle() {
    const orbits = {};
    const start = {};

    for (let i = 0; i < this.orbitnames.length; i++) {
      orbits[this.orbitnames[i]] = {
        numPieces: this.orbitdefs[i].size,
        orientations: this.orbitdefs[i].mod
      };
      start[this.orbitnames[i]] = this.solved.orbits[i].toKpuzzle();
    }

    const moves = {};

    for (let i = 0; i < this.movenames.length; i++) {
      moves[this.movenames[i]] = this.transformToKPuzzle(this.moveops[i]);
    }

    return {
      name: "PG3D",
      orbits,
      startPieces: start,
      moves
    };
  }

  optimize() {
    const neworbitnames = [];
    const neworbitdefs = [];
    const newsolved = [];
    const newmoveops = [];

    for (let j = 0; j < this.moveops.length; j++) {
      newmoveops.push([]);
    }

    for (let i = 0; i < this.orbitdefs.length; i++) {
      const om = this.orbitdefs[i].mod;
      const n = this.orbitdefs[i].size;
      const du = new DisjointUnion(n);
      const changed = new Array(this.orbitdefs[i].size);

      for (let k = 0; k < n; k++) {
        changed[k] = false;
      }

      for (let j = 0; j < this.moveops.length; j++) {
        for (let k = 0; k < n; k++) {
          if (this.moveops[j].orbits[i].perm[k] !== k || this.moveops[j].orbits[i].ori[k] !== 0) {
            changed[k] = true;
            du.union(k, this.moveops[j].orbits[i].perm[k]);
          }
        }
      }

      let keepori = true; // right now we kill ori only if solved is unique and
      // if we can kill it completely.  This is not all the optimization
      // we can perform.

      if (om > 1) {
        keepori = false;
        const duo = new DisjointUnion(this.orbitdefs[i].size * om);

        for (let j = 0; j < this.moveops.length; j++) {
          for (let k = 0; k < n; k++) {
            if (this.moveops[j].orbits[i].perm[k] !== k || this.moveops[j].orbits[i].ori[k] !== 0) {
              for (let o = 0; o < om; o++) {
                duo.union(k * om + o, this.moveops[j].orbits[i].perm[k] * om + (o + this.moveops[j].orbits[i].ori[k]) % om);
              }
            }
          }
        }

        for (let j = 0; !keepori && j < n; j++) {
          for (let o = 1; o < om; o++) {
            if (duo.find(j * om) === duo.find(j * om + o)) {
              keepori = true;
            }
          }
        }

        for (let j = 0; !keepori && j < n; j++) {
          for (let k = 0; k < j; k++) {
            if (this.solved.orbits[i].perm[j] === this.solved.orbits[i].perm[k]) {
              keepori = true;
            }
          }
        }
      } // is there just one result set, or more than one?


      let nontriv = -1;
      let multiple = false;

      for (let j = 0; j < this.orbitdefs[i].size; j++) {
        if (changed[j]) {
          const h = du.find(j);

          if (nontriv < 0) {
            nontriv = h;
          } else if (nontriv !== h) {
            multiple = true;
          }
        }
      }

      for (let j = 0; j < this.orbitdefs[i].size; j++) {
        if (!changed[j]) {
          continue;
        }

        const h = du.find(j);

        if (h !== j) {
          continue;
        }

        const no = [];
        const on = [];
        let nv = 0;

        for (let k = 0; k < this.orbitdefs[i].size; k++) {
          if (du.find(k) === j) {
            no[nv] = k;
            on[k] = nv;
            nv++;
          }
        }

        if (multiple) {
          neworbitnames.push(this.orbitnames[i] + "_p" + j);
        } else {
          neworbitnames.push(this.orbitnames[i]);
        }

        if (keepori) {
          neworbitdefs.push(new OrbitDef(nv, this.orbitdefs[i].mod));
          newsolved.push(this.solved.orbits[i].remapVS(no, nv));

          for (let k = 0; k < this.moveops.length; k++) {
            newmoveops[k].push(this.moveops[k].orbits[i].remap(no, on, nv));
          }
        } else {
          neworbitdefs.push(new OrbitDef(nv, 1));
          newsolved.push(this.solved.orbits[i].remapVS(no, nv).killOri());

          for (let k = 0; k < this.moveops.length; k++) {
            newmoveops[k].push(this.moveops[k].orbits[i].remap(no, on, nv).killOri());
          }
        }
      }
    }

    return new OrbitsDef(neworbitnames, neworbitdefs, new VisibleState(newsolved), this.movenames, newmoveops.map(_ => new Transformation(_)));
  } // generate a new "solved" position based on scrambling
  // we use an algorithm that should be faster for large puzzles than
  // just picking random moves.


  scramble(n) {
    const pool = [];

    for (let i = 0; i < this.moveops.length; i++) {
      pool[i] = this.moveops[i];
    }

    for (let i = 0; i < pool.length; i++) {
      const j = Math.floor(Math.random() * pool.length);
      const t = pool[i];
      pool[i] = pool[j];
      pool[j] = t;
    }

    if (n < pool.length) {
      n = pool.length;
    }

    for (let i = 0; i < n; i++) {
      const ri = Math.floor(Math.random() * pool.length);
      const rj = Math.floor(Math.random() * pool.length);
      const rm = Math.floor(Math.random() * this.moveops.length);
      pool[ri] = pool[ri].mul(pool[rj]).mul(this.moveops[rm]);

      if (Math.random() < 0.1) {
        // break up parity
        pool[ri] = pool[ri].mul(this.moveops[rm]);
      }
    }

    let s = pool[0];

    for (let i = 1; i < pool.length; i++) {
      s = s.mul(pool[i]);
    }

    this.solved = this.solved.mul(s);
  }

  reassemblySize() {
    let n = 1;

    for (let i = 0; i < this.orbitdefs.length; i++) {
      n *= this.orbitdefs[i].reassemblySize();
    }

    return n;
  }

}

exports.OrbitsDef = OrbitsDef;

class Orbit {
  static e(n, mod) {
    return new Orbit((0, _Perm.iota)(n), (0, _Perm.zeros)(n), mod);
  }

  constructor(perm, ori, orimod) {
    this.perm = perm;
    this.ori = ori;
    this.orimod = orimod;
  }

  mul(b) {
    const n = this.perm.length;
    const newPerm = new Array(n);

    if (this.orimod === 1) {
      for (let i = 0; i < n; i++) {
        newPerm[i] = this.perm[b.perm[i]];
      }

      return new Orbit(newPerm, this.ori, this.orimod);
    } else {
      const newOri = new Array(n);

      for (let i = 0; i < n; i++) {
        newPerm[i] = this.perm[b.perm[i]];
        newOri[i] = (this.ori[b.perm[i]] + b.ori[i]) % this.orimod;
      }

      return new Orbit(newPerm, newOri, this.orimod);
    }
  }

  inv() {
    const n = this.perm.length;
    const newPerm = new Array(n);
    const newOri = new Array(n);

    for (let i = 0; i < n; i++) {
      newPerm[this.perm[i]] = i;
      newOri[this.perm[i]] = (this.orimod - this.ori[i]) % this.orimod;
    }

    return new Orbit(newPerm, newOri, this.orimod);
  }

  equal(b) {
    const n = this.perm.length;

    for (let i = 0; i < n; i++) {
      if (this.perm[i] !== b.perm[i] || this.ori[i] !== b.ori[i]) {
        return false;
      }
    }

    return true;
  } // in-place mutator


  killOri() {
    const n = this.perm.length;

    for (let i = 0; i < n; i++) {
      this.ori[i] = 0;
    }

    this.orimod = 1;
    return this;
  }

  toPerm() {
    const o = this.orimod;

    if (o === 1) {
      return new _Perm.Perm(this.perm);
    }

    const n = this.perm.length;
    const newPerm = new Array(n * o);

    for (let i = 0; i < n; i++) {
      for (let j = 0; j < o; j++) {
        newPerm[i * o + j] = o * this.perm[i] + (this.ori[i] + j) % o;
      }
    }

    return new _Perm.Perm(newPerm);
  } // returns tuple of sets of identical pieces in this orbit


  identicalPieces() {
    const done = [];
    const n = this.perm.length;
    const r = [];

    for (let i = 0; i < n; i++) {
      const v = this.perm[i];

      if (done[v] === undefined) {
        const s = [i];
        done[v] = true;

        for (let j = i + 1; j < n; j++) {
          if (this.perm[j] === v) {
            s.push(j);
          }
        }

        r.push(s);
      }
    }

    return r;
  }

  order() {
    // can be made more efficient
    return this.toPerm().order();
  }

  isIdentity() {
    const n = this.perm.length;

    if (this.perm === (0, _Perm.iota)(n) && this.ori === (0, _Perm.zeros)(n)) {
      return true;
    }

    for (let i = 0; i < n; i++) {
      if (this.perm[i] !== i || this.ori[i] !== 0) {
        return false;
      }
    }

    return true;
  }

  zeroOris() {
    const n = this.perm.length;

    if (this.ori === (0, _Perm.zeros)(n)) {
      return true;
    }

    for (let i = 0; i < n; i++) {
      if (this.ori[i] !== 0) {
        return false;
      }
    }

    return true;
  }

  remap(no, on, nv) {
    const newPerm = new Array(nv);
    const newOri = new Array(nv);

    for (let i = 0; i < nv; i++) {
      newPerm[i] = on[this.perm[no[i]]];
      newOri[i] = this.ori[no[i]];
    }

    return new Orbit(newPerm, newOri, this.orimod);
  }

  remapVS(no, nv) {
    const newPerm = new Array(nv);
    const newOri = new Array(nv);
    let nextNew = 0;
    const reassign = [];

    for (let i = 0; i < nv; i++) {
      const ov = this.perm[no[i]];

      if (reassign[ov] === undefined) {
        reassign[ov] = nextNew++;
      }

      newPerm[i] = reassign[ov];
      newOri[i] = this.ori[no[i]];
    }

    return new Orbit(newPerm, newOri, this.orimod);
  }

  appendConciseDefinition(result, name, useVS) {
    if (this.isIdentity()) {
      return;
    }

    result.push(name);
    result.push(this.perm.map(_ => _ + 1).join(" "));

    if (!this.zeroOris()) {
      if (useVS) {
        const newori = new Array(this.ori.length);

        for (let i = 0; i < newori.length; i++) {
          newori[this.perm[i]] = this.ori[i];
        }

        result.push(newori.join(" "));
      } else {
        result.push(this.ori.join(" "));
      }
    }
  } // TODO: return type


  toKpuzzle() {
    const n = this.perm.length;

    if (this.isIdentity()) {
      if (!Orbit.kcache[n]) {
        Orbit.kcache[n] = {
          permutation: (0, _Perm.iota)(n),
          orientation: (0, _Perm.zeros)(n)
        };
      }

      return Orbit.kcache[n];
    } else {
      return {
        permutation: this.perm,
        orientation: this.ori
      };
    }
  }

}

exports.Orbit = Orbit;
(0, _defineProperty2.default)(Orbit, "kcache", []);

class TransformationBase {
  constructor(orbits) {
    this.orbits = orbits;
  }

  internalMul(b) {
    const newOrbits = [];

    for (let i = 0; i < this.orbits.length; i++) {
      newOrbits.push(this.orbits[i].mul(b.orbits[i]));
    }

    return newOrbits;
  }

  internalInv() {
    const newOrbits = [];

    for (let i = 0; i < this.orbits.length; i++) {
      newOrbits.push(this.orbits[i].inv());
    }

    return newOrbits;
  }

  equal(b) {
    for (let i = 0; i < this.orbits.length; i++) {
      if (!this.orbits[i].equal(b.orbits[i])) {
        return false;
      }
    }

    return true;
  }

  killOri() {
    for (let i = 0; i < this.orbits.length; i++) {
      this.orbits[i].killOri();
    }

    return this;
  }

  toPerm() {
    const perms = new Array();
    let n = 0;

    for (let i = 0; i < this.orbits.length; i++) {
      const p = this.orbits[i].toPerm();
      perms.push(p);
      n += p.n;
    }

    const newPerm = new Array(n);
    n = 0;

    for (let i = 0; i < this.orbits.length; i++) {
      const p = perms[i];

      for (let j = 0; j < p.n; j++) {
        newPerm[n + j] = n + p.p[j];
      }

      n += p.n;
    }

    return new _Perm.Perm(newPerm);
  }

  identicalPieces() {
    const r = [];
    let n = 0;

    for (let i = 0; i < this.orbits.length; i++) {
      const o = this.orbits[i].orimod;
      const s = this.orbits[i].identicalPieces();

      for (let j = 0; j < s.length; j++) {
        r.push(s[j].map(_ => _ * o + n));
      }

      n += o * this.orbits[i].perm.length;
    }

    return r;
  }

  order() {
    let r = 1;

    for (let i = 0; i < this.orbits.length; i++) {
      r = (0, _Perm.lcm)(r, this.orbits[i].order());
    }

    return r;
  }

}

exports.TransformationBase = TransformationBase;

class Transformation extends TransformationBase {
  constructor(orbits) {
    super(orbits);
  }

  mul(b) {
    return new Transformation(this.internalMul(b));
  }

  mulScalar(n) {
    if (n === 0) {
      return this.e();
    } // eslint-disable-next-line @typescript-eslint/no-this-alias


    let t = this;

    if (n < 0) {
      t = t.inv();
      n = -n;
    }

    while ((n & 1) === 0) {
      t = t.mul(t);
      n >>= 1;
    }

    if (n === 1) {
      return t;
    }

    let s = t;
    let r = this.e();

    while (n > 0) {
      if (n & 1) {
        r = r.mul(s);
      }

      if (n > 1) {
        s = s.mul(s);
      }

      n >>= 1;
    }

    return r;
  }

  inv() {
    return new Transformation(this.internalInv());
  }

  e() {
    return new Transformation(this.orbits.map(_ => Orbit.e(_.perm.length, _.orimod)));
  }

}

exports.Transformation = Transformation;

class VisibleState extends TransformationBase {
  constructor(orbits) {
    super(orbits);
  }

  mul(b) {
    return new VisibleState(this.internalMul(b));
  }

} //  Disjoint set union implementation.


exports.VisibleState = VisibleState;

class DisjointUnion {
  constructor(n) {
    this.n = n;
    (0, _defineProperty2.default)(this, "heads", void 0);
    this.heads = new Array(n);

    for (let i = 0; i < n; i++) {
      this.heads[i] = i;
    }
  }

  find(v) {
    let h = this.heads[v];

    if (this.heads[h] === h) {
      return h;
    }

    h = this.find(this.heads[h]);
    this.heads[v] = h;
    return h;
  }

  union(a, b) {
    const ah = this.find(a);
    const bh = this.find(b);

    if (ah < bh) {
      this.heads[bh] = ah;
    } else if (ah > bh) {
      this.heads[ah] = bh;
    }
  }

}

function showcanon(g, disp) {
  // show information for canonical move derivation
  const n = g.moveops.length;

  if (n > 30) {
    throw new Error("Canon info too big for bitmask");
  }

  const orders = [];
  const commutes = [];

  for (let i = 0; i < n; i++) {
    const permA = g.moveops[i];
    orders.push(permA.order());
    let bits = 0;

    for (let j = 0; j < n; j++) {
      if (j === i) {
        continue;
      }

      const permB = g.moveops[j];

      if (permA.mul(permB).equal(permB.mul(permA))) {
        bits |= 1 << j;
      }
    }

    commutes.push(bits);
  }

  let curlev = {};
  curlev[0] = 1;

  for (let d = 0; d < 100; d++) {
    let sum = 0;
    const nextlev = {};
    let uniq = 0;

    for (const sti in curlev) {
      const st = +sti; // string to number

      const cnt = curlev[st];
      sum += cnt;
      uniq++;

      for (let mv = 0; mv < orders.length; mv++) {
        if ((st >> mv & 1) === 0 && (st & commutes[mv] & (1 << mv) - 1) === 0) {
          const nst = st & commutes[mv] | 1 << mv;

          if (nextlev[nst] === undefined) {
            nextlev[nst] = 0;
          }

          nextlev[nst] += (orders[mv] - 1) * cnt;
        }
      }
    }

    disp("" + d + ": canonseq " + sum + " states " + uniq);
    curlev = nextlev;
  }
} // This is a less effective canonicalization (that happens to work fine
// for the 3x3x3).  We include this only for comparison.


function showcanon0(g, disp) {
  // show information for canonical move derivation
  const n = g.moveops.length;

  if (n > 30) {
    throw new Error("Canon info too big for bitmask");
  }

  const orders = [];
  const commutes = [];

  for (let i = 0; i < n; i++) {
    const permA = g.moveops[i];
    orders.push(permA.order());
    let bits = 0;

    for (let j = 0; j < n; j++) {
      if (j === i) {
        continue;
      }

      const permB = g.moveops[j];

      if (permA.mul(permB).equal(permB.mul(permA))) {
        bits |= 1 << j;
      }
    }

    commutes.push(bits);
  }

  let curlev = {};
  disp("" + 0 + ": canonseq " + 1);

  for (let x = 0; x < orders.length; x++) {
    curlev[x] = orders[x] - 1;
  }

  for (let d = 1; d < 100; d++) {
    let sum = 0;
    const nextlev = {};
    let uniq = 0;

    for (const sti in curlev) {
      const st = +sti; // string to number

      const cnt = curlev[st];
      sum += cnt;
      uniq++;

      for (let mv = 0; mv < orders.length; mv++) {
        if (mv === st || commutes[mv] & 1 << st && mv < st) {
          continue;
        }

        if (nextlev[mv] === undefined) {
          nextlev[mv] = 0;
        }

        nextlev[mv] += (orders[mv] - 1) * cnt;
      }
    }

    disp("" + d + ": canonseq " + sum + " states " + uniq);
    curlev = nextlev;
  }
}
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","./Perm":"VeGsJ"}],"4vHWD":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.useNewFaceNames = useNewFaceNames;
exports.getpuzzles = getpuzzles;
exports.getpuzzle = getpuzzle;
exports.parsedesc = parsedesc;
exports.getPuzzleGeometryByDesc = getPuzzleGeometryByDesc;
exports.getPuzzleGeometryByName = getPuzzleGeometryByName;
exports.PuzzleGeometry = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _alg = require("../alg");

var _FaceNameSwizzler = require("./FaceNameSwizzler");

var _NotationMapper = require("./NotationMapper");

var _Perm = require("./Perm");

var _PermOriSet = require("./PermOriSet");

var _PGPuzzles = require("./PGPuzzles");

var _PlatonicGenerator = require("./PlatonicGenerator");

var _Quat = require("./Quat");

/* tslint:disable no-bitwise */

/* tslint:disable prefer-for-of */
// TODO

/* tslint:disable only-arrow-functions */
// TODO

/* tslint:disable typedef */
// TODO
const DEFAULT_COLOR_FRACTION = 0.77;
// TODO: Remove this once we no longer have prefix restrictions.
let NEW_FACE_NAMES = true;

function useNewFaceNames(use) {
  NEW_FACE_NAMES = use;
} //  Now we have a geometry class that does the 3D goemetry to calculate
//  individual sticker information from a Platonic solid and a set of
//  cuts.  The cuts must have the same symmetry as the Platonic solid;
//  we even restrict them further to be either vertex-normal,
//  edge-normal, or face-parallel cuts.  Right now our constructor takes
//  a character solid indicator (one of c(ube), o(ctahedron), i(cosahedron),
//  t(etradron), or d(odecahedron), followed by an array of cuts.
//  Each cut is a character normal indicator that is either f(ace),
//  e(dge), or v(ertex), followed by a floating point value that gives
//  the depth of the cut where 0 is the center and 1 is the outside
//  border of the shape in that direction.
//  This is a heavyweight class with lots of members and construction
//  is slow.  Be gentle.
//  Everything except a very few methods should be considered private.


const eps = 1e-9;
const copyright = "PuzzleGeometry 0.1 Copyright 2018 Tomas Rokicki.";
const permissivieMoveParsing = false; // This is a description of the nets and the external names we give each
// face.  The names should be a set of prefix-free upper-case alphabetics
// so
// we can easily also name and distinguish vertices and edges, but we
// may change this in the future.  The nets consist of a list of lists.
// Each list gives the name of a face, and then the names of the
// faces connected to that face (in the net) in clockwise order.
// The length of each list should be one more than the number of
// edges in the regular polygon for that face.  All polygons must
// have the same number of edges.
// The first two faces in the first list must describe a horizontal edge
// that is at the bottom of a regular polygon.  The first two faces in
// every subsequent list for a given polytope must describe a edge that
// is directly connected in the net and has already been described (this
// sets the location and orientation of the polygon for that face.
// Any edge that is not directly connected in the net should be given
// the empty string as the other face.  All faces do not need to have
// a list starting with that face; just enough to describe the full
// connectivity of the net.
//
// TODO: change this back to a const JSON definition.

function defaultnets() {
  return {
    // four faces: tetrahedron
    4: [["F", "D", "L", "R"]],
    // six faces: cube
    6: [["F", "D", "L", "U", "R"], ["R", "F", "", "B", ""]],
    // eight faces: octahedron
    8: [["F", "D", "L", "R"], ["D", "F", "BR", ""], ["BR", "D", "", "BB"], ["BB", "BR", "U", "BL"]],
    // twelve faces:  dodecahedron; U/F/R/F/BL/BR from megaminx
    12: [["U", "F", "", "", "", ""], ["F", "U", "R", "C", "A", "L"], ["R", "F", "", "", "E", ""], ["E", "R", "", "BF", "", ""], ["BF", "E", "BR", "BL", "I", "D"]],
    // twenty faces: icosahedron
    20: [["R", "C", "F", "E"], ["F", "R", "L", "U"], ["L", "F", "A", ""], ["E", "R", "G", "I"], ["I", "E", "S", "H"], ["S", "I", "J", "B"], ["B", "S", "K", "D"], ["K", "B", "M", "O"], ["O", "K", "P", "N"], ["P", "O", "Q", ""]]
  };
} // TODO: change this back to a const JSON definition.


function defaultcolors() {
  return {
    // the colors should use the same naming convention as the nets, above.
    4: {
      F: "#00ff00",
      D: "#ffff00",
      L: "#ff0000",
      R: "#0000ff"
    },
    6: {
      U: "#ffffff",
      F: "#00ff00",
      R: "#ff0000",
      D: "#ffff00",
      B: "#0000ff",
      L: "#ff8000"
    },
    8: {
      U: "#ffffff",
      F: "#ff0000",
      R: "#00bb00",
      D: "#ffff00",
      BB: "#1122ff",
      L: "#9524c5",
      BL: "#ff8800",
      BR: "#aaaaaa"
    },
    12: {
      U: "#ffffff",
      F: "#006633",
      R: "#ff0000",
      C: "#ffffd0",
      A: "#3399ff",
      L: "#660099",
      E: "#ff66cc",
      BF: "#99ff00",
      BR: "#0000ff",
      BL: "#ffff00",
      I: "#ff6633",
      D: "#999999"
    },
    20: {
      R: "#db69f0",
      C: "#178fde",
      F: "#23238b",
      E: "#9cc726",
      L: "#2c212d",
      U: "#177fa7",
      A: "#e0de7f",
      G: "#2b57c0",
      I: "#41126b",
      S: "#4b8c28",
      H: "#7c098d",
      J: "#7fe7b4",
      B: "#85fb74",
      K: "#3f4bc3",
      D: "#0ff555",
      M: "#f1c2c8",
      O: "#58d340",
      P: "#c514f2",
      N: "#14494e",
      Q: "#8b1be1"
    }
  };
} // the default precedence of the faces is given here.  This permits
// the orientations to be reasonably predictable.  There are tradeoffs;
// some face precedence orders do better things to the edge orientations
// than the corner orientations and some are the opposite.
// TODO: change this back to a const JSON definition.


function defaultfaceorders() {
  return {
    4: ["F", "D", "L", "R"],
    6: ["U", "D", "F", "B", "L", "R"],
    8: ["F", "BB", "D", "U", "BR", "L", "R", "BL"],
    12: ["L", "E", "F", "BF", "R", "I", "U", "D", "BR", "A", "BL", "C"],
    20: ["L", "S", "E", "O", "F", "B", "I", "P", "R", "K", "U", "D", "J", "A", "Q", "H", "G", "N", "M", "C"]
  };
}
/*
 *  Default orientations for the puzzles in 3D space.  Can be overridden
 *  by puzzleOrientation or puzzleOrientations options.
 *
 *  These are defined to have a strong intuitive vertical (y) direction
 *  since 3D orbital controls need this.  In comments, we list the
 *  preferred initial camera orientation for each puzzle for twizzle;
 *  this information is explicitly given in the twizzle app file.
 */
// TODO: change this back to a const JSON definition.


function defaultOrientations() {
  return {
    4: ["FLR", [0, 1, 0], "F", [0, 0, 1]],
    // FLR towards viewer
    6: ["U", [0, 1, 0], "F", [0, 0, 1]],
    // URF towards viewer
    8: ["U", [0, 1, 0], "F", [0, 0, 1]],
    // FLUR towards viewer
    12: ["U", [0, 1, 0], "F", [0, 0, 1]],
    // F towards viewer
    20: ["GUQMJ", [0, 1, 0], "F", [0, 0, 1]] // F towards viewer

  };
}

function findelement(a, p) {
  // find something in facenames, vertexnames, edgenames
  for (let i = 0; i < a.length; i++) {
    if (a[i][0].dist(p) < eps) {
      return i;
    }
  }

  throw new Error("Element not found");
}

function getpuzzles() {
  // get some simple definitions of basic puzzles
  return _PGPuzzles.PGPuzzles;
}

function getpuzzle(puzzleName) {
  // get some simple definitions of basic puzzles
  return _PGPuzzles.PGPuzzles[puzzleName];
}

function parsedesc(s) {
  // parse a text description
  const a = s.split(/ /).filter(Boolean);

  if (a.length % 2 === 0) {
    return false;
  }

  if (a[0] !== "o" && a[0] !== "c" && a[0] !== "i" && a[0] !== "d" && a[0] !== "t") {
    return false;
  }

  const r = [];

  for (let i = 1; i < a.length; i += 2) {
    if (a[i] !== "f" && a[i] !== "v" && a[i] !== "e") {
      return false;
    }

    r.push([a[i], a[i + 1]]);
  }

  return [a[0], r];
}

function getPuzzleGeometryByDesc(desc, options = []) {
  const [shape, cuts] = parsedesc(desc);
  const pg = new PuzzleGeometry(shape, cuts, ["allmoves", "true"].concat(options));
  pg.allstickers();
  pg.genperms();
  return pg;
}

function getPuzzleGeometryByName(puzzleName, options = []) {
  return getPuzzleGeometryByDesc(_PGPuzzles.PGPuzzles[puzzleName], options);
}

function getmovename(geo, bits, slices) {
  // generate a move name based on bits, slice, and geo
  // if the move name is from the opposite face, say so.
  // find the face that's turned.
  let inverted = false;

  if (slices - bits[1] < bits[0]) {
    // flip if most of the move is on the other side
    geo = [geo[2], geo[3], geo[0], geo[1]];
    bits = [slices - bits[1], slices - bits[0]];
    inverted = true;
  }

  let movenameFamily = geo[0];
  let movenamePrefix = "";

  if (bits[0] === 0 && bits[1] === slices) {
    movenameFamily = movenameFamily + "v";
  } else if (bits[0] === bits[1]) {
    if (bits[1] > 0) {
      movenamePrefix = String(bits[1] + 1);
    }
  } else if (bits[0] === 0) {
    movenameFamily = movenameFamily.toLowerCase();

    if (bits[1] > 1) {
      movenamePrefix = String(bits[1] + 1);
    }
  } else {
    throw "We only support slice and outer block moves right now. " + bits;
  }

  return [movenamePrefix + movenameFamily, inverted];
} // split a geometrical element into face names.  Do greedy match.
// Permit underscores between names.


function splitByFaceNames(s, facenames) {
  const r = [];
  let at = 0;

  while (at < s.length) {
    if (at > 0 && at < s.length && s[at] === "_") {
      at++;
    }

    let currentMatch = "";

    for (let i = 0; i < facenames.length; i++) {
      if (s.substr(at).startsWith(facenames[i][1]) && facenames[i][1].length > currentMatch.length) {
        currentMatch = facenames[i][1];
      }
    }

    if (currentMatch !== "") {
      r.push(currentMatch);
      at += currentMatch.length;
    } else {
      throw new Error("Could not split " + s + " into face names.");
    }
  }

  return r;
}

function toCoords(q, maxdist) {
  return [q.b / maxdist, -q.c / maxdist, q.d / maxdist];
}

function toFaceCoords(q, maxdist) {
  const r = [];
  const n = q.length;

  for (let i = 0; i < n; i++) {
    r[n - i - 1] = toCoords(q[i], maxdist);
  }

  return r;
}

function trimEdges(face, tr) {
  const r = [];

  for (let iter = 1; iter < 10; iter++) {
    for (let i = 0; i < face.length; i++) {
      const pi = (i + face.length - 1) % face.length;
      const ni = (i + 1) % face.length;
      const A = face[pi].sub(face[i]).normalize();
      const B = face[ni].sub(face[i]).normalize();
      const d = A.dot(B);
      const m = tr / Math.sqrt(1 - d * d);
      r[i] = face[i].sum(A.sum(B).smul(m));
    }

    let good = true;

    for (let i = 0; good && i < r.length; i++) {
      const pi = (i + face.length - 1) % face.length;
      const ni = (i + 1) % face.length;

      if (r[pi].sub(r[i]).cross(r[ni].sub(r[i])).dot(r[i]) >= 0) {
        good = false;
      }
    }

    if (good) {
      return r;
    }

    tr /= 2;
  }

  return face;
}

class PuzzleGeometry {
  // all members of the rotation group
  // unique rotations of the baseplane
  // planes, corresponding to faces
  // face names
  // face planes
  // edge names
  // vertexnames
  // all geometric directions, with names and types
  // the planes that split moves
  // the planes that split moves, filtered
  // the move planes, in parallel sets
  // one move plane
  // the order of rotations for each move set
  // geometric feature information for move sets
  // polytope faces before cuts
  // all the stickers
  // center of mass of all faces
  // number of base faces
  // number of stickers per face
  // number of faces that meet at a corner
  // the cubies
  // shortest edge
  // vertex distance
  // edge distance
  // count of cubie orbits
  // map a face to a cubie index and offset
  // move rotations
  // cubie locator
  // cubie keys
  // face list by key
  // cubie set names
  // the size of each orbit
  // the orientation size of each orbit
  // the map for identical cubies
  // cubies in each cubie set
  // cmoves as perms by slice
  // options
  // verbosity (console.log)
  // generate all slice moves in ksolve
  // generate outer block moves
  // generate vertex moves
  // add symmetry information to ksolve output
  // move list to generate
  // parsed move list
  // single puzzle orientation from options
  // puzzle orientation override list from options
  // include corner sets
  // include center sets
  // include edge sets
  // make corner sets gray
  // make center sets gray
  // make edge sets gray
  // eliminate any orientations
  // optimize PermOri
  // scramble?
  // move names from ksolve
  // fix a piece?
  // orient centers?
  // which faces are duplicated
  // which cubies are duplicated
  // fixed cubie, if any
  // grips from svg generation by svg coordinate
  constructor(shape, cuts, optionlist) {
    (0, _defineProperty2.default)(this, "args", "");
    (0, _defineProperty2.default)(this, "rotations", void 0);
    (0, _defineProperty2.default)(this, "baseplanerot", void 0);
    (0, _defineProperty2.default)(this, "baseplanes", void 0);
    (0, _defineProperty2.default)(this, "facenames", void 0);
    (0, _defineProperty2.default)(this, "faceplanes", void 0);
    (0, _defineProperty2.default)(this, "edgenames", void 0);
    (0, _defineProperty2.default)(this, "vertexnames", void 0);
    (0, _defineProperty2.default)(this, "geonormals", void 0);
    (0, _defineProperty2.default)(this, "moveplanes", void 0);
    (0, _defineProperty2.default)(this, "moveplanes2", void 0);
    (0, _defineProperty2.default)(this, "moveplanesets", void 0);
    (0, _defineProperty2.default)(this, "moveplanenormals", void 0);
    (0, _defineProperty2.default)(this, "movesetorders", void 0);
    (0, _defineProperty2.default)(this, "movesetgeos", void 0);
    (0, _defineProperty2.default)(this, "basefaces", void 0);
    (0, _defineProperty2.default)(this, "faces", void 0);
    (0, _defineProperty2.default)(this, "facecentermass", void 0);
    (0, _defineProperty2.default)(this, "basefacecount", void 0);
    (0, _defineProperty2.default)(this, "stickersperface", void 0);
    (0, _defineProperty2.default)(this, "cornerfaces", void 0);
    (0, _defineProperty2.default)(this, "cubies", void 0);
    (0, _defineProperty2.default)(this, "shortedge", void 0);
    (0, _defineProperty2.default)(this, "vertexdistance", void 0);
    (0, _defineProperty2.default)(this, "edgedistance", void 0);
    (0, _defineProperty2.default)(this, "orbits", void 0);
    (0, _defineProperty2.default)(this, "facetocubies", void 0);
    (0, _defineProperty2.default)(this, "moverotations", void 0);
    (0, _defineProperty2.default)(this, "cubiekey", void 0);
    (0, _defineProperty2.default)(this, "cubiekeys", void 0);
    (0, _defineProperty2.default)(this, "facelisthash", void 0);
    (0, _defineProperty2.default)(this, "cubiesetnames", void 0);
    (0, _defineProperty2.default)(this, "cubieords", void 0);
    (0, _defineProperty2.default)(this, "cubiesetnums", void 0);
    (0, _defineProperty2.default)(this, "cubieordnums", void 0);
    (0, _defineProperty2.default)(this, "orbitoris", void 0);
    (0, _defineProperty2.default)(this, "cubievaluemap", void 0);
    (0, _defineProperty2.default)(this, "cubiesetcubies", void 0);
    (0, _defineProperty2.default)(this, "cmovesbyslice", []);
    (0, _defineProperty2.default)(this, "verbose", 0);
    (0, _defineProperty2.default)(this, "allmoves", false);
    (0, _defineProperty2.default)(this, "outerblockmoves", void 0);
    (0, _defineProperty2.default)(this, "vertexmoves", void 0);
    (0, _defineProperty2.default)(this, "addrotations", void 0);
    (0, _defineProperty2.default)(this, "movelist", void 0);
    (0, _defineProperty2.default)(this, "parsedmovelist", void 0);
    (0, _defineProperty2.default)(this, "puzzleOrientation", void 0);
    (0, _defineProperty2.default)(this, "puzzleOrientations", void 0);
    (0, _defineProperty2.default)(this, "cornersets", true);
    (0, _defineProperty2.default)(this, "centersets", true);
    (0, _defineProperty2.default)(this, "edgesets", true);
    (0, _defineProperty2.default)(this, "graycorners", false);
    (0, _defineProperty2.default)(this, "graycenters", false);
    (0, _defineProperty2.default)(this, "grayedges", false);
    (0, _defineProperty2.default)(this, "killorientation", false);
    (0, _defineProperty2.default)(this, "optimize", false);
    (0, _defineProperty2.default)(this, "scramble", 0);
    (0, _defineProperty2.default)(this, "ksolvemovenames", void 0);
    (0, _defineProperty2.default)(this, "fixPiece", "");
    (0, _defineProperty2.default)(this, "orientCenters", false);
    (0, _defineProperty2.default)(this, "duplicatedFaces", []);
    (0, _defineProperty2.default)(this, "duplicatedCubies", []);
    (0, _defineProperty2.default)(this, "fixedCubie", -1);
    (0, _defineProperty2.default)(this, "svggrips", void 0);
    (0, _defineProperty2.default)(this, "net", []);
    (0, _defineProperty2.default)(this, "colors", []);
    (0, _defineProperty2.default)(this, "faceorder", []);
    (0, _defineProperty2.default)(this, "faceprecedence", []);
    (0, _defineProperty2.default)(this, "swizzler", void 0);
    (0, _defineProperty2.default)(this, "notationMapper", new _NotationMapper.NullMapper());
    (0, _defineProperty2.default)(this, "addNotationMapper", "");
    (0, _defineProperty2.default)(this, "setReidOrder", false);

    function asstructured(v) {
      if (typeof v === "string") {
        return JSON.parse(v);
      }

      return v;
    }

    function asboolean(v) {
      if (typeof v === "string") {
        if (v === "false") {
          return false;
        }

        return true;
      } else {
        return v ? true : false;
      }
    }

    if (optionlist !== undefined) {
      if (optionlist.length % 2 !== 0) {
        throw new Error("Odd length in option list?");
      }

      for (let i = 0; i < optionlist.length; i += 2) {
        if (optionlist[i] === "verbose") {
          this.verbose++;
        } else if (optionlist[i] === "quiet") {
          this.verbose = 0;
        } else if (optionlist[i] === "allmoves") {
          this.allmoves = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "outerblockmoves") {
          this.outerblockmoves = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "vertexmoves") {
          this.vertexmoves = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "rotations") {
          this.addrotations = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "cornersets") {
          this.cornersets = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "centersets") {
          this.centersets = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "edgesets") {
          this.edgesets = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "graycorners") {
          this.graycorners = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "graycenters") {
          this.graycenters = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "grayedges") {
          this.grayedges = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "movelist") {
          this.movelist = asstructured(optionlist[i + 1]);
        } else if (optionlist[i] === "killorientation") {
          this.killorientation = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "optimize") {
          this.optimize = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "scramble") {
          this.scramble = optionlist[i + 1];
        } else if (optionlist[i] === "fix") {
          this.fixPiece = optionlist[i + 1];
        } else if (optionlist[i] === "orientcenters") {
          this.orientCenters = asboolean(optionlist[i + 1]);
        } else if (optionlist[i] === "puzzleorientation") {
          this.puzzleOrientation = asstructured(optionlist[i + 1]);
        } else if (optionlist[i] === "puzzleorientations") {
          this.puzzleOrientations = asstructured(optionlist[i + 1]);
        } else {
          throw new Error("Bad option while processing option list " + optionlist[i]);
        }
      }
    }

    this.args = shape + " " + cuts.map(_ => _.join(" ")).join(" ");

    if (optionlist) {
      this.args += " " + optionlist.join(" ");
    }

    if (this.verbose > 0) {
      console.log(this.header("# "));
    }

    this.create(shape, cuts);
  }

  create(shape, cuts) {
    // create the shape, doing all the essential geometry
    // create only goes far enough to figure out how many stickers per
    // face, and what the short edge is.  If the short edge is too short,
    // we probably don't want to display or manipulate this one.  How
    // short is too short is hard to say.
    // var that = this ; // TODO
    this.moveplanes = [];
    this.moveplanes2 = [];
    this.faces = [];
    this.cubies = [];
    let g = null;

    switch (shape) {
      case "c":
        g = (0, _PlatonicGenerator.cube)();
        break;

      case "o":
        g = (0, _PlatonicGenerator.octahedron)();
        break;

      case "i":
        g = (0, _PlatonicGenerator.icosahedron)();
        break;

      case "t":
        g = (0, _PlatonicGenerator.tetrahedron)();
        break;

      case "d":
        g = (0, _PlatonicGenerator.dodecahedron)();
        break;

      default:
        throw new Error("Bad shape argument: " + shape);
    }

    this.rotations = (0, _PlatonicGenerator.closure)(g);

    if (this.verbose) {
      console.log("# Rotations: " + this.rotations.length);
    }

    const baseplane = g[0];
    this.baseplanerot = (0, _PlatonicGenerator.uniqueplanes)(baseplane, this.rotations);
    const baseplanes = this.baseplanerot.map(_ => baseplane.rotateplane(_));
    this.baseplanes = baseplanes;
    this.basefacecount = baseplanes.length;
    const net = defaultnets()[baseplanes.length];
    this.net = net;
    this.colors = defaultcolors()[baseplanes.length];
    this.faceorder = defaultfaceorders()[baseplanes.length];

    if (this.verbose) {
      console.log("# Base planes: " + baseplanes.length);
    }

    const baseface = (0, _PlatonicGenerator.getface)(baseplanes);
    const zero = new _Quat.Quat(0, 0, 0, 0);

    if (this.verbose) {
      console.log("# Face vertices: " + baseface.length);
    }

    const facenormal = baseplanes[0].makenormal();
    const edgenormal = baseface[0].sum(baseface[1]).makenormal();
    const vertexnormal = baseface[0].makenormal();
    const boundary = new _Quat.Quat(1, facenormal.b, facenormal.c, facenormal.d);

    if (this.verbose) {
      console.log("# Boundary is " + boundary);
    }

    const planerot = (0, _PlatonicGenerator.uniqueplanes)(boundary, this.rotations);
    const planes = planerot.map(_ => boundary.rotateplane(_));
    let faces = [(0, _PlatonicGenerator.getface)(planes)];
    this.edgedistance = faces[0][0].sum(faces[0][1]).smul(0.5).dist(zero);
    this.vertexdistance = faces[0][0].dist(zero);
    const cutplanes = [];
    const intersects = [];
    let sawface = false; // what cuts did we see?

    let sawedge = false;
    let sawvertex = false;

    for (let i = 0; i < cuts.length; i++) {
      let normal = null;
      let distance = 0;

      switch (cuts[i][0]) {
        case "f":
          normal = facenormal;
          distance = 1;
          sawface = true;
          break;

        case "v":
          normal = vertexnormal;
          distance = this.vertexdistance;
          sawvertex = true;
          break;

        case "e":
          normal = edgenormal;
          distance = this.edgedistance;
          sawedge = true;
          break;

        default:
          throw new Error("Bad cut argument: " + cuts[i][0]);
      }

      cutplanes.push(normal.makecut(Number(cuts[i][1])));
      intersects.push(cuts[i][1] < distance);
    }

    if (this.addrotations) {
      if (!sawface) {
        cutplanes.push(facenormal.makecut(10));
      }

      if (!sawvertex) {
        cutplanes.push(vertexnormal.makecut(10));
      }

      if (!sawedge) {
        cutplanes.push(edgenormal.makecut(10));
      }
    }

    this.basefaces = [];

    for (let i = 0; i < this.baseplanerot.length; i++) {
      const face = this.baseplanerot[i].rotateface(faces[0]);
      this.basefaces.push(face);
    } //
    //   Determine names for edges, vertices, and planes.  Planes are defined
    //   by the plane normal/distance; edges are defined by the midpoint;
    //   vertices are defined by actual point.  In each case we define a name.
    //   Note that edges have two potential names, and corners have n where
    //   n planes meet at a vertex.  We arbitrarily choose the one that is
    //   alphabetically first (and we will probably want to change this).
    //


    const facenames = [];
    const faceplanes = [];
    const vertexnames = [];
    const edgenames = [];
    const edgesperface = faces[0].length;

    function searchaddelement(a, p, name) {
      for (let i = 0; i < a.length; i++) {
        if (a[i][0].dist(p) < eps) {
          a[i].push(name);
          return;
        }
      }

      a.push([p, name]);
    }

    for (let i = 0; i < this.baseplanerot.length; i++) {
      const face = this.baseplanerot[i].rotateface(faces[0]);

      for (let j = 0; j < face.length; j++) {
        const jj = (j + 1) % face.length;
        const midpoint = face[j].sum(face[jj]).smul(0.5);
        searchaddelement(edgenames, midpoint, i);
      }
    }

    const otherfaces = [];

    for (let i = 0; i < this.baseplanerot.length; i++) {
      const face = this.baseplanerot[i].rotateface(faces[0]);
      const facelist = [];

      for (let j = 0; j < face.length; j++) {
        const jj = (j + 1) % face.length;
        const midpoint = face[j].sum(face[jj]).smul(0.5);
        const el = edgenames[findelement(edgenames, midpoint)];

        if (i === el[1]) {
          facelist.push(el[2]);
        } else if (i === el[2]) {
          facelist.push(el[1]);
        } else {
          throw new Error("Could not find edge");
        }
      }

      otherfaces.push(facelist);
    }

    const facenametoindex = {};
    const faceindextoname = [];
    faceindextoname.push(net[0][0]);
    facenametoindex[net[0][0]] = 0;
    faceindextoname[otherfaces[0][0]] = net[0][1];
    facenametoindex[net[0][1]] = otherfaces[0][0];

    for (let i = 0; i < net.length; i++) {
      const f0 = net[i][0];
      const fi = facenametoindex[f0];

      if (fi === undefined) {
        throw new Error("Bad edge description; first edge not connected");
      }

      let ii = -1;

      for (let j = 0; j < otherfaces[fi].length; j++) {
        const fn2 = faceindextoname[otherfaces[fi][j]];

        if (fn2 !== undefined && fn2 === net[i][1]) {
          ii = j;
          break;
        }
      }

      if (ii < 0) {
        throw new Error("First element of a net not known");
      }

      for (let j = 2; j < net[i].length; j++) {
        if (net[i][j] === "") {
          continue;
        }

        const of = otherfaces[fi][(j + ii - 1) % edgesperface];
        const fn2 = faceindextoname[of];

        if (fn2 !== undefined && fn2 !== net[i][j]) {
          throw new Error("Face mismatch in net");
        }

        faceindextoname[of] = net[i][j];
        facenametoindex[net[i][j]] = of;
      }
    }

    for (let i = 0; i < faceindextoname.length; i++) {
      let found = false;

      for (let j = 0; j < this.faceorder.length; j++) {
        if (faceindextoname[i] === this.faceorder[j]) {
          this.faceprecedence[i] = j;
          found = true;
          break;
        }
      }

      if (!found) {
        throw new Error("Could not find face " + faceindextoname[i] + " in face order list " + this.faceorder);
      }
    }

    for (let i = 0; i < this.baseplanerot.length; i++) {
      const face = this.baseplanerot[i].rotateface(faces[0]);
      const faceplane = boundary.rotateplane(this.baseplanerot[i]);
      const facename = faceindextoname[i];
      facenames.push([face, facename]);
      faceplanes.push([faceplane, facename]);
    }

    for (let i = 0; i < this.baseplanerot.length; i++) {
      const face = this.baseplanerot[i].rotateface(faces[0]);
      const facename = faceindextoname[i];

      for (let j = 0; j < face.length; j++) {
        const jj = (j + 1) % face.length;
        const midpoint = face[j].sum(face[jj]).smul(0.5);
        const jjj = (j + 2) % face.length;
        const midpoint2 = face[jj].sum(face[jjj]).smul(0.5);
        const e1 = findelement(edgenames, midpoint);
        const e2 = findelement(edgenames, midpoint2);
        searchaddelement(vertexnames, face[jj], [facename, e2, e1]);
      }
    }

    this.swizzler = new _FaceNameSwizzler.FaceNameSwizzler(facenames.map(_ => _[1]));
    const sep = this.swizzler.prefixFree ? "" : "_"; // fix the edge names; use face precedence order

    for (let i = 0; i < edgenames.length; i++) {
      if (edgenames[i].length !== 3) {
        throw new Error("Bad length in edge names " + edgenames[i]);
      }

      let c1 = faceindextoname[edgenames[i][1]];
      const c2 = faceindextoname[edgenames[i][2]];

      if (this.faceprecedence[edgenames[i][1]] < this.faceprecedence[edgenames[i][2]]) {
        c1 = c1 + sep + c2;
      } else {
        c1 = c2 + sep + c1;
      }

      edgenames[i] = [edgenames[i][0], c1];
    } // fix the vertex names; counterclockwise rotations; low face first.


    this.cornerfaces = vertexnames[0].length - 1;

    for (let i = 0; i < vertexnames.length; i++) {
      if (vertexnames[i].length < 4) {
        throw new Error("Bad length in vertex names");
      }

      let st = 1;

      for (let j = 2; j < vertexnames[i].length; j++) {
        if (this.faceprecedence[facenametoindex[vertexnames[i][j][0]]] < this.faceprecedence[facenametoindex[vertexnames[i][st][0]]]) {
          st = j;
        }
      }

      let r = "";

      for (let j = 1; j < vertexnames[i].length; j++) {
        if (j === 1) {
          r = vertexnames[i][st][0];
        } else {
          r = r + sep + vertexnames[i][st][0];
        }

        for (let k = 1; k < vertexnames[i].length; k++) {
          if (vertexnames[i][st][1] === vertexnames[i][k][2]) {
            st = k;
            break;
          }
        }
      }

      vertexnames[i] = [vertexnames[i][0], r];
    }

    if (this.verbose > 1) {
      console.log("# Face precedence list: " + this.faceorder.join(" "));
      console.log("# Face names: " + facenames.map(_ => _[1]).join(" "));
      console.log("# Edge names: " + edgenames.map(_ => _[1]).join(" "));
      console.log("# Vertex names: " + vertexnames.map(_ => _[1]).join(" "));
    }

    const geonormals = [];

    for (let i = 0; i < faceplanes.length; i++) {
      geonormals.push([faceplanes[i][0].makenormal(), faceplanes[i][1], "f"]);
    }

    for (let i = 0; i < edgenames.length; i++) {
      geonormals.push([edgenames[i][0].makenormal(), edgenames[i][1], "e"]);
    }

    for (let i = 0; i < vertexnames.length; i++) {
      geonormals.push([vertexnames[i][0].makenormal(), vertexnames[i][1], "v"]);
    }

    this.facenames = facenames;
    this.faceplanes = faceplanes;
    this.edgenames = edgenames;
    this.vertexnames = vertexnames;
    this.geonormals = geonormals;
    const geonormalnames = geonormals.map(_ => _[1]);
    this.swizzler.setGripNames(geonormalnames);

    if (this.verbose) {
      console.log("# Distances: face " + 1 + " edge " + this.edgedistance + " vertex " + this.vertexdistance);
    } // expand cutplanes by rotations.  We only work with one face here.


    for (let c = 0; c < cutplanes.length; c++) {
      for (let i = 0; i < this.rotations.length; i++) {
        const q = cutplanes[c].rotateplane(this.rotations[i]);
        let wasseen = false;

        for (let j = 0; j < this.moveplanes.length; j++) {
          if (q.sameplane(this.moveplanes[j])) {
            wasseen = true;
            break;
          }
        }

        if (!wasseen) {
          this.moveplanes.push(q);

          if (intersects[c]) {
            this.moveplanes2.push(q);
          }
        }
      }
    }

    let ft = new _Quat.FaceTree(faces[0]);
    const tar = this.moveplanes2.slice(); // we want to use Math.random() here but we can't, because when
    // we call multiple times we'll get different orbits/layouts.
    // to resolve this, we use a very simple linear congruential
    // generator.  for our purposes, the numbers don't need to be
    // very random.

    let rval = 31;

    for (let i = 0; i < tar.length; i++) {
      const j = i + Math.floor((tar.length - i) * (rval / 65536.0));
      ft = ft.split(tar[j]);
      tar[j] = tar[i];
      rval = (rval * 1657 + 101) % 65536;
    }

    faces = ft.collect([], true);
    this.faces = faces;

    if (this.verbose) {
      console.log("# Faces is now " + faces.length);
    }

    this.stickersperface = faces.length; //  Find and report the shortest edge in any of the faces.  If this
    //  is small the puzzle is probably not practical or displayable.

    let shortedge = 1e99;

    for (let i = 0; i < faces.length; i++) {
      for (let j = 0; j < faces[i].length; j++) {
        const k = (j + 1) % faces[i].length;
        const t = faces[i][j].dist(faces[i][k]);

        if (t < shortedge) {
          shortedge = t;
        }
      }
    }

    this.shortedge = shortedge;

    if (this.verbose) {
      console.log("# Short edge is " + shortedge);
    } // add nxnxn cube notation if it has cube face moves


    if (shape === "c" && sawface && !sawedge && !sawvertex) {
      // In this case the mapper adding is deferred until we
      // know the number of slices.
      this.addNotationMapper = "NxNxNCubeMapper"; // try to set Reid order of the cubies within an orbit

      this.setReidOrder = true;
    }

    if (shape === "c" && sawvertex && !sawface && !sawedge) {
      this.addNotationMapper = "SkewbMapper";
    }

    if (shape === "t" && (sawvertex || sawface) && !sawedge) {
      this.addNotationMapper = "PyraminxMapper";
    }

    if (shape === "o" && sawface && NEW_FACE_NAMES) {
      this.notationMapper = new _NotationMapper.FaceRenamingMapper(this.swizzler, new _FaceNameSwizzler.FaceNameSwizzler(["F", "D", "L", "BL", "R", "U", "BR", "B"]));

      if (!sawedge && !sawvertex) {
        this.addNotationMapper = "FTOMapper";
      }
    }

    if (shape === "d" && sawface && NEW_FACE_NAMES) {
      this.addNotationMapper = "MegaminxMapper";
      this.notationMapper = new _NotationMapper.FaceRenamingMapper(this.swizzler, new _FaceNameSwizzler.FaceNameSwizzler(["U", "F", "L", "BL", "BR", "R", "FR", "FL", "DL", "B", "DR", "D"]));
    }
  }

  keyface(face) {
    return this.keyface2((0, _Quat.centermassface)(face));
  }

  keyface2(cm) {
    // take a face and figure out the sides of each move plane
    let s = "";

    for (let i = 0; i < this.moveplanesets.length; i++) {
      if (this.moveplanesets[i].length > 0) {
        const dv = cm.dot(this.moveplanesets[i][0]);
        let t = 0;
        let b = 1;

        while (b * 2 <= this.moveplanesets[i].length) {
          b *= 2;
        }

        for (; b > 0; b >>= 1) {
          if (t + b <= this.moveplanesets[i].length && dv > this.moveplanesets[i][t + b - 1].a) {
            t += b;
          }
        }

        s = s + " " + t;
      }
    }

    return s;
  }

  findface(face) {
    const cm = (0, _Quat.centermassface)(face);
    const key = this.keyface2(cm);
    const arr = this.facelisthash[key];

    if (arr.length === 1) {
      return arr[0];
    }

    for (let i = 0; i + 1 < arr.length; i++) {
      const face2 = this.facelisthash[key][i];

      if (Math.abs(cm.dist(this.facecentermass[face2])) < eps) {
        return face2;
      }
    }

    return arr[arr.length - 1];
  }

  findface2(cm) {
    const key = this.keyface2(cm);
    const arr = this.facelisthash[key];

    if (arr.length === 1) {
      return arr[0];
    }

    for (let i = 0; i + 1 < arr.length; i++) {
      const face2 = this.facelisthash[key][i];

      if (Math.abs(cm.dist(this.facecentermass[face2])) < eps) {
        return face2;
      }
    }

    return arr[arr.length - 1];
  }

  project2d(facen, edgen, targvec) {
    // calculate geometry to map a particular edge of a particular
    //  face to a given 2D vector.  The face is given as an index into the
    //  facenames/baseplane arrays, and the edge is given as an offset into
    //  the vertices.
    const face = this.facenames[facen][0];
    const edgen2 = (edgen + 1) % face.length;
    const plane = this.baseplanes[facen];
    let x0 = face[edgen2].sub(face[edgen]);
    const olen = x0.len();
    x0 = x0.normalize();
    const y0 = x0.cross(plane).normalize();
    let delta = targvec[1].sub(targvec[0]);
    const len = delta.len() / olen;
    delta = delta.normalize();
    const cosr = delta.b;
    const sinr = delta.c;
    const x1 = x0.smul(cosr).sub(y0.smul(sinr)).smul(len);
    const y1 = y0.smul(cosr).sum(x0.smul(sinr)).smul(len);
    const off = new _Quat.Quat(0, targvec[0].b - x1.dot(face[edgen]), targvec[0].c - y1.dot(face[edgen]), 0);
    return [x1, y1, off];
  }

  allstickers() {
    // next step is to calculate all the stickers and orbits
    // We do enough work here to display the cube on the screen.
    // take our newly split base face and expand it by the rotation matrix.
    // this generates our full set of "stickers".
    this.faces = (0, _Quat.expandfaces)(this.baseplanerot, this.faces);

    if (this.verbose) {
      console.log("# Total stickers is now " + this.faces.length);
    }

    this.facecentermass = new Array(this.faces.length);

    for (let i = 0; i < this.faces.length; i++) {
      this.facecentermass[i] = (0, _Quat.centermassface)(this.faces[i]);
    } // Split moveplanes into a list of parallel planes.


    const moveplanesets = [];
    const moveplanenormals = []; // get the normals, first, from unfiltered moveplanes.

    for (let i = 0; i < this.moveplanes.length; i++) {
      const q = this.moveplanes[i];
      const qnormal = q.makenormal();
      let wasseen = false;

      for (let j = 0; j < moveplanenormals.length; j++) {
        if (qnormal.sameplane(moveplanenormals[j].makenormal())) {
          wasseen = true;
        }
      }

      if (!wasseen) {
        moveplanenormals.push(qnormal);
        moveplanesets.push([]);
      }
    }

    for (let i = 0; i < this.moveplanes2.length; i++) {
      const q = this.moveplanes2[i];
      const qnormal = q.makenormal();

      for (let j = 0; j < moveplanenormals.length; j++) {
        if (qnormal.sameplane(moveplanenormals[j])) {
          moveplanesets[j].push(q);
          break;
        }
      }
    } // make the normals all face the same way in each set.


    for (let i = 0; i < moveplanesets.length; i++) {
      const q = moveplanesets[i].map(_ => _.normalizeplane());
      const goodnormal = moveplanenormals[i];

      for (let j = 0; j < q.length; j++) {
        if (q[j].makenormal().dist(goodnormal) > eps) {
          q[j] = q[j].smul(-1);
        }
      }

      q.sort((a, b) => a.a - b.a);
      moveplanesets[i] = q;
    }

    this.moveplanesets = moveplanesets;
    this.moveplanenormals = moveplanenormals;
    const sizes = moveplanesets.map(_ => _.length);

    if (this.verbose) {
      console.log("# Move plane sets: " + sizes);
    } // for each of the move planes, find the rotations that are relevant


    const moverotations = [];

    for (let i = 0; i < moveplanesets.length; i++) {
      moverotations.push([]);
    }

    for (let i = 0; i < this.rotations.length; i++) {
      const q = this.rotations[i];

      if (Math.abs(Math.abs(q.a) - 1) < eps) {
        continue;
      }

      const qnormal = q.makenormal();

      for (let j = 0; j < moveplanesets.length; j++) {
        if (qnormal.sameplane(moveplanenormals[j])) {
          moverotations[j].push(q);
          break;
        }
      }
    }

    this.moverotations = moverotations; //  Sort the rotations by the angle of rotation.  A bit tricky because
    //  while the norms should be the same, they need not be.  So we start
    //  by making the norms the same, and then sorting.

    for (let i = 0; i < moverotations.length; i++) {
      const r = moverotations[i];
      const goodnormal = r[0].makenormal();

      for (let j = 0; j < r.length; j++) {
        if (goodnormal.dist(r[j].makenormal()) > eps) {
          r[j] = r[j].smul(-1);
        }
      }

      r.sort((a, b) => a.angle() - b.angle());

      if (moverotations[i][0].dot(moveplanenormals[i]) < 0) {
        r.reverse();
      }
    }

    const sizes2 = moverotations.map(_ => 1 + _.length);
    this.movesetorders = sizes2;
    const movesetgeos = [];
    let gtype = "?";

    for (let i = 0; i < moveplanesets.length; i++) {
      const p0 = moveplanenormals[i];
      let neg = null;
      let pos = null;

      for (let j = 0; j < this.geonormals.length; j++) {
        const d = p0.dot(this.geonormals[j][0]);

        if (Math.abs(d - 1) < eps) {
          pos = [this.geonormals[j][1], this.geonormals[j][2]];
          gtype = this.geonormals[j][2];
        } else if (Math.abs(d + 1) < eps) {
          neg = [this.geonormals[j][1], this.geonormals[j][2]];
          gtype = this.geonormals[j][2];
        }
      }

      if (pos === null || neg === null) {
        throw new Error("Saw positive or negative sides as null");
      }

      movesetgeos.push([pos[0], pos[1], neg[0], neg[1], 1 + moveplanesets[i].length]);

      if (this.addNotationMapper === "NxNxNCubeMapper" && gtype === "f") {
        this.notationMapper = new _NotationMapper.NxNxNCubeMapper(1 + moveplanesets[i].length);
        this.addNotationMapper = "";
      }

      if (this.addNotationMapper === "SkewbMapper---DISABLED" && moveplanesets[0].length === 1) {
        this.notationMapper = new _NotationMapper.SkewbNotationMapper(this.swizzler);
        this.addNotationMapper = "";
      }

      if (this.addNotationMapper === "PyraminxMapper---DISABLED" && moveplanesets[0].length === 2) {
        this.notationMapper = new _NotationMapper.PyraminxNotationMapper(this.swizzler);
        this.addNotationMapper = "";
      }

      if (this.addNotationMapper === "MegaminxMapper" && gtype === "f") {
        if (1 + moveplanesets[i].length === 3) {
          this.notationMapper = new _NotationMapper.MegaminxScramblingNotationMapper(this.notationMapper);
        }

        this.addNotationMapper = "";
      }

      if (this.addNotationMapper === "FTOMapper" && gtype === "f") {
        if (1 + moveplanesets[i].length === 3) {
          this.notationMapper = new _NotationMapper.FTONotationMapper(this.notationMapper, this.swizzler);
        }

        this.addNotationMapper = "";
      }
    }

    this.movesetgeos = movesetgeos; //  Cubies are split by move plane sets.  For each cubie we can
    //  average its points to find a point on the interior of that
    //  cubie.  We can then check that point against all the move
    //  planes and from that derive a coordinate for the cubie.
    //  This also works for faces; no face should ever lie on a move
    //  plane.  This allows us to take a set of stickers and break
    //  them up into cubie sets.

    const cubiehash = {};
    const facelisthash = {};
    const cubiekey = {};
    const cubiekeys = [];
    const cubies = [];
    const faces = this.faces;

    for (let i = 0; i < faces.length; i++) {
      const face = faces[i];
      const s = this.keyface(face);

      if (!cubiehash[s]) {
        cubiekey[s] = cubies.length;
        cubiekeys.push(s);
        cubiehash[s] = [];
        facelisthash[s] = [];
        cubies.push(cubiehash[s]);
      }

      facelisthash[s].push(i);
      cubiehash[s].push(face); //  If we find a core cubie, split it up into multiple cubies,
      //  because ksolve doesn't handle orientations that are not
      //  cyclic, and the rotation group of the core is not cyclic.

      if (facelisthash[s].length === this.basefacecount) {
        if (this.verbose) {
          console.log("# Splitting core.");
        }

        for (let suff = 0; suff < this.basefacecount; suff++) {
          const s2 = s + " " + suff;
          facelisthash[s2] = [facelisthash[s][suff]];
          cubiehash[s2] = [cubiehash[s][suff]];
          cubiekeys.push(s2);
          cubiekey[s2] = cubies.length;
          cubies.push(cubiehash[s2]);
        }

        cubiehash[s] = [];
        cubies[cubiekey[s]] = [];
      }
    }

    this.cubiekey = cubiekey;
    this.facelisthash = facelisthash;
    this.cubiekeys = cubiekeys;

    if (this.verbose) {
      console.log("# Cubies: " + Object.keys(cubiehash).length);
    } //  Sort the faces around each corner so they are counterclockwise.  Only
    //  relevant for cubies that actually are corners (three or more
    //  faces).  In general cubies might have many faces; for icosohedrons
    //  there are five faces on the corner cubies.


    this.cubies = cubies;

    for (let k = 0; k < cubies.length; k++) {
      const cubie = cubies[k];

      if (cubie.length < 2) {
        continue;
      }

      if (cubie.length === this.basefacecount) {
        // looks like core?  don't sort
        continue;
      }

      if (cubie.length > 5) {
        throw new Error("Bad math; too many faces on this cubie " + cubie.length);
      }

      const cm = cubie.map(_ => (0, _Quat.centermassface)(_));
      const s = this.keyface2(cm[0]);
      const facelist = facelisthash[s];
      const cmall = (0, _Quat.centermassface)(cm);

      for (let looplimit = 0; cubie.length > 2; looplimit++) {
        let changed = false;

        for (let i = 0; i < cubie.length; i++) {
          const j = (i + 1) % cubie.length; // var ttt = cmall.dot(cm[i].cross(cm[j])) ; // TODO

          if (cmall.dot(cm[i].cross(cm[j])) < 0) {
            const t = cubie[i];
            cubie[i] = cubie[j];
            cubie[j] = t;
            const u = cm[i];
            cm[i] = cm[j];
            cm[j] = u;
            const v = facelist[i];
            facelist[i] = facelist[j];
            facelist[j] = v;
            changed = true;
          }
        }

        if (!changed) {
          break;
        }

        if (looplimit > 1000) {
          throw new Error("Bad epsilon math; too close to border");
        }
      }

      let mini = 0;
      let minf = this.findface(cubie[mini]);

      for (let i = 1; i < cubie.length; i++) {
        const temp = this.findface(cubie[i]);

        if (this.faceprecedence[this.getfaceindex(temp)] < this.faceprecedence[this.getfaceindex(minf)]) {
          mini = i;
          minf = temp;
        }
      }

      if (mini !== 0) {
        const ocubie = cubie.slice();
        const ofacelist = facelist.slice();

        for (let i = 0; i < cubie.length; i++) {
          cubie[i] = ocubie[(mini + i) % cubie.length];
          facelist[i] = ofacelist[(mini + i) % cubie.length];
        }
      }
    } //  Build an array that takes each face to a cubie ordinal and a
    //  face number.


    const facetocubies = [];

    for (let i = 0; i < cubies.length; i++) {
      const facelist = facelisthash[cubiekeys[i]];

      for (let j = 0; j < facelist.length; j++) {
        facetocubies[facelist[j]] = [i, j];
      }
    }

    this.facetocubies = facetocubies; //  Calculate the orbits of each cubie.  Assumes we do all moves.
    //  Also calculates which cubies are identical.

    const typenames = ["?", "CENTERS", "EDGES", "CORNERS", "C4RNER", "C5RNER"];
    const cubiesetnames = [];
    const cubietypecounts = [0, 0, 0, 0, 0, 0];
    const orbitoris = [];
    const seen = [];
    let cubiesetnum = 0;
    const cubiesetnums = [];
    const cubieordnums = [];
    const cubieords = []; // var cubiesetnumhash = {} ; // TODO

    const cubievaluemap = []; // Later we will make this smarter to use a get color for face function
    // so we support puzzles with multiple faces the same color

    const getcolorkey = cubienum => {
      return cubies[cubienum].map(_ => this.getfaceindex(this.findface(_))).join(" ");
    };

    const cubiesetcubies = [];

    for (let i = 0; i < cubies.length; i++) {
      if (seen[i]) {
        continue;
      }

      const cubie = cubies[i];

      if (cubie.length === 0) {
        continue;
      }

      const cubiekeymap = {};
      let cubievalueid = 0;
      cubieords.push(0);
      cubiesetcubies.push([]);
      const facecnt = cubie.length;
      const typectr = cubietypecounts[facecnt]++;
      let typename = typenames[facecnt];

      if (typename === undefined || facecnt === this.basefacecount) {
        typename = "CORE";
      }

      typename = typename + (typectr === 0 ? "" : typectr + 1);
      cubiesetnames[cubiesetnum] = typename;
      orbitoris[cubiesetnum] = facecnt;
      const queue = [i];
      let qg = 0;
      seen[i] = true;

      while (qg < queue.length) {
        const cind = queue[qg++];
        const cubiecolorkey = getcolorkey(cind);

        if (cubie.length > 1 || cubiekeymap[cubiecolorkey] === undefined) {
          cubiekeymap[cubiecolorkey] = cubievalueid++;
        }

        cubievaluemap[cind] = cubiekeymap[cubiecolorkey];
        cubiesetnums[cind] = cubiesetnum;
        cubiesetcubies[cubiesetnum].push(cind);
        cubieordnums[cind] = cubieords[cubiesetnum]++;
        const cm = (0, _Quat.centermassface)(cubies[cind][0]);

        if (queue.length < this.rotations.length) {
          for (let j = 0; j < moverotations.length; j++) {
            const tq = this.facetocubies[this.findface2(cm.rotatepoint(moverotations[j][0]))][0];

            if (!seen[tq]) {
              queue.push(tq);
              seen[tq] = true;
            }
          }
        }
      }

      cubiesetnum++;
    }

    if (this.setReidOrder && 4 <= this.stickersperface && this.stickersperface <= 9) {
      const reidorder = [["UF", "UR", "UB", "UL", "DF", "DR", "DB", "DL", "FR", "FL", "BR", "BL"], ["UFR", "URB", "UBL", "ULF", "DRF", "DFL", "DLB", "DBR"], ["U", "L", "F", "R", "B", "D"]];
      const reidmap = {};

      for (let i = 0; i < reidorder.length; i++) {
        for (let j = 0; j < reidorder[i].length; j++) {
          let mask = 0;

          for (let k = 0; k < reidorder[i][j].length; k++) {
            mask |= 1 << reidorder[i][j].charCodeAt(k) - 65;
          }

          reidmap[mask] = j;
        }
      }

      for (let i = 0; i < cubiesetnum; i++) {
        for (let j = 0; j < cubiesetcubies[i].length; j++) {
          const cubienum = cubiesetcubies[i][j];
          let mask = 0;

          for (let k = 0; k < cubies[cubienum].length; k++) {
            mask |= 1 << this.facenames[this.getfaceindex(this.findface(cubies[cubienum][k]))][1].charCodeAt(0) - 65;
          }

          cubieordnums[cubienum] = reidmap[mask];
        }
      }
    }

    this.orbits = cubieords.length;
    this.cubiesetnums = cubiesetnums;
    this.cubieordnums = cubieordnums;
    this.cubiesetnames = cubiesetnames;
    this.cubieords = cubieords;
    this.orbitoris = orbitoris;
    this.cubievaluemap = cubievaluemap;
    this.cubiesetcubies = cubiesetcubies; // if we fix a cubie, find a cubie to fix

    if (this.fixPiece !== "") {
      for (let i = 0; i < cubies.length; i++) {
        if (this.fixPiece === "v" && cubies[i].length > 2 || this.fixPiece === "e" && cubies[i].length === 2 || this.fixPiece === "f" && cubies[i].length === 1) {
          this.fixedCubie = i;
          break;
        }
      }

      if (this.fixedCubie < 0) {
        throw new Error("Could not find a cubie of type " + this.fixPiece + " to fix.");
      }
    } // show the orbits


    if (this.verbose) {
      console.log("# Cubie orbit sizes " + cubieords);
    }
  }

  unswizzle(mv) {
    const newmv = this.notationMapper.notationToInternal(mv);

    if (newmv === null) {
      return "";
    }

    return this.swizzler.unswizzle(newmv.family);
  } // We use an extremely permissive parse here; any character but
  // digits are allowed in a family name.


  stringToBlockMove(mv) {
    // parse a move from the command line
    const re = RegExp("^(([0-9]+)-)?([0-9]+)?([^0-9]+)([0-9]+'?)?$");
    const p = mv.match(re);

    if (p === null) {
      throw new Error("Bad move passed " + mv);
    }

    const grip = p[4];
    let loslice = undefined;
    let hislice = undefined;

    if (p[2] !== undefined) {
      if (p[3] === undefined) {
        throw new Error("Missing second number in range");
      }

      loslice = parseInt(p[2], 10);
    }

    if (p[3] !== undefined) {
      hislice = parseInt(p[3], 10);
    }

    let amountstr = "1";
    let amount = 1;

    if (p[5] !== undefined) {
      amountstr = p[5];

      if (amountstr[0] === "'") {
        amountstr = "-" + amountstr.substring(1);
      }

      amount = parseInt(amountstr, 10);
    }

    return new _alg.Move(new _alg.QuantumMove(grip, hislice, loslice), amount);
  }

  parseMove(move) {
    const bm = this.notationMapper.notationToInternal(move); // pluggable notation

    if (bm === null) {
      throw new Error("Bad move " + move.family);
    }

    move = bm;
    let grip = move.family;
    let fullrotation = false;

    if (grip.endsWith("v") && grip[0] <= "Z") {
      if (move.innerLayer !== undefined || move.outerLayer !== undefined) {
        throw new Error("Cannot use a prefix with full cube rotations");
      }

      grip = grip.slice(0, -1);
      fullrotation = true;
    }

    if (grip.endsWith("w") && grip[0] <= "Z") {
      grip = grip.slice(0, -1).toLowerCase();
    }

    let geo;
    let msi = -1;
    const geoname = this.swizzler.unswizzle(grip);
    let firstgrip = false;

    for (let i = 0; i < this.movesetgeos.length; i++) {
      const g = this.movesetgeos[i];

      if (geoname === g[0]) {
        firstgrip = true;
        geo = g;
        msi = i;
      }

      if (geoname === g[2]) {
        firstgrip = false;
        geo = g;
        msi = i;
      }
    }

    let loslice = 1;
    let hislice = 1;

    if (grip.toUpperCase() !== grip) {
      hislice = 2;
    }

    if (geo === undefined) {
      throw new Error("Bad grip in move " + move.family);
    }

    if (move.outerLayer !== undefined) {
      loslice = move.outerLayer;
    }

    if (move.innerLayer !== undefined) {
      if (move.outerLayer === undefined) {
        hislice = move.innerLayer;

        if (geoname === grip) {
          loslice = hislice;
        } else {
          loslice = 1;
        }
      } else {
        hislice = move.innerLayer;
      }
    }

    loslice--;
    hislice--;

    if (fullrotation) {
      loslice = 0;
      hislice = this.moveplanesets[msi].length;
    }

    if (loslice < 0 || loslice > this.moveplanesets[msi].length || hislice < 0 || hislice > this.moveplanesets[msi].length) {
      throw new Error("Bad slice spec " + loslice + " " + hislice);
    }

    if (!permissivieMoveParsing && loslice === 0 && hislice === this.moveplanesets[msi].length && !fullrotation) {
      throw new Error("! full puzzle rotations must be specified with v suffix.");
    }

    const r = [undefined, msi, loslice, hislice, firstgrip, move.effectiveAmount];
    return r;
  }

  parsemove(mv) {
    const r = this.parseMove(this.stringToBlockMove(mv));
    r[0] = mv;
    return r;
  }

  genperms() {
    // generate permutations for moves
    if (this.cmovesbyslice.length > 0) {
      // did this already?
      return;
    }

    const cmovesbyslice = []; // if orientCenters is set, we find all cubies that have only one
    // sticker and that sticker is in the center of a face, and we
    // introduce duplicate stickers so we can orient them properly.

    if (this.orientCenters) {
      for (let k = 0; k < this.cubies.length; k++) {
        if (this.cubies[k].length === 1) {
          const kk = this.findface(this.cubies[k][0]);
          const i = this.getfaceindex(kk);

          if ((0, _Quat.centermassface)(this.basefaces[i]).dist(this.facecentermass[kk]) < eps) {
            const o = this.basefaces[i].length;

            for (let m = 0; m < o; m++) {
              this.cubies[k].push(this.cubies[k][0]);
            }

            this.duplicatedFaces[kk] = o;
            this.duplicatedCubies[k] = o;
            this.orbitoris[this.cubiesetnums[k]] = o;
          }
        }
      }
    }

    for (let k = 0; k < this.moveplanesets.length; k++) {
      const moveplaneset = this.moveplanesets[k];
      const slicenum = [];
      const slicecnts = [moveplaneset.length + 1, 0];
      let bhi = 1;

      while (bhi * 2 <= moveplaneset.length) {
        bhi *= 2;
      }

      for (let i = 0; i < this.faces.length; i++) {
        let t = 0;

        if (moveplaneset.length > 0) {
          const dv = this.facecentermass[i].dot(moveplaneset[0]);

          for (let b = bhi; b > 0; b >>= 1) {
            if (t + b <= moveplaneset.length && dv > moveplaneset[t + b - 1].a) {
              t += b;
            }
          }

          t = moveplaneset.length - t;
        }

        slicenum.push(t);

        while (slicecnts.length <= t) {
          slicecnts.push(0);
        }

        slicecnts[t]++;
      }

      const axiscmoves = new Array(slicecnts.length);

      for (let sc = 0; sc < slicecnts.length; sc++) {
        axiscmoves[sc] = [];
      }

      const cubiedone = [];

      for (let i = 0; i < this.faces.length; i++) {
        if (slicenum[i] < 0) {
          continue;
        }

        const b = this.facetocubies[i].slice();
        let cm = this.facecentermass[i];
        const ocm = cm;
        let fi2 = i;
        const sc = slicenum[fi2];

        for (;;) {
          slicenum[fi2] = -1;
          const cm2 = cm.rotatepoint(this.moverotations[k][0]);

          if (cm2.dist(ocm) < eps) {
            break;
          }

          fi2 = this.findface2(cm2);
          const c = this.facetocubies[fi2];
          b.push(c[0], c[1]);
          cm = cm2;
        } // If an oriented center is moving, we need to figure out
        // the appropriate new orientation.  Normally we use the cubie
        // sticker identity to locate, but this doesn't work here.
        // Instead we need to redo the geometry of the sticker itself
        // rotating and figure out how that maps to the destination
        // sticker.
        //
        // We only need to do this for central center stickers: those
        // where the face vertex goes through the center.  The others
        // don't actually need orientation because they can only be
        // in one orientation by physical constraints.  (You can't spin
        // a point or cross sticker on the 5x5x5, for example.)
        //
        // This also simplifies things because it means the actual
        // remapping has the same order as the moves themselves.
        //
        // The center may or may not have been duplicated at this point.
        //
        // The move moving the center might not be the same modulo as the
        // center itself.


        if (b.length > 2 && this.orientCenters && (this.cubies[b[0]].length === 1 || this.cubies[b[0]][0] === this.cubies[b[0]][1])) {
          // is this a real center cubie, around an axis?
          if (this.facecentermass[i].dist((0, _Quat.centermassface)(this.basefaces[this.getfaceindex(i)])) < eps) {
            // how does remapping of the face/point set map to the original?
            let face1 = this.cubies[b[0]][0];

            for (let ii = 0; ii < b.length; ii += 2) {
              const face0 = this.cubies[b[ii]][0];
              let o = -1;

              for (let jj = 0; jj < face1.length; jj++) {
                if (face0[jj].dist(face1[0]) < eps) {
                  o = jj;
                  break;
                }
              }

              if (o < 0) {
                throw new Error("Couldn't find rotation of center faces; ignoring for now.");
              } else {
                b[ii + 1] = o;
                face1 = this.moverotations[k][0].rotateface(face1);
              }
            }
          }
        } // b.length == 2 means a sticker is spinning in place.
        // in this case we add duplicate stickers
        // so that we can make it animate properly in a 3D world.


        if (b.length === 2 && this.orientCenters) {
          for (let ii = 1; ii < this.movesetorders[k]; ii++) {
            if (sc === 0) {
              b.push(b[0], ii);
            } else {
              b.push(b[0], (this.movesetorders[k] - ii) % this.movesetorders[k]);
            }
          }
        }

        if (b.length > 2 && !cubiedone[b[0]]) {
          if (b.length !== 2 * this.movesetorders[k]) {
            throw new Error("Bad length in perm gen");
          }

          for (let j = 0; j < b.length; j++) {
            axiscmoves[sc].push(b[j]);
          }
        }

        for (let j = 0; j < b.length; j += 2) {
          cubiedone[b[j]] = true;
        }
      }

      cmovesbyslice.push(axiscmoves);
    }

    this.cmovesbyslice = cmovesbyslice;

    if (this.movelist !== undefined) {
      const parsedmovelist = []; // make sure the movelist makes sense based on the geos.

      for (let i = 0; i < this.movelist.length; i++) {
        parsedmovelist.push(this.parsemove(this.movelist[i]));
      }

      this.parsedmovelist = parsedmovelist;
    }

    this.facelisthash = null;
    this.facecentermass = [];
    this.cubiekey = [];
  }

  getfaces() {
    // get the faces for 3d.
    return this.faces.map(_ => {
      return _.map(__ => [__.b, __.c, __.d]);
    });
  }

  getboundarygeometry() {
    // get the boundary geometry
    return {
      baseplanes: this.baseplanes,
      facenames: this.facenames,
      faceplanes: this.faceplanes,
      vertexnames: this.vertexnames,
      edgenames: this.edgenames,
      geonormals: this.geonormals
    };
  }

  getmovesets(k) {
    // get the move sets we support based on slices
    // for even values we omit the middle "slice".  This isn't perfect
    // but it is what we do for now.
    // if there was a move list specified, pull values from that
    const slices = this.moveplanesets[k].length;
    let r = [];

    if (this.parsedmovelist !== undefined) {
      for (let i = 0; i < this.parsedmovelist.length; i++) {
        const parsedmove = this.parsedmovelist[i];

        if (parsedmove[1] !== k) {
          continue;
        }

        if (parsedmove[4]) {
          r.push([parsedmove[2], parsedmove[3]]);
        } else {
          r.push([slices - parsedmove[3], slices - parsedmove[2]]);
        }

        r.push(parsedmove[5]);
      }
    } else if (this.vertexmoves && !this.allmoves) {
      const msg = this.movesetgeos[k];

      if (msg[1] !== msg[3]) {
        for (let i = 0; i < slices; i++) {
          if (msg[1] !== "v") {
            if (this.outerblockmoves) {
              r.push([i + 1, slices]);
            } else {
              r.push([i + 1]);
            }

            r.push(1);
          } else {
            if (this.outerblockmoves) {
              r.push([0, i]);
            } else {
              r.push([i, i]);
            }

            r.push(1);
          }
        }
      }
    } else {
      for (let i = 0; i <= slices; i++) {
        if (!this.allmoves && i + i === slices) {
          continue;
        }

        if (this.outerblockmoves) {
          if (i + i > slices) {
            r.push([i, slices]);
          } else {
            r.push([0, i]);
          }
        } else {
          r.push([i, i]);
        }

        r.push(1);
      }
    }

    if (this.addrotations && !this.allmoves) {
      r.push([0, slices]);
      r.push(1);
    }

    if (this.fixedCubie >= 0) {
      const dep = +this.cubiekeys[this.fixedCubie].trim().split(" ")[k];
      const newr = [];

      for (let i = 0; i < r.length; i += 2) {
        let o = r[i];

        if (dep >= o[0] && dep <= o[1]) {
          if (o[0] === 0) {
            o = [o[1] + 1, slices];
          } else if (slices === o[1]) {
            o = [0, o[0] - 1];
          } else {
            throw Error("fixed cubie option would disconnect move");
          }
        }

        let found = false;

        for (let j = 0; j < newr.length; j += 2) {
          if (newr[j][0] === o[0] && newr[j][1] === o[1] && newr[j + 1] === r[i + 1]) {
            found = true;
            break;
          }
        }

        if (!found) {
          newr.push(o);
          newr.push(r[i + 1]);
        }
      }

      r = newr;
    }

    return r;
  }

  graybyori(cubie) {
    let ori = this.cubies[cubie].length;

    if (this.duplicatedCubies[cubie]) {
      ori = 1;
    }

    return ori === 1 && (this.graycenters || !this.centersets) || ori === 2 && (this.grayedges || !this.edgesets) || ori > 2 && (this.graycorners || !this.cornersets);
  }

  skipbyori(cubie) {
    let ori = this.cubies[cubie].length;

    if (this.duplicatedCubies[cubie]) {
      ori = 1;
    }

    return ori === 1 && !this.centersets || ori === 2 && !this.edgesets || ori > 2 && !this.cornersets;
  }

  skipcubie(fi) {
    return this.skipbyori(fi);
  }

  skipset(set) {
    if (set.length === 0) {
      return true;
    }

    const fi = set[0];
    return this.skipbyori(this.facetocubies[fi][0]);
  }

  header(comment) {
    return comment + copyright + "\n" + comment + this.args + "\n";
  }

  writegap() {
    // write out a gap set of generators
    const os = this.getOrbitsDef(false);
    const r = [];
    const mvs = [];

    for (let i = 0; i < os.moveops.length; i++) {
      const movename = "M_" + os.movenames[i]; // gap doesn't like angle brackets in IDs

      mvs.push(movename);
      r.push(movename + ":=" + os.moveops[i].toPerm().toGap() + ";");
    }

    r.push("Gen:=[");
    r.push(mvs.join(","));
    r.push("];");
    const ip = os.solved.identicalPieces();
    r.push("ip:=[" + ip.map(_ => "[" + _.map(__ => __ + 1).join(",") + "]").join(",") + "];");
    r.push("");
    return this.header("# ") + r.join("\n");
  }

  writeksolve(name = "PuzzleGeometryPuzzle") {
    const od = this.getOrbitsDef(false);
    return this.header("# ") + od.toKsolve(name).join("\n");
  }

  writekpuzzle(fortwisty = true) {
    const od = this.getOrbitsDef(fortwisty);
    const r = od.toKpuzzle();
    r.moveNotation = new PGNotation(this, od);
    return r;
  }

  getMoveFromBits(moverange, amount, inverted, axiscmoves, setmoves, movesetorder) {
    const moveorbits = [];
    const perms = [];
    const oris = [];

    for (let ii = 0; ii < this.cubiesetnames.length; ii++) {
      perms.push((0, _Perm.iota)(this.cubieords[ii]));
      oris.push((0, _Perm.zeros)(this.cubieords[ii]));
    }

    for (let m = moverange[0]; m <= moverange[1]; m++) {
      const slicecmoves = axiscmoves[m];

      for (let j = 0; j < slicecmoves.length; j += 2 * movesetorder) {
        const mperm = slicecmoves.slice(j, j + 2 * movesetorder);
        const setnum = this.cubiesetnums[mperm[0]];

        for (let ii = 0; ii < mperm.length; ii += 2) {
          mperm[ii] = this.cubieordnums[mperm[ii]];
        }

        let inc = 2;
        let oinc = 3;

        if (inverted) {
          inc = mperm.length - 2;
          oinc = mperm.length - 1;
        }

        if (perms[setnum] === (0, _Perm.iota)(this.cubieords[setnum])) {
          perms[setnum] = perms[setnum].slice();

          if (this.orbitoris[setnum] > 1 && !this.killorientation) {
            oris[setnum] = oris[setnum].slice();
          }
        }

        for (let ii = 0; ii < mperm.length; ii += 2) {
          perms[setnum][mperm[(ii + inc) % mperm.length]] = mperm[ii];

          if (this.orbitoris[setnum] > 1 && !this.killorientation) {
            oris[setnum][mperm[ii]] = (mperm[(ii + oinc) % mperm.length] - mperm[(ii + 1) % mperm.length] + 2 * this.orbitoris[setnum]) % this.orbitoris[setnum];
          }
        }
      }
    }

    let lastId = new _PermOriSet.Orbit((0, _Perm.iota)(24), (0, _Perm.zeros)(24), 1);

    for (let ii = 0; ii < this.cubiesetnames.length; ii++) {
      if (setmoves && !setmoves[ii]) {
        continue;
      }

      if (this.orbitoris[ii] === 1 || this.killorientation) {
        if (perms[ii] === (0, _Perm.iota)(lastId.perm.length)) {
          if (perms[ii] !== lastId.perm) {
            lastId = new _PermOriSet.Orbit(perms[ii], oris[ii], 1);
          }

          moveorbits.push(lastId);
        } else {
          moveorbits.push(new _PermOriSet.Orbit(perms[ii], oris[ii], 1));
        }
      } else {
        const no = new Array(oris[ii].length); // convert ksolve oris to our internal ori rep

        for (let jj = 0; jj < perms[ii].length; jj++) {
          no[jj] = oris[ii][perms[ii][jj]];
        }

        moveorbits.push(new _PermOriSet.Orbit(perms[ii], no, this.orbitoris[ii]));
      }
    }

    let mv = new _PermOriSet.Transformation(moveorbits);

    if (amount !== 1) {
      mv = mv.mulScalar(amount);
    }

    return mv;
  }

  getOrbitsDef(fortwisty) {
    // generate a representation of the puzzle
    const setmoves = [];
    const setnames = [];
    const setdefs = [];

    for (let k = 0; k < this.moveplanesets.length; k++) {
      const moveset = this.getmovesets(k);
      const movesetorder = this.movesetorders[k]; // check there's no redundancy in moveset.

      for (let i = 0; i < moveset.length; i += 2) {
        for (let j = 0; j < i; j += 2) {
          if (moveset[i] === moveset[j] && moveset[i + 1] === moveset[j + 1]) {
            throw new Error("Redundant moves in moveset.");
          }
        }
      }

      const allbits = [];

      for (let i = 0; i < moveset.length; i += 2) {
        for (let j = moveset[i][0]; j <= moveset[i][1]; j++) {
          allbits[j] = 1;
        }
      }

      const axiscmoves = this.cmovesbyslice[k];

      for (let i = 0; i < axiscmoves.length; i++) {
        if (allbits[i] !== 1) {
          continue;
        }

        const slicecmoves = axiscmoves[i];

        for (let j = 0; j < slicecmoves.length; j += 2 * movesetorder) {
          if (this.skipcubie(slicecmoves[j])) {
            continue;
          }

          const ind = this.cubiesetnums[slicecmoves[j]];
          setmoves[ind] = 1;
        }
      }
    }

    for (let i = 0; i < this.cubiesetnames.length; i++) {
      if (!setmoves[i]) {
        continue;
      }

      setnames.push(this.cubiesetnames[i]);
      setdefs.push(new _PermOriSet.OrbitDef(this.cubieords[i], this.killorientation ? 1 : this.orbitoris[i]));
    }

    const solved = [];

    for (let i = 0; i < this.cubiesetnames.length; i++) {
      if (!setmoves[i]) {
        continue;
      }

      const p = [];
      const o = [];

      for (let j = 0; j < this.cubieords[i]; j++) {
        if (fortwisty) {
          p.push(j);
        } else {
          const cubie = this.cubiesetcubies[i][j];
          p.push(this.cubievaluemap[cubie]);
        }

        o.push(0);
      }

      solved.push(new _PermOriSet.Orbit(p, o, this.killorientation ? 1 : this.orbitoris[i]));
    }

    const movenames = [];
    const moves = [];

    for (let k = 0; k < this.moveplanesets.length; k++) {
      const moveplaneset = this.moveplanesets[k];
      const slices = moveplaneset.length;
      const moveset = this.getmovesets(k);
      const movesetgeo = this.movesetgeos[k];

      for (let i = 0; i < moveset.length; i += 2) {
        const movebits = moveset[i];
        const mna = getmovename(movesetgeo, movebits, slices);
        const movename = mna[0];
        const inverted = mna[1];

        if (moveset[i + 1] === 1) {
          movenames.push(movename);
        } else {
          movenames.push(movename + moveset[i + 1]);
        }

        const mv = this.getMoveFromBits(movebits, moveset[i + 1], inverted, this.cmovesbyslice[k], setmoves, this.movesetorders[k]);
        moves.push(mv);
      }
    }

    this.ksolvemovenames = movenames; // hack!

    let r = new _PermOriSet.OrbitsDef(setnames, setdefs, new _PermOriSet.VisibleState(solved), movenames, moves);

    if (this.optimize) {
      r = r.optimize();
    }

    if (this.scramble !== 0) {
      r.scramble(this.scramble);
    }

    return r;
  }

  getMovesAsPerms() {
    return this.getOrbitsDef(false).moveops.map(_ => _.toPerm());
  }

  showcanon(disp) {
    // show information for canonical move derivation
    (0, _PermOriSet.showcanon)(this.getOrbitsDef(false), disp);
  }

  getsolved() {
    // get a solved position
    const r = [];

    for (let i = 0; i < this.basefacecount; i++) {
      for (let j = 0; j < this.stickersperface; j++) {
        r.push(i);
      }
    }

    return new _Perm.Perm(r);
  } // Given a rotation description that says to align feature1
  // with a given vector, and then as much as possible feature2
  // with another given vector, return a Quaternion that
  // performs this rotation.


  getOrientationRotation(desiredRotation) {
    const feature1name = desiredRotation[0];
    const direction1 = new _Quat.Quat(0, desiredRotation[1][0], -desiredRotation[1][1], desiredRotation[1][2]);
    const feature2name = desiredRotation[2];
    const direction2 = new _Quat.Quat(0, desiredRotation[3][0], -desiredRotation[3][1], desiredRotation[3][2]);
    let feature1 = null;
    let feature2 = null;
    const feature1geoname = this.swizzler.unswizzle(feature1name);
    const feature2geoname = this.swizzler.unswizzle(feature2name);

    for (const gn of this.geonormals) {
      if (feature1geoname === gn[1]) {
        feature1 = gn[0];
      }

      if (feature2geoname === gn[1]) {
        feature2 = gn[0];
      }
    }

    if (!feature1) {
      throw new Error("Could not find feature " + feature1name);
    }

    if (!feature2) {
      throw new Error("Could not find feature " + feature2name);
    }

    const r1 = feature1.pointrotation(direction1);
    const feature2rot = feature2.rotatepoint(r1);
    const r2 = feature2rot.unproject(direction1).pointrotation(direction2.unproject(direction1));
    return r2.mul(r1);
  }

  getInitial3DRotation() {
    const basefacecount = this.basefacecount;
    let rotDesc = null;

    if (this.puzzleOrientation) {
      rotDesc = this.puzzleOrientation;
    } else if (this.puzzleOrientations) {
      rotDesc = this.puzzleOrientations[basefacecount];
    } // either no option specified or no matching key in
    // puzzleOrientations.


    if (!rotDesc) {
      rotDesc = defaultOrientations()[basefacecount];
    }

    if (!rotDesc) {
      throw new Error("No default orientation?");
    }

    return this.getOrientationRotation(rotDesc);
  }

  generatesvg(w = 800, h = 500, trim = 10, threed = false) {
    // generate svg to interoperate with Lucas twistysim
    w -= 2 * trim;
    h -= 2 * trim;

    function extendedges(a, n) {
      let dx = a[1][0] - a[0][0];
      let dy = a[1][1] - a[0][1];
      const ang = 2 * Math.PI / n;
      const cosa = Math.cos(ang);
      const sina = Math.sin(ang);

      for (let i = 2; i < n; i++) {
        const ndx = dx * cosa + dy * sina;
        dy = dy * cosa - dx * sina;
        dx = ndx;
        a.push([a[i - 1][0] + dx, a[i - 1][1] + dy]);
      }
    } // if we don't add this noise to coordinate values, then Safari
    // doesn't render our polygons correctly.  What a hack.


    function noise(c) {
      return c + 0 * (Math.random() - 0.5);
    }

    function drawedges(id, pts, color) {
      return '<polygon id="' + id + '" class="sticker" style="fill: ' + color + '" points="' + pts.map(p => noise(p[0]) + " " + noise(p[1])).join(" ") + '"/>\n';
    } // What grips do we need?  if rotations, add all grips.


    let needvertexgrips = this.addrotations;
    let neededgegrips = this.addrotations;
    let needfacegrips = this.addrotations;

    for (let i = 0; i < this.movesetgeos.length; i++) {
      const msg = this.movesetgeos[i];

      for (let j = 1; j <= 3; j += 2) {
        if (msg[j] === "v") {
          needvertexgrips = true;
        }

        if (msg[j] === "f") {
          needfacegrips = true;
        }

        if (msg[j] === "e") {
          neededgegrips = true;
        }
      }
    } // Find a net from a given face count.  Walk it, assuming we locate
    // the first edge from (0,0) to (1,1) and compute the minimum and
    // maximum vertex locations from this.  Then do a second walk, and
    // assign the actual geometry.


    this.genperms();
    const boundarygeo = this.getboundarygeometry();
    const face0 = boundarygeo.facenames[0][0];
    const polyn = face0.length; // number of vertices; 3, 4, or 5

    const net = this.net;

    if (net === null) {
      throw new Error("No net?");
    }

    const edges = {};
    let minx = 0;
    let miny = 0;
    let maxx = 1;
    let maxy = 0;
    edges[net[0][0]] = [[1, 0], [0, 0]];
    extendedges(edges[net[0][0]], polyn);

    for (let i = 0; i < net.length; i++) {
      const f0 = net[i][0];

      if (!edges[f0]) {
        throw new Error("Bad edge description; first edge not connected.");
      }

      for (let j = 1; j < net[i].length; j++) {
        const f1 = net[i][j];

        if (f1 === "" || edges[f1]) {
          continue;
        }

        edges[f1] = [edges[f0][j % polyn], edges[f0][(j + polyn - 1) % polyn]];
        extendedges(edges[f1], polyn);
      }
    }

    for (const f in edges) {
      const es = edges[f];

      for (let i = 0; i < es.length; i++) {
        minx = Math.min(minx, es[i][0]);
        maxx = Math.max(maxx, es[i][0]);
        miny = Math.min(miny, es[i][1]);
        maxy = Math.max(maxy, es[i][1]);
      }
    }

    const sc = Math.min(w / (maxx - minx), h / (maxy - miny));
    const xoff = 0.5 * (w - sc * (maxx + minx));
    const yoff = 0.5 * (h - sc * (maxy + miny));
    const geos = {};
    const bg = this.getboundarygeometry();
    const edges2 = {};
    const initv = [[sc + xoff, yoff], [xoff, yoff]];
    edges2[net[0][0]] = initv;
    extendedges(edges2[net[0][0]], polyn);
    geos[this.facenames[0][1]] = this.project2d(0, 0, [new _Quat.Quat(0, initv[0][0], initv[0][1], 0), new _Quat.Quat(0, initv[1][0], initv[1][1], 0)]);
    const connectat = [];
    connectat[0] = 0;

    for (let i = 0; i < net.length; i++) {
      const f0 = net[i][0];

      if (!edges2[f0]) {
        throw new Error("Bad edge description; first edge not connected.");
      }

      let gfi = -1;

      for (let j = 0; j < bg.facenames.length; j++) {
        if (f0 === bg.facenames[j][1]) {
          gfi = j;
          break;
        }
      }

      if (gfi < 0) {
        throw new Error("Could not find first face name " + f0);
      }

      const thisface = bg.facenames[gfi][0];

      for (let j = 1; j < net[i].length; j++) {
        const f1 = net[i][j];

        if (f1 === "" || edges2[f1]) {
          continue;
        }

        edges2[f1] = [edges2[f0][j % polyn], edges2[f0][(j + polyn - 1) % polyn]];
        extendedges(edges2[f1], polyn); // what edge are we at?

        const caf0 = connectat[gfi];
        const mp = thisface[(caf0 + j) % polyn].sum(thisface[(caf0 + j + polyn - 1) % polyn]).smul(0.5);
        const epi = findelement(bg.edgenames, mp);
        const edgename = bg.edgenames[epi][1];
        const el = splitByFaceNames(edgename, this.facenames);
        const gf1 = el[f0 === el[0] ? 1 : 0];
        let gf1i = -1;

        for (let k = 0; k < bg.facenames.length; k++) {
          if (gf1 === bg.facenames[k][1]) {
            gf1i = k;
            break;
          }
        }

        if (gf1i < 0) {
          throw new Error("Could not find second face name");
        }

        const otherface = bg.facenames[gf1i][0];

        for (let k = 0; k < otherface.length; k++) {
          const mp2 = otherface[k].sum(otherface[(k + 1) % polyn]).smul(0.5);

          if (mp2.dist(mp) <= eps) {
            const p1 = edges2[f0][(j + polyn - 1) % polyn];
            const p2 = edges2[f0][j % polyn];
            connectat[gf1i] = k;
            geos[gf1] = this.project2d(gf1i, k, [new _Quat.Quat(0, p2[0], p2[1], 0), new _Quat.Quat(0, p1[0], p1[1], 0)]);
            break;
          }
        }
      }
    } // Let's build arrays for faster rendering.  We want to map from geo
    // base face number to color, and we want to map from geo face number
    // to 2D geometry.  These can be reused as long as the puzzle overall
    // orientation and canvas size remains unchanged.


    const pos = this.getsolved();
    const colormap = [];
    const facegeo = [];

    for (let i = 0; i < this.basefacecount; i++) {
      colormap[i] = this.colors[this.facenames[i][1]];
    }

    let hix = 0;
    let hiy = 0;
    const rot = this.getInitial3DRotation();

    for (let i = 0; i < this.faces.length; i++) {
      let face = this.faces[i];
      face = rot.rotateface(face);

      for (let j = 0; j < face.length; j++) {
        hix = Math.max(hix, Math.abs(face[j].b));
        hiy = Math.max(hiy, Math.abs(face[j].c));
      }
    }

    const sc2 = Math.min(h / hiy / 2, (w - trim) / hix / 4);

    const mappt2d = (fn, q) => {
      if (threed) {
        const xoff2 = 0.5 * trim + 0.25 * w;
        const xmul = this.baseplanes[fn].rotateplane(rot).d < 0 ? 1 : -1;
        return [trim + w * 0.5 + xmul * (xoff2 - q.b * sc2), trim + h * 0.5 + q.c * sc2];
      } else {
        const g = geos[this.facenames[fn][1]];
        return [trim + q.dot(g[0]) + g[2].b, trim + h - q.dot(g[1]) - g[2].c];
      }
    };

    for (let i = 0; i < this.faces.length; i++) {
      let face = this.faces[i];
      const facenum = Math.floor(i / this.stickersperface);

      if (threed) {
        face = rot.rotateface(face);
      }

      facegeo.push(face.map(_ => mappt2d(facenum, _)));
    }

    const svg = []; // group each base face so we can add a hover element

    for (let j = 0; j < this.basefacecount; j++) {
      svg.push("<g>");
      svg.push("<title>" + this.facenames[j][1] + "</title>\n");

      for (let ii = 0; ii < this.stickersperface; ii++) {
        const i = j * this.stickersperface + ii;
        const cubie = this.facetocubies[i][0];
        const cubieori = this.facetocubies[i][1];
        const cubiesetnum = this.cubiesetnums[cubie];
        const cubieord = this.cubieordnums[cubie];
        const color = this.graybyori(cubie) ? "#808080" : colormap[pos.p[i]];
        let id = this.cubiesetnames[cubiesetnum] + "-l" + cubieord + "-o" + cubieori;
        svg.push(drawedges(id, facegeo[i], color));

        if (this.duplicatedFaces[i]) {
          for (let jj = 1; jj < this.duplicatedFaces[i]; jj++) {
            id = this.cubiesetnames[cubiesetnum] + "-l" + cubieord + "-o" + jj;
            svg.push(drawedges(id, facegeo[i], color));
          }
        }
      }

      svg.push("</g>");
    }

    const svggrips = [];

    function addgrip(onface, name, pt, order) {
      const pt2 = mappt2d(onface, pt);

      for (let i = 0; i < svggrips.length; i++) {
        if (Math.hypot(pt2[0] - svggrips[i][0], pt2[1] - svggrips[i][1]) < eps) {
          return;
        }
      }

      svggrips.push([pt2[0], pt2[1], name, order]);
    }

    for (let i = 0; i < this.faceplanes.length; i++) {
      const baseface = this.facenames[i][0];
      let facecoords = baseface;

      if (threed) {
        facecoords = rot.rotateface(facecoords);
      }

      if (needfacegrips) {
        let pt = this.faceplanes[i][0];

        if (threed) {
          pt = pt.rotatepoint(rot);
        }

        addgrip(i, this.faceplanes[i][1], pt, polyn);
      }

      for (let j = 0; j < baseface.length; j++) {
        if (neededgegrips) {
          const mp = baseface[j].sum(baseface[(j + 1) % baseface.length]).smul(0.5);
          const ep = findelement(this.edgenames, mp);
          const mpc = facecoords[j].sum(facecoords[(j + 1) % baseface.length]).smul(0.5);
          addgrip(i, this.edgenames[ep][1], mpc, 2);
        }

        if (needvertexgrips) {
          const vp = findelement(this.vertexnames, baseface[j]);
          addgrip(i, this.vertexnames[vp][1], facecoords[j], this.cornerfaces);
        }
      }
    }

    const html = '<svg id="svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 800 500">\n' + '<style type="text/css"><![CDATA[' + ".sticker { stroke: #000000; stroke-width: 1px; }" + "]]></style>\n" + svg.join("") + "</svg>";
    this.svggrips = svggrips;
    return html;
  }

  dist(a, b) {
    return Math.hypot(a[0] - b[0], a[1] - b[1], a[2] - b[2]);
  }

  triarea(a, b, c) {
    const ab = this.dist(a, b);
    const bc = this.dist(b, c);
    const ac = this.dist(a, c);
    const p = (ab + bc + ac) / 2;
    return Math.sqrt(p * (p - ab) * (p - bc) * (p - ac));
  }

  polyarea(coords) {
    let sum = 0;

    for (let i = 2; i < coords.length; i++) {
      sum += this.triarea(coords[0], coords[1], coords[i]);
    }

    return sum;
  } // The colorfrac parameter says how much of the face should be
  // colored (vs dividing lines); we default to 0.77 which seems
  // to work pretty well.  It should be a number between probably
  // 0.4 and 0.9.


  get3d(colorfrac = DEFAULT_COLOR_FRACTION, options) {
    const stickers = [];
    const foundations = [];
    const rot = this.getInitial3DRotation();
    const faces = [];
    const maxdist = 0.52 * this.basefaces[0][0].len();
    let avgstickerarea = 0;

    for (let i = 0; i < this.basefaces.length; i++) {
      const coords = rot.rotateface(this.basefaces[i]);
      const name = this.facenames[i][1];
      faces.push({
        coords: toFaceCoords(coords, maxdist),
        name
      });
      avgstickerarea += this.polyarea(faces[i].coords);
    }

    avgstickerarea /= this.faces.length;
    const trim = Math.sqrt(avgstickerarea) * (1 - Math.sqrt(colorfrac)) / 2;

    for (let i = 0; i < this.faces.length; i++) {
      const facenum = Math.floor(i / this.stickersperface);
      const cubie = this.facetocubies[i][0];
      const cubieori = this.facetocubies[i][1];
      const cubiesetnum = this.cubiesetnums[cubie];
      const cubieord = this.cubieordnums[cubie];
      let color = this.graybyori(cubie) ? "#808080" : this.colors[this.facenames[facenum][1]];

      if (options === null || options === void 0 ? void 0 : options.stickerColors) {
        color = options.stickerColors[i];
      }

      let coords = rot.rotateface(this.faces[i]);
      foundations.push({
        coords: toFaceCoords(coords, maxdist),
        color,
        orbit: this.cubiesetnames[cubiesetnum],
        ord: cubieord,
        ori: cubieori
      });
      const fcoords = coords;

      if (trim && trim > 0) {
        coords = trimEdges(coords, trim);
      }

      stickers.push({
        coords: toFaceCoords(coords, maxdist),
        color,
        orbit: this.cubiesetnames[cubiesetnum],
        ord: cubieord,
        ori: cubieori
      });

      if (this.duplicatedFaces[i]) {
        for (let jj = 1; jj < this.duplicatedFaces[i]; jj++) {
          stickers.push({
            coords: toFaceCoords(coords, maxdist),
            color,
            orbit: this.cubiesetnames[cubiesetnum],
            ord: cubieord,
            ori: jj
          });
          foundations.push({
            coords: toFaceCoords(fcoords, maxdist),
            color,
            orbit: this.cubiesetnames[cubiesetnum],
            ord: cubieord,
            ori: jj
          });
        }
      }
    }

    const grips = [];

    for (let i = 0; i < this.movesetgeos.length; i++) {
      const msg = this.movesetgeos[i];
      const order = this.movesetorders[i];

      for (let j = 0; j < this.geonormals.length; j++) {
        const gn = this.geonormals[j];

        if (msg[0] === gn[1] && msg[1] === gn[2]) {
          grips.push([toCoords(gn[0].rotatepoint(rot), 1), msg[0], order]);
          grips.push([toCoords(gn[0].rotatepoint(rot).smul(-1), 1), msg[2], order]);
        }
      }
    }

    const f = function () {
      return function (mv) {
        return this.unswizzle(mv);
      };
    }().bind(this);

    return {
      stickers,
      foundations,
      faces,
      axis: grips,
      unswizzle: f,
      notationMapper: this.notationMapper
    };
  } //  From the name of a geometric element (face, vertex, edge), get a
  //  normal vector respecting the default orientation.  This is useful
  //  to define the initial position of the camera in a 3D scene.  The
  //  return value is normalized, so multiply it by the camera distance.
  //  Returns undefined if no such geometric element.


  getGeoNormal(geoname) {
    const rot = this.getInitial3DRotation();
    const grip = this.swizzler.unswizzle(geoname);

    for (let j = 0; j < this.geonormals.length; j++) {
      const gn = this.geonormals[j];

      if (grip === gn[1]) {
        const r = toCoords(gn[0].rotatepoint(rot), 1); //  This routine is intended to use for the camera location.
        //  If the camera location is vertical, and we give some
        //  near-zero values for x and z, then the rotation in the
        //  X/Z plane will be somewhat arbitrary.  So we clean up the
        //  returned vector here.  We give a very slight positive
        //  z value.

        if (Math.abs(r[0]) < eps && Math.abs(r[2]) < eps) {
          r[0] = 0.0;
          r[2] = 1e-6;
        }

        return r;
      }
    }

    return undefined;
  }

  getfaceindex(facenum) {
    const divid = this.stickersperface;
    return Math.floor(facenum / divid);
  }

}

exports.PuzzleGeometry = PuzzleGeometry;

class PGNotation {
  constructor(pg, od) {
    this.pg = pg;
    (0, _defineProperty2.default)(this, "cache", {});
    (0, _defineProperty2.default)(this, "orbitNames", void 0);
    this.orbitNames = od.orbitnames;
  }

  lookupMove(move) {
    const key = this.moveToKeyString(move);

    if (key in this.cache) {
      return this.cache[key];
    }

    const mv = this.pg.parseMove(move);
    let bits = [mv[2], mv[3]];

    if (!mv[4]) {
      const slices = this.pg.moveplanesets[mv[1]].length;
      bits = [slices - mv[3], slices - mv[2]];
    }

    const pgmv = this.pg.getMoveFromBits(bits, mv[5], !mv[4], this.pg.cmovesbyslice[mv[1]], undefined, this.pg.movesetorders[mv[1]]);

    const r = _PermOriSet.OrbitsDef.transformToKPuzzle(this.orbitNames, pgmv);

    this.cache[key] = r;
    return r;
  } // This is only used to construct keys, so does not need to be beautiful.


  moveToKeyString(move) {
    let r = "";

    if (move.outerLayer) {
      r = r + move.outerLayer + ",";
    }

    if (move.innerLayer) {
      r = r + move.innerLayer + ",";
    }

    r = r + move.family + "," + move.effectiveAmount;
    return r;
  }

}
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","../alg":"7Ff6b","./FaceNameSwizzler":"7GoOr","./NotationMapper":"3Rok1","./Perm":"VeGsJ","./PermOriSet":"2xFz1","./PGPuzzles":"7aLGY","./PlatonicGenerator":"fuu67","./Quat":"4Jbs3"}],"7GoOr":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.FaceNameSwizzler = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

// Manages a set of face names.  Detects whether they are prefix-free.
// Implements greedy splitting into face names and comparisons between
// concatenated face names and grip names.
class FaceNameSwizzler {
  constructor(facenames, gripnames_arg) {
    this.facenames = facenames;
    (0, _defineProperty2.default)(this, "prefixFree", true);
    (0, _defineProperty2.default)(this, "gripnames", []);

    if (gripnames_arg) {
      this.gripnames = gripnames_arg;
    }

    for (let i = 0; this.prefixFree && i < facenames.length; i++) {
      for (let j = 0; this.prefixFree && j < facenames.length; j++) {
        if (i !== j && facenames[i].startsWith(facenames[j])) {
          this.prefixFree = false;
        }
      }
    }
  }

  setGripNames(names) {
    this.gripnames = names;
  } // split a string into face names and return a list of
  // indices.


  splitByFaceNames(s) {
    const r = [];
    let at = 0;

    while (at < s.length) {
      if (at > 0 && at < s.length && s[at] === "_") {
        at++;
      }

      let currentMatch = -1;

      for (let i = 0; i < this.facenames.length; i++) {
        if (s.substr(at).startsWith(this.facenames[i]) && (currentMatch < 0 || this.facenames[i].length > this.facenames[currentMatch].length)) {
          currentMatch = i;
        }
      }

      if (currentMatch >= 0) {
        r.push(currentMatch);
        at += this.facenames[currentMatch].length;
      } else {
        throw new Error("Could not split " + s + " into face names.");
      }
    }

    return r;
  } // cons a grip from an array of numbers.


  joinByFaceIndices(list) {
    let sep = "";
    const r = [];

    for (let i = 0; i < list.length; i++) {
      r.push(sep);
      r.push(this.facenames[list[i]]);

      if (!this.prefixFree) {
        sep = "_";
      }
    }

    return r.join("");
  }
  /*
   *   Try to match something the user gave us with some geometric
   *   feature.  We used to have strict requirements:
   *
   *      a)  The set of face names are prefix free
   *      b)  When specifying a corner, all coincident planes were
   *          specified
   *
   *   But, to allow megaminx to have more reasonable and
   *   conventional names, and to permit shorter canonical
   *   names, we are relaxing these requirements and adding
   *   new syntax.  Now:
   *
   *      a)  Face names need not be syntax free.
   *      b)  When parsing a geometric name, we use greedy
   *          matching, so the longest name that matches the
   *          user string at the current position is the one
   *          assumed to match.
   *      c)  Underscores are permitted to separate face names
   *          (both in user input and in geometric
   *          descriptions).
   *      d)  Default names of corner moves where corners have
   *          more than three corners, need only include three
   *          of the corners.
   *
   *   This code is not performance-sensitive so we can do it a
   *   slow and simple way.
   */


  spinmatch(userinput, longname) {
    // are these the same rotationally?
    if (userinput === longname) {
      return true;
    }

    try {
      const e1 = this.splitByFaceNames(userinput);
      const e2 = this.splitByFaceNames(longname); // All elements of userinput need to be in the longname.
      // There should be no duplicate elements in the userinput.
      // if both have length 1 or length 2, the sets must be equal.
      // if both have length 3 or more, then the first set must be
      // a subset of the second.  Order doesn't matter.

      if (e1.length !== e2.length && e1.length < 3) {
        return false;
      }

      for (let i = 0; i < e1.length; i++) {
        for (let j = 0; j < i; j++) {
          if (e1[i] === e1[j]) {
            return false;
          }
        }

        let found = false;

        for (let j = 0; j < e2.length; j++) {
          if (e1[i] === e2[j]) {
            found = true;
            break;
          }
        }

        if (!found) {
          return false;
        }
      }

      return true;
    } catch (e) {
      return false;
    }
  }

  unswizzle(s) {
    if ((s.endsWith("v") || s.endsWith("w")) && s[0] <= "Z") {
      s = s.slice(0, s.length - 1);
    }

    const upperCaseGrip = s.toUpperCase();

    for (let i = 0; i < this.gripnames.length; i++) {
      const g = this.gripnames[i];

      if (this.spinmatch(upperCaseGrip, g)) {
        return g;
      }
    }

    return s;
  }

}

exports.FaceNameSwizzler = FaceNameSwizzler;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs"}],"3Rok1":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.FTONotationMapper = exports.PyraminxNotationMapper = exports.SkewbNotationMapper = exports.MegaminxScramblingNotationMapper = exports.FaceRenamingMapper = exports.NxNxNCubeMapper = exports.NullMapper = void 0;

var _alg = require("../alg");

class NullMapper {
  notationToInternal(move) {
    return move;
  }

  notationToExternal(move) {
    return move;
  }

}

exports.NullMapper = NullMapper;

function negate(family, v) {
  if (v === undefined) {
    v = -1;
  } else if (v === -1) {
    v = undefined;
  } else {
    v = -v;
  }

  return new _alg.Move(family, v);
}

class NxNxNCubeMapper {
  constructor(slices) {
    this.slices = slices;
  }

  notationToInternal(move) {
    const grip = move.family;

    if (!move.innerLayer && !move.outerLayer) {
      if (grip === "x") {
        move = new _alg.Move("Rv", move.effectiveAmount);
      } else if (grip === "y") {
        move = new _alg.Move("Uv", move.effectiveAmount);
      } else if (grip === "z") {
        move = new _alg.Move("Fv", move.effectiveAmount);
      }

      if ((this.slices & 1) === 1) {
        if (grip === "E") {
          move = new _alg.Move(new _alg.QuantumMove("D", (this.slices + 1) / 2), move.effectiveAmount);
        } else if (grip === "M") {
          move = new _alg.Move(new _alg.QuantumMove("L", (this.slices + 1) / 2), move.effectiveAmount);
        } else if (grip === "S") {
          move = new _alg.Move(new _alg.QuantumMove("F", (this.slices + 1) / 2), move.effectiveAmount);
        }
      }

      if (this.slices > 2) {
        if (grip === "e") {
          move = new _alg.Move(new _alg.QuantumMove("D", this.slices - 1, 2), move.effectiveAmount);
        } else if (grip === "m") {
          move = new _alg.Move(new _alg.QuantumMove("L", this.slices - 1, 2), move.effectiveAmount);
        } else if (grip === "s") {
          move = new _alg.Move(new _alg.QuantumMove("F", this.slices - 1, 2), move.effectiveAmount);
        }
      }
    }

    return move;
  } // do we want to map slice moves to E/M/S instead of 2U/etc.?


  notationToExternal(move) {
    const grip = move.family;

    if (!move.innerLayer && !move.outerLayer) {
      if (grip === "Rv") {
        return new _alg.Move("x", move.effectiveAmount);
      } else if (grip === "Uv") {
        return new _alg.Move("y", move.effectiveAmount);
      } else if (grip === "Fv") {
        return new _alg.Move("z", move.effectiveAmount);
      } else if (grip === "Lv") {
        return negate("x", move.effectiveAmount);
      } else if (grip === "Dv") {
        return negate("y", move.effectiveAmount);
      } else if (grip === "Bv") {
        return negate("z", move.effectiveAmount);
      }
    }

    return move;
  }

} // face renaming mapper.  Accepts two face name remappers.  We
// work between the two.


exports.NxNxNCubeMapper = NxNxNCubeMapper;

class FaceRenamingMapper {
  constructor(internalNames, externalNames) {
    this.internalNames = internalNames;
    this.externalNames = externalNames;
  } // TODO:  consider putting a cache in front of this


  convertString(grip, a, b) {
    let suffix = "";

    if ((grip.endsWith("v") || grip.endsWith("v")) && grip <= "_") {
      suffix = grip.slice(grip.length - 1);
      grip = grip.slice(0, grip.length - 1);
    }

    const upper = grip.toUpperCase();
    let isLowerCase = false;

    if (grip !== upper) {
      isLowerCase = true;
      grip = upper;
    }

    grip = b.joinByFaceIndices(a.splitByFaceNames(grip));

    if (isLowerCase) {
      grip = grip.toLowerCase();
    }

    return grip + suffix;
  }

  convert(move, a, b) {
    const grip = move.family;
    const ngrip = this.convertString(grip, a, b);

    if (grip === ngrip) {
      return move;
    } else {
      return new _alg.Move(new _alg.QuantumMove(ngrip, move.innerLayer, move.outerLayer), move.effectiveAmount);
    }
  }

  notationToInternal(move) {
    const r = this.convert(move, this.externalNames, this.internalNames);
    return r;
  }

  notationToExternal(move) {
    return this.convert(move, this.internalNames, this.externalNames);
  }

} // Sits on top of a (possibly null) notation mapper, and
// adds R++/R--/D++/D-- notation mapping.


exports.FaceRenamingMapper = FaceRenamingMapper;

class MegaminxScramblingNotationMapper {
  constructor(child) {
    this.child = child;
  }

  notationToInternal(move) {
    if (move.innerLayer === undefined && move.outerLayer === undefined) {
      if (Math.abs(move.effectiveAmount) === 1) {
        if (move.family === "R++") {
          return new _alg.Move(new _alg.QuantumMove("L", 3, 2), -2 * move.effectiveAmount);
        } else if (move.family === "R--") {
          return new _alg.Move(new _alg.QuantumMove("L", 3, 2), 2 * move.effectiveAmount);
        } else if (move.family === "D++") {
          return new _alg.Move(new _alg.QuantumMove("U", 3, 2), -2 * move.effectiveAmount);
        } else if (move.family === "D--") {
          return new _alg.Move(new _alg.QuantumMove("U", 3, 2), 2 * move.effectiveAmount);
        }
      }

      if (move.family === "y") {
        return new _alg.Move("Uv", move.effectiveAmount);
      }
    }

    return this.child.notationToInternal(move);
  } // we never rewrite click moves to these moves.


  notationToExternal(move) {
    if (move.family === "Uv") {
      return new _alg.Move(new _alg.QuantumMove("y", move.innerLayer, move.outerLayer), move.effectiveAmount);
    }

    if (move.family === "Dv") {
      return negate("y", move.effectiveAmount);
    }

    return this.child.notationToExternal(move);
  }

}

exports.MegaminxScramblingNotationMapper = MegaminxScramblingNotationMapper;

class SkewbNotationMapper {
  constructor(child) {
    this.child = child;
  }

  notationToInternal(move) {
    if (move.innerLayer || move.outerLayer) {
      return null;
    }

    if (move.family === "F") {
      return new _alg.Move(new _alg.QuantumMove("DFR", move.outerLayer, move.innerLayer), move.effectiveAmount);
    } else if (move.family === "R") {
      return new _alg.Move(new _alg.QuantumMove("DBR", move.outerLayer, move.innerLayer), move.effectiveAmount);
    } else if (move.family === "L") {
      return new _alg.Move(new _alg.QuantumMove("DFL", move.outerLayer, move.innerLayer), move.effectiveAmount);
    } else if (move.family === "B") {
      return new _alg.Move(new _alg.QuantumMove("DBL", move.outerLayer, move.innerLayer), move.effectiveAmount);
      /*
       *   (1) We are not including x/y/z in Skewb; they aren't WCA notation and
       *   it's unclear anyone needs them for reconstructions.
       *
      } else if (move.family === "x") {
      return new BlockMove(move.outerLayer, move.innerLayer, "Rv", move.amount);
      } else if (move.family === "y") {
      return new BlockMove(move.outerLayer, move.innerLayer, "Uv", move.amount);
      } else if (move.family === "z") {
      return new BlockMove(move.outerLayer, move.innerLayer, "Fv", move.amount);
       */
    } else {
      return null;
    }
  } // we never rewrite click moves to these moves.


  notationToExternal(move) {
    if (this.child.spinmatch(move.family, "DFR")) {
      return new _alg.Move(new _alg.QuantumMove("F", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (this.child.spinmatch(move.family, "DRB")) {
      return new _alg.Move(new _alg.QuantumMove("R", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (this.child.spinmatch(move.family, "DFL")) {
      return new _alg.Move(new _alg.QuantumMove("L", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (this.child.spinmatch(move.family, "DBL")) {
      return new _alg.Move(new _alg.QuantumMove("B", move.innerLayer, move.outerLayer), move.effectiveAmount);
      /*
       *   See (1) above.
       *
      } else if (move.family === "Rv") {
      return new BlockMove(move.outerLayer, move.innerLayer, "x", move.amount);
      } else if (move.family === "Uv") {
      return new BlockMove(move.outerLayer, move.innerLayer, "y", move.amount);
      } else if (move.family === "Fv") {
      return new BlockMove(move.outerLayer, move.innerLayer, "z", move.amount);
       */
    } else {
      return null;
    }
  }

}

exports.SkewbNotationMapper = SkewbNotationMapper;

class PyraminxNotationMapper {
  constructor(child) {
    this.child = child;
  }

  notationToInternal(move) {
    if (move.innerLayer || move.outerLayer) {
      return null;
    }

    if (move.family === "U") {
      return new _alg.Move(new _alg.QuantumMove("flr", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (move.family === "R") {
      return new _alg.Move(new _alg.QuantumMove("fld", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (move.family === "L") {
      return new _alg.Move(new _alg.QuantumMove("frd", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (move.family === "B") {
      return new _alg.Move(new _alg.QuantumMove("dlr", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (move.family === "u") {
      return new _alg.Move(new _alg.QuantumMove("FLR", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (move.family === "r") {
      return new _alg.Move(new _alg.QuantumMove("FLD", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (move.family === "l") {
      return new _alg.Move(new _alg.QuantumMove("FRD", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (move.family === "b") {
      return new _alg.Move(new _alg.QuantumMove("DLR", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else if (move.family === "y") {
      return negate("Dv", move.effectiveAmount);
    } else {
      return null;
    }
  } // we never rewrite click moves to these moves.


  notationToExternal(move) {
    if (move.family === move.family.toLowerCase()) {
      const fam = move.family.toUpperCase();

      if (this.child.spinmatch(fam, "FLR")) {
        return new _alg.Move(new _alg.QuantumMove("U", move.innerLayer, move.outerLayer), move.effectiveAmount);
      } else if (this.child.spinmatch(fam, "FLD")) {
        return new _alg.Move(new _alg.QuantumMove("R", move.innerLayer, move.outerLayer), move.effectiveAmount);
      } else if (this.child.spinmatch(fam, "FRD")) {
        return new _alg.Move(new _alg.QuantumMove("L", move.innerLayer, move.outerLayer), move.effectiveAmount);
      } else if (this.child.spinmatch(fam, "DLR")) {
        return new _alg.Move(new _alg.QuantumMove("B", move.innerLayer, move.outerLayer), move.effectiveAmount);
      }
    }

    if (move.family === move.family.toUpperCase()) {
      if (this.child.spinmatch(move.family, "FLR")) {
        return new _alg.Move(new _alg.QuantumMove("u", move.innerLayer, move.outerLayer), move.effectiveAmount);
      } else if (this.child.spinmatch(move.family, "FLD")) {
        return new _alg.Move(new _alg.QuantumMove("r", move.innerLayer, move.outerLayer), move.effectiveAmount);
      } else if (this.child.spinmatch(move.family, "FRD")) {
        return new _alg.Move(new _alg.QuantumMove("l", move.innerLayer, move.outerLayer), move.effectiveAmount);
      } else if (this.child.spinmatch(move.family, "DLR")) {
        return new _alg.Move(new _alg.QuantumMove("b", move.innerLayer, move.outerLayer), move.effectiveAmount);
      }
    }

    if (move.family === "Dv") {
      return negate("y", move.effectiveAmount);
    } else {
      return null;
    }
  }

}

exports.PyraminxNotationMapper = PyraminxNotationMapper;

class FTONotationMapper {
  constructor(child, sw) {
    this.child = child;
    this.sw = sw;
  }

  notationToInternal(move) {
    if (move.family === "T" && move.innerLayer === undefined && move.outerLayer === undefined) {
      return new _alg.Move(new _alg.QuantumMove("FLRv", move.innerLayer, move.outerLayer), move.effectiveAmount);
    } else {
      const r = this.child.notationToInternal(move);
      return r;
    }
  } // we never rewrite click moves to these moves.


  notationToExternal(move) {
    let fam = move.family;

    if (fam.length > 0 && fam[fam.length - 1] === "v") {
      fam = fam.substring(0, fam.length - 1);
    }

    if (this.sw.spinmatch(fam, "FLUR")) {
      return new _alg.Move(new _alg.QuantumMove("T", move.innerLayer, move.outerLayer), move.effectiveAmount);
    }

    return this.child.notationToExternal(move);
  }

}

exports.FTONotationMapper = FTONotationMapper;
},{"../alg":"7Ff6b"}],"7aLGY":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.PGPuzzles = void 0;
const PGPuzzles = {
  "2x2x2": "c f 0",
  "3x3x3": "c f 0.333333333333333",
  "4x4x4": "c f 0.5 f 0",
  "5x5x5": "c f 0.6 f 0.2",
  "6x6x6": "c f 0.666666666666667 f 0.333333333333333 f 0",
  "7x7x7": "c f 0.714285714285714 f 0.428571428571429 f 0.142857142857143",
  "8x8x8": "c f 0.75 f 0.5 f 0.25 f 0",
  "9x9x9": "c f 0.777777777777778 f 0.555555555555556 f 0.333333333333333 f 0.111111111111111",
  "10x10x10": "c f 0.8 f 0.6 f 0.4 f 0.2 f 0",
  "11x11x11": "c f 0.818181818181818 f 0.636363636363636 f 0.454545454545455 f 0.272727272727273 f 0.0909090909090909",
  "12x12x12": "c f 0.833333333333333 f 0.666666666666667 f 0.5 f 0.333333333333333 f 0.166666666666667 f 0",
  "13x13x13": "c f 0.846153846153846 f 0.692307692307692 f 0.538461538461538 f 0.384615384615385 f 0.230769230769231 f 0.0769230769230769",
  "20x20x20": "c f 0 f .1 f .2 f .3 f .4 f .5 f .6 f .7 f .8 f .9",
  "30x30x30": "c f 0 f .066667 f .133333 f .2 f .266667 f .333333 f .4 f .466667 f .533333 f .6 f .666667 f .733333 f .8 f .866667 f .933333",
  "40x40x40": "c f 0 f .05 f .1 f .15 f .2 f .25 f .3 f .35 f .4 f .45 f .5 f .55 f .6 f .65 f .7 f .75 f .8 f .85 f .9 f .95",
  "skewb": "c v 0",
  "master skewb": "c v 0.275",
  "professor skewb": "c v 0 v 0.38",
  "compy cube": "c v 0.915641442663986",
  "helicopter": "c e 0.707106781186547",
  "curvy copter": "c e 0.83",
  "dino": "c v 0.577350269189626",
  "little chop": "c e 0",
  "pyramorphix": "t e 0",
  "mastermorphix": "t e 0.346184634065199",
  "pyraminx": "t v 0.333333333333333 v 1.66666666666667",
  "master pyraminx": "t v 0 v 1 v 2",
  "professor pyraminx": "t v -0.2 v 0.6 v 1.4 v 2.2",
  "Jing pyraminx": "t f 0",
  "master pyramorphix": "t e 0.866025403784437",
  "megaminx": "d f 0.7",
  "gigaminx": "d f 0.64 f 0.82",
  "teraminx": "d f 0.64 f 0.76 f 0.88",
  "petaminx": "d f 0.64 f 0.73 f 0.82 f 0.91",
  "examinx": "d f 0.64 f 0.712 f 0.784 f 0.856 f 0.928",
  "zetaminx": "d f 0.64 f 0.7 f 0.76 f 0.82 f 0.88 f 0.94",
  "yottaminx": "d f 0.64 f 0.6914 f 0.7429 f 0.7943 f 0.8457 f 0.8971 f 0.9486",
  "pentultimate": "d f 0",
  "master pentultimate": "d f 0.1",
  "elite pentultimate": "d f 0 f 0.145905",
  // exact value for starminx is sqrt(5(5-2 sqrt(5))/3)
  "starminx": "d v 0.937962370425399",
  "starminx 2": "d f 0.23606797749979",
  "pyraminx crystal": "d f 0.447213595499989",
  "chopasaurus": "d v 0",
  "big chop": "d e 0",
  "skewb diamond": "o f 0",
  "FTO": "o f 0.333333333333333",
  "master FTO": "o f 0.5 f 0",
  "Christopher's jewel": "o v 0.577350269189626",
  "octastar": "o e 0",
  "Trajber's octahedron": "o v 0.433012701892219",
  "radio chop": "i f 0",
  "icosamate": "i v 0",
  "icosahedron 2": "i v 0.18759247376021",
  "icosahedron 3": "i v 0.18759247376021 e 0",
  "icosahedron static faces": "i v 0.84",
  "icosahedron moving faces": "i v 0.73",
  "Eitan's star": "i f 0.61803398874989",
  "2x2x2 + dino": "c f 0 v 0.577350269189626",
  "2x2x2 + little chop": "c f 0 e 0",
  "dino + little chop": "c v 0.577350269189626 e 0",
  "2x2x2 + dino + little chop": "c f 0 v 0.577350269189626 e 0",
  "megaminx + chopasaurus": "d f 0.61803398875 v 0",
  "starminx combo": "d f 0.23606797749979 v 0.937962370425399"
};
exports.PGPuzzles = PGPuzzles;
},{}],"fuu67":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.cube = cube;
exports.tetrahedron = tetrahedron;
exports.dodecahedron = dodecahedron;
exports.icosahedron = icosahedron;
exports.octahedron = octahedron;
exports.closure = closure;
exports.uniqueplanes = uniqueplanes;
exports.getface = getface;

var _Quat = require("./Quat");

/* tslint:disable prefer-for-of */
// TODO
// Next we define a class that yields quaternion generators for each of
// the five platonic solids.  The quaternion generators chosen are
// chosen specifically so that the first quaternion doubles as a plane
// description that yields the given Platonic solid (so for instance, the
// cubical group and octahedral group are identical in math, but we
// give distinct representations choosing the first quaternion so that
// we get the desired figure.)  Our convention is one vertex of the
// shape points precisely down.
// This class is static.
const eps = 1e-9; // TODO: Deduplicate with `PuzzleGeometry`?

function cube() {
  const s5 = Math.sqrt(0.5);
  return [new _Quat.Quat(s5, s5, 0, 0), new _Quat.Quat(s5, 0, s5, 0)];
}

function tetrahedron() {
  return [new _Quat.Quat(0.5, 0.5, 0.5, 0.5), new _Quat.Quat(0.5, 0.5, 0.5, -0.5)];
}

function dodecahedron() {
  const d36 = 2 * Math.PI / 10;
  let dx = 0.5 + 0.3 * Math.sqrt(5);
  let dy = 0.5 + 0.1 * Math.sqrt(5);
  const dd = Math.sqrt(dx * dx + dy * dy);
  dx /= dd;
  dy /= dd;
  return [new _Quat.Quat(Math.cos(d36), dx * Math.sin(d36), dy * Math.sin(d36), 0), new _Quat.Quat(0.5, 0.5, 0.5, 0.5)];
}

function icosahedron() {
  let dx = 1 / 6 + Math.sqrt(5) / 6;
  let dy = 2 / 3 + Math.sqrt(5) / 3;
  const dd = Math.sqrt(dx * dx + dy * dy);
  dx /= dd;
  dy /= dd;
  const ang = 2 * Math.PI / 6;
  return [new _Quat.Quat(Math.cos(ang), dx * Math.sin(ang), dy * Math.sin(ang), 0), new _Quat.Quat(Math.cos(ang), -dx * Math.sin(ang), dy * Math.sin(ang), 0)];
}

function octahedron() {
  const s5 = Math.sqrt(0.5);
  return [new _Quat.Quat(0.5, 0.5, 0.5, 0.5), new _Quat.Quat(s5, 0, 0, s5)];
}

function closure(g) {
  // compute the closure of a set of generators
  // This is quadratic in the result size.  Also, it has no protection
  // against you providing a bogus set of generators that would generate
  // an infinite group.
  const q = [new _Quat.Quat(1, 0, 0, 0)];

  for (let i = 0; i < q.length; i++) {
    for (let j = 0; j < g.length; j++) {
      const ns = g[j].mul(q[i]);
      const negns = ns.smul(-1);
      let wasseen = false;

      for (let k = 0; k < q.length; k++) {
        if (ns.dist(q[k]) < eps || negns.dist(q[k]) < eps) {
          wasseen = true;
          break;
        }
      }

      if (!wasseen) {
        q.push(ns);
      }
    }
  }

  return q;
}

function uniqueplanes(p, g) {
  // compute unique plane rotations
  // given a rotation group and a plane, find the rotations that
  // generate unique planes.  This is quadratic in the return size.
  const planes = [];
  const planerot = [];

  for (let i = 0; i < g.length; i++) {
    const p2 = p.rotateplane(g[i]);
    let wasseen = false;

    for (let j = 0; j < planes.length; j++) {
      if (p2.dist(planes[j]) < eps) {
        wasseen = true;
        break;
      }
    }

    if (!wasseen) {
      planes.push(p2);
      planerot.push(g[i]);
    }
  }

  return planerot;
}

function getface(planes) {
  // compute a face given a set of planes
  // The face returned will be a set of points that lie in the first plane
  // in the given array, that are on the surface of the polytope defined
  // by all the planes, and will be returned in clockwise order.
  // This is O(planes^2 * return size + return_size^2).
  const face = [];

  for (let i = 1; i < planes.length; i++) {
    for (let j = i + 1; j < planes.length; j++) {
      const p = (0, _Quat.solvethreeplanes)(0, i, j, planes);

      if (p) {
        let wasseen = false;

        for (let k = 0; k < face.length; k++) {
          if (p.dist(face[k]) < eps) {
            wasseen = true;
            break;
          }
        }

        if (!wasseen) {
          face.push(p);
        }
      }
    }
  }

  for (;;) {
    let changed = false;

    for (let i = 0; i < face.length; i++) {
      const j = (i + 1) % face.length;

      if (planes[0].dot(face[i].cross(face[j])) < 0) {
        const t = face[i];
        face[i] = face[j];
        face[j] = t;
        changed = true;
      }
    }

    if (!changed) {
      break;
    }
  }

  return face;
}
},{"./Quat":"4Jbs3"}],"4Jbs3":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.expandfaces = expandfaces;
exports.centermassface = centermassface;
exports.random = random;
exports.solvethreeplanes = solvethreeplanes;
exports.Quat = exports.FaceTree = void 0;

/* tslint:disable no-bitwise */

/* tslint:disable prefer-for-of */
// TODO
// We need a quaternion class.  We use this to represent rotations,
// planes, and points.
const eps = 1e-9; // TODO: Deduplicate with `PuzzleGeometry`?

function expandfaces(rots, faces) {
  // given a set of faces, expand by rotation set
  const nfaces = [];

  for (let i = 0; i < rots.length; i++) {
    for (let k = 0; k < faces.length; k++) {
      const face = faces[k];
      const nface = [];

      for (let j = 0; j < face.length; j++) {
        nface.push(face[j].rotateplane(rots[i]));
      }

      nfaces.push(nface);
    }
  }

  return nfaces;
}

function centermassface(face) {
  // calculate a center of a face by averaging points
  let s = new Quat(0, 0, 0, 0);

  for (let i = 0; i < face.length; i++) {
    s = s.sum(face[i]);
  }

  return s.smul(1.0 / face.length);
}

function random() {
  // generate a random quat
  const q = new Quat(Math.random() * 2 - 1, Math.random() * 2 - 1, Math.random() * 2 - 1, Math.random() * 2 - 1);
  return q.smul(1 / q.len());
}

function solvethreeplanes(p1, p2, p3, planes) {
  // find intersection of three planes but only if interior
  // Takes three indices into a plane array, and returns the point at the
  // intersection of all three, but only if it is internal to all planes.
  const p = planes[p1].intersect3(planes[p2], planes[p3]);

  if (!p) {
    return p;
  }

  for (let i = 0; i < planes.length; i++) {
    if (i !== p1 && i !== p2 && i !== p3) {
      const dt = planes[i].b * p.b + planes[i].c * p.c + planes[i].d * p.d;

      if (planes[i].a > 0 && dt > planes[i].a || planes[i].a < 0 && dt < planes[i].a) {
        return false;
      }
    }
  }

  return p;
}

class FaceTree {
  constructor(face, left, right) {
    this.face = face;
    this.left = left;
    this.right = right;
  }

  split(q) {
    const t = q.cutface(this.face);

    if (t !== null) {
      if (this.left === undefined) {
        this.left = new FaceTree(t[0]);
        this.right = new FaceTree(t[1]);
      } else {
        var _this$left, _this$right;

        this.left = (_this$left = this.left) === null || _this$left === void 0 ? void 0 : _this$left.split(q);
        this.right = (_this$right = this.right) === null || _this$right === void 0 ? void 0 : _this$right.split(q);
      }
    }

    return this;
  }

  collect(arr, leftfirst) {
    if (this.left === undefined) {
      arr.push(this.face);
    } else if (leftfirst) {
      var _this$left2, _this$right2;

      (_this$left2 = this.left) === null || _this$left2 === void 0 ? void 0 : _this$left2.collect(arr, false);
      (_this$right2 = this.right) === null || _this$right2 === void 0 ? void 0 : _this$right2.collect(arr, true);
    } else {
      var _this$right3, _this$left3;

      (_this$right3 = this.right) === null || _this$right3 === void 0 ? void 0 : _this$right3.collect(arr, false);
      (_this$left3 = this.left) === null || _this$left3 === void 0 ? void 0 : _this$left3.collect(arr, true);
    }

    return arr;
  }

}

exports.FaceTree = FaceTree;

class Quat {
  constructor(a, b, c, d) {
    this.a = a;
    this.b = b;
    this.c = c;
    this.d = d;
  }

  mul(q) {
    // Quaternion multiplication
    return new Quat(this.a * q.a - this.b * q.b - this.c * q.c - this.d * q.d, this.a * q.b + this.b * q.a + this.c * q.d - this.d * q.c, this.a * q.c - this.b * q.d + this.c * q.a + this.d * q.b, this.a * q.d + this.b * q.c - this.c * q.b + this.d * q.a);
  }

  toString() {
    return "Q[" + this.a + "," + this.b + "," + this.c + "," + this.d + "]";
  }

  dist(q) {
    // Euclidean distance
    return Math.hypot(this.a - q.a, this.b - q.b, this.c - q.c, this.d - q.d);
  }

  len() {
    // Euclidean length
    return Math.hypot(this.a, this.b, this.c, this.d);
  }

  cross(q) {
    // cross product
    return new Quat(0, this.c * q.d - this.d * q.c, this.d * q.b - this.b * q.d, this.b * q.c - this.c * q.b);
  }

  dot(q) {
    // dot product of two quaternions
    return this.b * q.b + this.c * q.c + this.d * q.d;
  }

  normalize() {
    // make the magnitude be 1
    const d = Math.sqrt(this.dot(this));
    return new Quat(this.a / d, this.b / d, this.c / d, this.d / d);
  }

  makenormal() {
    // make a normal vector from a plane or quat or point
    return new Quat(0, this.b, this.c, this.d).normalize();
  }

  normalizeplane() {
    // normalize a plane
    const d = Math.hypot(this.b, this.c, this.d);
    return new Quat(this.a / d, this.b / d, this.c / d, this.d / d);
  }

  smul(m) {
    // scalar multiplication
    return new Quat(this.a * m, this.b * m, this.c * m, this.d * m);
  }

  sum(q) {
    // quaternion sum
    return new Quat(this.a + q.a, this.b + q.b, this.c + q.c, this.d + q.d);
  }

  sub(q) {
    // difference
    return new Quat(this.a - q.a, this.b - q.b, this.c - q.c, this.d - q.d);
  }

  angle() {
    // quaternion angle
    return 2 * Math.acos(this.a);
  }

  invrot() {
    // quaternion inverse rotation
    return new Quat(this.a, -this.b, -this.c, -this.d);
  }

  det3x3(a00, a01, a02, a10, a11, a12, a20, a21, a22) {
    // 3x3 determinant
    return a00 * (a11 * a22 - a12 * a21) + a01 * (a12 * a20 - a10 * a22) + a02 * (a10 * a21 - a11 * a20);
  }

  rotateplane(q) {
    // rotate a plane using a quaternion
    const t = q.mul(new Quat(0, this.b, this.c, this.d)).mul(q.invrot());
    t.a = this.a;
    return t;
  } // return any vector orthogonal to the given one.  Find the smallest
  // component (in absolute value) and return the cross product of that
  // axis with the given vector.


  orthogonal() {
    const ab = Math.abs(this.b);
    const ac = Math.abs(this.c);
    const ad = Math.abs(this.d);

    if (ab < ac && ab < ad) {
      return this.cross(new Quat(0, 1, 0, 0)).normalize();
    } else if (ac < ab && ac < ad) {
      return this.cross(new Quat(0, 0, 1, 0)).normalize();
    } else {
      return this.cross(new Quat(0, 0, 0, 1)).normalize();
    }
  } // return the Quaternion that will rotate the this vector
  // to the b vector through rotatepoint.


  pointrotation(b) {
    const a = this.normalize();
    b = b.normalize();

    if (a.sub(b).len() < eps) {
      return new Quat(1, 0, 0, 0);
    }

    let h = a.sum(b);

    if (h.len() < eps) {
      h = h.orthogonal();
    } else {
      h = h.normalize();
    }

    const r = a.cross(h);
    r.a = a.dot(h);
    return r;
  } // given two vectors, return the portion of the first that
  // is not in the direction of the second.


  unproject(b) {
    return this.sum(b.smul(-this.dot(b) / (this.len() * b.len())));
  }

  rotatepoint(q) {
    // rotate a point
    return q.mul(this).mul(q.invrot());
  }

  rotateface(face) {
    // rotate a face by this Q.
    return face.map(_ => _.rotatepoint(this));
  }

  rotatecubie(cubie) {
    // rotate a cubie by this Q.
    return cubie.map(_ => this.rotateface(_));
  }

  intersect3(p2, p3) {
    // intersect three planes if there is one
    const det = this.det3x3(this.b, this.c, this.d, p2.b, p2.c, p2.d, p3.b, p3.c, p3.d);

    if (Math.abs(det) < eps) {
      return false; // TODO: Change to `null` or `undefined`?
    }

    return new Quat(0, this.det3x3(this.a, this.c, this.d, p2.a, p2.c, p2.d, p3.a, p3.c, p3.d) / det, this.det3x3(this.b, this.a, this.d, p2.b, p2.a, p2.d, p3.b, p3.a, p3.d) / det, this.det3x3(this.b, this.c, this.a, p2.b, p2.c, p2.a, p3.b, p3.c, p3.a) / det);
  }

  side(x) {
    // is this point close to the origin, or on one or the other side?
    if (x > eps) {
      return 1;
    }

    if (x < -eps) {
      return -1;
    }

    return 0;
  }
  /**
   * Cuts a face by this plane, or returns null if there
   * is no intersection.
   * @param face The face to cut.
   */


  cutface(face) {
    const d = this.a;
    let seen = 0;
    let r = null;

    for (let i = 0; i < face.length; i++) {
      seen |= 1 << this.side(face[i].dot(this) - d) + 1;
    }

    if ((seen & 5) === 5) {
      r = []; // saw both sides

      const inout = face.map(_ => this.side(_.dot(this) - d));

      for (let s = -1; s <= 1; s += 2) {
        const nface = [];

        for (let k = 0; k < face.length; k++) {
          if (inout[k] === s || inout[k] === 0) {
            nface.push(face[k]);
          }

          const kk = (k + 1) % face.length;

          if (inout[k] + inout[kk] === 0 && inout[k] !== 0) {
            const vk = face[k].dot(this) - d;
            const vkk = face[kk].dot(this) - d;
            const r = vk / (vk - vkk);
            const pt = face[k].smul(1 - r).sum(face[kk].smul(r));
            nface.push(pt);
          }
        }

        r.push(nface);
      }
    }

    return r;
  }

  cutfaces(faces) {
    // Cut a set of faces by a plane and return new set
    const nfaces = [];

    for (let j = 0; j < faces.length; j++) {
      const face = faces[j];
      const t = this.cutface(face);

      if (t) {
        nfaces.push(t[0]);
        nfaces.push(t[1]);
      } else {
        nfaces.push(face);
      }
    }

    return nfaces;
  }

  faceside(face) {
    // which side of a plane is a face on?
    const d = this.a;

    for (let i = 0; i < face.length; i++) {
      const s = this.side(face[i].dot(this) - d);

      if (s !== 0) {
        return s;
      }
    }

    throw new Error("Could not determine side of plane in faceside");
  }

  sameplane(p) {
    // are two planes the same?
    const a = this.normalize();
    const b = p.normalize();
    return a.dist(b) < eps || a.dist(b.smul(-1)) < eps;
  }

  makecut(r) {
    // make a cut from a normal vector
    return new Quat(r, this.b, this.c, this.d);
  }

}

exports.Quat = Quat;
},{}],"1ZFXX":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.schreierSims = schreierSims;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _Perm = require("./Perm");

class FactoredNumber {
  constructor() {
    (0, _defineProperty2.default)(this, "mult", void 0);
    this.mult = [];
  }

  multiply(n) {
    for (let f = 2; f * f <= n; f++) {
      while (n % f === 0) {
        if (undefined !== this.mult[f]) {
          this.mult[f]++;
        } else {
          this.mult[f] = 1;
        }

        n /= f;
      }
    }

    if (n > 1) {
      if (undefined !== this.mult[n]) {
        this.mult[n]++;
      } else {
        this.mult[n] = 1;
      }
    }
  }

  toString() {
    let r = "";

    for (let i = 0; i < this.mult.length; i++) {
      if (undefined !== this.mult[i]) {
        if (r !== "") {
          r += "*";
        }

        r += i;

        if (this.mult[i] > 1) {
          r += "^" + this.mult[i];
        }
      }
    }

    return r;
  }

}

function schreierSims(g, disp) {
  const n = g[0].p.length;
  const e = (0, _Perm.identity)(n);
  let sgs = [];
  let sgsi = [];
  let sgslen = [];
  let Tk = [];
  let Tklen = [];

  function resolve(p) {
    for (let i = p.p.length - 1; i >= 0; i--) {
      const j = p.p[i];

      if (j !== i) {
        if (!sgs[i][j]) {
          return false;
        }

        p = p.mul(sgsi[i][j]);
      }
    }

    return true;
  }

  function knutha(k, p, len) {
    Tk[k].push(p);
    Tklen[k].push(len);

    for (let i = 0; i < sgs[k].length; i++) {
      if (sgs[k][i]) {
        knuthb(k, sgs[k][i].mul(p), len + sgslen[k][i]);
      }
    }
  }

  function knuthb(k, p, len) {
    const j = p.p[k];

    if (!sgs[k][j]) {
      sgs[k][j] = p;
      sgsi[k][j] = p.inv();
      sgslen[k][j] = len;

      for (let i = 0; i < Tk[k].length; i++) {
        knuthb(k, p.mul(Tk[k][i]), len + Tklen[k][i]);
      }

      return;
    }

    const p2 = p.mul(sgsi[k][j]);

    if (!resolve(p2)) {
      knutha(k - 1, p2, len + sgslen[k][j]);
    }
  }

  function getsgs() {
    sgs = [];
    sgsi = [];
    Tk = [];
    sgslen = [];
    Tklen = [];

    for (let i = 0; i < n; i++) {
      sgs.push([]);
      sgsi.push([]);
      sgslen.push([]);
      Tk.push([]);
      Tklen.push([]);
      sgs[i][i] = e;
      sgsi[i][i] = e;
      sgslen[i][i] = 0;
    }

    let none = 0;
    let sz = 1;

    for (let i = 0; i < g.length; i++) {
      knutha(n - 1, g[i], 1);
      sz = 1;
      let tks = 0;
      let sollen = 0;
      const avgs = [];
      const mults = new FactoredNumber();

      for (let j = 0; j < n; j++) {
        let cnt = 0;
        let lensum = 0;

        for (let k = 0; k < n; k++) {
          if (sgs[j][k]) {
            cnt++;
            lensum += sgslen[j][k];

            if (j !== k) {
              none++;
            }
          }
        }

        tks += Tk[j].length;
        sz *= cnt;

        if (cnt > 1) {
          mults.multiply(cnt);
        }

        const avg = lensum / cnt;
        avgs.push(avg);
        sollen += avg;
      }

      disp("" + i + ": sz " + sz + " T " + tks + " sol " + sollen + " none " + none + " mults " + mults);
    }

    return sz;
  }

  return getsgs();
}
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","./Perm":"VeGsJ"}]},{},["5yKvQ"], "5yKvQ", "parcelRequire0395")

//# sourceMappingURL=puzzle-geometry.b4ff5f93.js.map
