<template>
<div class="hero min-h-screen bg-base-200">
  <div class="hero-content flex-col lg:flex-row-reverse">
    <div class="text-center lg:text-left">
      <h1 class="text-5xl font-bold">Bienvenu sur la platforme PlayProf</h1>
      <p class="py-6">pour acceder la platforme veuillez se connecter</p>
    </div>
    <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
      <div class="card-body">
        <div class="form-control">
          <label class="label">
            <span class="label-text">Email</span>
          </label>
          <input v-model="FormData.email" type="email" placeholder="email" class="input input-bordered" />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Password</span>
          </label>
          <input v-model="FormData.password" type="password" placeholder="password" class="input input-bordered" />
          <label class="label">
<!--            <a href="#" class="label-text-alt link link-hover">Forgot password?</a>-->
          </label>
        </div>
        <div class="form-control mt-6">
          <button @click="login" :disabled="!ToggleLogin" class="btn btn-primary">Login</button>
        </div>
      </div>
    </div>
  </div>
</div>


</template>

<script>
import {mapActions} from "vuex";
import { useToast } from "vue-toastification";

export default{
    name:'Home',
    components:{
        
    },
    props:{
      
    },

  /* Here there's the data we get from
  the form
  */

  data(){
      return{
        FormData:{
          email:"",
          password:""
        }
      }
  },

  /*Here's the methods that are used in this component
   */

  computed:{
    ToggleLogin(){
      if(this.FormData.email.length<1 || this.FormData.password.length<1)
      {
        return false
      }
      else return true;
    },
  },

  methods:{

    isValidMail(email){
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    },
    validate(email,password){
      const toast=useToast();
      if(!this.isValidMail(email))
      {
        toast.warning('Invalid Email');
        return false;
      }
      if(password.length>20)
      {
        toast.warning('Password too long');
        return false;
      }
      return true;
    },
    async login(){
      const isvalid = this.validate(this.FormData.email,this.FormData.password);
      if(isvalid)
      {
        await this.$store.dispatch('login',this.FormData);
      }
    },
  }




}
</script>