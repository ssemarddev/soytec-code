/**
 * Maneja endpoints de la API comunes a varios módulos
 */
export default class ApiAction {
    /**
     *
     * @param {String} type Tipo de petición
     * @param {String|Function} url Url de la petición, puede ser una URL relativa o absoluta
     * @param {String|Function} message Mensaje a mostrar luego que se reciban los resultados de la petición al endpoint
     */
    constructor({ type = "GET", url, message }) {
        this.type = type
        this.url = url
        this.message = message
    }

    /**
     * 
     * @param {number} id Id del registro que se actualizará o eliminará, <code>undefined</code> si es una operación para cear un nuevo registro o listar registros
     * @param {Object} item Datos del registro que se actualizará o eliminará, <code>undefined</code> si es una operación para cear un nuevo registro o listar registros
     * @returns 
     */
    url(id, item) {
        return ""
    }

    /**
     * 
     * @param {Array<number>} ids Ids de los registros actualizados o eliminados, <code>undefined</code> si es una operación para cear un nuevo registro o listar registros
     * @returns 
     */
    message(ids) {
        return ids.length == 1 ? "El registro fue actualizado correctamente" : "Los registros seleccionados fueron actualizados correctamente"
    }
}
