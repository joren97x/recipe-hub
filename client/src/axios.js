import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost/recipe-hub/server/public/api/', 
})

export default api