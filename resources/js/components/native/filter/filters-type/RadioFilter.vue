<script>
    import FiltersType from "./FiltersTypeMixin.js"
    
    export default {
        /**
         * @mixin: ./FiltersTypeMixin.js
         */
        mixins: [FiltersType],
    }
</script>

<template>
    <label><i :class="column.icon"></i> {{ column.name }}</label>
    <div class="form-check">
        <input @change="change" class="form-check-input" type="radio" :name="column.id" value="" checked v-model="params[column.id]" />
        <label class="form-check-label">Sin especificar</label>
    </div>
    <template v-for="option in column.options">
        <div class="form-check">
            <input @change="change" class="form-check-input" type="radio" :name="column.id" :value="option.value" v-model="params[column.id]" />
            <label class="form-check-label">{{ option.label }}</label>
        </div>
    </template>
</template>
