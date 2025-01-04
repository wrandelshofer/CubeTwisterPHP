import { c as cube3x3x3KPuzzle } from './chunk.IZKEXG6K-9f5d428e.js';

var __async = (__this, __arguments, generator) => {
  return new Promise((resolve, reject) => {
    var fulfilled = (value) => {
      try {
        step(generator.next(value));
      } catch (e) {
        reject(e);
      }
    };
    var rejected = (value) => {
      try {
        step(generator.throw(value));
      } catch (e) {
        reject(e);
      }
    };
    var step = (result) => {
      return result.done ? resolve(result.value) : Promise.resolve(result.value).then(fulfilled, rejected);
    };
    step((generator = generator.apply(__this, __arguments)).next());
  });
};

// src/cubing/puzzles/async/async-pg3d.ts
function asyncGetPuzzleGeometry(puzzleName) {
  return __async(this, null, function* () {
    const puzzleGeometry = yield import('../cubing/puzzle-geometry.js');
    return puzzleGeometry.getPuzzleGeometryByName(puzzleName, [
      "allmoves",
      "true",
      "orientcenters",
      "true"
    ]);
  });
}
function asyncGetDef(puzzleName) {
  return __async(this, null, function* () {
    return (yield asyncGetPuzzleGeometry(puzzleName)).writekpuzzle(true);
  });
}

// src/cubing/puzzles/implementations/2x2x2/index.ts
var cube2x2x2 = {
  id: "2x2x2",
  fullName: "2\xD72\xD72 Cube",
  def: () => __async(void 0, null, function* () {
    return yield import('./2x2x2.kpuzzle-4e97b1b8.js');
  }),
  svg: () => __async(void 0, null, function* () {
    return (yield import('./2x2x2.kpuzzle.svg-e446a3b5.js')).default;
  }),
  pg: () => __async(void 0, null, function* () {
    return asyncGetPuzzleGeometry("2x2x2");
  })
};

// src/cubing/puzzles/implementations/3x3x3/index.ts
var cube3x3x3 = {
  id: "3x3x3",
  fullName: "3\xD73\xD73 Cube",
  inventedBy: ["Ern\u0151 Rubik"],
  inventionYear: 1974,
  def: () => __async(void 0, null, function* () {
    return cube3x3x3KPuzzle;
  }),
  svg: () => __async(void 0, null, function* () {
    return (yield import('./3x3x3.kpuzzle.svg-a74f8e75.js')).default;
  }),
  llSVG: () => __async(void 0, null, function* () {
    return (yield import('./3x3x3-ll.kpuzzle.svg-3bccf4f6.js')).default;
  }),
  pg: () => __async(void 0, null, function* () {
    return asyncGetPuzzleGeometry("3x3x3");
  })
};

// src/cubing/puzzles/implementations/4x4x4/index.ts
var cube4x4x4 = {
  id: "4x4x4",
  fullName: "4\xD74\xD74 Cube",
  def: () => __async(void 0, null, function* () {
    return asyncGetDef("4x4x4");
  }),
  svg: () => __async(void 0, null, function* () {
    throw "Unimplemented!";
  }),
  pg: () => __async(void 0, null, function* () {
    return asyncGetPuzzleGeometry("4x4x4");
  })
};

// src/cubing/puzzles/implementations/5x5x5/index.ts
var cube5x5x5 = {
  id: "5x5x5",
  fullName: "5\xD75\xD75 Cube",
  def: () => __async(void 0, null, function* () {
    return asyncGetDef("5x5x5");
  }),
  svg: () => __async(void 0, null, function* () {
    throw "Unimplemented!";
  }),
  pg: () => __async(void 0, null, function* () {
    return asyncGetPuzzleGeometry("5x5x5");
  })
};

// src/cubing/puzzles/implementations/6x6x6/index.ts
var cube6x6x6 = {
  id: "6x6x6",
  fullName: "6\xD76\xD76 Cube",
  def: () => __async(void 0, null, function* () {
    return asyncGetDef("6x6x6");
  }),
  svg: () => __async(void 0, null, function* () {
    throw "Unimplemented!";
  }),
  pg: () => __async(void 0, null, function* () {
    return asyncGetPuzzleGeometry("6x6x6");
  })
};

// src/cubing/puzzles/implementations/7x7x7/index.ts
var cube7x7x7 = {
  id: "7x7x7",
  fullName: "7\xD77\xD77 Cube",
  def: () => __async(void 0, null, function* () {
    return asyncGetDef("7x7x7");
  }),
  svg: () => __async(void 0, null, function* () {
    throw "Unimplemented!";
  }),
  pg: () => __async(void 0, null, function* () {
    return asyncGetPuzzleGeometry("7x7x7");
  })
};

// src/cubing/puzzles/implementations/clock/index.ts
var clock = {
  id: "clock",
  fullName: "Clock",
  inventedBy: ["Christopher C. Wiggs", "Christopher J. Taylor"],
  inventionYear: 1988,
  def: () => __async(void 0, null, function* () {
    return yield import('./clock.kpuzzle-e1cfcdcc.js');
  }),
  svg: () => __async(void 0, null, function* () {
    return (yield import('./clock.kpuzzle.svg-5e77f213.js')).default;
  })
};

// src/cubing/puzzles/implementations/fto/index.ts
var fto = {
  id: "fto",
  fullName: "Face-Turning Octahedron",
  inventedBy: ["Karl Rohrbach", "David Pitcher"],
  inventionYear: 1983,
  def: () => __async(void 0, null, function* () {
    return asyncGetDef("FTO");
  }),
  svg: () => __async(void 0, null, function* () {
    throw "Unimplemented!";
  }),
  pg: () => __async(void 0, null, function* () {
    return asyncGetPuzzleGeometry("FTO");
  })
};

// src/cubing/puzzles/implementations/megaminx/index.ts
var megaminx = {
  id: "megaminx",
  fullName: "Megaminx",
  inventionYear: 1981,
  def: () => __async(void 0, null, function* () {
    return asyncGetDef("megaminx");
  }),
  svg: () => __async(void 0, null, function* () {
    throw "Unimplemented!";
  }),
  pg: () => __async(void 0, null, function* () {
    return asyncGetPuzzleGeometry("megaminx");
  })
};

// src/cubing/puzzles/implementations/pyraminx/index.ts
var pyraminx = {
  id: "pyraminx",
  fullName: "Pyraminx",
  inventedBy: ["Uwe Meffert"],
  inventionYear: 1970,
  def: () => __async(void 0, null, function* () {
    return yield import('./pyraminx.kpuzzle-85e0ef54.js');
  }),
  svg: () => __async(void 0, null, function* () {
    return (yield import('./pyraminx.kpuzzle.svg-ca093cf2.js')).default;
  })
};

// src/cubing/puzzles/implementations/skewb/index.ts
var skewb = {
  id: "skewb",
  fullName: "Skewb",
  inventedBy: ["Tony Durham"],
  def: () => __async(void 0, null, function* () {
    return asyncGetDef("skewb");
  }),
  svg: () => __async(void 0, null, function* () {
    throw "Unimplemented!";
  }),
  pg: () => __async(void 0, null, function* () {
    return asyncGetPuzzleGeometry("skewb");
  })
};

// src/cubing/puzzles/implementations/square1/index.ts
var square1 = {
  id: "square1",
  fullName: "Square-1",
  inventedBy: ["Karel Hr\u0161el", "Vojtech Kopsk\xFD"],
  inventionYear: 1990,
  def: () => __async(void 0, null, function* () {
    return yield import('./sq1-hyperorbit.kpuzzle-a2278c5c.js');
  }),
  svg: () => __async(void 0, null, function* () {
    return (yield import('./sq1-hyperorbit.kpuzzle.svg-a88b0d61.js')).default;
  })
};

// src/cubing/puzzles/index.ts
var puzzles = {
  "3x3x3": cube3x3x3,
  "2x2x2": cube2x2x2,
  "4x4x4": cube4x4x4,
  "5x5x5": cube5x5x5,
  "6x6x6": cube6x6x6,
  "7x7x7": cube7x7x7,
  clock,
  megaminx,
  pyraminx,
  skewb,
  square1,
  fto
};

export { __async as _, puzzles as p };
