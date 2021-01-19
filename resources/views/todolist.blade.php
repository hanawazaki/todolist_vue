<html>

<head>
    <title>Todo List Vue</title>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    {{-- bootstrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>

    {{-- vueJS --}}
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>

    {{-- Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    {{-- start : custom style --}}
    <style>
        .todolist-wrapper {
            min-height: 100px;
            border: 1px solid #cccccc;
        }

    </style>
    {{-- end : custom style --}}
</head>

<body>
    <div class="container">
        <div id="app">

            {{-- start : modal box --}}
            <div class="modal" tabindex="-1" role="dialog" id="modal-form">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-if=!id>Create - Todo List Form</h5>
                            <h5 class="modal-title" v-else>Edit - Todo List Form id-@{{ id }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea v-model="content" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" @click="saveTodolist" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end : modal box --}}

            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="text-right mb-3">
                        <a href="javascript:;" @click="openForm" class="btn btn-primary">Tambah Data</a>
                    </div>

                    <div class="text-center mb-3">
                        <input type="text" class="form-control" placeholder="cari disini" @change="searchData"
                            v-model="search">
                    </div>
                    <div class="todolist-wrapper">
                        <table class="table table-stripped table-bordered">
                            <tbody>
                                <tr v-for="(data,index) in data_list">
                                    <td>
                                        @{{ index + 1 }}
                                    </td>
                                    <td>
                                        @{{ data . content }}
                                    </td>
                                    <td>
                                        <a href="javascript:;" @click="editData(data.id)"
                                            class="btn btn-success">Edit</a>
                                        <a href="javascript:;" @click="hapusData(data.id)"
                                            class="btn btn-danger">Hapus</a>
                                    </td>
                                </tr>
                                <tr v-if=!data_list.length>
                                    <td>
                                        <i>Data Masih Kosong</i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>

    <script>
        let vue = new Vue({
            el: "#app",
            mounted() {
                this.getDataList();
            },
            data: {
                data_list: [],
                content: "",
                id: "",
                search: ""
            },
            methods: {
                openForm() {
                    $('#modal-form').modal('show');
                },
                saveTodolist() {
                    let form_data = new FormData();
                    form_data.append("content", this.content)

                    if (this.id) {
                        axios.post("{{ url('api/list/update') }}/" + this.id, form_data)
                            .then(res => {
                                this.content = "";
                                this.getDataList();
                            })
                            .catch(err => {
                                alert("error!")
                            })
                            .finally(() => {
                                $('#modal-form').modal('hide');
                            })
                    } else {
                        axios.post("{{ url('api/list/create') }}", form_data)
                            .then(res => {
                                this.content = "";
                                this.getDataList();
                            })
                            .catch(err => {
                                alert("error!")
                            })
                            .finally(() => {
                                $('#modal-form').modal('hide');
                            })
                    }

                },
                editData(id) {
                    this.id = id
                    axios.get("{{ url('api/list/edit') }}/" + this.id)
                        .then(res => {
                            this.content = res.data.content
                            $('#modal-form').modal('show');
                        })
                        .catch(err => {
                            console.log("error edit data")
                        })
                },
                hapusData(id) {
                    if (confirm('Apakah anda yakin akan menghapus data ini?')) {
                        axios.post("{{ url('api/list/delete') }}/" + id)
                            .then(res => {
                                alert(res.data.message)
                            })
                            .catch(err => {
                                alert("error hapus data")
                            })
                            .finally(this.getDataList())
                    }
                },
                getDataList() {
                    axios.get("{{ url('api/list') }}?search=" + this.search)
                        .then(res => {
                            this.data_list = res.data
                        })
                        .catch(err => {
                            alert("error get data")
                        })
                },
                searchData() {
                    this.getDataList();
                }
            }
        })

    </script>
</body>

</html>
