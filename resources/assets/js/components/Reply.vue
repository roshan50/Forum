<template>
  <div :id="'reply-'+data.id" class="panel" :class="isBest ? 'panel-success' : 'panel-default'">
    <div class="panel-heading">
      <div class="level">
        <h5 class="flex">
          <a :href="'/profiles/'+data.owner.name"
            v-text="data.owner.name">
          </a> said
          <span v-text="ago"></span>
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
            <wysiwyg v-model="body"></wysiwyg>
            <!--<textarea class="form-control" v-model="data.body" required></textarea>-->
          </div>
          <button class="btn btn-xs btn-primary" @click="update">ذخیره</button>
          <button class="btn btn-xs btn-link" @click="editing = false">لغو</button>
        <!--</form>-->
      </div>
      <div v-else v-html="data.body"></div>
    </div>

    <div class="panel-footer level" v-if="authorize('updateReply',reply) || authorize('updateThread',thread)">
      <div v-if="authorize('updateReply',reply)">
        <button class="btn btn-xs ml-1" @click="editing = true">ویرایش</button>
        <button class="btn btn-danger btn-xs" @click="destroy">حذف</button>
      </div>
      <button class="btn btn-default btn-xs mr-a" @click="markBestReply" v-if="authorize('updateThread',thread)">بهترین پاسخ؟</button>
    </div>

  </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';
    export default {
        props : ['data','editing'],
        components : { Favorite },
          date() {
              return{
                  editing : false,
                  id : this.data.id,
                  body : this.data.body,
                  // thread : window.thread,
                  // reply : this.data
              }
          },
        computed:{
            ago(){
                return moment(this.data.created_at).fromNow();
            },
            reply(){
                return this.data;
            },
            thread(){
                return window.thread;
            },
            isBest(){
                console.log(this.data.id);console.log(window.thread.best_reply_id);
                console.log(window.thread.best_reply_id == this.id);
                return window.thread.best_reply_id == this.id;
            }
            /*,
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
            },
            markBestReply(){
                axios.post('/replies/'+this.data.id+'/best');
                console.log(this.data.id);
                window.thread.best_reply_id = this.data.id;
            }

        }
    }
</script>