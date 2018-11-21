<template>
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th style="width:5%;">ID</th>
                    <th style="width:20%;">Name</th>
                    <th style="width:25%;">Position</th>
                    <th style="width:20%;">Hiring Date</th>
                    <th style="width:5%;">Salary</th>
                    <th style="width:15%;">Boss name</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="employee in employees">
                    <td>{{employee.id }}</td>
                    <td></td>
                    <td>{{ employee.position }}</td>
                    <td>{{ employee.hired_at }}</td>
                    <td>{{ employee.salary }}</td>
                    <td> {{employee.parent ? employee.parent.name : ""}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="container">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li  class="page-item" v-for="page in pages" :key="page">
                        <a @click="changed"
                            v-if="(current != page)&&((page <= 5)||(page > pages-5)||((current > page-3)&&(current < page+3)))"
                            class="page-link number">{{page}}</a>
                        <a @click="changed"
                            v-if="(current == page)&&((page <= 5)||(page > pages-5)||((current > page-3)&&(current < page+3)))"
                            class="page-link number active">{{page}}</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'employees', 'pages'
        ],
        data: function () {
            return {
                page: 1,
                current: 1,
            }
        },
        methods: {
            changed: function (event) {
                this.page = this.current = event.target.text;
            }
        },
        watch: {
            current: function () {
                console.log(this.current);
                axios.post('ajaxlist/moreitems',{  body: this.current  }).then((responce) => {
                    console.log(responce.data);
                    this.employees = responce.data.employees;
                    this.countPages = responce.data.countPages;
                })
            }
        },
    }
</script>

<style>
    .number {
        color: #FFF;
        background: #86c04b;
        cursor: pointer;
        text: #1c1c3d;
    }
    .number:hover, .number.active {
        background: #3e8118;
    }
    .active {
        background: #3e8118;
    }
</style>
