<template>
    <div>

        <input type="text" name="location" id="query" placeholder="Pesquisar" v-model="query" class="form-control" autocomplete="off">
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
            }
        },

        watch:{

            query: function (before, after) {
                this.fetchResults(this.query)
            }

        }
    }
</script>

<style scoped>

</style>
