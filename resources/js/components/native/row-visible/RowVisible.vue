<script>
    import Mixin from "./RowVisibleMixin.js"

    export default {
        /**
         * @mixin ./RowVisibleMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <div>Ver <input class="form-control mx-1" type="number" @input="change" @change="change" :value="config.rows" /> registros</div>
</template>

<style scoped>
    @media (max-width: 300px) {
        div > input {
            width: 1.7rem !important;
            padding: .2rem .3rem;
        }
    }
    div {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    div > input {
        width: 4rem;
    }
</style>
