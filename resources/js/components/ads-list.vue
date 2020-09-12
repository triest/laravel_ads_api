<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div v-for="item in ads">
                        <b>{{item.data.title}}</b><br>
                        <img :src="'storage/'+item.data.main_image.name"/>
                        <a :href="item.data.id">
                            Подробнее
                        </a>
                    </div>
                    <div v-if="prev_page_url!=null">
                         <button v-on:click="getAll(prev_page_url)">Назад</button>
                    </div>
                    <div v-if="next_page_url!=null">
                        <button v-on:click="getAll(next_page_url)">Вперед</button>
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
            getAll(url='/api/ads') {
                axios.get(url,).then(
                    (response) => {
                        let data = response.data;
                        this.ads = data.data;
                        this.prev_page_url=data.links.prev;
                        this.next_page_url=data.links.next;
                        console.log(this.prev_page_url)
                        console.log(this.next_page_url)

                    }
                ).catch();
            }
        }
    }
</script>
