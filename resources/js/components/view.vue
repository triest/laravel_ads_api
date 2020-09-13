<template>
    <div class="container">

        <div class="card">
            <div v-if="item!=null">
                <div class="card-body">
                    <h2 class="card-title">
                        {{item.title}}
                    </h2>
                    <p v-if="item.main_image!=null">
                        <img :src="item.main_image"/>
                    </p>
                    <p class="card-text">
                        {{item.description}}
                    </p>
                    Цена: {{item.price}}
                    <b> Фотографии:</b>
                    <div v-for="image in item.images">
                        <p v-if="image.name!=null">
                            <img :src="'storage/'+image.name"/>
                        </p>
                    </div>
                    <a href="/">
                        <button type="button" class="btn btn-info">Назад</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                type: Number,
                requared: true
            }
        },
        mounted() {
            console.log('Component mounted.');
            this.getAll();
        },
        data() {
            return {
                item: null
            }
        },
        methods: {
            getAll(url = '/api/ads/' + this.id) {
                axios.get(url,).then(
                    (response) => {
                        let data = response.data;
                        this.item = data.data;

                    }
                ).catch();
            }
        }
    }
</script>
