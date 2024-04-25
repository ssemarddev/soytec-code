<script>
import Routes from '../native/Routes.vue'
import Route from '../native/Route.js'
import Param from '../native/Param.js'

import Formats from './Formats'
import Responses from './Responses'
import Utils from '../../../doc/Utils.js'

const DATA = [
    new Param({
        name: 'id',
        type: 'int',
        head: true,
        unique: true,
        required: true,
        format: Formats.INTEGER,
        examples: [0, 1, 4, 12, 87]
    }),
    new Param({
        name: 'name',
        type: 'String',
        required: true,
        format: Formats.NAMES,
        examples: ['John', 'Albert', 'Michael', 'Jack']
    }),
    new Param({
        name: 'lastName',
        type: 'String',
        required: true,
        format: Formats.NAMES,
        examples: ['Bauer', 'Camus', 'Legend', 'Willer']
    }),
    new Param({
        name: 'gender',
        type: 'String',
        values: ['Otro', 'Masculino', 'Femenino'],
    }),
    new Param({
        name: 'email',
        type: 'email',
        unique: true,
        required: true,
        examples: ['jhon@example.com', 'willer.jack@gmail.com', 'albert98@hotmail.com'],
        format: Formats.EMAIL,
    }),
    new Param({
        name: 'phone',
        type: 'tel',
        required: true,
        format: Formats.TELEPHONE_NUMBER,
        examples: ['+58 (586) 852 458', '+57 (698) 254 236', '+53 (58) 698 253', 'Willer']
    }),
    new Param({
        name: 'state',
        type: 'String',
        values: ['Activa', 'Inactiva'],
    })
]

export default {
    components: { Routes },
    data() {
        return {
            routes: [
                new Route({
                    type: 'GET',
                    description: 'Retorna las categorías almacenadas en la base de datos',
                    path: 'categories',
                    data: {
                        type: 'Array',
                        params: DATA
                    },
                    responses: [
                        {
                            code: 200,
                            content: Utils.createJsonCode({
                                type: 'Array',
                                params: DATA
                            }),
                            description: 'Categorías listadas correctamente',
                            type: 'application/json'
                        },
                        Responses.RESPONSE_401,
                    ]
                }),
                new Route({
                    type: 'POST',
                    description: 'Agrega una nueva categoría a la base de datos',
                    path: 'categories',
                    params: DATA,
                    data: {
                        type: 'Object',
                        params: DATA
                    },
                    responses: [
                        {
                            code: 200,
                            content: Utils.createJsonCode({
                                type: 'Object',
                                params: DATA
                            }),
                            description: 'Categorías creada correctamente',
                            type: 'application/json'
                        },
                        Responses.RESPONSE_401,
                        Responses.RESPONSE_422,
                    ]
                }),
                new Route({
                    type: 'PUT',
                    description: 'Actualiza una categoría existente en la base de datos',
                    path: 'categories/{id}',
                    params: DATA,
                    data: {
                        type: 'Object',
                        params: DATA
                    },
                    responses: [
                        {
                            code: 200,
                            content: Utils.createJsonCode({
                                type: 'Object',
                                params: DATA
                            }),
                            description: 'Categoría actualizada correctamente',
                            type: 'application/json'
                        },
                        Responses.RESPONSE_401,
                        Responses.RESPONSE_422,
                    ]
                }),
                new Route({
                    type: 'DELETE',
                    description: 'Elimina las categorías de la base de datos',
                    path: 'categories',
                    params: [
                        new Param({
                            name: 'ids',
                            type: 'Array',
                            required: true,
                            examples: [[0, 5, 8, 10], [5, 4, 3], [2, 3, 6]],
                            format: Formats.INTEGER,
                        }),
                    ],
                    responses: [
                        {
                            code: 200,
                            content: '',
                            description: 'Categorías eliminadas correctamente',
                            type: 'application/json'
                        },
                        Responses.RESPONSE_401,
                        Responses.RESPONSE_422,
                    ]
                }),
            ]
        }
    }
}
</script>
<template>
    <Routes :routes="routes" title="Categorías" />
</template>
