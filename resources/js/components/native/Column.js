export default class Column {
    /**
     * @param {String} id: Identificador único de de la columna
     * @param {String} name: Nombre de la columna
     * @param {String} type: Tipo de dato que aloja la columna.
     * - @values {text|email|number|date|select|radio|tags}
     * @param {String} icon: Clase(s) CSS a aplicar al ícono de la columna.
     * @param {String} classes: Clase(s) CSS a aplicar en el objeto HTML <code>td</code>, <code>th</code> 
     * de la columna
     * @param {String} visible: <code>true</code> si la columna será visible por defecto o <code>false</code>
     * si no estará visible 
     * @param {Array<ColumnOption>} options: Si la columna es del tipo <code>radio|select</code> se debe pasar 
     * un Array con los diferentes valores que pueden tomar los datos de la columna
     * @param {Array<ColumnPattern>} patterns: Un Array con los diferentes patrones de expresiones regulares 
     * que deben cumplir los datos de la columna
     * @param {function} html: Una función que recibe como argumento el contenido de la fila y retorna el código
     * HTML de la celda
     * - @optional
     * @param {function} content:  Una función que recibe como argumento el contenido de la fila y retorna el contenido
     * en texto plano de la celda
     * - @optional
     */
    constructor({ id, name, type = "text", icon, classes = "", visible = true, options = [], patterns = [], html, content }) {
        /**
         * Identificador único de de la columna
         * @member
         * @type String
         */
        this.id = id
        /**
         * Nombre de la columna
         * @member
         * @type String
         */
        this.name = name
        /**
         * Tipo de dato que aloja la columna
         * @member
         * @type String
         * @values {text|email|number|date|select|radio|tags}
         */
        this.type = type
        /**
         * Clase(s) CSS a aplicar al ícono de la columna.
         * @member
         * @type String
         */
        this.icon = icon
        /**
         * Clase(s) CSS a aplicar en el objeto HTML <code>td</code>, <code>th</code> de la columna
         * @member
         * @type String
         */
        this.classes = classes
        /**
         * <code>true</code> si la columna será visible por defecto o <code>false</code> si no estará visible 
         * por defecto
         * @member
         * @type Boolean
         */
        this.visible = visible
        /**
         * Si la columna es del tipo <code>radio|select</code> se debe pasar un Array con los diferentes valores 
         * que pueden tomar los datos de la columna
         * @member
         * @type Array<ColumnOption>
         * @default []
         */
        this.options = options
        /**
         * Un Array con los diferentes patrones de expresiones regulares que deben cumplir los datos de la columna
         * @member
         * @type Array<ColumnPattern>
         * @default []
         */
        this.patterns = patterns
        if (html !== undefined) this.html = html
        if (content !== undefined) this.content = content
    }

    /**
     * Retorna el código HTML de la celda según los datos de la fila que fueron pasados en el argumento
     * @param {Object} item: Objecto con los datos de la fila
     * @returns {String}: El código HTML de la celda
     */
    html(item) {
        return item[this.id]
    }

    /**
     * Retorna el contenido en texto plano de la celda según los datos de la fila que fueron pasados en el argumento
     * @param {Object} item 
     * @returns {String}: El contenido en texto plano de la celda
     */
    content(item) {
        return `${item[this.id]}`
    }
}
