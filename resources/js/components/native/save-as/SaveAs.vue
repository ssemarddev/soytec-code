<script>
    import Mixin from "./SaveAsMixin.js"

    export default {
        /**
         * @mixin ./SaveAsMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <div class="dropdown me-1">
        <button class="btn btn-primary dropdown-toggle btn-sm" data-bs-toggle="dropdown"><i class="bi bi-save"></i> Guardar como</button>
        <ul class="dropdown-menu" id="save-as">
            <li>
                <button @click="save('pdf')" class="dropdown-item"><i class="bi bi-filetype-pdf"></i> Portable Document File (PDF)</button>
            </li>
            <li>
                <button @click="save('xlsx')" class="dropdown-item"><i class="bi bi-filetype-xlsx"></i> Hoja de cálculos (XLSX)</button>
            </li>
            <li>
                <button @click="save('csv')" class="dropdown-item"><i class="bi bi-filetype-csv"></i> Comma Separated Values (CSV)</button>
            </li>
            <li>
                <button @click="save('txt')" class="dropdown-item"><i class="bi bi-filetype-txt"></i> Texto Plano (TXT)</button>
            </li>
            <li>
                <button @click="save('html')" class="dropdown-item"><i class="bi bi-filetype-html"></i> Página Web (HTML)</button>
            </li>
            <li>
                <hr class="dropdown-divider" />
            </li>
            <li>
                <button @click="save('print')" class="dropdown-item"><i class="bi bi-printer"></i> Imprimir</button>
            </li>
        </ul>
    </div>
</template>
