<script>
    import SaveAs from "../save-as/SaveAs.vue"
    import ColumnVisible from "../column-visible/ColumnVisible.vue"
    import Pagination from "../pagination/Pagination.vue"
    import FilterRows from "../filter/FilterRows.vue"
    import ActionButtons from "../action-buttons/ActionButtons.vue"
    import RowVisible from "../row-visible/RowVisible.vue"
    import Sort from "../sort/Sort.vue"
    import Placeholder from "../placeholder/Placeholder.vue"
    import Row from "../row/Row.vue"
    import Unauthorized from "../errors/Unauthorized.vue"

    import Utils from "./UtilsMixin.js"
    import TableMixin from "./TableMixin.js"

    export default {
        /**
         * @mixin ./UtilsMixin.js
         * @mixin ./TableMixin.js
         */
        mixins: [Utils, TableMixin],
        components: { SaveAs, ColumnVisible, Pagination, FilterRows, ActionButtons, RowVisible, Sort, Placeholder, Row, Unauthorized },
    }
</script>

<template>
    <div class="main-actions">
        <slot name="table-nav">
            <SaveAs />
            <ColumnVisible />
        </slot>
    </div>
    <div class="page-container">
        <div class="table-header">
            <slot name="header">
                <div class="filter">
                    <FilterRows />
                </div>
                <div class="actions">
                    <ActionButtons />
                </div>
                <div class="rows-num">
                    <RowVisible />
                </div>
            </slot>
        </div>
        <div class="table-responsive">
            <Unauthorized v-if="loaded == 401" />
            <table v-else id="table" class="table table-hover align-middle">
                <thead>
                    <tr class="font-weight-bold text-center">
                        <th class="table-select">
                            <div class="form-check">
                                <input tag="selected" class="form-check-input" type="checkbox" @change="toogleAll" :checked="checked" />
                            </div>
                        </th>
                        <template v-for="(column, key) in columns">
                            <Sort :column="column" :id="key" />
                        </template>
                    </tr>
                </thead>
                <tbody class="bg-white" id="tbody">
                    <template v-if="loaded" v-for="item in items">
                        <slot name="row" :item="item">
                            <Row :item="item" />
                        </slot>
                    </template>
                    <Placeholder v-else v-for="n in config.rows" />
                </tbody>
            </table>
        </div>
        <slot name="footer">
            <Pagination :pages="pages" />
        </slot>
    </div>
</template>

<style scoped>
    th {
        white-space: nowrap;
        cursor: pointer;
        color: #7e7e7e;
        text-align: left;
    }
    tbody > tr:last-child {
        border-bottom: solid 1px transparent;
    }
    .table-header {
        display: grid;
        grid-template-areas: "F A C";
    }
    .filter {
        grid-area: F;
    }
    .actions {
        grid-area: A;
    }
    .rows-num {
        grid-area: C;
    }
    @media (max-width: 590px) {
        .table-header {
            grid-template-areas:
                "F C"
                "A A";
            grid-gap: 0.25rem;
        }
    }
    .main-actions {
        margin-top: 0.5rem;
        display: flex;
        justify-content: flex-end;
    }
    @media (max-width: 430px) {
        .main-actions {
            display: grid;
            grid-row-gap: 0.25rem;
        }
    }
</style>
