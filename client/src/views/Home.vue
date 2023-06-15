<template>
  <div class="hero min-h-screen bg-base-200" v-if="Loading">
    <div class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
        role="status">
  <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
    </div>
  </div>
<div class="hero min-h-screen bg-base-200" v-else @keyup.enter="login">
  <div class="hero-content flex-col lg:flex-row-reverse">
    <div class="text-center lg:text-left">
      <h1 class="text-5xl font-bold">Bienvenue sur la plateforme PayProf.</h1>
      <p class="py-6">Pour accéder à la plateforme, veuillez vous connecter.</p>
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
        <div class="form-control mt-6" >
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
        },
        Loading:false,
      }
  },

  /*Here's the methods that are used in this component
   */

  computed:{

    ToggleLogin(){
      if(this.FormData.email.length<1 || this.FormData.password.length<1)
      {
        return false;
      }
      else
      {
        return true;
      }
    },
  },

  methods:{
    ...mapActions([
        'login',
    ]),

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
        this.Loading=true;
        await this.$store.dispatch('login',this.FormData);
        this.Loading=false;
      }
    },
  }




}
</script>