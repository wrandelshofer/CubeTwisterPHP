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
})({"1Qn8g":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.experimentalShowRenderStats = experimentalShowRenderStats;
exports.experimentalSetShareAllNewRenderers = experimentalSetShareAllNewRenderers;
exports.Twisty3DCanvas = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _three = require("three");

var _RenderScheduler = require("../../animation/RenderScheduler");

var _ManagedCustomElement = require("../element/ManagedCustomElement");

var _canvas = require("./canvas");

var _Twisty3DCanvas = require("./Twisty3DCanvas.css");

var _TwistyOrbitControls = require("./TwistyOrbitControls");

var _nodeCustomElementShims = require("../element/node-custom-element-shims");

var _stats = _interopRequireDefault(require("../../../../vendor/node_modules/three/examples/jsm/libs/stats.module"));

let SHOW_STATS = false; // Show render stats for newly contructed renderers.

function experimentalShowRenderStats(show) {
  SHOW_STATS = show;
}

let resizeObserverWarningShown = false;
let shareAllNewRenderers = false; // WARNING: The current shared renderer implementation is not every efficient.
// Avoid using for players that are likely to have dimensions approaching 1 megapixel or higher.
// TODO: use a dedicated renderer while fullscreen?

function experimentalSetShareAllNewRenderers(share) {
  shareAllNewRenderers = share;
}

let sharedRenderer = null;

function newRenderer() {
  return new _three.WebGLRenderer({
    antialias: true,
    alpha: true // TODO

  });
}

function newSharedRenderer() {
  var _sharedRenderer;

  return (_sharedRenderer = sharedRenderer) !== null && _sharedRenderer !== void 0 ? _sharedRenderer : sharedRenderer = newRenderer();
} // <twisty-3d-canvas>


var _invisible = new WeakMap();

var _onRenderFinish = new WeakMap();

class Twisty3DCanvas extends _ManagedCustomElement.ManagedCustomElement {
  // TODO: share renderers across elements? (issue: renderers are not designed to be constantly resized?)
  // TODO: Are there any render duration performance concerns with removing this?
  constructor(scene, options = {}) {
    var _this$scene, _options$experimental;

    super();
    (0, _defineProperty2.default)(this, "scene", void 0);
    (0, _defineProperty2.default)(this, "canvas", void 0);
    (0, _defineProperty2.default)(this, "camera", void 0);
    (0, _defineProperty2.default)(this, "legacyExperimentalShift", 0);
    (0, _defineProperty2.default)(this, "orbitControls", void 0);
    (0, _defineProperty2.default)(this, "scheduler", new _RenderScheduler.RenderScheduler(this.render.bind(this)));
    (0, _defineProperty2.default)(this, "resizePending", false);
    (0, _defineProperty2.default)(this, "renderer", void 0);
    (0, _defineProperty2.default)(this, "rendererIsShared", void 0);
    (0, _defineProperty2.default)(this, "canvas2DContext", void 0);
    (0, _defineProperty2.default)(this, "stats", null);

    _invisible.set(this, {
      writable: true,
      value: false
    });

    _onRenderFinish.set(this, {
      writable: true,
      value: null
    });

    this.addCSS(_Twisty3DCanvas.twisty3DCanvasCSS);
    this.scene = scene;
    (_this$scene = this.scene) === null || _this$scene === void 0 ? void 0 : _this$scene.addRenderTarget(this); // TODO

    if (SHOW_STATS) {
      this.stats = (0, _stats.default)();
      this.stats.dom.style.position = "absolute";
      this.addElement(this.stats.dom);
    } // We rely on the resize logic to handle renderer dimensions.


    this.rendererIsShared = shareAllNewRenderers;
    this.renderer = this.rendererIsShared ? newSharedRenderer() : newRenderer();
    this.canvas = this.rendererIsShared ? document.createElement("canvas") : this.renderer.domElement;
    this.canvas2DContext = this.canvas.getContext("2d"); // TODO: avoid saving unneeded?

    this.addElement(this.canvas);
    this.camera = new _three.PerspectiveCamera(20, 1, // We rely on the resize logic to handle this.
    0.1, 20);
    this.camera.position.copy((_options$experimental = options.experimentalCameraPosition) !== null && _options$experimental !== void 0 ? _options$experimental : new _three.Vector3(2, 4, 4));

    if (options.negateCameraPosition) {
      this.camera.position.multiplyScalar(-1);
    }

    this.camera.lookAt(new _three.Vector3(0, 0, 0)); // TODO: Handle with `negateCameraPosition`

    this.orbitControls = new _TwistyOrbitControls.TwistyOrbitControls(this.camera, this.canvas, this.scheduleRender.bind(this)); // TODO: Remove this when enough Safari users have `ResizeObserver`.

    if (window.ResizeObserver) {
      const observer = new window.ResizeObserver(this.onResize.bind(this));
      observer.observe(this.contentWrapper);
    } else {
      this.scheduleRender();

      if (!resizeObserverWarningShown) {
        console.warn("You are using an older browser that does not support `ResizeObserver`. Displayed puzzles will not be rescaled.");
        resizeObserverWarningShown = true;
      }
    }
  }

  setMirror(partner) {
    this.orbitControls.setMirror(partner.orbitControls);
    partner.orbitControls.setMirror(this.orbitControls);
  }
  /** @deprecated */


  experimentalSetLatitudeLimits(limits) {
    this.orbitControls.experimentalLatitudeLimits = limits;
  }

  connectedCallback() {
    // Resize as soon as we're in the DOM, to avoid a flash of incorrectly sized content.
    this.resize();
    this.render();
  }

  scheduleRender() {
    this.scheduler.requestAnimFrame();
  } // If the current size/state is incorrect, it may be preferable to hide it
  // briefly, rather than flashing an incorrect version for one frame.


  makeInvisibleUntilRender() {
    this.contentWrapper.classList.add("invisible");
    (0, _classPrivateFieldSet2.default)(this, _invisible, true);
  }
  /** @deprecated */


  experimentalSetOnRenderFinish(f) {
    (0, _classPrivateFieldSet2.default)(this, _onRenderFinish, f);
  }

  render() {
    var _this$stats, _this$stats2;

    // Cancel any scheduled frame, since we're rendering right now.
    // We don't need to re-render until something schedules again.
    (_this$stats = this.stats) === null || _this$stats === void 0 ? void 0 : _this$stats.begin();
    this.scheduler.cancelAnimFrame();

    if (this.resizePending) {
      this.resize();
    }

    if (this.rendererIsShared) {
      this.renderer.setSize(this.canvas.width, this.canvas.height, false);
      this.canvas2DContext.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }

    if (this.scene) {
      this.renderer.render(this.scene, this.camera); // TODO
    }

    if (this.rendererIsShared) {
      this.canvas2DContext.drawImage(this.renderer.domElement, 0, 0);
    }

    if ((0, _classPrivateFieldGet2.default)(this, _invisible)) {
      this.contentWrapper.classList.remove("invisible");
    }

    (_this$stats2 = this.stats) === null || _this$stats2 === void 0 ? void 0 : _this$stats2.end();

    if ((0, _classPrivateFieldGet2.default)(this, _onRenderFinish)) {
      (0, _classPrivateFieldGet2.default)(this, _onRenderFinish).call(this);
    }
  }

  onResize() {
    this.resizePending = true;
    this.scheduleRender();
  }

  resize() {
    this.resizePending = false;
    const w = this.contentWrapper.clientWidth;
    const h = this.contentWrapper.clientHeight;
    let off = 0;

    if (this.legacyExperimentalShift > 0) {
      off = Math.max(0, Math.floor((w - h) * 0.5));
    } else if (this.legacyExperimentalShift < 0) {
      off = -Math.max(0, Math.floor((w - h) * 0.5));
    }

    let yoff = 0;
    let excess = 0;

    if (h > w) {
      excess = h - w;
      yoff = -Math.floor(0.5 * excess);
    }

    this.camera.aspect = w / h;
    this.camera.setViewOffset(w, h - excess, off, yoff, w, h);
    this.camera.updateProjectionMatrix(); // TODO

    if (this.rendererIsShared) {
      this.canvas.width = w * (0, _canvas.pixelRatio)();
      this.canvas.height = h * (0, _canvas.pixelRatio)();
      this.canvas.style.width = w.toString();
      this.canvas.style.height = w.toString();
    } else {
      this.renderer.setPixelRatio((0, _canvas.pixelRatio)());
      this.renderer.setSize(w, h, true);
    }

    this.scheduleRender();
  } // Square crop is useful for rending icons.


  renderToDataURL(options = {}) {
    // We don't preserve the drawing buffer, so we have to render again and then immediately read the canvas data.
    // https://stackoverflow.com/a/30647502
    this.render(); // TODO: can we assume that a central crop is similar enough to how a square canvas render would loook?

    if (!options.squareCrop || this.canvas.width === this.canvas.height) {
      // TODO: is this such an uncommon path that we can skip it?
      return this.canvas.toDataURL();
    } else {
      const tempCanvas = document.createElement("canvas");
      const squareSize = Math.min(this.canvas.width, this.canvas.height);
      tempCanvas.width = squareSize;
      tempCanvas.height = squareSize;
      const tempCtx = tempCanvas.getContext("2d"); // TODO: can we assume this is always availab?E

      tempCtx.drawImage(this.canvas, -(this.canvas.width - squareSize) / 2, -(this.canvas.height - squareSize) / 2);
      return tempCanvas.toDataURL();
    }
  }

}

exports.Twisty3DCanvas = Twisty3DCanvas;

_nodeCustomElementShims.customElementsShim.define("twisty-3d-canvas", Twisty3DCanvas);
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","three":"65WY3","../../animation/RenderScheduler":"1Xjlu","../element/ManagedCustomElement":"6Q6rX","./canvas":"FVBxw","./Twisty3DCanvas.css":"hkh7F","./TwistyOrbitControls":"Xce0t","../element/node-custom-element-shims":"3CBls","../../../../vendor/node_modules/three/examples/jsm/libs/stats.module":"6xKVv"}],"1Xjlu":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.RenderScheduler = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

// Debounces `requestAnimationFrame()`.
class RenderScheduler {
  constructor(callback) {
    this.callback = callback;
    (0, _defineProperty2.default)(this, "animFrameID", null);
    (0, _defineProperty2.default)(this, "animFrame", this.animFrameWrapper.bind(this));
  }

  requestAnimFrame() {
    if (!this.animFrameID) {
      this.animFrameID = requestAnimationFrame(this.animFrame);
    }
  }

  cancelAnimFrame() {
    if (this.animFrameID) {
      cancelAnimationFrame(this.animFrameID);
      this.animFrameID = 0;
    }
  }

  animFrameWrapper(timestamp) {
    this.animFrameID = 0;
    this.callback(timestamp);
  }

}

exports.RenderScheduler = RenderScheduler;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs"}],"6Q6rX":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.ManagedCustomElement = exports.CSSSource = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _nodeCustomElementShims = require("./node-custom-element-shims");

class CSSSource {
  constructor(sourceText) {// TODO: Replace with adopted style sheets some day if we can.
    // const blob = new Blob([sourceText], {
    //   type: "text/utf8",
    // });
    // this.url = URL.createObjectURL(blob);

    this.sourceText = sourceText;
  }

  getAsString() {
    return this.sourceText;
  }

} // - Wrapped element
//   - Shadow root
//     - Content wrapper


exports.CSSSource = CSSSource;

class ManagedCustomElement extends _nodeCustomElementShims.HTMLElementShim {
  // TODO: can we get rid of this wrapper?
  constructor(options) {
    var _options$mode;

    super();
    (0, _defineProperty2.default)(this, "shadow", void 0);
    (0, _defineProperty2.default)(this, "contentWrapper", void 0);
    (0, _defineProperty2.default)(this, "cssSourceMap", new Map());
    this.shadow = this.attachShadow({
      mode: (_options$mode = options === null || options === void 0 ? void 0 : options.mode) !== null && _options$mode !== void 0 ? _options$mode : "closed"
    });
    this.contentWrapper = document.createElement("div");
    this.contentWrapper.classList.add("wrapper");
    this.shadow.appendChild(this.contentWrapper);
  } // Add the source, if not already added.


  addCSS(cssSource) {
    if (this.cssSourceMap.get(cssSource)) {
      return;
    }

    const cssElem = document.createElement("style");
    cssElem.textContent = cssSource.getAsString();
    this.cssSourceMap.set(cssSource, cssElem);
    this.shadow.appendChild(cssElem);
  } // Remove the source, if it's currently added.


  removeCSS(cssSource) {
    const cssElem = this.cssSourceMap.get(cssSource);

    if (!cssElem) {
      return;
    }

    this.shadow.removeChild(cssElem);
    this.cssSourceMap.delete(cssSource);
  }

  addElement(element) {
    return this.contentWrapper.appendChild(element);
  }

  prependElement(element) {
    this.contentWrapper.prepend(element);
  }

  removeElement(element) {
    return this.contentWrapper.removeChild(element);
  }

}

exports.ManagedCustomElement = ManagedCustomElement;

_nodeCustomElementShims.customElementsShim.define("twisty-managed-custom-element", ManagedCustomElement);
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","./node-custom-element-shims":"3CBls"}],"3CBls":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.customElementsShim = exports.HTMLElementShim = void 0;

// Workarounds for `node`.
// TODO: figure out how to remove this.
// This stub does not need to be callable, just constructable to satisfy the `node` loader.
class HTMLElementStub {}

let HTMLElementShim;
exports.HTMLElementShim = HTMLElementShim;

if (typeof HTMLElement !== "undefined") {
  exports.HTMLElementShim = HTMLElementShim = HTMLElement;
} else {
  exports.HTMLElementShim = HTMLElementShim = HTMLElementStub;
}

class CustomElementsStub {
  define() {// nothing
  }

}

let customElementsShim;
exports.customElementsShim = customElementsShim;

if (typeof customElements !== "undefined") {
  exports.customElementsShim = customElementsShim = customElements;
} else {
  exports.customElementsShim = customElementsShim = new CustomElementsStub();
}
},{}],"FVBxw":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.pixelRatio = pixelRatio;

// TODO: Handle if you move across screens?
function pixelRatio() {
  return devicePixelRatio || 1;
}
},{}],"hkh7F":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.twisty3DCanvasCSS = void 0;

var _ManagedCustomElement = require("../element/ManagedCustomElement");

// The `position` values are a hack for a bug in Safari where the canvas either
// grows infinitely, or takes up the full `fr` of any encompassing grid (making
// the contents of that element e.g. over 100% of its height). `contain:
// content` is a good fix for this, but there is no indication that Safari will
// support it soon. https://developer.mozilla.org/en-US/docs/Web/CSS/contain
const twisty3DCanvasCSS = new _ManagedCustomElement.CSSSource(`
:host {
  width: 384px;
  height: 256px;
  display: grid;
}

.wrapper {
  width: 100%;
  height: 100%;
  display: grid;
  overflow: hidden;
}

/* TODO: This is due to stats hack. Replace with \`canvas\`. */
.wrapper > canvas {
  max-width: 100%;
  max-height: 100%;
}

.wrapper.invisible {
  opacity: 0;
}
`);
exports.twisty3DCanvasCSS = twisty3DCanvasCSS;
},{"../element/ManagedCustomElement":"6Q6rX"}],"Xce0t":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.TwistyOrbitControls = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _three = require("three");

var _RenderScheduler = require("../../animation/RenderScheduler");

// Buffer at the end values of the latitude (phi), to prevent gymbal lock.
// Without this, the puzzle would flip every frame if you try to push past the
// end, or snap to a standard longitude (theta).
const EPSILON = 0.00000001;
const INERTIA_DEFAULT = true;
const LATITUDE_LIMITS_DEFAULT = true;
const INERTIA_DURATION_MS = 500; // If the first inertial render is this long after the last move, we assume the
// user has halted the cursor and we consider inertia to have "timed out". We
// never begin animating the inertia.

const INERTIA_TIMEOUT_MS = 50;
const VERTICAL_MOVEMENT_BASE_SCALE = 0.75; // progress is from 0 to 1.

function momentumScale(progress) {
  // This is the exponential curve flipped so that
  // - The slope at progress = 0 is 1 (this corresponds to "x = 1" on the normal
  //   curve).
  // - The scale exponentially "decays" until progress = 1.
  // This means the scale at the end will be about 0.418
  return (Math.exp(1 - progress) - (1 - progress)) / (1 - Math.E) + 1;
}

class Inertia {
  constructor(startTimestamp, momentumX, momentumY, callback) {
    this.startTimestamp = startTimestamp;
    this.momentumX = momentumX;
    this.momentumY = momentumY;
    this.callback = callback;
    (0, _defineProperty2.default)(this, "scheduler", new _RenderScheduler.RenderScheduler(this.render.bind(this)));
    (0, _defineProperty2.default)(this, "lastTimestamp", void 0);
    this.scheduler.requestAnimFrame();
    this.lastTimestamp = startTimestamp;
  }

  render(now) {
    const progressBefore = (this.lastTimestamp - this.startTimestamp) / INERTIA_DURATION_MS;
    const progressAfter = Math.min(1, (now - this.startTimestamp) / INERTIA_DURATION_MS);

    if (progressBefore === 0 && progressAfter > INERTIA_TIMEOUT_MS / INERTIA_DURATION_MS) {
      // The user has already paused for a while. Don't start any inertia.
      return;
    }

    const delta = momentumScale(progressAfter) - momentumScale(progressBefore); // TODO: For now, we only carry horizontal momentum. If this should stay, we
    // can remove the plumbing for the Y dimension.

    this.callback(this.momentumX * delta * 1000, this.momentumY * delta * 1000);

    if (progressAfter < 1) {
      this.scheduler.requestAnimFrame();
    }

    this.lastTimestamp = now;
  }

} // TODO: change mouse cursor while moving.


class TwistyOrbitControls {
  /** @deprecated */

  /** @deprecated */
  // TODO: support multiple touches?
  // Variable for temporary use, to prevent reallocation.
  constructor(camera, canvas, scheduleRender) {
    this.camera = camera;
    this.canvas = canvas;
    this.scheduleRender = scheduleRender;
    (0, _defineProperty2.default)(this, "experimentalInertia", INERTIA_DEFAULT);
    (0, _defineProperty2.default)(this, "experimentalLatitudeLimits", LATITUDE_LIMITS_DEFAULT);
    (0, _defineProperty2.default)(this, "mirrorControls", void 0);
    (0, _defineProperty2.default)(this, "lastTouchClientX", 0);
    (0, _defineProperty2.default)(this, "lastTouchClientY", 0);
    (0, _defineProperty2.default)(this, "currentTouchID", null);
    (0, _defineProperty2.default)(this, "onMoveBound", this.onMove.bind(this));
    (0, _defineProperty2.default)(this, "onMouseMoveBound", this.onMouseMove.bind(this));
    (0, _defineProperty2.default)(this, "onMouseEndBound", this.onMouseEnd.bind(this));
    (0, _defineProperty2.default)(this, "onTouchMoveBound", this.onTouchMove.bind(this));
    (0, _defineProperty2.default)(this, "onTouchEndBound", this.onTouchEnd.bind(this));
    (0, _defineProperty2.default)(this, "tempSpherical", new _three.Spherical());
    (0, _defineProperty2.default)(this, "lastTouchTimestamp", 0);
    (0, _defineProperty2.default)(this, "lastTouchMoveMomentumX", 0);
    (0, _defineProperty2.default)(this, "lastTouchMoveMomentumY", 0);
    (0, _defineProperty2.default)(this, "lastMouseTimestamp", 0);
    (0, _defineProperty2.default)(this, "lastMouseMoveMomentumX", 0);
    (0, _defineProperty2.default)(this, "lastMouseMoveMomentumY", 0);
    (0, _defineProperty2.default)(this, "experimentalHasBeenMoved", false);
    canvas.addEventListener("mousedown", this.onMouseStart.bind(this));
    canvas.addEventListener("touchstart", this.onTouchStart.bind(this));
  } // f is the fraction of the canvas traversed per ms.


  temperMovement(f) {
    // This is scaled to be linear for small values, but to reduce large values
    // by a significant factor.
    return Math.sign(f) * Math.log(Math.abs(f * 10) + 1) / 6;
  }

  onMouseStart(e) {
    window.addEventListener("mousemove", this.onMouseMoveBound);
    window.addEventListener("mouseup", this.onMouseEndBound);
    this.onStart(e);
    this.lastMouseTimestamp = e.timeStamp;
  }

  onMouseMove(e) {
    if (e.buttons === 0) {
      // Certain elements (e.g. disabled buttons) can capture the `mouseup`
      // event. So if we notice that there are no mouse buttons pressed, we stop
      // the movement.
      this.onMouseEnd(e);
      return;
    }

    const minDim = Math.min(this.canvas.offsetWidth, this.canvas.offsetHeight);
    const movementX = this.temperMovement(e.movementX / minDim);
    const movementY = this.temperMovement(e.movementY / minDim * VERTICAL_MOVEMENT_BASE_SCALE);
    this.onMove(movementX, movementY);
    this.lastMouseMoveMomentumX = movementX / (e.timeStamp - this.lastMouseTimestamp);
    this.lastMouseMoveMomentumY = movementY / (e.timeStamp - this.lastMouseTimestamp);
    this.lastMouseTimestamp = e.timeStamp;
  }

  onMouseEnd(e) {
    window.removeEventListener("mousemove", this.onMouseMoveBound);
    window.removeEventListener("mouseup", this.onMouseEndBound);
    this.onEnd(e);

    if (this.experimentalInertia) {
      new Inertia(this.lastMouseTimestamp, this.lastMouseMoveMomentumX, this.lastMouseMoveMomentumY, this.onMoveBound);
    }
  }

  onTouchStart(e) {
    if (this.currentTouchID === null) {
      this.currentTouchID = e.changedTouches[0].identifier;
      this.lastTouchClientX = e.touches[0].clientX;
      this.lastTouchClientY = e.touches[0].clientY;
      window.addEventListener("touchmove", this.onTouchMoveBound);
      window.addEventListener("touchend", this.onTouchEndBound);
      window.addEventListener("touchcanel", this.onTouchEndBound);
      this.onStart(e);
      this.lastTouchTimestamp = e.timeStamp;
    }
  }

  onTouchMove(e) {
    for (let i = 0; i < e.changedTouches.length; i++) {
      const touch = e.changedTouches[i];

      if (touch.identifier === this.currentTouchID) {
        const minDim = Math.min(this.canvas.offsetWidth, this.canvas.offsetHeight);
        const movementX = this.temperMovement((touch.clientX - this.lastTouchClientX) / minDim);
        const movementY = this.temperMovement((touch.clientY - this.lastTouchClientY) / minDim * VERTICAL_MOVEMENT_BASE_SCALE);
        this.onMove(movementX, movementY);
        this.lastTouchClientX = touch.clientX;
        this.lastTouchClientY = touch.clientY;
        this.lastTouchMoveMomentumX = movementX / (e.timeStamp - this.lastTouchTimestamp);
        this.lastTouchMoveMomentumY = movementY / (e.timeStamp - this.lastTouchTimestamp);
        this.lastTouchTimestamp = e.timeStamp;
      }
    }
  }

  onTouchEnd(e) {
    for (let i = 0; i < e.changedTouches.length; i++) {
      const touch = e.changedTouches[i];

      if (touch.identifier === this.currentTouchID) {
        this.currentTouchID = null;
        window.removeEventListener("touchmove", this.onTouchMoveBound);
        window.removeEventListener("touchend", this.onTouchEndBound);
        window.removeEventListener("touchcancel", this.onTouchEndBound);
        this.onEnd(e);
      }
    }

    if (this.experimentalInertia) {
      new Inertia(this.lastTouchTimestamp, this.lastTouchMoveMomentumX, this.lastTouchMoveMomentumY, this.onMoveBound);
    }
  }

  onStart(e) {
    e.preventDefault();
  }

  onMove(movementX, movementY) {
    var _this$mirrorControls;

    // TODO: optimize, e.g. by caching or using the spherical coordinates
    // directly if they are still fresh.
    this.tempSpherical.setFromVector3(this.camera.position);
    this.tempSpherical.theta += -2 * movementX;
    this.tempSpherical.phi += -2 * movementY;

    if (this.experimentalLatitudeLimits) {
      this.tempSpherical.phi = Math.max(this.tempSpherical.phi, Math.PI * 0.3);
      this.tempSpherical.phi = Math.min(this.tempSpherical.phi, Math.PI * 0.7);
    } else {
      this.tempSpherical.phi = Math.max(this.tempSpherical.phi, EPSILON);
      this.tempSpherical.phi = Math.min(this.tempSpherical.phi, Math.PI - EPSILON);
    }

    this.camera.position.setFromSpherical(this.tempSpherical);
    this.camera.lookAt(new _three.Vector3(0, 0, 0));
    this.experimentalHasBeenMoved = true;
    this.scheduleRender();
    (_this$mirrorControls = this.mirrorControls) === null || _this$mirrorControls === void 0 ? void 0 : _this$mirrorControls.updateMirroredCamera(this.camera); // We would take the event in the arguments, and try to call
    // `preventDefault()` on it, but Chrome logs an error event if we try to
    // catch it, because it enforces a passive listener.
  }

  onEnd(e) {
    e.preventDefault();
  }

  setMirror(m) {
    this.mirrorControls = m;
  }

  updateMirroredCamera(c) {
    this.camera.position.copy(c.position);
    this.camera.position.multiplyScalar(-1);
    this.camera.lookAt(new _three.Vector3(0, 0, 0));
    this.scheduleRender();
  }

}

exports.TwistyOrbitControls = TwistyOrbitControls;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","three":"65WY3","../../animation/RenderScheduler":"1Xjlu"}],"6xKVv":[function(require,module,exports) {
/**
 * @author mrdoob / http://mrdoob.com/
 */

var Stats = function () {
  var mode = 0;

  var container = document.createElement("div");
  container.style.cssText =
    "position:fixed;top:0;left:0;cursor:pointer;opacity:0.9;z-index:10000";
  container.addEventListener(
    "click",
    function (event) {
      event.preventDefault();
      showPanel(++mode % container.children.length);
    },
    false,
  );

  //

  function addPanel(panel) {
    container.appendChild(panel.dom);
    return panel;
  }

  function showPanel(id) {
    for (var i = 0; i < container.children.length; i++) {
      container.children[i].style.display = i === id ? "block" : "none";
    }

    mode = id;
  }

  //

  var beginTime = (performance || Date).now(),
    prevTime = beginTime,
    frames = 0;

  var fpsPanel = addPanel(new Stats.Panel("FPS", "#0ff", "#002"));
  var msPanel = addPanel(new Stats.Panel("MS", "#0f0", "#020"));

  if (self.performance && self.performance.memory) {
    var memPanel = addPanel(new Stats.Panel("MB", "#f08", "#201"));
  }

  showPanel(0);

  return {
    REVISION: 16,

    dom: container,

    addPanel: addPanel,
    showPanel: showPanel,

    begin: function () {
      beginTime = (performance || Date).now();
    },

    end: function () {
      frames++;

      var time = (performance || Date).now();

      msPanel.update(time - beginTime, 200);

      if (time >= prevTime + 1000) {
        fpsPanel.update((frames * 1000) / (time - prevTime), 100);

        prevTime = time;
        frames = 0;

        if (memPanel) {
          var memory = performance.memory;
          memPanel.update(
            memory.usedJSHeapSize / 1048576,
            memory.jsHeapSizeLimit / 1048576,
          );
        }
      }

      return time;
    },

    update: function () {
      beginTime = this.end();
    },

    // Backwards Compatibility

    domElement: container,
    setMode: showPanel,
  };
};

Stats.Panel = function (name, fg, bg) {
  var min = Infinity,
    max = 0,
    round = Math.round;
  var PR = round(window.devicePixelRatio || 1);

  var WIDTH = 80 * PR,
    HEIGHT = 48 * PR,
    TEXT_X = 3 * PR,
    TEXT_Y = 2 * PR,
    GRAPH_X = 3 * PR,
    GRAPH_Y = 15 * PR,
    GRAPH_WIDTH = 74 * PR,
    GRAPH_HEIGHT = 30 * PR;

  var canvas = document.createElement("canvas");
  canvas.width = WIDTH;
  canvas.height = HEIGHT;
  canvas.style.cssText = "width:80px;height:48px";

  var context = canvas.getContext("2d");
  context.font = "bold " + 9 * PR + "px Helvetica,Arial,sans-serif";
  context.textBaseline = "top";

  context.fillStyle = bg;
  context.fillRect(0, 0, WIDTH, HEIGHT);

  context.fillStyle = fg;
  context.fillText(name, TEXT_X, TEXT_Y);
  context.fillRect(GRAPH_X, GRAPH_Y, GRAPH_WIDTH, GRAPH_HEIGHT);

  context.fillStyle = bg;
  context.globalAlpha = 0.9;
  context.fillRect(GRAPH_X, GRAPH_Y, GRAPH_WIDTH, GRAPH_HEIGHT);

  return {
    dom: canvas,

    update: function (value, maxValue) {
      min = Math.min(min, value);
      max = Math.max(max, value);

      context.fillStyle = bg;
      context.globalAlpha = 1;
      context.fillRect(0, 0, WIDTH, GRAPH_Y);
      context.fillStyle = fg;
      context.fillText(
        round(value) + " " + name + " (" + round(min) + "-" + round(max) + ")",
        TEXT_X,
        TEXT_Y,
      );

      context.drawImage(
        canvas,
        GRAPH_X + PR,
        GRAPH_Y,
        GRAPH_WIDTH - PR,
        GRAPH_HEIGHT,
        GRAPH_X,
        GRAPH_Y,
        GRAPH_WIDTH - PR,
        GRAPH_HEIGHT,
      );

      context.fillRect(GRAPH_X + GRAPH_WIDTH - PR, GRAPH_Y, PR, GRAPH_HEIGHT);

      context.fillStyle = bg;
      context.globalAlpha = 0.9;
      context.fillRect(
        GRAPH_X + GRAPH_WIDTH - PR,
        GRAPH_Y,
        PR,
        round((1 - value / maxValue) * GRAPH_HEIGHT),
      );
    },
  };
};

// This has been changed from `export default` because otherwise `npx jest`
// trips up on it.
module.exports = Stats;

},{}],"duTuZ":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
Object.defineProperty(exports, "countMoves", {
  enumerable: true,
  get: function () {
    return _CountMoves.countMoves;
  }
});
Object.defineProperty(exports, "countAnimatedMoves", {
  enumerable: true,
  get: function () {
    return _CountAnimatedMoves.countAnimatedMoves;
  }
});

var _CountMoves = require("./CountMoves");

var _CountAnimatedMoves = require("./CountAnimatedMoves");
},{"./CountMoves":"lRPso","./CountAnimatedMoves":"6JbeI"}],"lRPso":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.countMoves = void 0;

var _alg = require("../alg");

// TODO: move this file somewhere permanent.

/*
 *   For movecount, that understands puzzle rotations.  This code
 *   should be moved to the alg class, probably.
 */
class CountMoves extends _alg.TraversalUp {
  constructor(metric) {
    super();
    this.metric = metric;
  }

  traverseAlg(alg) {
    let r = 0;

    for (const unit of alg.units()) {
      r += this.traverseUnit(unit);
    }

    return r;
  }

  traverseGrouping(grouping) {
    // const unit: Unit = Alg.fromString("SDf");
    // console.log(unit);
    const alg = grouping.experimentalAlg;
    return this.traverseAlg(alg) * Math.abs(grouping.experimentalEffectiveAmount);
  }

  traverseMove(move) {
    return this.metric(move);
  }

  traverseCommutator(commutator) {
    return Math.abs(commutator.experimentalEffectiveAmount) * 2 * (this.traverseAlg(commutator.A) + this.traverseAlg(commutator.B));
  }

  traverseConjugate(conjugate) {
    return Math.abs(conjugate.experimentalEffectiveAmount) * (2 * this.traverseAlg(conjugate.A) + this.traverseAlg(conjugate.B));
  } // TODO: Remove spaces between repeated pauses (in traverseSequence)


  traversePause(_pause) {
    return 0;
  }

  traverseNewline(_newLine) {
    return 0;
  } // TODO: Enforce being followed by a newline (or the end of the alg)?


  traverseLineComment(_comment) {
    return 0;
  }

}

function isCharUppercase(c) {
  return "A" <= c && c <= "Z";
} // TODO: Implement a puzzle-specific way to calculate this.


function baseMetric(move) {
  const fam = move.family;

  if (isCharUppercase(fam[0]) && fam[fam.length - 1] === "v" || fam === "x" || fam === "y" || fam === "z" || fam === "T") {
    return 0;
  } else {
    return 1;
  }
}

const countMovesInstance = new CountMoves(baseMetric);
const countMoves = countMovesInstance.traverseAlg.bind(countMovesInstance);
exports.countMoves = countMoves;
},{"../alg":"7Ff6b"}],"6JbeI":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.countAnimatedMoves = void 0;

var _alg = require("../alg");

// TODO: Include Pause, include amounts
class CountAnimatedMoves extends _alg.TraversalUp {
  traverseAlg(alg) {
    let total = 0;

    for (const part of alg.units()) {
      total += this.traverseUnit(part);
    }

    return total;
  }

  traverseGrouping(grouping) {
    return this.traverseAlg(grouping.experimentalAlg) * Math.abs(grouping.experimentalEffectiveAmount);
  }

  traverseMove(_move) {
    return 1;
  }

  traverseCommutator(commutator) {
    return 2 * (this.traverseAlg(commutator.A) + this.traverseAlg(commutator.B));
  }

  traverseConjugate(conjugate) {
    return 2 * this.traverseAlg(conjugate.A) + this.traverseAlg(conjugate.B);
  }

  traversePause(_pause) {
    return 0;
  }

  traverseNewline(_newline) {
    return 0;
  }

  traverseLineComment(_comment) {
    return 0;
  }

}

const countAnimatedMovesInstance = new CountAnimatedMoves();
const countAnimatedMoves = countAnimatedMovesInstance.traverseAlg.bind(countAnimatedMovesInstance);
exports.countAnimatedMoves = countAnimatedMoves;
},{"../alg":"7Ff6b"}],"4DCsT":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.TwistyPlayerConfig = exports.viewerLinkPages = exports.puzzleIDs = exports.controlsLocations = exports.experimentalStickerings = exports.hintFaceletStyles = exports.backgroundThemes = exports.visualizationFormats = exports.setupToLocations = exports.cubeCameraPosition = exports.centeredCameraPosition = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _three = require("three");

var _ElementConfig = require("./element/ElementConfig");

var _TwistyViewerWrapper = require("./viewers/TwistyViewerWrapper");

const DEFAULT_CAMERA_Z = 5; // Golden ratio is perfect for FTO and Megaminx.

const DEFAULT_CAMERA_Y = DEFAULT_CAMERA_Z * (2 / (1 + Math.sqrt(5)));
const centeredCameraPosition = new _three.Vector3(0, DEFAULT_CAMERA_Y, DEFAULT_CAMERA_Z); // TODO

exports.centeredCameraPosition = centeredCameraPosition;
const cubeCameraPosition = new _three.Vector3(3, 4, 5); // TODO: turn these maps into lists?

exports.cubeCameraPosition = cubeCameraPosition;
const setupToLocations = {
  start: true,
  // default // TODO: "beginning"
  end: true
};
exports.setupToLocations = setupToLocations;
// TODO: turn these maps into lists?
const visualizationFormats = {
  "3D": true,
  // default
  "2D": true,
  "experimental-2D-LL": true,
  // TODO
  "PG3D": true
};
exports.visualizationFormats = visualizationFormats;
const backgroundThemes = {
  checkered: true,
  // default
  none: true
};
exports.backgroundThemes = backgroundThemes;
// TODO: turn these maps into lists?
const hintFaceletStyles = {
  floating: true,
  // default
  none: true
};
exports.hintFaceletStyles = hintFaceletStyles;
// TODO: turn these maps into lists?
// TODO: alg.cubing.net parity
const experimentalStickerings = {
  "full": true,
  // default
  "centers-only": true,
  // TODO
  "PLL": true,
  "CLS": true,
  "OLL": true,
  "COLL": true,
  "OCLL": true,
  "CLL": true,
  "ELL": true,
  "ELS": true,
  "LL": true,
  "F2L": true,
  "ZBLL": true,
  "ZBLS": true,
  "WVLS": true,
  "VLS": true,
  "LS": true,
  "EO": true,
  "CMLL": true,
  "L6E": true,
  "L6EO": true,
  "Daisy": true,
  "Cross": true,
  "2x2x2": true,
  "2x2x3": true,
  "Void Cube": true,
  "invisible": true,
  "picture": true,
  "experimental-centers-U": true,
  "experimental-centers-U-D": true,
  "experimental-centers-U-L-D": true,
  "experimental-centers-U-L-B-D": true,
  "experimental-centers": true,
  "experimental-fto-fc": true,
  "experimental-fto-f2t": true,
  "experimental-fto-sc": true,
  "experimental-fto-l2c": true,
  "experimental-fto-lbt": true
};
exports.experimentalStickerings = experimentalStickerings;
const controlsLocations = {
  "bottom-row": true,
  // default
  "none": true
};
exports.controlsLocations = controlsLocations;
const puzzleIDs = {
  "3x3x3": true,
  // default
  "custom": true,
  "2x2x2": true,
  "4x4x4": true,
  "5x5x5": true,
  "6x6x6": true,
  "7x7x7": true,
  "40x40x40": true,
  "megaminx": true,
  "pyraminx": true,
  "square1": true,
  "clock": true,
  "skewb": true,
  "fto": true,
  "gigaminx": true
};
exports.puzzleIDs = puzzleIDs;
const viewerLinkPages = {
  twizzle: true,
  // default
  none: true
};
exports.viewerLinkPages = viewerLinkPages;
const twistyPlayerAttributeMap = {
  "alg": "alg",
  "experimental-setup-alg": "experimentalSetupAlg",
  "experimental-setup-anchor": "experimentalSetupAnchor",
  "puzzle": "puzzle",
  "visualization": "visualization",
  "hint-facelets": "hintFacelets",
  "experimental-stickering": "experimentalStickering",
  "background": "background",
  "control-panel": "controlPanel",
  "back-view": "backView",
  "experimental-camera-position": "experimentalCameraPosition",
  "viewer-link": "viewerLink"
}; // TODO: Can we avoid instantiating a new class for each attribute, and would it help performance?

class TwistyPlayerConfig {
  constructor(twistyPlayer, // TODO
  initialValues) {
    this.twistyPlayer = twistyPlayer;
    (0, _defineProperty2.default)(this, "attributes", void 0);
    this.attributes = {
      "alg": new _ElementConfig.AlgAttribute(initialValues.alg),
      "experimental-setup-alg": new _ElementConfig.AlgAttribute(initialValues.experimentalSetupAlg),
      "experimental-setup-anchor": new _ElementConfig.StringEnumAttribute(setupToLocations, initialValues.experimentalSetupAnchor),
      "puzzle": new _ElementConfig.StringEnumAttribute(puzzleIDs, initialValues.puzzle),
      "visualization": new _ElementConfig.StringEnumAttribute(visualizationFormats, initialValues.visualization),
      "hint-facelets": new _ElementConfig.StringEnumAttribute(hintFaceletStyles, initialValues.hintFacelets),
      "experimental-stickering": new _ElementConfig.StringEnumAttribute(experimentalStickerings, initialValues.experimentalStickering),
      "background": new _ElementConfig.StringEnumAttribute(backgroundThemes, initialValues.background),
      "control-panel": new _ElementConfig.StringEnumAttribute(controlsLocations, initialValues.controlPanel),
      "back-view": new _ElementConfig.StringEnumAttribute(_TwistyViewerWrapper.backViewLayouts, initialValues["backView"]),
      "experimental-camera-position": new _ElementConfig.Vector3Attribute(null, initialValues["experimentalCameraPosition"]),
      "viewer-link": new _ElementConfig.StringEnumAttribute(viewerLinkPages, initialValues.viewerLink)
    };
  }

  static get observedAttributes() {
    return Object.keys(twistyPlayerAttributeMap);
  }

  attributeChangedCallback(attributeName, oldValue, newValue) {
    const managedAttribute = this.attributes[attributeName];

    if (managedAttribute) {
      // TODO: Handle `null` better.
      if (oldValue !== null && managedAttribute.string !== oldValue) {
        console.warn("Attribute out of sync!", attributeName, managedAttribute.string, oldValue);
      }

      managedAttribute.setString(newValue); // TODO: can we make this type-safe?
      // TODO: avoid double-setting in recursive calls

      const propertyName = twistyPlayerAttributeMap[attributeName]; // eslint-disable-next-line @typescript-eslint/ban-ts-comment
      // @ts-ignore

      this.twistyPlayer[propertyName] = managedAttribute.value;
    }
  }

}

exports.TwistyPlayerConfig = TwistyPlayerConfig;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","three":"65WY3","./element/ElementConfig":"7LoJ6","./viewers/TwistyViewerWrapper":"2w7nP"}],"7LoJ6":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Vector3Attribute = exports.StringFakeEnumAttribute = exports.StringEnumAttribute = exports.AlgAttribute = void 0;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _three = require("three");

var _alg = require("../../../alg");

// // type ConfigAttributes = Record<string, any>;
class AlgAttribute {
  constructor(initialValue) {
    (0, _defineProperty2.default)(this, "string", void 0);
    (0, _defineProperty2.default)(this, "value", void 0);

    if (initialValue) {
      if (typeof initialValue === "string") {
        this.setString(initialValue);
      } else {
        this.setValue(initialValue);
      }
    } else {
      this.setValue(this.defaultValue());
    }
  } // Return value indicates if the attribute changed.


  setString(str) {
    if (this.string === str) {
      return false;
    }

    this.string = str;
    this.value = this.toValue(str);
    return true;
  } // Return value indicates if the attribute changed.


  setValue(val) {
    const str = this.toString(val);

    if (this.string === str) {
      return false;
    }

    this.string = str;
    this.value = val;
    return true;
  }

  defaultValue() {
    return new _alg.Alg([]);
  }

  toValue(s) {
    return _alg.Alg.fromString(s);
  }

  toString(val) {
    return val.toString();
  }

} // TODO: subset of string rather than `extends`


exports.AlgAttribute = AlgAttribute;

class StringEnumAttribute {
  constructor(enumVal, initialValue) {
    this.enumVal = enumVal;
    (0, _defineProperty2.default)(this, "string", void 0);
    (0, _defineProperty2.default)(this, "value", void 0);
    (0, _defineProperty2.default)(this, "valid", void 0);
    this.setString(initialValue !== null && initialValue !== void 0 ? initialValue : this.defaultValue());
  } // Return value indicates if the attribute changed.


  setString(str) {
    if (this.string === str) {
      return false;
    }

    if (!(str in this.enumVal)) {
      throw new Error(`Invalid string for attribute!: ${str}`);
    }

    this.string = str;
    this.value = this.toValue(str);
    return true;
  } // Return value indicates if the attribute changed.


  setValue(val) {
    return this.setString(val);
  }

  defaultValue() {
    return Object.keys(this.enumVal)[0]; // TODO
  }

  toValue(s) {
    return s;
  } // private toString(s: string): string {
  //   return s;
  // }


} // TODO: subset of string rather than `extends`


exports.StringEnumAttribute = StringEnumAttribute;

class StringFakeEnumAttribute {
  constructor(validStrings, initialValue) {
    this.validStrings = validStrings;
    (0, _defineProperty2.default)(this, "string", void 0);
    (0, _defineProperty2.default)(this, "value", void 0);
    (0, _defineProperty2.default)(this, "valid", void 0);
    this.setString(initialValue !== null && initialValue !== void 0 ? initialValue : this.defaultValue());
  } // Return value indicates if the attribute changed.


  setString(str) {
    if (this.string === str) {
      return false;
    }

    if (!this.validStrings.includes(str)) {
      throw new Error(`Invalid string for attribute!: ${str}`);
    }

    this.string = str;
    this.value = this.toValue(str);
    return true;
  } // Return value indicates if the attribute changed.


  setValue(val) {
    return this.setString(val);
  }

  defaultValue() {
    return this.validStrings[0];
  }

  toValue(s) {
    return s;
  } // private toString(s: string): string {
  //   return s;
  // }


}

exports.StringFakeEnumAttribute = StringFakeEnumAttribute;

var _defaultValue = new WeakMap();

class Vector3Attribute {
  constructor(defaultValue, initialValue) {
    (0, _defineProperty2.default)(this, "string", void 0);
    (0, _defineProperty2.default)(this, "value", void 0);

    _defaultValue.set(this, {
      writable: true,
      value: void 0
    });

    (0, _classPrivateFieldSet2.default)(this, _defaultValue, defaultValue);
    this.setValue(initialValue !== null && initialValue !== void 0 ? initialValue : this.defaultValue());
  } // Return value indicates if the attribute changed.


  setString(str) {
    return this.setValue(str === "" ? null : this.toValue(str)); // TODO: test empty string
  } // Return value indicates if the attribute changed.


  setValue(val) {
    const str = this.toString(val);

    if (this.string === str) {
      return false;
    }

    this.string = str;
    this.value = val;
    return true;
  }

  defaultValue() {
    return (0, _classPrivateFieldGet2.default)(this, _defaultValue);
  }

  toValue(s) {
    if (!s.startsWith("[")) {
      throw new Error("TODO");
    }

    if (!s.endsWith("]")) {
      throw new Error("TODO");
    }

    const coords = s.slice(1, s.length - 1).split(",");

    if (coords.length !== 3) {
      throw new Error("TODO");
    }

    const [x, y, z] = coords.map(c => parseInt(c, 10));
    return new _three.Vector3(x, y, z);
  }

  toString(v) {
    return v ? `[${v.x}, ${v.y}, ${v.z}]` : ""; // TODO: empty string is not null
  }

}

exports.Vector3Attribute = Vector3Attribute;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","@babel/runtime/helpers/defineProperty":"55mTs","three":"65WY3","../../../alg":"7Ff6b"}],"2w7nP":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.TwistyViewerWrapper = exports.backViewLayouts = void 0;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _ClassListManager = require("../element/ClassListManager");

var _ManagedCustomElement = require("../element/ManagedCustomElement");

var _nodeCustomElementShims = require("../element/node-custom-element-shims");

var _TwistyViewerWrapper = require("./TwistyViewerWrapper.css");

const backViewLayouts = {
  "none": true,
  // default
  "side-by-side": true,
  "top-right": true
};
exports.backViewLayouts = backViewLayouts;

var _backViewClassListManager = new WeakMap();

class TwistyViewerWrapper extends _ManagedCustomElement.ManagedCustomElement {
  constructor(config = {}) {
    super();

    _backViewClassListManager.set(this, {
      writable: true,
      value: new _ClassListManager.ClassListManager(this, "back-view-", ["none", "side-by-side", "top-right"])
    });

    this.addCSS(_TwistyViewerWrapper.twistyViewerWrapperCSS);

    if (config.backView && config.backView in backViewLayouts) {
      (0, _classPrivateFieldGet2.default)(this, _backViewClassListManager).setValue(config.backView);
    }
  } // Returns if the value changed

  /** @deprecated */


  setBackView(backView) {
    return (0, _classPrivateFieldGet2.default)(this, _backViewClassListManager).setValue(backView);
  }

  clear() {
    this.contentWrapper.innerHTML = "";
  }

}

exports.TwistyViewerWrapper = TwistyViewerWrapper;

_nodeCustomElementShims.customElementsShim.define("twisty-viewer-wrapper", TwistyViewerWrapper);
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","../element/ClassListManager":"4ttu3","../element/ManagedCustomElement":"6Q6rX","../element/node-custom-element-shims":"3CBls","./TwistyViewerWrapper.css":"4v5gU"}],"4ttu3":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.ClassListManager = void 0;

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _currentClassName = new WeakMap();

class ClassListManager {
  // The prefix should ideally end in a dash.
  constructor(elem, prefix, validSuffixes) {
    this.elem = elem;
    this.prefix = prefix;
    this.validSuffixes = validSuffixes;

    _currentClassName.set(this, {
      writable: true,
      value: null
    });
  } // Does nothing if there was no value.


  clearValue() {
    if ((0, _classPrivateFieldGet2.default)(this, _currentClassName)) {
      this.elem.contentWrapper.classList.remove((0, _classPrivateFieldGet2.default)(this, _currentClassName));
    }

    (0, _classPrivateFieldSet2.default)(this, _currentClassName, null); // TODO: add test for this behaviour.
  } // Returns if the value changed


  setValue(suffix) {
    if (!this.validSuffixes.includes(suffix)) {
      throw new Error(`Invalid suffix: ${suffix}`);
    }

    const newClassName = `${this.prefix}${suffix}`;
    const changed = (0, _classPrivateFieldGet2.default)(this, _currentClassName) !== newClassName;

    if (changed) {
      this.clearValue();
      this.elem.contentWrapper.classList.add(newClassName);
      (0, _classPrivateFieldSet2.default)(this, _currentClassName, newClassName);
    }

    return changed;
  }

}

exports.ClassListManager = ClassListManager;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM"}],"4v5gU":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.twistyViewerWrapperCSS = void 0;

var _ManagedCustomElement = require("../element/ManagedCustomElement");

const twistyViewerWrapperCSS = new _ManagedCustomElement.CSSSource(`
:host {
  width: 384px;
  height: 256px;
  display: grid;
}

.wrapper {
  width: 100%;
  height: 100%;
  display: grid;
  overflow: hidden;
}

.wrapper > * {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.wrapper.back-view-side-by-side {
  grid-template-columns: 1fr 1fr;
}

.wrapper.back-view-top-right {
  grid-template-columns: 3fr 1fr;
  grid-template-rows: 1fr 3fr;
}

.wrapper.back-view-top-right > :nth-child(1) {
  grid-row: 1 / 3;
  grid-column: 1 / 3;
}

.wrapper.back-view-top-right > :nth-child(2) {
  grid-row: 1 / 2;
  grid-column: 2 / 3;
}
`);
exports.twistyViewerWrapperCSS = twistyViewerWrapperCSS;
},{"../element/ManagedCustomElement":"6Q6rX"}],"4hrtk":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.TwistyPlayer = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _classPrivateFieldGet7 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _three = require("three");

var _alg = require("../../alg");

var _puzzles = require("../../puzzles");

var _Cube3D = require("../3D/puzzles/Cube3D");

var _PG3D = require("../3D/puzzles/PG3D");

var _Twisty3DScene = require("../3D/Twisty3DScene");

var _AlgCursor = require("../animation/cursor/AlgCursor");

var _SimpleAlgIndexer = require("../animation/indexer/SimpleAlgIndexer");

var _SimultaneousMoveIndexer = require("../animation/indexer/simultaneous-moves/SimultaneousMoveIndexer");

var _TreeAlgIndexer = require("../animation/indexer/tree/TreeAlgIndexer");

var _Timeline = require("../animation/Timeline");

var _notation = require("../../notation");

var _buttons = require("./controls/buttons");

var _TwistyScrubber = require("./controls/TwistyScrubber");

var _ClassListManager = require("./element/ClassListManager");

var _ManagedCustomElement = require("./element/ManagedCustomElement");

var _nodeCustomElementShims = require("./element/node-custom-element-shims");

var _TwistyPlayer = require("./TwistyPlayer.css");

var _TwistyPlayerConfig = require("./TwistyPlayerConfig");

var _Twisty2DSVG = require("./viewers/Twisty2DSVG");

var _Twisty3DCanvas = require("./viewers/Twisty3DCanvas");

var _TwistyViewerWrapper = require("./viewers/TwistyViewerWrapper");

// TODO
function is3DVisualization(visualizationFormat) {
  return ["3D", "PG3D"].includes(visualizationFormat);
}

const indexerMap = {
  simple: _SimpleAlgIndexer.SimpleAlgIndexer,
  tree: _TreeAlgIndexer.TreeAlgIndexer,
  simultaneous: _SimultaneousMoveIndexer.SimultaneousMoveIndexer
}; // <twisty-player>

var _config = new WeakMap();

var _connected = new WeakMap();

var _legacyExperimentalPG3DViewConfig = new WeakMap();

var _experimentalStartStateOverride = new WeakMap();

var _hackyPendingFinalMoveCoalesce = new WeakMap();

var _viewerWrapper = new WeakMap();

var _controlsClassListManager = new WeakMap();

var _cursorIndexerName = new WeakMap();

var _pendingPuzzleUpdates = new WeakMap();

var _renderMode = new WeakMap();

class TwistyPlayer extends _ManagedCustomElement.ManagedCustomElement {
  /** @deprecated */
  // TODO: can we represent the intermediate state better?
  // TODO: can we represent the intermediate state better?
  // TODO: support config from DOM.
  constructor(initialConfig = {}, legacyExperimentalPG3DViewConfig = null, experimentalInvalidInitialAlgCallback = () => {// stub
  }) {
    super();
    this.experimentalInvalidInitialAlgCallback = experimentalInvalidInitialAlgCallback;

    _config.set(this, {
      writable: true,
      value: void 0
    });

    (0, _defineProperty2.default)(this, "timeline", void 0);
    (0, _defineProperty2.default)(this, "cursor", void 0);
    (0, _defineProperty2.default)(this, "scene", null);
    (0, _defineProperty2.default)(this, "twisty3D", null);

    _connected.set(this, {
      writable: true,
      value: false
    });

    _legacyExperimentalPG3DViewConfig.set(this, {
      writable: true,
      value: null
    });

    (0, _defineProperty2.default)(this, "legacyExperimentalPG3D", null);

    _experimentalStartStateOverride.set(this, {
      writable: true,
      value: null
    });

    (0, _defineProperty2.default)(this, "viewerElems", []);
    (0, _defineProperty2.default)(this, "controlElems", []);

    _hackyPendingFinalMoveCoalesce.set(this, {
      writable: true,
      value: false
    });

    _viewerWrapper.set(this, {
      writable: true,
      value: void 0
    });

    (0, _defineProperty2.default)(this, "legacyExperimentalCoalesceModFunc", _move => 0);

    _controlsClassListManager.set(this, {
      writable: true,
      value: new _ClassListManager.ClassListManager(this, "controls-", ["none", "bottom-row"])
    });

    _cursorIndexerName.set(this, {
      writable: true,
      value: "tree"
    });

    _pendingPuzzleUpdates.set(this, {
      writable: true,
      value: []
    });

    _renderMode.set(this, {
      writable: true,
      value: null
    });

    this.addCSS(_TwistyPlayer.twistyPlayerCSS);
    (0, _classPrivateFieldSet2.default)(this, _config, new _TwistyPlayerConfig.TwistyPlayerConfig(this, initialConfig));
    this.timeline = new _Timeline.Timeline();
    this.timeline.addActionListener(this); // We also do this in connectedCallback, but for now we also do it here so
    // that there is some visual change even if the rest of construction or
    // initialization fails.

    this.contentWrapper.classList.add("checkered");
    (0, _classPrivateFieldSet2.default)(this, _legacyExperimentalPG3DViewConfig, legacyExperimentalPG3DViewConfig);
  } // TODO(https://github.com/microsoft/TypeScript/pull/42425): Allow setting string in the type decl.


  set alg(newAlg)
  /* | string*/
  {
    var _this$cursor;

    // TODO: do validation for other algs as well.
    if (typeof newAlg === "string") {
      newAlg = _alg.Alg.fromString(newAlg);
    }

    (0, _classPrivateFieldGet7.default)(this, _config).attributes["alg"].setValue(newAlg);
    (_this$cursor = this.cursor) === null || _this$cursor === void 0 ? void 0 : _this$cursor.setAlg(newAlg, this.indexerConstructor()); // TODO: can we ensure the cursor already exists?

    this.setCursorStartState();
  }

  get alg() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["alg"].value;
  }
  /** @deprecated */


  set experimentalSetupAlg(newAlg) {
    // TODO: do validation for other algs as well.
    if (typeof newAlg === "string") {
      console.warn("`experimentalSetupAlg` for a `TwistyPlayer` was set using a string. It should be set using a `Sequence`!");
      newAlg = new _alg.Alg(newAlg);
    }

    (0, _classPrivateFieldGet7.default)(this, _config).attributes["experimental-setup-alg"].setValue(newAlg);
    this.setCursorStartState();
  }
  /** @deprecated */


  get experimentalSetupAlg() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["experimental-setup-alg"].value;
  }

  setCursorStartState() {
    if (this.cursor) {
      var _classPrivateFieldGet2;

      this.cursor.setStartState((_classPrivateFieldGet2 = (0, _classPrivateFieldGet7.default)(this, _experimentalStartStateOverride)) !== null && _classPrivateFieldGet2 !== void 0 ? _classPrivateFieldGet2 : this.cursor.algToState(this.cursorStartAlg())); // TODO
    }
  }

  cursorStartAlg() {
    let startAlg = this.experimentalSetupAlg;

    if (this.experimentalSetupAnchor === "end") {
      startAlg = startAlg.concat(this.alg.invert());
    }

    return startAlg; // TODO
  }
  /** @deprecated */


  set experimentalSetupAnchor(setupToLocation) {
    (0, _classPrivateFieldGet7.default)(this, _config).attributes["experimental-setup-anchor"].setValue(setupToLocation);
    this.setCursorStartState();
  }
  /** @deprecated */


  get experimentalSetupAnchor() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["experimental-setup-anchor"].value;
  }

  set puzzle(puzzle) {
    if ((0, _classPrivateFieldGet7.default)(this, _config).attributes["puzzle"].setValue(puzzle)) {
      this.updatePuzzleDOM();
    }
  }

  get puzzle() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["puzzle"].value;
  }

  set visualization(visualization) {
    if ((0, _classPrivateFieldGet7.default)(this, _config).attributes["visualization"].setValue(visualization)) {
      this.updatePuzzleDOM();
    }
  }

  get visualization() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["visualization"].value;
  }

  set hintFacelets(hintFacelets) {
    // TODO: implement this for PG3D.
    if ((0, _classPrivateFieldGet7.default)(this, _config).attributes["hint-facelets"].setValue(hintFacelets)) {
      if (this.twisty3D instanceof _Cube3D.Cube3D) {
        this.twisty3D.experimentalUpdateOptions({
          hintFacelets
        });
      }
    }
  }

  get hintFacelets() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["hint-facelets"].value;
  } // TODO: Implement for PG3D

  /** @deprecated */


  get experimentalStickering() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["experimental-stickering"].value;
  } // TODO: Implement for PG3D

  /** @deprecated */


  set experimentalStickering(experimentalStickering) {
    if ((0, _classPrivateFieldGet7.default)(this, _config).attributes["experimental-stickering"].setValue(experimentalStickering)) {
      const twisty3D = this.twisty3D;

      if (twisty3D instanceof _Cube3D.Cube3D) {
        twisty3D.experimentalUpdateOptions({
          experimentalStickering
        });
      }

      if (twisty3D instanceof _PG3D.PG3D) {
        (async () => {
          const appearance = await this.getPG3DAppearance();
          twisty3D.experimentalSetAppearance(appearance); // TODO
        })();
      }

      if (this.viewerElems[0] instanceof _Twisty2DSVG.Twisty2DSVG) {
        this.viewerElems[0].experimentalSetStickering(this.experimentalStickering);
      }
    }
  }

  set background(background) {
    if ((0, _classPrivateFieldGet7.default)(this, _config).attributes["background"].setValue(background)) {
      this.contentWrapper.classList.toggle("checkered", background === "checkered");
    }
  }

  get background() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["background"].value;
  }

  set controlPanel(controlPanel) {
    (0, _classPrivateFieldGet7.default)(this, _config).attributes["control-panel"].setValue(controlPanel);
    (0, _classPrivateFieldGet7.default)(this, _controlsClassListManager).setValue(controlPanel);
  }

  get controlPanel() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["control-panel"].value;
  }
  /** @deprecated use `controlPanel */


  set controls(controls) {
    this.controlPanel = controls;
  }
  /** @deprecated use `controlPanel */


  get controls() {
    return this.controlPanel;
  }

  set backView(backView) {
    (0, _classPrivateFieldGet7.default)(this, _config).attributes["back-view"].setValue(backView);

    if (backView !== "none" && this.viewerElems.length === 1) {
      this.createBackViewer();
    }

    if (backView === "none" && this.viewerElems.length > 1) {
      this.removeBackViewerElem();
    }

    if ((0, _classPrivateFieldGet7.default)(this, _viewerWrapper) && (0, _classPrivateFieldGet7.default)(this, _viewerWrapper).setBackView(backView)) {
      for (const viewer of this.viewerElems) {
        viewer.makeInvisibleUntilRender(); // TODO: can we do this more elegantly?
      }
    }
  }

  get backView() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["back-view"].value;
  }

  set experimentalCameraPosition(cameraPosition) {
    (0, _classPrivateFieldGet7.default)(this, _config).attributes["experimental-camera-position"].setValue(cameraPosition);

    if (this.viewerElems && ["3D", "PG3D"].includes((0, _classPrivateFieldGet7.default)(this, _config).attributes["visualization"].value)) {
      var _this$viewerElems$, _this$viewerElems$2, _this$viewerElems$3, _this$viewerElems$4, _this$viewerElems$5, _this$viewerElems$6;

      (_this$viewerElems$ = this.viewerElems[0]) === null || _this$viewerElems$ === void 0 ? void 0 : _this$viewerElems$.camera.position.copy(this.effectiveCameraPosition);
      (_this$viewerElems$2 = this.viewerElems[0]) === null || _this$viewerElems$2 === void 0 ? void 0 : _this$viewerElems$2.camera.lookAt(new _three.Vector3(0, 0, 0));
      (_this$viewerElems$3 = this.viewerElems[0]) === null || _this$viewerElems$3 === void 0 ? void 0 : _this$viewerElems$3.scheduleRender(); // Back view may or may not exist.

      (_this$viewerElems$4 = this.viewerElems[1]) === null || _this$viewerElems$4 === void 0 ? void 0 : _this$viewerElems$4.camera.position.copy(this.effectiveCameraPosition).multiplyScalar(-1);
      (_this$viewerElems$5 = this.viewerElems[1]) === null || _this$viewerElems$5 === void 0 ? void 0 : _this$viewerElems$5.camera.lookAt(new _three.Vector3(0, 0, 0));
      (_this$viewerElems$6 = this.viewerElems[1]) === null || _this$viewerElems$6 === void 0 ? void 0 : _this$viewerElems$6.scheduleRender();
    }
  }

  get experimentalCameraPosition() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["experimental-camera-position"].value;
  }

  set viewerLink(viewerLinkPage) {
    (0, _classPrivateFieldGet7.default)(this, _config).attributes["viewer-link"].setValue(viewerLinkPage);
    const maybePanel = this.controlElems[1];

    if (maybePanel === null || maybePanel === void 0 ? void 0 : maybePanel.setViewerLink) {
      maybePanel.setViewerLink(viewerLinkPage);
    }
  }

  get viewerLink() {
    return (0, _classPrivateFieldGet7.default)(this, _config).attributes["viewer-link"].value;
  }

  get effectiveCameraPosition() {
    var _this$experimentalCam;

    return (_this$experimentalCam = this.experimentalCameraPosition) !== null && _this$experimentalCam !== void 0 ? _this$experimentalCam : this.defaultCameraPosition;
  } // TODO


  get defaultCameraPosition() {
    return this.puzzle[1] === "x" ? _TwistyPlayerConfig.cubeCameraPosition : _TwistyPlayerConfig.centeredCameraPosition;
  }

  static get observedAttributes() {
    return _TwistyPlayerConfig.TwistyPlayerConfig.observedAttributes;
  }

  attributeChangedCallback(attributeName, oldValue, newValue) {
    (0, _classPrivateFieldGet7.default)(this, _config).attributeChangedCallback(attributeName, oldValue, newValue);
  }

  experimentalSetStartStateOverride(state) {
    (0, _classPrivateFieldSet2.default)(this, _experimentalStartStateOverride, state);
    this.setCursorStartState();
  }

  /** @deprecated */
  experimentalSetCursorIndexer(cursorName) {
    var _this$cursor2;

    if ((0, _classPrivateFieldGet7.default)(this, _cursorIndexerName) === cursorName) {
      // TODO: This is a hacky optimization.
      return;
    }

    (0, _classPrivateFieldSet2.default)(this, _cursorIndexerName, cursorName);
    (_this$cursor2 = this.cursor) === null || _this$cursor2 === void 0 ? void 0 : _this$cursor2.experimentalSetIndexer(this.indexerConstructor());
  }

  indexerConstructor() {
    return indexerMap[(0, _classPrivateFieldGet7.default)(this, _cursorIndexerName)];
  } // TODO: It seems this called after the `attributeChangedCallback`s for initial values. Can we rely on this?


  connectedCallback() {
    this.contentWrapper.classList.toggle("checkered", this.background === "checkered"); // TODO: specify exactly when back views are possible.
    // TODO: Are there any SVGs where we'd want a separate back view?

    const setBackView = this.backView && is3DVisualization(this.visualization);
    const backView = setBackView ? this.backView : "none";
    (0, _classPrivateFieldSet2.default)(this, _viewerWrapper, new _TwistyViewerWrapper.TwistyViewerWrapper({
      backView
    }));
    this.addElement((0, _classPrivateFieldGet7.default)(this, _viewerWrapper));
    const scrubber = new _TwistyScrubber.TwistyScrubber(this.timeline);
    const controlButtonGrid = new _buttons.TwistyControlButtonPanel(this.timeline, {
      fullscreenElement: this,
      viewerLinkCallback: this.visitTwizzleLink.bind(this),
      viewerLink: this.viewerLink
    });
    this.controlElems = [scrubber, controlButtonGrid];
    (0, _classPrivateFieldGet7.default)(this, _controlsClassListManager).setValue(this.controlPanel);
    this.addElement(this.controlElems[0]);
    this.addElement(this.controlElems[1]);
    (0, _classPrivateFieldSet2.default)(this, _connected, true);
    this.updatePuzzleDOM(true);
  }

  twizzleLink() {
    const url = new URL("https://experiments.cubing.net/cubing.js/alg.cubing.net/index.html"); // const url = new URL("http://localhost:3333/alg.cubing.net/index.html");

    if (!this.alg.experimentalIsEmpty()) {
      url.searchParams.set("alg", this.alg.toString());
    }

    if (!this.experimentalSetupAlg.experimentalIsEmpty()) {
      url.searchParams.set("experimental-setup-alg", this.experimentalSetupAlg.toString());
    }

    if (this.experimentalSetupAnchor !== "start") {
      url.searchParams.set("experimental-setup-anchor", this.experimentalSetupAnchor);
    }

    if (this.experimentalStickering !== "full") {
      url.searchParams.set("experimental-stickering", this.experimentalStickering);
    }

    if (this.puzzle !== "3x3x3") {
      url.searchParams.set("puzzle", this.puzzle);
    }

    return url.toString();
  }

  visitTwizzleLink() {
    const a = document.createElement("a");
    a.href = this.twizzleLink();
    a.target = "_blank";
    a.click();
  }

  // Idempotent
  clearRenderMode() {
    switch ((0, _classPrivateFieldGet7.default)(this, _renderMode)) {
      case "3D":
        this.scene = null;
        this.twisty3D = null;
        this.legacyExperimentalPG3D = null;
        this.viewerElems = [];
        (0, _classPrivateFieldGet7.default)(this, _viewerWrapper).clear();
        break;

      case "2D":
        this.viewerElems = [];
        (0, _classPrivateFieldGet7.default)(this, _viewerWrapper).clear();
        break;
    }

    (0, _classPrivateFieldSet2.default)(this, _renderMode, null);
  }

  setRenderMode2D() {
    if ((0, _classPrivateFieldGet7.default)(this, _renderMode) === "2D") {
      return;
    }

    this.clearRenderMode();
    (0, _classPrivateFieldSet2.default)(this, _renderMode, "2D");
  }

  setTwisty2DSVG(twisty2DSVG) {
    this.setRenderMode2D();
    (0, _classPrivateFieldGet7.default)(this, _viewerWrapper).clear();
    (0, _classPrivateFieldGet7.default)(this, _viewerWrapper).addElement(twisty2DSVG);
    this.viewerElems.push(twisty2DSVG);
  }

  setRenderMode3D() {
    if ((0, _classPrivateFieldGet7.default)(this, _renderMode) === "3D") {
      return;
    }

    this.clearRenderMode();
    this.scene = new _Twisty3DScene.Twisty3DScene();
    const mainViewer = new _Twisty3DCanvas.Twisty3DCanvas(this.scene, {
      experimentalCameraPosition: this.effectiveCameraPosition
    });
    this.viewerElems.push(mainViewer);
    (0, _classPrivateFieldGet7.default)(this, _viewerWrapper).addElement(mainViewer);

    if (this.backView !== "none") {
      this.createBackViewer();
    }

    (0, _classPrivateFieldSet2.default)(this, _renderMode, "3D");
  }

  setTwisty3D(twisty3D) {
    if (this.twisty3D) {
      this.scene.removeTwisty3DPuzzle(this.twisty3D);

      if (this.twisty3D instanceof _PG3D.PG3D) {
        this.twisty3D.dispose();
      }

      this.twisty3D = null;
    }

    this.twisty3D = twisty3D;
    this.scene.addTwisty3DPuzzle(twisty3D);
  }

  setCursor(cursor) {
    const oldCursor = this.cursor;
    this.cursor = cursor;

    try {
      this.cursor.setAlg(this.alg, this.indexerConstructor());
      this.setCursorStartState();
    } catch (e) {
      this.cursor.setAlg(new _alg.Alg(), this.indexerConstructor());
      this.cursor.setStartState(this.cursor.algToState(new _alg.Alg()));
      this.experimentalInvalidInitialAlgCallback(this.alg);
    }

    this.setCursorStartState();
    this.timeline.addCursor(cursor);

    if (oldCursor) {
      this.timeline.removeCursor(oldCursor);
      this.timeline.removeTimestampListener(oldCursor);
    }

    this.experimentalSetCursorIndexer((0, _classPrivateFieldGet7.default)(this, _cursorIndexerName));
  } // eslint-disable-next-line @typescript-eslint/no-unused-vars-experimental


  async updatePuzzleDOM(initial = false) {
    if (!(0, _classPrivateFieldGet7.default)(this, _connected)) {
      return;
    }

    let puzzleLoader;

    if (this.puzzle === "custom") {
      puzzleLoader = {
        id: "custom",
        fullName: "Custom (PG3D)",
        def: () => Promise.resolve((0, _classPrivateFieldGet7.default)(this, _legacyExperimentalPG3DViewConfig).def),
        svg: async () => {
          throw "unimplemented";
        }
      };
    } else {
      puzzleLoader = _puzzles.puzzles[this.puzzle];
    }

    for (const pendingPuzzleUpdate of (0, _classPrivateFieldGet7.default)(this, _pendingPuzzleUpdates)) {
      pendingPuzzleUpdate.cancelled = true;
    }

    (0, _classPrivateFieldSet2.default)(this, _pendingPuzzleUpdates, []);
    const pendingPuzzleUpdate = {
      cancelled: false
    };
    (0, _classPrivateFieldGet7.default)(this, _pendingPuzzleUpdates).push(pendingPuzzleUpdate);
    const def = await puzzleLoader.def();

    if (pendingPuzzleUpdate.cancelled) {
      return;
    }

    let cursor;

    try {
      cursor = new _AlgCursor.AlgCursor(this.timeline, def, this.alg, this.cursorStartAlg(), this.indexerConstructor()); // TODO: validate more directly if the alg is okay for the puzzle.

      this.setCursor(cursor);
    } catch (e) {
      if (initial) {
        // TODO: also take into account setup alg.
        this.experimentalInvalidInitialAlgCallback(this.alg);
      }

      cursor = new _AlgCursor.AlgCursor(this.timeline, def, new _alg.Alg(), new _alg.Alg(), this.indexerConstructor());
      this.setCursor(cursor);
    }

    if (initial && this.experimentalSetupAlg.experimentalIsEmpty() && this.experimentalSetupAnchor !== "end") {
      this.timeline.jumpToEnd();
    }

    switch (this.visualization) {
      case "2D":
      case "experimental-2D-LL":
        {
          var _puzzleLoader$llSVG;

          const options = {};

          if (this.experimentalStickering) {
            options.experimentalStickering = this.experimentalStickering;
          }

          this.setRenderMode2D();
          const svgPromiseFn = this.visualization === "2D" ? puzzleLoader.svg : (_puzzleLoader$llSVG = puzzleLoader.llSVG) !== null && _puzzleLoader$llSVG !== void 0 ? _puzzleLoader$llSVG : puzzleLoader.svg;
          const mainViewer = new _Twisty2DSVG.Twisty2DSVG(cursor, def, await svgPromiseFn(), options, puzzleLoader);

          if (!pendingPuzzleUpdate.cancelled) {
            this.setTwisty2DSVG(mainViewer);
          }
        }
        break;

      case "3D":
      case "PG3D":
        {
          this.setRenderMode3D();
          const scene = this.scene;
          let twisty3D;

          if (this.visualization === "3D" && this.puzzle === "3x3x3") {
            twisty3D = new _Cube3D.Cube3D(def, cursor, scene.scheduleRender.bind(scene), {
              hintFacelets: this.hintFacelets,
              experimentalStickering: this.experimentalStickering
            });
          } else {
            var _classPrivateFieldGet3, _classPrivateFieldGet4, _classPrivateFieldGet5, _classPrivateFieldGet6;

            let def;
            let stickerDat;
            const pgGetter = puzzleLoader.pg;

            if (this.puzzle === "custom") {
              def = (0, _classPrivateFieldGet7.default)(this, _legacyExperimentalPG3DViewConfig).def;
              stickerDat = (0, _classPrivateFieldGet7.default)(this, _legacyExperimentalPG3DViewConfig).stickerDat;
            } else if (pgGetter) {
              const pg = await pgGetter();

              if (pendingPuzzleUpdate.cancelled) {
                return;
              }

              def = pg.writekpuzzle(true); // TODO

              stickerDat = pg.get3d();
            } else {
              throw "Unimplemented!";
            }

            const options = {};
            const pg3d = new _PG3D.PG3D(cursor, scene.scheduleRender.bind(scene), def, stickerDat, (_classPrivateFieldGet3 = (_classPrivateFieldGet4 = (0, _classPrivateFieldGet7.default)(this, _legacyExperimentalPG3DViewConfig)) === null || _classPrivateFieldGet4 === void 0 ? void 0 : _classPrivateFieldGet4.showFoundation) !== null && _classPrivateFieldGet3 !== void 0 ? _classPrivateFieldGet3 : true, (_classPrivateFieldGet5 = (_classPrivateFieldGet6 = (0, _classPrivateFieldGet7.default)(this, _legacyExperimentalPG3DViewConfig)) === null || _classPrivateFieldGet6 === void 0 ? void 0 : _classPrivateFieldGet6.hintStickers) !== null && _classPrivateFieldGet5 !== void 0 ? _classPrivateFieldGet5 : this.hintFacelets === "floating", options);

            (async () => {
              const appearance = await this.getPG3DAppearance();

              if (appearance) {
                pg3d.experimentalSetAppearance(appearance);
              }
            })();

            this.legacyExperimentalPG3D = pg3d;
            twisty3D = pg3d;
          }

          this.setTwisty3D(twisty3D);
        }
        break;
    }
  }

  async getPG3DAppearance() {
    const puzzleLoader = _puzzles.puzzles[this.puzzle];

    if (puzzleLoader === null || puzzleLoader === void 0 ? void 0 : puzzleLoader.appearance) {
      var _this$experimentalSti;

      return puzzleLoader.appearance((_this$experimentalSti = this.experimentalStickering) !== null && _this$experimentalSti !== void 0 ? _this$experimentalSti : "full");
    }

    return null;
  }

  createBackViewer() {
    if (!is3DVisualization(this.visualization)) {
      throw new Error("Back viewer requires a 3D visualization");
    }

    const backViewer = new _Twisty3DCanvas.Twisty3DCanvas(this.scene, {
      experimentalCameraPosition: this.effectiveCameraPosition,
      negateCameraPosition: true
    });
    this.viewerElems.push(backViewer);
    this.viewerElems[0].setMirror(backViewer);
    (0, _classPrivateFieldGet7.default)(this, _viewerWrapper).addElement(backViewer);
  }

  removeBackViewerElem() {
    // TODO: Validate visualization.
    if (this.viewerElems.length !== 2) {
      throw new Error("Tried to remove non-existent back view!");
    }

    (0, _classPrivateFieldGet7.default)(this, _viewerWrapper).removeElement(this.viewerElems.pop());
  }

  async setCustomPuzzleGeometry(legacyExperimentalPG3DViewConfig) {
    this.puzzle = "custom";
    (0, _classPrivateFieldSet2.default)(this, _legacyExperimentalPG3DViewConfig, legacyExperimentalPG3DViewConfig);
    await this.updatePuzzleDOM();
  } // TODO: Handle playing the new move vs. just modying the alg.
  // Note: setting `coalesce`


  experimentalAddMove(move, coalesce = false, coalesceDelayed = false) {
    if ((0, _classPrivateFieldGet7.default)(this, _hackyPendingFinalMoveCoalesce)) {
      this.hackyCoalescePending();
    }

    const oldNumMoves = (0, _notation.countMoves)(this.alg); // TODO

    const newAlg = (0, _alg.experimentalAppendMove)(this.alg, move, {
      coalesce: coalesce && !coalesceDelayed,
      mod: this.legacyExperimentalCoalesceModFunc(move)
    }); // const newAlg = experimentalAppendBlockMove(
    //   this.alg,
    //   move,
    //   coalesce && !coalesceDelayed,
    //   this.legacyExperimentalCoalesceModFunc(move),
    // );

    if (coalesce && coalesceDelayed) {
      (0, _classPrivateFieldSet2.default)(this, _hackyPendingFinalMoveCoalesce, true);
    }

    this.alg = newAlg; // TODO

    if (oldNumMoves <= (0, _notation.countMoves)(newAlg)) {
      this.timeline.experimentalJumpToLastMove();
    } else {
      this.timeline.jumpToEnd();
    }

    this.timeline.play();
  }

  onTimelineAction(actionEvent) {
    if (actionEvent.action === _Timeline.TimelineAction.Pausing && actionEvent.locationType === _Timeline.TimestampLocationType.EndOfTimeline && (0, _classPrivateFieldGet7.default)(this, _hackyPendingFinalMoveCoalesce)) {
      this.hackyCoalescePending();
      this.timeline.jumpToEnd();
    }
  }

  hackyCoalescePending() {
    const units = Array.from(this.alg.units());
    const length = units.length;
    const pending = (0, _classPrivateFieldGet7.default)(this, _hackyPendingFinalMoveCoalesce);
    (0, _classPrivateFieldSet2.default)(this, _hackyPendingFinalMoveCoalesce, false);

    if (pending && length > 1 && units[length - 1].is(_alg.Move)) {
      const finalMove = units[length - 1];
      const newAlg = (0, _alg.experimentalAppendMove)(new _alg.Alg(units.slice(0, length - 1)), finalMove, {
        coalesce: true,
        mod: this.legacyExperimentalCoalesceModFunc(finalMove)
      });
      this.alg = newAlg;
    }
  }

  fullscreen() {
    this.requestFullscreen();
  }

}

exports.TwistyPlayer = TwistyPlayer;

_nodeCustomElementShims.customElementsShim.define("twisty-player", TwistyPlayer);
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","three":"65WY3","../../alg":"7Ff6b","../../puzzles":"KrRHt","../3D/puzzles/Cube3D":"784Fj","../3D/puzzles/PG3D":"5NdrU","../3D/Twisty3DScene":"2KiAH","../animation/cursor/AlgCursor":"1Dahd","../animation/indexer/SimpleAlgIndexer":"105Ga","../animation/indexer/simultaneous-moves/SimultaneousMoveIndexer":"5qE7r","../animation/indexer/tree/TreeAlgIndexer":"3v6C1","../animation/Timeline":"5Cj4O","../../notation":"duTuZ","./controls/buttons":"5NJ8b","./controls/TwistyScrubber":"5KyY7","./element/ClassListManager":"4ttu3","./element/ManagedCustomElement":"6Q6rX","./element/node-custom-element-shims":"3CBls","./TwistyPlayer.css":"7doiv","./TwistyPlayerConfig":"4DCsT","./viewers/Twisty2DSVG":"1AIRW","./viewers/Twisty3DCanvas":"1Qn8g","./viewers/TwistyViewerWrapper":"2w7nP"}],"784Fj":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.experimentalSetDefaultStickerElevation = experimentalSetDefaultStickerElevation;
exports.Cube3D = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _three = require("three");

var _puzzles = require("../../../puzzles");

var _easing = require("../../animation/easing");

var _TwistyPlayerConfig = require("../../dom/TwistyPlayerConfig");

var _TAU = require("../TAU");

const svgLoader = new _three.TextureLoader();
const ignoredMaterial = new _three.MeshBasicMaterial({
  color: 0x444444,
  side: _three.DoubleSide
});
const ignoredMaterialHint = new _three.MeshBasicMaterial({
  color: 0xcccccc,
  side: _three.BackSide
});
const invisibleMaterial = new _three.MeshBasicMaterial({
  visible: false
});
const orientedMaterial = new _three.MeshBasicMaterial({
  color: 0xff88ff
});
const orientedMaterialHint = new _three.MeshBasicMaterial({
  color: 0xff88ff,
  side: _three.BackSide
});

class AxisInfo {
  constructor(vector, fromZ, color, dimColor) {
    this.vector = vector;
    this.fromZ = fromZ;
    this.color = color;
    this.dimColor = dimColor;
    (0, _defineProperty2.default)(this, "stickerMaterial", void 0);
    (0, _defineProperty2.default)(this, "hintStickerMaterial", void 0);
    // TODO: Make sticker material single-sided when cubie foundation is opaque?
    this.stickerMaterial = {
      regular: new _three.MeshBasicMaterial({
        color,
        side: _three.DoubleSide
      }),
      dim: new _three.MeshBasicMaterial({
        color: dimColor,
        side: _three.DoubleSide
      }),
      oriented: orientedMaterial,
      ignored: ignoredMaterial,
      invisible: invisibleMaterial
    };
    this.hintStickerMaterial = {
      regular: new _three.MeshBasicMaterial({
        color,
        side: _three.BackSide
      }),
      dim: new _three.MeshBasicMaterial({
        color: dimColor,
        side: _three.BackSide,
        transparent: true,
        opacity: 0.75
      }),
      oriented: orientedMaterialHint,
      ignored: ignoredMaterialHint,
      invisible: invisibleMaterial
    };
  }

}

const axesInfo = [new AxisInfo(new _three.Vector3(0, 1, 0), new _three.Euler(-_TAU.TAU / 4, 0, 0), 0xffffff, 0xdddddd), new AxisInfo(new _three.Vector3(-1, 0, 0), new _three.Euler(0, -_TAU.TAU / 4, 0), 0xff8800, 0x884400), new AxisInfo(new _three.Vector3(0, 0, 1), new _three.Euler(0, 0, 0), 0x00ff00, 0x008800), new AxisInfo(new _three.Vector3(1, 0, 0), new _three.Euler(0, _TAU.TAU / 4, 0), 0xff0000, 0x660000), new AxisInfo(new _three.Vector3(0, 0, -1), new _three.Euler(0, _TAU.TAU / 2, 0), 0x0000ff, 0x000088), new AxisInfo(new _three.Vector3(0, -1, 0), new _three.Euler(_TAU.TAU / 4, 0, 0), 0xffff00, 0x888800)];
const face = {
  U: 0,
  L: 1,
  F: 2,
  R: 3,
  B: 4,
  D: 5
};
const familyToAxis = {
  U: face.U,
  u: face.U,
  Uw: face.U,
  y: face.U,
  L: face.L,
  l: face.L,
  Lw: face.L,
  M: face.L,
  F: face.F,
  f: face.F,
  Fw: face.F,
  S: face.F,
  z: face.F,
  R: face.R,
  r: face.R,
  Rw: face.R,
  x: face.R,
  B: face.B,
  b: face.B,
  Bw: face.B,
  D: face.D,
  d: face.D,
  Dw: face.D,
  E: face.D
};
const cubieDimensions = {
  stickerWidth: 0.85,
  stickerElevation: 0.503,
  foundationWidth: 1,
  hintStickerElevation: 1.45
};
const EXPERIMENTAL_PICTURE_CUBE_HINT_ELEVATION = 2;
/** @deprecated */

function experimentalSetDefaultStickerElevation(stickerElevation) {
  cubieDimensions.stickerElevation = stickerElevation;
}

const cube3DOptionsDefaults = {
  showMainStickers: true,
  hintFacelets: "floating",
  showFoundation: true,
  experimentalStickering: "full"
}; // TODO: Make internal foundation faces one-sided, facing to the outside of the cube.

const blackMesh = new _three.MeshBasicMaterial({
  color: 0x000000,
  opacity: 1,
  transparent: true
});
const blackTranslucentMesh = new _three.MeshBasicMaterial({
  color: 0x000000,
  opacity: 0.3,
  transparent: true
});

class CubieDef {
  // stickerFaceNames can be e.g. ["U", "F", "R"], "UFR" if every face is a single letter.
  constructor(orbit, stickerFaceNames, q) {
    this.orbit = orbit;
    (0, _defineProperty2.default)(this, "matrix", void 0);
    (0, _defineProperty2.default)(this, "stickerFaces", void 0);
    const individualStickerFaceNames = typeof stickerFaceNames === "string" ? stickerFaceNames.split("") : stickerFaceNames;
    this.stickerFaces = individualStickerFaceNames.map(s => face[s]);
    this.matrix = new _three.Matrix4();
    this.matrix.setPosition(firstPiecePosition[orbit]);
    this.matrix.premultiply(new _three.Matrix4().makeRotationFromQuaternion(q));
  }

}

function t(v, t4) {
  return new _three.Quaternion().setFromAxisAngle(v, _TAU.TAU * t4 / 4);
}

const r = {
  O: new _three.Vector3(0, 0, 0),
  U: new _three.Vector3(0, -1, 0),
  L: new _three.Vector3(1, 0, 0),
  F: new _three.Vector3(0, 0, -1),
  R: new _three.Vector3(-1, 0, 0),
  B: new _three.Vector3(0, 0, 1),
  D: new _three.Vector3(0, 1, 0)
};
const firstPiecePosition = {
  EDGES: new _three.Vector3(0, 1, 1),
  CORNERS: new _three.Vector3(1, 1, 1),
  CENTERS: new _three.Vector3(0, 1, 0)
};
const orientationRotation = {
  EDGES: [0, 1].map(i => new _three.Matrix4().makeRotationAxis(firstPiecePosition.EDGES.clone().normalize(), -i * _TAU.TAU / 2)),
  CORNERS: [0, 1, 2].map(i => new _three.Matrix4().makeRotationAxis(firstPiecePosition.CORNERS.clone().normalize(), -i * _TAU.TAU / 3)),
  CENTERS: [0, 1, 2, 3].map(i => new _three.Matrix4().makeRotationAxis(firstPiecePosition.CENTERS.clone().normalize(), -i * _TAU.TAU / 4))
};
const cubieStickerOrder = [face.U, face.F, face.R];
const pieceDefs = {
  EDGES: [new CubieDef("EDGES", "UF", t(r.O, 0)), new CubieDef("EDGES", "UR", t(r.U, 3)), new CubieDef("EDGES", "UB", t(r.U, 2)), new CubieDef("EDGES", "UL", t(r.U, 1)), new CubieDef("EDGES", "DF", t(r.F, 2)), new CubieDef("EDGES", "DR", t(r.F, 2).premultiply(t(r.D, 1))), new CubieDef("EDGES", "DB", t(r.F, 2).premultiply(t(r.D, 2))), new CubieDef("EDGES", "DL", t(r.F, 2).premultiply(t(r.D, 3))), new CubieDef("EDGES", "FR", t(r.U, 3).premultiply(t(r.R, 3))), new CubieDef("EDGES", "FL", t(r.U, 1).premultiply(t(r.R, 3))), new CubieDef("EDGES", "BR", t(r.U, 3).premultiply(t(r.R, 1))), new CubieDef("EDGES", "BL", t(r.U, 1).premultiply(t(r.R, 1)))],
  CORNERS: [new CubieDef("CORNERS", "UFR", t(r.O, 0)), new CubieDef("CORNERS", "URB", t(r.U, 3)), new CubieDef("CORNERS", "UBL", t(r.U, 2)), new CubieDef("CORNERS", "ULF", t(r.U, 1)), new CubieDef("CORNERS", "DRF", t(r.F, 2).premultiply(t(r.D, 1))), new CubieDef("CORNERS", "DFL", t(r.F, 2).premultiply(t(r.D, 0))), new CubieDef("CORNERS", "DLB", t(r.F, 2).premultiply(t(r.D, 3))), new CubieDef("CORNERS", "DBR", t(r.F, 2).premultiply(t(r.D, 2)))],
  CENTERS: [new CubieDef("CENTERS", "U", t(r.O, 0)), new CubieDef("CENTERS", "L", t(r.R, 3).premultiply(t(r.U, 1))), new CubieDef("CENTERS", "F", t(r.R, 3)), new CubieDef("CENTERS", "R", t(r.R, 3).premultiply(t(r.D, 1))), new CubieDef("CENTERS", "B", t(r.R, 3).premultiply(t(r.D, 2))), new CubieDef("CENTERS", "D", t(r.R, 2))]
};
const CUBE_SCALE = 1 / 3;
// TODO: Compatibility with Randelshofer or standard net layout? Offer a
// conversion function?
const pictureStickerCoords = {
  EDGES: [[[0, 4, 6], [0, 4, 5]], [[3, 5, 7], [0, 7, 5]], [[2, 4, 8], [0, 10, 5]], [[1, 3, 7], [0, 1, 5]], [[2, 4, 2], [2, 4, 3]], [[3, 5, 1], [2, 7, 3]], [[2, 4, 2], [2, 10, 3]], [[1, 3, 1], [2, 1, 3]], [[3, 5, 4], [3, 6, 4]], [[1, 3, 4], [1, 2, 4]], [[1, 9, 4], [1, 8, 4]], [[3, 11, 4], [3, 0, 4]]],
  CORNERS: [[[0, 5, 6], [0, 5, 5], [0, 6, 5]], [[3, 5, 8], [0, 8, 5], [0, 9, 5]], [[2, 3, 8], [0, 11, 5], [0, 0, 5]], [[1, 3, 6], [0, 2, 5], [0, 3, 5]], [[3, 5, 2], [2, 6, 3], [2, 5, 3]], [[2, 3, 2], [2, 3, 3], [2, 2, 3]], [[1, 3, 0], [2, 0, 3], [2, 11, 3]], [[0, 5, 0], [2, 9, 3], [2, 8, 3]]],
  CENTERS: [[[0, 4, 7]], [[0, 1, 4]], [[0, 4, 4]], [[0, 7, 4]], [[0, 10, 4]], [[0, 4, 1]]]
};
let sharedCubieFoundationGeometryCache = null;

function sharedCubieFoundationGeometry() {
  var _sharedCubieFoundatio;

  return (_sharedCubieFoundatio = sharedCubieFoundationGeometryCache) !== null && _sharedCubieFoundatio !== void 0 ? _sharedCubieFoundatio : sharedCubieFoundationGeometryCache = new _three.BoxGeometry(cubieDimensions.foundationWidth, cubieDimensions.foundationWidth, cubieDimensions.foundationWidth);
}

function newStickerGeometry() {
  const r = new _three.BufferGeometry();
  const half = 0.5 * cubieDimensions.stickerWidth;
  r.setAttribute("position", new _three.BufferAttribute(new Float32Array([half, half, 0, -half, half, 0, half, -half, 0, -half, half, 0, -half, -half, 0, half, -half, 0]), 3));
  r.setAttribute("uv", new _three.BufferAttribute(new Float32Array([1, 1, 0, 1, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 1, 0, 1, 1]), 2)); //  r.setAttribute('normals', new BufferAttribute(new Float32Array([0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1]), 3));

  return r;
}

let sharedStickerGeometryCache = null;

function sharedStickerGeometry() {
  var _sharedStickerGeometr;

  return (_sharedStickerGeometr = sharedStickerGeometryCache) !== null && _sharedStickerGeometr !== void 0 ? _sharedStickerGeometr : sharedStickerGeometryCache = newStickerGeometry();
} // TODO: Split into "scene model" and "view".


class Cube3D extends _three.Object3D {
  // TODO: Keep track of option-based meshes better.
  constructor(def, cursor, scheduleRenderCallback, options = {}) {
    super();
    this.def = def;
    this.scheduleRenderCallback = scheduleRenderCallback;
    (0, _defineProperty2.default)(this, "kpuzzleFaceletInfo", void 0);
    (0, _defineProperty2.default)(this, "pieces", {});
    (0, _defineProperty2.default)(this, "options", void 0);
    (0, _defineProperty2.default)(this, "experimentalHintStickerMeshes", []);
    (0, _defineProperty2.default)(this, "experimentalFoundationMeshes", []);
    (0, _defineProperty2.default)(this, "setSpriteURL", void 0);
    (0, _defineProperty2.default)(this, "sprite", new Promise(resolve => {
      this.setSpriteURL = url => {
        svgLoader.load(url, resolve);
      };
    }));
    (0, _defineProperty2.default)(this, "setHintSpriteURL", void 0);
    (0, _defineProperty2.default)(this, "hintSprite", new Promise(resolve => {
      this.setHintSpriteURL = url => {
        svgLoader.load(url, resolve);
      };
    }));
    this.options = { ...cube3DOptionsDefaults
    };
    Object.assign(this.options, options); // TODO: check if this works

    if (this.def.name !== "3x3x3") {
      throw new Error(`Invalid puzzle for this Cube3D implementation: ${this.def.name}`);
    }

    this.kpuzzleFaceletInfo = {};

    for (const orbit in pieceDefs) {
      const orbitFaceletInfo = [];
      this.kpuzzleFaceletInfo[orbit] = orbitFaceletInfo;
      this.pieces[orbit] = pieceDefs[orbit].map(this.createCubie.bind(this, orbit, orbitFaceletInfo));
    }

    this.scale.set(CUBE_SCALE, CUBE_SCALE, CUBE_SCALE); // TODO: Can we construct this directly instead of applying it later? Would that be more code-efficient?

    if (this.options.experimentalStickering) {
      this.setStickering(this.options.experimentalStickering);
    }

    cursor === null || cursor === void 0 ? void 0 : cursor.addPositionListener(this);
  } // Can only be called once.

  /** @deprecated */


  experimentalSetStickerSpriteURL(stickerSpriteURL) {
    this.setSpriteURL(stickerSpriteURL);
  } // Can only be called once.

  /** @deprecated */


  experimentalSetHintStickerSpriteURL(hintStickerSpriteURL) {
    this.setHintSpriteURL(hintStickerSpriteURL);
  }

  setStickering(stickering) {
    // TODO
    (async () => {
      // TODO
      const appearance = await _puzzles.puzzles["3x3x3"].appearance(stickering !== null && stickering !== void 0 ? stickering : "full");
      this.setAppearance(appearance !== null && appearance !== void 0 ? appearance : await _puzzles.puzzles["3x3x3"].appearance("full"));
    })();
  }

  setAppearance(appearance) {
    for (const [orbitName, orbitAppearance] of Object.entries(appearance.orbits)) {
      for (let pieceIdx = 0; pieceIdx < orbitAppearance.pieces.length; pieceIdx++) {
        const pieceAppearance = orbitAppearance.pieces[pieceIdx];

        if (pieceAppearance) {
          const pieceInfo = this.kpuzzleFaceletInfo[orbitName][pieceIdx];

          for (let faceletIdx = 0; faceletIdx < pieceInfo.length; faceletIdx++) {
            const faceletAppearance = pieceAppearance.facelets[faceletIdx];

            if (faceletAppearance) {
              var _faceletAppearance$hi;

              const faceletInfo = pieceInfo[faceletIdx];
              const appearance = typeof faceletAppearance === "string" ? faceletAppearance : faceletAppearance === null || faceletAppearance === void 0 ? void 0 : faceletAppearance.appearance;
              faceletInfo.facelet.material = axesInfo[faceletInfo.faceIdx].stickerMaterial[appearance]; // TODO

              const hintAppearance = typeof faceletAppearance === "string" ? appearance : (_faceletAppearance$hi = faceletAppearance.hintAppearance) !== null && _faceletAppearance$hi !== void 0 ? _faceletAppearance$hi : appearance;

              if (faceletInfo.hintFacelet) {
                faceletInfo.hintFacelet.material = axesInfo[faceletInfo.faceIdx].hintStickerMaterial[hintAppearance];
              }
            }
          }
        }
      }
    }

    if (this.scheduleRenderCallback) {
      this.scheduleRenderCallback();
    }
  }
  /** @deprecated */


  experimentalUpdateOptions(options) {
    if ("showMainStickers" in options) {
      throw new Error("Unimplemented");
    }

    const showFoundation = options.showFoundation;

    if (typeof showFoundation !== "undefined" && this.options.showFoundation !== showFoundation) {
      this.options.showFoundation = showFoundation;

      for (const foundation of this.experimentalFoundationMeshes) {
        foundation.visible = showFoundation;
      }
    }

    const hintFacelets = options.hintFacelets;

    if (typeof hintFacelets !== "undefined" && this.options.hintFacelets !== hintFacelets && _TwistyPlayerConfig.hintFaceletStyles[hintFacelets] // TODO: test this
    ) {
        this.options.hintFacelets = hintFacelets;

        for (const hintSticker of this.experimentalHintStickerMeshes) {
          hintSticker.visible = hintFacelets === "floating";
        }

        this.scheduleRenderCallback(); // TODO
      }

    const experimentalStickering = options.experimentalStickering;

    if (typeof experimentalStickering !== "undefined" && this.options.experimentalStickering !== experimentalStickering && _TwistyPlayerConfig.experimentalStickerings[experimentalStickering] // TODO: test this
    ) {
        this.options.experimentalStickering = experimentalStickering; // TODO
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore

        this.setStickering(experimentalStickering);
        this.scheduleRenderCallback(); // TODO
      }
  }

  onPositionChange(p) {
    const reid333 = p.state;

    for (const orbit in pieceDefs) {
      const pieces = pieceDefs[orbit];

      for (let i = 0; i < pieces.length; i++) {
        const j = reid333[orbit].permutation[i];
        this.pieces[orbit][j].matrix.copy(pieceDefs[orbit][i].matrix);
        this.pieces[orbit][j].matrix.multiply(orientationRotation[orbit][reid333[orbit].orientation[i]]);
      }

      for (const moveProgress of p.movesInProgress) {
        const move = moveProgress.move;
        const turnNormal = axesInfo[familyToAxis[move.family]].vector;
        const moveMatrix = new _three.Matrix4().makeRotationAxis(turnNormal, -this.ease(moveProgress.fraction) * moveProgress.direction * move.effectiveAmount * _TAU.TAU / 4);

        for (let i = 0; i < pieces.length; i++) {
          const k = this.def.moves[move.family][orbit].permutation[i];

          if (i !== k || this.def.moves[move.family][orbit].orientation[i] !== 0) {
            const j = reid333[orbit].permutation[i];
            this.pieces[orbit][j].matrix.premultiply(moveMatrix);
          }
        }
      }
    }

    this.scheduleRenderCallback();
  } // TODO: Always create (but sometimes hide parts) so we can show them later,
  // or (better) support creating puzzle parts on demand.


  createCubie(orbit, orbitFacelets, piece, orbitPieceIdx) {
    const cubieFaceletInfo = [];
    orbitFacelets.push(cubieFaceletInfo);
    const cubie = new _three.Group();

    if (this.options.showFoundation) {
      const foundation = this.createCubieFoundation();
      cubie.add(foundation);
      this.experimentalFoundationMeshes.push(foundation);
    }

    for (let i = 0; i < piece.stickerFaces.length; i++) {
      const sticker = this.createSticker(axesInfo[cubieStickerOrder[i]], axesInfo[piece.stickerFaces[i]], false);
      const faceletInfo = {
        faceIdx: piece.stickerFaces[i],
        facelet: sticker
      };
      cubie.add(sticker);

      if (this.options.hintFacelets === "floating") {
        const hintSticker = this.createSticker(axesInfo[cubieStickerOrder[i]], axesInfo[piece.stickerFaces[i]], true);
        cubie.add(hintSticker);
        faceletInfo.hintFacelet = hintSticker;
        this.experimentalHintStickerMeshes.push(hintSticker);
      }

      if (this.options.experimentalStickering === "picture" && pictureStickerCoords[orbit] && pictureStickerCoords[orbit][orbitPieceIdx] && pictureStickerCoords[orbit][orbitPieceIdx][i]) {
        const [rotate, offsetX, offsetY] = pictureStickerCoords[orbit][orbitPieceIdx][i];

        (async () => {
          const addImageSticker = async hint => {
            const texture = await (hint ? this.hintSprite : this.sprite);
            const mesh = this.createSticker(axesInfo[cubieStickerOrder[i]], axesInfo[piece.stickerFaces[i]], hint);
            mesh.material = new _three.MeshBasicMaterial({
              map: texture,
              side: hint ? _three.BackSide : _three.DoubleSide,
              transparent: true
            });
            const x1 = offsetX / 12;
            const x2 = (offsetX + 1) / 12;
            const y1 = offsetY / 9;
            const y2 = (offsetY + 1) / 9;
            let v1 = new _three.Vector2(x1, y1);
            let v2 = new _three.Vector2(x1, y2);
            let v3 = new _three.Vector2(x2, y2);
            let v4 = new _three.Vector2(x2, y1);

            switch (rotate) {
              case 1:
                [v1, v2, v3, v4] = [v2, v3, v4, v1];
                break;

              case 2:
                [v1, v2, v3, v4] = [v3, v4, v1, v2];
                break;

              case 3:
                [v1, v2, v3, v4] = [v4, v1, v2, v3];
                break;
            }

            mesh.geometry.setAttribute("uv", new _three.BufferAttribute(new Float32Array([v3.x, v3.y, v2.x, v2.y, v4.x, v4.y, v2.x, v2.y, v1.x, v1.y, v4.x, v4.y]), 2));
            cubie.add(mesh);
          }; // const delay: number = ({
          //   CENTERS: 1000,
          //   EDGES: 2000,
          //   CORNERS: 3500,
          // } as Record<string, number>)[orbit];
          // if (orbit === "CENTERS" && orbitPieceIdx === 5) {


          addImageSticker(true);
          addImageSticker(false); // } else {
          //   await this.sprite;
          //   await this.hintSprite;
          //   setTimeout(
          //     () => addImageSticker(true),
          //     delay + orbitPieceIdx * 100,
          //   );
          //   setTimeout(
          //     () => addImageSticker(false),
          //     delay + orbitPieceIdx * 100,
          //   );
          // }
        })();
      }

      cubieFaceletInfo.push(faceletInfo);
    }

    cubie.matrix.copy(piece.matrix);
    cubie.matrixAutoUpdate = false;
    this.add(cubie);
    return cubie;
  } // TODO: Support creating only the outward-facing parts?


  createCubieFoundation() {
    const box = sharedCubieFoundationGeometry();
    return new _three.Mesh(box, this.options.experimentalStickering === "picture" ? blackMesh : blackTranslucentMesh);
  }

  createSticker(posAxisInfo, materialAxisInfo, isHint) {
    const geo = this.options.experimentalStickering === "picture" ? newStickerGeometry() : sharedStickerGeometry();
    const stickerMesh = new _three.Mesh(geo, isHint ? materialAxisInfo.hintStickerMaterial.regular : materialAxisInfo.stickerMaterial.regular);
    stickerMesh.setRotationFromEuler(posAxisInfo.fromZ);
    stickerMesh.position.copy(posAxisInfo.vector);
    stickerMesh.position.multiplyScalar(isHint ? this.options.experimentalStickering === "picture" ? EXPERIMENTAL_PICTURE_CUBE_HINT_ELEVATION : cubieDimensions.hintStickerElevation : cubieDimensions.stickerElevation);
    return stickerMesh;
  }
  /** @deprecated */


  experimentalSetFoundationOpacity(opacity) {
    this.experimentalFoundationMeshes[0].material.opacity = opacity;
  }
  /** @deprecated */


  experimentalSetStickerWidth(width) {
    for (const orbitInfo of Object.values(this.kpuzzleFaceletInfo)) {
      for (const pieceInfo of orbitInfo) {
        for (const faceletInfo of pieceInfo) {
          faceletInfo.facelet.scale.setScalar(width / cubieDimensions.stickerWidth); // faceletInfo.facelet.setRotationFromAxisAngle(new Vector3(0, 1, 0), 0);
          // faceletInfo.facelet.rotateOnAxis(new Vector3(1, 0, 1), TAU / 6);
        }
      }
    }
  }
  /** @deprecated */


  experimentalSetCenterStickerWidth(width) {
    for (const orbitInfo of [this.kpuzzleFaceletInfo["CENTERS"]]) {
      for (const pieceInfo of orbitInfo) {
        for (const faceletInfo of pieceInfo) {
          faceletInfo.facelet.scale.setScalar(width / cubieDimensions.stickerWidth); // faceletInfo.facelet.setRotationFromAxisAngle(new Vector3(0, 1, 0), 0);
          // faceletInfo.facelet.rotateOnAxis(new Vector3(1, 0, 1), TAU / 6);
        }
      }
    }
  }

  ease(fraction) {
    return (0, _easing.smootherStep)(fraction);
  }

}

exports.Cube3D = Cube3D;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","three":"65WY3","../../../puzzles":"KrRHt","../../animation/easing":"214fW","../../dom/TwistyPlayerConfig":"4DCsT","../TAU":"7I9Z6"}],"214fW":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.smootherStep = smootherStep;

function smootherStep(x) {
  return x * x * x * (10 - x * (15 - 6 * x));
}
},{}],"7I9Z6":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.TAU = void 0;
const TAU = Math.PI * 2;
exports.TAU = TAU;
},{}],"5NdrU":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.PG3D = void 0;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _three = require("three");

var _kpuzzle = require("../../../kpuzzle");

var _puzzles = require("../../../puzzles");

var _easing = require("../../animation/easing");

var _TAU = require("../TAU");

const foundationMaterial = new _three.MeshBasicMaterial({
  side: _three.DoubleSide,
  color: 0x000000 // transparency doesn't work very well here
  // with duplicated center stickers
  //  transparent: true,
  //  opacity: 0.75,

});
const stickerMaterial = new _three.MeshBasicMaterial({
  vertexColors: true //    side: DoubleSide,

});
const polyMaterial = new _three.MeshBasicMaterial({
  visible: false
});

class Filler {
  constructor(sz, colored = true) {
    this.sz = sz;
    this.colored = colored;
    (0, _defineProperty2.default)(this, "pos", void 0);
    (0, _defineProperty2.default)(this, "ipos", void 0);
    (0, _defineProperty2.default)(this, "vertices", void 0);
    (0, _defineProperty2.default)(this, "colors", void 0);
    (0, _defineProperty2.default)(this, "ind", void 0);
    this.vertices = new Float32Array(9 * sz);

    if (colored) {
      this.colors = new Uint8Array(9 * sz);
      this.ind = new Uint8Array(sz);
    }

    this.pos = 0;
    this.ipos = 0;
  }

  add(pt, c) {
    this.vertices[this.pos] = pt[0];
    this.vertices[this.pos + 1] = pt[1];
    this.vertices[this.pos + 2] = pt[2];
    this.colors[this.pos] = c >> 16;
    this.colors[this.pos + 1] = c >> 8 & 255;
    this.colors[this.pos + 2] = c & 255;
    this.pos += 3;
  }

  addUncolored(pt) {
    this.vertices[this.pos] = pt[0];
    this.vertices[this.pos + 1] = pt[1];
    this.vertices[this.pos + 2] = pt[2];
    this.pos += 3;
  }

  setind(i) {
    this.ind[this.ipos++] = i;
  }

  setAttributes(geo) {
    geo.setAttribute("position", new _three.BufferAttribute(this.vertices, 3));

    if (this.colored) {
      geo.setAttribute("color", new _three.BufferAttribute(this.colors, 3, true));
    }
  }

  makeGroups(geo) {
    geo.clearGroups();

    for (let i = 0; i < this.ipos;) {
      const si = i++;
      const iv = this.ind[si];

      while (this.ind[i] === iv) {
        i++;
      }

      geo.addGroup(3 * si, 3 * (i - si), iv);
    }
  }

}

function makePoly(filler, coords, color, scale, ind, faceArray) {
  let ncoords = coords;

  if (scale !== 1) {
    ncoords = [];

    for (const v of coords) {
      const v2 = [v[0] * scale, v[1] * scale, v[2] * scale];
      ncoords.push(v2);
    }
  }

  for (let g = 1; g + 1 < ncoords.length; g++) {
    faceArray.push(filler.ipos);
    filler.add(ncoords[0], color);
    filler.add(ncoords[g], color);
    filler.add(ncoords[g + 1], color);
    filler.setind(ind);
  }
}

class StickerDef {
  constructor(filler, stickerDat, hintStickers, options) {
    this.filler = filler;
    (0, _defineProperty2.default)(this, "origColor", void 0);
    (0, _defineProperty2.default)(this, "origColorAppearance", void 0);
    (0, _defineProperty2.default)(this, "faceColor", void 0);
    (0, _defineProperty2.default)(this, "faceArray", []);
    (0, _defineProperty2.default)(this, "twistVal", -1);
    const sdColor = new _three.Color(stickerDat.color).getHex();
    this.origColor = sdColor;
    this.origColorAppearance = sdColor;

    if (options === null || options === void 0 ? void 0 : options.appearance) {
      this.setAppearance(options.appearance);
    }

    this.faceColor = sdColor;
    const coords = stickerDat.coords;
    makePoly(filler, coords, this.faceColor, 1, 0, this.faceArray);

    if (hintStickers) {
      let highArea = 0;
      let goodFace = null;

      for (const f of this.faceArray) {
        const t = new _three.Triangle(new _three.Vector3(filler.vertices[9 * f], filler.vertices[9 * f + 1], filler.vertices[9 * f + 2]), new _three.Vector3(filler.vertices[9 * f + 3], filler.vertices[9 * f + 4], filler.vertices[9 * f + 5]), new _three.Vector3(filler.vertices[9 * f + 6], filler.vertices[9 * f + 7], filler.vertices[9 * f + 8]));
        const a = t.getArea();

        if (a > highArea) {
          highArea = a;
          goodFace = t;
        }
      }

      const norm = new _three.Vector3();
      goodFace.getNormal(norm);
      norm.multiplyScalar(0.5);
      const hintCoords = [];

      for (let i = 0; i < coords.length; i++) {
        const j = coords.length - 1 - i;
        hintCoords.push([coords[j][0] + norm.x, coords[j][1] + norm.y, coords[j][2] + norm.z]);
      }

      makePoly(filler, hintCoords, this.faceColor, 1, 0, this.faceArray);
    }
  }

  addFoundation(filler, foundationDat, black) {
    makePoly(filler, foundationDat.coords, black, 0.999, 2, this.faceArray);
  }

  setAppearance(faceletMeshAppearance) {
    switch (faceletMeshAppearance) {
      case "regular":
        this.origColorAppearance = this.origColor;
        break;

      case "dim":
        if (this.origColor === 0xffffff) {
          this.origColorAppearance = 0xdddddd;
        } else {
          this.origColorAppearance = new _three.Color(this.origColor).multiplyScalar(0.5).getHex();
        }

        break;

      case "oriented":
        this.origColorAppearance = 0xff88ff;
        break;

      case "ignored":
        this.origColorAppearance = 0x444444;
        break;

      case "invisible":
        throw new Error("unimplemented");
    }
  }

  setColor(c) {
    if (this.faceColor !== c) {
      this.faceColor = c;
      const r = c >> 16;
      const g = c >> 8 & 255;
      const b = c & 255;

      for (const f of this.faceArray) {
        for (let i = 0; i < 9; i += 3) {
          this.filler.colors[9 * f + i] = r;
          this.filler.colors[9 * f + i + 1] = g;
          this.filler.colors[9 * f + i + 2] = b;
        }
      }

      return 1;
    } else {
      return 0;
    }
  }

}

class HitPlaneDef {
  constructor(hitface) {
    (0, _defineProperty2.default)(this, "cubie", void 0);
    (0, _defineProperty2.default)(this, "geo", void 0);
    this.cubie = new _three.Group();
    const coords = hitface.coords;
    const filler = new Filler(coords.length - 2, true);

    for (let g = 1; g + 1 < coords.length; g++) {
      filler.addUncolored(coords[0]);
      filler.addUncolored(coords[g]);
      filler.addUncolored(coords[g + 1]);
    }

    this.geo = new _three.BufferGeometry();
    filler.setAttributes(this.geo);
    const obj = new _three.Mesh(this.geo, polyMaterial);
    obj.userData.name = hitface.name;
    this.cubie.scale.setScalar(0.99);
    this.cubie.add(obj);
  }

}

class AxisInfo {
  constructor(axisDat) {
    (0, _defineProperty2.default)(this, "axis", void 0);
    (0, _defineProperty2.default)(this, "order", void 0);
    const vec = axisDat[0];
    this.axis = new _three.Vector3(vec[0], vec[1], vec[2]);
    this.order = axisDat[2];
  }

}

const PG_SCALE = 0.5; // TODO: Split into "scene model" and "view".

/*
 *  PG3D uses a single geometry for the puzzle, with all the faces for
 *  each sticker (including the foundation stickers) in a single
 *  geometry.  We use the materialIndex in the face to point to a
 *  specific entry, which is either a colored sticker, invisible, or
 *  black (foundation).
 *
 *  To support general twisting of a subset of the puzzle, we then
 *  instantiate this same geometry in two different meshes with two
 *  distinct material arrays.  One, the fixed mesh, has the material
 *  array set up like:  [colored, invisible, black, invisible].
 *  The twisting mesh has the material array set up as
 *  [invisible, colored, invislble, black].  When not twisted, the
 *  two meshes are directly coincident, and the (shared) materialIndex
 *  in each face points to a non-invisible material in exactly one of
 *  the two meshes.  When we decide to twist some cubies, we make
 *  the cubies that move point to visible materials in the moving
 *  mesh (which makes them point to invisible materials in the static
 *  mesh).  This way, we only need to rotate the moving mesh as a
 *  single object---this should be very fast, and occur entirely in
 *  the GPU.  Unfortunately this doesn't quite work as fast as we'd
 *  like because three.js makes a draw call every time we have a change
 *  in the material index.  By moving the foundation triangles separate
 *  from the sticker triangles, we enhance the probability that many
 *  triangles can be rendered in one call speeding up the render.
 *
 *  When we decide to support multiple subsets moving at distinct
 *  angular velocities, we will use more than two meshes, with
 *  larger material arrays, maintaining the invariant that each cubie
 *  is visible in only a single mesh.
 */

var _pendingStickeringUpdate = new WeakMap();

class PG3D extends _three.Object3D {
  // before this: colored; after: black
  constructor(cursor, scheduleRenderCallback, definition, pgdat, showFoundation = false, hintStickers = false, params = {}) {
    super();
    this.scheduleRenderCallback = scheduleRenderCallback;
    this.definition = definition;
    this.pgdat = pgdat;
    this.params = params;
    (0, _defineProperty2.default)(this, "stickers", void 0);
    (0, _defineProperty2.default)(this, "axesInfo", void 0);
    (0, _defineProperty2.default)(this, "stickerTargets", []);
    (0, _defineProperty2.default)(this, "controlTargets", []);
    (0, _defineProperty2.default)(this, "movingObj", void 0);
    (0, _defineProperty2.default)(this, "filler", void 0);
    (0, _defineProperty2.default)(this, "foundationBound", void 0);
    (0, _defineProperty2.default)(this, "fixedGeo", void 0);
    (0, _defineProperty2.default)(this, "lastPos", void 0);
    (0, _defineProperty2.default)(this, "lastMove", void 0);

    _pendingStickeringUpdate.set(this, {
      writable: true,
      value: false
    });

    this.axesInfo = {};
    const axesDef = this.pgdat.axis;

    for (const axis of axesDef) {
      this.axesInfo[axis[1]] = new AxisInfo(axis);
    }

    const stickers = this.pgdat.stickers;
    this.stickers = {};
    const materialArray1 = [stickerMaterial, polyMaterial, foundationMaterial, polyMaterial];
    const materialArray2 = [polyMaterial, stickerMaterial, polyMaterial, foundationMaterial];
    let triangleCount = 0;
    let multiplier = 1;

    if (hintStickers) {
      multiplier++;
    }

    if (showFoundation) {
      multiplier++;
    }

    for (let si = 0; si < stickers.length; si++) {
      const sides = stickers[si].coords.length;
      triangleCount += multiplier * (sides - 2);
    }

    const filler = new Filler(triangleCount);
    const black = 0;

    for (let si = 0; si < stickers.length; si++) {
      const sticker = stickers[si];
      const orbit = sticker.orbit;
      const ord = sticker.ord;
      const ori = sticker.ori;

      if (!this.stickers[orbit]) {
        this.stickers[orbit] = [];
      }

      if (!this.stickers[orbit][ori]) {
        this.stickers[orbit][ori] = [];
      }

      const options = {};

      if (params.appearance) {
        options.appearance = (0, _puzzles.experimentalGetFaceletAppearance)(params.appearance, orbit, ord, ori, false);
      }

      const stickerdef = new StickerDef(filler, sticker, hintStickers, options);
      this.stickers[orbit][ori][ord] = stickerdef;
    }

    this.foundationBound = filler.ipos;

    if (showFoundation) {
      for (let si = 0; si < stickers.length; si++) {
        const sticker = stickers[si];
        const foundation = this.pgdat.foundations[si];
        const orbit = sticker.orbit;
        const ord = sticker.ord;
        const ori = sticker.ori;
        this.stickers[orbit][ori][ord].addFoundation(filler, foundation, black);
      }
    }

    const fixedGeo = new _three.BufferGeometry();
    filler.setAttributes(fixedGeo);
    filler.makeGroups(fixedGeo);
    const obj = new _three.Mesh(fixedGeo, materialArray1);
    obj.scale.set(PG_SCALE, PG_SCALE, PG_SCALE);
    this.add(obj);
    const obj2 = new _three.Mesh(fixedGeo, materialArray2);
    obj2.scale.set(PG_SCALE, PG_SCALE, PG_SCALE);
    this.add(obj2);
    const hitfaces = this.pgdat.faces;
    this.movingObj = obj2;
    this.fixedGeo = fixedGeo;
    this.filler = filler;

    for (const hitface of hitfaces) {
      const facedef = new HitPlaneDef(hitface);
      facedef.cubie.scale.set(PG_SCALE, PG_SCALE, PG_SCALE);
      this.add(facedef.cubie);
      this.controlTargets.push(facedef.cubie.children[0]);
    }

    cursor.addPositionListener(this);
  }

  dispose() {
    if (this.fixedGeo) {
      this.fixedGeo.dispose();
    }
  }

  experimentalGetStickerTargets() {
    return this.stickerTargets;
  }

  experimentalGetControlTargets() {
    return this.controlTargets;
  }

  experimentalSetAppearance(appearance) {
    this.params.appearance = appearance;

    for (const orbitName in this.definition.orbits) {
      const {
        numPieces,
        orientations
      } = this.definition.orbits[orbitName];

      for (let pieceIdx = 0; pieceIdx < numPieces; pieceIdx++) {
        for (let faceletIdx = 0; faceletIdx < orientations; faceletIdx++) {
          const faceletAppearance = (0, _puzzles.experimentalGetFaceletAppearance)(appearance, orbitName, pieceIdx, faceletIdx, false);
          const stickerDef = this.stickers[orbitName][faceletIdx][pieceIdx];
          stickerDef.setAppearance(faceletAppearance);
        }
      }
    }

    if (this.scheduleRenderCallback) {
      (0, _classPrivateFieldSet2.default)(this, _pendingStickeringUpdate, true);
      this.onPositionChange(this.lastPos);
      this.scheduleRenderCallback();
    }
  }

  onPositionChange(p) {
    const state = p.state;
    const noRotation = new _three.Euler();
    this.movingObj.rotation.copy(noRotation);
    let colormods = 0;

    if (!this.lastPos || (0, _classPrivateFieldGet2.default)(this, _pendingStickeringUpdate) || !(0, _kpuzzle.areTransformationsEquivalent)(this.definition, this.lastPos.state, state)) {
      for (const orbit in this.stickers) {
        const pieces = this.stickers[orbit];
        const pos2 = state[orbit];
        const orin = pieces.length;

        if (orin === 1) {
          const pieces2 = pieces[0];

          for (let i = 0; i < pieces2.length; i++) {
            const ni = pos2.permutation[i];
            colormods += pieces2[i].setColor(pieces2[ni].origColorAppearance);
          }
        } else {
          for (let ori = 0; ori < orin; ori++) {
            const pieces2 = pieces[ori];

            for (let i = 0; i < pieces2.length; i++) {
              const nori = (ori + orin - pos2.orientation[i]) % orin;
              const ni = pos2.permutation[i];
              colormods += pieces2[i].setColor(pieces[nori][ni].origColorAppearance);
            }
          }
        }
      }

      this.lastPos = p;
      (0, _classPrivateFieldSet2.default)(this, _pendingStickeringUpdate, false);
    }

    let vismods = 0;

    for (const moveProgress of p.movesInProgress) {
      const externalMove = moveProgress.move; // TODO: unswizzle goes external to internal, and so does the call after that
      // and so does the stateForBlockMove call

      const unswizzled = this.pgdat.unswizzle(externalMove);
      const move = this.pgdat.notationMapper.notationToInternal(externalMove);

      if (move === null) {
        throw Error("Bad blockmove " + externalMove.family);
      }

      const quantumTransformation = (0, _kpuzzle.experimentalTransformationForQuantumMove)(this.definition, externalMove.quantum);
      const ax = this.axesInfo[unswizzled];
      const turnNormal = ax.axis;
      const angle = -this.ease(moveProgress.fraction) * moveProgress.direction * move.effectiveAmount * _TAU.TAU / ax.order;
      this.movingObj.rotateOnAxis(turnNormal, angle);

      if (this.lastMove !== quantumTransformation) {
        for (const orbit in this.stickers) {
          const pieces = this.stickers[orbit];
          const orin = pieces.length;
          const bmv = quantumTransformation[orbit];

          for (let ori = 0; ori < orin; ori++) {
            const pieces2 = pieces[ori];

            for (let i = 0; i < pieces2.length; i++) {
              const ni = bmv.permutation[i];
              let tv = 0;

              if (ni !== i || bmv.orientation[i] !== 0) {
                tv = 1;
              }

              if (tv !== pieces2[i].twistVal) {
                if (tv) {
                  for (const f of pieces2[i].faceArray) {
                    this.filler.ind[f] |= 1;
                  }
                } else {
                  for (const f of pieces2[i].faceArray) {
                    this.filler.ind[f] &= ~1;
                  }
                }

                pieces2[i].twistVal = tv;
                vismods++;
              }
            }
          }
        }

        this.lastMove = quantumTransformation;
      }
    }

    if (vismods) {
      this.filler.makeGroups(this.fixedGeo);
    }

    if (colormods) {
      this.fixedGeo.getAttribute("color").updateRange = {
        offset: 0,
        count: 9 * this.foundationBound
      };
      this.fixedGeo.getAttribute("color").needsUpdate = true;
    }

    this.scheduleRenderCallback();
  }

  ease(fraction) {
    return (0, _easing.smootherStep)(fraction);
  }

}

exports.PG3D = PG3D;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","@babel/runtime/helpers/defineProperty":"55mTs","three":"65WY3","../../../kpuzzle":"4ZRD3","../../../puzzles":"KrRHt","../../animation/easing":"214fW","../TAU":"7I9Z6"}],"2KiAH":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Twisty3DScene = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _three = require("three");

class Twisty3DScene extends _three.Scene {
  constructor() {
    super();
    (0, _defineProperty2.default)(this, "renderTargets", new Set());
    (0, _defineProperty2.default)(this, "twisty3Ds", new Set());
  }

  addRenderTarget(renderTarget) {
    this.renderTargets.add(renderTarget);
  }

  scheduleRender() {
    for (const renderTarget of this.renderTargets) {
      renderTarget.scheduleRender();
    }
  }

  addTwisty3DPuzzle(twisty3DPuzzle) {
    this.twisty3Ds.add(twisty3DPuzzle);
    this.add(twisty3DPuzzle); // TODO: scheduleRender?
  }

  removeTwisty3DPuzzle(twisty3DPuzzle) {
    this.twisty3Ds.delete(twisty3DPuzzle);
    this.remove(twisty3DPuzzle); // TODO: scheduleRender?
  }

  clearPuzzles() {
    for (const puz of this.twisty3Ds) {
      this.remove(puz);
    }

    this.twisty3Ds.clear(); // TODO: scheduleRender?
  }

}

exports.Twisty3DScene = Twisty3DScene;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","three":"65WY3"}],"1Dahd":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.AlgCursor = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _kpuzzle = require("../../../kpuzzle");

var _KPuzzleWrapper = require("../../3D/puzzles/KPuzzleWrapper");

var _TreeAlgIndexer = require("../indexer/tree/TreeAlgIndexer");

var _CursorTypes = require("./CursorTypes");

/* eslint-disable no-case-declarations */
// TODO: private vs. public properties/methods.
// TODO: optional construtor arguments for DOM elements
// TODO: figure out what can be moved into a worker using OffscreenCanvas https://developers.google.com/web/updates/2018/08/offscreen-canvas

/* eslint-disable @typescript-eslint/no-empty-interface */
// start of imports
class AlgCursor {
  // TODO: accessor instead of direct access
  constructor(timeline, def, alg, startStateAlg, // TODO: accept actual start state
  indexerConstructor) {
    this.timeline = timeline;
    this.def = def;
    this.alg = alg;
    (0, _defineProperty2.default)(this, "indexer", void 0);
    (0, _defineProperty2.default)(this, "positionListeners", new Set());
    (0, _defineProperty2.default)(this, "ksolvePuzzle", void 0);
    (0, _defineProperty2.default)(this, "startState", void 0);
    (0, _defineProperty2.default)(this, "indexerConstructor", _TreeAlgIndexer.TreeAlgIndexer);
    this.ksolvePuzzle = new _KPuzzleWrapper.KPuzzleWrapper(def);

    if (indexerConstructor) {
      this.indexerConstructor = this.indexerConstructor;
    }

    this.instantiateIndexer(alg);
    this.startState = startStateAlg ? this.algToState(startStateAlg) : this.ksolvePuzzle.startState();
    timeline.addTimestampListener(this);
  }

  setStartState(startState) {
    this.startState = startState;
    this.dispatchPositionForTimestamp(this.timeline.timestamp);
  }
  /** @deprecated */


  experimentalSetIndexer(indexerConstructor) {
    this.indexerConstructor = indexerConstructor;
    this.instantiateIndexer(this.alg);
    this.timeline.onCursorChange(this);
    this.dispatchPositionForTimestamp(this.timeline.timestamp);
  }

  instantiateIndexer(alg) {
    this.indexer = new this.indexerConstructor(this.ksolvePuzzle, alg);
  }
  /** @deprecated */


  algToState(s) {
    const kpuzzle = new _kpuzzle.KPuzzle(this.def);
    kpuzzle.applyAlg(s);
    return this.ksolvePuzzle.combine(this.def.startPieces, kpuzzle.state);
  }

  timeRange() {
    return {
      start: 0,
      end: this.indexer.algDuration()
    };
  }
  /** @deprecated */


  experimentalTimestampForStartOfLastMove() {
    const numMoves = this.indexer.numMoves();

    if (numMoves > 0) {
      return this.indexer.indexToMoveStartTimestamp(numMoves - 1);
    }

    return 0;
  }

  addPositionListener(positionListener) {
    this.positionListeners.add(positionListener);
    this.dispatchPositionForTimestamp(this.timeline.timestamp, [positionListener]); // TODO: should this be a separate dispatch, or should the listener manually ask for the position?
  }

  removePositionListener(positionListener) {
    this.positionListeners.delete(positionListener);
  }

  onTimelineTimestampChange(timestamp) {
    this.dispatchPositionForTimestamp(timestamp);
  }

  dispatchPositionForTimestamp(timestamp, listeners = this.positionListeners) {
    let position;

    if (this.indexer.timestampToPosition) {
      position = this.indexer.timestampToPosition(timestamp, this.startState);
    } else {
      const idx = this.indexer.timestampToIndex(timestamp);
      const state = this.indexer.stateAtIndex(idx, this.startState); // TODO

      position = {
        state,
        movesInProgress: []
      };

      if (this.indexer.numMoves() > 0) {
        const fraction = (timestamp - this.indexer.indexToMoveStartTimestamp(idx)) / this.indexer.moveDuration(idx);

        if (fraction === 1) {
          // TODO: push this into the indexer
          position.state = this.ksolvePuzzle.combine(state, this.ksolvePuzzle.stateFromMove(this.indexer.getMove(idx)));
        } else if (fraction > 0) {
          const move = this.indexer.getMove(idx);

          if (move) {
            position.movesInProgress.push({
              move,
              direction: _CursorTypes.Direction.Forwards,
              fraction
            });
          }
        }
      }
    }

    for (const listener of listeners) {
      listener.onPositionChange(position);
    }
  }

  onTimeRangeChange(_timeRange) {// nothing to do
  }

  setAlg(alg, indexerConstructor) {
    var _indexerConstructor;

    (_indexerConstructor = indexerConstructor) !== null && _indexerConstructor !== void 0 ? _indexerConstructor : indexerConstructor = this.indexerConstructor;

    if (alg.isIdentical(this.alg) && this.indexerConstructor === indexerConstructor) {
      // TODO: this is a hacky optimization.
      return;
    }

    this.indexerConstructor = indexerConstructor;
    this.alg = alg;
    this.instantiateIndexer(alg);
    this.timeline.onCursorChange(this);
    this.dispatchPositionForTimestamp(this.timeline.timestamp); // TODO: Handle state change.
  }

  moveBoundary(timestamp, direction) {
    if (this.indexer.numMoves() === 0) {
      return null;
    } // TODO: define semantics of indexing edge cases and remove this hack.


    const offsetHack = (0, _CursorTypes.directionScalar)(direction) * 0.001;
    const idx = this.indexer.timestampToIndex(timestamp + offsetHack);
    const moveStart = this.indexer.indexToMoveStartTimestamp(idx);

    if (direction === _CursorTypes.Direction.Backwards) {
      return timestamp >= moveStart ? moveStart : null;
    } else {
      const moveEnd = moveStart + this.indexer.moveDuration(idx);
      return timestamp <= moveEnd ? moveEnd : null;
    }
  }

  setPuzzle(def, alg = this.alg, startStateAlg) {
    this.ksolvePuzzle = new _KPuzzleWrapper.KPuzzleWrapper(def);
    this.def = def;
    this.indexer = new this.indexerConstructor(this.ksolvePuzzle, alg);

    if (alg !== this.alg) {
      this.timeline.onCursorChange(this);
    }

    this.setStartState(startStateAlg ? this.algToState(startStateAlg) : this.ksolvePuzzle.startState());
    this.alg = alg;
  }
  /** @deprecated */


  experimentalTimestampFromIndex(index) {
    return this.indexer.indexToMoveStartTimestamp(index);
  }
  /** @deprecated */


  experimentalIndexFromTimestamp(timestamp) {
    return this.indexer.timestampToIndex(timestamp);
  }

}

exports.AlgCursor = AlgCursor;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","../../../kpuzzle":"4ZRD3","../../3D/puzzles/KPuzzleWrapper":"pSYCK","../indexer/tree/TreeAlgIndexer":"3v6C1","./CursorTypes":"3xGVw"}],"pSYCK":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.QTMCounterPuzzle = exports.KPuzzleWrapper = exports.PuzzleWrapper = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _kpuzzle = require("../../../kpuzzle");

var _puzzles = require("../../../puzzles");

class PuzzleWrapper {
  multiply(state, amount) {
    if (amount < 0) {
      return this.invert(this.multiply(state, -amount));
    }

    if (amount === 0) {
      return this.identity();
    }

    while (amount % 2 === 0) {
      amount = amount / 2;
      state = this.combine(state, state);
    }

    let newState = state;
    amount--;

    while (amount > 0) {
      if (amount % 2 === 1) {
        newState = this.combine(newState, state);
      }

      amount = Math.floor(amount / 2);

      if (amount > 0) {
        state = this.combine(state, state);
      }
    }

    return newState;
  }

}

exports.PuzzleWrapper = PuzzleWrapper;

class KPuzzleWrapper extends PuzzleWrapper {
  // don't work the underlying kdefinition/multiply so hard
  static async fromID(id) {
    return new KPuzzleWrapper(await _puzzles.puzzles[id].def());
  }

  constructor(definition) {
    super();
    this.definition = definition;
    (0, _defineProperty2.default)(this, "moveCache", {});
  }

  startState() {
    return this.definition.startPieces;
  }

  invert(state) {
    return (0, _kpuzzle.invertTransformation)(this.definition, state);
  }

  combine(s1, s2) {
    return (0, _kpuzzle.combineTransformations)(this.definition, s1, s2);
  }

  stateFromMove(move) {
    const key = move.toString();

    if (!this.moveCache[key]) {
      this.moveCache[key] = (0, _kpuzzle.transformationForMove)(this.definition, move);
    }

    return this.moveCache[key];
  }

  identity() {
    return (0, _kpuzzle.identityTransformation)(this.definition);
  }

  equivalent(s1, s2) {
    return (0, _kpuzzle.areStatesEquivalent)(this.definition, s1, s2);
  }

}

exports.KPuzzleWrapper = KPuzzleWrapper;

class QTMCounterState {
  constructor(value) {
    this.value = value;
  }

}

class QTMCounterPuzzle extends PuzzleWrapper {
  startState() {
    return new QTMCounterState(0);
  }

  invert(state) {
    return new QTMCounterState(-state.value);
  }

  combine(s1, s2) {
    return new QTMCounterState(s1.value + s2.value);
  }

  stateFromMove(move) {
    return new QTMCounterState(Math.abs(move.effectiveAmount));
  }

  identity() {
    return new QTMCounterState(0);
  }

  equivalent(s1, s2) {
    return s1.value === s2.value;
  }

}

exports.QTMCounterPuzzle = QTMCounterPuzzle;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","../../../kpuzzle":"4ZRD3","../../../puzzles":"KrRHt"}],"3v6C1":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.TreeAlgIndexer = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _chunkAlgs = require("./chunkAlgs");

var _AlgWalker = require("./AlgWalker");

class TreeAlgIndexer {
  constructor(puzzle, alg) {
    this.puzzle = puzzle;
    (0, _defineProperty2.default)(this, "decoration", void 0);
    (0, _defineProperty2.default)(this, "walker", void 0);
    const deccon = new _AlgWalker.DecoratorConstructor(this.puzzle);
    const chunkedAlg = (0, _chunkAlgs.chunkAlgs)(alg);
    this.decoration = deccon.traverseAlg(chunkedAlg);
    this.walker = new _AlgWalker.AlgWalker(this.puzzle, chunkedAlg, this.decoration);
  }

  getMove(index) {
    // FIXME need to support Pause
    if (this.walker.moveByIndex(index)) {
      if (!this.walker.move) {
        throw new Error("`this.walker.mv` missing");
      }

      const move = this.walker.move; // TODO: this type of negation needs to be in alg

      if (this.walker.back) {
        return move.invert();
      }

      return move;
    }

    return null;
  }

  indexToMoveStartTimestamp(index) {
    if (this.walker.moveByIndex(index) || this.walker.i === index) {
      return this.walker.dur;
    }

    throw new Error("Out of algorithm: index " + index);
  }

  indexToMovesInProgress(index) {
    if (this.walker.moveByIndex(index) || this.walker.i === index) {
      return this.walker.dur;
    }

    throw new Error("Out of algorithm: index " + index);
  }

  stateAtIndex(index, startTransformation) {
    this.walker.moveByIndex(index);
    return this.puzzle.combine(startTransformation !== null && startTransformation !== void 0 ? startTransformation : this.puzzle.startState(), this.walker.st);
  } // TransformAtIndex does not reflect the start state; it only reflects
  // the change from the start state to the current move index.  If you
  // want the actual state, use stateAtIndex.


  transformAtIndex(index) {
    this.walker.moveByIndex(index);
    return this.walker.st;
  }

  numMoves() {
    return this.decoration.moveCount;
  }

  timestampToIndex(timestamp) {
    this.walker.moveByDuration(timestamp);
    return this.walker.i;
  }

  algDuration() {
    return this.decoration.duration;
  }

  moveDuration(index) {
    this.walker.moveByIndex(index);
    return this.walker.moveDuration;
  }

}

exports.TreeAlgIndexer = TreeAlgIndexer;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","./chunkAlgs":"kclD5","./AlgWalker":"69R0O"}],"kclD5":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.chunkAlgs = void 0;

var _alg = require("../../../../alg");

const MIN_CHUNKING_THRESHOLD = 16;

function chunkifyAlg(alg, chunkMaxLength) {
  const mainAlgBuilder = new _alg.AlgBuilder();
  const chunkAlgBuilder = new _alg.AlgBuilder();

  for (const unit of alg.units()) {
    chunkAlgBuilder.push(unit);

    if (chunkAlgBuilder.experimentalNumUnits() >= chunkMaxLength) {
      mainAlgBuilder.push(new _alg.Grouping(chunkAlgBuilder.toAlg()));
      chunkAlgBuilder.reset();
    }
  }

  mainAlgBuilder.push(new _alg.Grouping(chunkAlgBuilder.toAlg()));
  return mainAlgBuilder.toAlg();
}

class ChunkAlgs extends _alg.TraversalUp {
  traverseAlg(alg) {
    const algLength = alg.experimentalNumUnits();

    if (algLength < MIN_CHUNKING_THRESHOLD) {
      return alg;
    }

    return chunkifyAlg(alg, Math.ceil(Math.sqrt(algLength)));
  }

  traverseGrouping(grouping) {
    return new _alg.Grouping(this.traverseAlg(grouping.experimentalAlg), grouping.experimentalEffectiveAmount);
  }

  traverseMove(move) {
    return move;
  }

  traverseCommutator(commutator) {
    return new _alg.Conjugate(this.traverseAlg(commutator.A), this.traverseAlg(commutator.B), commutator.experimentalEffectiveAmount);
  }

  traverseConjugate(conjugate) {
    return new _alg.Conjugate(this.traverseAlg(conjugate.A), this.traverseAlg(conjugate.B), conjugate.experimentalEffectiveAmount);
  }

  traversePause(pause) {
    return pause;
  }

  traverseNewline(newline) {
    return newline;
  }

  traverseLineComment(comment) {
    return comment;
  }

}

const chunkAlgsInstance = new ChunkAlgs();
const chunkAlgs = chunkAlgsInstance.traverseAlg.bind(chunkAlgsInstance);
exports.chunkAlgs = chunkAlgs;
},{"../../../../alg":"7Ff6b"}],"69R0O":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.AlgWalker = exports.DecoratorConstructor = exports.AlgPartDecoration = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _alg = require("../../../../alg");

var _AlgDuration = require("../AlgDuration");

class AlgPartDecoration {
  constructor(_puz, moveCount, duration, forward, backward, children = []) {
    this.moveCount = moveCount;
    this.duration = duration;
    this.forward = forward;
    this.backward = backward;
    this.children = children;
  }

}

exports.AlgPartDecoration = AlgPartDecoration;

class DecoratorConstructor extends _alg.TraversalUp {
  constructor(puz) {
    super();
    this.puz = puz;
    (0, _defineProperty2.default)(this, "identity", void 0);
    (0, _defineProperty2.default)(this, "dummyLeaf", void 0);
    (0, _defineProperty2.default)(this, "durationFn", new _AlgDuration.AlgDuration(_AlgDuration.defaultDurationForAmount));
    (0, _defineProperty2.default)(this, "cache", {});
    this.identity = puz.identity();
    this.dummyLeaf = new AlgPartDecoration(puz, 0, 0, this.identity, this.identity, []);
  }

  traverseAlg(alg) {
    let moveCount = 0;
    let duration = 0;
    let state = this.identity;
    const child = [];

    for (const unit of alg.units()) {
      const apd = this.traverseUnit(unit);
      moveCount += apd.moveCount;
      duration += apd.duration;

      if (state === this.identity) {
        state = apd.forward;
      } else {
        state = this.puz.combine(state, apd.forward);
      }

      child.push(apd);
    }

    return new AlgPartDecoration(this.puz, moveCount, duration, state, this.puz.invert(state), child);
  }

  traverseGrouping(grouping) {
    const dec = this.traverseAlg(grouping.experimentalAlg);
    return this.mult(dec, grouping.experimentalEffectiveAmount, [dec]);
  }

  traverseMove(move) {
    const key = move.toString();
    let r = this.cache[key];

    if (r) {
      return r;
    }

    r = new AlgPartDecoration(this.puz, 1, this.durationFn.traverseUnit(move), this.puz.stateFromMove(move), this.puz.stateFromMove(move.invert()));
    this.cache[key] = r;
    return r;
  }

  traverseCommutator(commutator) {
    const decA = this.traverseAlg(commutator.A);
    const decB = this.traverseAlg(commutator.B);
    const AB = this.puz.combine(decA.forward, decB.forward);
    const ApBp = this.puz.combine(decA.backward, decB.backward);
    const ABApBp = this.puz.combine(AB, ApBp);
    const dec = new AlgPartDecoration(this.puz, 2 * (decA.moveCount + decB.moveCount), 2 * (decA.duration + decB.duration), ABApBp, this.puz.invert(ABApBp), [decA, decB]);
    return this.mult(dec, commutator.experimentalEffectiveAmount, [dec, decA, decB]);
  }

  traverseConjugate(conjugate) {
    const decA = this.traverseAlg(conjugate.A);
    const decB = this.traverseAlg(conjugate.B);
    const AB = this.puz.combine(decA.forward, decB.forward);
    const ABAp = this.puz.combine(AB, decA.backward);
    const dec = new AlgPartDecoration(this.puz, 2 * decA.moveCount + decB.moveCount, 2 * decA.duration + decB.duration, ABAp, this.puz.invert(ABAp), [decA, decB]);
    return this.mult(dec, conjugate.experimentalEffectiveAmount, [dec, decA, decB]);
  }

  traversePause(pause) {
    return new AlgPartDecoration(this.puz, 1, this.durationFn.traverseUnit(pause), this.identity, this.identity);
  }

  traverseNewline(_newline) {
    return this.dummyLeaf;
  }

  traverseLineComment(_comment) {
    return this.dummyLeaf;
  }

  mult(apd, n, child) {
    const absn = Math.abs(n);
    const st = this.puz.multiply(apd.forward, n);
    return new AlgPartDecoration(this.puz, apd.moveCount * absn, apd.duration * absn, st, this.puz.invert(st), child);
  }

}

exports.DecoratorConstructor = DecoratorConstructor;

class WalkerDown {
  constructor(apd, back) {
    /**/

    this.apd = apd;
    this.back = back;
  }

}

class AlgWalker extends _alg.TraversalDownUp {
  constructor(puz, algOrUnit, apd) {
    super();
    this.puz = puz;
    this.algOrUnit = algOrUnit;
    this.apd = apd;
    (0, _defineProperty2.default)(this, "move", void 0);
    (0, _defineProperty2.default)(this, "moveDuration", void 0);
    (0, _defineProperty2.default)(this, "back", void 0);
    (0, _defineProperty2.default)(this, "st", void 0);
    (0, _defineProperty2.default)(this, "root", void 0);
    (0, _defineProperty2.default)(this, "i", void 0);
    (0, _defineProperty2.default)(this, "dur", void 0);
    (0, _defineProperty2.default)(this, "goali", void 0);
    (0, _defineProperty2.default)(this, "goaldur", void 0);
    this.i = -1;
    this.dur = -1;
    this.goali = -1;
    this.goaldur = -1;
    this.move = undefined;
    this.back = false;
    this.moveDuration = 0;
    this.st = this.puz.identity();
    this.root = new WalkerDown(this.apd, false);
  }

  moveByIndex(loc) {
    if (this.i >= 0 && this.i === loc) {
      return this.move !== undefined;
    }

    return this.dosearch(loc, Infinity);
  }

  moveByDuration(dur) {
    if (this.dur >= 0 && this.dur < dur && this.dur + this.moveDuration >= dur) {
      return this.move !== undefined;
    }

    return this.dosearch(Infinity, dur);
  }

  dosearch(loc, dur) {
    this.goali = loc;
    this.goaldur = dur;
    this.i = 0;
    this.dur = 0;
    this.move = undefined;
    this.moveDuration = 0;
    this.back = false;
    this.st = this.puz.identity();
    const r = this.algOrUnit.is(_alg.Alg) ? this.traverseAlg(this.algOrUnit, this.root) : this.traverseUnit(this.algOrUnit, this.root); // TODO

    return r;
  }

  traverseAlg(alg, wd) {
    if (!this.firstcheck(wd)) {
      return false;
    }

    let i = wd.back ? alg.experimentalNumUnits() - 1 : 0;

    for (const unit of (0, _alg.experimentalDirectedGenerator)(alg.units(), wd.back ? _alg.ExperimentalIterationDirection.Backwards : _alg.ExperimentalIterationDirection.Forwards)) {
      if (this.traverseUnit(unit, new WalkerDown(wd.apd.children[i], wd.back))) {
        return true;
      }

      i += wd.back ? -1 : 1;
    }

    return false;
  }

  traverseGrouping(grouping, wd) {
    if (!this.firstcheck(wd)) {
      return false;
    }

    const back = this.domult(wd, grouping.experimentalEffectiveAmount);
    return this.traverseAlg(grouping.experimentalAlg, new WalkerDown(wd.apd.children[0], back));
  }

  traverseMove(move, wd) {
    if (!this.firstcheck(wd)) {
      return false;
    }

    this.move = move;
    this.moveDuration = wd.apd.duration;
    this.back = wd.back;
    return true;
  }

  traverseCommutator(commutator, wd) {
    if (!this.firstcheck(wd)) {
      return false;
    }

    const back = this.domult(wd, commutator.experimentalEffectiveAmount);

    if (back) {
      return this.traverseAlg(commutator.B, new WalkerDown(wd.apd.children[2], !back)) || this.traverseAlg(commutator.A, new WalkerDown(wd.apd.children[1], !back)) || this.traverseAlg(commutator.B, new WalkerDown(wd.apd.children[2], back)) || this.traverseAlg(commutator.A, new WalkerDown(wd.apd.children[1], back));
    } else {
      return this.traverseAlg(commutator.A, new WalkerDown(wd.apd.children[1], back)) || this.traverseAlg(commutator.B, new WalkerDown(wd.apd.children[2], back)) || this.traverseAlg(commutator.A, new WalkerDown(wd.apd.children[1], !back)) || this.traverseAlg(commutator.B, new WalkerDown(wd.apd.children[2], !back));
    }
  }

  traverseConjugate(conjugate, wd) {
    if (!this.firstcheck(wd)) {
      return false;
    }

    const back = this.domult(wd, conjugate.experimentalEffectiveAmount);

    if (back) {
      return this.traverseAlg(conjugate.A, new WalkerDown(wd.apd.children[1], !back)) || this.traverseAlg(conjugate.B, new WalkerDown(wd.apd.children[2], back)) || this.traverseAlg(conjugate.A, new WalkerDown(wd.apd.children[1], back));
    } else {
      return this.traverseAlg(conjugate.A, new WalkerDown(wd.apd.children[1], back)) || this.traverseAlg(conjugate.B, new WalkerDown(wd.apd.children[2], back)) || this.traverseAlg(conjugate.A, new WalkerDown(wd.apd.children[1], !back));
    }
  }

  traversePause(pause, wd) {
    if (!this.firstcheck(wd)) {
      return false;
    }

    this.move = pause;
    this.moveDuration = wd.apd.duration;
    this.back = wd.back;
    return true;
  }

  traverseNewline(_newline, _wd) {
    return false;
  }

  traverseLineComment(_lineComment, _wd) {
    return false;
  }

  firstcheck(wd) {
    if (wd.apd.moveCount + this.i <= this.goali && wd.apd.duration + this.dur < this.goaldur) {
      return this.keepgoing(wd);
    }

    return true;
  }

  domult(wd, amount) {
    let back = wd.back;

    if (amount === 0) {
      // I don't believe this will ever happen
      return back;
    }

    if (amount < 0) {
      back = !back;
      amount = -amount;
    }

    const base = wd.apd.children[0];
    const full = Math.min(Math.floor((this.goali - this.i) / base.moveCount), Math.ceil((this.goaldur - this.dur) / base.duration - 1));

    if (full > 0) {
      this.keepgoing(new WalkerDown(base, back), full);
    }

    return back;
  }

  keepgoing(wd, mul = 1) {
    this.i += mul * wd.apd.moveCount;
    this.dur += mul * wd.apd.duration;

    if (mul !== 1) {
      if (wd.back) {
        this.st = this.puz.combine(this.st, this.puz.multiply(wd.apd.backward, mul));
      } else {
        this.st = this.puz.combine(this.st, this.puz.multiply(wd.apd.forward, mul));
      }
    } else {
      if (wd.back) {
        this.st = this.puz.combine(this.st, wd.apd.backward);
      } else {
        this.st = this.puz.combine(this.st, wd.apd.forward);
      }
    }

    return false;
  }

}

exports.AlgWalker = AlgWalker;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","../../../../alg":"7Ff6b","../AlgDuration":"4aFRh"}],"4aFRh":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.constantDurationForAmount = constantDurationForAmount;
exports.defaultDurationForAmount = defaultDurationForAmount;
exports.ExperimentalScaledDefaultDurationForAmount = ExperimentalScaledDefaultDurationForAmount;
exports.AlgDuration = void 0;

var _alg = require("../../../alg");

function constantDurationForAmount(_amount) {
  return 1000;
}

function defaultDurationForAmount(amount) {
  switch (Math.abs(amount)) {
    case 0:
      return 0;

    case 1:
      return 1000;

    case 2:
      return 1500;

    default:
      return 2000;
  }
} // eslint-disable-next-line no-inner-declarations


function ExperimentalScaledDefaultDurationForAmount(scale, amount) {
  switch (Math.abs(amount)) {
    case 0:
      return 0;

    case 1:
      return scale * 1000;

    case 2:
      return scale * 1500;

    default:
      return scale * 2000;
  }
}

class AlgDuration extends _alg.TraversalUp {
  // TODO: Pass durationForAmount as Down type instead?
  constructor(durationForAmount = defaultDurationForAmount) {
    super();
    this.durationForAmount = durationForAmount;
  }

  traverseAlg(alg) {
    let total = 0;

    for (const unit of alg.units()) {
      total += this.traverseUnit(unit);
    }

    return total;
  }

  traverseGrouping(grouping) {
    return grouping.experimentalEffectiveAmount * this.traverseAlg(grouping.experimentalAlg);
  }

  traverseMove(move) {
    return this.durationForAmount(move.effectiveAmount);
  }

  traverseCommutator(commutator) {
    return commutator.experimentalEffectiveAmount * 2 * (this.traverseAlg(commutator.A) + this.traverseAlg(commutator.B));
  }

  traverseConjugate(conjugate) {
    return conjugate.experimentalEffectiveAmount * (2 * this.traverseAlg(conjugate.A) + this.traverseAlg(conjugate.B));
  }

  traversePause(_pause) {
    return this.durationForAmount(1);
  }

  traverseNewline(_newline) {
    return this.durationForAmount(1);
  }

  traverseLineComment(_comment) {
    return this.durationForAmount(0);
  }

}

exports.AlgDuration = AlgDuration;
},{"../../../alg":"7Ff6b"}],"3xGVw":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.directionScalar = directionScalar;
exports.BoundaryType = exports.Direction = void 0;
// TODO: unify duration/timstamp types
// Duration in milliseconds
// TODO: Extend `number`, introduce MoveSequenceTimestamp vs. EpochTimestamp,
// force Duration to be a difference.
// Duration since a particular epoch.
// Value from 0 to 1.
// 1, 0, -1 are used as scalars for `directionScalar` below.
let Direction;
exports.Direction = Direction;

(function (Direction) {
  Direction[Direction["Forwards"] = 1] = "Forwards";
  Direction[Direction["Paused"] = 0] = "Paused";
  Direction[Direction["Backwards"] = -1] = "Backwards";
})(Direction || (exports.Direction = Direction = {}));

function directionScalar(direction) {
  return direction;
}

let BoundaryType; // export type DurationForAmount = (amount: number) => Duration;

exports.BoundaryType = BoundaryType;

(function (BoundaryType) {
  BoundaryType[BoundaryType["Move"] = 0] = "Move";
  BoundaryType[BoundaryType["EntireTimeline"] = 1] = "EntireTimeline";
})(BoundaryType || (exports.BoundaryType = BoundaryType = {}));
},{}],"105Ga":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.SimpleAlgIndexer = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _alg = require("../../../alg");

var _notation = require("../../../notation");

var _AlgDuration = require("./AlgDuration");

class SimpleAlgIndexer {
  // TODO: Allow custom `durationFn`.
  constructor(puzzle, alg) {
    this.puzzle = puzzle;
    (0, _defineProperty2.default)(this, "moves", void 0);
    (0, _defineProperty2.default)(this, "durationFn", new _AlgDuration.AlgDuration(_AlgDuration.defaultDurationForAmount));
    // TODO: Avoid assuming all base moves are block moves.
    this.moves = new _alg.Alg(alg.experimentalExpand());
  }

  getMove(index) {
    return Array.from(this.moves.units())[index]; // TODO: perf
  }

  indexToMoveStartTimestamp(index) {
    const alg = new _alg.Alg(Array.from(this.moves.units()).slice(0, index)); // TODO

    return this.durationFn.traverseAlg(alg);
  }

  timestampToIndex(timestamp) {
    let cumulativeTime = 0;
    let i;

    for (i = 0; i < this.numMoves(); i++) {
      cumulativeTime += this.durationFn.traverseMove(this.getMove(i));

      if (cumulativeTime >= timestamp) {
        return i;
      }
    }

    return i;
  }

  stateAtIndex(index) {
    return this.puzzle.combine(this.puzzle.startState(), this.transformAtIndex(index));
  }

  transformAtIndex(index) {
    let state = this.puzzle.identity();

    for (const move of Array.from(this.moves.units()).slice(0, index)) {
      state = this.puzzle.combine(state, this.puzzle.stateFromMove(move));
    }

    return state;
  }

  algDuration() {
    return this.durationFn.traverseAlg(this.moves);
  }

  numMoves() {
    // TODO: Cache internally once performance matters.
    return (0, _notation.countAnimatedMoves)(this.moves);
  }

  moveDuration(index) {
    return this.durationFn.traverseMove(this.getMove(index));
  }

}

exports.SimpleAlgIndexer = SimpleAlgIndexer;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","../../../alg":"7Ff6b","../../../notation":"duTuZ","./AlgDuration":"4aFRh"}],"5qE7r":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.SimultaneousMoveIndexer = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _alg = require("../../../../alg");

var _CursorTypes = require("../../cursor/CursorTypes");

var _simulMoves = require("./simul-moves");

const demos = {
  "y' y' U' E D R2 r2 F2 B2 U E D' R2 L2' z2 S2 U U D D S2 F2' B2": [{
    move: new _alg.Move("y", -1),
    start: 0,
    end: 1000
  }, {
    move: new _alg.Move("y", -1),
    start: 1000,
    end: 2000
  }, {
    move: new _alg.Move("U", -1),
    start: 1000,
    end: 1600
  }, {
    move: new _alg.Move("E", 1),
    start: 1200,
    end: 1800
  }, {
    move: new _alg.Move("D"),
    start: 1400,
    end: 2000
  }, {
    move: new _alg.Move("R", 2),
    start: 2000,
    end: 3500
  }, {
    move: new _alg.Move("r", 2),
    start: 2000,
    end: 3500
  }, {
    move: new _alg.Move("F", 2),
    start: 3500,
    end: 4200
  }, {
    move: new _alg.Move("B", 2),
    start: 3800,
    end: 4500
  }, {
    move: new _alg.Move("U", 1),
    start: 4500,
    end: 5500
  }, {
    move: new _alg.Move("E", 1),
    start: 4500,
    end: 5500
  }, {
    move: new _alg.Move("D", -1),
    start: 4500,
    end: 5500
  }, {
    move: new _alg.Move("R", 2),
    start: 5500,
    end: 6500
  }, {
    move: new _alg.Move("L", -2),
    start: 5500,
    end: 6500
  }, {
    move: new _alg.Move("z", 2),
    start: 5500,
    end: 6500
  }, {
    move: new _alg.Move("S", 2),
    start: 6500,
    end: 7500
  }, {
    move: new _alg.Move("U"),
    start: 7500,
    end: 8000
  }, {
    move: new _alg.Move("U"),
    start: 8000,
    end: 8500
  }, {
    move: new _alg.Move("D"),
    start: 7750,
    end: 8250
  }, {
    move: new _alg.Move("D"),
    start: 8250,
    end: 8750
  }, {
    move: new _alg.Move("S", 2),
    start: 8750,
    end: 9250
  }, {
    move: new _alg.Move("F", -2),
    start: 8750,
    end: 10000
  }, {
    move: new _alg.Move("B", 2),
    start: 8750,
    end: 10000
  }],
  "M' R' U' D' M R": [{
    move: new _alg.Move("M", -1),
    start: 0,
    end: 1000
  }, {
    move: new _alg.Move("R", -1),
    start: 0,
    end: 1000
  }, {
    move: new _alg.Move("U", -1),
    start: 1000,
    end: 2000
  }, {
    move: new _alg.Move("D", -1),
    start: 1000,
    end: 2000
  }, {
    move: new _alg.Move("M"),
    start: 2000,
    end: 3000
  }, {
    move: new _alg.Move("R"),
    start: 2000,
    end: 3000
  }],
  "U' E' r E r2' E r U E": [{
    move: new _alg.Move("U", -1),
    start: 0,
    end: 1000
  }, {
    move: new _alg.Move("E", -1),
    start: 0,
    end: 1000
  }, {
    move: new _alg.Move("r"),
    start: 1000,
    end: 2500
  }, {
    move: new _alg.Move("E"),
    start: 2500,
    end: 3500
  }, {
    move: new _alg.Move("r", -2),
    start: 3500,
    end: 5000
  }, {
    move: new _alg.Move("E"),
    start: 5000,
    end: 6000
  }, {
    move: new _alg.Move("r"),
    start: 6000,
    end: 7000
  }, {
    move: new _alg.Move("U"),
    start: 7000,
    end: 8000
  }, {
    move: new _alg.Move("E"),
    start: 7000,
    end: 8000
  }]
};

class SimultaneousMoveIndexer {
  // TODO: Allow custom `durationFn`.
  constructor(puzzle, alg) {
    var _demos$alg$toString;

    this.puzzle = puzzle;
    (0, _defineProperty2.default)(this, "moves", void 0);
    this.moves = (_demos$alg$toString = demos[alg.toString()]) !== null && _demos$alg$toString !== void 0 ? _demos$alg$toString : (0, _simulMoves.simulMoves)(alg); // TODO: Avoid assuming all base moves are block moves.
  }

  getMove(index) {
    return this.moves[Math.min(index, this.moves.length - 1)].move;
  }

  getMoveWithRange(index) {
    return this.moves[Math.min(index, this.moves.length - 1)];
  }

  indexToMoveStartTimestamp(index) {
    let start = 0;

    if (this.moves.length > 0) {
      start = this.moves[Math.min(index, this.moves.length - 1)].start;
    }

    return start;
  }

  timestampToIndex(timestamp) {
    let i = 0;

    for (i = 0; i < this.moves.length; i++) {
      if (this.moves[i].start >= timestamp) {
        return Math.max(0, i - 1);
      }
    }

    return Math.max(0, i - 1);
  }

  timestampToPosition(timestamp, startTransformation) {
    const position = {
      state: startTransformation !== null && startTransformation !== void 0 ? startTransformation : this.puzzle.identity(),
      movesInProgress: []
    };

    for (const moveWithRange of this.moves) {
      if (moveWithRange.end <= timestamp) {
        position.state = this.puzzle.combine(position.state, this.puzzle.stateFromMove(moveWithRange.move));
      } else if (moveWithRange.start < timestamp && timestamp < moveWithRange.end) {
        position.movesInProgress.push({
          move: moveWithRange.move,
          direction: _CursorTypes.Direction.Forwards,
          fraction: (timestamp - moveWithRange.start) / (moveWithRange.end - moveWithRange.start)
        });
      } else if (timestamp < moveWithRange.start) {
        continue;
      }
    }

    return position;
  }

  stateAtIndex(index, startTransformation) {
    let state = startTransformation !== null && startTransformation !== void 0 ? startTransformation : this.puzzle.startState();

    for (let i = 0; i < this.moves.length && i < index; i++) {
      const moveWithRange = this.moves[i];
      state = this.puzzle.combine(state, this.puzzle.stateFromMove(moveWithRange.move));
    }

    return state;
  }

  transformAtIndex(index) {
    let state = this.puzzle.identity();

    for (const moveWithRange of this.moves.slice(0, index)) {
      state = this.puzzle.combine(state, this.puzzle.stateFromMove(moveWithRange.move));
    }

    return state;
  }

  algDuration() {
    let max = 0;

    for (const moveWithRange of this.moves) {
      max = Math.max(max, moveWithRange.end);
    }

    return max;
  }

  numMoves() {
    // TODO: Cache internally once performance matters.
    return this.moves.length;
  }

  moveDuration(index) {
    const move = this.getMoveWithRange(index);
    return move.end - move.start;
  }

}

exports.SimultaneousMoveIndexer = SimultaneousMoveIndexer;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","../../../../alg":"7Ff6b","../../cursor/CursorTypes":"3xGVw","./simul-moves":"6jMZC"}],"6jMZC":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.simulMoves = simulMoves;
exports.LocalSimulMoves = void 0;

var _alg = require("../../../../alg");

var _AlgDuration = require("../AlgDuration");

const axisLookup = {
  u: "y",
  l: "x",
  f: "z",
  r: "x",
  b: "z",
  d: "y",
  m: "x",
  e: "y",
  s: "z",
  x: "x",
  y: "y",
  z: "z"
};

function isSameAxis(move1, move2) {
  return axisLookup[move1.family[0].toLowerCase()] === axisLookup[move2.family[0].toLowerCase()];
} // TODO: Replace this with an optimized implementation.
// TODO: Consider `(x U)` and `(U x F)` to be simultaneous.


class LocalSimulMoves extends _alg.TraversalUp {
  traverseAlg(alg) {
    const processed = [];

    for (const nestedUnit of alg.units()) {
      processed.push(this.traverseUnit(nestedUnit));
    }

    return Array.prototype.concat(...processed);
  }

  traverseGroupingOnce(alg) {
    if (alg.experimentalIsEmpty()) {
      return [];
    }

    for (const unit of alg.units()) {
      if (!unit.is(_alg.Move)) // TODO: define the type statically on the class?
        return this.traverseAlg(alg);
    }

    const moves = Array.from(alg.units());
    let maxSimulDur = (0, _AlgDuration.defaultDurationForAmount)(moves[0].effectiveAmount);

    for (let i = 0; i < moves.length - 1; i++) {
      for (let j = 1; j < moves.length; j++) {
        if (!isSameAxis(moves[i], moves[j])) {
          return this.traverseAlg(alg);
        }
      }

      maxSimulDur = Math.max(maxSimulDur, (0, _AlgDuration.defaultDurationForAmount)(moves[i].effectiveAmount));
    }

    const localMovesWithRange = moves.map(blockMove => {
      return {
        move: blockMove,
        msUntilNext: 0,
        duration: maxSimulDur
      };
    });
    localMovesWithRange[localMovesWithRange.length - 1].msUntilNext = maxSimulDur;
    return localMovesWithRange;
  }

  traverseGrouping(grouping) {
    const processed = [];
    const segmentOnce = grouping.experimentalEffectiveAmount > 0 ? grouping.experimentalAlg : grouping.experimentalAlg.invert();

    for (let i = 0; i < Math.abs(grouping.experimentalEffectiveAmount); i++) {
      processed.push(this.traverseGroupingOnce(segmentOnce));
    }

    return Array.prototype.concat(...processed);
  }

  traverseMove(move) {
    const duration = (0, _AlgDuration.defaultDurationForAmount)(move.effectiveAmount);
    return [{
      move: move,
      msUntilNext: duration,
      duration
    }];
  }

  traverseCommutator(commutator) {
    const processed = [];
    const segmentsOnce = commutator.experimentalEffectiveAmount > 0 ? [commutator.A, commutator.B, commutator.A.invert(), commutator.B.invert()] : [commutator.B, commutator.A, commutator.B.invert(), commutator.A.invert()];

    for (let i = 0; i < Math.abs(commutator.experimentalEffectiveAmount); i++) {
      for (const segment of segmentsOnce) {
        processed.push(this.traverseGroupingOnce(segment));
      }
    }

    return Array.prototype.concat(...processed);
  }

  traverseConjugate(conjugate) {
    const processed = [];
    const segmentsOnce = conjugate.experimentalEffectiveAmount > 0 ? [conjugate.A, conjugate.B, conjugate.A.invert()] : [conjugate.A, conjugate.B.invert(), conjugate.A.invert()];

    for (let i = 0; i < Math.abs(conjugate.experimentalEffectiveAmount); i++) {
      for (const segment of segmentsOnce) {
        processed.push(this.traverseGroupingOnce(segment));
      }
    }

    return Array.prototype.concat(...processed);
  }

  traversePause(_pause) {
    return [];
  }

  traverseNewline(_newline) {
    return [];
  }

  traverseLineComment(_comment) {
    return [];
  }

}

exports.LocalSimulMoves = LocalSimulMoves;
const localSimulMovesInstance = new LocalSimulMoves();
const localSimulMoves = localSimulMovesInstance.traverseAlg.bind(localSimulMovesInstance);

function simulMoves(a) {
  let timestamp = 0;
  const l = localSimulMoves(a).map(localSimulMove => {
    const moveWithRange = {
      move: localSimulMove.move,
      start: timestamp,
      end: timestamp + localSimulMove.duration
    };
    timestamp += localSimulMove.msUntilNext;
    return moveWithRange;
  });
  return l;
}
},{"../../../../alg":"7Ff6b","../AlgDuration":"4aFRh"}],"5Cj4O":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Timeline = exports.TimestampLocationType = exports.TimelineAction = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _RenderScheduler = require("./RenderScheduler");

var _CursorTypes = require("./cursor/CursorTypes");

// YouTube keeps playing on jump, but it also stays frozen while the cursor is
// down. So I think it would be good for this to be false, but only if we
// implement a "start jumping" event that pauses until "finish jumping" while
// the scrubber is active.
const PAUSE_ON_JUMP = true; // TODO: We use symbols to avoid exposing `number` values. Is this performant enough? Should/can we use symbols?

let TimelineAction; // TODO: We use symbols to avoid exposing `number` values. Is this performant enough? Should/can we use symbols?

exports.TimelineAction = TimelineAction;

(function (TimelineAction) {
  TimelineAction["StartingToPlay"] = "StartingToPlay";
  TimelineAction["Pausing"] = "Pausing";
  TimelineAction["Jumping"] = "Jumping";
})(TimelineAction || (exports.TimelineAction = TimelineAction = {}));

let TimestampLocationType;
exports.TimestampLocationType = TimestampLocationType;

(function (TimestampLocationType) {
  TimestampLocationType["StartOfTimeline"] = "Start";
  TimestampLocationType["EndOfTimeline"] = "End";
  TimestampLocationType["StartOfMove"] = "StartOfMove";
  TimestampLocationType["EndOfMove"] = "EndOfMove";
  TimestampLocationType["MiddleOfMove"] = "MiddleOfMove";
  TimestampLocationType["BetweenMoves"] = "BetweenMoves";
})(TimestampLocationType || (exports.TimestampLocationType = TimestampLocationType = {}));

// `performance.now()` is rounded for security concerns, so it's usually not
// accurate to the millisecond. So we round it, which lets us work with whole ms
// everywhere.
function getNow() {
  return Math.round(performance.now());
}

class Timeline {
  // TODO: handle pausing here?
  constructor() {
    (0, _defineProperty2.default)(this, "animating", false);
    (0, _defineProperty2.default)(this, "tempoScale", 1);
    (0, _defineProperty2.default)(this, "cursors", new Set());
    (0, _defineProperty2.default)(this, "timestampListeners", new Set());
    (0, _defineProperty2.default)(this, "actionListeners", new Set());
    (0, _defineProperty2.default)(this, "timestamp", 0);
    (0, _defineProperty2.default)(this, "lastAnimFrameNow", 0);
    (0, _defineProperty2.default)(this, "lastAnimFrameTimestamp", void 0);
    (0, _defineProperty2.default)(this, "scheduler", void 0);
    (0, _defineProperty2.default)(this, "direction", _CursorTypes.Direction.Forwards);
    (0, _defineProperty2.default)(this, "boundaryType", _CursorTypes.BoundaryType.EntireTimeline);
    (0, _defineProperty2.default)(this, "cachedNextBoundary", void 0);

    const animFrame = _now => {
      if (this.animating) {
        const now = getNow(); // TODO: See if we can use the rAF value without monotonicity issues.;

        this.timestamp = this.timestamp + this.tempoScale * (0, _CursorTypes.directionScalar)(this.direction) * (now - this.lastAnimFrameNow);
        this.lastAnimFrameNow = now;
        const atOrPastBoundary = this.direction === _CursorTypes.Direction.Backwards ? this.timestamp <= this.cachedNextBoundary : this.timestamp >= this.cachedNextBoundary;

        if (atOrPastBoundary) {
          this.timestamp = this.cachedNextBoundary;

          if (this.animating) {
            this.animating = false;
            this.dispatchAction(TimelineAction.Pausing);
          }
        }
      }

      if (this.timestamp !== this.lastAnimFrameTimestamp) {
        this.dispatchTimestamp();
        this.lastAnimFrameTimestamp = this.timestamp;
      }

      if (this.animating) {
        this.scheduler.requestAnimFrame();
      }
    };

    this.scheduler = new _RenderScheduler.RenderScheduler(animFrame);
  }

  addCursor(cursor) {
    this.cursors.add(cursor);
    this.dispatchTimeRange();
  }

  removeCursor(cursor) {
    this.cursors.delete(cursor);
    this.clampTimestampToRange();
    this.dispatchTimeRange();
  } // TODO: test


  clampTimestampToRange() {
    const timeRange = this.timeRange();

    if (this.timestamp < timeRange.start) {
      this.setTimestamp(timeRange.start);
    }

    if (this.timestamp > timeRange.end) {
      this.setTimestamp(timeRange.end);
    }
  } // In the future, this might do some calculations or caching.


  onCursorChange(_cursor) {
    if (this.timestamp > this.maxTimestamp()) {
      this.timestamp = this.maxTimestamp();
    }

    this.dispatchTimeRange();
  }

  timeRange() {
    let start = 0;
    let end = 0;

    for (const cursor of this.cursors) {
      const cursorTimeRange = cursor.timeRange();
      start = Math.min(start, cursorTimeRange.start);
      end = Math.max(end, cursorTimeRange.end);
    }

    return {
      start,
      end
    };
  }

  minTimestamp() {
    // TODO: Calculate and cache this value every time there's a new cursor.
    return this.timeRange().start;
  }

  maxTimestamp() {
    // TODO: Calculate and cache this value every time there's a new cursor.
    return this.timeRange().end;
  }

  dispatchTimeRange() {
    const timeRange = this.timeRange();

    for (const listener of this.cursors) {
      // TODO: dedup in case the timestamp hasn't changed sine last time.
      listener.onTimeRangeChange(timeRange);
    } // TODO: Combine loops without extra memory?


    for (const listener of this.timestampListeners) {
      // TODO: dedup in case the timestamp hasn't changed sine last time.
      listener.onTimeRangeChange(timeRange);
    }
  }

  dispatchTimestamp() {
    for (const listener of this.cursors) {
      // TODO: dedup in case the timestamp hasn't changed sine last time.
      listener.onTimelineTimestampChange(this.timestamp);
    } // TODO: Combine loops without extra memory?


    for (const listener of this.timestampListeners) {
      // TODO: dedup in case the timestamp hasn't changed sine last time.
      listener.onTimelineTimestampChange(this.timestamp);
    }
  }

  addTimestampListener(timestampListener) {
    this.timestampListeners.add(timestampListener);
  }

  removeTimestampListener(timestampListener) {
    this.timestampListeners.delete(timestampListener);
  }

  addActionListener(actionListener) {
    this.actionListeners.add(actionListener);
  }

  removeActionListener(actionListener) {
    this.actionListeners.delete(actionListener);
  }

  play() {
    this.experimentalPlay(_CursorTypes.Direction.Forwards, _CursorTypes.BoundaryType.EntireTimeline);
  }

  experimentalPlay(direction, boundaryType = _CursorTypes.BoundaryType.EntireTimeline) {
    this.direction = direction;
    this.boundaryType = boundaryType;
    const nextBoundary = this.nextBoundary(this.timestamp, direction, this.boundaryType);

    if (nextBoundary === null) {
      return; // Nowhere to end, so we don't animate.
    }

    this.cachedNextBoundary = nextBoundary;

    if (!this.animating) {
      this.animating = true;
      this.lastAnimFrameNow = getNow();
      this.dispatchAction(TimelineAction.StartingToPlay);
      this.scheduler.requestAnimFrame();
    }
  } // Non-inclusive


  nextBoundary(timestamp, direction, boundaryType = _CursorTypes.BoundaryType.EntireTimeline) {
    switch (boundaryType) {
      case _CursorTypes.BoundaryType.EntireTimeline:
        {
          switch (direction) {
            case _CursorTypes.Direction.Backwards:
              return timestamp <= this.minTimestamp() ? null : this.minTimestamp();

            case _CursorTypes.Direction.Forwards:
              return timestamp >= this.maxTimestamp() ? null : this.maxTimestamp();

            default:
              throw new Error("invalid direction");
          }
        }

      case _CursorTypes.BoundaryType.Move:
        {
          let result = null;

          for (const cursor of this.cursors) {
            const boundaryTimestamp = cursor.moveBoundary(timestamp, direction);

            if (boundaryTimestamp !== null) {
              switch (direction) {
                case _CursorTypes.Direction.Backwards:
                  {
                    var _result;

                    result = Math.min((_result = result) !== null && _result !== void 0 ? _result : boundaryTimestamp, boundaryTimestamp);
                    break;
                  }

                case _CursorTypes.Direction.Forwards:
                  {
                    var _result2;

                    result = Math.max((_result2 = result) !== null && _result2 !== void 0 ? _result2 : boundaryTimestamp, boundaryTimestamp);
                    break;
                  }

                default:
                  throw new Error("invalid direction");
              }
            }
          }

          return result;
        }

      default:
        throw new Error("invalid boundary type");
    }
  } // One more render may be dispatched after this.


  pause() {
    // TODO: error if already paused?
    if (this.animating) {
      this.animating = false;
      this.dispatchAction(TimelineAction.Pausing);
      this.scheduler.requestAnimFrame();
    }
  }

  playPause() {
    if (this.animating) {
      this.pause();
    } else {
      if (this.timestamp >= this.maxTimestamp()) {
        this.timestamp = 0;
      }

      this.experimentalPlay(_CursorTypes.Direction.Forwards, _CursorTypes.BoundaryType.EntireTimeline);
    }
  }

  setTimestamp(timestamp) {
    const oldTimestamp = this.timestamp;
    this.timestamp = timestamp;
    this.lastAnimFrameNow = getNow();

    if (oldTimestamp !== timestamp) {
      this.dispatchAction(TimelineAction.Jumping);
      this.scheduler.requestAnimFrame();
    }

    if (PAUSE_ON_JUMP) {
      this.animating = false;
      this.dispatchAction(TimelineAction.Pausing);
    }
  }

  jumpToStart() {
    this.setTimestamp(this.minTimestamp());
  }

  jumpToEnd() {
    this.setTimestamp(this.maxTimestamp());
  }
  /** @deprecated */


  experimentalJumpToLastMove() {
    let max = 0;

    for (const cursor of this.cursors) {
      var _cursor$experimentalT;

      max = Math.max(max, (_cursor$experimentalT = cursor.experimentalTimestampForStartOfLastMove()) !== null && _cursor$experimentalT !== void 0 ? _cursor$experimentalT : 0);
    }

    this.setTimestamp(max);
  }

  dispatchAction(event) {
    let locationType = TimestampLocationType.MiddleOfMove; // TODO

    switch (this.timestamp) {
      // TODO
      case this.minTimestamp():
        locationType = TimestampLocationType.StartOfTimeline;
        break;

      case this.maxTimestamp():
        locationType = TimestampLocationType.EndOfTimeline;
        break;
    }

    const actionEvent = {
      action: event,
      locationType
    };

    for (const listener of this.actionListeners) {
      listener.onTimelineAction(actionEvent);
    }
  }

}

exports.Timeline = Timeline;
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","./RenderScheduler":"1Xjlu","./cursor/CursorTypes":"3xGVw"}],"5NJ8b":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.TwistyControlButtonPanel = exports.TwistyControlButton = void 0;

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _CursorTypes = require("../../animation/cursor/CursorTypes");

var _Timeline = require("../../animation/Timeline");

var _ClassListManager = require("../element/ClassListManager");

var _ManagedCustomElement = require("../element/ManagedCustomElement");

var _nodeCustomElementShims = require("../element/node-custom-element-shims");

var _buttons = require("./buttons.css");

class TwistyControlButton extends _ManagedCustomElement.ManagedCustomElement {
  constructor(timeline, timelineCommand, options) {
    var _options$fullscreenEl, _options$visitTwizzle;

    super();
    (0, _defineProperty2.default)(this, "timeline", void 0);
    (0, _defineProperty2.default)(this, "timelineCommand", void 0);
    (0, _defineProperty2.default)(this, "currentIconName", null);
    (0, _defineProperty2.default)(this, "button", document.createElement("button"));
    (0, _defineProperty2.default)(this, "fullscreenElement", null);
    (0, _defineProperty2.default)(this, "visitTwizzleLinkCallback", null);
    this.fullscreenElement = (_options$fullscreenEl = options === null || options === void 0 ? void 0 : options.fullscreenElement) !== null && _options$fullscreenEl !== void 0 ? _options$fullscreenEl : null;
    this.visitTwizzleLinkCallback = (_options$visitTwizzle = options === null || options === void 0 ? void 0 : options.visitTwizzleLinkCallback) !== null && _options$visitTwizzle !== void 0 ? _options$visitTwizzle : null;

    if (!timeline) {
      console.warn("Must have timeline!"); // TODO
    }

    this.timeline = timeline;

    if (!timelineCommand) {
      console.warn("Must have timelineCommand!"); // TODO
    }

    this.timelineCommand = timelineCommand;
    this.addCSS(_buttons.buttonCSS);
    this.setIcon(this.initialIcon());
    this.setHoverTitle(this.initialHoverTitle());
    this.addElement(this.button);
    this.addEventListener("click", this.onPress.bind(this));

    switch (this.timelineCommand) {
      case "fullscreen":
        if (!document.fullscreenEnabled) {
          this.button.disabled = true;
        }

        break;

      case "jump-to-start":
      case "play-step-backwards":
        this.button.disabled = true;
        break;
    }

    if (this.timeline) {
      // TODO
      this.timeline.addActionListener(this);

      switch (this.timelineCommand) {
        case "play-pause":
        case "play-step-backwards":
        case "play-step":
          this.timeline.addTimestampListener(this);
          break;
      }

      this.autoSetTimelineBasedDisabled();
    }
  } // TODO: Can we avoid duplicate calculations?


  autoSetTimelineBasedDisabled() {
    switch (this.timelineCommand) {
      case "jump-to-start":
      case "play-pause":
      case "play-step-backwards":
      case "play-step":
      case "jump-to-end":
        {
          const timeRange = this.timeline.timeRange();

          if (timeRange.start === timeRange.end) {
            this.button.disabled = true;
            return;
          }

          switch (this.timelineCommand) {
            case "jump-to-start":
            case "play-step-backwards":
              this.button.disabled = this.timeline.timestamp < this.timeline.maxTimestamp();
              break;

            case "jump-to-end":
            case "play-step":
              this.button.disabled = this.timeline.timestamp > this.timeline.minTimestamp();
              break;

            default:
              this.button.disabled = false;
          }

          break;
        }
    }
  }

  setIcon(buttonIconName) {
    if (this.currentIconName === buttonIconName) {
      return;
    }

    if (this.currentIconName) {
      this.button.classList.remove(`svg-${this.currentIconName}`);
    }

    this.button.classList.add(`svg-${buttonIconName}`);
    this.currentIconName = buttonIconName;
  }

  initialIcon() {
    const map = {
      "jump-to-start": "skip-to-start",
      "play-pause": "play",
      "play-step": "step-forward",
      "play-step-backwards": "step-backward",
      "jump-to-end": "skip-to-end",
      "fullscreen": "enter-fullscreen",
      "twizzle-link": "twizzle-tw"
    };
    return map[this.timelineCommand];
  }

  initialHoverTitle() {
    const map = {
      "jump-to-start": "Restart",
      "play-pause": "Play",
      "play-step": "Step forward",
      "play-step-backwards": "Step backward",
      "jump-to-end": "Skip to End",
      "fullscreen": "Enter fullscreen",
      "twizzle-link": "View at Twizzle"
    };
    return map[this.timelineCommand];
  }

  setHoverTitle(title) {
    this.button.title = title;
  }

  onPress() {
    switch (this.timelineCommand) {
      case "fullscreen":
        if (document.fullscreenElement === this.fullscreenElement) {
          document.exitFullscreen(); // this.setIcon("enter-fullscreen");
        } else {
          this.setIcon("exit-fullscreen");
          this.fullscreenElement.requestFullscreen().then(() => {
            const onFullscreen = () => {
              if (document.fullscreenElement !== this.fullscreenElement) {
                this.setIcon("enter-fullscreen");
                window.removeEventListener("fullscreenchange", onFullscreen);
              }
            };

            window.addEventListener("fullscreenchange", onFullscreen);
          });
        }

        break;

      case "jump-to-start":
        this.timeline.setTimestamp(0);
        break;

      case "jump-to-end":
        this.timeline.jumpToEnd();
        break;

      case "play-pause":
        this.timeline.playPause();
        break;

      case "play-step":
        this.timeline.experimentalPlay(_CursorTypes.Direction.Forwards, _CursorTypes.BoundaryType.Move);
        break;

      case "play-step-backwards":
        this.timeline.experimentalPlay(_CursorTypes.Direction.Backwards, _CursorTypes.BoundaryType.Move);
        break;

      case "twizzle-link":
        if (this.visitTwizzleLinkCallback) {
          this.visitTwizzleLinkCallback();
        }

        break;
    }
  }

  onTimelineAction(actionEvent) {
    switch (this.timelineCommand) {
      case "jump-to-start":
        // TODO: what if you're already playing?
        this.button.disabled = actionEvent.locationType === _Timeline.TimestampLocationType.StartOfTimeline && actionEvent.action !== _Timeline.TimelineAction.StartingToPlay;
        break;

      case "jump-to-end":
        this.button.disabled = actionEvent.locationType === _Timeline.TimestampLocationType.EndOfTimeline && actionEvent.action !== _Timeline.TimelineAction.StartingToPlay;
        break;

      case "play-pause":
        // Always enabled, since we will jump to the start if needed.
        switch (actionEvent.action) {
          case _Timeline.TimelineAction.Pausing:
            this.setIcon("play");
            this.setHoverTitle("Play");
            break;

          case _Timeline.TimelineAction.StartingToPlay:
            this.setIcon("pause");
            this.setHoverTitle("Pause");
            break;
          // TODO: does jumping mean pause?
        }

        break;

      case "play-step":
        // TODO: refine this
        this.button.disabled = actionEvent.locationType === _Timeline.TimestampLocationType.EndOfTimeline && actionEvent.action !== _Timeline.TimelineAction.StartingToPlay;
        break;

      case "play-step-backwards":
        // TODO: refine this
        this.button.disabled = actionEvent.locationType === _Timeline.TimestampLocationType.StartOfTimeline && actionEvent.action !== _Timeline.TimelineAction.StartingToPlay;
        break;
    }
  }

  onTimelineTimestampChange(_timestamp) {// Nothing
  }

  onTimeRangeChange(_timeRange) {
    // TODO
    this.autoSetTimelineBasedDisabled();
  }

}

exports.TwistyControlButton = TwistyControlButton;

_nodeCustomElementShims.customElementsShim.define("twisty-control-button", TwistyControlButton); // <twisty-control-button-grid>
// Usually a horizontal line.


var _viewerLinkClassListManager = new WeakMap();

class TwistyControlButtonPanel extends _ManagedCustomElement.ManagedCustomElement {
  constructor(timeline, options) {
    var _options$viewerLink;

    super();

    _viewerLinkClassListManager.set(this, {
      writable: true,
      value: new _ClassListManager.ClassListManager(this, "viewer-link-", ["none", "twizzle"])
    });

    this.addCSS(_buttons.buttonGridCSS);
    (0, _classPrivateFieldGet2.default)(this, _viewerLinkClassListManager).setValue((_options$viewerLink = options === null || options === void 0 ? void 0 : options.viewerLink) !== null && _options$viewerLink !== void 0 ? _options$viewerLink : "none"); // this.addElement(new TwistyControlButton(timeline!, fullscreenElement!));

    this.addElement(new TwistyControlButton(timeline, "fullscreen", {
      fullscreenElement: options === null || options === void 0 ? void 0 : options.fullscreenElement
    }));
    this.addElement(new TwistyControlButton(timeline, "jump-to-start"));
    this.addElement(new TwistyControlButton(timeline, "play-step-backwards"));
    this.addElement(new TwistyControlButton(timeline, "play-pause"));
    this.addElement(new TwistyControlButton(timeline, "play-step"));
    this.addElement(new TwistyControlButton(timeline, "jump-to-end"));
    this.addElement(new TwistyControlButton(timeline, "twizzle-link", {
      visitTwizzleLinkCallback: options === null || options === void 0 ? void 0 : options.viewerLinkCallback
    })).classList.add("twizzle-link-button");
    /*...*/
  }

  setViewerLink(viewerLink) {
    (0, _classPrivateFieldGet2.default)(this, _viewerLinkClassListManager).setValue(viewerLink);
  }

}

exports.TwistyControlButtonPanel = TwistyControlButtonPanel;

_nodeCustomElementShims.customElementsShim.define("twisty-control-button-panel", TwistyControlButtonPanel);
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/defineProperty":"55mTs","../../animation/cursor/CursorTypes":"3xGVw","../../animation/Timeline":"5Cj4O","../element/ClassListManager":"4ttu3","../element/ManagedCustomElement":"6Q6rX","../element/node-custom-element-shims":"3CBls","./buttons.css":"10W8F"}],"10W8F":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.buttonCSS = exports.buttonGridCSS = void 0;

var _ManagedCustomElement = require("../element/ManagedCustomElement");

const buttonGridCSS = new _ManagedCustomElement.CSSSource(`
:host {
  width: 384px;
  height: 24px;
  display: grid;
}

.wrapper {
  width: 100%;
  height: 100%;
  display: grid;
  overflow: hidden;
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
}

.wrapper {
  grid-auto-flow: column;
}

.viewer-link-none .twizzle-link-button {
  display: none;
}

.wrapper twisty-control-button {
  width: inherit;
  height: inherit;
}
`);
exports.buttonGridCSS = buttonGridCSS;
const buttonCSS = new _ManagedCustomElement.CSSSource(`
:host {
  width: 48px;
  height: 24px;
  display: grid;
}

.wrapper {
  width: 100%;
  height: 100%;
}

button {
  width: 100%;
  height: 100%;
  border: none;
  
  background-position: center;
  background-repeat: no-repeat;
  background-size: contain;

  background-color: rgba(196, 196, 196, 0.75);
}

button:enabled {
  background-color: rgba(196, 196, 196, 0.75)
}

button:disabled {
  background-color: rgba(0, 0, 0, 0.4);
  opacity: 0.25;
  pointer-events: none;
}

button:enabled:hover {
  background-color: rgba(255, 255, 255, 0.75);
  box-shadow: 0 0 1em rgba(0, 0, 0, 0.25);
  cursor: pointer;
}

/* TODO: fullscreen icons have too much padding?? */
button.svg-skip-to-start {
  background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzNTg0IiBoZWlnaHQ9IjM1ODQiIHZpZXdCb3g9IjAgMCAzNTg0IDM1ODQiPjxwYXRoIGQ9Ik0yNjQzIDEwMzdxMTktMTkgMzItMTN0MTMgMzJ2MTQ3MnEwIDI2LTEzIDMydC0zMi0xM2wtNzEwLTcxMHEtOS05LTEzLTE5djcxMHEwIDI2LTEzIDMydC0zMi0xM2wtNzEwLTcxMHEtOS05LTEzLTE5djY3OHEwIDI2LTE5IDQ1dC00NSAxOUg5NjBxLTI2IDAtNDUtMTl0LTE5LTQ1VjEwODhxMC0yNiAxOS00NXQ0NS0xOWgxMjhxMjYgMCA0NSAxOXQxOSA0NXY2NzhxNC0xMSAxMy0xOWw3MTAtNzEwcTE5LTE5IDMyLTEzdDEzIDMydjcxMHE0LTExIDEzLTE5eiIvPjwvc3ZnPg==");
}

button.svg-skip-to-end {
  background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzNTg0IiBoZWlnaHQ9IjM1ODQiIHZpZXdCb3g9IjAgMCAzNTg0IDM1ODQiPjxwYXRoIGQ9Ik05NDEgMjU0N3EtMTkgMTktMzIgMTN0LTEzLTMyVjEwNTZxMC0yNiAxMy0zMnQzMiAxM2w3MTAgNzEwcTggOCAxMyAxOXYtNzEwcTAtMjYgMTMtMzJ0MzIgMTNsNzEwIDcxMHE4IDggMTMgMTl2LTY3OHEwLTI2IDE5LTQ1dDQ1LTE5aDEyOHEyNiAwIDQ1IDE5dDE5IDQ1djE0MDhxMCAyNi0xOSA0NXQtNDUgMTloLTEyOHEtMjYgMC00NS0xOXQtMTktNDV2LTY3OHEtNSAxMC0xMyAxOWwtNzEwIDcxMHEtMTkgMTktMzIgMTN0LTEzLTMydi03MTBxLTUgMTAtMTMgMTl6Ii8+PC9zdmc+");
}

button.svg-step-forward {
  background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzNTg0IiBoZWlnaHQ9IjM1ODQiIHZpZXdCb3g9IjAgMCAzNTg0IDM1ODQiPjxwYXRoIGQ9Ik0yNjg4IDE1NjhxMCAyNi0xOSA0NWwtNTEyIDUxMnEtMTkgMTktNDUgMTl0LTQ1LTE5cS0xOS0xOS0xOS00NXYtMjU2aC0yMjRxLTk4IDAtMTc1LjUgNnQtMTU0IDIxLjVxLTc2LjUgMTUuNS0xMzMgNDIuNXQtMTA1LjUgNjkuNXEtNDkgNDIuNS04MCAxMDF0LTQ4LjUgMTM4LjVxLTE3LjUgODAtMTcuNSAxODEgMCA1NSA1IDEyMyAwIDYgMi41IDIzLjV0Mi41IDI2LjVxMCAxNS04LjUgMjV0LTIzLjUgMTBxLTE2IDAtMjgtMTctNy05LTEzLTIydC0xMy41LTMwcS03LjUtMTctMTAuNS0yNC0xMjctMjg1LTEyNy00NTEgMC0xOTkgNTMtMzMzIDE2Mi00MDMgODc1LTQwM2gyMjR2LTI1NnEwLTI2IDE5LTQ1dDQ1LTE5cTI2IDAgNDUgMTlsNTEyIDUxMnExOSAxOSAxOSA0NXoiLz48L3N2Zz4=");
}

button.svg-step-backward {
  background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzNTg0IiBoZWlnaHQ9IjM1ODQiIHZpZXdCb3g9IjAgMCAzNTg0IDM1ODQiPjxwYXRoIGQ9Ik0yNjg4IDIwNDhxMCAxNjYtMTI3IDQ1MS0zIDctMTAuNSAyNHQtMTMuNSAzMHEtNiAxMy0xMyAyMi0xMiAxNy0yOCAxNy0xNSAwLTIzLjUtMTB0LTguNS0yNXEwLTkgMi41LTI2LjV0Mi41LTIzLjVxNS02OCA1LTEyMyAwLTEwMS0xNy41LTE4MXQtNDguNS0xMzguNXEtMzEtNTguNS04MC0xMDF0LTEwNS41LTY5LjVxLTU2LjUtMjctMTMzLTQyLjV0LTE1NC0yMS41cS03Ny41LTYtMTc1LjUtNmgtMjI0djI1NnEwIDI2LTE5IDQ1dC00NSAxOXEtMjYgMC00NS0xOWwtNTEyLTUxMnEtMTktMTktMTktNDV0MTktNDVsNTEyLTUxMnExOS0xOSA0NS0xOXQ0NSAxOXExOSAxOSAxOSA0NXYyNTZoMjI0cTcxMyAwIDg3NSA0MDMgNTMgMTM0IDUzIDMzM3oiLz48L3N2Zz4=");
}

button.svg-pause {
  background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzNTg0IiBoZWlnaHQ9IjM1ODQiIHZpZXdCb3g9IjAgMCAzNTg0IDM1ODQiPjxwYXRoIGQ9Ik0yNTYwIDEwODh2MTQwOHEwIDI2LTE5IDQ1dC00NSAxOWgtNTEycS0yNiAwLTQ1LTE5dC0xOS00NVYxMDg4cTAtMjYgMTktNDV0NDUtMTloNTEycTI2IDAgNDUgMTl0MTkgNDV6bS04OTYgMHYxNDA4cTAgMjYtMTkgNDV0LTQ1IDE5aC01MTJxLTI2IDAtNDUtMTl0LTE5LTQ1VjEwODhxMC0yNiAxOS00NXQ0NS0xOWg1MTJxMjYgMCA0NSAxOXQxOSA0NXoiLz48L3N2Zz4=");
}

button.svg-play {
  background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzNTg0IiBoZWlnaHQ9IjM1ODQiIHZpZXdCb3g9IjAgMCAzNTg0IDM1ODQiPjxwYXRoIGQ9Ik0yNDcyLjUgMTgyM2wtMTMyOCA3MzhxLTIzIDEzLTM5LjUgM3QtMTYuNS0zNlYxMDU2cTAtMjYgMTYuNS0zNnQzOS41IDNsMTMyOCA3MzhxMjMgMTMgMjMgMzF0LTIzIDMxeiIvPjwvc3ZnPg==");
}

button.svg-enter-fullscreen {
  background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMjgiIHZpZXdCb3g9IjAgMCAyOCAyOCIgd2lkdGg9IjI4Ij48cGF0aCBkPSJNMiAyaDI0djI0SDJ6IiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTkgMTZIN3Y1aDV2LTJIOXYtM3ptLTItNGgyVjloM1Y3SDd2NXptMTIgN2gtM3YyaDV2LTVoLTJ2M3pNMTYgN3YyaDN2M2gyVjdoLTV6Ii8+PC9zdmc+");
}

button.svg-exit-fullscreen {
  background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMjgiIHZpZXdCb3g9IjAgMCAyOCAyOCIgd2lkdGg9IjI4Ij48cGF0aCBkPSJNMiAyaDI0djI0SDJ6IiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTcgMThoM3YzaDJ2LTVIN3Yyem0zLThIN3YyaDVWN2gtMnYzem02IDExaDJ2LTNoM3YtMmgtNXY1em0yLTExVjdoLTJ2NWg1di0yaC0zeiIvPjwvc3ZnPg==");
}

button.svg-twizzle-tw {
  background-image: url("data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODY0IiBoZWlnaHQ9IjYwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMzk3LjU4MSAxNTEuMTh2NTcuMDg0aC04OS43MDN2MjQwLjM1MmgtNjYuOTU1VjIwOC4yNjRIMTUxLjIydi01Ny4wODNoMjQ2LjM2MXptNTQuMzEgNzEuNjc3bDcuNTEyIDMzLjY5MmMyLjcxOCAxMi4xNiA1LjU4IDI0LjY4IDguNTg0IDM3LjU1NWEyMTgwLjc3NSAyMTgwLjc3NSAwIDAwOS40NDIgMzguODQzIDEyNjYuMyAxMjY2LjMgMCAwMDEwLjA4NiAzNy41NTVjMy43Mi0xMi41OSA3LjM2OC0yNS40NjYgMTAuOTQ1LTM4LjYyOCAzLjU3Ni0xMy4xNjIgNy4wMS0yNi4xMSAxMC4zLTM4Ljg0M2w1Ljc2OS0yMi40NTZjMS4yNDgtNC44ODcgMi40NzItOS43MDUgMy42NzQtMTQuNDU1IDMuMDA0LTExLjg3NSA1LjY1MS0yMi45NjIgNy45NC0zMy4yNjNoNDYuMzU0bDIuMzg0IDEwLjU2M2EyMDAwLjc3IDIwMDAuNzcgMCAwMDMuOTM1IDE2LjgyOGw2LjcxMSAyNy43MWMxLjIxMyA0Ljk1NiAyLjQ1IDkuOTggMy43MDkgMTUuMDczYTMxMTkuNzc3IDMxMTkuNzc3IDAgMDA5Ljg3MSAzOC44NDMgMTI0OS4yMjcgMTI0OS4yMjcgMCAwMDEwLjczIDM4LjYyOCAxOTA3LjYwNSAxOTA3LjYwNSAwIDAwMTAuMzAxLTM3LjU1NSAxMzk3Ljk0IDEzOTcuOTQgMCAwMDkuNjU3LTM4Ljg0M2w0LjQtMTkuMDQ2Yy43MTUtMy4xMyAxLjQyMS02LjIzNiAyLjExOC05LjMyMWw5LjU3Ny00Mi44OGg2Ni41MjZhMjk4OC43MTggMjk4OC43MTggMCAwMS0xOS41MjkgNjYuMzExbC01LjcyOCAxOC40ODJhMzIzNy40NiAzMjM3LjQ2IDAgMDEtMTQuMDE1IDQzLjc1MmMtNi40MzggMTkuNi0xMi43MzMgMzcuNjk4LTE4Ljg4NSA1NC4yOTRsLTMuMzA2IDguODI1Yy00Ljg4NCAxMi44OTgtOS40MzMgMjQuMjYzLTEzLjY0NyAzNC4wOTVoLTQ5Ljc4N2E4NDE3LjI4OSA4NDE3LjI4OSAwIDAxLTIxLjAzMS02NC44MDkgMTI4OC42ODYgMTI4OC42ODYgMCAwMS0xOC44ODUtNjQuODEgMTk3Mi40NDQgMTk3Mi40NDQgMCAwMS0xOC4yNCA2NC44MSAyNTc5LjQxMiAyNTc5LjQxMiAwIDAxLTIwLjM4OCA2NC44MWgtNDkuNzg3Yy00LjY4Mi0xMC45MjYtOS43Mi0yMy43NDMtMTUuMTEtMzguNDUxbC0xLjYyOS00LjQ3Yy01LjI1OC0xNC41MjEtMTAuNjgtMzAuMTkyLTE2LjI2Ni00Ny4wMTRsLTIuNDA0LTcuMjhjLTYuNDM4LTE5LjYtMTMuMDItNDAuMzQ0LTE5Ljc0My02Mi4yMzRhMjk4OC43MDcgMjk4OC43MDcgMCAwMS0xOS41MjktNjYuMzExaDY3LjM4NXoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjwvc3ZnPg==");
}
`); // Sized against full-screen dimensions.
// button.svg-twizzle-tw {
//   background-image: url("data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNzc3IiBoZWlnaHQ9IjUxMyIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMzU0LjU4MSAxMDcuMTh2NTcuMDg0aC04OS43MDN2MjQwLjM1MmgtNjYuOTU1VjE2NC4yNjRIMTA4LjIydi01Ny4wODNoMjQ2LjM2MXptNTQuMzEgNzEuNjc3bDcuNTEyIDMzLjY5MmMyLjcxOCAxMi4xNiA1LjU4IDI0LjY4IDguNTg0IDM3LjU1NWEyMTgwLjc3NSAyMTgwLjc3NSAwIDAwOS40NDIgMzguODQzIDEyNjYuMyAxMjY2LjMgMCAwMDEwLjA4NiAzNy41NTVjMy43Mi0xMi41OSA3LjM2OC0yNS40NjYgMTAuOTQ1LTM4LjYyOCAzLjU3Ni0xMy4xNjIgNy4wMS0yNi4xMSAxMC4zLTM4Ljg0M2w1Ljc2OS0yMi40NTZjMS4yNDgtNC44ODcgMi40NzItOS43MDUgMy42NzQtMTQuNDU1IDMuMDA0LTExLjg3NSA1LjY1MS0yMi45NjIgNy45NC0zMy4yNjNoNDYuMzU0bDIuMzg0IDEwLjU2M2EyMDAwLjc3IDIwMDAuNzcgMCAwMDMuOTM1IDE2LjgyOGw2LjcxMSAyNy43MWMxLjIxMyA0Ljk1NiAyLjQ1IDkuOTggMy43MDkgMTUuMDczYTMxMTkuNzc3IDMxMTkuNzc3IDAgMDA5Ljg3MSAzOC44NDMgMTI0OS4yMjcgMTI0OS4yMjcgMCAwMDEwLjczIDM4LjYyOCAxOTA3LjYwNSAxOTA3LjYwNSAwIDAwMTAuMzAxLTM3LjU1NSAxMzk3Ljk0IDEzOTcuOTQgMCAwMDkuNjU3LTM4Ljg0M2w0LjQtMTkuMDQ2Yy43MTUtMy4xMyAxLjQyMS02LjIzNiAyLjExOC05LjMyMWw5LjU3Ny00Mi44OGg2Ni41MjZhMjk4OC43MTggMjk4OC43MTggMCAwMS0xOS41MjkgNjYuMzExbC01LjcyOCAxOC40ODJhMzIzNy40NiAzMjM3LjQ2IDAgMDEtMTQuMDE1IDQzLjc1MmMtNi40MzggMTkuNi0xMi43MzMgMzcuNjk4LTE4Ljg4NSA1NC4yOTRsLTMuMzA2IDguODI1Yy00Ljg4NCAxMi44OTgtOS40MzMgMjQuMjYzLTEzLjY0NyAzNC4wOTVoLTQ5Ljc4N2E4NDE3LjI4OSA4NDE3LjI4OSAwIDAxLTIxLjAzMS02NC44MDkgMTI4OC42ODYgMTI4OC42ODYgMCAwMS0xOC44ODUtNjQuODEgMTk3Mi40NDQgMTk3Mi40NDQgMCAwMS0xOC4yNCA2NC44MSAyNTc5LjQxMiAyNTc5LjQxMiAwIDAxLTIwLjM4OCA2NC44MWgtNDkuNzg3Yy00LjY4Mi0xMC45MjYtOS43Mi0yMy43NDMtMTUuMTEtMzguNDUxbC0xLjYyOS00LjQ3Yy01LjI1OC0xNC41MjEtMTAuNjgtMzAuMTkyLTE2LjI2Ni00Ny4wMTRsLTIuNDA0LTcuMjhjLTYuNDM4LTE5LjYtMTMuMDItNDAuMzQ0LTE5Ljc0My02Mi4yMzRhMjk4OC43MDcgMjk4OC43MDcgMCAwMS0xOS41MjktNjYuMzExaDY3LjM4NXoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjwvc3ZnPg==");
// }

exports.buttonCSS = buttonCSS;
},{"../element/ManagedCustomElement":"6Q6rX"}],"5KyY7":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.TwistyScrubber = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _ManagedCustomElement = require("../element/ManagedCustomElement");

var _nodeCustomElementShims = require("../element/node-custom-element-shims");

var _TwistyScrubber = require("./TwistyScrubber.css");

// <twisty-scrubber>
// Usually a horizontal line.
class TwistyScrubber extends _ManagedCustomElement.ManagedCustomElement {
  // type="range"
  constructor(timeline) {
    var _this$timeline, _this$timeline2, _this$timeline3, _this$timeline4;

    super();
    (0, _defineProperty2.default)(this, "timeline", void 0);
    (0, _defineProperty2.default)(this, "range", document.createElement("input"));
    this.timeline = timeline; // TODO

    this.addCSS(_TwistyScrubber.twistyScrubberCSS);
    (_this$timeline = this.timeline) === null || _this$timeline === void 0 ? void 0 : _this$timeline.addTimestampListener(this); // TODO

    this.range.type = "range";
    this.range.step = 1 .toString();
    this.range.min = (_this$timeline2 = this.timeline) === null || _this$timeline2 === void 0 ? void 0 : _this$timeline2.minTimestamp().toString(); // TODO

    this.range.max = (_this$timeline3 = this.timeline) === null || _this$timeline3 === void 0 ? void 0 : _this$timeline3.maxTimestamp().toString(); // TODO

    this.range.value = (_this$timeline4 = this.timeline) === null || _this$timeline4 === void 0 ? void 0 : _this$timeline4.timestamp.toString(); // TODO

    this.range.addEventListener("input", this.onInput.bind(this));
    this.addElement(this.range);
  }

  onTimelineTimestampChange(timestamp) {
    this.range.value = timestamp.toString();
  }

  onTimeRangeChange(timeRange) {
    this.range.min = timeRange.start.toString();
    this.range.max = timeRange.end.toString();
  }

  onInput() {
    this.timeline.setTimestamp(parseInt(this.range.value, 10));
  }

}

exports.TwistyScrubber = TwistyScrubber;

_nodeCustomElementShims.customElementsShim.define("twisty-scrubber", TwistyScrubber);
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","../element/ManagedCustomElement":"6Q6rX","../element/node-custom-element-shims":"3CBls","./TwistyScrubber.css":"6OMS0"}],"6OMS0":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.twistyScrubberCSS = void 0;

var _ManagedCustomElement = require("../element/ManagedCustomElement");

const twistyScrubberCSS = new _ManagedCustomElement.CSSSource(`
:host {
  width: 384px;
  height: 16px;
  display: grid;
}

.wrapper {
  width: 100%;
  height: 100%;
  display: grid;
  overflow: hidden;
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
}

input {
  margin: 0; width: 100%;
}

input {
  background: none;
}

::-moz-range-track {
  background: rgba(0, 0, 0, 0.25);
  height: 50%;
  border: 1px solid rgba(0, 0, 0, 0.1);
}

::-webkit-slider-runnable-track {
  background: rgba(0, 0, 0, 0.05);
}

::-moz-range-progress {
  background: #3273F6;
  height: 50%;
  border: 1px solid rgba(0, 0, 0, 0.1);
}

::-ms-fill-lower {
  background: #3273F6;
  height: 50%;
  border: 1px solid rgba(0, 0, 0, 0.1);
}
`);
exports.twistyScrubberCSS = twistyScrubberCSS;
},{"../element/ManagedCustomElement":"6Q6rX"}],"7doiv":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.twistyPlayerCSS = void 0;

var _ManagedCustomElement = require("./element/ManagedCustomElement");

// TODO: figure out why `:host(twisty-player):fullscreen { background-color: white }` doesn't work.
const twistyPlayerCSS = new _ManagedCustomElement.CSSSource(`
:host {
  width: 384px;
  height: 256px;
  display: grid;
}

.wrapper {
  display: grid;
  overflow: hidden;
  grid-template-rows: 7fr 1em 1fr;
}

.wrapper > * {
  width: inherit;
  height: inherit;
  overflow: hidden;
}

.wrapper.controls-none {
  grid-template-rows: 7fr;
}

.wrapper.controls-none twisty-scrubber,
.wrapper.controls-none twisty-control-button-panel {
  display: none;
}

twisty-scrubber {
  background: rgba(196, 196, 196, 0.5);
}

.wrapper.checkered {
  background-color: #EAEAEA;
  background-image: linear-gradient(45deg, #DDD 25%, transparent 25%, transparent 75%, #DDD 75%, #DDD),
    linear-gradient(45deg, #DDD 25%, transparent 25%, transparent 75%, #DDD 75%, #DDD);
  background-size: 32px 32px;
  background-position: 0 0, 16px 16px;
}
`);
exports.twistyPlayerCSS = twistyPlayerCSS;
},{"./element/ManagedCustomElement":"6Q6rX"}],"1AIRW":[function(require,module,exports) {
"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Twisty2DSVG = void 0;

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _classPrivateFieldGet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldGet"));

var _classPrivateFieldSet2 = _interopRequireDefault(require("@babel/runtime/helpers/classPrivateFieldSet"));

var _kpuzzle = require("../../../kpuzzle");

var _CursorTypes = require("../../animation/cursor/CursorTypes");

var _RenderScheduler = require("../../animation/RenderScheduler");

var _ManagedCustomElement = require("../element/ManagedCustomElement");

var _nodeCustomElementShims = require("../element/node-custom-element-shims");

var _Twisty2DSVGView = require("./Twisty2DSVGView.css");

var _cachedPosition = new WeakMap();

// <twisty-2d-svg>
class Twisty2DSVG extends _ManagedCustomElement.ManagedCustomElement {
  // TODO: pull when needed.
  constructor(cursor, def, svgSource, options, puzzleLoader) {
    var _this$options;

    super();
    this.svgSource = svgSource;
    this.options = options;
    this.puzzleLoader = puzzleLoader;
    (0, _defineProperty2.default)(this, "definition", void 0);
    (0, _defineProperty2.default)(this, "svg", void 0);
    (0, _defineProperty2.default)(this, "scheduler", new _RenderScheduler.RenderScheduler(this.render.bind(this)));

    _cachedPosition.set(this, {
      writable: true,
      value: null
    });

    this.addCSS(_Twisty2DSVGView.twisty2DSVGCSS);
    this.definition = def;
    this.resetSVG(); // TODO

    cursor === null || cursor === void 0 ? void 0 : cursor.addPositionListener(this); // TODO

    if ((_this$options = this.options) === null || _this$options === void 0 ? void 0 : _this$options.experimentalStickering) {
      this.experimentalSetStickering(this.options.experimentalStickering);
    }
  } // eslint-disable-next-line @typescript-eslint/no-unused-vars-experimental


  onPositionChange(position) {
    if (position.movesInProgress.length > 0) {
      const move = position.movesInProgress[0].move;
      const def = this.definition;
      let partialMove = move;

      if (position.movesInProgress[0].direction === _CursorTypes.Direction.Backwards) {
        partialMove = move.invert();
      }

      const newState = (0, _kpuzzle.combineTransformations)(def, position.state, (0, _kpuzzle.transformationForMove)(def, partialMove)); // TODO: move to render()

      this.svg.draw(this.definition, position.state, newState, position.movesInProgress[0].fraction);
    } else {
      this.svg.draw(this.definition, position.state);
      (0, _classPrivateFieldSet2.default)(this, _cachedPosition, position);
    }
  }

  scheduleRender() {
    this.scheduler.requestAnimFrame();
  }

  experimentalSetStickering(stickering) {
    (async () => {
      var _this$puzzleLoader;

      if (!((_this$puzzleLoader = this.puzzleLoader) === null || _this$puzzleLoader === void 0 ? void 0 : _this$puzzleLoader.appearance)) {
        return;
      }

      const appearance = await this.puzzleLoader.appearance(stickering);
      this.resetSVG(appearance);
    })();
  } // TODO: do this without constructing a new SVG.


  resetSVG(appearance) {
    if (this.svg) {
      this.removeElement(this.svg.element);
    }

    if (!this.definition) {
      return; // TODO
    }

    this.svg = new _kpuzzle.KPuzzleSVGWrapper(this.definition, this.svgSource, appearance); // TODO

    this.addElement(this.svg.element);

    if ((0, _classPrivateFieldGet2.default)(this, _cachedPosition)) {
      this.onPositionChange((0, _classPrivateFieldGet2.default)(this, _cachedPosition));
    }
  }

  render() {
    /*...*/
  }

}

exports.Twisty2DSVG = Twisty2DSVG;

_nodeCustomElementShims.customElementsShim.define("twisty-2d-svg", Twisty2DSVG);
},{"@babel/runtime/helpers/interopRequireDefault":"5NNmD","@babel/runtime/helpers/defineProperty":"55mTs","@babel/runtime/helpers/classPrivateFieldGet":"5PNvM","@babel/runtime/helpers/classPrivateFieldSet":"2m3hn","../../../kpuzzle":"4ZRD3","../../animation/cursor/CursorTypes":"3xGVw","../../animation/RenderScheduler":"1Xjlu","../element/ManagedCustomElement":"6Q6rX","../element/node-custom-element-shims":"3CBls","./Twisty2DSVGView.css":"72tfO"}],"72tfO":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.twisty2DSVGCSS = void 0;

var _ManagedCustomElement = require("../element/ManagedCustomElement");

// TODO: Can we do this without so much nesting, and styling all the nested elems?
const twisty2DSVGCSS = new _ManagedCustomElement.CSSSource(`
:host {
  width: 384px;
  height: 256px;
  display: grid;
}

.wrapper {
  width: 100%;
  height: 100%;
  display: grid;
  overflow: hidden;
}

.svg-wrapper,
twisty-2d-svg,
svg {
  width: 100%;
  height: 100%;
  display: grid;
  min-height: 0;
}
`);
exports.twisty2DSVGCSS = twisty2DSVGCSS;
},{"../element/ManagedCustomElement":"6Q6rX"}]},{},[], null, "parcelRequire0395")

//# sourceMappingURL=index.3a4f7a9b.js.map
