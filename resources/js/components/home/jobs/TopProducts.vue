<script>
import Request from '../../../Request';

export default {
    data() {
        return {
            products: [],
            total: 0,
        }
    },
    created() {
        Request.get('api/products/popular').then((response) => {
            this.products = response.data
            this.total = 0
            for (let product of this.products) {
                this.total += product.quantity * (product.price - product.cost)
            }
        })
    }
}
</script>

<template>
    <div class="main mt-3">
        <div class="resume mb-2">
            <p><i class="bi bi-bookmark-heart-fill"></i> Más vendidos</p>
            <h6>${{total}}</h6>
        </div>

        <div>
            <div v-for="product in products" class="top">
                <img :src="'src/img/' + product.image" />
                <div>
                    <h6 class="top-name">{{ product.name }}</h6>
                    <p class="top-description">{{ product.trademark }} {{ product.model }}</p>
                </div>
                <div>
                    <p>Inventario</p>
                    <h6>{{ product.stock }} ({{ product.min }})</h6>
                </div>
                <div>
                    <p>Ventas</p>
                    <h6>${{ product.quantity }}</h6>
                </div>
                <div>
                    <p>Ganancias</p>
                    <h6>${{ product.quantity * (product.price - product.cost) }}</h6>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.main>div:not(.resume) {
    width: 100%;
}

.resume>p {
    margin-bottom: 0.05rem;
    font-weight: 700;
    color: rgb(0, 0, 0, 0.3);
    margin-bottom: .1rem;
}

.resume>p {
    color: rgb(0, 0, 0, 0.3);
}

.resume>h6 {
    line-height: 1.1em;
    max-width: 100%;
    text-overflow: ellipsis;
    overflow: hidden;
    margin-bottom: .1rem;
    font-weight: 700;
    height: 1.1em;
}

.top {
    margin: .5rem .25rem .5rem .25rem;
    border-radius: .75rem;
    padding: .5rem;
    box-shadow: 0 5px 1rem rgb(0 0 0 / 21%);
}

.top>img {
    max-width: 3.5rem;
    max-height: 3.5rem;
}

.top p {
    color: rgb(0, 0, 0, 0.3);
    margin-bottom: 0.1rem;
}

.top h6 {
    margin-bottom: .2rem;
    font-weight: 700;
}

.top-name,
.top-description {
    color: rgb(54, 162, 235);
    white-space: nowrap;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
}

.top {
    width: 100%;
    grid-column-gap: .15rem;
    display: flex;
    flex-wrap: wrap;
}

.top> :nth-child(1) {
    width: calc(10% - .15rem);
}

.top> :nth-child(2) {
    width: calc(37% - .15rem);
}

.top> :nth-child(3) {
    width: calc(19% - .15rem);
}

.top> :nth-child(4) {
    width: calc(15% - .15rem);
}

.top> :nth-child(5) {
    width: calc(19% - .15rem);
}
</style>
