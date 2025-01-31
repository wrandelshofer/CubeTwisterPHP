import { C as Combine } from './chunk.2VGDWMHM-ce7c26fb.js';

// src/cubing/kpuzzle/svg.ts
var xmlns = "http://www.w3.org/2000/svg";
var svgCounter = 0;
function nextSVGID() {
  svgCounter += 1;
  return "svg" + svgCounter.toString();
}
var colorMaps = {
  dim: {
    white: "#dddddd",
    orange: "#884400",
    limegreen: "#008800",
    red: "#660000",
    "rgb(34, 102, 255)": "#000088",
    yellow: "#888800"
  },
  oriented: {
    white: "#ff88ff",
    orange: "#ff88ff",
    limegreen: "#ff88ff",
    red: "#ff88ff",
    "rgb(34, 102, 255)": "#ff88ff",
    yellow: "#ff88ff"
  },
  ignored: {
    white: "#444444",
    orange: "#444444",
    limegreen: "#444444",
    red: "#444444",
    "rgb(34, 102, 255)": "#444444",
    yellow: "#444444"
  },
  invisible: {
    white: "#00000000",
    orange: "#00000000",
    limegreen: "#00000000",
    red: "#00000000",
    "rgb(34, 102, 255)": "#00000000",
    yellow: "#00000000"
  }
};
var SVG = class {
  constructor(kPuzzleDefinition, svgSource, experimentalAppearance) {
    this.kPuzzleDefinition = kPuzzleDefinition;
    this.originalColors = {};
    this.gradients = {};
    if (!svgSource) {
      throw new Error(`No SVG definition for puzzle type: ${kPuzzleDefinition.name}`);
    }
    this.svgID = nextSVGID();
    this.element = document.createElement("div");
    this.element.classList.add("svg-wrapper");
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
          let originalColor = elem.style.fill;
          if (experimentalAppearance) {
            (() => {
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
              const appearance = typeof faceletAppearance === "string" ? faceletAppearance : faceletAppearance == null ? void 0 : faceletAppearance.appearance;
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
  }
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
              singleColor = true;
            }
            fraction = fraction || 0;
            const easedBackwardsPercent = 100 * (1 - fraction * fraction * (2 - fraction * fraction));
            this.gradients[id].children[0].setAttribute("stop-color", this.originalColors[fromCur]);
            this.gradients[id].children[1].setAttribute("stop-color", this.originalColors[fromCur]);
            this.gradients[id].children[1].setAttribute("offset", `${Math.max(easedBackwardsPercent - 5, 0)}%`);
            this.gradients[id].children[2].setAttribute("offset", `${Math.max(easedBackwardsPercent - 5, 0)}%`);
            this.gradients[id].children[3].setAttribute("offset", `${easedBackwardsPercent}%`);
            this.gradients[id].children[4].setAttribute("offset", `${easedBackwardsPercent}%`);
            this.gradients[id].children[4].setAttribute("stop-color", this.originalColors[fromNext]);
            this.gradients[id].children[5].setAttribute("stop-color", this.originalColors[fromNext]);
          } else {
            singleColor = true;
          }
          if (singleColor) {
            this.gradients[id].children[0].setAttribute("stop-color", this.originalColors[fromCur]);
            this.gradients[id].children[1].setAttribute("stop-color", this.originalColors[fromCur]);
            this.gradients[id].children[1].setAttribute("offset", `100%`);
            this.gradients[id].children[2].setAttribute("offset", `100%`);
            this.gradients[id].children[3].setAttribute("offset", `100%`);
            this.gradients[id].children[4].setAttribute("offset", `100%`);
          }
        }
      }
    }
  }
  newGradient(id, originalColor) {
    const grad = document.createElementNS(xmlns, "radialGradient");
    grad.setAttribute("id", `grad-${this.svgID}-${id}`);
    grad.setAttribute("r", `70.7107%`);
    const stopDefs = [
      {offset: 0, color: originalColor},
      {offset: 0, color: originalColor},
      {offset: 0, color: "black"},
      {offset: 0, color: "black"},
      {offset: 0, color: originalColor},
      {offset: 100, color: originalColor}
    ];
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
    return this.element.querySelector("#" + id);
  }
};

// src/cubing/kpuzzle/transformations.ts
function EquivalentOrbitTransformations(def, orbitName, t1, t2, options = {}) {
  const oDef = def.orbits[orbitName];
  const o1 = t1[orbitName];
  const o2 = t2[orbitName];
  for (let idx = 0; idx < oDef.numPieces; idx++) {
    if (!(options == null ? void 0 : options.ignoreOrientation) && o1.orientation[idx] !== o2.orientation[idx]) {
      return false;
    }
    if (!(options == null ? void 0 : options.ignorePermutation) && o1.permutation[idx] !== o2.permutation[idx]) {
      return false;
    }
  }
  return true;
}
function EquivalentTransformations(def, t1, t2) {
  for (const orbitName in def.orbits) {
    if (!EquivalentOrbitTransformations(def, orbitName, t1, t2)) {
      return false;
    }
  }
  return true;
}
function EquivalentStates(def, t1, t2) {
  return EquivalentTransformations(def, Combine(def, def.startPieces, t1), Combine(def, def.startPieces, t2));
}

export { EquivalentTransformations as E, SVG as S, EquivalentOrbitTransformations as a, EquivalentStates as b };
