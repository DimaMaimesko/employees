<template>
    <div class="container">
        <div class="card mb-3">
            <div class="card-header">Filter</div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="form-group" style="width:5%;">
                            <label for="id" class="col-form-label">ID</label>
                            <input v-model="filt.id" id="id" class="form-control" name="id" value="">
                        </div>
                        <div class="form-group" style="width:20%;">
                            <label for="name" class="col-form-label">Name</label>
                            <input v-model="filt.name" id="name" class="form-control" name="name" value="">
                        </div>
                        <div class="form-group"  style="width:25%;">
                            <label for="position" class="col-form-label">Position</label>
                            <input v-model="filt.position" id="position" class="form-control" name="position" value="">
                        </div>
                        <div class="form-group" style="width:20%;">
                            <label for="hired_at" class="col-form-label">Hired at</label>
                            <input v-model="filt.hired_at" id="hired_at" class="form-control" name="hired_at" value="">
                        </div>
                        <div class="form-group" style="width:5%;">
                            <label for="salary" class="col-form-label">Salary</label>
                            <input v-model="filt.salary" id="salary" class="form-control" name="salary" value="">
                        </div>
                        <div class="form-group"  style="width:15%;">
                            <label for="boss_id" class="col-form-label">Boss Id</label>
                            <input v-model="filt.boss_id" id="boss_id" class="form-control" name="boss_id" value="">
                        </div>
                        <div class="form-group"  style="width:10%;">
                            <label class="col-form-label">&nbsp;</label><br />
                            <button @click.prevent="submitted" type="submit" class="btn btn-primary">Search</button>
                            <a @click.prevent="resetFilter" class="btn btn-outline-secondary">Clear</a>
                        </div>
                        <input type="hidden" id="custId" name="body" value="1">
                    </div>
                </form>
            </div>
        </div>
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
                filt: {
                    id: '',
                    name: '',
                    position: '',
                    hired_at: '',
                    salary: '',
                    boss_id: '',
                }
            }
        },
        methods: {
            changed: function (event) {
                this.page = this.current = event.target.text;
                console.log(this.pages);
            },
            submitted: function(){
                console.log(this.filt);
                axios.post('ajaxlist/moreitems',{  body: {curpage:this.current, filt:this.filt}  }).then((responce) => {
                    console.log(responce.data);
                    this.employees = responce.data.employees;
                    this.pages = responce.data.pages;
                });
            },
            resetFilter: function(){
                for (let key in this.filt) {
                    this.filt[key] = '';
                }
                this.current = 1;
            }
        },
        watch: {
            current: function () {
                axios.post('ajaxlist/moreitems',{  body: {curpage:this.current, filt:this.filt}  }).then((responce) => {
                    console.log(responce.data);
                    this.employees = responce.data.employees;
                    this.pages = responce.data.pages;
                });
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
