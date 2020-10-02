<template>
<div>
  <b-navbar type="dark" variant="dark">
    <b-navbar-nav>
      <b-nav-item href="#">TodoList</b-nav-item>
    </b-navbar-nav>
  </b-navbar>
  <div class="container mt-5">
      <b-card
              tag="article"
              style="max-width: 100%;"
              class="mb-2 text-center card"
      >
          <div class="container">
              <div class="container">
                  <div class="row">
                      <div class="col-10">
                          <b-input  v-model="todo_title" placeholder="New Task"></b-input>
                      </div>
                      <div class="col-2" style="margin-right: 0">
                          <button class="btn btn-primary" @click="addTodo">Add</button>
                      </div>
                  </div>
              </div>
          </div>
          <b-tabs class="mt-5" align="left">
              <b-tab title="All" active @click="allTodos"></b-tab>
              <b-tab title="Completed" @click="completedTodos"></b-tab>
          </b-tabs>
          <b-modal id="modal-1" title="Edit Todo" ok-disabled>
            <b-input  v-model="todo_edit.title" :placeholder="todo_edit.title"></b-input>
            <template v-slot:modal-footer="{}">
                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button size="sm" variant="success" @click="ok()">
                    Submit
                </b-button>
            </template>

          </b-modal>
          <b-list-group class="mt-3">
              <b-list-group-item  v-for="todo in this.todos" v-bind:key="todo.id" class="d-flex justify-content-between align-items-center">
                  <input v-if="todo.completed === 1"  type="checkbox" class="radio-custom" checked disabled>
                  <input v-else @click="complete(todo.id)" type="radio" class="radio-custom">

                  <p :id="todo.id" v-if="todo.completed === 1" disabled><s>{{todo.title}}</s></p>
                  <p :id="todo.id" v-else v-b-modal.modal-1 ><a href="#" @click="editTodo(todo.id)">{{todo.title}}</a></p>
                  <b-badge @click="deleteTodo(todo.id)" variant="danger" pill>x</b-badge>
              </b-list-group-item>
          </b-list-group>
      </b-card>

    </div>
</div>
</template>

<script>
export default {
    name: 'Todo',
    data() {
      return {
          backend: process.env.VUE_APP_BACKEND_URL,
          status: '',
          todo_title: '',
          todo_edit: {
              id: null,
              title: '',
              completed: 0,
          },
          todo: {
              title: '',
              completed: 0,
          },
          todos: []
      }
  },
    mounted() {
           this.getTodos();
    },
    methods: {

        /*
        * This method gets all the todos.
        * */
        allTodos(){
            this.getTodos();
        },

        /*
        * This method gets all the todos set as finished
        * */
        completedTodos(){
            this.axios.get(this.backend).then(data => {
                let todo = data.data;
                this.todos = todo.filter(todo => todo.completed === 1);
            }).catch(err => {
                console.log(err);
            })
        },

        /*
        * Get todos method
        * */
        getTodos(){
            console.log(this.backend)
            this.axios.get(this.backend).then(data => {
                let todo = data.data;
                this.todos = todo;
            }).catch(err => {
                console.log(err);
            })
        },

        /*
        * This method sets the todos as finished
        * */
        complete (id) {
            this.$confirm(
                {
                    message: `Set this Todo as finished?`,
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    callback: confirm => {
                        if (confirm) {
                            this.todo.title = this.todos.filter(a => a.id === id)[0].title;
                            this.todo.completed = this.todos.filter(a => a.id === id)[0].completed === 0 ? 1 : 0;

                            this.axios.patch(this.backend + "/" + id, this.todo).then(() => {
                                this.getTodos();
                            }).catch(err => {
                                console.log(err);
                            })
                        }
                    }
                }
            )

        },

        /*
        * This method adds the todos.
        * */
        addTodo() {
            this.todo.title = this.todo_title;
            this.todo.completed = 0;
            this.axios.post(this.backend, this.todo).then(() => {
                this.todos.push(this.todo);
                this.getTodos();
                this.todo_title = '';
            }).catch(err => {
                console.log(err);
            })
        },

        /*
        * Edit method
        * */
        editTodo(id){
            this.todo_edit.id = id;
             this.todo_edit.title = this.todos.filter(a => a.id === id)[0].title;
        },

        ok(){
             this.axios.patch(this.backend + '/' + this.todo_edit.id, this.todo_edit).then(() => {
                        this.getTodos();
                    }).catch(err => {
                        console.log(err);
                    })
           this.$refs['modal-1'].hide()

        },

        /*
        * This method adds a todo.
        * */
        deleteTodo(id) {
            this.$confirm(
                {
                    message: `Are you sure you want to delete this todo?`,
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    callback: confirm => {
                        if (confirm) {
                            this.axios.delete(this.backend + "/" + id).then(() => {
                                this.getTodos();
                            }).catch(err => {
                                console.log(err);
                            })
                        }
                    }
                }
            )
        }
    }
}
</script>

<style scoped>
.card {
    margin: 0 auto; /* Added */
    float: none; /* Added */
    margin-bottom: 10px; /* Added */
}
h3 {
  margin: 40px 0 0;
}

ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
