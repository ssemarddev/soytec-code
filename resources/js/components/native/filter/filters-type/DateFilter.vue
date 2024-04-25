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
        <input placeholder="Fecha inicial" @change="assign(column.id)" :type="column.type" class="form-control" v-model="start" />
        <input placeholder="Fecha tope" @change="assign(column.id)" :type="column.type" class="form-control"  v-model="end" />
    </div>
</template>
