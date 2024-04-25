export default class Param {
    constructor({ name, type, head, unique, required, format, values, examples }) {
        this.name = name;
        this.head = head || false
        this.type = type;
        this.unique = unique || false;
        this.required = required || false;
        this.format = format || values;
        this.values = values || [];
        this.examples = examples || this.values;
    }
}
