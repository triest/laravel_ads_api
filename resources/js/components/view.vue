<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div v-if="item!=null">
                        <b>{{item.title}}</b><br>
                        <img :src="'storage/'+item.main_image.name"/>
                        {{item.description}}

                        Фотографии:
                        <div v-for="image in item.images">
                            <p>
                                <img :src="'storage/'+image.name"/>
                            </p>
                        </div>
                    </div>
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
