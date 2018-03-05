<template>
  <div :id="'reply-'+data.id" class="panel panel-default">
    <div class="panel-heading">
      <div class="level">
        <h5 class="flex">
          <a :href="'/profiles/'+data.owner.name"
            v-text="data.owner.name">
          </a> said
          {{ data.created_at }}
        </h5>
        <div v-if="signedIn">
          <favorite :reply="data"></favorite>
        </div>
      </div>
    </div>

    <div class="panel-body">
      <div v-if="editing">
        <!--<form @submit="update">-->
          <div class="form-group">
            <textarea class="form-control" v-model="data.body" required></textarea>
          </div>
          <button class="btn btn-xs btn-primary" @click="update">ذخیره</button>
          <button class="btn btn-xs btn-link" @click="editing = false">لغو</button>
        <!--</form>-->
      </div>
      <div v-else v-html="data.body"></div>
    </div>

    <div class="panel-footer level">
      <button class="btn btn-xs ml-1" @click="editing = true">ویرایش</button>
      <button class="btn btn-danger btn-xs" @click="destroy">حذف</button>
    </div>

  </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    // import moment from 'moment';
    export default {
        props : ['data','editing'],
        components : { Favorite },
          date() {
              return{
                  editing : false,
                  id : this.data.id,
                  body : this.data.body
              };
          },
        computed:{
            signedIn(){
                return window.App.singedIn;
            },
            canUpdate(){
                return this.authorize(user => this.data.user_id == window.App.user.id);
            }/*,
            editing(){
                return false;
            }*/
        },
        methods:{
            update(){
                axios.patch('/replies/' + this.data.id, {
                    body : this.data.body
                }).catch(error=>{
                    flash(error.response.data,'danger');
                });

                 this.editing = false;

                flash('updated!');
            },

            destroy(){
                axios.delete('/replies/' + this.data.id);
                this.$emit('deleted',this.data.id);
                $(this.$el).fadeOut(300,()=>{
                    flash('delete!');
                });
            }

        }
    }
</script>