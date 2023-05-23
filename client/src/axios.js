import axios from "axios";
import {mapActions} from "vuex";

function Setdefaults(){
    axios.defaults.baseURL='http://localhost:8000/api/';
    axios.defaults.headers.common['Content-Type'] = 'application/json';

    // axios.interceptors.response.use(
    //     (response)=>{return response;},
    //     (error)=>{
    //         if(error.response && error.response.status === 401){
    //             const errorMessage = error.response.data.message.toLowerCase();
    //             if (errorMessage.includes('unauthenticated')) {
    //                 await refreshToken();
    //                 return axios(error.config);
    //             }
    //         }
    //         return Promise.reject(error);
    //     }
    // )

}

export default Setdefaults;

