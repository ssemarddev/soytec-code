export default class DashboardRoute {

    /**
     * 
     * @param {String} href: Identificador de la ruta. Debe ser un el nombre de un componente Vue registrado globalmente en la aplicación.
     * @param {String} name: Nombre de la ruta
     * @param {String} icon: Clase(s) CSS a aplicar en el ícono a mostrar en la barra lateral de navegación. 
     */
    constructor({ href, name, icon }) {
        /**
         * Identificador de la ruta. Debe ser un el nombre de un componente Vue registrado globalmente en la aplicación.
         * @member
         */
        this.href = href
        /**
         * Nombre de la ruta
         * @member
         */
        this.name = name
        /**
         * Clase(s) CSS a aplicar en el ícono a mostrar en la barra lateral de navegación. 
         */
        this.icon = icon
    }
}
