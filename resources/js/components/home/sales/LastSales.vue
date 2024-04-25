<script>
import Request from '../../../Request';

    export default {
        data() {
            return {
                sales: [],
            }
        },
        created() {
            Request.get('api/sales/latest').then((response) => {
                console.log(response)
                this.sales = response.data
            })
        }
    }
</script>

<style scoped>
    div.d-flex {
        border-radius: 0.75rem;
        box-shadow: 0 5px 1rem rgb(0 0 0 / 21%);
        padding-left: 0.5rem;
        padding-right: .5rem;
        padding-bottom: 0.25rem;
        margin-top: .5rem;
        margin-bottom: .5rem;
    }
    img {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        margin-right: .25rem;
    }
    h6 {
        line-height: 1.1em;
        max-width: 100%;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-bottom: .1rem;
        font-weight: 700;
        height: 1.1em;
    }
    p {
        color: rgb(0, 0, 0, 0.3);
        font-weight: 700;
    }
    span {
        color: rgb(0, 0, 0, 0.5);
        font-size: .9em;
    }
    div.float-end {
        font-weight: 700;
    }
    @media (max-width: 860px) {
        .main > div:last-child {
            display: none !important;
        }
    }
</style>

<template>
    <div class="main py-2">
        <p class="mb-1"><i class="bi bi-cart-check"></i> Últimas compras</p>
        <h6>$597.00</h6>
        <div v-for="(sale, index) in sales" class="d-flex align-items-center py-2">
            <img :src="sale.client.avatar" />
            <div class="w-100">
                <div class="float-end">${{ sale.total }}</div>
                <h6>{{ sale.client.name }} {{ sale.client.lastName }}</h6>
                <span>15/05/2022</span>
            </div>
        </div>
    </div>
</template>
