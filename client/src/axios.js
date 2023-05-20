import axios from "axios";

function Setdefaults(){
    axios.defaults.baseURL='http://localhost:8000/api/';
    axios.defaults.headers.common['Content-Type'] = 'application/json';

}

export default Setdefaults;

