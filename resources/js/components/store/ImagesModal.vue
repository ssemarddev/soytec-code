<script>
    import Tooltip from "bootstrap/js/dist/tooltip"
    import CustomModal from "../native/modal/Modal.vue"

    export default {
        components: { CustomModal },
        data() {
            return {
                selected: null,
            }
        },
        methods: {
            select(color) {
                this.selected = color
                this.config.window = `${this.product.name} (${color.name})`
            },
        },
        mounted() {
            this.selected = this.product.colors[0]
            this.config.window = `${this.product.name} (${this.selected.name})`
            const tooltipList = [...this.$el.querySelectorAll('[data-bs-toggle="tooltip"]')]
            tooltipList.map((el) => new Tooltip(el))
        },
    }
</script>

<template>
    <CustomModal :config="config" @accept="accept" @cancel="cancel">
        <div class="colors-list">
            <div v-for="(color, index) in product.colors" :class="{ active: color == selected }">
                <div :style="{ background: color.color }" @click="select(color)" data-bs-toggle="tooltip" :title="color.name"></div>
            </div>
        </div>
        <div v-if="selected !== null" class="images">
            <div v-for="image in selected.images">
                <img :src="image.url" />
            </div>
        </div>
    </CustomModal>
</template>

<style scoped>
    .colors-list {
        display: flex;
        justify-content: center;
        width: 100%;
    }
    .colors-list > div {
        border-radius: 50%;
        margin-left: 0.15rem;
        margin-right: 0.15rem;
        padding: 0.1rem;
        border: solid 4px #fff;
        transition: border ease-in-out 0.2s;
    }
    .colors-list > div > div {
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 50%;
        cursor: pointer;
    }
    .colors-list > div.active {
        border: solid 4px #dc3545;
        box-shadow: 0 0 0.5rem rgba(220, 53, 70, 0.356);
    }
    .images {
        display: grid;
        grid-gap: 0.5rem;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        margin-top: 0.75rem;
    }
    .images > div {
        padding: 0.5rem;
        border-radius: 0.5rem;
        border: solid 1px #dddddd;
        text-align: center;
    }
    .images > div > img {
        max-width: 100%;
        max-height: 125px;
    }
</style>
