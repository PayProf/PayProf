import axios from "axios";
import {mapActions} from "vuex";

function Setdefaults(){
    axios.defaults.baseURL='http://localhost:8000/api/';
    axios.defaults.headers.common['Content-Type'] = 'application/json';

}

export default Setdefaults;

