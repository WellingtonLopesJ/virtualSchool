<template>
    <div class="mb-2">

        <div v-for="result in this.selected" :key="result.id * -1">
            <input type="hidden" name="selected[]" :value="result.id">
        </div>

        <div v-for="result in this.selected" :key="result.id">
            <button class="btn btn-success m-1" v-on:click="unSelect(result, $event)">{{result.name}}</button>
        </div>

        <input type="text" id="query" placeholder="Pesquisar" v-model="query" class="form-control" autocomplete="off">

        <div v-for="result in this.results" :key="result.id">
            <button class="btn btn-primary m-1" v-on:click="select(result, $event)">{{result.name}}</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "StudentSearchBar",
        data: function () {
            return {
                query: "",
                results: [],
                selected: [],
                selectedIds: []
            }
        },
        methods: {
            fetchResults: function (query) {
                axios.get('/searchStudents', {params: {query: query, selectedIds: this.selectedIds }})
                    .then( response => {
                        this.results = response.data;
                    })
                    .catch((response)=> {
                        console.log(response)
                    })
            },
            select: function (obj, event) {
                event.preventDefault();
                this.selectedIds.push(obj.id)
                this.selected.push(obj)
                this.results = this.results.filter((result) => {
                    return result.id !== obj.id
                });
            },
            unSelect: function (obj, event) {
                event.preventDefault();
                this.results.push(obj)
                this.selectedIds = this.selectedIds.filter((id) => {
                    return id !== obj.id
                })
                this.selected = this.selected.filter((selected) => {
                    return selected.id !== obj.id;
                })
            },
            fetchCurrentStudents: function (slug){
                axios.get('http://master.myapp.com/searchCurrentStudents/' + slug)
                    .then( response => {
                        this.selected = response.data;

                        this.selected.forEach((item) => {
                            this.selectedIds.push(item.id)
                        })

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
                setTimeout(this.fetchCurrentStudents(lastTen), 11000)
            }
        }
    }
</script>

<style scoped>
</style>
