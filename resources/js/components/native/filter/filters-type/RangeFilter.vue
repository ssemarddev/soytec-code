<script>
    import FiltersType from "./FiltersTypeMixin.js"
    import Range from "./RangeMixin.js"
    
    export default {
        /**
         * @mixin: ./FiltersTypeMixin.js
         * @mixin: ./RangeMixin.js
         */
        mixins: [FiltersType, Range],
    }
</script>

<style scoped>
    input {
        max-width: 10rem;
    }
</style>

<template>
    <label class="w-100 mb-1 text-center"><i :class="column.icon"></i> {{ column.name }}</label>
    <div class="input-group">
        <input style="width: 3rem" placeholder="Valor inicial" @input="assign(column.id)" type="nummber" class="form-control" v-model="start" />
        <input style="width: 3rem" placeholder="Valor tope" @input="assign(column.id)" type="number" class="form-control" v-model="end" />
    </div>
</template>
