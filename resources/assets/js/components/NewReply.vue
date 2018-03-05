<template>
  <div>
    <div v-if="signedIn">
        <div class="form-group">
          <textarea name="body"
                    id="body"
                    class="form-control"
                    required
                    v-model="body"
                    placeholder="نظر"></textarea>
        </div>
        <button type="submit"
              class="btn btn-default"
              @click="addReply">ارسال نظر</button>
    </div>
    <p  class="text-center" v-else>
      برای مشارکت در بحث لطفا <a href="/login">وارد </a> سایت شوید!
    </p>

  </div>
</template>
<script>
  import 'at.js';
  import 'jquery.caret';
  export default {
      props : ['endpoint'],
      data(){
          return{
              'body' : ''
          }
      },
      computed: {
          signedIn() {
              return window.App.singedIn;
          },
      },
      mounted(){
        $("#body").atwho({
            at:"@",
            delay:750,
            callbacks:{
                remoteFilter: function(query,callback){
                  $.getJSON("/api/users", {name:query}, function(usernames){
                      callback(usernames);
                  });
                }
            }
        });
      },
      methods:{
          addReply(){
              axios.post(this.endpoint,{ body: this.body })
                  .catch(error=>{
                      flash(error.response.data,'danger');
                  })
                  .then(({data})=>{
                      this.body = '';
                      // flash('your reply has been posted.');
                      this.$emit('created',data);
                  });
          }
      }
  }
</script>