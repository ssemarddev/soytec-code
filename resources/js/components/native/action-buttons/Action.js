/**
 * @class Representa una acción sobre una o varias filas de la tabla.
 * Maneja las diferentes configuraciones de una acción.
 */
export default class Action {

    constructor({event, name, icon = "", single = false}) {
        /**
         * @member {String}: Nombre del evento que dispara esta acción
         */
        this.event = event
        /**
         * @member {String}: Nombre de la acción
         */
        this.name = name
        /**
         * @member {String}: Representa una clase (o un conjunto de clases) CSS a aplicar al ícono de la acción. 
         * Compatible con Google Font Awesome, Bootstrap Icons y otros sistemas similares
         */
        this.icon = icon
        /**
         * @member {Boolean}: <code>true</code> si es un acción que solo puede realizarse sobre una sola fila o 
         * <code>false</code> si es una acción que puede hacerse sobre múltiples filas
         * @default false
         */
        this.single = single
    }
}