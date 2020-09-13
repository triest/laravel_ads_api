<template>
    <div class="container">

        <div class="card">
            <div v-for="item in ads">
                <div class="card mb-4">
                    <div v-if="item.data.main_image!=null">
                        <img class="card-img-top" :src="'storage/'+item.data.main_image"/>
                    </div>
                    <div class="card-footer text-muted">
                        Цена:
                        {{item.data.price}}
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">{{item.data.title}}</h2>
                        <a :href="item.data.id" class="btn btn-primary">Подробней&rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
            this.getAll();
        },
        data() {
            return {
                ads: [],
                prev_page_url: null,
                next_page_url: null,
            }
        },
        methods: {
            getAll(url = '/api/ads') {
                axios.get(url,).then(
                    (response) => {
                        let data = response.data;
                        this.ads = data.data;
                        this.prev_page_url = data.links.prev;
                        this.next_page_url = data.links.next;
                        console.log(this.prev_page_url)
                        console.log(this.next_page_url)

                    }
                ).catch();
            }
        }
    }
</script>
