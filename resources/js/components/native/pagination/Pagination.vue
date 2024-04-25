<script>
    import Mixin from "./PaginationMixin.js"

    export default {
        /**
         * @mixin ./PaginationMixin.js
         */
        mixins: [Mixin],
    }
</script>
<template>
    <nav class="navigation">
        <ul class="pagination justify-content-center mb-2">
            <li class="page-item">
                <a class="page-link" :class="{ disabled: config.page == 0 }" role="button" @click="previousPage"><i class="bi bi-chevron-double-left"></i></a>
            </li>
            <template v-for="(page, index) in pages">
                <li v-if="!hiddenButtons.includes(index) || ellipsisButtons.includes(index)" class="page-item">
                    <a class="page-link" :class="{ active: index == config.page }" role="button" @click="selectPage(index)">
                        <template v-if="ellipsisButtons.includes(index)"> ... </template>
                        <template v-else>
                            {{ page }}
                        </template>
                    </a>
                </li>
            </template>
            <li class="page-item">
                <a class="page-link" :class="{ disabled: config.page >= pages.length - 1 }" role="button" @click="nextPage"><i class="bi bi-chevron-double-right"></i></a>
            </li>
        </ul>
    </nav>
</template>
