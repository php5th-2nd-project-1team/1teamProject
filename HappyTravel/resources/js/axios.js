import axios from "axios";

const axiosInstance = axios.create({
  	headers: {
    	'Content-Type': 'application/json', // 기본 Content-Type
  	},
});

export default axiosInstance;