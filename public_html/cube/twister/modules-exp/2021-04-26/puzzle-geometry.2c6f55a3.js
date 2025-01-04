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
})({"7Ff6b":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
var _exportNames = {
  Alg: true,
  AlgBuilder: true,
  TraversalDownUp: true,
  TraversalUp: true,
  Example: true,
  keyToMove: true,
  algCubingNetLink: true,
  AlgCubingNetOptions: true,
  experimentalAppendMove: true,
  experimentalIs: true,
  experimentalDirectedGenerator: true,
  experimentalDirect: true,
  ExperimentalIterationDirection: true
};
Object.defineProperty(exports, "Alg", {
  enumerable: true,
  get: function () {
    return _Alg.Alg;
  }
});
Object.defineProperty(exports, "AlgBuilder", {
  enumerable: true,
  get: function () {
    return _AlgBuilder.AlgBuilder;
  }
});
Object.defineProperty(exports, "TraversalDownUp", {
  enumerable: true,
  get: function () {
    return _traversal.TraversalDownUp;
  }
});
Object.defineProperty(exports, "TraversalUp", {
  enumerable: true,
  get: function () {
    return _traversal.TraversalUp;
  }
});
Object.defineProperty(exports, "Example", {
  enumerable: true,
  get: function () {
    return _example.Example;
  }
});
Object.defineProperty(exports, "keyToMove", {
  enumerable: true,
  get: function () {
    return _keyboard.keyToMove;
  }
});
Object.defineProperty(exports, "algCubingNetLink", {
  enumerable: true,
  get: function () {
    return _url.algCubingNetLink;
  }
});
Object.defineProperty(exports, "AlgCubingNetOptions", {
  enumerable: true,
  get: function () {
    return _url.AlgCubingNetOptions;
  }
});
Object.defineProperty(exports, "experimentalAppendMove", {
  enumerable: true,
  get: function () {
    return _operation.experimentalAppendMove;
  }
});
Object.defineProperty(exports, "experimentalIs", {
  enumerable: true,
  get: function () {
    return _is.experimentalIs;
  }
});
Object.defineProperty(exports, "experimentalDirectedGenerator", {
  enumerable: true,
  get: function () {
    return _iteration.directedGenerator;
  }
});
Object.defineProperty(exports, "experimentalDirect", {
  enumerable: true,
  get: function () {
    return _iteration.direct;
  }
});
Object.defineProperty(exports, "ExperimentalIterationDirection", {
  enumerable: true,
  get: function () {
    return _iteration.IterationDirection;
  }
});

var _Alg = require("./Alg");

var _AlgBuilder = require("./AlgBuilder");

var _traversal = require("./traversal");

var _example = require("./example");

var _keyboard = require("./keyboard");

var _units = require("./units");

Object.keys(_units).forEach(function (key) {
  if (key === "default" || key === "__esModule") return;
  if (Object.prototype.hasOwnProperty.call(_exportNames, key)) return;
  if (key in exports && exports[key] === _units[key]) return;
  Object.defineProperty(exports, key, {
    enumerable: true,
    get: function () {
      return _units[key];
    }
  });
});

var _url = require("./url");

var _operation = require("./operation");

var _is = require("./is");

var _iteration = require("./iteration");
},{"./Alg":"1F6Jc","./AlgBuilder":"1ipjY","./traversal":"2bCs0","./example":"1UkHF","./keyboard":"5om9f","./units":"1Y0Ib","./url":"3buzo","./operation":"4iRrR","./is":"6zYKN","./iteration":"4e4oJ"}],"1F6Jc":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.experimentalEnsureAlg = experimentalEnsureAlg;
exports.Alg = void 0;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _common = require("./common");

var _is = require("./is");

var _iteration = require("./iteration");

var _parse = require("./parse");

var _traversal = require("./traversal");

var _LineComment = require("./units/leaves/LineComment");

var _Move = require("./units/leaves/Move");

var _Newline = require("./units/leaves/Newline");

var _Pause = require("./units/leaves/Pause");

var _warnOnce = require("./warnOnce");

// TODO: validate
function toIterable(input) {
  if (!input) {
    return [];
  }

  if ((0, _is.experimentalIs)(input, Alg)) {
    return input.units();
  }

  if (typeof input === "string") {
    return (0, _parse.parseAlg)(input).units(); // TODO: something more direct?
  } // const seq = inputUnits as Sequence;
  // if (seq.type === "sequence" && seq.nestedUnits) {
  //   throw new Error("unimplemented");
  //   // return seq.nestedUnits;
  // }


  const iter = input;

  if (typeof iter[Symbol.iterator] === "function") {
    return iter; // TODO: avoid allocations
  }

  throw "Invalid unit";
} // Preserves the alg if it's already an `Alg`.


function experimentalEnsureAlg(alg) {
  if ((0, _is.experimentalIs)(alg, Alg)) {
    return alg;
  }

  return new Alg(alg);
}

var _units = new WeakMap();

class Alg extends _common.AlgCommon {
  // TODO: freeze?
  constructor(alg) {
    super();

    _units.set(this, {
      writable: true,
      value: void 0
    });

    (0, _classPrivateFieldSet2.default)(this, _units, Array.from(toIterable(alg))); // TODO: can we avoid array-casting?

    for (const unit of (0, _classPrivateFieldGet2.default)(this, _units)) {
      if (!(0, _is.experimentalIsUnit)(unit)) {
        throw new Error("An alg can only contain units.");
      }
    }
  }

  isIdentical(other) {
    const otherAsAlg = other;

    if (!other.is(Alg)) {
      return false;
    } // TODO: avoid converting to array


    const l1 = Array.from((0, _classPrivateFieldGet2.default)(this, _units));
    const l2 = Array.from((0, _classPrivateFieldGet2.default)(otherAsAlg, _units));

    if (l1.length !== l2.length) {
      return false;
    }

    for (let i = 0; i < l1.length; i++) {
      if (!l1[i].isIdentical(l2[i])) {
        return false;
      }
    }

    return true;
  }

  invert() {
    // TODO: Handle newLines and comments correctly
    // TODO: Make more efficient.
    return new Alg((0, _iteration.reverse)(Array.from((0, _classPrivateFieldGet2.default)(this, _units)).map(u => u.invert())));
  }
  /** @deprecated */


  *experimentalExpand(iterDir = _iteration.IterationDirection.Forwards, depth) {
    var _depth;

    (_depth = depth) !== null && _depth !== void 0 ? _depth : depth = Infinity;

    for (const unit of (0, _iteration.direct)((0, _classPrivateFieldGet2.default)(this, _units), iterDir)) {
      yield* unit.experimentalExpand(iterDir, depth);
    }
  }

  expand(options) {
    var _options$depth;

    return new Alg(this.experimentalExpand(_iteration.IterationDirection.Forwards, (_options$depth = options === null || options === void 0 ? void 0 : options.depth) !== null && _options$depth !== void 0 ? _options$depth : Infinity));
  }
  /** @deprecated */


  *experimentalLeafMoves() {
    for (const leaf of this.experimentalExpand()) {
      if (leaf.is(_Move.Move)) {
        yield leaf;
      }
    }
  }

  concat(input) {
    return new Alg(Array.from((0, _classPrivateFieldGet2.default)(this, _units)).concat(Array.from(toIterable(input))));
  }
  /** @deprecated */


  experimentalIsEmpty() {
    for (const _ of (0, _classPrivateFieldGet2.default)(this, _units)) {
      return false;
    }

    return true;
  }

  static fromString(s) {
    return (0, _parse.parseAlg)(s);
  }

  *units() {
    for (const unit of (0, _classPrivateFieldGet2.default)(this, _units)) {
      yield unit;
    }
  }

  experimentalNumUnits() {
    return Array.from((0, _classPrivateFieldGet2.default)(this, _units)).length;
  }
  /** @deprecated */


  get type() {
    (0, _warnOnce.warnOnce)("deprecated: type");
    return "sequence";
  } // toJSON(): AlgJSON {
  //   return {
  //     type: "alg",
  //     units: Array.from(this.#units) as UnitJSON[],
  //   };
  // }


  toString() {
    let output = "";
    let previousUnit = null;

    for (const unit of (0, _classPrivateFieldGet2.default)(this, _units)) {
      if (previousUnit) {
        output += spaceBetween(previousUnit, unit); // console.log("l", previousUnit.toString(), unit.toString(), output);
      }

      output += unit.toString();
      previousUnit = unit;
    }

    return output;
  } // *experimentalExpand(options: ExperimentalExpandOptions): Generator<Unit> {
  //   // if (options.depth === 0) {
  //   //   yield* this.units();
  //   //   return;
  //   // }
  //   // const newOptions = {
  //   //   depth: options.depth ? options.depth - 1 : null,
  //   // }; // TODO: avoid allocations?
  //   // for (const unit of this.#units) {
  //   //   yield* unit.experimentalExpandIntoAlg(newOptions);
  //   // }
  // }


  simplify(options) {
    return new Alg((0, _traversal.simplify)(this, options !== null && options !== void 0 ? options : {}));
  }

}

exports.Alg = Alg;

function spaceBetween(u1, u2) {
  if (u1.is(_Pause.Pause) && u2.is(_Pause.Pause)) {
    return "";
  }

  if (u1.is(_Newline.Newline) || u2.is(_Newline.Newline)) {
    return "";
  }

  if (u1.is(_LineComment.LineComment) && !u2.is(_Newline.Newline)) {
    return "\n"; /// TODO
  }

  return " ";
}
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","./common":"3pL6h","./is":"6zYKN","./iteration":"4e4oJ","./parse":"7D5q4","./traversal":"2bCs0","./units/leaves/LineComment":"18TvJ","./units/leaves/Move":"6RDYH","./units/leaves/Newline":"2yjDB","./units/leaves/Pause":"6BUL0","./warnOnce":"5uJF9"}],"5NNmD":[function(require,module,exports) {
function _interopRequireDefault(obj) {
  return obj && obj.__esModule ? obj : {
    "default": obj
  };
}

module.exports = _interopRequireDefault;
},{}],"5PNvM":[function(require,module,exports) {
function _classPrivateFieldGet(receiver, privateMap) {
  var descriptor = privateMap.get(receiver);

  if (!descriptor) {
    throw new TypeError("attempted to get private field on non-instance");
  }

  if (descriptor.get) {
    return descriptor.get.call(receiver);
  }

  return descriptor.value;
}

module.exports = _classPrivateFieldGet;
},{}],"2m3hn":[function(require,module,exports) {
function _classPrivateFieldSet(receiver, privateMap, value) {
  var descriptor = privateMap.get(receiver);

  if (!descriptor) {
    throw new TypeError("attempted to set private field on non-instance");
  }

  if (descriptor.set) {
    descriptor.set.call(receiver, value);
  } else {
    if (!descriptor.writable) {
      throw new TypeError("attempted to set read only private field");
    }

    descriptor.value = value;
  }

  return value;
}

module.exports = _classPrivateFieldSet;
},{}],"3pL6h":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.setAlgDebugField = setAlgDebugField;
exports.AlgCommon = exports.Comparable = void 0;
let writeAlgDebugField = false;

function setAlgDebugField(debug) {
  writeAlgDebugField = debug;
}

class Comparable {
  // eslint-disable-next-line @typescript-eslint/explicit-module-boundary-types
  is(c) {
    return this instanceof c;
  }

}

exports.Comparable = Comparable;

// Common to algs or units
class AlgCommon extends Comparable {
  constructor() {
    super();

    if (writeAlgDebugField) {
      Object.defineProperty(this, "_debugStr", {
        get: function () {
          return this.toString();
        }
      });
    }
  }

}

exports.AlgCommon = AlgCommon;
},{}],"6zYKN":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.experimentalIs = experimentalIs;
exports.experimentalIsUnit = experimentalIsUnit;

var _units = require("./units");

function experimentalIs( // eslint-disable-next-line @typescript-eslint/explicit-module-boundary-types
v, c) {
  return v instanceof c;
} // eslint-disable-next-line @typescript-eslint/explicit-module-boundary-types


function experimentalIsUnit(v) {
  return experimentalIs(v, _units.Grouping) || experimentalIs(v, _units.LineComment) || experimentalIs(v, _units.Commutator) || experimentalIs(v, _units.Conjugate) || experimentalIs(v, _units.Move) || experimentalIs(v, _units.Newline) || experimentalIs(v, _units.Pause);
}
},{"./units":"1Y0Ib"}],"1Y0Ib":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
Object.defineProperty(exports, "Grouping", {
  enumerable: true,
  get: function () {
    return _Grouping.Grouping;
  }
});
Object.defineProperty(exports, "LineComment", {
  enumerable: true,
  get: function () {
    return _LineComment.LineComment;
  }
});
Object.defineProperty(exports, "Commutator", {
  enumerable: true,
  get: function () {
    return _Commutator.Commutator;
  }
});
Object.defineProperty(exports, "Conjugate", {
  enumerable: true,
  get: function () {
    return _Conjugate.Conjugate;
  }
});
Object.defineProperty(exports, "Move", {
  enumerable: true,
  get: function () {
    return _Move.Move;
  }
});
Object.defineProperty(exports, "QuantumMove", {
  enumerable: true,
  get: function () {
    return _Move.QuantumMove;
  }
});
Object.defineProperty(exports, "Newline", {
  enumerable: true,
  get: function () {
    return _Newline.Newline;
  }
});
Object.defineProperty(exports, "Pause", {
  enumerable: true,
  get: function () {
    return _Pause.Pause;
  }
});
Object.defineProperty(exports, "Unit", {
  enumerable: true,
  get: function () {
    return _Unit.Unit;
  }
});

var _Grouping = require("./containers/Grouping");

var _LineComment = require("./leaves/LineComment");

var _Commutator = require("./containers/Commutator");

var _Conjugate = require("./containers/Conjugate");

var _Move = require("./leaves/Move");

var _Newline = require("./leaves/Newline");

var _Pause = require("./leaves/Pause");

var _Unit = require("./Unit");
},{"./containers/Grouping":"6WcJj","./leaves/LineComment":"18TvJ","./containers/Commutator":"5TYpy","./containers/Conjugate":"2OKRE","./leaves/Move":"6RDYH","./leaves/Newline":"2yjDB","./leaves/Pause":"6BUL0","./Unit":"5TxQ3"}],"6WcJj":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Grouping = void 0;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _Alg = require("../../Alg");

var _common = require("../../common");

var _iteration = require("../../iteration");

var _Repetition = require("../Repetition");

var _repetition = new WeakMap();

class Grouping extends _common.AlgCommon {
  constructor(algSource, repetitionInfo) {
    super();

    _repetition.set(this, {
      writable: true,
      value: void 0
    });

    const alg = (0, _Alg.experimentalEnsureAlg)(algSource);
    (0, _classPrivateFieldSet2.default)(this, _repetition, new _Repetition.Repetition(alg, repetitionInfo));
  }

  isIdentical(other) {
    const otherAsGrouping = other;
    return other.is(Grouping) && (0, _classPrivateFieldGet2.default)(this, _repetition).isIdentical((0, _classPrivateFieldGet2.default)(otherAsGrouping, _repetition));
  }
  /** @deprecated */


  get experimentalAlg() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).quantum;
  }
  /** @deprecated */


  get experimentalEffectiveAmount() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).experimentalEffectiveAmount();
  }
  /** @deprecated */


  get experimentalRepetitionSuffix() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).suffix();
  }

  invert() {
    return new Grouping((0, _classPrivateFieldGet2.default)(this, _repetition).quantum, (0, _classPrivateFieldGet2.default)(this, _repetition).inverseInfo());
  }

  *experimentalExpand(iterDir = _iteration.IterationDirection.Forwards, depth) {
    var _depth;

    (_depth = depth) !== null && _depth !== void 0 ? _depth : depth = Infinity;

    if (depth === 0) {
      yield iterDir === _iteration.IterationDirection.Forwards ? this : this.invert();
    } else {
      yield* (0, _classPrivateFieldGet2.default)(this, _repetition).experimentalExpand(iterDir, depth - 1);
    }
  }

  static fromString() {
    throw new Error("unimplemented");
  }

  toString() {
    return `(${(0, _classPrivateFieldGet2.default)(this, _repetition).quantum.toString()})${(0, _classPrivateFieldGet2.default)(this, _repetition).suffix()}`;
  } // toJSON(): GroupingJSON {
  //   return {
  //     type: "grouping",
  //     alg: this.#quanta.quantum.toJSON(),
  //   };
  // }


}

exports.Grouping = Grouping;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","../../Alg":"1F6Jc","../../common":"3pL6h","../../iteration":"4e4oJ","../Repetition":"3QMw7"}],"4e4oJ":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.toggleDirection = toggleDirection;
exports.direct = direct;
exports.reverse = reverse;
exports.directedGenerator = directedGenerator;
exports.reverseGenerator = reverseGenerator;
exports.IterationDirection = void 0;
let IterationDirection;
exports.IterationDirection = IterationDirection;

(function (IterationDirection) {
  IterationDirection[IterationDirection["Forwards"] = 1] = "Forwards";
  IterationDirection[IterationDirection["Backwards"] = -1] = "Backwards";
})(IterationDirection || (exports.IterationDirection = IterationDirection = {}));

function toggleDirection(iterationDirection, flip = true) {
  if (!flip) {
    return iterationDirection;
  }

  switch (iterationDirection) {
    case IterationDirection.Forwards:
      return IterationDirection.Backwards;

    case IterationDirection.Backwards:
      return IterationDirection.Forwards;
  }
}

function direct(g, iterDir) {
  return iterDir === IterationDirection.Backwards ? Array.from(g).reverse() : g;
}

function reverse(g) {
  return Array.from(g).reverse();
}

function* directedGenerator(g, direction) {
  return direction === IterationDirection.Backwards ? yield* reverseGenerator(g) : yield* g;
}

function* reverseGenerator(g) {
  for (const t of Array.from(g).reverse()) {
    yield t;
  }
}
},{}],"3QMw7":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Repetition = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _iteration = require("../iteration");

var _limits = require("../limits");

class Repetition {
  constructor(quantum, repetitionInfo) {
    (0, _defineProperty2.default)(this, "quantum", void 0);
    (0, _defineProperty2.default)(this, "absAmount", null);
    (0, _defineProperty2.default)(this, "prime", false);
    this.quantum = quantum;

    if (typeof repetitionInfo === "undefined" || repetitionInfo === null) {// nothing
    } else if (typeof repetitionInfo === "number") {
      this.absAmount = repetitionInfo === null ? null : Math.abs(repetitionInfo);
      this.prime = repetitionInfo === null ? false : repetitionInfo < 0;
      return;
    } else if (repetitionInfo instanceof Array) {
      this.absAmount = repetitionInfo[0] === null ? null : repetitionInfo[0];
      this.prime = repetitionInfo[1];
    } else {
      throw new Error("invalid repetition");
    }

    if (this.absAmount !== null) {
      if (!Number.isInteger(this.absAmount) || this.absAmount < 0 || this.absAmount > _limits.MAX_INT) {
        throw new Error(`Unit amount absolute value must be a non-negative integer no larger than ${_limits.MAX_INT_DESCRIPTION}.`);
      }
    }

    if (this.prime !== false && this.prime !== true) {
      throw new Error("Invalid prime boolean.");
    }
  }
  /** @deprecated */


  experimentalEffectiveAmount() {
    var _this$absAmount;

    return ((_this$absAmount = this.absAmount) !== null && _this$absAmount !== void 0 ? _this$absAmount : 1) * (this.prime ? -1 : 1);
  }

  suffix() {
    let s = ""; // TODO

    if (this.absAmount !== null && this.absAmount !== 1) {
      s += this.absAmount;
    }

    if (this.prime) {
      s += "'";
    }

    return s;
  }

  isIdentical(other) {
    var _this$absAmount2, _other$absAmount;

    return this.quantum.isIdentical(other.quantum) && ((_this$absAmount2 = this.absAmount) !== null && _this$absAmount2 !== void 0 ? _this$absAmount2 : 1) === ((_other$absAmount = other.absAmount) !== null && _other$absAmount !== void 0 ? _other$absAmount : 1) && // TODO
    this.prime === other.prime;
  }

  info() {
    return [this.absAmount, this.prime];
  }

  inverseInfo() {
    return [this.absAmount, !this.prime];
  } // TODO: `Conjugate` and `Commutator` decrement `depth` inside the quantum, `Grouping` has to do it outside the quantum.


  *experimentalExpand(iterDir, depth) {
    var _this$absAmount3;

    const absAmount = (_this$absAmount3 = this.absAmount) !== null && _this$absAmount3 !== void 0 ? _this$absAmount3 : 1;
    const newIterDir = (0, _iteration.toggleDirection)(iterDir, this.prime);

    for (let i = 0; i < absAmount; i++) {
      yield* this.quantum.experimentalExpand(newIterDir, depth);
    }
  }

}

exports.Repetition = Repetition;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","../iteration":"4e4oJ","../limits":"4zMBm"}],"55mTs":[function(require,module,exports) {
function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

module.exports = _defineProperty;
},{}],"4zMBm":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.MAX_INT_DESCRIPTION = exports.MAX_INT = void 0;
const MAX_INT = 0x7fffffff; // 2^32-1, the max value for signed 32-bit ints.

exports.MAX_INT = MAX_INT;
const MAX_INT_DESCRIPTION = "2^32 - 1";
exports.MAX_INT_DESCRIPTION = MAX_INT_DESCRIPTION;
},{}],"18TvJ":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.LineComment = void 0;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _common = require("../../common");

var _iteration = require("../../iteration");

var _text = new WeakMap();

// TODO: hash
// TODO: this conflicts with the HTML `LineComment` class
class LineComment extends _common.AlgCommon {
  constructor(commentText) {
    super();

    _text.set(this, {
      writable: true,
      value: void 0
    });

    if (commentText.includes("\n") || commentText.includes("\r")) {
      throw new Error("LineComment cannot contain newline");
    }

    (0, _classPrivateFieldSet2.default)(this, _text, commentText);
  }

  get text() {
    return (0, _classPrivateFieldGet2.default)(this, _text);
  }

  isIdentical(other) {
    const otherAsLineComment = other;
    return other.is(LineComment) && (0, _classPrivateFieldGet2.default)(this, _text) === (0, _classPrivateFieldGet2.default)(otherAsLineComment, _text);
  }

  invert() {
    return this;
  }

  *experimentalExpand(_iterDir = _iteration.IterationDirection.Forwards, _depth = Infinity) {
    yield this;
  }

  toString() {
    return `//${(0, _classPrivateFieldGet2.default)(this, _text)}`;
  } // toJSON(): LineCommentJSON {
  //   return {
  //     type: "comment",
  //     text: this.#text,
  //   };
  // }


}

exports.LineComment = LineComment;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","../../common":"3pL6h","../../iteration":"4e4oJ"}],"5TYpy":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Commutator = exports.QuantumCommutator = void 0;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _Alg = require("../../Alg");

var _common = require("../../common");

var _iteration = require("../../iteration");

var _Repetition = require("../Repetition");

class QuantumCommutator extends _common.Comparable {
  constructor(A, B) {
    super();
    this.A = A;
    this.B = B;
    Object.freeze(this);
  }

  isIdentical(other) {
    const otherAsQuantumCommutator = other;
    return other.is(QuantumCommutator) && this.A.isIdentical(otherAsQuantumCommutator.A) && this.B.isIdentical(otherAsQuantumCommutator.B);
  }

  toString() {
    return `[${this.A}, ${this.B}]`;
  } // TODO: use a common composite iterator helper.


  *experimentalExpand(iterDir = _iteration.IterationDirection.Forwards, depth) {
    if (depth === 0) {
      throw new Error("cannot expand depth 0 for a quantum");
    }

    if (iterDir === _iteration.IterationDirection.Forwards) {
      yield* this.A.experimentalExpand(_iteration.IterationDirection.Forwards, depth - 1);
      yield* this.B.experimentalExpand(_iteration.IterationDirection.Forwards, depth - 1);
      yield* this.A.experimentalExpand(_iteration.IterationDirection.Backwards, depth - 1);
      yield* this.B.experimentalExpand(_iteration.IterationDirection.Backwards, depth - 1);
    } else {
      yield* this.B.experimentalExpand(_iteration.IterationDirection.Forwards, depth - 1);
      yield* this.A.experimentalExpand(_iteration.IterationDirection.Forwards, depth - 1);
      yield* this.B.experimentalExpand(_iteration.IterationDirection.Backwards, depth - 1);
      yield* this.A.experimentalExpand(_iteration.IterationDirection.Backwards, depth - 1);
    }
  }

}

exports.QuantumCommutator = QuantumCommutator;

var _repetition = new WeakMap();

class Commutator extends _common.AlgCommon {
  constructor(aSource, bSource, repetitionInfo) {
    super();

    _repetition.set(this, {
      writable: true,
      value: void 0
    });

    (0, _classPrivateFieldSet2.default)(this, _repetition, new _Repetition.Repetition(new QuantumCommutator((0, _Alg.experimentalEnsureAlg)(aSource), (0, _Alg.experimentalEnsureAlg)(bSource)), // TODO
    repetitionInfo));
  }

  get A() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).quantum.A;
  }

  get B() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).quantum.B;
  }
  /** @deprecated */


  get experimentalEffectiveAmount() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).experimentalEffectiveAmount();
  }
  /** @deprecated */


  get experimentalRepetitionSuffix() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).suffix();
  }

  isIdentical(other) {
    const otherAsCommutator = other;
    return other.is(Commutator) && (0, _classPrivateFieldGet2.default)(this, _repetition).isIdentical((0, _classPrivateFieldGet2.default)(otherAsCommutator, _repetition));
  }

  invert() {
    return new Commutator((0, _classPrivateFieldGet2.default)(this, _repetition).quantum.B, (0, _classPrivateFieldGet2.default)(this, _repetition).quantum.A, (0, _classPrivateFieldGet2.default)(this, _repetition).info());
  }

  *experimentalExpand(iterDir = _iteration.IterationDirection.Forwards, depth) {
    var _depth;

    (_depth = depth) !== null && _depth !== void 0 ? _depth : depth = Infinity;

    if (depth === 0) {
      yield iterDir === _iteration.IterationDirection.Forwards ? this : this.invert();
    } else {
      yield* (0, _classPrivateFieldGet2.default)(this, _repetition).experimentalExpand(iterDir, depth);
    }
  }

  toString() {
    return `${(0, _classPrivateFieldGet2.default)(this, _repetition).quantum.toString()}${(0, _classPrivateFieldGet2.default)(this, _repetition).suffix()}`;
  } // toJSON(): CommutatorJSON {
  //   return {
  //     type: "commutator",
  //     A: this.#quanta.quantum.A.toJSON(),
  //     B: this.#quanta.quantum.B.toJSON(),
  //     amount: this.a
  //   };
  // }


}

exports.Commutator = Commutator;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","../../Alg":"1F6Jc","../../common":"3pL6h","../../iteration":"4e4oJ","../Repetition":"3QMw7"}],"2OKRE":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Conjugate = exports.QuantumCommutator = void 0;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _Alg = require("../../Alg");

var _common = require("../../common");

var _iteration = require("../../iteration");

var _Repetition = require("../Repetition");

class QuantumCommutator extends _common.Comparable {
  constructor(A, B) {
    super();
    this.A = A;
    this.B = B;
    Object.freeze(this);
  }

  isIdentical(other) {
    const otherAsQuantumCommutator = other;
    return other.is(QuantumCommutator) && this.A.isIdentical(otherAsQuantumCommutator.A) && this.B.isIdentical(otherAsQuantumCommutator.B);
  } // TODO: use a common composite iterator helper.


  *experimentalExpand(iterDir = _iteration.IterationDirection.Forwards, depth) {
    if (depth === 0) {
      throw new Error("cannot expand depth 0 for a quantum");
    }

    yield* this.A.experimentalExpand(_iteration.IterationDirection.Forwards, depth - 1);
    yield* this.B.experimentalExpand(iterDir, depth - 1);
    yield* this.A.experimentalExpand(_iteration.IterationDirection.Backwards, depth - 1);
  }

  toString() {
    return `[${this.A}: ${this.B}]`;
  }

}

exports.QuantumCommutator = QuantumCommutator;

var _repetition = new WeakMap();

class Conjugate extends _common.AlgCommon {
  constructor(aSource, bSource, repetitionInfo) {
    super();

    _repetition.set(this, {
      writable: true,
      value: void 0
    });

    (0, _classPrivateFieldSet2.default)(this, _repetition, new _Repetition.Repetition(new QuantumCommutator((0, _Alg.experimentalEnsureAlg)(aSource), (0, _Alg.experimentalEnsureAlg)(bSource)), // TODO
    repetitionInfo));
  }

  get A() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).quantum.A;
  }

  get B() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).quantum.B;
  }
  /** @deprecated */


  get experimentalEffectiveAmount() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).experimentalEffectiveAmount();
  }
  /** @deprecated */


  get experimentalRepetitionSuffix() {
    return (0, _classPrivateFieldGet2.default)(this, _repetition).suffix();
  }

  isIdentical(other) {
    const otherAsConjugate = other;
    return other.is(Conjugate) && (0, _classPrivateFieldGet2.default)(this, _repetition).isIdentical((0, _classPrivateFieldGet2.default)(otherAsConjugate, _repetition));
  }

  invert() {
    return new Conjugate((0, _classPrivateFieldGet2.default)(this, _repetition).quantum.A, (0, _classPrivateFieldGet2.default)(this, _repetition).quantum.B.invert(), (0, _classPrivateFieldGet2.default)(this, _repetition).info());
  }

  *experimentalExpand(iterDir, depth) {
    var _depth;

    (_depth = depth) !== null && _depth !== void 0 ? _depth : depth = Infinity;

    if (depth === 0) {
      yield iterDir === _iteration.IterationDirection.Forwards ? this : this.invert();
    } else {
      yield* (0, _classPrivateFieldGet2.default)(this, _repetition).experimentalExpand(iterDir, depth);
    }
  }

  toString() {
    return `${(0, _classPrivateFieldGet2.default)(this, _repetition).quantum.toString()}${(0, _classPrivateFieldGet2.default)(this, _repetition).suffix()}`;
  } // toJSON(): ConjugateJSON {
  //   return {
  //     type: "conjugate",
  //     A: this.#quanta.quantum.A.toJSON(),
  //     B: this.#quanta.quantum.B.toJSON(),
  //     amount: this.a
  //   };
  // }


}

exports.Conjugate = Conjugate;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","../../Alg":"1F6Jc","../../common":"3pL6h","../../iteration":"4e4oJ","../Repetition":"3QMw7"}],"6RDYH":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Move = exports.QuantumMove = void 0;

var _classPrivateFieldGet6 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _common = require("../../common");

var _iteration = require("../../iteration");

var _limits = require("../../limits");

var _parse = require("../../parse");

var _warnOnce = require("../../warnOnce");

var _Repetition = require("../Repetition");

var _family = new WeakMap();

var _innerLayer = new WeakMap();

var _outerLayer = new WeakMap();

class QuantumMove extends _common.Comparable {
  constructor(family, innerLayer, outerLayer) {
    super();

    _family.set(this, {
      writable: true,
      value: void 0
    });

    _innerLayer.set(this, {
      writable: true,
      value: void 0
    });

    _outerLayer.set(this, {
      writable: true,
      value: void 0
    });

    (0, _classPrivateFieldSet2.default)(this, _family, family);
    (0, _classPrivateFieldSet2.default)(this, _innerLayer, innerLayer !== null && innerLayer !== void 0 ? innerLayer : null);
    (0, _classPrivateFieldSet2.default)(this, _outerLayer, outerLayer !== null && outerLayer !== void 0 ? outerLayer : null);
    Object.freeze(this);

    if ((0, _classPrivateFieldGet6.default)(this, _innerLayer) !== null && (!Number.isInteger((0, _classPrivateFieldGet6.default)(this, _innerLayer)) || (0, _classPrivateFieldGet6.default)(this, _innerLayer) < 1 || (0, _classPrivateFieldGet6.default)(this, _innerLayer) > _limits.MAX_INT)) {
      throw new Error(`QuantumMove inner layer must be a positive integer below ${_limits.MAX_INT_DESCRIPTION}.`);
    }

    if ((0, _classPrivateFieldGet6.default)(this, _outerLayer) !== null && (!Number.isInteger((0, _classPrivateFieldGet6.default)(this, _outerLayer)) || (0, _classPrivateFieldGet6.default)(this, _outerLayer) < 1 || (0, _classPrivateFieldGet6.default)(this, _outerLayer) > _limits.MAX_INT)) {
      throw new Error(`QuantumMove outer layer must be a positive integer below ${_limits.MAX_INT_DESCRIPTION}.`);
    }

    if ((0, _classPrivateFieldGet6.default)(this, _outerLayer) !== null && (0, _classPrivateFieldGet6.default)(this, _innerLayer) !== null && (0, _classPrivateFieldGet6.default)(this, _innerLayer) <= (0, _classPrivateFieldGet6.default)(this, _outerLayer)) {
      throw new Error("QuantumMove outer layer must be smaller than inner layer.");
    }

    if ((0, _classPrivateFieldGet6.default)(this, _outerLayer) !== null && (0, _classPrivateFieldGet6.default)(this, _innerLayer) === null) {
      throw new Error("QuantumMove with an outer layer must have an inner layer"); // TODO: test
    }
  }

  static fromString(s) {
    return (0, _parse.parseQuantumMove)(s);
  }

  modified(modifications) {
    var _modifications$family, _modifications$innerL, _modifications$outerL;

    return new QuantumMove((_modifications$family = modifications.family) !== null && _modifications$family !== void 0 ? _modifications$family : (0, _classPrivateFieldGet6.default)(this, _family), (_modifications$innerL = modifications.innerLayer) !== null && _modifications$innerL !== void 0 ? _modifications$innerL : (0, _classPrivateFieldGet6.default)(this, _innerLayer), (_modifications$outerL = modifications.outerLayer) !== null && _modifications$outerL !== void 0 ? _modifications$outerL : (0, _classPrivateFieldGet6.default)(this, _outerLayer));
  }

  isIdentical(other) {
    const otherAsQuantumMove = other;
    return other.is(QuantumMove) && (0, _classPrivateFieldGet6.default)(this, _family) === (0, _classPrivateFieldGet6.default)(otherAsQuantumMove, _family) && (0, _classPrivateFieldGet6.default)(this, _innerLayer) === (0, _classPrivateFieldGet6.default)(otherAsQuantumMove, _innerLayer) && (0, _classPrivateFieldGet6.default)(this, _outerLayer) === (0, _classPrivateFieldGet6.default)(otherAsQuantumMove, _outerLayer);
  } // TODO: provide something more useful on average.

  /** @deprecated */


  get family() {
    return (0, _classPrivateFieldGet6.default)(this, _family);
  } // TODO: provide something more useful on average.

  /** @deprecated */


  get outerLayer() {
    return (0, _classPrivateFieldGet6.default)(this, _outerLayer);
  } // TODO: provide something more useful on average.

  /** @deprecated */


  get innerLayer() {
    return (0, _classPrivateFieldGet6.default)(this, _innerLayer);
  }

  experimentalExpand() {
    throw new Error("experimentalExpand() cannot be called on a `QuantumMove` directly.");
  }

  toString() {
    let s = (0, _classPrivateFieldGet6.default)(this, _family);

    if ((0, _classPrivateFieldGet6.default)(this, _innerLayer) !== null) {
      s = String((0, _classPrivateFieldGet6.default)(this, _innerLayer)) + s;

      if ((0, _classPrivateFieldGet6.default)(this, _outerLayer) !== null) {
        s = String((0, _classPrivateFieldGet6.default)(this, _outerLayer)) + "-" + s;
      }
    }

    return s;
  }

}

exports.QuantumMove = QuantumMove;

var _repetition = new WeakMap();

class Move extends _common.AlgCommon {
  constructor(...args) {
    super();

    _repetition.set(this, {
      writable: true,
      value: void 0
    });

    if (typeof args[0] === "string") {
      var _args$;

      if ((_args$ = args[1]) !== null && _args$ !== void 0 ? _args$ : null) {
        (0, _classPrivateFieldSet2.default)(this, _repetition, new _Repetition.Repetition(QuantumMove.fromString(args[0]), args[1]));
        return;
      } else {
        return Move.fromString(args[0]); // TODO: can we return here?
      }
    }

    (0, _classPrivateFieldSet2.default)(this, _repetition, new _Repetition.Repetition(args[0], args[1]));
  }

  isIdentical(other) {
    const otherAsMove = other;
    return other.is(Move) && (0, _classPrivateFieldGet6.default)(this, _repetition).isIdentical((0, _classPrivateFieldGet6.default)(otherAsMove, _repetition));
  }

  invert() {
    // TODO: handle char indices more consistently among units.
    return (0, _parse.transferCharIndex)(this, new Move((0, _classPrivateFieldGet6.default)(this, _repetition).quantum, (0, _classPrivateFieldGet6.default)(this, _repetition).inverseInfo()));
  }

  *experimentalExpand(iterDir = _iteration.IterationDirection.Forwards) {
    if (iterDir === _iteration.IterationDirection.Forwards) {
      yield this;
    } else {
      yield this.modified({
        repetition: (0, _classPrivateFieldGet6.default)(this, _repetition).inverseInfo()
      });
    }
  }

  get quantum() {
    return (0, _classPrivateFieldGet6.default)(this, _repetition).quantum;
  }

  equals(other) {
    return this.quantum.isIdentical(other.quantum) && (0, _classPrivateFieldGet6.default)(this, _repetition).isIdentical((0, _classPrivateFieldGet6.default)(other, _repetition));
  }

  modified(modifications) {
    var _modifications$repeti;

    return new Move((0, _classPrivateFieldGet6.default)(this, _repetition).quantum.modified(modifications), (_modifications$repeti = modifications.repetition) !== null && _modifications$repeti !== void 0 ? _modifications$repeti : (0, _classPrivateFieldGet6.default)(this, _repetition).info());
  }

  static fromString(s) {
    return (0, _parse.parseMove)(s);
  }
  /** @deprecated */


  get effectiveAmount() {
    var _classPrivateFieldGet2;

    return ((_classPrivateFieldGet2 = (0, _classPrivateFieldGet6.default)(this, _repetition).absAmount) !== null && _classPrivateFieldGet2 !== void 0 ? _classPrivateFieldGet2 : 1) * ((0, _classPrivateFieldGet6.default)(this, _repetition).prime ? -1 : 1);
  }
  /** @deprecated */


  get type() {
    (0, _warnOnce.warnOnce)("deprecated: type");
    return "blockMove";
  }
  /** @deprecated */


  get family() {
    var _classPrivateFieldGet3;

    return (_classPrivateFieldGet3 = (0, _classPrivateFieldGet6.default)(this, _repetition).quantum.family) !== null && _classPrivateFieldGet3 !== void 0 ? _classPrivateFieldGet3 : undefined;
  }
  /** @deprecated */


  get outerLayer() {
    var _classPrivateFieldGet4;

    return (_classPrivateFieldGet4 = (0, _classPrivateFieldGet6.default)(this, _repetition).quantum.outerLayer) !== null && _classPrivateFieldGet4 !== void 0 ? _classPrivateFieldGet4 : undefined;
  }
  /** @deprecated */


  get innerLayer() {
    var _classPrivateFieldGet5;

    return (_classPrivateFieldGet5 = (0, _classPrivateFieldGet6.default)(this, _repetition).quantum.innerLayer) !== null && _classPrivateFieldGet5 !== void 0 ? _classPrivateFieldGet5 : undefined;
  }

  toString() {
    return (0, _classPrivateFieldGet6.default)(this, _repetition).quantum.toString() + (0, _classPrivateFieldGet6.default)(this, _repetition).suffix();
  } // // TODO: Serialize as a string?
  // toJSON(): MoveJSON {
  //   return {
  //     type: "move",
  //     family: this.family,
  //     innerLayer: this.innerLayer,
  //     outerLayer: this.outerLayer,
  //   };
  // }


}

exports.Move = Move;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","../../common":"3pL6h","../../iteration":"4e4oJ","../../limits":"4zMBm","../../parse":"7D5q4","../../warnOnce":"5uJF9","../Repetition":"3QMw7"}],"7D5q4":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.parseAlg = parseAlg;
exports.parseMove = parseMove;
exports.parseQuantumMove = parseQuantumMove;
exports.transferCharIndex = transferCharIndex;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _AlgBuilder = require("./AlgBuilder");

var _Commutator = require("./units/containers/Commutator");

var _Conjugate = require("./units/containers/Conjugate");

var _Grouping = require("./units/containers/Grouping");

var _LineComment = require("./units/leaves/LineComment");

var _Move = require("./units/leaves/Move");

var _Newline = require("./units/leaves/Newline");

var _Pause = require("./units/leaves/Pause");

function parseIntWithEmptyFallback(n, emptyFallback) {
  return n ? parseInt(n) : emptyFallback;
}

const repetitionRegex = /^(\d+)?('?)/;
const moveStartRegex = /^[_\dA-Za-z]/;
const quantumMoveRegex = /^((([1-9]\d*)-)?([1-9]\d*))?([_A-Za-z]+)?/;
const commentTextRegex = /[^\n]*/;

function parseAlg(s) {
  return new AlgParser().parseAlg(s);
}

function parseMove(s) {
  return new AlgParser().parseMove(s);
}

function parseQuantumMove(s) {
  return new AlgParser().parseQuantumMove(s);
}

function addCharIndex(t, charIndex) {
  const parsedT = t;
  parsedT.charIndex = charIndex;
  return parsedT;
}

function transferCharIndex(from, to) {
  if ("charIndex" in from) {
    to.charIndex = from.charIndex;
  }

  return to;
} // TODO: support recording string locations for moves.


var _input = new WeakMap();

var _idx = new WeakMap();

class AlgParser {
  constructor() {
    _input.set(this, {
      writable: true,
      value: ""
    });

    _idx.set(this, {
      writable: true,
      value: 0
    });
  }

  parseAlg(input) {
    (0, _classPrivateFieldSet2.default)(this, _input, input);
    (0, _classPrivateFieldSet2.default)(this, _idx, 0);
    const alg = this.parseAlgWithStopping([]);
    this.mustBeAtEndOfInput();
    return alg;
  }

  parseMove(input) {
    (0, _classPrivateFieldSet2.default)(this, _input, input);
    (0, _classPrivateFieldSet2.default)(this, _idx, 0);
    const move = this.parseMoveImpl();
    this.mustBeAtEndOfInput();
    return move;
  }

  parseQuantumMove(input) {
    (0, _classPrivateFieldSet2.default)(this, _input, input);
    (0, _classPrivateFieldSet2.default)(this, _idx, 0);
    const quantumMove = this.parseQuantumMoveImpl();
    this.mustBeAtEndOfInput();
    return quantumMove;
  }

  mustBeAtEndOfInput() {
    if ((0, _classPrivateFieldGet2.default)(this, _idx) !== (0, _classPrivateFieldGet2.default)(this, _input).length) {
      throw new Error("parsing unexpectedly ended early");
    }
  }

  parseAlgWithStopping(stopBefore) {
    const algStartIdx = (0, _classPrivateFieldGet2.default)(this, _idx);
    const algBuilder = new _AlgBuilder.AlgBuilder(); // We're "crowded" if there was not a space or newline since the last unit.

    let crowded = false;

    const mustNotBeCrowded = () => {
      if (crowded) {
        throw new Error(`Unexpected unit at idx ${(0, _classPrivateFieldGet2.default)(this, _idx)}. Are you missing a space?`); // TODO better error message
      }
    };

    mainLoop: while ((0, _classPrivateFieldGet2.default)(this, _idx) < (0, _classPrivateFieldGet2.default)(this, _input).length) {
      const savedCharIndex = (0, _classPrivateFieldGet2.default)(this, _idx);

      if (stopBefore.includes((0, _classPrivateFieldGet2.default)(this, _input)[(0, _classPrivateFieldGet2.default)(this, _idx)])) {
        return addCharIndex(algBuilder.toAlg(), algStartIdx);
      }

      if (this.tryConsumeNext(" ")) {
        crowded = false;
        continue mainLoop;
      } else if (moveStartRegex.test((0, _classPrivateFieldGet2.default)(this, _input)[(0, _classPrivateFieldGet2.default)(this, _idx)])) {
        mustNotBeCrowded();
        const move = this.parseMoveImpl();
        algBuilder.push(move);
        crowded = true;
        continue mainLoop;
      } else if (this.tryConsumeNext("(")) {
        mustNotBeCrowded();
        const alg = this.parseAlgWithStopping([")"]);
        this.mustConsumeNext(")");
        const repetitionInfo = this.parseRepetition();
        algBuilder.push(addCharIndex(new _Grouping.Grouping(alg, repetitionInfo), savedCharIndex));
        crowded = true;
        continue mainLoop;
      } else if (this.tryConsumeNext("[")) {
        mustNotBeCrowded();
        const A = this.parseAlgWithStopping([",", ":"]);
        const separator = this.popNext();
        const B = this.parseAlgWithStopping(["]"]);
        this.mustConsumeNext("]");
        const repetitionInfo = this.parseRepetition();

        switch (separator) {
          case ":":
            algBuilder.push(addCharIndex(new _Conjugate.Conjugate(A, B, repetitionInfo), savedCharIndex));
            crowded = true;
            continue mainLoop;

          case ",":
            algBuilder.push(addCharIndex(new _Commutator.Commutator(A, B, repetitionInfo), savedCharIndex));
            crowded = true;
            continue mainLoop;

          default:
            throw "unexpected parsing error";
        }
      } else if (this.tryConsumeNext("\n")) {
        algBuilder.push(addCharIndex(new _Newline.Newline(), savedCharIndex));
        crowded = false;
        continue mainLoop;
      } else if (this.tryConsumeNext("/")) {
        this.mustConsumeNext("/");
        const [text] = this.parseRegex(commentTextRegex);
        algBuilder.push(addCharIndex(new _LineComment.LineComment(text), savedCharIndex));
        crowded = false;
        continue mainLoop;
      } else if (this.tryConsumeNext(".")) {
        mustNotBeCrowded();
        algBuilder.push(addCharIndex(new _Pause.Pause(), savedCharIndex));

        while (this.tryConsumeNext(".")) {
          algBuilder.push(addCharIndex(new _Pause.Pause(), (0, _classPrivateFieldGet2.default)(this, _idx) - 1)); // TODO: Can we precompute index similarly to other units?
        }

        crowded = true;
        continue mainLoop;
      } else {
        throw new Error(`Unexpected character: ${this.popNext()}`);
      }
    }

    if ((0, _classPrivateFieldGet2.default)(this, _idx) !== (0, _classPrivateFieldGet2.default)(this, _input).length) {
      throw new Error("did not finish parsing?");
    }

    if (stopBefore.length > 0) {
      throw new Error("expected stopping");
    }

    return addCharIndex(algBuilder.toAlg(), algStartIdx);
  }

  parseQuantumMoveImpl() {
    const [,,, outerLayerStr, innerLayerStr, family] = this.parseRegex(quantumMoveRegex);
    return new _Move.QuantumMove(family, parseIntWithEmptyFallback(innerLayerStr, undefined), parseIntWithEmptyFallback(outerLayerStr, undefined));
  }

  parseMoveImpl() {
    const savedCharIndex = (0, _classPrivateFieldGet2.default)(this, _idx);
    const quantumMove = this.parseQuantumMoveImpl();
    const repetitionInfo = this.parseRepetition();
    const move = addCharIndex(new _Move.Move(quantumMove, repetitionInfo), savedCharIndex);
    return move;
  }

  parseRepetition() {
    const [, absAmountStr, primeStr] = this.parseRegex(repetitionRegex);
    return [parseIntWithEmptyFallback(absAmountStr, null), primeStr === "'"];
  }

  parseRegex(regex) {
    const arr = regex.exec(this.remaining());

    if (arr === null) {
      throw new Error("internal parsing error"); // TODO
    }

    (0, _classPrivateFieldSet2.default)(this, _idx, (0, _classPrivateFieldGet2.default)(this, _idx) + arr[0].length);
    return arr;
  }

  remaining() {
    return (0, _classPrivateFieldGet2.default)(this, _input).slice((0, _classPrivateFieldGet2.default)(this, _idx));
  }

  popNext() {
    var _this$idx;

    const next = (0, _classPrivateFieldGet2.default)(this, _input)[(0, _classPrivateFieldGet2.default)(this, _idx)];
    (0, _classPrivateFieldSet2.default)(this, _idx, (_this$idx = +(0, _classPrivateFieldGet2.default)(this, _idx)) + 1), _this$idx;
    return next;
  }

  tryConsumeNext(expected) {
    if ((0, _classPrivateFieldGet2.default)(this, _input)[(0, _classPrivateFieldGet2.default)(this, _idx)] === expected) {
      var _this$idx2;

      (0, _classPrivateFieldSet2.default)(this, _idx, (_this$idx2 = +(0, _classPrivateFieldGet2.default)(this, _idx)) + 1), _this$idx2;
      return true;
    }

    return false;
  }

  mustConsumeNext(expected) {
    const next = this.popNext();

    if (next !== expected) {
      throw new Error(`expected \`${expected}\` while parsing, encountered ${next}`); // TODO: be more helpful
    }

    return next;
  }

}
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","./AlgBuilder":"1ipjY","./units/containers/Commutator":"5TYpy","./units/containers/Conjugate":"2OKRE","./units/containers/Grouping":"6WcJj","./units/leaves/LineComment":"18TvJ","./units/leaves/Move":"6RDYH","./units/leaves/Newline":"2yjDB","./units/leaves/Pause":"6BUL0"}],"1ipjY":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.AlgBuilder = void 0;

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _Alg = require("./Alg");

var _units = new WeakMap();

class AlgBuilder {
  constructor() {
    _units.set(this, {
      writable: true,
      value: []
    });
  }

  push(u) {
    (0, _classPrivateFieldGet2.default)(this, _units).push(u);
  } // TODO: can we guarantee this to be fast in the permanent API?


  experimentalNumUnits() {
    return (0, _classPrivateFieldGet2.default)(this, _units).length;
  } // can be called multiple times, even if you push units inbetween.


  toAlg() {
    return new _Alg.Alg((0, _classPrivateFieldGet2.default)(this, _units));
  }

  reset() {
    (0, _classPrivateFieldSet2.default)(this, _units, []);
  }

}

exports.AlgBuilder = AlgBuilder;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","./Alg":"1F6Jc"}],"2yjDB":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Newline = void 0;

var _common = require("../../common");

var _iteration = require("../../iteration");

class Newline extends _common.AlgCommon {
  toString() {
    return `\n`;
  }

  isIdentical(other) {
    return other.is(Newline);
  }

  invert() {
    return this;
  }

  *experimentalExpand(_iterDir = _iteration.IterationDirection.Forwards, _depth = Infinity) {
    yield this;
  }

}

exports.Newline = Newline;
},{"../../common":"3pL6h","../../iteration":"4e4oJ"}],"6BUL0":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Pause = void 0;

var _common = require("../../common");

var _iteration = require("../../iteration");

class Pause extends _common.AlgCommon {
  toString() {
    return `.`;
  }

  isIdentical(other) {
    return other.is(Pause);
  }

  invert() {
    return this;
  }

  *experimentalExpand(_iterDir = _iteration.IterationDirection.Forwards, _depth = Infinity) {
    yield this;
  }

}

exports.Pause = Pause;
},{"../../common":"3pL6h","../../iteration":"4e4oJ"}],"5uJF9":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.warnOnce = warnOnce;
const warned = new Set();

function warnOnce(s) {
  if (!warned.has(s)) {
    console.warn(s);
    warned.add(s);
  }
}
},{}],"5TxQ3":[function(require,module,exports) {
"use strict";
},{}],"2bCs0":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.simplify = exports.TraversalUp = exports.TraversalDownUp = void 0;

var _Grouping = require("./units/containers/Grouping");

var _Commutator = require("./units/containers/Commutator");

var _Move = require("./units/leaves/Move");

var _Newline = require("./units/leaves/Newline");

var _Pause = require("./units/leaves/Pause");

var _Conjugate = require("./units/containers/Conjugate");

var _LineComment = require("./units/leaves/LineComment");

function dispatch(t, unit, dataDown) {
  // TODO: Can we turn this back into a `switch` or something more efficiently?
  if (unit.is(_Grouping.Grouping)) {
    return t.traverseGrouping(unit, dataDown);
  }

  if (unit.is(_Move.Move)) {
    return t.traverseMove(unit, dataDown);
  }

  if (unit.is(_Commutator.Commutator)) {
    return t.traverseCommutator(unit, dataDown);
  }

  if (unit.is(_Conjugate.Conjugate)) {
    return t.traverseConjugate(unit, dataDown);
  }

  if (unit.is(_Pause.Pause)) {
    return t.traversePause(unit, dataDown);
  }

  if (unit.is(_Newline.Newline)) {
    return t.traverseNewline(unit, dataDown);
  }

  if (unit.is(_LineComment.LineComment)) {
    return t.traverseLineComment(unit, dataDown);
  }

  throw new Error(`unknown unit`);
}

function assertIsUnit(t) {
  if (t.is(_Grouping.Grouping) || t.is(_Move.Move) || t.is(_Commutator.Commutator) || t.is(_Conjugate.Conjugate) || t.is(_Pause.Pause) || t.is(_Newline.Newline) || t.is(_LineComment.LineComment)) {
    return t;
  }

  throw "internal error: expected unit"; // TODO: Make more helpful, add tests
}

class TraversalDownUp {
  // Immediate subclasses should overwrite this.
  traverseUnit(unit, dataDown) {
    return dispatch(this, unit, dataDown);
  }

  traverseIntoUnit(unit, dataDown) {
    return assertIsUnit(this.traverseUnit(unit, dataDown));
  }

}

exports.TraversalDownUp = TraversalDownUp;

class TraversalUp extends TraversalDownUp {
  traverseUnit(unit) {
    return dispatch(this, unit, undefined);
  }

  traverseIntoUnit(unit) {
    return assertIsUnit(this.traverseUnit(unit));
  }

}

exports.TraversalUp = TraversalUp;

// TODO: Test that inverses are bijections.
class Simplify extends TraversalDownUp {
  // TODO: Handle
  *traverseAlg(alg, options) {
    var _options$collapseMove;

    if (options.depth === 0) {
      yield* alg.units();
      return;
    }

    const newUnits = [];
    let lastUnit = null;
    const collapseMoves = (_options$collapseMove = options === null || options === void 0 ? void 0 : options.collapseMoves) !== null && _options$collapseMove !== void 0 ? _options$collapseMove : true;

    function appendCollapsed(newUnit) {
      var _lastUnit;

      if (collapseMoves && ((_lastUnit = lastUnit) === null || _lastUnit === void 0 ? void 0 : _lastUnit.is(_Move.Move)) && newUnit.is(_Move.Move)) {
        const lastMove = lastUnit;
        const newMove = newUnit;

        if (lastMove.quantum.isIdentical(newMove.quantum)) {
          newUnits.pop();
          let newAmount = lastMove.effectiveAmount + newMove.effectiveAmount;

          if (options === null || options === void 0 ? void 0 : options.quantumMoveOrder) {
            const order = options.quantumMoveOrder(lastMove.quantum);
            newAmount = (newAmount % order + order + 1) % order - 1; // TODO
          }

          if (newAmount !== 0) {
            const coalescedMove = new _Move.Move(lastMove.quantum, newAmount);
            newUnits.push(coalescedMove);
            lastUnit = coalescedMove;
          } else {
            lastUnit = newUnits.slice(-1)[0];
          }
        } else {
          // TODO: handle quantum move order
          newUnits.push(newUnit);
          lastUnit = newUnit;
        }
      } else {
        // TODO: handle quantum move order
        newUnits.push(newUnit);
        lastUnit = newUnit;
      }
    }

    const newOptions = {
      depth: options.depth ? options.depth - 1 : null
    }; // TODO: avoid allocations?

    for (const unit of alg.units()) {
      for (const ancestorUnit of this.traverseUnit(unit, newOptions)) {
        appendCollapsed(ancestorUnit);
      }
    }

    for (const unit of newUnits) {
      yield unit;
    }
  }

  *traverseGrouping(grouping, options) {
    if (options.depth === 0) {
      yield grouping;
      return;
    }

    const newOptions = {
      depth: options.depth ? options.depth - 1 : null
    }; // TODO: avoid allocations?

    yield new _Grouping.Grouping(this.traverseAlg(grouping.experimentalAlg, newOptions));
  }

  *traverseMove(move, _options) {
    yield move;
  }

  *traverseCommutator(commutator, options) {
    if (options.depth === 0) {
      yield commutator;
      return;
    }

    const newOptions = {
      depth: options.depth ? options.depth - 1 : null
    }; // TODO: avoid allocations?

    yield new _Commutator.Commutator(this.traverseAlg(commutator.A, newOptions), this.traverseAlg(commutator.B, newOptions));
  }

  *traverseConjugate(conjugate, options) {
    if (options.depth === 0) {
      yield conjugate;
      return;
    }

    const newOptions = {
      depth: options.depth ? options.depth - 1 : null
    }; // TODO: avoid allocations?

    yield new _Conjugate.Conjugate(this.traverseAlg(conjugate.A, newOptions), this.traverseAlg(conjugate.B, newOptions));
  }

  *traversePause(pause, _options) {
    yield pause;
  }

  *traverseNewline(newline, _options) {
    yield newline;
  }

  *traverseLineComment(comment, _options) {
    yield comment;
  }

}

const simplifyInstance = new Simplify();
const simplify = simplifyInstance.traverseAlg.bind(simplifyInstance);
exports.simplify = simplify;
},{"./units/containers/Grouping":"6WcJj","./units/containers/Commutator":"5TYpy","./units/leaves/Move":"6RDYH","./units/leaves/Newline":"2yjDB","./units/leaves/Pause":"6BUL0","./units/containers/Conjugate":"2OKRE","./units/leaves/LineComment":"18TvJ"}],"1UkHF":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Example = void 0;

var _Alg = require("./Alg");

var _Commutator = require("./units/containers/Commutator");

var _Conjugate = require("./units/containers/Conjugate");

var _Move = require("./units/leaves/Move");

var _Pause = require("./units/leaves/Pause");

// tslint:disable-next-line no-namespace // TODO: nested module
// eslint-disable-next-line @typescript-eslint/no-namespace
const Example = {
  Sune: new _Alg.Alg([new _Move.Move("R", 1), new _Move.Move("U", 1), new _Move.Move("R", -1), new _Move.Move("U", 1), new _Move.Move("R", 1), new _Move.Move("U", -2), new _Move.Move("R", -1)]),
  AntiSune: new _Alg.Alg([new _Move.Move("R", 1), new _Move.Move("U", 2), new _Move.Move("R", -1), new _Move.Move("U", -1), new _Move.Move("R", 1), new _Move.Move("U", -1), new _Move.Move("R", -1)]),
  SuneCommutator: new _Alg.Alg([new _Commutator.Commutator(new _Alg.Alg([new _Move.Move("R", 1), new _Move.Move("U", 1), new _Move.Move("R", -2)]), new _Alg.Alg([new _Conjugate.Conjugate(new _Alg.Alg([new _Move.Move("R", 1)]), new _Alg.Alg([new _Move.Move("U", 1)]), 1)]), 1)]),
  Niklas: new _Alg.Alg([new _Move.Move("R", 1), new _Move.Move("U", -1), new _Move.Move("L", -1), new _Move.Move("U", 1), new _Move.Move("R", -1), new _Move.Move("U", -1), new _Move.Move("L", 1), new _Move.Move("U", 1)]),
  EPerm: new _Alg.Alg([new _Move.Move("x", -1), new _Commutator.Commutator(new _Alg.Alg([new _Conjugate.Conjugate(new _Alg.Alg([new _Move.Move("R", 1)]), new _Alg.Alg([new _Move.Move("U", -1)]))]), new _Alg.Alg([new _Move.Move("D", 1)]), 1), new _Commutator.Commutator(new _Alg.Alg([new _Conjugate.Conjugate(new _Alg.Alg([new _Move.Move("R", 1)]), new _Alg.Alg([new _Move.Move("U", 1)]))]), new _Alg.Alg([new _Move.Move("D", 1)]), 1), new _Move.Move("x", 1)]),
  FURURFCompact: new _Alg.Alg([new _Conjugate.Conjugate(new _Alg.Alg([new _Move.Move("F", 1)]), new _Alg.Alg([new _Commutator.Commutator(new _Alg.Alg([new _Move.Move("U", 1)]), new _Alg.Alg([new _Move.Move("R", 1)]), 1)]), 1)]),
  APermCompact: new _Alg.Alg([new _Conjugate.Conjugate(new _Alg.Alg([new _Move.Move("R", 2)]), new _Alg.Alg([new _Commutator.Commutator(new _Alg.Alg([new _Move.Move("F", 2)]), new _Alg.Alg([new _Move.Move("R", -1), new _Move.Move("B", -1), new _Move.Move("R", 1)]), 1)]), 1)]),
  FURURFMoves: new _Alg.Alg([new _Move.Move("F", 1), new _Move.Move("U", 1), new _Move.Move("R", 1), new _Move.Move("U", -1), new _Move.Move("R", -1), new _Move.Move("F", -1)]),
  TPerm: new _Alg.Alg([new _Move.Move("R", 1), new _Move.Move("U", 1), new _Move.Move("R", -1), new _Move.Move("U", -1), new _Move.Move("R", -1), new _Move.Move("F", 1), new _Move.Move("R", 2), new _Move.Move("U", -1), new _Move.Move("R", -1), new _Move.Move("U", -1), new _Move.Move("R", 1), new _Move.Move("U", 1), new _Move.Move("R", -1), new _Move.Move("F", -1)]),
  HeadlightSwaps: new _Alg.Alg([new _Conjugate.Conjugate(new _Alg.Alg([new _Move.Move("F", 1)]), new _Alg.Alg([new _Commutator.Commutator(new _Alg.Alg([new _Move.Move("R", 1)]), new _Alg.Alg([new _Move.Move("U", 1)]), 3)]), 1)]),
  TriplePause: new _Alg.Alg([new _Pause.Pause(), new _Pause.Pause(), new _Pause.Pause()]) // AllAlgParts: [
  //   new Alg([new Move("R", 1), new Move("U", -1)]),
  //   new Grouping(new Alg([new Move("F", 1)]), 2),
  //   // new Rotation("y", -1),
  //   new Move("R", 2),
  //   new Commutator(new Alg([new Move("R", 2)]), new Alg([new Move("U", 2)]), 2),
  //   new Conjugate(new Alg([new Move("L", 2)]), new Alg([new Move("D", -1)]), 2),
  //   new Pause(),
  //   new Newline(),
  //   new LineComment("line comment"),
  // ],

};
exports.Example = Example;
},{"./Alg":"1F6Jc","./units/containers/Commutator":"5TYpy","./units/containers/Conjugate":"2OKRE","./units/leaves/Move":"6RDYH","./units/leaves/Pause":"6BUL0"}],"5om9f":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.keyToMove = keyToMove;

var _Move = require("./units/leaves/Move");

const cubeKeyMapping = {
  73: new _Move.Move("R"),
  75: new _Move.Move("R'"),
  87: new _Move.Move("B"),
  79: new _Move.Move("B'"),
  83: new _Move.Move("D"),
  76: new _Move.Move("D'"),
  68: new _Move.Move("L"),
  69: new _Move.Move("L'"),
  74: new _Move.Move("U"),
  70: new _Move.Move("U'"),
  72: new _Move.Move("F"),
  71: new _Move.Move("F'"),
  78: new _Move.Move("x'"),
  67: new _Move.Move("l"),
  82: new _Move.Move("l'"),
  85: new _Move.Move("r"),
  77: new _Move.Move("r'"),
  88: new _Move.Move("d"),
  188: new _Move.Move("d'"),
  84: new _Move.Move("x"),
  89: new _Move.Move("x"),
  66: new _Move.Move("x'"),
  186: new _Move.Move("y"),
  59: new _Move.Move("y"),
  65: new _Move.Move("y'"),
  // 186 is WebKit, 59 is Mozilla; see http://unixpapa.com/js/key.html
  80: new _Move.Move("z"),
  81: new _Move.Move("z'"),
  90: new _Move.Move("M'"),
  190: new _Move.Move("M'")
}; // TODO: options about whether to ignore modifier keys (e.g. alt, ctrl).
// TODO: Support different mappings.
// TODO: Return BaseMove instead?

function keyToMove(e) {
  if (e.altKey || e.ctrlKey) {
    return null;
  }

  return cubeKeyMapping[e.keyCode] || null;
}
},{"./units/leaves/Move":"6RDYH"}],"3buzo":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.algCubingNetLink = algCubingNetLink;

// This is not the most sophisticated scheme, but it has been used in production
// at alg.cubing.net for years.
function serializeURLParam(a) {
  let escaped = a.toString();
  escaped = escaped.replace(/_/g, "&#95;").replace(/ /g, "_");
  escaped = escaped.replace(/\+/g, "&#2b;");
  escaped = escaped.replace(/-/g, "&#45;").replace(/'/g, "-");
  return escaped;
}

// TODO: runtime validation?
function algCubingNetLink(options) {
  const url = new URL("https://alg.cubing.net");

  if (!options.alg) {
    throw new Error("An alg parameter is required.");
  }

  url.searchParams.set("alg", serializeURLParam(options.alg));

  if (options.setup) {
    url.searchParams.set("setup", serializeURLParam(options.setup));
  }

  if (options.title) {
    url.searchParams.set("title", options.title);
  }

  if (options.puzzle) {
    if (!["1x1x1", "2x2x2", "3x3x3", "4x4x4", "5x5x5", "6x6x6", "7x7x7", "8x8x8", "9x9x9", "10x10x10", "11x11x11", "12x12x12", "13x13x13", "14x14x14", "16x16x16", "17x17x17"].includes(options.puzzle)) {
      throw new Error(`Invalid puzzle parameter: ${options.puzzle}`);
    }

    url.searchParams.set("puzzle", options.puzzle);
  }

  if (options.stage) {
    if (!["full", "cross", "F2L", "LL", "OLL", "PLL", "CLS", "ELS", "L6E", "CMLL", "WV", "ZBLL", "void"].includes(options.stage)) {
      throw new Error(`Invalid stage parameter: ${options.stage}`);
    }

    url.searchParams.set("stage", options.stage);
  }

  if (options.view) {
    if (!["editor", "playback", "fullscreen"].includes(options.view)) {
      throw new Error(`Invalid view parameter: ${options.view}`);
    }

    url.searchParams.set("view", options.view);
  }

  if (options.type) {
    if (!["moves", "reconstruction", "alg", "reconstruction-end-with-setup"].includes(options.type)) {
      throw new Error(`Invalid type parameter: ${options.type}`);
    }

    url.searchParams.set("type", options.type);
  }

  return url.toString();
}
},{}],"4iRrR":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.experimentalAppendMove = experimentalAppendMove;

var _Alg = require("./Alg");

function experimentalAppendMove(alg, newMove, options) {
  const oldUnits = Array.from(alg.units());
  const oldLastMove = oldUnits[oldUnits.length - 1];

  if ((options === null || options === void 0 ? void 0 : options.coalesce) && oldLastMove && oldLastMove.quantum && oldLastMove.quantum.isIdentical(newMove.quantum)) {
    const newUnits = oldUnits.slice(0, oldUnits.length - 1);
    let newAmount = oldLastMove.effectiveAmount + newMove.effectiveAmount;
    const mod = options === null || options === void 0 ? void 0 : options.mod;

    if (mod) {
      newAmount = (newAmount % mod + mod) % mod;

      if (newAmount * 2 > mod) {
        newAmount -= mod;
      }
    }

    if (newAmount !== 0) {
      newUnits.push(oldLastMove.modified({
        repetition: newAmount
      }));
    }

    return new _Alg.Alg(newUnits);
  } else {
    return new _Alg.Alg([...oldUnits, newMove]);
  }
}
},{"./Alg":"1F6Jc"}]},{},[], null, "parcelRequire0395")

//# sourceMappingURL=puzzle-geometry.2c6f55a3.js.map
