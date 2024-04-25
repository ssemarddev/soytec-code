<script>
    import Mixin from "./RowsMixin.js"

    export default {
        /**
         * @mixin ./RowsMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <tr @click="toogleDetails">
        <td class="table-select">
            <div class="form-check">
                <input tag="selected" class="form-check-input" type="checkbox" @change="toogleCheck" :checked="checked" />
            </div>
        </td>
        <template v-for="column in columns">
            <td v-if="column.visible" v-html="column.html(item)" :class="column.classes"></td>
        </template>
    </tr>
    <ActionsRow :details="details" :item="item" />
</template>
