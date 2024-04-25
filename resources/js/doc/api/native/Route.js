export default class Route {
    constructor({ type, description, path, data, params, responses }) {
        this.type = type;
        this.description = description;
        this.path = path;
        this.data = data;
        this.params = params || [];
        this.responses = responses || [];
    }
}
