let user = window.App.user;
module.exports = {
    owns(model,prop= 'user_id'){
        return model[prop] === user.id;
    },
    updateReply(reply){
        return reply.user_id === user.id;
    },
    updateThread(thread){
        console.log(thread.user_id);
        console.log(user.id);
        return thread.user_id === user.id;
    },
    isAdmin(){
        return ['maryam','rahele'].includes(user.name);
    }
};
