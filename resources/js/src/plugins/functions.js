/**
 * MY HELPERS FUNCTIONS
 * Author & Developer Allen C. Alvarez
 */
export function Authenticated() {
    try{
        if(this.getSecureLocalStorage().id != undefined){
            return true
        }
    }catch(e){
        return false
    }
    return false
}

export function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

export function IsAdmin() {
    try{
        if(this.getSecureLocalStorage().id == 1){
            return true
        }
    }catch(e){
        return false
    }
    return false
}

export function getSecureLocalStorage(){
  try{
      var local = decrypt(localStorage.getItem('user'))
      local = IsJsonString(local) ? JSON.parse(local) : ""
      local == "" ? localStorage.removeItem('user') : local
      return local
  }catch(e){
      localStorage.removeItem('user')
      return ""
  }
}

export function getSecureLocalToken(){
    try{
        if(this.getSecureLocalStorage() != ""){
            return this.getSecureLocalStorage().token != undefined ? this.getSecureLocalStorage().token : ""
        }
    }catch(e){
        return ""
    }
}