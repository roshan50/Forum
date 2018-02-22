<script>
    import Favorite from './Favorite.vue';
    export default {
        props : ['data', 'editing'],
        components : { Favorite },
          date() {
              return{
                  editing : false,
                  body : this.data.body
              };
          },
        methods:{
            update(){
                axios.patch('/replies/' + this.data.id, {
                    body : this.data.body
                });

                this.editing = false;

                flash('updated!');
            },

            destroy(){
                axios.delete('/replies/' + this.data.id);

                $(this.$el).fadeOut(300,()=>{
                    flash('delete!');
                });
            }

        }
    }
</script>