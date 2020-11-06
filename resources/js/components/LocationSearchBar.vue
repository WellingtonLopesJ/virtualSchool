<template>
    <div>
        <input type="text" name="location" id="location" placeholder="Pesquisar" v-model="query" class="form-control" autocomplete="off">
        <ul v-if="results.length > 0 && query" class="list-group">
            <li v-for="result in results.slice(0,10)" :key="result.id" class="list-group-item list-group-item-action">
                <a v-on:click="setQuery(result.address)">
                    {{result.address}}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "LocationSearchBar",
        data: function () {

            return{
                query: "",
                results: []
            }
        },

        methods:{
            fetchResults: function (query) {

                axios.get('/searchLocations', {params: {query: query}})
                    .then( response => {
                        this.results = response.data;
                    })
                    .catch((response)=> {
                        console.log(response)
                    })
            },

            setQuery: function (val) {
                this.query = val
            },

            fetchCurrentLocation: function (slug){
                axios.get('http://master.myapp.com/searchCurrentLocation/' + slug)
                    .then( response => {
                        this.query = response.data;
                    })
                    .catch((response)=> {
                        console.log(response)
                    })
            },
        },

        watch:{

            query: function (before, after) {
                this.fetchResults(this.query)
            }

        },
        mounted() {
            var currentUrl = window.location.pathname;
            if (!currentUrl.includes('create')) {
                var lastTen = currentUrl.substr(currentUrl.length - 10);
                setTimeout(this.fetchCurrentLocation(lastTen), 11000)
            }
        },
    }
</script>

<style scoped>

</style>
