export default class Responses {
    static RESPONSE_422 = {
        code: 422,
        description: 'Ocurrió un error al validar los datos de la petición',
        content: '{\n    "message":"The description field is required.",\n    "errors":{\n        "description":["The description field is required."]\n    }\n}',
        type: 'application/json'
    }
    static RESPONSE_401 = {
        code: 401,
        content: 'Unauthorized',
        description: 'No tiene acceso para realizar este cambio en el sistema',
        type: 'text/plain'
    }
}
