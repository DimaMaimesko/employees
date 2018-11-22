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
                <tr style="background: rgba(97,156,33,0.57);">
                    <th @click="sortId++" style="width:7%;">ID
                        <div :class="idClass" class="d-flex flex-column float-right">
                        </div>
                    </th>
                    <th @click="sortName++" style="width:18%;">Name
                        <div :class="nameClass" class="d-flex flex-column float-right">
                        </div>
                    </th>
                    <th @click="sortPosition++" style="width:25%;">Position
                        <div :class="positionClass" class="d-flex flex-column float-right">
                        </div>
                    </th>
                    <th @click="sortDate++" class="sort-field" style="width:20%;">Hiring Date
                        <div :class="dateClass" class="d-flex flex-column float-right">
                        </div>
                    </th>
                    <th @click="sortSalary++" style="width:5%;">Salary
                        <div :class="salaryClass" class="d-flex flex-column float-right">
                        </div>
                    </th>
                    <th @click="sortBoss++" style="width:15%;">Boss name
                        <div :class="bossClass" class="d-flex flex-column float-right">
                        </div>
                    </th>
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
                },
                sortId: 0,
                sortName: 0,
                sortPosition: 0,
                sortSalary: 0,
                sortDate: 0,
                sortBoss: 0,
                sortField: null,
                sortDirection: null,
                idClass: '',
                nameClass: '',
                positionClass: '',
                salaryClass: '',
                dateClass: '',
                bossClass: '',
            }
        },
        methods: {
            changed: function (event) {
                this.page = this.current = event.target.text;
                console.log(this.pages);
            },
            submitted: function(){
                console.log(this.filt);
                this.current = 1;
                axios.post('ajaxlist/moreitems',{  body: {curpage:this.current, filt:this.filt , sortField: this.sortField, sortDirection:this.sortDirection}  }).then((responce) => {
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
            },

        },
        watch: {
            current: function() {
                axios.post('ajaxlist/moreitems',{  body: {curpage:this.current, filt:this.filt, sortField: this.sortField, sortDirection:this.sortDirection}  }).then((responce) => {
                    console.log(responce.data);
                    this.employees = responce.data.employees;
                    this.pages = responce.data.pages;
                });
            },
            sortId: function() {
                this.nameClass = '';this.positionClass = '';this.salaryClass = '';this.dateClass = '';this.bossClass = '';
                this.sortField = 'id'
                if (this.sortId == 1){
                    this.idClass = 'arrow_down';
                    this.sortDirection = 'asc';
                }
                if (this.sortId == 2){
                    this.idClass = 'arrow_up';
                    this.sortDirection = 'desc';
                }
                if (this.sortId > 2){
                    this.sortField = null;
                    this.sortId = 0;
                    this.sortDirection = null;
                    this.idClass = '';
                };
                axios.post('ajaxlist/moreitems',{  body: {curpage:this.current, filt:this.filt, sortField: this.sortField, sortDirection:this.sortDirection}  }).then((responce) => {
                    this.employees = responce.data.employees;
                    this.pages = responce.data.pages;
                });
            },
            sortName: function() {
                this.idClass = '';this.positionClass = '';this.salaryClass = '';this.dateClass = '';this.bossClass = '';
                this.sortField = 'name'
                if (this.sortName == 1){
                    this.nameClass = 'arrow_down';
                    this.sortDirection = 'asc';
                }
                if (this.sortName == 2){
                    this.nameClass = 'arrow_up';
                    this.sortDirection = 'desc';
                }
                if (this.sortName > 2){
                    this.nameClass = '';
                    this.sortField = null;
                    this.sortName = 0;
                    this.sortDirection = null;
                };
                axios.post('ajaxlist/moreitems',{  body: {curpage:this.current, filt:this.filt, sortField:this.sortField, sortDirection:this.sortDirection}  }).then((responce) => {
                    this.employees = responce.data.employees;
                    this.pages = responce.data.pages;
                });
            },
            sortPosition: function() {
                this.idClass = '';this.nameClass = '';this.salaryClass = '';this.dateClass = '';this.bossClass = '';
                this.sortField = 'position'
                if (this.sortPosition == 1){
                    this.positionClass = 'arrow_down';
                    this.sortDirection = 'asc';
                }
                if (this.sortPosition == 2){
                    this.positionClass = 'arrow_up';
                    this.sortDirection = 'desc'
                }
                if (this.sortPosition > 2){
                    this.positionClass = '';
                    this.sortField = null;
                    this.sortPosition = 0;
                    this.sortDirection = null;
                };
                axios.post('ajaxlist/moreitems',{  body: {curpage:this.current, filt:this.filt, sortField:this.sortField, sortDirection:this.sortDirection}  }).then((responce) => {
                    this.employees = responce.data.employees;
                    this.pages = responce.data.pages;
                });
            },
            sortSalary: function() {
                this.idClass = '';this.nameClass = '';this.positionClass = '';this.dateClass = '';this.bossClass = '';
                this.sortField = 'salary'
                if (this.sortSalary == 1){
                    this.salaryClass = 'arrow_down';
                    this.sortDirection = 'asc';
                }
                if (this.sortSalary == 2){
                    this.salaryClass = 'arrow_up';
                    this.sortDirection = 'desc'
                }
                if (this.sortSalary > 2){
                    this.salaryClass = '';
                    this.sortField = null;
                    this.sortSalary = 0;
                    this.sortDirection = null;
                };
                axios.post('ajaxlist/moreitems',{  body: {curpage:this.current, filt:this.filt, sortField:this.sortField, sortDirection:this.sortDirection}  }).then((responce) => {
                    this.employees = responce.data.employees;
                    this.pages = responce.data.pages;
                });
            },
            sortDate: function() {
                this.idClass = '';this.nameClass = '';this.positionClass = '';this.salaryClass = '';this.bossClass = '';
                this.sortField = 'hired_at'
                if (this.sortDate == 1){
                    this.dateClass = 'arrow_down';
                    this.sortDirection = 'asc';
                }
                if (this.sortDate == 2){
                    this.dateClass = 'arrow_up';
                    this.sortDirection = 'desc'
                }
                if (this.sortDate > 2){
                    this.dateClass = '';
                    this.sortField = null;
                    this.sortDate = 0;
                    this.sortDirection = null;
                };
                axios.post('ajaxlist/moreitems',{  body: {curpage:this.current, filt:this.filt, sortField:this.sortField, sortDirection:this.sortDirection}  }).then((responce) => {
                    this.employees = responce.data.employees;
                    this.pages = responce.data.pages;
                });
            },
            sortBoss: function() {
                this.idClass = '';this.nameClass = '';this.positionClass = '';this.salaryClass = '';this.dateClass = '';
                this.sortField = 'boss'
                if (this.sortBoss == 1){
                    this.bossClass = 'arrow_down';
                    this.sortDirection = 'asc';
                }
                if (this.sortBoss == 2){
                    this.bossClass = 'arrow_up';
                    this.sortDirection = 'desc'
                }
                if (this.sortBoss > 2){
                    this.bossClass = '';
                    this.sortField = null;
                    this.sortBoss = 0;
                    this.sortDirection = null;
                };
                axios.post('ajaxlist/moreitems',{  body: {curpage:this.current, filt:this.filt, sortField:this.sortField, sortDirection:this.sortDirection}  }).then((responce) => {
                    console.log(responce.data);
                    this.employees = responce.data.employees;
                    this.pages = responce.data.pages;
                });
            },


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
    .sort-field:hover {
        background: #658158;
        cursor: pointer;
    }
    .arrow_down {
        float: right;
        width: 12px;
        height: 15px;
        background-repeat: no-repeat;
        background-size: contain;
        background-position-y: bottom;
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB8AAAAaCAYAAABPY4eKAAAAAXNSR0IArs4c6QAAAvlJREFUSA29Vk1PGlEUHQaiiewslpUJiyYs2yb9AyRuJGm7c0VJoFXSX9A0sSZN04ULF12YEBQDhMCuSZOm1FhTiLY2Rky0QPlQBLRUsICoIN/0PCsGyox26NC3eTNn3r3n3TvnvvsE1PkwGo3yUqkkEQqFgw2Mz7lWqwng7ztN06mxsTEv8U0Aam5u7r5EInkplUol/f391wAJCc7nEAgE9Uwmkzo4OPiJMa1Wq6cFs7Ozt0H6RqlUDmJXfPIx+qrX69Ti4mIyHA5r6Wq1egND+j+IyW6QAUoul18XiUTDNHaSyGazKcZtdgk8wqhUKh9o/OMvsVgsfHJy0iWqVrcQNRUMBnd6enqc9MjISAmRP3e73T9al3XnbWNjIw2+KY1Gc3imsNHR0YV4PP5+d3e32h3K316TySQFoX2WyWR2glzIO5fLTSD6IElLNwbqnFpbWyO/96lCoai0cZjN5kfYQAYi5H34fL6cxWIZbya9iJyAhULBHAqFVlMpfsV/fHxMeb3er+Vy+VUzeduzwWC45XA4dlD/vEXvdDrj8DvURsYEWK3WF4FA4JQP9mg0WrHZbEYmnpa0NxYgPVObm5teiLABdTQT8a6vrwdRWhOcHMzMzCiXlpb2/yV6qDttMpkeshEzRk4Wo/bfoe4X9vb2amzGl+HoXNT29vZqsVi0sK1jJScG+Xx+HGkL4Tew2TPi5zUdQQt9otPpuBk3e0TaHmMDh1zS7/f780S0zX6Yni+NnBj09fUZUfvudDrNZN+GkQbl8Xi8RLRtHzsB9Hr9nfn5+SjSeWUCXC7XPq5kw53wsNogjZNohYXL2EljstvtrAL70/mVaW8Y4OidRO1/gwgbUMvcqGmcDc9aPvD1gnTeQ+0nmaInokRj0nHh+uvIiVOtVvt2a2vLv7Ky0tL3cRTXIcpPAwMDpq6R4/JXE4vFQ5FI5CN+QTaRSFCYc8vLy1l0rge4ARe5kJ/d27kYkLXoy2Jo4C7K8CZOsEBvb+9rlUp1xNXPL7v3IDwxvPD6AAAAAElFTkSuQmCC')
    }
    .arrow_up {
        float: right;
        width: 12px;
        height: 15px;
        background-repeat: no-repeat;
        background-size: contain;
        background-position-y: bottom;
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAaCAYAAACgoey0AAAAAXNSR0IArs4c6QAAAwpJREFUSA21Vt1PUmEYP4dvkQ8JFMwtBRocWAkDbiqXrUWXzU1rrTt0bdVqXbb1tbW16C9IBUSmm27cODdneoXjputa6069qwuW6IIBIdLvdaF4OAcOiGeDc87zPs/vd57P96WpFq7p6enbGo1mjKZpeTabjU1MTCRagGnOZHFxcXxtbe1XKpUq7+zslJeXl//Mz8+Hy+Uy3RxSE9qTk5M3otFooVQqgef4Wl9f343FYoEmoISrxuNxFX5f9vb2jhn/PxUKhfLS0tIPfFifUESRUMV8Pv/M6XReRm5rTGQyGeXxeGxYe1ezeBpBOBx2rKysbO7v79d4Wy3Y2Nj4GQqFbgnhaugxwiuGJx99Pp9FLBbXxYTXvTqd7v3MzIy6riIWGxJnMpl7AwMD14xGYyMsSq1WUyQdUqn0eSPlusQIsbGrq+vl4OCgvhFQZd1utyv1en0gEolcqsi47nWJlUrlG5fLZVcoFFy2nDKSDpIWlUoVTCQSEk4lCHmJMZ2GTCbTiMVikfIZ88l7enoos9l8dXt7+z6fDicxSJUokqDX6xXcl2wCROoc0vQCWL3sNfLOSdzR0fHY4XC4tVotl40gmVwup9xuN4OQv+UyqCFGH9rg7SOGYVRcBs3IEG4J0nVnamrqOtvuBDGGgQg9+wHFcVEi4a0LNkbdd6TrPKo8ODc311mteIIYjT/a398/jK+s1jnVM0kXoufCFvq0GuiIGEVgQIhfoygM1QrteEa9dAL7ITiYCt4RMabOK5AyKKzKWtvupLcRciu8D5J0EuDDPyT/Snd39yh6VtY2NhYQSR9G79Ds7OxdskRjEyAufvb7/cPoO5Z6e1+xtVKrq6vfcFzyi/A3ZrPZ3GdNSlwgo5ekE4X2RIQGf2C1WlufFE0GBeGWYQ8YERWLxQtnUVB830MKLZfL9RHir8lkssCn2G751tZWEWe03zTKm15YWPiEiXXTYDB0Ig/t7yd8PRws4EicwWHxO4jHD8/C5HiTTqd1BwcHFozKU89origB+y/kmzgYpgOBQP4fGmUiZmJ+WNgAAAAASUVORK5CYII=')
    }
</style>
