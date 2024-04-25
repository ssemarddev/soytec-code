/**
 * @class Representa una página del carrusel
 */
export default class CarouselPage {

    constructor({ id, name, active = false }) {
        /**
         * @member {String}: Identificador único de la página del carrusel
         */
        this.id = id
        /**
         * @member {String}: Nombre de la página a mostrar en los botones de navegación
         */
        this.name = name
        /**
         * @member {Boolean} <code>true</code> si la página estará activa (se muestra el color primario en el fondo)
         *                   o <code>false</code> si se estará inactiva al inicio
         * @default false
         */
        this.active = active
    }
}
