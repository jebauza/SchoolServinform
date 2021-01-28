<template>
    <div class="card border-primary mb-4">
        <div class="card-header">
            <h3 class="card-title text-primary font-weight-bold">Courses</h3>
            <div class="card-tools float-right">
                <button @click="showForm('add')" class="btn btn-info btn-sm">
                    <i class="fas fa-plus-square text-white"> New Course</i>
                </button>
            </div>
        </div>

        <div class="card-body">

            <div class="form-row">
                <div class="col-sm-5 form-group">
                    <label>Name</label>
                    <input v-model="filters.name" type="text" class="form-control" name="name" placeholder="Name">
                </div>
                <div class="col-sm-5 form-group">
                    <label>Student</label>
                   <input v-model="filters.student" type="text" class="form-control" name="student" placeholder="Student">
                </div>
                <div class="form-group col-auto mt-4 pt-2">
                    <button @click="clearFilters()" title="Remove filters" type="button"
                        class="btn waves-effect waves-light btn-danger float-right">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>

            <div class="row table-responsive">
                <table v-if="courses.length" class="table table-striped">
                    <thead>
                        <tr class="bg-info">
                            <th>Name</th>
                            <th>Students</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr v-for="course in courses" :key="course.id">
                            <td>{{course.name}}</td>
                            <td>{{course.students.map(s => s.fullname).join(', ')}}</td>
                            <td class="text-nowrap text-center">
                                <div>
                                    <button type="button" @click="showForm('edit', course)"
                                        class="btn m-r-10 waves-effect waves-light btn-outline-primary">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" @click="destroy(course)"
                                        class="btn waves-effect waves-light btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>


        <div class="modal fade" id="modalCourseFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-if="modalType=='add'" class="modal-title">New Course</h4>
                        <h4 v-else class="modal-title">Edit Course</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="needs-validation" v-on:submit.prevent="actionStoreUpdate">
                        <div class="modal-body">

                            <div class="form-row">

                                <div class="form-group col-12">
                                    <label for="name" :class="['control-label', errors.name ? 'text-danger' : '']">Name</label>
                                    <input v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" placeholder="Name" required>
                                    <small v-if="errors.name" class="form-control-feedback text-danger">
                                        {{ errors.name[0] }}
                                    </small>
                                </div>

                                <div class="form-group col-12">
                                    <label for="students" :class="['control-label', errors.students ? 'text-danger' : '']">Students</label>
                                    <multiselect
                                        v-model="form.students"
                                        :options="students"
                                        placeholder="Students"
                                        label="name"
                                        track-by="id"
                                        :multiple="true"
                                        :close-on-select="false"
                                        :clear-on-select="false"
                                        :preserve-search="true"
                                        >
                                    </multiselect>
                                    <small v-if="errors.students" class="form-control-feedback text-danger">
                                        {{ errors.students[0] }}
                                    </small>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';

export default {
    components: {Multiselect},
    mounted() {
        EventBus.$on('coursesLoad', () => {
            console.log('coursesLoad');
            this.getStudents();
            this.getCourses();
        });
    },
    created() {
        this.getStudents();
        this.getCourses();
    },
    watch: {
        'filters.name': function(newValue, oldValue) {
            this.getCourses();
        },
        'filters.student': function(newValue, oldValue) {
            this.getCourses();
        }
    },
    data() {
        return {
            courses: [],
            students:[],

            filters: {
                name: '',
                student:  ''
            },

            modalType: 'add',
            form: {
                name: '',
                students: [],
                id: ''
            },
            errors: {},
        }
    },
    methods: {
        getCourses() {
            const url = `/api/courses`;
            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                // background: '#7a76cb',
                text: 'Loading...'
            });

            axios.get(url, {
                params: this.filters
            })
            .then(res => {
                this.courses = res.data;
                loading.close();
                this.getStudents();
            }).catch(err => {
                loading.close();
                console.error(err);
            });
        },
        getStudents() {
            const url = `api/students`;

            axios.get(url)
            .then(res => {
                this.courses = res.data;
            });
        },
        clearFilters() {
            this.filters = {
                name: '',
                student:  ''
            };
        },
        showForm(action, course = null) {
            if(this.modalType != action) {
                this.clearForm();
            }

            this.modalType = action;
            if(this.modalType === 'edit' && course) {
                this.form = {
                    name: course.name,
                    students: course.students,
                    id: student.id
                }
            }
            this.erros = {};
            $('#modalCourseFormAddEdit').modal('show');
        },
        clearForm() {
            this.form = {
                name: '',
                students: [],
                id: ''
            };
            this.errors = {};
        },
        actionStoreUpdate() {
            if(this.modalType == 'add') {
                this.store();
            }else if(this.modalType == 'edit'){
                this.update();
            }
        },
        store() {
            const url = 'api/courses/store';
            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                // background: '#7a76cb',
                text: 'Saving...'
            });

            axios.post(url, {
                    name: this.form.name,
                    students: this.form.students.map(item => item.id)
            }).then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.nessage,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getCourses();
                $('#modalCourseFormAddEdit').modal('hide');
                this.clearForm();
            })
            .catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                    this.errorsStudents();
                }else if(err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }

                console.log(err.response);
            });
        },
        update() {
            const url = `api/courses/${this.form.id}/update`;
            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                // background: '#7a76cb',
                text: 'Saving...'
            });

            axios.put(url, {
                    name: this.form.name,
                    students: this.form.students.map(item => item.id)
            }).then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#modalCourseFormAddEdit').modal('hide');
                this.clearForm();
                this.getCourses();
            })
            .catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                    this.errorsStudents();
                }else if(err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }

                console.log(err.response);
            });
        },
        destroy(student) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to remove (${course.name})?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = `api/courses/${course.id}/destroy`;
                    const loading = this.$vs.loading({
                        type: 'points',
                        color: 'blue',
                        // background: '#7a76cb',
                        text: 'Deleting...'
                    });

                    axios.delete(url)
                    .then(res => {
                        loading.close();
                        Swal.fire({
                            title: res.data.message,
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        this.getCourses();
                    }).catch(err => {
                        loading.close();
                        if(err.response.data.message) {
                            Swal.fire({
                                title: 'Error!',
                                text: err.response.data.message,
                                icon: "error",
                                showCloseButton: true,
                                closeButtonColor: 'red',
                            });
                        }

                        console.log(err.response);
                    });
                }
            });
        },
        errorsStudents() {

            if(Object.keys(this.errors).length !== 0) {
                if(!this.errors.students){
                    for (let i = 0; i < this.students.length; i++) {
                        if(this.errors.hasOwnProperty(`students.${i}`)){
                            this.errors.students = this.errors[`students.${i}`];
                            break;
                        }
                    }
                }
            }
        }
    },

}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
