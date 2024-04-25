/**
 * Maneja funciones comunes de la aplicación
 */
export default class Utils {
    /**
     * Forma un código json a partir de los parámetros pasados
     * @param {Array} data Parámetros del código JSON
     */
    static createJsonCode(data) {
        let code = "";
        const params = data.params;
        if (data.type == "Array") {
            code += "[\n";
            for (let i = 0; i < 4; i++) {
                code += "    {\n";
                code += `        "id": ${i},\n`;
                for (let param of params) {
                    code += `        "${param.name}": `;
                    switch (param.type) {
                        case "String":
                            const i = Math.floor(
                                Math.random() * param.examples.length
                            );
                            code += `"${param.examples[i]}", \n`;
                    }
                }
                code += "    },\n";
            }
            code += "]";
        } else if (data.type == "Object") {
            code += "{\n";
            code += `    "id": ${Math.floor(Math.random() * 10)},\n`;
            for (let param of params) {
                code += `    "${param.name}": `;
                switch (param.type) {
                    case "String":
                        const i = Math.floor(
                            Math.random() * param.examples.length
                        );
                        code += `"${param.examples[i]}", \n`;
                }
            }
            code += "},\n";
        }

        return code;
    }
}
