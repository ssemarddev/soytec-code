import Pusher from "pusher-js"

export default {
    methods: {
        addMessage(message) {
            //Buscar el chat del mensaje para agregar el mensaje
            for (let chat of this.chats) {
                if (chat.id == message.chat_id) {
                    //Eliminar el mensaje de la lista mensajes en estado "Enviando"
                    for (let i in this.sending.messages) {
                        const sending = this.sending.messages[i]
                        if (sending.message == message.message) {
                            this.sending.messages.splice(i, 1)
                            break
                        }
                    }
                    //Agregar el mensaje
                    chat.messages.push(message)
                    break
                }
            }
        },
        removeMessage(message) {
            //Eliminar el mensaje del chat
            for (let chat of this.chats) {
                if (chat.id == message.chat_id) {
                    for (let i in chat.messages) {
                        if (chat.messages[i].id == message.id) {
                            chat.messages.splice(i, 1)
                            break
                        }
                    }
                    break
                }
            }
        },
        addChat(chat) {
            //Eliminar el mensaje de la lista mensajes en estado "Enviando"
            const chats = this.sending.chats
            for (let i in chats) {
                const sending = chats[i]
                if (sending == chat.title) {
                    chats.splice(i, 1)
                    break
                }
            }
            this.chats.push(chat)
        },
        removeChat(chat) {
            //Eliminar el mensaje de la lista mensajes en estado "Enviando"
            for (let i in this.chats) {
                const item = this.chats[i]
                if (item.id == chat.id) {
                    this.chats.splice(i, 1)
                    break
                }
            }
        },
        init(key) {
            const pusher = new Pusher(key, {
                cluster: "mt1",
            })
            //Canal de chats
            const chatsChannel = pusher.subscribe(this.apikey + "-chat-channel")
            chatsChannel.bind("ChatCreated", (data) => {
                this.addChat(data.chat)
            })
            chatsChannel.bind("ChatDeleted", (data) => {
                this.removeChat(data.chat)
            })
            //Canal de mensajes
            const messagesChannel = pusher.subscribe(this.apikey + "-message-channel")
            messagesChannel.bind("MessageSended", (data) => {
                this.addMessage(data.message)
            })
            messagesChannel.bind("MessageDeleted", (data) => {
                this.removeChat(data.message)
            })
        },
    },
}
