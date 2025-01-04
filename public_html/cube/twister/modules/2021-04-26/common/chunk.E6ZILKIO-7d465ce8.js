import { S as Sequence, C as Comment, N as NewLine, P as Pause, f as Conjugate, e as Commutator, B as BlockMove, G as Group, p as pegParseAlgJSON } from './chunk.RSGKTTJ7-5cf68302.js';

// src/cubing/alg/json.ts
function fromJSON(json) {
  if (json.type !== "sequence") {
    throw new Error(`Expected Sequence while parsing, got: ${json.type}`);
  }
  if (!json.nestedUnits) {
    throw new Error("Missing nestedUnits");
  }
  return new Sequence(json.nestedUnits.map((j) => unitFromJSON(j)));
}
function unitFromJSON(json) {
  switch (json.type) {
    case "sequence":
      throw new Error(`Expected AlgPart while parsing, got \`Sequence\`.`);
    case "group":
      if (!json.nestedSequence) {
        throw new Error("Missing nestedSequence");
      }
      if (!json.amount) {
        throw new Error("Missing amount");
      }
      return new Group(fromJSON(json.nestedSequence), json.amount);
    case "blockMove":
      if (!json.family) {
        throw new Error("Missing family");
      }
      if (!json.amount) {
        throw new Error("Missing amount");
      }
      return new BlockMove(json.outerLayer, json.innerLayer, json.family, json.amount);
    case "commutator":
      if (!json.A) {
        throw new Error("Missing A");
      }
      if (!json.B) {
        throw new Error("Missing B");
      }
      if (!json.amount) {
        throw new Error("Missing amount");
      }
      return new Commutator(fromJSON(json.A), fromJSON(json.B), json.amount);
    case "conjugate":
      if (!json.A) {
        throw new Error("Missing A");
      }
      if (!json.B) {
        throw new Error("Missing B");
      }
      if (!json.amount) {
        throw new Error("Missing amount");
      }
      return new Conjugate(fromJSON(json.A), fromJSON(json.B), json.amount);
    case "pause":
      return new Pause();
    case "newLine":
      return new NewLine();
    case "comment":
      if (!json.comment && json.comment !== "") {
        throw new Error("Missing comment");
      }
      return new Comment(json.comment);
    default:
      throw new Error(`Unknown alg type: ${json.type}`);
  }
}

// src/cubing/alg/parser/index.ts
function parseAlg(s, options = {validators: []}) {
  options.validators = options.validators || [];
  const algo = fromJSON(pegParseAlgJSON(s));
  for (const validate of options.validators) {
    validate(algo);
  }
  return algo;
}

export { fromJSON as f, parseAlg as p };
