<script>
    import Mixin from "./FilterRowsMixin.js"

    export default {
        /**
         * @mixin ./FilterRowsMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <form @reset="reset">
        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-filter"></i> Filtrar</button>
        <ul class="dropdown-menu p-3">
            <li class="mb-3">
                <div class="form-check form-switch">
                    <input @change="filter" class="form-check-input" type="checkbox" role="switch" v-model="sensible" />
                    <label class="form-check-label">Sensible a mayúsculas y minúsculas</label>
                </div>
            </li>
            <li v-for="column in columns" class="mb-3">
                <TextFilter v-if="column.type == 'text' || column.type == 'tel' || column.type == 'url' || column.type == 'email'" :params="params" :column="column" @change="filter" />
                <RadioFilter v-else-if="column.type == 'radio'" :params="params" :column="column" @change="filter" />
                <SelectFilter v-else-if="column.type == 'select'" :params="params" :column="column" @change="filter" />
                <DateFilter v-else-if="column.type == 'date' || column.type == 'datetime'" :params="params" :column="column" @change="filter" />
                <RangeFilter v-else-if="column.type == 'range'" :params="params" :column="column" @change="filter" />
                <TagFilter v-else-if="column.type == 'tags'" :params="params" :column="column" @change="filter" />
            </li>
            <SavedFilters @select-filter="setFilter" :params="params" :store="id" />
        </ul>
    </form>
</template>

<style scoped>
    form > h6 {
        font-weight: 700;
        font-size: 1em;
        text-align: end;
    }
    form > h6 > button {
        font-size: 1em;
        padding: 0.25rem;
    }
</style>
