class User {
    getDataKey = key => {
      return localStorage.getItem(key);
    };
    setUserLogin = isLogin => {
      localStorage.setItem("isLogin", isLogin);
    };
    isLogin() {
      return (localStorage.getItem("isLogin") === 'true') ? true : false;
    }
  }
  export default new User();