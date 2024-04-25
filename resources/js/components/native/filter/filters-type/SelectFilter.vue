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
    <div class="input-group">
        <label class="input-group-text"><i :class="column.icon"></i></label>
        <select @change="change" :name="column.id" class="form-select" v-model="params[column.id]">
            <option value="" selected>{{ column.name }}</option>
            <option v-for="option in column.options" :value="option">{{ option }}</option>
        </select>
    </div>
</template>
