import axios from "axios";

function Setdefaults(){
    axios.defaults.baseURL='http://localhost:5000/';
}

export default Setdefaults;

