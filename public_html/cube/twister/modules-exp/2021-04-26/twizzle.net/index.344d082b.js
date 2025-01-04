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
})({"2X8fG":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
Object.defineProperty(exports, "Twisty3DPuzzle", {
  enumerable: true,
  get: function () {
    return _Twisty3DPuzzle.Twisty3DPuzzle;
  }
});
Object.defineProperty(exports, "experimentalSetShareAllNewRenderers", {
  enumerable: true,
  get: function () {
    return _Twisty3DCanvas.experimentalSetShareAllNewRenderers;
  }
});
Object.defineProperty(exports, "experimentalShowRenderStats", {
  enumerable: true,
  get: function () {
    return _Twisty3DCanvas.experimentalShowRenderStats;
  }
});
Object.defineProperty(exports, "Twisty3DCanvas", {
  enumerable: true,
  get: function () {
    return _Twisty3DCanvas.Twisty3DCanvas;
  }
});
Object.defineProperty(exports, "TwistyPlayer", {
  enumerable: true,
  get: function () {
    return _TwistyPlayer.TwistyPlayer;
  }
});
Object.defineProperty(exports, "TwistyPlayerInitialConfig", {
  enumerable: true,
  get: function () {
    return _TwistyPlayerConfig.TwistyPlayerInitialConfig;
  }
});
Object.defineProperty(exports, "ExperimentalStickering", {
  enumerable: true,
  get: function () {
    return _TwistyPlayerConfig.ExperimentalStickering;
  }
});
Object.defineProperty(exports, "TimelineActionEvent", {
  enumerable: true,
  get: function () {
    return _Timeline.TimelineActionEvent;
  }
});
Object.defineProperty(exports, "TimestampLocationType", {
  enumerable: true,
  get: function () {
    return _Timeline.TimestampLocationType;
  }
});
Object.defineProperty(exports, "ExperimentalTwistyAlgViewer", {
  enumerable: true,
  get: function () {
    return _TwistyAlgViewer.ExperimentalTwistyAlgViewer;
  }
});
Object.defineProperty(exports, "Cube3D", {
  enumerable: true,
  get: function () {
    return _Cube3D.Cube3D;
  }
});
Object.defineProperty(exports, "PG3D", {
  enumerable: true,
  get: function () {
    return _PG3D.PG3D;
  }
});
Object.defineProperty(exports, "AlgIndexer", {
  enumerable: true,
  get: function () {
    return _AlgIndexer.AlgIndexer;
  }
});
Object.defineProperty(exports, "SimpleAlgIndexer", {
  enumerable: true,
  get: function () {
    return _SimpleAlgIndexer.SimpleAlgIndexer;
  }
});
Object.defineProperty(exports, "TreeAlgIndexer", {
  enumerable: true,
  get: function () {
    return _TreeAlgIndexer.TreeAlgIndexer;
  }
});
Object.defineProperty(exports, "KSolvePuzzle", {
  enumerable: true,
  get: function () {
    return _KPuzzleWrapper.KPuzzleWrapper;
  }
});
Object.defineProperty(exports, "BackViewLayout", {
  enumerable: true,
  get: function () {
    return _TwistyViewerWrapper.BackViewLayout;
  }
});

var _Twisty3DPuzzle = require("./3D/puzzles/Twisty3DPuzzle");

var _Twisty3DCanvas = require("./dom/viewers/Twisty3DCanvas");

var _TwistyPlayer = require("./dom/TwistyPlayer");

var _TwistyPlayerConfig = require("./dom/TwistyPlayerConfig");

var _Timeline = require("./animation/Timeline");

var _TwistyAlgViewer = require("./dom/TwistyAlgViewer");

var _Cube3D = require("./3D/puzzles/Cube3D");

var _PG3D = require("./3D/puzzles/PG3D");

var _AlgIndexer = require("./animation/indexer/AlgIndexer");

var _SimpleAlgIndexer = require("./animation/indexer/SimpleAlgIndexer");

var _TreeAlgIndexer = require("./animation/indexer/tree/TreeAlgIndexer");

var _KPuzzleWrapper = require("./3D/puzzles/KPuzzleWrapper");

var _TwistyViewerWrapper = require("./dom/viewers/TwistyViewerWrapper");
},{"./3D/puzzles/Twisty3DPuzzle":"5HmWT","./dom/viewers/Twisty3DCanvas":"1Qn8g","./dom/TwistyPlayer":"4hrtk","./dom/TwistyPlayerConfig":"4DCsT","./animation/Timeline":"5Cj4O","./dom/TwistyAlgViewer":"D0mx6","./3D/puzzles/Cube3D":"784Fj","./3D/puzzles/PG3D":"5NdrU","./animation/indexer/AlgIndexer":"1S1q5","./animation/indexer/SimpleAlgIndexer":"105Ga","./animation/indexer/tree/TreeAlgIndexer":"3v6C1","./3D/puzzles/KPuzzleWrapper":"pSYCK","./dom/viewers/TwistyViewerWrapper":"2w7nP"}],"5HmWT":[function(require,module,exports) {
"use strict";
},{}],"D0mx6":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.ExperimentalTwistyAlgViewer = void 0;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _alg = require("../../alg");

var _puzzles = require("../../puzzles");

var _twisty = require("../../twisty");

var _KPuzzleWrapper = require("../3D/puzzles/KPuzzleWrapper");

var _TreeAlgIndexer = require("../animation/indexer/tree/TreeAlgIndexer");

var _nodeCustomElementShims = require("./element/node-custom-element-shims");

const DEFAULT_OFFSET_MS = 250; // TODO: make this a fraction?

class DataDown {
  constructor() {
    (0, _defineProperty2.default)(this, "earliestMoveIndex", void 0);
    (0, _defineProperty2.default)(this, "twistyAlgViewer", void 0);
    (0, _defineProperty2.default)(this, "direction", void 0);
  }

}

class DataUp {
  constructor() {
    (0, _defineProperty2.default)(this, "moveCount", void 0);
    (0, _defineProperty2.default)(this, "element", void 0);
  }

}

class TwistyAlgLeafElem extends _nodeCustomElementShims.HTMLElementShim {
  constructor(className, text, dataDown, algOrUnit, offsetIntoMove) {
    super();
    this.algOrUnit = algOrUnit;
    this.textContent = text;
    this.classList.add(className);
    this.addEventListener("click", () => {
      dataDown.twistyAlgViewer.jumpToIndex(dataDown.earliestMoveIndex, offsetIntoMove);
    });
  }

  pathToIndex(_index) {
    return [];
  }

}

_nodeCustomElementShims.customElementsShim.define("twisty-alg-leaf-elem", TwistyAlgLeafElem);

class TwistyAlgWrapperElem extends _nodeCustomElementShims.HTMLElementShim {
  constructor(className, algOrUnit) {
    super();
    this.algOrUnit = algOrUnit;
    (0, _defineProperty2.default)(this, "queue", []);
    this.classList.add(className);
  }

  addString(str) {
    this.queue.push(document.createTextNode(str));
  }

  addElem(dataUp) {
    this.queue.push(dataUp.element);
    return dataUp.moveCount;
  }

  flushQueue(direction = _alg.ExperimentalIterationDirection.Forwards) {
    for (const node of maybeReverseList(this.queue, direction)) {
      this.append(node);
    }

    this.queue = [];
  }

  pathToIndex(_index) {
    return [];
  }

}

_nodeCustomElementShims.customElementsShim.define("twisty-alg-wrapper-elem", TwistyAlgWrapperElem);

function oppositeDirection(direction) {
  return direction === _alg.ExperimentalIterationDirection.Forwards ? _alg.ExperimentalIterationDirection.Backwards : _alg.ExperimentalIterationDirection.Forwards;
}

function updateDirectionByAmount(currentDirection, amount) {
  return amount < 0 ? oppositeDirection(currentDirection) : currentDirection;
}

function maybeReverseList(l, direction) {
  if (direction === _alg.ExperimentalIterationDirection.Forwards) {
    return l;
  } // console.log("rev", Array.from(l).reverse());
  // return Array.from(l).reverse();


  const copy = Array.from(l);
  copy.reverse();
  return copy;
}

class AlgToDOMTree extends _alg.TraversalDownUp {
  traverseAlg(alg, dataDown) {
    let moveCount = 0;
    const element = new TwistyAlgWrapperElem("twisty-alg-alg", alg); // TODO: pick a better class name.

    let first = true;

    for (const unit of (0, _alg.experimentalDirect)(alg.units(), dataDown.direction)) {
      if (!first) {
        element.addString(" ");
      }

      first = false;
      moveCount += element.addElem(this.traverseUnit(unit, {
        earliestMoveIndex: dataDown.earliestMoveIndex + moveCount,
        twistyAlgViewer: dataDown.twistyAlgViewer,
        direction: dataDown.direction
      }));
    }

    element.flushQueue(dataDown.direction);
    return {
      moveCount: moveCount,
      element
    };
  }

  traverseGrouping(grouping, dataDown) {
    const direction = updateDirectionByAmount(dataDown.direction, grouping.experimentalEffectiveAmount);
    let moveCount = 0;
    const element = new TwistyAlgWrapperElem("twisty-alg-grouping", grouping);
    element.addString("(");
    moveCount += element.addElem(this.traverseAlg(grouping.experimentalAlg, {
      earliestMoveIndex: dataDown.earliestMoveIndex + moveCount,
      twistyAlgViewer: dataDown.twistyAlgViewer,
      direction
    }));
    element.addString(")" + grouping.experimentalRepetitionSuffix);
    element.flushQueue();
    return {
      moveCount: moveCount * Math.abs(grouping.experimentalEffectiveAmount),
      element
    };
  }

  traverseMove(move, dataDown) {
    const element = new TwistyAlgLeafElem("twisty-alg-move", move.toString(), dataDown, move, true);
    dataDown.twistyAlgViewer.highlighter.addMove(move.charIndex, element);
    return {
      moveCount: 1,
      element
    };
  }

  traverseCommutator(commutator, dataDown) {
    let moveCount = 0;
    const element = new TwistyAlgWrapperElem("twisty-alg-commutator", commutator);
    element.addString("[");
    element.flushQueue();
    const direction = updateDirectionByAmount(dataDown.direction, commutator.experimentalEffectiveAmount);
    const [first, second] = maybeReverseList([commutator.A, commutator.B], direction);
    moveCount += element.addElem(this.traverseAlg(first, {
      earliestMoveIndex: dataDown.earliestMoveIndex + moveCount,
      twistyAlgViewer: dataDown.twistyAlgViewer,
      direction
    }));
    element.addString(", ");
    moveCount += element.addElem(this.traverseAlg(second, {
      earliestMoveIndex: dataDown.earliestMoveIndex + moveCount,
      twistyAlgViewer: dataDown.twistyAlgViewer,
      direction
    }));
    element.flushQueue(direction);
    element.addString("]" + commutator.experimentalRepetitionSuffix);
    element.flushQueue();
    return {
      moveCount: moveCount * 2 * Math.abs(commutator.experimentalEffectiveAmount),
      element
    };
  }

  traverseConjugate(conjugate, dataDown) {
    let moveCount = 0;
    const element = new TwistyAlgWrapperElem("twisty-alg-conjugate", conjugate);
    element.addString("[");
    const direction = updateDirectionByAmount(dataDown.direction, conjugate.experimentalEffectiveAmount);
    const aLen = element.addElem(this.traverseAlg(conjugate.A, {
      earliestMoveIndex: dataDown.earliestMoveIndex + moveCount,
      twistyAlgViewer: dataDown.twistyAlgViewer,
      direction
    }));
    moveCount += aLen;
    element.addString(": ");
    moveCount += element.addElem(this.traverseAlg(conjugate.B, {
      earliestMoveIndex: dataDown.earliestMoveIndex + moveCount,
      twistyAlgViewer: dataDown.twistyAlgViewer,
      direction
    }));
    element.addString("]" + conjugate.experimentalRepetitionSuffix);
    element.flushQueue();
    return {
      moveCount: (moveCount + aLen) * Math.abs(conjugate.experimentalEffectiveAmount),
      element
    };
  }

  traversePause(pause, dataDown) {
    return {
      moveCount: 1,
      element: new TwistyAlgLeafElem("twisty-alg-pause", ".", dataDown, pause, true)
    };
  }

  traverseNewline(newline, _dataDown) {
    const element = new TwistyAlgWrapperElem("twisty-alg-newline", newline);
    element.append(document.createElement("br"));
    return {
      moveCount: 0,
      element
    };
  }

  traverseLineComment(lineComment, dataDown) {
    return {
      moveCount: 0,
      element: new TwistyAlgLeafElem("twisty-alg-line-comment", `//${lineComment.text}`, dataDown, lineComment, false)
    };
  }

}

const algToDOMTreeInstance = new AlgToDOMTree();
const algToDOMTree = algToDOMTreeInstance.traverseAlg.bind(algToDOMTreeInstance);

class MoveHighlighter {
  constructor() {
    (0, _defineProperty2.default)(this, "moveCharIndexMap", new Map());
    (0, _defineProperty2.default)(this, "currentElem", null);
  }

  addMove(charIndex, elem) {
    this.moveCharIndexMap.set(charIndex, elem);
  }

  set(move) {
    var _this$moveCharIndexMa, _this$currentElem;

    const newElem = move ? (_this$moveCharIndexMa = this.moveCharIndexMap.get(move.charIndex)) !== null && _this$moveCharIndexMa !== void 0 ? _this$moveCharIndexMa : null : null;

    if (this.currentElem === newElem) {
      return;
    }

    (_this$currentElem = this.currentElem) === null || _this$currentElem === void 0 ? void 0 : _this$currentElem.classList.remove("twisty-alg-current-move");
    newElem === null || newElem === void 0 ? void 0 : newElem.classList.add("twisty-alg-current-move");
    this.currentElem = newElem;
  }

}

var _domTree = new WeakMap();

class ExperimentalTwistyAlgViewer extends _nodeCustomElementShims.HTMLElementShim {
  constructor(options) {
    super();
    (0, _defineProperty2.default)(this, "highlighter", new MoveHighlighter());

    _domTree.set(this, {
      writable: true,
      value: void 0
    });

    (0, _defineProperty2.default)(this, "twistyPlayer", null);
    (0, _defineProperty2.default)(this, "lastClickTimestamp", null);

    if (options === null || options === void 0 ? void 0 : options.twistyPlayer) {
      this.setTwistyPlayer(options === null || options === void 0 ? void 0 : options.twistyPlayer);
    }
  }

  connectedCallback() {// nothing to do?
  }

  setAlg(alg) {
    (0, _classPrivateFieldSet2.default)(this, _domTree, algToDOMTree(alg, {
      earliestMoveIndex: 0,
      twistyAlgViewer: this,
      direction: _alg.ExperimentalIterationDirection.Forwards
    }).element);
    this.textContent = "";
    this.appendChild((0, _classPrivateFieldGet2.default)(this, _domTree));
  }

  setTwistyPlayer(twistyPlayer) {
    if (this.twistyPlayer) {
      console.warn("twisty-player reassignment is not supported");
      return;
    }

    this.twistyPlayer = twistyPlayer;
    const sourceAlg = this.twistyPlayer.alg; // TODO: Use proper architecture instead of a heuristic to ensure we have a parsed alg annotated with char indices.

    const parsedAlg = "charIndex" in sourceAlg ? sourceAlg : _alg.Alg.fromString(sourceAlg.toString());
    this.setAlg(parsedAlg);

    (async () => {
      const wrapper = new _KPuzzleWrapper.KPuzzleWrapper(await _puzzles.puzzles[twistyPlayer.puzzle].def());
      const indexer = new _TreeAlgIndexer.TreeAlgIndexer(wrapper, parsedAlg);
      twistyPlayer.timeline.addTimestampListener({
        onTimelineTimestampChange: timestamp => {
          // TODO: improve perf, e.g. only get notified when the move index changes.
          this.highlighter.set(indexer.getMove(indexer.timestampToIndex(timestamp)));
        },

        onTimeRangeChange(_timeRange) {}

      });
    })();

    twistyPlayer.timeline.addTimestampListener({
      onTimelineTimestampChange: timestamp => {
        var _this$twistyPlayer$cu, _this$twistyPlayer, _this$twistyPlayer$cu2;

        if (timestamp !== this.lastClickTimestamp) {
          this.lastClickTimestamp = null;
        }

        const index = (_this$twistyPlayer$cu = (_this$twistyPlayer = this.twistyPlayer) === null || _this$twistyPlayer === void 0 ? void 0 : (_this$twistyPlayer$cu2 = _this$twistyPlayer.cursor) === null || _this$twistyPlayer$cu2 === void 0 ? void 0 : _this$twistyPlayer$cu2.experimentalIndexFromTimestamp(timestamp)) !== null && _this$twistyPlayer$cu !== void 0 ? _this$twistyPlayer$cu : null;

        if (index !== null) {// console.log(index);
          // console.log(this.#domTree.pathToIndex(index));
        }
      },
      onTimeRangeChange: _timeRange => {// TODO
      }
    });
  }

  jumpToIndex(index, offsetIntoMove) {
    if (this.twistyPlayer && this.twistyPlayer.cursor) {
      var _this$twistyPlayer$cu3, _this$twistyPlayer2;

      const offset = offsetIntoMove ? DEFAULT_OFFSET_MS : 0;
      const timestamp = ((_this$twistyPlayer$cu3 = this.twistyPlayer.cursor.experimentalTimestampFromIndex(index)) !== null && _this$twistyPlayer$cu3 !== void 0 ? _this$twistyPlayer$cu3 : -offset) + offset;
      (_this$twistyPlayer2 = this.twistyPlayer) === null || _this$twistyPlayer2 === void 0 ? void 0 : _this$twistyPlayer2.timeline.setTimestamp(timestamp);

      if (this.lastClickTimestamp === timestamp) {
        this.twistyPlayer.timeline.play();
        this.lastClickTimestamp = null;
      } else {
        this.lastClickTimestamp = timestamp;
      }
    }
  }

  attributeChangedCallback(attributeName, _oldValue, newValue) {
    if (attributeName === "for") {
      const elem = document.getElementById(newValue);

      if (!elem) {
        console.warn("for= elem does not exist");
        return;
      }

      if (!(elem instanceof _twisty.TwistyPlayer)) {
        console.warn("for= elem is not a twisty-player");
        return;
      }

      this.setTwistyPlayer(elem);
    }
  }

  static get observedAttributes() {
    return ["for"];
  }

}

exports.ExperimentalTwistyAlgViewer = ExperimentalTwistyAlgViewer;

_nodeCustomElementShims.customElementsShim.define("experimental-twisty-alg-viewer", ExperimentalTwistyAlgViewer);
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","@babel/runtime/helpers/defineProperty":"55mTs","../../alg":"7Ff6b","../../puzzles":"KrRHt","../../twisty":"2X8fG","../3D/puzzles/KPuzzleWrapper":"pSYCK","../animation/indexer/tree/TreeAlgIndexer":"3v6C1","./element/node-custom-element-shims":"3CBls"}],"1S1q5":[function(require,module,exports) {
"use strict";
},{}]},{},[], null, "parcelRequire0395")

//# sourceMappingURL=index.344d082b.js.map
