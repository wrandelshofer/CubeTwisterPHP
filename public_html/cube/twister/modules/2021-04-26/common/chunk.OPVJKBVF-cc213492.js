import { B as BlockMove } from './chunk.RSGKTTJ7-5cf68302.js';

// src/cubing/alg/operation.ts
function modifiedBlockMove(original, modifications) {
  var _a, _b, _c, _d;
  return new BlockMove((_a = modifications.outerLayer) != null ? _a : original.outerLayer, (_b = modifications.innerLayer) != null ? _b : original.innerLayer, (_c = modifications.family) != null ? _c : original.family, (_d = modifications.amount) != null ? _d : original.amount);
}

export { modifiedBlockMove as m };
