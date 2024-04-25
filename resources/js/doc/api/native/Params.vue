<script>
export default {
    props: {
        params: Array
    }
}
</script>
<template>
    <table class="table table-hover align-middle">
        <thead>
            <tr class="font-weight-bold">
                <th>Nombre</th>
                <!-- <th>Tipo de parámetro</th> -->
                <th>Tipo de dato</th>
                <th>Formato</th>
                <th>Valores</th>
                <th>Ejemplo de valores</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="param in params">
                <td>{{ param.name }}</td>
                <!-- <td>
                    <template v-if="param.head">
                        Parámetro de cabecera
                    </template>
                    <template v-else>
                        Parámetro del cuerpo
                    </template>
                </td> -->
                <td>{{ param.type }}</td>
                <td>{{ param.format }}</td>
                <td>{{ param.values }}</td>
                <td>{{ param.examples }}</td>
            </tr>
        </tbody>
    </table>
</template>
<style scoped>
table {
    font-size: .85em;
}
</style>
