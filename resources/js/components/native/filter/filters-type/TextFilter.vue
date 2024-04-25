<script>
    import FiltersType from "./FiltersTypeMixin.js"
    
    export default {
        /**
         * @mixin: ./FiltersTypeMixin.js
         */
        mixins: [FiltersType]
    }
</script>

<template>
    <div class="input-group">
        <span class="input-group-text"><i :class="column.icon"></i></span>
        <input @input="change" :type="column.type" :placeholder="column.name" class="form-control" :name="column.id" v-model="params[column.id]" />
    </div>
</template>
